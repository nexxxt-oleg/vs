<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)) { ?>
    <ul class="header-sub-menu-category">
        <?
        $previousLevel = 0;
        foreach ($arResult as $arItem) {
            if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) {
                str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
            }
            if ($arItem["IS_PARENT"]) { ?>
                <li>
                    <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                    <ul class="header-sub-menu-current-category<?= $arItem["DEPTH_LEVEL"] > 1 ? '-ul' : '' ?>">
              <?
            } else { ?>
                <li>
                    <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                </li>
            <? } ?>

        <? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

        <? } ?>

        <? if ($previousLevel > 1) {//close last item tags?>
            <?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
        <? } ?>

    </ul>
<? } ?>