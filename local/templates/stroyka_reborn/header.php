<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;

$tel = \Bitrix\Main\Config\Option::get('grain.customsettings', 'tel_header');
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta property="og:image" content="path/to/image.jpg">
    <link rel="shortcut icon" href="img/favicon/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="<?= $APPLICATION->GetTemplatePath('img/favicon/apple-touch-icon.png') ?>">
    <link rel="apple-touch-icon" sizes="72x72"
          href="<?= $APPLICATION->GetTemplatePath('img/favicon/apple-touch-icon-72x72.png') ?>">
    <link rel="apple-touch-icon" sizes="114x114"
          href="<?= $APPLICATION->GetTemplatePath('img/favicon/apple-touch-icon-114x114.png') ?>">
    <link rel="icon" href="/favicon.png" type="image/png">
    <title><?php $APPLICATION->ShowTitle() ?></title>
    <?
    $isHomePage = $APPLICATION->GetCurPage(false) === '/';
    $isCatalogSection = preg_match('/\/catalog\/(.+)?/ui', $APPLICATION->GetCurPage(false));
    $isSearchPage = preg_match('/\/(novelty|markdown|sale|popular)\//ui', $APPLICATION->GetCurPage(false));

    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/new-bootstrap.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/bootstrap.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/slick.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/slick-theme.css');
    //    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/main.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/new-main.css');
    $APPLICATION->ShowHead();
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery-3.2.1.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.smoothscroll.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/slick.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/switchPopup.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/common-new.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/header-search.js');
    if ($isHomePage || $isCatalogSection) {
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/page-home.js');
    }
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . 'js/new-catalog.js');

    $instagram = COption::GetOptionString("grain.customsettings", "insta");
    $vk = COption::GetOptionString("grain.customsettings", "vk");
    $fb = COption::GetOptionString("grain.customsettings", "fb");
    $ok = COption::GetOptionString("grain.customsettings", "ok");

    switch (true) {
        case $isHomePage:
            $pageMainClass = 'page-home';
            break;
        case $isSearchPage:
            $pageMainClass = 'p-search-result';
            break;
        default:
            $pageMainClass = '';
    }
    ?>
