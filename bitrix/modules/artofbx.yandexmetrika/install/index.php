<?php
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Artofbx\Yandexmetrika\Handlers\MetrikaHandler;

Loc::loadMessages(__FILE__);

class artofbx_yandexmetrika extends CModule
{
    var $MODULE_ID = 'artofbx.yandexmetrika';
    var $PARTNER_NAME = 'Art of Bitrix, Russia';
    var $PARTNER_URI = 'http://bxart.ru';

    function __construct()
    {
        $arModuleVersion = array();
        include("version.php");
        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }
        $this->MODULE_NAME = Loc::getMessage('MODULE_YANDEX_METRIKA_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MODULE_YANDEX_METRIKA_DESC');
        $this->PARTNER_NAME = Loc::getMessage('MODULE_YANDEX_METRIKA_VENDOR_NAME');
        $this->PARTNER_URI = Loc::getMessage('MODULE_YANDEX_METRIKA_VENDOR_URL');
    }


    function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        Loader::includeModule($this->MODULE_ID);
        MetrikaHandler::register($this->MODULE_ID);
    }

    function DoUninstall()
    {
        Loader::includeModule($this->MODULE_ID);
        MetrikaHandler::unRegister($this->MODULE_ID);
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}