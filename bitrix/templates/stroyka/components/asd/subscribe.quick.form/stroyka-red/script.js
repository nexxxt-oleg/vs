if (typeof($) !== 'undefined') {
	$(document).ready(function() {
		$('.asd_subscribe_submit').click(function(){
			var form = $(this).parent();
			if (!$.trim($(form).find('input[name$="asd_email"]').val()).length) {
				return false;
			}
			var arPost = {};
			arPost.asd_rub = [];
			$.each($(form).find('input'), function() {
				if ($(this).attr('type')!='checkbox') {
					arPost[$(this).attr('name')] = $(this).val();
				}
				else if ($(this).attr('type')=='checkbox' && $(this).is(':checked')) {
					arPost.asd_rub.push($(this).val());
				}
			});
			$(form).find('.asd_subscribe_res').hide();
			$(form).find('.asd_subscribe_submit').attr('disabled', 'disabled');
			$.post('/bitrix/components/asd/subscribe.quick.form/action.php', arPost,
					function(data) {
						$(form).find('.asd_subscribe_submit').removeAttr('disabled');
						if (data.status == 'error') {
							$(form).find('.asd_subscribe_res').css('color', 'red').html(data.message).show();
						} else {
							$(form).find('.asd_subscribe_res').css('color', 'green').html("Адрес подписки успешно добавлен.").show();
						}
					}, 'json');
			return false;
		});
	});
}