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

if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
?>

<div class="paginations top-navs__paginations">
    <? if ($arResult["bDescPageNumbering"] === true): ?>

        <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
            <? if ($arResult["bSavePage"]): ?>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>">
                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-left.svg") ?>" class="img-svg">
                </a>
            <? else: ?>
                <? if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"] + 1)): ?>
                    <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-left.svg") ?>" class="img-svg">
                    </a>
                <? else: ?>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>">
                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-left.svg") ?>" class="img-svg">
                    </a>
                <? endif ?>
            <? endif ?>
        <? endif ?>

        <? while ($arResult["nStartPage"] >= $arResult["nEndPage"]): ?>
            <? $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1; ?>

            <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
                <span><b><?= $NavRecordGroupPrint ?></b></span>
            <? elseif ($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false): ?>
                <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= $NavRecordGroupPrint ?></a>
            <? else: ?>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"><?= $NavRecordGroupPrint ?></a>
            <? endif ?>
            <? $arResult["nStartPage"]-- ?>
        <? endwhile ?>
        <? if ($arResult["NavPageNomer"] > 1): ?>
            <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>">
                <span><img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-right.svg") ?>" class="img-svg"></span>
            </a>
        <? endif ?>

    <? else: ?>
        <? if ($arResult["NavPageNomer"] > 1): ?>
            <? if ($arResult["bSavePage"]): ?>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>">
                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-left.svg") ?>" class="img-svg">
                </a>
            <? else: ?>
                <? if ($arResult["NavPageNomer"] > 2): ?>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>">
                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-left.svg") ?>" class="img-svg">
                    </a>
                <? else: ?>
                    <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-left.svg") ?>" class="img-svg">
                    </a>
                <? endif ?>
            <? endif ?>
        <? endif ?>
        <? while ($arResult["nStartPage"] <= $arResult["nEndPage"]): ?>

            <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
                <span><b><?= $arResult["nStartPage"] ?></b></span>
            <? elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false): ?>
                <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= $arResult["nStartPage"] ?></a>
            <? else: ?>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"><?= $arResult["nStartPage"] ?></a>
            <? endif ?>
            <? $arResult["nStartPage"]++ ?>
        <? endwhile ?>
        <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
            <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>">
                <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-right.svg") ?>" class="img-svg">
            </a>
        <? endif ?>

        <? if ($arResult["bShowAll"] && false): ?>
            <noindex>
                <? if ($arResult["NavShowAll"]): ?>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>SHOWALL_<?= $arResult["NavNum"] ?>=0" rel="nofollow">
                        <?= GetMessage("nav_paged") ?></a>
                <? else: ?>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>SHOWALL_<?= $arResult["NavNum"] ?>=1"
                       rel="nofollow"><?= GetMessage("nav_all") ?></a>
                <? endif ?>
            </noindex>
        <? endif ?>
    <? endif ?>
</div>
