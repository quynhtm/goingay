function JT_init(input){
  var parent = (input == null) ? 'a.jTip' : input+'.jTip';
  jQuery(parent).hover(
	   function(){
	   		JT_show(jQuery('span.content' + this.id).html(), parseInt(jQuery('.JT_width'+ this.id).val()));
	   },
	   function(){  
	   		jQuery('#JT').remove();
	   }
	);
  	jQuery(parent).mousemove(function(e){
		var jt_height = jQuery('#JT').height();
		var jt_width  = jQuery('#JT').width();
		var ox = e.pageX + 15;
  		var oy = e.pageY - 5;
		var border = (navigator.appName == 'Microsoft Internet Explorer') ? 25 : 1;
		var bpl= "left";
		var bpt= "10px";
		var pad= "0 0 0 17px";
  		var max_x  = jQuery(document).width() - border;
		if (self.innerHeight) { // Everyone but IE
			max_y  = window.pageYOffset + jQuery(window).height() - border;
		} else if (document.documentElement && document.documentElement.clientHeight) { // IE6 Strict
			max_y  = document.documentElement.scrollTop + jQuery(window).height() - border;
		} else if (document.body) { // Other IE, such as IE7
			max_y  = document.body.scrollTop + jQuery(window).height() - border;
		}
  		if((e.pageX + 35 + jt_width) >= max_x){
		  ox = e.pageX - jt_width - 20;
		  pad= "0 17px 0 0";
		  bpl= 'right';
		}
  		if((e.pageY + 25 + jt_height) > max_y){
		  oy = e.pageY - jt_height;
		  bpt= "bottom";
		}
  		jQuery('#JT').css({left: ox+"px", top: oy+"px", backgroundPosition:bpl+' '+bpt, padding:pad});
	});
}
function JT_show(content,width){
	width = (width <= 0) ? 'auto' : width+'px';
	jQuery("body").append("<div id='JT'><div id='JT_copy' style='width:"+width+"'><div id='JT_title'></div></div></div>");
	jQuery('#JT_copy').html(content);
	jQuery('#JT').show();
}
/**
 * QuynhTM hien thi thong tin cua san pham lien quan
 */
function JT_image(input){
	  var parent = (input == null) ? 'a.jTip' : input+'.jTip';
	  
	  jQuery(parent).hover(
		   function(){
		   		JT_show(jQuery(('span.content' + this.id)).html(),200);
		   },
		   function(){  
		   		jQuery('#JT').remove();
		   }
		);
	  	jQuery(parent).mousemove(function(e){
			var jt_height = jQuery('#JT').height();
			var jt_width  = jQuery('#JT').width();
			var ox = e.pageX + 15;
	  		var oy = e.pageY - 5;
			var border = (navigator.appName == 'Microsoft Internet Explorer') ? 25 : 1;
			var bpl= "left";
			var bpt= "10px";
			var pad= "0 0 0 17px";
	  		var max_x  = jQuery(document).width() - border;
			if (self.innerHeight) { // Everyone but IE
				max_y  = window.pageYOffset + jQuery(window).height() - border;
			} else if (document.documentElement && document.documentElement.clientHeight) { // IE6 Strict
				max_y  = document.documentElement.scrollTop + jQuery(window).height() - border;
			} else if (document.body) { // Other IE, such as IE7
				max_y  = document.body.scrollTop + jQuery(window).height() - border;
			}
	  		if((e.pageX + 35 + jt_width) >= max_x){
			  ox = e.pageX - jt_width - 20;
			  pad= "0 17px 0 0";
			  bpl= 'right';
			}
	  		if((e.pageY + 25 + jt_height) > max_y){
			  oy = e.pageY - jt_height;
			  bpt= "bottom";
			}
	  		jQuery('#JT').css({left: ox+"px", top: oy+"px", backgroundPosition:bpl+' '+bpt, padding:pad});
		});
	}
/**
 * TuanTQ add
 */
function JT_admin(input){
	  var parent = (input == null) ? 'a.jTip' : input+'.jTip';
	  
	  jQuery(parent).hover(
		   function(){
		   		JT_show("<div class='tooltip_icon'></div>"+jQuery(('div.content' + this.id)).html(),600);
		   },
		   function(){  
		   		jQuery('#JT').remove();
		   }
		);
	  	jQuery(parent).mousemove(function(e){
			var jt_height = jQuery('#JT').height();
			var jt_width  = jQuery('#JT').width();
			var ox = e.pageX + 15;
	  		var oy = e.pageY - 5;
			var border = (navigator.appName == 'Microsoft Internet Explorer') ? 25 : 1;
			var bpl= "left";
			var bpt= "10px";
			var pad= "0 0 0 17px";
	  		var max_x  = jQuery(document).width() - border;
			if (self.innerHeight) { // Everyone but IE
				max_y  = window.pageYOffset + jQuery(window).height() - border;
			} else if (document.documentElement && document.documentElement.clientHeight) { // IE6 Strict
				max_y  = document.documentElement.scrollTop + jQuery(window).height() - border;
			} else if (document.body) { // Other IE, such as IE7
				max_y  = document.body.scrollTop + jQuery(window).height() - border;
			}
	  		if((e.pageX + 35 + jt_width) >= max_x){
			  ox = e.pageX - jt_width - 20;			  
			  pad= "0 17px 0 0";
			  bpl= 'right';
			  jQuery(".tooltip_icon").hide();
			}
	  		if((e.pageY + 25 + jt_height) > max_y){
	  		  if((e.pageY-window.pageYOffset)<jt_height){
	  		  	if(jQuery(window).height()>jt_height){
	  		  		oy=window.pageYOffset+(jQuery(window).height()-jt_height)/2;
	  		  	}else{
	  		  		oy=window.pageYOffset+10;
	  		  	}
	  		  }	 
			  //oy = e.pageY -jQuery(window).height()+ jt_height;
			  bpt= "bottom";
			}
			jQuery('.tooltip_icon').css({left: "3px", top: (e.pageY-oy-2*border)+"px"});					
	  		jQuery('#JT').css({left: ox+"px", top: oy+"px", backgroundPosition:bpl+' '+bpt, padding:pad});
		});
	}
	