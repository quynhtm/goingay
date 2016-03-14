<?php
class SiteListNewsForm extends Form{
	function __construct(){
		Form::Form('SiteListNewsForm');
	}
	function draw(){
		global $display;
		$id_brand = (int)Url::get('id',0);
		$page = Url::get('page');
		$cond = ' status = 1 ';
		if($page == 'phu_kien_dien_thoai') {
			$cond .= ' AND category_id = '.CGlobal::PHU_KIEN_DIEN_THOAI." ORDER BY id DESC";
		}
		if($id_brand > 0){
			$cond .= " AND network_id =0 AND category_id = ".CGlobal::PHU_KIEN_DIEN_THOAI." AND brand_id=".$id_brand." ORDER BY id DESC";
			$display->add('name_type', CGlobal::$aryBrand[$id_brand]);
		}
		$total_row = DB::fetch('SELECT count(*) AS total_row FROM '. TABLE_PRODUCT.' WHERE '.$cond.'  LIMIT 0,1','total_row',0);
		if($total_row > 0){
			$limit = ' ';
			$pagingData = EBPagging::pagingSE($limit,$total_row,CGlobal::$number_product_21,10,'page_no',true);
			$sql = "SELECT id,name,images,price FROM ". TABLE_PRODUCT . " WHERE ".$cond.$limit;
			$res = DB::query($sql);
			$aryItemPro = array();
			if($res) {
				while ($row = mysql_fetch_assoc($res)) {
					$images = SvImg::getAllImages($row['images'], CGlobal::$product_image_sizes, $row['id'], SvImg::FOLDER_PRODUCT, OPT_GET_IMAGE);
					if(!empty($images)) {
						$row ['images'] = $images[136];
					}
					$row['link_detail'] = Url::build('detail_product', array('pro_id'=>$row ['id'], 'title'=>safe_title($row['name'])));
					$aryItemPro[] = $row;
				}
			}
			$display->add('item_pro', $aryItemPro);
			if($total_row > CGlobal::$number_product_21){
				$display->add('pagingDataPro', $pagingData);
			}
		}
		$display->output("SiteListNews");
	}
}