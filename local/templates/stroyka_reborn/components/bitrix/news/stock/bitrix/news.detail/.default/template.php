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
            <div class="col-sm-8">
                <div class="page-all-sect__top-title">
                    <h2><?= $arResult['NAME'] ?></h2>
                </div>
            </div>
            <div class="col-sm-4">
                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                <script src="//yastatic.net/share2/share.js"></script>
                <div class="page-all-sect__top-share card-share">
                    <span>Поделиться</span>
                    <div class="card-share__icons ya-share2" data-services="vkontakte,facebook" data-size="s"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 order-1 order-lg-0 col-lg-8">
                <div class="b-content">
                    <?= $arResult['DETAIL_TEXT'] ?>
                </div>
            </div>
            <?
            $activeTo = strtotime($arResult['ACTIVE_TO']);
            $today = strtotime(date("d-m-Y H:i"));
            ?>
            <div class="col-12 order-0 order-lg-1 col-lg-4">
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
                <? endif; ?>
            </div>
        </div>
    </div>

<?
if (array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y" && false) {
    ?>
    <div class="news-detail-share">
        <noindex>
            <?
            $APPLICATION->IncludeComponent("bitrix:main.share", "", array(
                "HANDLERS" => $arParams["SHARE_HANDLERS"],
                "PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
                "PAGE_TITLE" => $arResult["~NAME"],
                "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
                "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                "HIDE" => $arParams["SHARE_HIDE"],
            ),
                $component,
                array("HIDE_ICONS" => "Y")
            );
            ?>
        </noindex>
    </div>
    <?
}
?>