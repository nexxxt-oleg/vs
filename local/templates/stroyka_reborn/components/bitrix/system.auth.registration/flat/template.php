<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if ($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) && $arParams["AUTH_RESULT"]["TYPE"] === "OK"): ?>
    <div class="alert alert-success"><? echo GetMessage("AUTH_EMAIL_SENT") ?></div>
<? else: ?>

    <? if ($arResult["USE_EMAIL_CONFIRMATION"] === "Y"): ?>
        <div class="alert alert-warning"><? echo GetMessage("AUTH_EMAIL_WILL_BE_SENT") ?></div>
    <? endif ?>
    <section class="page-all-sect page-login">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="page-all-sect__top-title">
                        <h2>Регистрация</h2>
                    </div>
                </div>
            </div>
            <?
            if (!empty($arParams["~AUTH_RESULT"])):
                $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
                ?>
                <div class="alert row <?= ($arParams["~AUTH_RESULT"]["TYPE"] == "OK" ? "alert-success" : "alert-danger") ?>"><?= nl2br(htmlspecialcharsbx($text)) ?></div>
            <? endif ?>

            <div class="row">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                    <noindex>
                        <form method="post" action="<?= $arResult["AUTH_URL"] ?>" name="bform" class="register-form">
                            <? if ($arResult["BACKURL"] <> ''): ?>
                                <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                            <? endif ?>
                            <input type="hidden" name="AUTH_FORM" value="Y"/>
                            <input type="hidden" name="TYPE" value="REGISTRATION"/>

                            <div class="register-form__input form-field">
                                <input type="text" class="form-field__input" placeholder="<?= GetMessage("AUTH_NAME") ?>" name="USER_NAME"
                                       maxlength="255" value="<?= $arResult["USER_NAME"] ?>" required>
                            </div>
                            <div class="register-form__input form-field">
                                <input type="text" class="form-field__input" placeholder="<?= GetMessage("AUTH_LAST_NAME") ?>" name="USER_LAST_NAME"
                                       maxlength="255" value="<?= $arResult["USER_LAST_NAME"] ?>" required>
                        </div>
                        <div class=" register-form__input form-field">
                                <input type="text" class="form-field__input" placeholder="*<?= GetMessage("AUTH_LOGIN_MIN") ?>" name="USER_LOGIN"
                                       maxlength="255" value="<?= $arResult["USER_LOGIN"] ?>" required>
                            </div>
                            <div class="register-form__input form-field">
                                <? if ($arResult["SECURE_AUTH"]): ?>
                                    <div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none">
                                        <div class="bx-authform-psw-protected-desc"><span></span><? echo GetMessage("AUTH_SECURE_NOTE") ?></div>
                                    </div>
                                    <script type="text/javascript">
                                        document.getElementById('bx_auth_secure').style.display = '';
                                    </script>
                                <? endif ?>
                                <input type="password" class="form-field__input" placeholder="*<?= GetMessage("AUTH_PASSWORD_REQ") ?>"
                                       name="USER_PASSWORD" maxlength="255" value="<?= $arResult["USER_PASSWORD"] ?>" autocomplete="off">
                            </div>
                            <div class="register-form__input form-field">
                                <? if ($arResult["SECURE_AUTH"]): ?>
                                    <div class="bx-authform-psw-protected" id="bx_auth_secure_conf" style="display:none">
                                        <div class="bx-authform-psw-protected-desc"><span></span><? echo GetMessage("AUTH_SECURE_NOTE") ?></div>
                                    </div>
                                    <script type="text/javascript">
                                        document.getElementById('bx_auth_secure_conf').style.display = '';
                                    </script>
                                <? endif; ?>
                                <input type="password" class="form-field__input" placeholder="*<?= GetMessage("AUTH_CONFIRM") ?>"
                                       name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?= $arResult["USER_CONFIRM_PASSWORD"] ?>"
                                       autocomplete="off">
                            </div>
                            <div class="register-form__input form-field">
                                <input type="email" class="form-field__input"
                                       placeholder="<?= $arResult["EMAIL_REQUIRED"] ? '*' : '' ?><?= GetMessage("AUTH_EMAIL") ?>" name="USER_EMAIL"
                                       maxlength="255" value="<?= $arResult["USER_EMAIL"] ?>" required>
                            </div>

                            <? if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
                                <? foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): ?>
                                    <div class="register-form__input form-field">
                                        <div class="bx-authform-label-container"><? if ($arUserField["MANDATORY"] == "Y"): ?>
                                                <span class="bx-authform-starrequired">*</span><? endif ?><?= $arUserField["EDIT_FORM_LABEL"] ?>
                                        </div>

                                        <?
                                        $APPLICATION->IncludeComponent(
                                            "bitrix:system.field.edit",
                                            $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                                            array(
                                                "bVarsFromForm" => $arResult["bVarsFromForm"],
                                                "arUserField" => $arUserField,
                                                "form_name" => "bform"
                                            ),
                                            null,
                                            array("HIDE_ICONS" => "Y")
                                        );
                                        ?>
                                    </div>
                                <? endforeach; ?>
                            <? endif; ?>
                            <? if ($arResult["USE_CAPTCHA"] == "Y"): ?>
                                <div class="register-form__captcha">
                                    <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
                                    <?= GetMessage("CAPTCHA_REGF_PROMT") ?><br>
                                    <div class="bx-captcha">
                                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40"
                                             alt="CAPTCHA"/>
                                    </div>
                                    <div class="bx-authform-input-container">
                                        <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
                                    </div>
                                </div>
                            <? endif; ?>

                            <div class="register-form__button">
                                <input class="btn btn_color_ac" type="submit" class="btn btn-primary" name="Register"
                                       value="<?= GetMessage("AUTH_REGISTER") ?>"/>
                            </div>

                            <div class="register-form__desc">
                                <?= $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?><br>
                                <span class="bx-authform-starrequired">*</span><?= GetMessage("AUTH_REQ") ?>
                            </div>

                            <div class="register-form__auth">
                                <a href="<?= $arResult["AUTH_AUTH_URL"] ?>" rel="nofollow"><?= GetMessage("AUTH_AUTH") ?></a>
                            </div>
                            <script type="text/javascript">
                                document.bform.USER_NAME.focus();
                            </script>
                        </form>
                    </noindex>
                </div>
            </div>
        </div>
    </section>
<? endif ?>