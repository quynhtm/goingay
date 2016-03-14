//fix png
function fix_png(id) {
    if (navigator.appVersion.match(/MSIE [0-6]\./)) {
        jQuery(id).each(function () {
            var background_image = jQuery(this).css("backgroundImage");
            if (background_image != 'none') {
                if (background_image.substring(4, 5) == '"') {
                    var img_src = background_image.substring(5, background_image.length - 2)
                } else {
                    var img_src = background_image.substring(4, background_image.length - 1)
                }
                jQuery(this).css({
					'backgroundColor': 'transparent',
					'backgroundImage': 'none',
                    'filter': "progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=crop, src='" + img_src + "')"
                })
            }
        })
    }
}
//get random
function getRandom(a, b) {
	var c = arguments.length;
	if (c == 0) {
		a = 0;
		b = 2147483647
	} else if (c == 1) {
		throw new Error('Error');
	}
	return Math.floor(Math.random() * (b - a + 1)) + a;
}
//show + hide loading
function show_loading(txt){
	txt = txt ? txt : 'Đang tải dữ liệu...';
	jQuery('.float_loading').remove();
	jQuery('body').append('<div class="float_loading">'+txt+'</div>');
	jQuery('.float_loading').fadeTo("fast",0.9);
	updatePosition();
	jQuery(window).scroll(updatePosition);

}

function hide_loading(txt){
	txt = txt ? txt : 'Đóng...';
	jQuery('.float_loading').html(txt);
	jQuery('.float_loading').fadeTo("slow",0,function(){
		jQuery(this).remove();
	});
}
function updatePosition(){
	if (navigator.appName == 'Microsoft Internet Explorer')
        jQuery('.mine_float_loading').css('top', document.documentElement[ 'scrollTop' ]);
}
//change border
function changeBorder(obj, id, newClass){
	jQuery(id).removeClass(newClass);
	jQuery(obj).addClass(newClass);
}

function showImage(obj,speed){
	jQuery(obj).fadeTo(speed,1);
}
/*
 load_html function
 if started, new action has been saved to a queue & will be started after first request is done
*/

function load_html(id, file){
	if(Bm._store.variable['loading_html'] == undefined || Bm._store.variable['loading_html'] == false){
		var rand_tail = '?rand='+Math.random();
		jQuery.ajax({
			beforeSend: function(){
				show_loading('Đang tải dữ liệu...');
				Bm._store.variable['loading_html'] = true;
			},
			type: 'GET',
			url : file+rand_tail,
			success: function(data){
				jQuery(id).append(data);
				hide_loading();
				Bm._store.variable['loading_html'] = false;
				load_html_queue();
			}
		});
	}else{
		if(Bm._store.variable['load_html_queue'] == undefined || Bm._store.variable['load_html_queue'] == null){
			Bm._store.variable['load_html_queue'] = new Array();
		}
		Bm._store.variable['load_html_queue'][Bm._store.variable['load_html_queue'].length] = {id:id,file:file};
	}
}
function load_html_queue(){
	if(Bm._store.variable['load_html_queue'] != undefined || Bm._store.variable['load_html_queue'] != null){
		var now = Bm._store.variable['load_html_queue'][0] ? Bm._store.variable['load_html_queue'][0] : false;
		if(now != false){
			load_html(now.id,now.file);
			Bm._store.variable['load_html_queue'].splice(0,1);
		}
	}
}

function submit_search_form(id){
	var form = document.getElementById(id);
	if(form){
		form.submit();
	}
}
function search_form_focus(obj, active, deactive){
	var bg = document.getElementById('top_right_search_form');
	if(bg){
		if(active != ''){
			bg.style.backgroundColor = active;
			obj.style.backgroundColor= active;
		}else if(deactive != ''){
			bg.style.backgroundColor = deactive;
			obj.style.backgroundColor= deactive;
		}
	}
}

function isEmail(_email) {
	var emailReg = /^[a-z][a-z-_0-9\.]+@[a-z-_=>0-9\.]+\.[a-z]{2,3}$/i;
	return emailReg.test(_email);
}

