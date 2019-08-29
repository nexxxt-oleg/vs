<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if (empty($arResult))
    return "";

$strReturn = '';

$strReturn .= '<section class="bread-crumbs-sect">
				<div class="new-container">
					<div class="new-row">
						<div class="new-col-12">
							<ul class="bread-crumbs">';

$itemSize = count($arResult);
for ($index = 0; $index < $itemSize; $index++) {
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

    $title = mb_strtoupper(mb_substr($title, 0, 1)) . mb_strtolower(mb_substr($title, 1, mb_strlen($title)));
    if ($index == $itemSize - 1)
        $strReturn .= '<li><span>' . $title . '</span></li>';
    else
        $strReturn .= '<li><a href="' . $arResult[$index]["LINK"] . '" title="' . $title . '">' . $title . '</a></li>';
}

$strReturn .= '</ul>
						</div>
					</div>
				</div>
			</section>';

return $strReturn;