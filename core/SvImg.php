<?php
require_once('img/config.inc.php');
require_once('img/image.inc.php');
class SvImg {
		const FOLDER_DEFAULT 	= 'images/img_other';
		const FOLDER_PRODUCT 	= 'images/product';
		const FOLDER_BRAND 	= 'images/brand';
		const FOLDER_HOME_FEATURE 	= 'images/homefeature';
		const FOLDER_CATEGORY 	= 'images/category';
		const FOLDER_CATEGORY_NEWS 	= 'images/categorynews';
		const FOLDER_NEWS 		= 'images/news';
		const FOLDER_AVATAR 	= 'images/avatar';
		const FOLDER_AVATAR_SHOP 	= 'images/shop';

		/**
		 *  Get information folder
		 * 
		 * @param int $id
		 * @param string $folder
		 * 
		 * @author MinhNV
		 * Date 2011/07/29
		 */
		static function getFolderByID($id = 0, $folder = self::FOLDER_DEFAULT) {			
			return  $folder . '/' . $id . '/';
		}
		
		/**
		 *  Get folder by id 
		 * 
		 * @param int $id
		 * @param String $folder
		 * 
		 * @author MinhNV
		 * Date 2011/08/21
		 */
		static  function  getFoderNoGenById($id = 0, $folder = self::FOLDER_DEFAULT) {
			return $folder . '/' .  $id . '/';
		}
		
		
		static function getOldDirectory($id, $timestamp, $folder = self::FOLDER_DEFAULT) {
			$temp = $folder . '/' .  date("Y/m/d", $timestamp) . '/' . $id . '/';
			$directory  = ($id > 0) ?  $temp : '';
			$dir = ROOT . $directory;
			return $dir;
		}
		static function getNewDirectory($id, $folder = self::FOLDER_DEFAULT) {
			$directory  = ($id > 0) ? self::getFolderByID($id, $folder) : '';
			$dir = ROOT . $directory;
			//make_dir($dir);
			return $dir;
		}
		
		/**
		  *  Get images nogen
		  *  
		  * @param String $fname
		  * @param int $id
		  * @param String $folder
		  * @param int $check
		  * 
		  * @author MinhNV
		  * Date 2011/09/12
		  */
		 static function getImageNoGen($fname = '', $id = 0, $folder = self::FOLDER_DEFAULT, $check = OPT_UPLOAD_IMAGE) {
		  		if($fname != '') {
		  			$directory  = ($id > 0) ? self::getFoderNoGenById($id, $folder) : '';
					$paths = '';
		  			switch ($check) {
						case OPT_GET_IMAGE:
							$dir = WEB_ROOT . $directory;
							break;
						case OPT_DELETE_IMAGE :
							$dir = ROOT . $directory;
							break;
						default: //0
							$dir = IMAGE_URL . $directory;
							make_dir($dir);
							break;		
					}
					$paths = $dir . '_' . $fname;
					return $paths;
		  		}
		  		return false;
		  }
		  
		  /**
		   *  Upload images nogen
		   * 
		   * @param String $file_src
		   * @param String $file_name
		   * @param String $old_file
		   * @param array $aryError
		   * @param int $id
		   * @param String $folder
		   * 
		   * @author MinhNV
		   * Date 2011/09/12
		   */
		  static  function  uploadImagesNoGen($file_src = '',  $file_name = '' , $old_file = '', &$aryError, $id = 0, $folder = self::FOLDER_DEFAULT) {
		  		if($file_name != ''){
			  		$file_name = remove_sign_file($file_name);
				  	$image_old = self::getImageNoGen($old_file, $id, $folder);
			  		$image_orginal = self::getImageNoGen($file_name, $id, $folder);		  		
					$ret = copyOrginalImage($file_src, $image_orginal);
					if(!$ret) {
						$aryError[] = "Upload ảnh thương hiệu lỗi";
						return false;
					}
					if($image_old != '') {
						@unlink($image_old);
					}
					return  $file_name;
		  		}
		  }
		
		/**
		 *  Get all images 
		 * 
		 * @param String $fname
		 * @param array $product_image_sizes
		 * @param int $id
		 * 
		 * @author MinhNV
		 * Date 2011/07/29
		 */
		static  function  getAllImages($fname = '', $image_sizes = null, $id = 0, $folder = self::FOLDER_DEFAULT, $check = OPT_UPLOAD_IMAGE){
			if($fname != '' && $image_sizes != null){
				$directory  = ($id > 0) ? self::getFolderByID($id, $folder) : '';
				$paths = array();
				$dir = '';
				foreach($image_sizes as $k => $v){
					switch ($check) {
						case OPT_GET_IMAGE:
							$dir = WEB_ROOT . $directory;	
							break;
						case OPT_DELETE_IMAGE :
							$dir = IMAGE_URL . $directory;
							break;
						default: //0
							$dir = IMAGE_URL . $directory;
							make_dir($dir);
							break;		
					}
					$paths[$k] = $dir . $k . '_' . $fname;
				}
				return $paths;
			}
			return false;
	  }

