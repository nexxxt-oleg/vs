<?
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;

Loader::registerAutoLoadClasses('h2o.favorites', array(
    // no thanks, bitrix, we better will use psr-4 than your class names convention
    'h2o\Favorites\FavoritesTable' => 'lib/favorites.php',
));
IncludeModuleLangFile(__FILE__);
Class CHOFavorites
{
	function OnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
	{
		if($GLOBALS['APPLICATION']->GetGroupRight("main") < "R")
			return;

		$MODULE_ID = basename(dirname(__FILE__));
		$aMenu = array(
			//"parent_menu" => "global_menu_services",
			"parent_menu" => "global_menu_content",
			"section" => $MODULE_ID,
			"sort" => 50,
			"text" => GetMessage('H2O_FAVORITES_TITLE'),
			"title" => GetMessage('H2O_FAVORITES_TITLE'),
//			"url" => "partner_modules.php?module=".$MODULE_ID,
			"icon" => "",
			"page_icon" => "",
			"items_id" => $MODULE_ID."_items",
			"more_url" => array(),
			"items" => array()
		);

		if (file_exists($path = dirname(__FILE__).'/admin'))
		{
			if ($dir = opendir($path))
			{
				$arFiles = array("h2o_favorites_list.php");

				/*while(false !== $item = readdir($dir))
				{
					if (in_array($item,array('.','..','menu.php','tools.php','h2o_preorder_edit.php')))	//исключаем файлы из меню, негоже пустым пунктам в меню появляться
						continue;

		
					$arFiles[] = $item;
				}
				*/
				
				sort($arFiles);
				$arTitles = array(
					'h2o_favorites_list.php' => GetMessage("H2O_FAVORITES_LIST"),
					
				);

				foreach($arFiles as $item)
					$aMenu['items'][] = array(
						'text' => $arTitles[$item],
						'url' => $item,
						'module_id' => $MODULE_ID,
						"title" => "",
					);
			}
		}
		$aModuleMenu[] = $aMenu;
	}
}
?>