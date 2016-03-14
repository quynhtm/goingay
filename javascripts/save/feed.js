function reLoadTime() {
	var d2 = new Date();
	var currentClientTime = d2.getTime();
	var tmp = Math.floor((currentClientTime  - clientTime)/1000);
	jQuery(".timer").each(function(i) {
			Bm.get_ele(jQuery(this).attr('id')).innerHTML = duration_time(svrTime , parseInt(jQuery(this).attr('value')) - tmp, 1);
			
		});
	setTimeout("reLoadTime()", 30 * 1000);
}
var feed={
		length: 0,
		MAX_CHAR: 125,
		DANG_TIN_BAN: 1,
		DANG_TIN_MUA: 2,

		VIET_DANH_GIA: 3,
		VIET_DANH_GIA_COMMENT: 25,

		THICH: 4,
		SU_DUNG_MOBILE: 5,
		BINH_LUAN: 6,
		VIET_BLAST: 8,
		CAP_NHAT_DANH_BA: 9,
		VIET_LUU_BUT: 10,
		CAM_ON: 11,
		YEU_CAU_GAME: 12, // 1 account nao do yeu cau game toi 1 mobile nao do

		POST_GAME: 13, // account dang tin game va phan mem roi dua vao DB
		POST_GAME_COMMENT: 26,

		NEWS_GAME: 31, // tin tuc game - soft
		NEWS_GAME_COMMENT: 32, //- comment cho tin tuc game va soft

		//Hãng điện thoại và Hãng di động:

		DANG_TIN_KHUYEN_MAI: 15, //Shop
		DANG_TIN_KHUYEN_MAI_COMMENT: 28,

		THONG_BAO_SP_MOI: 16,
		THONG_BAO_SP_MOI_COMMENT: 30,

		NEWS: 19,
		NEWS_COMMENT: 29,

		COMMENT_ITEM: 17,
		COMMENT_NETWORK: 18,
		COMMENT_MOBILE: 20,

		DANG_TIN_MUA_BAN: 21,
		COMMENT_TYPE_NEWS: 22,
		TYPE_NEWS: 23,

		TEMP_COMMENT_ITEM: '<div class="comment_item"><div class="avatar50 float_left"style="background:url(R_AVATAR) no-repeat 0 0"><div class="avatar_overlay50"><a href="R_LINK_PROFILE_ACCOUNT_1"class="link_block"title="xem profile của R_ACCOUNT_NAME_1"></a></div></div><div class="float_right_extra paddingLeft10" id="R_ID_COMMENT"><div><a href="R_LINK_PROFILE_ACCOUNT_1"class="cyan"><strong>R_ACCOUNT_NAME_1</strong></a>R_COMMENT_ACCOUNT_2<span class="arial12">R_ACTION</span></div>R_COMMENT_DATA R_COMMENT_MIDDLE R_COMMENT_COMMENT R_COMMENT_FOOTER</div><div class="clear"></div><div class="clear"></div></div>',

		TEMP_COMMENT_ACCOUNT_2: '<span class="feed_space_arrow"></span><a href="R_LINK_PROFILE_ACCOUNT_2" class="cyan"><strong>R_ACCOUNT_NAME_2</strong></a>',

		TEMP_COMMENT_DATA: '<div class="paddingTop10 paddingBottom5 arial12 paddingLeft2"><div class="img_container70x70 float_left"><div class="img_main_overlay"></div><div class="img_main"style="background-image:url(R_IMAGE_URL)"><a href="R_IMAGE_LINK"class="link_block"></a></div></div><div class="float_left marginLeft10 feed_text_right"><div class="arial12"><strong><a href="R_LINK_ULR"class="">R_DATA_TITLE</a></strong></div><div class="paddingTop5"><strong>R_DATA_OPTION</strong></div><div class="paddingTop5 arial12 grey5c justify">R_DATA_DESC</div></div><div class="clear"></div></div>',

		TEMP_COMMENT_DATA_NO_IMAGE: '<div class="paddingTop10 paddingBottom5 arial12 paddingLeft2"><div class="float_left"><div class="arial12"><strong><a href="R_LINK_ULR"class="">R_DATA_TITLE</a></strong></div><div class="paddingTop5 arial12 grey5c justify">R_DATA_DESC</div></div><div class="clear"></div></div>',

		TEMP_COMMENT_COMMENT: '<div class="comment_item_list paddingLeft2"><div class="comment_comment"><div class=""><div><a href="R_LINK_PROFILE_ACCOUNT_1"class="cyan"><strong>R_ACCOUNT_NAME_1</strong></a><span style="color:#8e908f">R_TIME_BEFORE</span></div><div class="paddingTop5 arial12">R_COMMENT</div></div></div></div>',

		TEMP_COMMENT_COMMENT_2: '<div class="comment_item_list paddingLeft2"><div class="comment_comment"><div class="paddingTop5 arial12">R_COMMENT</div></div></div>',

		TEMP_COMMENT_FOOTER: '<div class="feed_line feed_R_FEED_TYPE grey83 marginTop5">R_TIME_BEFORE &nbsp;-&nbsp; <a href="R_LINK_VIET_BINH_LUAN" class="cyan">Viết bình luận</a> R_SPACE <a href="R_LINK" class="cyan">R_DATA</a></div><div class="clear"></div>',

		TEMP_COMMENT_FOOTER_2: '<div class="feed_line feed_R_FEED_TYPE grey83 marginTop5">R_TIME_BEFORE R_SPACE <a href="R_LINK" class="cyan">R_DATA</a></div> <div class="clear"></div>',
		
		TEMP_COMMENT_FOOTER_3: '<div class="feed_line feed_R_FEED_TYPE grey83 marginTop5">R_TIME_BEFORE R_EXTRA</div> <div class="clear"></div>',
		
		TEMP_EXTRA: '<a href="R_LINK" class="cyan" >R_DATA</a>',

		TEMP_COMMENT_MIDDLE: '<div class="feed_line feed_R_FEED_TYPE grey83 marginBottom5">R_TIME_BEFORE &nbsp;-&nbsp; <a href="R_LINK" class="cyan">R_DATA</a></div> <div class="clear"></div>'
    };

