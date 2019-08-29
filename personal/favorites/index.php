<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранные товары");

global $SORT;
global $ORDER;

$SORT = $_GET['sort'] ?? 'created';
$ORDER = $_GET['order'] ?? 'desc';

?><?$APPLICATION->IncludeComponent(
	"h2o:favorites.list",
	"grechka",
	Array(
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"BASKET_URL" => "/personal/cart/",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DATE_FORMAT" => "d.m.Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"ELEMENT_SORT_FIELD" => $SORT,
		"ELEMENT_SORT_FIELD2" => "timestamp_x",
		"ELEMENT_SORT_ORDER" => $ORDER,
		"ELEMENT_SORT_ORDER2" => "desc",
		"FAVORITES_COUNT" => "20",
		"FILTER_NAME" => "",
		"IBLOCK_ID" => "21",
		"IBLOCK_TYPE" => "catalog",
		"NAV_TEMPLATE" => "catalog",
		"OFFERS_CART_PROPERTIES" => array(),
		"OFFERS_FIELD_CODE" => array("",""),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array("",""),
		"PRICE_CODE" => array("Розничная руб."),
		"PRODUCT_PROPERTIES" => array(),
		"PROPERTY_CODE" => array("",""),
		"SET_TITLE" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"SORT_BY" => "DATE_INSERT",
		"SORT_ORDER" => "DESC"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>