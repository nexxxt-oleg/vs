<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;

Loc::loadMessages(__FILE__);

class H2oFavoritesAddComponent extends CBitrixComponent
{
	protected $bUseCatalog = null;
	/**
	 * Данные из таблицы h2o_favorites текущего пользователя
	 * @var array or bool
	 */
	protected static $cookie_user_id;
	protected $readyForOrderFilter = array("CAN_BUY" => "Y", "DELAY" => "N", "SUBSCRIBE" => "N");
	protected $default_view_field = array(
		"USER_EMAIL",
		"USER_NAME",
		"USER_PHONE",
		"COMMENT"
	);
	protected $default_required_field = array(
		"USER_EMAIL",
	);
	/**
	 * Fatal error list. Any fatal error makes useless further execution of a component code.
	 * In most cases, there will be only one error in a list according to the scheme "one shot - one dead body"
	 *
	 * @var string[] Array of fatal errors.
	 */

	protected $errorsFatal = array();
	/**
	 * Non-fatal error list. Some non-fatal errors may occur during component execution, so certain functions of the component
	 * may became defunct. Still, user should stay informed.
	 * There may be several non-fatal errors in a list.
	 *
	 * @var string[] Array of non-fatal errors.
	 */
	protected $errorsNonFatal = array();
	protected $requestData = array();
		 
	public function onPrepareComponentParams($arParams)
	{
		return $arParams;
	}
	
	public function onIncludeComponentLang()
	{
		Loc::loadMessages(__FILE__);
	}
	
	
	protected function checkRequiredModules()
	{
		if (!Loader::includeModule('h2o.favorites'))
			throw new Main\SystemException(Loc::getMessage("H2O_FAVORITES_MODULE_NOT_INSTALL"));
		if (!Loader::includeModule('iblock'))
			throw new Main\SystemException(Loc::getMessage("IBLOCK_MODULE_NOT_INSTALL"));
		
	}
	
	protected function processRequest()
	{
		$this->requestData = Context::getCurrent()->getRequest();
	}

	/**
	 * Move data read from database to a specially formatted $arResult
	 * @return void
	 */
	protected function formatResult()
	{
		global $USER;
		$arResult = array();
		$arResult['CURRENT_ELEMENT_IN_FAVORITES'] = array();
		$arFields = array(
			"ACTIVE" => "Y",
		);

		if($USER->IsAuthorized()){
			$arFields['USER_ID'] = $USER->GetID();
		}else{
			$arFields['COOKIE_USER_ID'] = self::getCookieUserID();
		}
		/** find favor */
		$favorDb = \h2o\Favorites\FavoritesTable::getList(array(
			'select' => array('ID', 'ELEMENT_ID'),
			'filter' => $arFields
		));
		while($favorItem = $favorDb->fetch()){
			$arResult['CURRENT_ELEMENT_IN_FAVORITES'][] = $favorItem['ELEMENT_ID'];
		}
		$this->arResult = $arResult;
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

	/**
	 * Function wraps action list evaluation into try-catch block.
	 * @return void
	 */
	private function performActions()
	{
		try
		{
			$this->performActionList();
		}
		catch (Exception $e)
		{
			$this->errorsNonFatal[htmlspecialcharsEx($e->getCode())] = htmlspecialcharsEx($e->getMessage());
		}
	}
	
	/**
	 * Function perform pre-defined list of actions based on current state of $_REQUEST and parameters.
	 * @return void
	 */
	protected function performActionList()
	{
		// add or delete favorites
		$this->performActionCheckFavorites();
	}

	/**
	 * Perform the following action: add favorites
	 * @throws Main\SystemException
	 * @return void
	 */
	protected function performActionCheckFavorites()
	{
		if($this->requestData['h2o_add_favorites'] == 'Y' && !isset($this->arResult['FATAL_ERROR'])){
			$this->checkFavoritesElement($this->requestData["H2O_FAVORITES_ELEMENT_ID"]);
		}
	}

	/**
	 * Функция добавления/удаления элемента избранное
	 * @param $ElementId
	 * @throws Main\SystemException
	 * @return void
	 */
	private function checkFavoritesElement($ElementId){
		global $USER, $DB;
		if($ElementId <= 0){
			throw new Main\SystemException(Loc::getMessage('H2O_FAVORITES_NOT_FIND_ELEMENT'));
		}

		$arFields = array(
			"ELEMENT_ID" => $ElementId,
			"ACTIVE" => "Y",
		);

		if($USER->IsAuthorized()){
			$arFields['USER_ID'] = $USER->GetID();
		}else{
			$arFields['COOKIE_USER_ID'] = self::getCookieUserID();
		}
		/** find favor */
		$favorDb = \h2o\Favorites\FavoritesTable::getList(array(
				'select' => array('ID'),
				'filter' => $arFields
		));
		if($favorItem = $favorDb->fetch()){
			/** delete favor */
			$DB->StartTransaction();
			$result = \h2o\Favorites\FavoritesTable::delete($favorItem['ID']);

			if($result->isSuccess()){
				$DB->Commit();
				$this->doAfterDeleteFavor();
				$this->arResult['SUCCESS'] = array(
					"DELETE" => $favorItem['ID']
				);
			}
			else{
				$DB->Rollback();
				$e = $result->getErrorMessages();
				throw new Main\SystemException(implode(";",$e));
			}
		}else{
			/** add favor */
			$arFields['DATE_INSERT'] = new \Bitrix\Main\Type\DateTime();

			$result = \h2o\Favorites\FavoritesTable::add($arFields);
			if($result->isSuccess()){
				$FAVORITES_ID = $result->getId();
				$this->arResult['SUCCESS'] = array(
					"ADD" => $FAVORITES_ID
				);
			}
			else{
				$e = $result->getErrorMessages();
				throw new Main\SystemException(implode(";",$e));
			}
		}

	}

	/**
	 * The default action in case of success copying order
	 * @return void
	 */
	protected function doAfterDeleteFavor()
	{
		if($_REQUEST['AJAX_CALL_FAVORITES_ADD'] != "Y")
			LocalRedirect();
	}

	protected function formatResultErrors()
	{
		$errors = array();
		if (!empty($this->errorsFatal))
			$errors['FATAL'] = $this->errorsFatal;
		if (!empty($this->errorsNonFatal))
			$errors['NONFATAL'] = $this->errorsNonFatal;


		if (!empty($errors['FATAL']))
			$this->arResult['FATAL_ERROR'] = $errors['FATAL'];
		if (!empty($errors['NONFATAL']))
			$this->arResult['NONFATAL'] = $errors['NONFATAL'];

		// backward compatiblity
		$error = each($this->errorsFatal);
		if (!empty($error['value']))
			$this->arResult['ERROR_MESSAGE'] = $error['value'];
	}

	public function executeComponent()
	{
		global $APPLICATION;
		try{
			$this->checkRequiredModules();
			$this->processRequest();
			$this->formatResult();
			$this->performActions();
		}
		catch (Exception $e){
			$this->errorsFatal[htmlspecialcharsEx($e->getCode())] = htmlspecialcharsEx($e->getMessage());
		}
		
		$this->formatResultErrors();

		if($this->requestData["AJAX_CALL_FAVORITES_ADD"] == "Y")
		{
			$APPLICATION->RestartBuffer();
			if(isset($this->arResult['SUCCESS'])){
				print json_encode($this->arResult['SUCCESS']);
			}
			die();
		}
				
		$this->includeComponentTemplate();

	}

}