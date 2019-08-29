<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css");
$this->addExternalCss("/bitrix/css/main/bootstrap.css");
CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);
?>

<section class="page-all-sect page-profile__order-current">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="page-all-sect__top-title">
                    <h2>Список заказов</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="page-profile__left-menu categories-left-menu">
                    <? $APPLICATION->IncludeComponent("bitrix:menu", "personal_menu", array(
                        "ROOT_MENU_TYPE" => "personal",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_TYPE" => "A",
                        "CACHE_SELECTED_ITEMS" => "N",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                    ),
                        false
                    ); ?>
                </div>
            </div>
            <div class="col-sm-9">
                <? if (!empty($arResult['ERRORS']['FATAL'])) {
                    foreach ($arResult['ERRORS']['FATAL'] as $error) {
                        ShowError($error);
                    }
                    $component = $this->__component;
                    if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) {
                        $APPLICATION->AuthForm('', false, false, 'N', false);
                    }

                } else {
                    if (!empty($arResult['ERRORS']['NONFATAL'])) {
                        foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
                            ShowError($error);
                        }
                    }
                if (!count($arResult['ORDERS'])) {
                if ($_REQUEST["filter_history"] == 'Y') {
                if ($_REQUEST["show_canceled"] == 'Y') { ?>
                    <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_CANCELED_ORDER') ?></h3>
                <? } else { ?>
                    <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST') ?></h3>
                <? }
                } else { ?>
                    <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST') ?></h3>
                <? }
                } ?>

                    <!-- Ссылки сверху -->
                    <div class="row col-md-12 col-sm-12">
                        <?
                        $nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);
                        $clearFromLink = array("filter_history", "filter_status", "show_all", "show_canceled");

                        if ($nothing || $_REQUEST["filter_history"] == 'N') {
                            ?>
                            <a class="sale-order-history-link"
                               href="<?= $APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false) ?>">
                                <?
                                echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY") ?>
                            </a>
                            <?
                        }
                        if ($_REQUEST["filter_history"] == 'Y') {
                            ?>
                            <a class="sale-order-history-link" href="<?= $APPLICATION->GetCurPageParam("", $clearFromLink, false) ?>">
                                <?
                                echo Loc::getMessage("SPOL_TPL_CUR_ORDERS") ?>
                            </a>
                            <?
                            if ($_REQUEST["show_canceled"] == 'Y') {
                                ?>
                                <a class="sale-order-history-link"
                                   href="<?= $APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false) ?>">
                                    <?
                                    echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY") ?>
                                </a>
                                <?
                            } else {
                                ?>
                                <a class="sale-order-history-link"
                                   href="<?= $APPLICATION->GetCurPageParam("filter_history=Y&show_canceled=Y", $clearFromLink, false) ?>">
                                    <?
                                    echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_CANCELED") ?>
                                </a>
                                <?
                            }
                        }
                        ?>
                    </div>
                <? if (!count($arResult['ORDERS'])) { ?>
                    <div class="row col-md-12 col-sm-12">
                        <a href="<?= htmlspecialcharsbx($arParams['PATH_TO_CATALOG']) ?>" class="sale-order-history-link">
                            <?= Loc::getMessage('SPOL_TPL_LINK_TO_CATALOG') ?>
                        </a>
                    </div>
                <? }

                if ($_REQUEST["filter_history"] !== 'Y') {
                $paymentChangeData = array();
                $orderHeaderStatus = null;

                foreach ($arResult['ORDERS'] as $key => $order) {
                if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $arResult['SORT_TYPE'] == 'STATUS') {
                $orderHeaderStatus = $order['ORDER']['STATUS_ID'];

                ?>
                    <h3 class="page-current-order__title">
                        <?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?>
                        &laquo;<?= htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']) ?>&raquo;
                    </h3>
                    <?
                }
                    ?>
                    <div class="card-head-grey page-current-order__item">
                        <div class="card-head-grey__head">
                            <h4 class="card-head-grey__title">
                                <?= Loc::getMessage('SPOL_TPL_ORDER') ?>
                                <?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') . $order['ORDER']['ACCOUNT_NUMBER'] ?>
                                <?= Loc::getMessage('SPOL_TPL_FROM_DATE') ?>
                                <?= $order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT']) ?>,
                            </h4>
                        </div>
                        <div class="card-head-grey__body sale-order-info">
													<span class="sale-order-list-inner-title-line first">
														<span class="sale-order-list-inner-title-line-item">Информация о заказе</span>
														<span class="sale-order-list-inner-title-line-border"></span>
													</span>
                            <?
                            $showDelimeter = false;
                            foreach ($order['PAYMENT'] as $payment) {
                                if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y') {
                                    $paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
                                        "order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
                                        "payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
                                        "allow_inner" => $arParams['ALLOW_INNER'],
                                        "refresh_prices" => $arParams['REFRESH_PRICES'],
                                        "path_to_payment" => $arParams['PATH_TO_PAYMENT'],
                                        "only_inner_full" => $arParams['ONLY_INNER_FULL']
                                    );
                                }
                                ?>
                                <div class="sale-order-list-inner-row">
                                    <? if ($showDelimeter) { ?>
                                        <div class="sale-order-list-top-border"></div>
                                    <? } else {
                                        $showDelimeter = true;
                                    } ?>

                                    <div class="sale-order-list-inner-row-body">
                                        <div class="sale-order-list-payment">
                                            <div class="sale-order-list-payment-title">
                                                <span class="sale-order-list-payment-title-element">Способ оплаты: <?= $payment['PAY_SYSTEM_NAME'] ?></span>
                                            </div>
                                            <div class="sale-order-list-payment-title">
                                                <span class="sale-order-list-payment-title-element">Сумма к оплате: <?= $order['ORDER']['FORMATED_PRICE'] ?></span>
                                            </div>

                                            <div hidden>
                                                <? if ($payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y') {
                                                    if ($order['ORDER']['IS_ALLOW_PAY'] == 'N') {
                                                        ?>
                                                        <div class="sale-order-list-button-container">
                                                            <a class="btn btn_color_ac inactive-button">
                                                                <?= Loc::getMessage('SPOL_TPL_PAY') ?>
                                                            </a>
                                                        </div>
                                                    <? } elseif ($payment['NEW_WINDOW'] === 'Y') { ?>
                                                        <div class="sale-order-list-button-container">
                                                            <a class="btn btn_color_ac" target="_blank"
                                                               href="<?= htmlspecialcharsbx($payment['PSA_ACTION_FILE']) ?>">
                                                                <?= Loc::getMessage('SPOL_TPL_PAY') ?>
                                                            </a>
                                                        </div>
                                                    <? } else { ?>
                                                        <div class="sale-order-list-button-container">
                                                            <a class="btn btn_color_ac ajax_reload"
                                                               href="<?= htmlspecialcharsbx($payment['PSA_ACTION_FILE']) ?>">
                                                                <?= Loc::getMessage('SPOL_TPL_PAY') ?>
                                                            </a>
                                                        </div>
                                                    <? }
                                                } ?>
                                                <?
                                                if (!empty($payment['CHECK_DATA'])) {
                                                    $listCheckLinks = "";
                                                    foreach ($payment['CHECK_DATA'] as $checkInfo) {
                                                        $title = Loc::getMessage('SPOL_CHECK_NUM', array('#CHECK_NUMBER#' => $checkInfo['ID'])) . " - " . htmlspecialcharsbx($checkInfo['TYPE_NAME']);
                                                        if (strlen($checkInfo['LINK'])) {
                                                            $link = $checkInfo['LINK'];
                                                            $listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
                                                        }
                                                    }
                                                    if (strlen($listCheckLinks) > 0) {
                                                        ?>
                                                        <div class="sale-order-list-payment-check">
                                                            <div class="sale-order-list-payment-check-left"><?= Loc::getMessage('SPOL_CHECK_TITLE') ?>
                                                                :
                                                            </div>
                                                            <div class="sale-order-list-payment-check-left">
                                                                <?= $listCheckLinks ?>
                                                            </div>
                                                        </div>
                                                        <?
                                                    }
                                                }
                                                if ($payment['PAID'] !== 'Y' && $order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y') {
                                                    ?>
                                                    <a href="#" class="sale-order-list-change-payment sale-order-info__list-change-payment"
                                                       id="<?= htmlspecialcharsbx($payment['ACCOUNT_NUMBER']) ?>">
                                                        <?= Loc::getMessage('SPOL_TPL_CHANGE_PAY_TYPE') ?>
                                                    </a>
                                                    <?
                                                }
                                                if ($order['ORDER']['IS_ALLOW_PAY'] == 'N' && $payment['PAID'] !== 'Y') {
                                                    ?>
                                                    <div class="sale-order-list-status-restricted-message-block">
                                                        <span class="sale-order-list-status-restricted-message"><?= Loc::getMessage('SOPL_TPL_RESTRICTED_PAID_MESSAGE') ?></span>
                                                    </div>
                                                    <?
                                                }
                                                ?>
                                            </div>
                                            <? foreach ($order['SHIPMENT'] as $shipment) :
                                                if (empty($shipment)) {
                                                    continue;
                                                }
                                                ?>
                                                <div class="sale-order-list-payment-title">
                                                    <span class="sale-order-list-payment-title-element">Способ доставки: <?= $arResult['INFO']['DELIVERY'][$shipment['DELIVERY_ID']]['NAME'] ?></span>
                                                </div>
                                                <div class="sale-order-list-payment-title">
                                                    <span class="sale-order-list-payment-title-element">Стоимость доставки: <?= $shipment['FORMATED_DELIVERY_PRICE'] ?></span>
                                                </div>
                                            <? endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                        <div class="card-head-grey__bottom pp-current-order-card-btm">
                            <div class="pp-current-order-card-btm__btn-more">
                                <a
                                        class="btn"
                                        href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"]) ?>">
                                    <?= Loc::getMessage('SPOL_TPL_MORE_ON_ORDER') ?>
                                </a>
                            </div>

                            <div class="pp-current-order-card-btm__btn-repeat">
                                <a
                                        class="btn btn_arrow_left"
                                        href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"]) ?>">
                                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/repeat.svg") ?>" class="img-svg">
                                    <span><?= Loc::getMessage('SPOL_TPL_REPEAT_ORDER') ?></span>
                                </a>
                            </div>
                        </div>
                        <a
                                class="sale-order-list-cancel-link"
                                href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"]) ?>"
                                style="display: none !important">
                            <?= Loc::getMessage('SPOL_TPL_CANCEL_ORDER') ?>
                        </a>
                    </div>
                    <?
                }
                } else {
                    $orderHeaderStatus = null;

                if ($_REQUEST["show_canceled"] === 'Y' && count($arResult['ORDERS'])) {
                    ?>
                    <h3 class="page-current-order__title">
                        <?= Loc::getMessage('SPOL_TPL_ORDERS_CANCELED_HEADER') ?>
                    </h3>
                    <?
                }

                foreach ($arResult['ORDERS'] as $key => $order) {
                if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $_REQUEST["show_canceled"] !== 'Y') {
                    $orderHeaderStatus = $order['ORDER']['STATUS_ID'];
                    ?>
                    <h3 class="page-current-order__title">
                        <?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?>
                        &laquo;<?= htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']) ?>&raquo;
                    </h3>
                    <?
                }
                    ?>
                    <!-- Блок с историей заказов -->
                    <div class="card-head-grey page-current-order__item">
                        <div class="card-head-grey__head card-head-grey__head_info">
                            <h4 class="card-head-grey__title">
                                <?= Loc::getMessage('SPOL_TPL_ORDER') ?>
                                <?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') ?>
                                <?= htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']) ?>
                                <?= Loc::getMessage('SPOL_TPL_FROM_DATE') ?>
                                <?= $order['ORDER']['DATE_INSERT'] ?>,
                                <?= count($order['BASKET_ITEMS']); ?>
                                <?
                                $count = substr(count($order['BASKET_ITEMS']), -1);
                                if ($count == '1') {
                                    echo Loc::getMessage('SPOL_TPL_GOOD');
                                } elseif ($count >= '2' || $count <= '4') {
                                    echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
                                } else {
                                    echo Loc::getMessage('SPOL_TPL_GOODS');
                                }
                                ?>
                                <?= Loc::getMessage('SPOL_TPL_SUMOF') ?>
                                <?= $order['ORDER']['FORMATED_PRICE'] ?>
                            </h4>
                            <div class="card-head-grey__info">
                                <? if ($_REQUEST["show_canceled"] !== 'Y') { ?>
                                    <span class="sale-order-list-accomplished-date">
															<?= Loc::getMessage('SPOL_TPL_ORDER_FINISHED') ?>
														</span>
                                <? } else { ?>
                                    <span class="sale-order-list-accomplished-date canceled-order">
															<?= Loc::getMessage('SPOL_TPL_ORDER_CANCELED') ?>
														</span>
                                <? } ?>
                                <span class="sale-order-list-accomplished-date-number"><?= $order['ORDER']['DATE_STATUS_FORMATED'] ?></span>
                            </div>
                        </div>
                        <div class="card-head-grey__bottom pp-current-order-card-btm">
                            <div class="pp-current-order-card-btm__btn-more">
                                <a class="btm"
                                   href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"]) ?>">
                                    <?= Loc::getMessage('SPOL_TPL_MORE_ON_ORDER') ?>
                                </a>
                            </div>
                            <div class="pp-current-order-card-btm__btn-repeat">
                                <a class="btn btn_arrow_left"
                                   href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"]) ?>">
                                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/repeat.svg") ?>" class="img-svg">
                                    <span><?= Loc::getMessage('SPOL_TPL_REPEAT_ORDER') ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?
                }
                }
                ?>
                    <div class="clearfix"></div>
                <?
                echo $arResult["NAV_STRING"];

                if ($_REQUEST["filter_history"] !== 'Y') {
                $javascriptParams = array(
                    "url" => CUtil::JSEscape($this->__component->GetPath() . '/ajax.php'),
                    "templateFolder" => CUtil::JSEscape($templateFolder),
                    "templateName" => $this->__component->GetTemplateName(),
                    "paymentList" => $paymentChangeData
                );
                $javascriptParams = CUtil::PhpToJSObject($javascriptParams);
                ?>
                    <script>
                        BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
                    </script>
                    <?
                }
                }
                ?>
            </div>
        </div>
    </div>
</section>
