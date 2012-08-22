/*

Background Slider v1.0

Copyright (C) urban0id - All rights reserved!

It's free to use for this template. For any other external use contact me via my site: http://www.theninjaofweb.com!

*/

jQuery.fn.bgSlider = function() {	
	//get arguments	
	var args = arguments[0] || {};    
	var fade_speed = args.speed;
	var pause = args.pause;

	var i = 0; //curr index
	var actr = 0;
	
	if(!fade_speed){fade_speed = 1500;}
	if(!pause){pause = 5000;}
	
	var this_div = jQuery(this);
	
	//get images
	
	var imgs = new Array();
	jQuery('img',this).each(function(){		
		imgs[actr] = jQuery(this).attr('src');		
		actr++;
	});
	
	

	//setting up 1st
			
	jQuery('img',this).remove();
	jQuery(this).append('<div id="bgslider-top"></div><div id="bgslider-bottom"></div>');
	jQuery('#bgslider-top').css({'opacity':'0'});
	if(imgs[0]){
		jQuery('#bgslider-bottom').css({'background-image':'url('+imgs[0]+')'});	
	}
	i++;
	if(!imgs[i]){i = 0;}
	if(imgs[i]){ 
		jQuery('#bgslider-top').css({'background-image':'url('+imgs[i]+')'});	
	}			
	
	
	
	//start rotating
	
	var change = function(){		
		
		
		jQuery('#bgslider-top').animate({'opacity':'1'},fade_speed,function(){
			//set bottom layer to current img
			jQuery('#bgslider-bottom').css({'background-image':'url('+imgs[i]+')'});
			
					//IE fix
					this_div.css({'background-image':'url('+imgs[i]+')'});
			
			
			//set top layer's bg image to the next one
			jQuery('#bgslider-top').css({'opacity':'0'});					
			

				
			i++;
			if(!imgs[i]){i = 0;}
			jQuery('#bgslider-top').css({'background-image':'url('+imgs[i]+')'});
		});		
				
		setTimeout(change,pause);
	};
	
	if(imgs.length > 1){
		var t=setTimeout(change,pause);	
	}
	
	
		
	
};