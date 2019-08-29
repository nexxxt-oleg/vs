<?php
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

$moduleId = 'artofbx.yandexmetrika';

if (!$USER->IsAdmin()) {
    return;
}

CUtil::InitJSCore(array('jquery'));

Loc::loadMessages(__FILE__);

$sort = 'DEF';
$order = 'desc';
$resList = CSite::GetList($sort, $order);
$arSites = array();
while ($arSite = $resList->Fetch()) {
    $arSites[$arSite['LID']] = $arSite['NAME'];
}

$siteId = $_REQUEST['site_id'] ? $_REQUEST['site_id'] : current(array_keys($arSites));

$arAllOptions = array(
    array("active", Loc::getMessage('MODULE_YANDEX_METRIKA_ACTIVE'), "", array("checkbox")),
    array("id", Loc::getMessage('MODULE_YANDEX_METRIKA_ID'), "", array("text", 20)),
    array("webvisor", Loc::getMessage('MODULE_YANDEX_METRIKA_WEBVISOR'), "", array("checkbox")),
    array("clickmap", Loc::getMessage('MODULE_YANDEX_METRIKA_CLICKMAP'), "", array("checkbox")),
    array("track_links", Loc::getMessage('MODULE_YANDEX_METRIKA_TRACK_LINKS'), "", array("checkbox")),
    array(
        "accurate_track_bounce",
        Loc::getMessage('MODULE_YANDEX_METRIKA_ACCURATE_TRACK_BOUNCE'),
        "",
        array("checkbox")
    ),
    array("noindex", Loc::getMessage('MODULE_YANDEX_METRIKA_NOINDEX'), "", array("checkbox")),
    array("track_hash", Loc::getMessage('MODULE_YANDEX_METRIKA_TRACK_HASH'), "", array("checkbox")),
    //array("informer", Loc::getMessage('MODULE_YANDEX_METRIKA_INFORMER'), "", array("textarea", 6, 50)),
    array("ignore_admin", Loc::getMessage('MODULE_YANDEX_METRIKA_IGNORE_ADMIN'), "", array("checkbox")),
    array(
        "ignore_authorized",
        Loc::getMessage('MODULE_YANDEX_METRIKA_IGNORE_AUTHORIZED'),
        "",
        array("checkbox")
    ),
);

$aTabs = array(
    array(
        "DIV" => "edit1",
        "TAB" => Loc::getMessage("MAIN_TAB_SET"),
        "ICON" => "ib_settings",
        "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_SET")
    ),
);
$tabControl = new CAdminTabControl("tabControl", $aTabs);

if ($REQUEST_METHOD == "POST" && strlen($Update) > 0 && check_bitrix_sessid() && $_REQUEST['change_site'] == 0) {
    foreach ($arAllOptions as $arOption) {
        $name = $arOption[0];
        $val = $_REQUEST[$name];
        if ($arOption[2][0] == "checkbox" && $val != "Y") {
            $val = "N";
        }
        Option::set($moduleId, $name, $val, $siteId);
    }
    LocalRedirect($APPLICATION->GetCurPage() . "?mid=" . urlencode($mid) . "&lang=" . urlencode(LANGUAGE_ID) . "&" . $tabControl->ActiveTabParam() . '&site_id=' . $siteId);
}


$tabControl->Begin();
?>
<form method="post"
      action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?= urlencode($mid) ?>&amp;lang=<? echo LANGUAGE_ID ?>">
    <? $tabControl->BeginNextTab(); ?>
    <tr>
        <td width="40%" nowrap>
            <label for="site_id"><?= Loc::getMessage('MODULE_YANDEX_METRIKA_SITE') ?>:</label>
        <td width="60%">
            <input type="hidden" name="change_site" id="change_site" value="0"/>
            <select name="site_id" onchange="$('#change_site').val(1); $(this).parents('form').submit();">
                <? foreach ($arSites as $value => $label): ?>
                    <option value="<?= $value ?>"
                            <? if ($siteId == $value): ?>selected="selected" <? endif; ?>><?= $label ?></option>
                <? endforeach; ?>
            </select>
        </td>
    </tr>
    <?
    foreach ($arAllOptions as $arOption):
        $val = Option::get($moduleId, $arOption[0], $arOption[2], $siteId);
        $type = $arOption[3];
        ?>
        <tr>
            <td width="40%" nowrap <?= $type[0] == "textarea" ? 'class="adm-detail-valign-top"' : '' ?>>
                <label for="<? echo htmlspecialcharsbx($arOption[0]) ?>"><? echo $arOption[1] ?>:</label>
            </td>
            <td width="60%">
                <? if ($type[0] == "checkbox"): ?>
                    <input type="checkbox" id="<? echo htmlspecialcharsbx($arOption[0]) ?>"
                           name="<? echo htmlspecialcharsbx($arOption[0]) ?>" value="Y"<? if ($val == "Y") {
                        echo " checked";
                    } ?>>
                <? elseif ($type[0] == "text"): ?>
                    <input type="text" size="<? echo $type[1] ?>" maxlength="255"
                           value="<? echo htmlspecialcharsbx($val) ?>"
                           name="<? echo htmlspecialcharsbx($arOption[0]) ?>">
                <? elseif ($type[0] == "textarea"): ?>
                    <textarea rows="<? echo $type[1] ?>" cols="<? echo $type[2] ?>"
                              name="<? echo htmlspecialcharsbx($arOption[0]) ?>"><? echo htmlspecialcharsbx($val) ?></textarea>
                <? endif ?>
            </td>
        </tr>
    <? endforeach ?>
    <? $tabControl->Buttons(); ?>
    <input type="submit" name="Update" value="<?= Loc::getMessage("MAIN_SAVE") ?>"
           title="<?= Loc::getMessage("MAIN_OPT_SAVE_TITLE") ?>" class="adm-btn-save">
    <?= bitrix_sessid_post(); ?>
    <? $tabControl->End(); ?>
</form>