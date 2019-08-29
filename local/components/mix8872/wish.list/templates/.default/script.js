$(function(){
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