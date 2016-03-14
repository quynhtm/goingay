<?php
class AdminEditPage extends Module{
    var $table_page = TABLE_PAGE;
    var $table_block = TABLE_BLOCK;
	function AdminEditPage($row){
		Module::Module($row);
		
		if(User::is_root()){
			$cmd=Url::get('cmd');
			
			switch ($cmd){
				case'change_layout':
					$id	=(int)Url::get('id',0);
					$new_layout=Url::get('new_layout');
					
					if($id && $new_layout && file_exists(ROOT_PATH.$new_layout)){
						DB::update($this->table_page,array('layout'=>$new_layout),'id='.$id);
					}
					
					EnBac::update_page(Url::get('id'));
					if(Url::check('href') && Url::get('href')){
						Url::redirect_url(Url::get('href'));
					}
					else{
						Url::redirect_current(array('id'=>Url::get('id')));
					}
					break;
				case'delete_block':	
					$id			=(int)Url::get('id',0);
					$block_id	=(int)Url::get('block_id',0);
					if($block_id){
						DB::delete($this->table_block,"id=$block_id");
						EnBac::update_page($id);
					}
					
					if(Url::check('href') && Url::get('href')){
						Url::redirect_url(Url::get('href'));
					}
					else{
						Url::redirect_current(array('id'=>$id));
					}
					break;
				case'set_ajax_load':	
					$id			=(int)Url::get('id',0);
					$block_id	=(int)Url::get('block_id',0);
					if($block_id){
						DB::update($this->table_block, array('ajax_load'=>1), "id=$block_id");
						EnBac::update_page($id);
					}
					
					if(Url::check('href') && Url::get('href')){
						Url::redirect_url(Url::get('href'));
					}
					else{
						Url::redirect_current(array('id'=>$id));
					}
					break;
				case'unset_ajax_load':	
					$id			=(int)Url::get('id',0);
					$block_id	=(int)Url::get('block_id',0);
					if($block_id){
						DB::update($this->table_block, array('ajax_load'=>0), "id=$block_id");
						EnBac::update_page($id);
					}
					if(Url::check('href') && Url::get('href')){
						Url::redirect_url(Url::get('href'));
					}
					else{
						Url::redirect_current(array('id'=>$id));
					}
					break;
				case'move_bottom':	
				case'move_top':	
					$id			=(int)Url::get('id',0);
					$block_id	=(int)Url::get('block_id',0);
					
					if($block_id && $id){
						$page 	= DB::select($this->table_page,'id='.$id);
						$block = DB::select($this->table_block,'id='.$block_id);
						
						if($block && $page){
							$region		=$block['region'];
							
							if($cmd=='move_bottom'){
								$position=DB::fetch('SELECT MAX(position) AS amax FROM '.$this->table_block.' WHERE region="'.$region.'" AND page_id="'.$id.'"','amax',0);
								if($position)
									$position++;
								else $position=1;
							}
							else{
								$position=DB::fetch('SELECT MIN(position) AS amin FROM '.$this->table_block.' WHERE region="'.$region.'" AND page_id="'.$id.'"','amax',0);
								if($position)
									$position--;
								else $position=1;
							}
							DB::update($this->table_block, array('region'=>$region, 'position'=>$position),'id="'.$block_id.'"');
							EnBac::update_page($id);
						}
					}
					
					if(Url::check('href') && Url::get('href')){
						Url::redirect_url(Url::get('href'));
					}
					else{
						Url::redirect_current(array('id'=>$id));
					}
					break;
				case'move':	
					$id			=(int)Url::get('id',0);	
					$block_id	=(int)Url::get('block_id',0);
					$dir=Url::get('move');
					
					if($id && $block_id&&$dir){
						$block=DB::select($this->table_block,$block_id);
				
						if($block){
							if($dir=='up'){
								$move[0]='<';
								$move[1]='DESC';
							}
							else{
								$move[0]='>';
								$move[1]='ASC';
							}
							if(DB::query('SELECT * FROM '.$this->table_block.' WHERE region="'.DB::escape($block['region']).'" AND page_id="'.$block['page_id'].'"
									AND position'.$move[0].$block['position'].' ORDER BY position '.$move[1])){
								if($row=DB::fetch()){
									DB::update($this->table_block,array('position'=>$block['position']),'`id`='.$row['id']);
									DB::update($this->table_block,array('position'=>$row['position']),'`id`='.$block['id']);
								}
							}
							EnBac::update_page($id);
						}
					}
					
					if(Url::check('href') && Url::get('href')){
						Url::redirect_url(Url::get('href'));
					}
					else{
						Url::redirect_current(array('id'=>$id));
					}
					break;
				default:
					$id			=(int)Url::get('id',0);	
					$module_id	=(int)Url::get('module_id',0);	
					$region		=urldecode(Url::get('region'));	
					if(!$id)Url::redirect($this->table_page);
					if($module_id && $region){
						$position=DB::fetch('SELECT MAX(position) AS amax FROM block WHERE region="'.$region.'" AND page_id="'.$id.'"','amax',0);
						if($position)
							$position++;
						if($position<=0) $position=1;
						DB::insert($this->table_block, array('region'=>$region, 'position'=>$position,'page_id'=>$id, 'module_id'=>$module_id));
						EnBac::update_page($id);
						
						if(Url::check('href') && Url::get('href')){
							Url::redirect_url(Url::get('href'));
						}
						else{
							Url::redirect_current(array('id'=>$id));
						}
					}
					else{//Cấu hình page:
						require_once 'forms/page_content.php';
						$this->add_form(new PageContentForm());break;
					}
					break;
			}
		}
		else{
			Url::access_denied();
		}
	}
}			
			
?>