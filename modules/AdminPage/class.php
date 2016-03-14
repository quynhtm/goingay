<?php 
class AdminPage extends Module{
    var $pages = array();
    var $table_page = TABLE_PAGE;
    var $table_block = TABLE_BLOCK;
	function AdminPage($row){
		Module::Module($row);
		if(User::is_root()){
			$act=Url::get('act');
			switch ($act){
				case 'delete_all_cache':
					EnBac::update_all_page();
					require_once ROOT_PATH.'includes/enbac/dir.php';
					empty_all_dir(PAGE_CACHE_DIR,true);
					Url::redirect_current();
					break;
				case 'refresh':
					$id=(int)Url::get('id',0);
					if($id){
						EnBac::update_page($id);
						
						if(Url::check('href')){
							Url::redirect_url($_REQUEST['href']);
						}
						else{
							Url::redirect_current();
						}
					}
					Url::redirect_current();
					break;
				case 'del_cache_page':
					$id=(int)Url::get('id',0);
					if($id){
						EnBac::update_page($id);
						require_once ROOT_PATH.'includes/enbac/dir.php';
						empty_all_dir(DIR_CACHE.'pages',false);
						empty_all_dir(DIR_CACHE.'modules',false);
						if(Url::check('href')){
							Url::redirect_url('http://'.base64_decode($_REQUEST['href']));
						}
						else{
							Url::redirect_current();
						}
					}
					Url::redirect_current();
					break;
				case 'delete_item':
					$id=(int)Url::get('id',0);
					if($id){
						DB::delete($this->table_block, 'page_id='.$id);
						DB::delete_id($this->table_page, $id);
						require_once ROOT_PATH.'includes/enbac/dir.php';
						empty_all_dir(DIR_CACHE.'pages',true);
						empty_all_dir(DIR_CACHE.'modules',true);
					}
					Url::redirect_current();
					break;
                //delete all
                case 'remove':
                    $selected_ids=Url::get('selected_ids');
                    if($selected_ids){
                        $ids=implode(',',$selected_ids);
                        if($ids){
                            EnBac::update_page($ids);
                            DB::delete($this->table_block, 'page_id IN('.$ids.')');
                            DB::delete($this->table_page, 'id IN('.$ids.')');

                            require_once ROOT_PATH.'includes/enbac/dir.php';
                            empty_all_dir(PAGE_CACHE_DIR,true);
                        }
                    }

                    Url::redirect_current();
					break;
				case 'edit':
				case 'add':
				case 'copy':
					require_once 'forms/edit.php';
					$this->add_form(new EditForm());
					break;
                case 'save':
                    $this->saveItem();
                    break;
				default: 
					require_once 'forms/list.php';
					$this->add_form(new ListForm());
					break;
			}
		}
		else{
            Url::redirect('admin');
		}
	}

    function saveItem(){
        $id = (int)Url::get('id');
        if(Url::get('cmd')=='edit' || Url::get('cmd')=='copy'){
            if($id){
                $this->pages= DB::select($this->table_page,'id='.$id);
            }
            if(!$this->pages)
                Url::redirect_current();
        }
        else{
            $this->pages=array('name' =>'','title'=>'','layout'	 =>'','description' =>'');
        }

        $name			= trim(Url::get('name'));
        $title			= trim(Url::get('title'));
        $layout			= trim(Url::get('layout'));
        $description 	= trim(Url::get('description'));

        $new_row = array('name'	=>$name,'title'=>$title,'layout'=>$layout,'description' =>$description);
        if(Url::get('cmd')=='copy'){
            if($name==$this->pages['name'] || DB::select($this->table_page,'name="'.$name.'"')){
                Url::redirect_current();
            }
            $id = DB::insert($this->table_page, $new_row);
            if($id){
                $re=DB::query('SELECT id, module_id, page_id, region, position FROM '.$this->table_block.' WHERE page_id='.$this->pages['id']);
                if($re){
                    while ($row=mysql_fetch_assoc($re)){
                        unset($row['id']);
                        $row['page_id']=$id;
                        DB::insert($this->table_block,$row);
                    }
                }
            }
        }
        elseif(Url::get('cmd')=='edit'){
            DB::update($this->table_page, $new_row,'id='.$this->pages['id']);
            EnBac::update_page($this->pages['id']);
        }
        else{
            $id = DB::insert($this->table_page, $new_row);
        }
        Url::redirect_current();
    }
}
?>