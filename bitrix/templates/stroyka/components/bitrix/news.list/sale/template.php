<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$this->setFrameMode(true);
?>

<section class="main-sale">
    <div class="container section-title">
        <div class="row">
            <div class="col-md-8 col-sm-6 col-xs-6"><h1>Распродажa</h1></div>
            <div class="col-md-4 col-sm-6 col-xs-6 text-right">
                <a class="intopath" href="#" hidden>В РАЗДЕЛ
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="sale-slider">
        <div class="sale-slider-wrapper container">
            <div class="row">
                <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
                    <?php
                    $db_res = CPrice::GetList(
                        array(),
                        array(
                            'PRODUCT_ID' => $arItem['ID'],
//                            'CATALOG_GROUP_ID' => 1,
                        )
                    );
                    if ($ar_res = $db_res->Fetch()) {
                        $arItem['PRICE'] = round($ar_res['PRICE']);
                    }
                    $res = getFinalPriceInCurrency($arItem['ID']);
                    if ($res) {
                        $arItem['GOODS_PRICE'] = round($res);
                    }
                    ?>
                    <div class="sale-slide col-sm-4 col-md-3 col-xs-6">
                        <div class="goods">
                            <a href="#" class="goods-img">
                                <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['PREVIEW_PICTURE']['DESCRIPTION'] ?>">
                            </a>
                            <div class="goods-bottom">
                                <div class="goods-title"><?= $arItem['NAME'] ?></div>
                                <div class="goods-descr"><?= $arItem['PREVIEW_TEXT'] ?></div>
                                <div class="goods-price"><span><?= $arItem['GOODS_PRICE'] ?></span>руб</div>
                                <strike class="goods-price-before"><span><?= $arItem['PRICE'] ?></span>руб</strike>
                                <button class="add-to-card" hidden></button>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
            <div class="sale-slider-control sale-slider-left"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
            <div class="sale-slider-control sale-slider-right"><i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</section>