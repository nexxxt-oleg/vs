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
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="our-principles__title"><?= $arResult['NAME'] ?></h2>
        </div>
    </div>
    <div class="our-principles__items">
        <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
            <div class="our-principles__item">
                <div class="principles-item">
                    <span class="principles-item__number"><?= $key + 1 ?></span>
                    <h3 class="principles-item__desc"><?= $arItem['NAME'] ?></h3>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>