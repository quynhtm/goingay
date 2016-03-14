var rand_tail = '&rand='+Math.random();
var aryItemsJs = new Array();
var current_select, max_select, count = 0, category_id = 0, aryAllMobileJs = new Array(), lastKeyPress = 0;
var register = {
	'active_mobile_id': 0,
	'mobile_type_id':0,
	'blurItem':'',
	'focusItem':'',
	'arr':{
		'username': {
			"str" : "Phải bắt đầu bằng 1 kí tự chữ. Chỉ cho phép nhập kí tự chữ, số và dấu _",
			"err" : "",
			"pos" : 0,
			"top" : 15,
			"height" : 45,
			"pheight" : 400
		},
		'pass': {
			"str" : "Mật khẩu đăng nhập nên chứa các kí tự hoa thường & số để đảm bảo an toàn",
			"err" : "",
			"pos" : 22,
			"top" : 20,
			"height" : 45,
			"pheight" : 395
		},
		'repass': {
			"str" : "Xác nhận mật khẩu, không nên copy để tránh bị sai",
			"err" : "",
			"pos" : 65,
			"top" : 20,
			"height" : 30,
			"pheight" : 395
		},
		'address':{
			"str" : "Địa chỉ của bạn để giao dịch nhận hàng, chuyển hàng.",
			"err" : "",
			"pos" : 65,
			"top" : 20,
			"height" : 30,
			"pheight" : 395
		},
		'tel':{
			"str" : "Số di động của bạn, Save.vn cam kết giữ bảo mật và không spam",
			"err" : "",
			"pos" : 100,
			"top" : 20,
			"height" : 30,
			"pheight" : 395
		},
		'email': {
			"str" : "Địa chỉ email là duy nhất - Email xác thực sẽ được gửi vào chính email này",
			"err" : "",
			"pos" : 0,
			"top" : 15,
			"height" : 45,
			"pheight" : 400
		},
		'yahoo': {
			"str" : "Nicks Yahoo name",
			"err" : "",
			"pos" : 225,
			"top" : 20,
			"height" : 30,
			"pheight" : 395
		},
		'skype': {
			"str" : "Nicks Skype name",
			"err" : "",
			"pos" : 260,
			"top" : 20,
			"height" : 30,
			"pheight" : 395
		},
		'mobile_name': {
			"str" : "Loại điện thoại bạn đang dùng.",
			"err" : "",
			"pos" : 280,
			"top" : 20,
			"height" : 30,
			"pheight" : 395
		},
		'keycode': {
			"str" : "Hãy nhập các ký tự giống hệt bức ảnh bên trái",
			"err" : "",
			"pos" : 180,
			"top" : 20,
			"height" : 30,
			"pheight" : 395
		}
	}
};

function activeStep(idx, cl) {
	for ( var i = 1; i <= 3; i++) {
		if (idx == i) {
			if (!jQuery('.' + cl + i).hasClass(cl + i + '_active')) {
				jQuery('.' + cl + i).addClass(cl + i + '_active');
			}
		} else {
			jQuery('.' + cl + i).removeClass(cl + i + '_active');
		}
	}
}
function changeStep(idx) {
	if(step_now == 2 && idx != 3) {
		registerCheckSubmit();
		return;
	}

	// get step index
	step_now = (idx <= 3 && idx >= 1) ? idx : (step_now < 3 ? (step_now + 1)
			: step_now);

	// active step bar
	activeStep(step_now, 'register_step');
	// load step content
	if (jQuery('.register_step_container' + step_now).html() == '') {
		var mobile = '';
		if(idx == 3) {
			mobile = '&mobile='+document.getElementById('mobile').value;//'&mobile='+3;//
		}
		load_html('.register_step_container' + step_now, BASE_URL
				+ 'ajax.php?act=register&code=change_step&step_now='
				+ step_now + mobile + '&'); //#mobile la phuc vu cho step 3
	}
	// active this step
	activeStep(step_now, 'register_step_container');
	// hide all button
	jQuery('.bt_tieptuc').hide();
	//jQuery('.finish_step').hide();
	// show button if finish form
	if (isFinish(step_now)) {
		switch (step_now) {
		case 1:
			jQuery('.bt_tieptuc').show();
			break;
		case 2:
			jQuery('.bt_tieptuc').show();
			//jQuery('#frmRegister').submit();
			break;
		case 3:
			//jQuery('.finish_step').show();
			jQuery('.bt_tieptuc').hide();
			jQuery('.finish_step').show();
			break;
		}
	}

	//document.getElementById('mobi_code').focus();
}
function isFinish(idx) {
	var isOke = false;
	switch (idx) {
	case 1:
		var temp = jQuery('.danhgia_img_active').get();
		if (temp.length > 0) {
			isOke = true
		}
		break;
	case 2:
		isOke = true;
		break;
	}
	return isOke;
}
function getDebugStr(obj) {
	jQuery('body').append(prettyPrint(obj));
}

