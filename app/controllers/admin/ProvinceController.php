<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

class ProvinceController extends BaseAdminController{
	private $permission_view = 'province_view';
	private $permission_full = 'province_full';
	private $permission_delete = 'province_delete';
	private $permission_create = 'province_create';
	private $permission_edit = 'province_edit';
	private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
	private $error = '';
	public function __construct(){
		parent::__construct();
		FunctionLib::site_js('backend/js/admin.js', CGlobal::$POS_HEAD);
	}
	public function listView(){
		if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		CGlobal::$pageAdminTitle = "Tỉnh thành | ".CGlobal::web_name;
		//Config Page
		$pageNo = (int) Request::get('page', 1);
		$pageScroll = CGlobal::num_scroll_page;
		$limit = CGlobal::number_limit_show;
		$offset = $stt = ($pageNo - 1) * $limit;
		$search = $data = array();
		$total = 0;
		
		$search['province_name'] = addslashes(Request::get('province_name', ''));
		$search['province_id'] = (int)Request::get('province_id', '');
		$search['province_status'] = (int)Request::get('province_status', -1);
		$search['field_get'] = '';
		
		$data = Province::searchByCondition($search, $limit, $offset, $total);
		$paging = $total > 0 ? Pagging::getNewPager($pageScroll, $pageNo, $total, $limit, $search) : '';
		
		$optionStatus = FunctionLib::getOption($this->arrStatus, $search['province_status']);
		$this->layout->content = View::make('admin.Province.list')
								->with('stt', $stt)
								->with('data', $data)
								->with('total', $total)
								->with('paging', $paging)
								->with('arrStatus', $this->arrStatus)
								->with('optionStatus', $optionStatus)
								->with('search', $search);
	}

	public function getItem($id=0) {
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		$data = array();
		$arrViewImgOther = array();
		$imageOrigin = $urlImageOrigin = '';
		if($id > 0) {
			$data = Province::getById($id);

		}
		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['province_status'])? $data['province_status'] : CGlobal::status_show);
		$this->layout->content = View::make('admin.Province.add')
			->with('id', $id)
			->with('data', $data)
			->with('imageOrigin', $imageOrigin)
			->with('urlImageOrigin', $urlImageOrigin)
			->with('arrViewImgOther', $arrViewImgOther)
			->with('optionStatus', $optionStatus)
			->with('arrStatus', $this->arrStatus);
	}
	public function postItem($id=0) {
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		$dataSave['news_title'] = addslashes(Request::get('news_title'));
		$dataSave['news_desc_sort'] = addslashes(Request::get('news_desc_sort'));
		$dataSave['news_content'] = Request::get('news_content');
		$dataSave['news_type'] = addslashes(Request::get('news_type'));
		$dataSave['news_category'] = addslashes(Request::get('news_category'));
		$dataSave['news_status'] = (int)Request::get('news_status', 0);
		$id_hiden = (int)Request::get('id_hiden', 0);

		//FunctionLib::debug($dataSave);
		if($this->valid($dataSave) && empty($this->error)) {
			$id = ($id == 0)?$id_hiden: $id;
			if($id > 0) {
				//cap nhat
				if(Province::updateData($id, $dataSave)) {
					return Redirect::route('admin.province');
				}
			} else {
				//them moi
				if(Province::addData($dataSave)) {
					return Redirect::route('admin.province');
				}
			}
		}

		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['province_status'])? $dataSave['province_status'] : -1);
		$this->layout->content =  View::make('admin.Province.add')
			->with('id', $id)
			->with('data', $dataSave)
			->with('optionStatus', $optionStatus)
			->with('error', $this->error)
			->with('arrStatus', $this->arrStatus);
	}

	public function deleteProvince(){
		$data = array('isIntOk' => 0);
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
			return Response::json($data);
		}
		$id = (int)Request::get('id', 0);
		FunctionLib::debug($id);
		if ($id > 0 && Province::deleteData($id)) {
			$data['isIntOk'] = 1;
		}
		return Response::json($data);
	}
}