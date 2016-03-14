/*
#####################
# Code by Enbac team
# EnBac library
# hoangnova
#####################
*/
jQuery(document).ready(function(){
	//begin
	jQuery().ajaxSend(function(r,s){
		jQuery("#loading-layer").show();
	});

	jQuery().ajaxStop(function(r,s){
		jQuery("#loading-layer").fadeOut("slow");
	});

	if(window.IS_ADMIN){
		// jQuery(".div_admin_config_form").each(function () {
		//alert(this);
		//jQuery(this).css({display:""});
		//});
		jQuery(".div_admin_config_form").css("display","");
	}
	//alert(jQuery('#banner_admicro').height());
});



function login_error(message){
	if(message)
	message_all = message ;
	else message_all='Bạn phải đăng nhập mới được dùng chức năng này';
	
	var str_openid = '';
	str_height = 99;

	if(OPENID_ON){
	/*	str_openid = '<div class="open_id_mini1" align="center"><div class="text_open_id">Chưa có tài khoản trên enbac ?</div><div class="btn_open_id" onclick="window.location=\''+OID_URL+'\'" onmouseout="this.className=\'btn_open_id\'" onmouseover="this.className=\'btn_open_id_hover\'"><a href="'+OID_URL+'">Đăng nhập nhanh với nick Y!M</a></div></div>';
		
		str_openid += '<div class="open_id_mini1" align="center"><div class="btn_open_id" onclick="window.location=\''+OID_URL+'\'" onmouseout="this.className=\'btn_open_id\'" onmouseover="this.className=\'btn_open_id_hover\'"><a href="'+OID_URL+'">Đăng nhập nhanh với Google</a></div></div>';*/
		
		str_openid  = '<div class="othrAcc" style="margin-left:70px;border-bottom:1px solid #cbcac8"> Đăng nhập dùng nick : <a class="google" href="'+OID_URL_GOG+'" title="Đăng nhập vào ÉnBạc bằng nick Google tại Google.com">Google</a> hoặc <a class="yahoo" href="'+OID_URL+'" title="Đăng nhập vào ÉnBạc bằng nick Yahoo tại Yahoo.com">Yahoo</a></div>';
		
		var str_height = 130;
	}
	jQuery.blockUI({message: '<div style="width:410px; border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div style=" height:26px; background-color:#17437a" align="left"><span style=" line-height:26px;color: #fff; padding-left:10px;">Thông báo !</span><img src="style/images/i_close2.gif" width="13" height="13" id="close_box" title="Close..." style="cursor:pointer; padding:2px; margin-top:3px; _margin-top:0px; margin-left:300px; _margin-left:300px; position:absolute" /></div><div style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom; min-height:99px;height:'+str_height+'px; "><div style="background:url(style/images/icon_log_login.gif) no-repeat 10px 10px; min-height:90px;_height:90px;"><div style="margin-left:76px; padding-top:20px;">'+message_all+'</div><div style="margin-top:10px;" align="center"><input type="button" name="sign_in" class="btnLogLogin"  id="login" value="Đăng nhập" /><input type="button" name="sign_in" class="btnLogOut"  id="no" value="Đóng" /></div></div>'+str_openid+'</div></div>', css: { border:'none', padding:0}});
	
	jQuery('#overlay').click(function () {
		jQuery.unblockUI();
	});
	jQuery('#login').mouseover(function () {
		jQuery(this).toggleClass("btnLogLoginOver");
		jQuery(this).removeClass("btnLogLogin");
	});
	jQuery('#login').mouseout(function () {
		jQuery(this).toggleClass("btnLogLogin");
		jQuery(this).removeClass("btnLogLoginOver");
	});
	jQuery('#no').mouseover(function () {
		jQuery(this).toggleClass("btnLogOutOver");
		jQuery(this).removeClass("btnLogOut");

	});
	jQuery('#no').mouseout(function () {
		jQuery(this).toggleClass("btnLogOut");
		jQuery(this).removeClass("btnLogOutOver");
	});

	jQuery('#close_box').click(function () {
		jQuery.unblockUI();
	});
	
	closeBlockUI();

	jQuery('#login').click(function() {
		// update the block message
		login_div();
	});

	jQuery('#no').click(function() {
		jQuery.unblockUI();
		return false;
	});
}
function login_div(){
	var str_openid = '';
	if(OPENID_ON){
		
		str_openid  = '<div class="othrAcc" style="margin-left:70px;border-bottom:1px solid #cbcac8"> Đăng nhập dùng nick : <a class="google" href="'+OID_URL_GOG+'" title="Đăng nhập vào ÉnBạc bằng nick Google tại Google.com">Google</a> hoặc <a class="yahoo" href="'+OID_URL+'" title="Đăng nhập vào ÉnBạc bằng nick Yahoo tại Yahoo.com">Yahoo</a></div>';
		
		var str_height = 130;
	}
	
	jQuery.blockUI({ message: '<form name="login_form" id="login_form" method="POST"><div style="width:410px;border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div style=" height:26px; background-color:#17437a;" align="left"><span style=" line-height:26px;color: #fff; padding-left:10px;">Đăng nhập !</span><img src="style/images/i_close2.gif" width="13" height="13" id="close_box" title="Close..." style="cursor:pointer; padding:2px; margin-top:3px; _margin-top:0px; margin-left:295px; _margin-left:300px; position:absolute" /></div><div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom; height:178px"><div class="sign-in-field" style="padding-top:20px;"><label for="user_name" style="font-weight:normal; width:120px; color:#000">T&#234;n &#273;&#259;ng nh&#7853;p: </label><input name="user_name" type="text" id="user_name" /></div><div class="sign-in-field"><label for="password" style="font-weight:normal; width:120px;color:#000">M&#7853;t kh&#7849;u: </label><input name="password" type="password" id="password" /></div><div class="sign-in-set-cookie" align="left" style="margin-left:35px;font-weight:normal;" ><input id="set_cookie" name="set_cookie" value="on" type="checkbox" /><label for="set_cookie" class="cursor" style="font-weight:normal"> Ghi nhớ mật khẩu</label></div><div  class="sign-in-submit1" style="padding-left:122px;"><input type="submit" name="sign_in" class="btnLogLogin floatLeft"  id="sign-in-submit"  value="Đăng nhập"/><span class="sign-in-lost-password"><a href="?page=forgot_password" style="font-weight:normal;">Qu&#234;n m&#7853;t kh&#7849;u?</a></span></div>'+str_openid+'</div></div></form>', css: { border:'none', padding:0} });
	jQuery('#sign-in-submit').mouseover(function () {
		jQuery(this).toggleClass("btnLogLoginOver");
		jQuery(this).removeClass("btnLogLogin");

	});
	jQuery('#sign-in-submit').mouseout(function () {
		jQuery(this).toggleClass("btnLogLogin");
		jQuery(this).removeClass("btnLogLoginOver");
	});
	jQuery("#login_form").submit(function(){
		on_submit_login();
		return false;
	});
			
	jQuery('#close_box').click(function () {
		jQuery.unblockUI();
	});
	
	closeBlockUI();
	
	jQuery('#overlay').click(function () {
		jQuery.unblockUI();
	});
}
function log_success(message_all,livetime){
	
	Bm.show_popup_message('<div style="width:360px; border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom; min-height:119px;_height:119px;"><div style="background:url(style/images/icon_log_success.gif) no-repeat 10px 20px; min-height:119px;_height:119px;"><div style="margin-left:76px; padding-top:40px">'+message_all+'</div></div></div></div>', 'Thông báo !', 1, 'auto' );

	if(livetime)
	livetime_all = livetime ;
	else livetime_all=2000;

	setTimeout("Bm.hide_all_popup()", livetime_all);
}


