<?php
class ListModuleAdminForm extends Form{
	function ListModuleAdminForm(){
		Form::Form('ListModuleAdminForm');
		$this->link_css('style/manage_content.css');
	}
	
	function draw(){
		global $display;
		$this->beginForm();

		$name		=trim(Url::get('name'));
		$order_by	=Url::get('order_by','id');
		$order_dir	=Url::get('order_dir','DESC');
		
		$cond = ' id > 0';
		
		if($name!='')
		$cond.=' AND name LIKE "%'.$name.'%"';
		
		$item_per_page = CGlobal::$number_per_page;
		$total_row = DB::fetch('SELECT count(*) AS total_row FROM '.TABLE_MODULE.' WHERE '.$cond.' LIMIT 0,1','total_row',0);
		$items = array();
		$paging = '';
		if($total_row){
			$limit='';
			$paging=EBPagging::pagingSE($limit,$total_row,$item_per_page,10,'page_no',true);
			$sql='SELECT  id ,name FROM  '.TABLE_MODULE.' WHERE '.$cond.' ORDER BY '.$order_by.' '.$order_dir.' '.$limit;
			$re=DB::query($sql);
			if($re){
				while ($row=mysql_fetch_assoc($re)){
					if(Url::check('page_id'))
						$row['onclick']=' onclick="location=\''.Url::build('edit_page',array('module_id'=>$row['id'],'id'=>(int)Url::get('page_id',0),'region','after','replace','href')).'\';"  style="cursor:pointer;" title="Click vào đây để cắm Module vào Page"';
					else
						$row['onclick']='';
					$re2=DB::query('SELECT page.id,page.name FROM '.TABLE_BLOCK.' INNER JOIN '.TABLE_PAGE.' ON page.id=block.page_id WHERE module_id="'.$row['id'].'"');
					if($re2){
						while ($page=mysql_fetch_assoc($re2)){
							$row['pages'][$page['id']]=$page;
						}
					}
					else {
						$row['pages']=array();
					}
					$items[$row['id']] = $row;
				}
			}
		}
		
		if($order_dir=='ASC')$order_dir='DESC'; else $order_dir='ASC';
		
		$href_id	=Url::build_current(array('order_by'=>'id','order_dir'=>$order_dir));
		$href_name	=Url::build_current(array('order_by'=>'name','order_dir'=>$order_dir));
		
		$img_id='';
		$img_name='';
		if($order_by=='id') 
		$img_id= '<img src="style/images/admin/'.(($order_dir!='DESC')?'down':'up').'arrow.png" alt="">';
		
		if($order_by=='name') 
		$img_name= '<img src="style/images/admin/'.(($order_dir!='DESC')?'down':'up').'arrow.png" alt="">';
		
		$display->add('img_id',$img_id);		
		$display->add('img_name',$img_name);		
		$display->add('href_id',$href_id);		
		$display->add('href_name',$href_name);	
			
		$display->add('name',$name);		
		$display->add('paging',$paging);		
		$display->add('aryModules',$items);
        $display->add('page', Url::get('page'));
		$display->add('hover',EnBacLib::mouse_hover('#E2F1DF',true));	
		
		$display->output('list');
		$this->endForm();	
	}
}
?>