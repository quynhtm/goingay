<?php
/**
 *
 * * @author Quynh_Arsenal
 *
 */
require_once ROOT_PATH.'core/lib/function.php';
class AdminProduct extends Module {
	function AdminProduct($row) {
		Module::Module($row);
		$act = Url::get('act');
        if(User::check_permit_product()) {
            switch ($act) {
                //dùng cho xóa nhiều item cùng lúc
                case 'remove':
                    if (isset($_POST['selected_ids'])) {
                        $cid = $_POST['selected_ids'] ? $_POST['selected_ids'] : array();
                        if (!empty($cid)) {
                            $condition = " id IN (" . implode(',', $cid) . ")";
                            if(!User::is_admin()){
                                $condition .= ' and create_user_id = '. User::id() .' ';
                            }
                            $aryDataDelete = Product::getProductByCondition('images,id,images_other_temp',$condition,false);
                            $len = count($cid);
                            if(!empty($aryDataDelete)){
                                for ($i = 0; $i < $len; $i++) {
                                    $aryDelete = $aryDataDelete[$cid[$i]];
                                    if (!empty($aryDelete)) {
                                        Product::deleteItem($aryDelete);
                                        Product::deleteCacheProduct($aryDelete['id']);
                                    }
                                }
                            }
                        }
                    }
                    Url::redirect_current();
                    break;
                //xóa từng 1 item
                case 'delete':
                    $id = (int)Url::get('id', 0);
                    if ($id <= 0) break;
                    //lay SP nguoi tao san pham
                    $condition = Product::$primaryKey.'='.$id;
                    if(!User::is_admin()){
                        $condition .= ' and create_user_id = '. User::id() .' ';
                    }
                    $aryDataDelete = Product::getProductByCondition('images,id,images_other_temp',$condition,false);
                    if(!empty($aryDataDelete)){
                        $aryDelete = $aryDataDelete[$id];
                        if (!empty($aryDelete)) {
                            Product::deleteItem($aryDelete);
                            Product::deleteCacheProduct($id);
                        }
                    }
                    Url::redirect_current();
                    break;
                case 'status':
                    $id = (int)Url::get('id', 0);
                    $status = (int)Url::get('status', 0);
                    if ($id) {
                        Product::updateProduct(array('status' => ($status == 1) ? 0 : 1),'id=' . $id);
                        Product::deleteCacheProduct($id);
                    }
                    Url::redirect_current();
                    break;
                case 'publishAll':
                case 'unpublishAll':
                    if (isset($_POST['selected_ids'])) {
                        $cid = $_POST['selected_ids'] ? $_POST['selected_ids'] : array();
                        if (!empty($cid)) {
                            $value = ($act == 'publishAll') ? 1 : 0;
                            $len = count($cid);
                            for ($i = 0; $i < $len; $i++) {
                                Product::updateProduct(array('status' => $value),'id=' . $cid[$i]);
                                Product::deleteCacheProduct($cid[$i]);
                            }
                        }
                    }
                    Url::redirect_current();
                    break;
                case 'hot':
                    if (User::is_manager()) {
                        $id = (int)Url::get('cid', 0);
                        $hot = (int)Url::get('hot', 0);
                        if ($id) {
                            Product::updateProduct(array('hot' => ($hot == 1) ? 0 : 1),'id=' . $id);
                            Product::deleteCacheProduct($id);
                        }
                        Url::redirect_current();
                    } else {
                        Url::redirect_current();
                    }
                    break;

                //kiểm duyệt SP
                case 'approval':
                case 'unapproval':
                    if (isset($_POST['selected_ids'])) {
                        $cid = $_POST['selected_ids'] ? $_POST['selected_ids'] : array();
                        if (!empty($cid)) {
                            $value = ($act == 'approval') ? 1 : 0;
                            $len = count($cid);
                            for ($i = 0; $i < $len; $i++) {
                                Product::updateProduct(array('approval' => $value),'id=' . $cid[$i]);
                                Product::deleteCacheProduct($cid[$i]);
                            }
                        }
                    }
                    Url::redirect_current();
                    break;
                case 'edit':
                case 'add':
                    require_once 'forms/Edit.php';
                    $this->add_form(new EditForm());
                    break;
                case 'copy':
                    require_once 'forms/Copy.php';
                    $this->add_form(new CopyForm());
                    break;
                case 'apply':
                case 'save':
                    $this->saveItem();
                    break;
                //kho và bán hàng
                case 'store':
                    require_once 'forms/Store.php';
                    $this->add_form(new StoreForm());
                    break;
                default:
                    require_once 'forms/List.php';
                    $this->add_form(new ListForm());
                    break;
            }
        }else{
            Url::redirect('admin');
        }
	}

