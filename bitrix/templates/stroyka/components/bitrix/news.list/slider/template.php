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
<section class="main-slider">
    <div class="main-slider-wrapper">
        <?foreach($arResult["ITEMS"] as $key=>$arItem):?>
            <div class="slick-slide">
                <a href="<?=$arItem["DISPLAY_PROPERTIES"]["LINK"]["~VALUE"]?>">
                    <img
                        src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                        alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                        title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                    >
                </a>
            </div>
        <? endforeach; ?>
    </div>
    <div class="main-slider-control-dots">
        <div class="container">
            <div class="row">
                <div class="col-md-12"></div>
            </div>
        </div>
    </div>
    <div class="main-slider-control">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-slider-control-btn main-slider-control-btn-left"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
                    <div class="main-slider-control-btn main-slider-control-btn-right"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                </div>
            </div>
        </div>
    </div>
</section>