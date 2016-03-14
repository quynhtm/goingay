<?php
class Pagging
{
    // phan trang dùng cho Boostrap
    public static function getNewPager(&$limit,$numPageShow = 10, $page = 1,$total = 1,$itemperpage = 1,$dataSearch, $page_name = 'page_no'){
        $total_page = ceil($total/$itemperpage);
        if($total_page == 1) return '';
        $next = '';
        $last = '';
        $prev = '';
        $first= '';
        $left_dot  = '';
        $right_dot = '';
        $from_page = $page - $numPageShow;
        $to_page = $page + $numPageShow;

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
        //limit
        if (Url::get($page_name)){
            $currentpage= Url::get($page_name);
        }
        else{
            $currentpage= 1;
        }
        $currentpage=round($currentpage);
        if($currentpage<=0 ||$currentpage>$total_page)
        {
            $currentpage=1;
        }
        $limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.$itemperpage;

        if($to_page < $total_page)	{
            $right_dot = '<li><span>...</span></li>';
        }else{
            $to_page = $total_page;
        }
        $pagerHtml = '';
        for($i=$from_page;$i<=$to_page;$i++){
            $pagerHtml .= self::parseNewLink($i, (($page == $i) ? 'active' : ''), $i, $page_name,$dataSearch);
        }
        return '<ul class="pagination">'.$first.$prev.$left_dot.$pagerHtml.$right_dot.$next.$last.'</ul>';
    }

    static function parseNewLink($page = 1, $class="", $title="", $page_name = 'page_no',$dataSearch){
        $paramSearch = self::buildParams("&", $dataSearch);
        $url_path = Url::build_all(array($page_name));
        $param[$page_name] = $page;
        if($class == 'active'){
            return '<li class="'.$class.'"><a href="#" title="xem trang '.$title.'">'.$title.'</a></li>';
        }
        return '<li class="'.$class.'"><a href="'.$url_path.'&'.$paramSearch.'" title="xem trang '.$title.'">'.$title.'</a></li>';
    }

    static function buildParams($pices = '&', $data) {
        $result = "";
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $result .= $k . '=' . urlencode($v) . $pices;
            }
        }
        if ($result != '') {
            $result = substr($result, 0, -1);
        }
        return $result;
    }

}
