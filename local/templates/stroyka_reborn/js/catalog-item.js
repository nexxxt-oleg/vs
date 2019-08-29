$(function () {

    $('.js-item-img-mismatch').on({
        click: function (e) {
            e.preventDefault();
            var name = $(this).data('element');
            var id = $(this).data('id');
            var url = $(this).data('element-url');
            var that = $(this);

            $.ajax({
                method: "post",
                url: "/ajax/product-img-mismatch.php",
                data: {name: name, id: id, url: url},
                success: function (response) {
                    if (response == "success") {
                        $(that).replaceWith($('<span class="card-product__mismatch-desc mismatch-desc"> Ваше уведомление отправлено менеджеру на рассмотрение</span>'));
                        //console.log('success2');
                    }
                }
            });
        }
    });
});