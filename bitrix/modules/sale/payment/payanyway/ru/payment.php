<?php
global $MESS;

$MESS['PAYANYWAY_TITLE']			= 'PayAnyWay.ru';
$MESS['PAYANYWAY_DESC']				= 'Оплата через платёжную систему PayAnyWay.ru. Для получения результата оплаты необходимо создать специальную страницу и разместить на ней компонент bitrix:sale.order.payment.receive с соответствующими параметрами. Указажите этот адрес в настройках Вашего счёта в системе PayAnyWay.ru («Pay URL»).';
$MESS['PAYANYWAY_SERVER']			= 'URL платежной системы demo.moneta.ru - для демо-аккаунта, www.payanyway.ru - для реального аккаунта в PayAnyWay.';
$MESS['PAYANYWAY_ID']				= 'Номер счета - номер расширенного счета в платежной системе PayAnyWay (Moneta.ru)';
$MESS['PAYANYWAY_AMOUNT']			= 'Сумма заказа';
$MESS['DATA_INTEGRITY_CODE']		= 'Код проверки целостности данных - указан в настройках расширенного счета';
$MESS['PAYANYWAY_TEST_MODE']		= 'Тестовый режим переход в режим тестирования, деньги не списываются со счета';
$MESS['PAYANYWAY_TEST_MODE_TRUE']	= 'Да';
$MESS['PAYANYWAY_TEST_MODE_FALSE']	= 'Нет';
$MESS['PAYANYWAY_LOGIN']			= 'Логин в PayAnyWay';
$MESS['PAYANYWAY_PASSWORD']			= 'Пароль PayAnyWay';
$MESS['PAYANYWAY_PAY_URL']			= 'Pay URL';
$MESS['PAYANYWAY_PAY_URL_DESC']		= 'URL страницы подтверждения оплаты';
$MESS["PAYANYWAY_CHANGE_ORDER_STATUS"]		= "Автоматически менять статус заказа на 'Оплачен' при подтверждении оплаты.";
$MESS["PAYANYWAY_CHANGE_ORDER_STATUS_DESC"] = "Y - менять, N - не менять.";

$MESS['PAYMENT_PAYANYWAY_TITLE']	= 'Оплата через платёжную систему PayAnyWay.ru';
$MESS['PAYMENT_PAYANYWAY_ORDER']	= 'Заказ номер';
$MESS['PAYMENT_PAYANYWAY_TO_PAY']	= 'Сумма к оплате:';
$MESS['PAYMENT_PAYANYWAY_BUTTON']	= 'Оплатить';
$MESS['PAYANYWAY_EXTRA_PARAMS_OK']	= 'Продолжить';
$MESS['PAYANYWAY_PAYMENT_CONFIRMED']    = 'Уведомление получено';
$MESS['PAYANYWAY_PAYMENT_CANCELED']     = 'Отменено платежной системой';

$MESS['PAYANYWAY_PAYMENT_TYPE'] = 'Способ оплаты';
$MESS['PAYANYWAY_DEPENDENCIES_ERROR'] = 'Для использования всех функций модуля необходимо установить расширения SOAP и libxml';
$MESS['PAYANYWAY_BANKTRANSFER'] = 'Банковский перевод';
$MESS['PAYANYWAY_CIBERPAY'] = 'Ciberpay';
$MESS['PAYANYWAY_COMEPAY'] = 'Comepay';
$MESS['PAYANYWAY_CONTACT'] = 'Contact';
$MESS['PAYANYWAY_ELECSNET'] = 'Элекснет';
$MESS['PAYANYWAY_EUROSET'] = 'Евросеть, Связной';
$MESS['PAYANYWAY_FORWARD'] = 'Форвард Мобайл';
$MESS['PAYANYWAY_GOROD'] = 'Федеральная Система ГОРОД';
$MESS['PAYANYWAY_MCB'] = 'Московский Кредитный Банк';
$MESS['PAYANYWAY_MONETA'] = 'Монета.ру';
$MESS['PAYANYWAY_MONEYMAIL'] = 'MoneyMail';
$MESS['PAYANYWAY_NOVOPLAT'] = 'NovoPlat';
$MESS['PAYANYWAY_PLASTIC'] = 'VISA, MasterCard';
$MESS['PAYANYWAY_PLATIKA'] = 'Платика';
$MESS['PAYANYWAY_POST'] = 'Отделения "Почта России"';
$MESS['PAYANYWAY_WEBMONEY'] = 'WebMoney';
$MESS['PAYANYWAY_YANDEX'] = 'Яндекс.Деньги';

$MESS["SASP_IP"] = "В процессе";
$MESS["SASP_D"] = "Ожидает подтверждения оплаты";
$MESS["SASP_A"] = "Оплачен";
$MESS["SASP_PA"] = "Оплачен частично";
$MESS["SASP_PD"] = "Подтвержден частично";
$MESS["SASP_C"] = "Отменен";
$MESS["SASP_PC"] = "Отменен частично";
$MESS["SASP_DEC"] = "Отклонен";
$MESS["SASP_T"] = "Закрыт по истечении времени";

$MESS["SASPD_IP"] = "Заказ создан";
$MESS["SASPD_D"] = "Операция оплаты по данному заказу успешно завершена по двустадийному механизму";
$MESS["SASPD_A"] = "Операция оплаты по данному заказу успешно завершена";
$MESS["SASPD_PA"] = "Операция оплаты проведена на часть суммы заказа (не используется)";
$MESS["SASPD_PD"] = "Подтверждение оплаты совершено на часть суммы оплаты";
$MESS["SASPD_C"] = "Отменен на полную сумму оплаты";
$MESS["SASPD_PC"] = "Отменен на часть суммы оплаты";
$MESS["SASPD_DEC"] = "Оплата завершена неуспешно";
$MESS["SASPD_T"] = "Заказ завершен по тайм-ауту";

?>