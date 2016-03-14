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

class ajax_faqs_list {
	
	static $errorList = array();
	
	function playme()
	{
		$code = Url::get ( 'code' );
		switch ($code) {
			case 'get_list':
				$this->getListFAQ();
				break;
			case 'post':
				$this->addFaqs();
				break;
			case 'update':
				$this->updateFaqs();
				break;
			case 'add_answer':
				$this->addAnswer();
				break;
			case 'update_answer':
				$this->updateAnswer();
				break;
			case 'set_like_faqs' :
				$faqs_id = (int)Url::get('faqs_id');
				$faqs_user_id = (int)Url::get('faqs_user_id');
				$account_id = User::id();				
				$this->set_like_faqs($faqs_id, $account_id, $faqs_user_id);
				break;
			case 'set_vote_answer' :
				$answer_id = (int)Url::get('answer_id');
				$answer_user_id = (int)Url::get('answer_user_id');
				$account_id = User::id();				
				$this->set_vote_answer($answer_id, $account_id, $answer_user_id);
				break;
			case 'set_like_answer' :
				$faqs_id = (int)Url::get('faqs_id');
				$answer_id = (int)Url::get('answer_id');
				$account_id = User::id();
				$this->set_like_answer($faqs_id, $answer_id, $account_id);
				break;
			case 'set_un_like_answer' :
				$faqs_id = (int)Url::get('faqs_id');
				$answer_id = (int)Url::get('answer_id');
				$account_id = User::id();
				$this->set_un_like_answer($faqs_id, $answer_id, $account_id);
				break;
			case 'del_faq':
				$faqs_id = (int)Url::get('faqs_id');
				$account_id = User::id();
				$this->delFaqs($faqs_id, $account_id);
				break;
			case 'del_answer':
				$answer_id = (int)Url::get('answer_id');
				$is_like = (int)Url::get('is_like');
				$faqs_id = (int)Url::get('faqs_id');
				$account_id = User::id();
				$this->delAnswer($answer_id, $account_id, $faqs_id, $is_like);
				break;
			default:
				break;
		}
	}
	function addFaqs()
	{
		EnBacLib::getAllMobile();
		$title 			= EnBacLib::getParam('title');
		$brief 			= addslashes(strip_tags(EnBacLib::getParam('brief')));
		$mobile_id 		= EnBacLib::getParam('mobile_id', 0);
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
		$mobile_name 		= CGlobal::$allMobile[$mobile_type_id][$mobile_id]['name'];
		$user_id 			= User::id();
		$user_name 			= User::$data['user_name'];
		$time				= time();
		$up_time			= time();
		$post_ip			= EnBacLib::ip();
		$status				= 1;
		
		$item_array = array(
				'title'				=> $title,
				'brief'				=> $brief,
				'mobile_id'			=> $mobile_id,
				'mobile_name'		=> $mobile_name,
				'user_id'			=> $user_id,
				'user_name'			=> $user_name,
				'time'				=> $time,
				'up_time'			=> $up_time,
				'post_ip'			=> $post_ip,
				'status'			=> $status
				);
								
		$id = DB::insert('bm_question',	$item_array);
		
		if(!$id)
		{
			$this->setFormError('',"Không đăng được câu hỏi! Mời bạn thử lại!");
			echo json_encode(array('post_sucess' => 2));
		}
		else
		{
			echo json_encode(array('post_sucess' => 1, 'update'=>0));
			//BAT CO THONG BAO DA CO SU THAY DOI (THEM || SUA || XOA) TIN MUA HOAC TIN BAN
  			//BMFeed::setFlagStatus(BMFeed::FLAG_ON, $user_id, BMFeed::FLAG_ITEM_BUY_SELL);
			$this->removeCached($mobile_id);
		}
		
		exit();
	}
	function updateFaqs()
	{
		$faqs_id 		= EnBacLib::getParam('faqs_id');
		$title 			= EnBacLib::getParam('title');
		$brief 			= addslashes(strip_tags(EnBacLib::getParam('brief')));
		$up_time		= time();
		$post_ip		= EnBacLib::ip();
		
		$item_array = array(
				'title'				=> $title,
				'brief'				=> $brief,
				'up_time'			=> $up_time,
				'post_ip'			=> $post_ip,
				);
								
		$id = DB::update('bm_question',	$item_array, ' id='.$faqs_id);
		
		if(!$id)
		{
			$this->setFormError('',"Không sửa được câu hỏi! Mời bạn thử lại!");
			echo json_encode(array('post_sucess' => 2));
		}
		else
		{
			echo json_encode(array('post_sucess' => 1, 'update'=>1));
			//BAT CO THONG BAO DA CO SU THAY DOI (THEM || SUA || XOA) TIN MUA HOAC TIN BAN
  			//BMFeed::setFlagStatus(BMFeed::FLAG_ON, $user_id, BMFeed::FLAG_ITEM_BUY_SELL);
		}
		
		exit();
	}
	function addAnswer()
	{
		$faqs_user_id	= EnBacLib::getParam('faqs_user_id', 0);
		$user_id 		= User::id();
		
		if($faqs_user_id==$user_id)
		{
			echo json_encode(array('post_sucess' => 3));
		}
		else
		{
			$question_id 	= EnBacLib::getParam('faqs_id', 0);
			$brief 			= addslashes(strip_tags(EnBacLib::getParam('brief')));
			
			$user_name 		= User::$data['user_name'];
			$time			= time();
			$up_time		= time();
			$post_ip		= EnBacLib::ip();
			$status			= 1;
			
			$item_array = array(
					'question_id'		=> $question_id,
					'brief'				=> $brief,
					'user_id'			=> $user_id,
					'user_name'			=> $user_name,
					'time'				=> $time,
					'up_time'			=> $up_time,
					'post_ip'			=> $post_ip,
					'status'			=> $status
					);
									
			$id = DB::insert('bm_answer', $item_array);
			
			if(!$id)
			{
				$this->setFormError('', "Không đăng được câu trả lời! Mời bạn thử lại!");
				echo json_encode(array('post_sucess' => 2));
			}
			else
			{
				DB::query("UPDATE ".PREFIX_TABLE."question SET  `answer_count` = `answer_count`+1  WHERE id = ".$question_id);
				echo json_encode(array('post_sucess' => 1));
				//BAT CO THONG BAO DA CO SU THAY DOI (THEM || SUA || XOA) TIN MUA HOAC TIN BAN
				//BMFeed::setFlagStatus(BMFeed::FLAG_ON, $user_id, BMFeed::FLAG_ITEM_BUY_SELL);
				$this->removeCached($mobile_id);
			}
		}
		
		exit();
	}
	function updateAnswer()
	{
		$answer_id 		= EnBacLib::getParam('answer_id', 0);
		$brief 			= addslashes(strip_tags(EnBacLib::getParam('brief')));
		$up_time		= time();
		$post_ip		= EnBacLib::ip();
		
		$item_array = array(
				'brief'				=> $brief,
				'up_time'			=> $up_time,
				'post_ip'			=> $post_ip,
				);
								
		$id = DB::update('bm_answer', $item_array, 'id='.$answer_id);
		
		if(!$id)
		{
			$this->setFormError('', "Không đăng được câu trả lời! Mời bạn thử lại!");
			echo json_encode(array('post_sucess' => 2));
		}
		else
		{
			echo json_encode(array('post_sucess' => 1));
			//BAT CO THONG BAO DA CO SU THAY DOI (THEM || SUA || XOA) TIN MUA HOAC TIN BAN
  			//BMFeed::setFlagStatus(BMFeed::FLAG_ON, $user_id, BMFeed::FLAG_ITEM_BUY_SELL);
		}
		
		exit();
	}
	function set_like_faqs($faqs_id, $account_id, $faqs_user_id)
	{
        $err = '';
		$script = '';
		$denied = false;
		if($faqs_user_id==$account_id && $account_id > 0)
		{
			echo json_encode(array('intReturn' => 2));
		}
		else
		{
			if($faqs_id > 0 && $account_id > 0)
			{
				if(DB::query("UPDATE ".PREFIX_TABLE."question SET  `like_count` = `like_count`+1  WHERE id = ".$faqs_id))
					$msg = 'Bạn đã chọn thích câu hỏi này thành công!';
				else
					$msg = 'System error ...';
			}
			else
			{
				if(!$account_id > 0) {
					$err = '';
					$denied = true;
					$script = 'Bm.show_access_notify()';
				}
				else {
					$err = 'System error ...';
				}
			}
			
			if($err != '' ||  $denied)
				echo json_encode(array('msg'=>$err, 'intReturn' => -1, 'script' => $script));	    
			else
				echo json_encode(array('intReturn' => 1, 'msg'=>$msg));
		}
	}
	function set_vote_answer($answer_id, $account_id, $answer_user_id)
	{
        $err = '';
		$script = '';
		$denied = false;
		if($answer_user_id==$account_id && $account_id > 0)
		{
			echo json_encode(array('intReturn' => 2));
		}
		else
		{
			if($answer_id > 0 && $account_id > 0)
			{
				if(DB::query("UPDATE ".PREFIX_TABLE."answer SET  `vote_count` = `vote_count`+1  WHERE id = ".$answer_id))
					$msg = 'Bạn đã Vote cho câu trả lời thành công!';
				else
					$msg = 'System error ...';
			}
			else
			{
				if(!$account_id > 0) {
					$err = '';
					$denied = true;
					$script = 'Bm.show_access_notify()';
				}
				else {
					$err = 'System error ...';
				}
			}
			
			if($err != '' ||  $denied)
				echo json_encode(array('msg'=>$err, 'intReturn' => -1, 'script' => $script));	    
			else
				echo json_encode(array('intReturn' => 1, 'msg'=>$msg, 'answer_id'=>$answer_id));
		}
	}
	function set_like_answer($faqs_id, $answer_id, $account_id)
	{
        $err = '';
		$script = '';
		$denied = false;
	    if($answer_id > 0 && $account_id > 0)
		{
			if(DB::query("UPDATE ".PREFIX_TABLE."answer SET  `is_like` = 1  WHERE id = ".$answer_id))
			{
				DB::query("UPDATE ".PREFIX_TABLE."question SET  `is_close` = 1  WHERE id = ".$faqs_id);
				$msg = 'Bạn đã chọn câu Trả lời hay thành công!';
			}
			else
				$msg = 'System error ...';
	    }
	    else
		{
			if(!$account_id > 0) {
				$err = '';
				$denied = true;
				$script = 'Bm.show_access_notify()';
			}
			else {
				$err = 'System error ...';
			}
	    }
	    
		if($err != '' ||  $denied)
			echo json_encode(array('msg'=>$err, 'intReturn' => -1, 'script' => $script));	    
		else
			echo json_encode(array('intReturn' => 1, 'msg'=>$msg));
	}
	function set_un_like_answer($faqs_id, $answer_id, $account_id)
	{
        $err = '';
		$script = '';
		$denied = false;
	    if($answer_id > 0 && $account_id > 0)
		{
			if(DB::query("UPDATE ".PREFIX_TABLE."answer SET  `is_like` = 0  WHERE id = ".$answer_id))
			{
				DB::query("UPDATE ".PREFIX_TABLE."question SET  `is_close` = 0  WHERE id = ".$faqs_id);
				$msg = 'Bạn đã hủy câu Trả lời hay thành công!';
			}
			else
				$msg = 'System error ...';
	    }
	    else
		{
			if(!$account_id > 0) {
				$err = '';
				$denied = true;
				$script = 'Bm.show_access_notify()';
			}
			else {
				$err = 'System error ...';
			}
	    }
	    
		if($err != '' ||  $denied)
			echo json_encode(array('msg'=>$err, 'intReturn' => -1, 'script' => $script));	    
		else
			echo json_encode(array('intReturn' => 1, 'msg'=>$msg));
	}
	function delFaqs($faqs_id, $account_id)
	{
        $err = '';
		$script = '';
		$denied = false;
	    if($faqs_id > 0 && $account_id > 0)
		{
			if(DB::query("UPDATE ".PREFIX_TABLE."question SET  `status` = -1  WHERE id = ".$faqs_id))
			{
				DB::query("UPDATE ".PREFIX_TABLE."answer SET  `status` = -1  WHERE question_id = ".$faqs_id);
				$msg = 'Bạn đã xóa câu hỏi thành công!';
			}
			else
				$msg = 'System error ...';
	    }
	    else
		{
			if(!$account_id > 0) {
				$err = '';
				$denied = true;
				$script = 'Bm.show_access_notify()';
			}
			else {
				$err = 'System error ...';
			}
	    }
	    
		if($err != '' ||  $denied)
			echo json_encode(array('msg'=>$err, 'intReturn' => -1, 'script' => $script));	    
		else{
			echo json_encode(array('intReturn' => 1, 'msg'=>$msg));
			$this->removeCached($mobile_id);
		}
	}
	function delAnswer($answer_id, $account_id, $faqs_id, $is_like)
	{
        $err = '';
		$script = '';
		$denied = false;
	    if($answer_id > 0 && $account_id > 0)
		{
			if(DB::query("UPDATE ".PREFIX_TABLE."answer SET  `status` = -1  WHERE id = ".$answer_id))
			{
				DB::query("UPDATE ".PREFIX_TABLE."question SET  `answer_count` = `answer_count`-1  WHERE id = ".$faqs_id);
				if($is_like)
					DB::query("UPDATE ".PREFIX_TABLE."question SET  `is_close` = 0 WHERE id = ".$faqs_id);
				$msg = 'Bạn đã xóa câu trả lời thành công!';
			}
			else
				$msg = 'System error ...';
	    }
	    else
		{
			if(!$account_id > 0) {
				$err = '';
				$denied = true;
				$script = 'Bm.show_access_notify()';
			}
			else {
				$err = 'System error ...';
			}
	    }
	    
		if($err != '' ||  $denied)
			echo json_encode(array('msg'=>$err, 'intReturn' => -1, 'script' => $script));	    
		else
			echo json_encode(array('intReturn' => 1, 'msg'=>$msg));
	}
	
