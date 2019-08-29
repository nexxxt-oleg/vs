<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
$APPLICATION->AddChainItem($arResult["NAME"]);
?>


<section class="current-service">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title"><?=$arResult["NAME"]?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <a href="#" class="services-ul-el">
                    <img src="<?= $arResult['PREVIEW_PICTURE']['SRC'] ?>" alt="" class="services-ul-el-img">
                    <h4 class="services-ul-el-title"><?=$arResult["NAME"]?></h4>
                    <p class="services-ul-el-descr"><?= $arResult["PREVIEW_TEXT"] ?></p>
                </a>
                <?$GLOBALS['arrFilter'] = array("!ID" => $arResult["ID"]);
                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "service",
                    Array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "N",
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
                        "FIELD_CODE" => array("",""),
                        "FILTER_NAME" => "arrFilter",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => "19",
                        "IBLOCK_TYPE" => "simple",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "N",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "",
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
                        "PROPERTY_CODE" => array("",""),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "Y",
                        "SET_META_KEYWORDS" => "Y",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "ID",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "DESC",
                        "SORT_ORDER2" => "ASC"
                    )
                );?>
            </div>
            <div class="col-md-9">
                <div class="service-text">
                    <?if($arResult["PROPERTIES"]['ALERT'] && !empty($arResult["PROPERTIES"]['ALERT']['VALUE'])){?>
                        <blockquote><?=$arResult["PROPERTIES"]['ALERT']['VALUE']['TEXT']?></blockquote>
                    <?}?>
                    <p>
                        <?if(strlen($arResult["DETAIL_TEXT"])>0):?>
                            <?echo $arResult["DETAIL_TEXT"];?>
                        <?else:?>
                            <?echo $arResult["PREVIEW_TEXT"];?>
                        <?endif?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
    </div>
</section>