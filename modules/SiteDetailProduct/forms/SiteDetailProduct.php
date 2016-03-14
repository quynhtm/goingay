<?php

class SiteDetailProductForm extends Form {
	private $product = array();
	function __construct() {
		Form::Form('SiteDetailProductForm');
		$id = (int) Url::get('pro_id',0);
		if ($id > 0) { //edit
			$this->product = Product::getProductById($id);
			if ($this->product){
				//check trạng thái sản phẩm
				if(Product::checkProductActionById($this->product['id']) == true){
					Url::redirect('home');
				}
				//check trạng thái shop
				if(Account::checkAccountActionById($this->product['create_user_id']) == true){
					Url::redirect('home');
				}
			}else{
				Url::redirect('home');
			}
		}else{
			Url::redirect('home');
		}
	}
	function draw() {
		global $display;
		$id = (int) Url::get('pro_id', 0);
		if ($id > 0) {
			if (!empty($this->product)) {
				//chi tiết tin
				$product = $this->product;
                $product['images_show'] = SvImg::getThumbImage($product['images'],$product['id'],SvImg::FOLDER_PRODUCT);
				$display->add('new', $product);

                //cùng loại
                $cat_id = !empty($product)? $product['category_id']: 0;
				if ($cat_id > 1 && isset($product['id']) && $product['id'] > 0) {
					$cond2 = " status = 1 AND category_id=" . $cat_id . " AND id <>" . $product['id'] . " ORDER BY id DESC limit 0,9";
					$sql = "SELECT id,name FROM ".TABLE_PRODUCT." WHERE " . $cond2;
					$res = DB::query($sql);
					$aryItemPro = array();
					if ($res) {
						while ($row = mysql_fetch_assoc($res)) {
							$row['view'] = Url::build('detail_product', array('pro_id' => $row['id'], 'title' => safe_title($row['name'])));
							$aryItemPro[] = $row;
						}
					}
					$display->add('item_pro', $aryItemPro);
				}
			}
		}
		$display->output("SiteDetailProduct");
	}
}