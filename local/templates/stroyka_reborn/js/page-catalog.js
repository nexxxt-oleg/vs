$(function () {
	
	$('.spoiler').each(function(id, el) {
		var btn = $(el).children('.spoiler__btn');
		var hiddenBlock = $(el).children('.spoiler__body');
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
	
	$('.catalog-card__top, .new-left-menu__item').on({
		mouseenter: function(){
			var parent = $(this);
			var thisId = parent.data('hover');
			 if(!parent.hasClass('active-on-hover')) {
				parent.addClass('active-on-hover');
				$('.new-left-menu__item').removeClass('new-left-menu__item_active');
				$('.catalog-card__top').removeClass('hover');
				$('.new-left-menu__item[data-hover="'+thisId+'"]').addClass('new-left-menu__item_active');
				$('.catalog-card__top[data-hover="'+thisId+'"]').addClass('hover');
			}
		},
		mouseleave: function(){
			var parent = $(this);
			if(parent.hasClass('active-on-hover')) {
				$('.new-left-menu__item').removeClass('new-left-menu__item_active');
				$('.catalog-card__top').removeClass('hover');
				parent.removeClass('active-on-hover');
			}
		}
	});
	

});
