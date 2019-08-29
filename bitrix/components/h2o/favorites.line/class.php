<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main;
use Bitrix\Main\Config;
use Bitrix\Main\Data;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;
use Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

class H2oFavoritesLineComponent extends CBitrixComponent
{
	/**
	 * Fatal error list. Any fatal error makes useless further execution of a component code.
	 * In most cases, there will be only one error in a list according to the scheme "one shot - one dead body"
	 *
	 * @var string[] Array of fatal errors.
	 */
	protected static $cookie_user_id;
	protected $errorsFatal = array();
	/**
	 * Non-fatal error list. Some non-fatal errors may occur during component execution, so certain functions of the component
	 * may became defunct. Still, user should stay informed.
	 * There may be several non-fatal errors in a list.
	 *
	 * @var string[] Array of non-fatal errors.
	 */
	protected $errorsNonFatal = array();

	/**
	 * Contains some valuable info from $_REQUEST
	 *
	 * @var object request info
	 */
	protected $requestData = array();

	/**
	 * Gathered options that are required
	 *
	 * @var string[] options
	 */
	protected $options = array();

	/**
	 * Variable remains true if there is 'catalog' module installed
	 *
	 * @var bool flag
	 */
	protected $useCatalog = true;

	/**
	 * A value of current date format
	 *
	 * @var string format
	 */
	private $dateFormat = '';
	
	/**
	 * Navstring for orm
	 */
	private $navString = "";
	private $navObject;
	/**
	 * Filter used when select orders
	 *
	 * @var mixed[] filter
	 */
	protected $filter = array();

	/**
	 * Sort field for query
	 *
	 * @var string field
	 */
	protected $sortBy = false;

	/**
	 * Sort direction for query
	 *
	 * @var string order: asc or desc
	 */
	protected $sortOrder = false;

	protected $dbResult = array();
	private $dbQueryResult = array();

	protected $currentCache = null;

	protected $application;
	
	public function __construct($component = null)
	{
		parent::__construct($component);

		CPageOption::SetOptionString("main", "nav_page_in_session", "N");

		$this->dateFormat = CSite::GetDateFormat("FULL", SITE_ID);
		global $APPLICATION;
		$this->application = $APPLICATION;//Application::getInstance();
		Loc::loadMessages(__FILE__);
	}

	public function onPrepareComponentParams($arParams)
	{

		$arParams["FAVORITES_COUNT"] = intval($arParams["FAVORITES_COUNT"]);
		if($arParams["FAVORITES_COUNT"]<=0)
			$arParams["FAVORITES_COUNT"] = 20;

		$arParams["CACHE_FILTER"] = $arParams["CACHE_FILTER"]=="Y";
		if(!$arParams["CACHE_FILTER"])
			$arParams["CACHE_TIME"] = 0;

		$arParams["SET_TITLE"] = $arParams["SET_TITLE"]!="N";
		$arParams["SET_BROWSER_TITLE"] = (isset($arParams["SET_BROWSER_TITLE"]) && $arParams["SET_BROWSER_TITLE"] === 'N' ? 'N' : 'Y');
		$arParams["SET_META_KEYWORDS"] = (isset($arParams["SET_META_KEYWORDS"]) && $arParams["SET_META_KEYWORDS"] === 'N' ? 'N' : 'Y');
		$arParams["SET_META_DESCRIPTION"] = (isset($arParams["SET_META_DESCRIPTION"]) && $arParams["SET_META_DESCRIPTION"] === 'N' ? 'N' : 'Y');


		$arParams["DISPLAY_TOP_PAGER"] = $arParams["DISPLAY_TOP_PAGER"]=="Y";
		$arParams["DISPLAY_BOTTOM_PAGER"] = $arParams["DISPLAY_BOTTOM_PAGER"]!="N";
		$arParams["PAGER_TITLE"] = trim($arParams["PAGER_TITLE"]);
		$arParams["PAGER_SHOW_ALWAYS"] = $arParams["PAGER_SHOW_ALWAYS"]=="Y";
		$arParams["NAV_TEMPLATE"] = trim($arParams["NAV_TEMPLATE"]);
		$arParams["PAGER_DESC_NUMBERING"] = $arParams["PAGER_DESC_NUMBERING"]=="Y";
		$arParams["PAGER_DESC_NUMBERING_CACHE_TIME"] = intval($arParams["PAGER_DESC_NUMBERING_CACHE_TIME"]);
		$arParams["PAGER_SHOW_ALL"] = $arParams["PAGER_SHOW_ALL"]=="Y";
		$arParams["CHECK_PERMISSIONS"] = $arParams["CHECK_PERMISSIONS"]!="N";
		$arParams["DATE_FORMAT"] = trim($arParams["DATE_FORMAT"]);
		$arParams['DATE_FORMAT'] = ($arParams['DATE_FORMAT'] != ""?$arParams['DATE_FORMAT']:"d.m.Y");

		$arParams["SORT_BY"] = trim($arParams["SORT_BY"]);
		if(strlen($arParams["SORT_BY"])<=0)
			$arParams["SORT_BY"] = "ID";
		if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER"]))
			$arParams["SORT_ORDER"]="DESC";


		return $arParams;
	}

