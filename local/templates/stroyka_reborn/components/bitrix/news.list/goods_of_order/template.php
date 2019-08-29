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
            <div class="new-col-12 col-no-padding">
                <div class="categories-sliders__dots sliders-dots">
                    <? foreach ($arResult['ITEMS'] as $key => $arItem): ?>
                        <? if ($key == 0): ?>
                            <button data-id="0" class="active"></button>
                        <? else: ?>
                            <button data-id="<?= $key ?>"></button>
                        <? endif; ?>
                    <? endforeach; ?>
                </div>
                <button class="categories-sliders__prev slider-arrow-prev">
                    <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/arrow-left.svg') ?>" class="img-svg">
                </button>
                <button class="categories-sliders__next slider-arrow-next">
                    <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/arrow-right.svg') ?>" class="img-svg">
                </button>
                <div class="categories-sliders__slider">

                    <? foreach ($arResult['ITEMS'] as $arItem): ?>

                        <?php
                        $url = isset($arItem['DISPLAY_PROPERTIES']['PAGE_URL']['VALUE']) &&
                        !empty($arItem['DISPLAY_PROPERTIES']['PAGE_URL']['VALUE']) ? $arItem['DISPLAY_PROPERTIES']['PAGE_URL']['VALUE'] : "/";

                        $fileUrl = isset($arItem['PROPERTIES']['BACKGROUND_IMG']['VALUE']) &&
                        !empty($arItem['PROPERTIES']['BACKGROUND_IMG']['VALUE']) ? CFile::GetPath($arItem['PROPERTIES']['BACKGROUND_IMG']['VALUE']) : '';
                        ?>

                        <div class="categories-sliders__item" id="<?= $this->GetEditAreaID($arItem['ID']) ?>">
                            <a href="<?= $url ?>" class="categories-card" style="background-image: url('<?= $fileUrl ?>')">
                                <div class="categories-card__content">
                                    <span class="categories-card__title h2-new"><?= $arItem['NAME'] ?></span>
                                    <p class="categories-card__desc"><?= $arItem['PREVIEW_TEXT'] ?></p>
                                </div>
                                <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                     alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>" class="categories-card__img">
                            </a>
                        </div>

                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<? endif; ?>