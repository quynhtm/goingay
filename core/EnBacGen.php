<?php
class EnBacGen{
	static $blocks = array();
	
	static function PageGenerate(){
		$code = self::TextGenerate();
		
		if(PAGE_CACHE_ON && $fp = @fopen(EnBac::$page_cache_file, 'w+')){
			fwrite ($fp, $code );fclose($fp);
			chmod(EnBac::$page_cache_file,0777);
			require_once EnBac::$page_cache_file;
		}
		else{ eval('?>'.$code.'<?php ');}
	}
	
	static function TextGenerate(){
		$code='<?php'."\n";
		$code .='EnBac::$page = '.str_replace(array("\n",' '),array('',''),var_export(EnBac::$page,true)).';';
		
		$code.="\n".'$blocks = ';
		$re=DB::query("SELECT id, module_id, region, ajax_load FROM  block WHERE  page_id= ".EnBac::$page['id']." ORDER BY position",__LINE__.__FILE__);
		
		if($re){
			while ($block=mysql_fetch_assoc($re)){
				self::$blocks[$block['id']]=$block;
			}
		}
		
		$mids = "";
		foreach(self::$blocks as $id=>$block){
			$mids.=($mids!=""?",":"").$block['module_id'];
			self::$blocks[$id]['module'] = array();
		}
		
		if($mids!=""){
			$re = DB::query("SELECT id, name FROM module WHERE id IN($mids)");
			if($re){
				$b_modules = array();
				while($b_module = mysql_fetch_assoc($re)){
					$b_modules[$b_module['id']] = $b_module;
				}
				if($b_modules){
					foreach(self::$blocks as $id=>$block){
						if(isset($b_modules[$block['module_id']])){
							self::$blocks[$id]['module'] = $b_modules[$block['module_id']];
						}
					}
				}
			}
		}
		
		$code .= str_replace(array("\n",' '),array('',''),var_export(self::$blocks,true)).';';
		$code .="\n".'foreach($blocks as &$block){';
		$code .="\n".'	if(file_exists(DIR_MODULE.$block[\'module\'][\'name\'].\'/class.php\')){';
		$code .="\n".'		require_once DIR_MODULE.$block[\'module\'][\'name\'].\'/class.php\';';
		$code .="\n".'		if($block[\'ajax_load\'] == 1) {';
		$code .="\n".'			$bl_tmp = array (';
		$code .="\n".'						\'id\' => $block[\'id\'],';
		$code .="\n".'						\'module\' => Array (';
		$code .="\n".'							\'id\' => $block[\'module\'][\'id\'],';
		$code .="\n".'							\'name\' => $block[\'module\'][\'name\']';
		$code .="\n".'							)';
		$code .="\n".'						);';
		$code .="\n".'			$bl_tmp[\'request\'] = $_REQUEST;';
		$code .="\n".'			$ajax_loading_module[$block[\'id\']] = \'[\'.$block[\'id\'].\', "\'.base64_encode(serialize($bl_tmp)).\'"]\';';
		$code .="\n".'			$block[\'object\'] = \'<div id="block_\'.$block[\'id\'].\'"></div>\';';
		$code .="\n".'		}';
		$code .="\n".'		else {';
		
		
		$code .="\n".'			$block[\'object\'] = new $block[\'module\'][\'name\']($block);';
		$code .="\n".'			';
		$code .="\n".'			if(isset($_POST[\'form_block_id\']) && $_POST[\'form_block_id\'] == $block[\'id\']){';
		$code .="\n".'				$block[\'object\']->submit();';
		$code .="\n".'			}';
		$code .="\n".'		}';
		$code .="\n".'	}';
		$code .="\n".'}';
		$code .="\n".'require_once ROOT_PATH."core/PageBegin.php" ?>';

		$text = file_get_contents(EnBac::$page['layout']);
		
		while(($pos=strpos($text,'[[|'))!==false){
			$code .= substr($text, 0,  $pos);
			$text = substr($text, $pos+3,  strlen($text)-$pos-3);
			
			if(preg_match('/([^\|]*)/',$text, $match)){
				if(isset($match[1])){
					$code .= self::RegionGenerate($match[1]);
				}
				if(($pos = strpos($text,'|]]',0))!==false){
					$text = substr($text, $pos+3,  strlen($text)-$pos-3);
				}
			}
			else{
				break;
			}
		}
		$code .= $text;
		
		$code .= "\n".'<?php';
		$code .= "\n".'if(!empty($ajax_loading_module)) {';
		$code .= "\n".' 	echo \'<script type="text/javascript">\';';
		$code .= "\n".'		echo \'var ajax_loading_module = new Array(\'. join(\',\', $ajax_loading_module).\');\';';
		$code .= "\n".'		echo \'Bm.ajax_loading_module(ajax_loading_module);\';';
		$code .= "\n".'		echo \'Bm._store.variable.ajax_loaded_module = new Array();\';';
		$code .= "\n".'		echo \'</script>\';';
		$code .= "\n".'} ';
		$code .= "\n".'?> ';
		
		$code .= "\n\n".'<?php require_once ROOT_PATH.\'core/PageEnd.php\' ?> ';

		return $code;
	}
	
	static function RegionGenerate($region){
		$code = '';
		foreach(self::$blocks as $id=>$block){
			if($block['region'] == $region){
				if($block['ajax_load'] == 1) {
		  			$code .= "\n".'<?php if(isset($blocks['.$id.'][\'object\'])) echo $blocks['.$id.'][\'object\'];?>';
				}
				else {
					$code .= "\n".'<?php if(isset($blocks['.$id.'][\'object\'])) $blocks['.$id.'][\'object\']->on_draw();?>';
				}
			}
		}
		return $code;
	}
}
?>