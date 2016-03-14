// JavaScript Document
jQuery(document).ready(function(){  
	
	if(Bm.get_ele('comment_content')){
		jQuery('#comment_content').elastic();
	}
	if(Bm.get_ele('luubut_content')){
		jQuery('#luubut_content').elastic();
	}
	
});

function area_set_auto_resize(eid, rows){
	jQuery(eid).keypress(function(e){
			if(this.style.height)
			this.style.height='';
			
			if(rows<1)
			rows =1;
			
			this.rows = rows-1;
			while(this.scrollHeight > this.clientHeight){
				this.rows +=1;
			}
			
			this.rows +=1;
	});
}


//box reply comment
function show_box_reply_comment(comment_id,parent_id){
	close_box_fast_reply();
	content ="<div class='marginTop10 box_fast_reply'>";
	content +="<div class='padding10' style='border:1px solid #d9d9d9;background-color:#fff'>";
	content +="<textarea name='content_fast_reply_"+comment_id+"' id='content_fast_reply_"+comment_id+"' row='2'></textarea>";
	content +="</div>";
	content +="<div class='paddingTop5'>";
	content +="<a href='javascript:void(0);' class='bt_grey' onclick='fn_new_feedback("+comment_id+",\"content_fast_reply_"+comment_id+"\","+parent_id+");' id = btn_comment_"+comment_id+"><div class='bg_left'><div class='bg_right'>Gửi</div></div></a>";
	content +="<a href='javascript:void(0);' onclick='close_box_fast_reply();' class='bt_grey marginLeft10'><div class='bg_left'><div class='bg_right'>Huỷ</div></div></a>";
	content +="<a onclick=\"load_smiley(event,'btn_fast_reply_"+comment_id+"','content_fast_reply_"+comment_id+"')\" href=\"javascript:void(0)\" class=\"bt_smiley\" style='float:right' id='btn_fast_reply_"+comment_id+"'>Chèn</a>";
	content +="<div class='clear'></div>";
	content +="</div>";
	content +="</div>";
	jQuery('#box_reply_'+comment_id).html(content);
	
	jQuery("#box_reply_"+comment_id).show();
	
	jQuery('#content_fast_reply_'+comment_id).elastic();
	
	jQuery("#content_fast_reply_"+comment_id).focus();
	
	
}
function close_box_fast_reply(){
	jQuery(".fast_box_reply").css('display','none');
}

// function comment
function fn_new_feedback(comment_id,id_content,parent_id,obj){	 
	
    var comment_content = encodeURIComponent(getValueId(id_content));
    
	var parent_id = (parent_id) ? parent_id : comment_id;
	var new_comment = '';
	
	if (!Bm.is_permission()) return false;
    
	if(comment_content == '' || comment_content==encodeURIComponent(document.getElementById(id_content).title)){
		Bm.show_popup_message('Bạn chưa nhập nội dung.', "Thông báo", -1);
		jQuery("#comment_content").focus();
        return false;
    }
    Bm.ajax_popup("act=bm_feedback&code=send_new_comment&nw_item_id="+nw_item_id,"", {
				content : comment_content,
				type	: type,
				comment_id : comment_id
				},
				function(json) {
					msg = '';
					var content = json['content'];   
					var new_comment_id = json['id_comment'];
					
					if(content == 'bad_word')
						msg = 'Nội dung phản hồi có chứa từ bị kiểm duyệt.';
					else if(content == 'no_perm')
						msg = 'Bạn không có quyền thực hiện.';
					else if(content == 'invalid_time')
						msg = 'Sau 30 giây bạn mới được gửi comment mới.';
					else{
						
						if (!parent_id){
							var className = 'class="avatar_overlay50"';
							if (Bm.is_ie6()){
								className = '';
							}
							//style_width = (type == 'mobile') ? 'style="width:580px"' : '' ;
							new_comment = '<div class="comment_item" id="comment_item_'+new_comment_id+'"><div class="avatar50 float_left" style="background:url('+cur_avatar_url_normal+') no-repeat 0 0"><div id="border_ava_'+new_comment_id+'" '+className+'></div></div><div class="float_right paddingLeft10" ><div><span class="c_034b8a"><strong>'+cur_user_name+'</strong></span> <span style="color:#8e908f">Vài giây trước</span></div><div class="paddingTop10 arial12">'+content+'</div></div><div class="clear"></div></div>';
						}
						else{
							var className = 'class="avatar_overlay32_grey"';
							if (Bm.is_ie6()){
								className = '';
							}
							//style_width = (type == 'mobile') ? 'style="width:520px"' : '' ;
							new_comment = '<div class="comment_comment" id="comment_item_'+new_comment_id+'"><div class="avatar32 float_left" style="background:url('+cur_avatar_url_small+') no-repeat 0 0"><div id="border_ava_'+new_comment_id+'" '+className+'"></div></div><div class="float_right paddingLeft5" ><div><span class="c_034b8a"><strong>'+cur_user_name+'</strong></span> <span style="color:#8e908f">Vài giây trước</span></div><div class="paddingTop5 arial12">'+content+'</div></div><div class="clear"></div></div>';
						}
					 }
						
					  if(new_comment != ''){
							jQuery("#total_feedback").html(json['total_feedback']);
							document.getElementById("comment_content").value='Viết bình luận tại đây...';
							
							if (!parent_id){
								jQuery("#list_all_comment").prepend(new_comment);
								fade_to_yellow(255,255,255,"comment_item_"+new_comment_id,0);
								
							}
							else{
								jQuery("#comment_item_list_"+parent_id).append(new_comment);
								
							   // fix_png("#border_ava_"+new_comment_id);
								
								jQuery("#comment_item_list_"+parent_id).show();
								
								jQuery("#box_reply_"+comment_id).html('');
								
								fade_to_yellow(243,243,243,"comment_item_"+new_comment_id,1);
							
							}

					  }
					  else if(msg){
						Bm.show_popup_message(msg, "Thông báo", -1);
						return false;
					  }
				});	
}