// for step 1
function choose_mobilephone(obj){
	var parent = jQuery(obj).parent();
	if(!parent.hasClass("mobile_active")){
	    //remove class
	    reset_step(1);
	    //add class
	    register.active_mobile_id = parent.attr("id");
	    parent.addClass("mobile_active");
	    var pp = parent.parent();
	    jQuery('.img_main_overlay', pp).addClass('danhgia_img_active');
		jQuery('a.link_block', pp).addClass('img_check');

	    jQuery('.bt_tieptuc').show();
	}
}

function reset_step(step) {
	if(step == 1) {
		jQuery('.img_check').removeClass('img_check');
		jQuery('.mobile_active').removeClass("danhgia_img_active");
		jQuery('.mobile_active').removeClass("mobile_active");
		jQuery('.img_main_overlay').removeClass('danhgia_img_active');
		jQuery('.bt_tieptuc').hide();
	}
}

function show_list_mobile(obj) {
	if (!jQuery(obj).hasClass("item_logo_active")) {
		// var url = document.getElementById("get_list_mobile_url").value;
		var url = BASE_URL + 'ajax.php?act=register&code=get_list_mobile';
		jQuery.ajax( {
			beforeSend : function() {
				jQuery('.item_logo_active').removeClass("item_logo_active");
				jQuery(obj).addClass("item_logo_active");
				register.mobile_type_id = obj.id;
				Bm.show_loading();
			},
			type : 'GET',
			dataType: 'json',
			url : url,
			data : 'id=' + obj.id + '&rand=' + Math.random(),
			success : function(data) {
				jQuery('#arrow_down').show();
				jQuery('#list_mobile').html(data.theme);
				aryItemsJs = data.data;
				jQuery('.bt_tieptuc').hide();
				Bm.hide_loading();
				jQuery('.link_block').hover(function() {
					jQuery(this).parent().addClass("danhgia_img_active")
				}, function() {
					var parent = jQuery(this).parent();
					if (!parent.hasClass("mobile_active")) {
						parent.removeClass("danhgia_img_active");
					}
				});
				auto_scroll('#mobi_list_anchor');
				document.getElementById('mobi_code').focus();
			}
		});
	}
}

function focusObj(id) {

	//var info = 'me='+id+' & blur='+register.blurItem + "<Br>" + register.arr[id].err + ' & ' + register.arr[register.blurItem].err + '<Br>';
	//jQuery("#test").append(info);
	if(register.arr[id].err != "" || register.blurItem == "")
		makeToolTip(id);
	else if(register.arr[id].err == "" && register.blurItem != "") {
		//alert('x');
		if(register.arr[register.blurItem].err != "")
			makeToolTip(register.blurItem);
		else makeToolTip(id);
	}
}
function makeToolTip(idx) {
	jQuery('.description_bar').css( {
		display : 'block',
		height : register.arr[idx].pheight + 'px',
		top : register.arr[idx].top + 'px'
	});
	jQuery('.toop_tip_bar').css( {
		paddingTop : register.arr[idx].pos + 'px'
	});
	jQuery('.tool_tip_content').css("height", register.arr[idx].height);
	if (register.arr[idx].err != "") {
		jQuery('.tool_tip_content').html(register.arr[idx].err);
	} else {
		jQuery('.tool_tip_content').html(register.arr[idx].str);
	}
}
function hideToolTip(id) {
	register.blurItem = id;
	//jQuery('.description_bar').hide();
}

