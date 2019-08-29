<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/about.css');
$APPLICATION->SetTitle("О компании");
?>
    <section class="page-all-sect page-company">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="page-all-sect__top-title">
                        <h2>О Компании</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="page-company__content b-content">
                        <blockquote>
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "text_inc.php"
                                )
                            ); ?>
                        </blockquote>
                    </div>
                </div>
                <div class="col-sm-6 offset-sm-3 col-lg-4 offset-lg-0">
                    <div class="page-company__year">
                        <div class="card-company-year">
                            <div class="card-company-year__left">
                                <span><? $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        Array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => "year_count_inc.php"
                                        )
                                    ); ?></span>
                                <span>Лет</span>
                            </div>
                            <div class="card-company-year__right">
                                <span>
                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        Array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => "year_text_inc.php"
                                        )
                                    ); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="page-company__principles our-principles">
        <? $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "principles",
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
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("", ""),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "23",
                "IBLOCK_TYPE" => "simple",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MAIN_URL" => "/news",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "5",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Покупайте правильно",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("", "IMAGE2", ""),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "ID",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "ASC"
            )
        ); ?>
    </section>
    <section class="page-all-sect page-company">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-company__content b-content">
                        <? $APPLICATION->IncludeComponent(
                           "bitrix:main.include",
                           "",
                           Array(
                              "AREA_FILE_SHOW" => "file",
                              "PATH" => "text_inc_bottom.php"
                           )
                           ); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>	
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>