function vote_score(id,action,type){
	
	return false;
	 if (!IS_LOGIN){  // chua dang nhap
		Bm.show_access_notify();
		return false;
    }	
    if(IS_BLOCK){
		Bm.show_popup_message('Bạn không có quyền thực hiện chức năng này.', "Thông báo", -1);
        return false;
    } 
	
	Bm.ajax_popup("act=bm_feedback&code=vote_score&comment_id="+id, "POST", {
				action	: action,
				type	: type
	},
	 function (json) {
		  var content = json['content'];  
		  if(content == 'success'){
				//log_faile('Thành công!');
				if(action == 'add'){
					var score = parseInt(jQuery("#score_"+id).text(), 0)+1;
				}
				else if(action == 'sub'){
					var score = parseInt(jQuery("#score_"+id).text(), 0)-1;
				}
				
				score = (score > 0) ? '+'+score : score ;
				jQuery("#score_"+id).html(score);	
				
				return false;
		  } 
		  else if(content == 'duplicate'){
           		Bm.show_popup_message('Bạn đã vote cho comment này rồi.', "Thông báo", -1);
				return false;
		  } 
		  else {
				Bm.show_popup_message('Bạn không có quyền thực hiện.', "Thông báo", -1);
				return false;
		  }
	 });
}

function get_more_comment(id,type){
	Bm.ajax_popup("act=bm_feedback&code=get_more_comment&comment_id="+id,"",{type:type},
				function(json) {
					var html = '';
					var className = 'class="avatar_overlay32_grey"';
				if (Bm.is_ie6()){
					className = '';
				}
					for(v in json){
						var add_sym = (json[v]['score']>0) ? '+' : '';
						html += '<div class="comment_comment" id="comment_item_'+json[v]['id']+'"><div class="vote_panel"><div class="float_left font11 c_5c5c5c"><strong id="score_'+json[v]['id']+'">'+add_sym+json[v]['score']+'</strong> điểm</div>';
                        if(cur_id != json[v]['sender_user_id']){
                        	html += '<a href="javascript:void(0)" onclick="vote_score('+json[v]['id']+',\'add\',\''+type+'\');" class="bt_cong_diem float_left marginLeft5"></a><a href="javascript:void(0)" onclick="vote_score('+json[v]['id']+',\'sub\',\''+type+'\');" class="bt_tru_diem float_left marginLeft10 marginRight10"></a>';
						}
							
                        html += '<div class="clear"></div></div><div class="avatar32 float_left" style="background:url('+json[v]['avatar']+') no-repeat 0 0"><div '+className+'><a href="'+json[v]['link_profile']+'" class="link_block" title="xem profile của '+json[v]['sender_user_name']+'"></a></div></div><div class="float_right paddingLeft5" ><div><a href="'+json[v]['link_profile']+'" class="c_034b8a" title="xem profile của '+json[v]['sender_user_name']+'"><strong>'+json[v]['sender_user_name']+'</strong></a> <span style="color:#8e908f">'+json[v]['create_time']+'</span></div><div class="paddingTop5 arial12">'+json[v]['content_feedback']+'</div>';
						if(cur_id != json[v]['sender_user_id']){
								html += '<div align="right"><a href="javascript:void(0);" class="font11 f_5c5c5c" onclick="show_box_reply_comment('+json[v]['id']+','+id+');">Trả lời</a></div><div id="box_reply_'+json[v]['id']+'" class="fast_box_reply hide_item"></div>';
						}
						html += '</div><div class="clear"></div></div>';
					}
					jQuery("#btn_view_sub_"+id).hide();
					jQuery("#comment_item_list_"+id).prepend(html);
					//fix_png(".avatar_overlay32_grey");
	});
}
(function () {
	document.body.onclick = function(){
		
			jQuery(".smiley_emotion").fadeOut();
		
	};
})();


