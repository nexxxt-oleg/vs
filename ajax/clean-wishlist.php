<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

Loader::includeModule("sale");
$res = CSaleBasket::GetList(array(), array(
    'FUSER_ID' => CSaleBasket::GetBasketUserID(),
    'LID' => SITE_ID,
    'DELAY' => 'Y',
    'CAN_BUY' => 'Y'));
while ($row = $res->fetch()) {
    CSaleBasket::Delete($row['ID']);
}