<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);

$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/style.css',
    'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME']
);

$arSkuTemplate = array();
if (isset($arResult['SKU_PROPS']) && is_array($arResult['SKU_PROPS'])) {
    foreach ($arResult['SKU_PROPS'] as $iblockId => $skuProps) {
        $arSkuTemplate[$iblockId] = array();
        foreach ($skuProps as &$arProp) {
            ob_start();
            if ('TEXT' == $arProp['SHOW_MODE']) {
                if (5 < $arProp['VALUES_COUNT']) {
                    $strClass = 'bx_item_detail_size full';
                    $strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
                    $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                    $strSlideStyle = '';
                } else {
                    $strClass = 'bx_item_detail_size';
                    $strWidth = '100%';
                    $strOneWidth = '20%';
                    $strSlideStyle = 'display: none;';
                }
                ?>
                <div class="<?= $strClass; ?>" id="#ITEM#_prop_<?= $arProp['ID']; ?>_cont">
                    <span class="bx_item_section_name_gray"><?= htmlspecialcharsex($arProp['NAME']); ?></span>

                    <div class="bx_size_scroller_container">
                        <div class="bx_size">
                            <ul id="#ITEM#_prop_<?= $arProp['ID']; ?>_list" style="width: <?= $strWidth; ?>;">
                                <? foreach ($arProp['VALUES'] as $arOneValue) { ?>
                                    <li
                                            data-treevalue="<?= $arProp['ID'] . '_' . $arOneValue['ID']; ?>"
                                            data-onevalue="<?= $arOneValue['ID']; ?>"
                                            style="width: <?= $strOneWidth; ?>;"
                                    ><i></i><span class="cnt"><?= htmlspecialcharsex($arOneValue['NAME']); ?></span></li>
                                <? } ?>
                            </ul>
                        </div>
                        <div class="bx_slide_left" id="#ITEM#_prop_<?= $arProp['ID']; ?>_left"
                             data-treevalue="<?= $arProp['ID']; ?>" style="<?= $strSlideStyle; ?>"></div>
                        <div class="bx_slide_right" id="#ITEM#_prop_<?= $arProp['ID']; ?>_right"
                             data-treevalue="<?= $arProp['ID']; ?>" style="<?= $strSlideStyle; ?>"></div>
                    </div>
                </div>
            <? } elseif ('PICT' == $arProp['SHOW_MODE']) {
                if (5 < $arProp['VALUES_COUNT']) {
                    $strClass = 'bx_item_detail_scu full';
                    $strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
                    $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                    $strSlideStyle = '';
                } else {
                    $strClass = 'bx_item_detail_scu';
                    $strWidth = '100%';
                    $strOneWidth = '20%';
                    $strSlideStyle = 'display: none;';
                }
                ?>
                <div class="<?= $strClass; ?>" id="#ITEM#_prop_<?= $arProp['ID']; ?>_cont">
                    <span class="bx_item_section_name_gray"><?= htmlspecialcharsex($arProp['NAME']); ?></span>

                    <div class="bx_scu_scroller_container">
                        <div class="bx_scu">
                            <ul id="#ITEM#_prop_<?= $arProp['ID']; ?>_list" style="width: <?= $strWidth; ?>;">
                                <? foreach ($arProp['VALUES'] as $arOneValue) { ?>
                                    <li
                                            data-treevalue="<?= $arProp['ID'] . '_' . $arOneValue['ID'] ?>"
                                            data-onevalue="<?= $arOneValue['ID']; ?>"
                                            style="width: <?= $strOneWidth; ?>; padding-top: <?= $strOneWidth; ?>;"
                                    ><i title="<?= htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
                                        <span class="cnt"><span class="cnt_item"
                                                                style="background-image:url('<?= $arOneValue['PICT']['SRC']; ?>');"
                                                                title="<?= htmlspecialcharsbx($arOneValue['NAME']); ?>"
                                            ></span></span></li>
                                <? } ?>
                            </ul>
                        </div>
                        <div class="bx_slide_left" id="#ITEM#_prop_<?= $arProp['ID']; ?>_left"
                             data-treevalue="<?= $arProp['ID']; ?>" style="<?= $strSlideStyle; ?>"></div>
                        <div class="bx_slide_right" id="#ITEM#_prop_<?= $arProp['ID']; ?>_right"
                             data-treevalue="<?= $arProp['ID']; ?>" style="<?= $strSlideStyle; ?>"></div>
                    </div>
                </div>
                <?
            }
            $arSkuTemplate[$iblockId][$arProp['CODE']] = ob_get_contents();
            ob_end_clean();
            unset($arProp);
        }
    }
} ?>

