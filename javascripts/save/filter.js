var choose;
jQuery(document).ready(function(){
	if(Bm.is_exists(aryCollapse))
	for(i in aryCollapse) {
		choose = false;
		/*QuynhTM dóng cho phần VCM
		 * jQuery("input:checkbox", "#source_fil_"+i).each(function(){
			if(this.checked) {
				choose = jQuery(this).parent().attr('stt');
			}
		});*/

		if(!choose) {
			jQuery("input:radio", "#source_fil_"+i).each(function(){
				if(this.checked) {
					choose = jQuery(this).parent().attr('stt');
				}
			});
		}

		if(!choose || choose < 10) { 
			jQuery("#source_fil_"+i).attr('style', 'height:175px');
		}
		else {
			aryCollapse[i] = -1;
			jQuery('#a_'+i).html('Thu lại >>');
		}
	}

	var aryFilter = jQuery.evalJSON(Bm.cookie.get('ckFilterLeft'));
		if(aryFilter) {
			for(var i=0 in aryFilter) {
				if(aryFilter[i][0]>0){
					if(aryFilter[i][1] == 0){
						jQuery('#source_fil_' + aryFilter[i][0]).hide();
						
						//if(Bm.is_exists(jQuery('#collapse_expand_' + aryFilter[i][0])))
						jQuery('#collapse_expand_' + aryFilter[i][0]).hide();
						
						jQuery('#link_' + aryFilter[i][0]).removeClass('minus');
						jQuery('#link_' + aryFilter[i][0]).addClass('plus');
					}else{
						jQuery('#source_fil_' + aryFilter[i][0]).show();
						
						//if(Bm.is_exists(jQuery('#collapse_expand_' + aryFilter[i][0])))
	
						jQuery('#collapse_expand_' + aryFilter[i][0]).show();
						jQuery('#link_' + aryFilter[i][0]).removeClass('plus');
						jQuery('#link_' + aryFilter[i][0]).addClass('minus');
						/*
						 * if(aryFilter[i][2] == 1) {
							jQuery('#short_filters_' + aryFilter[i][0]).hide();
							jQuery('#full_filters_' + aryFilter[i][0]).show();
						} else {
							jQuery('#short_filters_' + aryFilter[i][0]).show();
							jQuery('#full_filters_' + aryFilter[i][0]).hide();
						}
						 * */
					}
				}
			}
		}
});
	
	
	// remove filter tool tip
    jQuery(function () {
        jQuery('.bubbleInfo').each(function () {
            var distance = 10;
            var time = 25;
            var hideDelay = 25;

            var hideDelayTimer = null;

            var beingShown = false;
            var shown = false;
            var trigger = jQuery('.trigger', this);
            var info = jQuery('.popup', this).css('opacity', 0);


            jQuery([trigger.get(0), info.get(0)]).mouseover(function () {
                if (hideDelayTimer) clearTimeout(hideDelayTimer);
                if (beingShown || shown) {
                    // don't trigger the animation again
                    return;
                } else {
                    // reset position of info box
                    beingShown = true;

                    info.css({
                        top: -20,
                        left: -11,
                        display: 'block'
                    }).animate({
                        top: '-=' + distance + 'px',
                        opacity: 1
                    }, time, 'swing', function() {
                        beingShown = false;
                        shown = true;
                    });
                }

                return false;
            }).mouseout(function () {
                if (hideDelayTimer) clearTimeout(hideDelayTimer);
                hideDelayTimer = setTimeout(function () {
                    hideDelayTimer = null;
                    info.animate({
                        top: '-=' + distance + 'px',
                        opacity: 0
                    }, time, 'swing', function () {
                        shown = false;
                        info.css('display', 'none');
                    });

                }, hideDelay);

                return false;
            });
        });
    });
	
	
	
	
	function showhideFilters(sID,cate_id){
		if(sID != null && sID != '')
		{
			if(document.getElementById("source_fil_" + sID).style.display=="none"){
			    //document.getElementById("source_fil_" + sID).style.display="block";
			    jQuery('#source_fil_' + sID).show();
			    jQuery('#collapse_expand_' + sID).show();
			    jQuery('#link_' + sID).removeClass('plus');
			    jQuery('#link_' + sID).addClass('minus');
			    setCookieFilterLeft(sID, 1);
			}
			else{
			    //document.getElementById("source_fil_" + sID).style.display="none";
			    jQuery('#source_fil_' + sID).hide();
			    jQuery('#collapse_expand_' + sID).hide();
			    jQuery('#link_' + sID).removeClass('minus');
			    jQuery('#link_' + sID).addClass('plus');
			    setCookieFilterLeft(sID, 1);
			}
		}
	}
	
	
	function showHidePriceSearchFilter(id) {
		if(id > 0){
			if(document.getElementById("interval_price_fil_" + id).style.display == "none"){
			    jQuery('#interval_price_fil_' + id).show();
			    jQuery('#link_price_' + id).removeClass('plus');
			    jQuery('#link_price_' + id).addClass('minus');
			    //setCookieFilterLeft(sID, 1);
			}
			else{
			    jQuery('#interval_price_fil_' + id).hide();
			    jQuery('#link_price_' + id).removeClass('minus');
			    jQuery('#link_price_' + id).addClass('plus');
			    //setCookieFilterLeft(sID, 1);
			}
		}
	}
	
	
	function showFullFilters(sID){
		if(sID != null && sID != ''){
			jQuery('#short_filters_' + sID).hide();
			jQuery('#full_filters_' + sID).show();
			setCookieFilterLeft(sID);
		}
	}
	
	function showShortFilters(sID){
		if(sID != null && sID != ''){
			jQuery('#short_filters_' + sID).show();
			jQuery('#full_filters_' + sID).hide();
			setCookieFilterLeft(sID);
		}
	}
	
	//Mo: 1
	//Dong: 0
	function setCookieFilterLeft(sID, is_parent) {
		var aryCurrentData = new Array, aryCurrentId = 0;
		var aryFilter = jQuery.evalJSON(Bm.cookie.get('ckFilterLeft'));
		if(aryFilter) {
			for(var i=0 in aryFilter) {
				if(aryFilter[i][0] == sID) {
					aryCurrentData = aryFilter[i];
					aryCurrentId = i;
					break;
				}
			}
		}
		else {
			aryFilter = new Array;
		}
		
		if(aryCurrentId == 0) {
			aryCurrentData = new Array (sID, 1, 0);
		}
		
		
		if(is_parent) {
			aryCurrentData[1] = (document.getElementById("source_fil_" + sID).style.display=="none") ? 0 : 1;
		}
		else {
			aryCurrentData[2] = (document.getElementById("full_filters_" + sID).style.display=="none") ? 0 : 1;
		}
	
		if(aryCurrentId > 0) {
			aryFilter[aryCurrentId] = aryCurrentData;
		}
		else {
			aryFilter.push(aryCurrentData);
		}
	
		Bm.cookie.set('ckFilterLeft', jQuery.toJSON(aryFilter), 84600);
		
		//jQuery("body").append(prettyPrint(aryFilter));
		//	alert(aryFilter);
	}


	function build_url(id, obj, type, prefix, url_filter){
		var value = obj.value;
		type = parseInt(type, 10);
		var current_url = '';
		if(typeof(prefix) == 'undefined' ||  prefix == '') {
			prefix = 0;
		}
		else {
		     prefix = parseInt(prefix, 10);
		}
		if(typeof(url_filter) == 'undefined' ||  url_filter == '') {
			current_url = window.location.href;
		}
		else {
			current_url = url_filter;
		}
		if(current_url.match(/[^_]product_id=[^&^$]*/)) {
			current_url = current_url.replace(/product_id=[^&^$]*/, '');
		}
		
		if(!current_url.match(/.html\?/)) {
			current_url = current_url.replace(/.html/, '.html?');
		}
		var valCheck = value;
		value = rebuildParamsFilter(value);
		current_url = rebuildParamsFilter(current_url);
	
		if (current_url.match(id)){
			//Neu la check box
			if(type == 2){
				//TH Check
				if(obj.checked == true) {
					if(prefix == 1) {
						var patternFc = new RegExp('fc' + id + '=([^&]+)', 'i');
						if(current_url.match(patternFc)) {
							current_url = current_url.replace(patternFc , 'fc'+id+'=$1,'+value);
						}
						else {
							current_url = current_url+'&'+'fi'+id+'='+value;
						}
					}
					else {
						var patternFi = new RegExp('fi' + id + '=([^&]+)', 'i');
						if(current_url.match(patternFi)) {
							current_url = current_url.replace(patternFi , 'fi'+id+'=$1,'+value);
						}
						else {
							current_url = current_url+'&'+'fi'+id+'='+value;
						}
					}
					
					var patternPrice = new RegExp('price([^&]+)', 'i');
					if(valCheck.match(patternPrice)) {
						var patternFs = new RegExp('fs' + id + '=([^&]+)', 'i');
						if(current_url.match(patternFs)) {
							current_url = current_url.replace(patternFs , "");
						}
					}
				}
				else {
					remove_filter('', value, prefix);
					return;
				}
			}
			//Nguoc lai la radio box 
			else {
				if(prefix == 1) {
					var patternFc = new RegExp('fc' + id + '=([^&]+)', 'i');
					if(current_url.match(patternFc)) {
						current_url = current_url.replace( patternFc , 'fc'+id+'='+value);
					}
					else {
						current_url = current_url+'&'+'fc'+id+'='+value;
					}
				}
				else {
					var patternFi = new RegExp('fi' + id + '=([^&]+)', 'i');
					if(current_url.match(patternFi)) {
						current_url = current_url.replace( patternFi , 'fi'+id+'='+value);
					}
					else {
						current_url = current_url+'&'+'fi'+id+'='+value;
					}
				}
				var patternPrice = new RegExp('price([^&]+)', 'i');
				if(valCheck.match(patternPrice)) {
					var patternFs = new RegExp('fs' + id + '=([^&]+)', 'i');
					if(current_url.match(patternFs)) {
						current_url = current_url.replace(patternFs , "");
					}
				}
			}
		}
		else {
			current_url = (prefix == 1)  ? current_url+'&'+'fc'+id+'='+value : current_url+'&'+'fi'+id+'='+value;
		}
		current_url = unRebuildParamsFilter(current_url);
		if(current_url.match(/view_list=1/)) {
			current_url = current_url.replace( /view_list=1/g , '');
		}
		
		current_url = current_url.replace( /&&/ , '&');
		current_url = current_url.replace( /\?&/ , '\?');
		
		if(current_url.match(/page_no=(\d+)/)) {
			current_url = current_url.replace( /page_no=(\d+)/ , 'page_no=1');
		}
				
		location.href = current_url;
	}

	function remove_filter(title, value, prefix){
		if(typeof(prefix) == 'undefined' ||  prefix == '') {
			prefix = 0;
		}
		else {
		     prefix = parseInt(prefix, 10);
		}
		var current_url = window.location.href;
		current_url = decodeURIComponent(current_url.replace(/\+/g,  " "));

		if(current_url.match(/[^_]product_id=[^&^$]*/)) {
			current_url = current_url.replace(/product_id=[^&^$]*/, '');
		}
		
		value = rebuildParamsFilter(value);
		current_url = rebuildParamsFilter(current_url);

		if (current_url.match(value)){
			if(current_url.match(/page_no=(\d+)/)) {
				current_url = current_url.replace( /page_no=(\d+)/ , 'page_no=1');
			}
			if(prefix == 1) {
				var patern = new RegExp('[&]*fc[0-9]+=' + value +'([&])', 'i');
				current_url = current_url.replace(patern , '$1');
				
				var patern = new RegExp('[&]*fc[0-9]+=' + value +'$', 'i');
				current_url = current_url.replace(patern , '');
	
				var patern = new RegExp('([&]*fc[0-9]+=[^&]*),' + value +'([^&]*)', 'i');
				current_url = current_url.replace(patern , '$1$2');
				
				var patern = new RegExp('([&]*fc[0-9]+=[^&]*)' + value +',([^&]*)', 'i');
				current_url = current_url.replace(patern , '$1$2');
			}
			else {
				var patern = new RegExp('[&]*fi[0-9]+=' + value +'([&])', 'i');
				current_url = current_url.replace(patern , '$1');
				
				var patern = new RegExp('[&]*fi[0-9]+=' + value +'$', 'i');
				current_url = current_url.replace(patern , '');
	
				var patern = new RegExp('([&]*fi[0-9]+=[^&]*),' + value +'([^&]*)', 'i');
				current_url = current_url.replace(patern , '$1$2');
				
				var patern = new RegExp('([&]*fi[0-9]+=[^&]*)' + value +',([^&]*)', 'i');
				current_url = current_url.replace(patern , '$1$2');
			}
			if(!current_url.match(/fi[0-9]+/) && !current_url.match(/fs[0-9]+/)) {
				current_url += '&view_list=1';
			}
		}
		current_url = unRebuildParamsFilter(current_url);
		current_url = current_url.replace( /&&/ , '&');
		current_url = current_url.replace( /\?&/ , '\?');
		location.href = current_url;
	}
	
	
	function like_product(pID) {
		
		if(IS_LOGIN > 0){
			var product_id = pID;
			Bm.ajax_popup("act=so_like_products&code=like_product", "", {product_id:product_id}, function(res) {
			});
		}
		else{
			Bm.show_popup_message('Bạn cần đăng nhập để thực hiện chức năng này.', "Thông báo", -1);
		}
	}
	
	function rebuildParamsFilter(v) {
		v = v.replace(/ /g , '%20');
		v = v.replace(/\*/g , '_sao_');
		v = v.replace(/\[/g , '_moc_vuong_mo_');
		v = v.replace(/\]/g , '_moc_vuong_dong_');
		return v;
	}
	
	function unRebuildParamsFilter(v) {
		v = v.replace(/%20/g , ' ');
		v = v.replace(/_sao_/g , '*');
		v = v.replace(/_moc_vuong_mo_/g , '[');
		v = v.replace(/_moc_vuong_dong_/g , ']');
		return v;
	}
	
	/**
	 * Search theo khoang gia
	 *
	 * @author MinhNV
	 * Date 2010/10/12
	*/
	function searchIntervalPrice(id, type, url_filter) {
		var aryError = new Array();
		var min_price = jQuery.trim(jQuery('#min_price_search_' + id).val());
		var max_price = jQuery.trim(jQuery('#max_price_search_' + id).val());
		
		//Check kieu so
		if(min_price == '') {
			aryError.push("Bạn hãy nhập giá đầu");
		}
		
		else {
			if(isNaN(min_price)) {
				aryError.push("Giá đầu phải là số nguyên.Hãy nhập lại");
			}
		}
		//Check kieu so
		if(max_price == '') {
			aryError.push("Bạn hãy nhập giá cuối");
		}
		else {
			if(isNaN(max_price)) {
				aryError.push("Giá cuối phải là số nguyên.Hãy nhập lại");
			}
		}
		
		if((parseInt(min_price) < 0) || (parseInt(max_price) <= 0)){
			aryError.push("Bạn phải nhập giá lớn hơn 0");
		}
		else {
			if(parseInt(min_price) > parseInt(max_price)) {
				aryError.push("Bạn phải nhập giá đầu nhỏ hơn giá cuối.");
			}
		}
		
		if(aryError.length > 0) {
			var strError = aryError.join("<br/>");
			Bm.show_popup_message(strError, "Thông báo", -1);
			return false;
		}
		else {
			var current_url = '';
			if(typeof(url_filter) == 'undefined' ||  url_filter == '') {
				current_url = window.location.href;
			}
			else {
				current_url = url_filter;
			}
			current_url = decodeURIComponent(current_url.replace(/\+/g,  " "));
			var valReplace = "price:[" +  min_price + " TO " + max_price + "]";
			
			var pattern = new RegExp('fi' + id + '=price([^&]+)', 'i');
			if(current_url.match(pattern)) {
				current_url = current_url.replace(pattern , '');
			}
			
			var patternFc = new RegExp('fc' + id + '=price([^&]+)', 'i');
			if(current_url.match(patternFc)) {
				current_url = current_url.replace(patternFc , '');
			}
			
			var patternFs = new RegExp('fs' + id + '=price([^&]+)', 'i');
			if(current_url.match(patternFs)) {
				current_url = current_url.replace(patternFs , 'fs'+id+'='+valReplace);
			}
			else {
				current_url = current_url+'&'+'fs'+id+'='+valReplace;	
			}
			//Dua ve page = 1
			if(current_url.match(/page_no=(\d+)/)) {
				current_url = current_url.replace( /page_no=(\d+)/ , 'page_no=1');
			}
			location.href = current_url;
		}
	}
	/**
	 * Xóa search theo khoảng giá
	 *
	 * @author MinhNV
	 * Date 2010/10/12
	*/
	function removeIntervalPrice(id) {
		var current_url = window.location.href;
		current_url = decodeURIComponent(current_url.replace(/\+/g,  " "));

		if(current_url.match(/[^_]product_id=[^&^$]*/)) {
			current_url = current_url.replace(/product_id=[^&^$]*/, '');
		}
		current_url = rebuildParamsFilter(current_url);
		var patternFs = new RegExp('fs' + id + '=price([^&]+)', 'i');
		if(current_url.match(patternFs)) {
			current_url = current_url.replace(patternFs , "");
		}
		if(current_url.match(/page_no=(\d+)/)) {
			current_url = current_url.replace( /page_no=(\d+)/ , 'page_no=1');
		}
		if(!current_url.match(/fi[0-9]+/) && !current_url.match(/fs[0-9]+/)) {
			current_url += '&view_list=1';
		}
		current_url = unRebuildParamsFilter(current_url);
		current_url = current_url.replace( /&&/ , '&');
		current_url = current_url.replace( /\?&/ , '\?');
		location.href = current_url;
	}
	
	
	function view_more(id) {
		jQuery('#a_'+id).html( (aryCollapse[id] == 1) ? 'Thu hẹp' : 'Xem thêm');
		
		if(aryCollapse[id] == 1)	{
			jQuery('#a_'+id).removeClass('expand');
			jQuery('#a_'+id).addClass('collapse');
		}else{
			jQuery('#a_'+id).removeClass('collapse');
			jQuery('#a_'+id).addClass('expand');
		}
		
		jQuery("#source_fil_"+id).attr('style', ((aryCollapse[id] == 1) ? 'auto' : 'height:175px'));
		aryCollapse[id] = 0 - aryCollapse[id];
	}
	
//// QuynhTM add click view list all singer of depart VCM

	function call_list_singer(){
		var click = Bm.cookie.get('click_list_singer');
		if(!click || click==1){
			Bm.cookie.set('click_list_singer', '2',300);
			setTimeout( function() {
				jQuery('#show_all_singer').show();
			},50);
		}else{
			jQuery("#show_all_singer").hide();
			Bm.cookie.set('click_list_singer', '1',300);
			}
	}
	function close_show_all_singer(){
		jQuery("#show_all_singer").hide();
		Bm.cookie.set('click_list_singer', '1',300);
	}
