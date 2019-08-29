<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
	<div class="basket-checkout-container" data-entity="basket-checkout-aligner">
		<div class="row">
			<div class="col-12 col-sm-3">
			<?
			if ($arParams['HIDE_COUPON'] !== 'Y')
			{
				?>
				<div class="form-field">
					<input type="text" class="form-field__input" data-entity="basket-coupon-input" placeholder="<?=Loc::getMessage('SBB_COUPON_ENTER')?>">
					<span class="basket-coupon-block-coupon-btn"></span>
				</div>
				<?
			}
			?>
                <button class="pc-basket-btm__btn btn btn_color_ac{{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}"
                        data-entity="basket-clear-button">
                    <?=Loc::getMessage('SBB_CLEAN')?>
                </button>
			</div>
			<div class="col-12 col-sm-9">
				<div class="page-catalog-basket__bottom pc-basket-btm">
					<p class="pc-basket-btm__price-full">
						<span>Итого:</span>
						<span class="b-price" data-entity="basket-total-price">
							<span class="b-price__number">
								{{{PRICE_FORMATED}}}
								<!-- <span>1200</span><sup>00</sup> -->
							</span> <!-- <span class="b-price__rub"></span> -->
						</span>
					</p>
					<button class="pc-basket-btm__btn btn btn_color_ac{{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}"
						data-entity="basket-checkout-button">
						<?=Loc::getMessage('SBB_ORDER')?>
					</button>
				</div>
			</div>
		</div>

		<?
		if ($arParams['HIDE_COUPON'] !== 'Y')
		{
		?>
			<div class="basket-coupon-alert-section">
				<div class="basket-coupon-alert-inner">
					{{#COUPON_LIST}}
					<div class="basket-coupon-alert text-{{CLASS}}">
						<span class="basket-coupon-text">
							<strong>{{COUPON}}</strong> - <?=Loc::getMessage('SBB_COUPON')?> {{JS_CHECK_CODE}}
							{{#DISCOUNT_NAME}}({{{DISCOUNT_NAME}}}){{/DISCOUNT_NAME}}
						</span>
						<span class="close-link" data-entity="basket-coupon-delete" data-coupon="{{COUPON}}">
							<?=Loc::getMessage('SBB_DELETE')?>
						</span>
					</div>
					{{/COUPON_LIST}}
				</div>
			</div>
			<?
		}
		?>
	</div>
</script>