function buidfeed() {
  feed.length = jfeed.length;  	
  if(feed.length > 0)
    setTimeout("initFeed()", 1000);
}

function initFeed() {
    var i = 0, aryComment = null;
	
    for(var i = 0; i < feed.length; i++) {
		jQuery("#view_feed").append(createdFeed(jfeed[i]));
		aryComment = jfeed[i]['comment'];
		if(aryComment && aryComment.length > 0) {
			buildCommentForFeed(i) //
		}
    }
	fix_png(".avatar_overlay50");
	setTimeout("reLoadTime()", 30 * 1000);
}

function createdFeed(data) {

    var str = '';
	data.act = parseInt(data.act);
	if(data)
	  switch (data.act) {
	  case feed.DANG_TIN_BAN:
	  case feed.DANG_TIN_MUA:
		  str += buildBuySell(data);
		  break;
	  case feed.VIET_BLAST:
		  str += buildBlast(data);
		  break;
	  case feed.THICH:
		str += buildLike(data);
		break;
	  case feed.COMMENT_NEWS:
	  case feed.COMMENT_ITEM:
	  case feed.COMMENT_NETWORK:
	  case feed.COMMENT_MOBILE:
		str+= buildComment(data, data.act);
		break;
	  case feed.VIET_LUU_BUT:
		str += buildVietluubut(data);
		break;
	  case feed.YEU_CAU_GAME:
		str += buildYeucaugame(data);
		break;
	  case feed.DANG_TIN_KHUYEN_MAI:
	  case feed.NEWS:
		str += buildNews(data, false);
		break;
	  case feed.DANG_TIN_KHUYEN_MAI_COMMENT:
	  case feed.NEWS_COMMENT:
		str += buildNews(data, true);
		break;

	  case feed.VIET_DANH_GIA:
		str += buildVietdanhgia(data, false);
		break;
	  case feed.VIET_DANH_GIA_COMMENT:
		str += buildVietdanhgia(data, true);
		break;
	  case feed.POST_GAME:
		str += buildPostGame(data, false);
		break;
	  case feed.POST_GAME_COMMENT:
		str += buildPostGame(data, true);
		break;
	  default:
		  break;
	  }
    return str;
}


