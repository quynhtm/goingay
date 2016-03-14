<?php
function empty_dir($name)
{
	if($dir = @opendir($name)){
		while($file=readdir($dir)){
			if($file!='..'){
				@unlink($file);
			}
		}
		closedir($dir);
	}
}

function empty_all_dir($name, $remove_sub_dir = false,$remove_self=false){
	if(is_dir($name)){
		if($dir = opendir($name)){
			$dirs = array();
			while($file=readdir($dir)){
				if($file!='..' and $file!='.'){
					if(is_dir($name.'/'.$file)){
						$dirs[]=$file;
					}
					else{
						@unlink($name.'/'.$file);
					}
				}
			}
			closedir($dir);
			foreach($dirs as $dir_){
				if($remove_self || $remove_sub_dir)
					empty_all_dir($name.'/'.$dir_, true,true);
				else 
					empty_all_dir($name.'/'.$dir_, false,false);
			}
			
			if($remove_self){
				@rmdir($name);
			}
		}		
	}
}
/*
function copy_dir($source, $dest)
{
	$dir = opendir($source);
	while($file=readdir($dir))
	{
		if($file != '.' and $file != '..')
		{
			if(is_dir($source.'/'.$file)){
				if(mkdir($dest.'/'.$file)){
					copy_dir($source.'/'.$file,$dest.'/'.$file);
				}
			}
			else
			{
				copy($source.'/'.$file,$dest.'/'.$file);
			}
		}
	}
	closedir($dir);
}
function get_files_in_dir($dir_path,$type='file',$prefix='',$use_icon)
{
	$files = array();
	if(is_dir($dir_path))
	{
		$dir = opendir($dir_path);
		
		while($file = readdir($dir))
		{
			if($file != '.' and $file != '..' and 
				(($type=='file' and is_file($dir_path.'/'.$file))
				or($type=='dir' and is_dir($dir_path.'/'.$file))))
			{
				if($use_icon)
				{
					$files[$dir_path.'/'.$file] = array('name'=>str_replace('_',' ','<font color="red">'.$prefix.'</font>'.$file),'icon'=>(file_exists($dir_path.'/'.$file.'/icon.jpg')?$dir_path.'/'.$file.'/icon.jpg':'packages/cms/templates/content/detail/layouts/default/icon.jpg'));
				}
				else
				{
					$files[$dir_path.'/'.$file] = $prefix.$file;
				}
			}
		}
		closedir($dir);
	}
	return $files;
}
function get_package_template($extra_path, $type='file', $use_icon = false)
{
	require_once 'core/package.php';
	global $packages;
	if($use_icon)
	{
		$layouts = array(''=>array('name'=>'none','icon'=>'packages/cms/templates/content/detail/layouts/default/icon.jpg'));
	}
	else
	{
		$layouts = array(''=>'');
	}
	foreach($packages as $package)
	{
		$layouts += get_files_in_dir($package['path'].$extra_path,$type,$package['name'].'/',$use_icon);
	}
	return $layouts;
}*/
?>