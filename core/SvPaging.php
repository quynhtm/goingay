<?php
class SvPaging {

    // phan trang dùng cho Boostrap
    public static function getNewPager(&$limit,$numPageShow = 10, $page = 1,$total = 1,$item_per_page = 1,$dataSearch, $page_name = 'page_no'){
        $total_page = ceil($total/$item_per_page);
        if($total_page == 1) return '';
        $next = '';
        $last = '';
        $prev = '';
        $first= '';
        $left_dot  = '';
        $right_dot = '';
        $from_page = $page - $numPageShow;
        $to_page = $page + $numPageShow;
        $limit = ' LIMIT '.(($page -1)*$item_per_page).','.$item_per_page.'';

        //get prev & first link
        if($page > 1){
            $prev = self::parseNewLink($page-1, '', "&lt; Trước", $page_name,$dataSearch);
            $first= self::parseNewLink(1, '', "&laquo; Đầu", $page_name,$dataSearch);
        }
        //get next & last link
        if($page < $total_page){
            $next = self::parseNewLink($page+1, '', "Sau &gt;", $page_name,$dataSearch);
            $last = self::parseNewLink($total_page, '', "Cuối &raquo;", $page_name,$dataSearch);
        }
        //get dots & from_page & to_page
        if($from_page > 0)	{
            $left_dot = ($from_page > 1) ? '<li><span>...</span></li>' : '';
        }else{
            $from_page = 1;
        }

        if($to_page < $total_page)	{
            $right_dot = '<li><span>...</span></li>';
        }else{
            $to_page = $total_page;
        }
        $pagerHtml = '';
        for($i=$from_page;$i<=$to_page;$i++){
            $pagerHtml .= self::parseNewLink($i, (($page == $i) ? 'active' : ''), $i, $page_name,$dataSearch);
        }
        $html_msg = '<li><span style="border: none; background: #ffffff!important; color: #000000!important;"><b>Tổng số: '.$total.' items</b></span></li>';
        return '<ul class="pagination">'.$html_msg.$first.$prev.$left_dot.$pagerHtml.$right_dot.$next.$last.'</ul>';
    }
    static function parseNewLink($page = 1, $class="", $title="", $page_name = 'page_no',$dataSearch){
        $param = $dataSearch;
        $pageCurrent = EnBac::$page['name'];
        $param[$page_name] = $page;
        if($class == 'active'){
            return '<li class="'.$class.'"><a href="#" title="xem trang '.$title.'">'.$title.'</a></li>';
        }
        return '<li class="'.$class.'"><a href="'.Url::build($pageCurrent,$param).'" title="xem trang '.$title.'">'.$title.'</a></li>';
    }

    static function pagingSE(&$limit = false, $totalitem, $itemperpage, $numpageshow = 10, $page_name = 'page_no', $show_total_item = false,$itemname='',$page_label = '', $mod = false){
		$st = '';
		$totalpage = ceil($totalitem / $itemperpage);
		if ($totalpage < 2){
			if($show_total_item){
				return '<b>Tổng số '.$totalitem.'</b> '.$itemname;
			}
			return;
		}

		if (Url::get($page_name)){
			$currentpage= Url::get($page_name);
		}
		else{
			$currentpage= 1;
		}

		$currentpage=round($currentpage);
		if($currentpage<=0 ||$currentpage>$totalpage)
		{
			$currentpage=1;
		}

		$limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.$itemperpage;

		if($currentpage>($numpageshow/2)){
			$startpage = $currentpage-floor($numpageshow/2);
			if($totalpage-$startpage<$numpageshow){
				$startpage=$totalpage-$numpageshow+1;
			}
		}
		else{
			$startpage=1;
		}
		if($startpage<1){
			$startpage=1;
		}

		$url_path = Url::build_all(array($page_name));

		//Trang hien thoi
		$st .= ''.($show_total_item?'<b>Tổng số '.$totalitem.' '.$itemname.'</b> | ':'').''.$page_label.' ';
		//Link den trang truoc
		if($currentpage>1){
			$st .= '<a href="'.$url_path.'&'.$page_name.'='.($currentpage-1).'" class="pgPrev">';
			$st .= 'Trước</a>';
		}

		//Danh sach cac trang
		$st .= '';

		if($startpage>1){
			//$st .= '<a href="'.$url_path.'&'.$page_name.'='.$currentpage.'" id="pgNext">';
			$st .= '<a  href="'.$url_path.'">1</a> ';
			if($startpage>2){
				$st .= '<strong>...</strong>';//
			}
		}

		for($i=$startpage; $i<=$startpage+$numpageshow-1&&$i<=$totalpage; $i++){
			if($i!=$startpage){
				$st .= '';//
			}
			if($i==$currentpage){
				if($i>1)
				{
					$st .='';
				}
				$st .= '<a href="javascript:void(0)" class="current-page" id="pgCurrent">'.$i.'</a>';
			}
			else{
				if($i>1)
				{
					$st .='';
				}
				$st .= '<a  href="'.$url_path.'&'.$page_name.'='.$i.'">'.$i.'</a> ';
			}
		}

		if($i==$totalpage){
			$st .= '<a  href="'.$url_path.'&'.$page_name.'='.$totalpage.'">'.$totalpage.'</a> ';
		}
		else
		if($i<$totalpage){
			$st .= '<strong>...</strong><a  href="'.$url_path.'&'.$page_name.'='.$totalpage.'">'.$totalpage.'</a> ';
		}
		$st .= '';
		//Trang sau
		if($currentpage<$totalpage){
			$st .= '<a  href="'.$url_path.'&'.$page_name.'='.($currentpage+1).'" class="pgPrev">';
			$st .= 'Sau</a>';
		}

		$st .= '';

		return $st;
	}
	
