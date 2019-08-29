<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<section class="page-all-sect page-login">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="page-all-sect__top-title">
                    <h2>Запрос пароля</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <form class="password-form" name="bform" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">
                    <? if ($arResult["BACKURL"] <> ''): ?>
                        <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                    <? endif ?>
                    <input type="hidden" name="AUTH_FORM" value="Y">
                    <input type="hidden" name="TYPE" value="SEND_PWD">

                    <div class="password-form__desc b-content">
                        <h3><?= GetMessage("AUTH_GET_CHECK_STRING") ?></h3>
                        <p><?= GetMessage("AUTH_FORGOT_PASSWORD_1") ?></p>
                    </div>

                    <div class="password-form__input form-field">
                        <input type="text" class="form-field__input" placeholder="<?= GetMessage("AUTH_LOGIN_EMAIL") ?>" name="USER_LOGIN" maxlength="255" value="<?= $arResult["LAST_LOGIN"] ?>" required>
                        <input type="hidden" name="USER_EMAIL"/>
                    </div>

                    <? if ($arResult["USE_CAPTCHA"]): ?>
                        <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
                        <div class="password-form__input form-field">
                            <div class="bx-authform-label-container"><?= GetMessage("system_auth_captcha") ?></div>
                            <div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40"
                                                         alt="CAPTCHA"/></div>
                            <div class="bx-authform-input-container">
                                <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
                            </div>
                        </div>
                    <? endif ?>

                    <div class="login-form__button">
                        <input class="btn btn_color_ac" type="submit" class="btn btn-primary" name="send_account_info" value="<?= GetMessage("AUTH_SEND") ?>"/>
                    </div>

                    <? if (!empty($arParams["~AUTH_RESULT"])):
                        $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
                        ?>
                        <div class="login-form__passwd-msg b-content <?= ($arParams["~AUTH_RESULT"]["TYPE"] == "OK" ? "alert-success" : "alert-danger") ?>">
                            <h4>
                                <?= nl2br(htmlspecialcharsbx($text)) ?>
                            </h4>
                        </div>
                    <? endif ?>

                    <div class="login-form__auth">
                        <a href="<?= $arResult["AUTH_AUTH_URL"] ?>"><b><?= GetMessage("AUTH_AUTH") ?></b></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    document.bform.onsubmit = function () {
        document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;
    };
    document.bform.USER_LOGIN.focus();
</script>
