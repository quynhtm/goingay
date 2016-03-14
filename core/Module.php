<?php
class Module{
	var 	$data = false,$forms 	 = array(), $page = '';
	static 	$block_id = 0, $name = '';
	
	function Module($row){
		$this->data = $row;
		$this->page = Url::get('page', '');
		
		Module::$block_id 	= $this->data['id'];
		Module::$name 		= $this->data['module']['name'];
	}
	
	function add_form($sub_form){$this->forms[]=$sub_form;}
	
	function submit(){
		Module::$block_id 	= $this->data['id'];
		Module::$name 		= $this->data['module']['name'];
		
		$this->on_submit();
		
		Module::$block_id 	= 0;
		Module::$name 		= '';
	}
	
	function on_submit(){if($this->forms){foreach ($this->forms as $sub_form){$sub_form->on_submit();}}}
	
	function draw(){if($this->forms){foreach($this->forms as $sub_form){$sub_form->on_draw();}}}
	
	
	function on_draw(){
		
		if(is_debug()) {
			$start_block = microtime(true);
		}
		
		Module::$block_id 	= $this->data['id'];
		Module::$name 		= $this->data['module']['name'];
		
		$this->draw();
		
		if(is_debug()) {
			$time_block = round(microtime(true) - $start_block, 10);
			CGlobal::$aryModuleDebug[] = "<tr>
										    <td>".Module::$name."</td>
										    <td style='". ( ($time_block > 0.005) ? "color: red;":"" ). ( ($time_block > 0.01) ? "font-weight: bold":"" ) ."' >$time_block</td>
										 </tr>";
		}
		Module::$block_id 	= 0;
		Module::$name 		= '';
	}
}
?>