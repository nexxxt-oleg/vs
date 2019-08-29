<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Отложенные товары");
?>
    <span class="clean_wishlist">Очистить</span>
    <div class="clearfix"></div>
    <div class="wishlist_list">
        <? if (\Bitrix\Main\Loader::includeModule("sale")) {
            $dbBasketItems = CSaleBasket::GetList(
                array(
                    "NAME" => "ASC",
                    "ID" => "ASC"
                ),
                array(
                    "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                    "LID" => SITE_ID,
                    "ORDER_ID" => "NULL",
                    "DELAY" => "Y"
                ),
                false,
                false,
                array("ID", "DELAY", "PRODUCT_ID", "PRICE")
            );
            while ($arItems = $dbBasketItems->Fetch()) {
                $arBasketItems[] = $arItems["PRODUCT_ID"];
                if ($arItems['DELAY'] == 'Y') {
                    $res = CIBlockElement::GetByID($arItems["PRODUCT_ID"]); ?>
                    <? if ($ar_res = $res->GetNext()): ?>
                        <div class="col-sm-4">
                            <div class="bx_catalog_item_container">
                                <a href="<?= $ar_res["CANONICAL_PAGE_URL"] ?>" class="bx_catalog_item_images"
                                   title="Памятник с крестом из гранита габбро-диабаз №26">
                        <span class="img_wrap">
                            <?
                            $renderImage = CFile::ResizeImageGet($ar_res['DETAIL_PICTURE'], Array("width" => '285', "height" => '278'), BX_RESIZE_IMAGE_PROPORTIONAL_ALT); ?>
                            <img src="<?= $renderImage["src"] ?>" alt="<?= $ar_res['NAME']; ?>" title="<?= $ar_res['NAME']; ?>">
                        </span>
                                    <div class="bx_catalog_item_title order_name"><?= $ar_res['NAME']; ?></div>
                                </a>

                                <div class="bx_catalog_item_price">
                                    <div class="bx_price"><?= preg_replace('/\..+$/', '', $arItems["PRICE"]); ?> руб.</div>
                                </div>
                                <div class="bx_catalog_item_controls">
                                    <div class="bx_catalog_item_controls_blocktwo">
                                        <span class="addToCart">в корзину</span>
                                        <span class="price" style="display: none"><?= preg_replace('/\..+$/', '', $arItems["PRICE"]); ?> руб.</span>
                                        <span class="product_id" style="display: none"><?= $arItems["PRODUCT_ID"] ?></span>
                                    </div>
                                    <div style="clear: both;"></div>
                                </div>
                            </div>
                        </div>
                    <?endif; ?>
                <?
                }
            }
            $inwished = count($arBasketItems);
        }
        ?>
        <? if ($inwished == 0): ?>
            <p class="empty_wishlist">Ничего не найдено.</p>
        <? endif; ?>
        <div class="clearfix"></div>
    </div>
    <script>
        $(function () {
            var elm = document.getElementsByClassName('.addToCart');
            $(".addToCart").click(function (e) {
                var s = $(this).siblings('.product_id').html();
                var price = $(this).siblings('.price').html();
                var price_m = price.replace(' руб.', "");
                price_m = price_m.replace(' ', '');
                var sendData = {
                    id: s,
                    price: price_m,
                    value: 1
                };
                this.blur();
                $.ajax({
                    url: "/ajax/price1.php",
                    global: false,
                    type: "POST",
                    data: ({sendData: sendData}),
                    success: function (data) {
                        window.location.href = "/korzina/";
                    }
                });
                return false;
            });
            $(".clean_wishlist").click(function (e) {
                $.ajax({
                    type: "POST",
                    url: "/ajax/clean.php",
                    success: function (html) {
                        $('.wishlist_list').html('<p class="empty_wishlist">Ничего не найдено.</p>');
                        $('#wishcount').html('0');
                    }
                });
            });
        });
    </script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");