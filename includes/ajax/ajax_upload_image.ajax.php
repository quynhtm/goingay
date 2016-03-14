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

class ajax_upload_image {
	function playme(){
		$code = EnBacLib::getParam('code');
		switch( $code ){
            case 'upload_image' :
				$this->upload_image();
				break;
            //up anh chen vao noi dung mo ta
            case 'upload_image_insert_content' :
				$this->upload_image_insert_content();
				break;
            case 'remove_image' :
				$this->remove_image();
				break;
			default:
				$this->home();
				break;
		}
	}
	
	function home(){
		global $display;
		die("Nothing to do...");
	}
	/**
	 * upload ảnh TIN TUC, Sản Phẩm
	 */
	function upload_image() {
        $id_hiden = (int)Url::get('id', 0);
        $type = (int)Url::tget('type', 1);
        $dataImg = $_FILES["multipleFile"];

        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Dữ liệu không tồn tại";
        //SvLib::FunctionDebug($dataImg);
        switch( $type ){
            case 1://anh tin tưc
                $aryData = $this->uploadImageToFolder($dataImg,$id_hiden,TABLE_NEWS,CGlobal::$image_news,SvImg::FOLDER_NEWS);
                break;
            case 2 ://ảnh sản phẩm
                $aryData = $this->uploadImageToFolder($dataImg,$id_hiden,TABLE_PRODUCT,array(),SvImg::FOLDER_PRODUCT);
                break;
            default:
                break;
        }
		echo json_encode($aryData);
		exit();
	}
    function uploadImageToFolder($dataImg,$id_hiden,$table_action,$size_image,$folder_image){
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Dữ liệu không tồn tại";

        if (!empty($dataImg)) {
            if($id_hiden == 0){
                $new_row['create_time'] = TIME_NOW;
                $new_row['status'] = CGlobal::status_error;
                $id = DB::insert($table_action, $new_row);
            }elseif($id_hiden > 0){
                $id = $id_hiden;
            }
            $aryError = $tmpImg = array();
            $old_file = '';
            $file_name = SvImg::uploadImages($dataImg['tmp_name'], $dataImg['name'], $old_file, $size_image, $aryError, $id, $folder_image);
            if ($file_name != '' && empty($aryError)) {
                $tmpImg['name_img'] = $file_name;
                $tmpImg['id_key'] = rand(10000, 99999);
                //$tmpImg['src'] = SvImg::getImageBySize($file_name, CGlobal::size_image_80, $id, $folder_image, OPT_GET_IMAGE);
                $tmpImg['src'] = SvImg::getThumbImage($file_name,$id,$folder_image,80,80,'1:1');

                //update vao DB de xoa khi càn
                //lấy tên ảnh trong DB và xóa đi khi cần
                $listImageTempOther = DB::get_one("SELECT images_other_temp FROM  " . $table_action . ' WHERE id= ' . $id);
                $aryTempImages = ($listImageTempOther !='')? unserialize($listImageTempOther): array();
                $aryTempImages[] = $file_name;
                $new_row['images_other_temp'] = serialize($aryTempImages);
                DB::update($table_action, $new_row, 'id=' . $id);
            }
            $aryData['intIsOK'] = 1;
            $aryData['id_item'] = $id;
            $aryData['info'] = $tmpImg;
        }
        return $aryData;
    }

