<?php
/**
 * 
 ** @author ManhQuynh-VCC
 *
 */
class ListAdvertiseForm extends Form
{
	function ListAdvertiseForm(){
		Form::Form('ListAdvertiseForm');
	}

function draw(){
		global $display;
		$this->beginForm(false,'post',false,Url::build_current());
		$position	=Url::get('position',0);
		$arrRadioPosition= CGlobal::$arrRadioPosition;
		$cond = '';
		if($position> 0){
			$cond .= ' WHERE position ='.$position;
		}

		$item_per_page = 24;
		$total_row = DB::fetch('SELECT count(*) AS total_row FROM `sim_adver` '.$cond.' LIMIT 0,1','total_row',0);
		
		$items = array();
		$paging = '';
		if($total_row){
			$limit='';
			$paging = '';
			$paging=EBPagging::pagingSE($limit,$total_row,$item_per_page,10,'page_no',true);
			$sql='SELECT  * FROM  `sim_adver`'.$cond.' ORDER BY order_item ASC '.$limit;
			$re=DB::query($sql);
			if($re){
				while ($row=mysql_fetch_assoc($re)){
					$images = SvImg::getAllImages($row['image'], CGlobal::$adv_image_sizes, $row['id'], SvImg::FOLDER_AVATAR, OPT_GET_IMAGE);
					if(!empty($images)) {
						$row ['image'] = $images[40];
					}
					$row['name_position'] = $arrRadioPosition[$row['position']];
					$items[$row['id']] = $row;
				}
			}
		}
		$optionPosition= EnbacLib::getOption(array(0 => '-- Chọn Vị trí --')+$arrRadioPosition,$position);
		$display->add('optionPosition',$optionPosition);
	
		$display->add('paging',$paging);		
		$display->add('items',$items);	
		$display->add('page',Url::get('page'));	
		$display->add('hover',EnBacLib::mouse_hover('#E2F1DF',true));

        $display->add('title_page', 'Quản trị quảng cáo');
		$display->output('ListAdvertise');
		$this->endForm();
	}
}
?>