	function getListFAQ(){
		$mobile_id = (int)Url::get('id');
		$cache_key = 'BmFaqsListTab_mobile_id_'.$mobile_id.'_list_ajax';
		$user = User::$data;
		$post_permission = isset($user) && $user['id'];
		$items 	= array();
		
		if(MEMCACHE_ON){
			$items = eb_memcache::do_get($cache_key);
		}
		
		if(empty($items) || MEMCACHE_ON == false){
			EnBacLib::getAllMobile();
			$sql = "SELECT id, time, up_time, mobile_id, mobile_name, title, brief, time, user_id, user_name, read_count, answer_count, like_count, is_close
					FROM bm_question
					WHERE mobile_id = $mobile_id";
			$re 	= DB::query($sql);
			while ($item = mysql_fetch_assoc($re)){											
				$items[] = $this->processItem($item, $mobile_id);
			}
			if(MEMCACHE_ON){
				eb_memcache::do_put($cache_key, $items, 86400);
			}
		}		
		echo json_encode(array("data" => $items, "err" => 0, "post_permission" => $post_permission));
		exit();
	}
	
	function processItem($item, $mobile_id){
		$item['href']   = Url::build('product', array('cmd'=>'faqs_view', 'id'=>$mobile_id, 'faqs_id'=>$item['id'], 'ebname'=>EnBacLib::safe_title($item['mobile_name'])));
		$item['profile_url'] = Url::build('profile', array('user_name'=>$item['user_name']));
		$item['avatar'] = insert_getAvatar(array('avatar'=>'','id'=>$item['user_id'],'type'=>32,'sql'=>true));
		$item['time']   = insert_duration_time(array('time' => $item['up_time']));
		
		return $item;
	}
	
	function removeCached($id){
		if(MEMCACHE_ON){
			$cache_key = 'BmFaqsListTab_mobile_id_'.$id.'_list_ajax';
			eb_memcache::do_remove($cache_key);
		}
	}
}
?>