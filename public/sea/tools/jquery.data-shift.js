// data-shift api 
+function($) {
	"use strict";

	/*
	 * SHIFT CLASS DEFINITION ======================
	 */

	var Shift = function(element) {
		this.$element = $(element), this.$prev = this.$element.prev(),
				!this.$prev.length && (this.$parent = this.$element.parent());
	};

	Shift.prototype = {
		constructor : Shift,
		init : function() {
			var $el = this.$element, method = $el.data()['toggle'].split(':')[1], $target = $el
					.data('target');
			$el.hasClass('in') || $el[method]($target).addClass('in');
		},
		reset : function() {
			this.$parent && this.$parent['prepend'](this.$element);
			!this.$parent && this.$element['insertAfter'](this.$prev);
			this.$element.removeClass('in');
		}
	};

	/*
	 * SHIFT PLUGIN DEFINITION =======================
	 */

	$.fn.shift = function(option) {
		return this.each(function() {
			var $this = $(this), data = $this.data('shift');
			if (!data)
				$this.data('shift', (data = new Shift(this)));
			if (typeof option == 'string')
				data[option]();
		});
	};
	$.fn.shift.Constructor = Shift;
}(jQuery);