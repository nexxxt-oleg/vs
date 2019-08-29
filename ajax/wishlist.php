<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

if ($REQUEST_METHOD === "POST") {
//Подключаем модуль sale
    Loader::includeModule("sale");
//Получаем корзину текущего пользователя
    $fUserID = CSaleBasket::GetBasketUserID(True);
    $fUserID = (int)$fUserID;
//Создаем переменные для обработчика
    $arFields = array(
        "PRODUCT_ID" => (int)$HTTP_POST_VARS['p_id'],
        "PRODUCT_PRICE_ID" => (int)$HTTP_POST_VARS['pp_id'],
        "PRICE" => strip_tags($HTTP_POST_VARS['p']),
        "CURRENCY" => "RUB",
        "WEIGHT" => 0,
        "QUANTITY" => 1,
        "LID" => 's1',
        "DELAY" => "Y",
        "CAN_BUY" => "Y",
        "NAME" => mb_convert_encoding(strip_tags($HTTP_POST_VARS['name']), "UTF-8"),
        "MODULE" => "sale",
        "NOTES" => "",
        "DETAIL_PAGE_URL" => strip_tags($HTTP_POST_VARS['dpu']),
        "FUSER_ID" => $fUserID
    );
//Получаем количество отложеных товаров
    if (CSaleBasket::Add($arFields)) {
        $arBasketItems = array();
        $dbBasketItems = CSaleBasket::GetList(
            array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL",
                "DELAY" => "Y",
            ),
            false,
            false,
            array("PRODUCT_ID")
        );
        while ($arItems = $dbBasketItems->Fetch()) {
            $arBasketItems[] = $arItems["PRODUCT_ID"];
        }
        //Загоняем отложенне в переменную
        $inwished = count($arBasketItems);
    }
//Выводи количество отложенных товаров
    echo $inwished;
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
}
?>