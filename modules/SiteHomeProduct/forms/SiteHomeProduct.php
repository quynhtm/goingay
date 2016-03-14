<?php
class SiteHomeProductForm extends Form{
	function __construct(){
		Form::Form('SiteHomeProductForm');
	}
	
	function draw(){
		return;
		global $display;
		//Sản phẩm mới nhất trên trang chủ
		$cond = 'status = 1';
        $sql = "SELECT id,name,images,price FROM ".TABLE_PRODUCT." WHERE " . $cond . " order by modify_time DESC limit 0,16";
		$res = DB::query($sql);
		$aryHomeProduct = array();
		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
                $row['images'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_PRODUCT,150,180);
                $row['link_detail'] = Url::build('detail_product', array('pro_id' => $row['id'], 'title' => FunctionLib::safe_title($row['name'])));
                $row['title_cut'] = SvLib::word_limit($row['name'],10);
                $aryHomeProduct[] = $row;
			}
		}
		//SvLib::FunctionDebug($aryHomeProduct);

		$display->add('aryHomeProduct', $aryHomeProduct);
		$display->output("SiteHomeProduct");
	}
}