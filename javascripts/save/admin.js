function fn_click_move_content(form_name){
	
	var frm_name = eval("document."+form_name);	
	var val_checked = '';
	
	if(frm_name.id_cats.value==0){
		alert('Bạn phải chọn một chuyên mục để chuyển tin');	
		return false;
	}
	
	for (var i = 0; i < frm_name.elements.length; i++) {		
		if (frm_name.elements[i].name == 'selected_ids[]' && frm_name.elements[i].checked) {
			val_checked += frm_name.elements[i].value+',';			
		}
	}	
	
	if(val_checked==''){
		alert('Bạn cần chọn tin để chuyển chuyên mục');
		return false;
	}

	frm_name.product_item.value=val_checked;	
	frm_name.cmd.value='move_content';	
	frm_name.submit();
	
}
function fn_click_unban_nick_profile(user_id){
	jQuery.post(BASE_URL+"ajax.php?act=admin&code=un_ban_nick_profile", {		
		user_id: user_id
	},
	
	function(msg){			
	if(msg == 'no_perm')
		{			
			log_faile('Bạn không có quyền thực hiện chức năng này');
			return false;
		}			
	else if(msg=='success')
		{
			location.reload();
		}		
	});
}


function fn_admin_de_active_user(user_id,gids,act){	
	jQuery.get("ajax.php?act=admin&code=active_user", {	
	user_id: user_id,
	gids: gids,
	action: act
	},
	function(msg){			
	if(msg == 'not_login')
		{			
			login_error();
			return false;
		}
	else if(msg == 'no_perm')
		{			
			log_faile('Bạn không có quyền thực hiện chức năng này');
			return false;
		}
	else if(msg == 'unsuccess')	{
			log_faile('Không thực hiện được chức năng này');
			return false;
		}
	else
		{																					
			location.reload();
		}		
	});
}

function in_array(needle, haystack, strict) {  
    var found = false, key, strict = !!strict; 
    for (key in haystack) {
        if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
            found = true;
            break;
        }
    } 
    return found;
}

function selecte_all_checkbox(form_name){
	var o_item = new Array();
	o_item[0]="openid"; o_item[1]="ava"; o_item[2]="block"; o_item[3]="up";	 o_item[4]="blank";	o_item[5]="chk_ids"; o_item[6]="active";	
	
	var frm_name = eval("document."+form_name);
	for (var i = 0; i < frm_name.elements.length; i++) {
		if (frm_name.elements[i].type == "checkbox" && !in_array(frm_name.elements[i].name,o_item)) {			
			frm_name.elements[i].checked = (frm_name.elements[i].checked==true)?false:true;
		}
	}
}

function select_checkbox(form, name, checkbox, select_color, unselect_color){
	tr_color = checkbox.checked?select_color:unselect_color;
	if(typeof(event)=='undefined' || !event.shiftKey){
		jQuery('#'+name+'_all_checkbox').attr('lastSelected',checkbox);
		if(select_color){
			jQuery('#'+name+'_tr_'+checkbox.value).css('backgroundColor',checkbox.checked?select_color:unselect_color);
		}
		update_all_checkbox_status(form, name);
		return;
	}
	
	var active = typeof(jQuery('#'+name+'_all_checkbox').attr('lastSelected'))=='undefined'?true:false;
	
	for (var i = 0; i < form.elements.length; i++) {
		if (!active && form.elements[i]==jQuery('#'+name+'_all_checkbox').attr('lastSelected')){
			active = 1;
		}
		if (!active && form.elements[i]==checkbox){
			active = 2;
		}
		if (active && form.elements[i].id == name+'_checkbox') {
			form.elements[i].checked = checkbox.checked;
			jQuery('#'+name+'_tr_'+form.elements[i].value).css('backgroundColor',checkbox.checked?select_color:unselect_color);
		}
		
		if(active && (form.elements[i]==checkbox && active==1) || (form.elements[i]==jQuery('#'+name+'_all_checkbox').attr('lastSelected') && active==2)){
			break;
		}
	}
	update_all_checkbox_status(form, name);
}

function selectAllCheckbox(form,name,status, select_color, unselect_color){
	for (var i = 0; i < form.elements.length; i++) {
		//alert(form.elements[i].name);
		if (form.elements[i].name == 'selected_ids[]') {
			if(status==-1){
				form.elements[i].checked = !form.elements[i].checked;
			}
			else{
				form.elements[i].checked = status;
			}
			if(select_color){
				jQuery('#'+name+'_tr_'+form.elements[i].value).css('backgroundColor',form.elements[i].checked?select_color:unselect_color);
			}
		}
	}
}

function update_all_checkbox_status(form, name){
	var status = true;
	for (var i = 0; i < form.elements.length; i++) {
		if (form.elements[i].name == 'selected_ids[]' && !form.elements[i].checked) {
			status = false;
			break;
		}
	}
	jQuery('#'+name+'_all_checkbox').attr('checked',status);
}

function ban_nick_user(user_id, user_name){
	show_menu_admin_profile_info();
	var message_all='Khóa nick thành viên "'+user_name+'"';
	
	if(IS_ADMIN){
		var str_content = '<option value="1">Khóa theo ngày</option><option value="2">Khóa vĩnh viễn</option><option value="3">Khóa vĩnh viễn và khóa cookies</option>';	
	}
	else{
		var str_content = '<option value="1">Khóa theo ngày</option>';	
	}
	
	Bm.show_popup_message('<form name="frm_ban_nick" id="frm_ban_nick"><div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="padding-top:20px; margin-left:15px"><label for="user_name" style="font-weight:normal; width:120px; color:#000">Số ngày khóa nick: </label><input maxlength="250" size="10" name="date_ban" type="text" id="date_ban" value="7" /> <select name="type_lock" id="type_lock">'+str_content+'</select></div><br style="line-height:10px"><span style="margin-top:10px;margin-left:15px; font-weight:normal">Lý do:</span><span style="margin-left:77px"><textarea id="reason_lock" name="reason_lock"  rows="4" cols="50"></textarea></span><br><br style="line-height:8px"><div class="sign-in-submit" style="padding-left:145px;"><input type="button" name="accept" class="btnLogLogin floatLeft"  id="accept"  value="Chấp nhận"/><span class="sign-in-lost-password"><input type="submit" name="no_thank" class="btnLogLogin floatLeft" style="margin-left:20px"  id="no_thank"  value="Hủy bỏ"/></span></div></div></div></form>', message_all , 1, 'auto');
	//jQuery.blockUI({ message:  '', css: { border:'none', padding:0} });
	jQuery('#overlay').click(function () { 	  							   
		Bm.hide_all_popup();		
	});	
	
	jQuery('#no_thank').click(function() {		
		Bm.hide_all_popup();	
		return false;
	});		
	
	
	jQuery('#accept').click(function() { 	
	 if(getValueId('date_ban')=='' && getValueId('type_lock')==1)
	 {
		log_faile ('Số ngày khóa nick không được để trống');		
		return false;
	 }
	jQuery.post(BASE_URL+"ajax.php?act=admin&code=ban_nick", {
	ban_date: getValueId('date_ban'),
	type_lock: getValueId('type_lock'),
	user_id: user_id,
	user_name: user_name,
	reason_lock: getValueId('reason_lock')
	},
	function(msg){			
	if(msg == 'not_login')
		{			
			login_error();
			return false;
		}
	else if(msg == 'no_perm')
		{			
			log_faile('Bạn không có quyền thực hiện chức năng này');
			return false;
		}	
	else if(msg == 'invalid')
		{
			log_faile ('Ngày khóa nick phải là kiểu số và lớn hơn 0');
			return false;					
		}		
	else if(msg == 'unsuccess')
		{
			log_faile('Khóa nick "'+user_name+'" không thành công.',5000);			
			Bm.hide_all_popup();
		}
	else if(msg == 'lock_not_cookies' || msg == 'lock_cookies')
		{				
			if(query_string.indexOf("?page%3Duser")>=0)// chay trong admin
			{						
				location.reload();
			}
			else{//chay ngoai thanh vien					
				window.location = BASE_URL;
				return;	
			}
		}
	else
		{							
			if(query_string.indexOf("?page%3Duser")>=0)// chay trong admin
			{						
				log_success('Bạn đã khóa nick "'+user_name+'" thành công.',5000);
				jQuery('#'+user_id).css({'background':'#CCCCCC'});
				jQuery('#'+user_id+'_ac_img').html('<img src="style/images/admin/check.gif" title="Mở nick" />');
				jQuery('#'+user_id+'_status').html(msg);
				Bm.hide_all_popup();
			}
			else{//chay ngoai thanh vien					
				location.reload();
			}
		}		
	});
})
}

