<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>
<? if (!empty($arResult['ITEMS'])):
//    $elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
//    $elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
//    $elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM'));
    ?>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="page-all-sect__top-title">
                    <h2><?= $arResult['NAME'] ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "EDIT_TEMPLATE" => "",
                    "PATH" => "text_inc.php"
                )
            );?>
        </div>
        <div class="row">
            <? foreach ($arResult['ITEMS'] as $arItem): ?>
                <div class="col-12">
                    <div class="page-announc__card card-announc">
                        <span class="card-announc__tag"><?= strtolower($arItem['DISPLAY_PROPERTIES']['TYPE']['VALUE']) ?></span>
                        <h3 class="card-announc__title"><?= $arItem['NAME'] ?></h3>
                        <h3 class="card-announc__author"><?= $arItem['DISPLAY_PROPERTIES']['AUTHOR']['VALUE'] ?></h3>
                        <div class="card-announc__desc b-content">
                            <?= $arItem['DETAIL_TEXT'] ?>
                        </div>
                        <div class="card-announc__bottom">
                            <? if ($arParams["DISPLAY_DATE"] != "N" && $arItem["DATE_CREATE"]): ?>
                                <div class="card-announc__date">
                                    <? $arParams["DATE_CREATE"] = "j F Y"; ?>
                                    <span class="b-date"><?= CIBlockFormatProperties::DateFormat($arParams["DATE_CREATE"], MakeTimeStamp($arItem["DATE_CREATE"], CSite::GetDateFormat())); ?></span>
                                </div>
                            <? endif; ?>
                            <div class="card-announc__contacts">
                                <span>телефон: <a href="tel:<?= preg_replace('/[^\d+]/', '', $arItem['DISPLAY_PROPERTIES']['TEL']['VALUE']) ?>"><?= $arItem['DISPLAY_PROPERTIES']['TEL']['VALUE'] ?></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
        <? if (strlen($arResult["NAV_STRING"]) > 0):?><?= $arResult["NAV_STRING"] ?><? endif ?>
    </div>
<? endif; ?>

