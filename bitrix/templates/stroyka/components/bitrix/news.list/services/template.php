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
$opened = false;
?>
<section class="services">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">Услуги</h1>
            </div>
        </div>
        <div class="row">
            <div class="services-ul">
                <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
                    <div class="col-md-3 col-sm-6">
                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="services-ul-el">

                            <? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arItem["PREVIEW_PICTURE"])): ?>
                                <img class="services-ul-el-img" src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                     alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>"
                                     title="<?= $arItem['PREVIEW_PICTURE']['TITLE'] ?>"/>
                            <? endif; ?>

                            <? if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                                <h4 class="services-ul-el-title"><?= $arItem["NAME"] ?></h4>
                            <? endif; ?>

                            <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
                                <p class="services-ul-el-descr"><?= $arItem["PREVIEW_TEXT"] ?></p>
                            <? endif; ?>
                        </a>
                    </div>
                    <?= $key > 0 && $key % 3 == 0 ? '</div></div><div class="row"><div class="services-ul">' : '' ?>
                <? endforeach; ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <blockquote>Магазин оказывает услуги только на товар, приобретенный в этом магазине.
                    Условия предоставления услуг в магазинах могут отличаться.
                </blockquote>
            </div>
        </div>
    </div>
</section>
<script>
    var mh = 0;
    $(".services-ul-el").each(function () {
        var h_block = parseInt($(this).height());
        if(h_block > mh) {
            mh = h_block;
        };
    });
    $(".services-ul-el").height(mh);
</script>