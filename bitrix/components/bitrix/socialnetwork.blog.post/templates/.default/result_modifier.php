<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

$arResult["Post"]["SPERM_SHOW"] = $arResult["Post"]["SPERM"];

if (
	isset($arResult["Post"])
	&& isset($arResult["Post"]["SPERM"])
	&& isset($arResult["Post"]["SPERM"]["CRMCONTACT"])
	&& is_array($arResult["Post"]["SPERM"]["CRMCONTACT"])
	&& !empty($arResult["Post"]["SPERM"]["CRMCONTACT"])
	&& isset($arResult["Post"]["SPERM"]["U"])
	&& is_array($arResult["Post"]["SPERM"]["U"])
	&& !empty($arResult["Post"]["SPERM"]["U"])
)
{
	$arDestinationList = $arResult["Post"]["SPERM"];

	foreach($arDestinationList["CRMCONTACT"] as $key => $arDestination)
	{
		foreach($arDestinationList["U"] as $key2 => $arDestination2)
		{
			if (
				isset($arDestination2["CRM_ENTITY"])
				&& $arDestination2["CRM_ENTITY"] == 'C_'.$arDestination["ID"]
			)
			{
				$arDestinationList["CRMCONTACT"][$key]["CRM_USER_ID"] = $arDestinationList["U"][$key2]["ID"];
				unset($arDestinationList["U"][$key2]);
			}
		}
	}

	$arResult["Post"]["SPERM_SHOW"] = $arDestinationList;
}

?>