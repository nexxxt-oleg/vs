<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<ul>
    <? if (!empty($arResult)): ?>
        <?
        foreach ($arResult as $arItem):
            if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?>
            <li><a href="<?= $arItem["LINK"] ?>" class="h3"><?= $arItem["TEXT"] ?></a></li>

        <? endforeach ?>
    <? endif ?>
</ul>