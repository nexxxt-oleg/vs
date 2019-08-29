$(function() {
	// Передача значения из выбранного инпута в скрытый инпут
	var $value = $('.form-wraper__input');
	var $input = $('.formselect-radio__item input');

	$input.on('change', function() {
		$value.val($(this).val());
	});

	// Блок на самовывоз и радио
	var $hidden = $('.js-way2-block');
	var $radio = $('.js-way-radio');

	// Показ блока при смене способа доставки
	$radio.on('change', function() {
		if ($(this).hasClass('bx-enable-region')){
			$hidden.slideDown(200);
		} else {
			$hidden.slideUp(200);
		}
	});

	// Поиск внутри выпадающего списка адресов
	// $('.formselect-search__search-field').on('input', function() {
	// 	var $str = $(this).val().toLowerCase();
	// 	var $searchResult = $('ul .formselect-radio__item');
	// 	var $nothingFound = $('.formselect-search__nothing-found');
	// 	if ($str.length === 0) {
	// 		$searchResult.show();
	// 	} else {
	// 		$searchResult.each(function() {
	// 			if ($(this).text().toLowerCase().indexOf($str) === -1) {
	// 				$(this).hide();
	// 			} else {
	// 				$(this).show();
	// 			}
	// 		});
	// 	}
	// 	$nothingFound.css('display', $searchResult.text().toLowerCase().indexOf($str) === -1 ? 'flex' : 'none');
	// });

	// Поиск внутри выпадающего списка адресов BX
	$('.formselect-search__search-field').on('input', function() {
		var $str = $(this).val().toLowerCase();
		var $searchResult = $('.bx-ui-pager-page-wrapper .bx-ui-combobox-variant');
		var $nothingFound = $('.formselect-search__nothing-found');
		if ($str.length === 0) {
			$searchResult.show();
		} else {
			$searchResult.each(function() {
				if ($(this).text().toLowerCase().indexOf($str) === -1) {
					$(this).hide();
				} else {
					$(this).show();
				}
			});
		}
		$nothingFound.css('display', $searchResult.text().toLowerCase().indexOf($str) === -1 ? 'flex' : 'none');
	});

	$('.js-name-form-field').on('input', function(e) {
		this.value = this.value.replace(/([0-9.*+?^$|(){}\[\]\%\#\@\&\!\№\^\_\+\=\"\/\.\,\\\:\;\`\~])/gi, "");
	});

});

