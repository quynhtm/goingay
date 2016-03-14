<?php
class PageContentForm extends Form{
	private $pages=array(),$layout_text='',$layout=null,$undefined_regions=false,$regions=array();
	function PageContentForm(){
		Form::Form('ConfigPageAdminForm');
		CGlobal::$website_title="Cấu hình, cắm module cho Page";
		$id = (int)Url::get('id');
		if($id){
			$this->pages=DB::select('page','id='.$id);
		}
		
		if(!$this->pages)
		Url::redirect_current();
	}
	
	function draw(){
		global $display;
		
		$re = DB::query('SELECT block.id, block.module_id, block.page_id, block.region, block.position, block.ajax_load, module.name FROM `block`  INNER JOIN module ON module.id=module_id WHERE page_id='.$_REQUEST['id'].' ORDER BY position');
		$this->all_blocks = array();
		if($re){
			while ($block=mysql_fetch_assoc($re)){
				$this->all_blocks[$block['id']]=$block;
			}
		}
		if(file_exists($this->pages['layout']))
		$this->layout_text = file_get_contents($this->pages['layout']);
		$this->get_regions();
		
		$text=$this->layout_text.($this->undefined_regions?'<p><h1>Các module ngoài Layout</h1>[[|undefined_regions|]]</p>':'');
		
		$result = '';
		while(($pos=strpos($text,'[[|'))!==false){
			if($pos2 = strpos($text,'|',$pos+3)){
				$var = substr($text, $pos+3,  $pos2-$pos-3);
				
				if(isset($this->regions[$var]))
				$item=$this->regions[$var];
				
				if($item){
					$result .= substr($text, 0,  $pos).$item;
					$text = substr($text, $pos2+3,  strlen($text)-$pos2-3);
				}
				else{
					$result .= substr($text, 0,  $pos+3);
					$text = substr($text, $pos+3,  strlen($text)-$pos-3);
				}
			}
			else{
				$result .= substr($text, 0,  $pos+3);
				$text = substr($text, $pos+3,  strlen($text)-$pos-3);
			}
		}
		$regions = $result.$text;		
		
		$display->add('name',$this->pages['name']);
		$display->add('id',$this->pages['id']);
		$display->add('regions',$regions);
		$display->add('option_layout',EnBacLib::getOption($this->get_all_layouts(),Url::get('status',$this->pages['layout'])));
		$display->add('page_content',$this->pages);
		$display->output('page_content');
	}
	
	function get_regions(){
		$this->regions = array();
		
		if(preg_match_all('/\[\[\|([^\|]+)\|\]\]/i', $this->layout_text, $region_matchs,PREG_SET_ORDER)){		
			$region_s='';
			foreach($region_matchs as $region){
				$region_s.=($region_s?',':'').'"'.$region[1].'"';
				$this->regions[$region[1]]='';
			}
			
			$modules=array();
			if($region_s){
				$re=DB::query('SELECT block.id,  block.module_id, block.page_id, block.region, block.position, block.ajax_load, module.name FROM `block` INNER JOIN module ON module.id=module_id WHERE  page_id='.$this->pages['id'].' AND region IN('.$region_s.') ORDER BY position');
				
				if($re){
					while ($row=mysql_fetch_assoc($re)){
						$modules[$row['region']][$row['id']]=$row;
						unset($this->all_blocks[$row['id']]);
					}
				}
			}
			
			foreach ($this->regions as $region=>$val){
				if(!isset($modules[$region]))
				$modules[$region]=array();
				
				$this->regions[$region] = $this->draw_list($region, $modules[$region]);
			}
			unset($modules);
		}
		$this->undefined_regions = $this->all_blocks!=array();
		
		$this->regions['undefined_regions'] = $this->draw_list('undefined_regions', $this->all_blocks);
	}
	
	function draw_list($region, $modules){
		$i = 0;
		$last = false;
		
		if($modules){
			foreach ($modules as $key=>$item){
				if($i){
					if($i>1){
						$last['move_up'] = '<a href="'.Url::build_current(array('cmd'=>'move','id'=>$this->pages['id'],'block_id'=>$last['id'],'move'=>'up')).'"><img src="style/images/admin/up_arrow_.gif" alt="Move up"></a>';
						$last['move_top'] = '<a href="'.Url::build('edit_page',array('id'=>$this->pages['id'],'block_id'=>$last['id'],'cmd'=>'move_top')).'">MoveTop</a>';
				
					}
					$last['move_down'] = '<a href="'.Url::build('edit_page',array('cmd'=>'move','id'=>$this->pages['id'],'block_id'=>$last['id'],'move'=>'down')).'"><img src="style/images/admin/down_arrow_.gif" alt="Move down"></a>';
					$last['move_bottom'] = '<a href="'.Url::build('edit_page',array('id'=>$this->pages['id'],'block_id'=>$last['id'],'cmd'=>'move_bottom')).'">MoveBottom</a>';
				}
				$i++;
				
				$last = &$modules[$key];
				$last['move_up']='';
				$last['move_down']='';
			}
			
			if($i>1){
				$modules[$key]['move_up']='<a href="'.Url::build('edit_page',array('cmd'=>'move','id'=>$this->pages['id'],'block_id'=>$item['id'],'move'=>'up')).'"><img src="style/images/admin/up_arrow_.gif" alt="Move up"></a>';
				$modules[$key]['move_top'] = '<a href="'.Url::build('edit_page',array('id'=>$this->pages['id'],'block_id'=>$item['id'],'cmd'=>'move_top')).'">MoveTop</a>';
			}
		}
		
		global $display;
		$display->add('hover',EnBacLib::mouse_hover('#CCCCCC',true));
		$display->add('id',$this->pages['id']);
		$display->add('name',$region);
		$display->add('items',$modules);
		return $display->output('list_block',true);
	}
	
	function get_all_layouts(){
		//Code mới: TuấnNK ( 20080606 15h36
		$layouts = array('default'=>'-- Chọn layout --');
		$dir = opendir(ROOT_PATH.'layouts');
		while($file = readdir($dir)){
			if($file != '.' and $file != '..' and is_file('layouts/'.$file)){
				$layouts['layouts/'.$file] = basename($file,EnBacLib::getExtension($file));
			}
		}
		closedir($dir);
		
		asort($layouts, SORT_STRING);
		return $layouts;
	}
}
?>