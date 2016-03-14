<?php
/*
+--------------------------------------------------------------------------
|   Web: http://www.boxmobi.com 
|   Started date : 08/08/2009
+---------------------------------------------------------------------------
|   > Script written by PhongCT
+---------------------------------------------------------------------------
*/

if (preg_match ( "/".basename ( __FILE__ )."/", $_SERVER ['PHP_SELF'] )) {
	die ("<h1>Incorrect access</h1>You cannot access this file directly.");
}

class ajax_feed_comment {
	
	static $errorList = array();
	
	function playme() {
		$code = Url::get ( 'code' );
		switch ($code) {			
			case 'send_new_comment' :
				if(!User::is_login()){
					echo json_encode(array('script' => 'Bm.show_access_notify();'));
				}
				else {
					$content = Url::get ('content');
					$comment_id = Url::get ('comment_id');
					self::insert_new_comment($comment_id, $content);	
				}
				break;
			default :
				$this->home ();
				break;
		}
		System::halt();
	}
	
	function home() {
            global $display;
            die ( "Nothing to do..." );
	}
	
	function insert_new_comment($comment_id, $content) {
		$err = '';
		if($comment_id)
		list($account_id, $act, $time) = explode("_", $comment_id);
		$currentTime = time();
		$aryData = array();
		
		if($account_id && $act && $time)
		{
			if(EnBacLib::checkBadWord($content)) {
				$err = 'Nội dung comment có chứa từ khóa bị kiểm duyệt. Hãy nhập lại';
			}
			else {
				$user_receiver = User::getUser($account_id);
				$tableName = BMFeed::getTblComment($time);
				if(!$tableName) $err = 'System Error';
				else {				
					$arySQL = array(
									 '`key`' => $comment_id,
									 '`mobile_id`' => 0,
									 '`act`' => $act,
									 '`act_data`' => $content,
									 '`act_time`' => $currentTime,
									 '`sender_email`' => '',
									 '`sender_user_id`' => User::id(),
									 '`sender_user_name`' => User::user_name(),
									 '`receiver_user_id`' => $account_id,
									 '`receiver_user_name`' => $user_receiver['user_name'],
									 '`replied_user_id`' => 0,
									 '`replied_user_name`' => '',
									 '`parent_id`' => 0,
									 '`have_child`' => 0,
									 );
					$sql = "INSERT INTO `{$tableName}`
						(". join(', ', array_keys($arySQL)) .")
						VALUES
						('". join("','", $arySQL) ."')";
					if(DB::query($sql)) {
						$sql = " SELECT distinct sender_user_name, sender_user_id  FROM `{$tableName}` WHERE `key` = '$comment_id' AND sender_user_id <> ". User::id();
						//echo $sql;
						$aryUserName = DB::fetch_array($sql);
						
						if(is_array($aryUserName) && count($aryUserName) > 0) {
							foreach ($aryUserName as $v) {
								$aryDataAction = array(
										'sender_user_id'=>	User::id(),
										'sender_user_name'	=>	User::user_name(),
										'receiver_user_id'=>	$v['sender_user_id'],
										'receiver_user_name'	=>	$v['sender_user_name'],										
										'link'		=>  Url::build('profile', array('user_name'=>$user_receiver['user_name'])).'/detail/'.$comment_id.'.html',
										'data'		=>  $content
									  );
						
								BMFeed::doActionNotify(BMFeed::$aryNotifyDefined['COMMENT_BLAST'], $aryDataAction, $currentTime);
							}
						}
						
						$aryData = array(
										 'cur_avatar_url_small'	=>	ImageUrl::getUserAvatar(32,true,true,'', User::id(),true),
										 'cur_user_name'		=>	User::user_name(),
										 'time'					=>	$currentTime,
										 'content'					=>	nl2br(BMLib::addLinkFromContent(EnBacLib::parseEmoticon($content))),										 
										 'link_profile'			=>	insert_getProfileLink(array('user_name'=>User::user_name()))
										 );
						
						
						
						$aryFeedAcc = eb_memcache::do_get(BMFeed::MEMCACHE_FEED.$account_id);
						
						if(is_array($aryFeedAcc))
						foreach($aryFeedAcc as $k => $v) {
							if($v['acc_id'] == $account_id && $v['act'] == $act && $v['time'] == $time) {
								if(!isset($aryFeedAcc[$k]['comment'])) $aryFeedAcc[$k]['comment'] = array();
								array_push($aryFeedAcc[$k]['comment'], $aryData);
								eb_memcache::do_put(BMFeed::MEMCACHE_FEED.$account_id, $aryFeedAcc, 4 * 3600); // life 4 hour
								break;
							}
						}
					}
					else $err = 'System Error';
				}
			}
			
		}
		else $err = 'System Error';
		
		if($err != '') {
			echo json_encode(array('err'=>$err));
		}
		else {		
			echo json_encode(array('data' => $aryData));
		}
	}
	
	function setError($key, $value) {
		self::$errorList[$key] = $value;
	}
	
} //class
?>