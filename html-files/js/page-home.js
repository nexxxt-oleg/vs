$(function() {
	
	/* Слайдер новостей */
	
	var newsSlider = $('.news-slider__slick');
	var newsSliderPrev = $('.news-slider__prev');
	var newsSliderNext = $('.news-slider__next');
	var newsSliderDots = $('.news-slider__dots');

	$(document).ready(function() {
		newsSlider.css('opacity', '1');
	});
	
	newsSlider.slick({
		infinite: true,
		dots: false,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 4000
	});
	
	newsSliderPrev.on('click', function() {
		newsSlider.slick('slickPrev');
	});
	
	newsSliderNext.on('click', function() {
		newsSlider.slick('slickNext');
	});
	
	newsSliderDots.children('button').on('click', function() {
		var id = parseInt($(this).data('id'));
		newsSlider.slick('slickGoTo', id);
	});
	
	newsSlider.on('afterChange', function(e, slick, currentSlide){
		newsSliderDots.children('button').removeClass('active');
		newsSliderDots.children('button[data-id="'+currentSlide+'"]').addClass('active');
	});
	
	/* Слайдер распродажи */
	var slider = $('.sale-slider__slick');
	var sliderPrev = $('.sale-slider__prev');
	var sliderNext = $('.sale-slider__next');
	var sliderDots = $('.sale-slider__dots');
	var sliderItem = $('.sale-slider__item');
	function sliders(sl) {
		sl.find(slider).slick( {
			infinite: true,
			dots: false,
			arrows: false,
			slidesToShow: 6,
			swipeToSlide: true,
			responsive: [
				{
					breakpoint: 1260,
					settings: {
						slidesToShow: 4,
						slidesToScroll: 4,
					}
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 3,
						swipeToSlide: 3,
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2,
						swipeToSlide: 2,
					}
				}
			]
		});
		$(document).ready(function() {
			slider.css('opacity', '1');
			if( $(window).width() < 992 ) {
				sl.find(sliderDots).append('<button data-id="0" class="active"></button>');
				if(	$(window).width() > 767 ) {
					for( var i = 3; i < sl.find(sliderItem).length; i += 3) {
						sl.find(sliderDots).append('<button data-id="' + i + '"></button>');
					}
				} else {
						for( var i = 2; i < sl.find(sliderItem).length; i += 2) {
							sl.find(sliderDots).append('<button data-id="' + i + '"></button>');
					}
				}
			}
			sl.find(sliderNext).on('click', function() {
				sl.find(slider).slick('slickNext');
			});
			sl.find(sliderPrev).on('click', function() {
				sl.find(slider).slick('slickPrev');
			});
			if(sliderDots) {
				sl.find(sliderDots).children('button').on('click', function() {
					var id = parseInt($(this).data('id'));
					sl.find(slider).slick('slickGoTo', id);
				});
			}
			if(sliderDots) {
				sl.children(slider).on('afterChange', function(e, slick, currentSlide) {
					var current = sl.find(sliderDots).children('button[data-id="'+currentSlide+'"]');
					var allDots = sl.find(sliderDots).children('button');
					allDots.removeClass('active');
					current.addClass('active');
				});
			}
		});
	}

	sliders($('.sale-slider__discount'));
	sliders($('.sale-slider__discount-all'));
	sliders($('.sale-slider__new'));
	sliders($('.sale-slider__popular-goods'));
	
	/* Слайдер популярных товаров */
	
	var popularSlider = $('.sale-slider__slick_popular');
	var popularSliderPrev = $('.js-popular-prev');
	var popularSliderNext = $('.js-popular-next');
	
	popularSlider.slick({
		dots: false,
		arrows: false,
		slidesToShow: 6,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 1260,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					centerMode: true
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToScroll: 2,
					slidesToShow: 2
				}
			}
		]
	});
	
	popularSliderPrev.on('click', function() {
		popularSlider.slick('slickPrev');
	});
	
	popularSliderNext.on('click', function() {
		popularSlider.slick('slickNext');
	});

	// Популярные категории
	
	var categoriesSlider = $('.categories-sliders__slider');
	var categoriesDots = $('.categories-sliders__dots');
	var categoriesNext = $('.categories-sliders__next');
	var categoriesPrev = $('.categories-sliders__prev');
	var categoriesItem = $('.categories-sliders__item');

	categoriesSlider.slick({
		dots: false,
		arrows: false,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});


	if( $(window).width() > 767 && categoriesItem.length > 3 ) {
		categoriesPrev.css('display', 'flex');
		categoriesNext.css('display', 'flex');
		$('.categories-sliders__slider').css('padding-bottom', '32px');
	}

	categoriesPrev.on('click', function() {
		categoriesSlider.slick('slickPrev');
	});
	
	categoriesNext.on('click', function() {
		categoriesSlider.slick('slickNext');
	});

	categoriesDots.children('button').on('click', function() {
		var id = parseInt($(this).data('id'));
		categoriesSlider.slick('slickGoTo', id);
	});
	
	categoriesSlider.on('afterChange', function(e, slick, currentSlide){
		categoriesDots.children('button').removeClass('active');
		categoriesDots.children('button[data-id="'+currentSlide+'"]').addClass('active');
	});
	
	// Слайдер новости
	var allNewsSlider = $('.all-news-sliders__slick');
	var allNewsSDots = $('.all-news-sliders__dots');

	allNewsSlider.slick({
		dots: false,
		arrows: false,
		slidesToShow: 4,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});

	allNewsSDots.children('button').on('click', function() {
		var id = parseInt($(this).data('id'));
		allNewsSlider.slick('slickGoTo', id);
	});
	
	allNewsSlider.on('afterChange', function(e, slick, currentSlide){
		allNewsSDots.children('button').removeClass('active');
		allNewsSDots.children('button[data-id="'+currentSlide+'"]').addClass('active');
	});

	
	/* Слайдер партнеров и поставщиков */
	
	var partnersSlider = $('.partners-slider__slick');
	var partnersSliderItem = $('.partners-slider__item');
	var partnersSliderPrev = $('.partners-slider__prev');
	var partnersSliderNext = $('.partners-slider__next');
	
	partnersSlider.slick({
		infinite: false,
		dots: false,
		arrows: false,
		slidesPerRow: 10,
		rows: 2,
		adaptiveHeight: true,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesPerRow: 4
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesPerRow: 2
				}
			}
    ]
	});
	partnersSliderPrev.on('click', function() {
		partnersSlider.slick('slickPrev');
	});
	
	partnersSliderNext.on('click', function() {
		partnersSlider.slick('slickNext');
	});

	partnersSliderPrev.css('display', $(window).width() > 991 && partnersSliderItem.length > 20 ? 'flex' : 'none');
	partnersSliderNext.css('display', $(window).width() > 991 && partnersSliderItem.length > 20 ? 'flex' : 'none');
	
	partnersSliderPrev.css('display', $(window).width() > 767 && $(window).width() < 992 && partnersSliderItem.length > 8 ? 'flex' : 'none');
	partnersSliderNext.css('display', $(window).width() > 767 && $(window).width() < 992 && partnersSliderItem.length > 8 ? 'flex' : 'none');

	partnersSliderPrev.css('display', $(window).width() < 768 && partnersSliderItem.length > 4 ? 'flex' : 'none');
	partnersSliderNext.css('display', $(window).width() < 768 && partnersSliderItem.length > 4 ? 'flex' : 'none');
});
