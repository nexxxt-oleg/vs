<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

if (!isset($arParams["CACHE_TIME"]))
    $arParams["CACHE_TIME"] = 36000000;

$arParams["ID"] = intval($arParams["ID"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);

$arResult = array();

if ($this->StartResultCache()) {
    if (!CModule::IncludeModule("iblock")) {
        $this->AbortResultCache();
    } else {
        $arFilter = array(
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "GLOBAL_ACTIVE" => "Y",
            "IBLOCK_ACTIVE" => "Y",
            "<=" . "DEPTH_LEVEL" => $arParams['DEPTH_LEVEL'],
        );
        $arOrder = array(
            "left_margin" => "asc",
        );

        $rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, array(
            "ID",
            "DEPTH_LEVEL",
            "NAME",
            "SECTION_PAGE_URL",
            "IBLOCK_SECTION_ID"
        ));

        $levelID = array();
        while ($arSection = $rsSections->GetNext()) {
            if (sizeof($arResult) >= 20) {
                break;
            }
            switch ($arSection["DEPTH_LEVEL"]) {
                case '1':
                    $arResult[$arSection["ID"]] = [
                        'ID' => $arSection["ID"],
                        'NAME' => $arSection["~NAME"],
                        'SECTION_PAGE_URL' => $arSection["~SECTION_PAGE_URL"],
                        'DEPTH_LEVEL' => $arSection["DEPTH_LEVEL"],
                        'ITEMS' => []
                    ];
                    $levelID[$arSection["DEPTH_LEVEL"]] = $arSection["ID"];
                    break;
                case '2':
                    $parent = &$arResult[$levelID[1]];
                    if (sizeof($parent['ITEMS']) < 6) {
                        $parent['ITEMS'][$arSection["ID"]] = [
                            'ID' => $arSection["ID"],
                            'NAME' => $arSection["~NAME"],
                            'SECTION_PAGE_URL' => $arSection["~SECTION_PAGE_URL"],
                            'DEPTH_LEVEL' => $arSection["DEPTH_LEVEL"],
                            'ITEMS' => [],
                        ];
                        $levelID[$arSection["DEPTH_LEVEL"]] = $arSection["ID"];
                    } elseif (!isset($parent['OVERFLOW'])) {
                        $parent['OVERFLOW'] = true;
                    }
                    break;
                case '3':
                    $parent = &$arResult[$levelID[1]]['ITEMS'][$levelID[2]];
                    if (sizeof($parent['ITEMS']) < 6) {
                        $parent['ITEMS'][$arSection["ID"]] = [
                            'ID' => $arSection["ID"],
                            'NAME' => $arSection["~NAME"],
                            'SECTION_PAGE_URL' => $arSection["~SECTION_PAGE_URL"],
                            'DEPTH_LEVEL' => $arSection["DEPTH_LEVEL"],
                        ];
                    } elseif(!isset($parent['OVERFLOW'])) {
                        $parent['OVERFLOW'] = true;
                    }
                    break;
            }
        }
        $this->EndResultCache();
    }
}
$this->includeComponentTemplate();
return $arResult;
?>
