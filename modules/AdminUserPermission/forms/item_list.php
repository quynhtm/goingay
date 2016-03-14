<?php
class ItemListForm extends Form{
	function ItemListForm(){
		Form::Form('ItemListForm');
		CGlobal::$website_title="Danh sách sản phẩm của thành viên";	
		$this->link_css('style/manage_content.css');
		$this->link_css('style/ui.datepicker.css');		
		$this->link_js('javascripts/jquery/ui.datepicker.js');	
	}
	function on_submit(){
		$ids = (isset($_POST['chk_id']))?$_POST['chk_id']:array(); 							
		if(count($ids)>0){						
			for($i=0;$i<count($ids);$i++){
				Item::delete_item($ids[$i]);
			}				
			Url::redirect_url(Url::build_all(array('chk_id','del_all','id','lock_die_all','hd_ac')));
		}	
	}	
	
	function draw(){
		$this->beginForm();
		global $display;
		$user_id = intval(Url::get('user_id'));
		$user_info = DB::select('account','id="'.$user_id.'"');
		$display->add('created_time_from',Url::get('created_time_from'));
		$display->add('created_time_to',Url::get('created_time_to'));		
		//search theo ngay thang nam
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
		$search_value=' 1 ';
		if($created_time_from){																	
			$search_value .= ' AND created_time >= '.$created_time_from;
		}
		if($created_time_to){																	
			$search_value .= ' AND created_time <= '.$created_time_to;
		}
			
		$item_per_page = 50;
		$sql_count='SELECT COUNT(id) AS total_item FROM item WHERE user_id = "'.$user_id.'" AND '.$search_value;		
		$total = DB::fetch($sql_count,'total_item',0);		
		$items = array();		
		if($total){
			$limit='';
			
			$paging = EBPagging::pagingSE($limit,$total,$item_per_page,10,'page_no',true,'Giao dịch','Trang');			
			$sql = 'SELECT id,name,created_time,up_time,up_count,user_id,user_name,status FROM item WHERE user_id = "'.$user_id.'" AND '.$search_value.' ORDER BY up_time  DESC '.$limit;
			
			$result = DB::query($sql);
			if($result){
				while ($row=mysql_fetch_assoc($result)){						
					$row['ebname'] =  EnBacLib::safe_title($row['name']);
					$row['up_time'] =  date('d/m/y H:i',$row['up_time']);
					$row['created_time'] =  date('d/m/y H:i',$row['created_time']);
					$row['del_link'] = Url::build_all(array('chk_id','del_all','cmd','id','lock_die_all','hd_ac'),'cmd=delete&id='.$row['id'].'&user_id='.$row['user_id']);
					$items[$row['id']]=$row;
				}				
			}
		}else 
		{
			$paging = '';
		}
		
		$display->add('user_info',$user_info);
		$display->add('total_item',$total);
		$display->add('items',$items);
		$display->add('paging',$paging);		
		$display->output('item_list');	
		
		$this->endForm();
		
		
	}
}
?>
