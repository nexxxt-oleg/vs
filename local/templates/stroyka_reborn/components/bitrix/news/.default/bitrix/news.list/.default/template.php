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
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="page-news__card card-news">
                    <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"]): ?>
                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="card-news__img">
                            <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"/>
                        </a>
                    <? else: ?>
                        <div class="card-news__img">
                            <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"/>
                        </div>
                    <? endif; ?>

                    <? if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                        <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="card-news__title h3"><?= $arItem["NAME"] ?></a>
                        <? else: ?>
                            <span class="card-news__title h3"><?= $arItem["NAME"] ?></span>
                        <? endif; ?>
                    <? endif; ?>
                    <div class="card-news__desc b-content">
                        <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
                            <?= $arItem["PREVIEW_TEXT"]; ?>
                        <? endif; ?>
                    </div>
                    <div class="card-news__bottom">
                        <? if ($arParams["DISPLAY_DATE"] != "N" && $arItem["DATE_CREATE"]): ?>
                            <div class="card-news__date">
                                <? $arParams["DATE_CREATE"] = "j F Y"; ?>
                                <span class="b-date"><?= CIBlockFormatProperties::DateFormat($arParams["DATE_CREATE"], MakeTimeStamp($arItem["DATE_CREATE"], CSite::GetDateFormat())); ?></span>
                            </div>
                        <? endif ?>
                        <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"]): ?>
                            <div class="card-news__more">
                                <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="arrow-link arrow-link_sm arrow-link_right">
                                    <span>Подробнее</span>
                                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-right.svg") ?>" class="img-svg">
                                </a>
                            </div>
                        <? endif; ?>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
    </div>
    <?if (strlen($arResult["NAV_STRING"]) > 0):?><?=$arResult["NAV_STRING"]?><?endif?>
</div>