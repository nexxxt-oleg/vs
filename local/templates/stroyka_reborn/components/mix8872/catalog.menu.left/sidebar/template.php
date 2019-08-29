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
$t="";

if (!function_exists('headerContentBlock')) {
    function headerContentBlock( )
    {

    }
}

?>

<? if (!empty($arResult['SECTIONS'])) : ?>
    <div class="left-menu-accordion">
        <ul class="left-menu-accordion__first">
        <? $previousLevel = 0;
        $k = 0;
        $more = false;
        $topDepth = 0;
        $countParent = 0;
        foreach ($arResult['SECTIONS'] as $key => $arSection) :

            if(($arSection["DEPTH_LEVEL"] == 1) || ($arSection["DEPTH_LEVEL"] == 2)) { $countParent++;}
            if ($key == 0) {
                $topDepth = $arSection['DEPTH_LEVEL'];
            }
            $arSection["DEPTH_LEVEL"] == $topDepth && $k++;
            if ($key > 0 && $previousLevel && $arSection["DEPTH_LEVEL"] < $previousLevel) {
                echo str_repeat("</ul></li>", ($previousLevel - $arSection["DEPTH_LEVEL"]));
            }
            if ($k == 6) {
                if($countParent == 6){
                    echo '</ul><ul class="left-menu-accordion__last" style="display: block">';
                    $countParent++;
                }
                $more = true;
            }
            if ($arSection['IS_PARENT']) : ?>
                <li class="is-parent<?= $arSection['IS_CURRENT'] ? ' open current' : '' ?>">
                    <a href="<?= $arSection['SECTION_PAGE_URL'] ?>"><?= $arSection['NAME'] ?></a>
                    <button>
                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-bottom.svg") ?>" class="img-svg">
                    </button>
                    <ul style="display: <?= $arSection['IS_CURRENT'] ? '' : 'none' ?>">
            <? else : ?>
                <li style="<?= $arSection['IS_CURRENT'] ? 'current' : '' ?>">
                    <a href="<?= $arSection['SECTION_PAGE_URL'] ?>"><?= $arSection['NAME'] ?></a>
                </li>
            <? endif; ?>

            <? $previousLevel = $arSection["DEPTH_LEVEL"]; ?>

        <? endforeach; ?>

        <? if ($previousLevel > 1) { //close last item tags
            echo str_repeat("</ul></li>", ($previousLevel - 1));
        } ?>
        </ul>
        <? if ($more): ?>
            <button class="left-menu-accordion__more-btn open">
                <span>Ещё</span>
                <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-bottom.svg") ?>" class="img-svg">
            </button>
        <? endif; ?>
    </div>
<? endif; ?>