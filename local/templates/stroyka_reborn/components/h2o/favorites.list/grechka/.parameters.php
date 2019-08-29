<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use Bitrix\Iblock;
use Bitrix\Currency;

if (!Loader::includeModule('iblock'))
	return;
$catalogIncluded = Loader::includeModule('catalog');

$arIBlockType = CIBlockParameters::GetIBlockTypes();
$arIBlock = array();
$iblockFilter = !empty($arCurrentValues['IBLOCK_TYPE'])
	? array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y')
	: array('ACTIVE' => 'Y');

$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);
while ($arr = $rsIBlock->Fetch())
{
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
}

$arProperty = array();
$arProperty_N = array();
$arProperty_X = array();
$listProperties = array();
if ($iblockExists)
{
	$propertyIterator = Iblock\PropertyTable::getList(array(
		'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'),
		'filter' => array('=IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], '=ACTIVE' => 'Y'),
		'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
	));
	while ($property = $propertyIterator->fetch())
	{
		$propertyCode = (string)$property['CODE'];

		if ($propertyCode === '')
		{
			$propertyCode = $property['ID'];
		}

		$propertyName = '['.$propertyCode.'] '.$property['NAME'];

		if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
		{
			$arProperty[$propertyCode] = $propertyName;

			if ($property['MULTIPLE'] === 'Y')
			{
				$arProperty_X[$propertyCode] = $propertyName;
			}
			elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_LIST)
			{
				$arProperty_X[$propertyCode] = $propertyName;
			}
			elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_ELEMENT && (int)$property['LINK_IBLOCK_ID'] > 0)
			{
				$arProperty_X[$propertyCode] = $propertyName;
			}
		}

		if ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_NUMBER)
		{
			$arProperty_N[$propertyCode] = $propertyName;
		}
	}
	unset($propertyCode, $propertyName, $property, $propertyIterator);
}


$offers = false;
$filterDataValues = array();
$arProperty_Offers = array();
$arProperty_OffersWithoutFile = array();
if ($catalogIncluded && $iblockExists)
{
	$filterDataValues['iblockId'] = (int)$arCurrentValues['IBLOCK_ID'];
	$offers = CCatalogSku::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	if (!empty($offers))
	{
		$filterDataValues['offersIblockId'] = $offers['IBLOCK_ID'];
		$propertyIterator = Iblock\PropertyTable::getList(array(
			'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'),
			'filter' => array('=IBLOCK_ID' => $offers['IBLOCK_ID'], '=ACTIVE' => 'Y', '!=ID' => $offers['SKU_PROPERTY_ID']),
			'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
		));
		while ($property = $propertyIterator->fetch())
		{
			$propertyCode = (string)$property['CODE'];

			if ($propertyCode === '')
			{
				$propertyCode = $property['ID'];
			}

			$propertyName = '['.$propertyCode.'] '.$property['NAME'];
			$arProperty_Offers[$propertyCode] = $propertyName;

			if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
			{
				$arProperty_OffersWithoutFile[$propertyCode] = $propertyName;
			}
		}
		unset($propertyCode, $propertyName, $property, $propertyIterator);
	}
}
$arSort = CIBlockParameters::GetElementSortFields(
	array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
	array('KEY_LOWERCASE' => 'Y')
);

$arPrice = array();
if ($catalogIncluded)
{
	$arOfferSort = array_merge($arSort, CCatalogIBlockParameters::GetCatalogSortFields());
	if (isset($arSort['CATALOG_AVAILABLE']))
		unset($arSort['CATALOG_AVAILABLE']);
	$arPrice = CCatalogIBlockParameters::getPriceTypesList();
}
else
{
	$arOfferSort = $arSort;
	$arPrice = $arProperty_N;
}