	/**
	 * Function checks if required modules installed. If not, throws an exception
	 * @throws Main\SystemException
	 * @return void
	 */
	protected function checkRequiredModules()
	{
		if (!Loader::includeModule('h2o.favorites'))
			throw new Main\SystemException(Loc::getMessage("H2O_FAVORITES_MODULE_NOT_INSTALL"));
		if (!Loader::includeModule('iblock'))
			throw new Main\SystemException(Loc::getMessage("IBLOCK_MODULE_NOT_INSTALL"));

	}

	/**
	 * Function processes and corrects $_REQUEST. Everyting about $_REQUEST lies here.
	 * @return void
	 */
	protected function processRequest()
	{
		$this->requestData = Context::getCurrent()->getRequest();

		$this->prepareFilter();
	}

	/**
	 * Creates filter for CSaleOrder::GetList() based on $_REQUEST and other parameters
	 * @return void
	 */
	protected function prepareFilter()
	{
		global $USER;
		global $DB;

		$arFilter = array();

		if($USER->IsAuthorized()){
			$arFilter['USER_ID'] = $USER->GetID();
		}else{
			$arFilter['COOKIE_USER_ID'] = self::getCookieUserID();
		}
		$arFilter['ACTIVE'] = 'Y';
		if(strlen($this->arParams["FILTER_NAME"])<=0 || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $this->arParams["FILTER_NAME"]))
		{
			$arrFilter = array();
		}
		else
		{
			$arrFilter = $GLOBALS[$this->arParams["FILTER_NAME"]];
			if(!is_array($arrFilter))
				$arrFilter = array();
		}
		$arFilter = array_merge($arFilter, $arrFilter);
		if (strlen($this->requestData["filter_id"]))
		{
			$arFilter["ID"] = intval($this->requestData["filter_id"]);
		}
		if (strlen($this->requestData["filter_element_id"]))
		{
			$arFilter["ELEMENT_ID"] = intval($this->requestData["filter_element_id"]);
		}

		if (strlen($this->requestData["filter_date_insert_from"]))
		{
			$arFilter[">=DATE_INSERT"] = trim($this->requestData["filter_date_insert_from"]);

			if ($arDate = ParseDateTime(trim($this->requestData["filter_date_insert_from"]), $this->dateFormat))
			{
				if (StrLen(trim($this->requestData["filter_date_insert_from"])) < 11)
				{
					$arDate["HH"] = 23;
					$arDate["MI"] = 59;
					$arDate["SS"] = 59;
				}

				$arFilter[">=DATE_INSERT"] = date($DB->DateFormatToPHP($this->dateFormat), mktime($arDate["HH"], $arDate["MI"], $arDate["SS"], $arDate["MM"], $arDate["DD"], $arDate["YYYY"]));
			}
		}
		if (strlen($this->requestData["filter_date_insert_to"]))
		{
			$arFilter["<=DATE_INSERT"] = trim($this->requestData["filter_date_insert_to"]);

			if ($arDate = ParseDateTime(trim($this->requestData["filter_date_insert_to"]), $this->dateFormat))
			{
				if (StrLen(trim($this->requestData["filter_date_insert_to"])) < 11)
				{
					$arDate["HH"] = 23;
					$arDate["MI"] = 59;
					$arDate["SS"] = 59;
				}

				$arFilter["<=DATE_INSERT"] = date($DB->DateFormatToPHP($this->dateFormat), mktime($arDate["HH"], $arDate["MI"], $arDate["SS"], $arDate["MM"], $arDate["DD"], $arDate["YYYY"]));
			}
		}

