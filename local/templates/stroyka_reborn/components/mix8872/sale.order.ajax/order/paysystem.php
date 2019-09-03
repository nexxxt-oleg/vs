<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

	<script type="text/javascript">
		function changePaySystem(param)
		{
			if (BX("account_only") && BX("account_only").value == 'Y') // PAY_CURRENT_ACCOUNT checkbox should act as radio
			{
				if (param == 'account')
				{
					if (BX("PAY_CURRENT_ACCOUNT"))
					{
						BX("PAY_CURRENT_ACCOUNT").checked = true;
						BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
						BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');

						// deselect all other
						var el = document.getElementsByName("PAY_SYSTEM_ID");
						for(var i=0; i<el.length; i++)
							el[i].checked = false;
					}
				}
				else
				{
					BX("PAY_CURRENT_ACCOUNT").checked = false;
					BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
					BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
				}
			}
			else if (BX("account_only") && BX("account_only").value == 'N')
			{
				if (param == 'account')
				{
					if (BX("PAY_CURRENT_ACCOUNT"))
					{
						BX("PAY_CURRENT_ACCOUNT").checked = !BX("PAY_CURRENT_ACCOUNT").checked;

						if (BX("PAY_CURRENT_ACCOUNT").checked)
						{
							BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
							BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
						}
						else
						{
							BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
							BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
						}
					}
				}
			}

			submitForm();
		}
	</script>
	<div class="ordering-form__wrap">
		<span class="ordering-form__title h3-new">Способ оплаты</span>
        <div class="ordering-form__flex form-flex">
		<?
		$arPaySystemDesc = [];
		if ($arResult["PAY_FROM_ACCOUNT"] == "Y")
		{
			$accountOnly = ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y") ? "Y" : "N";
			?>
			<input type="hidden" id="account_only" value="<?=$accountOnly?>" class="form-flex__radio" />

					<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="N">
					<label
                            class="form-flex__btn form-flex__btn_sm form-flex-btn_sm form-flex-btn"
                            for="PAY_CURRENT_ACCOUNT"
                            id="PAY_CURRENT_ACCOUNT_LABEL" onclick="changePaySystem('account');" class="<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo "selected"?>">
						<input type="checkbox" name="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT" value="Y"<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo " checked=\"checked\"";?>>
						<!--div class="bx_logotype">
							<span style="background-image:url(<?=$templateFolder?>/images/logo-default-ps.gif);"></span>
						</div-->
						<div class="bx_description">
							<strong><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT")?></strong>
							<p>
								<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT1")." <b>".$arResult["CURRENT_BUDGET_FORMATED"]?></b></div>
								<? if ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y"):?>
									<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT3")?></div>
								<? else:?>
									<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT2")?></div>
								<? endif;?>
							</p>
						</div>
					</label>

			<?
		}

		uasort($arResult["PAY_SYSTEM"], "cmpBySort"); // resort arrays according to SORT value


		foreach($arResult["PAY_SYSTEM"] as $arPaySystem)
		{
			$arPaySystemDesc[$arPaySystem["ID"]] = $arPaySystem["DESCRIPTION"];
			
			if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) > 0 || intval($arPaySystem["PRICE"]) > 0)
			{
				if (count($arResult["PAY_SYSTEM"]) == 1)
				{
					?>
					<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
                    <input type="radio"
                        id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
                        name="PAY_SYSTEM_ID"
                        value="<?=$arPaySystem["ID"]?>"
                        <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
                        onclick="changePaySystem();"
                           class="form-flex__radio"
                        />
                    <label class="form-flex__btn form-flex__btn_sm form-flex-btn_sm form-flex-btn" for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
								<?
								if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
									$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
								else:
									$imgUrl = $templateFolder."/images/logo-default-ps.gif";
								endif;
								?>
								<div class="bx_logotype" style="background-image:url(<?=$imgUrl?>);">
								</div>

									<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
										<span><?=$arPaySystem["PSA_NAME"];?></span>
									<?endif;?>

							</label>


					<?
				}
				else // more than one
				{
				?>
					<input type="radio"
                           class="form-flex__radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();" />
							<label class="form-flex__btn form-flex__btn_sm form-flex-btn_sm form-flex-btn" for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
								<?
								if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
									$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
								else:
									$imgUrl = $templateFolder."/images/logo-default-ps.gif";
								endif;
								?>


									<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
										<span><?=$arPaySystem["PSA_NAME"];?></span>
									<?endif;?>
                                <div class="bx_logotype" style='background-image:url(<?=$imgUrl?>);'>
                                </div>

							</label>

				<?
				}
			}

			if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) == 0 && intval($arPaySystem["PRICE"]) == 0)
			{
				if (count($arResult["PAY_SYSTEM"]) == 1)
				{
					?>

							<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
							<input type="radio"
                                   class="form-flex__radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();"
								/>
							<label class="form-flex__btn form-flex__btn_sm form-flex-btn_sm form-flex-btn" for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
							<?
							if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
								$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
							else:
								$imgUrl = $templateFolder."/images/logo-default-ps.gif";
							endif;
							?>
							<!--div class="bx_logotype">
								<span style='background-image:url(<?=$imgUrl?>);'></span>
							</div-->
							<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>

									<span><?=$arPaySystem["PSA_NAME"];?></span>

							<?endif;?>

				<?
				}
				else // more than one
				{
				?>


							<input class="form-flex__radio" type="radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();" />

							<label class="form-flex__btn form-flex__btn_sm form-flex-btn_sm form-flex-btn" for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
								<?
								if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
									$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
								else:
									$imgUrl = $templateFolder."/images/logo-default-ps.gif";
								endif;
								?>
								<!--div class="bx_logotype">
									<span style='background-image:url(<?=$imgUrl?>);'></span>
								</div-->
								<span><?=$arPaySystem["PSA_NAME"];?></span>

							</label>

				<?
				}
			}
		}
		?>
        </div>
        <div class="ordering-form__info">
		<?php
        if($_REQUEST["PAY_SYSTEM_ID"]){
			$key = intval(htmlspecialchars($_REQUEST["PAY_SYSTEM_ID"]));
			echo $arPaySystemDesc[$key];
		} else {
			echo array_shift($arPaySystemDesc);
		}
         
         ?>
         </div>
	</div>
