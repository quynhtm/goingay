<?php

/**
 * 
 * * @author Quynh_Arsenal
 *
 */
class ListForm extends Form {
	var $condition = array(),$aryCatPro = array(), $search = array(), $paramSearch = array(), $stringWhere = '', $page_no = 1, $offset = 0, $item_per_page = 0;
    var $aryTypeNews = array();
    var $arrHot = array(-1=>'Tin hot' ,1 => 'Có', 0 => "Không");
    var $arrStatus = array(-1=>'Chọn trạng thái' ,1 => 'Hiện thị', 0 => "Ẩn");

	function __construct() {
		Form::Form('ListForm');//dùng common
		$this->deleteItemError();
		$this->buildCondition();
        CGlobal::$website_title = 'Quản trị tin tức';
	}

    function deleteItemError(){
        $sql = "SELECT images,id,images_other_temp FROM  " . TABLE_NEWS . ' WHERE status='.CGlobal::status_error;
        $re = DB::query($sql);
        if ($re) {
            while ($row = mysql_fetch_assoc($re)) {
                DB::delete_id(TABLE_NEWS, $row['id']);
                if ($row['images'] != '') {
                    SvImg::deleteImage($row['images'], CGlobal::$image_news, $row['id'], SvImg::FOLDER_NEWS,true, OPT_DELETE_IMAGE);
                }
                if($row['images_other_temp'] != '') {
                    $aryTempImages = array();
                    $aryTempImages = unserialize($row['images_other_temp']);
                    if(is_array($aryTempImages) && count($aryTempImages) > 0) {
                        foreach ($aryTempImages as $k2 => $v2) {
                            SvImg::deleteImage($v2, CGlobal::$image_news, $row['id'], SvImg::FOLDER_NEWS, OPT_DELETE_IMAGE);
                        }
                    }
                }
            }
        }
    }
	function buildCondition() {
		//------------ SEARCH - SET AND GET FROM COOKIE -----------
		$cookieName = 'news_seach';
		$ckValue = (isset($_COOKIE[$cookieName]) ? unserialize($_COOKIE[$cookieName]) : array());

		//từ khóa
		$title_news = SvLib::getContion('title_news', $ckValue);
		$this->search['title_news'] = $title_news;
		if ($title_news != '') {
			$this->condition[] = ' name like "%' . $title_news . '%" ';
            $this->paramSearch['title_news'] = $title_news;
		}
                
         //option loại tin
		$this->aryTypeNews = CGlobal::$arrCatgoryNew;
		$type_new = SvLib::getContion('cat_new_id', $ckValue);
		$this->search['cat_new_id'] = EnbacLib::getOption(array(0=>'----Chọn mục tin----') + $this->aryTypeNews, $type_new);
		if ($type_new != 0) {
			$this->condition[] = ' cat_new_id = ' . $type_new . ' ';
            $this->paramSearch['cat_new_id'] = $type_new;
		}
                
        //trạng thái
		$hots_new = SvLib::getContion('status', $ckValue, -1);
		$this->search['status'] = EnbacLib::getOption($this->arrStatus, $hots_new);
		if ($hots_new != -1) {
			$this->condition[] = ' status = ' . $hots_new . ' ';
            $this->paramSearch['status'] = $hots_new;
		}
		
		//paging
		$this->page_no = SvLib::getContion('page_no', $ckValue, 1);
		$this->item_per_page = SvLib::getContion('page_no', $ckValue, 1); // số bản ghi trong một trang kết quả
		$this->search['item_per_page'] = SvLib::item_per_page($this->item_per_page);
		$this->offset = ($this->page_no - 1) * $this->item_per_page;

		EnBacLib::set_cookie($cookieName, serialize($ckValue), TIME_NOW + 600);
		$this->stringWhere = empty($this->condition) ? '' : '' . join(' AND ', $this->condition);
	}

	function draw() {
		global $display;
        $page_no = Url::get('page_no',1);
		$this->beginForm(false, 'post', false, Url::build_current());
		if($this->stringWhere != '') {
			$total_row = DB::fetch('SELECT count(*) AS total_row FROM '.TABLE_NEWS.' WHERE ' . $this->stringWhere . ' LIMIT 0,1', 'total_row', 0);	
		}
		else {
			$total_row = DB::fetch('SELECT count(*) AS total_row FROM '.TABLE_NEWS.' LIMIT 0,1', 'total_row', 0);
		}
		$items = array();
		$paging = '';
		if ($total_row) {
			$limit = '';
            $paging = SvPaging::getNewPager($limit,CGlobal::$number_pages_show, $page_no, $total_row, CGlobal::$number_per_page,$this->paramSearch);

			$sql = 'SELECT * FROM '.TABLE_NEWS;
			$sql .=  ($this->stringWhere != '') ? ' WHERE '. $this->stringWhere : ' ';
			$sql .= ' ORDER BY id desc';
			$sql .= $limit;
			
			$re = DB::query($sql);
			if ($re) {
				while ($row = mysql_fetch_assoc($re)) {
                    $row ['images_big'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_NEWS,300,150);
                    $row ['images'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_NEWS,40,40);

                    $row ['cat_news_name'] = isset($this->aryTypeNews[$row ['cat_new_id']])?$this->aryTypeNews[$row ['cat_new_id']]:'Chưa xác định';
					$items[$row['id']] = $row;
				}
			}
		}

		$display->add('paging', $paging);
		$display->add('total_row', $total_row);
		$display->add('items', $items);
		$display->add('page', Url::get('page'));
		$display->add('stt', ($page_no-1)*CGlobal::$number_per_page);
		$display->add('hover', EnBacLib::mouse_hover(COLOR_MOUSE_HOVER, true));

		//common
		$display->add('title_page', 'Quản trị tin tức');
		$display->add('search',	$this->search);
		$display->output('List');
		$this->endForm();
	}
}
?>