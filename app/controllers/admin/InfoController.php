<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

class InfoController extends BaseAdminController{
	
	private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
	private $error = '';
	public function __construct(){
		parent::__construct();
		FunctionLib::site_js('backend/js/admin.js', CGlobal::$POS_HEAD);
		FunctionLib::site_js('libs/upload/cssUpload.css', CGlobal::$POS_HEAD);
		FunctionLib::site_js('libs/upload/jquery.uploadfile.js', CGlobal::$POS_HEAD);
		FunctionLib::site_js('backend/js/upload-admin.js', CGlobal::$POS_HEAD);
	}
	public function listView(){
		$this->header();
		$Meta = array('title'=>'Info',);
		foreach($Meta as $key=>$val){
			$this->layout->$key = $val;
		}
		//Config Page
		$pageNo = (int) Request::get('page', 1);
		$pageScroll = CGlobal::num_scroll_page;
		$limit = CGlobal::number_limit_show;
		$offset = ($pageNo - 1) * $limit;
		$search = $data = array();
		$total = 0;
		
		$search['info_title'] = addslashes(Request::get('info_title', ''));
		$search['info_status'] = (int)Request::get('info_status', -1);
		$search['field_get'] = '';
		
		$data = Info::searchByCondition($search, $limit, $offset, $total);
		$paging = $total > 0 ? Pagging::getNewPager($pageScroll, $pageNo, $total, $limit, $search) : '';
		
		$optionStatus = FunctionLib::getOption($this->arrStatus, $search['info_status']);
		$messages = FunctionLib::messages('messages');
		
		$this->layout->content = View::make('admin.info.list')
								->with('data', $data)
								->with('total', $total)
								->with('paging', $paging)
								->with('arrStatus', $this->arrStatus)
								->with('optionStatus', $optionStatus)
								->with('search', $search)
								->with('messages', $messages);
	}
	public function getItem($id=0){
		
		FunctionLib::site_js('libs/ckeditor/ckeditor.js', CGlobal::$POS_HEAD);
		
		$this->header();
		$Meta = array('title'=>'Info',);
		foreach($Meta as $key=>$val){
			$this->layout->$key = $val;
		}
		$data = array();
		if($id > 0) {
			$data = Info::getById($id);
		}
		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['info_status'])? $data['info_status'] : CGlobal::status_show);
		$this->layout->content = View::make('admin.info.add')
								->with('id', $id)
								->with('data', $data)
								->with('optionStatus', $optionStatus)
								->with('error', $this->error);
	}
	public function postItem($id=0){
		
		FunctionLib::site_js('libs/ckeditor/ckeditor.js', CGlobal::$POS_HEAD);
		
		$this->header();
		$Meta = array('title'=>'Info',);
		foreach($Meta as $key=>$val){
			$this->layout->$key = $val;
		}
		
		$id_hiden = (int)Request::get('id_hiden', 0);
		$data = array();
		
		$dataSave = array(
				'info_title'=>array('value'=>addslashes(Request::get('info_title')), 'require'=>1, 'messages'=>'Tiêu đề không được trống!'),
				'info_keyword'=>array('value'=>addslashes(Request::get('info_keyword')),'require'=>1, 'messages'=>'Từ khóa không được trống!'),
				'info_intro'=>array('value'=>addslashes(Request::get('info_intro')),'require'=>0),
				'info_content'=>array('value'=>addslashes(Request::get('info_content')),'require'=>0),
				'info_order_no'=>array('value'=>(int)addslashes(Request::get('info_order_no')),'require'=>0),
				'info_created'=>array('value'=>time()),
				'info_status'=>array('value'=>(int)Request::get('info_status', -1),'require'=>0),
				
				'meta_title'=>array('value'=>addslashes(Request::get('meta_title')),'require'=>0),
				'meta_keywords'=>array('value'=>addslashes(Request::get('meta_keywords')),'require'=>0),
				'meta_description'=>array('value'=>addslashes(Request::get('meta_description')),'require'=>0),
		);
		
		if($id > 0){
			unset($dataSave['info_keyword']);
			unset($dataSave['info_created']);
		}
		
		$this->error = ValidForm::validInputData($dataSave);
		if($this->error == ''){
			$id = ($id == 0) ? $id_hiden : $id;
			
			//So Sanh Anh Cu Va Moi, Neu Khac Nhau thi Xoa Anh Cu Di
			if($id > 0){
				$info_img = trim(addslashes(Request::get('img')));
				$info_img_old = trim(addslashes(Request::get('img_old')));
				if($info_img_old !== '' && $info_img !== '' && strcmp ( $info_img_old , $info_img ) != 0){
					$path = Config::get('config.DIR_ROOT').'uploads/'.CGlobal::FOLDER_INFO.'/'.$id;
					if(is_file($path.'/'.$info_img_old)){
						@unlink($path.'/'.$info_img_old);
					}
				}
			}
			
			Info::saveData($id, $dataSave);
			return Redirect::route('admin.info');
		}else{
			foreach($dataSave as $key=>$val){
				$data[$key] = $val['value'];
			}
		}
		
		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['info_status'])? $data['info_status'] : -1);
		$this->layout->content = View::make('admin.info.add')
								->with('id', $id)
								->with('data', $data)
								->with('optionStatus', $optionStatus)
								->with('error', $this->error);
	}
	public function delete(){
		$listId = Request::get('checkItem', array());
		$token = Request::get('_token', '');
		if(Session::token() === $token){
			if(!empty($listId) && is_array($listId)){
				foreach($listId as $id){
					Trash::addItem($id, 'Info', '', 'info_id', 'info_title', '', '');
					Info::deleteId($id);
				}
				FunctionLib::messages('messages', 'Xóa thành công!', 'success');
			}
		}
		return Redirect::route('admin.info');
	}
}