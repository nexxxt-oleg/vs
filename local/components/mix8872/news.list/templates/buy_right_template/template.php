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
?>
<section class="main-news">
    <div class="container section-title">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8"><h1>Новости и статьи</h1></div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-right"><a class="intopath" href="/news">В РАЗДЕЛ <i class="fa fa-angle-right" aria-hidden="true"></i></a></div>
        </div>
    </div>
    <div class="container">
        <div class="row main-news-wrapper">
            <?foreach($arResult["ITEMS"] as $key=>$arItem):?>
            <div class="col-md-3 col-sm-4">
                <a href="<?= $arItem["DETAIL_PAGE_URL"]?>">
                <div class="news">
                    <div class="news-img">
                        <img
                                class="statia-block-img"
                                src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                                alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                        >
                    </div>
                    <div class="news-title"><?echo $arItem["NAME"]?></div>
                    <div class="news-bottom">
                        <div class="news-date"><?= date("d.m.Y", strtotime($arItem["TIMESTAMP_X"])) ?></div>
                        <a href="<?= $arItem["DETAIL_PAGE_URL"]?>" class="podrobno">Подробно <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
                </a>
            </div>
            <? endforeach; ?>
        </div>
    </div>
</section>