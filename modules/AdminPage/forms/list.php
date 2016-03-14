<?php
class ListForm extends Form
{
	function ListForm(){
		Form::Form('ListForm');
		CGlobal::$website_title="Quản trị Pages";
	}
	/*
	function on_submit(){
		if(Url::get('cmd')=='delete_items'){
			$selected_ids=Url::get('selected_ids');
			
			if($selected_ids){
				$ids=implode(',',$selected_ids);
				if($ids){
					EnBac::update_page($ids);
					DB::delete('block', 'page_id IN('.$ids.')'); 
					DB::delete('page', 'id IN('.$ids.')');
						
					require_once ROOT_PATH.'includes/enbac/dir.php';
					empty_all_dir(PAGE_CACHE_DIR,true);
				}
			}
			
			Url::redirect_current();
		}
	}*/
	
	function draw(){
		global $display;
		$this->beginForm(false,'post',false,Url::build_current());
		$name		= trim(Url::get('name'));
		$title		= trim(Url::get('title'));
		$id		= (int)Url::get('id',0);
		$order_by	= Url::get('order_by','id');
		$order_dir	= Url::get('order_dir','DESC');
		
		$cond = ' 1 ';
		
		if($name !='')
		$cond.=' AND name LIKE "%'.$name.'%"';

        if($title !='')
		$cond.=' AND title LIKE "%'.$title.'%"';

        if($id !=0)
		$cond.=' AND id='.$id;

		$item_per_page = 50;
		$total_row = DB::fetch('SELECT count(*) AS total_row FROM `page` WHERE '.$cond.' LIMIT 0,1','total_row',0);
		$items = array();
		$paging = '';
		if($total_row){
			$limit='';
			$paging=EBPagging::pagingSE($limit,$total_row,$item_per_page,10,'page_no',true);
			$sql='SELECT * FROM  `page` WHERE '.$cond.' ORDER BY '.$order_by.' '.$order_dir.' '.$limit;
			$re=DB::query($sql);
			if($re){
				while ($row=mysql_fetch_assoc($re)){
					$row['href'] = Url::build('edit_page',array('id'=>$row['id']));;
					$items[$row['id']] = $row;
				}
			}
		}
		
		if($order_dir=='ASC')$order_dir='DESC'; else $order_dir='ASC';
		
		$href_id	=Url::build_current(array('order_by'=>'id','order_dir'=>$order_dir));
		$href_name	=Url::build_current(array('order_by'=>'name','order_dir'=>$order_dir));
		$href_des	=Url::build_current(array('order_by'=>'description','order_dir'=>$order_dir));
		$href_title	=Url::build_current(array('order_by'=>'title','order_dir'=>$order_dir));
		
		$img_id='';
		$img_name='';
		$img_title='';
		$img_des='';
		if($order_by=='id') 
		$img_id= '<img src="style/images/admin/'.(($order_dir!='DESC')?'down':'up').'arrow.png" alt="">';
		
		if($order_by=='name') 
		$img_name= '<img src="style/images/admin/'.(($order_dir!='DESC')?'down':'up').'arrow.png" alt="">';
		
		if($order_by=='description') 
		$img_des= '<img src="style/images/admin/'.(($order_dir!='DESC')?'down':'up').'arrow.png" alt="">';
		
		if($order_by=='title') 
		$img_title= '<img src="style/images/admin/'.(($order_dir!='DESC')?'down':'up').'arrow.png" alt="">';
		
		$display->add('img_id',$img_id);		
		$display->add('img_name',$img_name);		
		$display->add('img_title',$img_title);		
		$display->add('img_des',$img_des);		
		
		$display->add('href_id',$href_id);		
		$display->add('href_title',$href_title);		
		$display->add('href_name',$href_name);	
		$display->add('href_des',$href_des);	
			
		$display->add('name',$name);		
		$display->add('title',$title);
		$display->add('id',$id);

		$display->add('paging',$paging);
		$display->add('aryPage',$items);	
		$display->add('hover',EnBacLib::mouse_hover('#E2F1DF',true));
        $display->add('page', Url::get('page'));
        $display->add('total_row', $total_row);
		
		$display->output('list');
		$this->endForm();
	}
}
?>