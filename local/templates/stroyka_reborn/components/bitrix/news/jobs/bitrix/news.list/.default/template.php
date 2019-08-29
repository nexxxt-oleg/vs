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
<div class="row">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <div class="col-12">
            <div class="page-careers__card card-careers">
                <div class="card-careers__top">
                    <a hre="#" class="card-careers__title h3"><?= $arItem['NAME'] ?></a>
                    <div class="card-careers__price">
                        <span><?= $arItem['DISPLAY_PROPERTIES']['CASH']['VALUE'] ?></span>
                    </div>
                </div>
                <div class="card-careers__desc b-content">
                    <?= $arItem['PREVIEW_TEXT'] ?>
                </div>
                <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="card-careers__more btn btn_arrow_right btn_right">
                    <span>Подробнее</span>
                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-right-sm.svg") ?>" class="img-svg">
                </a>
            </div>
        </div>
    <? endforeach; ?>
</div>
<? if (strlen($arResult["NAV_STRING"]) > 0): ?><?= $arResult["NAV_STRING"] ?><? endif ?>