function fn_add_admin(){	
	var message_all='Phân nhóm cho thành viên';
	var group_options='<select name="group_id" id="group_id">';
	for(var gid in all_groups){
		group_options+='<option value="'+gid+'">'+all_groups[gid]['brief']+'</option>';
	}
	group_options+='</select>';

	Bm.show_popup_message('<form name="frm_ban_nick" id="frm_ban_nick"><div style="width:370px;border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="padding-top:20px; margin-left:35px"><label for="user_name" style="font-weight:normal; width:120px; color:#000">UserName: </label><input maxlength="250" size="10" name="user_name_admin" type="text" id="user_name_admin"/> Hoặc <label for="user_name" style="font-weight:normal; width:120px; color:#000">ID: </label><input maxlength="250" size="10" name="id_admin" type="text" id="id_admin"/></div><div style="padding-top:10px; margin-left:35px"><label for="user_name" style="font-weight:normal; width:120px; color:#000">Thuộc nhóm: </label>'+group_options+'</div><br style="line-height:10px"><div class="sign-in-submit" style="padding-left:70px;"><input type="button" name="accept" class="btnLogLogin floatLeft"  id="accept"  value="Chấp nhận"/><span class="sign-in-lost-password"><input type="submit" name="no_thank" class="btnLogLogin floatLeft" style="margin-left:20px"  id="no_thank"  value="Hủy bỏ"/></span></div></div></div></form>', message_all , 1, 'auto' );
	
				
	jQuery('#overlay').click(function () { 
		Bm.hide_all_popup();
	});	
	jQuery('#no_thank').click(function() { 
		Bm.hide_all_popup();
		return false;
	});
	jQuery('#accept').click(function() { 
		 if(getValueId('id_admin')=='' && getValueId('user_name_admin')==''){
			log_faile ('ID hoặc tên đăng nhập Admin không được để trống');
			return false;
		 }
		jQuery.get("ajax.php?act=admin&code=add_admin", {
		id_admin: getValueId('id_admin'),
		user_name_admin: getValueId('user_name_admin'),
		group_id: getValueId('group_id')
		},
		function(msg){			
		 if(msg == 'no_perm'){			
				log_faile('Bạn không có quyền truy thực hiện chức năng này');
				return false;
		}
		else if(msg == 'no_exist'){
				log_success('Phân nhóm thành công!',5000);
				return false;					
		}	
		else if(msg == 'exist_admin'){
				log_faile ('ID hoặc UserName này trước rồi!');
				return false;					
		}	
		else if(msg == 'invalid'){
				log_faile ('Bạn nhập sai định dạng ID hoặc UserName!');
				return false;					
		}		
		else if(msg == 'unsuccess'){
				log_faile('Phân nhóm không thành công!',5000);
				Bm.hide_all_popup();
		}
		else{
				log_success('Phân nhóm thành công!',5000);
				location.reload();
		}		
		});
	})
}

function grant_permit(ref_id,pid_str,type, user_name){//Phân quyền
	if(type==0)
		//var message_all='Phân quyền cho nhóm "'+all_groups[ref_id]['brief']+'"';
		var message_all='Phân quyền cho nhóm "' + user_name + '"';
	else
		//var message_all='Phân quyền cho thành viên "'+all_users[ref_id]['user_name']+'"';
		var message_all='Phân quyền cho thành viên "' + user_name + '"';
	
	var pid_arr={};
	if(pid_str!='')
	pid_arr=pid_str.split('|');
	
	var permit_list='';
	for(var pid in all_permits){
		permit_list+='<input type="checkbox" style="cursor:pointer" value="'+pid+'" class=".check_permit" ';
		
		for(i in pid_arr){
			if(pid_arr[i]==pid)
			permit_list+=' checked="checked"';
		}
		permit_list+=' id="check_permit'+pid+'" />'+all_permits[pid]['name']+' ('+all_permits[pid]['des']+')<br />';
	}
	
	Bm.show_popup_message('\
			<form name="frm_ban_nick" id="frm_ban_nick">\
			<div style="width:420px; background-color:#fff; padding:1px;" align="left">\
				<div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;">\
					<div style="padding-top:10px; margin-left:35px"><label for="user_name" style="font-weight:normal; width:120px; color:#000">Quyền thao tác:<br /></label>'+permit_list+'</div><br style="line-height:10px">\
					<div class="sign-in-submit" style="padding-left:85px;">\
						<input type="button" name="accept" class="btnLogLogin floatLeft"  id="accept"  value="Chấp nhận"/>\
						<span class="sign-in-lost-password"><input type="submit" name="no_thank" class="btnLogLogin floatLeft" style="margin-left:20px"  id="no_thank"  value="Hủy bỏ"/></span>\
					</div>\
				</div></div></form>', message_all , 1, 'auto' );
	
	
	
	jQuery('#overlay').click(function () { 
	  //jQuery.unblockUI();		
		Bm.hide_all_popup();
	});	
	jQuery('#no_thank').click(function() { 
		//jQuery.unblockUI();
		Bm.hide_all_popup();
		return false;
	});
	jQuery('#accept').click(function(){
		var pids='';
		for(var pid in all_permits){
			if(jQuery('#check_permit'+pid).attr('checked')!=''){
				pids+=(pids!=''?'|':'')+getValueId("check_permit"+pid);
			}
		}
		
		jQuery.get("ajax.php?act=admin&code=grant_permit", {type: type,ref_id: ref_id,pids: pids},
				function(msg){			
					if(msg == 'no_perm'){			
							log_faile('Bạn không có quyền truy thực hiện chức năng này');
							return false;
					}
					else if(msg == 'invalid'){
							if(type==0)
								log_faile ('Nhóm không tồn tại!');
							else
								log_faile ('Người dùng không tồn tại!');
							return false;					
					}
					else if(msg == 'unsuccess'){
							log_faile('Phân quyền không thành công!',5000);
							Bm.hide_all_popup();
					}
					else if(msg == 'success'){
						log_success('Phân quyền thành công!',5000);
						location.reload();
					}		
				}
		);
	})
}

function grant_category(user_id,cid_str, user_name){//Phân quyền thao tác trên danh mục
	//var message_all = 'Chỉ định danh mục được phép thao tác cho '+all_users[user_id]['user_name'];
	var message_all = 'Chỉ định danh mục được phép thao tác cho "'+user_name + '"';
	Bm.show_popup_message('\
		<form name="frm_ban_nick" id="frm_ban_nick">\
				<div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;">\
					<div style="padding-top:10px; margin-left:35px">\
						<label for="user_name" style="font-weight:normal; width:120px; color:#000">Các danh mục: </label>\
							<input maxlength="250" size="40" name="cids" type="text" id="cids" value="'+cid_str+'"/> (VD: 1,2)\
					</div><br style="line-height:10px">\
					<div class="sign-in-submit" style="padding-left:85px;">\
						<input type="button" name="accept" class="btnLogLogin floatLeft"  id="accept"  value="Chấp nhận"/>\
						<span class="sign-in-lost-password"><input type="submit" name="no_thank" class="btnLogLogin floatLeft" style="margin-left:20px"  id="no_thank"  value="Hủy bỏ"/></span>\
					</div>\
				</div></div></form>', message_all , 1, 'auto');
	jQuery('#overlay').click(function () { 
		Bm.hide_all_popup();
	});	
	jQuery('#no_thank').click(function() { 
		Bm.hide_all_popup();
		return false;
	});
	
	jQuery('#accept').click(function(){
		var cids= getValueId("cids");
		
		jQuery.get("ajax.php?act=admin&code=grant_category", {user_id: user_id,cids: cids},
				function(msg){			
					if(msg == 'no_perm'){			
							log_faile('Bạn không có quyền truy thực hiện chức năng này');
							return false;
					}
					else if(msg == 'invalid'){
						log_faile ('Người dùng không tồn tại!');
						return false;					
					}
					else if(msg == 'unsuccess'){
						log_faile('Thao tác không thành công!',5000);
						Bm.hide_all_popup();
					}
					else if(msg == 'success'){
						log_success('Thao tác thành công!',5000);
						location.reload();
					}		
				}
		);
	})
}

