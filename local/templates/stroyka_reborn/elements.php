<? $APPLICATION->IncludeComponent(
    "bitrix:search.form",
    "",
    Array(
        "PAGE" => "#SITE_DIR#search/index.php",
        "USE_SUGGEST" => "Y"
    )
); ?>

<? $APPLICATION->IncludeComponent(
    "bitrix:menu",
    "simple_horizontal",
    array(
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "left",
        "DELAY" => "N",
        "MAX_LEVEL" => "1",
        "MENU_CACHE_GET_VARS" => [],
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_THEME" => "site",
        "ROOT_MENU_TYPE" => "top",
        "USE_EXT" => "N",
        "COMPONENT_TEMPLATE" => "simple_horizontal"
    ),
    false
); ?>

<? $APPLICATION->IncludeComponent(
    "bitrix:menu",
    "simple_multilevel",
    array(
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "podmenu",
        "DELAY" => "N",
        "MAX_LEVEL" => "2",
        "MENU_CACHE_GET_VARS" => [],
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_THEME" => "site",
        "ROOT_MENU_TYPE" => "catalog",
        "USE_EXT" => "Y",
        "COMPONENT_TEMPLATE" => "simple_multilevel"
    ),
    false
); ?>

<? if ($APPLICATION->GetCurPage(false) !== '/') {
    $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        "stroyka",
        array(
            "PATH" => "",
            "SITE_ID" => "s1",
            "START_FROM" => "0",
            "COMPONENT_TEMPLATE" => "stroyka"
        ),
        false
    );
}
?>

<?$APPLICATION->IncludeComponent(
    "asd:subscribe.quick.form",
    "stroyka",
    Array(
        "FORMAT" => "html",
        "INC_JQUERY" => "Y",
        "NOT_CONFIRM" => "Y",
        "RUBRICS" => array("1"),
        "SHOW_RUBRICS" => "N"
    )
);?>

<?$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "simple_vertical",
    Array(
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "left",
        "DELAY" => "N",
        "MAX_LEVEL" => "1",
        "MENU_CACHE_GET_VARS" => array(""),
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_THEME" => "site",
        "ROOT_MENU_TYPE" => "bottom1",
        "USE_EXT" => "N"
    )
);?>

<?$APPLICATION->IncludeComponent(
    "bitrix:sale.bestsellers",
    "",
    Array(
        "ACTION_VARIABLE" => "action",
        "ADDITIONAL_PICT_PROP_21" => "MORE_PHOTO",
        "ADDITIONAL_PICT_PROP_22" => "MORE_PHOTO",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BASKET_URL" => "/personal/basket.php",
        "BY" => "AMOUNT",
        "CACHE_TIME" => "86400",
        "CACHE_TYPE" => "A",
        "CART_PROPERTIES_21" => array(""),
        "CART_PROPERTIES_22" => array("",""),
        "CONVERT_CURRENCY" => "N",
        "DETAIL_URL" => "",
        "DISPLAY_COMPARE" => "N",
        "FILTER" => array(),
        "HIDE_NOT_AVAILABLE" => "Y",
        "LABEL_PROP_21" => "-",
        "LINE_ELEMENT_COUNT" => "3",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_BTN_SUBSCRIBE" => "Подписаться",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "OFFER_TREE_PROPS_22" => array(),
        "PAGE_ELEMENT_COUNT" => "30",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PERIOD" => "0",
        "PRICE_CODE" => array("Розничная руб."),
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "PRODUCT_SUBSCRIPTION" => "N",
        "PROPERTY_CODE_21" => array(""),
        "PROPERTY_CODE_22" => array("",""),
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_IMAGE" => "Y",
        "SHOW_NAME" => "Y",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "SHOW_PRODUCTS_21" => "Y",
        "TEMPLATE_THEME" => "blue",
        "USE_PRODUCT_QUANTITY" => "N"
    )
);?>