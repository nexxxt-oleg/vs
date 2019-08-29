<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
<div class="new-container">
    <div class="new-row">
        <div class="new-col-lg-12">
            <? if (!empty($arResult["ITEMS"])): ?>
                <div class="news-slider__slick">
                    <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
                        <div class="news-slider__item">
                            <a href="<?= $arItem["DISPLAY_PROPERTIES"]["LINK"]["~VALUE"] ?>" class="news-slider__link">
                                <img
                                        class="news-slider__img"
                                        src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                        alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                        title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                                >
                            </a>
                        </div>
                    <? endforeach; ?>
                </div>
                <button class="news-slider__prev slider-arrow-prev">
                    <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/arrow-left.svg') ?>" class="img-svg">
                </button>
                <button class="news-slider__next slider-arrow-next">
                    <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/arrow-right.svg') ?>" class="img-svg">
                </button>
                <div class="news-slider__dots">
                    <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
                        <button data-id="<?= $key + 1 ?>"<?= $key == 0 ? ' class="active"' : '' ?>><?= $key + 1 ?></button>
                    <? endforeach; ?>
                </div>
            <? endif; ?>
        </div>
    </div>
</div>

