/**
 * 
 */
define(["validator"], function(require) {

	var $title = $('input[name=title]').val();
	var $keywords = $('input[name=keywords]').val();
	var $description = $('input[name=description]').val();
	var $text = $('input[textarea=text]').val();
	var $catid = $('select[name=catid]').val();
	var $published = $('select[name=published]').val();

	var url = "";
	var data_main = {
		title : $title,
		keywords : $keywords,
		description : $description,
		text : $text,
	};

	var data_public = {
		published : $published
	};

	var data_category = {
		catid : $catid
	};

	var data_tags = {

	};

	var settings = {
		type : 'POST',
		dataType : 'json',
		processData : false,
		contentType : false,
		success : function(data, status) {
			if (status == 'success' && !data.status) {
			}
		}
	};

	$('form').submit(function() {
		$(this).validator();
//		settings.data = new FormData($(this).get(0));
//		$.ajax(url, settings);
		return false;
	});
});