	/**
	 *paging for Boxmobile
	 *@param $st: data phân trang trả về dưới dạng reference
	 *@param $limit: Thành phần trả về dưới dạng reference để nhúng vào câu sql
	 *$param $totalitem: Tổng số bản ghi
	 *@param $itemperpage: Số bản ghi hiện thị trên 1 trang
	 *@param $numpageshow: Số trang hiển thị
	 *@param $page_name: Param truyền trên URL để lấy trang hiện thời (mặc định là page_no)
	 *
	 *@return $st và $limit dưới dạng reference
	 */
	static function paging(&$st, &$limit,$totalitem,$itemperpage, $numpageshow=10, $page_name='page_no', $extend = ''){
		
		$totalpage = ceil($totalitem/$itemperpage);
		if ($totalpage<2){
			return;
		}
		$st = '<div class="pager float_right">';
		$currentpage= (Url::check($page_name))?Url::get($page_name):1;
		$currentpage = ($currentpage<=0 ||$currentpage>$totalpage)?1:$currentpage;
		
		$limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.$itemperpage;

		if($currentpage>($numpageshow/2)){
			$startpage = $currentpage-floor($numpageshow/2);
			if($totalpage-$startpage<$numpageshow){
				$startpage=$totalpage-$numpageshow+1;
			}
			$startpage = ($startpage<1) ? 1 : $startpage;
		}
		else{
			$startpage=1;
		}
		$url_path = Url::build_all(array($page_name)).$extend;

		//Trang hien thoi
		$st .= '<div class="page_current">Trang '.$currentpage.'/'. $totalpage.'</div><div class="page_items">';
		//Link den trang truoc
		if($currentpage>1){
			//link den trang dau tien
			$st .='<a class="page_item page_first" href="'.$url_path.'&'.$page_name.'=1" title="Xem trang đầu tiên"></a>';
			
			$st .= '<a href="'.$url_path.'&'.$page_name.'='.($currentpage-1).'" class="page_item page_prev" title="Xem trang trước"></a>';
		}

		//Danh sach cac trang
		$st .= '';

		if($startpage>1){
			//$st .= '<a href="'.$url_path.'&'.$page_name.'='.$currentpage.'" id="pgNext">';
			$st .= '<a  href="'.$url_path.'">1</a> ';
			if($startpage>2){
				$st .= '<span class="page_item">...</span>';//
			}
		}

		for($i=$startpage; $i<=$startpage+$numpageshow-1&&$i<=$totalpage; $i++){
			if($i!=$startpage){
				$st .= '';//
			}
			if($i==$currentpage){
				if($i>1)
				{
					$st .='';
				}
				$st .= '<a href="javascript:void(0)" class="page_item page_item_active">'.$i.'</a>';
			}
			else{
				if($i>1)
				{
					$st .='';
				}
				$st .= '<a  class="page_item"  href="'.$url_path.'&'.$page_name.'='.$i.'" title="Xem trang '.$i.'">'.$i.'</a> ';
			}
		}

		if($i==$totalpage){
			$st .= '<a  class="page_item"   href="'.$url_path.'&'.$page_name.'='.$totalpage.'">'.$totalpage.'</a> ';
		}
		else
		if($i<$totalpage){
			$st .= '<span class="page_item">...</span><a class="page_item"  href="'.$url_path.'&'.$page_name.'='.$totalpage.'">'.$totalpage.'</a> ';
		}
		$st .= '';
		//Trang sau
		if($currentpage<$totalpage){
			$st .= '<a  href="'.$url_path.'&'.$page_name.'='.($currentpage+1).'" class="page_item page_next" title="Xem trang tiếp theo"></a>';
			//trang cuoi cung
			$st .='<a class="page_item page_last" href="'.$url_path.'&'.$page_name.'='.$totalpage.'" title="Xem trang cuối"></a>';
		}
		
		$st .= '</div><div class="clear"></div></div>';
		return;
	}
	
	

