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
<section class="page-all-sect page-profile__favorites">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="page-all-sect__top-title">
                    <h2>Избранные товары</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <? if (empty($arResult['ITEMS'])): ?>


                <div class="col-sm-2">
                    <div class="pp-favorites-icon">
                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/favorites.svg") ?>" class="img-svg">
                    </div>
                </div>
                <div class="col-sm-9 col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="b-content">
                                <p>Здесь Вы можете отложить понравившийся товар, чтобы потом легко его найти.</p>

                                <p><strong>Внимание! <br>Отложенный товар не является резервом заказа</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            <? else: ?>
                <div class="col-12">
                    <div class="row">
                        <? foreach ($arResult['ITEMS'] as $arItem): ?>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="page-profile__card card-product">
                                    <div class="card-product__top">
                                        <button class="card-product__add-favorites active">
                                            <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/delete.svg") ?>" class="img-svg">
                                        </button>
                                        <div class="card-product__img">
                                            <img src="<?= $arItem['DETAIL']['RESIZED_IMG']['src'] ?>">
                                        </div>
                                    </div>
                                    <div class="card-product__middle">
                                        <h5 class="card-product__title"><?= $arItem['DETAIL']['NAME'] ?></h5>
                                        <div class="card-product__desc b-content">
                                            <p>Антивибрационные подставки</p>
                                        </div>
                                    </div>
                                    <div class="card-product__bottom">
                                        <div class="card-product__price-old">
												<span class="b-price b-price_strike">
													<span class="b-price__number">
														<span>60 000</span><sup>00</sup>
													</span> <span class="b-price__rub"></span>
												</span>
                                        </div>
                                        <div class="card-product__price-current">
												<span class="b-price b-price_ac">
													<span class="b-price__number">
														<span>58 999</span><sup>50</sup>
													</span> <span class="b-price__rub"></span>
												</span>
                                        </div>
                                        <button class="card-product__add-cart">
                                            <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/basket-plus.svg") ?>" class="img-svg">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            <? endif; ?>
        </div>
    </div>
</section>
