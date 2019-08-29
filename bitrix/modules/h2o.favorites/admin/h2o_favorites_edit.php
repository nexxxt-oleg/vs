<?
use Bitrix\Main\Loader;

// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/h2o.favorites/admin/tools.php");

Loader::includeModule('h2o.favorites');
// подключим языковой файл
IncludeModuleLangFile(__FILE__);


global $DB;
// сформируем список закладок
$aTabs = array(
  array("DIV" => "edit1", "TAB" => GetMessage("H2O_FAVORITES_TAB_MAIN"), "ICON"=>"main_user_edit", "TITLE"=>GetMessage("H2O_FAVORITES_TAB_MAIN")),
  
);
$tabControl = new CAdminTabControl("tabControl", $aTabs);

$ID = intval($ID);		// идентификатор редактируемой записи
$message = null;		// сообщение об ошибке
$bVarsFromForm = false; // флаг "Данные получены с формы", обозначающий, что выводимые данные получены с формы, а не из БД.

// ******************************************************************** //
//                ОБРАБОТКА ИЗМЕНЕНИЙ ФОРМЫ                             //
// ******************************************************************** //

if(
    $REQUEST_METHOD == "POST" // проверка метода вызова страницы
    &&
    ($save!="" || $apply!="") // проверка нажатия кнопок "Сохранить" и "Применить"
    &&
    check_bitrix_sessid()     // проверка идентификатора сессии
)
{
  
  $arMap = \h2o\Favorites\FavoritesTable::getMap();
  $arFields = array();
  foreach($arMap as $key => $field){
  	if(isset($_REQUEST[$key]) && $field['editable']){
  		$arFields[$key] = $_REQUEST[$key];
  	}elseif($field['data_type'] == 'boolean' && $field['editable']){
  		$arFields[$key] = "N";
  	}
  }
 
  
  // сохранение данных
  if($ID > 0)
  {
    $result = \h2o\Favorites\FavoritesTable::update($ID, $arFields);
  }
  else
  {
  	$arFields['CREATED'] = new \Bitrix\Main\Type\DateTime();
    $result = \h2o\Favorites\FavoritesTable::add($arFields);
    if($result->isSuccess()){
    	$ID = $result->getId();
    }
  }

  if($result->isSuccess())
  {
    // если сохранение прошло удачно - перенаправим на новую страницу 
    // (в целях защиты от повторной отправки формы нажатием кнопки "Обновить" в браузере)
    if ($apply != "")
      // если была нажата кнопка "Применить" - отправляем обратно на форму.
  
      LocalRedirect("/bitrix/admin/H2O_FAVORITES_edit.php?ID=".$ID."&mess=ok&lang=".LANG."&".$tabControl->ActiveTabParam());
    else
      // если была нажата кнопка "Сохранить" - отправляем к списку элементов.
      LocalRedirect("/bitrix/admin/H2O_FAVORITES_list.php?lang=".LANG);
  }
  else
  {
    // если в процессе сохранения возникли ошибки - получаем текст ошибки и меняем вышеопределённые переменные
    if($e = $result->getErrorMessages())
      $message = new CAdminMessage(GetMessage("H2O_FAVORITES_ERROR").implode("; ",$e));
    $bVarsFromForm = true;
  }
}

// ******************************************************************** //
//                ВЫБОРКА И ПОДГОТОВКА ДАННЫХ ФОРМЫ                     //
// ******************************************************************** //


// выборка данных
if($ID>0)
{
	$res = \h2o\Favorites\FavoritesTable::getById($ID);
  
  if(!$favorites_element = $res->fetch())
    $ID=0;
}


// если данные переданы из формы, инициализируем их
if($bVarsFromForm)
  $DB->InitTableVarsForEdit("b_list_favorites", "", "str_");

// ******************************************************************** //
//                ВЫВОД ФОРМЫ                                           //
// ******************************************************************** //

// установим заголовок страницы
$APPLICATION->SetTitle(($ID>0? GetMessage("H2O_FAVORITES_EDIT_TITLE").$ID : GetMessage("H2O_FAVORITES_ADD_TITLE")));

// не забудем разделить подготовку данных и вывод
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

// конфигурация административного меню
$aMenu = array(
  array(
    "TEXT"=>GetMessage("H2O_FAVORITES_LIST"),
    "TITLE"=>GetMessage("H2O_FAVORITES_LIST_TITLE"),
    "LINK"=>"h2o_favorites_list.php?lang=".LANG,
    "ICON"=>"btn_list",
  )
);

