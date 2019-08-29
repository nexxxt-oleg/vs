<?
IncludeModuleLangFile(__FILE__);
Class payanyway_payment extends CModule
{
	const MODULE_ID = 'payanyway.payment';
	var $MODULE_ID = 'payanyway.payment';
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
		$this->MODULE_NAME = GetMessage("payanyway.payment_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("payanyway.payment_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("payanyway.payment_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("payanyway.payment_PARTNER_URI");
	}

	function InstallDB($arParams = array())
	{
		RegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CPayanywayPayment', 'OnBuildGlobalMenu');
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		UnRegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CPayanywayPayment', 'OnBuildGlobalMenu');
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function copyDir( $source, $destination ) {
		if ( is_dir( $source ) ) {
			@mkdir( $destination, 0755 );
			$directory = dir( $source );
			while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
				if ( $readdirectory == '.' || $readdirectory == '..' ) continue;
				$PathDir = $source . '/' . $readdirectory;
				if ( is_dir( $PathDir ) ) {
					$this->copyDir( $PathDir, $destination . '/' . $readdirectory );
					continue;
				}
				copy( $PathDir, $destination . '/' . $readdirectory );
			}
			$directory->close();
		} else {
			copy( $source, $destination );
		}
	}

	function InstallFiles($arParams = array())
	{
		$path = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/payment/payanyway';
		$remove_files = array( 'result_receive.php', 'payanyway_invoice.php', 'logo.png', '.htaccess' );
		foreach ($remove_files as $file) {
			if ( file_exists($path . '/' . $file) )
				@unlink( $path . '/' . $file );
		}

		if (is_dir($source = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install')) {
			$this->copyDir( $source."/payment", $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/sale/payment');
		}
		return true;
	}

	function UnInstallFiles()
	{
		foreach(glob($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/sale/payment/payanyway*') as $fld){
			DeleteDirFilesEx(str_replace($_SERVER['DOCUMENT_ROOT'], '', $fld));
		}
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION;
		$this->InstallFiles();
		$this->InstallDB();
		RegisterModule(self::MODULE_ID);
	}

	function DoUninstall()
	{
		global $APPLICATION;
		UnRegisterModule(self::MODULE_ID);
		$this->UnInstallDB();
		$this->UnInstallFiles();
	}
}
?>
