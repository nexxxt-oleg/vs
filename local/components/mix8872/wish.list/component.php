<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

Loader::includeModule("sale");
Loader::includeModule("catalog");
Loader::includeModule("iblock");

$dbBasketItems = CSaleBasket::GetList(
    array(
        "NAME" => "ASC",
        "ID" => "ASC"
    ),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => "NULL",
        "DELAY" => "Y"
    ),
    false,
    false,
    array('ID', 'DELAY', 'PRODUCT_ID', 'PRICE', 'DISCOUNT_PRICE')
);
$arResult = [];

if ($REQUEST_METHOD === "POST") {

    if (isset($HTTP_POST_VARS['CLEAN']) && $HTTP_POST_VARS['CLEAN'] === 'Y') {
        while ($row = $dbBasketItems->Fetch()) {
            CSaleBasket::Delete($row['ID']);
        }
        $this->includeComponentTemplate();
        $arResult['COUNT'] = 0;
        return $arResult;
    } else {
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
            "LID" => SITE_ID,
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
            while ($arItems = $dbBasketItems->Fetch()) {
                $arBasketItems[] = $arItems["PRODUCT_ID"];
            }
            //Загоняем отложенне в переменную
            $inwished = count($arBasketItems);
        }
        echo $inwished;
        require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
    }
} else {
    $arResult["PRICES"] = CIBlockPriceTools::GetCatalogPrices($arParams["IBLOCK_ID"], $arParams["PRICE_CODE"]);
    $arSelect = [
        "ID",
        "IBLOCK_ID",
        "CODE",
        "XML_ID",
        "NAME",
        "ACTIVE",
        "DATE_ACTIVE_FROM",
        "DATE_ACTIVE_TO",
        "SORT",
        "PREVIEW_TEXT",
        "PREVIEW_TEXT_TYPE",
        "DETAIL_TEXT",
        "DETAIL_TEXT_TYPE",
        "DATE_CREATE",
        "CREATED_BY",
        "TIMESTAMP_X",
        "MODIFIED_BY",
        "TAGS",
        "IBLOCK_SECTION_ID",
        "DETAIL_PAGE_URL",
        "DETAIL_PICTURE",
        "PREVIEW_PICTURE",
        'CATALOG_GROUP_' . $arParams['PRICE_CODE']
    ];
    $arSort = [];

    while ($arItem = $dbBasketItems->Fetch()) {
        $arBasketItems[] = $arItems["PRODUCT_ID"];
        if ($arItem['DELAY'] == 'Y') {
            $arFilter = [
                'ID' => $arItem["PRODUCT_ID"],
                "ACTIVE" => "Y"
            ];
            $res = CIBlockElement::GetList($arSort, $arFilter, false, [], $arSelect);
            if ($ar_res = $res->Fetch()) {
                $item = array();

                $item['DETAIL'] = $ar_res;
                $item['DETAIL']['RESIZED_IMG'] = CFile::ResizeImageGet($ar_res['PREVIEW_PICTURE'], Array("width" => '285', "height" => '278'), BX_RESIZE_IMAGE_PROPORTIONAL);

                $item["PRICES"] = CIBlockPriceTools::GetItemPrices($ar_res["IBLOCK_ID"], $arResult["PRICES"], $ar_res, 'Y', []);
                if (!empty($item['DETAIL']['PRICES']))
                    $item['DETAIL']['MIN_PRICE'] = CIBlockPriceTools::getMinPriceFromList($item['DETAIL']['PRICES']);

                $item['DETAIL'] = array_merge($item['DETAIL'], $arItem);

                $arResult['ITEMS'][$arItem["PRODUCT_ID"]] = $item;
            }
        }
    }
    unset($item);
    unset($res);
    unset($ar_res);

    $arResult['COUNT'] = count($arBasketItems);
    $this->includeComponentTemplate();
    return $arResult;
}