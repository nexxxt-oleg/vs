<?php
namespace h2o\Favorites;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class FavoritesTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> ACTIVE bool optional default 'Y'
 * <li> DATE_INSERT datetime mandatory
 * <li> DATE_UPDATE datetime optional
 * <li> USER_ID int optional
 * <li> COOKIE_USER_ID string(64) optional
 * <li> ELEMENT_ID int mandatory
 * </ul>
 *
 * @package Bitrix\Favorites
 **/

class FavoritesTable extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'h2o_favorites';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
				'title' => Loc::getMessage('FAVORITES_ENTITY_ID_FIELD'),
			),
			'ACTIVE' => array(
				'editable' => true,
				'data_type' => 'boolean',
				'values' => array('N', 'Y'),
				'title' => Loc::getMessage('FAVORITES_ENTITY_ACTIVE_FIELD'),
			),
			'DATE_INSERT' => array(
				'data_type' => 'datetime',
				'required' => true,
				'title' => Loc::getMessage('FAVORITES_ENTITY_DATE_INSERT_FIELD'),
			),
			'DATE_UPDATE' => array(
				'data_type' => 'datetime',
				'title' => Loc::getMessage('FAVORITES_ENTITY_DATE_UPDATE_FIELD'),
			),
			'USER_ID' => array(
				'editable' => true,
				'data_type' => 'integer',
				'title' => Loc::getMessage('FAVORITES_ENTITY_USER_ID_FIELD'),
			),
			'COOKIE_USER_ID' => array(
				'data_type' => 'string',
				'validation' => array(__CLASS__, 'validateCookieUserId'),
				'title' => Loc::getMessage('FAVORITES_ENTITY_COOKIE_USER_ID_FIELD'),
			),
			'ELEMENT_ID' => array(
				'editable' => true,
				'data_type' => 'integer',
				'required' => true,
				'title' => Loc::getMessage('FAVORITES_ENTITY_ELEMENT_ID_FIELD'),
			),
		);
	}
	/**
	 * Returns validators for COOKIE_USER_ID field.
	 *
	 * @return array
	 */
	public static function validateCookieUserId()
	{
		return array(
			new Main\Entity\Validator\Length(null, 64),
		);
	}

	public static function onBeforeUpdate(\Bitrix\Main\Entity\Event $event)
	{
		$result = new \Bitrix\Main\Entity\EventResult;
		$result->modifyFields(array('DATE_UPDATE' => new \Bitrix\Main\Type\DateTime()));
		return $result;
	}
}