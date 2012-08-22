jQuery(document).ready(function() {		
	run_footer();
});

window.onresize = function(event) {
	run_footer();
}

function run_footer(){
	var browser_dimension = detect_browser_dimension();
	var dimensions = browser_dimension.split(':');
	
	var height = dimensions[1];
	
	if(parseInt(height) < 550){
		$('div#sidebar-bottom').hide();
	}
	else{
		$('div#sidebar-bottom').show();
	}
}

function detect_browser_dimension(){
	var viewportwidth;
	var viewportheight;

	// the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight

	if (typeof window.innerWidth != 'undefined')
	{
		viewportwidth = window.innerWidth,
		viewportheight = window.innerHeight
	}

	// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)

	else if (typeof document.documentElement != 'undefined'
	&& typeof document.documentElement.clientWidth !=
	'undefined' && document.documentElement.clientWidth != 0)
	{
		viewportwidth = document.documentElement.clientWidth,
		viewportheight = document.documentElement.clientHeight
	}

	// older versions of IE

	else
	{
		viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
		viewportheight = document.getElementsByTagName('body')[0].clientHeight
	}
	
	var dimension = viewportwidth+':'+viewportheight;
	
	return dimension;
}