function resetPas(user_id, user_name){
	var message_all='Khôi phục mật khẩu cho "'+user_name+'"';
	Bm.show_popup_message('<form name="frm_ban_nick" id="frm_ban_nick"><div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><br><span style="margin-left:15px; font-weight:normal">Password: <input type="text" maxlength="100" size="30" id="reset_password" value="123456" /></span><div style="padding-top:8px; margin-left:15px"><label for="user_name" style="font-weight:normal; width:120px; color:#000">Gửi email: </label><input type="checkbox" id="send_email_4_pas"  name="send_email_4_pas" value="on"/></div><br style="line-height:8px"><div class="sign-in-submit" style="padding-left:70px;"><input type="button" name="accept" class="btnLogLogin floatLeft"  id="accept"  value="Chấp nhận"/><span class="sign-in-lost-password"><input type="submit" name="no_thank" class="btnLogLogin floatLeft" style="margin-left:20px"  id="no_thank"  value="Hủy bỏ"/></span></div></div></div></form>',  message_all , 1, 'auto');
	jQuery('#overlay').click(function () { 
		Bm.hide_all_popup();		
	});	
	
	jQuery('#no_thank').click(function() { 
		Bm.hide_all_popup();
		return false;
	});
	jQuery('#accept').click(function() { 
		if(getValueId("reset_password")==''){
		  log_faile ('Mật khẩu không được để trống');
		  return false;
		}
		
		if(getValueId('send_email_4_pas','checked')){
			var jchecked = 'on';
		}
		else{
			var jchecked = 'off';
		}
		jQuery.post(BASE_URL+"ajax.php?act=admin&code=reset_success", {
			checked: jchecked,	
			user_id: user_id,
			pas: getValueId("reset_password")
		},
		function(msg){			
		if(msg == 'not_login')
			{			
				login_error();
				return false;
			}
		else if(msg == 'no_perm')
			{			
				log_faile('Bạn không có quyền thực hiện chức năng này');
				return false;
			}				
		else if(msg == 'unsuccess')
			{
				log_faile('Không reset được mật khẩu',5000);
				return false;
			}
		else
			{
				log_success('Đổi mật khẩu thành công',5000);	
			}		
		});
	})
}

function admin_send_email_active(user_id, user_name)
{
	var message_all='Bạn sẽ gửi email Active tới thành viên "'+ user_name+'"';
		Bm.show_popup_message('<div style="width:520px; border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div style=" height:26px; background-color:#17437a" align="left"><span style=" line-height:26px;color: #fff; padding-left:10px;">Thông báo !</span><img src="style/images/i_close2.gif" width="13" height="13" id="close_box" title="Close..." style="cursor:pointer; padding:2px; margin-top:3px; _margin-top:0px; margin-left:410px; _margin-left:410px; position:absolute" /></div><div style="background:url(style/images/icon_log_login.gif) no-repeat 10px 10px; min-height:99px;_height:99px;"><div style="margin-left:76px; padding-top:20px;">'+message_all+'</div><div style="margin-top:10px;" align="center"><input type="button" name="accept" class="btnLogLogin"  id="accept" value="Đồng Ý" />&nbsp;&nbsp;<input type="button" name="sign_in" class="btnLogOut"  id="no_thank" value="Hủy Bỏ" /></div></div></div>','', 1, 'auto');
		jQuery('#overlay').click(function () { 
			Bm.hide_all_popup();		
		});	
		jQuery('#no_thank').click(function() { 
			Bm.hide_all_popup();
			return false;
		});
		
		jQuery('#close_box').click(function () {
			Bm.hide_all_popup();
		});
	
		closeBlockUI();
		
		jQuery('#accept').click(function() { 
			jQuery.post(BASE_URL+"ajax.php?act=admin&code=send_email_active", {
			user_id: user_id
			},
			function(msg){
			 if(msg == 'not_login')
				{			
					login_error();
					return false;
				}
			 else if(msg == 'no_perm')
				{			
					log_faile ('Bạn có quyền thực hiện chức năng này.');
					return false;
				}			
			 else if (msg != 'unsuccess')
				{					
					log_success('Bạn đã gửi email Active tới thành viên "'+user_name+'" thành công',5000);
				}
				
			}			
		);
	})
}


function check_data(form){
	if(!form.user_sell.checked || form.id_cats.value==0){
		alert('Bạn phải chọn Thành viên bán và chuyên mục bán');
		return false;
	}
	else{
		form.submit();	
	}
	
}


function show_menu_admin_profile_info(){
	jQuery('#drop_down_profi_info').toggle();	
}


function add_up_item_user(user_id, user_name,up_item){	
	show_menu_admin_profile_info();
	var message_all='Cộng số lần up tin cho thành viên "'+user_name+'"';
	jQuery.blockUI({ message: '<form name="frm_ban_nick" id="frm_ban_nick"><div style="width:380px;border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div style=" height:26px; background-color:#17437a" align="left"><span style=" line-height:26px;color: #fff; padding-left:10px;">'+message_all+'</span></div><div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="padding-top:20px; margin-left:35px"><label for="user_name" style="font-weight:normal; width:120px; color:#000">Số lần: </label><input maxlength="6" size="6" value="0"  name="num_up_item" type="text" id="num_up_item"/> <label for="user_name" style="font-weight:normal; color:#000;margin-left:15px">Hiện tại</label> <input size="6" name="num_up_item_dis" value="'+up_item+'" type="text" readonly="true" id="num_up_item_dis"/></div><br><br style="line-height:8px"><div class="sign-in-submit" style="padding-left:100px;"><input type="button" name="accept" class="btnLogLogin floatLeft"  id="accept"  value="Chấp nhận"/><span class="sign-in-lost-password"><input type="submit" name="no_thank" class="btnLogLogin floatLeft" style="margin-left:20px"  id="no_thank"  value="Hủy bỏ"/></span></div></div></div></form>', css: { border:'none', padding:0} });
	jQuery('#overlay').click(function () { 
	  show_menu_admin_profile_info();							   
	  Bm.hide_all_popup();		
	});	
	
	jQuery('#no_thank').click(function() { 
	    show_menu_admin_profile_info();
		Bm.hide_all_popup();		
		return false;
	});		
	
	
	jQuery('#accept').click(function() { 	
	 if(getValueId('num_up_item')=='')
	 {
		log_faile ('Số lần up tin không được để trống');		
		return false;
	 }
	jQuery.post(BASE_URL+"ajax.php?act=admin&code=add_up_item", {	
	up_count: getValueId('num_up_item'),
	user_id: user_id,
	user_name: user_name
	},
	function(msg){			
	if(msg == 'not_login')
		{			
			login_error();
			return false;
		}
	else if(msg == 'no_perm')
		{			
			log_faile('Bạn không có quyền thực hiện chức năng này');
			return false;
		}	
	else if(msg == 'invalid')
		{
			log_faile ('Số lần up tin phải là kiểu số và lớn hơn 0');
			return false;					
		}		
	else if(msg == 'unsuccess')
		{
			log_faile('Cộng số lần up tin cho "'+user_name+'" không thành công.',5000);
			Bm.hide_all_popup();
		}
	else
		{						
			if(query_string.indexOf("?page%3Duser")>=0)// chay trong admin
			{						
				location.reload();
			}
			else{//chay ngoai thanh vien
				Bm.hide_all_popup();	
				show_menu_admin_profile_info();
				jQuery('#num_up_count').html(msg);
				jQuery('#add_poin').html(msg);
				return; 	
			}					
		}		
	});
})
}

