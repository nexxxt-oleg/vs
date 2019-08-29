<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Обратная связь");
?>
    <section class="page-all-sect page-cnt-callback">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="page-all-sect__top-title">
                        <h2>Обратная связь</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="page-cnt-callback__content b-content">
                        <blockquote>
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "text1_inc.php"
                                )
                            ); ?>
                        </blockquote>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "text2_inc.php"
                            )
                        ); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9 col-lg-6">
                    <? $APPLICATION->IncludeComponent(
                        "mix8872:main.feedback",
                        "stroyka",
                        Array(
                            "EMAIL_TO" => "sale@vs82.ru",
                            "EVENT_MESSAGE_ID" => array("7"),
                            "EXT_FIELDS" => array("телефон", "тема сообщения", "город", ""),
                            "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                            "REQUIRED_FIELDS" => array("NAME", "EMAIL", "MESSAGE"),
                            "USE_CAPTCHA" => "N"
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </section> <br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>