<?php
/*
+--------------------------------------------------------------------------
|   Web: http://www.boxmobi.com
|   Started date : 08/08/2009
+---------------------------------------------------------------------------
|   > Script written by HaLM
+---------------------------------------------------------------------------
*/

if (preg_match ( "/".basename ( __FILE__ )."/", $_SERVER ['PHP_SELF'] )) {
	die ("<h1>Incorrect access</h1>You cannot access this file directly.");
}

class ajax_profile_edit {

	static $errorList = array();

	function playme() {
		$code = Url::get ( 'code' );
		switch ($code) {
			case 'blast' :
				$this->updateBlast();
				break;
			case 'post_item':
				$this->UpdateItem();
				break;
			case 'danhgia':
				$this->getDanhGiaForm();
				break;
			case 'update_contact':
				$this->update_contact();
				break;
			case 'get_contact':
				$this->get_contact();
				break;
			case 'get_group':
				$this->get_group();
				break;
			case 'del_contact':
				$this->del_contact();
				break;
			case 'update_group':
				$this->update_group();
				break;
			case 'del_group':
				$this->del_group();
				break;
			case 'remove_follow':
				$this->remove_follow();
				break;
			case 'lock_follow':
				$this->lock_follow();
				break;
			case 'post_news':
				$this->UpdateNews();
				break;
			case 'user':
				$this->updateUserInfo();
				break;
			case 'update_more_info':
				$this->updateMoreInfo();
				break;
			case 'remove_mobile_like':
				$this->remove_mobile_like();
				break;

			case 'remove_product_like':
				$this->remove_product_like();
				break;

			case 'using':
				$this->update_mobile_using();
				break;
			case 'using_remove':
				$this->remove_mobile_using();
				break;
			case 'delete_avatar':
				$this->delete_avatar();
				break;
			default:
				die('no action');
		}
	}
	function updateBlast(){
		$id = User::id();
		$u_name = User::user_name();
		$err= 'Mời bạn thử lại';

		$oke= -1;
		if($id > 0){
			$blast = EnBacLib::getParam('content','');
			if($blast != ''){
				if(EnBacLib::checkBadWord($blast)){

					$err = 'Nội dung blast chứa từ bị kiểm duyệt. Bạn hãy kiểm tra lại';

				}
				else {
					$blast = BMLib::addLinkFromContent($blast);
					if( DB::update("account",array("blast" => $blast),"id=".$id) ){

						//halm: them action vao feed 21/09/2009
						//phongct: sua tham so truyen cho feed
						$current_time = time();
						if(BMFeed::doAction(BMFeed::VIET_BLAST, array('sender_user_id'=>$id,
						'sender_user_name'=>$u_name,
						'content_feedback'=>$blast), $current_time)) {

							$oke = 1;
						}
						else $err = 'Cập nhật blast thành công. Nhưng có lỗi gì đó trên hệ thống :(.';
						//update memcache
						if(MEMCACHE_ON){
							$user_memcache = eb_memcache::do_get("user:".$id);
							if($user_memcache){
								$user_memcache['blast'] = $blast;
								eb_memcache::do_put("user:".$id, $user_memcache);
							}
						}
					}else{
						$err = 'Không cập nhật được blast. '.$err;
					}
				}
			}else{
				$err = 'Nội dung blast rỗng. Bạn hãy kiểm tra lại';
			}
		}

		if($oke == 1) {

			$feed = array(
			'acc_id'=>4,
			'act'=>BMFeed::VIET_BLAST,
			'data'=>array(),
			'time'=>$current_time,
			'key'=>$id.'_'.BMFeed::VIET_BLAST.'_'.$current_time
			);
			$feed['data'] = array(
			'id' => null,
			'item_id' => null,
			'content_feedback' => $blast,
			'sender_user_id' => $id,
			'sender_user_name' => $u_name,
			'receiver_user_id' => null,
			'receiver_user_name' => null,
			'replied_user_id' => null,
			'replied_user_name' => null,
			'parent_id' => null,
			'title' => null,
			'image_url' => null,
			'mobile_id' => null,
			'cat_id' => null,
			'item_type' => null,
			'price' => null,
			'other' => null
			);
			$user = User::getUser($id);
			$feed['data']['R_AVATAR'] = ImageUrl::getUserAvatar(50, true, true, $user['avatar_url'], $id, false);
			$feed['data']['R_LINK_PROFILE_ACCOUNT_1'] = Url::build('profile', array('user_name' =>$feed['data']['sender_user_name']));
			$feed['data']['content_feedback'] = EnBacLib::parseEmoticon($feed['data']['content_feedback']);

			$aryFeedBlast = eb_memcache::do_get(BMFeed::MEMCACHE_FEED_VIET_BLAST.$id);
			if(!$aryFeedBlast || !is_array($aryFeedBlast)) $aryFeedBlast = array();
			array_push($aryFeedBlast, $feed);
			eb_memcache::do_put(BMFeed::MEMCACHE_FEED_VIET_BLAST.$id, $aryFeedBlast, 10*60); // 10 phut
			echo json_encode(array('data'=> $feed));

		}
		else  {
			echo json_encode(array('err'=>$err));
		}
		System::halt();
		exit();
	}
	function UpdateItem(){
		EnBacLib::getAllMobile();
		EnBacLib::getProvinces();

		$mobile_id = EnBacLib::getParam('mobile_id', 0);
		$mobile_type_id = 0;
		if(CGlobal::$allMobile)
		{
			foreach(CGlobal::$allMobile as $k => $v)
			{
				if(isset($v[$mobile_id]))
				{
					$mobile_type_id = $k;
				}
			}
		}
		$user_id 			= User::id();
		$user_name 			= User::$data['user_name'];
		$user_status		= User::$data['status'];
		$city_id			= EnBacLib::getParam('city_id');
		$city_name			= CGlobal::$provinces[$city_id]['name'];
		$price				= Url::cdouble(EnBacLib::getParam('price',0));

		$mobile_name 		= CGlobal::$allMobile[$mobile_type_id][$mobile_id]['name'];
		$original_image_url = CGlobal::$allMobile[$mobile_type_id][$mobile_id]['images'];

		$design = CGlobal::$allMobile[$mobile_type_id][$mobile_id]['design'];
		$camera = (CGlobal::$allMobile[$mobile_type_id][$mobile_id]['camera']==''?'0':'1');
		$listen_music = (CGlobal::$allMobile[$mobile_type_id][$mobile_id]['listen_music']==''?'0':'1');
		$memory_card_support = (CGlobal::$allMobile[$mobile_type_id][$mobile_id]['memory_card_support']==''?'0':'1');
		$wifi = (CGlobal::$allMobile[$mobile_type_id][$mobile_id]['wifi']==''?'0':'1');
		$network_support3g = (CGlobal::$allMobile[$mobile_type_id][$mobile_id]['network_support3g']==''?'0':'1');
		$touch = (CGlobal::$allMobile[$mobile_type_id][$mobile_id]['touch']==''?'0':'1');
		$sim_support = (CGlobal::$allMobile[$mobile_type_id][$mobile_id]['2sim_support']==''?'0':'1');

		$item_description 	= addslashes(EnBacLib::getParam('item_description'));
		$content 			= addslashes(EnBacLib::getParam('content'));
		$warrancy 			= EnBacLib::getParam('warrancy');

		$item_description = EnBacLib::clean_value($item_description);
		$content = EnBacLib::clean_value($content);
		$item_type = EnBacLib::getParam('item_type');
		if($item_type==1)
		{
			$item_array = array(
			'mobile_type_id'		=>$mobile_type_id,
			'mobile_id'				=>$mobile_id,
			'mobile_name'			=>$mobile_name,
			'item_type'				=>$item_type,
			'price'					=>$price,
			'brief'					=>$item_description,
			'content'				=>$content,
			'province_id'			=>$city_id,
			'province_name'			=>$city_name,
			'warrancy'				=>$warrancy,
			'created_time'			=>time(),
			'up_time'				=>time(),
			'user_id'				=>$user_id,
			'user_name'				=>$user_name,
			'user_status'			=>$user_status,
			'modify_time'			=>time(),
			'modify_user_name'		=>$user_name,
			'original_image_url'	=>$original_image_url,
			'post_ip'				=>EnBacLib::ip(),
			'status'				=>1,
			'design'				=>$design,
			'camera'				=>$camera,
			'listen_music'			=>$listen_music,
			'memory_card_support'	=>$memory_card_support,
			'wifi'					=>$wifi,
			'network_support3g'		=>$network_support3g,
			'touch'					=>$touch,
			'2sim_support'			=>$sim_support
			);

			$id =DB::insert('bm_item',	$item_array);

			if(!$id){
				$this->setFormError('',"Không đăng được Sản phẩm! Mời bạn thử lại!");
			}
			/*
			else
			{
			DB::query('UPDATE `bm_mobile` SET `total_item_sell`=`total_item_sell`+1 WHERE `id`='.$mobile_id);
			if($price < CGlobal::$allMobile[$mobile_type_id][$mobile_id]['min_price'] || !CGlobal::$allMobile[$mobile_type_id][$mobile_id]['min_price'])
			{
			$min_mobile_array = array(
			'min_price'			=>	$price,
			'user_min_price'	=>	$user_name,
			);
			$id =DB::update('bm_mobile', $min_mobile_array, ' id="'.$mobile_id.'" ');
			if($id)
			EnBacLib::getAllMobile(true, true);
			}
			if($price > CGlobal::$allMobile[$mobile_type_id][$mobile_id]['max_price'] || !CGlobal::$allMobile[$mobile_type_id][$mobile_id]['max_price'])
			{
			$max_mobile_array = array(
			'max_price'			=>	$price,
			'user_max_price'	=>	$user_name,
			);
			$id =DB::update('bm_mobile', $max_mobile_array, ' id="'.$mobile_id.'" ');
			if($id)
			EnBacLib::getAllMobile(true, true);
			}
			}
			*/
		}
		else
		{
			$item_array = array(
			'mobile_type_id'		=>$mobile_type_id,
			'mobile_id'				=>$mobile_id,
			'mobile_name'			=>$mobile_name,
			'item_type'				=>$item_type,
			'price'					=>$price,
			'brief'					=>$item_description,
			'province_id'			=>$city_id,
			'province_name'			=>$city_name,
			'created_time'			=>time(),
			'up_time'				=>time(),
			'user_id'				=>$user_id,
			'user_name'				=>$user_name,
			'user_status'			=>$user_status,
			'modify_time'			=>time(),
			'modify_user_name'		=>$user_name,
			'original_image_url'	=>$original_image_url,
			'post_ip'				=>EnBacLib::ip(),
			'status'				=>1,
			'design'				=>$design,
			'camera'				=>$camera,
			'listen_music'			=>$listen_music,
			'memory_card_support'	=>$memory_card_support,
			'wifi'					=>$wifi,
			'network_support3g'		=>$network_support3g,
			'touch'					=>$touch,
			'2sim_support'			=>$sim_support
			);

			$id =DB::insert('bm_item',	$item_array);

			//DB::query('UPDATE `bm_mobile` SET `total_item_buy`=`total_item_buy`+1 WHERE `id`='.$mobile_id);
		}
		if(!$id)
		echo json_encode(array('post_sucess' => 2));
		else
		{
			echo json_encode(array('post_sucess' => 1));
			//BAT CO THONG BAO DA CO SU THAY DOI (THEM || SUA || XOA) TIN MUA HOAC TIN BAN
			BMFeed::setFlagStatus(BMFeed::FLAG_ON, $user_id, BMFeed::FLAG_ITEM_BUY_SELL);
		}

		exit();
	}
	function getDanhGiaForm(){

	}
	function getMobileList(){
		$id = Url::get('id',0);
		if($id > 0){
			$sql = "SELECT mobile_name, id, os_id
										  FROM bm_mobile
										  WHERE type_id = $id
										  ORDER BY mobile_name";
			$is_obj = Url::get('is_object',false);
			if($is_obj){
				$res = DB::query($sql);
				while($row = @mysql_fetch_assoc($res)){
					$mobile_list[$row['id']] = $row;
				}
			}else{
				$mobile_list = DB::fetch_all_array($sql);
			}
			echo json_encode(array('list' => $mobile_list, 'intReturn' => 2));
		}else{
			echo json_encode(array('err' => 'Không tìm thấy hãng điện thoại hợp lệ', 'intReturn' => -1));
		}
		exit();
	}
	function get_contact(){
		if(!User::is_login()){
			echo '({"content":"no_perm"})';
			exit();
		}
		$sql = "SELECT bm_contact.*, bm_contact_group.name_group FROM bm_contact LEFT JOIN bm_contact_group ON bm_contact.group_id = bm_contact_group.id WHERE bm_contact.user_id = ".User::id()." ORDER BY group_id";

		$re  = DB::query($sql);
		$contacts = array();
		$temp_arr = array();
		if($re){
			while($row = mysql_fetch_assoc($re)){
				$temp_arr['id'] = $row['id'];
				$temp_arr['name_contact'] = $row['name_contact'];
				$temp_arr['number_contact'] = $row['number_contact'];
				$contacts[$row['group_id']]['name_group'] = $row['name_group'];
				$contacts[$row['group_id']]['contacts'][$row['id']] = $temp_arr;
			}
		}
		if($contacts){
			echo json_encode($contacts);
		}
		else{
			echo '({"content":"no_contact"})';
		}
		exit();
	}
	function get_group(){
		if(!User::is_login()){
			echo '({"content":"no_perm"})';
			exit();
		}

		$sql = "SELECT * FROM bm_contact_group WHERE user_id IN (0,".User::id().")";

		$re  = DB::query($sql);
		$groups = array();
		if($re){
			while($row = mysql_fetch_assoc($re)){
				$groups[$row['id']] = $row['name_group'];
			}
		}

		if($groups){
			$json['content'] = EnBacLib::getOption($groups,Url::get('group_id',0));
			echo json_encode($json);
		}
		exit();
	}

