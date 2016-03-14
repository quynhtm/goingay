<?php
class SiteDetailNewRightForm extends Form{
	function __construct(){
		Form::Form('SiteDetailNewRightForm');
        //$this->link_js('javascripts/jquery/jquery.js');
	}
	
	function draw(){
		global $display;
		//tin tức mới
		$id = (int) Url::get('new_id', 0);
		$cond = 'status = 1';
		if ($id > 0) {
			$cond .= ' AND id<>' . $id;
		}
		$sql = "SELECT id,name,images,create_time,description FROM ".TABLE_NEWS." WHERE " . $cond . " order by id DESC limit 0,15";
		$res = DB::query($sql);
		$aryNews = array();
		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$row['images_80'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_NEWS,80,80);
                $row['view_news'] = Url::build('detail_news', array('new_id' => $row['id'], 'title' => safe_title($row['name'])));
                $row['name'] = SvLib::word_limit($row['name'],8);
                $row['description'] = SvLib::word_limit($row['description'],10);
                $aryNews[] = $row;
			}
		}
		$display->add('aryNews', $aryNews);
		//banner quang cao
		$banner = array();
		$banner = SvLib::getResultBanner();
		$display->add('banner_right', $banner);

		$display->output("SiteDetailNewRight");
	}
}