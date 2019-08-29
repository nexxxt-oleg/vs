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
<div class="container">
    <div class="row">
        <div class="col-8">
            <div class="page-all-sect__top-title">
                <h2>Товары в наших магазинах</h2>
            </div>
        </div>
        <div class="col-4">
            <div class="page-all-sect__top-link">
                <a href="/catalog/" class="arrow-link arrow-link_sm arrow-link_right">
                    <span>В раздел</span>
                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-right.svg") ?>" class="img-svg">
                </a>
            </div>
        </div>
    </div>

    <div class="products-category-slider">
        <button class="products-category-slider__prev">
            <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-left.svg") ?>" class="img-svg">
        </button>
        <button class="products-category-slider__next">
            <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-right.svg") ?>" class="img-svg">
        </button>
        <div class="products-category-slider__slick">
            <? foreach ($arResult as $menuItem): ?>
                <div class="products-category-slider__item">
                    <div class="section-menu-lg">
                        <a href="<?= $menuItem['SECTION_PAGE_URL'] ?>" class="section-menu-lg__title h3"><?= $menuItem['NAME'] ?></a>
                        <ul class="section-menu-lg__links">
                            <? foreach ($menuItem['ITEMS'] as $menuItemLevel2): ?>
                                <li>
                                    <a href="<?= $menuItemLevel2['SECTION_PAGE_URL'] ?>"><?= $menuItemLevel2['NAME'] ?></a>
                                </li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</div>