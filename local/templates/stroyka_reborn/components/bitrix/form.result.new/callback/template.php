<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<? if ($arResult["isFormErrors"] == "Y"): ?><?= $arResult["FORM_ERRORS_TEXT"]; ?><? endif; ?>



<? if ($arResult["isFormNote"] != "Y") {
    $arResult["FORM_HEADER"] = preg_replace('/action/ui', 'class="popup-callback__form ajax-form" action', $arResult["FORM_HEADER"]);
    ?>
    <button class="popup__close js-tgl-callback">
        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/del.svg") ?>" class="img-svg">
    </button>
    <?= $arResult["FORM_HEADER"] ?>
    <h2 class="popup-callback__title">Заказать звонок</h2>
    <? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion): ?>
        <? if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'): ?>
            <?= preg_replace('/value="*"/ui', 'value="' . $APPLICATION->sDocTitle . '"', $arQuestion["HTML_CODE"]) ?>
        <? else: ?>
            <div class="popup-callback__input form-field">
                <?= $arQuestion["HTML_CODE"] ?>
            </div>
        <? endif; ?>
    <? endforeach; ?>
    <div class="popup-callback__politconf">
        <p>Заполняя данную форму, Вы принимаете условия Политики конфиденциальности и Пользовательского соглашения</p>
    </div>
    <input type="hidden" name="web_form_apply" value="Y"/>
    <div class="popup-callback__button">
        <button <?= (intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : ""); ?>
                class="btn btn_color_ac"
                type="submit" name="web_form_submit"
                value="<?= htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>">
            <?= htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>
        </button>
    </div>

    <? if ($arResult["isUseCaptcha"] == "Y") {
        ?>
        <th colspan="2"><b><?= GetMessage("FORM_CAPTCHA_TABLE_TITLE") ?></b></th>
        <input type="hidden" name="captcha_sid" value="<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>"/><img
                src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>"
                width="180"
                height="40"/>
        <?= GetMessage("FORM_CAPTCHA_FIELD_TITLE") ?><?= $arResult["REQUIRED_SIGN"]; ?></td>
        <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext"/>

        <?
    } // isUseCaptcha?>
    <?= $arResult["FORM_FOOTER"] ?>
    <? } else { ?>

    <?php if( !empty($arResult["FORM_NOTE"]) ):?>
        <?php $arTitle = explode("!", $arResult["FORM_NOTE"], 2) ?>
        <div class="popup-wrap__message-success">
            <h2 class="popup-callback__title"><?=$arTitle['0']?></h2>
            <div class="popup-callback__desc b-content">
                <p><?=$arTitle['1']?></p>
            </div>

            <img src="<?= $APPLICATION->GetTemplatePath("img/form-success.svg")?>" class="img-svg popup-callback__img-success">
        </div>
   <?php endif;?>

<? } //endif (isFormNote)
