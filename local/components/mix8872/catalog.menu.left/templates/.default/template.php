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
?>
<ul>
    <? foreach ($arResult as $menuItem): ?>
        <? $isParent = !empty($menuItem['ITEMS']); ?>

        <? if ($isParent): ?>
            <li class="is-parent">
                <a href="<?= $menuItem['SECTION_PAGE_URL'] ?>">
                    <span><?= $menuItem['NAME'] ?></span>
                    <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-right.svg") ?>" class="img-svg">
                </a>
                <div>
                        <div class="row">
                            <div class="col-8">
                                <div class="page-all-sect__top-title">
                                    <h2><?= $menuItem['NAME'] ?></h2>
                                </div>
                            </div>
                            <div class="col-4">
                                <? if (isset($menuItem['OVERFLOW']) && $menuItem['OVERFLOW']): ?>
                                <div class="page-all-sect__top-link">
                                    <a href="<?= $menuItem['SECTION_PAGE_URL'] ?>" class="arrow-link arrow-link_sm arrow-link_right">
                                        <span>Все товары</span>
                                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-right.svg") ?>" class="img-svg">
                                    </a>
                                </div>
                                <? endif; ?>
                            </div>
                        </div>
                    <div class="row">
                        <? foreach ($menuItem['ITEMS'] as $menuItemLevel2): ?>
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="hb-menu-lg__submenu section-menu-lg">
                                    <a href="<?= $menuItemLevel2['SECTION_PAGE_URL'] ?>"
                                       class="section-menu-lg__title h3"><?= $menuItemLevel2['NAME'] ?></a>
                                    <? if (!empty($menuItemLevel2['ITEMS'])): ?>
                                        <ul class="section-menu-lg__links">
                                            <? foreach ($menuItemLevel2['ITEMS'] as $menuItemLevel3): ?>
                                                <li>
                                                    <a href="<?= $menuItemLevel3['SECTION_PAGE_URL'] ?>"><?= $menuItemLevel3['NAME'] ?></a>
                                                </li>
                                            <? endforeach; ?>
                                        </ul>
                                        <? if (isset($menuItemLevel2['OVERFLOW']) && $menuItemLevel2['OVERFLOW']): ?>
                                            <a href="<?= $menuItemLevel2['SECTION_PAGE_URL'] ?>"
                                               class="section-menu-lg__more arrow-link arrow-link_sm arrow-link_right">
                                                <span>В раздел</span>
                                                <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-right.svg") ?>" class="img-svg">
                                            </a>
                                        <? endif; ?>
                                    <? endif; ?>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </li>
        <? else: ?>
            <li>
                <a href="<?= $menuItem['SECTION_PAGE_URL'] ?>">
                    <span><?= $menuItem['NAME'] ?></span>
                </a>
            </li>
        <? endif; ?>
    <? endforeach; ?>
</ul>