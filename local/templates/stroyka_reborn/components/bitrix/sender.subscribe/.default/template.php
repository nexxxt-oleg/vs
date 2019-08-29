<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$buttonId = $this->randString();
$frame = $this->createFrame("sender-subscribe", false)->begin();
?>
    <div id="sender-subscribe">

        <? if (isset($arResult['MESSAGE'])): ?>
            <div id="sender-subscribe-response-cont" class="popup popup-subscription js-added-to-subscription display visible">
                <div class="popup__bg js-tgl-subscription"></div>
                <div class="popup__wrap popup__wrap_subscription">
                    <button class="popup__close popup__close_subscription js-tgl-subscription">
                        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/close.png') ?>" alt="">
                    </button>
                    <div class="subscription-card-popup">
                        <span class="subscription-card-popup__title h2-new"><?= GetMessage('subscr_form_response_' . $arResult['MESSAGE']['TYPE']) ?></span>
                        <p class="subscription-card-popup__desc"><?= htmlspecialcharsbx($arResult['MESSAGE']['TEXT']) ?></p>
                        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/subscription-confirmed.png') ?>" alt=""
                             class="subscription-card-popup__img">
                    </div>
                </div>
            </div>
            <script>
                if($('.js-added-to-subscription').length) {
                    $('.js-added-to-subscription').switchPopup({
                        btnClass: 'js-tgl-subscription',
                        duration: 300
                    });
                }
            </script>
            <section class="subscription">
                <div class="new-container">
                    <div class="new-row">
                        <div class="new-col-12">
                            <div class="subscription__block">
                                <span class="subscription__title h2-new">Поздравляем!</span>
                                <p class="subscription__desc">Теперь вы будете получать рассылку от Вечной стройки!</p>
                                <p class="subscription__desc"><a href="/"><strong>Вернуться на главную</strong></a></p>
                                <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/subscription-confirmed.png') ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <? endif; ?>

        <? if (!isset($arResult['MESSAGE'])): ?>

            <div class="footer__middle footer-middle">
                <div class="new-row">
                    <div class="new-col-sm-6 new-col-lg-4">
                        <span class="footer-middle__title h2-new">Подпишитесь на рассылку</span>
                        <a href="#" class="footer-middle__link">Новости. Акции. Спецпредложения.</a>
                    </div>
                    <div class="new-col-sm-6 new-col-lg-3">
                        <form class="footer-middle__search footer-search" id="bx_subscribe_subform_<?= $buttonId ?>"
                              role="form" method="post"
                              action="<?= $arResult["FORM_ACTION"] ?>">
                            <?= bitrix_sessid_post() ?>
                            <input type="hidden" name="sender_subscription" value="add">
                            <input type="email" name="SENDER_SUBSCRIBE_EMAIL" class="footer-search__input"
                                   placeholder="<?= htmlspecialcharsbx(GetMessage('subscr_form_email_title')) ?>"
                                   title="<?= GetMessage("subscr_form_email_title") ?>">
                            <button class="footer-search__arrow" type="submit" id="bx_subscribe_btn_<?= $buttonId ?>">
                                <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/send.svg') ?>" alt=""
                                     class="img-svg">
                            </button>
                        </form>
                    </div>
                    <div class="new-col-lg-5">
                        <p class="footer-middle__politconf">Подписываясь, я соглашаюсь на обработку персональных данных
                            в
                            соответствии с ФЗ РФ № 152-ФЗ «О персональных данных», а также с Политикой
                            конфиденциальности.</p>
                    </div>
                </div>
            </div>
        <? endif; ?>
    </div>
<? $frame->beginStub(); ?>
<? if (isset($arResult['MESSAGE'])): ?>
    <div id="sender-subscribe-response-cont" class="popup popup-subscription js-added-to-subscription display visible">
        <div class="popup__bg js-tgl-subscription"></div>
        <div class="popup__wrap popup__wrap_subscription">
            <button class="popup__close popup__close_subscription js-tgl-subscription">
                <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/close.png') ?>" alt="">
            </button>
            <div class="subscription-card-popup">
                <span class="subscription-card-popup__title h2-new"><?= GetMessage('subscr_form_response_' . $arResult['MESSAGE']['TYPE']) ?></span>
                <p class="subscription-card-popup__desc"><?= htmlspecialcharsbx($arResult['MESSAGE']['TEXT']) ?></p>
                <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/subscription-confirmed.png') ?>" alt=""
                     class="subscription-card-popup__img">
            </div>
        </div>
    </div>
    <script>
        if($('.js-added-to-subscription').length) {
            $('.js-added-to-subscription').switchPopup({
                btnClass: 'js-tgl-subscription',
                duration: 300
            });
        }
    </script>
<? endif; ?>
<? if (!isset($arResult['MESSAGE'])): ?>
    <div class="footer__middle footer-middle">
        <div class="new-row">
            <div class="new-col-sm-6 new-col-lg-4">
                <span class="footer-middle__title h2-new">Подпишитесь на рассылку</span>
                <a href="#" class="footer-middle__link">Новости. Акции. Спецпредложения.</a>
            </div>
            <div class="new-col-sm-6 new-col-lg-3">
                <form class="footer-middle__search footer-search" id="bx_subscribe_subform_<?= $buttonId ?>" role="form"
                      method="post"
                      action="<?= $arResult["FORM_ACTION"] ?>">
                    <?= bitrix_sessid_post() ?>
                    <input type="hidden" name="sender_subscription" value="add">
                    <input type="email" name="SENDER_SUBSCRIBE_EMAIL" class="footer-search__input"
                           placeholder="<?= htmlspecialcharsbx(GetMessage('subscr_form_email_title')) ?>"
                           title="<?= GetMessage("subscr_form_email_title") ?>">
                    <button class="footer-search__arrow" type="submit">
                        <img src="img/ui-icon/send.svg" alt="" class="img-svg">
                    </button>
                </form>
            </div>
            <div class="new-col-lg-5">
                <p class="footer-middle__politconf">Подписываясь, я соглашаюсь на обработку персональных данных в
                    соответствии с ФЗ РФ № 152-ФЗ «О персональных данных», а также с Политикой конфиденциальности.</p>
            </div>
        </div>
    </div>
<? endif; ?>
<?
$frame->end();
?>