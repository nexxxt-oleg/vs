<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<ul class="header-main-menu-list">
<?if (!empty($arResult)):?>
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
        <li>
            <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
        </li>
	<?else:?>
        <li>
            <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
        </li>
	<?endif?>
	
<?endforeach?>
<?endif?>
</ul>