	/**
	 * function paging ajax
	 * @param $st
	 * @param $limit
	 * @param $totalitem
	 * @param $itemperpage
	 * @param $numpageshow
	 * @param $page_name
	 * @param $show_current_page
	 * @param $url_path
	 * @param $div_id
	 * @param $callback: Function callback:
	 * @return unknown_type
	 */
	static function AjaxPaging(&$st, &$limit = '', $totalitem, $itemperpage, $numpageshow = 10, $page_name = 'page_no', $show_current_page = false, $url_path = '', $div_id = '', $callback = 'undefined', $returnDataType = 'text') {
		
		$totalpage = ceil ( $totalitem / $itemperpage );
		if ($totalpage < 2) {
			return;
		}
		$st = '<div class="pager float_right">';
		if (Url::get ( $page_name )) {
			$currentpage = Url::get ( $page_name );
		} else {
			$currentpage = 1;
		}
		
		$currentpage = round ( $currentpage );
		if ($currentpage <= 0 || $currentpage > $totalpage) {
			$currentpage = 1;
		}
		
		$limit = ' LIMIT ' . (($currentpage - 1) * $itemperpage) . ',' . $itemperpage;
		
		if ($currentpage > ($numpageshow / 2)) {
			$startpage = $currentpage - floor ( $numpageshow / 2 );
			if ($totalpage - $startpage < $numpageshow) {
				$startpage = $totalpage - $numpageshow + 1;
			}
		} else {
			$startpage = 1;
		}
		if ($startpage < 1) {
			$startpage = 1;
		}
		
		if ($url_path != '')
			$url_path .= '&' . $page_name . '=';
		else
			$url_path = '?' . $page_name . '=';
			
		//Trang hien thoi
		$st .= ($show_current_page) ? "<div class='page_current'>Trang $currentpage/$totalpage</div>" : '';
		
		//Link den trang truoc
		if ($currentpage > 1) {
			
			$st .= '<a href="javascript:void(0);" class="page_item page_prev" onclick="Bm.ajax_paging(\'' . $url_path . ($currentpage - 1) . '\',\'' . $div_id . '\',\'' . $url_path . $currentpage . '\', ' . $callback . ',\'' . $returnDataType . '\'); return false;"></a>';
		
		}
		
		//Danh sach cac trang
		

		if ($startpage > 1) {
			$st .= '<a class="page_item"  href="javascript:void(0);" onclick = "Bm.ajax_paging(\'' . $url_path . '1\',\'' . $div_id . '\',\'' . $url_path . $currentpage . '\', ' . $callback . ',\'' . $returnDataType . '\'); return false;">1</a> ';
			if ($startpage > 2) {
				$st .= '<span class="page_item">...</span>'; //
			}
		}
		
		for($i = $startpage; $i <= $startpage + $numpageshow - 1 && $i <= $totalpage; $i ++) {
			if ($i == $currentpage) {
				$st .= '<a href="javascript:void(0)" class="page_item page_item_active">' . $i . '</a>';
			} else {
				$st .= '<a  class="page_item"  href="javascript:void(0);" onclick = "Bm.ajax_paging(\'' . $url_path . $i . '\',\'' . $div_id . '\',\'' . $url_path . $currentpage . '\', ' . $callback . ',\'' . $returnDataType . '\'); return false;">' . $i . '</a> ';
			
			}
		}
		
		if ($i == $totalpage) {
			$st .= '<a  class="page_item"   href="javascript:void(0);" onclick = "Bm.ajax_paging(\'' . $url_path . $totalpage . '\',\'' . $div_id . '\',\'' . $url_path . $currentpage . '\', ' . $callback . ',\'' . $returnDataType . '\'); return false;">' . $totalpage . '</a> ';
		} elseif ($i < $totalpage) {
			$st .= '<span class="page_item">...</span><a class="page_item"  href="javascript:void(0);" onclick = "Bm.ajax_paging(\'' . $url_path . $totalpage . '\',\'' . $div_id . '\',\'' . $url_path . $currentpage . '\', ' . $callback . ',\'' . $returnDataType . '\'); return false;">' . $totalpage . '</a> ';
		}
		$st .= '';
		//Trang sau
		if ($currentpage < $totalpage) {
			$st .= '<a  href="javascript:void(0);" class="page_item page_next" onclick="Bm.ajax_paging(\'' . $url_path . ($currentpage + 1) . '\',\'' . $div_id . '\',\'' . $url_path . $currentpage . '\', ' . $callback . ',\'' . $returnDataType . '\'); return false;"></a>';
		}
		
		$st .= '</div><div class="clear"></div></div>';
		return;
	}
	
	
	
