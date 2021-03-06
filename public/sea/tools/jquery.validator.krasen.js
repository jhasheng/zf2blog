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
		errorClass : 'has-error',
		successClass : 'has-success',
		notCheckElementNames : 'published',
		validatorFn : {
			//fn : function(name, value)
		}
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
							if($.inArray(k, that.options.notCheckElementNames.split(',')))
								that.response(k, data.info[k].isEmpty);
						}
					}
				}
			}
		};
		$.ajax(this.options.url, settings);
	};
	
	Validator.prototype.reset = function(elementName) {
		if(elementName){
			this.$element[elementName].removeClass(this.options.errorClass);
		}else{
			for(var ele in this.$element){
				if(this.$element[ele].hasClass(this.options.errorClass)){
					this.$element[ele].removeClass(this.options.errorClass);
				}
			}
		}
	};
	
	Validator.prototype.response = function(elementName, message){
		var errorBox = $(this.options.errorTemplate).text(message);
		if(this.$element[elementName]){
			this.$element[elementName].append(errorBox).addClass(this.options.errorClass);
		}else{
			$('*[name='+ elementName +']').parent().append(oError).addClass(this.options.errorClass);
		}
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