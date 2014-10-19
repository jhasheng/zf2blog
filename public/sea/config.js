/**
 * 
 */
var seaConfig = {
	base 	: "tools/",
	alias 	: {
		"jquery"						:	"jquery.min.js",
		"bootstrap"						:	'bootstrap.min.js',
		"placeholder"					:	"jquery.placeholder.min.js",
		"modernizr"						:	"jquery.modernizr.min.js",
		"screenfull"					:	"jquery.screenfull.min.js",
		"bjax"							:	"jquery.data-bjax.js",
		"shift"							:	"jquery.data-shift.js",
		"cookie"						:	"jquery.cookie.js",
		
		"slimscroll"					:	"slimscroll/jquery.slimscroll.min.js",
		"editable"						:	"editable/bootstrap-editable.js",
		
		"pie-chart"						:	"charts/easypiechart/jquery.easy-pie-chart.js",
		"sparkline"						:	"charts/sparkline/jquery.sparkline.min.js",
		"flot"							:	"charts/flot/jquery.flot.min.js",
		"tooltip"						:	"charts/flot/jquery.flot.tooltip.min.js",
		"spline"						:	"charts/flot/jquery.flot.spline.js",
		"pie"							:	"charts/flot/jquery.flot.pie.min.js",
		"resize"						:	"charts/flot/jquery.flot.resize.min.js",
		"grow"							:	"charts/flot/jquery.flot.grow.min.js",
		
		"flot_demo"						:	"charts/flot/demo.js",
		
		"calendar"						:	"formelement/calendar/bootstrap_calendar.js",
		"calendar_demo"					:	"formelement/calendar/demo.js",
		"chosen"						:	"formelement/chosen/chosen.jquery.min.js",
		
		"sortable"						:	"sortable/jquery.sortable.js",
		
		"init"							:	"app.plugin.js",
		
		"remember"						:	"init.js",
	},
	
	debug		: true,
	charset 	: "UTF-8",
	
	required	: ["jquery","bootstrap","placeholder","modernizr","screenfull","bjax","shift","cookie","slimscroll","editable","remember"],
};

seajs.config(seaConfig);

seajs.use(seaConfig.required);
