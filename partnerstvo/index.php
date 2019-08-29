<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("IS_CONTENT", "Y");
$APPLICATION->SetPageProperty("title", "Партнерство");
$APPLICATION->SetTitle("Партнерство");
?><div class="row">
	<div class="col-md-2">
 <a href="#opt" class="h3">Оптовикам</a><br>
 <a href="#post" class="h3">Поставщикам</a><br>
 <br>
	</div>
	<div class="col-md-10">
		<h3 id="opt">Оптовикам</h3>
		<p>
			<img src="/images/Оптовикам.jpg" alt="Оптовикам"><br>
		</p>
		<p>
			 На протяжении уже 15 лет компания “Вечная стройка” является надежным партнером в комплексном снабжении строительных объектов. Среди наших клиентов как представители крупного и среднего бизнеса, так и частные лица.
		</p>
		<p>
 <span style="font-size: 1rem;">Приглашаем Вас пополнить ряды наших удовлетворенных клиентов! Менеджеры нашего отдела продаж с удовольствием ответят на все интересующие Вас вопросы:</span>
		</p>
		<p>
			 тел.: +7 (978) 00-70-111
		</p>
		<p>
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+7 (978) 00-70-222
		</p>
		<p>
			 Email: <a href="mailto:prodazhi@vs82.ru">prodazhi@vs82.ru</a>
		</p>
 <section class="page-company__principles our-principles">
		<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"principles",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array("",""),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "26",
		"IBLOCK_TYPE" => "simple",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MAIN_URL" => "/news",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "5",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Покупайте правильно",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array("","IMAGE2",""),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	)
);?> </section>
		<p>
			 &nbsp;
		</p>
		<hr>
		<p>
			 &nbsp;
		</p>
		<h3 id="post">Поставщикам</h3>
		<p>
 <img src="/images/Поставщикам.jpg" alt="Поставщикам">
		</p>
		<p>
			 Основной принцип работы нашей компании- это удовлетворение потребностей клиентов в качественных товарах для строительства и ремонта. Поэтому мы заинтересованы в развитии долгосрочных, взаимовыгодных партнерских отношений с поставщиками и производителями. Особое внимание мы уделяем локальным поставщикам и прямым производителям и стремимся обеспечить максимальное расширение такого сотрудничества.
		</p>
		<p>
			 Ждем Ваши вопросы и предложения о сотрудничестве!
		</p>
		<p>
			 &nbsp;
		</p>
		<p>
 <em>Отдел закупок:</em>
		</p>
		<p>
			 тел.: +7 (978) 815-55-44
		</p>
		<p>
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+7 (978) 815-55-45
		</p>
		<p>
			 Email: <a href="mailto:zakupki@vs82.ru">zakupki@vs82.ru</a>
		</p>
		<p>
			 &nbsp;
		</p>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>