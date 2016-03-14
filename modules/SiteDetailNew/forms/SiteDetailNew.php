<?php

class SiteDetailNewForm extends Form {
	private $news = array();
	function __construct() {
		Form::Form('SiteDetailNewForm');
		$id = (int) Url::get('new_id',0);
		if ($id > 0) { //edit
			$this->news = News::getNewsById($id);
			if ($this->news){
				if(News::checkNewsActionById($this->news['id']) == true){
					Url::redirect('home');
				}
			}else{
				Url::redirect('home');
			}
		}else{
			Url::redirect('home');
		}
	}
	function draw() {
		global $display;
		if (!empty($this->news)) {
			$new = $this->news;
			$new['images_show'] = SvImg::getThumbImage($new['images'],$new['id'],SvImg::FOLDER_NEWS);
			$new['view'] = Url::build('detail_news', array('new_id' => $new['id'], 'title' => safe_title($new['name'])));
			$display->add('new', $new);

			//cùng loại
			if ($new['cat_new_id'] > 0 && $new['id'] > 0) {
				$cond2 = " status = 1 AND cat_new_id=" . $new['cat_new_id'] . " AND id <>" . $new['id'] . " ORDER BY id DESC limit 0,9";
				$sql = "SELECT id,name FROM ".TABLE_NEWS." WHERE " . $cond2;
				$res = DB::query($sql);
				$aryItemPro = array();
				if ($res) {
					while ($row = mysql_fetch_assoc($res)) {
						$row['view'] = Url::build('detail_news', array('new_id' => $row['id'], 'title' => safe_title($row['name'])));
						$aryItemPro[] = $row;
					}
				}
				$display->add('item_pro', $aryItemPro);
			}

		}
		$display->output("SiteDetailNew");
	}
}