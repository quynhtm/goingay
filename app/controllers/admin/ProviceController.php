<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

class ProviceController extends BaseAdminController{
	
	private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
	private $error = '';
	public function __construct(){
		parent::__construct();
		FunctionLib::site_js('backend/js/admin.js', CGlobal::$POS_HEAD);
	}
	public function listView(){
		$this->header();
		$Meta = array('title'=>'Provice',);
		foreach($Meta as $key=>$val){
			$this->layout->$key = $val;
		}
		//Config Page
		$pageNo = (int) Request::get('page', 1);
		$pageScroll = CGlobal::num_scroll_page;
		$limit = CGlobal::number_limit_show;
		$offset = $stt = ($pageNo - 1) * $limit;
		$search = $data = array();
		$total = 0;
		
		$search['provice_title'] = addslashes(Request::get('provice_title', ''));
		$search['provice_status'] = (int)Request::get('provice_status', -1);
		$search['field_get'] = '';
		
		$data = Provice::searchByCondition($search, $limit, $offset, $total);
		$paging = $total > 0 ? Pagging::getNewPager($pageScroll, $pageNo, $total, $limit, $search) : '';
		
		$optionStatus = FunctionLib::getOption($this->arrStatus, $search['provice_status']);
		$messages = FunctionLib::messages('messages');
		
		$this->layout->content = View::make('admin.provice.list')
								->with('stt', $stt)
								->with('data', $data)
								->with('total', $total)
								->with('paging', $paging)
								->with('arrStatus', $this->arrStatus)
								->with('optionStatus', $optionStatus)
								->with('search', $search)
								->with('messages', $messages);
	}
	public function getItem($id=0){
		$this->header();
		$Meta = array('title'=>'Provice',);
		foreach($Meta as $key=>$val){
			$this->layout->$key = $val;
		}
		$data = array();
		if($id > 0) {
			$data = Provice::getById($id);
		}
		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['provice_status'])? $data['provice_status'] : CGlobal::status_show);
		$this->layout->content = View::make('admin.provice.add')
								->with('id', $id)
								->with('data', $data)
								->with('optionStatus', $optionStatus)
								->with('error', $this->error);
	}
	public function postItem($id=0){
		$this->header();
		$Meta = array('title'=>'Provice',);
		foreach($Meta as $key=>$val){
			$this->layout->$key = $val;
		}
		
		$id_hiden = (int)Request::get('id_hiden', 0);
		$data = array();
		
		$dataSave = array(
				'provice_title'=>array('value'=>addslashes(Request::get('provice_title')), 'require'=>1, 'messages'=>'Tiêu đề không được trống!'),
				'provice_order_no'=>array('value'=>(int)addslashes(Request::get('provice_order_no')),'require'=>0),
				'provice_status'=>array('value'=>(int)Request::get('provice_status', -1),'require'=>0),
				'provice_created'=>array('value'=>time()),
		);
		
		if($id > 0){
			unset($dataSave['provice_created']);
		}
		
		$this->error = ValidForm::validInputData($dataSave);
		if($this->error == ''){
			$id = ($id == 0) ? $id_hiden : $id;
			Provice::saveData($id, $dataSave);
			return Redirect::route('admin.provice');
		}else{
			foreach($dataSave as $key=>$val){
				$data[$key] = $val['value'];
			}
		}
		
		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['provice_status'])? $data['provice_status'] : -1);
		$this->layout->content = View::make('admin.provice.add')
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
					Trash::addItem($id, 'Provice', '', 'provice_id', 'provice_title', '', '');
					Provice::deleteId($id);
				}
				FunctionLib::messages('messages', 'Xóa thành công!', 'success');
			}
		}
		return Redirect::route('admin.provice');
	}
}