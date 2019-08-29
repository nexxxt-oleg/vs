<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<section class="page-all-sect page-login">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="page-all-sect__top-title">
                    <h2><?= GetMessage("AUTH_PLEASE_AUTH") ?></h2>
                </div>
            </div>
        </div>
        <? if (!empty($arParams["~AUTH_RESULT"])):
            $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
            ?>
            <div class="alert row alert-danger"><?= nl2br(htmlspecialcharsbx($text)) ?></div>
        <? endif ?>

        <? if ($arResult['ERROR_MESSAGE'] <> ''):
            $text = str_replace(array("<br>", "<br />"), "\n", $arResult['ERROR_MESSAGE']);
            ?>
            <div class="alert row alert-danger"><?= nl2br(htmlspecialcharsbx($text)) ?></div>
        <? endif ?>
        <div class="row">
            <form class="login-form" name="form_auth" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">
                <input type="hidden" name="AUTH_FORM" value="Y"/>
                <input type="hidden" name="TYPE" value="AUTH"/>
                <? if (strlen($arResult["BACKURL"]) > 0): ?>
                    <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                <? endif ?>
                <? foreach ($arResult["POST"] as $key => $value): ?>
                    <input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
                <? endforeach ?>
                <p class="login-form__input form-field">
                    <input type="text" class="form-field__input" placeholder="<?= GetMessage("AUTH_LOGIN") ?>" name="USER_LOGIN" maxlength="255"
                           value="<?= $arResult["LAST_LOGIN"] ?>" required>
                </p>
                <? if ($arResult["SECURE_AUTH"]): ?>
                    <div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none">
                        <div class="bx-authform-psw-protected-desc"><span></span><? echo GetMessage("AUTH_SECURE_NOTE") ?></div>
                    </div>

                    <script type="text/javascript">
                        document.getElementById('bx_auth_secure').style.display = '';
                    </script>
                <? endif ?>
                <p class="login-form__input form-field">
                    <input type="password" class="form-field__input" placeholder="<?= GetMessage("AUTH_PASSWORD") ?>" name="USER_PASSWORD"
                           maxlength="255" autocomplete="off">
                </p>

                <? if ($arResult["CAPTCHA_CODE"]): ?>
                    <input type="hidden" name="captcha_sid" value="<? echo $arResult["CAPTCHA_CODE"] ?>"/>

                    <div class="bx-authform-formgroup-container dbg_captha">
                        <div class="bx-authform-label-container">
                            <? echo GetMessage("AUTH_CAPTCHA_PROMT") ?>
                        </div>
                        <div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<? echo $arResult["CAPTCHA_CODE"] ?>" width="180"
                                                     height="40"
                                                     alt="CAPTCHA"/></div>
                        <div class="bx-authform-input-container">
                            <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
                        </div>
                    </div>
                <? endif; ?>

                <? if ($arResult["STORE_PASSWORD"] == "Y"): ?>
                    <p class="login-form__remember-me form-checkbox">
                        <input class="form-checkbox__input" type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y"/>
                        <label class="form-checkbox__label" for="USER_REMEMBER">
                            <span><?= GetMessage("AUTH_REMEMBER_ME") ?></span>
                        </label>
                    </p>
                <? endif ?>

                <p class="login-form__button">
                    <input class="btn btn_color_ac" type="submit" class="btn btn-primary" name="Login" value="<?= GetMessage("AUTH_AUTHORIZE") ?>"/>
                </p>
                <? if ($arParams["NOT_SHOW_LINKS"] != "Y"): ?>
                    <p class="login-form__psw">
                        <a href="<?= $arResult["AUTH_FORGOT_PASSWORD_URL"] ?>" rel="nofollow"><b><?= GetMessage("AUTH_FORGOT_PASSWORD_2") ?></b></a>
                    </p>
                <? endif; ?>

                <? if ($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"): ?>
                    <noindex>
                        <p class="login-form__register">
                            <?= GetMessage("AUTH_FIRST_ONE") ?><br/>
                            <a href="<?= $arResult["AUTH_REGISTER_URL"] ?>" rel="nofollow"><b><?= GetMessage("AUTH_REGISTER") ?></b></a>
                        </p>
                    </noindex>
                <? endif ?>
            </form>
        </div>
    </div>
    </div>
</section>

<script type="text/javascript">
    <?if (strlen($arResult["LAST_LOGIN"]) > 0):?>
    try {
        document.form_auth.USER_PASSWORD.focus();
    } catch (e) {
    }
    <?else:?>
    try {
        document.form_auth.USER_LOGIN.focus();
    } catch (e) {
    }
    <?endif?>
</script>

