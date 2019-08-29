<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
?>
<div class="btn-bf">
    <? if($arResult['NUM_PRODUCTS'] > 0): ?>
        <a href="<?= $arParams['PATH_TO_BASKET'] ?>" class="btn-bf__btn" data-count="<?= $arResult['NUM_PRODUCTS'] ?>">
    <? else: ?>
        <a href="<?= $arParams['PATH_TO_BASKET'] ?>" class="btn-bf__btn" >
    <? endif; ?>
        <img src="<?= $APPLICATION->GetTemplatePath("img/header/basket.svg") ?>" class="img-svg">
    </a>
    <div class="btn-bf__desc">
        <a href="<?= $arParams['PATH_TO_BASKET'] ?>" class="btn-bf__text">Корзина</a>
        <? if ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y'): ?>
            <p class="btn-bf__price h4"><?= $arResult['TOTAL_PRICE'] ?></p>
        <? endif ?>
    </div>
</div>
