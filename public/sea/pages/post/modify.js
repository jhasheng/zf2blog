/**
 * 
 */
var requireMod = ["validate","validator/extends/notEmpty","validator/extends/different"];
define(requireMod, function(require) {
	$('form').bootstrapValidator({
		message: 'This value is not valid',
		feedbackIcons: {
			valid: 'fa fa-check',
			invalid: 'fa fa-times',
			validating: 'fa fa-refresh',
		},
//		fields: {
//			title: {
//                message: 'The title is not valid',
//                validators: {
//                    notEmpty: {
//                        message: 'The title is required and can\'t be empty'
//                    }
//                }
//            },
//		}
	}).on('success.form.bv', function(e){
		e.preventDefault();
		var $form = $(e.target);
		var $bv = $form.data('bootstrapValidator');
		$.post($form.attr('action'), $form.serialize(), function(result) {
			console.log(result);
		}, 'json');
	});
});