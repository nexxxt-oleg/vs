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

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs($APPLICATION->GetTemplatePath('js/new-catalog.js'));
?>


<section class="page-all-sect page-catalog__categories ">
    <div class="new-container">
        <div class="new-row">
            <div class="new-col-12">
                <div class="page-all-sect__top-title">
                    <span class="h1-new">Каталог</span>
                </div>
            </div>
        </div>
        <div class="new-row">
            <div class="new-col-sm-4 new-col-lg-3">
                <div class="page-catalog__left-menu new-left-menu">
                    <ul class="new-left-menu">
                        <? foreach ($arResult['SECTIONS'] as $key => $arSection):
                            if ($arSection['DEPTH_LEVEL'] == 1) :?>
                                <li class="new-left-menu__item" data-hover="<?= $key ?>">
                                    <a href="<?= $arSection['SECTION_PAGE_URL'] ?>"><?= mb_ucfirst(strtolower($arSection['NAME'])) ?></a>
                                </li>
                            <? endif; ?>
                        <? endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="new-col-sm-8 new-col-lg-9">
                <div class="new-row">
                    <? $subs = $num = 0; ?>
                    <? foreach ($arResult['SECTIONS'] as $key => $arSection) :
                        if ($prevDepth > $arSection['DEPTH_LEVEL']):
                            if ($subs <= 3) {
                                echo "</ul>
                                        </div>
                                    </div>
                                </div>";
                            } else {
                                $line = ($num < 0) ? '<div class="line"></div>' : '';
                                $num++;

                                echo "</ul>
                                            <button class='new-catalog__show-submenu'>Еще</button>
                                        </div>
                                    </div>" .
                                    $line .
                                    "</div>";
                            };
                        endif;
                        if ($arSection['ID'] == 7846) {
                            $a = 1;
                        }
                        switch ($arSection['DEPTH_LEVEL']) {
                            case 1:
                                if ($key > 0 && $prevDepth == 1) {
                                    echo "</div>
                                       </div>";
                                }
                                $imgUrl = !empty($arSection['PICTURE']['SRC']) ? $arSection['PICTURE']['SRC'] : $APPLICATION->GetTemplatePath('img/no_photo.png');
                                echo "
                                   <div class='new-col-sm-6 new-col-lg-3'>
									<div class='new-catalog__card-full'>
										<a href='{$arSection['SECTION_PAGE_URL']}' class='new-catalog__card' data-hover='{$key}'>
											<img src='{$imgUrl}' class='new-catalog__img'>
											<span class='new-catalog__title h4-new'>" . mb_ucfirst(strtolower($arSection['NAME'])) . '</span>
										</a>';
                                $subs = 0;
                                break;
                            case 2:
                                $subs++;

                                if ($prevDepth >= $arSection['DEPTH_LEVEL'] && $subs == 4):
                                    echo "</ul>
                                        <ul class='new-catalog__submenu-hidden display'>";
                                elseif ($prevDepth < $arSection['DEPTH_LEVEL']) :
                                    echo "<div class='full-submenu'>
										<ul class='new-catalog__submenu'>";
                                endif;
                                echo PHP_EOL . "<li>
										<a href='{$arSection['SECTION_PAGE_URL']}'>{$arSection['NAME']}</a>
									</li>";
                                break;
                        }
                        $prevDepth = $arSection['DEPTH_LEVEL'];
                    endforeach;
                    switch ($arSection['DEPTH_LEVEL']) {
                        case 1:
                            echo "</div>
                                </div>";
                            break;
                        case 2:
                            if ($subs <= 3) {
                                echo "</ul>
                                        </div>
                                    </div>
                                </div>";
                            } else {
                                echo "</ul>
                                            <button class='new-catalog__show-submenu'>Еще</button>
                                        </div>
                                    </div>
                                </div>";
                            };
                            break;
                    }
                    ?>

                    <div class="page-all-sect__top-title scroll-sect" data-sect="2">
                    </div>
                    <div class="page-all-sect__top-title scroll-sect" data-sect="3">
                    </div>
                    <div class="page-all-sect__top-title scroll-sect" data-sect="3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>