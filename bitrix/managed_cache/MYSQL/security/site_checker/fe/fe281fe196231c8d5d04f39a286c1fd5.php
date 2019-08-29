<?
if($INCLUDE_FROM_CACHE!='Y')return false;
$datecreate = '001564561748';
$dateexpire = '001567153748';
$ser_content = 'a:2:{s:7:"CONTENT";s:0:"";s:4:"VARS";a:2:{s:7:"results";a:7:{i:0;a:5:{s:5:"title";s:102:"Пароль к БД не содержит спецсимволов(знаков препинания)";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:138:"Пароль слишком прост, что повышает риск взлома учетной записи в базе данных";s:14:"recommendation";s:57:"Добавить спецсимволов в пароль";s:15:"additional_info";s:0:"";}i:1;a:5:{s:5:"title";s:105:"Ограничен список потенциально опасных расширений файлов";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:377:"Текущий список расширений файлов, которые считаются потенциально опасными, не содержит всех рекомендованных значений. Список расширений исполняемых файлов всегда должен находится в актуальном состоянии";s:14:"recommendation";s:264:"Вы всегда можете изменить список расширений исполняемых файлов в настройках сайта: <a href="/bitrix/admin/settings.php?mid=fileman" target="_blank">Управление структурой</a>";s:15:"additional_info";s:344:"Текущие: php,php3,php4,php5,php6<br>
Рекомендованные (без учета настроек вашего сервера): php,php3,php4,php5,php6,phtml,pl,asp,aspx,cgi,dll,exe,ico,shtm,shtml,fcg,fcgi,fpl,asmx,pht,py,psp<br>
Отсутствующие: phtml,pl,asp,aspx,cgi,dll,exe,ico,shtm,shtml,fcg,fcgi,fpl,asmx,pht,py,psp";}i:2;a:5:{s:5:"title";s:113:"Разрешено отображение сайта во фрейме с произвольного домена";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:307:"Запрет отображения фреймов сайта со сторонних доменов способен предотвратить целый класс атак, таких как <a href="https://www.owasp.org/index.php/Clickjacking" target="_blank">Clickjacking</a>, Framesniffing и т.д.";s:14:"recommendation";s:1875:"Скорее всего, вам будет достаточно разрешения на просмотр сайта в фреймах только на страницах текущего сайта.
Сделать это достаточно просто, достаточно добавить заголовок ответа "X-Frame-Options: SAMEORIGIN" в конфигурации вашего frontend-сервера.
</p><p>В случае использования nginx:<br>
1. Найти секцию server, отвечающую за обработку запросов нужного сайта. Зачастую это файлы в /etc/nginx/site-enabled/*.conf<br>
2. Добавить строку:
<pre>
add_header X-Frame-Options SAMEORIGIN;
</pre>
3. Перезапустить nginx<br>
Подробнее об этой директиве можно прочесть в документации к nginx: <a href="http://nginx.org/ru/docs/http/ngx_http_headers_module.html" target="_blank">Модуль ngx_http_headers_module</a>
</p><p>В случае использования Apache:<br>
1. Найти конфигурационный файл для вашего сайта, зачастую это файлы /etc/apache2/httpd.conf, /etc/apache2/vhost.d/*.conf<br>
2. Добавить строки:
<pre>
&lt;IfModule headers_module&gt;
	Header set X-Frame-Options SAMEORIGIN
&lt;/IfModule&gt;
</pre>
3. Перезапустить Apache<br>
4. Убедиться, что он корректно обрабатывается Apache и этот заголовок никто не переопределяет<br>
Подробнее об этой директиве можно прочесть в документации к Apache: <a href="http://httpd.apache.org/docs/2.2/mod/mod_headers.html" target="_blank">Apache Module mod_headers</a>
</p>";s:15:"additional_info";s:2651:"Адрес: <a href="http://vs82.ru/" target="_blank">http://vs82.ru/</a><br>Запрос/Ответ: <pre>GET / HTTP/1.1
host: vs82.ru
accept: */*
user-agent: BitrixCloud BitrixSecurityScanner/Robin-Scooter