function buildBuySell(data) {

    var str = feed.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
	str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/g, ' &nbsp;' + data['data']['R_ACTION']);
    str = str.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);


    str = str.replace(/R_COMMENT_COMMENT/, '');

	var commentData = feed.TEMP_COMMENT_DATA;
	commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
	commentData = commentData.replace(/R_DATA_TITLE/, data['data']['R_DATA_TITLE']);
	commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
    commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_OPTION/,'Giá ' + ((data['data']['item_type'] == 2)? 'mua: ' : 'bán: ') + format_number(data['data']['price']) + ' VNĐ');
    commentData = commentData.replace(/R_DATA_DESC/, data['data']['content_feedback']);

	str = str.replace(/R_COMMENT_DATA/, commentData);

    var commentFooter = feed.TEMP_COMMENT_FOOTER_3;
		
    var extra1 = feed.TEMP_EXTRA.replace(/R_LINK/, data['data']['R_IMAGE_LINK']+'&s_cm=1');
    extra1 = extra1.replace(/R_DATA/, 'Viết bình luận');
	
	var extra2 = '';
	if(data['data']['sender_user_name'] != curentUser) {
		var extra2 = feed.TEMP_EXTRA.replace(/R_LINK/,  'javascript:Bm.show_form_sendmessage(\''+ data['data']['sender_user_id'] +'\', \''+ data['data']['sender_user_name'] +'\')');
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
    var str = feed.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
    str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/, ' &nbsp;'+data['data']['R_ACTION']);



    var commentData = feed.TEMP_COMMENT_DATA;
	commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
	commentData = commentData.replace(/R_DATA_TITLE/, data['data']['title']);
	commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
    commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_OPTION/, '');


	var commentMiddle = feed.TEMP_COMMENT_MIDDLE;
	
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

		var commentComment = feed.TEMP_COMMENT_COMMENT_2;
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
    var str = feed.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, upperFirst(upperFirst(data['data']['R_AVATAR'])));
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
    str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/, ' &nbsp;'+data['data']['R_ACTION']);



    var commentData = feed.TEMP_COMMENT_DATA;
	commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
	commentData = commentData.replace(/R_DATA_TITLE/, data['data']['R_DATA_TITLE']);
	commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
    commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_OPTION/, '');


	var commentMiddle = feed.TEMP_COMMENT_MIDDLE;
	
	commentMiddle = commentMiddle.replace(/R_TIME_BEFORE/, duration_time(svrTime, data['time']));
	commentMiddle = commentMiddle.replace(/R_LINK/g, data['data']['R_IMAGE_LINK']);
	commentMiddle = commentMiddle.replace(/R_DATA/g, 'Viết bình luận');
	
	if(data['data']['R_@_NAME'] != undefined) {
	  data['data']['content_feedback'] = data['data']['R_@_NAME'] + data['data']['content_feedback'];
	}
	
	if(is_comment == false) {
		commentMiddle = commentMiddle.replace(/R_FEED_TYPE/, 'post');
		var tmp_feedback = data['data']['content_feedback'];
		
		commentData = commentData.replace(/R_DATA_DESC/, tmp_feedback.replace(/</g, '-'));
		str = str.replace(/R_COMMENT_COMMENT/, '');
	}
	else {
		commentMiddle = commentMiddle.replace(/R_FEED_TYPE/, 'cm');
		commentData = commentData.replace(/R_DATA_DESC/, data['data']['other']);

		var commentComment = feed.TEMP_COMMENT_COMMENT_2;
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
    var str = feed.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
    str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/, ' &nbsp;' + data['data']['R_ACTION']);


	var commentData = feed.TEMP_COMMENT_DATA_NO_IMAGE;
	commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_TITLE_LINK']);
	commentData = commentData.replace(/R_DATA_TITLE/, data['data']['title']);

	var commentMiddle = feed.TEMP_COMMENT_MIDDLE;
	
	commentMiddle = commentMiddle.replace(/R_TIME_BEFORE/, duration_time(svrTime, data['time']));
	commentMiddle = commentMiddle.replace(/R_LINK/g, data['data']['R_TITLE_LINK']);
	commentMiddle = commentMiddle.replace(/R_DATA/g, 'Viết bình luận');

	if(is_comment == false) {
		commentMiddle = commentMiddle.replace(/R_FEED_TYPE/, 'up_tin');
		commentData = commentData.replace(/R_DATA_DESC/, splitChar(data['data']['content_feedback'], feed.MAX_CHAR));
		str = str.replace(/R_COMMENT_COMMENT/, '');
	}
	else {
		commentMiddle = commentMiddle.replace(/R_FEED_TYPE/, 'cm');
		commentData = commentData.replace(/R_DATA_DESC/, splitChar(data['data']['other'], feed.MAX_CHAR));

		var commentComment = feed.TEMP_COMMENT_COMMENT_2;
		commentComment = commentComment.replace(/R_COMMENT/, data['data']['content_feedback']);
		str = str.replace(/R_COMMENT_COMMENT/, commentComment);
	}
	str = str.replace(/R_COMMENT_MIDDLE/, commentMiddle);
	str = str.replace(/R_COMMENT_DATA/, commentData);
    str = str.replace(/R_COMMENT_FOOTER/, '', str);

    return str;
}

