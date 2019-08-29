$(function () {
	var opacityGroup = $('.header__logo, .header__burger, .header__btns');
	if( $(window).width() < 1025 ) {
		$('.js-header-search').on({
			focusin: function() {
				$(this).addClass('focus');
					$('.js-new-col-search').css('position', 'static');
				opacityGroup.addClass('search-active');
			},
			focusout: function() {
				$(this).removeClass('focus');
				$('.js-new-col-search').css('position', 'relative');
				opacityGroup.removeClass('search-active');
			}
		});
	}
});