	function update_contact(){
		if(!User::is_login()){
			echo '({"content":"no_perm"})';
			exit();
		}
		$id = Url::get('contact_id',0);

		if($id > 0){
			$check = DB::count("bm_contact", " id = $id AND user_id = ".User::id());
			if($check){
				$name_contact	=EnBacLib::upcase_first_char(Url::tget('name_contact',''));
				$number_contact	=Url::tget('number_contact','');
				$group_id	=Url::tget('group_id',0);
				$val = array (
				'name_contact'      =>$name_contact,
				'number_contact'    =>$number_contact,
				'group_id'          =>$group_id
				);
				$id_update = DB::update("bm_contact",$val," id = $id  AND user_id = ".User::id());
				if($id_update){
					$json = array(
					'content'			=>'success',
					'name_contact'      =>$name_contact,
					'number_contact'    =>$number_contact,
					'group_id'          =>$group_id
					);
					echo json_encode($json);
				}
				else{
					echo '({"content":"no_perm"})';
				}
			}
			else{
				echo '({"content":"no_perm"})';
			}
		}
		else{
			echo '({"content":"no_perm"})';
		}

		exit();
	}
	function del_contact(){
		if(!User::is_login()){
			echo '({"content":"no_perm"})';
			exit();
		}
		$id = Url::get('contact_id',0);

		if($id > 0){
			$check = DB::count("bm_contact", " id = $id AND user_id = ".User::id());
			if($check){

				$id_del = DB::delete("bm_contact"," id = $id  AND user_id = ".User::id());
				if($id_del){
					echo '({"content":"success"})';
				}
				else{
					echo '({"content":"no_perm"})';
				}
			}
			else{
				echo '({"content":"no_perm"})';
			}
		}
		else{
			echo '({"content":"no_perm"})';
		}

		exit();
	}
	function del_group(){
		if(!User::is_login()){
			echo '({"content":"no_perm"})';
			exit();
		}
		$id = Url::get('group_id',0);
		if($id > 0){
			$count = DB::count("bm_contact_group", " id = $id AND user_id = ".User::id());
			if($count){
				$sql_check ="SELECT * FROM bm_contact WHERE group_id = $id AND user_id = ".User::id();
				$re_check = DB::query($sql_check);
				$contact_id = array();
				while ($row = mysql_fetch_assoc($re_check)){
					$contact_id[] = $row['id'];
				}

				$contact_ids = implode(',',$contact_id);
				if($contact_ids){
					$id_update = DB::update("bm_contact",array('group_id'=>0)," id IN ($contact_ids) ");
				}
				$id_del = DB::delete("bm_contact_group"," id = $id AND user_id = ".User::id());
				if($id_del){
					echo '({"content":"success"})';
				}
				else{
					echo '({"content":"no_perm"})';
				}
			}
			else{
				echo '({"content":"no_perm"})';
			}
		}
		else{
			echo '({"content":"no_perm"})';
		}
		exit();
	}
	function update_group(){
		if(!User::is_login()){
			echo '({"content":"no_perm"})';
			exit();
		}
		$id = Url::get('group_id',0);

		if($id > 0){
			$check = DB::count("bm_contact_group", " id = $id AND user_id = ".User::id());
			if($check){
				$name_group	=Url::tget('name_group','');
				$val = array (
				'name_group'      =>EnBacLib::upcase_first_char($name_group)
				);
				$id_update = DB::update("bm_contact_group",$val," id = $id AND user_id = ".User::id());
				if($id_update){
					echo '({"content":"success"})';
				}
				else{
					echo '({"content":"no_perm"})';
				}
			}
			else{
				echo '({"content":"no_perm"})';
			}
		}
		else{
			echo '({"content":"no_perm"})';
		}

		exit();
	}
	function remove_follow(){
		if(!User::is_login()){
			echo '({"content":"no_perm"})';
			exit();
		}
		$id = intval(Url::get('follow_id',0));

		if($id > 0){
			$check = DB::count("bm_follow", " id = $id AND follower = ".User::id());
			if($check){
				$id_del = DB::delete_id ("bm_follow",$id);
				if($id_del){
					echo '({"content":"success"})';
				}
				else{
					echo '({"content":"no_perm"})';
				}
			}
			else{
				echo '({"content":"no_perm"})';
			}
		}
		else{
			echo '({"content":"no_perm"})';
		}
		exit();
	}
	function lock_follow(){
		if(!User::is_login()){
			echo '({"content":"no_perm"})';
			exit();
		}
		$id = intval(Url::get('follow_id',0));

		if($id > 0){
			$check = DB::select("bm_follow", " id = $id AND user_id = ".User::id());
			if($check){
				$status = ($check['status'])? 0 : 1 ;
				$id_update = DB::update_id ("bm_follow",array('status'=>$status),$id);
				if($id_update){
					$result = array('content' => 'success','status'=>$status);
					echo json_encode($result);
				}
			}
			else{
				echo '({"content":"no_perm"})';
			}
		}
		else{
			echo '({"content":"no_perm"})';
		}
		exit();
	}