function buildBlast(data) {
    var str = feed.TEMP_COMMENT_ITEM;
	var key = data['acc_id']+'_'+data['act']+'_'+data['time'];
	
    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
	str = str.replace(/R_ID_COMMENT/g, key);
	
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
    str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/, ' &nbsp;'+modifyBlast(data['data']['content_feedback']));
    str = str.replace(/R_COMMENT_DATA/, '');
    str = str.replace(/R_COMMENT_COMMENT/, '');
	
    var commentFooter = feed.TEMP_COMMENT_FOOTER_2;
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
    var str = feed.TEMP_COMMENT_ITEM;	
	var key = data['acc_id']+'_'+data['act']+'_'+data['time'];
	
	str = str.replace(/R_ID_COMMENT/g, key);	
    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));

	var commentAcc2 = feed.TEMP_COMMENT_ACCOUNT_2;
	commentAcc2 = commentAcc2.replace(/R_LINK_PROFILE_ACCOUNT_2/,data['data']['R_LINK_PROFILE_ACCOUNT_2']);
	commentAcc2 = commentAcc2.replace(/R_ACCOUNT_NAME_2/,data['data']['receiver_user_name']);

    str = str.replace(/R_COMMENT_ACCOUNT_2/g, commentAcc2);
    str = str.replace(/R_ACTION/, '');

	var commentData = feed.TEMP_COMMENT_DATA_NO_IMAGE;
	commentData = commentData.replace(/R_LINK_ULR/,'');
	commentData = commentData.replace(/R_DATA_TITLE/,'');
	commentData = commentData.replace(/R_DATA_DESC/, data['data']['content_feedback']);

    str = str.replace(/R_COMMENT_DATA/, commentData);
    str = str.replace(/R_COMMENT_COMMENT/, '');

    var commentFooter = feed.TEMP_COMMENT_FOOTER_2;
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

    var str = feed.TEMP_COMMENT_ITEM;
	
	var key = data['acc_id']+'_'+data['act']+'_'+data['time'];
	
	str = str.replace(/R_ID_COMMENT/g, key);
	
    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
	str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/g, ' &nbsp;yêu cầu game - phần mềm');
    str = str.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);


    commentData = feed.TEMP_COMMENT_DATA;
    commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_TITLE/, data['data']['R_DATA_TITLE']);
    commentData = commentData.replace(/R_DATA_DESC/, data['data']['content_feedback']);
    commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
    commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);

    str = str.replace(/R_COMMENT_DATA/, commentData);

    str = str.replace(/R_COMMENT_COMMENT/, '');
    str = str.replace(/R_DATA_OPTION/, '');

    var commentFooter = feed.TEMP_COMMENT_FOOTER;
	
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

    var str = feed.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
	str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/g, ' &nbsp;thích');
    str = str.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);


    commentData = feed.TEMP_COMMENT_DATA;
    commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_TITLE/, data['data']['R_DATA_TITLE']);
    commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
    commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);
    commentData = commentData.replace(/R_DATA_DESC/, data['data']['R_DATA_DESC'] + '<div class="paddingTop5 arial12 grey5c justify">'+ data['data']['mobile_like'] +' người thích</div>');

    str = str.replace(/R_COMMENT_DATA/, commentData);

    str = str.replace(/R_COMMENT_COMMENT/, '');
    str = str.replace(/R_DATA_OPTION/, '');

    var commentFooter = feed.TEMP_COMMENT_FOOTER_2;
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

    var str = feed.TEMP_COMMENT_ITEM;

    str = str.replace(/R_AVATAR/g, data['data']['R_AVATAR']);
    str = str.replace(/R_LINK_PROFILE_ACCOUNT_1/g,  data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    str = str.replace(/R_ACCOUNT_NAME_1/g, upperFirst(data['data']['sender_user_name']));
	str = str.replace(/R_COMMENT_ACCOUNT_2/g, '');
    str = str.replace(/R_ACTION/g, ' ' + data['data']['R_ACTION']);


	if(act != feed.COMMENT_NEWS) {
	  var commentData = feed.TEMP_COMMENT_DATA;
	  commentData = commentData.replace(/R_IMAGE_LINK/, data['data']['R_IMAGE_LINK']);
	  commentData = commentData.replace(/R_IMAGE_URL/, data['data']['R_IMAGE_URL']);
	  commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
	  commentData = commentData.replace(/R_DATA_OPTION/, (data['data']['R_DATA_OPTION'])?data['data']['R_DATA_OPTION']:'');
	  commentData = commentData.replace(/R_DATA_DESC/, splitChar(data['data']['R_DATA_DESC'], feed.MAX_CHAR));
	}
	else {
	  var commentData = feed.TEMP_COMMENT_DATA_NO_IMAGE;
	  commentData = commentData.replace(/R_LINK_ULR/, data['data']['R_IMAGE_LINK']);
	  commentData = commentData.replace(/R_DATA_OPTION/, '');
	  commentData = commentData.replace(/R_DATA_DESC/, data['data']['R_DATA_DESC']);
	}

	if(act == feed.COMMENT_NETWORK) {
	  commentData = commentData.replace(/R_DATA_TITLE/, data['data']['title']);
	}
	else {
	  commentData = commentData.replace(/R_DATA_TITLE/, data['data']['R_DATA_TITLE']);
	}


    str = str.replace(/R_COMMENT_DATA/, commentData);

	var commentComment = feed.TEMP_COMMENT_COMMENT_2;
    commentComment = commentComment.replace(/R_LINK_PROFILE_ACCOUNT_1/, data['data']['R_LINK_PROFILE_ACCOUNT_1']);
    commentComment = commentComment.replace(/R_ACCOUNT_NAME_1/, upperFirst(data['data']['sender_user_name']));

	if(data['data']['R_@_NAME'] != undefined) {
	  data['data']['content_feedback'] = data['data']['R_@_NAME'] + data['data']['content_feedback'];
	}

    commentComment = commentComment.replace(/R_COMMENT/, data['data']['content_feedback']);

    str = str.replace(/R_COMMENT_COMMENT/, commentComment);

    var commentFooter = feed.TEMP_COMMENT_MIDDLE;
    commentFooter = commentFooter.replace(/R_LINK/g, data['data']['R_IMAGE_LINK']);
    commentFooter = commentFooter.replace(/R_DATA/g, 'Viết bình luận');

	str = str.replace(/R_COMMENT_MIDDLE/, commentFooter);
    str = str.replace(/R_COMMENT_FOOTER/, '');
    str = str.replace(/R_TIME_BEFORE/, duration_time(svrTime, data['time']));
    str = str.replace(/R_FEED_TYPE/, 'cm');

    return str;
}

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


