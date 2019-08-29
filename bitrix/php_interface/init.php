<?php

use Bitrix\Sale;
use Bitrix\Main\Loader;
use Bitrix\Main\Data;

/**
 * Created by PhpStorm.
 * User: Mix
 * Date: 08.02.2018
 * Time: 12:06
 */
/***Как посчитать стоимость товара или предложения со всеми скидками***/

/*Логин по email*/
/*AddEventHandler("main", "OnBeforeUserLogin", "OnBeforeUserLoginHandler");

function OnBeforeUserLoginHandler(&$arFields) {
    if (isset($_POST['USER_LOGIN'])) {
        $e = htmlspecialchars($_POST['USER_LOGIN'], ENT_QUOTES);
        $filter = Array("EMAIL" => $e);
        $rsUsers = CUser::GetList(($by="id"), ($order="desc"), $filter);
        $res = $rsUsers->Fetch();
        $arFields["LOGIN"] = $res['LOGIN'];
    }
}*/

AddEventHandler("main", "OnEpilog", "My404PageInSiteStyle");
function My404PageInSiteStyle()
{
    if (defined('ERROR_404') && ERROR_404 == 'Y') {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/404.php';
        include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';
    }
}

if (isset($_POST["BasketClear"]) && CModule::IncludeModule("sale")) {
    $uid = CSaleBasket::GetBasketUserID();
    $res = CSaleBasket::GetList([], [
        'FUSER_ID' => $uid,
        'LID' => SITE_ID,
        'ORDER_ID' => 'null',
    ]);
    while ($row = $res->Fetch()) {
        CSaleBasket::Delete($row['ID']);
    }
}

function getFinalPriceInCurrency($item_id, $sale_currency = 'RUB')
{
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("catalog");
    CModule::IncludeModule("sale");
    global $USER;

    $currency_code = 'RUB';

    // Проверяем, имеет ли товар торговые предложения?
    if (CCatalogSku::IsExistOffers($item_id)) {

        // Пытаемся найти цену среди торговых предложений
        $res = CIBlockElement::GetByID($item_id);

        if ($ar_res = $res->GetNext()) {

            if (isset($ar_res['IBLOCK_ID']) && $ar_res['IBLOCK_ID']) {

                // Ищем все тогровые предложения
                $offers = CIBlockPriceTools::GetOffersArray(array(
                    'IBLOCK_ID' => $ar_res['IBLOCK_ID'],
                    'HIDE_NOT_AVAILABLE' => 'Y',
                    'CHECK_PERMISSIONS' => 'Y'
                ), array($item_id), null, null, null, null, null, null, array('CURRENCY_ID' => $sale_currency), $USER->getId(), null);

                foreach ($offers as $offer) {

                    $price = CCatalogProduct::GetOptimalPrice($offer['ID'], 1, $USER->GetUserGroupArray(), 'N');
                    if (isset($price['PRICE'])) {

                        $final_price = $price['PRICE']['PRICE'];
                        $currency_code = $price['PRICE']['CURRENCY'];

                        // Ищем скидки и высчитываем стоимость с учетом найденных
                        $arDiscounts = CCatalogDiscount::GetDiscountByProduct($item_id, $USER->GetUserGroupArray(), "N");
                        if (is_array($arDiscounts) && sizeof($arDiscounts) > 0) {
                            $final_price = CCatalogProduct::CountPriceWithDiscount($final_price, $currency_code, $arDiscounts);
                        }

                        // Конец цикла, используем найденные значения
                        break;
                    }

                }
            }
        }

    } else {

        // Простой товар, без торговых предложений (для количества равному 1)
        $price = CCatalogProduct::GetOptimalPrice($item_id, 1, $USER->GetUserGroupArray(), 'N');

        // Получили цену?
        if (!$price || !isset($price['PRICE'])) {
            return false;
        }

        // Меняем код валюты, если нашли
        if (isset($price['CURRENCY'])) {
            $currency_code = $price['CURRENCY'];
        }
        if (isset($price['PRICE']['CURRENCY'])) {
            $currency_code = $price['PRICE']['CURRENCY'];
        }

        // Получаем итоговую цену
        $final_price = $price['PRICE']['PRICE'];

        // Ищем скидки и пересчитываем цену товара с их учетом
        $arDiscounts = CCatalogDiscount::GetDiscountByProduct($item_id, $USER->GetUserGroupArray(), "N", 2);
        if (is_array($arDiscounts) && sizeof($arDiscounts) > 0) {
            $final_price = CCatalogProduct::CountPriceWithDiscount($final_price, $currency_code, $arDiscounts);
        }

    }

    // Если необходимо, конвертируем в нужную валюту
    if ($currency_code != $sale_currency) {
        $final_price = CCurrencyRates::ConvertCurrency($final_price, $currency_code, $sale_currency);
    }

    return $final_price;

}


AddEventHandler("main", "OnBeforeProlog", "MyOnBeforePrologHandler", 50);

function MyOnBeforePrologHandler()
{
    // Получение списка избранных товаров.
    // Вынесено сюда воизбежание повторных запросов на выборку списка и ошибок с кешированными данными.

    if (Loader::includeModule('h2o.favorites')) {
        if (Loader::includeModule('iblock')) {
            global $APPLICATION;
            global $USER;
            global $arFavorites;
            $userId = $USER && $USER->IsAuthorized() ? $USER->GetID() : '';
            $cookieUserId = $APPLICATION->get_cookie("H2O_COOKIE_USER_ID");
            $arFilter = [];
            if (!empty($userId)){
                $arFilter["filter"] = [
                    'USER_ID' => $userId,
                    'ACTIVE' => 'Y',
                    ];
            }
            else{
                $arFilter["filter"] = [
                    'COOKIE_USER_ID' => $cookieUserId,
                    'ACTIVE' => 'Y',
                ];
            }
            $arFilter["count_total"] = true;
            $favorItemsReq = \h2o\Favorites\FavoritesTable::getList($arFilter);
            $APPLICATION->delayedItems = array();
            $arFavorites = array();
            while ($arItem = $favorItemsReq->fetch()) {
                $APPLICATION->delayedItems[] = $arItem['ELEMENT_ID'];
                $arFavorites[] = $arItem['ELEMENT_ID'];
            }
        }
    }
}



if (!function_exists('mb_ucfirst') && extension_loaded('mbstring')) {
    /**
     * mb_ucfirst - преобразует первый символ в верхний регистр
     * @param string $str - строка
     * @param string $encoding - кодировка, по-умолчанию UTF-8
     * @return string
     */
    function mb_ucfirst($str, $encoding = 'UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) .
            mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }
}