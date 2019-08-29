<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.downCount.js');
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
            <div class="col-12 col-sm-6 col-md-4">
                <div class="page-actions__card card-actions">
                    <div class="row">
                        <div class="col-12">
                            <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"]): ?>
                                <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="card-actions__img">
                                    <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                         alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                         title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"/>
                                </a>
                            <? else: ?>
                                <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                     alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                     title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"/>
                            <? endif; ?>
                        </div>
                        <div class="col-12">
                            <div class="card-actions__body">
                                <? if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                                    <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="card-actions__title h3"><?= $arItem["NAME"] ?></a>
                                    <? else: ?>
                                        <span class="card-actions__title h3"><?= $arItem["NAME"] ?></span>
                                    <? endif; ?>
                                <? endif; ?>
                                <div class="card-actions__desc b-content">
                                    <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
                                        <?= $arItem["PREVIEW_TEXT"]; ?>
                                    <? endif; ?>
                                </div>
                                <div class="card-actions__bottom card-actions__bottom_timer">
                                    <div class="card-actions__date">
                                        <? $arParams["DATE_CREATE"] = "j F Y"; ?>
                                        <span class="b-date"><?= CIBlockFormatProperties::DateFormat($arParams["DATE_CREATE"], MakeTimeStamp($arItem["DATE_CREATE"], CSite::GetDateFormat())); ?></span>
                                    </div>
                                    <?
                                    $activeTo = strtotime($arItem['ACTIVE_TO']);
                                    $today = strtotime(date("d-m-Y H:i"));
                                    ?>
                                    <div class="card-actions__timer">
                                        <? if ($activeTo >= $today): ?>
                                            <div class="card-new-actions-timer" data-time="<?= date("m/d/Y H:i:s", $activeTo) ?>">
                                                <div class="card-new-actions-timer__title">До завершения акции осталось: </div>
                                                <div class="card-new-actions-timer__number">
                                                    <span class="card-new-actions-timer__days-number days"></span>
                                                    <span class="card-new-actions-timer__hours-number hours"></span>
                                                    <span class="card-new-actions-timer__minutes-number minutes"></span>
                                                </div>
                                                <div class="card-new-actions-timer__desc">
                                                    <span class="card-new-actions-timer__days-desc">Дней</span>
                                                    <span class="card-new-actions-timer__hours-desc">Часов</span>
                                                    <span class="card-new-actions-timer__minutes-desc">Минут</span>
                                                </div>
                                            </div>
                                        <? else: ?>
                                            <div class="card-new-actions-timer__title">Акция завершена </div>
                                            <div class="card-new-actions-timer__number">
                                                <span class="card-new-actions-timer__days-number days">--</span>
                                                <span class="card-new-actions-timer__hours-number hours">--</span>
                                                <span class="card-new-actions-timer__minutes-number minutes">--</span>
                                            </div>
                                            <div class="card-new-actions-timer__desc">
                                                <span class="card-new-actions-timer__days-desc">Дней</span>
                                                <span class="card-new-actions-timer__hours-desc">Часов</span>
                                                <span class="card-new-actions-timer__minutes-desc">Минут</span>
                                            </div>
                                        <? endif; ?>
                                    </div>
                                    <div class="card-actions__more">
                                        <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"]): ?>
                                            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="arrow-link arrow-link_sm arrow-link_right">
                                                <span>Подробнее</span>
                                                <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-right.svg") ?>" class="img-svg">
                                            </a>
                                        <? endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <? endforeach; ?>
    </div>
    <? if (strlen($arResult["NAV_STRING"]) > 0): ?><?= $arResult["NAV_STRING"] ?><? endif ?>
</div>