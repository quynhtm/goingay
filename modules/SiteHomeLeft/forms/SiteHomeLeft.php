<?php
class SiteHomeLeftForm extends Form{
	function __construct(){
		Form::Form('SiteHomeLeftForm');
	}
	function draw(){
		global $display;
        $aryNews = array();

        //tin tức chung mới
        $cond = 'status = 1 AND cat_new_id = '.CGlobal::TIN_TUC_CHUNG;
        $sql = "SELECT id,name,images,create_time,description FROM ".TABLE_NEWS." WHERE " . $cond . " order by id DESC limit 6,7";
        $res = DB::query($sql);
        if ($res) {
            while ($row = mysql_fetch_assoc($res)) {
                $row['images_150'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_NEWS,150,150);
                $row['view_news'] = Url::build('detail_news', array('new_id' => $row['id'], 'title' => FunctionLib::safe_title($row['name'])));
                $row['description'] = SvLib::word_limit($row['description'],56);
                $aryNews[] = $row;
            }
        }
        $display->add('aryNews', $aryNews);

        //tin tức làng nghề
        $cond2 = 'status = 1 AND cat_new_id = '.CGlobal::TIN_LANG_NGHE;
        $sql2 = "SELECT id,name,images,create_time,description FROM ".TABLE_NEWS." WHERE " . $cond2 . " order by id DESC limit 0,30";
        $res2 = DB::query($sql2);
        $aryNewsLangNghe = array();
        if ($res2) {
            while ($row = mysql_fetch_assoc($res2)) {
                $row['images_80'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_NEWS,80,80);
                $row['view_news'] = Url::build('detail_news', array('new_id' => $row['id'], 'title' => FunctionLib::safe_title($row['name'])));
                $row['description'] = SvLib::word_limit($row['description'],10);
                $row['title_cut'] = SvLib::word_limit($row['name'],6);
                $aryNewsLangNghe[] = $row;
            }
        }
        $display->add('aryNewsLangNghe', $aryNewsLangNghe);

        //banner quang cao
        $banner = array();
        //$banner = SvLib::getResultBanner(CGlobal::POSITION_LEFT);
        $display->add('banner_left', $banner);

		$display->output("SiteHomeLeft");
	}
}