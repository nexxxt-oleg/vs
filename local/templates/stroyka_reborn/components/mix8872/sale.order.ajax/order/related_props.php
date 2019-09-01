<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format.php");
?>

	<?=PrintPropsForm($arResult["ORDER_PROP"]["RELATED"], $arParams["TEMPLATE_LOCATION"])?>