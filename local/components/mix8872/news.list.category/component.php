<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$rsSections = CIBlockSection::GetList(array('left_margin' => 'asc'), array('IBLOCK_ID' => $arParams['IBLOCK_ID']));
while ($arSection = $rsSections->Fetch()) {
    $section = CIBlockElement::GetList(Array(), ["SECTION_ID" => $arSection['ID']]);
    $k = 0;
    while ($item = $section->GetNextElement()) {
        $itemFields = CIBlockElement::GetProperty($arParams['IBLOCK_ID'], $item->fields['ID']);
        while ($field = $itemFields->GetNext()) {
            $arResult[$arSection['NAME']][$k][$field['CODE']] = $field['VALUE'];
        }
        $k++;
    }
}
$this->includeComponentTemplate();
return $arResult;