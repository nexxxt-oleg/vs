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
$this->setFrameMode(true);?>
<form action="<?=$arResult["FORM_ACTION"]?>" class="header-search">
			<?if($arParams["USE_SUGGEST"] === "Y"):?>

                <?$APPLICATION->IncludeComponent(
				"bitrix:search.suggest.input",
				"",
				array(
					"NAME" => "q",
					"VALUE" => "",
//					"INPUT_SIZE" => 15,
					"DROPDOWN_SIZE" => 10,
				),
				$component, array("HIDE_ICONS" => "Y")
			);?>

            <?else:?>
                <input type="text" class="header-search-input" name="q" value="" size="15" placeholder="Поиск…" maxlength="50" />
            <?endif;?>

<!--			<input name="s" type="submit" value="<?=GetMessage("BSF_T_SEARCH_BUTTON");?>" />-->
			<input name="s" class="header-search-submit" value="" type="submit" />
</form>
