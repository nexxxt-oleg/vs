<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if ($arResult['DETAIL_TEXT_TYPE'] === 'html') {
    $arResult['DETAIL_TEXT'] = str_replace(["\r\n", "\r", "\n"], '<br/>', $arResult['DETAIL_TEXT']);
}