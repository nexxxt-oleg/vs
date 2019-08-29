<?
//include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");?>

    <section class="sect-404">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-5 col-lg-3">
                    <h2 class="sect-404__title">Страница не найдена</h2>
                    <a href="/" class="sect-404__link btn btn_color_ac">Главная</a>
                </div>
                <div class="col-12 col-sm-7 col-lg-8">
                    <div class="sect-404__img">
                        <img src="<?= $APPLICATION->GetTemplatePath("img/404.svg") ?>" class="img-svg">
                    </div>
                </div>
            </div>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>