HTTP/1.1 200 OK
Server: nginx
Date: Tue, 25 Jun 2019 08:32:32 GMT
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
Vary: Accept-Encoding
X-Powered-By: PHP/7.1.18
P3P: policyref=&quot;/bitrix/p3p.xml&quot;, CP=&quot;NON DSP COR CUR ADM DEV PSA PSD OUR UNR BUS UNI COM NAV INT DEM STA&quot;
X-Powered-CMS: Bitrix Site Manager (548fd64933658dd700dedf3525b9d87d)
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate
Pragma: no-cache
Set-Cookie: PHPSESSID=3afe9bfb4270ed31998ed40bd1869a88; path=/; HttpOnly
Set-Cookie: LIVECHAT_GUEST_HASH=e17869a3e523029f884e4b6c899d2346; expires=Wed, 24-Jun-2020 08:32:31 GMT; Max-Age=31536000; path=/
Set-Cookie: BITRIX_SM_ABTEST_s1=deleted; expires=Thu, 01-Jan-1970 00:00:01 GMT; Max-Age=0; path=/
Set-Cookie: BITRIX_SM_H2O_COOKIE_USER_ID=a1ca2e58c9dd396d6111548036429497; expires=Fri, 19-Jun-2020 08:32:31 GMT; Max-Age=31103999; path=/
Set-Cookie: BITRIX_SM_SALE_UID=7b652a245be351949baf78b2f46ac7e4; expires=Fri, 19-Jun-2020 08:32:32 GMT; Max-Age=31104000; path=/

&lt;!doctype html&gt;
&lt;html lang=&quot;ru&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;utf-8&quot;&gt;
    &lt;meta http-equiv=&quot;X-UA-Compatible&quot; content=&quot;IE=edge&quot;&gt;
    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1, maximum-scale=1&quot;&gt;
    &lt;link rel=&quot;icon&quot; href=&quot;/favicon.png&quot; type=&quot;image/png&quot;&gt;
    &lt;title&gt;Интернет магазин стройматериалов &quot;Вечная стройка&quot;&lt;/title&gt;
    &lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=UTF-8&quot; /&gt;