    function saveItem(){
        require_once ROOT_PATH.'core/lib/function.php';
        $new_row = array();

        $name = Url::tget('name');
        $category_id = Url::tget('category_id');
        $description = Url::tget('description');
        $content = Url::tget('content');

        $store = Url::tget('store',0);
        $quantity_sell = Url::tget('quantity_sell',0);

        $price = Url::tget('price_hide',0);
        $price_input = Url::tget('price_input_hide',0);
        $price_market = Url::tget('price_market_hide',0);

        $start_time = Url::tget('start_time',0);
        $end_time = Url::tget('end_time',0);
        $status = Url::tget('status',0);
        $position = Url::tget('position',0);
        $hot = Url::tget('hot',0);

        $page_keywords = Url::tget('page_keywords');
        $page_descriptions = Url::tget('page_descriptions');

        //ảnh chính
        $images = Url::tget('image_primary','');

        //option danh mục
        $arrCategoryLists = getTreeCatAll();
        $arrListOption = array();
        $arrListOption[0] = '--- ROOT ---';
        foreach($arrCategoryLists as $arrCategoryList){
            $arrListOption[$arrCategoryList->id] = $arrCategoryList->textTitle;
        }

        $new_row = array(
            'name'          => $name,
            'content'       => str_replace('\"','"',$content),
            'description'   => strip_tags($description),
            'category_id'   => $category_id,
            'category_name' => isset($arrListOption[$category_id]) ? $arrListOption[$category_id]: '',
            'id_ncc'        => '',
            'name_ncc'      => '',
            'status'        => $status,
            'images'        => $images,
            'position'      => $position,
            'store'         => $store,
            'quantity_sell' => $quantity_sell,
            'price'         => $price,
            'price_input'   => $price_input,
            'price_market'  => $price_market,
            'discount'      => round(($price/$price)*100),
            'page_keywords'  => $page_keywords,
            'page_descriptions'  => $page_descriptions,
            'start_time'    => strtotime($start_time),
            'end_time'      => strtotime($end_time),
            'hot'           => $hot);


        //them mới
        $id = (int) Url::get('id',0);
        if ($id == 0) {
            $new_row['create_user_id'] = User::id();
            $new_row['create_user_name'] = User::user_name();
            $new_row['create_time'] = TIME_NOW;
            $new_row['modify_time'] = TIME_NOW;
            $id = DB::insert(Product::$table, $new_row);
        } else {
            if(!User::is_root()){
                $new_row['create_user_id'] = User::id();
                $new_row['create_user_name'] = User::user_name();
            }
            $new_row['modify_user_id'] = User::id();
            $new_row['modify_user_name'] = User::user_name();
            $new_row['modify_time'] = TIME_NOW;
        }

        //ảnh khác
        $arrInputImgOther = array();
        $getImgOther = Url::get('img_other',array());
        if(!empty($getImgOther)){
            foreach($getImgOther as $k=>$val){
                if($val !=''){
                    $arrInputImgOther[] = $val;
                }
            }
        }
        if (!empty($arrInputImgOther) && count($arrInputImgOther) > 0) {
            if($images == ''){
                $new_row['images'] = $arrInputImgOther[0];
            }
            $new_row['images_other'] = serialize($arrInputImgOther);
        }
        Product::updateProduct($new_row,'id=' . $id);
        Product::deleteCacheProduct($id);
        if(EnBacLib::getParam('act') == 'apply'){
            Url::redirect_current(array('act'=>'edit','id'=>$id));
        }
        else {
            Url::redirect_current();
        }
    }
}

?>