function log_faile(message_all,livetime){
	Bm.show_popup_message('<div id="bound_log_faile" style="width:360px;border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom; min-height:119px;_height:119px;"><div style="background:url(style/images/icon_log_faile.gif) no-repeat 10px 20px; min-height:119px;_height:119px;"><div style="margin-left:76px; padding-top:40px">'+message_all+'</div></div></div></div>', 'Thông báo !', 1, 'auto' );
	
	if(livetime)
	livetime_all = livetime ;
	else livetime_all=2000;
	setTimeout("Bm.hide_all_popup()", livetime_all);
}

function mini_block_faile(id_block,message){
	jQuery(id_block).block({
		message: message,
		css: { border: '1px solid #f00',padding:'10px' }
	});
	setTimeout(function(){jQuery(id_block).unblock(); }, 2000);
}

function confirm_remove_email_alert(user_id,active_code,URL){
	var message_all='Bạn đang gửi yêu cầu tới hệ thống ngừng cung cấp email thông báo cho bạn?';
	Bm.show_popup_message('<div style="width:410px; border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div style="background:url(style/images/icon_log_login.gif) no-repeat 10px 10px; min-height:99px;_height:99px;"><div style="margin-left:76px; padding-top:20px;">'+message_all+'</div><div style="margin-top:10px;" align="center"><input type="button" name="accept" class="btnLogLogin"  id="accept" value="Đồng Ý" />&nbsp;&nbsp;<input type="button" name="sign_in" class="btnLogOut"  id="no_thank" value="Hủy Bỏ" /></div></div></div>', 'Thông báo !', 1, 'auto' );
	jQuery('#overlay').click(function () {
		Bm.hide_all_popup();
		//window.location = URL+"?page=profile&user_id="+user_id;
		window.location = URL;
	});
	jQuery('#no_thank').click(function() {
		jQuery.unblockUI();
		//window.location = URL+"?page=profile&user_id="+user_id;
		window.location = URL;
		return false;
	});

	jQuery('#accept').click(function() {
		jQuery.post("ajax.php?act=user&code=remove_email_alert", {
			user_id: user_id,
			active_code: active_code
		},
		function(msg){
			if (msg != 'unsuccess'){
				//window.location = URL+"?page=profile&user_id="+user_id;
				window.location = URL;
			}
		}
		);
	})
}
function closeBlockUI(){		
	jQuery(window).keydown(function (e) {
      if (e.which == 27){
		  jQuery.unblockUI();
	  }
	});
}

