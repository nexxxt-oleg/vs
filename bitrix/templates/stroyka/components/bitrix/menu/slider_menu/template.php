<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$currentLevel = 1;
if (!empty($arResult)):
    ?>
    <div class="row">
    <? foreach ($arResult as $key => $arItem): ?>
    <? if ($arItem['DEPTH_LEVEL'] < $currentLevel): ?>
        </ul>
        </div>
    <? endif; ?>
    <? if ($arItem['DEPTH_LEVEL'] == 1): ?>
        <div class="col-md-3">
        <ul class="bottom-category">
        <li class="bottom-category-title"><a href="<?= $arItem['LINK'] ?>"><?= $arItem['TEXT'] ?></a></li>
    <? else: ?>
        <li><a href="<?= $arItem['LINK'] ?>"><?= $arItem['TEXT'] ?></a></li>
    <? endif; ?>
    <? $currentLevel = $arItem['DEPTH_LEVEL']; ?>
<? endforeach; ?>
    </ul>
    </div>
    </div>
<? endif; ?>