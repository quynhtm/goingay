<?php
require_once 'core/config.php';//System Config...
require_once 'core/Debug.php'; //System Debug...
require_once 'core/Init.php';  //System Init...
$params = Url::get('params', array());//param
$params = @unserialize(base64_decode($params));
$_REQUEST = (isset($params['request']) ? $params['request'] : array());
$block_id = (isset($params['id']) ? (int)$params['id'] : 0);
$module_id = (isset($params['module']['id']) ? (int)$params['module']['id'] : 0);
$module_name = (isset($params['module']['name']) ? $params['module']['name'] : '');
ob_start();
if((int)$block_id > 0 && $module_id > 0 &&  $module_name != '') {
	if(file_exists(DIR_MODULE . $module_name .'/class.php')){
		require_once DIR_MODULE . $module_name .'/class.php';
		$module = new $module_name($params);
		$module->on_draw();
	}
}
$html = ob_get_clean();
echo json_encode(array('block' => $block_id, 'html' => $html));
exit();