var fnow = -1;
var record_per_page=0;
function fnext(status, mobile_id){
    if(fnow == -1) {
       //fnow = document.getElementById('fnow').value;
	   fnow = feed.length;
	   if(Bm.is_exists(feed_new_blast)) fnow -= feed_new_blast;
	   record_per_page = fnow;
    }

    if(fnow <= 0 ) return;
	if(status == 'all') {
	   jQuery.ajax({
			beforeSend: Bm.show_loading('Đang tải dữ liệu...'),
			type: 'post',
			dataType: 'json',
			url : BASE_URL + 'ajax.php?act=getFeed&code=paging&now='+fnow+'&rand='+Math.random(),
			success: function(aryData){
					if(aryData.intReturn == 1){
						if(aryData.curentRecord > fnow) {
							var tmpData = aryData.data;
							for(i in tmpData) {								
								jQuery("#ext_data").append(createdFeed(tmpData[i]));
							}
							fnow = aryData.curentRecord;							
							if(fnow%record_per_page != 0) jQuery("#extra_area").addClass("hide_item");
						}
						else {
							//Bm.show_overlay_popup("thongbao", "Thông báo", "Không còn hành động nào nữa! ");
							jQuery("#extra_area").addClass("hide_item");
						}
					}
					else alert(aryData.err);
			Bm.hide_loading();
	
			}
		});	
	}
	else if(status == 'mobile') {
		jQuery.ajax({
			beforeSend: Bm.show_loading('Đang tải dữ liệu...'),
			type: 'post',
			dataType: 'json',
			url : BASE_URL + 'ajax.php?act=getFeed&code=pagingMobile&now='+fnow+'&mobile_id='+mobile_id+'&rand='+Math.random(),
			success: function(data){
					if(data.intReturn == 1){
						if(data.curentRecord > fnow) {
							var tmpData = data.data;
							for(i in tmpData) {
								jQuery("#ext_data").append(createdFeed(tmpData[i]));
							}
							fnow = data.curentRecord;
							if(fnow%record_per_page != 0) jQuery("#extra_area").addClass("hide_item");
						}
						else {
							//Bm.show_overlay_popup("thongbao", "Thông báo", "Không còn hành động nào nữa! ");							
							jQuery("#extra_area").addClass("hide_item");
						}
					}
					else alert(data.err);
			Bm.hide_loading();
			}
		});
	}
	jQuery("#extra_area").css("top","1px");
}
var profile_now = -1;
function profile_next(){
    if(profile_now == -1) {
       //profile_now = document.getElementById('profile_now').value;
	   profile_now = feed.length;
	   if(Bm.is_exists(feed_new_blast)) profile_now -= feed_new_blast;
	}
	var acc_id  = document.getElementById('acc_id').value;
    if(profile_now <= 0 ) return;
	 
	   jQuery.ajax({
			beforeSend: Bm.show_loading('Đang tải dữ liệu...'),
			type: 'post',
			dataType: 'json',
			url : BASE_URL + 'ajax.php?act=getFeed&code=pagingProfile&now='+profile_now+'&acc_id='+acc_id+'&rand='+Math.random(),
			success: function(data){
					if(data.intReturn == 1){
						if(data.curentRecord > profile_now) {
							var tmpData = data.data;				
							for(i in tmpData) {
								jQuery("#ext_data").append(createdFeed(tmpData[i]));
							}
							profile_now = data.curentRecord;	
						}
						else {
							Bm.show_overlay_popup("thongbao", "Thông báo", "Không còn hành động nào nữa! ");							
							jQuery("#extra_area").addClass("hide_item");
						}
					}
					else alert(data.err);
			Bm.hide_loading();
	
			}
		});
	jQuery("#extra_area").css("top","1px");
}
var data_new = new Array();
var num_data_new = 0;
var feedLastTime = 0;
function getNew(){
	if(feedLastTime == 0) feedLastTime = TIME_NOW;
    jQuery.ajax({
	    type: 'get',
	    dataType: 'json',
	    url : BASE_URL + '?page=cronjobFeed&act=upGetNew&acc='+document.getElementById('acc_id').value+'&feedLastTime='+feedLastTime+'&rand='+Math.random(),
	    //url : BASE_URL + 'test.html?act=upGetNew&acc='+document.getElementById('acc_id').value+'&rand='+Math.random(),
	    success: function(data){
                if(data.intReturn == 1){
					if(data.countNew > 0) {
						document.getElementById('new_update').style.display = 'block';
						dataTmp = data.data;
						for(var i = (dataTmp.length-1); i >= 0; i--) {
							data_new.push(dataTmp[i]);
						}
						num_data_new += data.countNew;
						document.getElementById('label_view_new').innerHTML =" Xem thêm " + num_data_new + " cập nhật mới !";
						feedLastTime = data.feedLastTime;
						
						//phongct added.
						//Phan nay de phuc vu cho viec click [xem tiep]
							if(fnow == -1) {
								//fnow = document.getElementById('fnow').value;
								fnow = feed.length;
								if(Bm.is_exists(feed_new_blast)) fnow -= feed_new_blast;
								record_per_page = fnow;
							}
							fnow += data.countNew;
						//end
					}
                }
				setTimeout("getNew()",10000);
	    }
    });
    
}

