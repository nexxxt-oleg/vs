<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Page\Asset;
use Bitrix\Main\Loader;
use Bitrix\Main\Data;

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
$inFavorites = in_array($arResult['ID'], $APPLICATION->delayedItems);
$isAuthoredUser = isset($USER) && $USER->IsAuthorized();
?>

    <section class="catalog-item" id="<?= $itemIds['ID'] ?>">
        <div class="new-container" itemscope itemtype="http://schema.org/Product">
            <div class="new-row">
                <? if ($arParams['DISPLAY_NAME'] === 'Y') { ?>
                    <div class="new-col-sm-12 new-offset-lg-5 new-col-lg-7">
                        <span class="catalog-item__title h2-new"><?= $name ?></span>
                    </div>
                <? } ?>
                <div class="new-col-sm-6 new-col-lg-5">
                    <div class="catalog-item__preview" id="<?= $itemIds['BIG_SLIDER_ID'] ?>"
                         data-entity="images-container">
                        <? if (!empty($actualItem['MORE_PHOTO'] && $actualItem['MORE_PHOTO'][0])) {
                            foreach ($actualItem['MORE_PHOTO'] as $key => $photo) {
                                ?>
                                <img src="<?= $photo['SRC'] ?>" alt="<?= $alt ?>" title="<?= $title ?>"
                                     class="catalog-item__product-img" data-entity="image"
                                     data-id="<?= $photo['ID'] ?>">
                                <?
                            }
                        } else { ?>
                            <img src="<?= $APPLICATION->GetTemplatePath("img/no_photo.png") ?>" alt="<?= $alt ?>"
                                 title="<?= $title ?>"
                                 class="catalog-item__product-img" data-entity="image"
                                 data-id="<?= $photo['ID'] ?>">
                        <? } ?>
                        <a href="#" class="catalog-item__warning-img js-item-img-mismatch"
                           data-id="<?= $arResult['ID'] ?>"
                           data-element="<?= $arResult['NAME'] ?>"
                           data-element-url="<?= $arResult['DETAIL_PAGE_URL'] ?>"
                           title="Сообщить менеджеру о несоответствии фото товару">
                            <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/warning.svg') ?>" alt="">
                        </a>
                        <div class="catalog-item__badges">
                            <? if (($diffDateCreate->format('%a')) < 30): ?>
                                <span class="card-product__badge card-product__badge_color_green">Новинка</span>
                            <? endif; ?>
                            <span class="card-product__badge card-product__badge_color_red d-none">Акция</span>
                            <? if (isset($arResult['PROPERTIES']['PRICHINA_UTSENKI']) && !empty($arResult['PROPERTIES']['PRICHINA_UTSENKI']['VALUE'])): ?>
                                <div class="card-product__badge card-product__badge_markdown card-product__badge_color_violet d-none">
                                    Уценка
                                    <div class="card-product__markdown-wrap">
                                        <span class="card-product__markdown"> <?= $arResult['PROPERTIES']['PRICHINA_UTSENKI']['VALUE'] ?></span>
                                    </div>
                                </div>
                            <? endif; ?>
                            <?
                            if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y') :
                                if ($haveOffers) : ?>
                                    <span class="card-product__badge card-product__badge_discount card-product__badge_color_red" <?= $itemIds['DISCOUNT_PERCENT_ID'] ?>></span>
                                <? elseif ($price['DISCOUNT'] > 0) : ?>
                                    <span class="card-product__badge card-product__badge_discount card-product__badge_color_red"
                                          id="<?= $itemIds['DISCOUNT_PERCENT_ID'] ?>"><?= -$price['PERCENT'] ?>%</span>
                                <? endif;
                            endif; ?>
                        </div>
                    </div>
                </div>
                <div class="new-col-sm-6 new-col-lg-4">
                    <div class="catalog-item__price-list price-list">
                        <div class="price-list__top price-list-top">
                            <div class="price-list-top__exists price-list-top__exists_true">
                                <? if ($arResult['CATALOG_QUANTITY'] > 0): ?>
                                    <span>Есть в наличии</span>
                                    <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/in-stock.svg') ?>" alt="">
                                <? else: ?>
                                    <span>Нет в наличии</span>
                                <? endif; ?>
                            </div>
                            <div class="price-list-top__code">
                                <span>Код:</span>
                                <span><?= $arResult['PROPERTIES']['CML2_TRAITS']['VALUE']['2'] ?></span>
                            </div>
                        </div>
                        <? $truePrice = !empty($old_price_param) ? $price['RATIO_PRICE'] <= $old_price_param : false; ?>
                        <div class="price-list__middle price-list-middle">
                            <div class="price-list-middle__price">
                                <span class="price-list-middle__current-price h2-new" id="<?= $itemIds['PRICE_ID'] ?>">
                                    <?= $price['PRINT_RATIO_PRICE'] ?>
                                </span>

                                <? if ($arParams['SHOW_OLD_PRICE'] === 'Y') : ?>
                                    <? if ($truePrice): ?>
                                        <span class="price-list-middle__old-price h4-new">
                                            <?= ($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : (!empty($old_price_param) ? ($old_price_param . " " . $currency) : '')) ?>
                                        </span>
                                    <? endif; ?>
                                <? endif; ?>

                                <? if (($arParams['SHOW_OLD_PRICE'] !== 'Y') && !empty($old_price_param)): ?>
                                    <? if ($truePrice): ?>
                                        <span class="price-list-middle__old-price h4-new">
                                            <?= $old_price_param . " " . $currency ?>
                                        </span>
                                    <? endif; ?>
                                <? endif; ?>
                            </div>

                            <? if ($arParams['USE_PRODUCT_QUANTITY']) : ?>
                                <div class="price-list-middle__total"
                                     style="<?= (!$actualItem['CAN_BUY'] ? 'display: none;' : '') ?>"
                                     data-entity="quantity-block">
                                    <div class="price-list-middle__block-cnt block-cnt">
                                        <button class="block-cnt__minus"
                                                id="<?= $itemIds['QUANTITY_DOWN_ID'] ?>"></button>
                                        <input class="block-cnt__field" id="<?= $itemIds['QUANTITY_ID'] ?>"
                                               type="number"
                                               value="<?= $price['MIN_QUANTITY'] ?>">
                                        <button class="block-cnt__plus" id="<?= $itemIds['QUANTITY_UP_ID'] ?>"></button>
                                    </div>
                                    <div class="price-list-middle__total-price">
                                        <span>Итого:</span>
                                        <span id="<?= $itemIds['PRICE_TOTAL'] ?>"></span>
                                    </div>
                                </div>
                            <? endif; ?>
                            <div class="price-list-middle__bye" id="<?= $itemIds['BASKET_ACTIONS_ID'] ?>"
                                 style="display: <?= ($actualItem['CAN_BUY'] ? '' : 'none') ?>;">
                                <? if ($showAddBtn) : ?>
                                    <a class="<?= $showButtonClassName ?> price-list-middle__basket"
                                       id="<?= $itemIds['ADD_BASKET_LINK'] ?>"
                                       href="javascript:void(0);">
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/basket.svg') ?>" alt=""
                                             class="img-svg">
                                        <span class="h5-new"><?= $arParams['MESS_BTN_ADD_TO_BASKET'] ?></span>

                                    </a>
                                <? endif;
                                if ($showBuyBtn) : ?>
                                    <a class="<?= $buyButtonClassName ?> price-list-middle__basket"
                                       id="<?= $itemIds['BUY_LINK'] ?>"
                                       href="javascript:void(0);">
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/basket.svg') ?>" alt=""
                                             class="img-svg">
                                        <span class="h5-new"><?= $arParams['MESS_BTN_BUY'] ?></span>
                                    </a>
                                <? endif; ?>
                                <!--<button class="price-list-middle__basket">
                                <img src="<? /*=$APPLICATION->GetTemplatePath('img/ui-icon/basket.svg')*/ ?>" alt="" class="img-svg">
                                <img src="<? /*=$APPLICATION->GetTemplatePath('img/ui-icon/added.svg')*/ ?>" alt="">
                                <span class="h5-new">Купить</span>
                            </button>-->
                                <? if ($isAuthoredUser): ?>
                                    <button class="price-list-middle__favorite h2o_add_favor <?= $inFavorites ? ' active' : '' ?>"
                                            data-id="<?= $arResult["ID"] ?>">
                                        <span>В избранное</span>
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/favorite.svg') ?>"
                                             alt=""
                                             class="<?= !$inFavorites ? ' display' : '' ?>">
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/favorite-fill.svg') ?>"
                                             class="<?= $inFavorites ? ' display' : '' ?>" alt="">
                                    </button>
                                <? else: ?>
                                    <?
                                    $currentUrl = urlencode($APPLICATION->GetCurPageParam("", [
                                        "login",
                                        "login_form",
                                        "logout",
                                        "register",
                                        "forgot_password",
                                        "change_password",
                                        "confirm_registration",
                                        "confirm_code",
                                        "confirm_user_id",
                                        "logout_butt",
                                        "auth_service_id"
                                    ]));
                                    $favoritesListUrl = "/login?login=yes&backurl=" . $currentUrl;
                                    ?>
                                    <a href="<?=$favoritesListUrl?>" class="price-list-middle__favorite"
                                       data-id="<?= $arResult["ID"] ?>">
                                        <span>В избранное</span>
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/favorite.svg') ?>"
                                             alt=""
                                             class="<?= !$inFavorites ? ' display' : '' ?>">
                                    </a>
                                <? endif; ?>
                            </div>
                        </div>
                        <div class="price-list__bottom price-list-bottom">
                            <div class="price-list-bottom__wraper">
                                <button class="price-list-bottom__method js-price-popup">Способы оплаты</button>
                                <div class="price-list-bottom__popup price-popup">
                                    <? $APPLICATION->IncludeComponent(
                                        'bitrix:main.include',
                                        '',
                                        Array(
                                            'AREA_FILE_SHOW' => 'file',
                                            'PATH' => '/catalog/product_payment-inc.php'
                                        )
                                    ); ?>
                                </div>
                            </div>
                            <div class="price-list-bottom__wraper">
                                <button class="price-list-bottom__method js-price-popup">Доставка</button>
                                <div class="price-list-bottom__popup price-list-bottom__popup_sm-right price-popup price-popup_sm-right">
                                    <? $APPLICATION->IncludeComponent(
                                        'bitrix:main.include',
                                        '',
                                        Array(
                                            'AREA_FILE_SHOW' => 'file',
                                            'PATH' => '/catalog/product_delivery-inc.php'
                                        )
                                    ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="new-col-md-12 new-offset-lg-1 new-col-lg-2">
                    <div class="catalog-item__pluses catalog-item-pluses">
                        <div class="catalog-item-pluses__item">
                            <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/discount.svg') ?>" alt="">
                            <span>выгодная система скидок</span>
                        </div>
                        <div class="catalog-item-pluses__item">
                            <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/delivery2.svg') ?>" alt="">
                            <span>быстрая доставка</span>
                        </div>
                        <div class="catalog-item-pluses__item">
                            <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/return.svg') ?>" alt="">
                            <span>возврат в течение 30 дней</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<? if ($showDescription): ?>
    <section class="section-content section-content_description">
        <div class="new-container">
            <div class="new-row">
                <div class="new-col-lg-8">
                    <div class="b-content">
                        <span class="h3-new"><?= $arParams['MESS_DESCRIPTION_TAB'] ?></span>
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
            </div>
        </div>
    </section>
<? endif; ?>

    <div class="new-container">
        <div class="new-row">
            <div class="new-col-12">
                <span class="section-line"></span>
            </div>
        </div>
    </div>

<? if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) : ?>
    <section class="section-content section-content_characteristic">
        <div class="new-container">
            <div class="new-row">
                <div class="new-col-sm-8 new-col-lg-5">
                    <span class="section-content__title h3-new">Характеристики</span>
                    <? if (!empty($arResult['DISPLAY_PROPERTIES'])) : ?>
                        <? foreach ($arResult['DISPLAY_PROPERTIES'] as $property) : ?>
                            <? if ($property['CODE'] !== 'CML2_TRAITS'): ?>
                                <div class="section-content__item">
                                    <span><?= $property['NAME'] ?></span>
                                    <span>
                            <?= (
                            is_array($property['DISPLAY_VALUE'])
                                ? implode(' / ', $property['DISPLAY_VALUE'])
                                : $property['DISPLAY_VALUE']
                            ) ?>
                        </span>
                                </div>
                            <? else: ?>
                                <? continue; ?>
                            <? endif; ?>
                        <? endforeach; ?>
                    <? endif; ?>
                    <? if ($arResult['SHOW_OFFERS_PROPS']) : ?>
                        <div class="section-content__item" id="<?= $itemIds['DISPLAY_PROP_DIV'] ?>">
                        </div>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </section>

    <div class="new-container">
        <div class="new-row">
            <div class="new-col-12">
                <span class="section-line"></span>
            </div>
        </div>
    </div>

