<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
//$this->createFrame()->begin("");
$arJSParams = array(
    "CONTAINER_CLASS" => "ajax-h2ofavorites-list page-all-sect page-profile__favorites",
    "ELEMENT_MAPS" => $arResult['ELEMENT_MAPS']
);
if (is_array($arResult['ERRORS']['FATAL']) && !empty($arResult['ERRORS']['FATAL'])):?>

    <? foreach ($arResult['ERRORS']['FATAL'] as $error): ?>
        <?= ShowError($error) ?>
    <? endforeach ?>

<? elseif (is_array($arResult["FAVORITES"]) && !empty($arResult['FAVORITES'])): ?>

    <? if (is_array($arResult['ERRORS']['NONFATAL']) && !empty($arResult['ERRORS']['NONFATAL'])): ?>

        <? foreach ($arResult['ERRORS']['NONFATAL'] as $error): ?>
            <?= ShowError($error) ?>
        <? endforeach ?>

    <? endif ?>

    <? if ($arParams["DISPLAY_TOP_PAGER"]): ?>
        <?= $arResult["NAV_STRING"] ?><br/>
    <? endif; ?>
    <?
    global $arrFilterFavorList;
    $arrFilterFavorList = array(
        'ID' => $arResult['ELEMENT_IDS']
    );

    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "favorites",
        array(
            "PRODUCT_DISPLAY_MODE" => "Y",
            "PRODUCT_SUBSCRIPTION" => "N",
            "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
            "SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
            "ADD_TO_BASKET_ACTION" => "ADD",
            "SHOW_CLOSE_POPUP" => "Y",
            "MESS_BTN_BUY" => GetMessage('H2O_FAVORITES_MESS_BTN_BUY'),
            "MESS_BTN_ADD_TO_BASKET" => GetMessage("H2O_FAVORITES_MESS_BTN_ADD_TO_BASKET"),
            "MESS_BTN_SUBSCRIBE" => "",
            "MESS_BTN_DETAIL" => GetMessage("H2O_FAVORITES_MESS_BTN_DETAIL"),
            "MESS_NOT_AVAILABLE" => GetMessage("H2O_FAVORITES_MESS_NOT_AVAILABLE"),
            "MESS_BTN_COMPARE" => "",
            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
            "ELEMENT_SORT_FIELD" => $arParams['ELEMENT_SORT_FIELD'],
            "ELEMENT_SORT_ORDER" => $arParams['ELEMENT_SORT_ORDER'],
            "ELEMENT_SORT_FIELD2" => $arParams['ELEMENT_SORT_FIELD2'],
            "ELEMENT_SORT_ORDER2" => $arParams['ELEMENT_SORT_ORDER2'],
            "SET_LAST_MODIFIED" => "N",
            "INCLUDE_SUBSECTIONS" => "Y",
            "BASKET_URL" => $arParams['BASKET_URL'],
            "ACTION_VARIABLE" => "action",
            "PRODUCT_ID_VARIABLE" => "id",
            "SECTION_ID_VARIABLE" => "SECTION_ID",
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "FILTER_NAME" => "arrFilterFavorList",
            "CACHE_TYPE" => $arParams['CACHE_TYPE'],
            "CACHE_TIME" => $arParams['CACHE_TIME'],
            "CACHE_FILTER" => $arParams['CACHE_FILTER'],
            "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
            "SET_TITLE" => "N",
            "MESSAGE_404" => "",
            "SET_STATUS_404" => "N",
            "SHOW_404" => "N",
            "FILE_404" => "N",
            "DISPLAY_COMPARE" => "N",
            "PAGE_ELEMENT_COUNT" => $arParams['FAVORITES_COUNT'],
            "LINE_ELEMENT_COUNT" => "3",
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "N",
            "USE_PRODUCT_QUANTITY" => "N",
            "ADD_PROPERTIES_TO_BASKET" => $arParams['ADD_PROPERTIES_TO_BASKET'],
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "PRODUCT_PROPERTIES" => $arParams['PRODUCT_PROPERTIES'],
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "PAGER_TITLE" => "",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "arrows",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "OFFERS_CART_PROPERTIES" => $arParams['OFFERS_CART_PROPERTIES'],
            "OFFERS_FIELD_CODE" => $arParams['OFFERS_FIELD_CODE'],
            "OFFERS_PROPERTY_CODE" => $arParams['OFFERS_PROPERTY_CODE'],
            "HIDE_NOT_AVAILABLE" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "SET_BROWSER_TITLE" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_META_DESCRIPTION" => "N",
            "COMPARE_NAME" => "CATALOG_COMPARE_LIST",
            "FILL_ITEM_ALL_PRICES" => "N",
            "SHOW_FROM_SECTION" => "N",
            "SHOW_ALL_WO_SECTION" => "Y",
            "COMPONENT_TEMPLATE" => "old_version_16",

            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
            "OFFERS_SORT_FIELD" => "sort",
            "OFFERS_SORT_ORDER" => "asc",
            "OFFERS_SORT_FIELD2" => "id",
            "OFFERS_SORT_ORDER2" => "desc",
            "PROPERTY_CODE" => $arParams['PROPERTY_CODE'],
            "OFFERS_LIMIT" => $arParams['OFFERS_LIMIT'],
            "SEF_MODE" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "USE_MAIN_ELEMENT_SECTION" => "N",
            "CONVERT_CURRENCY" => "N",
            "COMPATIBLE_MODE" => "Y",
            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
            'CONTAINER_CLASS' => $arJSParams['CONTAINER_CLASS']
        ),
        $component,
        false
    ); ?>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <br/><?= $arResult["NAV_STRING"] ?>
    <? endif; ?>

<? else: ?>
    <section class="<?= $arJSParams['CONTAINER_CLASS'] ?>">
        <div class="new-container">
            <div class="new-row">
                <div class="new-col-12">
                    <div class="page-all-sect__top-title">
                        <h2>Избранные товары</h2>
                    </div>
                </div>
            </div>
            <div class="new-row">
                <div class="new-col-12">
                    <div class="pp-favorites-icon">
                        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/favorite.svg') ?>" class="">
                    </div>
                </div>
                <div class="new-col-12">
                    <div class="new-row">
                        <div class="new-col-12">
                            <div class="b-content">
                                <p>Здесь Вы можете отложить понравившийся товар, чтобы потом легко его найти.</p>

                                <p><strong>Внимание! <br>Отложенный товар не является резервом заказа</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<? endif; ?>
<script>
    var H2oFavoritesList = new JCH2oFavoritesList(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>