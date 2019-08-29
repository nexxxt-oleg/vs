<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

if(!CModule::IncludeModule("iblock"))
	return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];

$arSorts = array("ASC"=>GetMessage("H2O_FAVORITES_SORT_ASC"), "DESC"=>GetMessage("H2O_FAVORITES_SORT_DESC"));
$arSortFields = array(
		"ID"=>GetMessage("H2O_FAVORITES_SORT_ID"),
		"DATE_INSERT"=>GetMessage("H2O_FAVORITES_SORT_DATE_INSERT"),
	);

$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(array("sort"=>"asc", "name"=>"asc"), array("ACTIVE"=>"Y", "IBLOCK_ID"=>(isset($arCurrentValues["IBLOCK_ID"])?$arCurrentValues["IBLOCK_ID"]:$arCurrentValues["ID"])));
while ($arr=$rsProp->Fetch())
{
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S")))
	{
		$arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arComponentParameters = array(
	"GROUPS" => array(
		'CATALOG_SECTION' => array("NAME" => GetMessage("CATALOG_SECTION_GROUP"), "SORT" => "500")
	),
	"PARAMETERS" => array(
		
		"FAVORITES_COUNT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("H2O_FAVORITES_LIST_FAVORITES_COUNT"),
			"TYPE" => "STRING",
			"DEFAULT" => "20",
		),
		"SORT_BY" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("H2O_FAVORITES_LIST_DESC_IBORD"),
			"TYPE" => "LIST",
			"DEFAULT" => "DATE_INSERT",
			"VALUES" => $arSortFields,
			"ADDITIONAL_VALUES" => "Y",
		),
		"SORT_ORDER" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("H2O_FAVORITES_LIST_DESC_IBBY"),
			"TYPE" => "LIST",
			"DEFAULT" => "DESC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),

		"FILTER_NAME" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("H2O_FAVORITES_LIST_FILTER"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		
		"DATE_FORMAT" => CIBlockParameters::GetDateFormat(GetMessage("H2O_FAVORITES_LIST_DESC_ACTIVE_DATE_FORMAT"), "ADDITIONAL_SETTINGS"),
		
		
		
		"SET_TITLE" => array(),
		
		
		
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		"CACHE_FILTER" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("IBLOCK_CACHE_FILTER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BNL_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"DISPLAY_TOP_PAGER" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("H2O_FAVORITES_LIST_DISPLAY_TOP_PAGER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"DISPLAY_BOTTOM_PAGER" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("H2O_FAVORITES_LIST_DISPLAY_BOTTOM_PAGER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"NAV_TEMPLATE" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("H2O_FAVORITES_LIST_NAV_TEMPLATE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
	),
);
/*
CIBlockParameters::AddPagerSettings(
	$arComponentParameters,
	GetMessage("H2O_FAVORITES_LIST_DESC_PAGER_NEWS"), //$pager_title
	false, //$bDescNumbering
	true, //$bShowAllParam
	false, //$bBaseLink
	$arCurrentValues["PAGER_BASE_LINK_ENABLE"]==="Y" //$bBaseLinkEnabled
);*/

