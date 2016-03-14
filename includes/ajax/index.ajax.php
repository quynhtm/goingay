<?php
/*
+--------------------------------------------------------------------------
|   Web: http://www.enbac.com 
|   Started date : 30/06/2008
+---------------------------------------------------------------------------
|   > Script written by Nova
+---------------------------------------------------------------------------
*/

if (preg_match ( "/".basename ( __FILE__ )."/", $_SERVER ['PHP_SELF'] )) {
	die ("<h1>Incorrect access</h1>You cannot access this file directly.");
}

class index {
    	function playme(){
    		$code = EnBacLib::getParam('code');
			switch( $code )
			{
				case 'home':
					$this->home();
					break;	
				case 'clear_cache':
					$this->clear_cache();
					break;	
				default:
					$this->home();
					break;
			}

			//$print->html = $skin->index();
			//$print->display();
		}

		function home(){
			global $display;
			die("Nothing to do...");
		}
		
		function clear_cache(){
			$isOK = 0;
			if(isset($_POST['key']) && $_POST['key'] != '') {
				eb_memcache::do_remove($_POST['key']);
				$isOK = 1;
			}
			
			echo json_encode(array('isOK' => $isOK));
		}
}
?>