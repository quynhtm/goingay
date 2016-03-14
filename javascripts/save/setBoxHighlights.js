var highLights={
		length: 0,
		MAX_CHAR: 125,
		DANG_TIN_BAN: 1,
		DANG_TIN_MUA: 2,
		NEWS_COMMENT: 29,
		VIET_DANH_GIA_COMMENT: 25,
		DANG_TIN_KHUYEN_MAI_COMMENT: 28,
		COMMENT_NETWORK: 18,
		COMMENT_MOBILE: 20,
		COMMENT_ITEM: 17
    };
function initHL() {
	highLights.length = jHighLights.length;
    var i = 0;
    for(i = 0; i < highLights.length; i++) {
		jQuery("#HighLightArea").append(createdHL(jHighLights[i]));
    }
	fix_png(".avatar_overlay50");
}

function createdHL(data) {

    var str = '';
	data.act = parseInt(data.act);
	if(data)
	  switch (data.act) {
	  case highLights.DANG_TIN_BAN:
	  case highLights.DANG_TIN_MUA:
		  str += buildBuySell(data);
		  break;
	  case highLights.VIET_BLAST:
		  str += buildBlast(data);
		  break;
	  case highLights.THICH:
		str += buildLike(data);
		break;
	  case highLights.COMMENT_NEWS:
	  case highLights.COMMENT_ITEM:
	  case highLights.COMMENT_NETWORK:
	  case highLights.COMMENT_MOBILE:
		str+= buildComment(data, data.act);
		break;
	  case highLights.VIET_LUU_BUT:
		str += buildVietluubut(data);
		break;
	  case highLights.YEU_CAU_GAME:
		str += buildYeucaugame(data);
		break;
	  case highLights.DANG_TIN_KHUYEN_MAI:
	  case highLights.NEWS:
		str += buildNews(data, false);
		break;
	  case highLights.DANG_TIN_KHUYEN_MAI_COMMENT:
	  case highLights.NEWS_COMMENT:
		str += buildNews(data, true);
		break;

	  case highLights.VIET_DANH_GIA:
		str += buildVietdanhgia(data, false);
		break;
	  case highLights.VIET_DANH_GIA_COMMENT:
		str += buildVietdanhgia(data, true);
		break;
	  case highLights.POST_GAME:
		str += buildPostGame(data, false);
		break;
	  case highLights.POST_GAME_COMMENT:
		str += buildPostGame(data, true);
		break;
	  default:
		  break;
	  }
    return str;
}


function buildBuySell(data) {

    var str = highLights.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
	str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/g, ' &nbsp;' + data['data']['R_ACTION']);
    str = str.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);


    str = str.replace(/R_COMMENT_COMMENT/, '');

	var commentData = highLights.TEMP_COMMENT_DATA;
	commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
	commentData = commentData.replace(/R_DATA_TITLE/, data['data']['R_DATA_TITLE']);
	commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
    commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_OPTION/,'Giá ' + ((data['data']['item_type'] == 2)? 'mua: ' : 'bán: ') + format_number(data['data']['price']) + ' VNĐ');
    commentData = commentData.replace(/R_DATA_DESC/, data['data']['content_feedback']);

	str = str.replace(/R_COMMENT_DATA/, commentData);

    var commentFooter = highLights.TEMP_COMMENT_FOOTER_3;
		
    var extra1 = highLights.TEMP_EXTRA.replace(/R_LINK/, data['data']['R_IMAGE_LINK']+'&s_cm=1');
    extra1 = extra1.replace(/R_DATA/, 'Viết bình luận');
	
	var extra2 = '';
	if(data['data']['sender_user_name'] != curentUser) {
		var extra2 = highLights.TEMP_EXTRA.replace(/R_LINK/,  'javascript:Bm.show_form_sendmessage(\''+ data['data']['sender_user_id'] +'\', \''+ data['data']['sender_user_name'] +'\')');
		extra2 = extra2.replace(/R_DATA/,  ((data['data']['item_type'] == 2)? 'Bán' : 'Mua') + ' ngay');
		extra2 = ' &nbsp;-&nbsp; ' + extra2;
	}
	commentFooter = commentFooter.replace(/R_EXTRA/,  ' &nbsp;-&nbsp; ' + extra1 + extra2);
	
//
    str = str.replace(/R_COMMENT_FOOTER/g, commentFooter, str);
    str = str.replace(/R_TIME_BEFORE/g, duration_time(svrTime, data['time']));

    str = str.replace(/R_FEED_TYPE/g, (data['data']['item_type'] == 1) ? 'sell' : 'buy');

	str = str.replace(/R_COMMENT_MIDDLE/, '');
    return str;
}

