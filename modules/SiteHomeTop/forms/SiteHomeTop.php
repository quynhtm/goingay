<?php
class SiteHomeTopForm extends Form{
	function __construct(){
		Form::Form('SiteHomeTopForm');
		$this->link_css('style/site_css/style_home_slider.css');
		$this->link_js('javascripts/slidershow/jquery-1.3.2.min.js');
		$this->link_js('javascripts/slidershow/jquery-ui-1.7.2.custom.min.js');
	}
	
	function draw(){
		global $display;
		//tin tức chung mới
        $cond = 'status = 1 AND cat_new_id = '.CGlobal::TIN_TUC_CHUNG;
		$sql = "SELECT id,name,images,create_time,description FROM ".TABLE_NEWS." WHERE " . $cond . " order by id DESC limit 0,5";
		$res = DB::query($sql);
		$aryNews = array();
		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
                $row ['images_small'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_NEWS,80,80);
                $row ['images_big'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_NEWS,450,450);

				$row['view_news'] = Url::build('detail_news', array('new_id' => $row['id'], 'title' => FunctionLib::safe_title($row['name'])));
				$row['title_cut'] = SvLib::word_limit($row['name'],10);
				$row['description_cut'] = SvLib::word_limit($row['description'],40);
				$aryNews[] = $row;
			}
		}

        $display->add('src_img_adv_1', STATIC_URL.'flash/website/batdongsanhungvuong.gif');
        $display->add('src_img_adv_2', STATIC_URL.'flash/website/image_adv.jpg');
        $display->add('aryNews', $aryNews);
		$display->output("HomeTop");
	}
}
