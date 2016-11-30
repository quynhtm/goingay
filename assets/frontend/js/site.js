jQuery(document).ready(function($){
	SITE.menuFixed();
	SITE.backTop();
});

SITE={
		menuFixed:function(){
			//Head
			$(".line-head").sticky({topSpacing: 0, className:"line-head-fixed"});
			//Left
			$(".list-item-panel-icon").sticky({ topSpacing: 47, bottomSpacing: 200, className:"menu-left-fixed"});
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