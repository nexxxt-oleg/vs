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
    <? foreach ($arResult as $categoryName => $arItems): ?>
    <div class="col-lg-6">
        <div class="row">
        <div class="col-12">
            <h3 class="page-cnt-contacts__department-title"><?= $categoryName ?></h3>
        </div>
        <? foreach ($arItems as $arItem): ?>
            <? $arPhone = explode(',', $arItem['PHONE']); ?>
            <div class="col-sm-8">
                <div class=" card-contact">
                    <? if (!empty($arItem['ONAME']) || !empty($arItem['PLACE'])) : ?>
                        <h4 class="card-contact__title"><?= $arItem['ONAME'] ?><br><?= $arItem['PLACE'] ?></h4>
                    <? endif; ?>
                    <ul class="card-contact__desc">
                        <? if (isset($arPhone[0]) && !empty($arPhone[0])) : ?>
                        <li>Тел.:
                            <? foreach ($arPhone as $phone): ?>
                                <?= !empty($phone) && $phone != ' ' ? trim($phone) . '<br/>' : '' ?>
                            <? endforeach; ?>
                        </li>
                        <? endif; ?>
                        <?= isset($arItem['FAX']) && !empty($arItem['FAX']) ? '<li>Тел/факс: ' . $arItem['FAX'] . '</li>' : '' ?>
                        <li>Email: <?= $arItem['EMAIL'] ?></li>
                        <?= isset($arItem['WORKTIME']) && !empty($arItem['WORKTIME']) ? '<li>График работы: ' . $arItem['WORKTIME'] . '</li>' : '' ?>
                    </ul>
                </div>
            </div>
        <? endforeach; ?>
        </div>
    </div>
    <? endforeach; ?>
