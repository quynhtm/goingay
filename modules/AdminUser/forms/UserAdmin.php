<?php
class ListUserAdminForm extends Form
{
	function ListUserAdminForm(){
		Form::Form('ListUserAdminForm');	
		CGlobal::$website_title="Quản trị thành viên";	
		$this->link_css('style/manage_content.css');
		$this->link_css('style/ui.datepicker.css');		
		$this->link_js('javascripts/jquery/ui.datepicker.js');	
		
		if(Url::get('cmd')=='del_user'){//Xoá 1 thành viên
			$id=Url::get('id');
			if($id && $id!=User::id() && $id!=4){
				$this->del_user($id);
			}
			Url::redirect_url(Url::build_all(array('chk_id','del_all','cmd','id','lock_die_all','hd_ac')));
		}
	}
	
	function on_submit(){
		
		$ids = (isset($_POST['chk_id']))?$_POST['chk_id']:array(); 							
		
		if(count($ids)>0){		
			if(Url::get('hd_ac')=='block_all'){//Khoá nhiều thành viên
				$user_ids='';
				
				for($i=0;$i<count($ids);$i++){
					if($ids[$i] && $ids[$i]!=User::id() && $ids[$i]!=4){
						$user_ids.=($user_ids?',':'').$ids[$i];
					}
				}	
				
				if($user_ids){
					$time_expire = TIME_NOW + BAN_NICK_DATE*24*3600;
					
					DB::update('account',array('block_time'=>$time_expire),'id IN('.$user_ids.')');			
					DB::query("UPDATE up_item_schedule SET status=0 WHERE user_id IN (".$user_ids.")  AND status = 1");					
					
					$re	= DB::query('SELECT id,user_name FROM account WHERE id IN('.$user_ids.')');
					
					if($re){
						while ($user=mysql_fetch_assoc($re)){
							DB::insert('acc_lock',array('time'=>TIME_NOW,'time_expire'=>$time_expire,'user_id'=>$user['id'],'user_name'=>$user['user_name'],'type'=>0,'note'=>'admin khóa','admin_id'=>User::id(),'admin_name'=>User::user_name()));
							User::getUser($user['id'],0,1);
						}
					}
				}
			}
			
			if(Url::get('hd_ac')=='lock_die_all'){//Khoá vĩnh viễn + khoá cookies
				$user_ids='';
				for($i=0;$i<count($ids);$i++){
					if($ids[$i] && $ids[$i]!=User::id() && $ids[$i]!=4){
						$user_ids.=($user_ids?',':'').$ids[$i];
					}
				}	
				
				if($user_ids){
					$this->lock_user($user_ids);
					
					DB::update('account',array('block_time'=>-1),'id IN('.$user_ids.')');
					
					$re=DB::query('SELECT id, user_name FROM account WHERE id IN('.$user_ids.')');
					if($re){
						while ($user=mysql_fetch_assoc($re)){
							DB::insert('acc_lock',array('time'=>TIME_NOW,'user_id'=>$user['id'],'user_name'=>$user['user_name'],'type'=>3,'admin_id'=>User::id(),'admin_name'=>User::user_name()));
							User::getUser($user['id'],0,1);
						}
					}
				}
			}
			elseif(Url::get('hd_ac')=='lock_die_all_not_cookies'){//Khoá vĩnh viễn nhiều thành viên không khóa cookies
				$user_ids='';
				for($i=0;$i<count($ids);$i++){
					if($ids[$i] && $ids[$i]!=User::id() && $ids[$i]!=4){
						$user_ids.=($user_ids?',':'').$ids[$i];
					}
				}	
				if($user_ids){
					$this->lock_user($user_ids);
					DB::update('account',array('block_time'=>-1),'id IN('.$user_ids.')');	
					
					$re=DB::query('SELECT id, user_name FROM account WHERE id IN('.$user_ids.')');
					if($re){
						while ($user=mysql_fetch_assoc($re)){
							DB::insert('acc_lock',array('time'=>TIME_NOW,'user_id'=>$user['id'],'user_name'=>$user['user_name'],'type'=>1,'admin_id'=>User::id(),'admin_name'=>User::user_name()));
							User::getUser($user['id'],0,1);
						}
					}				
				}
			}
			elseif(Url::get('hd_ac')=='invalid_all'){//Kiểm duyệt nhiều thành viên 
				$user_ids='';
				for($i=0;$i<count($ids);$i++){
					if($ids[$i] && $ids[$i]!=User::id() && $ids[$i]!=4){
						$user_ids.=($user_ids?',':'').$ids[$i];
					}
				}	
				if($user_ids){
					$time_expire = TIME_NOW + 7*24*3600;
					
					DB::update('account',array('invalid_time'=>$time_expire),'id IN('.$user_ids.')');	
					$re=DB::query('SELECT id,user_name FROM account WHERE id IN('.$user_ids.')');
					
					if($re){
						while ($user=mysql_fetch_assoc($re)){
							DB::insert('acc_lock',array('time'=>TIME_NOW,'time_expire'=>$time_expire,'user_id'=>$user['id'],'user_name'=>$user['user_name'],'type'=>2,'note'=>'Kiểm duyệt nhiều thành viên','admin_id'=>User::id(),'admin_name'=>User::user_name()));
							User::getUser($user['id'],0,1);
						}
					}
					
					$sql_item 	= 	'SELECT id FROM item where user_id IN ('.$user_ids.')  AND status = 1';
					$re_item	=	DB::query($sql_item);
					
					if($re_item){	
						while ($item=mysql_fetch_assoc($re_item)){
							$sql_insert = "INSERT INTO bad_content (`type`,`id_item`,`user_id`,`user_name`,`reason`,`time_post`) VALUES (2,{$item['id']},".User::id().",'".User::user_name()."','Kiểm duyệt do thành viên bị kiểm duyệt',".time().")";
							DB::query($sql_insert);	
						}
						
						if(MEMCACHE_ON){
							$sql 	= "SELECT * FROM item WHERE user_id IN($user_ids)  AND status = 1";
							$re 	= DB::query($sql);
							
							while($item_memcache = mysql_fetch_assoc($re)){
								$item_memcache['status'] 			= 2;
								$item_memcache['modify_time'] 		= TIME_NOW;
								$item_memcache['modify_user_name'] 	= User::user_name();
								eb_memcache::do_put("item:".$item_memcache['id'],$item_memcache);
							}
						}
						DB::update('item',array('status'=>"2",'modify_time'=>time(),'modify_user_name'=>User::user_name()),'user_id IN('.$user_ids.')  AND status = 1');
					}									
				}
			}
			elseif(Url::get('hd_ac')=='del_all'){//Xoá nhiều thành viên
				$user_ids='';
				for($i=0;$i<count($ids);$i++){
					if($ids[$i] && $ids[$i]!=User::id() && $ids[$i]!=4){
						$user_ids.=($user_ids?',':'').$ids[$i];
					}
				}
				//Xoá users:
				if($user_ids){
					$this->del_user($user_ids);		
				}
			}
			elseif(Url::get('hd_ac')=='unlock_die_all'){// Mở khoá nhiều thành viên
				$user_ids='';
				for($i=0;$i<count($ids);$i++){
					if($ids[$i] && $ids[$i]!=User::id() && $ids[$i]!=4){
						$user_ids.=($user_ids?',':'').$ids[$i];
					}
				}
				
				if($user_ids){	
					DB::update('account',array('block_time'=>0),'id IN('.$user_ids.')');
					User::getUser($id,1,true);
				}
			}				
			Url::redirect_url(Url::build_all(array('chk_id','del_all','cmd','id','lock_die_all','hd_ac')));
		}	
	}	
	
