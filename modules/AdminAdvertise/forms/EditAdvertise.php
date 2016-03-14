<?php
/**
 * 
 ** @author ManhQuynh-VCC
 *
 */
class EditAdvertiseForm extends Form {
	private $pages = array ();
	function EditAdvertiseForm() {
		Form::Form ( 'EditAdvertiseForm' );
		if (Url::get ( 'cmd' ) == 'edit') {
			$id = ( int ) Url::get ( 'id' );
			if ($id) {
				$this->pages = DB::select ( 'sim_adver', 'id=' . $id );
			}
			if (! $this->pages)
			Url::redirect_current ();
		} else {
			$this->pages = array ('title' => '', 'image' => '', 'status' => '', 'image' => '', 'link_view' => '','order_item' => '','position' => '');
		}
	}

	function on_submit() {
		$new_row = array();
		$name_baner =  Url::tget ( 'name_banner' ) ;
		$link_detail =  Url::tget ( 'link_view_product','' ) ;
		$status =  Url::tget ( 'status',0 ) ;
		$position = Url::tget ( 'position',0) ;
		$order_item = Url::tget ( 'order_item',0) ;

		if (! $this->errNum) {
			$new_row = array ('title' => $name_baner,
							'link_view' => $link_detail,			
							'status' => $status,
							'order_item' => $order_item,
							'position' => $position );

			if (Url::get ( 'cmd' ) != 'edit') {
				$new_row['time'] = TIME_NOW;
				$id = DB::insert ( 'sim_adver', $new_row );
			}else{
				$id = $this->pages['id'];
			}
			if(isset($_FILES['image_product']['tmp_name'])AND(!empty($_FILES['image_product']['tmp_name']))){
				$aryError = array();
				$old_file =(Url::get ( 'cmd' ) != 'edit') ? '' : $this->pages['image'];
				$file_name = SvImg::uploadImages($_FILES['image_product']['tmp_name'], $_FILES['image_product']['name'], $old_file, CGlobal::$adv_image_sizes, $aryError, $id, SvImg::FOLDER_AVATAR);
				if($file_name != '' && empty($aryError)) {
					$new_row['image'] = $file_name;
				}
			}
			DB::update ( 'sim_adver', $new_row, 'id='. $id);
			Url::redirect_current ();
		}
	}
	function draw() {
		global $display;
		$this->beginForm ( true );
		if (Url::get ( 'cmd' ) == 'edit')
		$display->add ( 'mode', "Sửa " );
		else
		$display->add ( 'mode', "Thêm " );
		$display->add ( 'msg', $this->showFormErrorMessages ( 1 ) ); //thong bao loi khi co
		
		$banner_id = (int)Url::get('id',0);
		$display->add('id', $banner_id);

		//option status
		$arrStatus= array(2 => '-- Chọn Ẩn/hiện --',1 => 'Hiện', 0 => "Ẩn");
		$optionStatus= EnbacLib::getOption($arrStatus, (isset($this->pages ['status'])?$this->pages ['status']:2));
		$display->add('optionStatus',$optionStatus);
		
		//radio posotion
		$arrRadioPosition= CGlobal::$arrRadioPosition;
		$radioPosition= EnbacLib::getRadioList('position', $arrRadioPosition,(isset($this->pages ['position'])?$this->pages ['position']:1));
		$display->add('radioPosition',$radioPosition);
			
		//name banner
		/*$editor_name = getEditor('name_banner', Url::get ( 'name_banner', $this->pages ['name_baner'] ));
		$display->add('editor_name_banner',$editor_name)*/;

		if (Url::get ( 'cmd' ) == 'edit'){
			$display->add ( 'name_banner', Url::get ( 'name_banner', $this->pages ['title'] ) );
			$display->add ( 'order_item', Url::get ( 'order_item', $this->pages ['order_item'] ) );
		
			$display->add ( 'link_detail', Url::get ( 'link_view_product', $this->pages ['link_view'] ) );
			$display->add ( 'position', Url::get ( 'position', $this->pages ['position'] ) );
			$display->add ( 'position_deff', Url::get ( 'position', $this->pages ['position'] ) );//hide khi sua, de xoa cache vi tri cu
			
			$images = SvImg::getAllImages( $this->pages ['image'], CGlobal::$adv_image_sizes,  $this->pages ['id'], SvImg::FOLDER_AVATAR, OPT_GET_IMAGE);
			$display->add ( 'image_product', Url::get ( 'image_product',(!empty($images))? $images[40]:'') );
			$display->add ( 'image_product_src',(!empty($images))? $images[40]:'');
			
		}
		$display->add('page',Url::get('page'));
		$display->output ( 'EditAdvertise' ); // hien thi template
		$this->endForm ();
	}
}
?>