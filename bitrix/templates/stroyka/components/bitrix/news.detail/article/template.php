<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$this->setFrameMode(true);
//$arReturnUrl = array(
//	"add_element" => CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "DETAIL_PAGE_URL"),
//	"delete_element" => (
//		empty($arResult["SECTION_URL"])?
//		$arResult["LIST_PAGE_URL"]:
//		$arResult["SECTION_URL"]
//	),
//);
//$arButtons = CIBlock::GetPanelButtons(
//	$arResult["IBLOCK_ID"],
//	$arResult["ID"],
//	$arResult["IBLOCK_SECTION_ID"],
//	Array(
//		"RETURN_URL" => $arReturnUrl,
//		"SECTION_BUTTONS" => false,
//	)
//);
//$arTitleOptions = array(
//	'ADMIN_EDIT_LINK' => $arButtons["submenu"]["edit_element"]["ACTION"],
//	'PUBLIC_EDIT_LINK' => $arButtons["edit"]["edit_element"]["ACTION"],
//	'COMPONENT_NAME' => $this->getName(),
//);
//$APPLICATION->SetTitle($arResult["NAME"], $arTitleOptions);
$APPLICATION->AddChainItem($arResult["NAME"]);

$tags = explode(",", str_replace(" ", "", $arResult['TAGS']));
$items = CIBlockElement::GetList(Array("DATE_CREATE" => "DESC"), ["!ID" => $arResult["ID"], "IBLOCK_ID" => $arResult['IBLOCK_ID'], "?TAGS" => $tags], false, Array("nPageSize" => 4), Array("DATE_CREATE", "DETAIL_PAGE_URL", "NAME", "PREVIEW_TEXT", "TAGS", "PREVIEW_PICTURE"));
$articles = [];
while ($top_new = $items->GetNextElement()) {
    $articles[$top_new->fields['CODE']] = $top_new;
    $articles[$top_new->fields['CODE']]->fields['PREVIEW_PICTURE_URL'] = CFile::GetPath($top_new->fields['PREVIEW_PICTURE']);
}
?>
<section class="statya">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title"><?= $arResult["NAME"] ?>
                    <? if (array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y"): ?>
                        <div class="share-block">Поделиться
                            <img class="img-share" src="<?= SITE_TEMPLATE_PATH ?>/img/ic-share.png" alt="">
                            <noindex>
                                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                                <script src="//yastatic.net/share2/share.js"></script>
                                <div class="ya-share2"
                                     data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,lj"
                                     data-image="<?= $_SERVER['HTTP_HOST'].$arResult["DETAIL_PICTURE"]["SRC"] ?>"
                                     data-title="<?= $arResult["NAME"] ?>"
                                ></div>
                            </noindex>
                        </div>
                    <? endif; ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row statya-block-1">
            <div class="col-md-12">
                <div class="statya-block-1-left">
                    <? if (!empty($arResult["DETAIL_PICTURE"])): ?>
                        <img class="statya-img" src="<?= $arResult["DETAIL_PICTURE"]["SRC"]; ?>">
                    <? endif; ?>
                    <? if (strlen($arResult["DETAIL_TEXT"]) > 0): ?>
                        <?= $arResult["DETAIL_TEXT"]; ?>
                    <? else: ?>
                        <?= $arResult["PREVIEW_TEXT"]; ?>
                    <? endif ?>
                </div>
            </div>
        </div>
        <? if (!empty($articles)): ?>
            <div class="row can-be-interest">
                <div class="col-md-12">
                    <h2 class="can-be-interest-title">Вам может быть интересно:</h2>
                </div>
                <? foreach ($articles as $article): ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="can-be-interest-el">
                            <div class="can-be-interest-el-img">
                                <img src="<?= $article->fields["PREVIEW_PICTURE_URL"] ?>" alt="">
                            </div>
                            <h2 class="can-be-interest-el-title"><?= $article->fields["NAME"] ?></h2>
                            <div class="can-be-interest-el-bottom">
                                <div class="can-be-interest-date"><?= date("d.m.Y", strtotime($article->fields["DATE_CREATE"])) ?></div>
                                <a href="<?= $article->fields["DETAIL_PAGE_URL"] ?>" class="podrobno">Подробно <i
                                            class="fa fa-angle-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        <? endif; ?>
    </div>
</section>
