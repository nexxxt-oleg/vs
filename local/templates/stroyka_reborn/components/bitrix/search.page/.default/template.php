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

$APPLICATION->SetTitle("Результаты поиска");

global $SORT;
global $ORDER;

$SORT = $_GET['sort'] ?? 'shows';
$ORDER = $_GET['order'] ?? 'asc';

$GLOBALS['searchFilter'] = [
    "ACTIVE" => "Y",
    'ID' => array_column($arResult['SEARCH'], 'ITEM_ID')
];

if ($GLOBALS['searchFilter']['ID']) :
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "search",
        Array(
            "ACTION_VARIABLE" => "action",
            "ADD_PICT_PROP" => "-",
            "ADD_PROPERTIES_TO_BASKET" => "Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "ADD_TO_BASKET_ACTION" => "ADD",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "BACKGROUND_IMAGE" => "-",
            "BASKET_URL" => "/personal/cart/",
            "BROWSER_TITLE" => "-",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "COMPATIBLE_MODE" => "Y",
            "CONVERT_CURRENCY" => "N",
            "DETAIL_URL" => "",
            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_COMPARE" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "ELEMENT_SORT_FIELD" => $SORT,
            "ELEMENT_SORT_FIELD2" => "id",
            "ELEMENT_SORT_ORDER" => $ORDER,
            "ELEMENT_SORT_ORDER2" => "desc",
            'USE_FILTER' => 'Y',
            'SHOW_ALL_WO_SECTION' => 'Y',
            "FILTER_NAME" => "searchFilter",
            "HIDE_NOT_AVAILABLE" => "Y",
            "HIDE_NOT_AVAILABLE_OFFERS" => "Y",
            "IBLOCK_ID" => "21",
            "IBLOCK_TYPE" => "catalog",
            "INCLUDE_SUBSECTIONS" => "Y",
            "LABEL_PROP" => "-",
            "LAZY_LOAD" => "N",
            "LINE_ELEMENT_COUNT" => "4",
            "LOAD_ON_SCROLL" => "N",
            "MESSAGE_404" => "",
            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
            "MESS_BTN_BUY" => "Купить",
            "MESS_BTN_COMPARE" => "Сравнить",
            "MESS_BTN_DETAIL" => "Подробнее",
            "MESS_BTN_SUBSCRIBE" => "Подписаться",
            "MESS_NOT_AVAILABLE" => "Нет в наличии",
            "META_DESCRIPTION" => "-",
            "META_KEYWORDS" => "-",
            "OFFERS_CART_PROPERTIES" => array(),
            "OFFERS_FIELD_CODE" => array("", ""),
            "OFFERS_LIMIT" => "5",
            "OFFERS_PROPERTY_CODE" => array("", ""),
            "OFFERS_SORT_FIELD" => "sort",
            "OFFERS_SORT_FIELD2" => "id",
            "OFFERS_SORT_ORDER" => "asc",
            "OFFERS_SORT_ORDER2" => "desc",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Товары",
            "PAGE_ELEMENT_COUNT" => "30",
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "PRICE_CODE" => array("Розничная руб."),
            "PRICE_VAT_INCLUDE" => "Y",
            "PRODUCT_DISPLAY_MODE" => "N",
            "PRODUCT_ID_VARIABLE" => "id",
            "PRODUCT_PROPERTIES" => array(),
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "PRODUCT_SUBSCRIPTION" => "Y",
            "PROPERTY_CODE" => array("", ""),
            "RCM_TYPE" => "personal",
            "SECTION_CODE" => "",
            "SECTION_ID" => "",
            "SECTION_ID_VARIABLE" => "SECTION_ID",
            "SECTION_URL" => "",
            "SECTION_USER_FIELDS" => array("", ""),
            "SEF_MODE" => "N",
            "SET_BROWSER_TITLE" => "Y",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "Y",
            "SET_META_KEYWORDS" => "Y",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "Y",
            "SHOW_404" => "N",
            "SHOW_ALL_WO_SECTION" => "Y",
            "SHOW_CLOSE_POPUP" => "Y",
            "SHOW_DISCOUNT_PERCENT" => "N",
            "SHOW_FROM_SECTION" => "N",
            "SHOW_MAX_QUANTITY" => "N",
            "SHOW_OLD_PRICE" => "Y",
            "SHOW_PRICE_COUNT" => "1",
            "TEMPLATE_THEME" => "blue",
            "USE_ENHANCED_ECOMMERCE" => "N",
            "USE_MAIN_ELEMENT_SECTION" => "N",
            "USE_PRICE_COUNT" => "N",
            "USE_PRODUCT_QUANTITY" => "Y",
            'TITLE' => 'Результаты поиска',
        )
    );
else: ?>

    <section class="page-all-sect page-profile__favorites">
        <div class="new-container">

            <div class="new-row">
                <div class="new-col-8">
                    <div class="page-all-sect__top-title">
                        <h2>Результаты поиска</h2>
                    </div>
                </div>
                <div class="new-col-lg-12">
                    <div class="new-row">
                        <div class="search-result__wrap">

                            <div class="new-col-12 new-col-sm-6 new-col-lg-5">
                                <form class="search-result__form form-result">
                                    <input name="q" type="text" class="form-result__input" placeholder="Поиск..." value="<?= $_GET["q"] ?>">
                                    <input type="hidden" name="how"
                                           value="<? echo $arResult["REQUEST"]["HOW"] == "d" ? "d" : "r" ?>"/>
                                    <button class="form-result__btn" type="submit">
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/search.svg') ?>" alt="" class="img-svg">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="new-row">
                <div class="new-col-12">
                    <div class="new-row">
                        <div class="new-col-12">
                            <div class="b-content">
                                <p>К сожалению по вашему запросу ничего не найдено</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

<? endif;



