function open_popup(s){
	var settings=jQuery.extend({content:'',id:'',width:600,top:30}, s);

	//document width & height
	var dwidth = 0, dheight = 0;
	if( typeof( window.innerWidth ) == 'number' ) {
		//Non-IE
		dwidth = window.innerWidth;
		dheight = window.innerHeight;
	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
		dwidth = document.documentElement.clientWidth;
		dheight = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		//IE 4 compatible
		dwidth = document.body.clientWidth;
		dheight = document.body.clientHeight;
	}

	//document scroll top/left
	var scrollX = 0, scrollY = 0;
	if( typeof( window.pageYOffset ) == 'number' ) {
		//Netscape compliant
		scrollY = window.pageYOffset;
		scrollX = window.pageXOffset;
	} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
		//DOM compliant
		scrollY = document.body.scrollTop;
		scrollX = document.body.scrollLeft;
	} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
		//IE6 standards compliant mode
		scrollY = document.documentElement.scrollTop;
		scrollX = document.documentElement.scrollLeft;
	}

	pLeft=(dwidth-settings.width)/2;
	pLeft=(pLeft<0? 0 : pLeft)+scrollX;
	var popup='<div id=\"'+settings.id+'\"></div>';
	$('body').append(popup);
	$('div#'+settings.id)
		.addClass('popup')
		.css('width', settings.width)
		.css('top', scrollY+settings.top)
		.css('left', pLeft)
		.html(settings.content)
		.fadeIn('fast');
}

function close_popup(id){
	obj=id? $('#'+id) : $('.popup');
	obj.each(function(){
		$(this).fadeOut('fast', function(){$(this).remove();});
	});
}