$arAscDesc = array(
	'asc' => GetMessage('IBLOCK_SORT_ASC'),
	'desc' => GetMessage('IBLOCK_SORT_DESC'),
);
$arTemplateParameters['IBLOCK_TYPE'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('IBLOCK_TYPE'),
	'TYPE' => 'LIST',
	'VALUES' => $arIBlockType,
	'REFRESH' => 'Y',
);
$arTemplateParameters['IBLOCK_ID'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('IBLOCK_IBLOCK'),
	'TYPE' => 'LIST',
	'ADDITIONAL_VALUES' => 'Y',
	'VALUES' => $arIBlock,
	'REFRESH' => 'Y',
);
$arTemplateParameters['SHOW_DISCOUNT_PERCENT'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('CP_BCS_TPL_SHOW_DISCOUNT_PERCENT'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y'
);
$arTemplateParameters['SHOW_OLD_PRICE'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('CP_BCS_TPL_SHOW_OLD_PRICE'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y'
);
$arTemplateParameters['ELEMENT_SORT_FIELD'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_FIELD'),
	'TYPE' => 'LIST',
	'VALUES' => $arSort,
	'ADDITIONAL_VALUES' => 'Y',
	'DEFAULT' => 'sort',
);
$arTemplateParameters['ELEMENT_SORT_ORDER'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_ORDER'),
	'TYPE' => 'LIST',
	'VALUES' => $arAscDesc,
	'DEFAULT' => 'asc',
	'ADDITIONAL_VALUES' => 'Y',
);
$arTemplateParameters['ELEMENT_SORT_FIELD2'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_FIELD2'),
	'TYPE' => 'LIST',
	'VALUES' => $arSort,
	'ADDITIONAL_VALUES' => 'Y',
	'DEFAULT' => 'id',
);
$arTemplateParameters['ELEMENT_SORT_ORDER2'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_ORDER2'),
	'TYPE' => 'LIST',
	'VALUES' => $arAscDesc,
	'DEFAULT' => 'desc',
	'ADDITIONAL_VALUES' => 'Y',
);
$arTemplateParameters['BASKET_URL']= array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('IBLOCK_BASKET_URL'),
	'TYPE' => 'STRING',
	'DEFAULT' => '/personal/cart/',
);
$arTemplateParameters['PRICE_CODE'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('IBLOCK_PRICE_CODE'),
	'TYPE' => 'LIST',
	'MULTIPLE' => 'Y',
	'VALUES' => $arPrice,
);
$arTemplateParameters['PROPERTY_CODE'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('IBLOCK_PROPERTY'),
	'TYPE' => 'LIST',
	'MULTIPLE' => 'Y',
	'VALUES' => $arProperty,
	'ADDITIONAL_VALUES' => 'Y',
);
$arTemplateParameters['OFFERS_FIELD_CODE'] = CIBlockParameters::GetFieldCode(GetMessage('CP_BCS_OFFERS_FIELD_CODE'), 'CATALOG_SECTION');
$arTemplateParameters['OFFERS_PROPERTY_CODE'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('CP_BCS_OFFERS_PROPERTY_CODE'),
	'TYPE' => 'LIST',
	'MULTIPLE' => 'Y',
	'VALUES' => $arProperty_Offers,
	'ADDITIONAL_VALUES' => 'Y',
);
$arTemplateParameters['OFFERS_LIMIT'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('CP_BCS_OFFERS_LIMIT'),
	'TYPE' => 'STRING',
	'DEFAULT' => 5
);
$arTemplateParameters['ADD_PROPERTIES_TO_BASKET'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('CP_BCS_ADD_PROPERTIES_TO_BASKET'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'REFRESH' => 'Y'
);
$arTemplateParameters['PRODUCT_PROPERTIES'] = array(
	'PARENT' => 'CATALOG_SECTION',
	'NAME' => GetMessage('CP_BCS_PRODUCT_PROPERTIES'),
	'TYPE' => 'LIST',
	'MULTIPLE' => 'Y',
	'VALUES' => $arProperty_X,
	'HIDDEN' => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] === 'N' ? 'Y' : 'N')
);

if (empty($offers))
{
	unset($arTemplateParameters['OFFERS_FIELD_CODE']);
	unset($arTemplateParameters['OFFERS_PROPERTY_CODE']);
	unset($arTemplateParameters['OFFERS_SORT_FIELD']);
	unset($arTemplateParameters['OFFERS_SORT_ORDER']);
	unset($arTemplateParameters['OFFERS_SORT_FIELD2']);
	unset($arTemplateParameters['OFFERS_SORT_ORDER2']);
}
else
{
	$arTemplateParameters['OFFERS_CART_PROPERTIES'] = array(
		'PARENT' => 'CATALOG_SECTION',
		'NAME' => GetMessage('CP_BCS_OFFERS_CART_PROPERTIES'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'Y',
		'VALUES' => $arProperty_OffersWithoutFile,
		'HIDDEN' => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] === 'N' ? 'Y' : 'N')
	);
}