function minus_up_item_user(user_id, user_name,up_item){
	show_menu_admin_profile_info();
	var message_all='Trừ số lần up tin cho thành viên "'+user_name+'"';
	jQuery.blockUI({ message: '<form name="frm_ban_nick" id="frm_ban_nick"><div style="width:380px;border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div style=" height:26px; background-color:#17437a" align="left"><span style=" line-height:26px;color: #fff; padding-left:10px;">'+message_all+'</span></div><div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="padding-top:20px; margin-left:35px"><label for="user_name" style="font-weight:normal; width:120px; color:#000">Số lần: </label><input maxlength="6" size="6"  value="0" name="num_up_item" type="text" id="num_up_item"/> <label for="user_name" style="font-weight:normal; color:#000;margin-left:15px">Hiện tại</label> <input size="6" name="num_up_item_dis" value="'+up_item+'" type="text" readonly="true" id="num_up_item_dis"/></div><br><br style="line-height:8px"><div class="sign-in-submit" style="padding-left:100px;"><input type="button" name="accept" class="btnLogLogin floatLeft"  id="accept"  value="Chấp nhận"/><span class="sign-in-lost-password"><input type="submit" name="no_thank" class="btnLogLogin floatLeft" style="margin-left:20px"  id="no_thank"  value="Hủy bỏ"/></span></div></div></div></form>', css: { border:'none', padding:0} });
	jQuery('#overlay').click(function () { 
	  show_menu_admin_profile_info();							   
	  Bm.hide_all_popup();		
	});	
	
	jQuery('#no_thank').click(function() { 
	    show_menu_admin_profile_info();
		Bm.hide_all_popup();		
		return false;
	});		
	
	
	jQuery('#accept').click(function() { 	
	 if(getValueId('num_up_item')=='')
	 {
		log_faile ('Số lần up tin không được để trống');		
		return false;
	 }
	jQuery.post(BASE_URL+"ajax.php?act=admin&code=minus_up_item", {	
	up_count: getValueId('num_up_item'),
	user_id: user_id,
	user_name: user_name
	},
	function(msg){			
	if(msg == 'not_login')
		{			
			login_error();
			return false;
		}
	else if(msg == 'no_perm')
		{			
			log_faile('Bạn không có quyền thực hiện chức năng này');
			return false;
		}	
	else if(msg == 'invalid')
		{
			log_faile ('Số lần up tin phải là kiểu số và lớn hơn 0');
			return false;					
		}		
	else if(msg == 'unsuccess')
		{
			log_faile('Trừ số lần up tin cho "'+user_name+'" không thành công.',5000);
			Bm.hide_all_popup();
		}
	else
		{						
			if(query_string.indexOf("?page%3Duser")>=0)// chay trong admin
			{						
				location.reload();
			}
			else{//chay ngoai thanh vien
				Bm.hide_all_popup();	
				show_menu_admin_profile_info();
				jQuery('#num_up_count').html(msg);
				jQuery('#add_poin').html(msg);
				return; 	
			}					
		}		
	});
})
}

function set_check_proces_bad_content(id, status, note){
	//if(confirm("Bạn sẽ dùng chức năng này chứ?")){		
	var message_all='Thông tin giải quyết lý do';
	var s_status = "";
	
	if(status==1){
		s_status = "checked";
	}
	
	jQuery.blockUI({ message: '<form name="frm_form" id="frm_ban_nick"><div style="width:480px;border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div style=" height:26px; background-color:#17437a" align="left"><span style=" line-height:26px;color: #fff; padding-left:10px;">'+message_all+'</span></div><div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="padding-top:20px; margin-left:35px"><label for="user_name" style="font-weight:normal; width:120px; color:#000">Nội dung: </label><textarea name="note" id="note" cols="60" rows="7">'+note+'</textarea></div><div style="padding-top:20px; margin-left:35px"><label for="user_name" style="font-weight:normal; width:120px; color:#000">Đã xong: </label><input type="checkbox" value="1" id="status" name="status" '+s_status+'></div><br style="line-height:8px"><div class="sign-in-submit" style="padding-left:100px;"><input type="button" name="accept" class="btnLogLogin floatLeft"  id="accept"  value="Chấp nhận"/><span class="sign-in-lost-password"><input type="submit" name="no_thank" class="btnLogLogin floatLeft" style="margin-left:20px"  id="no_thank"  value="Hủy bỏ"/></span></div></div></div></form>', css: { border:'none', padding:0} });
	jQuery('#overlay').click(function () { 							   
	  Bm.hide_all_popup();		
	});	
	
	jQuery('#no_thank').click(function() { 	   
		Bm.hide_all_popup();		
		return false;
	});	
	
	jQuery('#accept').click(function() { 
		 if(getValueId('note')=='')
		 {
			log_faile ('Nhập nội dung đã giải quyết');		
			return false;
		 }
		 
		if(getValueId('status','checked')){
			var jchecked = 1;
		}
		else{
			var jchecked = 0;
		}
		 
		jQuery.post(BASE_URL+"ajax.php?act=admin&code=processed_bad_content", {		
			id: id,
			note:getValueId('note'),
			status: jchecked
		},
		
		function(msg){			
		if(msg == 'no_perm')
			{			
				log_faile('Bạn không có quyền thực hiện chức năng này');
				return false;
			}			
		else if(msg=='success')
			{
				location.reload();
			}		
		});
	});
	//}
}

function fn_tracking_user(user_id, type){
	jQuery.get(BASE_URL+"ajax.php?act=admin&code=tracking_user&id="+user_id+"&type="+type,
			function(msg){			
				if(msg == 'no_perm'){			
						log_faile('Bạn không có quyền truy thực hiện chức năng này');
						return false;
				}				
				else if(msg == 'unsuccess'){
					log_faile('Thao tác không thành công!',5000);
					Bm.hide_all_popup();
				}
				else if(msg == 'success'){
					log_success('Thao tác thành công!',5000);
					location.reload();
				}		
			}
	);
}


function admin_add_tag_search(id,content,hit){	
	var message_all='Thêm Tag Search';
	var type = 'add';
	var id = (id)?id:0;
	var hit = (hit)?hit:0;
	var content = (content)?content:'';
	var str_hit = "";

	if(id!=0 && content!=''){
		message_all='Sửa Tag Search';	
		type = 'edit';
		str_hit = '<div style="padding-top:10px; margin-left:35px"><span style="margin-left:31px"></span><label for="hit" style="font-weight:normal; width:120px; color:#000">Hit: </label><input maxlength="250" size="10" name="hit" value="'+hit+'" type="text" id="hit"/></div>';
	}
	
	var cat_options='<select name="cat_ids" id="cat_ids">';	
		cat_options+=all_cats;	
		cat_options+='</select>';
	
	jQuery.blockUI({ message: '<form name="frm_form" id="frm_form"><div style="width:370px;border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div style=" height:26px; background-color:#17437a" align="left"><span style=" line-height:26px;color: #fff; padding-left:10px;">'+message_all+'</span></div><div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="padding-top:20px; margin-left:35px"><label for="contents" style="font-weight:normal; width:120px; color:#000">Từ khóa: </label><input maxlength="250" size="40" name="contents" type="text" id="contents" value="'+content+'"/></div>'+str_hit+'<div style="padding-top:10px; margin-left:35px"><label for="cat_id" style="font-weight:normal; width:120px; color:#000">Thuộc nhóm: </label>'+cat_options+'</div><br style="line-height:10px"><div class="sign-in-submit" style="padding-left:93px;"><input type="button" name="accept" class="btnLogLogin floatLeft"  id="accept"  value="Chấp nhận"/><span class="sign-in-lost-password"><input type="submit" name="no_thank" class="btnLogLogin floatLeft" style="margin-left:20px"  id="no_thank"  value="Hủy bỏ"/></span></div></div></div></form>', css: { border:'none', padding:0} });
	jQuery('#overlay').click(function () { 
	  Bm.hide_all_popup();		
	});	
	jQuery('#no_thank').click(function() { 
		Bm.hide_all_popup();
		return false;
	});
	jQuery('#accept').click(function() { 
		 if(getValueId('contents')==''){
			log_faile ('Nội dung từ khóa không được để trống');
			return false;
		 }
		 		
		jQuery.get(BASE_URL+"ajax.php?act=admin&code=tag_search", {	
			id:id,
			hit: getValueId('hit'),
			type: type,
			cat_id: getValueId('cat_ids'),
			contents: getValueId('contents')
		},
		function(msg){			
			 if(msg == 'no_perm'){			
				log_faile('Bạn không có quyền truy thực hiện chức năng này');
				return false;
			}
			else if(msg == 'success'){
				location.reload();
				return false;					
			}				
		});
	})
}

