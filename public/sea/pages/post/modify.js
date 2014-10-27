/**
 * 
 */
define(["validate","validator/extends/notEmpty","validator/extends/different"], function(require) {
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
                    },
                    different: {
                        field: 'password',
                        message: 'The title and password can\'t be the same as each other'
                    }
                }
            },
		}
	});
});