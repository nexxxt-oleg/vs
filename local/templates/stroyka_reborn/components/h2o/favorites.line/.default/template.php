<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->createFrame()->begin("");
?>

<? if($arParams['URL_LIST'] != ""): ?>
<?
    $isAuthoredUser = isset($USER) && $USER->IsAuthorized();
    $favoritesListUrl = '';
    if($isAuthoredUser)
        $favoritesListUrl = $arParams['URL_LIST'];
    else{
         $currentUrl = urlencode($APPLICATION->GetCurPageParam("", [
            "login",
            "login_form",
            "logout",
            "register",
            "forgot_password",
            "change_password",
            "confirm_registration",
            "confirm_code",
            "confirm_user_id",
            "logout_butt",
            "auth_service_id"
        ]));
        $favoritesListUrl = "/login?login=yes&backurl=". $currentUrl;
    }
    ?>
    <div class="header-btns__wrap favor-list-wrap">
		<? if($arResult['COUNT'] > 0): ?>
            <a href="<?=$favoritesListUrl?>" class="header-btns__link" data-count="<?= $arResult['COUNT'] ?>">
                <img src="<?=$APPLICATION->GetTemplatePath('img/ui-icon/favorite.svg')?>" alt="" class="header-btns__icon">
                <img src="<?=$APPLICATION->GetTemplatePath('img/ui-icon/favorite-fill.svg')?>" alt="" class="header-btns__icon">
            </a>
		<? else: ?>
            <a href="<?=$favoritesListUrl?>" class="header-btns__link">
                <img src="<?=$APPLICATION->GetTemplatePath('img/ui-icon/favorite.svg')?>" alt="" class="header-btns__icon">
                <img src="<?=$APPLICATION->GetTemplatePath('img/ui-icon/favorite-fill.svg')?>" alt="" class="header-btns__icon">
            </a>
		<? endif; ?>
		<a href="<?=$favoritesListUrl?>" class="header-btns__link">Избранное</a>
    </div>
<? else: ?>
	<div class="count-favor-item"><?=$arResult['COUNT']?></div>
<? endif; ?>