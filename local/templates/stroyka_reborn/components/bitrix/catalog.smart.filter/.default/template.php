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
$this->setFrameMode(true); ?>
<div class="new-col-12 filter__item filter-box bx-filter-parameters-box bx-active">
    <span class="filter-box__title h3-new"><?= GetMessage("CT_BCSF_FILTER_TITLE") ?></span>


        <form name="<?= $arResult["FILTER_NAME"] . "_form" ?>" action="<?= $arResult["FORM_ACTION"] ?>" method="get" class="smartfilter">
            <? foreach ($arResult["HIDDEN"] as $arItem): ?>
                <input
                        type="hidden"
                        name="<?= $arItem["CONTROL_NAME"] ?>"
                        id="<?= $arItem["CONTROL_ID"] ?>"
                        value="<?= $arItem["HTML_VALUE"] ?>"
                />
            <? endforeach; ?>
            <div class="row">
                <? //prices
                foreach ($arResult["ITEMS"] as $key => $arItem):
                    $key = $arItem["ENCODED_ID"];
                    if (isset($arItem["PRICE"])):
                        if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                            continue;

                        $step_num = 4;
                        $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
                        $prices = array();
                        if (Bitrix\Main\Loader::includeModule("currency")) {
                            for ($i = 0; $i < $step_num; $i++) {
                                $prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                            }
                            $prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                        } else {
                            $precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
                            for ($i = 0; $i < $step_num; $i++) {
                                $prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, $precision, ".", "");
                            }
                            $prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                        }
                        ?>
                        <div class="new-col-12 filter__item filter-box bx-filter-parameters-box bx-active">
                            <span class="bx-filter-container-modef filter__modef"></span>
                            <span class="filter-box__sub-title h5-new"><?= $arItem["NAME"] ?></span>

                            <div class="filter-box__params filter-slider bx-filter-block" data-role="bx_filter_block">

                                <div class="filter-slider__field filter-slider__field_left">
                                    <div class="filter-field">
                                        <i class="filter-field__ph"><?= GetMessage("CT_BCSF_FILTER_FROM") ?></i>
                                        <input
                                                class="min-price filter-field__input"
                                                type="text"
                                                name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                value="<?= $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                size="5"
                                                onkeyup="smartFilter.keyup(this)"
                                        />
                                    </div>
                                </div>

                                <div class="filter-slider__field filter-slider__field_right">
                                    <div class="filter-field">
                                        <i class="filter-field__ph"><?= GetMessage("CT_BCSF_FILTER_TO") ?></i>
                                        <input
                                                class="max-price filter-field__input"
                                                type="text"
                                                name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                value="<?= $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                size="5"
                                                onkeyup="smartFilter.keyup(this)"
                                        />
                                    </div>
                                </div>

                                <div class="filter-slider__slider-track">
                                    <div class="filter-track" id="drag_track_<?= $key ?>">
                                        <div class="filter-track__container">
                                            <div class="filter-track__part p1">
                                                <span><?= $minVal ?></span>
                                            </div>
                                            <div class="filter-track__part p2"><span></span></div>
                                            <div class="filter-track__part p3"><span></span></div>
                                            <div class="filter-track__part p4"><span></span></div>
                                            <div class="filter-track__part p5">
                                                <span><?= $maxVal ?></span>
                                            </div>

                                            <div class="filter-track__line-vd" id="colorUnavailableActive_<?= $key ?>"
                                                style="left: 0; right: 0;"></div>
                                            <div class="filter-track__line-vn" id="colorAvailableInactive_<?= $key ?>"
                                                style="left: 0; right: 0;"></div>
                                            <div class="filter-track__line-v" id="colorAvailableActive_<?= $key ?>"
                                                style="left: 0; right: 0;"></div>
                                            <div class="filter-track__range" id="drag_tracker_<?= $key ?>"
                                                style="left: 0%; right: 0%;">
                                                <a class="filter-track__btn left" id="left_slider_<?= $key ?>"
                                                style="left: 0;"
                                                href="javascript:void(0)"></a>
                                                <a class="filter-track__btn right" id="right_slider_<?= $key ?>"
                                                style="right: 0;" href="javascript:void(0)"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <? $arJsParams = array(
                        "leftSlider" => 'left_slider_' . $key,
                        "rightSlider" => 'right_slider_' . $key,
                        "tracker" => "drag_tracker_" . $key,
                        "trackerWrap" => "drag_track_" . $key,
                        "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                        "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                        "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                        "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                        "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                        "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                        "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
                        "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                        "precision" => $precision,
                        "colorUnavailableActive" => 'colorUnavailableActive_' . $key,
                        "colorAvailableActive" => 'colorAvailableActive_' . $key,
                        "colorAvailableInactive" => 'colorAvailableInactive_' . $key,
                    ); ?>
                        <script type="text/javascript">
                            BX.ready(function () {
                                window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                            });
                        </script>
                    <? endif;
                endforeach;

                //not prices
                foreach ($arResult["ITEMS"] as $key => $arItem) :
                    if (empty($arItem["VALUES"]) || isset($arItem["PRICE"])) {
                        continue;
                    }

                    if ($arItem["DISPLAY_TYPE"] == "A"
                        && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)) {
                        continue;
                    }
                    ?>
                    <div class="new-col-12 filter__item filter-box bx-filter-parameters-box<?= $arItem["DISPLAY_EXPANDED"] == "Y" ? ' bx-active' : '' ?>">
                        <div class="bx-filter-container-modef filter__modef"></div>

                        <div class="filter-box__title" onclick="smartFilter.hideFilterProps(this)">
                            <h4 class="filter-box__title-text"><?= $arItem["NAME"] ?>
                                <?
                                if ($arItem["FILTER_HINT"] <> ""):?>
                                    <i id="item_title_hint_<?= $arItem["ID"] ?>" class="fa fa-question-circle"></i>
                                    <script type="text/javascript">
                                        new top.BX.CHint({
                                            parent: top.BX("item_title_hint_<?echo $arItem["ID"]?>"),
                                            show_timeout: 10,
                                            hide_timeout: 200,
                                            dx: 2,
                                            preventHide: true,
                                            min_width: 250,
                                            hint: '<?= CUtil::JSEscape($arItem["FILTER_HINT"])?>'
                                        });
                                    </script>
                                <? endif ?>
                            </h4>
                        </div>

                        <?
                        $arCur = current($arItem["VALUES"]);
                        switch ($arItem["DISPLAY_TYPE"]) :
                        case "A"://NUMBERS_WITH_SLIDER
                            ?>
                            <div class="filter-box__params filter-slider" data-role="bx_filter_block">

                                <div class="filter-slider__field filter-slider__field_left">
                                    <div class="filter-field">
                                        <i class="filter-field__ph"><?= GetMessage("CT_BCSF_FILTER_FROM") ?></i>
                                        <input
                                                class="min-price filter-field__input"
                                                type="text"
                                                name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                value="<?= $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                size="5"
                                                onkeyup="smartFilter.keyup(this)"
                                        />
                                    </div>
                                </div>

                                <div class="filter-slider__field filter-slider__field_right">
                                    <div class="filter-field">
                                        <i class="filter-field__ph"><?= GetMessage("CT_BCSF_FILTER_TO") ?></i>
                                        <input
                                                class="max-price filter-field__input"
                                                type="text"
                                                name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                value="<?= $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                size="5"
                                                onkeyup="smartFilter.keyup(this)"
                                        />
                                    </div>
                                </div>

                                <div class="filter-slider__slider-track">
                                    <div class="filter-track" id="drag_track_<?= $key ?>">
                                        <?
                                        $values = array();
                                        $precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
                                        $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
                                        $values[] = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
                                        $values[] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, $precision, ".", "");
                                        $values[] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, $precision, ".", "");
                                        $values[] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, $precision, ".", "");
                                        $values[] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                                        foreach ($values as $key => $value): ?>
                                            <div class="bx-ui-slider-part p<?= $key + 1 ?>"><span><?= $value ?></span></div>
                                        <? endforeach; ?>

                                        <div class="filter-track__line-vd" style="left: 0;right: 0;"
                                             id="colorUnavailableActive_<?= $key ?>"></div>
                                        <div class="filter-track__line-vn" style="left: 0;right: 0;"
                                             id="colorAvailableInactive_<?= $key ?>"></div>
                                        <div class="filter-track__line-v" style="left: 0;right: 0;"
                                             id="colorAvailableActive_<?= $key ?>"></div>
                                        <div class="filter-track__range" id="drag_tracker_<?= $key ?>" style="left: 0;right: 0;">
                                            <a class="filter-track__btn left" style="left:0;" href="javascript:void(0)"
                                               id="left_slider_<?= $key ?>"></a>
                                            <a class="filter-track__btn right" style="right:0;" href="javascript:void(0)"
                                               id="right_slider_<?= $key ?>"></a>
                                        </div>
                                    </div>
                                </div>
                                <?
                                $arJsParams = array(
                                    "leftSlider" => 'left_slider_' . $key,
                                    "rightSlider" => 'right_slider_' . $key,
                                    "tracker" => "drag_tracker_" . $key,
                                    "trackerWrap" => "drag_track_" . $key,
                                    "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                                    "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                                    "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                                    "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                                    "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                                    "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                                    "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
                                    "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                                    "precision" => $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0,
                                    "colorUnavailableActive" => 'colorUnavailableActive_' . $key,
                                    "colorAvailableActive" => 'colorAvailableActive_' . $key,
                                    "colorAvailableInactive" => 'colorAvailableInactive_' . $key,
                                );
                                ?>
                            </div>
                            <script type="text/javascript">
                                BX.ready(function () {
                                    window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                                });
                            </script>
                            <?
                            break;
                        default://CHECKBOXES
                        ?>
                            <div class="filter-box__params filter-checkbox bx-filter-block" data-role="bx_filter_block">

                                <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                                    <div class="filter-checkbox__item">
                                        <label data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                            class="filter-checkbox__label <?= $ar["DISABLED"] ? 'disabled' : '' ?>"
                                            for="<?= $ar["CONTROL_ID"] ?>">
                                            <input
                                                class="filter-checkbox__input"
                                                type="checkbox"
                                                value="<?= $ar["HTML_VALUE"] ?>"
                                                name="<?= $ar["CONTROL_NAME"] ?>"
                                                id="<?= $ar["CONTROL_ID"] ?>"
                                                <?= $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                onclick="smartFilter.click(this)"
                                            />
                                            <span class="filter-checkbox__checkbox">
                                                <span class="filter-checkbox__text" title="<?= $ar["VALUE"]; ?>"><?= $ar["VALUE"]; ?>
                                                    <? if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])): ?>
                                                        (<span data-role="count_<?= $ar["CONTROL_ID"] ?>"><?= $ar["ELEMENT_COUNT"]; ?></span>)<?
                                                    endif; ?>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                <? endforeach; ?>

                            </div>

                        <? endswitch; ?>
                    </div><!--//row-->
                <? endforeach; ?>

                <div class="new-col-12 filter__item filter__item_last">
                    <div class="new-row no-gutters">
                        <div class="new-col-5">
                            <button class="btn btn_new btn_color_gradient filter__set-btn" type="submit" id="set_filter" name="set_filter">
                                <?= GetMessage("CT_BCSF_SET_FILTER") ?>
                            </button>
                        </div>
                        <div class="new-col-5">
                            <button class="btn btn_new btn_color_transparent filter__del-btn" type="button" id="del_filter" name="del_filter">
                                <?= GetMessage("CT_BCSF_DEL_FILTER") ?>
                            </button>
                        </div>
                        <!-- new modef content block -->
                        <div class="bx-filter-popup-result <?= $arParams["FILTER_VIEW_MODE"] == "VERTICAL" ? $arParams["POPUP_POSITION"] : '' ?>"
                             id="modef" style="display: <?= !isset($arResult["ELEMENT_COUNT"]) ? 'none' : 'inline-block' ?>">
                            <a href="<?= $arResult["FILTER_URL"] ?>" target="">
                                <span></span>
                                <span>Показать</span>
                                <span id="modef_num"><?= (int)$arResult["ELEMENT_COUNT"] ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<script type="text/javascript">
    var smartFilter = new JCSmartFilter('<?= CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>