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
$this->setFrameMode(true);

global $arSectionResult;
$arSectionResult = $arResult;
$isFilter = ($arParams['USE_FILTER'] == 'Y');
$elementsCount = explode(',', \Bitrix\Main\Config\Option::get('grain.customsettings', 'page_elements'));

$generalParams = array(
    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
    'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
    'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
    'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
    'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],
    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
    'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
    'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
    'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
    'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
    'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
    'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'],
    'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
    'COMPARE_PATH' => $arParams['COMPARE_PATH'],
    'COMPARE_NAME' => $arParams['COMPARE_NAME'],
    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
    'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
    'LABEL_POSITION_CLASS' => $labelPositionClass,
    'DISCOUNT_POSITION_CLASS' => $discountPositionClass,
    'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
    'SLIDER_PROGRESS' => $arParams['SLIDER_PROGRESS'],
    '~BASKET_URL' => $arParams['~BASKET_URL'],
    '~ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
    '~BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
    '~COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
    '~COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
    'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
    'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY'],
    'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
    'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
    'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
    'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
    'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
    'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE']
);
if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y') {
    $basketAction = isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '';
} else {
    $basketAction = isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '';
}

if (!empty($arResult['ITEMS'])) :
    $templateLibrary = array('popup');
    $currencyList = '';
    if (!empty($arResult['CURRENCIES'])) {
        $templateLibrary[] = 'currency';
        $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
    }
    unset($currencyList, $templateLibrary);

    $areaIds = array();

    foreach ($arResult['ITEMS'] as $item) {
        $uniqueId = $item['ID'] . '_' . md5($this->randString() . $component->getAction());
        $areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
        $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
        $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
    }

    $elementActions = [
        'EDIT' => CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"),
        'DELETE' => CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"),
        'DELETE_PARAMS' => array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM')),
    ];
    ?>
    <section class="<?= $arParams['CONTAINER_CLASS'] ?>">
        <div class="new-container">
            <div class="new-row">
                <div class="new-col-12">
                    <div class="page-all-sect__top-title">
                        <h2>Избранные товары</h2>
                    </div>
                </div>
                <div class="new-col-lg-12">
                    <div class="new-row">
                        <div class="search-result__wrap">
                            <div class="new-col-8 new-col-sm-6 new-col-lg-3">
                                <? $APPLICATION->IncludeComponent(
                                    "codeblogpro:sort.panel",
                                    "grechka",
                                    array(
                                        "CACHE_TIME" => "36000000",
                                        "CACHE_TYPE" => "A",
                                        "FIELDS_CODE" => array(
                                            "name",
                                            "shows",
                                            "created",
                                        ),
                                        "IBLOCK_ID" => "21",
                                        "IBLOCK_TYPE" => "catalog",
                                        "INCLUDE_SORT_TO_SESSION" => "N",
                                        "ORDER_NAME" => "ORDER",
                                        "PRICE_CODE" => array(
                                            0 => "5",
                                        ),
                                        "PROPERTY_CODE" => array(),
                                        "SORT_NAME" => "SORT",
                                        "SORT_ORDER" => array(
                                            "asc",
                                            "desc",
                                        ),
                                        "COMPONENT_TEMPLATE" => "grechka"
                                    ),
                                    false
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="new-row">
                <? foreach ($arResult['ITEMS'] as $key => $item): ?>
                    <div class="col-no-padding new-col-6 new-col-sm-4 new-col-lg-2">
                        <div class="card-wraper p-search-result__card-wraper">
                            <? $APPLICATION->IncludeComponent(
                                'bitrix:catalog.item',
                                'favorites',
                                array(
                                    'RESULT' => array(
                                        'ITEM' => $item,
                                        'AREA_ID' => $areaIds[$item['ID']],
//                                              'TYPE' => $rowData['TYPE'],
                                        'BIG_LABEL' => 'N',
                                        'BIG_DISCOUNT_PERCENT' => 'N',
                                        'BIG_BUTTONS' => 'Y',
                                        'SCALABLE' => 'N'
                                    ),
                                    'PARAMS' => $generalParams,
                                    'ACTIONS' => $elementActions
                                ),
                                $component,
                                array('HIDE_ICONS' => 'Y')
                            ); ?>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    </section>
    <? if ($arParams['DISPLAY_BOTTOM_PAGER']) : ?>
    <section class="main__paginations-sect paginations-sect">
        <div class="new-container">
            <div class="new-row">
                <div class="new-col-12">
                    <?= $arResult['NAV_STRING'] ?>
                </div>
            </div>
        </div>
    </section>
<? endif; ?>
<? endif; ?>