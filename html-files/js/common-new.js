$(function() {
	var imgSvgArray = {};

	function imgSvg() {
		$('img.img-svg').each(function () {
			var $img = $(this);
			var imgID = $img.attr('id');
			var imgClass = $img.attr('class');
			var imgURL = $img.attr('src');

			if (typeof imgSvgArray[imgURL] !== 'undefined') {
				var $svg = $(imgSvgArray[imgURL]);
				if (typeof imgClass !== 'undefined') {
					$svg = $svg.attr('class', imgClass + ' replaced-svg');
				}
				$img.replaceWith($svg);
			} else {
				$.ajax({
					url: imgURL,
					async: false,
					dataType: "xml",
					success: function (data) {
						var $svg = $(data).find('svg');
		
						if (typeof imgID !== 'undefined') {
							$svg = $svg.attr('id', imgID);
						}
		
						$svg = $svg.removeAttr('xmlns:a');
		
						if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
							$svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
						}
		
						imgSvgArray[imgURL] = $svg[0].outerHTML;
		
						if (typeof imgClass !== 'undefined') {
							$svg = $svg.attr('class', imgClass + ' replaced-svg');
						}

						$img.replaceWith($svg);
					}
				});
			}
		});
	}

	imgSvg();

	$('.main').on("DOMNodeInserted", function (e) {
		imgSvg();
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

//Бургер
	var menuBurger = $('.js-btn-burger');
	var menuPopup = $('.js-menu');
	var middleMenu = $('.js-new-menu-middle');
	//Закрытие popup не по кнопке
	$(document).on('click', function(e) {
		if( menuPopup.hasClass('display') ) {
			if( $(e.target).is(menuBurger) || $(e.target).is(menuBurger.children()) || $(e.target).is('.btn-burger__icon span')) return;
			menuBurger.removeClass('open');
			menuBurger.addClass('close');
			menuPopup.switchPopup('close');
		}
	});

	menuBurger.on('click', function() {
		$(this).toggleClass('close open');
		$('.left-menu__link.active').siblings(middleMenu).addClass('display visible');
	});

	menuPopup.switchPopup({
		btnClass: 'js-btn-burger',
		duration: 300,
		overflow: false
	});

	menuPopup.on('click', function(e) {
		e.stopPropagation();
	});

	function resizeGridItem($item) {
		var $grid = $('.new-menu__blocks');
		rowHeight = parseInt($grid.css('grid-auto-rows'));
		rowGap = parseInt($grid.css('grid-row-gap'));
		rowSpan = Math.ceil(($item.children()[0].getBoundingClientRect().height+rowGap)/(rowHeight+rowGap));
		$item[0].style.gridRowEnd = "span " + rowSpan;
	}

	function resizeAllGridItems() {
		$(".new-menu__block").each(function(id, el) {
			resizeGridItem($(el));
		});
	}
	var heightMenu, maxHeightMiddleMenu, activeMiddleMenuHeight;

	function resizeHeight() {
		maxHeightMiddleMenu = $('.left-menu').outerHeight(true);
		activeMiddleMenuHeight = $('.left-menu__link.active').siblings(middleMenu).outerHeight(true);
		maxHeightMiddleMenu = ( activeMiddleMenuHeight > maxHeightMiddleMenu ) ? activeMiddleMenuHeight : maxHeightMiddleMenu;
		menuPopup.height(maxHeightMiddleMenu + 58);
	}

	$(window).on('load', function() {
		var leftMenuLink = $('.left-menu__link');
		if( $(window).width() > 767 ) {
			//изначальная высота меню
			heightMenu = menuPopup.outerHeight(true);
			maxHeightMiddleMenu = heightMenu;
			resizeAllGridItems();

			//Поиск высоты списка 2го уровня активной пункта
			activeMiddleMenuHeight = $('.left-menu__link.active').siblings(middleMenu).outerHeight(true);

			//присвоение высоты для всего меню + отступы
			maxHeightMiddleMenu = ( activeMiddleMenuHeight > maxHeightMiddleMenu ) ? activeMiddleMenuHeight : maxHeightMiddleMenu;
			menuPopup.height(maxHeightMiddleMenu + 58);
			resizeAllGridItems();
			leftMenuLink.on('mouseenter click', function() {
				var _ = $(this);
				leftMenuLink.removeClass('active');
				_.addClass('active');
				middleMenu.removeClass('display visible');
				var thisSiblings = _.siblings(middleMenu);
				thisSiblings.addClass('display');
				setTimeout(function() {
					_.trigger('open', [_]);
					maxHeightMiddleMenu = ( _.siblings(middleMenu).outerHeight(true) > heightMenu ) ?  _.siblings(middleMenu).outerHeight(true) : heightMenu;
					menuPopup.height(maxHeightMiddleMenu + 58);
					thisSiblings.addClass('visible');
					_.trigger('open', [_]);
				}, 1);
				$('.left-menu__link').on('open', function(e, leftMenuLink) {
					leftMenuLink.parent('.left-menu__item').find('.new-menu__block').each(function(id, el) {
						resizeGridItem($(el));
					});
				});
			});
		} else {
			leftMenuLink.removeClass('active');
			$('.new-menu__middle-title').text('перейти в категорию');
			$('.left-menu__item').each(function(id, el) {
				var btn = $(el).children(leftMenuLink);
				var hiddenBlock = $(el).children('.js-new-menu-middle');
				btn.on('click', function() {
					hiddenBlock.toggleClass('display');
					btn.toggleClass('active');
					setTimeout(function() {
						hiddenBlock.toggleClass('visible');
					}, 150);
				});
			});
		}
		//удаление display класса у всего меню
		middleMenu.removeClass('display');
		menuPopup.removeClass('display');
	});

	$(window).on('resize', function() {
		if( !menuPopup.hasClass('display') ) {
			middleMenu.addClass('display');
			menuPopup.addClass('display');
			resizeAllGridItems();
			setTimeout(function () {
				resizeHeight();
			}, 0);
			setTimeout(function () {
				middleMenu.removeClass('display');
				menuPopup.removeClass('display');
			}, 1);
		} else {
			resizeAllGridItems();
			setTimeout(function () {
				resizeHeight();
			}, 0);
		}
	});

	//Кнопка купить добавить в избранное (сердечко) на карточке в слайдере 
	$('.card-product__add-favorites').on('click', function() {
		$(this).toggleClass('active');
	});

	// Левое меню-аккордион
	// Показать еще
	var moreBtnTextVal;
	$('.left-menu-accordion__more-btn').on('click', function() {
		var _ = $(this);
		var parentMenu = _.parent('.left-menu-accordion');
		var lastMenu = parentMenu.children('.left-menu-accordion__last');
		if( _.hasClass('open') ) {
			_.removeClass('open');
			lastMenu.slideUp('200');
			_.html(moreBtnTextVal);
		} else {
			moreBtnTextVal = _.html();
			_.addClass('open');
			lastMenu.slideDown('200');
			_.html('Скрыть');
		}
	});

	var btnFilter = $('.js-filter-btn-more');
	var btnCategories= $('.js-subcategories-btn-more');
	var filterHidden = $('.filter__hidden');
	var categoriesHidden = $('.js-filter-categories-hidden');

	//Показывать-скрывать фильтры - подкатегории
	btnFilter.on('click', function() {
		var moreBtn = $(this);
		var moreBtnText = moreBtn.children('span');
		moreBtnText.text(moreBtnText.text() !== 'Скрыть' ? 'Скрыть' : 'Фильтры');
		filterHidden.toggleClass('open');
		if( categoriesHidden.hasClass('open') ) {
			categoriesHidden.slideToggle('200');
			btnCategories.children('span').text('Подкатегории');
			categoriesHidden.removeClass('open');
		}
		filterHidden.slideToggle('200');
	});

	btnCategories.on('click', function() {
		var moreBtn = $(this);
		var moreBtnText = moreBtn.children('span');
		moreBtnText.text(moreBtnText.text() !== 'Скрыть' ? 'Скрыть' : 'Подкатегории');
		categoriesHidden.toggleClass('open');
		if( filterHidden.hasClass('open') ) {
			filterHidden.slideToggle('200');
			btnFilter.children('span').text('Фильтры');
			filterHidden.removeClass('open');
		}
		categoriesHidden.slideToggle('200');
	});

	// Для Сафари
	$('.formselect-radio__list').bind('mousewheel DOMMouseScroll', function(e) {
		var scrollTo = null;

		if( e.type == 'mousewheel' ) {
			scrollTo = (e.originalEvent.wheelDelta * -1);
		} else if( e.type == 'DOMMouseScroll' ) {
			scrollTo = 40 * e.originalEvent.detail;
		}

		if( scrollTo ) {
			e.preventDefault();
			$(this).scrollTop(scrollTo + $(this).scrollTop());
		}
	});

	// Выпадающий список (радиокнопки замаскированные под select)
	// Открытие выпадашки по клику на нее
	$(document).on('click', '.formselect-radio__value, .formselect-radio__arrow', function() {
		var $parent = $(this).parent('.formselect-radio');
		if(!$parent.hasClass('form-wraper_disabled')) {
			$parent.toggleClass('open');
		}
	});

	// Закрытие выпадашки по клику вне нее
	$(document).on('click', function(event) {
		var $formselectRadioAll = $('.formselect-radio.open');
		var $formselectRadio = $(event.target).closest('.formselect-radio.open');
		if( $formselectRadio.length ) { // Если клик внутри formselect-radio
			if( $formselectRadioAll.length > 1 ) // Если было открыто больше 1 formselect-radio
				$formselectRadioAll.not($formselectRadio).removeClass('open'); // Закрытие всех formselect-radio кроме только что открытого
			return;
		}
		$formselectRadioAll.removeClass('open');
		event.stopPropagation();
	});

	// Меняет value выпадашки
	function updateSelectRadioValue(a) {
		var $parent = $(a).parents('.formselect-radio');
		var $value = $parent.children('.formselect-radio__value');
		var $input = $value.children('span');
		var text = $(a).text();
		$value.children().text(text);
		$input.val(text);
		$value.attr('title', text);
		return $parent;
	}
	// // Обработка инпутов внутри выпадашки
	$(document).on('click', '.formselect-radio__item', function() {
		var _ = $(this);
		if (!_.hasClass('active')) {
			var parent = _.parents('.formselect-radio__list');
			parent.find('.formselect-radio__item').removeClass('active');
			_.addClass('active');
		}
		updateSelectRadioValue(_).removeClass('open');
	});

	//Клип по кнопке добавления в корзину на странице товара
	$('.price-list-middle__basket').on('click', function() {
		$(this).children('.h5-new').text('Добавлено');
		$(this).addClass('added');
	})

	//Попап на странице товара
	var pricePopup = $('.price-popup');
	$(window).on('load', function() {
		if( $(this).width() > 1200 ) {
			$('.price-list-bottom__wraper').on({
				'mouseenter': function() {
					var _ = $(this);
					var popupChild = _.children(pricePopup);
					popupChild.addClass('display');
					setTimeout(function () {
						popupChild.addClass('visible');
					}, 1);
				},
				'mouseleave': function() {
					var _ = $(this);
					var popupChild = _.children(pricePopup);
					popupChild.removeClass('visible');
					setTimeout(function () {
						popupChild.removeClass('display');
					}, 300);
				}
			});
		} else {
			$('.js-price-popup').on('click', function(){
				var _ = $(this);
				var parent = _.parent('.price-list-bottom__wraper');
				var popupChild = parent.find(pricePopup);
				if( !popupChild.hasClass('display') ) {
					if( pricePopup.length > 1 ) // Если было открыто больше 1 formselect-radio
						pricePopup.removeClass('display visible'); // Закрытие всех formselect-radio кроме только что открытог
					popupChild.addClass('display');
					setTimeout(function () {
						popupChild.addClass('visible');
					}, 1);
				} else {
					popupChild.removeClass('visible');
					setTimeout(function () {
						popupChild.removeClass('display');
					}, 300);
				}
			});
		}
		$(document).on('click', function(e) {
			if( pricePopup.hasClass('display') ) {
				if( $(e.target).is($('.js-price-popup')) ) return;
				pricePopup.removeClass('visible');
				setTimeout(function () {
					pricePopup.removeClass('display');
				}, 300);
			}
		});
	})
	pricePopup.on('click', function(e) {
		e.stopPropagation();
	});


	$('.price-list-middle__favorite').on('click', function() {
		$(this).toggleClass('active');
	})

	$('.card-product__badge_markdown').on({
		mouseenter: function() {
			var descWrap = $('.card-product__markdown-wrap', this);
			if(!descWrap.hasClass('display')) {
				descWrap.addClass('display');
				setTimeout(function(){
					descWrap.addClass('visible');
				}, 1);
			}
		},
		mouseleave: function() {
			var descWrap = $('.card-product__markdown-wrap', this);
			if(descWrap.hasClass('display')) {
				descWrap.removeClass('visible');
				setTimeout(function(){
					descWrap.removeClass('display');
				}, 300);
			}
		}
	});
	$('.js-new-bx-btn').on('click', function() {
		$('.js-bx-comment-block').slideToggle(300);
	});

	if($('.js-added-to-subscription').length) {
		$('.js-added-to-subscription').switchPopup({
			btnClass: 'js-tgl-subscription',
			duration: 300
		});
	}
	if($('.js-added-to-basket').length) {
		$('.js-added-to-basket').switchPopup({
			btnClass: 'js-tgl-basket',
			duration: 300
		});
	}

	// Input с телефонным номером (маска ввода)
	$('.js-input-phone').each(function(id, input) {
		new Inputmask("+7 (999) 999 99 99").mask(input);
	});

});
