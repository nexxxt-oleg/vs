$(function() {
	$('.js-toggle-payment').on('click', function() {
		var btn = $(this);
		var radioCard = $('.pp-current-order-params-radio');
		
		if(radioCard.hasClass('open')) {
			radioCard.slideUp(300);
			radioCard.removeClass('open');
			btn.removeClass('btn_arrow-reverse');
		} else {
			radioCard.slideDown(300);
			radioCard.addClass('open');
			btn.addClass('btn_arrow-reverse');
		}
	});
});