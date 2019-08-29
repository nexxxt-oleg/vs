<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
	'left' => 'basket-item-label-left',
	'center' => 'basket-item-label-center',
	'right' => 'basket-item-label-right',
	'bottom' => 'basket-item-label-bottom',
	'middle' => 'basket-item-label-middle',
	'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>
<script id="basket-item-template" type="text/html">
	<div class="pc-basket__row{{#SHOW_RESTORE}} pc-basket__row_expend{{/SHOW_RESTORE}}" id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
        {{#SHOW_RESTORE}}

        {{#SHOW_LOADING}}
        <div class="basket-items-list-item-overlay"></div>
        {{/SHOW_LOADING}}
        <div class="pc-basket__removed-container" id="basket-item-height-aligner-{{ID}}">
            <div>
                <span data-entity="basket-item-name" class="h4"><?=Loc::getMessage('SBB_GOOD_CAP')?> 	&laquo; {{NAME}} 	&raquo;  <?=Loc::getMessage('SBB_BASKET_ITEM_DELETED')?>.</span>
            </div>
            <div class="basket-items-list-item-removed-block">
                <a class="pc-basket__removed" href="javascript:void(0)" data-entity="basket-item-restore-button">
                    <?=Loc::getMessage('SBB_BASKET_ITEM_RESTORE')?>
                </a>
                <span class="basket-items-list-item-clear-btn" data-entity="basket-item-close-restore-button"></span>
            </div>
        </div>
        {{/SHOW_RESTORE}}
		{{^SHOW_RESTORE}}
			<div class="pc-basket__prop-col" id="basket-item-height-aligner-12">
				<div class="pc-basket__img-col">
					<?
					if (in_array('PREVIEW_PICTURE', $arParams['COLUMNS_LIST']))
					{
						?>
						{{#DETAIL_PAGE_URL}}
							<a href="{{DETAIL_PAGE_URL}}">
						{{/DETAIL_PAGE_URL}}
							<img class="pc-basket__img" alt="{{NAME}}" src="{{{IMAGE_URL}}}{{^IMAGE_URL}}<?=$templateFolder?>/images/no_photo.png{{/IMAGE_URL}}">
						{{#DETAIL_PAGE_URL}}
							</a>
						{{/DETAIL_PAGE_URL}}
						<?
					}
					?>
				</div>
				<div class="pc-basket__name-col">
					{{^DETAIL_PAGE_URL}}
						<h4 class="pc-basket__name">
					{{/DETAIL_PAGE_URL}}
					{{#DETAIL_PAGE_URL}}
						<a href="{{DETAIL_PAGE_URL}}" class="pc-basket__name h4">
					{{/DETAIL_PAGE_URL}}
						<span data-entity="basket-item-name">{{NAME}}</span>
					{{#DETAIL_PAGE_URL}}
						</a>
					{{/DETAIL_PAGE_URL}}
					{{^DETAIL_PAGE_URL}}
						</h4>
					{{/DETAIL_PAGE_URL}}
				</div>
			</div>
			<div class="pc-basket__price-col">
				<div class="card-sm-title">
					<p>Цена за шт.:</p>
					<span class="b-price">
						<span class="b-price__number" id="basket-item-price-{{ID}}">
							{{{PRICE_FORMATED}}}
							<!-- <span>600</span><sup>00</sup> -->
						</span> <!-- <span class="b-price__rub"></span> -->
					</span>
				</div>
			</div>
			<div class="pc-basket__amount-col">
				<div class="card-sm-title card-sm-title_center-text">
					<p>Количество шт.:</p>
					<div class="product-amount" data-entity="basket-item-quantity-block">
						<span class="product-amount__minus no-select{{#NOT_AVAILABLE}} disabled{{/NOT_AVAILABLE}}" data-entity="basket-item-quantity-minus">
							<img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/minus.svg") ?>" class="img-svg">
						</span>
						<input type="text" class="product-amount__field" value="{{QUANTITY}}"
							{{#NOT_AVAILABLE}} disabled="disabled"{{/NOT_AVAILABLE}}
							data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field"
							id="basket-item-quantity-{{ID}}">
						<span class="product-amount__plus no-select{{#NOT_AVAILABLE}} disabled{{/NOT_AVAILABLE}}" data-entity="basket-item-quantity-plus">
							<img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/plus.svg") ?>" class="img-svg">
						</span>
					</div>
				</div>
			</div>
			<div class="pc-basket__price-full-col">
				<div class="card-sm-title">
					<p>Итого:</p>
					<span class="b-price" id="basket-item-sum-price-12">
						<span class="b-price__number" id="basket-item-sum-price-{{ID}}">
							{{{SUM_PRICE_FORMATED}}}
							<!-- <span>600</span><sup>00</sup> -->
						</span> <!-- <span class="b-price__rub"></span> -->
					</span>
				</div>
			</div>
			<div class="pc-basket__del-col">
				<button class="pc-basket__del" data-entity="basket-item-delete">
					<img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/delete.svg") ?>" class="img-svg">
				</button>
			</div>
		{{/SHOW_RESTORE}}
	</div>
</script>