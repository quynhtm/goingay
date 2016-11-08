jQuery(document).ready(function($){
	MEMBER.register();
	MEMBER.login();
	MEMBER.changeInfo();
	MEMBER.changePass();
	MEMBER.forgetpass();
	MEMBER.getNewPass();
	MEMBER.viewItemOrder();
});

MEMBER = {
	register:function(){
		jQuery('.clickRegister').click(function(){
			jQuery('.content-popup-show').modal('hide');
			jQuery('#sys-popup-register').modal('show');
			jQuery('#btnRegister').click(function(){
				var token = jQuery('#frmRegister input[name="_token"]');
				var email = jQuery('#sys_reg_email');
				var pass = jQuery('#sys_reg_pass');
				var repass = jQuery('#sys_reg_re_pass');
				var full_name = jQuery('#sys_reg_full_name');
				var phone = jQuery('#sys_reg_phone');
				var address = jQuery('#sys_reg_address');
				
				var error = '';
				if(email.val() == ''){
					email.addClass('error');
					error = 'Email không được trống!<br/>';
				}else{
					var regex = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
					var checkMail = regex.test(email.val());
					if(!checkMail){
						email.addClass('error');
						error = 'Email không đúng định dạng!<br/>';
					}else{
						email.removeClass('error');
						error = '';
					}
				}
				if(pass.val() == ''){
					pass.addClass('error');
					error = error + 'Mật khẩu không được trống!<br/>';
				}
				if(repass.val() == ''){
					repass.addClass('error');
					error = error + 'Nhập lại mật khẩu không được trống!<br/>';
				}
				if(pass.val() != repass.val()){
					pass.addClass('error');
					repass.addClass('error');
					error = error + 'Mật khẩu không khớp!<br/>';
				}else{
					if(pass.val() == '' && repass.val() == ''){
						pass.addClass('error');
						repass.addClass('error');
					}else{
						pass.removeClass('error');
						repass.removeClass('error');
					}
				}
				if(full_name.val() == ''){
					full_name.addClass('error');
					error = error + 'Họ tên không được trống!<br/>';
				}else{
					full_name.removeClass('error');
				}
				if(phone.val() == ''){
					phone.addClass('error');
					error = error + 'Điện thoại không được trống!<br/>';
				}else{
					phone.removeClass('error');
				}
				if(address.val() == ''){
					address.addClass('error');
					error = error + 'Địa chỉ không được trống!<br/>';
				}else{
					address.removeClass('error');
				}
				
				if(error != ''){
					jQuery('#error-register').html(error);
				}else{
					//Check ajax
					var url = WEB_ROOT + '/dang-ky.html';
					jQuery('body').append('<div class="loading"></div>');
					jQuery.ajax({
						type: "POST",
						url: url,
						data: "sys_reg_email="+encodeURI(email.val()) + "&sys_reg_pass="+encodeURI(pass.val()) + "&sys_reg_re_pass="+encodeURI(repass.val()) + "&sys_reg_full_name="+encodeURI(full_name.val()) + "&sys_reg_phone="+encodeURI(phone.val()) + "&sys_reg_address="+encodeURI(address.val()) + "&token="+encodeURI(token.val()),
						success: function(data){
							jQuery('body').find('div.loading').remove();
							if(data == ''){
								window.location.reload();
							}else{
								jQuery('#error-register').html(data);
								return false;
							}
						}
					});
				}
			});
		});
	},
	login:function(){
		jQuery('.clickLogin').unbind('click').click(function(){
			jQuery('.content-popup-show').modal('hide');
			jQuery('#sys-popup-login').modal('show');
			jQuery('#btnLogin').click(function(){
				var token = jQuery('#frmLogin input[name="_token"]');
				var email = jQuery('#sys_login_mail');
				var pass = jQuery('#sys_login_pass');
				var error = '';
				if(email.val() == ''){
					email.addClass('error');
					error = 'Email không được trống!<br/>';
				}else{
					var regex = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
					var checkMail = regex.test(email.val());
					if(!checkMail){
						email.addClass('error');
						error = 'Email không đúng định dạng!<br/>';
					}else{
						email.removeClass('error');
						error = '';
					}
				}
				if(pass.val() == ''){
					pass.addClass('error');
					error = error + 'Mật khẩu không được trống!';
				}
				if(error != ''){
					jQuery('#error-login').html(error);
				}else{
					//Check ajax
					var url = WEB_ROOT + '/dang-nhap.html';
					jQuery('body').append('<div class="loading"></div>');
					jQuery.ajax({
						type: "POST",
						url: url,
						data: "sys_login_mail="+encodeURI(email.val()) + "&sys_login_pass="+encodeURI(pass.val()) + "&token="+encodeURI(token.val()),
						success: function(data){
							jQuery('body').find('div.loading').remove();
							if(data == ''){
								window.location.reload();
							}else{
								jQuery('#error-login').html(data);
								return false;
							}
						}
					});
				}
			});
		});
	},
	changeInfo:function(){
		jQuery('#btnChangeInfo').click(function(){
			var email = jQuery('#sys_change_email');
			var full_name = jQuery('#sys_change_full_name');
			var phone = jQuery('#sys_change_phone');
			var address = jQuery('#sys_change_address');
			
			var error = '';
			if(email.val() == ''){
				email.addClass('error');
				error = 'Email không được trống!<br/>';
			}else{
				var regex = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
				var checkMail = regex.test(email.val());
				if(!checkMail){
					email.addClass('error');
					error = 'Email không đúng định dạng!<br/>';
				}else{
					email.removeClass('error');
					error = '';
				}
			}
			if(full_name.val() == ''){
				full_name.addClass('error');
				error = error + 'Họ tên không được trống!<br/>';
			}else{
				full_name.removeClass('error');
			}
			if(phone.val() == ''){
				phone.addClass('error');
				error = error + 'Điện thoại không được trống!<br/>';
			}else{
				phone.removeClass('error');
			}
			if(address.val() == ''){
				address.addClass('error');
				error = error + 'Địa chỉ không được trống!<br/>';
			}else{
				address.removeClass('error');
			}
			
			if(error != ''){
				jQuery('#error-change-info').html(error);
				return false;
			}
		});
	},
	changePass:function(){
		jQuery('#btnChangePass').click(function(){
			
			var email = jQuery('#sys_change_email');
			var pass = jQuery('#sys_change_pass');
			var repass = jQuery('#sys_change_re_pass');
			
			var error = '';
			if(email.val() == ''){
				email.addClass('error');
				error = 'Email không được trống!<br/>';
			}else{
				var regex = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
				var checkMail = regex.test(email.val());
				if(!checkMail){
					email.addClass('error');
					error = 'Email không đúng định dạng!<br/>';
				}else{
					email.removeClass('error');
					error = '';
				}
			}
			if(pass.val() == ''){
				pass.addClass('error');
				error = error + 'Mật khẩu không được trống!<br/>';
			}
			if(repass.val() == ''){
				repass.addClass('error');
				error = error + 'Nhập lại mật khẩu không được trống!<br/>';
			}
			if(pass.val() != repass.val()){
				pass.addClass('error');
				repass.addClass('error');
				error = error + 'Mật khẩu không khớp!<br/>';
			}else{
				pass.removeClass('error');
				repass.removeClass('error');
			}
			
			if(error != ''){
				jQuery('#error-change-pass').html(error);
				return false;
			}
		});
	},
	forgetpass:function(){
		jQuery('.clickForgetPass').unbind('click').click(function(){
			jQuery('.content-popup-show').modal('hide');
			jQuery('#sys-popup-forgetpass').modal('show');
			jQuery('#btnForgetpass').click(function(){
				var token = jQuery('#frmForgetPass input[name="_token"]');
				var email = jQuery('#sys_forget_mail');
				var error = '';
				if(email.val() == ''){
					email.addClass('error');
					error = 'Email không được trống!<br/>';
				}else{
					var regex = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
					var checkMail = regex.test(email.val());
					if(!checkMail){
						email.addClass('error');
						error = 'Email không đúng định dạng!<br/>';
					}else{
						email.removeClass('error');
						error = '';
					}
				}
				if(error != ''){
					jQuery('#error-forgetpass').html(error);
				}else{
					//Check ajax
					var url = WEB_ROOT + '/quen-mat-khau.html';
					jQuery('body').append('<div class="loading"></div>');
					jQuery.ajax({
						type: "POST",
						url: url,
						data: "sys_forget_mail="+encodeURI(email.val()) + "&token="+encodeURI(token.val()),
						success: function(data){
							jQuery('body').find('div.loading').remove();
							if(data == '1'){
								window.location.reload();
							}else{
								jQuery('#error-forgetpass').html(data);
								return false;
							}
						}
					});
				}
			});
		});
	},
	getNewPass:function(){
		jQuery('#btnChangeNewPass').click(function(){
			
			var pass = jQuery('#sys_change_new_pass');
			var repass = jQuery('#sys_change_new_re_pass');
			var error = '';
			
			if(pass.val() == ''){
				pass.addClass('error');
				error = error + 'Mật khẩu không được trống!<br/>';
			}
			if(repass.val() == ''){
				repass.addClass('error');
				error = error + 'Nhập lại mật khẩu không được trống!<br/>';
			}
			if(pass.val() != repass.val()){
				pass.addClass('error');
				repass.addClass('error');
				error = error + 'Mật khẩu không khớp!<br/>';
			}else{
				pass.removeClass('error');
				repass.removeClass('error');
			}
			
			if(error != ''){
				jQuery('#error-change-new-pass').html(error);
				return false;
			}
		});
	},
	viewItemOrder:function(){
		jQuery('.viewOrder').click(function(){
			var item = jQuery(this).attr('data');
			if(item > 0){
				jQuery('#sys-popup-view-order').modal('show');
				//Check ajax
				var url = WEB_ROOT + '/chi-tiet-don-hang.html';
				jQuery('body').append('<div class="loading"></div>');
				jQuery('#sys-popup-view-order .content-item').html('');
				jQuery.ajax({
					type: "POST",
					url: url,
					data: "item="+encodeURI(item),
					success: function(data){
						jQuery('body').find('div.loading').remove();
						if(data != ''){
							data = jQuery.parseJSON(data);
							jQuery('#sys-popup-view-order .content-item').append(data);
						}
					}
				});
			}
		});
	}
}