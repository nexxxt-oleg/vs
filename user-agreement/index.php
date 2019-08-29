<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пользовательское соглашение");
?>
<section class="page-all-sect page-actions">
	<div class="container">
		<div class="row">
			<div class="col-8">
				<div class="page-all-sect__top-title">
					<h1>Пользовательское соглашение</h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="b-content">
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "page",
							"AREA_FILE_SUFFIX" => "inc",
							"COMPOSITE_FRAME_MODE" => "A",
							"COMPOSITE_FRAME_TYPE" => "STATIC",
							"EDIT_TEMPLATE" => "include_area.php"
						)
					);?>
				</div>
			</div>
		</div>
	</div>
</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>