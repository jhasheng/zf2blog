+function($) {
	"use strict";
	var Validator = function(form, options) {
		this.$form = $(form);
		this.options = options;
		this.$element = [];
		this.init();
	};

	Validator.DEFUALTS = {
		url : '',
		tagName : 'input,select,textarea',
		elementType : 'submit,reset',
		errorTemplate : '<span class="help-block m-b-none"></span>',
		enableCallback : true,
		errorBreak : true,
	};
	/**
	 * 初始化验证对象
	 * 1、将form里的表单元素过滤并存储起来
	 * 2、验证元素值的合法性
	 * 3、是否启用ajax回调
	 * @returns {Boolean}
	 */
	Validator.prototype.init = function() {
		var that = this;
		$(':input', that.$form).each(function(index, item){
			if($(item).attr('name') && $.inArray($(item).attr('type'), that.options.elementType.split(','))){
				if($.inArray($(item).get(0).tagName.toUpperCase(), that.options.tagName.split(','))){
					that.$element[$(item).attr('name')] = $(item).parent();
				}
			}
		});
		
		if(this.check(this.$element)){
			this.callback(this.options.enableCallback);
		}else{
			this.response(that.$element[0], 'NG');
		}
	};
	
	Validator.prototype.callback = function(enable) {
		var that = this;
		var settings = {
			data : new FormData(this.$form.get(0)),
			dataType : 'json',
			type : 'POST',
			processData : false,
			contentType : false,
			success : function (data, status) {
				if(status == 'success'){
					if(!data.status && enable){
						for(var k in data.info){
							that.response(that.$element[k], data.info[k].isEmpty);
						}
//						console.log(data.info);
					}
				}
			}
		};
		$.ajax(this.options.url, settings);
	};
	
	Validator.prototype.reset = function() {
		
	};
	
	Validator.prototype.response = function(element, message){
		var oError = $(this.options.errorTemplate).text(message);
		element.append(oError).addClass('has-error');
	};
	
	Validator.prototype.check = function($element) {
		return true;
	};
	
	$.fn.validator = function(option) {
		return this.each(function() {
			var options = $.extend({}, Validator.DEFUALTS, {
				url : "",
			});
			new Validator(this, options);
		});
	};
	
	$.fn.validator.Constructor = Validator;
	
}(jQuery);