<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$APPLICATION->AddChainItem($arResult["NAME"]);
?>
<section class="cur-vacancy">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title"><?=$arResult["PROPERTIES"]['JOB']['VALUE']?>

                    <? if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y"): ?>
                        <div class="share-block">Поделиться
                            <img class="<?= SITE_TEMPLATE_PATH ?>/img-share" src="img/ic-share.png" alt="">
                            <noindex>
                                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                                <script src="//yastatic.net/share2/share.js"></script>
                                <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,lj"></div>
                            </noindex>
                        </div>
                    <? endif; ?>

                </h1>
            </div>
        </div>

    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="cur-vacancy-terms-block">
                    <h2 class="cur-vacancy-terms-title">Обязанности:</h2>
                    <div class="cur-vacancy-terms">
                        <?= $arResult["PROPERTIES"]["RESP"]["~VALUE"]["TEXT"] ?>
                    </div>
                </div>
                <div class="cur-vacancy-terms-block">
                    <h2 class="cur-vacancy-terms-title">Требования:</h2>
                    <div class="cur-vacancy-terms">
                        <?= $arResult["PROPERTIES"]["REQ"]["~VALUE"]["TEXT"] ?>
                    </div>
                </div>
                <div class="cur-vacancy-terms-block">
                    <h2 class="cur-vacancy-terms-title">Условия:</h2>
                    <div class="cur-vacancy-terms">
                        <?= $arResult["PROPERTIES"]["COND"]["~VALUE"]["TEXT"] ?>
                    </div>
                </div>


            </div>
            <div class="col-md-4">
                <div class="cash-size">
                    <h2><?=$arResult["PROPERTIES"]['CITY']['VALUE']?>, <?=$arResult["PROPERTIES"]['CASH']['VALUE']?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <blockquote>Работа у нас тысячи новых рабочих мест, обеспечиваем успешных соискателей стабильной работой с достойной заработной платой, Отправьте свое резюме через форму или свяжитесь с менеджером по телефону: +7 978 00 70 333 </blockquote>
            </div>
            <div class="col-md-5"></div>
        </div>
        <div class="row" hidden>
            <div class="col-md-12">
                <div class="row">
                    <form action="" class="cur-vacancy-form">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <input placeholder="ФИО" type="text">
                        </div>
                        <div class="col-md-2"><input placeholder="Телефон" type="phone"></div>
                        <div class="col-md-2"><input placeholder="Email" type="email"></div>
                        <div class="col-md-2">
                            <div class="input-file-wrapper">
                                <input id="form-file" type="file">
                                <label for="form-file">Прикрепить файл</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="submit-input-wrapper">
                                <input id="submit" type="submit">
                                <label for="submit" class="btn-type-1">
                                    <div class="btn-type-1-arrow"></div>
                                    <div class="btn-type-1-text">Отправить</div>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div style="clear: both;"></div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>