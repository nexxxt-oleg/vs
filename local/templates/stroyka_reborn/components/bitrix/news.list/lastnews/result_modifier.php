<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
foreach ($arResult["ITEMS"] as $arItem) {

    $arButtons = CIBlock::GetPanelButtons(
        $arItem["IBLOCK_ID"],
        $arItem["ID"],
        0,
        array("SECTION_BUTTONS" => false, "SESSID" => false)
    );
    $arItem["ADD_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];
    $arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
    $arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

    $arItem["ADD_LINK_TEXT"] = $arButtons["edit"]["add_element"]["TEXT"];
    $arItem["EDIT_LINK_TEXT"] = $arButtons["edit"]["edit_element"]["TEXT"];
    $arItem["DELETE_LINK_TEXT"] = $arButtons["edit"]["delete_element"]["TEXT"];

    $this->AddEditAction($arItem['ID'], $arItem['ADD_LINK'], $arItem["ADD_LINK_TEXT"]);
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $arItem["EDIT_LINK_TEXT"]);
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $arItem["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
}