	function draw(){
		global $display;
		$this->beginForm(false,"POST",false,Url::build_current());		
		
		//search theo ngay thang nam
		$display->add('created_time_from',Url::get('created_time_from'));
		$display->add('created_time_to',Url::get('created_time_to'));
		
		$created_time_from=0;
		$created_time_to=0;
		if(Url::get('created_time_from')){
			$date_arr = explode('-',Url::get('created_time_from'));
			if(isset($date_arr[0]) && isset($date_arr[1]) && isset($date_arr[2]))
			$created_time_from = mktime(0,0,0,(int)$date_arr[1],(int)$date_arr[0],(int)$date_arr[2]);
		}
		if(Url::get('created_time_to')){
			$date_arr = explode('-',Url::get('created_time_to'));
			
			if(isset($date_arr[0]) && isset($date_arr[1]) && isset($date_arr[2]))
			$created_time_to = mktime(23,59,59,(int)$date_arr[1],(int)$date_arr[0],(int)$date_arr[2]);
		}		
		$search_value = 1;
		if($created_time_from){																	
			$search_value .= ' AND create_time >= '.$created_time_from;
		}
		if($created_time_to){																	
			$search_value .= ' AND create_time <= '.$created_time_to;
		}
		
		$group_id = (int)Url::get('group_id', 0);
		if($group_id > 0){
			$search_value .= ' AND gids='. $group_id;		
		}
		$display->add('group_id', $group_id);
		
		if(Url::get('active')==1){																	
			$search_value .= ' AND (is_active=1)';		
			$display->add('active_checked','checked');
		}		
		else{			
			$display->add('active_checked','');
		}
		
		if(Url::get('tracking')==1){																	
			$search_value .= ' AND (tracking=1)';		
			$display->add('tracking_checked','checked');
		}		
		else{			
			$display->add('tracking_checked','');
		}
		
		if(Url::get('invalid')==1){	
			$search_value .= ' AND (invalid_time > 0 OR invalid_time = -1)';
			$order_by=' ORDER BY invalid_time DESC ';
			$display->add('invalid_checked','checked');
		}else{			
			//$search_value .= ' AND invalid_time = 0';
			$order_by=' ORDER BY id DESC ';
			$display->add('invalid_checked','');
		}
		
		if(Url::get('block')==1){																	
			$search_value .= ' AND (block_time >= '.TIME_NOW.' OR block_time = -1)';
			$order_by=' ORDER BY block_time DESC ';
			$display->add('block_checked','checked');
		}		
		else{
			//$search_value .= ' AND block_time!=-1 AND block_time <= '.TIME_NOW;
			
			$display->add('block_checked','');
		}						
		
		
		$od_by	=Url::get('order_by');
		$od_dir	=Url::get('order_dir','DESC');
		if($od_by=='name'){
			$order_by = ' ORDER BY user_name '.$od_dir;
		}
		elseif($od_by=='id')
		{
			$order_by = ' ORDER BY id '.$od_dir;
		}
		elseif($od_by=='up')
		{
			$order_by = ' ORDER BY up_item '.$od_dir;
		}
		elseif($od_by=='time'){
			$order_by = ' ORDER BY create_time '.$od_dir;
		}
		
		if(Url::get('ava')){																	
			$search_value .= ' AND avatar_url != ""';
			$display->add('ava_checked','checked');
		}
		else{
			$display->add('ava_checked','');
		}
		
		// search ô textbox	 ID
		$id_search=(int)Url::get('id_search',0);		
		if($id_search){
			$search_value .= ' AND id='.$id_search;
		}
		if($id_search==0){
			$id_search='';
		}		
		$display->add('id_search',$id_search);				
		
		// search ô textbox	tài khoản
		if(Url::get('text_value')!=''){		
			$text_value=Url::get('text_value');
			$display->add('text_value',$text_value);
			
			$str_search = str_replace( "'" , '"', $text_value );
			$str_search = str_replace( "&#39;" , '"', $str_search );
			$str_search = str_replace( "&quot;" , '"', $str_search );
								
			$search_value .= " AND (user_name LIKE '%".$str_search."%'  OR email LIKE '%".$str_search."%')";
		}
		
		// search so dien thoai
		if(Url::get('id_phone')!=''){		
			$id_phone=Url::get('id_phone');											
			$search_value .= " AND (home_phone LIKE '%".$id_phone."%'  OR mobile_phone LIKE '%".$id_phone."%')";
		}
		
		$display->add('id_phone',Url::get('id_phone'));

		$item_per_page = Url::get('item_per_page',50);
		$sql_count='SELECT COUNT(id) AS total_item FROM account WHERE '.$search_value;	
		$total=DB::fetch($sql_count,'total_item',0);		
		$items=array();
		$str_id = '';
		$uids   = '';
		if($total){
			$limit='';
			
			$paging = EBPagging::pagingSE($limit,$total,$item_per_page,10,'page_no',true,'Thành viên','Trang');			
			$sql = 'SELECT id, user_name, full_name, email, website, yahoo_id, home_phone, mobile_phone, skype_id, province_id, create_time,  block_time, avatar_url, is_active,invalid_time, gids, reg_ip, last_ip, up_item, last_login FROM account WHERE '.$search_value.' '.$order_by.$limit;
			
			$result = DB::query($sql);			
									
			if($result){
				while ($row=mysql_fetch_assoc($result)){

					if($row['block_time']>TIME_NOW || $row['block_time']==-1 || $row['invalid_time']>0 || $row['invalid_time']==-1 ){
						$str_id .= ($str_id==''?'':',').$row['id'];
					}
					$row['create_time'] = date('d/m/y H:i',$row['create_time']);
					
					if($row['last_login']){
						$row['last_login'] = date('d/m/y H:i',$row['last_login']);
					}
					else{
						$row['last_login'] = false;
					}
					if($row['block_time']>TIME_NOW || $row['block_time']==-1){
						
						if($row['block_time']!=-1){
							$row['status'] = "<font color=red><b>".date('H:i d/m/y',$row['block_time']).'</b></font>';
						}
						else{
							$row['status'] = '<font color=red><b>Khóa vĩnh viễn</b></font>';
						}
						$row['bgcolor'] = 'bgcolor="#CCCCCC"';
						$row['is_block'] = true;
						$display->add('type_reason','Khóa');
					}else{
						$row['status'] = "";
						$row['bgcolor'] = '';
						$row['is_block'] = false;
					}
					if($row['invalid_time']>0 || $row['invalid_time']==-1 ){
						
						$row['status'] = ($row['invalid_time'] == -1) ? "<font color=red><b>kiểm duyệt vĩnh viễn</b></font>" : "<font color=red><b>".date('H:i d/m/y',$row['invalid_time']).'</b></font>';
						
						
						$row['is_invalid'] = true;
						$display->add('type_reason','Kiểm duyệt');
					}else{
						//$row['status'] = "";
						//$row['bgcolor'] = '';
						$row['is_invalid'] = false;
					}
					
					if($row['province_id'] && isset(CGlobal::$provinces[$row['province_id']]))
						$row['city']=CGlobal::$provinces[$row['province_id']]['name'];	
					else
						$row['city']='';
							
					$row['gender']='';	
					
					if($row['website'] && strpos($row['website'],'http://')===false){
						$row['website']='http://'.$row['website'];	
					}
						
					if($row['avatar_url']){
						//$row['avatar_preview']=EnBacLib::getImageThumb($row['avatar_url'],60,0,1);	
						$row['avatar_src'] = $row['avatar_url'];	
						$row['del_avatar']=Url::build_all(array('chk_id','del_all','cmd','id','lock_die_all','hd_ac'),'cmd=del_avatar&id='.$row['id']);	
					}
					else{
						$row['avatar_preview']='';
						
						$row['avatar_src']	  ='';
						$row['del_avatar']	  ='';
					}
					$row['unban_nick'] = Url::build_all(array('chk_id','del_all','cmd','id','lock_die_all','hd_ac'),'cmd=unban_nick&id='.$row['id']);;
					
					
					$row['del_link']   = Url::build_all(array('chk_id','del_all','cmd','id','lock_die_all','hd_ac'),'cmd=del_user&id='.$row['id']);;
					$row['detail']     = Url::build_current(array('cmd'=>'detail','id'=>$row['id']));
					$row['openids'] = array();
					
					$row['del_cache']	= Url::build_all(array('cmd','id'),'cmd=del_cache&id='.$row['id']);
					
					$uids.=($uids?',':'').$row['id'];
					$row['detail_acc_link'] = Url::build('account', array('user_name'=> $row['user_name']));
					$items[$row['id']]=$row;
				}				
			}
		}
		else{
			$paging = '';
		}

		/*if($uids){
			$re = DB::query("SELECT openid_url,user_id FROM openid WHERE user_id IN($uids)");
			if($re){
				while ($oid = mysql_fetch_assoc($re)) {
					$items[$oid['user_id']]['openids'][] = $oid['openid_url'];
				}
			}
		}*/
		
		//lay ly do khoa nicks hoac kiem duyet nick
		$arr_reason = array();
		if($str_id){
			$where = '';
			if(Url::get('block')==1){
				$where = ' AND type IN (0,1) ';
			}else if(Url::get('invalid')==1){
				$where = ' AND type = 2 ';
			}
			$sql = 'SELECT user_id, time, note, type,admin_id, admin_name FROM acc_lock WHERE user_id IN('.$str_id.') '.$where.' ORDER BY id ASC';
			$result = DB::query($sql);
			while ($row=mysql_fetch_assoc($result)){
				$arr_reason[$row['user_id']]=$row;
			}
		}
				
		foreach($items as $value){
			if(isset($arr_reason[$value['id']]['user_id']) && $value['id']==$arr_reason[$value['id']]['user_id']){
				$items[$value['id']]['lock_reason'] = EnBacLib::filter_title($arr_reason[$value['id']]['note']);
				$items[$value['id']]['lock_type'] = $arr_reason[$value['id']]['type'];
				$items[$value['id']]['time_lock'] = date("d/m/y H:i",$arr_reason[$value['id']]['time']);
				$items[$value['id']]['create_time_lock'] = $arr_reason[$value['id']]['time'];
				$items[$value['id']]['admin_name'] = $arr_reason[$value['id']]['admin_name'];
			}
			else{
				$items[$value['id']]['lock_reason'] = '';
				$items[$value['id']]['lock_type'] = '';
				$items[$value['id']]['time_lock'] = '';
				$items[$value['id']]['create_time_lock'] = 0;
				$items[$value['id']]['admin_name'] = '';
			}
		}
		//end lay ly do khoa nick						
					
		if($od_dir=='ASC'){
			$od_dir='DESC'; 			
		}
		else{
			$od_dir='ASC';
		}		
		
		$href_id	=Url::build_all(array('chk_id','del_all','cmd','id','lock_die_all','hd_ac'),'order_by=id&order_dir='.$od_dir);
		$href_name	=Url::build_all(array('chk_id','del_all','cmd','id','lock_die_all','hd_ac'),'order_by=name&order_dir='.$od_dir);
		$href_up	=Url::build_all(array('chk_id','del_all','cmd','id','lock_die_all','hd_ac'),'order_by=up&order_dir='.$od_dir);
		$href_time	=Url::build_all(array('chk_id','del_all','cmd','id','lock_die_all','hd_ac'),'order_by=time&order_dir='.$od_dir);
		
		$img_id='<img src="style/images/admin/downarrow.png" alt="">';//default
		$img_name='';
		$img_up='';
		$img_time='';

		if($od_by=='id'){
			$img_id= '<img src="style/images/admin/'.(($od_dir!='DESC')?'down':'up').'arrow.png" alt="">';
		}
		
		if($od_by=='name'){ 
			$img_name= '<img src="style/images/admin/'.(($od_dir!='DESC')?'down':'up').'arrow.png" alt="">';	
			$img_id='';
		}
		
		if($od_by=='up'){ 
			$img_up= '<img src="style/images/admin/'.(($od_dir!='DESC')?'down':'up').'arrow.png" alt="">';	
			$img_id='';
		}
		
		if($od_by=='time'){
			$img_time= '<img src="style/images/admin/'.(($od_dir!='DESC')?'down':'up').'arrow.png" alt="">';
			$img_id='';
		}
				
		// neu show cac thanh vien bi khoa, se sap xep theo thoi diem khoa hien tai giam dan
		if(Url::get('block')==1){				
			usort($items, array("ListUserAdminForm","cmp"));
		}
		
		$display->add('groupPermisstion', CGlobal::$group);
		$display->add('img_id',$img_id);		
		$display->add('img_name',$img_name);		
		$display->add('img_up',$img_up);		
		$display->add('img_time',$img_time);
				
		$display->add('href_id',$href_id);	
		$display->add('href_name',$href_name);	
		$display->add('href_up',$href_up);	
		$display->add('href_time',$href_time);	
		
		$display->add('total_account',$total);
		$display->add('limit_date',BAN_NICK_DATE);	
		$display->add('aryUserItems',$items);
		$display->add('paging',$paging);		
		$display->output('list');		
		$this->endForm();
	}
	
