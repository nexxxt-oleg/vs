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
$this->setFrameMode(true); ?>
<form class="hm-search" action="<?=$arResult["FORM_ACTION"]?>" method="get">
    <div class="hm-search__text-field input-search">

        <? if ($arParams["USE_SUGGEST"] === "Y"): ?>
            <? $APPLICATION->IncludeComponent(
                "bitrix:search.suggest.input",
                "",
                array(
                    "NAME" => "q",
                    "VALUE" => "",
                    "INPUT_SIZE" => 15,
                    "DROPDOWN_SIZE" => 10,
                ),
                $component, array("HIDE_ICONS" => "Y")
            ); ?>

        <? else: ?>
            <input type="text" name="q" value="" class="input-search__input" maxlength="50"/>
        <? endif; ?>


        <button type="submit" name="s" class="input-search__btn">
            <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/search.svg") ?>" class="img-svg">
        </button>

    </div>
</form>