	function UpdateNews(){
		EnBacLib::getAllMobile();
		EnBacLib::getProvinces();

		$mobile_id = EnBacLib::getParam('mobile_id', 0);
		$mobile_type_id = 0;
		if(CGlobal::$allMobile)
		{
			foreach(CGlobal::$allMobile as $k => $v)
			{
				if(isset($v[$mobile_id]))
				{
					$mobile_type_id = $k;
				}
			}
		}
		$user 				= User::$data;
		$user_id 			= $user['id'];
		$user_name 			= $user['user_name'];
		$mobile_name 		= CGlobal::$allMobile[$mobile_type_id][$mobile_id]['name'];
		$original_image_url = CGlobal::$allMobile[$mobile_type_id][$mobile_id]['images'];
		$title	 			= addslashes(EnBacLib::getParam('title'));
		$des	 			= addslashes(EnBacLib::getParam('content'));
		$brief 				= EnBacLib::word_limit(String::html2txt(EnBacLib::post_db_parse_html($des)),25,'...');
		$image_url 			= EnBacLib::getParam('image_url');
		$rank				= EnBacLib::getParam('rank');
		$des 				= EnBacLib::post_db_parse_html($des);
		$brief 				= EnBacLib::post_db_parse_html($brief);
		$item_type 			= EnBacLib::getParam('item_type');

		switch ($item_type){
			case 2:
				if($user['status'] == ACC_SHOP || $user['status'] == ACC_PERSON ){
					$arr_mobile = DB::select(PREFIX_TABLE.'mobile','id='.$mobile_id);
					$mobile_type_id = $arr_mobile['type_id'];
					$mobile_name 	= $arr_mobile['mobile_name'];
					$mobile_images 	= $arr_mobile['images'];
					$mobile_vote 	= $arr_mobile['vote'];
					$mobile_rank 	= $arr_mobile['rank'];

					$item_array = array(
					'cat_id'				=>CATID_REVIEW,
					'title'					=>$title,
					'brief'					=>$brief,
					'des'					=>$des,
					'time_create'			=>time(),
					'time_modify'			=>time(),
					'image_url'				=>$original_image_url,
					'user_id'				=>$user_id,
					'user_name'				=>$user_name,
					'mobile_type_id'		=>$mobile_type_id,
					'mobile_id'				=>$mobile_id,
					'mobile_name'			=>$mobile_name,
					'review_rank'			=>$rank,
					'status'				=>1
					);
				}
				else
				{
					echo json_encode(array('post_sucess' => 'no_perm'));
					exit();
				}
				break;
			case 3:
				if($user['status'] == ACC_TYPE_MOBILE || $user['status'] == ACC_NETWORK){
					$item_array = array(
					'cat_id'				=>CATID_PROMOTION,
					'title'					=>$title,
					'des'					=>$des,
					'time_create'			=>time(),
					'time_modify'			=>time(),
					'user_id'				=>$user_id,
					'user_name'				=>$user_name,
					'status'				=>1
					);
					break;
				}
				else
				{
					echo json_encode(array('post_sucess' => 'no_perm'));
					exit();
				}
			default:
				if($user['status'] != ACC_PERSON ){
					$item_array = array(
					'cat_id'				=>CATID_NEWS,
					'title'					=>$title,
					'des'					=>$des,
					'time_create'			=>time(),
					'time_modify'			=>time(),
					'user_id'				=>$user_id,
					'user_name'				=>$user_name,
					'status'				=>1
					);
					break;
				}
				else
				{
					echo json_encode(array('post_sucess' => 'no_perm'));
					exit();
				}
		}

		$newsid =DB::insert(PREFIX_TABLE.'news',	$item_array);

		if(!$newsid){
			$this->setFormError('',"Không đăng được đánh giá! Mời bạn thử lại!");
			echo json_encode(array('post_sucess' => 2));
		}else {
			//Send anh dai dien
			if($item_type == 2){
				$vote = $mobile_vote + 1;
				$mobile_rank = ($mobile_vote * $mobile_rank + $rank) / $vote;
				$mobile_rank = number_format($mobile_rank,1,",",".");
				DB::update(PREFIX_TABLE.'mobile',array('vote'=>$vote,'rank'=>$mobile_rank),'id='.$mobile_id);
			}

			if($image_url != '' && $image_url != 'undefined'){
				$aryError = array();
				$tail  = explode('.', $image_url);
				$tail  = array_pop($tail);
				if(in_array(strtolower($tail),array('jpg','gif','png'))){
					//halm: CURL
					$file_name = time().md5($image_url).".".$tail;
					$arr_send_inf['file_path']= $image_url;
					$arr_send_inf['id']  = $newsid;
					$arr_send_inf['news_name']= $file_name;
					$arr_send_inf['old_file'] = "";
					/*$curl = new CURL();
					$curl->setCallback('getMessageFromCurl');
					$url  = ImageUrl::getImageServerUrl()."code_img/create_image_news_from_file.php";
					$output = $curl->post($url,$arr_send_inf);
					if($output[1] == 'OKE'){
					DB::update(PREFIX_TABLE.'news', array('file_url'=>$file_name),'id='.$newsid);

					}else{
					$this->setFormError('upload_images', 'Upload FTP to server ['.FTP_IMAGE_SERVER.'] error');
					}		*/

				} else {
					echo json_encode(array('post_sucess' => 'err_image_url'));
					exit();
				}
			}
			echo json_encode(array('post_sucess' => 1));
		}



		exit();
	}
	
