<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Page\Asset;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
$this->addExternalCss('/bitrix/css/main/bootstrap.css');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/catalog-item.js');


$arParams['USE_COMMENTS'] = 'Y';

$templateLibrary = array('popup', 'fx');
$currencyList = '';
$price = $item['MIN_PRICE'];  //Test this value!
$currency_lang = CCurrencyLang::GetByID($arResult['MIN_PRICE']['CURRENCY'], "ru");
$currency = trim($currency_lang["FORMAT_STRING"], ("# "));
$old_price_param = $arResult['PROPERTIES']['STARAYA_TSENA']['VALUE']; // свойсво Старая цена

if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
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
$delayedItems = array();
while ($arItem = $dbBasketItems->Fetch()) {
    $delayedItems[] = $arItem['PRODUCT_ID'];
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
    'STICKER_ID' => $mainId . '_sticker',
    'BIG_SLIDER_ID' => $mainId . '_big_slider',
    'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId . '_slider_cont',
    'OLD_PRICE_ID' => $mainId . '_old_price',
    'PRICE_ID' => $mainId . '_price',
    'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
    'PRICE_TOTAL' => $mainId . '_price_total',
    'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
    'QUANTITY_ID' => $mainId . '_quantity',
    'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
    'QUANTITY_UP_ID' => $mainId . '_quant_up',
    'QUANTITY_MEASURE' => $mainId . '_quant_measure',
    'QUANTITY_LIMIT' => $mainId . '_quant_limit',
    'BUY_LINK' => $mainId . '_buy_link',
    'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
    'COMPARE_LINK' => $mainId . '_compare_link',
    'TREE_ID' => $mainId . '_skudiv',
    'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
    'OFFER_GROUP' => $mainId . '_set_group_',
    'BASKET_PROP_DIV' => $mainId . '_basket_prop',
    'SUBSCRIBE_LINK' => $mainId . '_subscribe',
    'TABS_ID' => $mainId . '_tabs',
    'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel',
    'TABS_PANEL_ID' => $mainId . '_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers) {
    $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
        ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
        : reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer) {
        if ($offer['MORE_PHOTO_COUNT'] > 1) {
            $showSliderControls = true;
            break;
        }
    }
} else {
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$dateCreate = new DateTime($arResult['DATE_CREATE']);
$currDate = new DateTime();
$currDate->format('Y-m-d H:i:s');
$diffDateCreate = $dateCreate->diff($currDate);

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION'])) {
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}
?>



























    <div class="container" id="<?= $itemIds['ID'] ?>" itemscope itemtype="http://schema.org/Product">
        <? if ($arParams['DISPLAY_NAME'] === 'Y') { ?>
            <div class="row">
                <div class="col-8">
                    <div class="page-all-sect__top-title">
                        <h2><?= $name ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <hr class="page-catalog__hr">
                </div>
            </div>
        <? } ?>
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="page-catalog-product__slider pc-product-slider"
                     id="<?= $itemIds['BIG_SLIDER_ID'] ?>">
                    <span class="pc-product-slider__close" data-entity="close-popup"></span>
                    <div class="pc-product-slider-big pc-product-slider__big"
                         data-entity="images-slider-block">

                    <span class="pc-product-slider-big__prev" data-entity="slider-control-left"
                          style="display: none;">
                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-left.svg") ?>" class="img-svg">
                    </span>
                        <span class="pc-product-slider-big__next" data-entity="slider-control-right"
                              style="display: none;">
                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-right.svg") ?>" class="img-svg">
                    </span>
                        <div class="pc-product-slider-big__sticker <?= $labelPositionClass ?>"
                             id="<?= $itemIds['STICKER_ID'] ?>" <?= (!$arResult['LABEL'] ? 'style="display: none;"' : '') ?>>
                            <? if ($arResult['LABEL'] && !empty($arResult['LABEL_ARRAY_VALUE'])) :
                                foreach ($arResult['LABEL_ARRAY_VALUE'] as $code => $value) : ?>
                                    <div<?= (!isset($arParams['LABEL_PROP_MOBILE'][$code]) ? ' class="hidden-xs"' : '') ?>>
                                        <span title="<?= $value ?>"><?= $value ?></span>
                                    </div>
                                <? endforeach;
                            endif; ?>
                        </div>
                        <?
                        if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y') :
                            if ($haveOffers) : ?>
                                <div class="pc-product-slider-big__pict <?= $discountPositionClass ?>"
                                     id="<?= $itemIds['DISCOUNT_PERCENT_ID'] ?>"
                                     style="display: none;">
                                </div>
                            <? elseif ($price['DISCOUNT'] > 0) : ?>
                                <div class="pc-product-slider-big__pict <?= $discountPositionClass ?>"
                                     id="<?= $itemIds['DISCOUNT_PERCENT_ID'] ?>"
                                     title="<?= -$price['PERCENT'] ?>%">
                                    <span><?= -$price['PERCENT'] ?>%</span>
                                </div>
                            <? endif;
                        endif; ?>
                        <div class="pc-product-slider-big__container mismatch-desc-parent"
                             data-entity="images-container">
                            <?
                            if (!empty($actualItem['MORE_PHOTO'])) {
                                foreach ($actualItem['MORE_PHOTO'] as $key => $photo) {
                                    ?>
                                    <div class="pc-product-slider-big__item mismatch-desc-wrap<?= ($key == 0 ? ' active' : '') ?>"
                                         data-entity="image"
                                         data-id="<?= $photo['ID'] ?>">
                                        <a href="#"
                                           class="pc-product-slider-big__mismatch-desc mismatch-desc js-item-img-mismatch"
                                           data-id="<?= $arResult['ID'] ?>"
                                           data-element="<?= $arResult['NAME'] ?>"
                                           data-element-url="<?= $arResult['DETAIL_PAGE_URL'] ?>">Сообщить менеджеру о
                                            несоответствии изображения товару</a>
                                        <img src="<?= $photo['SRC'] ?>" alt="<?= $alt ?>"
                                             title="<?= $title ?>"<?= ($key == 0 ? ' itemprop="image"' : '') ?>>
                                        <? if (!true): ?>

                                        <? else: ?>
                                            <div class="card-product__badges card-product__badges_upper-left-corner">
                                                <span class="card-product__badge card-product__badge_color_red d-none">Акция</span>
                                                <? if (isset($arResult['PROPERTIES']['KATEGORIYA']['VALUE']) && $arResult['PROPERTIES']['KATEGORIYA']['VALUE'] === "Спец.предложение"): ?>
                                                    <span class="card-product__badge card-product__badge_color_orange">Специальное предложение</span>
                                                <? elseif (isset($item['PROPERTIES']['KATEGORIYA']['VALUE']) && $item['PROPERTIES']['KATEGORIYA']['VALUE'] === "Уценка"): ?>

                                                    <? if (isset($arResult['PROPERTIES']['PRICHINA_UTSENKI']) && !empty($arResult['PROPERTIES']['PRICHINA_UTSENKI']['VALUE'])): ?>
                                                        <div class="card-product__badge card-product__badge_color_violet card-product__badge_why">
                                                            Уценка
                                                            <div class="card-product__desc-wrap">
                                                                <span class="card-product__desc-why">
                                                                    <?= $arResult['PROPERTIES']['PRICHINA_UTSENKI']['VALUE'] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    <? else: ?>
                                                        <span class="card-product__badge card-product__badge_color_violet">Уценка</span>
                                                    <? endif; ?>

                                                <? elseif (($diffDateCreate->format('%a')) < 30): ?>
                                                    <span class="card-product__badge card-product__badge_color_green">Новинка</span>
                                                <? endif; ?>
                                            </div>
                                        <? endif; ?>
                                    </div>
                                    <?
                                }
                            }
                            ?>
                        </div>
                        <? if ($arParams['SLIDER_PROGRESS'] === 'Y') { ?>
                            <div class="product-item-detail-slider-progress-bar" data-entity="slider-progress-bar"
                                 style="width: 0;"></div>
                        <? } ?>
                    </div>
                    <? if ($showSliderControls) :
                        if ($haveOffers) :
                            foreach ($arResult['OFFERS'] as $keyOffer => $offer) :
                                if (!isset($offer['MORE_PHOTO_COUNT']) || $offer['MORE_PHOTO_COUNT'] <= 0)
                                    continue;

                                $strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
                                ?>
                                <div class="pc-product-slider__small"
                                     id="<?= $itemIds['SLIDER_CONT_OF_ID'] . $offer['ID'] ?>"
                                     style="display: <?= $strVisible ?>;">
                                    <? foreach ($offer['MORE_PHOTO'] as $keyPhoto => $photo) : ?>
                                        <div class="pc-product-slider-small__item<?= ($keyPhoto == 0 ? ' active' : '') ?>"
                                             data-entity="slider-control"
                                             data-value="<?= $offer['ID'] . '_' . $photo['ID'] ?>">
                                            <img src="<?= $photo['SRC'] ?>">
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            <? endforeach;
                        else : ?>
                            <div class="pc-product-slider-small pc-product-slider__small"
                                 id="<?= $itemIds['SLIDER_CONT_ID'] ?>">
                                <? if (!empty($actualItem['MORE_PHOTO'])) {
                                    foreach ($actualItem['MORE_PHOTO'] as $key => $photo) { ?>
                                        <div class="pc-product-slider-small__item<?= ($key == 0 ? ' active' : '') ?>"
                                             data-entity="slider-control" data-value="<?= $photo['ID'] ?>">
                                            <img src="<?= $photo['SRC'] ?>">
                                        </div>
                                    <? }
                                } ?>
                            </div>
                        <? endif;
                    endif; ?>
                </div>
            </div>
            <div class="col-md-6 offset-lg-1 col-lg-4">
                <div class="page-catalog-product__props pc-product-props<?= false ? ' pc-product-props_action' : '' ?>">
                    <div class="row">
                        <div class="col-7 col-sm-6">
                            <div class="pc-product-props__code">
                                <p><strong>Код: </strong><?= $arResult['PROPERTIES']['CML2_TRAITS']['VALUE']['2'] ?></p>
                            </div>

                            <? foreach ($arParams['PRODUCT_INFO_BLOCK_ORDER'] as $blockName) :
                                switch ($blockName) :
                                    case 'sku':
                                        if ($haveOffers && !empty($arResult['OFFERS_PROP'])) : ?>
                                            <div id="<?= $itemIds['TREE_ID'] ?>">
                                                <? foreach ($arResult['SKU_PROPS'] as $skuProperty) :
                                                    if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
                                                        continue;

                                                    $propertyId = $skuProperty['ID'];
                                                    $skuProps[] = array(
                                                        'ID' => $propertyId,
                                                        'SHOW_MODE' => $skuProperty['SHOW_MODE'],
                                                        'VALUES' => $skuProperty['VALUES'],
                                                        'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
                                                    );
                                                    ?>
                                                    <div class="product-item-detail-info-container"
                                                         data-entity="sku-line-block">
                                                        <div class="product-item-detail-info-container-title"><?= htmlspecialcharsEx($skuProperty['NAME']) ?></div>
                                                        <div class="product-item-scu-container">
                                                            <div class="product-item-scu-block">
                                                                <div class="product-item-scu-list">
                                                                    <ul class="product-item-scu-item-list">
                                                                        <?
                                                                        foreach ($skuProperty['VALUES'] as &$value) :
                                                                            $value['NAME'] = htmlspecialcharsbx($value['NAME']);

                                                                            if ($skuProperty['SHOW_MODE'] === 'PICT') : ?>
                                                                                <li class="product-item-scu-item-color-container"
                                                                                    title="<?= $value['NAME'] ?>"
                                                                                    data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                                                    data-onevalue="<?= $value['ID'] ?>">
                                                                                    <div class="product-item-scu-item-color-block">
                                                                                        <div class="product-item-scu-item-color"
                                                                                             title="<?= $value['NAME'] ?>"
                                                                                             style="background-image: url('<?= $value['PICT']['SRC'] ?>');">
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            <? else : ?>
                                                                                <li class="product-item-scu-item-text-container"
                                                                                    title="<?= $value['NAME'] ?>"
                                                                                    data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                                                    data-onevalue="<?= $value['ID'] ?>">
                                                                                    <div class="product-item-scu-item-text-block">
                                                                                        <div class="product-item-scu-item-text"><?= $value['NAME'] ?></div>
                                                                                    </div>
                                                                                </li>
                                                                            <? endif;
                                                                        endforeach;
                                                                        ?>
                                                                    </ul>
                                                                    <div style="clear: both;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <? endforeach; ?>
                                            </div>
                                        <? endif;

                                        break;

                                    case 'props':
                                        if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) : ?>
                                            <div class="product-item-detail-info-container">
                                                <? if (!empty($arResult['DISPLAY_PROPERTIES'])) : ?>
                                                    <dl class="product-item-detail-properties">
                                                        <? foreach ($arResult['DISPLAY_PROPERTIES'] as $property) :
                                                            if (isset($arParams['MAIN_BLOCK_PROPERTY_CODE'][$property['CODE']])) : ?>
                                                                <dt><?= $property['NAME'] ?></dt>
                                                                <dd><?= (is_array($property['DISPLAY_VALUE'])
                                                                        ? implode(' / ', $property['DISPLAY_VALUE'])
                                                                        : $property['DISPLAY_VALUE']) ?>
                                                                </dd>
                                                            <? endif;
                                                        endforeach;
                                                        unset($property); ?>
                                                    </dl>
                                                <? endif;

                                                if ($arResult['SHOW_OFFERS_PROPS']) : ?>
                                                    <dl class="product-item-detail-properties"
                                                        id="<?= $itemIds['DISPLAY_MAIN_PROP_DIV'] ?>"></dl>
                                                <? endif; ?>
                                            </div>
                                        <? endif;

                                        break;
                                endswitch;
                            endforeach;
                            ?>
                            <? foreach ($arParams['PRODUCT_PAY_BLOCK_ORDER'] as $blockName) :
                                switch ($blockName) :
                                    case 'rating':
                                        if ($arParams['USE_VOTE_RATING'] === 'Y') : ?>
                                            <div class="product-item-detail-info-container">
                                                <? $APPLICATION->IncludeComponent(
                                                    'bitrix:iblock.vote',
                                                    'stars',
                                                    array(
                                                        'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                                        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                                        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                                        'ELEMENT_ID' => $arResult['ID'],
                                                        'ELEMENT_CODE' => '',
                                                        'MAX_VOTE' => '5',
                                                        'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
                                                        'SET_STATUS_404' => 'N',
                                                        'DISPLAY_AS_RATING' => $arParams['VOTE_DISPLAY_AS_RATING'],
                                                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                                        'CACHE_TIME' => $arParams['CACHE_TIME']
                                                    ),
                                                    $component,
                                                    array('HIDE_ICONS' => 'Y')
                                                ); ?>
                                            </div>
                                        <? endif;

                                        break;

                                    case 'price': ?>
                                        <? $truePrice = !empty($old_price_param) ? $price['RATIO_PRICE'] <= $old_price_param : false; ?>
                                        <div class="pc-product-props__price card-sm-title">
                                            <p>Цена за шт.:</p>
                                            <? if ($arParams['SHOW_OLD_PRICE'] === 'Y') : ?>
                                                <div class="pc-product-props__old-price b-price b-price_strike">
                                                    <? if ($truePrice): ?>
                                                        <span class="b-price__number">
                                                            <span>
                                                                <?= ($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : (!empty($old_price_param) ? ($old_price_param . " " . $currency) : '')) ?>
                                                            </span>
                                                        </span> <!-- <span class="b-price__rub"></span> -->
                                                    <? endif; ?>
                                                </div>
                                            <? endif; ?>
                                            <? if (($arParams['SHOW_OLD_PRICE'] !== 'Y') && !empty($old_price_param)): ?>
                                                <div class="pc-product-props__old-price b-price b-price_strike">
                                                    <? if ($truePrice): ?>
                                                        <span class="b-price__number">
                                                            <span><?= $old_price_param . " " . $currency ?></span>
                                                        </span> <!-- <span class="b-price__rub"></span> -->
                                                    <? endif; ?>
                                                </div>
                                            <? endif; ?>
                                            <span class="pc-product-props__new-price b-price b-price_ac">
                                                <span class="b-price__number" id="<?= $itemIds['PRICE_ID'] ?>">
                                                    <span><?= $price['PRINT_RATIO_PRICE'] ?></span>
                                                </span> <!-- <span class="b-price__rub"></span> -->
                                            </span>
                                        </div>

                                        <? if (false && $arParams['SHOW_OLD_PRICE'] === 'Y') : ?>
                                            <div class="item_economy_price" id="<?= $itemIds['DISCOUNT_PRICE_ID'] ?>"
                                                 style="display: <?= ($showDiscount ? '' : 'none') ?>;">
                                                <? if ($showDiscount) {
                                                    echo Loc::getMessage('CT_BCE_CATALOG_ECONOMY_INFO2', array('#ECONOMY#' => $price['PRINT_RATIO_DISCOUNT']));
                                                } ?>
                                            </div>
                                        <? endif; ?>
                                        <? break;

                                    case 'priceRanges':
                                        if ($arParams['USE_PRICE_COUNT']) {
                                            $showRanges = !$haveOffers && count($actualItem['ITEM_QUANTITY_RANGES']) > 1;
                                            $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';
                                            ?>
                                            <div class="product-item-detail-info-container"
                                                <?= $showRanges ? '' : 'style="display: none;"' ?>
                                                 data-entity="price-ranges-block">
                                                <div class="product-item-detail-info-container-title">
                                                    <?= $arParams['MESS_PRICE_RANGES_TITLE'] ?>
                                                    <span data-entity="price-ranges-ratio-header">
                                                    (<?= (Loc::getMessage(
                                                            'CT_BCE_CATALOG_RATIO_PRICE',
                                                            array('#RATIO#' => ($useRatio ? $measureRatio : '1') . ' ' . $actualItem['ITEM_MEASURE']['TITLE'])
                                                        )) ?>)
                                                </span>
                                                </div>
                                                <dl class="product-item-detail-properties"
                                                    data-entity="price-ranges-body">
                                                    <?
                                                    if ($showRanges) {
                                                        foreach ($actualItem['ITEM_QUANTITY_RANGES'] as $range) {
                                                            if ($range['HASH'] !== 'ZERO-INF') {
                                                                $itemPrice = false;

                                                                foreach ($arResult['ITEM_PRICES'] as $itemPrice) {
                                                                    if ($itemPrice['QUANTITY_HASH'] === $range['HASH']) {
                                                                        break;
                                                                    }
                                                                }

                                                                if ($itemPrice) {
                                                                    ?>
                                                                    <dt>
                                                                        <?
                                                                        echo Loc::getMessage(
                                                                                'CT_BCE_CATALOG_RANGE_FROM',
                                                                                array('#FROM#' => $range['SORT_FROM'] . ' ' . $actualItem['ITEM_MEASURE']['TITLE'])
                                                                            ) . ' ';

                                                                        if (is_infinite($range['SORT_TO'])) {
                                                                            echo Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                                                                        } else {
                                                                            echo Loc::getMessage(
                                                                                'CT_BCE_CATALOG_RANGE_TO',
                                                                                array('#TO#' => $range['SORT_TO'] . ' ' . $actualItem['ITEM_MEASURE']['TITLE'])
                                                                            );
                                                                        }
                                                                        ?>
                                                                    </dt>
                                                                    <dd><?= ($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']) ?></dd>
                                                                    <?
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </dl>
                                            </div>
                                            <?
                                            unset($showRanges, $useRatio, $itemPrice, $range);
                                        }

                                        break;

                                    case 'quantityLimit':
                                        if ($arParams['SHOW_MAX_QUANTITY'] !== 'N') {
                                            if ($haveOffers) {
                                                ?>
                                                <div class="product-item-detail-info-container"
                                                     id="<?= $itemIds['QUANTITY_LIMIT'] ?>"
                                                     style="display: none;">
                                                    <div class="product-item-detail-info-container-title">
                                                        <?= $arParams['MESS_SHOW_MAX_QUANTITY'] ?>:
                                                        <span class="product-item-quantity"
                                                              data-entity="quantity-limit-value"></span>
                                                    </div>
                                                </div>
                                                <?
                                            } else {
                                                if (
                                                    $measureRatio
                                                    && (float)$actualItem['CATALOG_QUANTITY'] > 0
                                                    && $actualItem['CATALOG_QUANTITY_TRACE'] === 'Y'
                                                    && $actualItem['CATALOG_CAN_BUY_ZERO'] === 'N'
                                                ) {
                                                    ?>
                                                    <div class="product-item-detail-info-container"
                                                         id="<?= $itemIds['QUANTITY_LIMIT'] ?>">
                                                        <div class="product-item-detail-info-container-title">
                                                            <?= $arParams['MESS_SHOW_MAX_QUANTITY'] ?>:
                                                            <span class="product-item-quantity"
                                                                  data-entity="quantity-limit-value">
                                                            <?
                                                            if ($arParams['SHOW_MAX_QUANTITY'] === 'M') {
                                                                if ((float)$actualItem['CATALOG_QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR']) {
                                                                    echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
                                                                } else {
                                                                    echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
                                                                }
                                                            } else {
                                                                echo $actualItem['CATALOG_QUANTITY'] . ' ' . $actualItem['ITEM_MEASURE']['TITLE'];
                                                            }
                                                            ?>
                                                        </span>
                                                        </div>
                                                    </div>
                                                    <?
                                                }
                                            }
                                        }

                                        break;

                                    case 'quantity':
                                        if ($arParams['USE_PRODUCT_QUANTITY']) : ?>
                                            <div class="product-item-detail-info-container pc-product-props__amount card-sm-title"
                                                 style="<?= (!$actualItem['CAN_BUY'] ? 'display: none;' : '') ?>"
                                                 data-entity="quantity-block">
                                                <p>Количество, <?= $actualItem['ITEM_MEASURE']['TITLE'] ?>.:</p>
                                                <div class="product-amount">
                                                    <?= Loc::getMessage('CATALOG_QUANTITY') ?>
                                                    <span class="product-amount__minus no-select"
                                                          id="<?= $itemIds['QUANTITY_DOWN_ID'] ?>">
                                                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/minus.svg") ?>"
                                                             class="img-svg">
                                                    </span>
                                                    <input class="product-amount__field"
                                                           id="<?= $itemIds['QUANTITY_ID'] ?>"
                                                           type="number"
                                                           value="<?= $price['MIN_QUANTITY'] ?>">
                                                    <span class="product-amount__plus no-select"
                                                          id="<?= $itemIds['QUANTITY_UP_ID'] ?>">
                                                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/plus.svg") ?>"
                                                             class="img-svg">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="pc-product-props__price-full card-sm-title">
                                                <p>Итого:</p>
                                                <span class="b-price">
                                                <span class="b-price">
                                                    <span class="b-price__number">
                                                        <span id="<?= $itemIds['PRICE_TOTAL'] ?>"></span>
                                                    </span> <!-- <span class="b-price__rub"></span> -->
                                                </span>
                                            </div>
                                        <? endif;
                                        break;
                                endswitch;
                            endforeach;
                            ?>
                        </div>
                        <div class="col-5 col-sm-6">
                            <div class="pc-product-props__in-stock">
                                <p><strong>В
                                        наличии:</strong> <?= ($arResult['CATALOG_QUANTITY'] > 0) ? 'есть в наличии' : 'нет в наличии' ?>
                                </p>
                            </div>
                            <div class="pc-product-props__delivery">
                                <a href="/delivery/" class="btn btn_left btn_arrow_left">
                                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/delivery.svg") ?>"
                                         class="img-svg">
                                    <span>Доставка</span>
                                </a>
                            </div>
                            <div class="pc-product-props__payment">
                                <a href="/pay/" class="btn btn_left btn_arrow_left">
                                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/payment.svg") ?>"
                                         class="img-svg">
                                    <span>Оплата</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row" data-entity="main-button-container">
                        <div class="col-6 col-sm-3 col-md-6" id="<?= $itemIds['BASKET_ACTIONS_ID'] ?>"
                             style="display: <?= ($actualItem['CAN_BUY'] ? '' : 'none') ?>;">
                            <? if ($showAddBtn) : ?>
                                <a class="<?= $showButtonClassName ?> btn-add-product"
                                   id="<?= $itemIds['ADD_BASKET_LINK'] ?>"
                                   href="javascript:void(0);">
                                    <span><?= $arParams['MESS_BTN_ADD_TO_BASKET'] ?></span>
                                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/basket-plus.svg") ?>"
                                         class="img-svg">
                                </a>
                            <? endif;
                            if ($showBuyBtn) : ?>
                                <a class="<?= $buyButtonClassName ?> btn-add-product"
                                   id="<?= $itemIds['BUY_LINK'] ?>"
                                   href="javascript:void(0);">
                                    <span><?= $arParams['MESS_BTN_BUY'] ?></span>
                                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/basket-plus.svg") ?>"
                                         class="img-svg">
                                </a>
                            <? endif; ?>
                        </div>
                        <div class="col-6 col-sm-3 col-md-6">
                            <div class="pc-product-props__add-favorites">
                                <button class="btn btn_color_grey h2o_add_favor btn_arrow_left<?= in_array($arResult['ID'], $delayedItems) ? ' active' : '' ?>"
                                        data-id="<?= $arResult["ID"] ?>">
                                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/favorites.svg") ?>"
                                         class="img-svg">
                                    <span>В избранное</span>
                                </button>
                            </div>
                        </div>
                        <? if (false && $showSubscribe) { ?>
                            <div class="product-item-detail-info-container col-6 col-sm-3 col-md-6">
                                <? $APPLICATION->IncludeComponent(
                                    'bitrix:catalog.product.subscribe',
                                    '',
                                    array(
                                        'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                        'PRODUCT_ID' => $arResult['ID'],
                                        'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                                        'BUTTON_CLASS' => 'btn btn-default product-item-detail-buy-button',
                                        'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
                                        'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                                    ),
                                    $component,
                                    array('HIDE_ICONS' => 'Y')
                                ); ?>
                            </div>
                        <? } ?>
                        <div class="product-item-detail-info-container">
                            <a class="btn btn-link product-item-detail-buy-button"
                               id="<?= $itemIds['NOT_AVAILABLE_MESS'] ?>"
                               href="javascript:void(0)"
                               rel="nofollow" style="display: <?= (!$actualItem['CAN_BUY'] ? '' : 'none') ?>;">
                                <?= $arParams['MESS_NOT_AVAILABLE'] ?>
                            </a>
                        </div>
                    </div>
                    <? if (false): ?>
                        <div class="pc-product-props__timer">
                            <div class="card-actions-timer" data-time="08/14/2018 12:00:00">
                                <div class="card-sm-title">
                                    <p>До завершения акции осталось: </p>
                                    <p class="b-timer"><span class="days"></span> дней <span class="hours"></span> часов
                                        <span class="minutes"></span>
                                        минуты</p>
                                </div>
                            </div>
                        </div>
                    <? endif; ?>
                </div>
            </div>
        </div>
        <div class="row" hidden>
            <div class="col-xs-12">
                <? if ($haveOffers) {
                    if ($arResult['OFFER_GROUP']) {
                        foreach ($arResult['OFFER_GROUP_VALUES'] as $offerId) { ?>
                            <span id="<?= $itemIds['OFFER_GROUP'] . $offerId ?>" style="display: none;">
                            <? $APPLICATION->IncludeComponent(
                                'bitrix:catalog.set.constructor',
                                '.default',
                                array(
                                    'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                    'IBLOCK_ID' => $arResult['OFFERS_IBLOCK'],
                                    'ELEMENT_ID' => $offerId,
                                    'PRICE_CODE' => $arParams['PRICE_CODE'],
                                    'BASKET_URL' => $arParams['BASKET_URL'],
                                    'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
                                    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                    'CACHE_TIME' => $arParams['CACHE_TIME'],
                                    'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                                    'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
                                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                    'CURRENCY_ID' => $arParams['CURRENCY_ID']
                                ),
                                $component,
                                array('HIDE_ICONS' => 'Y')
                            ); ?>
                        </span>
                        <? }
                    }
                } else {
                    if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP']) {
                        $APPLICATION->IncludeComponent(
                            'bitrix:catalog.set.constructor',
                            '.default',
                            array(
                                'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                'ELEMENT_ID' => $arResult['ID'],
                                'PRICE_CODE' => $arParams['PRICE_CODE'],
                                'BASKET_URL' => $arParams['BASKET_URL'],
                                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                'CACHE_TIME' => $arParams['CACHE_TIME'],
                                'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                                'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
                                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                'CURRENCY_ID' => $arParams['CURRENCY_ID']
                            ),
                            $component,
                            array('HIDE_ICONS' => 'Y')
                        );
                    }
                } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="pc-product-tabs">

                    <div class="pc-product-tabs__head pc-product-tabs-head" id="<?= $itemIds['TABS_ID'] ?>">
                        <? if ($showDescription) : ?>
                            <div class="pc-product-tabs-head__item active" data-entity="tab" data-value="description">
                                <a href="javascript:void(0);" class="pc-product-tabs-head__link h3">
                                    <span><?= $arParams['MESS_DESCRIPTION_TAB'] ?></span>
                                </a>
                            </div>
                        <? endif; ?>

                        <? if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) : ?>
                            <div class="pc-product-tabs-head__item" data-entity="tab" data-value="properties">
                                <a href="javascript:void(0);" class="pc-product-tabs-head__link h3">
                                    <span><?= $arParams['MESS_PROPERTIES_TAB'] ?></span>
                                </a>
                            </div>
                        <? endif; ?>

                        <? if (isset($arResult['PROPERTIES']['PRICHINA_UTSENKI'])) : ?>
                            <? if (!empty($arResult['PROPERTIES']['PRICHINA_UTSENKI']['VALUE'])): ?>
                                <div class="pc-product-tabs-head__item" data-entity="tab"
                                     data-value="markdown">
                                    <a href="javascript:void(0);" class="pc-product-tabs-head__link h3">
                                        <span><?= $arResult['PROPERTIES']['PRICHINA_UTSENKI']['NAME'] ?></span>
                                    </a>
                                </div>
                            <? endif; ?>
                        <? endif; ?>

                        <? if ($arParams['USE_COMMENTS'] === 'Y') : ?>
                            <div class="pc-product-tabs-head__item" data-entity="tab" data-value="comments">
                                <a href="javascript:void(0);" class="pc-product-tabs-head__link h3">
                                    <span><?= $arParams['MESS_COMMENTS_TAB'] ?></span>
                                </a>
                            </div>
                        <? endif; ?>
                    </div>

                    <div class="pc-product-tabs__body pc-product-tabs-body" id="<?= $itemIds['TAB_CONTAINERS_ID'] ?>">
                        <div class="col-xs-12">
                            <? if ($showDescription) : ?>
                                <div class="pc-product-tabs-body__item" data-entity="tab-container"
                                     data-value="description"
                                     itemprop="description" style="display: ;">
                                    <div class="b-content">
                                        <?
                                        if (
                                            $arResult['PREVIEW_TEXT'] != ''
                                            && (
                                                $arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
                                                || ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == '')
                                            )
                                        ) {
                                            echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>' . $arResult['PREVIEW_TEXT'] . '</p>';
                                        }

                                        if ($arResult['DETAIL_TEXT'] != '') {
                                            echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>' . $arResult['DETAIL_TEXT'] . '</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            <? endif; ?>

                            <? if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) : ?>
                                <div class="product-item-detail-tab-content pc-product-tabs-body__item"
                                     data-entity="tab-container"
                                     data-value="properties" style="display: none;">
                                    <div class="product-properties">
                                        <? if (!empty($arResult['DISPLAY_PROPERTIES'])) : ?>
                                            <!--                                                <h4 class="product-properties__title">Характеристики</h4>-->

                                            <dl class="product-properties__list">
                                                <? foreach ($arResult['DISPLAY_PROPERTIES'] as $property) : ?>
                                                    <? if ($property['CODE'] !== 'CML2_TRAITS'): ?>
                                                        <dt><?= $property['NAME'] ?></dt>
                                                        <dl><?= (
                                                            is_array($property['DISPLAY_VALUE'])
                                                                ? implode(' / ', $property['DISPLAY_VALUE'])
                                                                : $property['DISPLAY_VALUE']
                                                            ) ?>
                                                        </dl>
                                                    <? else: ?>
                                                        <? continue; ?>
                                                    <? endif; ?>
                                                <? endforeach; ?>
                                            </dl>
                                        <? endif; ?>
                                        <? if ($arResult['SHOW_OFFERS_PROPS']) : ?>
                                            <dl class="product-item-detail-properties"
                                                id="<?= $itemIds['DISPLAY_PROP_DIV'] ?>"></dl>
                                        <? endif; ?>
                                    </div>
                                </div>
                            <? endif; ?>

                            <? if (isset($arResult['PROPERTIES']['PRICHINA_UTSENKI'])) : ?>
                                <? if (!empty($arResult['PROPERTIES']['PRICHINA_UTSENKI']['VALUE'])): ?>
                                    <div class="product-item-detail-tab-content"
                                         data-entity="tab-container"
                                         data-value="markdown" style="display: none;">

                                        <div class="b-content">
                                            <?= $arResult['PROPERTIES']['PRICHINA_UTSENKI']['VALUE'] ?>
                                        </div>
                                    </div>
                                <? endif; ?>
                            <? endif; ?>

                            <? if ($arParams['USE_COMMENTS'] === 'Y') { ?>
                                <div class="product-item-detail-tab-content" data-entity="tab-container"
                                     data-value="comments"
                                     style="display: none;">
                                    <? $componentCommentsParams = array(
                                        'ELEMENT_ID' => $arResult['ID'],
                                        'ELEMENT_CODE' => '',
                                        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                        'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
                                        'URL_TO_COMMENT' => '',
                                        'WIDTH' => '',
                                        'COMMENTS_COUNT' => '5',
                                        'BLOG_USE' => "Y",
                                        'FB_USE' => $arParams['FB_USE'],
                                        'FB_APP_ID' => $arParams['FB_APP_ID'],
                                        'VK_USE' => $arParams['VK_USE'],
                                        'VK_API_ID' => $arParams['VK_API_ID'],
                                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                        'CACHE_TIME' => $arParams['CACHE_TIME'],
                                        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                                        'BLOG_TITLE' => '',
                                        'BLOG_URL' => $arParams['BLOG_URL'],
                                        'PATH_TO_SMILE' => '',
                                        'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
                                        'AJAX_POST' => 'Y',
                                        'SHOW_SPAM' => 'Y',
                                        'SHOW_RATING' => 'N',
                                        'FB_TITLE' => '',
                                        'FB_USER_ADMIN_ID' => '',
                                        'FB_COLORSCHEME' => 'light',
                                        'FB_ORDER_BY' => 'reverse_time',
                                        'VK_TITLE' => '',
                                        'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME']
                                    );
                                    if (isset($arParams["USER_CONSENT"]))
                                        $componentCommentsParams["USER_CONSENT"] = $arParams["USER_CONSENT"];
                                    if (isset($arParams["USER_CONSENT_ID"]))
                                        $componentCommentsParams["USER_CONSENT_ID"] = $arParams["USER_CONSENT_ID"];
                                    if (isset($arParams["USER_CONSENT_IS_CHECKED"]))
                                        $componentCommentsParams["USER_CONSENT_IS_CHECKED"] = $arParams["USER_CONSENT_IS_CHECKED"];
                                    if (isset($arParams["USER_CONSENT_IS_LOADED"]))
                                        $componentCommentsParams["USER_CONSENT_IS_LOADED"] = $arParams["USER_CONSENT_IS_LOADED"];
                                    $APPLICATION->IncludeComponent(
                                        'bitrix:catalog.comments',
                                        '',
                                        $componentCommentsParams,
                                        $component,
                                        array('HIDE_ICONS' => 'Y')
                                    );
                                    ?>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <?
                if ($arResult['CATALOG'] && $actualItem['CAN_BUY'] && \Bitrix\Main\ModuleManager::isModuleInstalled('sale')) {
                    $APPLICATION->IncludeComponent(
                        'bitrix:sale.prediction.product.detail',
                        '.default',
                        array(
                            'BUTTON_ID' => $showBuyBtn ? $itemIds['BUY_LINK'] : $itemIds['ADD_BASKET_LINK'],
                            'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                            'POTENTIAL_PRODUCT_TO_BUY' => array(
                                'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
                                'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
                                'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
                                'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
                                'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

                                'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][0]['ID']) ? $arResult['OFFERS'][0]['ID'] : null,
                                'SECTION' => array(
                                    'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
                                    'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
                                    'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
                                    'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
                                ),
                            )
                        ),
                        $component,
                        array('HIDE_ICONS' => 'Y')
                    );
                } ?>
            </div>
        </div>
    </div>
    <!--Small Card-->
    <div class="product-item-detail-short-card-fixed hidden-xs" id="<?= $itemIds['SMALL_CARD_PANEL_ID'] ?>">
        <div class="product-item-detail-short-card-content-container">
            <table>
                <tr>
                    <td rowspan="2" class="product-item-detail-short-card-image">
                        <img src="" style="height: 65px;" data-entity="panel-picture">
                    </td>
                    <td class="product-item-detail-short-title-container" data-entity="panel-title">
                        <span class="product-item-detail-short-title-text"><?= $name ?></span>
                    </td>
                    <td rowspan="2" class="product-item-detail-short-card-price">
                        <?
                        if ($arParams['SHOW_OLD_PRICE'] === 'Y') {
                            ?>
                            <div class="product-item-detail-price-old"
                                 style="display: <?= ($showDiscount ? '' : 'none') ?>;"
                                 data-entity="panel-old-price">
                                <?= ($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '') ?>
                            </div>
                            <?
                        }
                        ?>
                        <div class="product-item-detail-price-current" data-entity="panel-price">
                            <?= $price['PRINT_RATIO_PRICE'] ?>
                        </div>
                    </td>
                    <?
                    if ($showAddBtn) {
                        ?>
                        <td rowspan="2" class="product-item-detail-short-card-btn"
                            style="display: <?= ($actualItem['CAN_BUY'] ? '' : 'none') ?>;"
                            data-entity="panel-add-button">
                            <a class="btn <?= $showButtonClassName ?> product-item-detail-buy-button"
                               id="<?= $itemIds['ADD_BASKET_LINK'] ?>"
                               href="javascript:void(0);">
                                <span><?= $arParams['MESS_BTN_ADD_TO_BASKET'] ?></span>
                            </a>
                        </td>
                        <?
                    }

                    if ($showBuyBtn) {
                        ?>
                        <td rowspan="2" class="product-item-detail-short-card-btn"
                            style="display: <?= ($actualItem['CAN_BUY'] ? '' : 'none') ?>;"
                            data-entity="panel-buy-button">
                            <a class="btn <?= $buyButtonClassName ?> product-item-detail-buy-button"
                               id="<?= $itemIds['BUY_LINK'] ?>"
                               href="javascript:void(0);">
                                <span><?= $arParams['MESS_BTN_BUY'] ?></span>
                            </a>
                        </td>
                        <?
                    }
                    ?>
                    <td rowspan="2" class="product-item-detail-short-card-btn"
                        style="display: <?= (!$actualItem['CAN_BUY'] ? '' : 'none') ?>;"
                        data-entity="panel-not-available-button">
                        <a class="btn btn-link product-item-detail-buy-button" href="javascript:void(0)"
                           rel="nofollow">
                            <?= $arParams['MESS_NOT_AVAILABLE'] ?>
                        </a>
                    </td>
                </tr>
                <? if ($haveOffers) { ?>
                    <tr>
                        <td>
                            <div class="product-item-selected-scu-container" data-entity="panel-sku-container">
                                <?
                                $i = 0;

                                foreach ($arResult['SKU_PROPS'] as $skuProperty) {
                                    if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']])) {
                                        continue;
                                    }

                                    $propertyId = $skuProperty['ID'];

                                    foreach ($skuProperty['VALUES'] as $value) {
                                        $value['NAME'] = htmlspecialcharsbx($value['NAME']);
                                        if ($skuProperty['SHOW_MODE'] === 'PICT') {
                                            ?>
                                            <div class="product-item-selected-scu product-item-selected-scu-color selected"
                                                 title="<?= $value['NAME'] ?>"
                                                 style="background-image: url('<?= $value['PICT']['SRC'] ?>'); display: none;"
                                                 data-sku-line="<?= $i ?>"
                                                 data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                 data-onevalue="<?= $value['ID'] ?>">
                                            </div>
                                            <?
                                        } else {
                                            ?>
                                            <div class="product-item-selected-scu product-item-selected-scu-text selected"
                                                 title="<?= $value['NAME'] ?>"
                                                 style="display: none;"
                                                 data-sku-line="<?= $i ?>"
                                                 data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                 data-onevalue="<?= $value['ID'] ?>">
                                                <?= $value['NAME'] ?>
                                            </div>
                                            <?
                                        }
                                    }

                                    $i++;
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <?
                }
                ?>
            </table>
        </div>
        <!--Top tabs-->
        <div class="product-item-detail-tabs-container-fixed hidden-xs" id="<?= $itemIds['TABS_PANEL_ID'] ?>">
            <ul class="product-item-detail-tabs-list">
                <?
                if ($showDescription) {
                    ?>
                    <li class="product-item-detail-tab active" data-entity="tab" data-value="description">
                        <a href="javascript:void(0);" class="product-item-detail-tab-link">
                            <span><?= $arParams['MESS_DESCRIPTION_TAB'] ?></span>
                        </a>
                    </li>
                    <?
                }

                if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) {
                    ?>
                    <li class="product-item-detail-tab" data-entity="tab" data-value="properties">
                        <a href="javascript:void(0);" class="product-item-detail-tab-link">
                            <span><?= $arParams['MESS_PROPERTIES_TAB'] ?></span>
                        </a>
                    </li>
                    <?
                }

                if (isset($arResult['PROPERTIES']['PRICHINA_UTSENKI'])) {
                    if (!empty($arResult['PROPERTIES']['PRICHINA_UTSENKI']['VALUE'])) {
                        ?>
                        <li class="product-item-detail-tab" data-entity="tab" data-value="markdown">
                            <a href="javascript:void(0);" class="product-item-detail-tab-link">
                                <span><?= $arResult['PROPERTIES']['PRICHINA_UTSENKI']['NAME'] ?></span>
                            </a>
                        </li>
                        <?
                    }
                }

                if ($arParams['USE_COMMENTS'] === 'Y') {
                    ?>
                    <li class="product-item-detail-tab" data-entity="tab" data-value="comments">
                        <a href="javascript:void(0);" class="product-item-detail-tab-link">
                            <span><?= $arParams['MESS_COMMENTS_TAB'] ?></span>
                        </a>
                    </li>
                    <?
                }
                ?>
            </ul>
        </div>

        <meta itemprop="name" content="<?= $name ?>"/>
        <meta itemprop="category" content="<?= $arResult['CATEGORY_PATH'] ?>"/>
        <?
        if ($haveOffers) {
            foreach ($arResult['JS_OFFERS'] as $offer) {
                $currentOffersList = array();

                if (!empty($offer['TREE']) && is_array($offer['TREE'])) {
                    foreach ($offer['TREE'] as $propName => $skuId) {
                        $propId = (int)substr($propName, 5);

                        foreach ($skuProps as $prop) {
                            if ($prop['ID'] == $propId) {
                                foreach ($prop['VALUES'] as $propId => $propValue) {
                                    if ($propId == $skuId) {
                                        $currentOffersList[] = $propValue['NAME'];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                $offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
                ?>
                <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<meta itemprop="sku" content="<?= htmlspecialcharsbx(implode('/', $currentOffersList)) ?>"/>
				<meta itemprop="price" content="<?= $offerPrice['RATIO_PRICE'] ?>"/>
				<meta itemprop="priceCurrency" content="<?= $offerPrice['CURRENCY'] ?>"/>
				<link itemprop="availability"
                      href="http://schema.org/<?= ($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock') ?>"/>
			</span>
                <?
            }

            unset($offerPrice, $currentOffersList);
        } else {
            ?>
            <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<meta itemprop="price" content="<?= $price['RATIO_PRICE'] ?>"/>
			<meta itemprop="priceCurrency" content="<?= $price['CURRENCY'] ?>"/>
			<link itemprop="availability"
                  href="http://schema.org/<?= ($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock') ?>"/>
		</span>
            <?
        }
        ?>
    </div>
<?
if ($haveOffers) {
    $offerIds = array();
    $offerCodes = array();

    $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

    foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer) {
        $offerIds[] = (int)$jsOffer['ID'];
        $offerCodes[] = $jsOffer['CODE'];

        $fullOffer = $arResult['OFFERS'][$ind];
        $measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

        $strAllProps = '';
        $strMainProps = '';
        $strPriceRangesRatio = '';
        $strPriceRanges = '';

        if ($arResult['SHOW_OFFERS_PROPS']) {
            if (!empty($jsOffer['DISPLAY_PROPERTIES'])) {
                foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property) {
                    $current = '<dt>' . $property['NAME'] . '</dt><dd>' . (
                        is_array($property['VALUE'])
                            ? implode(' / ', $property['VALUE'])
                            : $property['VALUE']
                        ) . '</dd>';
                    $strAllProps .= $current;

                    if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']])) {
                        $strMainProps .= $current;
                    }
                }

                unset($current);
            }
        }

        if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1) {
            $strPriceRangesRatio = '(' . Loc::getMessage(
                    'CT_BCE_CATALOG_RATIO_PRICE',
                    array('#RATIO#' => ($useRatio
                            ? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
                            : '1'
                        ) . ' ' . $measureName)
                ) . ')';

            foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range) {
                if ($range['HASH'] !== 'ZERO-INF') {
                    $itemPrice = false;

                    foreach ($jsOffer['ITEM_PRICES'] as $itemPrice) {
                        if ($itemPrice['QUANTITY_HASH'] === $range['HASH']) {
                            break;
                        }
                    }

                    if ($itemPrice) {
                        $strPriceRanges .= '<dt>' . Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_FROM',
                                array('#FROM#' => $range['SORT_FROM'] . ' ' . $measureName)
                            ) . ' ';

                        if (is_infinite($range['SORT_TO'])) {
                            $strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                        } else {
                            $strPriceRanges .= Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_TO',
                                array('#TO#' => $range['SORT_TO'] . ' ' . $measureName)
                            );
                        }

                        $strPriceRanges .= '</dt><dd>' . ($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']) . '</dd>';
                    }
                }
            }

            unset($range, $itemPrice);
        }

        $jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
        $jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
        $jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
        $jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
    }

    $templateData['OFFER_IDS'] = $offerIds;
    $templateData['OFFER_CODES'] = $offerCodes;
    unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => true,
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
            'OFFER_GROUP' => $arResult['OFFER_GROUP'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null
        ),
        'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
        'VISUAL' => $itemIds,
        'DEFAULT_PICTURE' => array(
            'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
            'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
        ),
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'NAME' => $arResult['~NAME'],
            'CATEGORY' => $arResult['CATEGORY_PATH']
        ),
        'BASKET' => array(
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'BASKET_URL' => $arParams['BASKET_URL'],
            'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        ),
        'OFFERS' => $arResult['JS_OFFERS'],
        'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
        'TREE_PROPS' => $skuProps
    );
} else {
    $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
    if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties) {
        ?>
        <div id="<?= $itemIds['BASKET_PROP_DIV'] ?>" style="display: none;">
            <?
            if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])) {
                foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo) {
                    ?>
                    <input type="hidden" name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]"
                           value="<?= htmlspecialcharsbx($propInfo['ID']) ?>">
                    <?
                    unset($arResult['PRODUCT_PROPERTIES'][$propId]);
                }
            }

            $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
            if (!$emptyProductProperties) {
                ?>
                <table>
                    <?
                    foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo) {
                        ?>
                        <tr>
                            <td><?= $arResult['PROPERTIES'][$propId]['NAME'] ?></td>
                            <td>
                                <?
                                if (
                                    $arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
                                    && $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
                                ) {
                                    foreach ($propInfo['VALUES'] as $valueId => $value) {
                                        ?>
                                        <label>
                                            <input type="radio"
                                                   name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]"
                                                   value="<?= $valueId ?>" <?= ($valueId == $propInfo['SELECTED'] ? '"checked"' : '') ?>>
                                            <?= $value ?>
                                        </label>
                                        <br>
                                        <?
                                    }
                                } else {
                                    ?>
                                    <select name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]">
                                        <?
                                        foreach ($propInfo['VALUES'] as $valueId => $value) {
                                            ?>
                                            <option value="<?= $valueId ?>" <?= ($valueId == $propInfo['SELECTED'] ? '"selected"' : '') ?>>
                                                <?= $value ?>
                                            </option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                    <?
                                }
                                ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
                <?
            }
            ?>
        </div>
        <?
    }

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null
        ),
        'VISUAL' => $itemIds,
        'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'PICT' => reset($arResult['MORE_PHOTO']),
            'NAME' => $arResult['~NAME'],
            'SUBSCRIPTION' => true,
            'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
            'ITEM_PRICES' => $arResult['ITEM_PRICES'],
            'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
            'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
            'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
            'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
            'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
            'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
            'SLIDER' => $arResult['MORE_PHOTO'],
            'CAN_BUY' => $arResult['CAN_BUY'],
            'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
            'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
            'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
            'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
            'CATEGORY' => $arResult['CATEGORY_PATH']
        ),
        'BASKET' => array(
            'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
            'EMPTY_PROPS' => $emptyProductProperties,
            'BASKET_URL' => $arParams['BASKET_URL'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        )
    );
    unset($emptyProductProperties);
}

if ($arParams['DISPLAY_COMPARE']) {
    $jsParams['COMPARE'] = array(
        'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
        'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
        'COMPARE_PATH' => $arParams['COMPARE_PATH']
    );
}
?>
    <script>
        BX.message({
            ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
            TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
            TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
            BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
            BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
            BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
            BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
            BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
            TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
            COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
            COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
            COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
            BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
            PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
            PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
            RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
            RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
            SITE_ID: '<?=$component->getSiteId()?>'
        });

        var <?=$obName?> =
        new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    </script>
<?
unset($actualItem, $itemIds, $jsParams);