if($ID>0)
{
  $aMenu[] = array("SEPARATOR"=>"Y");
  $aMenu[] = array(
    "TEXT"=>GetMessage("H2O_FAVORITES_ADD"),
    "TITLE"=>GetMessage("H2O_FAVORITES_ADD"),
    "LINK"=>"h2o_favorites_edit.php?lang=".LANG,
    "ICON"=>"btn_new",
  );
  $aMenu[] = array(
    "TEXT"=>GetMessage("H2O_FAVORITES_DELETE"),
    "TITLE"=>GetMessage("H2O_FAVORITES_DELETE"),
    "LINK"=>"javascript:if(confirm('".GetMessage("H2O_FAVORITES_DELETE_CONF")."'))window.location='H2O_FAVORITES_list.php?ID=".$ID."&action=delete&lang=".LANG."&".bitrix_sessid_get()."';",
    "ICON"=>"btn_delete",
  );
  
}

// создание экземпляра класса административного меню
$context = new CAdminContextMenu($aMenu);

// вывод административного меню
$context->Show();
?>

<?
// если есть сообщения об ошибках или об успешном сохранении - выведем их.
if($_REQUEST["mess"] == "ok" && $ID>0)
  CAdminMessage::ShowMessage(array("MESSAGE"=>GetMessage("H2O_FAVORITES_SAVED"), "TYPE"=>"OK"));

if($message)
  echo $message->Show();
elseif($favorites_element->LAST_ERROR!="")
  CAdminMessage::ShowMessage($favorites_element->LAST_ERROR);
?>

<?
// далее выводим собственно форму
?>
<form method="POST" action="<?echo $APPLICATION->GetCurPage()?>" enctype="multipart/form-data" name="favorites_edit_form">
<?// проверка идентификатора сессии ?>
<?echo bitrix_sessid_post();?>
<?
// отобразим заголовки закладок
$tabControl->Begin();
CJSCore::Init(array('date'));
?>
<?
//********************
// первая закладка - форма редактирования параметров рассылки
//********************
$tabControl->BeginNextTab();

$arMap = \h2o\Favorites\FavoritesTable::getMap();
foreach($arMap as $code => $field):
	if($field['hidden'] || $code == 'ID'){
		continue;
	}
	if($ID == 0 && !$field['editable']){
		continue;
	}
?>
  <tr>
    <td width="40%">
    	<?if($field['required']):?>
			<span class="adm-required-field"><?echo $field['title']?>:</span>
		<?else:?>
			<?echo $field['title']?>:
		<?endif;?>
	</td>
    <td width="60%">
		<?if($field['editable']):?>
			<?switch($field['data_type']){
				case 'datetime':
					echo CAdminCalendar::CalendarDate($code, $favorites_element[$code]->toString(), 19, true);
					break;
				case 'boolean':
					?><input type="checkbox" name="<?=$code?>" value="Y"<?if($favorites_element[$code] == "Y") echo " checked"?>/>	<?
					break;	
				case 'integer':
				case 'string':
					if($code == 'ELEMENT_ID'){
						\h2o\Favorites\H2oFavoritesTools::ShowElementField($code,$field,array($favorites_element[$code]));
					}elseif($code == 'USER_ID'){
						print \h2o\Favorites\H2oFavoritesTools::ShowUserField($code,$field,array("VALUE" => $favorites_element[$code]));
					}else{
						?><input type="text" name="<?=$code?>" value="<?=$favorites_element[$code]?>"/>	<?
					}
					break;
			}?>
				
			
			
		<?else:?>
			<?if(is_object($favorites_element[$code])):?>
				<?if(method_exists($favorites_element[$code],'toString')):?>
					<?=$favorites_element[$code]->toString();?>
				<?endif;?>
			<?else:?>
				<?=$favorites_element[$code]?>
			<?endif;?>
		<?endif;?>
		</td>
  </tr>
<?endforeach;?>
  
<?

// завершение формы - вывод кнопок сохранения изменений
$tabControl->Buttons(
  array(
    "disabled"=>false,
    "back_url"=>"rubric_admin.php?lang=".LANG,
    
  )
);
?>
<input type="hidden" name="lang" value="<?=LANG?>">
<?if($ID>0 && !$bCopy):?>
  <input type="hidden" name="ID" value="<?=$ID?>">
<?endif;?>
<?
// завершаем интерфейс закладок
$tabControl->End();
?>

<?
// дополнительное уведомление об ошибках - вывод иконки около поля, в котором возникла ошибка
$tabControl->ShowWarnings("favorites_edit_form", $message);
?>


<?
// информационная подсказка
echo BeginNote();?>

<span class="required">*</span><?echo GetMessage("REQUIRED_FIELDS")?>
<?echo EndNote();?>

<?
// завершение страницы
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>