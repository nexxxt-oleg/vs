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
    <div class="new-container">
        <div class="new-row">
            <div class="new-col-12">
                <div class="page-home__block-title">
                    <span class="page-home__slider-title h2-new"><?= $arResult['NAME'] ?></span>
                    <a href="/news/" class="page-home__slider-link">
                        <span>в раздел</span>
                        <span></span>
                    </a>
                </div>
                <div class="all-news-sliders__dots sliders-dots">
                    <? foreach ($arResult['ITEMS'] as $key => $arItem): ?>
                        <? if ($key == 0): ?>
                            <button data-id="0" class="active"></button>
                        <? else: ?>
                            <button data-id="<?= $key ?>"></button>
                        <? endif; ?>
                    <? endforeach; ?>
                </div>
                <div class="all-news-sliders__slick">
                    <? foreach ($arResult['ITEMS'] as $arItem): ?>
                        <?
//                $this->AddEditAction($uniqueId, $arItem['EDIT_LINK'], $elementEdit);
//                $this->AddDeleteAction($uniqueId, $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
                        ?>
                        <div class="all-news-sliders__item" id="<?= $this->GetEditAreaID($arItem['ID']) ?>">
                            <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="news-card">
                                <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                     alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>" class="news-card__img">
                                <span class="news-card__title h4-new"><?= $arItem['NAME'] ?></span>
                                <p class="news-card__desc"> <?= $arItem['PREVIEW_TEXT'] ?> </p>
                                <span class="news-card__date">
                            <? $arParams["DATE_CREATE"] = "j F Y"; ?>
                            <?= CIBlockFormatProperties::DateFormat($arParams["DATE_CREATE"], MakeTimeStamp($arItem["DATE_CREATE"], CSite::GetDateFormat())); ?>
                        </span>
                            </a>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<? endif; ?>