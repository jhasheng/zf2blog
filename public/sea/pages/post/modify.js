/**
 * 
 */
var requireMod = ["validate","validator:notEmpty","validator:different"];
define(requireMod, function(require) {
	$('form').bootstrapValidator({
		message: 'This value is not valid',
		feedbackIcons: {
			valid: 'fa fa-check',
			invalid: 'fa fa-times',
			validating: 'fa fa-refresh',
		},
		fields: {
			title: {
                message: 'The title is not valid',
                validators: {
                    notEmpty: {
                        message: 'The title is required and can\'t be empty'
                    }
                }
            },
            keywords: {
                message: 'The keywords is not valid',
                validators: {
                    notEmpty: {
                        message: 'The keywords is required and can\'t be empty'
                    }
                }
            },
            text: {
                message: 'The text is not valid',
                validators: {
                    notEmpty: {
                        message: 'The text is required and can\'t be empty'
                    }
                }
            }
		}
	}).on('success.form.bv', function(e){
		e.preventDefault();
		var $form = $(e.target);
		var $bv = $form.data('bootstrapValidator');
		$.post($form.attr('action'), $form.serialize(), function(result) {
			console.log(result);
		}, 'json');
	});
});