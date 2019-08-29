<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;


if (strlen($arParams["MAIN_CHAIN_NAME"]) > 0)
{
	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}

$theme = Bitrix\Main\Config\Option::get("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);

$availablePages = array();

if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'],
		"name" => Loc::getMessage("SPS_ORDER_PAGE_NAME"),
		"icon" => '<img src="'.$APPLICATION->GetTemplatePath("img/profile-icon/order-current.svg").'" class="img-svg">'
	);
}

if ($arParams['SHOW_ACCOUNT_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ACCOUNT'],
		"name" => Loc::getMessage("SPS_ACCOUNT_PAGE_NAME"),
		"icon" => '<i class="fa fa-credit-card"></i>'
	);
}

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PRIVATE'],
		"name" => Loc::getMessage("SPS_PERSONAL_PAGE_NAME"),
		"icon" => '<img src="'.$APPLICATION->GetTemplatePath("img/profile-icon/profile.svg").'" class="img-svg">'
	);
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{

	$delimeter = ($arParams['SEF_MODE'] === 'Y') ? "?" : "&";
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'].$delimeter."filter_history=Y",
		"name" => Loc::getMessage("SPS_ORDER_PAGE_HISTORY"),
		"icon" => '<img src="'.$APPLICATION->GetTemplatePath("img/profile-icon/order-history.svg").'" class="img-svg">'
	);
}

if ($arParams['SHOW_PROFILE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PROFILE'],
		"name" => Loc::getMessage("SPS_PROFILE_PAGE_NAME"),
		"icon" => '<i class="fa fa-list-ol"></i>'
	);
}

if ($arParams['SHOW_BASKET_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arParams['PATH_TO_BASKET'],
		"name" => Loc::getMessage("SPS_BASKET_PAGE_NAME"),
		"icon" => '<img src="'.$APPLICATION->GetTemplatePath("img/profile-icon/basket.svg").'" class="img-svg">'
	);
}

if ($arParams['SHOW_SUBSCRIBE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_SUBSCRIBE'],
		"name" => Loc::getMessage("SPS_SUBSCRIBE_PAGE_NAME"),
		"icon" => '<i class="fa fa-envelope"></i>'
	);
}

if ($arParams['SHOW_CONTACT_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arParams['PATH_TO_CONTACT'],
		"name" => Loc::getMessage("SPS_CONTACT_PAGE_NAME"),
		"icon" => '<i class="fa fa-info-circle"></i>'
	);
}

$customPagesList = CUtil::JsObjectToPhp($arParams['~CUSTOM_PAGES']);
if ($customPagesList)
{
	foreach ($customPagesList as $page)
	{
		$availablePages[] = array(
			"path" => $page[0],
			"name" => $page[1],
			"icon" => (strlen($page[2])) ? '<i class="fa '.htmlspecialcharsbx($page[2]).'"></i>' : ""
		);
	}
}

if (empty($availablePages))
{
	ShowError(Loc::getMessage("SPS_ERROR_NOT_CHOSEN_ELEMENT"));
}
else
{
	?>
	<section class="page-all-sect page-profile__order-current">
		<div class="container">
			<div class="row">
				<div class="col-8">
					<div class="page-all-sect__top-title">
						<h2>Личный кабинет</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3 col-lg-3">
					<div class="page-profile__left-menu categories-left-menu">
						<ul>
							<? foreach ($availablePages as $blockElement) { ?>
								<li>
									<a href="<?=htmlspecialcharsbx($blockElement['path'])?>" class="h3"><?=htmlspecialcharsbx($blockElement['name'])?></a>
								</li>
							<? } ?>
						</ul>
					</div>
				</div>
				<div class="col-sm-9 col-lg-9">
					<div class="row">
						<? foreach ($availablePages as $blockElement) { ?>
							<div class="col-lg-3 col-md-6 col-sm-12 col-12">
									<a class="pp-menu-block" href="<?=htmlspecialcharsbx($blockElement['path'])?>">
										<div class="pp-menu-block__content">
											<span class="pp-menu-block__icon">
												<?=$blockElement['icon']?>
											</span>
											<span class="pp-menu-block__title">
												<?=htmlspecialcharsbx($blockElement['name'])?>
											</span>
										</div>
									</a>
							</div>
						<? } ?>
					</div>
				</div>
			</div>
		</section>
	<?
}
?>
