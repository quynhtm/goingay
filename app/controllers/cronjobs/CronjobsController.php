<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class CronjobsController extends BaseSiteController
{
    private  $sizeImageShowUpload = CGlobal::sizeImage_100;
	//cronjobs/runJobs?action=0
    function runJobs() {
        $action = Request::get('action', 0);//kiểu chạy joib
        switch( $action ){
            case 1://cập nhật link ảnh trong sản phẩm
            case 2://cập nhật link ảnh trong sản phẩm
            case 4://replace /r/n
                $this->updateLinkInContent($action);
                break;
			case 3://cập nhật email NCC
                $this->convertEmailProvider();
                break;
            default:
                break;
        }
        echo 'Bạn chưa chọn kiểu action';
    }

    public function updateLinkInContent($type = 0){
    	$total = 0;
    	switch( $type ){
        		case 1://cập nhật link ảnh trong sản phẩm
        			$dataSearch['field_get'] = 'item_id,item_content';
        			$data = Items::searchByCondition($dataSearch,500,0,$total);
        			if($data){
        				foreach($data as $k=>$product){
        					$content = stripcslashes($product->item_content);
        					
        					$url_old = '600x600';
        					$content = str_replace($url_old, '500x300',$content);
        					
        					$dataUpdate['item_content'] = $content;
        					Items::updateData($product->item_id,$dataUpdate);
        				}
        			}
        			break;
        		case 2://cập nhật link ảnh trong tin tức
        				$dataSearch['field_get'] = 'news_id,news_content';
        				$data = News::searchByCondition($dataSearch,1000,0,$total);
        				
        				if($data){
        					foreach($data as $k=>$product){
        						$content = stripcslashes($product->news_content);
        						 
        						$url_old1 = 'http://www.shopcuatui.com.vn/image.php?type_dir=news&amp;id='.$product->news_id.'&amp;width=700&amp;height=700&amp;image=';
        						$content1 = str_replace($url_old1, '',$content);
        						 
        						$url_old2 = 'http://shopcuatui.com.vn/image.php?type_dir=news&amp;id='.$product->news_id.'&amp;width=700&amp;height=700&amp;image=';
        						$content2 = str_replace($url_old2, '',$content1);
        						$dataUpdate['news_content'] = $content2;
        						 
        						News::updateData($product->news_id,$dataUpdate);
        					}
        				}
        				break;
				case 4://replace /r/n
                    $dataSearch['field_get'] = 'item_id,item_content';
                    $data = Item::searchByCondition($dataSearch,1000,0, $total);
                    if($data){
                        foreach($data as $k=>$item){
                            $content = stripcslashes($item->item_content);
                            $content = str_replace('\r', '',$content);
                            $content = str_replace('\n', '',$content);
                            $content = str_replace('\\', '',$content);
                        
                            $dataUpdate['item_content'] = $content;
                            Item::updateData($item->item_id, $dataUpdate);
                        }
                    }
                    break;
        		default:
        			break;
        	}
            echo 'đã cập nhật xong';
        }

	public function convertEmailProvider(){
		die('dã chạy thêm dữ liệu');
		$total = 0;
		$dataSearch['field_get'] = 'provider_id,provider_name,provider_phone,provider_email';
		$dataProvider = ProviderEmail::searchByCondition($dataSearch,1000,0,$total);
		$total_insert = 0;
		if($dataProvider){
			foreach($dataProvider as $k=>$valu){
				if($valu->provider_email != ''){
					$insert = array('supplier_created'=>time(),
						'supplier_name'=>$valu->provider_name,
						'supplier_phone'=>$valu->provider_phone,
						'supplier_email'=>trim(str_replace(' ','',$valu->provider_email)));
					Supplier::addData($insert);
					$total_insert ++;
				}
			}
		}
		echo 'Tong ban dau: '.$total.'--- Tong them: '.$total_insert;
		//FunctionLib::debug($provider);
	}

	public function apiPushProductShop(){
		$limit = (int)Request::get('limit',1000);
		$order_by = (int)Request::get('order_by','desc');
		$base_url_shop = 'http://shopcuatui.com.vn';
		$url_shop = $base_url_shop.'/cronjobs/apiGetProductShop?limit='.$limit.'&order_by='.$order_by;
		$this->user_customer = UserCustomer::getByID(7);
		//lay mang id da tồn tại trên rao vat
		$arrProducInRaovat = Items::getProductIdShop();
		$update = $insert = 0;
		$curl = Curl::getInstance();
		$content = $curl->get($url_shop);
		if($content){
			/*
			 * $result[$item->product_id] = array(
					'product_id'=>$item->product_id,
					'product_name'=>$item->product_name,
					'product_type_price'=>$item->product_type_price,//1:hiển thị giá số, 2: hiển thị giá liên hệ
					'product_price_sell'=>$item->product_price_sell,
					'product_content'=>$item->product_content,
					'product_image'=>$item->product_image,
					'product_image_other'=>$item->product_image_other,
					'product_status'=>$item->product_status,
					);
			 * */
			$content = json_decode($content,true);
			
			foreach($content as $item){
				$dataSave['item_name'] = 'Bán '.$item['product_name'];
				$dataSave['item_shop_product_id'] = $item['product_id'];//id cua SP shop
				$dataSave['item_status'] = $item['product_status'];
				$dataSave['item_content'] = FunctionLib::strReplace(addslashes($item['product_content']),CGlobal::$arrIconSpecals,'');
				$dataSave['item_content'] = FunctionLib::strReplace($dataSave['item_content'], '\r\n', '');
				$dataSave['item_type_price'] = $item['product_type_price'];
				$dataSave['item_price_sell'] = $item['product_price_sell'];
				$dataSave['time_ontop'] = time();
				
				//cập nhật nếu tồn tại rồi
				if(!empty($arrProducInRaovat) && isset($arrProducInRaovat[$item['product_id']])){
					$dataSave['time_update'] = time();
					
					if(isset($item['product_image']) && $item['product_image'] != ''){
						$rao_vat_path_img = Config::get('config.DIR_ROOT').'/uploads/' .CGlobal::FOLDER_PRODUCT.'/'.$item['product_id'];
						if(!file_exists($rao_vat_path_img)){
							@mkdir($rao_vat_path_img, 0777, true);
						};
						$path_shop_img = $base_url_shop.'/uploads/product/'.$item['product_id'].'/'.$item['product_image'];
						@copy($path_shop_img, $rao_vat_path_img.'/'.$item['product_image']);
						$dataSave['item_image'] = $item['product_image'];
					}
					
					if(Items::updateData($arrProducInRaovat[$item['product_id']],$dataSave)){
						$update ++;
					}
				}
				//thêm mới
				else{
					$dataSave['item_image'] = '';
					$dataSave['item_image_other'] = '';
					$dataSave['item_category_id'] = 261;//thời trang làm đẹp
					$dataSave['item_category_name'] = 'Thời trang - Làm đẹp';
					$dataSave['item_type_action'] = CGlobal::ITEMS_TYPE_ACTION_1;

					$dataSave['item_province_id'] = 22;
					$dataSave['item_province_name'] = 'Hà Nội';
					$dataSave['customer_id'] = $this->user_customer['customer_id'];
					$dataSave['customer_name'] = $this->user_customer['customer_name'];
					$dataSave['is_customer'] = $this->user_customer['is_customer'];
					$dataSave['item_province_id'] = ($dataSave['item_province_id'] > 0) ?$dataSave['item_province_id'] : $this->user_customer['customer_province_id'];
					$dataSave['item_infor_contract'] = $this->user_customer['customer_about'];
					$dataSave['item_district_id'] = $this->user_customer['customer_district_id'];
					$dataSave['item_block'] = CGlobal::ITEMS_NOT_BLOCK;
					$dataSave['time_created'] = time();
					
					$_id =Items::addData($dataSave);
					
					if($_id){
						if(isset($item['product_image']) && $item['product_image'] != ''){
							$rao_vat_path_img = Config::get('config.DIR_ROOT').'/uploads/' .CGlobal::FOLDER_PRODUCT.'/'.$_id;
							if(!file_exists($rao_vat_path_img)){
								@mkdir($rao_vat_path_img, 0777, true);
							};
							$path_shop_img = $base_url_shop.'/uploads/product/'.$item['product_id'].'/'.$item['product_image'];
							@copy($path_shop_img, $rao_vat_path_img.'/'.$item['product_image']);
							$dataSaveUpdate['item_image'] = $item['product_image'];
							Items::updateData($_id, $dataSaveUpdate);
						}
						$insert ++;
					}
				}
				//FunctionLib::debug($dataSave);
			}
		}
		echo 'Thêm mới '.$insert.' và Cập nhật: '.$update; die;
		//FunctionLib::debug($result);
	}
}