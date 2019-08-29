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
            <div class="col-lg-8">
                <div class="b-content">
                    <h3>Обязанности:</h3>

                    <?= $arResult['DISPLAY_PROPERTIES']['RESP']['~VALUE']['TEXT'] ?>

                    <h3>Требования:</h3>

                    <?= $arResult['DISPLAY_PROPERTIES']['REQ']['~VALUE']['TEXT'] ?>

                    <h3>Условия:</h3>

                    <?= $arResult['DISPLAY_PROPERTIES']['COND']['~VALUE']['TEXT'] ?>

                    <blockquote>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "text3_inc.php"
                            )
                        ); ?>
                    </blockquote>

                </div>
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