<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"URL_LIST" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("H2O_FAVORITES_LINE_URL_LIST"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),

	),
);


