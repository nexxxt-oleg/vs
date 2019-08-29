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
        <div class="col-8">
            <div class="page-all-sect__top-title">
                <h2><?= $arResult['NAME'] ?></h2>
            </div>
        </div>
    </div>
    <div class="row">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <div class="page-services__card col-sm-4 col-lg-3">
                <? if ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] === 'Y' && empty($arItem['DETAIL_TEXT'])): ?>
                    <span class="card-services">
                        <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>"
                             class="img-svg card-services__img">
                        <h3 class="card-services__title"><?= $arItem['NAME'] ?></h3>
                        <p class="card-services__desc"><?= $arItem['PREVIEW_TEXT'] ?></p>
                    </span>
                <? else: ?>
                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="card-services">
                        <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>"
                             class="img-svg card-services__img">
                        <h3 class="card-services__title"><?= $arItem['NAME'] ?></h3>
                        <p class="card-services__desc"><?= $arItem['PREVIEW_TEXT'] ?></p>
                    </a>
                <? endif; ?>
            </div>
        <? endforeach; ?>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="page-services__content b-content">
                <blockquote>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "attention_inc.php"
                        )
                    ); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
