<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

class HosttingController extends BaseAdminController{
	private $permission_view = 'hostting_view';
	private $permission_full = 'hostting_full';
	private $permission_delete = 'hostting_delete';
	private $permission_create = 'hostting_create';
	private $permission_edit = 'hostting_edit';
	private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
	private $arrIsHostting = array(-1 => 'Chọn hostting', CGlobal::status_hide => 'Hostting bên ngoài', CGlobal::status_show => 'Hostting của mình');
	private $error = '';
	public function __construct(){
		parent::__construct();
		//Include javascript.
		FunctionLib::link_js(array(
			//'lib/upload/jquery.uploadfile.js',
			'lib/ckeditor/ckeditor.js',
			'lib/ckeditor/config.js',
			'lib/number/autoNumeric.js',
			'js/common.js',
		));
	}
	public function listView(){
		if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		CGlobal::$pageAdminTitle = "QL Website Hostting | ".CGlobal::web_name;
		//Config Page
		$pageNo = (int) Request::get('page', 1);
		$pageScroll = CGlobal::num_scroll_page;
		$limit = CGlobal::number_limit_show;
		$offset = $stt = ($pageNo - 1) * $limit;
		$search = $dataFilter = $data = array();
		$total = 0;
		
		$search['web_name'] = addslashes(Request::get('web_name', ''));
		$search['web_domain'] = addslashes(Request::get('web_domain', ''));
		$search['web_id'] = (int)Request::get('web_id', '');
		$search['web_status'] = (int)Request::get('web_status', -1);
		$search['web_is_hostting'] = (int)Request::get('web_is_hostting', -1);
		$dataFilter = $search;
		//ngay bat dau
		$from_start_time = Request::get('from_start_time','');
		if($from_start_time != '') {
			$dataFilter['from_start_time'] = $from_start_time;
			$search['from_start_time'] = strtotime($from_start_time);
		}
		$to_start_time = Request::get('to_start_time','');
		if($to_start_time != '') {
			$dataFilter['to_start_time'] = $to_start_time;
			$search['to_start_time'] = strtotime($to_start_time);
		}
		//ngay kết thúc
		$from_end_time = Request::get('from_end_time','');
		if($from_end_time != '') {
			$dataFilter['from_end_time'] = $from_end_time;
			$search['from_end_time'] = strtotime($from_end_time);
		}
		$to_end_time = Request::get('to_end_time','');
		if($to_end_time != '') {
			$dataFilter['to_end_time'] = $to_end_time;
			$search['to_end_time'] = strtotime($to_end_time);
		}

		$data = Hostting::searchByCondition($search, $limit, $offset, $total);
		$paging = $total > 0 ? Pagging::getNewPager($pageScroll, $pageNo, $total, $limit, $dataFilter) : '';
		
		$optionStatus = FunctionLib::getOption($this->arrStatus, $search['web_status']);
		$optionIsHostting = FunctionLib::getOption($this->arrIsHostting, $search['web_is_hostting']);
		$this->layout->content = View::make('admin.Hostting.list')
								->with('stt', $stt)
								->with('data', $data)
								->with('total', $total)
								->with('paging', $paging)
								->with('is_root', $this->is_root)
								->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)
								->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
								->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
								->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
								->with('arrStatus', $this->arrStatus)
								->with('optionStatus', $optionStatus)
								->with('optionIsHostting', $optionIsHostting)
								->with('search', $search);
	}

	public function getItem($id=0) {
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		$data = array();
		if($id > 0) {
			$data = Hostting::getById($id);
			if(!empty($data) && isset($data['web_infor'])){
				if($data['web_infor'] != ''){
					$data['web_infor'] = ($data['web_infor'] != '') ? unserialize($data['web_infor']): array();
				}
			}
		}
		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['web_status'])? $data['web_status'] : CGlobal::status_show);
		$optionIsHostting = FunctionLib::getOption($this->arrIsHostting, isset($data['web_is_hostting'])? $data['web_is_hostting'] : CGlobal::status_show);
		$this->layout->content = View::make('admin.Hostting.add')
			->with('id', $id)
			->with('data', $data)
			->with('optionStatus', $optionStatus)
			->with('optionIsHostting', $optionIsHostting)
			->with('arrStatus', $this->arrStatus);
	}
	public function postItem($id=0) {
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		$dataSave['web_name'] = Request::get('web_name','');
		$dataSave['web_note'] = Request::get('web_note');
		$dataSave['web_domain'] = Request::get('web_domain');
		$dataSave['web_price'] = (int)str_replace('.','',Request::get('web_price'));
		$dataSave['web_status'] = (int)Request::get('web_status', CGlobal::status_show);
		$dataSave['web_is_hostting'] = (int)Request::get('web_is_hostting', CGlobal::status_show);
		$dataSave['web_time_start'] = Request::get('web_time_start','');
		$dataSave['web_time_end'] = Request::get('web_time_end','');

		//thong tin web
		$infor_name = addslashes(Request::get('infor_name'));
		$infor_stand = addslashes(Request::get('infor_stand'));
		$infor_email = addslashes(Request::get('infor_email'));
		$infor_address = addslashes(Request::get('infor_address'));
		$infor_price_domain = (int)str_replace('.','',Request::get('infor_price_domain'));
		$infor_price_host = (int)str_replace('.','',Request::get('infor_price_host'));
		$infor_phone = addslashes(Request::get('infor_phone'));
		$infor_web = array(
			'infor_name' => $infor_name,
			'infor_stand' => $infor_stand,
			'infor_email' => $infor_email,
			'infor_address' => $infor_address,
			'infor_price_domain' => $infor_price_domain,
			'infor_price_host' => $infor_price_host,
			'infor_phone' => $infor_phone);
		$dataSave['web_infor'] = !empty($infor_web)? serialize($infor_web): '';//thông tin web

		$id_hiden = (int)Request::get('id_hiden', 0);
		if($this->valid($dataSave) && empty($this->error)) {
			$id = ($id == 0)?$id_hiden: $id;
			if($dataSave['web_is_hostting'] == CGlobal::status_show){
				if($dataSave['web_time_start'] != '' && $dataSave['web_time_end'] != ''){
					$dataSave['web_time_start'] = strtotime($dataSave['web_time_start'] . ' 00:00:00');
					$dataSave['web_time_end'] = strtotime($dataSave['web_time_end'] . ' 23:59:59');
				}
			}else{
				$dataSave['web_time_start'] = $dataSave['web_time_end'] = 0;
			}

			//FunctionLib::debug($dataSave);
			if($id > 0) {
				//cap nhat
				if(Hostting::updateData($id, $dataSave)) {
					return Redirect::route('admin.hostting');
				}
			} else {
				//them moi
				if(Hostting::addData($dataSave)) {
					return Redirect::route('admin.hostting');
				}
			}
		}

		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['web_status'])? $dataSave['web_status'] : CGlobal::status_show);
		$optionIsHostting = FunctionLib::getOption($this->arrIsHostting, isset($dataSave['web_is_hostting'])? $dataSave['web_is_hostting'] : CGlobal::status_show);
		$dataSave['web_time_start'] = strtotime($dataSave['web_time_start']);
		$dataSave['web_time_end'] = strtotime($dataSave['web_time_end']);
		$this->layout->content =  View::make('admin.Hostting.add')
			->with('id', $id)
			->with('data', $dataSave)
			->with('optionStatus', $optionStatus)
			->with('optionIsHostting', $optionIsHostting)
			->with('error', $this->error)
			->with('arrStatus', $this->arrStatus);
	}
	private function valid($data=array()) {
		if(!empty($data)) {
			if(isset($data['web_name']) && trim($data['web_name']) == '') {
				$this->error[] = 'Tên web không được bỏ trống';
			}
			if(isset($data['web_domain']) && trim($data['web_domain']) == '') {
				$this->error[] = 'Domain không được bỏ trống';
			}
			if(isset($data['web_is_hostting']) && trim($data['web_is_hostting']) == CGlobal::status_show) {
				if(isset($data['web_time_start']) && trim($data['web_time_start']) == '') {
					$this->error[] = 'Chưa nhập thời gian bắt đầu';
				}
				if(isset($data['web_time_end']) && trim($data['web_time_end']) == '') {
					$this->error[] = 'Chưa nhập thời gian kết thúc';
				}
			}
		}
		return true;
	}

	public function deleteHostting(){
		$data = array('isIntOk' => 0);
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
			return Response::json($data);
		}
		$id = (int)Request::get('id', 0);
		if ($id > 0 && Hostting::deleteData($id)) {
			$data['isIntOk'] = 1;
		}
		return Response::json($data);
	}
}