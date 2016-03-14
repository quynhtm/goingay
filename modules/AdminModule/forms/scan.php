<?php
class ScanModuleForm extends Form{
	var $update=false,$list_scan='';
	function ScanModuleForm(){
		Form::Form('ScanModuleForm');
		CGlobal::$website_title="Auto Scan Modules";
		
		if(isset($_POST['update_scan']) && (int)$_POST['update_scan']==1){
			$this->update=(int)$_POST['update_scan'];
		}
		else{
			$this->on_submit();
		}
	}
	
	function on_submit(){
		$all_modules=array();
		$re=DB::query('SELECT id, name FROM '.TABLE_MODULE.' ORDER BY name');
		if($re){
			while ($module=mysql_fetch_assoc($re)) {
				$all_modules[strtolower($module['name'])]=$module;
			}
		}
		
		$module_dirs=scandir(DIR_MODULE);
		unset($module_dirs[0]);
		unset($module_dirs[1]);
		
		if($module_dirs){
			$i=1;
			foreach ($module_dirs as $module_dir){
				if(is_dir(DIR_MODULE.$module_dir) && !isset($all_modules[strtolower($module_dir)])){
					$arr=array('name'=>$module_dir);
					
					if($this->update){
						$id=DB::insert('module',$arr);
						
						if($id){
							$this->list_scan.='<br />'.$i++.') <font color="blue">Đã thêm module: '.$module_dir.'</font>';
							$all_modules[strtolower($module_dir)]=array('id'=>$id,'name'=>$module_dir);
						}
					}
					else{
						$this->list_scan.='<br />'.$i++.')<font color="blue">Thêm module: '.$module_dir.'</font>';
					}
				}
			}
		}
		
		if($all_modules){
			$this->list_scan.=$this->list_scan?'<br />':'';
		
			$i=1;
			foreach ($all_modules as $module){
				if(!is_dir(DIR_MODULE.$module['name'])){
					if($this->update){
						DB::delete(TABLE_BLOCK, 'module_id='.$module['id']);
						DB::delete(TABLE_MODULE, 'id='.$module['id']);
	
						$this->list_scan.='<br />'.$i++.')<font color="red">Đã xoá module: '.$module['name'].'</font>';
					}
					else{
						$this->list_scan.='<br />'.$i++.')<font color="red">Xoá module: '.$module['name'].'</font>';
					}
				}
			}
		}
		
		$this->list_scan=$this->list_scan?'<center><b>CÁC MODULES THAY ĐỔI</b></center>'.$this->list_scan.'<br />':'';
		
		if($this->update){
			$this->list_scan.='<br /><center><font color="green"><b>ĐÃ CẬP NHẬT XONG</b>
				<br /><br /><a href="'.Url::build_current(array('cmd'=>'scan')).'"><b>Scan tiếp</b></a></font></center><br />';
		}
		else{
			if($this->list_scan)
				$this->list_scan.='<br /><br /><center><input type="submit" value="Cập nhật"></center>';
			else
				$this->list_scan.='<center><b>KHÔNG CÓ THÔNG TIN THAY ĐỔI NÀO</b></center>';
		}
	}
	
	function draw(){
		global $display;
		$this->beginForm();
		$display->add('list_scan',$this->list_scan);	
		$display->output('scan');
		$this->endForm();
	}
}
?>