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
<div class="col-md-12 faq-wrp">
    <? if ($arParams["DISPLAY_TOP_PAGER"]): ?>
        <?= $arResult["NAV_STRING"] ?><br/>
    <? endif; ?>
    <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
        <div class="faq-accord">
            <h1 class="faq-accord-title" data-toggle="collapse" data-target="#faq-<?= $key ?>"><?= $arItem["NAME"]; ?>
                <span class="podrobno">Ответ
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </h1>
            <div class="collapse-wrapper">
                <div id="faq-<?= $key ?>" class="collapse">
                    <div class="panel-body">
                        <?= $arItem["PREVIEW_TEXT"]; ?>
                    </div>
                </div>
            </div>
        </div>
    <? endforeach; ?>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <br/><?= $arResult["NAV_STRING"] ?>
    <? endif; ?>
</div>




