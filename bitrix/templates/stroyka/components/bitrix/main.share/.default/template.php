<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (strlen($arResult["PAGE_URL"]) > 0){
		if (is_array($arResult["BOOKMARKS"]) && count($arResult["BOOKMARKS"]) > 0){?>
		<div class="bookmarks">
			<span class="socbookmark">Поделиться&nbsp;</span>
			<?foreach($arResult["BOOKMARKS"] as $name => $arBookmark){?>
				<span class="socbookmark"><?=$arBookmark["ICON"]?></span>
			<?}?>
		</div>
		<?}?>
	<?}else{?>
	<?=GetMessage("SHARE_ERROR_EMPTY_SERVER")?><?
}?>