function isOkeStep2() {
	var nobug = true, boolReturn = true;
	
	jQuery('.form_item > input')
			.each(function(){
				if(this.id != 'mobile') {
					nobug = validItem(this.id, jQuery(this).val(), false);
					if(!nobug) boolReturn = false;
				}
			}); 
/*
	if (jQuery('#city').val() == 0) {
		jQuery('#city').addClass('class_err');
		nobug = false;
	} else {
		jQuery('#city').removeClass('class_err');
		register.arr['city'].err = "";
	}
	
	if (jQuery('#mobile_type').val() == 0) {
		jQuery('#mobile_type').addClass('class_err');
		nobug = false;
	} else {
		jQuery('#mobile_type').removeClass('class_err');
		register.arr['mobile_type'].err = "";
	}
	
	if (jQuery('#mobile').val() == 0) {
		jQuery('#mobile_name').addClass('class_err');
		nobug = false;
	} else {
		jQuery('#mobile_name').removeClass('class_err');
		register.arr['mobile_name'].err = "";
	}
*/	
	if(!nobug) boolReturn = false;
	
	return boolReturn;
}

function validObject(obj) {
	var nobug = true;
	validItem(obj, txt)
	if (jQuery('#city').val() == 0) {
		jQuery('#city').addClass('class_err');
		nobug = false;
	} else {
		jQuery('#city').removeClass('class_err');
		register.arr['city'].err = "";
	}
	return nobug;
}
function validItem(id, txt, call_me_from_item) {
	if(call_me_from_item == undefined) call_me_from_item = true;
	var validating = false;
	var nobug = true;
	var check = true;
	txt = jQuery.trim(txt);
	var idx = '';

	switch (id) {
	case 'username':
		if (txt.length < 3 || txt.length > 35) {
			nobug = false;
			check = false;
			register.arr['username'].err = "Username tối thiểu phải có 3 ký tự, tối đa là 35 ký tự.";
		}
		else if ((txt.match(/^[0-9]/) == null)	&& (txt.search(/^[0-9_a-zA-Z]*$/) > -1)) {
			if(call_me_from_item) { validating = true; validAjax(id, txt); };
		} else {
			nobug = false;
			check = false;
			register.arr['username'].err = "Username không hợp lệ";
		}
		break;
	case 'pass':
		if (txt.length < 6) {
			nobug = false;
			check = false;
			register.arr['pass'].err = "Mật khẩu tối thiểu có 6 kí tự";
		}

		break;
	case 'repass':
		if (txt != jQuery.trim(jQuery('#pass').val())) {
			nobug = false;
			check = false;
			register.arr['repass'].err = "Mật khẩu không trùng khớp, vui lòng gõ lại mật khẩu";
		}

		break;
	case 'tel':
	break;
		// check tel number is existed by ajax here
		if (txt.length < 10 || txt.length > 11) {
			nobug = false;
			check = false;
			register.arr['tel'].err = "Số điện thoại chỉ có 10 hoặc 11 chữ số";
		}
		if (!Bm.is_phone(txt)) {
			nobug = false;
			check = false;
			register.arr['tel'].err = "Số điện thoại có thể chưa đúng";
		}
		else if (txt.charAt(0) != 0){
			nobug = false;
			check = false;
			register.arr['tel'].err = "Số điện thoại phải bắt đầu là số '0'";
		}
		else if(call_me_from_item) { validating = true; validAjax(id, txt); };

		break;
	case 'email':
		if (Bm.is_mail(txt)) {
			if(call_me_from_item) {
				validating = true;
				validAjax(id, txt);
			}
		} else {
			nobug = false;
			check = false;
			register.arr['email'].err = "Địa chỉ email không hợp lệ";
		}
		break;
	case 'keycode':
		if (txt == '') {
			nobug = false;
			check = false;
			register.arr['keycode'].err = "Mã bảo mật không hợp lệ";
		}
		break;
	}

	if (check) {
		if(!validating) {
			jQuery("#"+id).removeClass('class_err');
			//register.arr[id].err = "";
			hideToolTip(id);
		}
		else { // dang trong qua trinh valid = ajax
			nobug = false;
		}
	} else {
		jQuery("#"+id).addClass('class_err');
		if(call_me_from_item)  {
			//makeToolTip(id);
		}
	}
	return nobug;
}