	function updateMoreInfo() {
		$uid = Url::get('id_user');
		$out = array(
		'update_sucess' => 0,
		'key' => Url::get('key',''),
		'data'=> Url::get('data',''),
		'msg' => "Cập nhật thất bại! Xin vui lòng thử lại"
		);
		
		if((int)$uid > 0){
			$aryUpdate = array();
			$aryUpdate['address']		= Url::get('txt_address', '');
			$aryUpdate['province_id'] 	= Url::get('province_id', 0);
			$aryUpdate['district_id'] 	= Url::get('district_id', 0);
			
			DB::update('account', $aryUpdate, ' id='.$uid);
			User::updateUserCache($uid);
			$out['update_sucess'] = 1;
		}
		
		echo json_encode($out);
		exit();
	}

	function updateUserInfo(){
		$out = array(
		'update_sucess' => 0,
		'key' => Url::get('key',''),
		'data'=> Url::get('data',''),
		'msg' => ""
		);
		$uid = Url::get('id_user');
		//$uid = User::id();
		if(($out['key'] != '') && ($uid != 0)){
			$update = array();
			switch($out['key']){
				case 'user_name':
					$username_existed = DB::fetch("SELECT count(*) as total FROM account WHERE user_name='".$out['data']."' AND id <> $uid LIMIT 0,1");
					if(intval($username_existed['total']) > 0){
						$out['msg'] = "User_name này đang được sử dụng! Bạn vui lòng nhập User_name khác";
					}else{
						$update['user_name'] = $out['data'];
						$out['update_sucess'] = 1;
					}
					break;

				case 'password':
					$update['password'] = User::encode_password($out['data']);
					$out['update_sucess'] = 1;
					break;
					
				case 'pass_old':
					$pass_old = User::encode_password($out['data']);
					$password = DB::get_one("SELECT password FROM account WHERE id = ".$uid);
					 if ($pass_old !== $password){
					 		$out['msg'] = "Mật khẩu cũ không đúng, mời bạn nhập lại mật khẩu cũ!";	
					}
					else{
						$out['update_sucess'] = 1;	
					}
					break;
					
				case 'name_shop':
					$update['full_name'] = $out['data'];
					$out['update_sucess']=1;
				case 'gender':
					$update['gender'] = (trim($out['data']) == "Nam") ? 1 : 0;
					$out['update_sucess'] = 1;
					break;
				/*QuynhTM đóng cho phép xóa sdt */
				case 'mobile_phone':
				  /*	if((trim($out['data']) == 'Chưa cập nhật')){
				  		$out['msg'] = "Số điện thoại không hợp lệ! Bạn vui lòng nhập lại";
				  	}else{*/
						//echo '=='.$out['data']; exit();
					  	if ($out['data']!==''  && is_numeric(trim($out['data']))){
							$mobile_phone = preg_replace("/[^0-9]/", "", $out['data']);
							if(EnBacLib::is_mobile($mobile_phone)){
								$update['mobile_phone']  = $mobile_phone;
								$out['update_sucess'] = 1;
							}else{
								$out['msg'] = "Số Mobile không hợp lệ! Bạn vui lòng nhập lại";
							}
						}else{
							$update['mobile_phone']  = $out['data'];
							$out['update_sucess'] = 1;
						}
				 // 	}
				break;
				case 'mobile_phone2':
					/*if((trim($out['data']) == 'Chưa cập nhật')){
				  		$out['msg'] = "Số điện thoại không hợp lệ! Bạn vui lòng nhập lại";
				  	}else{*/
					if ((trim($out['data']) != '') && is_numeric(trim($out['data']))){
						$mobile_phone = preg_replace("/[^0-9]/", "", $out['data']);
						if(EnBacLib::is_mobile($mobile_phone)){
							$update['mobile_phone2']  = $mobile_phone;
							$out['update_sucess'] = 1;
						}
					}else{
						$update['mobile_phone2']  = $out['data'];
						$out['update_sucess'] = 1;
					}
				break;
				case 'email':case 'website':case 'yahoo_id': case 'address':
					if((trim($out['data']) == 'Chưa cập nhật')){
						if($out['key'] == 'email'){
							$out['msg'] = "Email là không hợp lệ!";
						}
						if($out['key'] == 'website'){
							$out['msg'] = "Website là không hợp lệ!";
						}
						$out['msg'] .= ' Bạn vui lòng nhập lại.';
					}else{
						if(!EnBacLib::checkBadWord($out['data'])){
							if($out['key'] == 'website'){
								$update['website'] = strip_tags(trim($out['data']));
								$out['update_sucess'] = 1;
							}else if($out['key'] == 'email'){
								
								$out['data'] = strip_tags(trim($out['data']));
								if ($out['data']!==''){
									$mail_existed = DB::fetch("SELECT count(*) as total FROM account WHERE email='".$out['data']."' AND id <> $uid LIMIT 0,1");
									if(intval($mail_existed['total']) > 0){
										$out['msg'] = "Email này đang được sử dụng! Bạn vui lòng nhập email khác";
									}
									else{
										//QuynhTM add checked user thuong thi update user_name va email cung ten
										$curUser = User::getUser ( $uid );
										if($curUser['status']==ACC_NOMAL && $curUser['id']!=1 /*id=1 =>>admin*/){
											$update['user_name'] = $out['data'];
										}
										
										$update['email'] = $out['data'];
										$out['update_sucess'] = 1;
									}
								}else{
									$update['email'] = $out['data'];
									$out['update_sucess'] = 1;
								}
							}else{
								$update[$out['key']] = $out['data'];
								$out['update_sucess'] = 1;
							}
						}else{
							$out['msg'] = "Dữ liệu có chứa từ xấu! Bạn vui lòng nhập lại";
						}
					}
				break;
				case 'email2':case 'website2':case 'yahoo_id2':case 'address2':
					if((trim($out['data']) == 'Chưa cập nhật')){
						if($out['key'] == 'email2'){
							$out['msg'] = "Email khác là không hợp lệ!";
						}
						if($out['key'] == 'website2'){
							$out['msg'] = "Website khác là không hợp lệ!";
						}
						$out['msg'] .= ' Bạn vui lòng nhập lại.';
					}else{
						if(!EnBacLib::checkBadWord($out['data'])){
							if($out['key'] == 'website2'){
								$update['website2'] = strip_tags(trim($out['data']));
								$out['update_sucess'] = 1;
							}else if($out['key'] == 'email2'){
								$out['data'] = strip_tags(trim($out['data']));
								if ($out['data']!==''){
									$mail_existed = DB::fetch("SELECT count(*) as total FROM account WHERE email='".$out['data']."' AND id <> $uid LIMIT 0,1");
									if(intval($mail_existed['total']) > 0){
										$out['msg'] = "Email này đang được sử dụng! Bạn vui lòng nhập email khác";
									}
									else{
										$update['email2'] = $out['data'];
										$out['update_sucess'] = 1;
									}
								}else{
									$update['email2'] = $out['data'];
									$out['update_sucess'] = 1;
								}
	
							}else{
								$update[$out['key']] = $out['data'];
								$out['update_sucess'] = 1;
							}
						}else{
							$out['msg'] = "Dữ liệu có chứa từ xấu! Bạn vui lòng nhập lại";
						}
					}
				break;
				case 'birth_day':
					$arr = explode('-',$out['data']);
					if(is_numeric($arr['0']) && is_numeric($arr['1']) && is_numeric($arr['2']) && checkdate($arr['1'], $arr['0'], $arr['2']) && (1930 < $arr['2']) && ($arr['2'] < 2010)){
						$out['update_sucess'] = 1;
						$update['birth_day'] = $arr['2'].'-'.$arr['1'].'-'.$arr['0'];
					}else{
						$out['msg'] = "Ngày sinh không hợp lệ! Vui lòng nhập lại";
					}
					break;
				default:
					if((trim($out['data']) == 'Chưa cập nhật')){
				  		$out['msg'] = "Số điện thoại không hợp lệ! Bạn vui lòng nhập lại";
				  	}else{
						$update[$out['key']] = $out['data'];
						$out['update_sucess'] = 1;
				  	}
			}
			if(!empty($update) && ($out['update_sucess'] == 1) && DB::update('account',$update,"id=".$uid)){
				//update lai User memcache
				User::updateUserCache($uid);
				User::$current = new User();
			}
		}
		echo json_encode($out);
		exit();
	}

