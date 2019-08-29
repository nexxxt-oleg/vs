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
        <div class="new-col-12">
            <div class="page-home__block-title">
                <span class="page-home__slider-title h2-new"><?= $arResult['NAME'] ?></span>
            </div>
            <div class="partners-slider">
                <button class="partners-slider__prev sale-slider__prev slider-arrow-prev">
                    <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/arrow-left.svg') ?>" class="img-svg">
                </button>
                <button class="partners-slider__next sale-slider__next slider-arrow-next">
                    <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/arrow-right.svg') ?>" class="img-svg">
                </button>
                <div class="partners-slider__slick">
                    <? foreach ($arResult['ITEMS'] as $arItem): ?>
                        <div class="partners-slider__item">
                            <div class="card-partner">
                                <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                     alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>">
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>