function fn_del_tag_search(id,cat_id){
	if(!confirm('Bạn có chắc muốn xóa tag search này không?'))
		return false;
	else{
		jQuery.get(BASE_URL+"ajax.php?act=admin&code=del_tag_search", {	
			id:id,
			cat_id:cat_id
		},
		function(msg){			
			 if(msg == 'no_perm'){			
					log_faile('Bạn không có quyền truy thực hiện chức năng này');
					return false;
			}
			else{
				jQuery('#'+msg).hide();
				Bm.hide_all_popup();
				return true;					
			}				
		});
	}
}

function check_input(id_input){
	if(id_input!=''){
		document.getElementById(id_input).checked = (document.getElementById(id_input).checked==true)?false:true;
	}
}

function show_menu_admin_item_info(){
	jQuery('#drop_down_item_info').toggle();	
}

function fn_click_lock_item(id, type){
	show_menu_admin_item_info();// hide menu admin trong trang detail
	var reason_send = '';
	if(type=='lock'){
			
		jQuery.blockUI({message: '<div style="width:400px;border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left" id="block_mini_message"><div style=" height:26px; background-color:#17437a" align="left"><span style="line-height:26px;color: #fff; padding-left:10px;">Lý do khóa Topic</span></div><div style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="font-weight:normal; margin-left:10px;"><br /><label><input type="checkbox" name="val_0" id="val_0" value="val_0"/>Spam</label><br /><label><input type="checkbox" name="val_1" id="val_1" value="val_1"/>Làm mới tin quá quy định</label><br /><br /><b>Lý do khác:</b></div><textarea name="content_rs_mini" id="content_rs_mini" rows="3" class="textAreReplyFeedback enbac_bbcode" style="margin-left:10px"></textarea><div style=" margin-top:-5px; padding-bottom:5px;" align="right"><div align="right" class="btnAllFeedback" onmouseout="this.className=\'btnAllFeedback\'"  onmouseover="this.className=\'btnAllFeedbackHover\'" style=" margin-right:10px;_margin-right:5px; margin-left:10px;*margin-left:5px; width:50px;float:left;" id="close_reason">Đóng</div><div align="right" class="btnAllFeedback" onmouseout="this.className=\'btnAllFeedback\'"  onmouseover="this.className=\'btnAllFeedbackHover\'" style=" margin-right:10px;_margin-right:5px; width:100px;" id="accept">Gửi lý do</div></div></div></div>',css: { border:'none', padding:0}});		
	setTimeout(function(){jQuery("#content_rs_mini").focus();}, 500);
	jQuery('#close_reason').click(function () { 
		Bm.hide_all_popup();
	}); 
		
		
	}
	else{
		var message_all='Bạn sẽ mở khóa topic này chứ?';
		
		jQuery.blockUI({message: '<div style="width:410px; border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div style=" height:26px; background-color:#17437a" align="left"><span style=" line-height:26px;color: #fff; padding-left:10px;">Thông báo !</span><img src="style/images/i_close2.gif" width="13" height="13" id="close_box" title="Close..." style="cursor:pointer; padding:2px; margin-top:3px; _margin-top:0px; margin-left:300px; _margin-left:300px; position:absolute" /></div><div style="background:url(style/images/icon_log_login.gif) no-repeat 10px 10px; min-height:99px;_height:99px;"><div style="margin-left:76px; padding-top:20px;">'+message_all+'</div><div style="margin-top:10px;" align="center"><input type="button" name="accept" class="btnLogLogin"  id="accept" value="Đồng Ý" />&nbsp;&nbsp;<input type="button" name="sign_in" class="btnLogOut"  id="no_thank" value="Hủy Bỏ" /></div></div></div>', css: { border:'none', padding:0}});
		
	}
	
	jQuery('#overlay').click(function () { 
	  Bm.hide_all_popup();		
	});	
	jQuery('#no_thank').click(function() { 
		Bm.hide_all_popup();
		return false;
	});
	
	jQuery('#close_box').click(function () {
		Bm.hide_all_popup();
	});

	closeBlockUI();
	
	jQuery('#accept').click(function() {
									 
		if(type=='lock'){
			if(getValueId('val_0','checked')){
				reason_send +=' Spam tin';
				if(getValueId('val_1','checked') || getValueId('content_rs_mini') != ""){
					reason_send +='; ';
				}
			}
			
			if(getValueId('val_1','checked')){
				reason_send +=' Làm mới tin quá quy định';
				if(getValueId('content_rs_mini') != ""){
					reason_send +='; ';
				}
			}						
			
			if (getValueId('content_rs_mini') != ""){
				reason_send +=' '+getValueId('content_rs_mini');
			}
			
			if(reason_send==""){			
				log_faile('Bạn chưa cho lý do khóa topic');
				return false;
			}
		}				
											 
		jQuery.post(BASE_URL+"ajax.php?act=admin&code=lock_topic", {
		id: id,
		reason_lock:reason_send,
		type:type
		},
		function(msg){
			if(msg == 'no_perm'){			
				log_faile ('Bạn có quyền thực hiện chức năng này.');
				return false;
			}	
			else{	
				if(msg=="lock"){
					//log_success('Bạn đã khóa topic thành công. Topic này không thể comment và làm mới tin nữa.',5000);										
					Bm.hide_all_popup();
					jQuery('#bound_div_lock').html('<div align="center" class="div_reason_lock">Tin này đã bị khóa</div>');
				}
				else if(msg=="unlock"){
					//log_success('Bạn đã mở topic thành công.',5000);
					Bm.hide_all_popup();
					jQuery("#bound_div_lock").css({display:"none"});
				}
			}
		});
	})
}

function fn_del_reason(id){
	if(!confirm('Bạn có chắc muốn xóa không?')){
		return;
	}
	jQuery.post(BASE_URL+"ajax.php?act=admin&code=del_reason", {
		id: id
		},
		function(msg){
			if(msg == 'no_perm'){			
				log_faile ('Bạn không có quyền thực hiện chức năng này.');
				return false;
			}else if(msg == 'not_login'){
				log_faile ('Chưa đăng nhập.');
				return false;
			}
			else{	
				if(msg=="unsuccess"){
					log_faile ('Không xóa được.');
					return false;							
					
				}
				else{
					
					jQuery("#"+msg).css({display:"none"});
				}
			}
		});
	
}
function fn_del_item(id){
	if(!confirm('Bạn có chắc muốn xóa không?')){
		return;
	}
	jQuery.post(BASE_URL+"ajax.php?act=admin&code=del_item_reason", {
		id: id
		},
		function(msg){
			if(msg == 'no_perm'){			
				log_faile ('Bạn không có quyền thực hiện chức năng này.');
				return false;
			}	
			else if(msg == 'not_login'){
				log_faile ('Chưa đăng nhập.');
				return false;
			}
			else{	
				if(msg=="unsuccess"){
					log_faile ('Không xóa được.');
					return false;							
					
				}
				else{
					
					jQuery("#"+msg).css({display:"none"});
				}
			}
		});
	
}

