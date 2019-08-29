<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
if (!empty($arResult["CATEGORIES"])):?>
    <ul class="title-search-result__list hidden">
        <?
        foreach ($arResult["CATEGORIES"] as $category_id => $arCategory):?>

            <?
            foreach ($arCategory["ITEMS"] as $i => $arItem):?>
                <?
                $res = CCatalogProduct::GetByIDEx($arItem["ITEM_ID"], true); // Вся инфа о товаре
                $price = CurrencyFormat($res["PRICES"][5]["PRICE"], $res["PRICES"][5]["CURRENCY"]);; // текущая цена без скидок
                $imgUrl = CFile::GetPath($res["PREVIEW_PICTURE"]);
                $imgUrl = !empty($imgUrl) ? $imgUrl : $APPLICATION->GetTemplatePath('img/file.svg'); // Берем либо адрес картинки из превьюшки либо заглушку
                ?>

                <? if ($arItem["NAME"] !== "остальные"): ?>
                    <li class="header-search-result__item">
                        <a href="<?= $arItem["URL"] ?>" class="search-item">
                            <img src="<?= $imgUrl ?>" alt="" class="search-item__prew">
                            <span class="search-item__name"><?= $arItem["NAME"] ?></span>
                            <? if ($price) : ?>
                                <span class="search-item__price"><?= $price ?></span>
                            <? endif; ?>
                        </a>
                    </li>
                <? endif; ?>

            <? endforeach; ?>
        <? endforeach; ?>
    </ul>
<?endif;
?>