&lt;meta name=&quot;robots&quot; content=&quot;index, follow&quot; /&gt;
&lt;meta name=&quot;keywords&quot; content=&quot;Стройматериалы&quot; /&gt;
&lt;meta name=&quot;description&quot; content=&quot;Интернет магазин строительных материалов с доставкой по г.Саки и Сакскому району. Самые выгодные ценовые предложения и сервис&quot; /&gt;
&lt;script type=&quot;text/javascript&quot; data-skip-moving=&quot;true&quot;&gt;(function(w, d, n) {var cl = &quot;bx-core&quot;;var ht = d.documentElement;var htc = ht ? ht.className : undefined;if (htc === undefined
----------Only 1Kb of body shown----------<pre>";}i:3;a:5:{s:5:"title";s:68:"Разрешено чтение файлов по URL (URL wrappers)";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:256:"Если эта, сомнительная, возможность PHP не требуется - рекомендуется отключить, т.к. она может стать отправной точкой для различного типа атак";s:14:"recommendation";s:89:"Необходимо в настройках php указать:<br>allow_url_fopen = Off";s:15:"additional_info";s:0:"";}i:4;a:5:{s:5:"title";s:110:"Установлен не корректный порядок формирования массива _REQUEST";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:392:"Зачастую в массив _REQUEST нет необходимости добавлять любые переменные, кроме массивов _GET и _POST. В противном случае это может привести к раскрытию информации о пользователе/сайте и иным не предсказуемым последствиям.";s:14:"recommendation";s:88:"Необходимо в настройках php указать:<br>request_order = "GP"";s:15:"additional_info";s:75:"Текущее значение: ""<br>Рекомендованное: "GP"";}i:5;a:5:{s:5:"title";s:44:"Включен Automatic MIME Type Detection";s:8:"critical";s:3:"LOW";s:6:"detail";s:248:"По умолчанию в Internet Explorer/FlashPlayer включен автоматический mime-сниффинг, что может служить источником XSS нападения или раскрытия информации.";s:14:"recommendation";s:1752:"Скорее всего, вам не нужна эта функция, поэтому её можно безболезненно отключить, добавив заголовок ответа "X-Content-Type-Options: nosniff" в конфигурации вашего веб-сервера.
</p><p>В случае использования nginx:<br>
1. Найти секцию server, отвечающую за обработку запросов нужного сайта. Зачастую это файлы в /etc/nginx/site-enabled/*.conf<br>
2. Добавить строку:
<pre>
add_header X-Content-Type-Options nosniff;
</pre>
3. Перезапустить nginx<br>
Подробнее об этой директиве можно прочесть в документации к nginx: <a href="http://nginx.org/ru/docs/http/ngx_http_headers_module.html" target="_blank">Модуль ngx_http_headers_module</a>
</p><p>В случае использования Apache:<br>
1. Найти конфигурационный файл для вашего сайта, зачастую это файлы /etc/apache2/httpd.conf, /etc/apache2/vhost.d/*.conf<br>
2. Добавить строки:
<pre>
&lt;IfModule headers_module&gt;
	Header set X-Content-Type-Options nosniff
&lt;/IfModule&gt;
</pre>
3. Перезапустить Apache<br>
4. Убедиться, что он корректно обрабатывается Apache и этот заголовок никто не переопределяет<br>
Подробнее об этой директиве можно прочесть в документации к Apache: <a href="http://httpd.apache.org/docs/2.2/mod/mod_headers.html" target="_blank">Apache Module mod_headers</a>
</p>";s:15:"additional_info";s:1824:"Адрес: <a href="http://vs82.ru/bitrix/js/main/core/core.js?rnd=0.423137796715" target="_blank">http://vs82.ru/bitrix/js/main/core/core.js?rnd=0.423137796715</a><br>Запрос/Ответ: <pre>GET /bitrix/js/main/core/core.js?rnd=0.423137796715 HTTP/1.1
host: vs82.ru
accept: */*
user-agent: BitrixCloud BitrixSecurityScanner/Robin-Scooter

HTTP/1.1 200 OK
Server: nginx
Date: Tue, 25 Jun 2019 08:32:28 GMT
Content-Type: application/javascript
Content-Length: 123541
Last-Modified: Mon, 10 Jun 2019 06:04:19 GMT
Connection: keep-alive
Vary: Accept-Encoding
ETag: &quot;5cfdf2e3-1e295&quot;
Expires: Tue, 02 Jul 2019 08:32:28 GMT
Cache-Control: max-age=604800
Accept-Ranges: bytes

if (typeof WeakMap === &quot;undefined&quot;)
{
	(function() {

		var counter = Date.now() % 1e9;

		var WeakMap = function(iterable)
		{
			this.name = &quot;__bx&quot; + (Math.random() * 1e9 &gt;&gt;&gt; 0) + counter++;
		};

		WeakMap.prototype =
		{
			set: function(key, value)
			{
				if (!this.isValid(key))
				{
					throw new TypeError(&quot;Invalid value used as weak map key&quot;);
				}

				var entry = key[this.name];
				if (entry &amp;&amp; entry[0] === key)
				{
					entry[1] = value;
				}
				else
				{
					Object.defineProperty(key, this.name, { value: [key, value], writable: true });
				}

				return this;
			},

			get: function(key)
			{
				if (!this.isValid(key))
				{
					return undefined;
				}

				var entry = key[this.name];

				return entry &amp;&amp; entry[0] === key ? entry[1] : undefined;
			},

			&quot;delete&quot;: function(key)
			{
				if (!this.isValid(key))
				{
					return false;
				}

				var entry = key[this.name];
				if (!entry)
				{
					return false;
				}
				var hasValue = entry[0] === key;
				entry[0] = entry[1] = u
----------Only 1Kb of body shown----------<pre>";}i:6;a:5:{s:5:"title";s:77:"Почтовые сообщения содержат UID PHP процесса";s:8:"critical";s:3:"LOW";s:6:"detail";s:356:"В каждом отправляемом письме добавляется заголовок X-PHP-Originating-Script, который содержит UID и имя скрипта отправляющего письмо. Это позволяет злоумышленнику узнать от какого пользователя работает PHP.";s:14:"recommendation";s:91:"Необходимо в настройках php указать:<br>mail.add_x_header = Off";s:15:"additional_info";s:0:"";}}s:9:"test_date";s:10:"25.06.2019";}}';
return true;
?>