function changeTab(cl, url, idx){
	var active = cl+'_active';
	jQuery('.'+cl).removeClass(active);
	jQuery('.'+cl+idx).addClass(active);
	//var cache_key = url + '_' + idx;
	// kiem tra cache
	//if (jQuery.jCache.hasItem(cache_key)){
		//jQuery('.tab_content_container').html(jQuery.jCache.getItem(cache_key));
	//}else{
		var rand_tail = '?rand='+Math.random();
		//call add ajax request
		jQuery.ajax({
			beforeSend: function(){
				show_loading();
			},
			type: 'GET',
			url : url,
			success: function(data){
				jQuery('.tab_content_container').html(data);
				hide_loading();
				//jQuery.jCache.setItem(cache_key, data);
			}
		});
	//}
}

function changeTab2(pcl, cl, content_cl, idx){
	var active = cl+'_active';
	//show hide tab
	jQuery('.'+pcl+' .'+active).removeClass(active);
	jQuery('.'+pcl+' .'+cl+idx).addClass(active);
	//show hide content
	jQuery('.'+pcl+' .'+content_cl).addClass('hide_item');
	jQuery('.'+pcl+' .'+content_cl+idx).removeClass('hide_item');
}

function numbersonly(myfield, e, dec){
	var key;
	var keychar;
	if (window.event)
	   key = window.event.keyCode;
	else if (e)
	   key = e.which;
	else
	   return true;
	keychar = String.fromCharCode(key);
	// control keys
	if ((key==null) || (key==0) || (key==8) ||
		(key==9) || (key==13) || (key==27) )
	   return true;
	// numbers
	else if ((("0123456789").indexOf(keychar) > -1))
	   return true;
	// decimal point jump
	else if (dec && (keychar == ".")){
	   return true;
	}else
	   return false;
}

function auto_scroll(anchor) {
    var target = jQuery(anchor);
    target = target.length && target || jQuery('[name=' + anchor.slice(1) + ']');
    if (target.length) {
        var targetOffset = target.offset().top;
        jQuery('html,body').animate({scrollTop: targetOffset},1000);
        return false;
    }
}

function confirmDelete(form_id){
	if(confirm('Bạn muốn xóa các item này?')){
		form_id.cmd.value = 'delete';
		form_id.submit();
	}
}

function strip_tags(str, allowed_tags) {
    var key = '',
    allowed = false;
    var matches = [];
    var allowed_array = [];
    var allowed_tag = '';
    var i = 0;
    var k = '';
    var html = '';
    var replacer = function (search, replace, str) {
        return str.split(search).join(replace)
    };
    if (allowed_tags) {
        allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi)
    }
    str += '';
    matches = str.match(/(<\/?[\S][^>]*>)/gi);
    for (key in matches) {
        if (isNaN(key)) {
            continue
        }
        html = matches[key].toString();
        allowed = false;
        for (k in allowed_array) {
            allowed_tag = allowed_array[k];
            i = -1;
            if (i != 0) {
                i = html.toLowerCase().indexOf('<' + allowed_tag + '>')
            }
            if (i != 0) {
                i = html.toLowerCase().indexOf('<' + allowed_tag + ' ')
            }
            if (i != 0) {
                i = html.toLowerCase().indexOf('</' + allowed_tag)
            }
            if (i == 0) {
                allowed = true;
                break
            }
        }
        if (!allowed) {
            str = replacer(html, "", str)
        }
    }
    return str
}

//fade color
function setbgColor(r,g,b,id) {
    document.getElementById(id).style.backgroundColor = "rgb("+r+","+g+","+b+")";
	
}

