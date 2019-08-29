;(function($) {
	'use strict';
	var SwitchPopup = window.SwitchPopup || {};

	SwitchPopup = (function() {
		function SwitchPopup(element, settings) {
			var _ = this;
			
			_.$popup = $(element);
			_.state = 'close';
			_.btnClass = '';
			_.duration = 300;
			_.overflow = true;
			_.displayClass = 'display';
			_.visibleClass = 'visible';
			_.scrollWidth = window.innerWidth - document.documentElement.clientWidth;

			_.options = $.extend(_, settings);

			_.init();
		}
		return SwitchPopup;
	}());

	SwitchPopup.prototype.open = function() {
		var _ = this;
		_.state = 'opening';
		_.$popup.trigger('beforeOpen', [_.$popup]);
		_.$popup.trigger('beforeChange', [_.$popup, 'open']);
		_.$popup.addClass(_.displayClass);
		setTimeout(function () {
			_.$popup.addClass(_.visibleClass);
		}, 1);
		setTimeout(function() {
			_.state = 'open';
			_.$popup.trigger('afterOpen', [_.$popup]);
			_.$popup.trigger('afterChange', [_.$popup, 'open']);
		}, _.duration);
		if(_.overflow) {
			$('html').css({
				'padding-right': _.scrollWidth,
				'overflow': 'hidden'
			});
		}
	}

	SwitchPopup.prototype.close = function() {
		var _ = this;
		_.state = 'closing';
		_.$popup.trigger('beforeClose', [_.$popup]);
		_.$popup.trigger('beforeChange', [_.$popup, 'close']);
		_.$popup.removeClass(_.visibleClass);
		setTimeout(function () {
			_.$popup.removeClass(_.displayClass);
			_.state = 'close';
			_.$popup.trigger('afterClose', [_.$popup]);
			_.$popup.trigger('afterChange', [_.$popup, 'close']);
			if(_.overflow) {
				$('html').css({
					'padding-right': 0,
					'overflow': 'auto'
				});
			}
		}, _.duration);
	}

	SwitchPopup.prototype.toggle = function() {
		var _ = this;
		if (_.$popup.hasClass(_.displayClass)) {
			_.close();
		} else {
			_.open();
		}
	}

	SwitchPopup.prototype.getState = function() {
		var _ = this;
		return _.state;
	}

	SwitchPopup.prototype.init = function() {
		var _ = this;
		if(_.$popup.length) {
			if( !_.btnClass.length ) return;
			$(document).on('click', '.'+_.btnClass, function() {
				_.toggle();
			});
		}
		_.$popup.trigger('init', [_.$popup]);
	}

	$.fn.switchPopup = function() {
		var _ = this,
				opt = arguments[0],
				args = Array.prototype.slice.call(arguments, 1),
				l = _.length,
				i,
				ret;

		for (i = 0; i < l; i++) {
			if (typeof opt == 'object' || typeof opt == 'undefined') {
				_[i].switchPopup = new SwitchPopup(_[i], opt);
			} else {
				ret = _[i].switchPopup[opt].apply(_[i].switchPopup, args);
			}
			if (typeof ret != 'undefined') return ret;
		}
		return _;
	};
})(jQuery);
