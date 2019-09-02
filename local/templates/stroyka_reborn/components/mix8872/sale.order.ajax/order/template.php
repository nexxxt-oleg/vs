<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
    if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
    {
        if(strlen($arResult["REDIRECT_URL"]) > 0)
        {
            $APPLICATION->RestartBuffer();
            ?>
            <script type="text/javascript">
                window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
            </script>
            <?
            die();
        }

    }
}

$APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");
$APPLICATION->AddHeadScript($templateFolder.'/jquery.maskedinput.min.js');
?>
<a name="order_form"></a>
<section class="page-all-sect page-ordering__order">
    <div class="new-container">
        <div class="new-row">
            <div class="new-col-12">
                <div class="page-all-sect__top-title">
                    <span class="h2-new">Оформление заказа</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="page-ordering__form">
    <div class="new-container">
        <div class="new-row">
            <div class="new-col-md-7 new-col-lg-6">
                <hr class="page-ordering__line">
            </div>
        </div>
        <div class="new-row">
            <div class="new-col-md-11 new-col-lg-10">



    <div id="order_form_div" class="order-checkout">
        <NOSCRIPT>
            <div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
        </NOSCRIPT>

        <?
        if (!function_exists("getColumnName"))
        {
            function getColumnName($arHeader)
            {
                return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
            }
        }

        if (!function_exists("cmpBySort"))
        {
            function cmpBySort($array1, $array2)
            {
                if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
                    return -1;

                if ($array1["SORT"] > $array2["SORT"])
                    return 1;

                if ($array1["SORT"] < $array2["SORT"])
                    return -1;

                if ($array1["SORT"] == $array2["SORT"])
                    return 0;
            }
        }
        ?>

        <div class="bx_order_make">
            <?
            if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
            {
                if(!empty($arResult["ERROR"]))
                {
                    foreach($arResult["ERROR"] as $v)
                        echo ShowError($v);
                }
                elseif(!empty($arResult["OK_MESSAGE"]))
                {
                    foreach($arResult["OK_MESSAGE"] as $v)
                        echo ShowNote($v);
                }

                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
            }
            else
            {
                if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
                {
                    if(strlen($arResult["REDIRECT_URL"]) == 0)
                    {
                        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
                    }
                }
                else
                {
                    ?>
                    <script type="text/javascript">

                        <?if(CSaleLocation::isLocationProEnabled()):?>

                        <?
                        // spike: for children of cities we place this prompt
                        $city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
                        ?>

                        BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
                            'source' => $this->__component->getPath().'/get.php',
                            'cityTypeId' => intval($city['ID']),
                            'messages' => array(
                                'otherLocation' => '--- '.GetMessage('SOA_OTHER_LOCATION'),
                                'moreInfoLocation' => '--- '.GetMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
                                'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.GetMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.GetMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
                                        '#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
                                        '#ANCHOR_END#' => '</a>'
                                    )).'</div>'
                            )
                        ))?>);

                        <?endif?>

                        var BXFormPosting = false;
                        function submitForm(val)
                        {
                            if (BXFormPosting === true)
                                return true;
                            //BX.hide(BX('select_store'));
                            BXFormPosting = true;
                            if(val != 'Y')
                                BX('confirmorder').value = 'N';

                            var orderForm = BX('ORDER_FORM');
                            BX.showWait();

							BX.saleOrderAjax.cleanUp();
                            BX.ajax.submit(orderForm, ajaxResult);

                            return true;
                        }
                        
                        function validsubmitForm() {
                        	
                        	$('.ordering-form__input-block').removeClass('error');
    						$('#ORDER_FORM .error-text').remove();
                        	
                    	    var name = $('#ORDER_PROP_1').val();
						    var phone = $('#ORDER_PROP_3').val();
						    var email = $('#ORDER_PROP_2').val();
                        	var error = 0;
                        	
                        	if (name.length<1) {
								$('#ORDER_PROP_1').parent().addClass('error');
								$('#ORDER_PROP_1').after('<p class="ordering-form__error-text error-text">Обязательное поле</p>');
								error = 1;
							}
							
							if (email.length<1) {
								$('#ORDER_PROP_2').parent().addClass('error');
								$('#ORDER_PROP_2').after('<p class="ordering-form__error-text error-text">Обязательное поле</p>');
								error = 1;
							} else {
								var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}$/i;
								if(!pattern.test(email)) {
								   	$('#ORDER_PROP_2').parent().addClass('error');
									$('#ORDER_PROP_2').after('<p class="ordering-form__error-text error-text">Вы ввели некорректный e-mail</p>');
									error = 1;
								}
							}
							
							if (phone.length<1) {
								$('#ORDER_PROP_3').parent().addClass('error');
								$('#ORDER_PROP_3').after('<p class="ordering-form__error-text error-text">Обязательное поле</p>');
								error = 1;
							}
							
							if($('#ORDER_PROP_7').length > 0) {
								var adr = $('#ORDER_PROP_7').val();
								if (adr.length<1) {
									$('#ORDER_PROP_7').parent().addClass('error');
									$('#ORDER_PROP_7').after('<p class="ordering-form__error-text error-text">Обязательное поле</p>');
									error = 1;
								}
							}
                        	
                        	if(!error) {
								submitForm('Y');	
							}
						}

                        function ajaxResult(res)
                        {
                            var orderForm = BX('ORDER_FORM');
                            try
                            {
                                // if json came, it obviously a successfull order submit

                                var json = JSON.parse(res);
                                BX.closeWait();

                                if (json.error)
                                {
                                    BXFormPosting = false;
                                    return;
                                }
                                else if (json.redirect)
                                {
                                    window.top.location.href = json.redirect;
                                }
                            }
                            catch (e)
                            {
                                // json parse failed, so it is a simple chunk of html

                                BXFormPosting = false;
                                BX('order_form_content').innerHTML = res;

                                <?if(CSaleLocation::isLocationProEnabled()):?>
                                BX.saleOrderAjax.initDeferredControl();
                                <?endif?>
                            }

                            BX.closeWait();
                            BX.onCustomEvent(orderForm, 'onAjaxSuccess');
                        }

                        function SetContact(profileId)
                        {
                            BX("profile_change").value = "Y";
                            submitForm();
                        }
                    </script>
                    <?if($_POST["is_ajax_post"] != "Y")
                {
                    ?><form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
                    <?=bitrix_sessid_post()?>
                    <div id="order_form_content">
                        <?
                        }
                        else
                        {
                            $APPLICATION->RestartBuffer();
                        }

                        if($_REQUEST['PERMANENT_MODE_STEPS'] == 1)
                        {
                            ?>
                            <input type="hidden" name="PERMANENT_MODE_STEPS" value="1" />
                            <?
                        }

                        if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
                        {
                            foreach($arResult["ERROR"] as $v)
                                echo ShowError($v);
                            ?>
                            <script type="text/javascript">
                                top.BX.scrollToNode(top.BX('ORDER_FORM'));
                            </script>
                            <?
                        }

                        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
                        if (!$_REQUEST["DELIVERY_ID"] || $_REQUEST["DELIVERY_ID"] == 'simple:simple') {
                            include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/delivery-city.php");
                        }
                        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
                        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
                        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");
                        ?>
                        <div class="ordering-form__input-block">
                            <span class="ordering-form__label">Комментарий к заказу</span>
                            <textarea class="ordering-form__text-point ordering-form-textarea"
                                      name="ORDER_DESCRIPTION"
                                      id="ORDER_DESCRIPTION"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea>
                        </div>
                        <?
                        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
                        if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
                            echo $arResult["PREPAY_ADIT_FIELDS"];
                        ?>

                        <?if($_POST["is_ajax_post"] != "Y")
                        {
                        ?>
                    </div>
                    <input type="hidden" name="confirmorder" id="confirmorder" value="Y">
                    <input type="hidden" name="profile_change" id="profile_change" value="N">
                    <input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
                    <input type="hidden" name="json" value="Y">
                    <button
                            class="ordering-form__send gradient-btn"
                            onclick="validsubmitForm('Y'); return false;"
                            id="ORDER_CONFIRM_BUTTON"><span>Подтвердить заказ</span>
                    </button>
                </form>
                    <?
                if($arParams["DELIVERY_NO_AJAX"] == "N")
                {
                    ?>
                    <div style="display:none;"><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?></div>
                <?
                }
                }
                else
                {
                ?>
                    <script type="text/javascript">
                        top.BX('confirmorder').value = 'Y';
                        top.BX('profile_change').value = 'N';
                    </script>
                    <?
                    die();
                }
                }
            }
            ?>
        </div>
    </div>

<?if(CSaleLocation::isLocationProEnabled()):?>

    <div style="display: none">
        <?// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:sale.location.selector.steps",
            ".default",
            array(
            ),
            false
        );?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:sale.location.selector.search",
            ".default",
            array(
            ),
            false
        );?>
    </div>

<?endif?>

            </div>
        </div>
    </div>
</section>
