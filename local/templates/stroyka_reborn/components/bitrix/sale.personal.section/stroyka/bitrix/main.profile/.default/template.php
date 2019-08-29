<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\Localization\Loc;

?>
<section class="page-all-sect page-profile__order-current">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="page-all-sect__top-title">
                    <h2>Личные данные</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 col-lg-3">
                <div class="page-profile__left-menu categories-left-menu">
                    <? $APPLICATION->IncludeComponent("bitrix:menu", "personal_menu", array(
                        "ROOT_MENU_TYPE" => "personal",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_TYPE" => "A",
                        "CACHE_SELECTED_ITEMS" => "N",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                    ),
                        false
                    ); ?>
                </div>
            </div>
            <div class="col-sm-9 col-lg-5">
                <?
                ShowError($arResult["strProfileError"]);

                if ($arResult['DATA_SAVED'] == 'Y') {
                    ShowNote(Loc::getMessage('PROFILE_DATA_SAVED'));
                }

                ?>
                <form method="post" name="form1" action="<?= $APPLICATION->GetCurUri() ?>" enctype="multipart/form-data"
                      role="form" class="pe-form">
                    <?= $arResult["BX_SESSION_CHECK"] ?>
                    <input type="hidden" name="lang" value="<?= LANG ?>"/>
                    <input type="hidden" name="ID" value="<?= $arResult["ID"] ?>"/>
                    <input type="hidden" name="LOGIN" value="<?= $arResult["arUser"]["LOGIN"] ?>"/>
                    <div class="pe-form__inputs" id="user_div_reg">
                        <div class="pe-form__info">
                            <?
                            if ($arResult["ID"] > 0) {
                                if (strlen($arResult["arUser"]["TIMESTAMP_X"]) > 0) {
                                    ?>
                                    <p>
                                        <span><?= Loc::getMessage('LAST_UPDATE') ?></span>
                                        <span><?= $arResult["arUser"]["TIMESTAMP_X"] ?></span>
                                    </p>
                                    <?
                                }

                                if (strlen($arResult["arUser"]["LAST_LOGIN"]) > 0) {
                                    ?>
                                    <p>
                                        <span><?= Loc::getMessage('LAST_LOGIN') ?></span>
                                        <span><?= $arResult["arUser"]["LAST_LOGIN"] ?></span>
                                    </p>
                                    <?
                                }
                            }
                            ?>
                        </div>
                        <?
                        if (!in_array(LANGUAGE_ID, array('ru', 'ua'))) {
                            ?>
                            <p class="pe-form__input form-field">
                                <input
                                        type="text"
                                        name="TITLE"
                                        maxlength="50"
                                        id="main-profile-title"
                                        class="form-field__input"
                                        placeholder="<?= Loc::getMessage('main_profile_title') ?>"
                                        value="<?= $arResult["arUser"]["TITLE"] ?>"
                                />
                            </p>
                            <?
                        }
                        ?>
                        <p class="pe-form__input form-field">
                            <input
                                    type="text"
                                    name="NAME"
                                    maxlength="50"
                                    id="main-profile-name"
                                    class="form-field__input"
                                    placeholder="<?= Loc::getMessage('NAME') ?>"
                                    value="<?= $arResult["arUser"]["NAME"] ?>"
                            />
                        </p>
                        <p class="pe-form__input form-field">
                            <input
                                    type="text"
                                    name="LAST_NAME"
                                    maxlength="50"
                                    id="main-profile-last-name"
                                    class="form-field__input"
                                    placeholder="<?= Loc::getMessage('LAST_NAME') ?>"
                                    value="<?= $arResult["arUser"]["LAST_NAME"] ?>"
                            />
                        </p>
                        <p class="pe-form__input form-field">
                            <input
                                    type="text"
                                    name="SECOND_NAME"
                                    maxlength="50"
                                    id="main-profile-second-name"
                                    class="form-field__input"
                                    placeholder="<?= Loc::getMessage('SECOND_NAME') ?>"
                                    value="<?= $arResult["arUser"]["SECOND_NAME"] ?>"
                            />
                        </p>
                        <p class="pe-form__input form-field">
                            <input
                                    type="text"
                                    name="EMAIL"
                                    maxlength="50"
                                    id="main-profile-email"
                                    class="form-field__input"
                                    placeholder="<?= Loc::getMessage('EMAIL') ?>"
                                    value="<?= $arResult["arUser"]["EMAIL"] ?>"
                            />
                        </p>
                        <p class="pe-form__input form-field">
                            <input
                                    type="text"
                                    name="PERSONAL_PHONE"
                                    maxlength="50"
                                    id="main-profile-personal-phone"
                                    class="form-field__input"
                                    placeholder="<?= Loc::getMessage('PERSONAL_PHONE') ?>"
                                    value="<?= $arResult["arUser"]["PERSONAL_PHONE"] ?>"
                            />
                        </p>
                        <?
                        if ($arResult["arUser"]["EXTERNAL_AUTH_ID"] == '') {
                            ?>
                            <!-- <p class="pe-form__input"> -->
                            <? //=  $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?>
                            <!-- </p> -->
                            <p class="pe-form__input pe-form__input_password-first form-field">
                                <input
                                        type="password"
                                        name="NEW_PASSWORD"
                                        maxlength="50"
                                        id="main-profile-password"
                                        class="form-field__input"
                                        placeholder="<?= Loc::getMessage('NEW_PASSWORD_REQ') ?>"
                                        value=""
                                        autocomplete="off"
                                />
                            </p>
                            <p class="pe-form__input form-field">
                                <input
                                        type="password"
                                        name="NEW_PASSWORD_CONFIRM"
                                        maxlength="50"
                                        id="main-profile-password-confirm"
                                        class="form-field__input"
                                        placeholder="<?= Loc::getMessage('NEW_PASSWORD_CONFIRM') ?>"
                                        value=""
                                        autocomplete="off"
                                />
                            </p>
                            <?
                        }
                        ?>
                    </div>
                    <div class="pe-form__bottom">
                        <button type="submit" name="save"
                                class="btn btn_color_ac"><?= (($arResult["ID"] > 0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD")) ?></button>
                        <button type="submit" name="reset" class="btn"><? echo GetMessage("MAIN_RESET") ?></button>
                        <input type="hidden" name="save" value="Y">
                    </div>
                </form>
                <div class="col-sm-12 main-profile-social-block">
                    <?
                    if ($arResult["SOCSERV_ENABLED"]) {
                        $APPLICATION->IncludeComponent("bitrix:socserv.auth.split", ".default", array(
                            "SHOW_PROFILES" => "Y",
                            "ALLOW_DELETE" => "Y"
                        ),
                            false
                        );
                    }
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>