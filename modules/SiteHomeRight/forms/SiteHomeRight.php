<?php
class SiteHomeRightForm extends Form{
	function __construct(){
		Form::Form('SiteHomeRightForm');
        $this->link_js('javascripts/jquery/jquery.js');
        $this->link_js('javascripts/jquery/skype-uri.js');
	}
	
	function draw(){
		global $display;
        //sản phẩm nổi bật
        //tin tức làng nghề
        $cond = 'status = 1 AND cat_new_id = '.CGlobal::TIN_NOI_BAT;
        $sql = "SELECT id,name,images,create_time,description FROM ".TABLE_NEWS." WHERE " . $cond . " order by id DESC limit 0,15";
        $res = DB::query($sql);
        $newsNewNoibat = array();
        if ($res) {
            while ($row = mysql_fetch_assoc($res)) {
                $row['images_80'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_NEWS,80,80);
                $row['view_news'] = Url::build('detail_news', array('new_id' => $row['id'], 'title' => FunctionLib::safe_title($row['name'])));
                $row['description'] = SvLib::word_limit($row['description'],10);
                $row['title_cut'] = SvLib::word_limit($row['name'],6);
                $newsNewNoibat[] = $row;
            }
        }

		$display->add('newsNewNoibat', $newsNewNoibat);
		//banner quang cao
		$banner = array();
		$banner = SvLib::getResultBanner(CGlobal::POSITION_RIGHT);
		$display->add('banner_right', $banner);
		$display->output("SiteHomeRight");
	}
}