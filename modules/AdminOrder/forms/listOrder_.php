<?php
class listOrderForm extends Form {
	const ALL_STATUS_BILL = 1000;
    var $search = array();
	function __construct(){
		Form::Form('ListForm');
        $this->link_css('style/bootstrap/lib/datetimepicker_new/datetimepicker.css');
        $this->link_js('style/bootstrap/lib/datetimepicker_new/jquery.datetimepicker.js');
		require_once ROOT_PATH.'core/lib/function.php';
	}
	function draw(){
		global $display;
		$this->beginForm(false,'post',false,Url::build_current());

		$cond = self::buildCond();
		//Get all acount
		$aryBill = array();
		$total_row = 0;
		$total_row = DB::get_one("SELECT COUNT(id) FROM  ".TABLE_CART."  WHERE " . $cond);
		$paging = '';
		if($total_row > 0){
			$limit = '';
			$paging = SvPaging::pagingSE($limit, $total_row, CGlobal::$number_per_page, CGlobal::$number_pages_show, 'page_no', true);
			$sql = "SELECT * ";
			$sql .= "FROM ".TABLE_CART." WHERE ". $cond. " ORDER BY id DESC " . $limit ;
			$res = DB::query($sql);
			if($res) {
				$i = 0;
				while ($item = mysql_fetch_assoc($res)){
					$item['date'] = date('H:i d-m-Y', $item['date']);
					$item['link_detail'] = Url::build('detail_product', array('pro_id'=>$item ['product_id'], 'title'=>safe_title($item['product_name'])));
					$aryBill[$i] = $item;
					$i++;
				}
			}
		}
		
		// assign varible doi soat
        $page_no = Url::get('page_no',1);
        $display->add('paging', $paging);
        $display->add('total_row', $total_row);
        $display->add('items', $aryBill);
        $display->add('page', Url::get('page'));
        $display->add('stt', ($page_no-1)*CGlobal::$number_per_page);

        $display->add('search',	$this->search);
		$display->output('List');
		$this->endForm();
	}
	
	function buildCond(){
        $this->search['customer_name'] = $cus_name = Url::get('customer_name');
        $this->search['mobile_phone'] = $cus_mobile = Url::get('mobile_phone');
        $this->search['product_name'] = $pro_name = Url::get('product_name');
        $this->search['product_id'] = $product_id = Url::get('product_id');
        $this->search['category_id'] = $cat_product_id =  Url::get('category_id', 0);

		$start_date = 0;
		$end_date = 0;
        $this->search['start_date'] = Url::get('start_date', date('d-m-Y H:i', strtotime('-1 day')));
        $this->search['end_date'] = Url::get('end_date', date('d-m-Y H:i'));

        $date_from = Url::get('start_date', date('d-m-Y H:i', strtotime('-1 day')));
        $date_to = Url::get('end_date', date('d-m-Y H:i'));
		if($date_from != '' || $date_to != '') {
			if($date_from){
				$date_arr = explode('-', $date_from);
				if(isset($date_arr[0]) && isset($date_arr[1]) && isset($date_arr[2]))
				$start_date = mktime(0,0,0,(int)$date_arr[1],(int)$date_arr[0],(int)$date_arr[2]);
			}
			if($date_to){
				$date_arr = explode('-', $date_to);
				if(isset($date_arr[0]) && isset($date_arr[1]) && isset($date_arr[2]))
				$end_date = mktime(23,59,59,(int)$date_arr[1],(int)$date_arr[0],(int)$date_arr[2]);
			}
		}

		$cond ='';
		$cond .= ' del_flag = 0 ';

        //lay SP nguoi tao san pham
        if(!User::is_root()){
            $cond .= ' AND shop_id = '. User::id() .' ';
        }

        $status = Url::get('status',-1);
        $this->search['status'] = EnBacLib::getOption(array(-1 => 'Tất cả') + CGlobal::$arrStatus, $status);
        if($status != -1 ) {
            $cond .=  ' AND status = '. $status .' ';
        }

        //Search theo ngay startdate
		/*if($start_date) {
			$cond .= ' AND `date` >=' . $start_date ;
		}

		//Search theo enddate
		if($end_date) {
			$cond .= ' AND `date` <=' . $end_date ;
		}*/
		
		//Search tên khách hàng
		if($cus_name != '') {
			$cond .= ' AND customer_name like "%' . trim($cus_name) .'%"';
		}

		//Search theo user_name
		if($pro_name != '') {
			$cond .= ' AND product_name like "%' . trim($pro_name) .'%"';
		}
		//Search theo user_name
		if($product_id != '' && (int)$product_id > 0) {
			$cond .= ' AND product_id =' . $product_id .'';
		}

		//Search theo mobile
		if($cus_mobile) {
			$cond .= ' AND `mobile_phone` ="' . trim($cus_mobile) .'"';	
		}

		//Search theo category
        ////Get all category_product
        $aryCatProduct = getTreeCatAll();
        $this->aryCatProduct = $aryCatProduct;

        $aryCatOption=array();
        $aryCatOption[0]='--- Root ---';
        foreach($aryCatProduct as $arrCategoryList){
            $aryCatOption[$arrCategoryList->id]=$arrCategoryList->textTitle;
        }
        $cat_product_id =  SvLib::getContion('category_id', $ckValue);
        $cat_product_id = Url::get('category_id',0);
        $this->search['category_id'] = EnBacLib::getOption(array(0 => 'Tất cả') + $aryCatOption, $cat_product_id);
		if($cat_product_id > 0) {
			$cond .= ' AND category_id =' . $cat_product_id;
		}
		return $cond;
	}
}