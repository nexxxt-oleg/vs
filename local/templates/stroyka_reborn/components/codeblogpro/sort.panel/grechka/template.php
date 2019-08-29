<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

if (!empty($arResult['SORT']['PROPERTIES'])) { ?>
    <div class="catalog-sort catalog-sort_right top-navs__sort top-navs__sort_no-mt-mb-24">
    <span class="catalog-sort__title"><?= Loc::getMessage('CODEBLOGPRO_SORT_PANEL_COMPONENT_TEMPALTE_SORT_BY_VALUE') ?>
        :</span>
        <div class="catalog-sort__select form-wraper formselect-radio">
            <? $arLinkItems = '';
            $activeItem = '';
            $valSort = '';
            foreach ($arResult['SORT']['PROPERTIES'] as $key => $property) {
                if ($property['CODE'] == 'catalog_PRICE_5') {
                    $property['NAME'] = 'По цене';
                } else {
                    $property['NAME'] = preg_replace('/\s/u', '&nbsp', $property['NAME']);
                }
                if ($property['ACTIVE']) {
                    $acriveItem = $property['NAME'];
                    $sort = $property['ORDER'] === 'asc' || $GLOBALS['ORDER'] === 'asc' ? ' formselect-radio__item_with-arrow_up' : '';
                    $valSort = $property['ORDER'] === 'asc' || $GLOBALS['ORDER'] === 'asc' ? 'formselect-radio__value_with-arrow formselect-radio__value_with-arrow_up' : 'formselect-radio__value_with-arrow';
                    $arLinkItems .= '<a href="' . $property['URL'] . '" class="formselect-radio__item formselect-radio__item_with-arrow' . $sort . ' active">' . $property['NAME'] . '</a>';
                } else {
                    $arLinkItems .= '<a href="' . $property['URL'] . '" class="formselect-radio__item formselect-radio__item_with-arrow">' . $property['NAME'] . '</a>';
                }
            }
            ?>
            <div class="form-wraper__box formselect-radio__value <?= $valSort ?> form-box" title="<?= $acriveItem ?>">
                <span><?= $acriveItem ?></span>
            </div>
            <button type="button" class="form-wraper__button formselect-radio__arrow">
                <img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/dropdown.svg') ?>" alt="" class="img-svg">
            </button>
            <div class="formselect-radio__list">
                <?= $arLinkItems ?>
            </div>
        </div>
    </div>
<? } ?>