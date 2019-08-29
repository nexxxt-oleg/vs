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
$this->setFrameMode(true);

$items = CIBlockElement::GetList(
    [
        "created" => "DESC"
    ],
    [
//        "IBLOCK_TYPE" => "simple",
        "IBLOCK_ID" => $arResult['IBLOCK_ID']
    ],
    false,
    [
        "nPageSize" => 4
    ]
   /* [
        "DATE_CREATE",
        "DETAIL_PAGE_URL",
        "NAME",
        "PREVIEW_TEXT",
        "TAGS",
        "PREVIEW_PICTURE"
    ]*/
);
$articles = [];
while ($top_new = $items->GetNextElement()) {
    $articles[$top_new->fields['CODE']] = $top_new;
    $articles[$top_new->fields['CODE']]->fields['PREVIEW_PICTURE_URL'] = CFile::GetPath($top_new->fields['PREVIEW_PICTURE']);
}
echo "1";
?>