</head>
<body>
<div class="root">
    <? $APPLICATION->IncludeComponent(
        "h2o:favorites.add",
        "",
        Array()
    );
    ?>
    <? $APPLICATION->ShowPanel(); ?>
    <header class="header">
        <div class="header__top">
            <div class="new-container">
                <div class="new-row">
                    <div class="new-col-sm-8 new-col-md-7 new-col-lg-5">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "simple-new",
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
                                "COMPONENT_TEMPLATE" => "simple",
                                "MENU_CLASS" => "header__link"
                            ),
                            false
                        ); ?>

                    </div>
                    <div class="new-col-sm-4 new-col-md-5 new-offset-lg-2 new-col-lg-5">
                        <div class="header__contacts">
                            <a href="tel:<?= preg_replace('/[^\d+]+/u', '', $tel) ?>"
                               class="header__phone"><?= $tel ?></a>
                            <div class="header__login">
                                <? $profileLink = ''; ?>
                                <? if (isset($USER) && $USER->IsAuthorized()): ?>
                                    <? $profileLink = "/personal/"; ?>
                                    <a href="?logout=yes&backurl=<?= $currentUrl ?>">Выйти</a>
                                    <a href="/personal/">Личный кабинет</a>
                                <? else: ?>
                                    <? $profileLink = "/login?login=yes&backurl="; ?>
                                    <? $currentUrl = urlencode($APPLICATION->GetCurPageParam("", [
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
                                    ])); ?>
                                    <a href="/login?login=yes&backurl=<?= $currentUrl ?>">Вход</a>
                                    <a href="/login?register=yes&backurl=<?= $currentUrl ?>">Регистрация</a>
                                <? endif; ?>
                                <img src="<?= $APPLICATION->GetTemplatePath('img/header/user.svg') ?>" alt="">
                                <a href="<?= $profileLink ?>">
                                    <img src="<?= $APPLICATION->GetTemplatePath('img/header/user.svg') ?>" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__middle">
            <div class="new-container">
                <div class="new-row">
                    <div class="new-col-6 new-col-sm-3 new-col-lg-2">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/logo_inc.php"
                            )
                        ); ?>
                    </div>
                    <div class="new-col-6 new-col-sm-3 new-col-lg-2 header__middle_xs">
                        <div class="header__btn-catalog">
                            <button class="header__burger btn-burger btn js-btn-burger close">
                                <div class="btn-burger__icon">
                                    <span></span>
                                </div>
                                <span class="btn-burger__desc">Каталог</span>
                            </button>
                        </div>
                    </div>
                    <div class="js-new-col-search new-col-6 new-col-sm-3 new-col-lg-5 header__middle_xs">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:search.title",
                            "grechka-search-new",
                            Array(
                                "CATEGORY_0" => array("iblock_catalog"),
                                "CATEGORY_0_TITLE" => "",
                                "CATEGORY_0_iblock_catalog" => array("21"),
                                "CATEGORY_0_iblock_simple" => array("all"),
                                "CHECK_DATES" => "N",
                                "CONTAINER_ID" => "title-search",
                                "INPUT_ID" => "title-search-input",
                                "NUM_CATEGORIES" => "1",
                                "ORDER" => "rank",
                                "PAGE" => "#SITE_DIR#search/index.php",
                                "SHOW_INPUT" => "Y",
                                "SHOW_OTHERS" => "N",
                                "TOP_COUNT" => "5",
                                "USE_LANGUAGE_GUESS" => "Y"
                            )
                        ); ?>
                    </div>
                    <div class="new-col-6 new-col-sm-3 new-col-lg-3 header__middle_xs">
                        <div class="header__btns header-btns">
                            <? $APPLICATION->IncludeComponent(
                                "h2o:favorites.line",
                                "",
                                Array(
                                    "CACHE_TIME" => "36000000",
                                    "CACHE_TYPE" => "A",
                                    "URL_LIST" => "/personal/favorites"
                                )
                            ); ?>
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:sale.basket.basket.line",
                                "new-basket-line",
                                array(
                                    "HIDE_ON_BASKET_PAGES" => "N",
                                    "PATH_TO_AUTHORIZE" => "",
                                    "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
                                    "PATH_TO_ORDER" => SITE_DIR . "personal/order/make/",
                                    "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                                    "PATH_TO_PROFILE" => SITE_DIR . "personal/",
                                    "PATH_TO_REGISTER" => SITE_DIR . "login/",
                                    "POSITION_FIXED" => "N",
                                    "POSITION_HORIZONTAL" => "right",
                                    "POSITION_VERTICAL" => "top",
                                    "SHOW_AUTHOR" => "N",
                                    "SHOW_DELAY" => "N",
                                    "SHOW_EMPTY_VALUES" => "Y",
                                    "SHOW_IMAGE" => "Y",
                                    "SHOW_NOTAVAIL" => "Y",
                                    "SHOW_NUM_PRODUCTS" => "Y",
                                    "SHOW_PERSONAL_LINK" => "N",
                                    "SHOW_PRICE" => "Y",
                                    "SHOW_PRODUCTS" => "N",
                                    "SHOW_SUMMARY" => "Y",
                                    "SHOW_TOTAL_PRICE" => "Y",
                                    "COMPONENT_TEMPLATE" => ".default",
                                    "SHOW_REGISTRATION" => "Y"
                                ),
                                false
                            ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <? $APPLICATION->IncludeComponent(
            "mix8872:catalog.menu",
            "grechka-new-catalog",
            Array(
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_ID#",
                "IBLOCK_ID" => "21",
                "IBLOCK_TYPE" => "catalog",
//                                                "ID" => $_REQUEST["ID"],
                "SECTION_PAGE_URL" => "#SECTION_CODE#/",
                "SECTION_URL" => "",
            )
        ); ?>
    </header>
    <main class="main <?= $pageMainClass ?>">
    <? if (!$isHomePage){ ?>
            <? $APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "",
                array(
                    "PATH" => "",
                    "SITE_ID" => "s1",
                    "START_FROM" => "0",
                    "COMPONENT_TEMPLATE" => "stroyka"
                ),
                false
            );

            if (!function_exists('headerContentBlock')) {
                function headerContentBlock()
                {
                    global $APPLICATION;
                    $isContent = $APPLICATION->GetPageProperty('is_content');
                    $isSocial = $APPLICATION->GetPageProperty('is_social');
                    $APPLICATION->isContentPage = $isContent;
                    if ($isContent === 'Y') {
                        $title = $isContent = $APPLICATION->GetPageProperty('title');
                        $result = '<section class="page-all-sect">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="page-all-sect__top-title">
                                            <h2>' . $title . '</h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">';
                        $socialBtn = $isSocial == "Y" ? '
                                        <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                                        <script src="//yastatic.net/share2/share.js"></script>
                                        <div class="page-all-sect__top-share card-share">
                                            <span>Поделиться</span>
                                            <div class="card-share__icons ya-share2" data-services="vkontakte,facebook" data-size="s"></div>
                                        </div>' : '';

                        $res2 = '</div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="b-content">';
                        $result .= $socialBtn . $res2;
                        return $result;
                    }
                }
            }
            $APPLICATION->AddBufferContent('headerContentBlock');
            }
            ?>
