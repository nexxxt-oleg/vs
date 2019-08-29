<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if ($_POST["BasketClear"] and CModule::IncludeModule("sale"))
{
    $uid = CSaleBasket::GetBasketUserID();
	echo CSaleBasket::DeleteAll($uid);
}