function buildPostGame(data, is_comment) {
    var str = highLights.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
    str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/, ' &nbsp;'+data['data']['R_ACTION']);



    var commentData = highLights.TEMP_COMMENT_DATA;
	commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
	commentData = commentData.replace(/R_DATA_TITLE/, data['data']['title']);
	commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
    commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_OPTION/, '');


	var commentMiddle = highLights.TEMP_COMMENT_MIDDLE;
	
	commentMiddle = commentMiddle.replace(/R_TIME_BEFORE/, duration_time(svrTime, data['time']));
	commentMiddle = commentMiddle.replace(/R_LINK/g, data['data']['R_IMAGE_LINK']);
	commentMiddle = commentMiddle.replace(/R_DATA/g, 'Viết bình luận');

	if(is_comment == false) {
		commentMiddle = commentMiddle.replace(/R_FEED_TYPE/, 'postgame');
		str = str.replace(/R_COMMENT_COMMENT/, '');
		commentData = commentData.replace(/R_DATA_DESC/, data['data']['content_feedback']);
	}
	else {
		commentMiddle = commentMiddle.replace(/R_FEED_TYPE/, 'cm');
		commentData = commentData.replace(/R_DATA_DESC/, data['data']['other']);

		var commentComment = highLights.TEMP_COMMENT_COMMENT_2;
		commentComment = commentComment.replace(/R_COMMENT/, data['data']['content_feedback']);

		str = str.replace(/R_COMMENT_COMMENT/, commentComment);
	}

    str = str.replace(/R_COMMENT_DATA/, commentData);
	str = str.replace(/R_COMMENT_MIDDLE/, commentMiddle);

    str = str.replace(/R_COMMENT_FOOTER/, '', str);

	str = str.replace(/R_COMMENT_MIDDLE/, '');
    return str;
}


function buildVietdanhgia(data, is_comment) {
    var str = highLights.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, upperFirst(upperFirst(data['data']['R_AVATAR'])));
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
    str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/, ' &nbsp;'+data['data']['R_ACTION']);



    var commentData = highLights.TEMP_COMMENT_DATA;
	commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
	commentData = commentData.replace(/R_DATA_TITLE/, data['data']['R_DATA_TITLE']);
	commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
    commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_OPTION/, '');


	var commentMiddle = highLights.TEMP_COMMENT_MIDDLE;
	
	commentMiddle = commentMiddle.replace(/R_TIME_BEFORE/, duration_time(svrTime, data['time']));
	commentMiddle = commentMiddle.replace(/R_LINK/g, data['data']['R_IMAGE_LINK']);
	commentMiddle = commentMiddle.replace(/R_DATA/g, 'Viết bình luận');
	
	if(data['data']['R_@_NAME'] != undefined) {
	  data['data']['content_feedback'] = data['data']['R_@_NAME'] + data['data']['content_feedback'];
	}
	
	if(is_comment == false) {
		commentMiddle = commentMiddle.replace(/R_FEED_TYPE/, 'post');
		commentData = commentData.replace(/R_DATA_DESC/, data['data']['content_feedback']);
		str = str.replace(/R_COMMENT_COMMENT/, '');
	}
	else {
		commentMiddle = commentMiddle.replace(/R_FEED_TYPE/, 'cm');
		commentData = commentData.replace(/R_DATA_DESC/, data['data']['other']);

		var commentComment = highLights.TEMP_COMMENT_COMMENT_2;
		commentComment = commentComment.replace(/R_COMMENT/, data['data']['content_feedback']);
		str = str.replace(/R_COMMENT_COMMENT/, commentComment);
	}
	str = str.replace(/R_COMMENT_DATA/, commentData);
	str = str.replace(/R_COMMENT_MIDDLE/, commentMiddle);

    str = str.replace(/R_COMMENT_FOOTER/, '', str);

	str = str.replace(/R_COMMENT_MIDDLE/, '');
    return str;
}

function buildNews(data, is_comment) {
    var str = highLights.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
    str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/, ' &nbsp;' + data['data']['R_ACTION']);


	var commentData = highLights.TEMP_COMMENT_DATA_NO_IMAGE;
	commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_TITLE_LINK']);
	commentData = commentData.replace(/R_DATA_TITLE/, data['data']['title']);

	var commentMiddle = highLights.TEMP_COMMENT_MIDDLE;
	
	commentMiddle = commentMiddle.replace(/R_TIME_BEFORE/, duration_time(svrTime, data['time']));
	commentMiddle = commentMiddle.replace(/R_LINK/g, data['data']['R_TITLE_LINK']);
	commentMiddle = commentMiddle.replace(/R_DATA/g, 'Viết bình luận');

	if(is_comment == false) {
		commentMiddle = commentMiddle.replace(/R_FEED_TYPE/, 'up_tin');
		commentData = commentData.replace(/R_DATA_DESC/, splitChar(data['data']['content_feedback'], highLights.MAX_CHAR));
		str = str.replace(/R_COMMENT_COMMENT/, '');
	}
	else {
		commentMiddle = commentMiddle.replace(/R_FEED_TYPE/, 'cm');
		commentData = commentData.replace(/R_DATA_DESC/, splitChar(data['data']['other'], highLights.MAX_CHAR));

		var commentComment = highLights.TEMP_COMMENT_COMMENT_2;
		commentComment = commentComment.replace(/R_COMMENT/, data['data']['content_feedback']);
		str = str.replace(/R_COMMENT_COMMENT/, commentComment);
	}
	str = str.replace(/R_COMMENT_MIDDLE/, commentMiddle);
	str = str.replace(/R_COMMENT_DATA/, commentData);
    str = str.replace(/R_COMMENT_FOOTER/, '', str);

    return str;
}