<? endif; ?>

<? if ($arParams['USE_COMMENTS'] === 'Y') { ?>
    <section class="section-content">
        <div class="new-container">
            <div class="new-row">
                <div class="new-col-lg-12">
                    <span class="h-new">Отзывы</span>

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
            </div>
        </div>
    </section>
<? } ?>
    <div class="new-container">
        <div class="new-row">
            <div class="new-col-12">
                <span class="section-line"></span>
            </div>
        </div>
    </div>
    <section class="page-home__slider">
        <?
        $GLOBALS['pArFilter'] = [
            '!ID' => $arResult['ID'],
            'IBLOCK_ID' => $arResult['IBLOCK_ID'],
            'IBLOCK_SECTION_ID' => $arResult['IBLOCK_SECTION_ID'],
        ];
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.top",
            "",
            Array(
                "ACTION_VARIABLE" => "action",
                "ADD_PICT_PROP" => "-",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "ADD_TO_BASKET_ACTION" => "ADD",
                "BASKET_URL" => "/personal/cart/",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COMPARE_NAME" => "CATALOG_COMPARE_LIST",
                "COMPATIBLE_MODE" => "Y",
                "CONVERT_CURRENCY" => "N",
                "CUSTOM_FILTER" => "",
                "DETAIL_URL" => "",
                "DISPLAY_COMPARE" => "N",
                "ELEMENT_COUNT" => "30",
                "ELEMENT_SORT_FIELD" => "timestamp_x",
                "ELEMENT_SORT_FIELD2" => "shows",
                "ELEMENT_SORT_ORDER" => "desc",
                "ELEMENT_SORT_ORDER2" => "asc",
                "ENLARGE_PRODUCT" => "STRICT",
                "FILTER_NAME" => "pArFilter",
                "HIDE_NOT_AVAILABLE" => "Y",
                "HIDE_NOT_AVAILABLE_OFFERS" => "Y",
                "IBLOCK_ID" => "21",
                "IBLOCK_TYPE" => "catalog",
                "LABEL_PROP" => "TSVET",
                "LABEL_PROP_MOBILE" => array(),
                "LABEL_PROP_POSITION" => "top-left",
                "LINE_ELEMENT_COUNT" => "3",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_COMPARE" => "Сравнить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "OFFERS_CART_PROPERTIES" => array(),
                "OFFERS_FIELD_CODE" => array("", ""),
                "OFFERS_LIMIT" => "0",
                "OFFERS_PROPERTY_CODE" => array("", ""),
                "OFFERS_SORT_FIELD" => "shows",
                "OFFERS_SORT_FIELD2" => "shows",
                "OFFERS_SORT_ORDER" => "asc",
                "OFFERS_SORT_ORDER2" => "asc",
                "PARTIAL_PRODUCT_PROPERTIES" => "Y",
                "PRICE_CODE" => array("Розничная руб."),
                "PRICE_VAT_INCLUDE" => "Y",
                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
                "PRODUCT_DISPLAY_MODE" => "N",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_PROPERTIES" => array(),
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_ROW_VARIANTS" => array("={{'VARIANT':'2'}", "BIG_DATA':false", "={{'VARIANT':'2'}", "BIG_DATA':false", "={{'VARIANT':'2'}", "BIG_DATA':false"),
                "PRODUCT_SUBSCRIPTION" => "Y",
                "PROPERTY_CODE" => array("", ""),
                "PROPERTY_CODE_MOBILE" => array(),
                "ROTATE_TIMER" => "30",
                "SECTION_ID_VARIABLE" => "SECTION_ID",
                "SECTION_URL" => "",
                "SEF_MODE" => "N",
                "SEF_RULE" => "",
                "SHOW_CLOSE_POPUP" => "Y",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_MAX_QUANTITY" => "N",
                "SHOW_OLD_PRICE" => "Y",
                "SHOW_PAGINATION" => "Y",
                "SHOW_PRICE_COUNT" => "1",
                "SHOW_SLIDER" => "N",
                "SLIDER_INTERVAL" => "3000",
                "SLIDER_PROGRESS" => "N",
                "TEMPLATE_THEME" => "blue",
                "USE_ENHANCED_ECOMMERCE" => "N",
                "USE_PRICE_COUNT" => "N",
                "USE_PRODUCT_QUANTITY" => "Y",
                "VIEW_MODE" => "BANNER",
                "TITLE" => "Смотрите также",
                'PAGE_URL' => $arResult['SECTION']['SECTION_PAGE_URL']
            )
        ); ?>
    </section>
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