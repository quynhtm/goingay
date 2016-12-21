<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class ToolsCommonController extends BaseAdminController
{
    private $permission_view = 'toolsCommon_view';
    private $permission_full = 'toolsCommon_full';
    private $permission_delete = 'toolsCommon_delete';
    private $permission_create = 'toolsCommon_create';
    private $permission_edit = 'toolsCommon_edit';

    private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    private $error = array();

    public function __construct()
    {
        parent::__construct();
        //Include style.
        FunctionLib::link_css(array(
            'lib/upload/cssUpload.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            'lib/upload/jquery.uploadfile.js',
            'lib/ckeditor/ckeditor.js',
            'lib/ckeditor/config.js',
            'lib/dragsort/jquery.dragsort.js',
            'js/common.js',
        ));
    }


    /************************************************************************************************************************************
     * @return mixed
     * Quản lý lượt share của shop
     * **********************************************************************************************************************************
     */
    public function viewClickShare() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }

        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['object_name'] = addslashes(Request::get('object_name',''));
        $search['object_id'] = (int)Request::get('object_id',0);

        $dataSearch = ClickShare::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        $this->layout->content = View::make('admin.ToolsCommon.viewClickShare')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)

            ->with('is_root', $this->is_root)//dùng common
            ->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);//dùng common
    }

    //cập nhật thêm quyền cho hệ thông
    public function addPermit(){
        die('tạm dừng chức năng này');
        $arrPermit = ArrayPermission::$arrPermit;
        /*DB::table('permission')->truncate();
        DB::table('group_user')->truncate();
        DB::table('group_user_permission')->truncate();*/
        /*foreach($arrPermit as $permit=> $infor){
            $arrInsert = array('permission_code'=>$permit,
                'permission_name'=>$infor['name_permit'],
                'permission_group_name'=>$infor['group_permit'],
                'permission_status'=>1);
            if (!Permission::checkExitsPermissionCode($permit)) {
                Permission::createPermission($arrInsert);
            }
        }*/
        FunctionLib::debug($arrPermit);
    }
}