function fade_to_yellow(r,g,b,id,t) {
        setbgColor(r,g,b,id);
		r = (r > 207)?(r-1):r;
		g = (g > 232)?(g-1):g;
		b = (b > 240)?(b-1):b;
		if (r>207 || g>232 || b>240){
			setTimeout(function(){fade_to_yellow(r,g,b,id,t);},10);
		}else
		{
			if(t==1){
				setTimeout(function(){fade_to_gray(r,g,b,id);},500);			
			}else{
				setTimeout(function(){fade_to_white(r,g,b,id);},500);			
			}
		}
}
function fade_to_gray(r,g,b,id) {
        setbgColor(r,g,b,id);
		r = (r < 243)?(r+1):r;
		g = (g < 243)?(g+1):g;
		b = (b < 243)?(b+1):b;
		setTimeout(function(){fade_to_gray(r,g,b,id);},10);
}
function fade_to_white(r,g,b,id) {
        setbgColor(r,g,b,id);
		r = (r < 255)?(r+1):r;
		g = (g < 255)?(g+1):g;
		b = (b < 255)?(b+1):b;
		setTimeout(function(){fade_to_white(r,g,b,id);},10);
}

//time_now: server time tai thoi diem load trang. thuong thi bien nay se duoc truyen tu sever ve.
//time: time truyen vao
//returnType: Neu ko truyen thi mac dinh se tra ve cả thẻ <span class="timer">, nếu truyền vào 1 thì sẽ trả về thời gian là: 1 phút trước hoặc 1 ngày trước ....

function duration_time(time_now, time, returnType){	
	var c_time = time;
	
    time = parseInt(time_now - time);
	var strReturn;
    
	if(time>(365*86400)){
		strReturn =  Math.floor(time/(365*86400))+ ' năm trước';
	}

	else if(time>(30*86400)){
		strReturn = Math.floor(time/(30*86400))+ ' tháng trước';
	}

	else if(time>(7*86400)){
		strReturn = Math.floor(time/(7*86400))+ ' tuần trước';
	}
	else if(time>86400){
		var d = Math.floor(time/(86400));
		if(d <= 2) {
			var h = Math.floor((time%86400)/(3600));
			var m = Math.floor((time%3600)/(60));
			strReturn = 'Hôm '+ ((d==1)?'qua':'kia') +' lúc '+ ((h < 10)?'0':'') + h +':'+ ((m < 10)?'0':'') + m + ' phút';
		}
		else 
		strReturn = d + ' ngày trước';
	}

	else if(time>3600){
		var h = Math.floor(time/(3600));
		if(h <= 3) {
			
			strReturn = h + ' giờ ' + Math.floor((time%3600)/(60)) + ' phút trước';
		}
		else
		strReturn = h + ' giờ trước';
	}

	else if(time>60){
		strReturn = Math.floor(time/(60))+ ' phút trước';
	}
	else strReturn = ' vài giây trước';
	
	if(returnType == 1) {
		return strReturn;
	}
	else
	return '<span class="timer" value="'+c_time+'" id="'+ c_time + '_' + Math.random() +'">' + strReturn + '</span>';
}

/**
 * redirect url
*/
function onClickClassified(url) {
    window.location.href = url;
}

/**
 * Change dieu kien sort
 * 
 */
function onChangeSortByFields(obj) {
    var val = jQuery(obj).val();
    var url = location.href;
    var pattern = new RegExp('sort_opt=([^&]+)', 'i');
    if(url.match(pattern)) {
	    url = url.replace(pattern , 'sort_opt'+'='+val);
    }
    else {
	if(!url.match(/.html/)) {
	    url = url + '?' + obj.id +'='+ val;
	}
	else {
	    url = url + '&' + obj.id +'='+ val;
	}
    }
    window.location.href = url;
}
    
function onChangeOptionSortByFields(value) {
    var val = value;
    var url = location.href;
    var pattern = new RegExp('sort_opt=([^&]+)', 'i');
    if(url.match(pattern)) {
	    url = url.replace(pattern , 'sort_opt'+'='+val);
    }
    else {
	if(!url.match(/.html/)) {
		    url = url + '?' + 'sort_opt' +'='+ val;
	}
	else {
		    url = url + '&' + 'sort_opt' +'='+ val;
	}
    }
    window.location.href = url;
}