	function remove_mobile_like(){
		$id = Url::get('id',0);
		$out = array(
		'msg' => 'Xóa thất bại!',
		'success' => 0
		);
		if($id > 0){
			$user_id = User::id();
			if(($user_id > 0) && (DB::delete("bm_like_mobile","account_id=$user_id AND mobile_id = $id"))){
				$out['msg'] = 'Xóa thành công!';
				$out['success'] = 1;
			}
		}
		echo json_encode($out);
	}



	function remove_product_like(){
		$id = Url::get('id',0);
		$out = array(
		'msg' => 'Xóa thất bại!',
		'success' => 0
		);
		if($id > 0){
			$user_id = User::id();
			if(($user_id > 0) && (DB::delete("so_like_products","account_id=$user_id AND product_id = $id"))){
				$out['success'] = 1;
			}
		}
		echo json_encode($out);
	}


	function update_mobile_using(){
		$msg = array(
		'error' => 1,
		'msg' => '');
		$mobile_id	= Url::get('mobile_id', 0);
		$mobile_type= Url::get('mobile_type', 0);
		$type = Url::get('type','mobile');
		if($mobile_id > 0 && $mobile_type > 0){
			$oke = true;
			$user= User::$data;
			if($type == 'mobile'){
				$update=array('mobile'=>$mobile_id,'mobile_type'=>$mobile_type);
				$oke = !($user['mobile2'] == $mobile_id);
			}else{
				$update=array('mobile2'=>$mobile_id,'mobile_type2'=>$mobile_type);
				$oke = !($user['mobile'] == $mobile_id);
			}
			if($oke){
				$check = DB::fetch("SELECT mobile_name, images, id FROM bm_mobile WHERE id = $mobile_id AND type_id = $mobile_type AND status = 1 LIMIT 0,1");
				if($check){
					if(DB::update('account',$update,'id = '.$user['id'])){
						if(MEMCACHE_ON){
							$user_memcache = eb_memcache::do_get("user:".$user['id']);
							if($user_memcache){
								if($type == 'mobile'){
									$user_memcache['mobile'] = $mobile_id;
									$user_memcache['mobile_type'] = $mobile_type;
								}else{
									$user_memcache['mobile2'] = $mobile_id;
									$user_memcache['mobile_type2'] = $mobile_type;
								}
								eb_memcache::do_put("user:".$user['id'], $user_memcache);
							}
						}
						$msg['error'] = 0;
						$msg['type'] = $type;
						$msg['name'] = $check['mobile_name'];
						$msg['link'] = insert_getProductLink(array('id' => $check['id'], 'ebname' => $check['mobile_name']));
						$msg['img']  = ImageUrl::getProductImage(157,true,true,$check['images'],$check['id']);
					}else{
						$msg['msg'] = 'Không cập nhật được dữ liệu';
					}
				}else{
					$msg['msg'] = 'Không tìm thấy dữ liệu phù hợp';
				}
			}else{
				$msg['msg'] = 'Bạn đã đang dùng điện thoại này! Vui lòng chọn điện thoại khác';
			}
		}
		echo json_encode($msg);
		exit();
	}
	function remove_mobile_using(){
		$id = User::id();
		$msg= array('error' => 1, 'msg' => 'Thao tác thất bại! Vui lòng thử lại');
		if($id > 0){
			if(DB::update('account',array('mobile2'=>0,'mobile_type2'=>0),"id=$id")){
				$msg['error'] = 0;
				if(MEMCACHE_ON){
					$user_memcache = eb_memcache::do_get("user:".$id);
					if($user_memcache){
						$user_memcache['mobile2'] = 0;
						$user_memcache['mobile_type2'] = 0;
						eb_memcache::do_put("user:".$id, $user_memcache);
					}
				}
			}
		}
		echo json_encode($msg);
		exit();
	}
	/**
	 * QuynhTM add 29/11/2010
	 * Xoa anh avatar cua account
	 */
	function delete_avatar(){
		$user_id = Url::get('id_user',0);
		$date_img = Url::get('date_img',0);
		$out = array(
		'msg' => 'Xóa thất bại!',
		'update_sucess' => 0,
		'avatar_url' =>''
		);
		if($user_id > 0){
			$update_row =array();
			$update_row['avatar_url'] = '';
			if((SoImg::deleteImage ( $user_id, SoImg::FOLDER_AVATAR, $date_img, '', true )) && DB::update('account',$update_row,'id = '.$user_id)){
				User::updateUserCache($user_id);//update lai cache user
				$curUser = User::getUser($user_id);
				$out['avatar_url'] = SoImg::getImage($curUser['avatar_url'], $user_id, SoImg::FOLDER_AVATAR, $curUser['create_time'], '90x0');
				$out['update_sucess'] = 1;
			}
		}
		echo json_encode($out);
	}
	// NghiaPT added 21/06/2011 check input
	function validateEmail($email){
		$regex = '/([a-z0-9_.-]+)'. # name

		'@'. # at

		'([a-z0-9.-]+){2,255}'. # domain & possibly subdomains

		'.'. # period

		'([a-z]+){2,10}/i'; # domain extension 
		$eregi = preg_replace($regex, '', $email);
		return empty($eregi) ? true : false;
	}
	function getTextBetweenTags($string, $tagname) {
	    $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
	    preg_match($pattern, $string, $matches);
	    return $matches[1];
	}
	function isValidURL($url){
		return preg_match('/^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$/i',$url);
	}
}
?>