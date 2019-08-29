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
$this->createFrame()->begin("");
?>
<div class="favor-list-wrap">
	<?if($arParams['URL_LIST'] != ""):?>
		<a href="<?=$arParams['URL_LIST']?>" class="count-favor-item"><?=$arResult['COUNT']?></a>
	<?else:?>
		<div class="count-favor-item"><?=$arResult['COUNT']?></div>
	<?endif;?>
</div>