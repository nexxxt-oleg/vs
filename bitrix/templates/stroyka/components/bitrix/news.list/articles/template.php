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
        <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
        <? $date = new DateTime($arItem['TIMESTAMP_X']); ?>
            <div class="col-md-3 col-sm-6">
                <div class="can-be-interest-el">
                    <div class="can-be-interest-el-img">
                        <img
                                src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                        >
                    </div>
                    <h2 class="can-be-interest-el-title"><? echo $arItem["NAME"] ?></h2>
                    <div class="can-be-interest-el-bottom">
                        <div class="can-be-interest-date"><?= $date->format("d.m.Y") ?></div>
                        <a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>" class="podrobno">Подробно <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

        <?= $key > 0 && $key%4 == 0 ? '</div><div class="row">' : '' ?>
        <? endforeach; ?>
    </div>
</div>