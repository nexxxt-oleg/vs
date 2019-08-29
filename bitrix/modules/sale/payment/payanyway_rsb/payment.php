<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

include(GetLangFileName(dirname(__FILE__)."/", "/payment.php"));

$payment_system = 'payanyway_RSB';
$unit_id = 845902;
$invoice = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && trim($_POST["SET_NEW_RSB"])!=""){
	$rsbClientPhone = trim($_POST["RSB_CLIENT_PHONE"]);
	$rsbPaymentPurpose = trim($_POST["RSB_PAYMENTPURPOSE"]);
} else {
	$rsbClientPhone = "";
	$rsbPaymentPurpose = "";
}

preg_match("/^([\d]{10})$/", $rsbClientPhone, $matches);

if (!$matches)
{
	?>
	<form method="post" action="<?= POST_FORM_ACTION_URI?>">
		<p><font color="Red"><?= GetMessage("PAYANYWAY_RSB_DESC")?></font></p>
		<table>
			<tr>
				<td><label><?= GetMessage("PAYANYWAY_RSB_CLIENT_PHONE")?></label></td>
				<td><input type="text" name="RSB_CLIENT_PHONE" value="<?= $rsbClientPhone?>"></td>
				<td><p><font color="Red"><?= GetMessage("PAYANYWAY_RSB_CLIENT_PHONE_HELP")?></font></p></td>
			</tr>
			<tr>
				<td><label><?= GetMessage("PAYANYWAY_RSB_PAYMENTPURPOSE")?></label></td>
				<td><input type="text" name="RSB_PAYMENTPURPOSE" value="<?= $rsbPaymentPurpose?>"></td>
			</tr>
		</table>
		<input type="submit" name="SET_NEW_RSB" value="<?= GetMessage("PAYANYWAY_EXTRA_PARAMS_OK")?>" />
	</form>
<?
}
else
{
	$extraParameters["additionalParameters.rsbClientPhone"] = $rsbClientPhone;
	$extraParameters["additionalParameters.rsbPaymentPurpose"] = $rsbPaymentPurpose;

	if(file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/payment/payanyway/payment.php"))
		include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/payment/payanyway/payment.php");
}
