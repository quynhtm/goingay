jQuery(document).ready(function($){
	USER_CUSTOMMER.register();
	USER_CUSTOMMER.login();
	USER_CUSTOMMER.changeInfo();
	USER_CUSTOMMER.forgetpass();
	USER_CUSTOMMER.getNewPass();
	
	USER_CUSTOMMER.clickLoginFacebook();
	USER_CUSTOMMER.clickLoginGoogle();
});

USER_CUSTOMMER = {
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
								jAlert('Bạn đăng ký tài khoản thành công! Kiểm tra mail để kích hoạt.', 'Thông báo');
								jQuery("#popup_ok").click(function(){
									jQuery('#frmRegister input').val('');
									window.location.reload();
									return false;
								});
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
		jQuery('.clickLogin, .aRegPost').unbind('click').click(function(){
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
	forgetpass:function(){
		jQuery('.clickForgetPass').click(function(){
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
								jAlert('Thông tin đăng nhập mới được gửi tới mail của bạn.', 'Thông báo');
								jQuery("#popup_ok").click(function(){
									window.location.reload();
								});
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
	getDistrictInforCustomer:function(){
		var customer_province_id = $('#customer_province_id').val();
		if(parseInt(customer_province_id) > 0){
			jQuery.ajax({
				type: "POST",
				url: WEB_ROOT + '/thong-tin-quan-huyen-cua-khach.html',
				data: {customer_province_id : customer_province_id},
				dataType: 'json',
				success: function(res) {
					if(res.isIntOk === 1){
						$('#customer_district_id').html(res.html_option);
					}else{
						jAlert(res.msg, 'Thông báo');
					}
				}
			});
		}
	},
	changePassCustomer:function(){
		var customer_password = $('#customer_password').val();
		jConfirm('Bạn muốn thay đổi mật khẩu [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
			if(r && customer_password != ''){
				jQuery.ajax({
					type: "POST",
					url: WEB_ROOT + '/thay-doi-mat-khau.html',
					data: {customer_password : customer_password},
					dataType: 'json',
					success: function(res) {
						jAlert(res.msg, 'Thông báo');
					}
				});
			}
		});
	},
	setTopItems:function(item_id){
		jConfirm('Bạn muốn up top tin đăng này? [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
			if(r && parseInt(item_id) > 0){
				jQuery.ajax({
					type: "POST",
					url: WEB_ROOT + '/up-top-tin-dang.html',
					data: {item_id : item_id},
					dataType: 'json',
					success: function(res) {
						jAlert(res.msg, 'Thông báo');
					}
				});
			}
		});
	},
	removeItems:function(item_id){
		jConfirm('Bạn thực sự muốn xóa tin này? [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
			if(r && parseInt(item_id) > 0){
				jQuery.ajax({
					type: "POST",
					url: WEB_ROOT + '/xoa-tin-dang.html',
					data: {item_id : item_id},
					dataType: 'json',
					success: function(res) {
						if(res.isIntOk == 1){
							jAlert(res.msg, 'Thông báo');
							window.location.reload();
						}else{
							jAlert(res.msg, 'Thông báo');
						}
					}
				});
			}
		});
	},
	
	//Login Social
	clickLoginFacebook:function(){
		jQuery('#clickLoginFacebook').click(function(){
			$.oauthPopup({
	            path: WEB_ROOT+'/facebooklogin',
				width:800,
				height:570,
	            callback: function(){
	                window.location.reload();
	            }
	        });
		});
	},
	clickLoginGoogle:function(){
		jQuery('#clickLoginGoogle').click(function(){
			$.oauthPopup({
	            path: WEB_ROOT+'/googlelogin',
				width:800,
				height:570,
	            callback: function(){
	                window.location.reload();
	            }
	        });
		});
	},

	//Dat lich set top tu dong
	popupSetupTimeRunDeal: function(idDeal) {
		$('#sys_PopupSetTimeUpDeal').modal('show');
		$('#sys_infor_popup').hide();
		$('#sys_msg_return').hide();
		USER_CUSTOMMER.resetInputPopup();
		USER_CUSTOMMER.removePointer();
		if(idDeal > 0 ){
			var urlAjax = document.getElementById('sys_urlAjaxGetInforShop').value ;
			$('#img_loading_ajax').show();
			$.ajax({
				type: "POST",
				url: urlAjax,
				data: {campaign_id : idDeal},
				responseType: 'json',
				success: function(data) {
					$('#img_loading_ajax').hide();
					if(data.intReturn === 1){
						var infor = data.info;

						//build data edit
						if(infor.dataEdit.length !== 0){
							var editItem = infor.dataEdit;
							//so lần up trong khoang thời gian
							$('#number_up_1').val(editItem.number_up_1);
							$('#number_up_2').val(editItem.number_up_2);
							$('#number_up_3').val(editItem.number_up_3);
							$('#number_up_4').val(editItem.number_up_4);

							//thứ ngày tháng chọn
							$.each(editItem.calendar_up_date, function(date, val_date){
								$('#'+date).prop( "checked", true );
							});

							//setup thời gian chạy
							$.each(editItem.calendar_up_time, function(time, str_time){
								USER_CUSTOMMER.addTime(str_time);
							});
						}

						//show thông tin
						var nameDeal = infor.campain_name+" (Id deal:" + infor.campain_id + ")";
						$('#sys_name_deal_up').html(nameDeal);

						/*var tinhthanhDeal = infor.name_province;
						 $('#sys_tinhthanh_deal_up').html(tinhthanhDeal);*/

						//lươt up deal cua shop
						$('#sys_number_up_shop').html(infor.strNumberUp);
						$('#sys_number_up_can_user_shop').val(infor.numberUpDeal);

						$('#number_up_hold').val(infor.number_up_hold);
						$('#sys_hidden_hold_con_lai').val(infor.number_up_hold);
						$('#hold_con_lai').html(infor.number_up_hold);

						//if(infor.numberUpDeal > 0){
						var button_submit = "<a href='javascript:;' class='btn btn-primary'onclick='USER_CUSTOMMER.submitSetUpTime()' id='submitUptime'>";
						button_submit += "<i class='fa fa-floppy-o'></i> &nbsp;&nbsp;Lưu lại</a>";

						button_submit += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:;' class='btn btn-warning'onclick='USER_CUSTOMMER.exitPopup()' >";
						button_submit += "&nbsp;&nbsp;Bỏ qua</a>";
						$('#button_submit').html(button_submit);
						/*}else{
						 $('#sys_msg_return').show();
						 $('#sys_msg_return').html('Tài khoản của bạn không đủ điều kiện để thiết lập lịch up');
						 }*/
						var input_hidden = '<input type="hidden" id="campaign_id" name="campaign_id" value="'+infor.campain_id+'"/>';
						input_hidden += '<input type="hidden" id="feed_home_id" name="feed_home_id" value="'+infor.feed_home_id+'"/>';
						input_hidden += '<input type="hidden" id="location_id" name="location_id" value="'+infor.location_id+'"/>';
						input_hidden += '<input type="hidden" id="numberUpDealShop" name="numberUpDealShop" value="'+infor.numberUpDeal+'"/>';
						$('#sys_input_hidden').html(input_hidden);
						$('#sys_infor_popup').show();

					}else{
						$('#sys_msg_return').show();
						$('#sys_msg_return').html(data.msg);
					}
				}
			});
		}
	},

	exitPopup:function(){
		$('#sys_PopupSetTimeUpDeal').modal('hide');
	},

	submitSetUpTime: function(){
		var submitSetup = true;
		$('#sys_msg_return').hide();
		var thu_2 = ($('#thu_2').is(':checked')) ? $('#thu_2').val(2): 0;
		var thu_3 = ($('#thu_3').is(':checked')) ? $('#thu_3').val(3): 0;
		var thu_4 = ($('#thu_4').is(':checked')) ? $('#thu_4').val(4): 0;
		var thu_5 = ($('#thu_5').is(':checked')) ? $('#thu_5').val(5): 0;
		var thu_6 = ($('#thu_6').is(':checked')) ? $('#thu_6').val(6): 0;
		var thu_7 = ($('#thu_7').is(':checked')) ? $('#thu_7').val(7): 0;
		var thu_8 = ($('#thu_8').is(':checked')) ? $('#thu_8').val(8): 0;

		//sys_number_up_can_user_shop
		var numberCanUser = document.getElementById('sys_number_up_can_user_shop').value ;
		var numberUp = document.getElementById('number_up_hold').value ;
		var sys_hidden_hold_con_lai = document.getElementById('sys_hidden_hold_con_lai').value ;

		if(parseInt(numberUp)==0){
			submitSetup = false;
			$('#number_up_hold').focus();
			var thong_bao = '<p>Bạn phải nhập Tổng số lượt dùng cho deal này! </p>';
			$('#sys_msg_return').show();
			$('#sys_msg_return').html(thong_bao);
		}

		if(parseInt(numberCanUser) + parseInt(sys_hidden_hold_con_lai) < parseInt(numberUp)){
			submitSetup = false;
			$('#number_up_hold').focus();
			var thong_bao = '<p>Bạn phải nhập lượt up dành cho deal này <= số lượt up có thể dùng </p>';
			$('#sys_msg_return').show();
			$('#sys_msg_return').html(thong_bao);
		}

		if(submitSetup){
			if(thu_2 == 0 && thu_3 == 0 && thu_4 == 0 && thu_5 == 0 && thu_6 == 0 && thu_7 == 0 && thu_8 == 0){
				var thong_bao_thu = 'Bạn phải chọn ngày để chạy up tự động!';
				$('#sys_msg_return').show();
				$('#sys_msg_return').html(thong_bao_thu);
			}else{
				if (confirm('Bạn có muốn lập lịch up cho deal này không?')) {
					var urlAjax = document.getElementById('sys_urlAjaxPustUpTimeDeal').value ;
					//$('#button_submit').hide();
					$('#img_loading_ajax').show();
					$.ajax({
						type: "POST",
						url: urlAjax,
						data: jQuery('#form_uptime').serializeArray(),
						responseType: 'json',
						success: function(data) {
							$('#button_submit').show();
							$('#img_loading_ajax').hide();
							if(data.intReturn === 1){
								alert(data.msg);
								$('#sys_PopupSetTimeUpDeal').modal('hide');
								window.location.reload();
							}else{
								$('#sys_msg_return').show();
								$('#sys_msg_return').html(data.msg);
							}
						}
					});
				}
			}
		}
	},

	setUpTime: function(){
		$('#sys_msg_return').hide();
		var total_up = 0;
		var number_up_hold = parseInt(document.getElementById('number_up_hold').value);
		if(isNaN(number_up_hold)){
			$('#sys_msg_return').show();
			$('#sys_msg_return').html('yêu cầu nhập số');
			$('#number_up_hold').focus().val(0);
			return;
		}else if(number_up_hold == 0){
			$('#sys_msg_return').show();
			$('#sys_msg_return').html('Bạn phải nhập Tổng số lượt dùng cho deal này!');
			$('#number_up_hold').focus().val(0);
			return;
		}

		var limit_1 = parseInt(document.getElementById('number_up_1').value);
		var limit_2 = parseInt(document.getElementById('number_up_2').value);
		var limit_3 = parseInt(document.getElementById('number_up_3').value);
		var limit_4 = parseInt(document.getElementById('number_up_4').value);

		//check trong mot khoang thoi gian so lan up time
		var numberTimeAccess = 12;
		if(parseInt(limit_1) > numberTimeAccess || parseInt(limit_2) > numberTimeAccess || parseInt(limit_3) > numberTimeAccess || parseInt(limit_4) > numberTimeAccess ){
			submitSetup = false;
			var thong_bao = '<p>Trong một khoảng thời gian, số lượt up tin không vượt quá '+numberTimeAccess+' </p>';
			$('#sys_msg_return').show();
			$('#sys_msg_return').html(thong_bao);
		}
		var thong_bao_nhap_so = "Yêu cầu nhập số cho Số lần up tin";
		if(isNaN(limit_1)){
			$('#sys_msg_return').show();
			$('#sys_msg_return').html(thong_bao_nhap_so);
			$('#number_up_1').focus().val(0);
			return;
		}else if(isNaN(limit_2)){
			$('#sys_msg_return').show();
			$('#sys_msg_return').html(thong_bao_nhap_so);
			$('#number_up_2').focus().val(0);
			return;
		}else if(isNaN(limit_3)){
			$('#sys_msg_return').show();
			$('#sys_msg_return').html(thong_bao_nhap_so);
			$('#number_up_3').focus().val(0);
			return;
		}else if(isNaN(limit_4)){
			$('#sys_msg_return').show();
			$('#sys_msg_return').html(thong_bao_nhap_so);
			$('#number_up_4').focus().val(0);
			return;
		}
		total_up = limit_1 + limit_2 +limit_3 + limit_4;
		if(total_up > 0){
			USER_CUSTOMMER.removePointer();
			if(limit_1 > 0){
				USER_CUSTOMMER.buildTimeRun(limit_1,0);
			}
			if(limit_2 > 0){
				USER_CUSTOMMER.buildTimeRun(limit_2,6);
			}
			if(limit_3 > 0){
				USER_CUSTOMMER.buildTimeRun(limit_3,12);
			}
			if(limit_4 > 0){
				USER_CUSTOMMER.buildTimeRun(limit_4,18);
			}
		}else{
			$('#sys_msg_return').show();
			$('#sys_msg_return').html('Bạn chưa nhập số lần up tin trong các khoảng thời gian trên');
		}
	},

	buildTimeRun: function(number,timeStart) {
		var minute_defaul =(number <= 6)? 60 : 15;
		for(var i=0; i<number; i++){
			//set time auto
			var minuteRun = i*minute_defaul;// khoang cach
			var hour = timeStart+(Math.floor(minuteRun/60));
			var str_hour = (hour < 10)? '0'+hour: hour;
			var minute = minuteRun%60;
			var str_minute = (minute < 10)? '0'+minute: minute;
			var time = str_hour+':'+str_minute;
			USER_CUSTOMMER.addTime(time);
		}
	},

	addTime: function(time){
		var imgUptime = document.getElementById('sys_imgUptime').value;//icon di chuyen time
		var pointer = K.create.element({
			style: {
				position: "absolute",
				top: "-12px",
				width: "16px",
				height: "18px",
				cursor: "pointer",
				zIndex:12,
				background: "url('"+imgUptime+"') center no-repeat"
			},
			event: {
				mouseover: function(event) {
					var tooltip = K('tooltip').show();
					pointer.appendChild(tooltip);
					var result = K('result');
					result.innerHTML = "";
					result.appendChild(document.createTextNode(pointer.interval));

				},
				mouseout: function(event) {
					K('tooltip').hide();
				}
			},className:'dragTimeConfig'
		});
		pointer.interval = time ? time : "00:00";
		if (time) {
			var exp = time.split(":");
			pointer.style.left =  (Math.round(38 * exp[0] + 38/60 * exp[1])) + "px";
		}

		K(pointer).initDragDrop({
			onMove: function() {
				var event = this.event;
				var element = this.self;
				var root = K('up_calendar');
				var rootX = K.get.X(root);
				var X = K.get.X(event) - rootX;
				element.style.top = "-12px";

				if (X < 0) {
					element.style.left = "-1px";
				} else if (X > 912) {
					element.style.left =  (912-1)  + "px";
				} else {
					//1 hour = 38px;
					var hour 	=  parseInt(X/38);
					var minute 	=  Math.round((60/38) * Math.round(X - 38 * hour));

					minute = (minute < 10) ? "0" + minute : minute;
					var interval = 1 * hour < 10 ? "0" + hour + ":" + minute : hour + ":" + minute;

					var timeGet = X;
					K(element).first().value = interval;
					var result = K('result');
					result.innerHTML = "";
					result.appendChild(document.createTextNode(interval));
					element.interval = interval;
					element.style.left = (X-1) + "px";
				}
			}
		});

		var store = K.create.element({
			tagName: "input",
			className: "interval",
			attribute: {
				type: "hidden",
				name: "timeSetting[]"
			}
		});
		pointer.appendChild(store);
		K('up_calendar').appendChild(pointer);
		pointer.first().value = pointer.interval;
	},

	removePointer: function(){
		$(".interval").val("");  ;
		$(".dragTimeConfig").hide();
	},

	resetInputPopup: function(){
		$('#number_up_hold').val(0);

		$('#number_up_1').val(0);
		$('#number_up_2').val(0);
		$('#number_up_3').val(0);
		$('#number_up_4').val(0);

		$('#thu_2').prop( "checked", false );
		$('#thu_3').prop( "checked", false );
		$('#thu_4').prop( "checked", false );
		$('#thu_5').prop( "checked", false );
		$('#thu_6').prop( "checked", false );
		$('#thu_7').prop( "checked", false );
		$('#thu_8').prop( "checked", false );

	},
};

(function(jQuery){
	jQuery.oauthPopup = function(options){
		options.windowName = options.windowName || 'ConnectWithOAuth';
        options.windowOptions = options.windowOptions || 'location=0,status=0,width='+options.width+',height='+options.height+',scrollbars=1';
        options.callback = options.callback || function(){
            window.location.reload();
        };
        var that = this;
        that._oauthWindow = window.open(options.path, options.windowName, options.windowOptions);
        that._oauthInterval = window.setInterval(function(){
            if (that._oauthWindow.closed) {
                window.clearInterval(that._oauthInterval);
                options.callback();
            }
        }, 2000);
    };
})(jQuery);