function view_new_update() {
	var tmp = '';
	for(var i = (data_new.length-1); i >= 0; i--) {
		tmp += createdFeed(data_new[i]);
	}
	
    document.getElementById('view_new_update').innerHTML = tmp + document.getElementById('view_new_update').innerHTML;
    document.getElementById('new_update').style.display = 'none';
    data_new = new Array();
    num_data_new = 0;
	fix_png(".avatar_overlay50");
}
 
function format_number(num){
	if(!num) return num;
	var stt = 0;
	var result = '';
	for(var i = num.length; i >= 0; i--) {		
		result = num.charAt(i) + result;
		if(stt%3 == 0 && i > 0 && stt>0) result = '.' + result;
		stt++;
	}	
	return result;
}

function upperFirst(t)  {
	if(t)
		return t.substr(0, 1).toUpperCase() + t.substr(1);
	else return t;
}

function splitChar(str, num)  {
	if(str && str.length > num)
		return str.substr(0, num) + ' ...';
	else return str;
}

function buildCommentForFeed(j) {
	
	var act_account = jfeed[j]['acc_id'], act = jfeed[j]['act'], act_time = jfeed[j]['time'], aryComment = jfeed[j]['comment'];
	var length = aryComment.length;	
	if(length > 0) {		
		var comment_id = act_account +'_'+ act +'_'+ act_time;
		var comment_comment = '';
		jQuery("#" + comment_id).append(show_box_reply_comment(act_account, act, act_time, 0));
		var start_comment = (Bm.is_exists(view_detail_feed) && view_detail_feed == true)? 0 : (length-2) ;
		for(var i = start_comment ; i < length; i++) {
			//if(!aryComment[i]) continue;
			var rand = Math.random();
			comment_comment += build_comment_for_stream(aryComment[i], act_account, act, act_time, comment_id, rand);
		}
		
		if(start_comment != 0 && length > 2) {
			var tmp
			tmp = '<div class="comment_comment" id="view_all_'+comment_id+'"><div class="paddingLeft5">';
			if(length > 10)
				tmp += '<a href="'+BASE_URL + jfeed[j]['data']['sender_user_name'] + '/detail/'+ comment_id +'.html" class="cyan">Xem tất cả '+ length +' bình luận</a></div></div>';
			else
			tmp += "<a href=\"javascript:buildAllCommentForFeed("+j+")\" class='cyan'>Xem tất cả "+ length +" bình luận</a></div></div>";
				
			comment_comment = tmp + comment_comment;
			
		}
		jQuery("#append_"+comment_id).append(comment_comment);
		
		jQuery("#append_"+comment_id).removeClass("hide_item");
		
		ShowHideComment('hide', comment_id);
		jQuery("#key_"+comment_id).css("display","block");
	}
}
function buildAllCommentForFeed(j) {
	var act_account = jfeed[j]['acc_id'], act = jfeed[j]['act'], act_time = jfeed[j]['time'], aryComment = jfeed[j]['comment'];
	var length = aryComment.length;
	
	if(length > 2) {
		var comment_id = act_account +'_'+ act +'_'+ act_time;
		jQuery("#view_all_"+comment_id).addClass("hide_item");
		var comment_comment = '';
		for(var i = 0 ; i < length-2; i++) {
			//if(!aryComment[i]) continue;
			var rand = Math.random();
			comment_comment += build_comment_for_stream(aryComment[i], act_account, act, act_time, comment_id, rand);
		}
		Bm.get_ele("append_"+comment_id).innerHTML = comment_comment + Bm.get_ele("append_"+comment_id).innerHTML ;		
	}
}


