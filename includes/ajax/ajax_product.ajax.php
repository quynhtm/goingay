<?php
if (preg_match ( "/" . basename ( __FILE__ ) . "/", $_SERVER ['PHP_SELF'] )) {
	die ( "<h1>Incorrect access</h1>You cannot access this file directly." );
}
class ajax_product {	
	function playme() {
		$code = EnBacLib::getParam ( 'code' );
		switch ($code) {
			case 'render':
				$this->renderAttProduct();
				break;
            case 'buy_product':
				$this->buy_product();
				break;
			default :
				$this->actDef();
				break;
		}
	}
	
	function actDef() {
		global $display;
		die ( "Nothing to do..." );
	}

    function buy_product() {
        $id = Url::get('id_product', 0);
        $aryData = array();
        $aryResult = array('intIsOK'=>-1,'msg'=>'');

        if($id > 0) {
            $sql = "SELECT * FROM ". TABLE_PRODUCT . " WHERE `status`=1 AND id = ". $id;
            $aryProduct = DB::get_row($sql);

            $full_name = Url::get('fullname');
            $address = Url::get('address');
            $mobile = Url::get('mobile');
            $soluong = Url::get('num_item');
            $content = Url::get('content');

            $aryData = array();
            $aryData['name'] = $aryProduct['name'];
            $aryData['category_id'] = $aryProduct['category_id'];
            $aryData['category_name'] = $aryProduct['category_name'];
            $aryData['network_name'] = $aryProduct['name_alias'];
            $aryData['price'] = $aryProduct['price'];
            $aryData['num_item'] = $soluong;
            $aryData['full_name'] = $full_name;
            $aryData['address'] = $address;
            $aryData['mobile_phone'] = $mobile;
            $aryData['description'] = $content;
            $aryData['product_id'] = $id;
            $aryData['date'] = TIME_NOW;

            $id = DB::insert(TABLE_CART, $aryData);
            if($id > 0) {
                $aryResult['intIsOK'] = 1;
                $aryResult['msg'] = "Bạn đã đặt hàng thành công trên namdalat.com, chúng tôi sẽ liên hệ với bạn sớm nhất.";
            }else{
                $aryResult['intIsOK'] = -1;
                $aryResult['msg'] = "Có lỗi đặt hàng. Phiền quý khách gọi điện trực tiếp để liên hệ";
            }

        }
        echo $aryResult['msg'];
        exit;
        /*echo json_encode($aryResult);
        exit();*/
    }
	private function renderAttProduct() {
		$cat_id = EnBacLib::getParamInt('cat_id');
		$net_brand = 0;
		if($cat_id > 0) {
			$net_brand = DB::get_one("SELECT `type` FROM ".TABLE_CATEGORY." WHERE id=".$cat_id);
			if($net_brand == 0) {
				$arySelect = array();
				$arySelect[0] = 'Hãy chọn nhà mạng';
				$arySelect += CGlobal::$aryNetwork;
				echo '<select id="network_id" name="network_id">';
				echo EnbacLib::getOption($arySelect, 0);
				echo '</select>';
			}
			else {
				$arySelect = array();
				$arySelect[0] = 'Hãy chọn thương hiệu';
				$arySelect += CGlobal::$aryBrand;
				echo '<select id="brand_id" name="brand_id">';
				echo EnbacLib::getOption($arySelect, 0);
				echo '</select>';
			}
		}
		exit ();
	}

} //class
