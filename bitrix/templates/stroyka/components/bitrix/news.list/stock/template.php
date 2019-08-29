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

?>
<div class="container">
    <div class="row">
        <?foreach($arResult["ITEMS"] as $key => $arItem):?>
            <?
            $endDate = new DateTime($arItem['ACTIVE_TO']);
            $today = new DateTime(date("d-m-Y H:i"));
            $diff = $today->diff($endDate);
            ?>
        <div class="col-md-4">
            <div class="akciya-block">
                <div class="akciya-block-img">
                    <?if($arParams["DISPLAY_PICTURE"]!= "N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                        <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>" title="<?=$arItem['PREVIEW_PICTURE']['TITLE']?>"/>
                    <?endif;?>
                    <div class="akciya-block-img-overlay">
                        <?= $arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"] ? '<h2>'.$arItem["NAME"].'</h2>' : '' ?>
                        <div class="btn-type-1">
                            <div class="btn-type-1-arrow"></div>
                            <a class="btn-type-1-text" href="<?=$arItem["DETAIL_PAGE_URL"]?>">Подробно</a>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="akciya-block-time">До завершения акции осталось: <span><?= $diff->format("%d дней %H часов %i минут"); ?></span></div>
            </div>
        </div>
        <?= $key > 0 && $key%3 == 0 ? '</div><div class="row">' : '' ?>
        <?endforeach;?>
    </div>
</div>