function add_box_to_stream(act_account, act, act_time,parent_id) {
	
	var content = show_box_reply_comment(act_account, act, act_time,parent_id);
	if(content) {
		var comment_id = act_account +'_'+ act +'_'+ act_time;
		jQuery("#" + comment_id).append(content);
		jQuery("#key_"+comment_id).fadeIn("slow");
		jQuery("#content_fast_reply_"+comment_id).focus();
	}
}
 //box reply comment
function show_box_reply_comment(act_account, act, act_time,parent_id){
	var v_content ='';
	var comment_id = act_account +'_'+ act +'_'+ act_time;
	if(!parent_id) parent_id = 0;
	
	if(Bm.get_ele('key_'+comment_id) != undefined) {
	   jQuery("#key_"+comment_id).fadeIn("slow");
	   jQuery("#content_fast_reply_"+comment_id).focus();
	   return;
	}
	v_content +="<div class=\"comment_item_list hide_item\"  id=\"append_"+comment_id+"\"></div>"
	v_content +="<div style='display:none; overflow: hidden' class='box_fast_reply' added_comment=0 id='key_"+ comment_id +"'>";
	v_content +="<div class='padding2' style='border:1px solid #d9d9d9;background-color:#fff'>";
	//onBlur=\"Bm.get_ele('btn_"+comment_id+"').style.display='none'\" 
	v_content +="<textarea onblur=\"ShowHideComment('hide', '"+comment_id+"');\"  onfocus=\"ShowHideComment('show', '"+comment_id+"');\" name='content_fast_reply_"+comment_id+"' id='content_fast_reply_"+comment_id+"' row='1'></textarea>";
	v_content +="</div>";
	v_content +="<div class='paddingTop5' id='btn_"+ comment_id +"'>";
	v_content +="<a href='javascript:void(0);' class='bt_grey' onclick=\"fn_new_feedback('"+act_account+"','"+act+"','"+act_time+"','content_fast_reply_"+comment_id+"',"+parent_id+");\" id = btn_comment_"+comment_id+"><div class='bg_left'><div class='bg_right'>Gửi</div></div></a>";
	//v_content +="<a href=\"javascript:void(0);\" onclick=\"close_box_fast_reply('key_"+ comment_id +"');\" class='bt_grey marginLeft10'><div class='bg_left'><div class='bg_right'>Hủy</div></div></a>";
	//v_content +="<a onclick=\"load_smiley('btn_fast_reply_"+comment_id+"','content_fast_reply_"+comment_id+"')\" href=\"javascript:void(0)\" class=\"bt_smiley\" style='float:right' id='btn_fast_reply_"+comment_id+"'>ChÃ¨n</a>";
	v_content +="<div class='clear'></div>";
	v_content +="</div>";
	v_content +="</div>";
	return v_content;
}


