<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Page\Asset;
$APPLICATION->SetPageProperty("description", "Контактные данный торгового комплекса \"Вечная стройка\", отделы закупом и продаж. Менеджеры компании");
$APPLICATION->SetPageProperty("keywords", "Контакты Вечная стройка");
$APPLICATION->SetPageProperty("title", "Контакты \"Вечная стройка\" - стройматериалы в Крыму");
Asset::getInstance()->addJs('https://api-maps.yandex.ru/2.1/?lang=ru_RU');
$APPLICATION->SetTitle("Контакты \"Вечная стройка\" - стройматериалы в Крыму");
?>
    <section class="page-all-sect page-all-sect_pb_none page-cnt-contacts__map">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="page-all-sect__top-title">
                        <h2>Контакты</h2>
                    </div>
                </div>
            </div>
            <div class="row">

                    <?$APPLICATION->IncludeComponent(
                        "mix8872:news.list.category",
                        "contacts",
                        Array(
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "IBLOCK_ID" => "18",
                            "IBLOCK_TYPE" => "simple",
//                            "ID" => $_REQUEST["ID"],
                            "SECTION_URL" => ""
                        )
                    );?>


                <!--<div class="col-lg-6">
                    <?/* $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "map_inc.php"
                        )
                    ); */?>
                </div>-->
            </div>
        </div>
    </section>
<? $APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "shops",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "N",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array("", ""),
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "20",
        "IBLOCK_TYPE" => "simple",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "Y",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "200",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array("CITY", "COORDINATES", "ADDRESS", "PHONE", "FAX", "WORKTIME", "HOLIDAYS", ""),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "SORT",
        "SORT_BY2" => "ID",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "DESC"
    )
); ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>