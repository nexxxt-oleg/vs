<?
IncludeModuleLangFile(__FILE__);
if (class_exists("h2o_favorites"))
	return;

Class h2o_favorites extends CModule
{
	const MODULE_ID = 'h2o.favorites';
	var $MODULE_ID = 'h2o.favorites'; 
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("h2o.favorites_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("h2o.favorites_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("h2o.favorites_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("h2o.favorites_PARTNER_URI");
	}

	function InstallDB($arParams = array())
	{
		global $DB;
		RegisterModule(self::MODULE_ID);
		/**
		 * Создание глобального меню
		 */
		RegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CHOFavorites', 'OnBuildGlobalMenu');
		/**
		 * Установка таблицы
		 */
		$DB->RunSQLBatch(dirname(__FILE__)."/sql/install.sql"); 

		return true;
	}

	function UnInstallDB($arParams = array())
	{
		global $DB;
		UnRegisterModule(self::MODULE_ID);
		UnRegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CHOFavorites', 'OnBuildGlobalMenu');

		$DB->RunSQLBatch(dirname(__FILE__)."/sql/uninstall.sql");
		
		return true;
	}

	function InstallEvents()
	{
		global $DB;
		//include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".self::MODULE_ID."/install/events.php");
		return true;
	}

	function UnInstallEvents()
	{
		$et = new \CEventType;
		$eventM = new \CEventMessage;
		$et->Delete("H2O_FAVORITES_NOTIFICATION");
		$dbEvent = \CEventMessage::GetList($b="ID", $order="ASC", Array("EVENT_NAME" => "H2O_FAVORITES_NOTIFICATION"));
		while($arEvent = $dbEvent->Fetch())
		{
			$eventM->Delete($arEvent["ID"]);
		}
		return true;
	}

	function InstallFiles($arParams = array())
	{
		CopyDirFiles(dirname(__FILE__)."/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true);
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.')
						continue;
					CopyDirFiles($p.'/'.$item, $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/'.$item, $ReWrite = True, $Recursive = True);
				}
				closedir($dir);
			}
		}
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFiles(dirname(__FILE__)."/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.' || !is_dir($p0 = $p.'/'.$item))
						continue;

					$dir0 = opendir($p0);
					while (false !== $item0 = readdir($dir0))
					{
						if ($item0 == '..' || $item0 == '.')
							continue;
						DeleteDirFilesEx('/bitrix/components/'.$item.'/'.$item0);
					}
					closedir($dir0);
				}
				closedir($dir);
			}
		}
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION;
		$this->InstallFiles();
		$this->InstallDB();
	}

	function DoUninstall()
	{
		global $APPLICATION;
		
		$this->UnInstallDB();
		$this->UnInstallFiles();
	}
}
?>
