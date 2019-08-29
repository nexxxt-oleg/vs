(function ($) {

    /*формы AJAX*/
    // $(document).on('submit', '.ajax-form', function(e){
    //     e.preventDefault();
    //     var that = $(this);
    //     var action = that.attr('action');
    //     var method = that.attr('method');
    //     var data = that.serializeArray();

    //     $.ajax({
    //         method: method,
    //         url: action,
    //         data: data,
    //         success: function(response) {
    //             that.html(response);
    //         }
    //     });
    // });

    $.fn.switchPopup = function (btn, time, overflow) {
        var $popup = this;
        $(document).on('click', btn, function () {
            var $scrollWidth = window.innerWidth - document.documentElement.clientWidth
            var $time = typeof time === 'number' ? time : 300;
			var $overflow = typeof overflow !== 'undefined' ? overflow : true;

            function closePopup(popup) {
                popup.removeClass('visible');
                setTimeout(function () {
                    popup.removeClass('display');
					if($overflow) {
						$('.root').css({
							'padding-right': 0,
							'overflow': 'auto'
						});
					}
                }, $time);
            }

            if ($popup.hasClass('display')) {
                closePopup($popup);
            }

            if (!$popup.hasClass('display')) {
                $popup.addClass('display');
                setTimeout(function () {
                    $popup.addClass('visible');
                }, 1);
				if($overflow) {
					$('.root').css({
						'padding-right': $scrollWidth,
						'overflow': 'hidden'
					});
				}
            }

            setTimeout(function () {
                if ($('.popup.display.visible').length > 1) {
                    closePopup($('.popup').not($popup));
                }
            }, 2);
        });
    };
})(jQuery);

