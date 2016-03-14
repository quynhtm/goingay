<?php
class EditForm extends Form{
	private $pages=array();
	function EditForm(){
		Form::Form('EditForm');
		if(Url::get('act')=='copy')
			CGlobal::$website_title="Copy Page";
		else
			CGlobal::$website_title="Sửa Page";
		if(Url::get('act')=='edit' || Url::get('act')=='copy'){
			$id = (int)Url::get('id');
			if($id){
				$this->pages=DB::select('page','id='.$id);
			}
			
			if(!$this->pages)
			Url::redirect_current();
		}
		else{
			$this->pages=array('name' =>'','title'=>'','layout'	 =>'','description' =>'');
		}
	}
	
	function on_submit(){

	}	
	
	function draw(){	
		global $display;
		$this->beginForm();

		if(Url::get('act')=='edit')
			$display->add('mode',"Sửa");
		elseif(Url::get('act')=='copy')
			$display->add('mode',"Copy");
		else
			$display->add('mode',"Thêm");
			
		$display->add('msg',$this->showFormErrorMessages(1));
		
		$display->add('name',Url::get('name',$this->pages['name']));
		$display->add('title',Url::get('title',$this->pages['title']));
		$display->add('description',Url::get('description',$this->pages['description']));

        $display->add('page', Url::get('page'));
        $id = (int) Url::get('id', 0);
        $display->add('id', $id);

		$display->add('option_layout',EnBacLib::getOption($this->get_all_layouts(),Url::get('status',$this->pages['layout'])));
		$display->output('edit');
		$this->endForm();
	}
	
	function get_all_layouts(){
		//Code mới: TuấnNK ( 20080606 15h36
		$layouts = array(''=>'-- Chọn layout --');
		$dir = opendir(ROOT_PATH.'layouts');
		while($file = readdir($dir)){
			if($file != '.' and $file != '..' and is_file('layouts/'.$file)){
				$layouts['layouts/'.$file] = basename($file,EnBacLib::getExtension($file));
			}
		}
		/***********sua*********/
		ksort($layouts);
		/***********sua*********/
		
		closedir($dir);
		return $layouts;
	}
}
?>