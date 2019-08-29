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

$elementsCount = explode(',',\Bitrix\Main\Config\Option::get('grain.customsettings', 'page_elements'));

function sectionTitle()
{
    global $arSectionResult;

    $title = mb_strtoupper(mb_substr($arSectionResult['NAME'], 0, 1)) . mb_strtolower(mb_substr($arSectionResult['NAME'], 1, mb_strlen($arSectionResult['NAME'])));

    return $title;
}

//Проверяем, есть ли данный товар в отложенных
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
    array("PRODUCT_ID")
);

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

$delayedItems = array();
while ($arItem = $dbBasketItems->Fetch()) {
    $delayedItems[] = $arItem['PRODUCT_ID'];
}

if (!empty($arResult['ITEMS'])) {
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
?>
    <div class="page-catalog__top-navs top-navs new-row">
    <?
    if ($arParams["DISPLAY_TOP_PAGER"]) { ?>

                    <div class="new-col-sm-7 new-col-md-7 new-col-lg-7">
                        <? $APPLICATION->IncludeComponent(
                            "codeblogpro:sort.panel",
                            "grechka",
                            Array(
                                "CACHE_TIME" => "36000000",
                                "CACHE_TYPE" => "A",
                                "FIELDS_CODE" => array("shows", "name", "created"),
                                "IBLOCK_ID" => "21",
                                "IBLOCK_TYPE" => "catalog",
                                "INCLUDE_SORT_TO_SESSION" => "N",
                                "ORDER_NAME" => "ORDER",
                                "PRICE_CODE" => array("5"),
                                "PROPERTY_CODE" => array(),
                                "SORT_NAME" => "SORT",
                                "SORT_ORDER" => array("asc", "desc"),
                                'CURRENT_SORT_FIELD' => $arParams['ELEMENT_SORT_FIELD'],
                                'CURRENT_SORT_ORDER' => $arParams['ELEMENT_SORT_ORDER']
                            )
                        ); ?>
                    </div>
                    <div class="new-col-sm-5 new-col-md-5 new-col-lg-5">
                        <div class="catalog-counter top-navs__counter">
                            <span class="catalog-sort__title">Товаров на странице:</span>
                            <div class="catalog-sort__select catalog-sort__select_short form-wraper formselect-radio">
                                <?
                                $resLinks = '';
                                $activeItem = '';
                                foreach($elementsCount as $countItem){
                                    $countItem = trim($countItem);
                                    $url = $APPLICATION->GetCurPageParam('elements=' . $countItem, ['elements', 'SHOWALL_1']);
                                    $activeClass = $arResult['NAV_RESULT']->NavPageSize == $countItem ? 'active' : '';
                                    $resLinks .= '<a href="'. $url. '" class="formselect-radio__item '. $activeClass. '">'. $countItem . '</a>';
                                    if($arResult['NAV_RESULT']->NavPageSize == $countItem){
                                        $activeItem = $countItem;
                                    }
                                }
                                ?>
                                <div class="form-wraper__box formselect-radio__value form-box" title="<?=$activeItem?>">
                                    <span><?=$activeItem?></span>
                                </div>
                                <button type="button" class="form-wraper__button formselect-radio__arrow">
                                    <img src="<?=$APPLICATION->GetTemplatePath('img/ui-icon/dropdown.svg')?>" alt="" class="img-svg">
                                </button>
                                <div class="formselect-radio__list">
                                    <?=$resLinks?>
                                    <a href="<?= $APPLICATION->GetCurPageParam('SHOWALL_1=1', ['SHOWALL_1']) ?>" class="formselect-radio__item <?= isset($_GET['SHOWALL_1']) && $_GET['SHOWALL_1'] == 1 ? 'active' : '' ?>">Все</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <? }

    $elementActions = [
        'EDIT' => CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"),
        'DELETE' => CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"),
        'DELETE_PARAMS' => array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM')),
    ];

    if ($arParams['HIDE_SECTION_DESCRIPTION'] !== 'Y') { ?>

        <div class="bx-section-desc">
            <p class="bx-section-desc-post"><?= $arResult["DESCRIPTION"] ?></p>
        </div>

    <? } ?>



        <div class="new-row">
        <? foreach ($arResult['ITEMS'] as $key => $item): ?>
            <div class="new-col-6 new-col-sm-6 new-col-md-4 new-col-lg-3 col-no-padding">
                <div class="card-wraper">
                    <? $APPLICATION->IncludeComponent(
                        'bitrix:catalog.item',
                        'grechka-new',
                        array(
                            'RESULT' => array(
                                'ITEM' => $item,
                                'AREA_ID' => $areaIds[$item['ID']],
//                                'TYPE' => $rowData['TYPE'],
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
    <?
    if ($arParams["DISPLAY_BOTTOM_PAGER"]) { ?>
        <div class="row">
            <div class="col-12"></div>
            <div class="col-12">
                <div class="page-catalog__top-navs row">
                    <div class="col-12">
                        <?= $arResult["NAV_STRING"]; ?>
                    </div>
                </div>
            </div>
        </div>
    <? }
}