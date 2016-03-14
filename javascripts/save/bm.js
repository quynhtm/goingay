	/*
	 solo prototype;
	 Level 3;
	*/ 
	var Bm = {
	  _store : {
		ajax: {},
		data: {},
		method: {},
		variable: {}
	  },
	  _all_popup: {},
	  _show_popup : {},
	  _active_popup : function(popup_id, title, content, option) {
	
		  if (Bm.is_exists(Bm._all_popup[popup_id])) {
			var popup = Bm.get_ele(popup_id);
			jQuery(popup).remove();
		  }
	
		  var config = {
			background_image : 'style/images/boxmobi/buttons/From-dang-nhap_16.gif',
			auto_hide: 0,
			/*
			  default, center-center,
			  top-left, top-center, top-right,
			  bottom-left, bottom-center, bottom-right
			*/
			position : 'default',
			pos_type : 'absolute',
			/*
			  overlay, one-time, show-hide,
			*/
			type: 'show-hide',
			overlay: {
			  'background-color' : '#000000',
			  'opacity' : '0.9'
			},
			border: {
			  'background-color' : '#bebebe',
			  'padding' : '5px'
			},
			title : {
			  'background-color' : '#034b8a',
			  'color' : '#ffffff',
			  'status': 1,
			  'display' : 'block'
			},
			content : {
			  'width' : '500px',
			  'height': 'auto',
			  'padding' : '20px',
			  'display' : 'block',
			  '-moz-border-radius': '5px',
			  'background':'rgba(255,255,255, 0.24)',
			  'font-size':'12px'
			},
			before: function(){},
			release: function(){},
			onclose: function(){}
		  };
		  //load config;
		  if (Bm.is_exists(option)) {
			for(var o in option) {
			  if(!Object.prototype[o] && Bm.is_exists(option[o])) {
				if (Bm.is_func(option[o])) {
					config[o] = option[o];
				} else if (Bm.is_obj(option[o])) {
				  for (var i in option[o]) {
					var sub_opt = option[o];
					if (!Object.prototype[i] && Bm.is_exists(sub_opt[i])) {
					  config[o][i] = sub_opt[i];
					}
				  }
				} else {
				  config[o] = option[o];
				}
			  }
			}
		  }
		  Bm._all_popup[popup_id] = config.type;
	
		  //get site dimension;
		  var windowHeight = jQuery(window).height();
		  var windowWidth = jQuery(window).width();
		  var pageHeight = jQuery(document).height() ;
		  var pageWidth = jQuery(document).width();
		  //create overlay popup;
		  if (config.type == 'overlay') {
	
			var oPopup = jQuery('<div id=' + popup_id + '> </div>')
			.css({
			  'background-color' : config.overlay['background-color'],
			  'opacity': config.overlay['opacity'],
			  'position' : config.pos_type,
			  'top' : '0px',
			  'left' : '0px',
			  'z-index' : '332',
			  'width' : '100%'
			}).height(pageHeight).appendTo('body');
	
		  } else {
			//detect close button type;
			var close_button, close_button_hover;
			if (config.title.status == 1) {
			  close_button = 'popup-close-button pcb-blue-normal';
			  close_button_hover = 'popup-close-button pcb-blue-hover';
			} else if (config.title.status == -1){
			  close_button = 'popup-close-button pcb-red-normal';
			  close_button_hover = 'popup-close-button pcb-red-hover';
			} else {
			  close_button = 'popup-close-button pcb-orange-normal';
			  close_button_hover = 'popup-close-button pcb-orange-hover';
			}
			var oButton = jQuery('<div></div>')
			.addClass(close_button)
			.mouseover(function(){
			  this.className = close_button_hover;
			}).mouseout(function(){
			  this.className = close_button;
			}).click(function(){
			  Bm._hide_popup(popup_id);
			});
				
				var sTitle = jQuery('<div style="fload: left;">'+title+'</div>');
			if(title) {
				var oTitle = jQuery('<div></div>')
				.css({
				  'padding-left' : '20px',
				  'font-size' : '16px',
				  'font-weight' : 'bold',
				  'height' : '33px',
				  'line-height' : '33px',
				  'cursor' : 'pointer',
				  'display' : config.title['display'],
				  'color' : config.title['color'],
				  'background-color' : config.title['background-color']
				}).append(oButton).append(sTitle).append('<div style="clear: both;"/></div>');
			}
			
			var oContent = jQuery('<div id="popup-container" style="padding: 20px; color: black"></div>')
			.css({
			  'font-size' : config.content['font-size'],
			  //'height' : config.content['height'],
			  //'height' :220, // QuynhTM add
			  'padding' : config.content['padding'],
			  'display' : config.content['display']
			});
	
			var content_popup_id = null;
			var content_popup_state = null;
			if (Bm.is_str(content)) {
			  oContent.html(content);
			} else if (Bm.is_ele(content)) {
			  //store state content visibility;
			  content_popup_id = content.id;
			  content_popup_state = content.style.display;
			  oContent.append(content);
			  content.style.display = "block";
			}
	
			var blockContent = jQuery('<div style="background-color: white"></div>');
	
			var oPopup = jQuery('<div id=' + popup_id + '></div>')
			.css({
			  'background' : 'rgba(255,255,255, 0.24)',
			  'position' : config.pos_type,
			  'padding' : config.border['padding'],
			  'opacity' : '0.4',
			  'border-radius': config.content['-moz-border-radius'],
			  '-moz-border-radius': config.content['-moz-border-radius'],
			  'z-index' : '333',
			  'width' : config.content['width']
			}).append(blockContent.append(oTitle).append(oContent)).appendTo('body').fadeTo("fast", 1);
	
			//store state of content popup;
			if (content_popup_id) {
			  Bm.get_ele(popup_id).content_popup = {
				id : content_popup_id,
				state : content_popup_state
			  };
			}
	
			config.before(oPopup);
			//display popup;
			switch (config.position ) {
			  case 'top-left':
				  oPopup.css({
					'top': 0,
					'left' : 0
				  });
				  break;
			  case 'top-center':
				 oPopup.css({
					'top': 0,
					'left' : (pageWidth - oPopup.width()) / 2
				  });
				  break;
			  case 'top-right':
				  oPopup.css({
					'top': 0,
					'right' : 0
				  });
				  break;
			  case 'center-center':
				 oPopup.css({
					'top':  (windowHeight - oPopup.height()) / 2,
					'left' : (pageWidth - oPopup.width()) / 2
				  });
				  break;
			  case 'bottom-left':
				  oPopup.css({
					'bottom': 0,
					'left' : 0
				  });
				  break;
			  case 'bottom-center':
				  oPopup.css({
					'bottom': 0,
					'left' : (pageWidth - oPopup.width()) / 2
				  });
				  break;
			  case 'bottom-right':
				  oPopup.css({
					'bottom': 0,
					'right' : 0
				  });
				  break;
			  case 'default':
				  oPopup.css({
					'top': Bm.get_top_page() + 92,
					'left' : (pageWidth - oPopup.width()) / 2
				  });
				  break;
			}// end of else;
		  }
	
		  //auto hide;
		  if (config.auto_hide) {
			setTimeout(function() {
				oPopup.fadeTo('show', 0, function() {
					if (config.type != 'show-hide') {
					  jQuery(this).remove();
					} else  {
					  jQuery(this).hide();
					}
				});
			  },
			  config.auto_hide);
		  }
		  Bm.get_ele(popup_id).onclose = config.onclose;
		  config.release(oPopup);
		  return oPopup;
		},
		_hide_popup: function(id) {
		  var popup = Bm.get_ele(id);
		  if (Bm.is_ele(popup)) {
			//remove overlay popup if it exists;
			Bm.hide_popup(popup.overlay_popup);
			//restore state visibility;
			if (Bm.is_exists(popup.content_popup)) {
			  var content_popup = Bm.get_ele(popup.content_popup.id);
			  content_popup.style.display = popup.content_popup.state;
			}
			//remove chaos popup;
			if (Bm._all_popup[id] == 'one-time' || Bm._all_popup[id] == 'overlay') {
			  Bm._all_popup[id] = null;
			  delete Bm._all_popup[id];
			  popup.parentNode.removeChild(popup);
			} else {
			  popup.style.display = "none";
			}
			var onclose = popup.onclose;
			if (Bm.is_func(onclose)) {
				onclose();
			} else if (Bm.is_str(onclose)) {
				eval(onclose);
			}
		  }
		}
	};

	//check every thing;
	Bm.is_arr = function(arr) {
	  return (arr != null && arr.constructor == Array);
	};
	
	Bm.is_str = function(str) {
	  return (str && (/string/).test(typeof str));
	};
	
	Bm.is_func = function(func) {
		return (func != null && func.constructor == Function);	
	};
	
	Bm.is_num = function(num) {
	  return (num != null && num.constructor == Number);
	};
	
	Bm.is_obj = function(obj) {
	  return (obj != null && obj instanceof Object);
	};
	
	Bm.is_ele = function(ele) {
	  return (ele && ele.tagName && ele.nodeType == 1);
	};
	Bm.is_ele_id = function(id) {
		var ele = Bm.get_ele(id);
		return (ele && ele.tagName && ele.nodeType == 1);
	};
	
	Bm.is_exists = function(obj) {
	  return (obj != null && obj != undefined && obj != "undefined");
	};
	
	Bm.is_json = function(){};
	
	Bm.is_blank = function(str) {
	  return (Bm.util_trim(str) == "");
	};
	
	
	Bm.is_mail = function(str) {
	  return (/^[a-z][a-z-_0-9\.]+@[a-z-_=>0-9\.]+\.[a-z]{2,3}$/i).test(Bm.util_trim(str));
	};
	Bm.is_email = function(str) {
		return Bm.is_mail(str);
	};
	
	Bm.is_username = function(str) {
		return (/^[0-9_a-zA-Z]*$/i).test(Bm.util_trim(str)) ;
	};
	
	Bm.is_link = function(str){
	  return (/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/).test(Bm.util_trim(str));
	};
	
	Bm.is_image = function(imagePath){
	  var fileType = imagePath.substring(imagePath.lastIndexOf("."),imagePath.length).toLowerCase();
	  return (fileType == ".gif") || (fileType == ".jpg") || (fileType == ".png") || (fileType == ".jpeg");
	};
	
	Bm.is_flash = function(imagePath){
	  var fileType = imagePath.substring(imagePath.lastIndexOf("."),imagePath.length).toLowerCase();
	  return (fileType == ".swf") || (fileType == ".flv");
	};
	
	Bm.is_phone = function(num) {
		//return (/^(0120|0121|0122|0123|0124|0125|0126|0127|0128|0129|0163|0164|0165|0166|0167|0168|0169|0188|0199|090|091|092|093|094|095|096|097|098|099)(\d{7})$/i).test(num);
		return (/^(01([0-9]{2})|09[0-9])(\d{7})$/i).test(num);
	};
	
	Bm.is_phone2 = function(num) {
		var mvArr = [20, 22, 25, 26, 27, 29, 30, 31, 33, 36, 37, 38,
		             39, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 
		             66, 67, 68, 70, 72, 73, 74, 75, 76, 77, 79, 210, 211, 
		             218, 219, 230, 231, 240, 241, 280, 281, 320, 321, 350, 
		             351, 500, 501, 510, 511, 650, 651, 710, 711, 780];
		
		for( var i = 0; i < mvArr.length; i++ ) {
			var str = "^(84|0)?" + mvArr[i] + "(\\d{7})$";
			var reg = new RegExp( str );
			
			if( reg.test(num) ) 
				return true;
		}
		
		if( (/^((84|0)?(4|8)[0-9]|01([0-9]{2})|09[0-9])(\d{7})$/i).test(num) )	
			return true;
		
		return false;
	};
	
	Bm.is_ff  = function(){
	  return (/Firefox/).test(navigator.userAgent);
	};
	
	Bm.is_ie  = function() {
	  return (/MSIE/).test(navigator.userAgent);
	};
	
	Bm.is_ie6 = function() {
	  return (/MSIE 6/).test(navigator.userAgent);
	};
	
	Bm.is_ie7 = function() {
	  return (/MSIE 7/).test(navigator.userAgent);
	};
	
	Bm.is_ie8 = function() {
	  return (/MSIE 8/).test(navigator.userAgent);
	};
	
	Bm.is_chrome = function(){
		return (/Chrome/).test(navigator.userAgent);
	};

	Bm.is_opera = function() {
	  return (/Opera/).test(navigator.userAgent);
	};
	
	Bm.is_safari = function() {
	  return (/Safari/).test(navigator.userAgent);
	};
	
	Bm.is_permission = function(msg) {
		if (!IS_LOGIN) {
			Bm.show_access_notify(msg?msg:'Bạn chưa đăng nhập hoặc không có quyền thực hiện chức năng này.');
			return false;
		}	
		if(IS_BLOCK) {
			Bm.show_popup_message(msg?msg:'Bạn chưa đăng nhập hoặc không có quyền thực hiện chức năng này.', "Thông báo", -1);
			return false;
		}
		return true;
	};
	
	//working with ajax;
	Bm.ajax_get = function(){};
	Bm.ajax_post = function(){};
	
	Bm.ajax_popup = function(url, method, param, callback, option) {
	  if (!Bm.is_exists(url)) return;
	  var	data = '',
			opt = {
				loading: (Bm.is_obj(option) && Bm.is_func(option.loading)) ? option.loading : Bm.show_loading
			};
	  if(Bm.is_obj(param)) {
		  for (var key in param) {
			if (Object.prototype[key]) continue;
			data += '&' + key + '=' + param[key];
		  }
	  } else if (Bm.is_str(param)) {
		data = '&' + param;
	  }
	  var old_ajax = Bm._store.ajax[url];
	  if (Bm.is_exists(old_ajax) && old_ajax === data) {
		return;
	  } else {
		Bm._store.ajax[url] = data;
	  }
	  data += '&rand=' + Math.random();
	  jQuery.ajax({
		  beforeSend: opt.loading,
		  url : BASE_URL + 'ajax.php?' + url,
		  type: method ? method : 'POST',
		  data: data,
		  dataType: 'json',
		  success: function(xhr) {
			  Bm._store.ajax[url] = null;
			  delete Bm._store.ajax[url];
			  Bm.hide_loading();
			  if (xhr && Bm.is_exists(xhr.intReturn)) {
				switch(xhr.intReturn) {
				  case -1:
					Bm.show_popup_message(xhr.msg, "Thông báo lỗi!", -1);
					break;
				  case 0:
					Bm.show_popup_message(xhr.msg, "Cảnh báo", 0);
					break;
				  case 1:
					Bm.show_popup_message(xhr.msg, "Thông báo", 1);
					break;
				}
			  }
			  if (xhr && Bm.is_exists(xhr.script)) {
				eval(xhr.script);
			  }
			  if(xhr && Bm.is_exists(callback)) {
				callback(xhr);
			  }
		  },
		  error: function(xhr) {
			Bm._store.ajax[url] = null;
			delete Bm._store.ajax[url];
			Bm.hide_loading();
			//Bm.show_popup_message("Lỗi kết nối mạng", "Thông báo lỗi!", -1);
		  }
	  });
	};
	
	Bm.ajax_paging = function (url_path,div_id,curent_url_path, callback, returnDataType) {
		jQuery.jCache.maxSize = 10;
		if(document.getElementById(div_id)) {
			var cache_key 			= escape(url_path);
			var current_cache_key 	= escape(curent_url_path);
	
			if (jQuery.jCache.hasItem(cache_key)) {
				if(current_cache_key!=cache_key) {
					jQuery.jCache.setItem(current_cache_key,document.getElementById(div_id).innerHTML);	
				}
				document.getElementById(div_id).innerHTML=jQuery.jCache.getItem(cache_key);
				return;
			}
			
			jQuery.ajax({
			  url: url_path,
			  cache: false,
			  dataType: (returnDataType)?returnDataType:'text',// kiểm tra loại dữ liệu trả về là gì?
			  success: function(xhr) {
				if(Bm.is_exists(callback)) {					
					callback(xhr);
				}
				else if (xhr!='' && xhr!='undefined') {
					
					if(current_cache_key!=cache_key) {
						jQuery.jCache.setItem(current_cache_key,document.getElementById(div_id).innerHTML);
					}
					jQuery.jCache.setItem(cache_key, xhr);
					document.getElementById(div_id).innerHTML = xhr;
				}
			  }
			});
		}
	};
	
	Bm.ajax_tab = function(){};

	Bm.show_loading = function (txt){
	  txt = Bm.is_str(txt) ? txt : 'Đang tải dữ liệu...';
	  jQuery('.float_loading').remove();
	  jQuery('body').append('<div class="float_loading">'+txt+'</div>');
	  jQuery('.float_loading').fadeTo("fast",0.9);
	  Bm.update_position();
	  jQuery(window).scroll(Bm.updatePosition);
	};
	
	Bm.update_position = function(){
	  if (Bm.is_ie()) {
		jQuery('.mine_float_loading').css('top', document.documentElement['scrollTop']);
	  }
	};
	
	Bm.hide_loading = function() {
	  jQuery('.float_loading').fadeTo("slow",0,function(){jQuery(this).remove();});
	};
	
	//working with popup;
	Bm.show_popup =  function(popup_id, title, content, option) {
	  Bm.hide_all_popup();
	  Bm._active_popup(popup_id, title, content, option);
	};
	
	Bm.hide_popup = function(id) {
		Bm._hide_popup(id);
	};
	
	Bm.show_next_popup = function(popup_id, title, content, option) {
	  Bm._active_popup(popup_id, title, content, option);
	};

	Bm.hide_all_popup = function() {
	  for(var i in Bm._all_popup) {
		if (Object.prototype[i]) continue;
		Bm._hide_popup(i);
	  }
	};
  
	//hide all popup when press esc;
	jQuery(document).keydown(
		function(event) {
			if (event.keyCode == 27) {
				Bm.hide_all_popup();
			}
		}
	);

	Bm.show_overlay_popup = function(popup_id, title, content, option) {
	  Bm.hide_all_popup();
	  Bm._active_popup(
		'overlay-popup',
		'',
		'',
		{
		  type: 'overlay',
		  overlay: Bm.is_exists(option) ? option.overlay : null
		}
	  );
	  Bm._active_popup(popup_id, title, content, option);
	  //store to remove;
	  Bm.get_ele(popup_id).overlay_popup = 'overlay-popup';
	  //update height;
	  Bm.get_ele('overlay-popup').style.height =  jQuery(document).height() + 92 + 'px';
	};
	
	Bm.hide_overlay_popup = function(id) {
	  Bm.hide_popup(id);
	  Bm.hide_popup('overlay-popup');
	};


	Bm.show_popup_message = function(message, title, type, width, height, _auto_hide) {
	
	  var bg_color;
	  if (type == -1) {
		bg_color = '#ba0000';
	  } else if (type == 0) {
		bg_color = '#ec6f00';
	  } else {
		bg_color = '#034b8a';
	  }
	
	  var id_overlay = Bm.get_uuid();
	  Bm._active_popup(id_overlay, "", "", {
		type: "overlay",
		auto_hide: (_auto_hide) ? _auto_hide : 0,
		overlay : {
		  'opacity' : 0.3,
		  'background-color' : '#ffffff'
		}
	  });
	
	  var id_popup = Bm.get_uuid();
	  Bm._active_popup(id_popup, title, message, {
		type: 'one-time',
		auto_hide: (_auto_hide) ? _auto_hide : 0,
		title: {
		  'background-color' : bg_color,
		  'status' : type
		},
		content: {
		  'width' : width ? width : '300px',
		  'height' : height ? height : 'auto'
		}
	  });
	  //store to remove;
	  Bm.get_ele(id_popup).overlay_popup = id_overlay;
	  //update height;
	  Bm.get_ele(id_overlay).style.height =  jQuery(document).height() + 'px';
	};

	Bm.show_access_notify = function(msg) {
	  Bm.show_overlay_popup(
		"popup_access_notify",
		"Thông báo",
		((msg)?msg:Bm.get_ele("access_notify")),
		{
		  title: {
			'background-color' : 'red',
			'status' : -1
		  },
		  content: {
			width: '400px'
		  }
		}
	  );
	};

	Bm.confirm = function(message, callback, callback_data) {
		//halm: update data for callback function :D
		Bm.show_next_popup(
			"popup_confirm",
			"Xác nhận",
			'<div style="font-weight: bold; margin: 6px 0px;">' + message + '</div>' +
			'<a class="bt_grey marginLeft10" style="margin-left: 0px;" href="javascript: Bm.confirm_ok();">' +
				'<div class="bg_left">' +
					'<div class="bg_right">' +
						'Đồng ý' +
					'</div>' +
				'</div>' +
			'</a>' +
			'<a class="bt_grey marginLeft10" href="javascript: Bm.hide_popup(\'popup_confirm\');">' +
				'<div class="bg_left">' +
					'<div class="bg_right">' +
						'Hủy' +
					'</div>' +
				'</div>' +
			'</a>' +
			'<div class="clear"></div>',
			{content: {width: "300px"}}
		);
		Bm._store.method["popup_confirm"] = callback;
		Bm._store.method["popup_confirm_data"] = callback_data;
	};

	Bm.confirm_ok = function(){
		//halm: update data for callback function :D
		Bm._store.method["popup_confirm"](Bm._store.method["popup_confirm_data"]);
		Bm.hide_popup("popup_confirm");
		Bm._store.method["popup_confirm"] = null;
		Bm._store.method["popup_confirm_data"] = null;
		delete Bm._store.method["popup_confirm"];
		delete Bm._store.method["popup_confirm_data"];
	};


	Bm.test_popup = function() {
	   Bm.confirm("test nha'", function(){alert(2)});
		/*
		//show earch popup;
		Bm.show_popup("mot", "mot", "mot", {position: 'top-right'});
		alert(2);
  
		Bm.show_popup("hai", "hai", "hai", {position: 'bottom-left'});
		K.discover(Bm._all_popup);
		alert(2);
  
		Bm.show_next_popup("ba", "ba", "ba", {position: 'bottom-right'});
		alert(2);
  
		//show overlay popup;
		Bm.show_overlay_popup("bon", "bon", "bon", {position: 'bottom-center'});
		alert(2);
  
		Bm.show_overlay_popup("nam", "nam", "nam", {overlay: {'background-color' : 'red'}});
		alert(2);
  
		Bm.show_next_popup("sau", "sau", "sau", {position: 'top-right', content:{width: '300px', height: '500px'}});
		alert(2);
  
		Bm.hide_all_poppup();
		alert(2);
  
		//show earch popup;
		Bm.show_popup("mot", "mot-mot", "mot-mot", {position: 'top-center', content: {width: '100px'}});
		alert(2);
  
		Bm.show_popup("loading", "Loading...", "", {position: 'top-right', content:{display: 'none'}});
		*/
	};

	//Working with something;
	Bm.util_trim = function(str) {
		return (/string/).test(typeof str) ? str.replace(/^\s+|\s+$/g, "") : "";
	};
	
	Bm.util_random = function(a, b) {
		return Math.floor(Math.random() * (b - a + 1)) + a;
	};
	
	Bm.get_ele = function(id) {
		return document.getElementById(id);
	};
	
	Bm.get_uuid = function() {
		return (new Date().getTime() + Math.random().toString().substring(2));
	};

	Bm.get_top_page = function() {
		if (Bm.is_exists(window.pageYOffset)) {
			return window.pageYOffset;
		}
		if (Bm.is_exists(document.compatMode) && document.compatMode != 'BackCompat') {
			return document.documentElement.scrollTop;
		}
		if (Bm.is_exists(document.body)) {
			scrollPos = document.body.scrollTop;
		}
		return 0;
	};

	Bm.get_form = function(form_id) {
		var form = Bm.get_ele(form_id);
	
		if (!Bm.is_ele(form)) return '';
	
		var arr = [];
	
		var inputs = form.getElementsByTagName("input");
	
		for (var i = 0; i < inputs.length; i ++) {
			var item = inputs[i];
			if (item.type != 'button') {
			  arr.push(item.name + "=" + encodeURIComponent(item.value));
			}
		}
	
		var selects = form.getElementsByTagName("select");
	
		for (var i = 0; i < selects.length; i ++) {
			var item = selects[i];
			var key = item.name;
			var value = item.options[item.selectedIndex].value;
			arr.push(key + "=" + encodeURIComponent(value));
		}
	
		var textareas = form.getElementsByTagName("textarea");
	
		for (var i = 0; i < textareas.length; i ++) {
			var item = textareas[i];
			arr.push(item.name + "=" + encodeURIComponent(item.value));
		}
	
		return arr.join("&");
	};




	/*
	  Level 3
	*/

    //message;
    Bm.show_form_sendmessage = function(to_id, to_name) {
	  if (!Bm.is_permission()) return;
	  var form = '<form id="BmSendMessageForm"><div id="bm-send-message"><div class="row"><span class="label">Gửi đến : </span><a onclick="Bm.chooseReceiver()" href="javascript:void(0)"><span class="name_to" id="bm-send-message-to">'+to_name+'</span></a></div><input type="hidden" value="'+to_id+'" name="to" /><div class="row"><span class="label"> Tiêu đề : </span></div><input class="field_input" type="text" name="title" /><div class="row"><span class="label"> Nội dung : </span></div> <textarea class="textarea"  name="content"></textarea> <div class="popup-footer"><a class="bt_grey marginRight5" href="javascript: Bm.send_message();" ><div class="bg_left"><div class="bg_right">Gửi tin</div></div></a><a class="bt_grey" href="javascript: Bm.cancel_message();" ><div class="bg_left"><div class="bg_right">Hủy bỏ</div></div></a><div class="clear"></div></div></div></form>';
      Bm.show_overlay_popup(
        'popup-sendmessage',
        'Gửi tin nhắn',
        form,
        {content: {'width' : '500px'}}
      );
    };

    Bm.cancel_message = function() {
       Bm.get_ele('bm-send-message').style.display = "none";
       Bm.hide_overlay_popup('popup-sendmessage');
    };

    Bm.send_message = function() {
      var form = Bm.get_ele('BmSendMessageForm');
      var valid = true;
      if (!Bm.is_permission() || Bm.is_blank(form['to'].value)) {
        Bm.show_access_notify();
        valid = false;
      }
      if (Bm.is_blank(form['title'].value)) {
        Bm.show_popup_message("Thiếu tiêu đề", "Thông báo !", -1);
        valid = false;
      }
      if (Bm.is_blank(form['content'].value)) {
        Bm.show_popup_message("Thiếu nội dung", "Thông báo !", -1);
        valid = false;
      }
      if (!valid) return;
      var data = Bm.get_form('BmSendMessageForm');
      Bm.ajax_popup('act=send_message', '', data);
      Bm.hide_overlay_popup('popup-sendmessage');
    };

    //follow;
    Bm.do_follow = function(id, name) {
	  var id = parseInt (id);
      if (!Bm.is_permission()) return;
	  if (id && Bm.is_exists(id) && !Bm.is_blank(name) && Bm.is_exists(name)) {
            Bm.ajax_popup(
                'act=follow&code=follow',
                '',
                {'id': id, 'name' : name},
                Bm.update_follow_button
            );
      } else {
        Bm.show_popup_message("Bạn cần đăng nhập để thực hiện chức năng này", "Thông báo", -1, 300);
      }
    };

    Bm.un_follow = function(id, name) {
	  var id = parseInt (id);
	  if (!Bm.is_permission()) return;
      if (id && Bm.is_exists(id) && !Bm.is_blank(name) && Bm.is_exists(name)) {
        Bm.confirm("Bạn muốn bỏ quân tâm đến: " + name, function() {
            Bm.ajax_popup(
                'act=follow&code=unfollow',
                '',
                {'id': id, 'name' : name},
                 Bm.update_follow_button
            );
        });
      } else {
        Bm.show_popup_message('Bạn cần đăng nhập để thực hiện chức năng này', 'Thông báo', -1, 300);
      }
    };

    Bm.update_follow_button = function(xhr) {
        var button = Bm.get_ele(Bm._store.variable["follow_update_button"]);
        button.innerHTML = xhr.data;
        Bm._store.variable["follow_update_button"] = null;
        delete Bm._store.variable["follow_update_button"];
    };

    Bm.store_follow_button = function(object) {
        object.id = Bm.get_uuid();
        Bm._store.variable["follow_update_button"] = object.id;
    };

    //login;
    Bm.show_login_form = function() {
      var login_form = Bm.get_ele('bm_login_form');
      jQuery('#msg_err').html(''); //QuynhTM add
	  login_form.reset();
      Bm.show_overlay_popup(
        'popup_login_form',
        '',
        Bm.get_ele('bm_login_form'),
        {
          title: {
            'display' : 'none'
          },
          content: {
            'padding' : '0px',
            'width' : '350px'
          }
        }
      );
      login_form['user_name'].focus();
    };

    Bm.login_submit = function() {    	
      var login_form = Bm.get_ele('bm_login_form');
      var user = Bm.util_trim(login_form['user_name'].value);
      var pass = Bm.util_trim(login_form['password'].value);
	  var save = login_form['save_login'];
	  var cookie = save.checked ? 'on' : 'off';

      if (Bm.is_blank(user) || Bm.is_blank(pass)) {
        /*Bm.show_popup_message("Đăng nhập không thành công", "Thông báo", -1);
        return false;*/
    	  //QuynhTM add
    	  jQuery('#msg_err').html('<font color="red"> <i>Bạn chưa nhập User_name hoặc Password!</i></font>');
    	  return false;
      } else {
          jQuery.post("ajax.php?act=user&code=login_user",
            {
              'user': user,
              'pass': pass,
              set_cookie: cookie
            },
            function (msg) {
              if (msg == "success") {
                location.reload();
              } else {
                /*Bm.hide_popup('popup_login_form');
                Bm.show_popup_message("Đăng nhập không thành công", "Thông báo", -1);*/
            	  jQuery('#msg_err').html('<font color="red"> <i> Có lỗi khi đăng nhập!</i></font>');
              }
            }
          );
        return false;
      }
    };
	

	//set ussing mobile;
	Bm.set_using_mobile = function(id, mobileTypeId) {
		if (Bm.is_permission()) {
			Bm.ajax_popup('act=common&code=set_using_mobile&mobile_id=' + id + '&mobileTypeId='+mobileTypeId);	
		}
	};
	//set like mobile;
	
	Bm.like_mobile = function(id) {
		if (Bm.is_permission()) {
			Bm.ajax_popup('act=common&code=set_like_mobile&mobile_id=' + id);	
		}
	};
	
	//set
	Bm.goTo = function(name) {
		if(!name) name = 'top';
		
		var url = location.href;
		if(url.match("#.+")) {
			url = url.replace(/\#.+/, '');
		}
		url = url + '#' + name;
		
		document.write('<a href="'+url+'" class="go_top"> Lên trên</a>');
	};
	
	//halm: fade image to hide loading
	Bm.fadeImageLoading = function(obj, speed, width, height) {
	  speed = speed ? speed : 400;
	  jQuery(obj).fadeTo(speed,1,function(){
		if(width){
		  jQuery(obj).parent().css({width:'auto'});
		}
		if(height){
		  jQuery(obj).parent().css({height:'auto'});
		}
	  });
	};
		
	// using to fix with for image;	
	Bm.fix_width_element = function(obj, limit) {
		var width = jQuery(obj).width(),
			height = jQuery(obj).height(),
			max_width = limit || 468;
		if (width > max_width) {
			var ratio = (height / width );
			var new_width = max_width;
			var new_height = (new_width * ratio);
			jQuery(obj).height(new_height).width(new_width);
		}
	};
	
	//convert http://solo.vcmedia.vn/img/product/2010/07/27/776/30776/_1282817156.7462150.gif
	//to 	  http://solo.vcmedia.vn/img/product/2010/07/27/776/30776/140x100_1282817156.7462150.gif
	Bm.getImagesFromOtherSize = function(other_size, full_link_img) {
		if(full_link_img.match(/(\/)([0-9]+x[0-9]+)(_[^\/]*$)/)) {
			return full_link_img.replace(/(\/)([0-9]+x[0-9]+)(_[^\/]*$)/, "/"+other_size+"$3");
		}
		else if(full_link_img.match(/(\/)(_[^\/]*$)/)) { // original size
			return full_link_img.replace(/(\/)(_[^\/]*$)/, "/"+other_size+"$2");
		}
		else return '';
	};
	
	
	
	Bm.ajax_loading_module = function() {
		for(var i = 0 in ajax_loading_module) {
			if(ajax_loading_module[i][0] && ajax_loading_module[i][0] > 0) {
				jQuery.post("parse_request.php",
		            {	
		              'params': ajax_loading_module[i][1]
		            },
		            function (data) {
		            	if(data['block'] > 0)
		            	document.getElementById('block_'+ data['block']).innerHTML = data['html']; 
		            },
		            "json"
		        );
			}
		}
	};

	Bm.generate_price_input = function (textbox_id) {
		var input_string = document.getElementById(textbox_id).value;
		var sLength = input_string.length;
		var new_val = "";
		var str="0123456789";
		for(var j=0;j<sLength;j++)
		{
			if(str.indexOf(input_string.charAt(j))!=-1)
				new_val+=input_string.charAt(j);
		}
		var inputLength = new_val.length;
		input_string = new_val;
		new_val = "";
		var i = 0;
		for(var j=inputLength-1; j>=0; j--)
		{
			i++;
			if(i%3==0 && j>=1)
				new_val='.'+input_string.charAt(j)+new_val;
			else
				new_val=input_string.charAt(j)+new_val;
		}
		document.getElementById(textbox_id).value = new_val;
	};
	
	
	Bm.cookie={		
		set: function(name, value, expires, path, domain, secure) {
		    expires instanceof Date ? expires = expires.toGMTString() : typeof(expires) == 'number' && (expires = (new Date( + (new Date) + expires * 1e3)).toGMTString());
		    
		    if (expires  == undefined) {
				var today = new Date();
				today.setTime( today.getTime() );
				expires = expires * 1000 * 60 * 60 * 24;
				expires = new Date( today.getTime() + (expires) );
			}

		    var r = [name + "=" + escape(value)],
		    s,
		    i;
		    for (i in s = {
		        expires: expires,
		        path: (path == undefined) ? '/' : path,
		        domain: domain
		    }) {
		        s[i] && r.push(i + "=" + s[i])
		    }
		    return secure && r.push("secure"),
		    document.cookie = r.join(";"),
		    true
		},
		//lay cookie
	    get: function(c_name) {
		    if (document.cookie.length > 0) {
		        c_start = document.cookie.indexOf(c_name + "=");
		        if (c_start != -1) {
		            c_start = c_start + c_name.length + 1;
		            c_end = document.cookie.indexOf(";", c_start);
		            if (c_end == -1) c_end = document.cookie.length;
		            return unescape(document.cookie.substring(c_start, c_end))
		        }
		    }
		    return false
		},
		
		del: function( name, path, domain ) {
			if ( Bm.cookie.get( name ) ) document.cookie = name + "=" + ( ( path ) ? ";path=" + path : "") + ( ( domain ) ? ";domain=" + domain : "" ) + ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
		}

		
	};
	
	

	//time_now: server time tai thoi diem load trang. thuong thi bien nay se duoc truyen tu sever ve.
	//time: time truyen vao
	//returnType: Neu ko truyen thi mac dinh se tra ve cả thẻ <span class="timer">, nếu truyền vào 1 thì sẽ trả về thời gian là: 1 phút trước hoặc 1 ngày trước ....
	
	Bm.duration_time = function (time_now, time, returnType) {
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
	
	Bm.area_set_auto_resize = function(obj){
		 
			if(obj.style.height)
				obj.style.height='';

			if(obj.rows<1)
				obj.rows =1;

			obj.rows = obj.rows-1;
			while(obj.scrollHeight > obj.clientHeight){
				obj.rows +=1;
			}

			obj.rows +=1;
		 
	}
	
	Bm.safe_title = function(title){

		title = Bm.post_db_parse_html(title)
		title = Bm.stripUnicode(title)
		
		if(title){
			return title;
		}
		else{
			return "vccorp.vn";
		}
	}
	
	Bm.post_db_parse_html = function(title){
		
		if ( title == "" ){
			return title;
		}

		title = title.replace( "&#39;"   , "'");
		title = title.replace( "&#33;"   , "!");
		title = title.replace( "&#036;"  , "$");
		title = title.replace( "&#124;"  , "|");
		title = title.replace( "&amp;"   , "&");
		title = title.replace( "&gt;"    , ">");
		title = title.replace( "&lt;"    , "<");
		title = title.replace( "&quot;"  , '"');

		//-----------------------------------------
		// Take a crack at parsing some of the nasties
		// NOTE: THIS IS NOT DESIGNED AS A FOOLPROOF METHOD
		// AND SHOULD NOT BE RELIED UPON!
		//-----------------------------------------

		title = title.replace( "/javascript/i" , "j&#097;v&#097;script");
		title = title.replace( "/alert/i"      , "&#097;lert"          );
		title = title.replace( "/about:/i"     , "&#097;bout:"         );
		title = title.replace( "/onmouseover/i", "&#111;nmouseover"    );
		title = title.replace( "/onmouseout/i", "&#111;nmouseout"    );
		title = title.replace( "/onclick/i"    , "&#111;nclick"        );
		title = title.replace( "/onload/i"     , "&#111;nload"         );
		title = title.replace( "/onsubmit/i"   , "&#111;nsubmit"       );
		title = title.replace( "/object/i"   , "&#111;bject"       );
		title = title.replace( "/frame/i"   , "fr&#097;me"       );
		title = title.replace( "/applet/i"   , "&#097;pplet"       );
		title = title.replace( "/meta/i"   , "met&#097;"       );
		title = title.replace( "/embed/i"   , "met&#097;"       );

		return title;
	}
	
	Bm.stripUnicode = function(str) {
		str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
		str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
		str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
		str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
		str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
		str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
		str= str.replace(/đ/g,"d");
		
		str= str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g,"A");
		str= str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g,"E");
		str= str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g,"I");
		str= str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g,"O");
		str= str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g,"U");
		str= str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g,"Y");
		str= str.replace(/Đ/g,"D");
		
		str= str.replace(/[^a-zA-Z0-9\-\_]/g,"-");/* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
		
		str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1-
		str= str.replace(/^\-+|\-+$/g,"");
		return str;
	}
	
	Bm.format_number = function(pnumber){
		
		pnumber = ""+pnumber;
		var input_string = pnumber.replace(/[^\d]*/g,"");
		var new_val = "", inputLength = input_string.length, i = 0;
		if(inputLength > 0)
		for(var j=inputLength-1; j>=0; j--)
		{
			i++;
			if(i%3==0 && j>=1)
			new_val='.'+input_string.charAt(j)+new_val;
			else
			new_val=input_string.charAt(j)+new_val;
		}

		 
		return new_val;
	}
	//QuynhTM add 
	Bm.int_number = function(pnumber){
		var input_string = pnumber.replace(/[^\d]*/g,"");
		var new_val= Number(input_string);
		return new_val;
	}
	
	//Hien thi gia theo format
	
	Bm.show_price = function(number,id_show){
		var strP=Bm.format_number(number);			  	
	  	jQuery('#'+id_show).html(strP);
	  	jQuery('#'+id_show).show();
	}
	
	Bm.join = function(str) {
	  var store = [str];
	  return function extend(other) {
	    if (other != null && 'string' == typeof other ) {
	      store.push(other);
	      return extend;
	    }
	    return store.join('');
	  }
	};
	
	//solo valid

	//solo valid
	Bm.valid = {
			require: 1,
			number: 2,
			email: 3,
			phone: 4,
			phone2: 8,
			min_length: 5,
			max_length: 6,
			username: 7,
			first_element_error: '',
			
			config: {
				type_msg_error: 'alert',//after_obj
				show_all_msg_error: false//Duyá»‡t toÃ n bá»™ element trong máº£ng config Ä‘á»ƒ bÃ¡o lá»—i hay ko
			},
			
			_add_config: function(option) {
				if (Bm.is_exists(option)) {
					for(var o in option) {
					  if(!Object.prototype[o] && Bm.is_exists(option[o])) {
						if (Bm.is_func(option[o])) {
							Bm.valid.config[o] = option[o];
						} else if (Bm.is_obj(option[o])) {
						  for (var i in option[o]) {
							var sub_opt = option[o];
							if (!Object.prototype[i] && Bm.is_exists(sub_opt[i])) {
								Bm.valid.config[o][i] = sub_opt[i];
							}
						  }
						} else {
							Bm.valid.config[o] = option[o];
						}
					  }
					}
				}
			},
			
			_reset: function() {
				Bm.valid.first_element_error = null;
				jQuery('.bm_class_msg_error').remove();
			},
			
			do_valid: function(obj, option) {
				
				Bm.valid._reset();
				Bm.valid._add_config(option);
				
				var id = '', has_error = true;
				
				if(obj) {
					for(id in obj) {
						if(obj[id].length > 0) {
							for(var i in obj[id]) {
								if(Bm.valid.config.show_all_msg_error) {
									if(Bm.valid._do_valid_one_type(id, obj[id][i]) != 2) {
										has_error = false;
										break;
									}
								}
								else {
									if(!Bm.valid._do_valid_one_type(id, obj[id][i])) {
										Bm.valid.focus_element();
										return false;
									}
								}
							}
							
						}
					}
				}
				
				Bm.valid.focus_element();
				return has_error;
			},
			
			_do_valid_one_type: function(id, curent_obj) {
				var has_error = false, temp_value = Bm.get_ele(id).value;
				if(curent_obj[0] == Bm.valid.require) {
					if(Bm.util_trim(temp_value) == "" || (curent_obj[2] != undefined && Bm.util_trim(temp_value) == curent_obj[2])) {
						Bm.valid.show_msg(id, curent_obj[1]);
						has_error = true;
					}
				}
				else if(curent_obj[0] == Bm.valid.number) {
					if(!Bm.is_num(temp_value)) {
						Bm.valid.show_msg(id, curent_obj[1]);
						has_error = true;
					}
				}
				else if(curent_obj[0] == Bm.valid.email) {
					if(Bm.util_trim(temp_value).length > 0 && !Bm.is_mail(temp_value)) {
						Bm.valid.show_msg(id, curent_obj[1]);
						has_error = true;
					}
				}
				else if(curent_obj[0] == Bm.valid.phone) {
					if(Bm.util_trim(temp_value).length > 0 && !Bm.is_phone(temp_value)) {
						Bm.valid.show_msg(id, curent_obj[1]);
						has_error = true;
					}
				} 
				else if(curent_obj[0] == Bm.valid.phone2) {
					if(Bm.util_trim(temp_value).length > 0 && !Bm.is_phone2(temp_value)) {
						Bm.valid.show_msg(id, curent_obj[1]);
						has_error = true;
					}
				}
				else if(Bm.util_trim(temp_value).length > 0 && curent_obj[0] == Bm.valid.min_length) {
					if(Bm.util_trim(temp_value).length < curent_obj[2]) {
						Bm.valid.show_msg(id, curent_obj[1]);
						has_error = true;
					}
				}
				else if(curent_obj[0] == Bm.valid.max_length) {
					if(Bm.util_trim(temp_value).length > 0 && Bm.util_trim(temp_value).length > curent_obj[2]) {
						Bm.valid.show_msg(id, curent_obj[1]);
						has_error = true;
					}
				}
				else if(curent_obj[0] == Bm.valid.username) {					
					if(Bm.util_trim(temp_value).length > 0 && !Bm.is_username(temp_value)) {
						Bm.valid.show_msg(id, curent_obj[1]);
						has_error = true;
					}
				}
				
				if(has_error) return Bm.valid.config.show_all_msg_error;
				
				return 2;
			},
			
			show_msg: function(id, msg) {				
				if(Bm.valid.first_element_error == null) {
					Bm.valid.first_element_error = id;
				}
				
				if(Bm.valid.config.type_msg_error == 'after_obj') {
					jQuery('#' + id).after('<span class="bm_class_msg_error">'+msg+'</span>');
				}
				else {//default lÃ  alert
					alert(msg);
				}
			},
			
			focus_element: function(id) {
				//neu la text hidden thi phai code them
				if(Bm.valid.first_element_error != null) Bm.get_ele(Bm.valid.first_element_error).focus();
			}
			
	};
	
	Bm.numbersonly = function(myfield, e, dec){
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
	};
	

	Bm.numberFormat = function( number, decimals, dec_point, thousands_sep ){
		var n = number, prec = decimals;
		n = !isFinite(+n) ? 0 : +n;
		prec = !isFinite(+prec) ? 0 : Math.abs(prec);
		var sep = (typeof thousands_sep == "undefined") ? '.' : thousands_sep;
		var dec = (typeof dec_point == "undefined") ? ',' : dec_point;
		var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;
		var abs = Math.abs(n).toFixed(prec);
		var _, i;
		if (abs >= 1000) {
			_ = abs.split(/\D/);
			i = _[0].length % 3 || 3;
			_[0] = s.slice(0,i + (n < 0)) +
				  _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
			s = _.join(dec);
		} else {
			s = s.replace(',', dec);
		}
		return s;
	};
	
	Bm.error = {
		  set:function(id, msg, width, cl){
			msg = msg ? msg : '';
			width = (width > 0) ? 'width: '+width+'px;' : '';
			var html = Bm.join
			('<div class="my_msg" style="'+width+' color:red; margin: 5px auto 15px; padding:10px; background:rgb(255, 249, 215); border: 1px solid rgb(226, 200, 34); text-align: center; font-size: 15px;">')
			  (msg)
			('</div>')();
			if(cl){
			  jQuery('#cError', jQuery(cl)).html(html);
			}else{
			  jQuery('#cError').html(html);
			}
			jQuery(id).addClass('error').focus();
		  },
		  close:function(id, cl){
			if(cl){
			  jQuery('#cError', jQuery(cl)).html('');
			}else{
			  jQuery('#cError').html('');
			}
			jQuery(id).removeClass('error');
		  }
	};
	
	Bm.nl2br = function(str, is_xhtml) {
	    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
	    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	};
	
	Bm.print_r = function(obj, id_element) {
		if(id_element) {
			Bm.get_ele(id_element).innerHTML = prettyPrint(obj);
		}
		else {
			jQuery('body').append(prettyPrint(obj));
		}
	};
	
	Bm.delete_memcache = function(key) {
		jQuery.post("ajax.php?act=index&code=clear_cache",
            {	
              'key': key
            },
            function (data) {
            	 if(data.isOK == 1) {
            		 Bm.reload_page();
            	 }else {
            		 alert('Xóa cache thất bại');            	 
            	 }
            },
            "json"
        );
	};
	
	Bm.reload_page = function(time_out) {
		if(time_out == undefined) {
			location.reload();
		}
		else {
			setTimeout(function() {
				location.reload();
			}, time_out);
		}
	};

	Bm.no_submit = function(e) {
		var key, keychar;
		if (window.event)
		   key = window.event.keyCode;
		else if (e)
		   key = e.which;
		else
		   return true;
		keychar = String.fromCharCode(key);
		if(key==13) return false; else return true;
	}





