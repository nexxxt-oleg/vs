<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)) { ?>
    <ul class="all-products-menu">
        <?
        $previousLevel = 1;
        foreach ($arResult as $arItem) :
            if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) {
                echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
            }
            if ($arItem["IS_PARENT"]) : ?>
                <li class="is-parent">
                    <span>
                        <span><?= $arItem["TEXT"] ?></span>
                        <img src="<?= $APPLICATION->GetTemplatePath("img/ui-icon/arrow-bottom.svg") ?>" class="img-svg">
                    </span>
                <?= '<ul>' ?>
            <? else : ?>
                <li>
                    <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                </li>
            <? endif; ?>

            <? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

        <? endforeach; ?>

        <? if ($previousLevel > 1) {//close last item tags?>
            <?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
        <? } ?>

    </ul>
<? } ?>