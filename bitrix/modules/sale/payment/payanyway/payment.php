<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

include_once(GetLangFileName(dirname(__FILE__)."/", "/payment.php"));

$payment_system = isset($payment_system) ? $payment_system : "payanyway";
$extraParameters = isset($extraParameters) ? $extraParameters : array();
$unit_id = isset($unit_id) ? $unit_id : null;
$account_id = isset($account_id) ? $account_id : null;
$invoice = isset($invoice) ? $invoice : false;
$orderData = $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"];

// order ID
$MNT_TRANSACTION_ID = $orderData["ID"];
if (isset($orderData["ORDER_PAYMENT_ID"])) {
    $MNT_TRANSACTION_ID .= "_" . $orderData["ORDER_PAYMENT_ID"];
}

// custom number of order account
if (isset($orderData["ACCOUNT_NUMBER"])) {
    $MNT_TRANSACTION_ID .= "_" . $orderData["ACCOUNT_NUMBER"];
}

// Init PAW params
CSalePaySystemAction::InitParamArrays($arOrder, $orderData["ID"]);

// define payment server url
$MNT_PAYMENT_SERVER = CSalePaySystemAction::GetParamValue("MNT_PAYMENT_SERVER", "www.payanyway.ru");
$action = "https://".$MNT_PAYMENT_SERVER."/assistant.htm";

// do other work
$MNT_ID = trim( CSalePaySystemAction::GetParamValue("MNT_ID", 0) );
$MNT_CURRENCY_CODE = $orderData["CURRENCY"];

if (isset($GLOBALS["SALE_CORRESPONDENCE"]["MNT_AMOUNT"]["VALUE"]) && $GLOBALS["SALE_CORRESPONDENCE"]["MNT_AMOUNT"]["VALUE"] > 0) {
    $MNT_AMOUNT = number_format( $GLOBALS["SALE_CORRESPONDENCE"]["MNT_AMOUNT"]["VALUE"], 2, ".", "" );
}
else if (isset($orderData["SHOULD_PAY"]) && $orderData["SHOULD_PAY"] > 0) {
    $MNT_AMOUNT = number_format( $orderData["SHOULD_PAY"], 2, ".", "" );
}
else {
    $MNT_AMOUNT = number_format( CSalePaySystemAction::GetParamValue("MNT_AMOUNT", 0), 2, ".", "" );
}

$MNT_TEST_MODE = CSalePaySystemAction::GetParamValue("MNT_TEST_MODE", "0") == "1" ? "1" : "0";
$MNT_SIGNATURE = md5($MNT_ID . $MNT_TRANSACTION_ID . $MNT_AMOUNT . $MNT_CURRENCY_CODE . $MNT_TEST_MODE . CSalePaySystemAction::GetParamValue("DATA_INTEGRITY_CODE", ""));

$host = COption::GetOptionString("main", "server_name", $_SERVER["HTTP_HOST"]);
if($host == "") $host = $_SERVER["HTTP_HOST"];
$host = $_SERVER['HTTPS'] == 'on' ? 'https://'.$host : 'http://'.$host;

