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
$prevDepth = 1;
?>

<?php
$res = $arResult;
$t = "";

if (!function_exists('headerContentBlock')) {
    function headerContentBlock()
    {

    }
}

?>

<? if (!empty($arResult['SECTIONS'])) : ?>

    <div class="new-col-12 filter__lists js-filter-categories-hidden">
    <?
    $previousLevel = 0;
    $k = 0;
    $more = false;
    $childDepth = $topDepth = 0;
    $childCount = 0;
    $countParent = 0;
    $parentOpen = false;
    $arResMenu = [];
    $arParent = [];
    $overflowSectionList = false;

    foreach ($arResult['SECTIONS'] as $key => $arSection) {
        if ($key == 0) {
            $topDepth = $arSection['DEPTH_LEVEL'];
        }

        if ($arSection["DEPTH_LEVEL"] == $topDepth) { ?>

            <?
            if ($arSection['IS_PARENT']): ?>
                <?
                $childCount = 0;
                ?>

                <? if ($previousLevel > $arSection["DEPTH_LEVEL"] && $parentOpen): ?>
                    </ul>
                    <?
                    if ($overflowSectionList): ?>
                        <button type="button" class="left-menu-accordion__more-btn">Показать все</button>
                    <?endif; ?>
                    </div>
                    </div>
                <?endif; ?>

                <div class="new-col-12 filter__item filter__item_small filter__item_xs filter-box bx-filter-parameters-box bx-active">
                <div class="left-menu-accordion">
                <a href="<?= $arSection['SECTION_PAGE_URL'] ?>"
                   class="left-menu-accordion__title h5-new"><?= $arSection['NAME'] ?></a>
                <ul class="left-menu-accordion__first">
                <? $parentOpen = true; ?>
            <? else: ?>
                <? if ($previousLevel > $arSection["DEPTH_LEVEL"] && $parentOpen): ?>
                    </ul>
                    <?
                    if ($overflowSectionList): ?>
                        <button type="button" class="left-menu-accordion__more-btn">Показать все</button>
                    <?endif; ?>
                    </div>
                    </div>
                <?endif; ?>
                <? $parentOpen = false;
                $childCount = 0;
                ?>
                <div class="new-col-12 filter__item filter__item_small filter__item_xs filter-box bx-filter-parameters-box bx-active">
                    <div class="left-menu-accordion">
                        <a href="<?= $arSection['SECTION_PAGE_URL'] ?>"
                           class="left-menu-accordion__title h5-new"><?= $arSection['NAME'] ?></a>
                    </div>
                </div>
            <?endif; ?>

            <?
            $overflowSectionList = false;
            $previousLevel = $arSection["DEPTH_LEVEL"];
        } elseif ($arSection["DEPTH_LEVEL"] == $topDepth + 1) {
            ?>
            <? if ($childCount < 5): ?>
                <li>
                    <a href="<?= $arSection['SECTION_PAGE_URL'] ?>"><?= $arSection['NAME'] ?></a>
                </li>
            <? elseif ($childCount == 5): ?>
                <? $overflowSectionList = true; ?>
                </ul>
                <ul class="left-menu-accordion__last">
                <li>
                    <a href="<?= $arSection['SECTION_PAGE_URL'] ?>"><?= $arSection['NAME'] ?></a>
                </li>
            <? else: ?>
                <li>
                    <a href="<?= $arSection['SECTION_PAGE_URL'] ?>"><?= $arSection['NAME'] ?></a>
                </li>
            <?endif; ?>
            <?
            $childCount++;
            $previousLevel = $arSection["DEPTH_LEVEL"];//
        } elseif ($arSection["DEPTH_LEVEL"] !== $topDepth + 1) {
            continue;
        }

    } // endforeach
    ?>
    <? if ($parentOpen): ?>
        </ul>
        <? if ($overflowSectionList): ?>
            <button type="button" class="left-menu-accordion__more-btn">Показать все</button>
        <? endif; ?>
        </div>
        </div>
    <? endif; ?>
    </div>


<? endif; ?>