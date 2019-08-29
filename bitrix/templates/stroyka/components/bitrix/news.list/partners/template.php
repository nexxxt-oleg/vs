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
$opened = false;
?>

<section class="main-partners">
    <div class="container section-title">
        <div class="row">
            <div class="col-md-12"><h1>Наши поставщики и партнеры</h1></div>
        </div>
    </div>
    <div class="container partners-slider">
        <div class="row">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            <div class="partners-slider-wrapper">
                <? foreach ($arResult["ITEMS"] as $i => $arItem): ?>
                    <?= $i % 2 == 0 ? '<div class="col-md-2 col-sm-2">' : '' ?>
                    <a href="#">
                        <img class="partners-slids-img" border="0"
                             src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                             alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                             title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                        />
                    </a>
                    <?= $i > 0 && $i % 2 == 1 ? '</div>' : '' ?>
                <? endforeach; ?>
            </div>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </div>
    </div>
</section>