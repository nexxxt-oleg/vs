<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

if (method_exists($this, 'setFrameMode')) {
	$this->setFrameMode(true);
}

if ($arResult['ACTION']['status']=='error') {
	ShowError($arResult['ACTION']['message']);
} elseif ($arResult['ACTION']['status']=='ok') {
	ShowNote($arResult['ACTION']['message']);
}
?>
<div id="asd_subscribe_res" style="display: none;"></div>
<div class="footer-subscribe">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-5 col-xs-12 text-center">
                <div class="footer-sub-descr-block">
                    <svg width="24px" height="19px" viewBox="0 0 24 19" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title></title>
                        <desc></desc>
                        <defs></defs>
                        <g id="podpiska-line" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(-432.000000, -32.000000)">
                            <g fill="#FFFFFF" fill-rule="nonzero" id="black-back-closed-envelope-shape">
                                <g transform="translate(432.000000, 32.000000)">
                                    <path d="M21.8488421,18.9904342 C22.3881234,18.9904342 22.8554047,18.8110531 23.2526461,18.4568545 L16.4555935,11.6091755 C16.2925154,11.7268176 16.1344465,11.8412125 15.9851325,11.9499908 C15.4764719,12.3275335 15.063637,12.6221432 14.7466279,12.8332494 C14.4296624,13.0448383 14.0079419,13.2605081 13.48151,13.4806975 C12.9547296,13.7011501 12.463971,13.8110254 12.0087114,13.8110254 L11.9953829,13.8110254 L11.9820544,13.8110254 C11.5267514,13.8110254 11.0359927,13.701194 10.5092559,13.4806975 C9.98251906,13.2605081 9.56079855,13.0448383 9.24413793,12.8332494 C8.92717241,12.6221432 8.51455535,12.3275774 8.00563339,11.9499908 C7.86381125,11.8452494 7.70652632,11.7303279 7.53647913,11.6073326 L0.738119782,18.4568545 C1.1353176,18.8110531 1.60290381,18.9904342 2.14214156,18.9904342 L21.8488421,18.9904342 Z" id="Shape"></path>
                                    <path d="M1.35231942,7.29718476 C0.843702359,6.95557968 0.392667877,6.56434642 0,6.12366051 L0,16.5418476 L5.99089655,10.5065612 C4.7923775,9.66362818 3.24814519,8.59506467 1.35231942,7.29718476 Z" id="Shape"></path>
                                    <path d="M22.6522976,7.29718476 C20.8287768,8.54056582 19.2789256,9.61097229 18.0025699,10.5089746 L23.9910708,16.5421109 L23.9910708,6.12366051 C23.6071143,6.55548268 23.1609147,6.94645266 22.6522976,7.29718476 Z" id="Shape"></path>
                                    <path d="M21.8488421,0.000570438799 L2.14218512,0.000570438799 C1.45467877,0.000570438799 0.926112523,0.234450346 0.555833031,0.701727483 C0.185248639,1.16922402 0.000261343013,1.75387991 0.000261343013,2.45503695 C0.000261343013,3.02139492 0.245749546,3.63505543 0.736508167,4.296194 C1.22726679,4.95706928 1.74947368,5.47616859 2.30286751,5.8537552 C2.60624319,6.06968822 3.52111797,6.71042263 5.04749183,7.77573903 C5.87146279,8.35096074 6.58802178,8.85233256 7.20378947,9.28498845 C7.72865336,9.65340416 8.18129946,9.97245497 8.55501996,10.2372263 C8.59792377,10.2675473 8.66539383,10.3161663 8.75494737,10.3806697 C8.8514265,10.4504827 8.97351724,10.5390762 9.12413793,10.6486443 C9.41418512,10.85997 9.65514338,11.0307945 9.84705626,11.1612933 C10.0387078,11.291836 10.2709111,11.437649 10.5433176,11.5995658 C10.8155064,11.7612633 11.0722323,11.8828545 11.3131906,11.9637252 C11.5541924,12.044552 11.7772922,12.085097 11.9825336,12.085097 L11.9958621,12.085097 L12.0091906,12.085097 C12.2143884,12.085097 12.4375318,12.044552 12.6785771,11.9637252 C12.9194918,11.8828545 13.176,11.7615266 13.4484065,11.5995658 C13.7205517,11.437649 13.9524501,11.2915289 14.1447114,11.1612933 C14.3366243,11.0307945 14.5775826,10.8600139 14.8676733,10.6486443 C15.0179891,10.5390762 15.1400799,10.4504388 15.236559,10.3808891 C15.3261561,10.3161224 15.3935826,10.2678106 15.4367477,10.2372263 C15.7278838,10.0331409 16.1815753,9.71540647 16.7915499,9.28871824 C17.9014737,8.51182448 19.5360871,7.36835797 21.7022722,5.8537552 C22.3537568,5.3953418 22.8980472,4.84214781 23.3354918,4.19496305 C23.7721525,3.54777829 23.9910708,2.86891224 23.9910708,2.1585843 C23.9910708,1.56510855 23.7788167,1.05728637 23.3552232,0.634327945 C22.9311506,0.211896074 22.42898,0.000570438799 21.8488421,0.000570438799 Z" id="Shape"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <div class="footer-sub-descr-1">Подписаться на рассылку</div>
                    <div class="footer-sub-descr-2">Новости. Акции. Спецпредложения.</div>
                </div>
            </div>
            <form action="<?= POST_FORM_ACTION_URI?>" method="post" id="asd_subscribe_form">
                <?= bitrix_sessid_post()?>
                <input type="hidden" name="asd_subscribe" value="Y" />
                <input type="hidden" name="charset" value="<?= SITE_CHARSET?>" />
                <input type="hidden" name="site_id" value="<?= SITE_ID?>" />
                <input type="hidden" name="asd_rubrics" value="<?= $arParams['RUBRICS_STR']?>" />
                <input type="hidden" name="asd_format" value="<?= $arParams['FORMAT']?>" />
                <input type="hidden" name="asd_show_rubrics" value="<?= $arParams['SHOW_RUBRICS']?>" />
                <input type="hidden" name="asd_not_confirm" value="<?= $arParams['NOT_CONFIRM']?>" />
                <input type="hidden" name="asd_key" value="<?= md5($arParams['JS_KEY'].$arParams['RUBRICS_STR'].$arParams['SHOW_RUBRICS'].$arParams['NOT_CONFIRM'])?>" />

                <div class="col-md-4 col-sm-4 col-xs-12 ">
                    <input placeholder="Электронная почта" name="asd_email" class="sub-email" type="text">
                </div>
                <div class="col-md-4 col-sm-3 col-xs-12 sub-f-center">
                    <input id="footer-sub" name="asd_submit" type="submit">
                    <label for="footer-sub" class="btn-type-1">
                        <div class="btn-type-1-arrow"></div>
                        <div class="btn-type-1-text"><?=GetMessage("ASD_SUBSCRIBEQUICK_PODPISATQSA")?></div>
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </label>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="sub-terms">Подписываясь, я соглашаюсь на обработку персональных данных в соответствии с ФЗ РФ № 152-ФЗ «О персональных данных», а также с политикой конфеденциальности.</p>
            </div>
        </div>
    </div>
</div>