function getValueId(id,type,svalue){
	if(document.getElementById(id)){
		
		if(typeof(type)=='undefined'){
			var type='value';
		}
		
		if(typeof(svalue)=='undefined'){
			var svalue='';
		}
		
		if(type=='value'){
			return document.getElementById(id).value;
		}
		else if(type=='checked'){
			return document.getElementById(id).checked;
		}
		else if(type=='assign'){
			return document.getElementById(id).value = svalue;
		}
		else{
			return '';
		}
	}
}
function MM_preloadImages() { //v3.0
	var d=document;
	if(d.images){
	if(!d.MM_p) d.MM_p=new Array();
	var i,j=d.MM_p.length,a=MM_preloadImages.arguments;
	for(i=0; i<a.length; i++)
	if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}


function getVar(href_val){
	var arr_view = new Array();
	if(href_val){
		var view = href_val.replace(/^.*#/, '');		
	}
	else{
		var view = (window && window.location && window.location.hash) ? window.location.hash : '#inbox';
		view = view.replace(/^.*#/, '');	
	}			
	arr_view = view.split('/');	
	return arr_view;	
}


Array.prototype.inArray = function (value){
	var i;
	for (i=0; i < this.length; i++) 
	{
		if (this[i] == value) 
		{
		return true;
		}
	}
	return false;
};
function Shuffle_arr(v){
	for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
	return v;
}
function in_array(needle, haystack, argStrict) {
 
    var key = '', strict = !!argStrict;
 
    if (strict) {
        for (key in haystack) {
            if (haystack[key] === needle) {
                return true;
            }
        }
    } else {
        for (key in haystack) {
            if (haystack[key] == needle) {
                return true;
            }
        }
    }
 
    return false;
}