function buildBlast(data) {
    var str = highLights.TEMP_COMMENT_ITEM;
	var key = data['acc_id']+'_'+data['act']+'_'+data['time'];
	
    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
	str = str.replace(/R_ID_COMMENT/g, key);
	
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
    str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/, ' &nbsp;'+modifyBlast(data['data']['content_feedback']));
    str = str.replace(/R_COMMENT_DATA/, '');
    str = str.replace(/R_COMMENT_COMMENT/, '');
	
    var commentFooter = highLights.TEMP_COMMENT_FOOTER_2;
    commentFooter = commentFooter.replace(/R_LINK/g, 'javascript:add_box_to_stream(\''+data['acc_id']+'\',\''+data['act']+'\',\''+data['time']+'\')');
    commentFooter = commentFooter.replace(/R_SPACE/g, ' &nbsp;-&nbsp; ');
    commentFooter = commentFooter.replace(/R_DATA/g, 'Viết bình luận');

    str = str.replace(/R_COMMENT_FOOTER/, commentFooter, str);

    str = str.replace(/R_TIME_BEFORE/, duration_time(svrTime, data['time']));
    str = str.replace(/R_FEED_TYPE/, 'talk');
	str = str.replace(/R_COMMENT_MIDDLE/, '');
    return str;
}
function buildVietluubut(data) {
    var str = highLights.TEMP_COMMENT_ITEM;	
	var key = data['acc_id']+'_'+data['act']+'_'+data['time'];
	
	str = str.replace(/R_ID_COMMENT/g, key);	
    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));

	var commentAcc2 = highLights.TEMP_COMMENT_ACCOUNT_2;
	commentAcc2 = commentAcc2.replace(/R_LINK_PROFILE_ACCOUNT_2/,data['data']['R_LINK_PROFILE_ACCOUNT_2']);
	commentAcc2 = commentAcc2.replace(/R_ACCOUNT_NAME_2/,data['data']['receiver_user_name']);

    str = str.replace(/R_COMMENT_ACCOUNT_2/g, commentAcc2);
    str = str.replace(/R_ACTION/, '');

	var commentData = highLights.TEMP_COMMENT_DATA_NO_IMAGE;
	commentData = commentData.replace(/R_LINK_ULR/,'');
	commentData = commentData.replace(/R_DATA_TITLE/,'');
	commentData = commentData.replace(/R_DATA_DESC/, data['data']['content_feedback']);

    str = str.replace(/R_COMMENT_DATA/, commentData);
    str = str.replace(/R_COMMENT_COMMENT/, '');

    var commentFooter = highLights.TEMP_COMMENT_FOOTER_2;
    commentFooter = commentFooter.replace(/R_LINK/g, 'javascript:add_box_to_stream(\''+data['acc_id']+'\',\''+data['act']+'\',\''+data['time']+'\')');
    commentFooter = commentFooter.replace(/R_SPACE/g, ' &nbsp;-&nbsp; ');
    commentFooter = commentFooter.replace(/R_DATA/g, 'Viết bình luận');

    str = str.replace(/R_COMMENT_FOOTER/, commentFooter, str);

    str = str.replace(/R_TIME_BEFORE/, duration_time(svrTime, data['time']));
    str = str.replace(/R_FEED_TYPE/, 'vlb');
	str = str.replace(/R_COMMENT_MIDDLE/, '');
    return str;
}


