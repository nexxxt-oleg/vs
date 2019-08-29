$(function () {	
	
	$('.full-submenu').each(function(id, el) {
		var btn = $(el).children('.new-catalog__show-submenu');
		var hiddenBlock = $(el).children('.new-catalog__submenu-hidden');
		btn.on('click', function() {
			if(!btn.hasClass('active')) {
				hiddenBlock.slideDown(600);
				btn.addClass('active');
				btn.text('Скрыть');
			} else {
				hiddenBlock.slideUp();
				btn.text('Еще');
				btn.removeClass('active');
			}
		});
	});
	
	$('.new-catalog__card, .new-left-menu__item').on({
		mouseenter: function(){
			var parent = $(this);
			var thisId = parent.data('hover');
			 if(!parent.hasClass('active-on-hover')) {
				parent.addClass('active-on-hover');
				$('.new-left-menu__item').removeClass('new-left-menu__item_active');
				$('.new-catalog__card').removeClass('hover');
				$('.new-left-menu__item[data-hover="'+thisId+'"]').addClass('new-left-menu__item_active');
				$('.new-catalog__card[data-hover="'+thisId+'"]').addClass('hover');
			}
		},
		mouseleave: function(){
			var parent = $(this);
			if(parent.hasClass('active-on-hover')) {
				$('.new-left-menu__item').removeClass('new-left-menu__item_active');
				$('.new-catalog__card').removeClass('hover');
				parent.removeClass('active-on-hover');
			}
		}
	});
	

});