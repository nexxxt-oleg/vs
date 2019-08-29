<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!empty($arResult["CATEGORIES"])):?>
    <ul class="hm-search__spisok search-spisok hidden">
		<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>

			<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
                <?
                    $res = CCatalogProduct::GetByIDEx( $arItem["ITEM_ID"], true); // Вся инфа о товаре
                    $price = CurrencyFormat($res["PRICES"][5]["PRICE"], $res["PRICES"][5]["CURRENCY"]);; // текущая цена без скидок
                    $imgUrl = CFile::GetPath($res["PREVIEW_PICTURE"]);
                    $imgUrl = !empty($imgUrl) ? $imgUrl : $APPLICATION->GetTemplatePath('img/file.svg'); // Берем либо адрес картинки из превьюшки либо заглушку
                ?>

                <? if($arItem["NAME"] !== "остальные"): ?>
                    <li>
                        <a href="<?echo $arItem["URL"]?>" class="search-spisok__item">
                            <div class="search-spisok__variant">
                                                <span class="search-spisok__img">
                                                        <img src="<?=$imgUrl?>" alt="">
                                                    </span>
                                <span class="search-spisok__name"><?echo $arItem["NAME"]?></span>
                            </div>
                            <span class="search-spisok__price"><?=$price?></span>
                        </a>
                    </li>
                <?endif;?>

			<?endforeach;?>
		<?endforeach;?>
	</ul>
<?endif;
?>