//kiem duyet san pham
function admin_invalid_item(item_id,receiver_user_id){//kiểm duyệt sp	
	jQuery.blockUI({message: '<div style="width:400px;border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left" id="block_mini_message"><div style=" height:26px; background-color:#17437a" align="left"><span style="line-height:26px;color: #fff; padding-left:10px;">Lý do kiểm duyệt</span></div><div style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="font-weight:normal; margin-left:10px;"><br /><label><input type="checkbox" name="val_0" id="val_0" value="val_0"/>Thiếu ảnh/ảnh không hợp lệ</label><br /><label><input type="checkbox" name="val_1" id="val_1" value="val_1"/>Không có thông tin sản phẩm/địa chỉ</label><br /><label><input type="checkbox" name="val_2" id="val_2" value="val_2"/>Tiêu đề không dấu/ký tự đặc biệt</label><br /><label><input type="checkbox" name="val_3" id="val_3" value="val_3"/>Giá</label><br /><label><input type="checkbox" name="val_4" id="val_4" value="val_4"/>Spam tin</label><br /><label><input type="checkbox" name="val_5" id="val_5" value="val_5"/><span title="Tin bị kiểm duyệt nhưng đưa vào mục Tin theo dõi lừa đảo">Nghi lừa</span></label> (***)<br />  <br /><b>Lý do khác:</b></div><textarea name="content_rs_mini" id="content_rs_mini" rows="3" class="textAreReplyFeedback enbac_bbcode" style="margin-left:10px"></textarea><div style=" margin-top:-5px; padding-bottom:5px;" align="right"><div align="right" class="btnAllFeedback" onmouseout="this.className=\'btnAllFeedback\'"  onmouseover="this.className=\'btnAllFeedbackHover\'" style=" margin-right:10px;_margin-right:5px; margin-left:10px;*margin-left:5px; width:50px;float:left;" id="close_reason">Đóng</div><div align="right" class="btnAllFeedback" onmouseout="this.className=\'btnAllFeedback\'"  onmouseover="this.className=\'btnAllFeedbackHover\'" style=" margin-right:10px;_margin-right:5px; width:100px;" id="send_reason">Gửi lý do</div></div></div></div>',css: { border:'none', padding:0}});		
	setTimeout(function(){jQuery("#content_rs_mini").focus();}, 500);
	jQuery('#close_reason').click(function () { 
		Bm.hide_all_popup();
	}); 
	
	jQuery('#send_reason').click(function () {
		var type_check = 2;
		if(getValueId('content_rs_mini')!="" || jQuery("input:checked").length )
		{
			var reason_send = '';
			
			if(getValueId('val_0','checked')){
				reason_send +=' Thiếu ảnh/ảnh không hợp lệ';
				if(getValueId('val_1','checked') || getValueId('val_2','checked') || getValueId('val_3','checked') || getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('content_rs_mini') != ""){
					reason_send +='; ';
				}
			}
			
			if(getValueId('val_1','checked')){
				reason_send +=' Không có thông tin sản phẩm/địa chỉ';
				if(getValueId('val_2','checked') || getValueId('val_3','checked') || getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('content_rs_mini') != ""){
					reason_send +='; ';
				}
			}
			
			if(getValueId('val_2','checked')){
				reason_send +=' Tiêu đề không dấu/ký tự đặc biệt';
				if (getValueId('val_3','checked') || getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('content_rs_mini') != ""){
					reason_send +='; ';
				}
			}
			
			if (getValueId('val_3','checked')){
				reason_send +=' Giá của sản phẩm không chính xác (bạn đang để giá x00 đồng)';
				if (getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('content_rs_mini') != ""){
					reason_send +='; ';
				}
			}
			
			if (getValueId('val_4','checked')){
				reason_send +=' Spam tin';
				if (getValueId('val_5','checked') || getValueId('content_rs_mini') != ""){
					reason_send +='; ';
				}
			}
			
			if (getValueId('val_5','checked')){
				reason_send +=' Tin bán không trung thực';
				type_check = 3;
				if (getValueId('content_rs_mini') != ""){
					reason_send +='; ';
				}
			}
			
			if (getValueId('content_rs_mini') != ""){
				reason_send +=' '+getValueId('content_rs_mini');
			}						
						
			jQuery.ajax({
			type: "POST",
			url: BASE_URL+"ajax.php?act=admin&code=in_valid",
			data: "type="+type_check+"&id="+item_id+"&reason="+reason_send+"&receiver_user_id="+receiver_user_id,
			success: function(msg) {		
					if(msg == 'not_login'){
						 login_error();
						 return false;
					}
					else if(msg == 'fail_invalid'){
						log_faile('Tin này đã được kiểm duyệt.');
						return false;
					}
					else if(msg == 'no_perm'){
						log_faile('Bạn không có quyền thực hiện chức năng này.');
						return false;
					}
					else if(msg == 'success_invalid'){
						jQuery(".is_invalid").css({display:"none"});
						jQuery(".is_valid").css({display:"inline"});
						jQuery(".msg_alert").css({display:"block"});
												
						jQuery("#invalid_admin").css({display:"none"});						
						jQuery("#valid_admin").css({display:"inline"});
						
						Bm.hide_all_popup();
						return ;
						
					}else {
						
												
						jQuery("#"+msg).css({display:"none"});						
					
						
						Bm.hide_all_popup();
						return ;
						
					}
					
				}
			});
		}
		else
		{
			mini_block_faile('#block_mini_message','Nội dung kiểm duyệt không được để trống.');
			jQuery('#content_rs_mini').focus();
						
		}
	}); 
	jQuery('#overlay').click(function () { 
	  Bm.hide_all_popup();
	});		
}

