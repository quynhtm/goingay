<?php
define('AUTOLOAD_CACHE_FILE', DIR_CACHE . '_autoload.php');
function __autoload($className) {
	if (class_exists($className, false) || interface_exists($className, false)) {
		return;
	}

	if (!is_file(AUTOLOAD_CACHE_FILE)) {
		AutoLoader::readDir();
	}

	require (AUTOLOAD_CACHE_FILE);
	
	if (isset($autoload) && is_array($autoload) && file_exists($autoload[$className])) {
		require_once($autoload[$className]);
		array_push(AutoLoader::$list_file_loaded, $autoload[$className]);
	}
	else {
		echo 'Not found class {'.$className.'}'; 
		/*echo '<pre>'; print_r($autoload); echo '</pre>';
		die(); */
		echo '<pre style="text-align: left">'; print_r(debug_backtrace()); echo '</pre>';
		exit;
	}
}

class AutoLoader {	
	static $list_file_loaded = array();

	/**
	 * read dir
	 *
	 */
	static public function readDir($flag = 0) {
		$listFile = array();
        self::scanDir($listFile, ROOT_PATH .'core/');
        self::scanDir($listFile, ROOT_PATH .'models/');
        self::writeFile($listFile);
	}

	/**
	 * scan directory, get list file in directory
	 *
	 * @param array $listFile
	 * @param string $rootDir
	 * @param string $dir
	 */
	static public function scanDir(& $listFile, $rootDir, $dir = '', $flag = 0) {
		$aryNotRequire = array(".", "..", ".svn", "_svn","");
		$hd = @opendir($rootDir . $dir);
		while (false !== ($entry = @readdir($hd))) {
			if (!in_array($entry, $aryNotRequire)) {

				if (is_file($rootDir . $dir . $entry) && in_array(substr($entry, -4), array('.php', 'php3', 'php4', 'php5'))) {
					$fileName = $rootDir. $dir.$entry;
					$tmp = explode('.', $entry);
					$class = substr($entry, 0, strlen($entry) - (strlen($tmp[count($tmp) - 1]) + 1));
					$listFile[$class] = $fileName;
				}

				if (is_dir($rootDir . $dir.$entry)) {
					self::scanDir($listFile, $rootDir, $dir.$entry.'/');
				}
			}
		}
		closedir($hd);
	}

	static public function writeFile(& $listFile) {
		$cacheFile = AUTOLOAD_CACHE_FILE;
		ob_start();
		var_export($listFile);
		$cacheContents = ob_get_clean();
		try {
			$handle = @fopen($cacheFile, "w");
			if ($handle) {
				fwrite($handle, "<?php\n\n");
				fwrite($handle, "\$autoload = ");
				fwrite($handle, $cacheContents);
				fwrite($handle, ";\n\n?>");
				fclose($handle);
			}
		} catch(Exception $e) {
			show($e->getMessage());
			exit;
		}
	}
}