// new to create an invoice
if ($invoice) {
    $arOrder = $MNT_TRANSACTION_ID;
    $payment_method = $payment_system;

    // lang file
    include_once(GetLangFileName($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/payment/".$payment_method."/", "/payment.php"));
    // moneta lib
    require_once(dirname(__FILE__).'/MonetaAPI/MonetaWebService.php');

    $payment_server = CSalePaySystemAction::GetParamValue("MNT_PAYMENT_SERVER", "www.payanyway.ru");
    switch ($payment_server)
    {
        case "demo.moneta.ru":
            $service = new MonetaWebService("https://demo.moneta.ru/services.wsdl", CSalePaySystemAction::GetParamValue('PAYANYWAY_LOGIN', ''), CSalePaySystemAction::GetParamValue('PAYANYWAY_PASSWORD', ''));
            break;
        case "www.payanyway.ru":
            $service = new MonetaWebService("https://service.payanyway.ru/services.wsdl", CSalePaySystemAction::GetParamValue('PAYANYWAY_LOGIN', ''), CSalePaySystemAction::GetParamValue('PAYANYWAY_PASSWORD', ''));
            break;
    }

    try
    {
        $totalAmount = $MNT_AMOUNT." ".$MNT_CURRENCY_CODE;
        $fee = "-";

        // check commision via moneta API
        if ($account_id) {
            $transactionRequestType = new MonetaForecastTransactionRequest();
            $transactionRequestType->payer = $account_id;
            $transactionRequestType->payee = $MNT_ID;
            $transactionRequestType->amount = $MNT_AMOUNT;
            $transactionRequestType->clientTransaction = $MNT_TRANSACTION_ID;
            $forecast = $service->ForecastTransaction($transactionRequestType);
            $totalAmount = number_format($forecast->payerAmount,2,'.','')." ".$forecast->payerCurrency;
            $fee = number_format($forecast->payerFee,2,'.','')." ".$forecast->payerCurrency;
        }

        $request = new MonetaInvoiceRequest();
        if ($account_id) {
            $request->payer = $account_id;
        }

        $request->payee = $MNT_ID;
        $request->amount = $MNT_AMOUNT;
        $request->clientTransaction = $MNT_TRANSACTION_ID;

        $response = $service->Invoice($request);
        $operation_id = $response->transaction;
        if ($payment_method == 'payanyway_euroset') {
            $response1 = $service->GetOperationDetailsById($response->transaction);
            foreach ($response1->operation->attribute as $attr) {
                if ($attr->key == 'rapidatid') {
                    $transaction_id = $attr->value;
                }
            }
        } else {
            $transaction_id = $response->transaction;
        }

        $title = GetMessage("PAW_INVOICE_CREATED_TTL");
        $invoice =  array( 'status' => $response->status,
            'system' => $payment_method,
            'ctid' => $MNT_TRANSACTION_ID,
            'transaction' => str_pad($transaction_id, 10, "0", STR_PAD_LEFT),
            'operation' => $operation_id,
            'amount' => $totalAmount,
            'fee' => $fee,
            'unitid' => $unit_id,
            'payment_server' => $payment_server);

    }
    catch (Exception $e)
    {
        $title = GetMessage("PAW_INVOICE_ERROR_TTL");
        $invoice = array( 'status' => 'FAILED',
            'error_message' => $e->getMessage());
    }

    $APPLICATION->SetTitle($title);
    if ($invoice['status'] !== 'FAILED')
    {
        echo str_replace(
            array('%transaction%', '%operation%', '%ctid%', '%amount%', '%unitid%', '%payment_server%', '%fee%'),
            array($invoice['transaction'], $invoice['operation'], $invoice['ctid'], $invoice['amount'], $invoice['unitid'], $invoice['payment_server'], $invoice['fee']),
            GetMessage("PAW_INVOICE_CREATED"));

        // let`s go and pay added invoice
        $action .= '?operationId=' . $invoice['transaction'];
    }
    else
    {
        // show error message
        echo "<p>".iconv("UTF-8",LANG_CHARSET,$invoice['error_message'])."</p>";
    }
}

echo '<form action="' . $action . '" method="post" accept-charset="utf-8">';
echo '<font class="tablebodytext">';
echo GetMessage("PAYMENT_PAYANYWAY_TO_PAY") . '<b>' . SaleFormatCurrency($MNT_AMOUNT, $MNT_CURRENCY_CODE) . '</b>';
echo '<p>';
echo '<input type="hidden" name="MNT_ID" value="' . $MNT_ID . '">';
echo '<input type="hidden" name="MNT_TRANSACTION_ID" value="' . $MNT_TRANSACTION_ID . '">';
echo '<input type="hidden" name="MNT_CURRENCY_CODE" value="' . $MNT_CURRENCY_CODE . '">';
echo '<input type="hidden" name="MNT_AMOUNT" value="' . $MNT_AMOUNT . '">';
echo '<input type="hidden" name="MNT_TEST_MODE" value="' . $MNT_TEST_MODE . '">';
echo '<input type="hidden" name="MNT_SIGNATURE" value="' . $MNT_SIGNATURE . '">';
echo '<input type="hidden" name="paymentSystem" value="' . $payment_system . '">';
echo '<input type="hidden" name="MNT_SUCCESS_URL" value="' . $host . '/personal/order/">';
echo '<input type="hidden" name="MNT_FAIL_URL" value="' . $host . '/personal/order/">';

foreach ($extraParameters as $name => $value) {
    echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
}
			
if ($invoice) {
    echo '<input type="hidden" name="action" value="invoice">';
}
			
if ($unit_id) {
    echo '<input type="hidden" name="paymentSystem.unitId" value="' . $unit_id . '">';
}
			
if ($account_id) {
    echo '<input type="hidden" name="paymentSystem.accountId" value="' . $account_id . '">';
}
			
if ($payment_system !== 'payanyway') {
    echo '<input type="hidden" name="followup" value="true">';
    echo '<input type="hidden" name="javascriptEnabled" value="true">';
}

echo '<input class="btn btn_color_ac" type="submit" value="' . GetMessage("PAYMENT_PAYANYWAY_BUTTON") . '">';
echo '</p>';
echo '</font>';
echo '</form>';

?>