function validAjax(id, txt) {
	var url = BASE_URL + 'ajax.php?act=register&code=valid&id='+id+'&value='+txt+rand_tail;
	jQuery.ajax({
		/*beforeSend: show_loading('Đang thực hiện kiểm tra dữ liệu ...'), */
		type: 'GET',
		url : url,
                dataType: 'json',
		success: function(data){
			if(data.intReturn != 1) {
                            register.arr[id].err = data.err;
                            jQuery("#"+id).addClass('class_err');
                        }
                        else {
                            jQuery("#"+id).removeClass('class_err');
							register.arr[id].err = "";
							hideToolTip(id);
                        }
			//hide_loading();
		}
	});
}

function check_image(){
	//QuynhTM add kiem tra file anh
	var str = document.getElementById('avatar').value;
	if(str.length >0){
		var regx = /gif|jpg|png|jpeg/i;
		if(str.match(regx))
		{
			return true;
		} else {
			alert("File ảnh không đúng định dạng: .gif|.jpg|.png|.jpeg");
			document.getElementById('avatar').focus();
			return false;
		}
	}else{
		return true;
	}
}
function registerCheckSubmit() {
	var check = true;
	/*if (!isOkeStep2()) {
		check = false;
	}QuynhTM dong
	*/
	/*if(!check_image() ){
		check=false;
	}*/

	if(check){
		jQuery("#frmRegister").validate({		
			submitHandler: function(form) {
				jQuery(form).ajaxSubmit({
					success:       showResponse,
					dataType:	'json',
					beforeSubmit:	resetAll
				});
			}
		})
		jQuery('#frmRegister').submit();
	}
}

function showResponse(responseText, statusText) {
	Bm.hide_loading();
	if(responseText.intReturn == -1) { // Co loi xay ra
		for(idx in  responseText.aryErr) {
			register.arr[idx].err = responseText.aryErr[idx];
			//makeToolTip(idx);
			jQuery('#'+idx).addClass('class_err');
		}
	}
	else {
		//Bm.show_overlay_popup('123', 'Thông báo', 'Đăng ký thành công');
		location.href = BASE_URL + 'quan-ly-ca-nhan.html';
	}
}

function resetAll() {
	Bm.show_loading();
}

function registerStep2() {
	jQuery("#frmRegister").validate({		
		submitHandler: function(form) {
			jQuery(form).ajaxSubmit({
        		success:       showResponse,
        		dataType:	'json',
        		beforeSubmit:	resetAll
			});
		}
	});	
	document.getElementById('username').focus();
	auto_scroll('#mobi_top');
}
function getListMobileByJs(obj) {
	var i = 0;
	var str = '';
	var d = obj.value;
	d = d.toLowerCase();
	document.getElementById("noProduct").style.display = "none";
	var matched = false;
	for(i in aryItemsJs) {
		str = aryItemsJs[i].mobile_name;
		str = str.toLowerCase();
		if( str.match(d) == null ) {
			document.getElementById("items_"+i).style.display = "none";
			if(i == register.active_mobile_id) register.active_mobile_id = 0;
		}
		else {
			document.getElementById("items_"+i).style.display = "block";
			matched = true;
		}
	}


	if(!matched) {
		document.getElementById("noProduct").style.display = "block";
	}
	if(!matched || register.active_mobile_id == 0) {
		reset_step(1);
	}
}