function fn_new_feedback(act_account, act, act_time, IdTextArea, parent_id){
	
	if (!Bm.is_permission()) return;
	
	var content = Bm.get_ele(IdTextArea).value;
	if(content.length > feed.MAX_CHAR) {
		Bm.show_popup_message("Số lượng ký tự bạn nhập vượt quá giới hạn cho phép là 125 ký tự.", "Thông báo", -1);
		return;
	}
	var comment_id = act_account +'_'+ act +'_'+ act_time;
	Bm.ajax_popup("act=feed_comment&code=send_new_comment&comment_id="+comment_id, "", {content: content},
		function (json) {
			if (Bm.is_exists(json.data)) {
				add_to_stream(json.data, act_account, act, act_time, parent_id, true);
				Bm.get_ele('content_fast_reply_'+comment_id).value = '';
				ShowHideComment('hide', comment_id);
			}else if(Bm.is_exists(json.err)){
				Bm.show_popup_message(json.err, "Thông báo", -1);
			}
		});
}
function ShowHideComment(status, comment_id) {
	var txt_default = "Viết bình luận tại đây"
	if(status == 'hide') {
		
		if('' == Bm.get_ele('content_fast_reply_'+comment_id).value) {
			if(Bm.get_ele('append_'+comment_id).innerHTML == '') {
				jQuery('#key_'+comment_id).css("height","0px");
			}
			else {
				Bm.get_ele('content_fast_reply_'+comment_id).value = txt_default;
				jQuery('#key_'+comment_id).css("height","22px");
				jQuery('#content_fast_reply_'+comment_id).css("height","15px");	
			}
		}
	}
	else {
		jQuery('#key_'+comment_id).css("height","auto");
		jQuery('#content_fast_reply_'+comment_id).css("height","auto");
		
		if(txt_default == Bm.get_ele('content_fast_reply_'+comment_id).value) 
			Bm.get_ele('content_fast_reply_'+comment_id).value = '';
	}
}

function add_to_stream(data, act_account, act, act_time, parent_id, fadeIn){
	
	if(data && data.cur_user_name && data.content) {
		var rand = Math.random();
		var comment_id = act_account +'_'+ act +'_'+ act_time;
		var comment_comment = build_comment_for_stream(data, act_account, act, act_time, comment_id, rand);
		jQuery("#append_"+comment_id).append(comment_comment);
		
		jQuery("#append_"+comment_id).removeClass("hide_item");
		jQuery("#content_fast_reply_"+comment_id).val("");
		if(fadeIn)
		fade_to_yellow(243,243,243,comment_id+"_"+rand,1);
	}
}
function build_comment_for_stream(data, act_account, act, act_time, comment_id, rand) {
	if(data && data.cur_user_name && data.content)
		return '<div class="comment_comment" id="'+comment_id+'_'+rand+'"><div class="avatar32 float_left" style="background:url('+data.cur_avatar_url_small+') no-repeat 0 0"></div>  <div style="padding-left:40px;" ><div><a class="cyan" href="'+ data.link_profile +'"><strong>'+data.cur_user_name+'</strong></a> <span class="grey83">'+ duration_time(svrTime, data.time) +'</span></div><div class="paddingTop2" id ="arial12">' + modifyBlast(data.content) + '</div>  </div>  <div class="clear"></div></div>';
	else return '';
}
function close_box_fast_reply(id){
	jQuery("#"+id).fadeOut("slow");
}
function addToFeed(aryData) {
 
	var rand = Math.random();
	var tmp = '<div id="blast_'+ rand +'">'+ buildBlast(aryData) +'</div>';
	document.getElementById('view_new_update').innerHTML = tmp + document.getElementById('view_new_update').innerHTML;
	fade_to_yellow(243,243,243,"blast_"+rand,0);

}
function modifyBlast(blast) {
	var tmp, str, spChar;
	spChar = "http://";
	if(blast) {
		var ary = blast.split(spChar);
		for(i in ary) {
			if((ary[i-1] != undefined && ary[i-1].substr((ary[i-1].length-1), 1) != '"')) {
				str ='';
				if(ary[i].match("<")) {
					tmp = ary[i].split("<");
					ary[i] = tmp[0];
					tmp[0] = '';
					str = tmp.join("<");
				}
				if(ary[i].match(" ")) {
					tmp = ary[i].split(" ");
					ary[i] = tmp[0];
					tmp[0] = '';
					str = tmp.join(" ") + str;
				}
				ary[i] = spChar + ary[i];
				ary[i] = '<a href="'+ary[i]+'" class="cyan" target="_blank" title="'+ary[i]+'">' + ary[i] + '</a>' + str;
			}
		}
		blast = ary.join(" ");
	}
	return blast;
}

