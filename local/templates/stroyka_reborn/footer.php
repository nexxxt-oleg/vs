<?
$APPLICATION->AddBufferContent('footerContentBlock');
if (!function_exists('footerContentBlock')) {
    function footerContentBlock()
    {
        global $APPLICATION;

        if ($APPLICATION->isContentPage === 'Y') {
            return '        </div>
                        </div>
                    </div>
                </div>
            </section>';
        }
    }
}

$isHomePage = $APPLICATION->GetCurPage(false) === '/';
$isCatalogSection = preg_match('/\/catalog\/(.+)?/ui', $APPLICATION->GetCurPage(false));

$instagram = COption::GetOptionString("grain.customsettings", "insta");
$vk = COption::GetOptionString("grain.customsettings", "vk");
$fb = COption::GetOptionString("grain.customsettings", "fb");
$ok = COption::GetOptionString("grain.customsettings", "ok");
$email = COption::GetOptionString("grain.customsettings", "email");
$tel = explode(",", COption::GetOptionString("grain.customsettings", "phone"));

?>
<!--<section class="subscribe-sect">
    <? /* $APPLICATION->IncludeComponent(
	"asd:subscribe.quick.form",
	"stroyka",
	array(
		"FORMAT" => "html",
		"INC_JQUERY" => "Y",
		"NOT_CONFIRM" => "Y",
		"RUBRICS" => array(
			0 => "1",
		),
		"SHOW_RUBRICS" => "N",
		"AJAX_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "stroyka"
	),
	false
); */ ?>
</section>-->

<button class="btn-to-top">
    <img class="img-svg" src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-top-lg.svg") ?>">
    <span class="btn-to-top__text">Вверх</span>