$(function() {
	/* ИМГ В СВГ */
	$('img.img-svg').each(function(){
		var $img = $(this);
		var imgID = $img.attr('id');
		var imgClass = $img.attr('class');
		var imgURL = $img.attr('src');

		$.get(imgURL, function(data) {
			var $svg = $(data).find('svg');

			if(typeof imgID !== 'undefined') {
				$svg = $svg.attr('id', imgID);
			}

			if(typeof imgClass !== 'undefined') {
				$svg = $svg.attr('class', imgClass+' replaced-svg');
			}

			$svg = $svg.removeAttr('xmlns:a');

			if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
				$svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
			}

			$img.replaceWith($svg);

		}, 'xml');
	});

    /*// поиск
    $('.input-search__input').on({
        'focusin': function() {
            $('.header-middle__search').addClass('header-middle__search_active');
            $('.search-spisok').addClass('hidden');
        }
    });
    //оверфлов ...
    function trimTextByElementLength(txt, el, lines) {
        var c = document.createElement('canvas'); // Не стоит создавать канвас каждый раз, лучше создавать его при первом вызове функции, а при следующих обращаться к нему
        var ctx = c.getContext('2d');
        var cs = window.getComputedStyle(el, null);
        var fontSize = cs.fontSize,
            fontName = cs.fontName,
            fontWeight = cs.fontWeight;
        var size = parseInt(cs.getPropertyValue('width'), 10);
        var txt = txt.split(' ');

        ctx.font = fontWeight + ' ' + fontSize + ' ' + fontName;

        var target = 0;
        var result = [];

        for (var line = 1; line <= lines; line++) {
            for (var word = 0; word < txt.length; word++) {
                if (target + ctx.measureText(txt[word]).width + ctx.measureText(' ').width < size) {
                    target += ctx.measureText(txt[word]).width + ctx.measureText(' ').width;
                    result.push(txt[word]);
                } else {
                    break;
                }
            }

            target = 0;

            if (line >= lines) {
                result.pop();
                result.push('...');
                break;
            }
        }

        return result.join(' ');
    }
*/
/*
    $('.card-product__title').each(function(id, el) {
        console.log(el);
        var text = $(el).data('text');
        $(el).text(trimTextByElementLength(text, el, 3));
    });
*/



//  Попапы
	$('.hb-menu-lg__main').switchPopup('.js-tgl-menu-lg', 300, false);
	$('.hb-menu-xs__main').switchPopup('.js-tgl-menu-xs', 300);
	$('.popup-callback').switchPopup('.js-tgl-callback', 300);
	
	$('.js-tgl-menu-xs, .js-tgl-menu-lg').on('click', function() {
		if(!$(this).hasClass('open')) {
			$(this).removeClass('close');
			$(this).addClass('open');
		} else {
			$(this).removeClass('open');
			$(this).addClass('close');
		}
	});
	
// Выпадающие пункты меню
	function openMnu(object) {
		obj = object.obj;
		closeAll = object.closeAll ? object.closeAll : false;
		noAnim = object.noAnim ? object.noAnim : false;

		if(typeof closeAll == 'undefined' || closeAll) {
			var allObj = obj.parent('ul').children('li').not(obj);
			closeMnu(allObj);
		}

		if(!noAnim) {
			obj.addClass('display');
			setTimeout(function() {
				obj.addClass('visible');
			}, 1);
		} else {
			obj.addClass('display');
			obj.addClass('visible');
		}
	}

	function closeMnu(object) {
		obj = object.obj;
		closeAll = object.closeAll ? object.closeAll : false;
		noAnim = object.noAnim ? object.noAnim : false;
		
		if(!noAnim) {
			obj.removeClass('visible');
			setTimeout(function() {
				obj.removeClass('display');
			}, 200);
		} else {
			obj.removeClass('visible');
			obj.removeClass('display');
		}
	}

	var supportsTouch = 'ontouchstart' in window || navigator.msMaxTouchPoints;
	if(typeof supportsTouch == 'undefined' || !supportsTouch) {
		$('.hb-menu-lg__main .is-parent').on({
			'mouseenter': function() {
				openMnu({ obj: $(this), noAnim: true });
			},
			'mouseleave': function() {
				closeMnu({ obj: $(this), noAnim: true });
			}
		});
	} else {
		$('.hb-menu-lg__main .is-parent').on('click', function() {
			if(!$(this).hasClass('display')) {
				openMnu({ obj: $(this) });
			} else {
				closeMnu({ obj: $(this) });
			}
		});
		
		$('.hb-menu-xs__main .is-parent').on('click', function() {
			if(!$(this).hasClass('display')) {
				openMnu({
					obj: $(this)
				});
			} else {
				closeMnu({
					obj: $(this)
				});
			}
		});
	}

	// Таймеры акций
	if($('.card-actions-timer').length !== 0) {
		$('.card-actions-timer').each(function(id, element) {
			$(element).downCount({
				date: $(element).data('time'),
				offset: +10
			});
		});
	}

	if($('.card-new-actions-timer').length !== 0) {
		$('.card-new-actions-timer').each(function(id, element) {
			$(element).downCount({
				date: $(element).data('time'),
				offset: +10
			});
		});
	}

	// Выпадающий список js (для сортировки каталога)
	if($('.catalog-sort').length !== 0) {
		$('.catalog-sort').each(function(i, el) {
			$(el).find('.catalog-sort__arrow').on('click', function() {
				$(el).children('.catalog-sort__select').toggleClass('active');
			});
			$(el).find('.catalog-sort__param').text($(el).find('.catalog-sort__body a.active').first().text());
		});
	}

	// Левое меню-аккордион
	$('.left-menu-accordion li.is-parent > button').on('click', function() {
		var parent = $(this).parent('.is-parent');
		if(parent.hasClass('open')) {
			parent.removeClass('open');
			parent.children('ul').slideUp('200');
		} else {
			parent.addClass('open');
			parent.children('ul').slideDown('200');
		}
	});

    var moreBtnTextVal;
	$('.left-menu-accordion__more-btn').on('click', function() {
		var lastMenu = $('.left-menu-accordion__last');
		var moreBtn = $(this);
		var moreBtnText = moreBtn.children('span');
		if(moreBtn.hasClass('open')) {
			moreBtn.removeClass('open');
			lastMenu.slideUp('200');
            moreBtnText.html(moreBtnTextVal);
		} else {
            moreBtnTextVal = moreBtnText.html();
			moreBtn.addClass('open');
			lastMenu.slideDown('200');
			moreBtnText.html('Скрыть');
		}
	});

	// Скролл страницы вверх
	function scrollToTop() {
		var $button = $('.btn-to-top');
		var $buttonText = $('.btn-to-top__text');
		var $scrollBlock = $('.root');
		var vh = $(window).height();

		var topText = 'Вверх';
		var bottomText = 'Вниз';

		// Запоминается место на которое можно будет вернуться после нажатия на кнопку "Наверх"
		var saveScroll = $scrollBlock.scrollTop();

		// 0 - Обычный
		// 1 - Вернулся
		// 2 - Вернулся и начал скролл
		var scrollStatus = 0;

		$button.on('click', function () {
			if ($(this).hasClass('back')) {
				$scrollBlock.scrollTop(saveScroll);
				$button.removeClass('back');
				$buttonText.text(topText);
				scrollStatus = 0;
			} else {
				saveScroll = $scrollBlock.scrollTop();
				$scrollBlock.scrollTop(0);
				$button.addClass('back');
				$buttonText.text(bottomText);
				scrollStatus = 1;
			}
		});

		$scrollBlock.on('scroll', function () {
			if (scrollStatus === 1 && $scrollBlock.scrollTop() === 0) {
				scrollStatus = 2;
			}
			if (scrollStatus === 2 && $scrollBlock.scrollTop() > 0) {
				$button.removeClass('back');
				$buttonText.text(topText);
				scrollStatus = 0;
			}
			if (scrollStatus === 0) {
				if ($scrollBlock.scrollTop() >= vh) {
					if (!$button.hasClass('display')) {
						$button.addClass('display');
						setTimeout(function () {
							$button.addClass('visible');
						}, 5);
					}
				} else {
					if ($button.hasClass('display')) {
						$button.removeClass('visible');
						setTimeout(function () {
							$button.removeClass('display');
						}, 200);
					}
				}
			}
		});
	}

	scrollToTop();

	$('.card-product__badge_why').on({
		mouseenter: function() {
			var descWrap = $('.card-product__desc-wrap', this);
			if(!descWrap.hasClass('display')) {
				descWrap.addClass('display');
				setTimeout(function(){
					descWrap.addClass('visible');
				}, 1);
			}
		},
		mouseleave: function() {
			var descWrap = $('.card-product__desc-wrap', this);
			if(descWrap.hasClass('display')) {
				descWrap.removeClass('visible');
				setTimeout(function(){
					descWrap.removeClass('display');
				}, 300);
			}
		}
	});
	$('.mismatch-desc-wrap').on({
		mouseenter: function() {
			var mismatch = $(this).parents('.mismatch-desc-parent');
			if(!mismatch.hasClass('mismatch-desc-parent_display')) {
				mismatch.addClass('mismatch-desc-parent_display');
				setTimeout(function(){
					mismatch.addClass('mismatch-desc-parent_visible');
				}, 1);
			}
		},
		mouseleave: function() {
			var mismatch = $(this).parents('.mismatch-desc-parent');
			if(mismatch.hasClass('mismatch-desc-parent_display')) {
				mismatch.removeClass('mismatch-desc-parent_visible');
				setTimeout(function(){
					mismatch.removeClass('mismatch-desc-parent_display');
				}, 300);
			}
		}
	});

});