    function remove_image() {
		$id = Url::tget('id', 0);
		$nameImage = Url::get('nameImage','');
		$type = Url::tget('type', 1);
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['nameImage'] = $nameImage;
        switch( $type ){
            case 1://anh tin tưc
                $folder_image = SvImg::FOLDER_NEWS;
                $sizeAllImage = CGlobal::$image_news;
                $table_action = TABLE_NEWS;
                if($id > 0 && $nameImage != '' && $folder_image != '' && !empty($sizeAllImage)){
                    $delete_action = $this->delete_image_item($id,$nameImage,$table_action,$sizeAllImage,$folder_image);
                    if($delete_action == 1){
                        $aryData['intIsOK'] = 1;
                        $aryData['msg'] = "Đã xóa thành công";
                    }
                }
                break;
            case 2 ://ảnh sản phẩm
                $folder_image = SvImg::FOLDER_PRODUCT;
                $sizeAllImage = CGlobal::$image_product;
                $table_action = TABLE_PRODUCT;
                if($id > 0 && $nameImage != '' && $folder_image != '' && !empty($sizeAllImage)){
                    $delete_action = $this->delete_image_item($id,$nameImage,$table_action,$sizeAllImage,$folder_image);
                    if($delete_action == 1){
                        $aryData['intIsOK'] = 1;
                        $aryData['msg'] = "Đã xóa thành công";
                    }
                }
                break;
            default:
                $folder_image = SvImg::FOLDER_DEFAULT;
                break;
        }
		echo json_encode($aryData);
		exit();
	}
    function delete_image_item($id,$nameImage,$table_action,$sizeAllImage,$folder_image){
        $delete_action = 0;
        //lấy tên ảnh trong DB và xóa đi
        $listImageOther = DB::get_one("SELECT images_other FROM  " . $table_action . ' WHERE id= ' . $id);
        $aryImages = unserialize($listImageOther);
        if(is_array($aryImages) && count($aryImages) > 0) {
            foreach ($aryImages as $k => $v) {
                if($v === $nameImage){
                    SvImg::deleteImage($nameImage, $sizeAllImage, $id, $folder_image,true, OPT_DELETE_IMAGE);
                    $delete_action = 1;
                    break;
                }
            }
        }
        //xóa khi chưa update vào DB, ảnh mới upload
        if($delete_action == 0){
            SvImg::deleteImage($nameImage, $sizeAllImage, $id, $folder_image,true, OPT_DELETE_IMAGE);
            $delete_action = 1;
        }
        return $delete_action;
    }

    /*
     * Dùng cho chen anh cua nội dung
     */
    function upload_image_insert_content() {
        $id_hiden = (int)Url::get('id', 0);
        $type = (int)Url::tget('type', 1);
        $dataImg = $_FILES["multipleFile"];

        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Dữ liệu không tồn tại";
        //SvLib::FunctionDebug($dataImg);
        $size_image = array(
            CGlobal::size_image_100 => array('width' => 100,  'height' => 100),//view popup
            CGlobal::size_image_700 => array('width' => 700,  'height' => 700)// cho noi dung tin bai
        );
        switch( $type ){
            case 1://anh tin tưc
                $aryData = $this->uploadImageInsertContent($dataImg,$id_hiden,TABLE_NEWS,$size_image,SvImg::FOLDER_NEWS);
                break;
            case 2 ://ảnh sản phẩm
                $aryData = $this->uploadImageInsertContent($dataImg,$id_hiden,TABLE_PRODUCT,$size_image,SvImg::FOLDER_PRODUCT);
                break;
            default:
                break;
        }
        echo json_encode($aryData);
        exit();
    }
    function uploadImageInsertContent($dataImg,$id_hiden,$table_action,$size_image,$folder_image){
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Dữ liệu không tồn tại";
        if (!empty($dataImg)) {
            if($id_hiden == 0){
                $new_row['create_time'] = TIME_NOW;
                $new_row['status'] = CGlobal::status_error;
                $id = DB::insert($table_action, $new_row);
            }elseif($id_hiden > 0){
                $id = $id_hiden;
            }
            $aryError = $tmpImg = array();
            $old_file = '';
            $file_name = SvImg::uploadImages($dataImg['tmp_name'], $dataImg['name'], $old_file, $size_image, $aryError, $id, $folder_image);
            if ($file_name != '' && empty($aryError)) {
                $tmpImg['name_img'] = $file_name;
                $tmpImg['id_key'] = rand(10000, 99999);
                $tmpImg['src'] = SvImg::getThumbImage($file_name,$id,$folder_image,100,100,'1:1');
                $tmpImg['src_700'] = SvImg::getThumbImage($file_name,$id,$folder_image);

                //update vao DB de xoa khi càn
                //lấy tên ảnh trong DB và xóa đi khi cần
                $listImageTempOther = DB::get_one("SELECT images_other_temp FROM  " . $table_action . ' WHERE id= ' . $id);
                $aryTempImages = ($listImageTempOther !='')? unserialize($listImageTempOther): array();
                $aryTempImages[] = $file_name;
                $new_row['images_other_temp'] = serialize($aryTempImages);
                DB::update($table_action, $new_row, 'id=' . $id);
            }
            $aryData['intIsOK'] = 1;
            $aryData['id_item'] = $id;
            $aryData['info'] = $tmpImg;
        }
        return $aryData;
    }

}//class
?>