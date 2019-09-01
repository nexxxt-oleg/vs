<div id="addres_delivery" class="ordering-form__wrap js-way2-block">
    <div class="bx-soa-section-title-container">
        <h2 class="bx-soa-section-title">Адрес доставки</h2>
    </div>
    <div class="bx-soa-section-content">
<?php

if (is_array($arResult["ORDER_PROP"]["USER_PROPS_Y"])) {
    foreach ($arResult["ORDER_PROP"]["USER_PROPS_Y"] as $k => $arProperties) {
        if ($arProperties["TYPE"] == "LOCATION") {
            ?>
            <div class="bx-ui-slst-pool">

                <?
                $value = 0;
                if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
                {
                    foreach ($arProperties["VARIANTS"] as $arVariant)
                    {
                        if ($arVariant["SELECTED"] == "Y")
                        {
                            $value = $arVariant["ID"];
                            break;
                        }
                    }
                }

                // here we can get '' or 'popup'
                // map them, if needed
                if(CSaleLocation::isLocationProMigrated())
                {
                    $locationTemplateP = $locationTemplate == 'popup' ? 'search' : 'steps';
                    $locationTemplateP = $_REQUEST['PERMANENT_MODE_STEPS'] == 1 ? 'steps' : $locationTemplateP; // force to "steps"
                }
                ?>

                <?if($locationTemplateP == 'steps'):?>
                    <input type="hidden" id="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" name="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" value="<?=($_REQUEST['LOCATION_ALT_PROP_DISPLAY_MANUAL'][intval($arProperties["ID"])] ? '1' : '0')?>" />
                <?endif?>

                <?CSaleLocation::proxySaleAjaxLocationsComponent(array(
                    "AJAX_CALL" => "N",
                    "COUNTRY_INPUT_NAME" => "COUNTRY",
                    "REGION_INPUT_NAME" => "REGION",
                    "CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
                    "CITY_OUT_LOCATION" => "N",
                    "LOCATION_VALUE" => $value,
                    "ORDER_PROPS_ID" => $arProperties["ID"],
                    "ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
                    "SIZE1" => $arProperties["SIZE1"],
                ),
                    array(
                        "ID" => $value,
                        "CODE" => "",
                        "SHOW_DEFAULT_LOCATIONS" => "Y",

                        // function called on each location change caused by user or by program
                        // it may be replaced with global component dispatch mechanism coming soon
                        "JS_CALLBACK" => "submitFormProxy",

                        // function window.BX.locationsDeferred['X'] will be created and lately called on each form re-draw.
                        // it may be removed when sale.order.ajax will use real ajax form posting with BX.ProcessHTML() and other stuff instead of just simple iframe transfer
                        "JS_CONTROL_DEFERRED_INIT" => intval($arProperties["ID"]),

                        // an instance of this control will be placed to window.BX.locationSelectors['X'] and lately will be available from everywhere
                        // it may be replaced with global component dispatch mechanism coming soon
                        "JS_CONTROL_GLOBAL_ID" => intval($arProperties["ID"]),

                        "DISABLE_KEYBOARD_INPUT" => "Y",
                        "PRECACHE_LAST_LEVEL" => "Y",
                        "PRESELECT_TREE_TRUNK" => "Y",
                        "SUPPRESS_ERRORS" => "Y"
                    ),
                    $locationTemplateP,
                    true,
                    'location-block-wrapper'
                )?>

                <?
                if (strlen(trim($arProperties["DESCRIPTION"])) > 0):
                    ?>
                    <div class="bx_description">
                        <?=$arProperties["DESCRIPTION"]?>
                    </div>
                    <?
                endif;
                ?>

            </div>

            <?
            unset($arResult["ORDER_PROP"]["USER_PROPS_Y"][$k]);
        }
    }
}


//echo '<pre>';
//var_dump($arResult["ORDER_PROP"]["RELATED"]);
//echo '</pre>';
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");
?>
    </div>
</div>