		$this->filter = $arFilter;
	}

	/**
	 * Fetches all required data from database. Everyting that connected with data fetch lies here.
	 * @return void
	 */
	protected function obtainData()
	{
		$this->obtainDataReferences();
		$this->obtainDataFavoritess();
	}

	/**
	 * Read some data from database, using cache. Under some info we mean status list, delivery system list and so on.
	 * @throws Main\SystemException
	 * @return void
	 */
	protected function obtainDataReferences()
	{
		if ($this->startCache(array('favor-line')))
		{
			try
			{
				$cachedData = array();

				/////////////////////
				/////////////////////



				/////////////////////
				/////////////////////

			}
			catch (Exception $e)
			{
				$this->abortCache();
				throw $e;
			}

			$this->endCache($cachedData);

		}
		else
			$cachedData = $this->getCacheData();

		$this->dbResult = array_merge($this->dbResult, $cachedData);
	}

	/**
	 * Perform reading main data from database, no cache is used
	 * @return void
	 */
	protected function obtainDataFavoritess()
	{

		$this->dbQueryResult['FAVORITES'] = \h2o\Favorites\FavoritesTable::getList(
			array(
				"filter" => $this->filter,
				"count_total" => true,
			)
		);
	$this->dbResult['COUNT'] = $this->dbQueryResult['FAVORITES']->getCount();
	}

	/**
	 * Move data read from database to a specially formatted $arResult
	 * @return void
	 */
	protected function formatResult()
	{
		$arResult = array();

		$arResult["COUNT"] = $this->dbResult['COUNT'];


		$this->arResult = $arResult;
	}


	/**
	 * Move all errors to $arResult, if there were any
	 * @return void
	 */
	protected function formatResultErrors()
	{
		$errors = array();
		if (!empty($this->errorsFatal))
			$errors['FATAL'] = $this->errorsFatal;
		if (!empty($this->errorsNonFatal))
			$errors['NONFATAL'] = $this->errorsNonFatal;

		if (!empty($errors))
			$this->arResult['ERRORS'] = $errors;

		// backward compatiblity
		$error = each($this->errorsFatal);
		if (!empty($error['value']))
			$this->arResult['ERROR_MESSAGE'] = $error['value'];
	}

	////////////////////////
	// Cache functions
	////////////////////////
	/**
	 * Function checks if cacheing is enabled in component parameters
	 * @return boolean
	 */
	final protected function getCacheNeed()
	{
		return	intval($this->arParams['CACHE_TIME']) > 0 &&
				$this->arParams['CACHE_TYPE'] != 'N' &&
				Config\Option::get("main", "component_cache_on", "Y") == "Y";
	}

	/**
	 * Function perform start of cache process, if needed
	 * @param mixed[]|string $cacheId An optional addition for cache key
	 * @return boolean True, if cache content needs to be generated, false if cache is valid and can be read
	 */
	final protected function startCache($cacheId = array())
	{
		if(!$this->getCacheNeed())
			return true;

		$this->currentCache = Data\Cache::createInstance();

		return $this->currentCache->startDataCache(intval($this->arParams['CACHE_TIME']), $this->getCacheKey($cacheId));
	}

	/**
	 * Function perform start of cache process, if needed
	 * @throws Main\SystemException
	 * @param mixed[] $data Data to be stored in the cache
	 * @return void
	 */
	final protected function endCache($data = false)
	{
		if(!$this->getCacheNeed())
			return;

		if($this->currentCache == 'null')
			throw new Main\SystemException('Cache were not started');

		$this->currentCache->endDataCache($data);
		$this->currentCache = null;
	}

	/**
	 * Function discard cache generation
	 * @throws Main\SystemException
	 * @return void
	 */
	final protected function abortCache()
	{
		if(!$this->getCacheNeed())
			return;

		if($this->currentCache == 'null')
			throw new Main\SystemException('Cache were not started');

		$this->currentCache->abortDataCache();
		$this->currentCache = null;
	}

	/**
	 * Function return data stored in cache
	 * @throws Main\SystemException
	 * @return void|mixed[] Data from cache
	 */
	final protected function getCacheData()
	{
		if(!$this->getCacheNeed())
			return;

		if($this->currentCache == 'null')
			throw new Main\SystemException('Cache were not started');

		return $this->currentCache->getVars();
	}

	/**
	 * Function leaves the ability to modify cache key in future.
	 * @return string Cache key to be used in CPHPCache()
	 */
	final protected function getCacheKey($cacheId = array())
	{
		if(!is_array($cacheId))
			$cacheId = array((string) $cacheId);

		$cacheId['SITE_ID'] = SITE_ID;
		$cacheId['LANGUAGE_ID'] = LANGUAGE_ID;
		// if there are two or more caches with the same id, but with different cache_time, make them separate
		$cacheId['CACHE_TIME'] = intval($this->arResult['CACHE_TIME']);

		if(defined("SITE_TEMPLATE_ID"))
			$cacheId['SITE_TEMPLATE_ID'] = SITE_TEMPLATE_ID;

		return implode('|', $cacheId);
	}

	/**
	 * Получение идентификатора неавторизованного пользователя
	 * @return string
	 */
	public static function getCookieUserID(){
		global $APPLICATION;
		if(isset(self::$cookie_user_id)){
			return self::$cookie_user_id;
		}
		if($cookie_user_id = $APPLICATION->get_cookie("H2O_COOKIE_USER_ID")){
			return $cookie_user_id;
		}else{
			$cookie_user_id = md5(time().randString(10));
			$APPLICATION->set_cookie("H2O_COOKIE_USER_ID", $cookie_user_id);
			self::$cookie_user_id = $cookie_user_id;
			return $cookie_user_id;
		}

	}

	public function executeComponent()
	{
		try
		{
			$this->checkRequiredModules();
			$this->processRequest();

			$this->obtainData();
			$this->formatResult();
		}
		catch (Exception $e)
		{
			$this->errorsFatal[htmlspecialcharsEx($e->getCode())] = htmlspecialcharsEx($e->getMessage());
		}

		$this->formatResultErrors();
		if($this->requestData["AJAX_CALL_FAVORITES_LINE"] == "Y")
		{
			$this->application->RestartBuffer();
		}
		$this->includeComponentTemplate();
		if ($this->requestData["AJAX_CALL_FAVORITES_LINE"] == "Y")
		{
			die();
		}
	}
	
}