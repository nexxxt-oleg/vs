<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogTopComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
$delayedItem = $APPLICATION->delayedItems;

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['SECTION'] = CIBlockSection::GetByID($arItem['IBLOCK_SECTION_ID'])->Fetch();
}
$arResult['ID'] = rand(1000000, 9990999);