function invalid_item_mod(user_id,item_id){

	var reason_send = "";
	
		jQuery.blockUI({message: '<div style="width:400px;border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left" id="block_mini_message"><div style=" height:26px; background-color:#17437a" align="left"><span style="line-height:26px;color: #fff; padding-left:10px;">Lý do thông báo tin xấu</span></div><div style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="font-weight:normal; margin-left:10px;"><br /><label><input type="checkbox" name="val_0" id="val_0" value="val_0"/>Sai chuyên mục</label><br /><label><input type="checkbox" name="val_1" id="val_1" value="val_1"/>Tin không phù hợp, sang rongbay.com</label><br /><label><input type="checkbox" name="val_2" id="val_2" value="val_2"/>Đăng/ Up quá nhiều tin, sai quy định đăng tin.</label><br /><label><input type="checkbox" name="val_3" id="val_3" value="val_3"/>Tiêu đề tin không dấu/ký tự đặc biệt.</label><br /><label><input type="checkbox" name="val_4" id="val_4" value="val_4"/>Thiếu ảnh/ảnh không hợp lệ.</label><br /><label><input type="checkbox" name="val_5" id="val_5" value="val_5"/>Không có thông tin SP/người bán.</label><br /><label><input type="checkbox" name="val_6" id="val_6" value="val_6"/>Giá SP không đúng,bạn đang để X00 đồng.</label><br /><br /><b>Lý do khác:</b></div><textarea name="content_rs_mini" id="content_rs_mini" rows="3" class="textAreReplyFeedback enbac_bbcode" style="margin-left:10px"></textarea><div style=" margin-top:-5px; padding-bottom:5px;" align="right"><div align="right" class="btnAllFeedback" onmouseout="this.className=\'btnAllFeedback\'"  onmouseover="this.className=\'btnAllFeedbackHover\'" style=" margin-right:10px;_margin-right:5px; margin-left:10px;*margin-left:5px; width:50px;float:left;" id="close_reason">Đóng</div><div align="right" class="btnAllFeedback" onmouseout="this.className=\'btnAllFeedback\'"  onmouseover="this.className=\'btnAllFeedbackHover\'" style=" margin-right:10px;_margin-right:5px; width:100px;" id="accept">Gửi lý do</div></div></div></div>',css: { border:'none', padding:0}});		
		setTimeout(function(){jQuery("#content_rs_mini").focus();}, 500);
		jQuery('#close_reason').click(function () { 
			Bm.hide_all_popup();
		}); 
	
	
	
	jQuery('#accept').click(function() {
									 
		
		if(getValueId('val_0','checked')){
			reason_send +=' Sai chuyên mục';
			if(getValueId('val_1','checked') || getValueId('val_2','checked') || getValueId('val_3','checked') || getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('val_6','checked') ||  getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if(getValueId('val_1','checked')){
			reason_send +=' Tin không phù hợp, sang rongbay.com';
			if(getValueId('val_2','checked') ||  getValueId('val_3','checked') || getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('val_6','checked') || getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if(getValueId('val_2','checked')){
			reason_send +=' Đăng/ Up quá nhiều tin, sai quy định đăng tin';
			if(getValueId('val_3','checked') || getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('val_6','checked') || getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if(getValueId('val_3','checked')){
			reason_send +=' Tiêu đề tin không dấu/ký tự đặc biệt';
			if(getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('val_6','checked') || getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if(getValueId('val_4','checked')){
			reason_send +=' Thiếu ảnh/ảnh không hợp lệ';
			if(getValueId('val_5','checked') || getValueId('val_6','checked') || getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if(getValueId('val_5','checked')){
			reason_send +=' Không có thông tin SP/người bán';
			if(getValueId('val_6','checked') || getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		

		if(getValueId('val_6','checked')){
			reason_send +=' Giá SP không đúng, bạn đang để X00 đồng';
			if(getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if (getValueId('content_rs_mini') != ""){
			reason_send +=' '+getValueId('content_rs_mini');
		}
		
		if(reason_send==""){			
			log_faile('Bạn chưa nhập lý do!');
			return false;
		}
					
											 
		jQuery.ajax({
			type: "POST",
			url: BASE_URL+"ajax.php?act=admin&code=in_valid",
			data: "id="+item_id+"&reason="+reason_send+"&receiver_user_id="+user_id+"&from=admin",
			success: function(msg) {		
					if(msg == 'not_login'){
						 login_error();
						 return false;
					}
					else if(msg == 'fail_invalid'){
						log_faile('Tin này đã được kiểm duyệt.');
						return false;
					}
					else if(msg == 'dup_invalid'){
						log_faile('Tin này đã được bạn thông báo rồi.');
						return false;
					}
					else if(msg == 'fail'){
						log_faile('Bạn không có quyền thực hiện chức năng này.');
						return false;
					}
					else if(msg == 'empty'){
						log_faile('Bạn chưa nhập lý do.');
						return false;
					}
					else if(msg == 'success_invalid'){
						Bm.hide_all_popup();
						return ;							
					}
					else{// admin dua vao kiem duyet tu list san pham
						jQuery("#inva_"+msg).css({display:"none"});
						jQuery("#va_"+msg).css({display:"inline"});
						Bm.hide_all_popup();
						return ;
					}
					
				}
			});
		
	}); 
	jQuery('#overlay').click(function () { 
	  Bm.hide_all_popup();
	});	
	
}

function change_valid_user(user_id,invalid_time,isRefresh){
	
	show_menu_admin_profile_info();
	
	var text_confirm = 'Bỏ kiểm duyệt thành viên không?';
	
	var message_all='Kiểm duyệt thành viên ';
	
	if(IS_ADMIN){
		var str_content = '<option value="1">Kiểm duyệt theo ngày</option><option value="2">Kiểm duyệt vĩnh viễn</option>';	
	}
	else{
		var str_content = '<option value="1">Kiểm duyệt theo ngày</option>';		
	}
	
	if (invalid_time == 0){
		Bm.show_popup_message('<div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="padding-top:20px; margin-left:15px"><label for="user_name" style="font-weight:normal; width:120px; color:#000">Số ngày kiểm duyệt : </label><input maxlength="250" size="10" name="date_invalid" type="text" id="date_invalid" value="7" /> <select name="type_invalid" id="type_invalid">'+str_content+'</select></div><div style="padding-top:10px;margin-left:85px;"><span style="margin-top:10px;margin-left:15px; font-weight:normal">Lý do:</span><span style="margin-left:5px"><textarea id="reason_invalid" name="reason_invalid"  rows="4" cols="50"></textarea></span><br><br style="line-height:8px"><div class="sign-in-submit" style="padding-left:145px;"><input type="button" name="accept" class="btnLogLogin floatLeft"  id="accept"  value="Chấp nhận"/><span class="sign-in-lost-password"><input type="submit" name="no_thank" class="btnLogLogin floatLeft" style="margin-left:20px"  id="no_thank"  value="Hủy bỏ"/></span></div></div></div>', message_all, 1, 'auto');
		jQuery('#overlay').click(function () { 		  							   
		  Bm.hide_all_popup();		
		});	
		
		jQuery('#no_thank').click(function() {			
			Bm.hide_all_popup();		
			return false;
		});	
		jQuery('#accept').click(function() {
			var reason_invalid = getValueId('reason_invalid');
			fn_post_invalid (user_id,invalid_time,reason_invalid,isRefresh,getValueId('date_invalid'),getValueId('type_invalid'));
			Bm.hide_all_popup();	
		});
	}else{
		if(!confirm(text_confirm))return false;	
		fn_post_invalid (user_id,invalid_time,'',isRefresh,0,0);
	}	
}
function fn_post_invalid (user_id,invalid_time,reason_invalid,isRefresh,date_invalid,type_invalid){
	
	jQuery.post(BASE_URL+"ajax.php?act=user&code=invalid_user", {
	date_invalid: date_invalid,
	type_invalid: type_invalid,
	user_id: user_id,
	invalid_time: invalid_time,
	reason_invalid: reason_invalid
	},
	function(msg) {		
					if(msg == 'no_perm'){
						log_faile('Bạn không có quyền thực hiện chức năng này.');
						return false;
					}
					else {
						jQuery("#"+msg).css({display:"none"});
						(isRefresh)?window.location.reload():'';
						return false;
					}
					
				});
}

function fn_lock_all_item(user_id, type_check) {
	show_menu_admin_profile_info();
	Bm.show_popup_message('<div style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="font-weight:normal; margin-left:10px;"><br /><label><input type="checkbox" name="val_0" id="val_0" value="val_0"/>Thiếu ảnh/ảnh không hợp lệ</label><br /><label><input type="checkbox" name="val_1" id="val_1" value="val_1"/>Không có thông tin sản phẩm/địa chỉ</label><br /><label><input type="checkbox" name="val_2" id="val_2" value="val_2"/>Tiêu đề không dấu/ký tự đặc biệt</label><br /><label><input type="checkbox" name="val_3" id="val_3" value="val_3"/>Giá</label><br /><label><input type="checkbox" name="val_4" id="val_4" value="val_4"/>Spam tin</label><br /><label><input type="checkbox" name="val_5" id="val_5" value="val_5"/><span title="Tin bị kiểm duyệt nhưng đưa vào mục Tin theo dõi lừa đảo">Nghi lừa</span></label> (***)<br />  <br /><b>Lý do khác:</b></div><textarea name="content_rs_mini" id="content_rs_mini" rows="3" class="textAreReplyFeedback enbac_bbcode" style="margin-left:10px"></textarea><div style=" margin-top:-5px; padding-bottom:5px;" align="right"><div align="right" class="btnAllFeedback" onmouseout="this.className=\'btnAllFeedback\'"  onmouseover="this.className=\'btnAllFeedbackHover\'" style=" margin-right:10px;_margin-right:5px; margin-left:10px;*margin-left:5px; width:50px;float:left;" id="close_reason">Đóng</div><div align="right" class="btnAllFeedback" onmouseout="this.className=\'btnAllFeedback\'"  onmouseover="this.className=\'btnAllFeedbackHover\'" style=" margin-right:10px;_margin-right:5px; width:100px;" id="send_reason">Gửi lý do</div></div></div></div>','Lý do kiểm duyệt tất cả Topic', 1, 'auto');
	setTimeout(function(){jQuery("#content_rs_mini").focus();}, 500);
	jQuery('#close_reason').click(function () { 
		Bm.hide_all_popup();
	}); 
	
	jQuery('#send_reason').click(function () {
		var type_check = 2;
		var reason_send = '';
			
		if(getValueId('val_0','checked')){
			reason_send +=' Thiếu ảnh/ảnh không hợp lệ';
			if(getValueId('val_1','checked') || getValueId('val_2','checked') || getValueId('val_3','checked') || getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if(getValueId('val_1','checked')){
			reason_send +=' Không có thông tin sản phẩm/địa chỉ';
			if(getValueId('val_2','checked') || getValueId('val_3','checked') || getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if(getValueId('val_2','checked')){
			reason_send +=' Tiêu đề không dấu/ký tự đặc biệt';
			if (getValueId('val_3','checked') || getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if (getValueId('val_3','checked')){
			reason_send +=' Giá của sản phẩm không chính xác (bạn đang để giá x00 đồng)';
			if (getValueId('val_4','checked') || getValueId('val_5','checked') || getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if (getValueId('val_4','checked')){
			reason_send +=' Spam tin';
			if (getValueId('val_5','checked') || getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if (getValueId('val_5','checked')){
			reason_send +=' Tin bán không trung thực';
			type_check = 3;
			if (getValueId('content_rs_mini') != ""){
				reason_send +='; ';
			}
		}
		
		if (getValueId('content_rs_mini') != ""){
			reason_send +=' '+getValueId('content_rs_mini');
		}	
		
		if(reason_send==""){
			mini_block_faile('#block_mini_message','Nội dung kiểm duyệt không được để trống.');
			jQuery('#content_rs_mini').focus();	
		}
					
		jQuery.ajax({
		type: "POST",
		url: BASE_URL+"ajax.php?act=admin&code=valid_all_item",
		data: "type="+type_check+"&user_id="+user_id+"&reason="+reason_send,
		success: function(msg) {		
				if(msg == 'not_login'){
					 login_error();
					 return false;
				}					
				else if(msg == 'no_perm'){
					log_faile('Bạn không có quyền thực hiện chức năng này.');
					return false;
				}
				else if(msg == 'success'){						
					location.reload();
					return ;
					
				}else{						
					Bm.hide_all_popup();
					return ;
				}
				
			}
		});
		
	}); 
	jQuery('#overlay').click(function () { 
	  Bm.hide_all_popup();
	});		
}

// product hot Tannv add 03/06/2009


function fn_add_product_hot(item_id){	
	var cat_id = document.getElementById('item_cat_product_hot'+item_id).value;
	var start_date = document.getElementById('start_date'+item_id).value;
	var end_date = document.getElementById('end_date'+item_id).value;
	if(!IS_LOGIN){
		login_error();
		return false;
	}
	jQuery.ajax({
		type: "POST",
		url: BASE_URL+"ajax.php?act=admin&code=add_product_hot",
		data: "item_id="+item_id+"&cat_id="+cat_id+"&start_date="+start_date+"&end_date="+end_date,
		success: function(data) {		
				if(data=='not_login') {
					login_error('Bạn phải đăng nhập mới được thực hiện chức năng này.');
					return false;
				}
				else if(data=='no_perm'){
					log_faile ('Bạn không được sử dụng chức năng này.');
					return false;
				}
				else if(data=='dup_item'){
					log_faile ('Tin này đã có trong list!');
					return false;	
				}
				else if(data=='success'){
					document.getElementById('box_cat_product_hot'+item_id).style.display='none';
					log_success ('Tin đã được cho vào product hot!');
					
				}
				else
				{
					log_faile ('Không thành công!');
					return false;	
				}
				
			}
		});
}
function del_product_hot(cat_id){
	if(confirm('Bạn có chắc chắn muốn xóa không?')){
		jQuery.get(BASE_URL+"ajax.php?act=admin&code=del_product_hot", {	cat_id: cat_id},
		function(msg){			
		if(msg == 'not_login')
			{			
				login_error('Bạn phải đăng nhập mới được thực hiện chức năng này.');
				return false;
			}
		else if(msg == 'no_perm')
			{			
				log_faile('Bạn không có quyền thực hiện chức năng này');
				return false;
			}
		else if(msg == 'success')	{
				log_success ('Đã xoá thành công!');
				document.getElementById('list_item_product_hot'+cat_id).style.display='none';
			}
		else
			{																					
				log_faile ('Không thành công!');
				return false;	
			}		
		});
	}
	else{
		return false;	
	}
}
function del_item_product_hot(item_id,cat_id){
	if(confirm('Bạn có chắc chắn muốn xóa không?')){
		jQuery.get(BASE_URL+"ajax.php?act=admin&code=del_item_product_hot", {	item_id: item_id,cat_id:cat_id},
		function(msg){			
		if(msg == 'not_login')
			{			
				login_error('Bạn phải đăng nhập mới được thực hiện chức năng này.');
				return false;
			}
		else if(msg == 'no_perm')
			{			
				log_faile('Bạn không có quyền thực hiện chức năng này');
				return false;
			}
		else if(msg == 'success')	{
				log_success ('Đã xoá thành công!');
				document.getElementById(cat_id+'_'+item_id).style.display='none';
				
			}
		else
			{																					
				log_faile ('Không thành công!');
				return false;	
			}		
		});
	}
	else{
		return false;	
	}
}

function del_static_cache(cache_file){

	jQuery.get(BASE_URL+"ajax.php?act=admin&code=del_static_cache", {cache_file:cache_file},
	function(msg){			
	if(msg == 'not_login')
		{			
			login_error('Bạn phải đăng nhập mới được thực hiện chức năng này.');
			return false;
		}
	else if(msg == 'no_perm')
		{			
			log_faile('Bạn không có quyền thực hiện chức năng này');
			return false;
		}
	else if(msg == 'success')	{
			log_success ('Đã xoá cache thành công!');
			return false;	
		}
	else
		{																					
			log_faile ('Không thành công!');
			return false;	
		}		
	});
}

function account_same(user_id, user_name){
		show_menu_admin_profile_info();
		var message_all='Thành viên "'+user_name+'"';
		Bm.show_popup_message('<form name="frm_same_nick" id="frm_same_nick"><div style="width:380px;border:1px solid #d1d4d3; background-color:#fff; padding:1px;" align="left"><div id="loginForm" align="left" style=" background:url(style/images/bg_log_faile.gif) repeat-x bottom;"><div style="padding-top:20px; margin-left:35px"><label for="group_name" style="font-weight:normal; width:120px; color:#000">Trùng với Account: </label><input size="25"  value="" name="user_name" type="text" id="user_name"/><br><br><label for="user_name" style="font-weight:normal; width:120px; color:#000">Admin ghi chú </label><textarea id="note" name="note"  rows="4" cols="52"></textarea></div><br style="line-height:8px"><div class="sign-in-submit" style="padding-left:100px;"><input type="button" name="accept" class="btnLogLogin floatLeft"  id="accept"  value="Chấp nhận"/><span class="sign-in-lost-password"><input type="submit" name="no_thank" class="btnLogLogin floatLeft" style="margin-left:20px"  id="no_thank"  value="Hủy bỏ"/></span></div></div></div></form>', message_all, 1, 'auto' );
		
		jQuery('#overlay').click(function () { 
		  Bm.hide_all_popup();		
		});	
		
		jQuery('#no_thank').click(function() { 
			Bm.hide_all_popup();		
			return false;
		});		
		
		
		jQuery('#accept').click(function() { 	
		 if(getValueId('user_name')==''){
			log_faile ('Tên thành viên không được để trống');		
			return false;
		 }
		jQuery.post(BASE_URL+"ajax.php?act=admin&code=account_same", {	
		user_name: getValueId('user_name'),
		user_id: user_id,
		note: getValueId('note')
		},
		function(json){			
		if(json["msg"] == 'not_login'){			
			login_error();
			return false;
		}
		else if(json["msg"] == 'no_perm'){			
			log_faile('Bạn không có quyền thực hiện chức năng này');
			return false;
		}
		else if(json["msg"]=="not_exist"){
			log_faile ('Không tồn tại thành viên này',10000);
			return false;
		}
		else if(json["msg"] == 'exist'){
			log_faile ('Thành viên này đã được đưa vào 1 nhóm gồm: '+json["list_user"]);
			return false;					
		}		
		else{										
			location.reload();				
		}		
		},"json");
	})

}

function del_account_same(user_id){
	if(confirm("Bạn sẽ xóa chứ?")){
		jQuery.post(BASE_URL+"ajax.php?act=admin&code=del_account_same", {		
		user_id: user_id
		},
		
		function(msg){			
		if(msg == 'no_perm'){			
				log_faile('Bạn không có quyền thực hiện chức năng này');
				return false;
			}			
		else{
			jQuery("#account_same_"+msg).hide();
		}		
		});
	}	
}

function del_bill_permit(id) {
	if(confirm("Bạn có chắc chắn xóa quền thao tác hóa đơn đã chọn không ?")){
		Bm.ajax_popup("act=admin&code=del_bill_permit", "", {id: id}, function(res) {
		if(res.intIsOK == 1) {
		    //alert('Xoá thành công');
		    location.reload();
		}
		else {
		    if(res.msg) {
			alert(res.msg);
		    }
		}
	    });
	}
	else {
		return false;
	}
}