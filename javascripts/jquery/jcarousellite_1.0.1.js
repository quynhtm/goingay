Bm.scrollAutoPlz = function(config){
	var total = jQuery(config.class_list+' > li').get().length;
	if(config.visible < total){
		var first = jQuery(config.class_list+' > li:first');
        var key   = 'auto_scroll'+Math.random();
		//innit
        Bm._store.variable[key] = {
                width: 0,
                height:0,
                total: 0,
                class_list: '',
                btnNext: '',
                btnPrev: '',
                scroll : 1,
                visible: 1
        };
		for (var p in config){
			Bm._store.variable[key][p] = config[p];
		}
		Bm._store.variable[key].total = total;
		//get width
		Bm._store.variable[key].width = first.width() + Bm.getDimension(first.css("margin-left")) + Bm.getDimension(first.css("margin-right"));
		//get height
		Bm._store.variable[key].height = first.height() + Bm.getDimension(first.css("margin-top")) + Bm.getDimension(first.css("margin-bottom"));
		//set width + height
		var w = parseInt(Bm._store.variable[key].width)*parseInt(Bm._store.variable[key].visible);
		jQuery(config.class_list).css({width:w+'px',height:Bm._store.variable[key].height+'px',overflow:'hidden'});
		//config button
		jQuery(config.btnNext).attr("href","javascript:void(0)").click(function(){
			Bm.scrollAuto('right',key);
		});
		jQuery(config.btnPrev).attr("href","javascript:void(0)").click(function(){
			Bm.scrollAuto('left',key);
		});
	}
};
Bm.getDimension = function(need){
	if(need){return parseInt(need.replace('px',''));}
	return 0;
};
Bm.scrollAuto = function(direct,key){
	var cl = Bm._store.variable[key].class_list;
	if(direct == 'right'){
		jQuery(cl).append(jQuery(cl+' > li:first'));
	}else{
		jQuery(cl).prepend(jQuery(cl+' > li:last'));
	}
};