//load smiley
function load_smiley(event,id,text_area){
	event= window.event || event;
	event.cancelBubble = true;
	var obj = document.getElementById("smiley_div_"+id);
	
	if(obj){
		if(obj.style.display=='none'){
			jQuery("#smiley_div_"+id).fadeIn();
		}else{
			jQuery("#smiley_div_"+id).fadeOut();
			
		}
		return false;
	}
	 var offset = jQuery("#"+id).offset();
	 var top = offset.top+22+"px";
	 var left = offset.left+"px";
	// alert (offset.left + ", " + offset.top);
	var emoticons = '';
	var arr_emo = new Array(':)' , ':(' , ';)' , ':D' , ';;)' , ';))' , ':-/' , ':x' , ':\">' , ':P' , ':-*' , '=((' , ':-O' , 'X(' , ':>' , 'B-)' , ':-S' , '#:-S' , '>:)' , ':((' , ':))' , ':|' , '/:)' , '=))' , 'O:-)' , ':-B' , '=;' ,  'I-)' , '8-|' , 'L-)' , ':-&' , ':-$' , '[-(' , ':O)' , '8-}' , '<:-P' , '(:|' , '=P~' , ':-?' , '#-o' , '=D>' , ':-SS' , '@-)' , ':^o' , ':-w' , ':-<' , '>:P' , '<):)' , '^#(^' , ':)]' , ':-c' , '~X(' , ':-h' , ':-t' , '8->' , 'X_X' , ':!!' , '\\m/' , ':-q' , ':-bd' , '>:D<');
	for (i=1;i<=60;i++){
		
		emoticons +="<a href='javascript:void(0);' onclick ='add_emotions(\""+escape(arr_emo[i-1])+"\",\""+text_area+"\",\""+id+"\")' alt='"+arr_emo[i-1]+"' title='"+arr_emo[i-1]+"' class='float_left emoticons'><img alt='"+arr_emo[i-1]+"' title='"+arr_emo[i-1]+"'  src='style/images/boxmobi/emoticons/"+i+".gif'></a>";
	}
	var div_content = "<div id='smiley_div_"+id+"' style='border:2px solid #075b75;padding:10px; display:none; background:#f5f5f5;left:"+left+";top:"+top+";width:370px;position:absolute;z-index:2' class='smiley_emotion'>"+emoticons+"</div>";
	jQuery(div_content).appendTo("body");
	jQuery("#smiley_div_"+id).fadeIn();
	

}
function add_emotions(emo,text_area,smiley_div){
	var obj = document.getElementById(text_area);
	var obj_smile = document.getElementById("smiley_div_"+smiley_div);
	var emo = unescape(emo);
	if(obj_smile){
		jQuery("#smiley_div_"+smiley_div).fadeOut();
	}
	//var old_val = obj.value;
	if(obj.value == obj.title){
		obj.value = '';
	}
	obj.value = obj.value+' '+emo+' ';
	obj.focus();
}

// comment user

