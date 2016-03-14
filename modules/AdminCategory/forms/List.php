<?php

/**
 * 
 * * @author Quynh_Arsenal
 *
 */
class ListForm extends Form {
	var $condition = array(),$aryCatPro = array(), $search = array(), $stringWhere = '', $page_no = 1, $offset = 0, $item_per_page = 0;
    var $aryTypeNews = array();
    var $arrHot = array(-1=>'Tin hot' ,1 => 'Có', 0 => "Không");
    var $table_action = TABLE_CATEGORY;
	function __construct() {
		Form::Form('ListForm');//dùng common
		$this->buildCondition();
	}

    function buildCondition() {
        //------------ SEARCH - SET AND GET FROM COOKIE -----------
        $cookieName = 'product_seach';
        $ckValue = (isset($_COOKIE[$cookieName]) ? unserialize($_COOKIE[$cookieName]) : array());

        $name_pro =  SvLib::getContion('name', $ckValue);
        $this->search['name'] = $name_pro;
        if($name_pro != '') {
            $this->condition[] = ' name like "%'.$name_pro.'%" ';
        }

        $product_id =  SvLib::getContion('product_id', $ckValue);
        $this->search['product_id'] = $product_id;
        if($product_id != '') {
            $this->condition[] = ' id ='.$product_id.'';
        }

        //tim category
        $aryCatProduct = array();
        $this->aryCatPro = $aryCatProduct = getTreeCatAll();
        $aryCatOption = array();
        foreach($aryCatProduct as $arrCategoryList){
            $aryCatOption[$arrCategoryList->id]=$arrCategoryList->textTitle;
        }
        $cat_product_id =  SvLib::getContion('category_id', $ckValue);
        $this->search['category_id'] = EnBacLib::getOption(array(0 => 'Tất cả') + $aryCatOption, $cat_product_id);
        if($cat_product_id != 0 ) {
            $this->condition[] = ' category_id = '. $cat_product_id .' ';
        }

        $status =  SvLib::getContion('status', $ckValue,-1);
        $this->search['status'] = EnBacLib::getOption(array(-1 => 'Tất cả') + CGlobal::$arrStatus, $status);
        if($status != -1 ) {
            $this->condition[] = ' status = '. $status .' ';
        }

        //paging
        $this->page_no =  SvLib::getContion('page_no', $ckValue, 1);
        $this->item_per_page =  SvLib::getContion('item_per_page', $ckValue, CGlobal::$number_per_page); // số bản ghi trong một trang kết quả
        $this->search['item_per_page'] = SvLib::item_per_page($this->item_per_page);
        $this->offset = ($this->page_no-1) * $this->item_per_page;
        //set cookie search 10 phút
        EnBacLib::set_cookie($cookieName, serialize($ckValue), TIME_NOW+600);

        //lay SP nguoi tao san pham
        if(!User::is_root()){
            $this->condition[] = ' create_user_id = '. User::id() .' ';
        }

        $this->stringWhere = empty($this->condition) ? '' : ''.join(' AND ', $this->condition);
    }

	function draw() {
        global $display;
        $this->beginForm(false,"post",false,Url::build_current());
        $total_row = DB::fetch('SELECT count(*) AS total_row FROM '.$this->table_action.' limit 0,1','total_row',0);
        $items = array();
        if($total_row){
            // Get category
            $arrCategoryLists = getTreeCatAll();
            //Set for Items
            $i = 0;
            foreach($arrCategoryLists as $arrCategoryList){
                foreach ($arrCategoryList as $key=>$value){
                    $items[$i][$key]=$value;
                }
                $i++;
            }
        }

        $page_no = Url::get('page_no',1);
		$display->add('total_row', $total_row);
		$display->add('items', $items);
		$display->add('page', Url::get('page'));
		$display->add('stt', ($page_no-1)*CGlobal::$number_per_page);

		//common
        $display->add('is_root',(User::is_root())? 1: 0);
		$display->add('title_page', 'Quản trị danh mục');
        $display->add('hover', EnBacLib::mouse_hover(COLOR_MOUSE_HOVER, true));
		$display->add('search',	$this->search);
		$display->output('List');
		$this->endForm();
	}
}
?>