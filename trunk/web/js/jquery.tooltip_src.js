jQuery.extend({
	tooltip:function(s){
		var mainElement=$('#'+s.mainElement);
		var tipElement=$('#'+s.tipElement);
		var width=s.width? s.width : 200;
		var top=s.top? s.top : 10;
		var left=s.left? s.left : 15;
		
		tipElement.css('width', width);
		mainElement.bind('mouseover', function(e){
			x=e.pageX || event.clientX;
			y=e.pageY || event.clientY;
			tipElement.css('top', (y-top<0? y+top : y-top));
			tipElement.css('left', x+left);
			tipElement.fadeIn('fast');
		});
		mainElement.bind('mouseout', function(){
			tipElement.fadeOut('fast');
		});		
		mainElement.bind('mousemove', function(e){
			x=e.pageX || event.clientX;
			y=e.pageY || event.clientY;
			tipElement.css('top', (y-top<0? y+top : y-top));
			tipElement.css('left', x+left);
		});
	}
});