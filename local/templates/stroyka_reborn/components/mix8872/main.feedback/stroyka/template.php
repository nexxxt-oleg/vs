<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult["ERROR_MESSAGE"])) {
    foreach ($arResult["ERROR_MESSAGE"] as $v)
        ShowError($v);
}
if (strlen($arResult["OK_MESSAGE"]) > 0) {
    ?>
    <div class="mf-ok-text"><?= $arResult["OK_MESSAGE"] ?></div><?
}
?>

<form action="" method="POST" class="pc-callback-form page-cnt-callback__form">
    <?= bitrix_sessid_post() ?>
    <div class="row">
        <div class="col-sm-4">
            <p class="pc-callback-form__input form-field">
                <input type="text" name="user_name" value="<?= $arResult["AUTHOR_NAME"] ?>" class="form-field__input"
                       placeholder="<?= GetMessage("MFT_NAME") ?><?= empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"]) ? '*' : '' ?>">
            </p>
        </div>
        <div class="col-sm-4">
            <p class="pc-callback-form__input form-field">
                <input type="mail" class="form-field__input" name="user_email" value="<?= $arResult["AUTHOR_EMAIL"] ?>"
                       placeholder="<?= GetMessage("MFT_EMAIL") ?><?= empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"]) ? '*' : '' ?>">
            </p>
        </div>

        <? foreach ($arParams["NEW_EXT_FIELDS"] as $i => $ext_field): ?>
            <div class="col-sm-4">
                <p class="pc-callback-form__input form-field">
                    <input type="text" name="custom[<? $i ?>]" class="form-field__input" placeholder="<?= $ext_field ?>"
                           value="<?= $arResult["custom_$i"] ?>">
                </p>
            </div>
        <? endforeach; ?>

        <div class="col-12">
            <hr class="pc-callback-form__hr">
        </div>
        <div class="col-12">
            <p class="pc-callback-form__textarea form-field">
                <textarea class="form-field__textarea" name="MESSAGE"
                          placeholder="<?= GetMessage("MFT_MESSAGE") ?><?= empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"]) ? '*' : '' ?>"><?= $arResult["MESSAGE"] ?></textarea>
            </p>
        </div>
        <? if ($arParams["USE_CAPTCHA"] == "Y"): ?>
            <div class="col-12">
                <div class="mf-text"><?= GetMessage("MFT_CAPTCHA") ?></div>
                <input type="hidden" name="captcha_sid" value="<?= $arResult["capCode"] ?>">
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["capCode"] ?>" width="180" height="40" alt="CAPTCHA">
                <div class="mf-text"><?= GetMessage("MFT_CAPTCHA_CODE") ?><span class="mf-req">*</span></div>
                <input type="text" name="captcha_word" size="30" maxlength="50" value="">
            </div>
        <? endif; ?>
        <div class="col-sm-8">
            <div class="pc-callback-form__politconf">
                <p>Нажимая «Отправить», я соглашаюсь на обработку персональных данных в соответствии с ФЗ РФ № 152-ФЗ «О персональных данных», а также
                    с политикой конфеденциальности.</p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="pc-callback-form__submit">
                <button type="submit" name="submit" class="btn btn_color_ac" value="<?= GetMessage("MFT_SUBMIT") ?>"><?= GetMessage("MFT_SUBMIT") ?></button>
            </div>
        </div>
    </div>
</form>