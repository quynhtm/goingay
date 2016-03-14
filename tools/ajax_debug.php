<?php
	require_once '../core/config.php';//System Config...
	require_once '../core/Debug.php'; //System Debug...
	require_once '../core/Init.php';  //System Init...
	
	if(User::is_root()){
		$debug = new Debug();
		if(isset($_REQUEST['req_ajax_debug'])) {
			$req_ajax_debug = $_REQUEST['req_ajax_debug'];
			if($req_ajax_debug == 'start') {//Bật debug ajax
				$debug->start_ajax_debug();
			}
			elseif($req_ajax_debug == 'stop') {//Tắt debug ajax
				$debug->stop_ajax_debug();
			}
			elseif($req_ajax_debug == 'stop') {
				$debug->stop_ajax_debug();
			}
			header('Location:'. WEB_DIR . 'tools/ajax_debug.php');
			die();
		}
		
		
		if($debug->is_ajax_debug()) {
			$aryDebug = $debug->get_ajax_debug();
			if(empty($aryDebug)) {
				echo '<h4>Ajax debug đã bật. <a href="?req_ajax_debug=stop">Tắt Debug Ajax tại đây.</a></h4>';
				echo '<h1>Chưa có dữ liệu</h1>';
			}
			else {
?>
<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/jquery/jquery.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/jquery/jquery.jcache.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>"></script>
<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/jquery/jquery.json-2.2.min.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>"></script>
<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/save/bm.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>"></script>
<?php 
				echo '<h4>Ajax debug đã bật. <a href="?req_ajax_debug=stop">Tắt Debug Ajax tại đây.</a></h4>';
				echo "
				<style type='text/css'>
					#debug_area td {padding: 5px;}
				</style>
				<center style='margin: 20px auto; padding: 10px 30px; background: #fff' id='debug_area'>";
				$aryDebug = array_reverse($aryDebug);
				foreach ($aryDebug as $k => $v) {
					echo print_ary_debug($v, $k);
				}
					
				echo "</center>";
			}
		}
		else {
			echo '<h4>Bạn chưa bật debug ajax - <a href="?req_ajax_debug=start">Bật debug tại đây.</a></h4>';
		}
	}
	else {
		echo 'Bạn ko có đủ quyền.';
	}
	
	function print_ary_debug($debug, $stt) {
		$txt ="
			<div style='border: #ccc 3px solid; padding: 10px; margin: 10px' id='".$debug['key']."'>
				<div style='text-align: left; background: #E8E8E8; padding: 2px 10px; position: relative'>Call: ".$debug['key']." - lúc: ". date('H:i:s', $debug['time']) ."
					<br/><a href='javascript:void(0)' onclick='jQuery(this).parent().next().toggle()'>Show/Hide</a>
					<div style='position: absolute; top:0; right:0; background:red; color: yellow; padding: 5px;'>$stt</div>
				</div>
				<div style='display:none'>";
				
		if(!empty($debug['params'])){
			$txt.= 	"<div style='margin-top:20px; padding: 2px; border: #FFD6DC 1px solid; font-size:12px;'>
						<div style='background-color: #E8E8E8;font-size:22px;color:#000; margin-bottom: 10px;'><b>Params</b></div>";
			$txt.= 	'<div style="padding: 5px; text-align:left"><pre>'. htmlspecialchars(print_r($debug['params'], true)) .'</pre></div>';
			$txt.= 	"</div>";
		}
		
		if(!empty($debug['$_'])){
			$txt.= 	"<div style='margin-top:20px; padding: 2px; border: #FFD6DC 1px solid; font-size:12px;'>
						<div style='background-color: #E8E8E8;font-size:22px;color:#000; margin-bottom: 10px;'><b>\$_</b></div>";
			$txt.= 	'<div style="padding: 5px; text-align:left"><pre>'. htmlspecialchars(print_r($debug['$_'], true)) .'</pre></div>';
			$txt.= 	"</div>";
		}
		
		if($debug['query_debug']){
			$txt.= 	"<div style='margin-top:20px; padding: 2px; border: #FFD6DC 1px solid; font-size:12px;'>
						<table width='100%' border='0' cellpadding='6' cellspacing='1' bgcolor='#ababab' align='center'>
							<tr>
								<td colspan='8' style='background-color: #FFD6DC;font-size:22px;color:#000'><b>MySql Query</b></td>
							</tr>
							". $debug['query_debug'] ."
						</table>
					</div>";
		}

		if(!empty($debug['aryMemcacheDebug'])){
			$txt.= 	"<div style='margin-top:20px; padding: 2px; border: green 1px solid; font-size:12px;'>
						<div>
							<div style='background-color:green;font-size:22px;color:#fff; margin-bottom: 10px;'><b>MemCache</b></div>";
			foreach ($debug['aryMemcacheDebug'] as $module_name => $list) {
				$txt.= 	"<table width='100%' border='0' cellpadding='6' cellspacing='1' bgcolor='#ababab'  align='center' style='margin-bottom: 10px;'>
								<tr>
									<td style='background-color:#cccccc;font-size:13px;'><b>". $module_name ."</b></td>
								</tr>";
				foreach ($list as $v) {
					$txt.= 	$v;
				}
				
				$txt.= 	"</table>";
			}							
			$txt.= 					"
						</div> 
					</div>";
		}

		if(!empty($debug['list_file_loaded'])) {
			$txt.= 	"<div style='margin-top:20px; padding: 2px; border: #ffd850 1px solid; font-size:12px;'>
						<div style='background-color: #ffd850;font-size:22px;color:#f20000; margin-bottom: 10px;'><b>AUTOLOAD</b></div>
								<table width='100%' border='1' cellpadding='6' cellspacing='1' style='border-collapse: collapse; border-color: #cccccc' align='left'>
									<tr bgcolor='#CCCCCC'>
										<td style='padding-left: 50px;' bgcolor='#ffffb0'>
											<ul style='list-style-type: decimal;'><li> ".  join('</li><li>', AutoLoader::$list_file_loaded) ."</li></ul>
										</td>
									</tr>";
			$txt.= 	"			</table> 
						<div style='clear: both'></div>
					</div>";
		}

		
		$txt.= "
				<div style='text-align: left; color:  #333'>END: ".$debug['key']."</div>
				</div>
			</div>";
		
		return $txt;
	}
?>