<?php	
class BMLib {
	/*Clone function delete_comment used in */
	static function so_delete_comment ($comment_id,$type,$tbl_comment){
		if(!User::is_login() || !User::is_admin()){
			return false;
		}
		switch ($type){
			case 'shop':
				$table_item = 'so_products_classified';
				$table_comment = 'so_'.$tbl_comment.'_comment';
				break;
			case 'news':
				$table_item = 'news';
				$table_comment = 'so_'.$tbl_comment.'_comment';
				$col_total = 'comment_count';
				break;
			case 'product':
				$table_item = 'so_products_product';
				$table_comment = 'so_'.$tbl_comment.'_comment';
				$col_total = 'total_new_comment';
				break;
			case 'all':
				$table_comment = 'so_'.$tbl_comment.'_comment';
				break;
			default:
				return false;
			}

		$select_comment = DB::select($table_comment," id = $comment_id AND status = 1");
	
		$value = " status = -1 ";
	
		if($select_comment){
			$cond = " id = $comment_id ";
		}
		else{
			return false;
		}
	
		if($type != 'user'){
			// neu co sub comment
			if($select_comment['have_child']){
				$cond .= " OR parent_id = $comment_id ";
			}
			// neu la sub comment
			if($select_comment['parent_id']){
				$value .= ", have_child = have_child - 1 ";
	
			}
		}
	
	
		//update xoa vao bang comment
		$query_update = DB::query("UPDATE $table_comment SET $value WHERE $cond");
	
	
		if($query_update)
		{
	
	
			//neu la luu but trong profile
			if($type == 'user'){
				$receiver_user_id = $select_comment['receiver_user_id'];
				DB::query("UPDATE account SET total_comment_user = total_comment_user - 1 WHERE id = $receiver_user_id");
				User::getUser($receiver_user_id,1);
			}
			else{
				// neu la sub comment
				$id_sub = array();
				if($select_comment['parent_id']){
					$re = DB::query("SELECT id FROM $table_comment WHERE parent_id = {$select_comment['parent_id']} AND status = 1 ORDER BY id DESC LIMIT 0,2");
					
					if($re){
						while($row = mysql_fetch_assoc($re)){
							if($row){
								$id_sub[] = $row['id'];
							}
						}
					}
					if($id_sub){
						$ids = implode(',',$id_sub);
						DB::query("UPDATE $table_comment SET display = 1 WHERE id IN ($ids)");
					}
				}
	
				//update tong so
				//$table_item = "bm_".$type;
				//$col_total = ($type == 'item') ? 'reply_count' : 'comment_count' ;
				
				
				if($type!='all'){
					$total_feedback = DB::count($table_comment,"item_id={$select_comment['item_id']} AND status = 1");
				
					DB::update_id($table_item,array($col_total=>$total_feedback),$select_comment['item_id']);
					if(MEMCACHE_ON){
						$product_infor = eb_memcache::do_put($table_item.":".$select_comment['item_id'],array($col_total=>$total_feedback));
					}
				}
				
			}
			return true;
		}
	}
	
	
	/*
	* function replacr @
	* replace @nick
	* tanv add 07/10
	*/
	static function addLinkFromContent($content) {
            $content .= ' ';

           $strEscape = '.,;: ';
            $aryMatches = array();
            //preg_match_all("|@[0-9_a-zA-Z-]+[\s\v$strEscape]|", $content, $aryMatches, PREG_PATTERN_ORDER);
            preg_match_all("|@[0-9_a-zA-Z-]{3,}+[\s\v$strEscape]|", $content, $aryMatches, PREG_PATTERN_ORDER);
            $aryReplace = array();
            $aryRegex = array();
            if(sizeof($aryMatches))
				foreach ($aryMatches[0] as $nick) {
					
						 $real_nick = trim($nick, $strEscape.'@');
					   
						$full_nick = '/@'. $real_nick .' /';
						$aryRegex[] = $full_nick;
						$profileUrl = insert_getProfileLink(array('user_name'=>$real_nick));
						$aryReplace[$full_nick] = '<a title="'.$real_nick.'" class="cyan" href="'.$profileUrl.'">@'.$real_nick.'</a> ';
				}
				
				
					
				usort($aryRegex,array( 'self', 'arr_len_sort' ));
				$text_replace = array();
				foreach ($aryRegex as $value){
						$text_replace[$value] = $aryReplace[$value];
				
			    }
				//print_r ($text_replace);
				//die();
                $content = preg_replace(array_keys($text_replace), $text_replace, $content);
                return $content;
	}
	
	static function arr_len_sort($a,$b){
				return strlen($b)-strlen($a);
	}
}
