<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?

include(GetLangFileName(dirname(__FILE__)."/", "/payment.php"));

$payment_system = 'payanyway_qbank';
$unit_id = 1006431;
$invoice = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && trim($_POST["SET_RAPIDA_PHONE"])!="")
	$rapidaPhone = trim($_POST["RAPIDA_PHONE"]);
else
	$rapidaPhone = '';

preg_match("/^(\+7)([\d]{10})$/", $rapidaPhone, $matches);

if (!$matches)
{
	?>
	<form method="post" action="<?= POST_FORM_ACTION_URI?>">
		<p><font color="Red"><?= GetMessage("PAYANYWAY_QBANK_RAPIDAPHONE_HELP")?></font></p>
		<input type="text" name="RAPIDA_PHONE" size="30" value="<?= $rapidaPhone?>" />
		<input type="submit" name="SET_RAPIDA_PHONE" value="<?= GetMessage("PAYANYWAY_EXTRA_PARAMS_OK")?>" />
	</form>
	<?
}
else
{
	$extraParameters["additionalParameters.rapidaPhone"] = $rapidaPhone;
	if(file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/payment/payanyway/payment.php"))
		include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/payment/payanyway/payment.php");
}