color_user_comment = ""; //class name
function send_comment_user(id){
	var comment_content = encodeURIComponent(getValueId("luubut_content"));
	 if (!IS_LOGIN){  // chua dang nhap
		Bm.show_access_notify();
		return false;
	}
	if(IS_BLOCK){
		    Bm.show_popup_message('Bạn không có quyền thực hiện chức năng này.', "Thông báo", -1);
	    return false;
	} 
	
	if(comment_content == '' || comment_content==encodeURIComponent(document.getElementById('luubut_content').title)){
		    Bm.show_popup_message('Bạn chưa nhập nội dung.', "Thông báo", -1);
		    jQuery("#luubut_content").focus();
	    return false;
	}
	
	Bm.ajax_popup("act=bm_feedback&code=send_new_user_comment","",{
				receiver_user_id:id,
				comment_content:comment_content
				},
	function(json) {
		msg = '';
		var content = json['content'];   
		var new_comment = '';
		var new_user_comment_id = json['id_comment'];
		if(content == 'bad_word')
		    msg = 'Nội dung phản hồi có chứa từ bị kiểm duyệt.';
		else if(content == 'no_perm')
		    msg = 'Bạn không có quyền thực hiện.';
		else if(content == 'mine')
		    msg = 'Bạn không được tự viết lưu bút cho chính mình.';	
		else if(content == 'invalid_time')
		    msg = 'Sau 30 giây bạn mới được gửi comment mới.';
		else{
			var grey = (color_user_comment) ? '_grey' : "";
			var className = 'class="avatar_overlay32'+grey+'"';
			if (Bm.is_ie6()){
				className = '';
		    }
			new_comment = '<div class="luubut_item '+color_user_comment+'" id="luubut_item_'+new_user_comment_id+'"><div class="luubut_item_info"><div class="avatar32 float_left" style="background:url('+cur_avatar_url_small+') no-repeat 0 0"><div id="border_ava_'+new_user_comment_id+'" '+className+'><a href="'+json['user_link']+'" class="link_block" title="xem profile của '+cur_user_name+'"></a></div></div><div class="nick_time float_left"><div><a href="'+json['user_link']+'" class="c_034b8a"><strong>'+cur_user_name+'</strong></a></div><div><span style="color:#8e908f">vài giây trước</span></div></div><div class="clear"></div></div><div class="luubut_item_content arial12">'+content+'</div></div>';
			color_user_comment = (color_user_comment) ? '' : "luubut_item_white";
		}
		if(new_comment != ''){
			document.getElementById("luubut_content").value='Viết lưu bút tại đây...';
			
			jQuery("#luubut_item_list").prepend(new_comment);
		//	fix_png("#border_ava_"+new_user_comment_id);
			if(color_user_comment){
				
				fade_to_yellow(255,255,255,"luubut_item_"+new_user_comment_id,0);
			}
			else{
				
				fade_to_yellow(243,243,243,"luubut_item_"+new_user_comment_id,1);
			}
		}
		if(msg){
		      Bm.show_popup_message(msg, "Thông báo", -1);
		}
		return false;
	});
}
//delete comment

	function delete_comment(comment_id,type){
		if(IS_ADMIN){
			
			Bm.ajax_popup("act=bm_feedback&code=del_comment&comment_id="+comment_id,"",{
					type:type
					},
					function(json) {
						var content = json['content']
						if(content == 'no_perm')
							msg = 'Bạn không có quyền thực hiện.';
						else if(content == 'success'){
							var content_id = "comment_"+type+"_"+comment_id;
							jQuery("#"+content_id).hide();
							return false;	
						}
						else{
							msg = 'Không thành công.';
						}
						if(msg){
							Bm.show_popup_message(msg, "Thông báo", -1);
						}
						return false;	
			});
		}
		else{
			return false;	
		}
	}
	
	
	
	/*CLONE function delete_comment used in SOLO*/
	function so_delete_comment(comment_id,type,table_comment){
		if(IS_ADMIN){
			
			Bm.ajax_popup("act=bm_feedback&code=so_del_comment&comment_id="+comment_id,"",{
					type:type,table_comment:table_comment
					},
					function(json) {
						var content = json['content']
						if(content == 'no_perm')
							msg = 'Bạn không có quyền thực hiện.';
						else if(content == 'success'){
							var content_id = "comment_"+type+"_"+comment_id;
							jQuery("#"+content_id).hide();
							return false;	
						}
						else{
							msg = 'Không thành công.';
						}
						if(msg){
							Bm.show_popup_message(msg, "Thông báo", -1);
						}
						return false;	
			});
		}
		else{
			return false;	
		}
	}