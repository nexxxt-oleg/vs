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

<div class="new-menu js-menu display">
    <div class="new-container">
        <div class="new-row">
            <div class="new-col-12 new-offset-sm-2 new-col-sm-4 new-offset-lg-1 new-col-lg-3">
                <ul class="new-menu__left left-menu">
                    <? $i = 0; ?>
                    <? foreach ($arResult as $key => $menuItem): ?>
                        <? $isParent = !empty($menuItem['ITEMS']); ?>
                        <? if ($isParent): ?>
                            <li class="left-menu__item <?= $i == 0 ? 'active' : '' ?>">
                                <button class="left-menu__link <?= $i == 0 ? 'active' : '' ?>"><?= mb_ucfirst(strtolower($menuItem['NAME'])) ?></button>
                                <div class="new-menu__middle js-new-menu-middle display ">
                                    <a href="<?= $menuItem['SECTION_PAGE_URL'] ?>"
                                       class="new-menu__middle-title h3-new">
                                        <?= mb_ucfirst(strtolower($menuItem['NAME'])) ?>
                                        <span><img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/arrow-right.svg') ?>" alt="" class="img-svg"></span>
                                    </a>
                                    <div class="new-menu__blocks">
                                        <? foreach ($menuItem['ITEMS'] as $menuItemLevel2): ?>
                                            <div class="new-menu__block">
                                                <div>
                                                    <a href="<?= $menuItemLevel2['SECTION_PAGE_URL'] ?>"
                                                       class="new-menu__subtitle h5-new"><?= $menuItemLevel2['NAME'] ?></a>
                                                    <? if (!empty($menuItemLevel2['ITEMS'])): ?>
                                                        <ul class="middle-menu">
                                                            <? foreach ($menuItemLevel2['ITEMS'] as $menuItemLevel3): ?>
                                                                <li class="middle-menu__item">
                                                                    <a href="<?= $menuItemLevel3['SECTION_PAGE_URL'] ?>"><?= $menuItemLevel3['NAME'] ?></a>
                                                                </li>
                                                                <? if (isset($menuItemLevel2['OVERFLOW']) && $menuItemLevel2['OVERFLOW']): ?>
                                                                    <li class="middle-menu__item">
                                                                        <a href="<?= $menuItemLevel2['SECTION_PAGE_URL'] ?>">В
                                                                            раздел</a>
                                                                    </li>
                                                                <? endif; ?>
                                                            <? endforeach; ?>
                                                        </ul>
                                                    <? endif; ?>
                                                </div>
                                            </div>
                                        <? endforeach; ?>
                                    </div>
                                </div>
                            </li>
                        <? else: ?>
                            <li class="left-menu__item">
                                <button class="left-menu__link active"><?= $menuItem['NAME'] ?></button>
                                <div class="new-menu__middle js-new-menu-middle display">
                                    <a href="<?= $menuItem['SECTION_PAGE_URL'] ?>"
                                       class="new-menu__middle-title h3-new">
                                        <?= $menuItem['NAME'] ?>
                                        <span><img src="<?= $APPLICATION->GetTemplatePath('img/ui-icon/arrow-right.svg') ?>" alt="" class="img-svg"></span>
                                    </a>
                                </div>
                            </li>
                        <? endif; ?>
                    <? $i++; ?>
                    <? endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>