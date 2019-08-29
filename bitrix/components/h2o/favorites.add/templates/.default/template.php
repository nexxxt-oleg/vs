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
$frame = $this->createFrame()->begin("");


$arJSParams = array(
	'CURRENT_ELEMENT_IN_FAVORITES' => $arResult['CURRENT_ELEMENT_IN_FAVORITES'],
	'BUTTON_CONTENT' => array(
		'IN_FAVOR' => GetMessage("H2O_FAVOR_BUTTON_IN_FAVOR"),
		'NOT_IN_FAVOR' => GetMessage("H2O_FAVOR_BUTTON_NOT_IN_FAVOR"),
	),
);

?>
<script type="text/javascript">
	var h2oFavoritAdd = new JCH2oFavoritesAdd(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>