function buildYeucaugame(data) {

    var str = highLights.TEMP_COMMENT_ITEM;
	
	var key = data['acc_id']+'_'+data['act']+'_'+data['time'];
	
	str = str.replace(/R_ID_COMMENT/g, key);
	
    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
	str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/g, ' &nbsp;yêu cầu game - phần mềm');
    str = str.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);


    commentData = highLights.TEMP_COMMENT_DATA;
    commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_TITLE/, data['data']['R_DATA_TITLE']);
    commentData = commentData.replace(/R_DATA_DESC/, data['data']['content_feedback']);
    commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
    commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);

    str = str.replace(/R_COMMENT_DATA/, commentData);

    str = str.replace(/R_COMMENT_COMMENT/, '');
    str = str.replace(/R_DATA_OPTION/, '');

    var commentFooter = highLights.TEMP_COMMENT_FOOTER;
	
	commentFooter = commentFooter.replace(/R_LINK_VIET_BINH_LUAN/, 'javascript:add_box_to_stream(\''+data['acc_id']+'\',\''+data['act']+'\',\''+data['time']+'\')');
	
    commentFooter = commentFooter.replace(/R_LINK/g, data['data']['R_POST_GAME']);
	commentFooter = commentFooter.replace(/R_SPACE/g, '&nbsp; - &nbsp;');
    commentFooter = commentFooter.replace(/R_DATA/g, 'Chia sẻ');

    str = str.replace(/R_COMMENT_FOOTER/g, commentFooter, str);
    str = str.replace(/R_TIME_BEFORE/g, duration_time(svrTime, data['time']));
    str = str.replace(/R_FEED_TYPE/g, 'request');
	str = str.replace(/R_COMMENT_MIDDLE/, '');
    return str;
}
function buildLike(data) {

    var str = highLights.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
	str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/g, ' &nbsp;thích');
    str = str.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);


    commentData = highLights.TEMP_COMMENT_DATA;
    commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_TITLE/, data['data']['R_DATA_TITLE']);
    commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
    commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_DESC/, data['data']['R_DATA_DESC'] + '<div class="paddingTop5 arial12 grey5c justify">'+ data['data']['mobile_like'] +' người thích</div>');

    str = str.replace(/R_COMMENT_DATA/, commentData);

    str = str.replace(/R_COMMENT_COMMENT/, '');
    str = str.replace(/R_DATA_OPTION/, '');

    var commentFooter = highLights.TEMP_COMMENT_FOOTER_2;
    commentFooter = commentFooter.replace(/R_LINK/g, '');
	commentFooter = commentFooter.replace(/R_SPACE/g, '');
    commentFooter = commentFooter.replace(/R_DATA/g, '');

    str = str.replace(/R_COMMENT_FOOTER/g, commentFooter, str);
    str = str.replace(/R_TIME_BEFORE/g, duration_time(svrTime, data['time']));
    str = str.replace(/R_FEED_TYPE/g, 'heart');
	str = str.replace(/R_COMMENT_MIDDLE/, '');
    return str;
}
function buildComment(data, act) {

    var str = highLights.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
	str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/g, ' ' + data['data']['R_ACTION']);


	if(act != highLights.COMMENT_NEWS) {
	  var commentData = highLights.TEMP_COMMENT_DATA;
	  commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);
	  commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
	  commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
	  commentData = commentData.replace(/R_DATA_OPTION/, (data['data']['R_DATA_OPTION'])?data['data']['R_DATA_OPTION']:'');
	  commentData = commentData.replace(/R_DATA_DESC/, splitChar(data['data']['R_DATA_DESC'], highLights.MAX_CHAR));
	}
	else {
	  var commentData = highLights.TEMP_COMMENT_DATA_NO_IMAGE;
	  commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
	  commentData = commentData.replace(/R_DATA_OPTION/, '');
	  commentData = commentData.replace(/R_DATA_DESC/, data['data']['R_DATA_DESC']);
	}

	if(act == highLights.COMMENT_NETWORK) {
	  commentData = commentData.replace(/R_DATA_TITLE/, data['data']['title']);
	}
	else {
	  commentData = commentData.replace(/R_DATA_TITLE/, data['data']['R_DATA_TITLE']);
	}


    str = str.replace(/R_COMMENT_DATA/, commentData);

	var commentComment = highLights.TEMP_COMMENT_COMMENT_2;
    commentComment = commentComment.replace(/R_LINK_PROFILE_ACCOUNT_1/, data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    commentComment = commentComment.replace(/R_ACCOUNT_NAME_1/, upperFirst(data['data']['sender_user_name']));

	if(data['data']['R_@_NAME'] != undefined) {
	  data['data']['content_feedback'] = data['data']['R_@_NAME'] + data['data']['content_feedback'];
	}

    commentComment = commentComment.replace(/R_COMMENT/, data['data']['content_feedback']);

    str = str.replace(/R_COMMENT_COMMENT/, commentComment);

    var commentFooter = highLights.TEMP_COMMENT_MIDDLE;
    commentFooter = commentFooter.replace(/R_LINK/g, data['data']['R_IMAGE_LINK']);
    commentFooter = commentFooter.replace(/R_DATA/g, 'Viết bình luận');

	str = str.replace(/R_COMMENT_MIDDLE/, commentFooter);
    str = str.replace(/R_COMMENT_FOOTER/, '');
    str = str.replace(/R_TIME_BEFORE/, duration_time(svrTime, data['time']));
    str = str.replace(/R_FEED_TYPE/, 'cm');

    return str;
}
 

