// data-bjax api 
+ function($) {
	"use strict";
	var Bjax = function(element, options) {
		this.options = options, this.$element = $(element), this.start();
	};

	Bjax.DEFAULTS = {
		backdrop : true,
		url : '',
		completeTime : 500
	};

	Bjax.prototype.start = function() {
		var that = this;
//		this.backdrop();
		$.ajax(this.options.url).done(function(r) {
			that.backdrop();
			that.$content = r;
			that.complete();
		}).fail(function(e){
			that.alert(e.responseText);
//			window.location.reload();
    	});
	};
	
	Bjax.prototype.alert = function(errMsg) {
		var errMsgObj = $.parseJSON(errMsg);
		var html =  '<div class="modal fade" id="bjax-modal"><div class="modal-dialog"><div class="modal-content">' + 
					'<div class="modal-body wrapper-lg"><div class="row"><div class="col-sm-12">' + 
					'<h4 class="text-danger">' + errMsgObj.error.message + '</h4>' +
					'<pre style="height:200px"><code>' + errMsgObj.error.trace + '</code></pre>' +
					'</div></div></div></div></div></div>';
		console.log('error');
		$('body').append(html);
		$('#bjax-modal').modal('show').on('hidden.bs.modal',function(e){ window.location.reload();});
	};

	Bjax.prototype.complete = function() {
		var that = this;
		try {
			window.history.pushState({}, '', that.options.url);
		} catch (e) {
			window.location.replace(that.options.url);
		}
		this.updateBar(100);
	};

	Bjax.prototype.backdrop = function() {
		this.$element.css('position', 'relative');
		this.$backdrop = $('<div class="backdrop fade"></div>').appendTo(this.$element);
		this.$backdrop[0].offsetWidth; // force reflow
		this.$backdrop.addClass('in');
		this.$bar = $('<div class="bar b-t b-info"></div>').width(0).appendTo(this.$backdrop);
	};

	Bjax.prototype.update = function() {
		!this.$element.is('html') && this.$element.html(this.$content);
		if (this.$element.is('html')) {
			document.open();
			document.write(this.$content);
			document.close();
		}
	};

	Bjax.prototype.updateBar = function(per) {
		var that = this;
		this.$bar.stop().animate({width : per + '%'}, this.options.completeTime, 'linear', function() {
			if (per == 100) that.update();
		});
	};

	Bjax.prototype.enable = function(e) {
		var link = e.currentTarget;
		if (location.protocol !== link.protocol || location.hostname !== link.hostname) return false;
		if (link.hash && link.href.replace(link.hash, '') === location.href.replace( location.hash, '')) return false;
		if (link.href === location.href + '#' || link.href === location.href) return false;
		return true;
	};

	$.fn.bjax = function(option) {
		return this.each(function() {
			var $this = $(this);
			var data = $this.data('app.bjax');
			var options = $.extend({}, Bjax.DEFAULTS, $this.data(), typeof option == 'object' && option);

			if (!data) $this.data('app.bjax', (data = new Bjax(this, options)));
			if (typeof option == 'string') data[option]();
		});
	};

	$.fn.bjax.Constructor = Bjax;

	$(window).on("popstate", function(e) {
		if (e.originalEvent.state !== null) {
			window.location.reload(true);
		}
		e.preventDefault();
	});

	$(document).on('click.app.bjax.data-api', '[data-bjax], .nav-primary a', function(e) {
		console.log('click');
		if (!Bjax.prototype.enable(e)) return;
		var $this = $(this);
		var $url = $this.attr('href');
		var $target = $($this.attr('data-target') || 'html');
		var option = $.extend({url : $url}, $target.data(), $this.data());
		$target.bjax(option);
		e.preventDefault();
	});
}(jQuery);