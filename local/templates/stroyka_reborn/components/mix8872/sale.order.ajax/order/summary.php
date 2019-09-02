<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$bDefaultColumns = $arResult["GRID"]["DEFAULT_COLUMNS"];
$colspan = ($bDefaultColumns) ? count($arResult["GRID"]["HEADERS"]) : count($arResult["GRID"]["HEADERS"]) - 1;
$bPropsColumn = false;
$bUseDiscount = false;
$bPriceType = false;
$bShowNameWithPicture = ($bDefaultColumns) ? true : false; // flat to show name and picture column in one column

$productCount = 0;
if (is_array($arResult["GRID"]["ROWS"])) {
    foreach ($arResult["GRID"]["ROWS"] as $product) {
        $productCount += $product["data"]["QUANTITY"];
    }
}

?>


<div class="ordering-form__wraper">
    <div class="ordering-form__right-block basket-right-block">
        <div class="basket-right-block__on-head">
            <span class="basket-right-block__title">Ваш заказ</span>
            <a href="<?= $arParams["PATH_TO_BASKET"] ?>" class="basket-right-block__change">Изменить</a>
        </div>

        <div class="basket-right-block__head" data-entity="basket-items-list-header">
            <a href="javascript:void(0)" data-entity="basket-items-count" data-filter="all">
                <span>Товаров в корзине:</span>
                <span><?= $productCount?></span>
            </a>
        </div>

        <div class="basket-right-block__weight">
            <span>Общий вес:</span>
            <span><?= $arResult["ORDER_WEIGHT_FORMATED"] ?></span>
        </div>
        <?php
        if (!$_REQUEST["DELIVERY_ID"] || $_REQUEST["DELIVERY_ID"] == 'simple:simple') {
            ?>

            <div class="basket-right-block__delivery" id="basketDelivery2">
                <span>Доставка:</span>
                <span>рассчитывается менеджером</span>
            </div>
            <?php
        }
        ?>

        <div class="basket-right-block__price-full">
            <span>Итого:</span>
            <span data-entity="basket-total-price"><?= str_replace('руб.', '₽', $arResult["ORDER_TOTAL_PRICE_FORMATED"])?></span>
        </div>

    </div>
</div>

