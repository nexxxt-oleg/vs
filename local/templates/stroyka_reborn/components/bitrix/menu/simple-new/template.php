<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="<?= $arParams['MENU_CLASS'] ?>">
    <? if (!empty($arResult)): ?>
        <?
        foreach ($arResult as $arItem):
            if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?>
            <? if ($arItem["SELECTED"]):?>
            <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
        <? else:?>
            <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
        <? endif ?>
        <? endforeach ?>
    <? endif ?>
</div>