jQuery(document).ready(function($){
	SITE.menuHeadFixed();
	SITE.backTop();
});

SITE={
		menuHeadFixed:function(){
			var menuSite = jQuery('.line-head'),
				posMenu  = menuSite.offset();
			jQuery(window).scroll(function(){
				if(jQuery(this).scrollTop() >= 0.1){
					menuSite.addClass('line-head-fixed');
				}else if(jQuery(this).scrollTop() <= posMenu.top){
					menuSite.removeClass('line-head-fixed');
				}
			});
		},
		backTop:function(){
		 jQuery(window).scroll(function() {
	        if(jQuery(window).scrollTop() > 0) {
				jQuery("#back-top").fadeIn();
			} else {
				jQuery("#back-top").fadeOut();
			}
		});
		jQuery("#back-top").click(function(){
			jQuery("html, body").animate({scrollTop: 0}, 1000);
			return false;
		});
	},
}