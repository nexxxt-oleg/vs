<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?><?
$APPLICATION->IncludeComponent(
	"mix8872:sale.order.ajax", 
	"order", 
	array(
		"COMPONENT_TEMPLATE" => "order",
		"PAY_FROM_ACCOUNT" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"COUNT_DELIVERY_TAX" => "N",
		"ALLOW_AUTO_REGISTER" => "Y",
		"SEND_NEW_USER_NOTIFY" => "N",
		"DELIVERY_NO_AJAX" => "N",
		"DELIVERY_NO_SESSION" => "N",
		"TEMPLATE_LOCATION" => "popup",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"USE_PREPAYMENT" => "N",
		"PROP_1" => array(
		),
		"PROP_2" => array(
		),
		"ALLOW_NEW_PROFILE" => "N",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "N",
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_PERSONAL" => "/personal/",
		"PATH_TO_PAYMENT" => "payment.php",
		"PATH_TO_AUTH" => "/auth/",
		"SET_TITLE" => "Y",
		"DISABLE_BASKET_REDIRECT" => "Y",
		"PRODUCT_COLUMNS" => array(
			0 => "WEIGHT_FORMATED",
		)
	),
	false
);

/*$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax",
	"grechka",
	Array(
		"ACTION_VARIABLE" => "soa-action",
		"ADDITIONAL_PICT_PROP_21" => "-",
		"ADDITIONAL_PICT_PROP_22" => "-",
		"ALLOW_APPEND_ORDER" => "Y",
		"ALLOW_AUTO_REGISTER" => "Y",
		"ALLOW_NEW_PROFILE" => "N",
		"ALLOW_USER_PROFILES" => "N",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"BASKET_POSITION" => "before",
		"COMPATIBLE_MODE" => "N",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"DELIVERIES_PER_PAGE" => "9",
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",
		"DELIVERY_NO_AJAX" => "N",
		"DELIVERY_NO_SESSION" => "Y",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"DISABLE_BASKET_REDIRECT" => "N",
		"EMPTY_BASKET_HINT_PATH" => "/",
		"MESS_AUTH_BLOCK_NAME" => "Авторизация",
		"MESS_BACK" => "Назад",
		"MESS_BASKET_BLOCK_NAME" => "Товары в заказе",
		"MESS_BUYER_BLOCK_NAME" => "Покупатель",
		"MESS_DELIVERY_BLOCK_NAME" => "Доставка",
		"MESS_EDIT" => "изменить",
		"MESS_FURTHER" => "Далее",
		"MESS_NAV_BACK" => "Назад",
		"MESS_NAV_FORWARD" => "Вперед",
		"MESS_ORDER" => "Оформить заказ",
		"MESS_PAYMENT_BLOCK_NAME" => "Оплата",
		"MESS_PERIOD" => "Срок доставки",
		"MESS_PRICE" => "Стоимость",
		"MESS_REGION_BLOCK_NAME" => "Ваш регион",
		"MESS_REG_BLOCK_NAME" => "Регистрация",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"PATH_TO_AUTH" => "/auth/",
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_ORDER" => "/personal/order/make/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PATH_TO_PERSONAL" => "/personal/order/",
		"PAY_FROM_ACCOUNT" => "Y",
		"PAY_SYSTEMS_PER_PAGE" => "9",
		"PICKUPS_PER_PAGE" => "5",
		"PICKUP_MAP_TYPE" => "yandex",
		"PRODUCT_COLUMNS_HIDDEN" => array("PRICE_FORMATED","PROPERTY_CML2_ARTICLE"),
		"PRODUCT_COLUMNS_VISIBLE" => array("PREVIEW_PICTURE","PROPS","PRICE_FORMATED","PROPERTY_CML2_ARTICLE"),
		"PROPS_FADE_LIST_1" => array(),
		"PROPS_FADE_LIST_2" => "",
		"PROP_1" => "",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"SERVICES_IMAGES_SCALING" => "adaptive",
		"SET_TITLE" => "Y",
		"SHOW_ACCOUNT_NUMBER" => "Y",
		"SHOW_BASKET_HEADERS" => "N",
		"SHOW_COUPONS_BASKET" => "N",
		"SHOW_COUPONS_DELIVERY" => "N",
		"SHOW_COUPONS_PAY_SYSTEM" => "N",
		"SHOW_DELIVERY_INFO_NAME" => "Y",
		"SHOW_DELIVERY_LIST_NAMES" => "Y",
		"SHOW_DELIVERY_PARENT_NAMES" => "N",
		"SHOW_MAP_IN_PROPS" => "N",
		"SHOW_NEAREST_PICKUP" => "N",
		"SHOW_NOT_CALCULATED_DELIVERIES" => "L",
		"SHOW_ORDER_BUTTON" => "final_step",
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
		"SHOW_PICKUP_MAP" => "Y",
		"SHOW_STORES_IMAGES" => "Y",
		"SHOW_TOTAL_ORDER_BUTTON" => "N",
		"SHOW_VAT_PRICE" => "Y",
		"SKIP_USELESS_BLOCK" => "Y",
		"SPOT_LOCATION_BY_GEOIP" => "Y",
		"TEMPLATE_LOCATION" => ".default",
		"TEMPLATE_THEME" => "blue",
		"USER_CONSENT" => "N",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
		"USE_CUSTOM_ERROR_MESSAGES" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "Y",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_PHONE_NORMALIZATION" => "Y",
		"USE_PRELOAD" => "Y",
		"USE_PREPAYMENT" => "N",
		"USE_YM_GOALS" => "N"
	)
);*/?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>