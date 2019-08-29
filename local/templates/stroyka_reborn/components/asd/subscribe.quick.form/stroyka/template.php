<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

if (method_exists($this, 'setFrameMode')) {
	$this->setFrameMode(true);
}
?>

<div class="container">
    <form class="row">
        <?= bitrix_sessid_post()?>
        <input type="hidden" name="asd_subscribe" value="Y" />
        <input type="hidden" name="charset" value="<?= SITE_CHARSET?>" />
        <input type="hidden" name="site_id" value="<?= SITE_ID?>" />
        <input type="hidden" name="asd_rubrics" value="<?= $arParams['RUBRICS_STR']?>" />
        <input type="hidden" name="asd_format" value="<?= $arParams['FORMAT']?>" />
        <input type="hidden" name="asd_show_rubrics" value="<?= $arParams['SHOW_RUBRICS']?>" />
        <input type="hidden" name="asd_not_confirm" value="<?= $arParams['NOT_CONFIRM']?>" />
        <input type="hidden" name="asd_key" value="<?= md5($arParams['JS_KEY'].$arParams['RUBRICS_STR'].$arParams['SHOW_RUBRICS'].$arParams['NOT_CONFIRM'])?>" />

        <? if ($arResult['ACTION']['status']=='error' || $arResult['ACTION']['status']=='ok') { ?>
            <div class="col-12 col-lg-11 offset-lg-1">
                <h2 class="subscribe-sect__message"><? echo $arResult['ACTION']['message']; ?></h2>
            </div>
        <? } ?>

        <div class="col-sm-5 col-lg-3 offset-lg-1">
            <div class="subscribe-sect__sub">
                <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/subscribe-mail.svg") ?>" class="img-svg subscribe-sect__icon">
                <h3 class="subscribe-sect__title">Подписаться на рассылку</h3>
                <p class="subscribe-sect__desc">Новости. Акции. Спецпредложения.</p>
            </div>
        </div>
        <div class="col-sm-4 col-lg-4">
            <p class="subscribe-sect__form-field">
                <input type="mail" name="asd_email" placeholder="Электронная почта">
            </p>
        </div>
        <div class="col-sm-3 col-lg-4">
            <div class="subscribe-sect__btn">
                <button class="btn btn_color_white" type="submit" name="asd_submit"><?=GetMessage("ASD_SUBSCRIBEQUICK_PODPISATQSA")?></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="subscribe-sect__politconf">
                <div id="asd_subscribe_res" style="display: none;"></div>
                <p>Подписываясь, я соглашаюсь на обработку персональных данных в соответствии с ФЗ РФ № 152-ФЗ «О персональных данных», а также с Политикой конфиденциальности.</p>
            </div>
        </div>
    </div>
</div>