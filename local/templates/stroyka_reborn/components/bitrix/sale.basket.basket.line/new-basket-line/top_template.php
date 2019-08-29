<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
?>

<? if ($arResult['NUM_PRODUCTS'] > 0): ?>
    <a href="<?= $arParams['PATH_TO_BASKET'] ?>" class="header-btns__link"
       data-count="<?= $arResult['NUM_PRODUCTS'] ?>">
        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/basket.svg') ?>" alt=""
             class="header-btns__icon header-btns__icon_left">
        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/basket-fill.svg') ?>" alt="" class="header-btns__icon">
    </a>
    <a href="<?= $arParams['PATH_TO_BASKET'] ?>" class="header-btns__link">Корзина</a>
<? else: ?>
    <a href="<?= $arParams['PATH_TO_BASKET'] ?>" class="header-btns__link">
        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/basket.svg') ?>" alt=""
             class="header-btns__icon header-btns__icon_left">
        <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/basket-fill.svg') ?>" alt="" class="header-btns__icon">
    </a>
    <a href="<?= $arParams['PATH_TO_BASKET'] ?>" class="header-btns__link">Корзина</a>
<? endif; ?>


