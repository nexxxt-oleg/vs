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
<?foreach($arResult["ITEMS"] as $key => $arItem):?>
<?$properties = $arItem['PROPERTIES'];?>
    <div class="row">
        <div class="col-md-12">
            <div class="vacancy-el">
                <h2><?=$properties['JOB']['VALUE']?> <span><?=$properties['CITY']['VALUE']?>, <?=$properties['CASH']['VALUE']?></span></h2>
                <p><?= $arItem['PREVIEW_TEXT'] ?></p>
                <div class="text-right"><a class="podrobno" href="<?=$arItem['DETAIL_PAGE_URL']?>">Подробно <i class="fa fa-angle-right" aria-hidden="true"></i></a></div>
            </div>
        </div>
    </div>
<?endforeach;?>