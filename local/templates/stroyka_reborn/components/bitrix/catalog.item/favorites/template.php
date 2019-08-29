<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Page\Asset;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogProductsViewedComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

//Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.downCount.js');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/catalog-item.js');

if (isset($arResult['ITEM'])) {
    $item = $arResult['ITEM'];
    $areaId = $arResult['AREA_ID'];
    $itemIds = array(
        'ID' => $areaId,
        'PICT' => $areaId . '_pict',
        'SECOND_PICT' => $areaId . '_secondpict',
        'PICT_SLIDER' => $areaId . '_pict_slider',
        'STICKER_ID' => $areaId . '_sticker',
        'SECOND_STICKER_ID' => $areaId . '_secondsticker',
        'QUANTITY' => $areaId . '_quantity',
        'QUANTITY_DOWN' => $areaId . '_quant_down',
        'QUANTITY_UP' => $areaId . '_quant_up',
        'QUANTITY_MEASURE' => $areaId . '_quant_measure',
        'QUANTITY_LIMIT' => $areaId . '_quant_limit',
        'BUY_LINK' => $areaId . '_buy_link',
        'BASKET_ACTIONS' => $areaId . '_basket_actions',
        'NOT_AVAILABLE_MESS' => $areaId . '_not_avail',
        'SUBSCRIBE_LINK' => $areaId . '_subscribe',
        'COMPARE_LINK' => $areaId . '_compare_link',
        'PRICE' => $areaId . '_price',
        'PRICE_OLD' => $areaId . '_price_old',
        'PRICE_TOTAL' => $areaId . '_price_total',
        'DSC_PERC' => $areaId . '_dsc_perc',
        'SECOND_DSC_PERC' => $areaId . '_second_dsc_perc',
        'PROP_DIV' => $areaId . '_sku_tree',
        'PROP' => $areaId . '_prop_',
        'DISPLAY_PROP_DIV' => $areaId . '_sku_prop',
        'BASKET_PROP_DIV' => $areaId . '_basket_prop',
    );
    $obName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $areaId);
    $isBig = isset($arResult['BIG']) && $arResult['BIG'] === 'Y';

    $productTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
        ? $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
        : $item['NAME'];

    $imgTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
        ? $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
        : $item['NAME'];

    $skuProps = array();

    $haveOffers = !empty($item['OFFERS']);
    if ($haveOffers) {
        $actualItem = isset($item['OFFERS'][$item['OFFERS_SELECTED']])
            ? $item['OFFERS'][$item['OFFERS_SELECTED']]
            : reset($item['OFFERS']);
    } else {
        $actualItem = $item;
    }

    if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers) {
        $price = $item['ITEM_START_PRICE'];
        $minOffer = $item['OFFERS'][$item['ITEM_START_PRICE_SELECTED']];
        $measureRatio = $minOffer['ITEM_MEASURE_RATIOS'][$minOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
        $morePhoto = $item['MORE_PHOTO'];
    } else {
        $price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
        $measureRatio = $price['MIN_QUANTITY'];
        $morePhoto = $actualItem['MORE_PHOTO'];
    }

    $showSlider = is_array($morePhoto) && count($morePhoto) > 1;
    $showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($item['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

    $discountPositionClass = isset($arResult['BIG_DISCOUNT_PERCENT']) && $arResult['BIG_DISCOUNT_PERCENT'] === 'Y'
        ? 'product-item-label-big'
        : 'product-item-label-small';
    $discountPositionClass .= $arParams['DISCOUNT_POSITION_CLASS'];

    $labelPositionClass = isset($arResult['BIG_LABEL']) && $arResult['BIG_LABEL'] === 'Y'
        ? 'product-item-label-big'
        : 'product-item-label-small';
    $labelPositionClass .= $arParams['LABEL_POSITION_CLASS'];

    $buttonSizeClass = isset($arResult['BIG_BUTTONS']) && $arResult['BIG_BUTTONS'] === 'Y' ? 'btn-md' : 'btn-sm';
    $itemHasDetailUrl = isset($item['DETAIL_PAGE_URL']) && $item['DETAIL_PAGE_URL'] != '';

    $oldPrice = $item['PROPERTIES']['STARAYA_TSENA']['VALUE'];
    $discount = $item['PROPERTIES']['SKIDKA']['VALUE'];
    $currencyLang = CCurrencyLang::GetByID($item['MIN_PRICE']['CURRENCY'], "ru");
    $currency = trim($currencyLang["FORMAT_STRING"], ("# "));
    $dateCreate = new DateTime($item['DATE_CREATE']);
    $currDate = new DateTime();
    $currDate->format('Y-m-d H:i:s');
    $diffDateCreate = $dateCreate->diff($currDate);
    ?>


    <div class="card-product" id="<?= $areaId ?>" data-cardid="<?=$item['ID']?>">
        <div class="card-product__top">
            <div class="card-product__badges">
                <?php if (false && isset($item['PROPERTIES']['KATEGORIYA']['VALUE']) && $item['PROPERTIES']['KATEGORIYA']['VALUE'] === "Спец.предложение"): ?>
                    <span class="card-product__badge card-product__badge_color_orange">Специальное предложение</span>
                <? elseif (isset($item['PROPERTIES']['KATEGORIYA']['VALUE']) && $item['PROPERTIES']['KATEGORIYA']['VALUE'] === "Уценка"): ?>

                    <? if (isset($item['PROPERTIES']['PRICHINA_UTSENKI']) && !empty($item['PROPERTIES']['PRICHINA_UTSENKI']['VALUE'])): ?>
                        <div class="card-product__badge card-product__badge_markdown card-product__badge_color_violet">
                            Уценка
                            <div class="card-product__markdown-wrap">
                                <span class="card-product__markdown"><?= $item['PROPERTIES']['PRICHINA_UTSENKI']['VALUE'] ?></span>
                            </div>
                        </div>
                    <? else: ?>
                        <div class="card-product__badge card-product__badge_color_violet">
                            Уценка
                        </div>
                    <? endif; ?>

                <? elseif (($diffDateCreate->format('%a')) < 30): ?>
                    <span class="card-product__badge card-product__badge_color_green">Новинка</span>
                <?php endif; ?>
                <span class="card-product__badge card-product__badge_color_red d-none">Акция</span>
                <? if ($item['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']) : ?>
                    <span class="card-product__badge card-product__badge_discount card-product__badge_color_red">-<?= $item['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ?>%</span>
                <? elseif ($oldPrice):
                    $discountPercent = round(100 - ((int)$item['MIN_PRICE']['VALUE'] * 100 / $oldPrice));
                    ?>
                    <span class="card-product__badge card-product__badge_discount card-product__badge_color_red">-<?= $discountPercent ?>%</span>
                <? elseif ($discount) : ?>
                    <span class="card-product__badge card-product__badge_discount card-product__badge_color_red">-<?= rtrim($discount, '%') ?>%</span>
                <? endif; ?>
            </div>
            <div class="card-product__preview">
                <a href="<?= $item['DETAIL_PAGE_URL'] ?>">
                    <img src="<?= $item['PRODUCT_PREVIEW'] ? $item['PRODUCT_PREVIEW']['SRC'] : $APPLICATION->GetTemplatePath('img/no_photo.png') ?>"
                         alt="" class="card-product__img">
                </a>
            </div>
            <button class="card-product__add-favorites active delete_favorites" data-id="<?= $item['ID'] ?>">
                <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/favorite.svg') ?>" alt=""
                     class="img-svg">
                <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/favorite-fill.svg') ?>" alt=""
                     class="img-svg">
            </button>
        </div>
        <? if ($item['MIN_PRICE']): ?>
            <? $fullPrice = preg_replace('/^(\d+)\.?(\d+)?(\s.\.)$/ui', "<span>\$1</span><sup>\$2</sup>\$3", $item['MIN_PRICE']['PRINT_VALUE']); ?>
            <div class="card-product__middle">
                <? if ($price['DISCOUNT_DIFF'] > 0) :
                    $discountPrice = preg_replace('/^(\d+)\.?(\d+)?(\s.\.)$/ui', "<span>\$1</span><sup>\$2</sup>\$3", $item['MIN_PRICE']['PRINT_DISCOUNT_VALUE']);
                    ?>
                    <div class="card-product__price">
                        <span class="card-product__current-price"><?= $fullPrice ?></span>
                        <span class="card-product__discount"><?= $discountPrice ?></span>
                    </div>
                <? else : ?>
                    <?
                    switch (true) {
                        case !empty($oldPrice):
                            $truePrice = $oldPrice >= $item['MIN_PRICE']['VALUE'];
                            break;
                        case $discount:
                            $truePrice = true;
                            $oldPrice = $item['MIN_PRICE']['VALUE'] / 100 * (100 + (int)$discount);
                            break;
                        default:
                            $truePrice = false;
                    }
                    $truePrice = !empty($oldPrice) ? $oldPrice >= $item['MIN_PRICE']['VALUE'] : false;
                    ?>
                    <div class="card-product__price">
                        <span class="card-product__current-price b-price__number"
                              id="<?= $itemIds['PRICE'] ?>"><?= $price['PRINT_RATIO_PRICE'] ?></span>
                        <span style="display: none"
                              data-entity="scu-measure">/<?= $item['ITEM_MEASURE']['TITLE'] ?></span>

                        <? if ($truePrice): ?>
                            <span class="card-product__discount"><?= $oldPrice . " " . $currency ?></span>
                        <? endif; ?>
                    </div>

                <? endif; ?>


                <a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="card-product__info"><?= $item['NAME'] ?></a>
                <div class="card-product__code">
                    <span>Код:</span>
                    <span><?= $item['PROPERTIES']['CML2_TRAITS']['VALUE']['2'] ?></span>
                </div>
            </div>
            <div class="card-product__bottom" id="<?= $itemIds['BASKET_ACTIONS'] ?>">
                <div class="card-product__block-cnt block-cnt" data-entity="quantity-block">
                    <button class="block-cnt__minus" id="<?= $itemIds['QUANTITY_DOWN'] ?>"></button>
                    <input class="block-cnt__field" type="number" id="<?= $itemIds['QUANTITY'] ?>"
                           name="<?= $arParams['PRODUCT_QUANTITY_VARIABLE'] ?>"
                           value="<?= $measureRatio ?>"
                           min="0">
                    <button class="block-cnt__plus" id="<?= $itemIds['QUANTITY_UP'] ?>"></button>
                </div>
                <div hidden>
                    <span id="<?= $itemIds['QUANTITY_MEASURE'] ?>"><?= $actualItem['ITEM_MEASURE']['TITLE'] ?></span>
                    <span id="<?= $itemIds['PRICE_TOTAL'] ?>"></span>
                </div>
                <a href="<?= $item['ADD_URL'] ?>" class="card-product__basket" id="<?= $itemIds['BUY_LINK'] ?>">
                    <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/basket.svg') ?>" alt="" class="img-svg">
                    <span class="h5-new">Купить</span>
                </a>
            </div>
        <? else: ?>
            <span class="b-price b-price_ac">Товар недоступен</span>
        <? endif; ?>
    </div>

    <? if (!$haveOffers) {
        $jsParams = array(
            'PRODUCT_TYPE' => $item['CATALOG_TYPE'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_ADD_BASKET_BTN' => false,
            'SHOW_BUY_BTN' => true,
            'SHOW_ABSENT' => true,
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'BIG_DATA' => $item['BIG_DATA'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'VIEW_MODE' => $arResult['TYPE'],
            'USE_SUBSCRIBE' => $showSubscribe,
            'PRODUCT' => array(
                'ID' => $item['ID'],
                'NAME' => $productTitle,
                'DETAIL_PAGE_URL' => $item['DETAIL_PAGE_URL'],
                'PICT' => $item['SECOND_PICT'] ? $item['PREVIEW_PICTURE_SECOND'] : $item['PREVIEW_PICTURE'],
                'CAN_BUY' => $item['CAN_BUY'],
                'CHECK_QUANTITY' => $item['CHECK_QUANTITY'],
                'MAX_QUANTITY' => $item['CATALOG_QUANTITY'],
                'STEP_QUANTITY' => $item['ITEM_MEASURE_RATIOS'][$item['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
                'QUANTITY_FLOAT' => is_float($item['ITEM_MEASURE_RATIOS'][$item['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
                'ITEM_PRICE_MODE' => $item['ITEM_PRICE_MODE'],
                'ITEM_PRICES' => $item['ITEM_PRICES'],
                'ITEM_PRICE_SELECTED' => $item['ITEM_PRICE_SELECTED'],
                'ITEM_QUANTITY_RANGES' => $item['ITEM_QUANTITY_RANGES'],
                'ITEM_QUANTITY_RANGE_SELECTED' => $item['ITEM_QUANTITY_RANGE_SELECTED'],
                'ITEM_MEASURE_RATIOS' => $item['ITEM_MEASURE_RATIOS'],
                'ITEM_MEASURE_RATIO_SELECTED' => $item['ITEM_MEASURE_RATIO_SELECTED'],
                'MORE_PHOTO' => $item['MORE_PHOTO'],
                'MORE_PHOTO_COUNT' => $item['MORE_PHOTO_COUNT']
            ),
            'BASKET' => array(
                'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
                'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                'EMPTY_PROPS' => empty($item['PRODUCT_PROPERTIES']),
                'BASKET_URL' => $arParams['~BASKET_URL'],
                'ADD_URL_TEMPLATE' => $arParams['~ADD_URL_TEMPLATE'],
                'BUY_URL_TEMPLATE' => $arParams['~BUY_URL_TEMPLATE']
            ),
            'VISUAL' => array(
                'ID' => $itemIds['ID'],
                'PICT_ID' => $item['SECOND_PICT'] ? $itemIds['SECOND_PICT'] : $itemIds['PICT'],
                'PICT_SLIDER_ID' => $itemIds['PICT_SLIDER'],
                'QUANTITY_ID' => $itemIds['QUANTITY'],
                'QUANTITY_UP_ID' => $itemIds['QUANTITY_UP'],
                'QUANTITY_DOWN_ID' => $itemIds['QUANTITY_DOWN'],
                'PRICE_ID' => $itemIds['PRICE'],
                'PRICE_OLD_ID' => $itemIds['PRICE_OLD'],
                'PRICE_TOTAL_ID' => $itemIds['PRICE_TOTAL'],
                'BUY_ID' => $itemIds['BUY_LINK'],
                'BASKET_PROP_DIV' => $itemIds['BASKET_PROP_DIV'],
                'BASKET_ACTIONS_ID' => $itemIds['BASKET_ACTIONS'],
                'NOT_AVAILABLE_MESS' => $itemIds['NOT_AVAILABLE_MESS'],
                'COMPARE_LINK_ID' => $itemIds['COMPARE_LINK'],
                'SUBSCRIBE_ID' => $itemIds['SUBSCRIBE_LINK']
            )
        );
    } else {
        $jsParams = array(
            'PRODUCT_TYPE' => $item['CATALOG_TYPE'],
            'SHOW_QUANTITY' => false,
            'SHOW_ADD_BASKET_BTN' => false,
            'SHOW_BUY_BTN' => true,
            'SHOW_ABSENT' => true,
            'SHOW_SKU_PROPS' => false,
            'SECOND_PICT' => $item['SECOND_PICT'],
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'BIG_DATA' => $item['BIG_DATA'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'VIEW_MODE' => $arResult['TYPE'],
            'USE_SUBSCRIBE' => $showSubscribe,
            'DEFAULT_PICTURE' => array(
                'PICTURE' => $item['PRODUCT_PREVIEW'],
                'PICTURE_SECOND' => $item['PRODUCT_PREVIEW_SECOND']
            ),
            'VISUAL' => array(
                'ID' => $itemIds['ID'],
                'PICT_ID' => $itemIds['PICT'],
                'SECOND_PICT_ID' => $itemIds['SECOND_PICT'],
                'PICT_SLIDER_ID' => $itemIds['PICT_SLIDER'],
                'QUANTITY_ID' => $itemIds['QUANTITY'],
                'QUANTITY_UP_ID' => $itemIds['QUANTITY_UP'],
                'QUANTITY_DOWN_ID' => $itemIds['QUANTITY_DOWN'],
                'QUANTITY_MEASURE' => $itemIds['QUANTITY_MEASURE'],
                'QUANTITY_LIMIT' => $itemIds['QUANTITY_LIMIT'],
                'PRICE_ID' => $itemIds['PRICE'],
                'PRICE_OLD_ID' => $itemIds['PRICE_OLD'],
                'PRICE_TOTAL_ID' => $itemIds['PRICE_TOTAL'],
                'TREE_ID' => $itemIds['PROP_DIV'],
                'TREE_ITEM_ID' => $itemIds['PROP'],
                'BUY_ID' => $itemIds['BUY_LINK'],
                'DSC_PERC' => $itemIds['DSC_PERC'],
                'SECOND_DSC_PERC' => $itemIds['SECOND_DSC_PERC'],
                'DISPLAY_PROP_DIV' => $itemIds['DISPLAY_PROP_DIV'],
                'BASKET_ACTIONS_ID' => $itemIds['BASKET_ACTIONS'],
                'NOT_AVAILABLE_MESS' => $itemIds['NOT_AVAILABLE_MESS'],
                'COMPARE_LINK_ID' => $itemIds['COMPARE_LINK'],
                'SUBSCRIBE_ID' => $itemIds['SUBSCRIBE_LINK']
            ),
            'BASKET' => array(
                'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                'SKU_PROPS' => $item['OFFERS_PROP_CODES'],
                'BASKET_URL' => $arParams['~BASKET_URL'],
                'ADD_URL_TEMPLATE' => $arParams['~ADD_URL_TEMPLATE'],
                'BUY_URL_TEMPLATE' => $arParams['~BUY_URL_TEMPLATE']
            ),
            'PRODUCT' => array(
                'ID' => $item['ID'],
                'NAME' => $productTitle,
                'DETAIL_PAGE_URL' => $item['DETAIL_PAGE_URL'],
                'MORE_PHOTO' => $item['MORE_PHOTO'],
                'MORE_PHOTO_COUNT' => $item['MORE_PHOTO_COUNT']
            ),
            'OFFERS' => array(),
            'OFFER_SELECTED' => 0,
            'TREE_PROPS' => array()
        );

        if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && !empty($item['OFFERS_PROP'])) {
            $jsParams['SHOW_QUANTITY'] = $arParams['USE_PRODUCT_QUANTITY'];
            $jsParams['SHOW_SKU_PROPS'] = $item['OFFERS_PROPS_DISPLAY'];
            $jsParams['OFFERS'] = $item['JS_OFFERS'];
            $jsParams['OFFER_SELECTED'] = $item['OFFERS_SELECTED'];
            $jsParams['TREE_PROPS'] = $skuProps;
        }
    }

    if ($arParams['DISPLAY_COMPARE']) {
        $jsParams['COMPARE'] = array(
            'COMPARE_URL_TEMPLATE' => $arParams['~COMPARE_URL_TEMPLATE'],
            'COMPARE_DELETE_URL_TEMPLATE' => $arParams['~COMPARE_DELETE_URL_TEMPLATE'],
            'COMPARE_PATH' => $arParams['COMPARE_PATH']
        );
    }

    if ($item['BIG_DATA']) {
        $jsParams['PRODUCT']['RCM_ID'] = $item['RCM_ID'];
    }

    $jsParams['PRODUCT_DISPLAY_MODE'] = $arParams['PRODUCT_DISPLAY_MODE'];
    $jsParams['USE_ENHANCED_ECOMMERCE'] = $arParams['USE_ENHANCED_ECOMMERCE'];
    $jsParams['DATA_LAYER_NAME'] = $arParams['DATA_LAYER_NAME'];
    $jsParams['BRAND_PROPERTY'] = !empty($item['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
        ? $item['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
        : null;

    $templateData = array(
        'JS_OBJ' => $obName,
        'ITEM' => array(
            'ID' => $item['ID'],
            'IBLOCK_ID' => $item['IBLOCK_ID'],
            'OFFERS_SELECTED' => $item['OFFERS_SELECTED'],
            'JS_OFFERS' => $item['JS_OFFERS']
        )
    );
    ?>
    <script>
        var <?=$obName?> =
        new JCCatalogItem(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    </script>
    <?
    unset($item, $actualItem, $minOffer, $itemIds, $jsParams);
}