	static function del_user($user_ids){	
		
		
	
		$u_arr=array();
		if(preg_match('#,#', $user_ids)){
			$where=" IN (".$user_ids.")";
			$u_arr=explode(',',$user_ids);
		}
		else{
			$where=" = ".$user_ids;
			$u_arr[]=$user_ids;
		}

		if(DB::query('DELETE FROM account WHERE id '.$where)) {
			DB::delete('acc_lock','user_id IN('.$user_ids.')');

		}
		
		if($u_arr){
			foreach ($u_arr as $uid){
				User::getUser($uid,1,true);
			}
		}
	}
	
	static function lock_user($user_ids){		
		$u_arr=array();
		if(eregi(',',$user_ids)){
			$where=" IN (".$user_ids.")";
			$not_where=" NOT IN (".$user_ids.")";
			$u_arr=explode(',',$user_ids);
		}
		else{
			$where=" = ".$user_ids;
			$not_where=" != ".$user_ids;
			$u_arr[]=$user_ids;
		}
		
		//Kick Out from session:
		DB::query('DELETE FROM '._SESS_TABLE.' WHERE user_id '.$where);

		DB::query('DELETE FROM friends_list WHERE user_id_friend '.$where);
		DB::query('DELETE FROM bad_content WHERE user_id '.$where);

		if($u_arr){
			foreach ($u_arr as $uid){
				User::getUser($uid,1,true);
			}
		}
	}
	
	static function cmp($a, $b){
	   return ($a['create_time_lock']>$b['create_time_lock'])?-1:1;
	}	
}
?>