function getMobileByMobileType(obj) {
	var url = BASE_URL + 'ajax.php?act=register&code=get_list_mobile&id=' + obj.value + '&rand=' + Math.random();
	jQuery.ajax( {
		beforeSend : function() {			
			Bm.show_loading();
		},
		type : 'GET',
		dataType: 'json',
		url : url,
		success : function(data) {			
			Bm.hide_loading();
		}
	});
}

function selectHangDienThoaiBuy(obj) {
    cur_obj = obj;
    aryAllMobileJs = obj.value;
    Bm.ajax_popup('act=profile_edit&code=mobile_list&id=' + obj.value+'&is_object=1', 'GET', null, bindMobileListBuy);
	    Bm.get_ele('mobile').value = '';
		Bm.get_ele('mobile').title = '';
		
		Bm.get_ele('mobile_name').value = Bm.get_ele('mobile_name').title;
}



function keypress_handle_2(e,sform,kbox,rbox){
	if(count <= 0) return;
	var key = window.event ? e.keyCode : e.which;
	lastKeyPress = key;
	if(key==13)
	{
		if(current_select==-1 && document.getElementById(kbox).value!='')
		{
			if(getFirstMobileInArr(kbox))
				document.getElementById(kbox).value = getFirstMobileInArr(kbox);
		}
		
		if(check_input_value(kbox)) {
			get_go_2(sform,kbox,rbox,current_select);
		}
		else
		{
			alert('Điện thoại bạn chọn không đúng, vui lòng thử lại!');
			return false;
		}
	}
	
	return;
}

function keyup_handle_2(e,sform,kbox,rbox){
	if(lastKeyPress == 13 || lastKeyPress == 27) {
		hide_rbox('trbox');
		return;
	}
	if(count <= 0) return;
	++count;
	if (count>100) return false;
	var key = window.event ? e.keyCode : e.which;
	
	switch(key){
		case 40: move_down(kbox,rbox); break;
		case 38: move_up(kbox,rbox); break;
		default: get_ajax_list(kbox,rbox,sform, 'get_go_2');
	}
}


function bindMobileListBuy(data) {
	aryAllMobileJs = data.list;
	count = data.list.length;
	
	
	/*
    var curObj = jQuery('#mobile', jQuery(cur_obj).parent());
    curObj.children().remove();
    var dataArr = toArray(data.list);
    var len = dataArr.length;
    if (len <= 0) {
        curObj.append('<option value="0">Chọn điện thoại</option>');
    } else {
        for (var i = 0; i < len; i++) {
            curObj.append('<option value="' + dataArr[i].id + '">' + dataArr[i].mobile_name + '</option>');
        }
    }*/
	//jQuery('.jNice').jNice();
}

function get_go_2(sform,kbox,rbox,index){
	
	if(index && index!=-1){
		set_text(index,kbox);
		hide_rbox(rbox);
	}
	var string = clean_string(document.getElementById(kbox).value);
	if(document.getElementById(kbox)) {
		document.getElementById(kbox).value = string;
		
		for(i in aryAllMobileJs) {
			if(aryAllMobileJs[i]['mobile_name'].toLowerCase() == string) {
				
				Bm.get_ele('mobile').value = i;
				Bm.get_ele('mobile').title = string;
				
				break;
			}
		}
	}
	else {
		alert('System Error');
	}
	
		
}

function hideSugess(value) {
	
}
/*

function toArray(o) {
	var a = new Array();
	for (x in o){
	    a.push(o[x]);
	}
	return a;
}
*/
jQuery(document).ready(function(){
	var obj_mobile_type = Bm.get_ele('mobile_type');
	if(obj_mobile_type && obj_mobile_type.value > 0)
		selectHangDienThoaiBuy(obj_mobile_type);
});


/* Check input text*/