<? if (isset($arResult['ITEMS']) && !empty($arResult['ITEMS'])): ?>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="page-all-sect__top-title">
                    <h2><?= GetMessage('SRP_HREF_TITLE') ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <? foreach ($arResult['ITEMS'] as $key => $arItem) {
                $strMainID = $this->GetEditAreaId($arItem['ID'] . $key);

                $arItemIDs = array(
                    'ID' => $strMainID,
                    'PICT' => $strMainID . '_pict',
                    'SECOND_PICT' => $strMainID . '_secondpict',
                    'MAIN_PROPS' => $strMainID . '_main_props',

                    'QUANTITY' => $strMainID . '_quantity',
                    'QUANTITY_DOWN' => $strMainID . '_quant_down',
                    'QUANTITY_UP' => $strMainID . '_quant_up',
                    'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
                    'BUY_LINK' => $strMainID . '_buy_link',
                    'SUBSCRIBE_LINK' => $strMainID . '_subscribe',

                    'PRICE' => $strMainID . '_price',
                    'DSC_PERC' => $strMainID . '_dsc_perc',
                    'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',

                    'PROP_DIV' => $strMainID . '_sku_tree',
                    'PROP' => $strMainID . '_prop_',
                    'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
                    'BASKET_PROP_DIV' => $strMainID . '_basket_prop'
                );

                $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

                $strTitle = (
                isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
                    ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
                    : $arItem['NAME']
                );
                $showImgClass = $arParams['SHOW_IMAGE'] != "Y" ? "no-imgs" : "";

                ?>
                <div class="col-sm-6 col-md-3">
                    <div class="card-product" id="<?= $strMainID; ?>">
                        <div class="card-product__top">
                            <!-- <button class="card-product__add-favorites"> -->
                            <!-- <img src="/img/ui-icon/favorites.svg" class="img-svg"> -->
                            <!-- </button> -->
                            <? if ($arParams['SHOW_IMAGE'] == "Y") { ?>
                                <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>" id="<?= $arItemIDs['PICT']; ?>" class="card-product__img">
                                    <img src="<?= ($arParams['SHOW_IMAGE'] == "Y" ? $arItem['PREVIEW_PICTURE']['SRC'] : ""); ?>">
                                </a>
                            <? } ?>
                        </div>
                        <div class="card-product__middle">
                            <? if ($arParams['SHOW_NAME'] == "Y") { ?>
                                <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>" class="card-product__title h5"><?= $arItem['NAME']; ?></a>
                            <? } ?>
                            <!-- <div class="card-product__desc b-content"> -->
                            <!-- <p>Антивибрационные подставки</p> -->
                            <!-- </div> -->
                        </div>
                        <div class="card-product__bottom">
                            <div class="card-product__price-old" id="<?= $arItemIDs['PRICE']; ?>">
							<span class="b-price">
								<span class="b-price__number">
									<? if (!empty($arItem['MIN_PRICE'])) {
                                        if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) {
                                            echo GetMessage(
                                                'SRP_TPL_MESS_PRICE_SIMPLE_MODE',
                                                array(
                                                    '#PRICE#' => $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
                                                    '#MEASURE#' => GetMessage(
                                                        'SRP_TPL_MESS_MEASURE_SIMPLE_MODE',
                                                        array(
                                                            '#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
                                                            '#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
                                                        )
                                                    )
                                                )
                                            );
                                        } else {
                                            echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
                                        }
                                        if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']) { ?>
                                            <span style="color: #a5a5a5;font-size: 12px;font-weight: normal;white-space: nowrap;text-decoration: line-through;"><?= $arItem['MIN_PRICE']['PRINT_VALUE']; ?></span>
                                        <? }
                                    } ?>
								</span> <!-- <span class="b-price__rub"></span> -->
							</span>
                            </div>
                            <!-- <div class="card-product__price-current">
                                <span class="b-price b-price_ac">
                                    <span class="b-price__number">
                                        <span>600</span><sup>00</sup>
                                    </span> <span class="b-price__rub"></span>
                                </span>
                            </div> -->

                            <a id="<?= $arItemIDs['BUY_LINK']; ?>" class="card-product__add-cart" href="javascript:void(0)" rel="nofollow">
                                <? //echo('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('SRP_TPL_MESS_BTN_BUY')); ?>
                                <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/basket-plus.svg") ?>">
                            </a>
                        </div>
                        <? if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) { // Simple Product ?>
                            <?
                            $arJSParams = array(
                                'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
                                'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                                'SHOW_ADD_BASKET_BTN' => false,
                                'SHOW_BUY_BTN' => true,
                                'SHOW_ABSENT' => true,
                                'PRODUCT' => array(
                                    'ID' => $arItem['ID'],
                                    'NAME' => $arItem['~NAME'],
                                    'PICT' => $arItem['PREVIEW_PICTURE'],
                                    'CAN_BUY' => $arItem["CAN_BUY"],
                                    'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
                                    'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
                                    'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
                                    'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
                                    'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
                                    'ADD_URL' => $arItem['~ADD_URL'],
                                    'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL']
                                ),
                                'BASKET' => array(
//                                    'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
                                    'ADD_PROPS' => false,
                                    'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                                    'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                                    'EMPTY_PROPS' => $emptyProductProperties
                                ),
                                'VISUAL' => array(
                                    'ID' => $arItemIDs['ID'],
                                    'PICT_ID' => $arItemIDs['PICT'],
                                    'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                                    'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                                    'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                                    'PRICE_ID' => $arItemIDs['PRICE'],
                                    'BUY_ID' => $arItemIDs['BUY_LINK'],
                                    'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
                                ),
                                'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
                            );
                            ?>
                            <script type="text/javascript">
                                var <?= $strObName; ?> =
                                new JCCatalogSectionSRec(<?= CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                            </script><?
                        } else { // Wth Sku ?>
                            <div class="bx_catalog_item_controls no_touch">
                                <? if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) { ?>
                                    <div class="bx_catalog_item_controls_blockone">
                                        <a id="<?= $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)"
                                           class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
                                        <input type="text" class="bx_col_input" id="<?= $arItemIDs['QUANTITY']; ?>"
                                               name="<?= $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>"
                                               value="<?= $arItem['CATALOG_MEASURE_RATIO']; ?>">
                                        <a id="<?= $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)"
                                           class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
                                        <span id="<?= $arItemIDs['QUANTITY_MEASURE']; ?>"></span>
                                    </div>
                                <? } ?>
                                <div class="bx_catalog_item_controls_blocktwo">
                                    <a id="<?= $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium"
                                       href="javascript:void(0)" rel="nofollow">
                                        <?= ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('SRP_TPL_MESS_BTN_BUY')); ?>
                                    </a>
                                </div>
                                <div style="clear: both;"></div>
                            </div>

                            <div class="bx_catalog_item_controls touch">
                                <a class="bx_bt_button_type_2 bx_medium"
                                   href="<?= $arItem['DETAIL_PAGE_URL']; ?>">
                                    <?= ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('SRP_TPL_MESS_BTN_DETAIL')); ?>
                                </a>
                            </div>
                        <?
                        $boolShowOfferProps = !!$arItem['OFFERS_PROPS_DISPLAY'];
                        $boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));
                        if ($boolShowProductProps || $boolShowOfferProps) { ?>
                            <div class="bx_catalog_item_articul">
                                <? if ($boolShowProductProps) {
                                    foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp) { ?>
                                        <br><?= $arOneProp['NAME']; ?><strong> <?
                                        echo(
                                        is_array($arOneProp['DISPLAY_VALUE'])
                                            ? implode(' / ', $arOneProp['DISPLAY_VALUE'])
                                            : $arOneProp['DISPLAY_VALUE']
                                        ); ?></strong><?
                                    }
                                } ?>
                                <span id="<?= $arItemIDs['DISPLAY_PROP_DIV']; ?>" style="display: none;"></span>
                            </div>
                        <? }
                        if (!empty($arItem['OFFERS']) && isset($arSkuTemplate[$arItem['IBLOCK_ID']])) {
                        $arSkuProps = array();
                        ?>
                            <div class="bx_catalog_item_scu" id="<?= $arItemIDs['PROP_DIV']; ?>">
                                <? foreach ($arSkuTemplate[$arItem['IBLOCK_ID']] as $code => $strTemplate) {
                                    if (!isset($arItem['OFFERS_PROP'][$code]))
                                        continue;
                                    echo '<div>', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '</div>';
                                }

                                if (isset($arResult['SKU_PROPS'][$arItem['IBLOCK_ID']])) {
                                    foreach ($arResult['SKU_PROPS'][$arItem['IBLOCK_ID']] as $arOneProp) {
                                        if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
                                            continue;
                                        $arSkuProps[] = array(
                                            'ID' => $arOneProp['ID'],
                                            'SHOW_MODE' => $arOneProp['SHOW_MODE'],
                                            'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
                                        );
                                    }
                                }
                                foreach ($arItem['JS_OFFERS'] as &$arOneJs) {
                                    if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
                                        $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-' . $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] . '%';
                                } ?>
                            </div>
                        <? if ($arItem['OFFERS_PROPS_DISPLAY']) {
                            foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer) {
                                $strProps = '';
                                if (!empty($arJSOffer['DISPLAY_PROPERTIES'])) {
                                    foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp) {
                                        $strProps .= '<br>' . $arOneProp['NAME'] . ' <strong>' . (
                                            is_array($arOneProp['VALUE'])
                                                ? implode(' / ', $arOneProp['VALUE'])
                                                : $arOneProp['VALUE']
                                            ) . '</strong>';
                                    }
                                }
                                $arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
                            }
                        }
                        $arJSParams = array(
                            'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
                            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                            'SHOW_ADD_BASKET_BTN' => false,
                            'SHOW_BUY_BTN' => true,
                            'SHOW_ABSENT' => true,
                            'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
                            'SECOND_PICT' => false,
                            'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
                            'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
                            'DEFAULT_PICTURE' => array(
                                'PICTURE' => $arItem['PRODUCT_PREVIEW'],
                                'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
                            ),
                            'VISUAL' => array(
                                'ID' => $arItemIDs['ID'],
                                'PICT_ID' => $arItemIDs['PICT'],
                                //'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
                                'SECOND_PICT_ID' => $arItemIDs['PICT'],
                                'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                                'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                                'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                                'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
                                'PRICE_ID' => $arItemIDs['PRICE'],
                                'TREE_ID' => $arItemIDs['PROP_DIV'],
                                'TREE_ITEM_ID' => $arItemIDs['PROP'],
                                'BUY_ID' => $arItemIDs['BUY_LINK'],
                                'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
                                'DSC_PERC' => $arItemIDs['DSC_PERC'],
                                'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
                                'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
                            ),
                            'BASKET' => array(
                                'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                                'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE']
                            ),
                            'PRODUCT' => array(
                                'ID' => $arItem['ID'],
                                'NAME' => $arItem['~NAME']
                            ),
                            'OFFERS' => $arItem['JS_OFFERS'],
                            'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
                            'TREE_PROPS' => $arSkuProps,
                            'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
                        );
                        ?>
                            <script type="text/javascript">
                                var <?= $strObName; ?> =
                                new JCCatalogSectionSRec(<?= CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                            </script>
                        <? }
                        } ?>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>

    <script type="text/javascript">
        BX.message({
            MESS_BTN_BUY: '<?=('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('SRP_TPL_MESS_BTN_BUY')); ?>',
            MESS_BTN_ADD_TO_BASKET: '<?=('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('SRP_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',

            MESS_BTN_DETAIL: '<?=('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('SRP_TPL_MESS_BTN_DETAIL')); ?>',

            MESS_NOT_AVAILABLE: '<?=('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('SRP_TPL_MESS_BTN_DETAIL')); ?>',
            BTN_MESSAGE_BASKET_REDIRECT: '<?= GetMessageJS('SRP_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
            BASKET_URL: '<?= $arParams["BASKET_URL"]; ?>',
            ADD_TO_BASKET_OK: '<?= GetMessageJS('SRP_ADD_TO_BASKET_OK'); ?>',
            TITLE_ERROR: '<?= GetMessageJS('SRP_CATALOG_TITLE_ERROR') ?>',
            TITLE_BASKET_PROPS: '<?= GetMessageJS('SRP_CATALOG_TITLE_BASKET_PROPS') ?>',
            TITLE_SUCCESSFUL: '<?= GetMessageJS('SRP_ADD_TO_BASKET_OK'); ?>',
            BASKET_UNKNOWN_ERROR: '<?= GetMessageJS('SRP_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
            BTN_MESSAGE_SEND_PROPS: '<?= GetMessageJS('SRP_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
            BTN_MESSAGE_CLOSE: '<?= GetMessageJS('SRP_CATALOG_BTN_MESSAGE_CLOSE') ?>'
        });
    </script>

<? endif ?>
