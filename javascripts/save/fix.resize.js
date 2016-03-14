var FixResize={
	window:{
		width:function(){
			return (IS_BACK_END) ? jQuery(window).width() : ((jQuery(window).width() < 1024) ? jQuery(window).width() : 1024);
		},
		height:function(){
			return jQuery(window).height();
		}
	},
	/**
	 * function fix resize Width relative
	 */	
	fixWidthRelative : function(selItem,selContain,selRalative,sub) {
		jQuery(selItem).width(jQuery(selContain).width()-jQuery(selRalative).width()-sub);		
	},
	/**
	 * function fix layout for all site
	 */	
	fixLayout : function() {
		//full site
		jQuery('.wrap').width(this.window.width()-44); //tru padding
		if(jQuery('.wrap').width()<980){
			jQuery('.wrap').width(980);
		}
		
		//var temp_window = this.window.width(), margin_ = 22;
		
		//if(temp_window < 1024) {
			//margin_ = Math.round((temp_window - 980) / 2);
			//margin_ = (margin_ > 0) ? margin_ : 0;
		//}
		
		//jQuery('.wrap').css("margin-left",margin_ + "px");
		//jQuery('.wrap').css("margin-right",margin_ + "px");
		
		
		
		//Home
		this.fixWidthRelative('.main_left','.main_home','.main_right',20);
						
		//depart maytinh-dienthoai
		this.fixWidthRelative('.top_right','.main','.top_left',20);
		this.fixWidthRelative('.middle_left','.block_middle','.middle_right',10);
		
		jQuery('.block_middle .middle_right #depart_promotion').height(jQuery('.block_middle .middle_left').height());				

		//jQuery('.vcm-shopping-cart-wrap').css('right', (jQuery(window).width() > jQuery('.wrap').width()) ? ((jQuery(window).width() - jQuery('.wrap').width()) / 2) : 0);	
				
		this.fixWidthRelative('.ad_right','#container','.ad_left',0);				 		
		
	},
	/**
	 * function fix box auto resize
	 */
	 setDefaultAd : function(){
	 	jQuery('.ad_left').width(740);
		jQuery('.top_right .ad_left').width(660);
		this.fixWidthRelative('.ad_right','#container','.ad_left',0);
	 }, 
	/**
	 * function fix box auto resize
	 */	
	fixBox : function(widthItem,paddingLeftItem,paddingRightItem,selItem,selContain) {
		var widthItem=(widthItem)?parseInt(widthItem):jQuery(selItem).width();
		var widthContain=jQuery(selContain).width();					
		var count=-1;
		var widthRate=widthItem+parseInt(paddingLeftItem)+parseInt(paddingRightItem);		
		if(widthItem>0){
			count=Math.floor(widthContain/widthRate);
		}				
		if(count>0){
			var excessWidth=widthContain-(widthRate*count);		
			jQuery(selItem).css("width",Math.round(widthItem+(excessWidth/count)));
		}
		//alert(widthContain+"gsgs"+widthRate+"gsgs"+count+"gsgs"+Math.round(widthItem+(excessWidth/count)));
		return count;		
	},
	/**
	 * function fix box auto resize gallery
	 */	
	fixBoxGallery : function(widthItem,paddingLeftItem,paddingRightItem,selItem,selContain,widthEx,selRelative) {
		this.setDefaultAd();
		var widthItem=(widthItem)?parseInt(widthItem):jQuery(selItem).width();
		var widthContain=jQuery(selContain).width();					
		var count=-1;
		var widthRate=widthItem+parseInt(paddingLeftItem)+parseInt(paddingRightItem);		
		if(widthItem>0){
			count=Math.floor(widthContain/widthRate);
		}				
		if(count>=0){
			var excessWidth=widthContain-(widthRate*count);			
			if((((widthRate-excessWidth)<widthEx)&&(count<2))||(((widthRate-excessWidth)<(widthEx/2))&&(count>=2))){
				jQuery(selContain).width(widthContain+(widthRate-excessWidth));				
				jQuery(selRelative).width(jQuery(selRelative).width()-(widthRate-excessWidth));
				jQuery(selItem).css("width",widthItem);
			//	alert(jQuery(selRelative).width()+'  '+widthContain);
				count++;								
			}else{								
				jQuery(selItem).css("width",Math.round(widthItem+(excessWidth/count)));
			}
		}
		//alert(widthContain+"gsgs"+widthRate+"gsgs"+count+"gsgs"+Math.round(widthItem+(excessWidth/count)));
		return count;		
	}	
}

jQuery(function(){
	FixResize.fixLayout();
});

jQuery(window).resize(function() {
	FixResize.fixLayout();	
});
