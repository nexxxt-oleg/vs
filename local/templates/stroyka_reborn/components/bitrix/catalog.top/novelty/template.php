<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogTopComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

//$this->setFrameMode(true);

if (!empty($arResult['ITEMS'])) :
    $elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
    $elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
    $elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM'));

    $templateLibrary = array('popup');
    $currencyList = '';

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

    $elementActions = [
        'EDIT' => CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"),
        'DELETE' => CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"),
        'DELETE_PARAMS' => array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM')),
    ];

    if (!empty($arResult['CURRENCIES'])) {
        $templateLibrary[] = 'currency';
        $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
    }

    $templateData = array(
        'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
        'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME'],
        'TEMPLATE_LIBRARY' => $templateLibrary,
        'CURRENCIES' => $currencyList
    );
    unset($currencyList, $templateLibrary);
    $areaIds = array();

    foreach ($arResult['ITEMS'] as $item) {
        $uniqueId = $item['ID'] . '_' . md5($this->randString() . $component->getAction());
        $areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
        $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
        $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
    }
    ?>

    <div class="new-container">
        <? if (!empty($arResult['ITEMS'])): ?>
            <div class="new-row">
                <div class="new-col-lg-12">
                    <div class="page-home__block-title">
                        <span class="page-home__slider-title h2-new">Новинки</span>
                        <a href="/novelty/" class="page-home__slider-link">
                            <span>в раздел</span>
                            <span></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="new-row">
                <div class="col-no-padding new-col-lg-12">
                    <div class="page-home__sale-slider sale-slider">
                        <div class="sale-slider__new">
                            <button class="sale-slider__prev slider-arrow-prev">
                                <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/arrow-left.svg') ?>"
                                     class="img-svg">
                            </button>
                            <button class="sale-slider__next slider-arrow-next">
                                <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/arrow-right.svg') ?>"
                                     class="img-svg">
                            </button>
                            <div class="sale-slider__dots sliders-dots">
                            </div>
                            <div class="sale-slider__slick">
                                <? foreach ($arResult['ITEMS'] as $item): ?>
                                    <?
                                    $uniqueId = $item['ID'] . '_' . md5($this->randString() . $component->getAction());
                                    $areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
                                    $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
                                    $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
                                    $price = $item['MIN_PRICE'];
                                    ?>
                                    <div class="sale-slider__item">
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
                                <? endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <? endif; ?>
    </div>
    <script type="text/javascript">
        $(function () {
            var saleSlider_<?= $arResult['ID'] ?> = $('[data-entity="slick-slider_<?= $arResult['ID'] ?>"]');
            var saleSliderPrev_<?= $arResult['ID'] ?> = $('[data-entity="slick-prev_<?= $arResult['ID'] ?>"]');
            var saleSliderNext_<?= $arResult['ID'] ?> = $('[data-entity="slick-next_<?= $arResult['ID'] ?>"]');

            saleSlider_<?= $arResult['ID'] ?>.slick({
                infinite: false,
                dots: false,
                arrows: false,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            saleSliderPrev_<?= $arResult['ID'] ?>.on('click', function () {
                saleSlider_<?= $arResult['ID'] ?>.slick('slickPrev');
            });

            saleSliderNext_<?= $arResult['ID'] ?>.on('click', function () {
                saleSlider_<?= $arResult['ID'] ?>.slick('slickNext');
            });
        });
    </script>

<? endif; ?>