	  /**
		 *  Get all images 
		 * 
		 * @param String $fname
		 * @param array $product_image_sizes
		 * @param int $id
		 * @param int $timestamp
		 * 
		 * @author MinhNV
		 * Date 2011/07/29
	    */
		static  function  getImageBySize($fname = '', $size = 0, $id = 0, $folder = self::FOLDER_DEFAULT, $check = OPT_UPLOAD_IMAGE){
			if($fname != '' && $size  > 0 ){
				$directory  = ($id > 0) ? self::getFolderByID($id, $folder) : '';
				$paths = '';
				switch ($check) {
					case OPT_GET_IMAGE:
						$dir = WEB_ROOT . $directory;	
						break;
					case OPT_DELETE_IMAGE :
						$dir = IMAGE_URL . $directory;
						break;
					default: //0
						$dir = IMAGE_URL . $directory;
						make_dir($dir);
						break;		
				}
				$paths = $dir . $size . '_' . $fname;
				return $paths;
			}
			return false;
	   }
	  
	  /**
	   *  Get image orginal
	   * 
	   *  @author MinhNV
	   *  Date 2011/09/12
	   */
	  static function getOrginalImage($fname = '', $id = 0, $folder = self::FOLDER_DEFAULT, $check = OPT_UPLOAD_IMAGE) {
	  		if($fname != '') {
	  			$directory  = ($id > 0) ? self::getFolderByID($id, $folder) : '';
				$paths = '';
				switch ($check) {
					case OPT_GET_IMAGE:
						$dir = IMAGE_URL . $directory;	
						break;
					case OPT_DELETE_IMAGE :
						$dir = IMAGE_URL . $directory;
						break;
					default: //0
						$dir = IMAGE_URL . $directory;
						make_dir($dir);
						break;		
				}
				$paths = $dir . '_' . $fname;
				return $paths;
	  		}
	  		return false;
	  }
    /**
     * QuynhTM
     * lấy ảnh gốc rồi thumb qua hàm image.php
     * @param string $fname
     * @param int $id
     * @param string $folder
     * @param int $thum_w
     * @param int $thum_h
     * @param string $cropratio
     * @return bool|string
     */
    static function getThumbImage($fname = '', $id = 0, $folder = self::FOLDER_DEFAULT,$thum_w = 0,$thum_h = 0,$cropratio = '') {
        if($fname != '' && $id > 0) {
            $directory  = self::getFolderByID($id, $folder);
            $string_crop = ($cropratio != '') ? '&cropratio='.$cropratio : '';
            $dir = STATIC_URL . $directory;
            $paths_image = $dir . '_' . $fname;
            $url_image = STATIC_URL."thumb_img/image.php?width={$thum_w}&height={$thum_h}{$string_crop}&image=".$paths_image;
            return $url_image;
        }
        return false;
    }
	  
	  /**
	   *  upload images
	   * 
	   * @param String $file_src
	   * @param String $file_name
	   * @param int $id
	   * @param String $folder
	   * @param int $date
	   * 
	   * @author MinhNV
	   * Date 2011/07/29
	   */
	  static  function  uploadImages($file_src,  $file_name = '' , $old_file = '', $images_size, &$aryError, $id = 0, $folder = self::FOLDER_DEFAULT) {
	  		if($file_name != '') {
		  		$aryReturn = array();
				$imageInfo = getimagesize($file_src);
				$file_name = remove_sign_file($file_name);
		  		$all_img_name = self::getAllImages($file_name, $images_size, $id, $folder);
				
		  		$old_img_name = self::getAllImages($old_file, $images_size, $id, $folder, OPT_DELETE_IMAGE);
				$aspect_ratio = ($imageInfo[0] > 0) ? ($imageInfo[1] / $imageInfo[0]) : 1;
				
				//Gen anh orginal moi
				$image_orginal = self::getOrginalImage($file_name, $id, $folder);
				copyOrginalImage($file_src, $image_orginal);
				
				//Xóa image orginal cu
				if($old_file != '') {
					$old_image_orginal = self::getOrginalImage($old_file, $id, $folder, OPT_DELETE_IMAGE);
					@unlink($old_image_orginal);	
				}
				
				//Gen anh moi va xoa anh cu
				if(is_array($all_img_name) && !empty($all_img_name)){
					foreach ($images_size as $k => $val){
						$oke = genImageFromSource($file_src, $all_img_name[$k], $imageInfo[0], $imageInfo[1], $val['width'] , $val['height'], $aspect_ratio);
						if(!$oke){
							$aryError[] = 'Upload images product _'.$k.'_error'; 
						}
						else {
							@unlink($old_img_name[$k]);
						}
					}
				}
				return  $file_name;
	  		}
	  }
	  
	  /**
	   * 
	   * Delete image from server 
	   * 
	   * @param String $file_name
	   * @param array $images_size
	   * @param int $id
	   * @param int $timestamp
	   * @param String $folder
	   * 
	   * @author MinhNV
	   * Date 2011/09/11
	   */
	  static function  deleteImage($file_name = '', $images_size = NULL, $id = 0, $folder = self::FOLDER_DEFAULT, $is_delDir = 0, $check = OPT_DELETE_IMAGE) {
	  		if($file_name != '') {
			  	//Xoa anh goc
			  	$image_orginal = self::getOrginalImage($file_name, $id, $folder, $check);
			  	@unlink($image_orginal);
			  	
			  	if(!is_null($images_size)){
				  	//Xoa anh gen
				  	$all_images = self::getAllImages($file_name, $images_size, $id, $folder, $check);
				  	if(is_array($all_images) && !empty($all_images)){
				  		foreach ($images_size as $k => $val){
				  			@unlink($all_images[$k]);
				  		}
				  	}
			  	}
			  	//Xoa thu muc
			  	if($is_delDir) {
				  	$dir = '';
				  	$dir = self::getFolderByID($id,  $folder);
				  	if(is_dir($dir)) {
				  		@rmdir($dir);
				  	}
			  	}
	  		}
	  }
}