</button>
</main>
<footer class="footer">
    <div class="new-container">
        <div class="new-row">
            <div class="new-col-lg-12">
                <div class="footer__top footer-top">
                    <div class="new-row">
                        <div class="new-col-sm-4 new-col-lg-3">
                            <div class="footer-top__contacts footer-contacts">
                                <div class="footer-contacts__phone">
                                    <? foreach ($tel as $telephone): ?>
                                        <a href="tel:<?= $telephone ?>"><?= $telephone ?></a>
                                    <? endforeach; ?>
                                </div>
                                <a href="mailto:<?= $email ?>" class="footer-contacts__email"><?= $email ?></a>
                                <a class="footer-contacts__shops">Наши магазины в Крыму</a>
                                <div class="footer-contacts__soc">
                                    <a href="<?= $vk ?>">
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/social/vk.svg') ?>" alt="">
                                    </a>
                                    <a href="<?= $fb ?>">
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/social/fb.svg') ?>" alt="">
                                    </a>
                                    <a href="<?= $ok ?>">
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/social/ok.svg') ?>" alt="">
                                    </a>
                                    <a href="<?= $instagram ?>">
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/social/insta.svg') ?>" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="new-col-5 new-col-sm-2 new-offset-lg-1 new-col-lg-1">
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "simple-new",
                                array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "1",
                                    "MENU_CACHE_GET_VARS" => [],
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "N",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "MENU_THEME" => "site",
                                    "ROOT_MENU_TYPE" => "bottom1",
                                    "USE_EXT" => "N",
                                    "COMPONENT_TEMPLATE" => "simple",
                                    "MENU_CLASS" => "footer__info"
                                ),
                                false
                            ); ?>
                        </div>
                        <div class="new-col-7 new-offset-sm-2 new-col-sm-4 new-offset-lg-2 new-col-lg-2">
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "simple-new",
                                array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "1",
                                    "MENU_CACHE_GET_VARS" => [],
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "N",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "MENU_THEME" => "site",
                                    "ROOT_MENU_TYPE" => "bottom2",
                                    "USE_EXT" => "N",
                                    "COMPONENT_TEMPLATE" => "simple",
                                    "MENU_CLASS" => "footer__info"
                                ),
                                false
                            ); ?>
                        </div>
                        <div class="new-col-md-11 new-col-lg-3">
                            <div class="footer-top__wrap">
                                <div class="footer__info footer__info_sm-center">
                                    <? $APPLICATION->IncludeFile("/local/templates/stroyka_reborn/footer_politconf_link_inc.php", [], [
                                        'MODE' => 'html',
                                        'NAME' => 'Ссылки на политику конфиденциальности',
                                    ]); ?>
                                </div>
                                <div class="footer-top__pay footer-pay">
                                    <a href="#">
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/cards/visa.svg') ?>" alt=""
                                             class="footer-pay__img">
                                    </a>
                                    <a href="#">
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/cards/mastercard.svg') ?>"
                                             alt=""
                                             class="footer-pay__img footer-pay__img_master-card">
                                    </a>
                                    <a href="#">
                                        <img src="<?= $APPLICATION->GetTemplatePath('img/cards/mir.svg') ?>" alt=""
                                             class="footer-pay__img">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="new-col-lg-12">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:sender.subscribe",
                    "footer",
                    Array(
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "N",
                        "CACHE_TIME" => "3600",
                        "CACHE_TYPE" => "A",
                        "CONFIRMATION" => "Y",
                        "HIDE_MAILINGS" => "Y",
                        "SET_TITLE" => "N",
                        "SHOW_HIDDEN" => "N",
                        "USER_CONSENT" => "N",
                        "USER_CONSENT_ID" => "0",
                        "USER_CONSENT_IS_CHECKED" => "Y",
                        "USER_CONSENT_IS_LOADED" => "N",
                        "USE_PERSONALIZATION" => "Y"
                    )
                ); ?>
            </div>
            <div class="new-col-lg-12">
                <div class="footer__bottom footer-bottom">
                    <div class="new-row">
                        <div class="new-col-12 new-col-sm-6 new-col-lg-4">
                            <p class="footer-bottom__rights">© 2001 – <?= date('Y') ?> Все права защищены. Вечная
                                Стройка</p>
                        </div>
                        <div class="new-col-12 new-offset-sm-2 new-col-sm-4 new-offset-lg-6 new-col-lg-2">
                            <div class="footer-bottom__grch">
                                <span>Разработка сайта:</span>
                                <a href="https://grechka.digital">Гречка</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="popup popup-callback">
    <div class="popup__bg js-tgl-callback"></div>
    <div class="popup__wrap popup-wrap popup-wrap_success">
        <? $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => "/ajax/form-callback.php"
            )
        ); ?>
    </div>
</div>

<div class="popup popup-testing">
    <div class="popup__bg js-tgl-testing"></div>
    <div class="popup__wrap popup-testing__wrap">
        <button class="popup__close js-tgl-testing">
            <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/del.svg") ?>" class="img-svg">
        </button>
        <div class="popup-testing__content">
            <h2 class="popup-testing__title">Уважаемые посетители!</h2>
            <div class="popup-testing__desc b-content">
                <p>Интернет-магазин «Вечная стройка» находится в тестовом режиме, но вы уже сейчас можете сделать заказ:
                    он будет принят в работу после проверки менеджером.</p>
                <p>Ежедневно каталог наполняется новыми позициями, на сайт добавляются новые функции и устраняются
                    мелкие недочеты.</p>
            </div>
            <!-- <a href="#" class="popup-testing__link btn btn_color_ac">Перейти в интернет-магазин</a> -->

            <div class="popup-testing__bq b-content">
                <blockquote>
                    <h4>Мы стремимся стать лучше и запускаем проект, который сэкономит вам время на покупку
                        стройматериалов и товаров для дома по Крыму.</h4>
                </blockquote>
            </div>

            <span class="popup-testing__note">Внимание:  в период тестирования цены в интернет-магазине могут отличаться от реальных.</span>
        </div>
        <img src="<?= $APPLICATION->GetTemplatePath("img/popup-testing-hd.png") ?>" class="popup-testing__img-hd">
        <img src="<?= $APPLICATION->GetTemplatePath("img/popup-testing-mob.png") ?>" class="popup-testing__img-mob">
    </div>
</div>

</div>
</body>
</html>