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
    var $table_action = TABLE_ACCOUNT;
	function __construct() {
		Form::Form('ListForm');//dùng common
		$this->buildCondition();
	}

    function buildCondition() {
        //------------ SEARCH - SET AND GET FROM COOKIE -----------
        $cookieName = 'user_seach';
        $ckValue = (isset($_COOKIE[$cookieName]) ? unserialize($_COOKIE[$cookieName]) : array());

        //từ khóa
        $name_pro =  SvLib::getContion('name_pro', $ckValue);
        $this->search['name_pro'] = $name_pro;
        if($name_pro != '') {
            $this->condition[] = ' name like "%'.$name_pro.'%" ';
        }
        //end từ khóa

        //tim nha cung cap
        $aryNCC = array();
        $aryNCC = SvLib::getResultNCC();
        $aryNccOption = array();
        foreach($aryNCC as $val){
            $aryNccOption[$val['id']] = $val['name_ncc'];
        }
        $id_ncc =  SvLib::getContion('id_nhacc', $ckValue);
        $this->search['id_ncc'] = EnBacLib::getOption(array(0 => 'Chọn nhà cung cấp') + $aryNccOption, $id_ncc);
        if($id_ncc != 0 ) {
            $this->condition[] = ' id_ncc = '. $id_ncc .' ';
        }

        //lay nhung id do người ay tao
        if(!User::is_root()){
            $this->condition[] = ' create_user_id = '. User::id() .' ';
        }

        //paging
        $this->page_no =  SvLib::getContion('page_no', $ckValue, 1);
        $this->item_per_page =  SvLib::getContion('item_per_page', $ckValue, CGlobal::$number_per_page); // số bản ghi trong một trang kết quả
        $this->search['item_per_page'] = SvLib::item_per_page($this->item_per_page);
        $this->offset = ($this->page_no-1) * $this->item_per_page;
        //set cookie search 10 phút
        EnBacLib::set_cookie($cookieName, serialize($ckValue), TIME_NOW+600);
        $this->stringWhere = empty($this->condition) ? '' : ''.join(' AND ', $this->condition);
    }

	function draw() {
		global $display;
		$this->beginForm(false, 'post', false, Url::build_current());
		if($this->stringWhere != '') {
			$total_row = DB::fetch('SELECT count(*) AS total_row FROM '.$this->table_action.' WHERE ' . $this->stringWhere . ' LIMIT 0,1', 'total_row', 0);
		}
		else {
			$total_row = DB::fetch('SELECT count(*) AS total_row FROM '.$this->table_action.' LIMIT 0,1', 'total_row', 0);
		}
		$items = array();
		$paging = '';
		if ($total_row) {
			$limit = '';
			$paging = SvPaging::pagingSE ($limit, $total_row, CGlobal::$number_per_page, CGlobal::$number_pages_show, 'page_no', true );
			$sql = 'SELECT * FROM '.$this->table_action;
			$sql .=  ($this->stringWhere != '') ? ' WHERE '. $this->stringWhere : ' ';
			$sql .= ' ORDER BY id desc';
			$sql .= $limit;
            $re = DB::query($sql);
			if ($re) {
				while ($row = mysql_fetch_assoc($re)) {
                    $row['link_edit'] = '?page='.Url::get('page').'&act=edit&id='.base64_encode('user_admin_'.$row['id']);
					$items[$row['id']] = $row;
				}
			}
		}

        $page_no = Url::get('page_no',1);
		$display->add('paging', $paging);
		$display->add('total_row', $total_row);
		$display->add('items', $items);
        $display->add('is_root', (User::is_root())? 1: 0);
		$display->add('page', Url::get('page'));
		$display->add('stt', ($page_no-1)*CGlobal::$number_per_page);

		//common
		$display->add('title_page', 'Quản trị Users');
        $display->add('hover', EnBacLib::mouse_hover(COLOR_MOUSE_HOVER, true));
		$display->add('search',	$this->search);
		$display->output('List');
		$this->endForm();
	}
}
?>