	/**
	 * paging template for 
	 * 
	 *@param $st: data phân trang trả về dưới dạng reference
	 *@param $limit: Thành phần trả về dưới dạng reference để nhúng vào câu sql
	 *$param $totalitem: Tổng số bản ghi
	 *@param $itemperpage: Số bản ghi hiện thị trên 1 trang
	 *@param $numpageshow: Số trang hiển thị
	 *@param $page_name: Param truyền trên URL để lấy trang hiện thời (mặc định là page_no)
	 *@param $show_current_page 
	 *@param $url_path : Dia chi url 
	 *@param $funcPagingJS : function Js goi trong method này
	 *
	 *@return $st và $limit dưới dạng reference
	 */
	static function AjaxPagingTemplate(&$st, &$limit='', $totalitem, $itemperpage, $numpageshow = 10, $page_name = 'page_no', $show_current_page = false, $url_path = '', $funcPagingJS){
		$totalpage = ceil($totalitem / $itemperpage);
		if ($totalpage < 2){
			return;
		}
		$st = '<div class="pager float_right">';
		
		$currentpage = Url::get($page_name) ? Url::get($page_name) : 1;
		$currentpage = round($currentpage);
		if($currentpage <= 0 || $currentpage > $totalpage){
			$currentpage = 1;
		}

		$limit=' LIMIT '.(($currentpage - 1) * $itemperpage) . ',' . $itemperpage;

		if($currentpage >($numpageshow / 2)){
			$startpage = $currentpage - floor($numpageshow / 2);
			if($totalpage - $startpage < $numpageshow){
				$startpage = $totalpage - $numpageshow + 1;
			}
		}
		else {
			$startpage = 1;
		}
		if($startpage < 1){
			$startpage = 1;
		}
		
		$url_path .= ($url_path != '') ? '&'.$page_name.'=' : '?'.$page_name.'=';
		
		//Trang hien thoi
		$st .= ($show_current_page) ? "<div class='page_current'>Trang $currentpage / $totalpage</div>" : '' ;
		
		//Link den trang truoc
		if($currentpage > 1){
			$st .= '<a href="javascript:void(0);" class="page_item page_prev" onclick="'.$funcPagingJS.'(\''.$url_path.($currentpage-1).'\'); return false;"></a>';
		
		}
		
		//Danh sach cac trang
		
		if($startpage>1){
			$st .= '<a class="page_item"  href="javascript:void(0);" onclick = "'.$funcPagingJS.'(\''.$url_path.'1\'); return false;">1</a> ';
			if($startpage>2){
				$st .= '<span class="page_item">...</span>';//
			}
		}

		for($i = $startpage; $i <= $startpage + $numpageshow - 1 && $i <= $totalpage; $i++){
			if($i == $currentpage){
				$st .= '<a href="javascript:void(0)" class="page_item page_item_active">'.$i.'</a>';
			}
			else{
				$st .= '<a  class="page_item"  href="javascript:void(0);" onclick = "'.$funcPagingJS.'(\''.$url_path.$i.'\'); return false;">'.$i.'</a> ';
			}
		}
		
		if($i==$totalpage){
			$st .= '<a  class="page_item"   href="javascript:void(0);" onclick = "'.$funcPagingJS.'(\''.$url_path.$totalpage.'\'); return false;">'.$totalpage.'</a> ';
		}
		elseif($i<$totalpage){
			$st .= '<span class="page_item">...</span><a class="page_item"  href="javascript:void(0);" onclick = "'.$funcPagingJS.'(\''.$url_path.$totalpage.'\'); return false;">'.$totalpage.'</a> ';
		}
		$st .= '';
		//Trang sau
		if($currentpage<$totalpage){
			$st .= '<a  href="javascript:void(0);" class="page_item page_next" onclick="'.$funcPagingJS.'(\''.$url_path.($currentpage+1).'\'); return false;"></a>';
		}

		$st .= '</div><div class="clear"></div></div>';
		return;
	}
}