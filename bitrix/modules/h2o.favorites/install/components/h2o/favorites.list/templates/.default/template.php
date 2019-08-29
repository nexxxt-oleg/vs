<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->createFrame()->begin("");
?><div class="ajax-h2ofavorites-list"><?
	if(is_array($arResult['ERRORS']['FATAL']) && !empty($arResult['ERRORS']['FATAL'])):?>

		<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>

	<?elseif(is_array($arResult["FAVORITES"]) && !empty($arResult['FAVORITES'])):?>

		<?if(is_array($arResult['ERRORS']['NONFATAL']) && !empty($arResult['ERRORS']['NONFATAL'])):?>

			<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
				<?=ShowError($error)?>
			<?endforeach?>

		<?endif?>

		<?if($arParams["DISPLAY_TOP_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?><br />
		<?endif;?>
		<table class="h2o_favorites_table" width="100%" cellspacing="0" cellpadding="5">
			<tr>
				<th><?=GetMessage("H2O_FAVORITES_FIELD_DATE_INSERT")?></th>
				<th><?=GetMessage("H2O_FAVORITES_FIELD_ELEMENT")?></th>

				<th><?=GetMessage("H2O_FAVORITES_FIELD_DELETE")?></th>
			</tr>
			<?foreach($arResult["FAVORITES"] as $arItem):?>
				<tr>
					<td>
						<?=$arItem['DATE_INSERT']?>
					</td>
					<td>
						<a href="<?=$arItem['ELEMENT']['DETAIL_PAGE_URL']?>"><?=$arItem['ELEMENT']['NAME']?></a>
					</td>

					<td>
						<a href="#" class="delete_favorites" data-id="<?=$arItem['ID']?>"><?=GetMessage("H2O_FAVORITES_DELETE_ITEM")?></a>
					</td>
				</tr>


			<?endforeach;?>
		</table>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<br /><?=$arResult["NAV_STRING"]?>
		<?endif;?>

	<?else:?>
		<?=GetMessage("H2O_FAVORITES_EMPTY_LIST");?>
	<?endif;?>
</div>