<?php
class BMPaging {
	
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
	 * @param $callback: Function callback: QuynhTM bo xung ngay 24/05/2010
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