<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 08/2016
* @Version	 : 1.0
*/
if(!class_exists('ThumbImg') ){

	class ThumbImg{
		private $__name = 'Thumbs img';

		public static function makeDir($folder = '', $id = 0, $path = ''){
			$folders = explode('/', ($path));
			$tmppath =  Config::get('config.DIR_ROOT').'/uploads/thumbs/'.$folder.'/'.$id.'/';

			if(!file_exists($tmppath)){
				mkdir($tmppath, 0777, true);
			};

			for($i = 0; $i < count($folders) - 1; $i++) {
				if(!file_exists($tmppath . $folders[$i]) && ! mkdir($tmppath . $folders [$i], 0777)){
					return false;
				}
				$tmppath = $tmppath . $folders [$i] . '/';
			}
			return true;
		}

		public static function thumbBaseNormal($folder='', $id=0, $path='', $width=100, $height=100, $alt='', $isThumb=true, $returnPath=false, $watermark=true){
				
			if(!preg_match("/.jpg|.jpeg|.JPEG|.JPG|.png|.gif/",strtolower($path))) return ' ';
				
			$url_img = '';

			if($isThumb){

				$imagSource = Config::get('config.DIR_ROOT').'uploads/' .$folder. '/'. $id. '/' .$path;
				$paths =  $width."x".$height.'/'.$path;
				$thumbPath = Config::get('config.DIR_ROOT').'uploads/thumbs/'.$folder.'/'.$id.'/'. $paths;
				$url_img = Config::get('config.BASE_URL').'uploads/thumbs/'.$folder.'/'.$id.'/'. $paths;
				
				if(file_exists($imagSource)){
					if(!file_exists($thumbPath)){
						$objThumb = new PHPThumb\GD($imagSource);
						$objThumb->resize($width, $height);
						if(!file_exists($thumbPath)){
							if(!self::makeDir($folder, $id, $paths)){
								return '';
							}
							self::saveCustom($imagSource);
						}
						$objThumb->show(true, $thumbPath, $watermark);
					}
				}else{
					$url_img = '';
				}
			}

			if($returnPath){
				return $url_img;
			}else{
				return '<img src="'.$url_img.'" alt="'.$alt.'"/>';
			}
		}

		public static function saveCustom($fileName){
			@chmod($fileName, 0777);
			return true;
		}
	}
}
