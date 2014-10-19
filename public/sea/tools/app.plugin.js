+ function ($) { 
	"use strict";
  	$(function(){
  		Date.now = Date.now || function() { return +new Date; };
		// sparkline	线状图
		var sparkline = function($re){
			$(".sparkline").each(function(){
				var $data = $(this).data();
				if($re && !$data.resize) return;
				($data.type == 'pie') && $data.sliceColors && ($data.sliceColors = eval($data.sliceColors));
				($data.type == 'bar') && $data.stackedBarColor && ($data.stackedBarColor = eval($data.stackedBarColor));
				$data.valueSpots = {'0:': $data.spotColor};
				$(this).sparkline('html', $data);
			});
		};
		var sr = '';
		$(window).resize(function(e) {
			clearTimeout(sr);
			sr = setTimeout(function(){sparkline(true);}, 500);
		});
		sparkline(false);
		// easypie		饼状图
		var easypie = function(){
			$('.easypiechart').each(function(){
				var $this = $(this), 
				$data = $this.data(), 
				$step = $this.find('.step'), 
				$target_value = parseInt($($data.target).text()),
				$value = 0;
				$data.barColor || ( $data.barColor = function($percent) {
			        $percent /= 100;
			        return "rgb(" + Math.round(200 * $percent) + ", 200, " + Math.round(200 * (1 - $percent)) + ")";
			    });
				$data.onStep =  function(value){
					$value = value;
					$step.text(parseInt(value));
					$data.target && $($data.target).text(parseInt(value) + $target_value);
				};
				$data.onStop =  function(){
					$target_value = parseInt($($data.target).text());
					$data.update && setTimeout(function() {
				        $this.data('easyPieChart').update(100 - $value);
				    }, $data.update);
				};
				$(this).easyPieChart($data);
			});
		};
		easypie();
		// datepicker	日期选择
		$(".datepicker-input").each(function(){ $(this).datepicker();});
		// dropfile		文件拖拽上传
		$('.dropfile').each(function(){
			var $dropbox = $(this);
			if (typeof window.FileReader === 'undefined') {
				$('small',this).html('File API & FileReader API not supported').addClass('text-danger');
				return;
			}

			this.ondragover = function () {$dropbox.addClass('hover'); return false; };
			this.ondragend = function () {$dropbox.removeClass('hover'); return false; };
			this.ondrop = function (e) {
				e.preventDefault();
				$dropbox.removeClass('hover').html('');
				var file = e.dataTransfer.files[0], reader = new FileReader();
				reader.onload = function (event) {
					$dropbox.append($('<img>').attr('src', event.target.result));
				};
				reader.readAsDataURL(file);
				return false;
			};
		});
		// slider		滑动条
		$('.slider').each(function(){ $(this).slider(); });
		// sortable		拖动排序
		if ($.fn.sortable) { $('.sortable').sortable(); };
		// slim-scroll	自定义滚动条
		$('.no-touch .slim-scroll').each(function(){
			var $self = $(this), $data = $self.data(), $slimResize;
			$self.slimScroll($data);
			$(window).resize(function(e) {
				clearTimeout($slimResize);
				$slimResize = setTimeout(function(){ $self.slimScroll($data);}, 500);
			});
		    $(document).on('updateNav', function(){
		    	$self.slimScroll($data);
		    });
		});
		// portlet		可排序窗口
		$('.portlet').each(function(){
			$(".portlet").sortable({
		        connectWith: '.portlet',
	            iframeFix: false,
	            items: '.portlet-item',
	            opacity: 0.8,
	            helper: 'original',
	            revert: true,
	            forceHelperSize: true,
	            placeholder: 'sortable-box-placeholder round-all',
	            forcePlaceholderSize: true,
	            tolerance: 'pointer'
		    });
	    });
		// docs
		$('#docs pre code').each(function(){
		    var $this = $(this);
		    var t = $this.html();
		    $this.html(t.replace(/</g, '&lt;').replace(/>/g, '&gt;'));
		});
		// table select/deselect all	
		$(document).on('change', 'table thead [type="checkbox"]', function(e){
			e && e.preventDefault();
			var $table = $(e.target).closest('table'), $checked = $(e.target).is(':checked');
			$('tbody [type="checkbox"]',$table).prop('checked', $checked);
		});
		// random progress	进度条
		$(document).on('click', '[data-toggle^="progress"]', function(e){
			e && e.preventDefault();
			var $el = $(e.target),
			$target = $($el.data('target'));
			$('.progress', $target).each(function(){
				var $max = 50, $data, $ps = $('.progress-bar',this).last();
				($(this).hasClass('progress-xs') || $(this).hasClass('progress-sm')) && ($max = 100);
				$data = Math.floor(Math.random()*$max)+'%';
				$ps.css('width', $data).attr('data-original-title', $data);
			});
		});
		// add notes
		function addMsg($msg){
			var $el = $('.nav-user'), $n = $('.count:first', $el), $v = parseInt($n.text());
			$('.count', $el).fadeOut().fadeIn().text($v+1);
			$($msg).hide().prependTo($el.find('.list-group')).slideDown().css('display','block');
		}
		typeof msg != 'undefined' && addMsg(msg);
		//chosen	自定义select
		$(".chosen-select").length && $(".chosen-select").chosen();
		
		//----------------------2-----------------------
		// toogle fullscreen
	    $(document).on('click', "[data-toggle=fullscreen]", function(e){
	    	e.preventDefault();
	    	if (screenfull.enabled) {
	    		screenfull.request();
	    	}
	    });
	  	// placeholder
	  	$('input[placeholder], textarea[placeholder]').placeholder();
	    // popover 弹出框
	    $("[data-toggle=popover]").popover();
	    $(document).on('click', '.popover-title .close', function(e){
	    	var $target = $(e.target), $popover = $target.closest('.popover').prev();
	    	$popover && $popover.popover('hide');
	    });
	    // ajax modal
	    $(document).on('click', '[data-toggle="ajaxModal"]', function(e) {
	        $('#ajaxModal').remove();
	        e.preventDefault();
	        var $this = $(this), $remote = $this.data('remote') || $this.attr('href'), $modal = $('<div class="modal fade" id="ajaxModal"><div class="modal-body"></div></div>');
	        $('body').append($modal);
	        $modal.modal();
	        $modal.load($remote);
	  	});
	    // dropdown menu
		$.fn.dropdown.Constructor.prototype.change = function(e){
			e.preventDefault();
			var $item = $(e.target), $select, $checked = false, $menu, $label;
			!$item.is('a') && ($item = $item.closest('a'));
			$menu = $item.closest('.dropdown-menu');
			$label = $menu.parent().find('.dropdown-label');
			$labelHolder = $label.text();
			$select = $item.find('input');
			$checked = $select.is(':checked');
			if($select.is(':disabled')) return;
			if($select.attr('type') == 'radio' && $checked) return;
			if($select.attr('type') == 'radio') $menu.find('li').removeClass('active');
			$item.parent().removeClass('active');
			!$checked && $item.parent().addClass('active');
			$select.prop("checked", !$select.prop("checked"));
			
			$items = $menu.find('li > a > input:checked');
			if ($items.length) {
				$text = [];
				$items.each(function () {
					var $str = $(this).parent().text();
					$str && $text.push($.trim($str));
				});
	
				$text = $text.length < 4 ? $text.join(', ') : $text.length + ' selected';
		        $label.html($text);
			}else{
				$label.html($label.data('placeholder'));
			};
	    };
	    $(document).on('click.dropdown-menu', '.dropdown-select > li > a', $.fn.dropdown.Constructor.prototype.change);
	  	// tooltip
	    $("[data-toggle=tooltip]").tooltip();
	    // class
	  	$(document).on('click', '[data-toggle^="class"]', function(e){
	  		e && e.preventDefault();
	  		var $this = $(e.target), $class , $target, $tmp, $classes = '', $targets;
	  		!$this.data('toggle') && ($this = $this.closest('[data-toggle^="class"]'));
	    	$class = $this.data()['toggle'];
	    	$target = $this.data('target') || $this.attr('href');
	        $class && ($tmp = $class.split(':')[1]) && ($classes = $tmp.split(','));
	        $target && ($targets = $target.split(','));
	        $classes && $classes.length && $.each($targets, function( index, value ) {
		        if ( $classes[index].indexOf( '*' ) !== -1 ) {
		        	var patt = new RegExp( '\\s' + $classes[index].replace( /\*/g, '[A-Za-z0-9-_]+' ).split( ' ' ).join( '\\s|\\s' ) + '\\s', 'g' );
		        	$($this).each( function ( i, it ) {
			            var cn = ' ' + it.className + ' ';
			            while ( patt.test( cn ) ) {
			            	cn = cn.replace( patt, ' ' );
			            }
			            it.className = $.trim( cn );
		        	});
		        };
		        ($targets[index] !='#') && $($targets[index]).toggleClass($classes[index]) || $this.toggleClass($classes[index]);
	        });
	    	$this.toggleClass('active');
	  	});
	    // panel toggle
	    $(document).on('click', '.panel-toggle', function(e){
	    	e && e.preventDefault();
	    	var $this = $(e.target), $class = 'collapse' , $target;
	    	if (!$this.is('a')) $this = $this.closest('a');
	    	$target = $this.closest('.panel');
	        $target.find('.panel-body').toggleClass($class);
	        $this.toggleClass('active');
	    });
	  	// carousel
	  	$('.carousel.auto').carousel();
	  	// button loading
	  	$(document).on('click.button.data-api', '[data-loading-text]', function (e) {
	  	    var $this = $(e.target);
	  	    $this.is('i') && ($this = $this.parent());
	  	    $this.button('loading');
	  	});
	 	
	    var $window = $(window);
	    // mobile
	  	var mobile = function(option){
	  		if(option == 'reset'){
	  			$('[data-toggle^="shift"]').shift('reset');
	  			return true;
	  		}
	  		$('[data-toggle^="shift"]').shift('init');
	  		return true;
	  	};
	  	// unmobile
	  	$window.width() < 768 && mobile();
	    // resize
	    var $resize = '';
	  	$window.resize(function() {
	  		clearTimeout($resize);
	  		$resize = setTimeout(function(){
		        setHeight(); $window.width() < 767 && mobile(); $window.width() >= 768 && mobile('reset') && fixVbox();
	  		}, 500);
	  	});
	    // fluid layout
	    var setHeight = function(){
	    	$('.app-fluid #nav > *').css('min-height', $(window).height()-60);
	    	return true;
	    };
	    setHeight();
	    // fix vbox
	    var fixVbox = function(){
	    	$('.ie11 .vbox').each(function(){
	    		$(this).height($(this).parent().height());
	    	});
	    	return true;
	    };
	    fixVbox();
	    // collapse nav
	    $(document).on('click', '[data-ride="collapse"] a', function (e) {
	    	console.log('as');
	    	var $this = $(e.target), $active;      
	        $this.is('a') || ($this = $this.closest('a'));
	      
	        $active = $this.parent().siblings( ".active" );
	        $active && $active.toggleClass('active').find('> ul:visible').slideUp(200);
	      
	        ($this.parent().hasClass('active') && $this.next().slideUp(200)) || $this.next().slideDown(200);
	        $this.parent().toggleClass('active');
	      
	        $this.next().is('ul') && e.preventDefault();
	        setTimeout(function(){ $(document).trigger('updateNav'); }, 300);      
	    });
	    // dropdown still
	    $(document).on('click.bs.dropdown.data-api', '.dropdown .on, .dropup .on, .open .on', function (e) { e.stopPropagation(); });
	    
	    $('table a[editable]').editable({
	    	placement : 'right',
	    	params : function(params){
	    		params.keyname = params.name;
	    		delete params.name;
	    		return params;
	    	}
	    });
  	});
}(window.jQuery);