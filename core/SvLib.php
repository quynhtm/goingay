<?php
class SvLib {
	
	static function getPathWay() {
		/**
		 * 1. http://save.vn
		 * 2. http://save.vn/thoi-trang/c1/Giay-dep.html
		 * 3. http://save.vn/thoi-trang/c13/gender2/Giay-the-thao-Nam.html
		 * 4. http://save.vn/thoi-trang/c13/gender2/snew1/Moi-nhat.html
		 * 5. http://save.vn/thoi-trang/p1/adidas-Running-Sprint-Star-2.html
		 * 6. http://save.vn/gio-hang.html
		 * 7. http://save.vn/quy-dinh-chinh-sach/n3/Gioi-thieu.html
		 */
		
		$aryParams = array ();
		$aryParams ['home'] [] = array ('title' => CGlobal::$website_title , 'link' => WEB_DIR );
		
		$page = Url::get('page');
		switch ($page) {
			case 'sv_notice' :
				$id = Url::get('news_id', 0);
				if($id > 0) {
					$aryNews = array();
					$aryNews = SvNewsLib::getNewsId($id);
					if(is_array($aryNews) && count($aryNews) > 0) {
						$aryParams ['news'] [] = array ('title' => $aryNews['name'], 'link' =>  $aryNews['link_detail']);
					}
				}
				break;
				
			case 'brand':
				$brand_id = Url::get('brand_id', 0);
				if($brand_id > 0) {
					$aryBrand = array();
					$aryBrand = SvProductLib::getBrandProduct($brand_id);
					if(is_array($aryBrand) && count($aryBrand) > 0) {
						$aryParams ['brand'] [] = array ('title' => $aryBrand['name'], 'link' =>  $aryBrand['link_detail']);
					}
				}
				break;
					
			default:
				break;		
		}
		$aryBreadCrumb = array ();
		foreach($aryParams as $p ) {
			foreach ( $p as $v ) {
				$aryBreadCrumb[] = $v;
			}
		}
		return $aryBreadCrumb;
	}
	
	
	
	/**
	 * Build bread crumb function
	 * 
	 * Date 2010/08/21
	 */
	static function buildBreadCrumb($aryData) {
		CGlobal::$website_title = '';
		$strPathWay = '';
		if (is_array ( $aryData ) && count ( $aryData ) > 0) {
			$strPathWay .= '<div id="breadcrumbs">';
			$strPathWay .= '<span id="btb" style="display: inline;"><a class="gae-click*Product-Page*Back-to-Browsing*boo" href="javascript:history.go(-1)" id="browse">Trở lại</a></span>';
			$len = count ( $aryData );
			if ($len > 0) {
				$strPathWay .= '<span id="crumbs">';
				for($i = 0; $i < $len; $i ++) {
					if ($i == 0) {
						CGlobal::$website_title = $aryData [$i] ['title'] . CGlobal::$website_title;
						$strPathWay .= '<a href="' . $aryData [$i] ['link'] . '" >' . $aryData [$i] ['title'] . '</a>';
					} 
					else {
						if ($i == ($len - 1)) {
							$strPathWay .= ' › ' . $aryData [$i] ['title'];
						} 
						else {
							$strPathWay .= ' › <a href="' . $aryData [$i] ['link'] . '">' . $aryData [$i] ['title'] . '</a>';
						}
						CGlobal::$website_title = $aryData [$i] ['title'] . ' - ' . CGlobal::$website_title;
					}
				}
				$strPathWay .= '</span>';
			}
			$strPathWay .= '</div>';
		}
		if(CGlobal::$website_title == 'namdalat.com') {
			CGlobal::$website_title = 'namdalat.com';
		}
		else {
			if (CGlobal::$website_title != '') {
				CGlobal::$website_title = preg_replace ( "#namdalat$#", "namdalat.com", CGlobal::$website_title);
				CGlobal::$website_title = preg_replace ( "# - namdalat\.com$#", " | namdalat.com", CGlobal::$website_title );
			}
		}
		return $strPathWay;
	}
	

	/**
	 * random string
	 */
	static function random_string(){
		$len = 8;
		$base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
		$max=strlen($base)-1;
		$activatecode='';
		mt_srand((double)microtime()*1000000);
		while (strlen($activatecode) < $len+1)
		  $activatecode.=$base{mt_rand(0,$max)};		  
		return $activatecode;
	}

        /**
         * 
         * Get list option provice
         *
         *  @author MinhNV
         *  Date 2011/09/20
         */
        static  function  getListOptionProvince() {
        	$aryProvince = array ();
        	if(MEMCACHE_ON) {
				$aryProvince = sv_memcache::do_get(Cache::MC_LIST_OPTION_PROVINCE );
        	}
			if(empty($aryProvince)) {
				$aryProvince = array ();
				$sql = 'SELECT id,name FROM '.TABLE_PROVINCE.' ORDER BY position';
				$re = SvSQL::query ( $sql );
				if ($re) {
					while ( $row = mysql_fetch_assoc ( $re ) ) {
						$aryProvince [$row ['id']] = $row['name'];
					}
				}
				if(MEMCACHE_ON) {
					sv_memcache::do_put ( Cache::MC_LIST_OPTION_PROVINCE, $aryProvince );
				}
			}
			return $aryProvince;
        }
        
        /**
         *  Get ty gia ngan hang VCB
         *  
         * 
         */
        static  function  getExchangeRate() {
        	$rate = 0;
        	if(MEMCACHE_ON) {
        		$rate = sv_memcache::do_get(Cache::MC_EXCHANGE_RATE_FOREGIN);
        	}
        	if(empty($rate)) {
        		try {
	        		$rate = 0;
		        	$url = "http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx";
					$xmlDoc = new DOMDocument();
					$xmlDoc->load($url);
					$el = $xmlDoc->getElementsByTagName('Exrate');
					for ($i = 0; $i < $el->length; $i++) {
						if ($el->item($i)->nodeType == 1 && $el->item($i)->getAttribute('CurrencyCode') == "USD"){
							$rate = $el->item($i)->getAttribute('Sell');
							break;
						}
					}
        		 }  
        		 catch (Exception $e) {
	        	 	 return  $rate;
	        	 }
				if(MEMCACHE_ON) {
					if($rate > 0) {
						sv_memcache::do_put(Cache::MC_EXCHANGE_RATE_FOREGIN, $rate, Cache::MC_TIME_TO_LIVE_ONE_HOUR);
					}
				}
        	}
			return $rate;
		}
		
		/**
		 *  Get type shipping
		 * 
		 * @author MinhNV
		 * Date 2011/09/18
		 * @param int $shipping_method
		 */
		static function getTypeShipping($shipping_method = 0, $is_fee_shipping_standar = 0) {
			$aryTypeShip = array(
				SHIPPING_TYPE_STANDARD => array( 'id' => SHIPPING_TYPE_STANDARD,
						    'min_time' => 2, 
							'max_time' => 7,
							'info' => 'Vận chuyển tiết kiệm (2 - 7 ngày làm việc trừ thứ 7 và chủ nhật)',
							'fee' => ($is_fee_shipping_standar == 1) ? 0 : 40000,
							'brief'=>'Vận chuyển Tiêu chuẩn'
							),
				SHIPPING_TYPE_FAST => array( 'id' => SHIPPING_TYPE_FAST,
						    'min_time' => 2, 
							'max_time' => 2,
							'info' 	=>	'Vận chuyển nhanh (2 ngày làm việc trừ thứ 7 và chủ nhật)',
							'fee' => 210000,
							'brief'	=>	'Vận chuyển nhanh - 2 ngày'
							),
				SHIPPING_TYPE_VERY_FAST => array( 'id' => SHIPPING_TYPE_VERY_FAST,
						    'min_time' => 1, 
							'max_time' => 1,
							'info' 	=>	'Vận chuyển nhanh (1 ngày làm việc trừ thứ 7 và chủ nhật)',
							'fee' => 420000,
							'brief'	=>	'Vận chuyển nhanh - 1 ngày'
							)
			);
			
			if($shipping_method > 0) {
				return (isset($aryTypeShip[$shipping_method]) ? $aryTypeShip[$shipping_method] : false);
			}
			else {
				return $aryTypeShip;	
			}
		}
		
		
		/**
		 * 
		 * Get type payment for order
		 * 
		 * @author MinhNV
		 * Date 2011/09/18
		 * @param int $type
		 */
		static function getTypePayment($type = 0) {
			$aryTypePay = array(
				PAYMENT_TYPE_COD => array('id' => PAYMENT_TYPE_COD
										, 'info' => 'Giao hàng thu tiền tại nhà(COD) <span style="color: red">(Hiện tại hình thức này chỉ áp dụng cho khách hàng trong các quận nội thành Hà Nội)</span>'
										, 'brief' => 'Giao hàng thu tiền tại nhà'),
				PAYMENT_TYPE_ATM => array('id' => PAYMENT_TYPE_ATM
										, 'info' => 'Chuyển khoản qua máy ATM hoặc Ngân hàng <span style="color: red">(Quý khách tự thanh toán phí chuyển khoản)</span>'
										, 'brief' => 'Chuyển khoản'),
				PAYMENT_TYPE_ONEPAY => array('id' => PAYMENT_TYPE_ONEPAY
										, 'info' => 'Cổng thanh toán OnePay<span style="color: red">(Chấp nhận thẻ ATM của các ngân hàng sau : Vietcombank, VietinBank, Techcombank, DongABank, TienPhongBank, SHB, VIB, Eximbank, HDBank, MB, VietA Bank, Maritime Bank)</span>'
										, 'brief' => 'Thanh toán Online dùng thẻ ATM, tài khoản có Internet Banking')						
			);
			if($type > 0) {
				return (isset($aryTypePay[$type]) ? $aryTypePay[$type] : false);
			}
			else {
				return $aryTypePay;	
			}
		}
		
 		static function item_per_page($num = 10) {
                $ary = array(10, 20, 25, 50, 100, 1000, 10000);
                $p = '';
                foreach ($ary as $n) {			
                        $p .= "<option value='{$n}'" . (($num == $n) ? ' selected ' : '') . ">{$n}</option>";
                }
                return $p;
        }
        
        /**
         *  Kiem tra xem co dang refresh hay ko         
         */
        static  function  isRefresh() {
        	return (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0');
        }
        
        /**
 		 * Get depart id 
         */
        static function getDepart() {
        	$page = Url::get('page');
        	foreach (SGlobal::$aryDepartName as $k => $v) {
        		if($v == $page) {
        			return $k;
        		}
        	} 
        	return 0;
        }
        /**
         * QuynTM add 13.4.2012
         * Enter description here ...
         * @param unknown_type $position
         */
       static function getResultBanner($position = 0){
            $result = array();
            $condition = ($position > 0)? "status = 1 AND position = ".$position :'status = 1';
            $sql = "SELECT title,image,id,link_view FROM `sim_adver` WHERE ".$condition." ORDER BY order_item ASC";
            $res = DB::query($sql);
            if($res) {
                     while ($row = mysql_fetch_assoc($res)) {
                         $images = SvImg::getAllImages($row['image'], CGlobal::$adv_image_sizes, $row['id'], SvImg::FOLDER_AVATAR, OPT_GET_IMAGE);
                         if(!empty($images)) {
                             $row ['image_top'] = $images[280];
                             $row ['image_right'] = $images[220];
                         }
                         $result[] = $row;
                     }
            }
           
           return $result; 
       } 
        /**
         * QuynTM add 13.4.2012
         * Enter description here ...
         * @param 
         */
       static function getResultYahoo(){
	       	$result = array();
	       	$sql = "SELECT * FROM `sim_yahoo` WHERE status = 1 ORDER BY position ASC" ;
			$res = DB::query($sql);
			if($res) {
				while ($row = mysql_fetch_assoc($res)) {
						$result[] = $row;
				}
			}
		   return $result; 
       } 
       static function getResultNCC(){
	       	$result = array();
	       	$sql = "SELECT * FROM `sim_ncc` WHERE status = 1 ORDER BY id ASC" ;
			$res = DB::query($sql);
			if($res) {
				while ($row = mysql_fetch_assoc($res)) {
						$result[] = $row;
				}
			}
		   return $result; 
       } 
		static function getMenuArr(){
			return array(
				CGlobal::MENU_TRANG_CHU => array('link' => Url::build('home', array()),'title' => CGlobal::$arymNameMenuTop[CGlobal::MENU_TRANG_CHU],'active' => false),
				CGlobal::MENU_LOI_GIOI_THIEU =>array('link' => Url::build(CGlobal::$aryUrlMenuTop[CGlobal::MENU_LOI_GIOI_THIEU], array()), 	'title' => CGlobal::$arymNameMenuTop[CGlobal::MENU_LOI_GIOI_THIEU],'active' => false),
				CGlobal::MENU_TIN_TUC_CHUNG =>array('link' => Url::build(CGlobal::$aryUrlMenuTop[CGlobal::MENU_TIN_TUC_CHUNG], array()), 	'title' => CGlobal::$arymNameMenuTop[CGlobal::MENU_TIN_TUC_CHUNG],'active' => false),
				CGlobal::MENU_CAC_DONG_HO =>array('link' => Url::build(CGlobal::$aryUrlMenuTop[CGlobal::MENU_CAC_DONG_HO], array()), 	'title' => CGlobal::$arymNameMenuTop[CGlobal::MENU_CAC_DONG_HO],'active' => false),
				CGlobal::MENU_THAP_TAM_TRAI =>array('link' => Url::build(CGlobal::$aryUrlMenuTop[CGlobal::MENU_THAP_TAM_TRAI], array()), 	'title' => CGlobal::$arymNameMenuTop[CGlobal::MENU_THAP_TAM_TRAI],'active' => false),
				CGlobal::MENU_LANG_NGHE =>array('link' => Url::build(CGlobal::$aryUrlMenuTop[CGlobal::MENU_LANG_NGHE], array()), 	'title' => CGlobal::$arymNameMenuTop[CGlobal::MENU_LANG_NGHE],'active' => false),
			);
		}
		static function getActiveMenu($cmd){
			foreach (CGlobal::$aryUrlMenuTop as $depart_id => $page) {
				if($cmd === $page) {
					return $depart_id;
				}
			}
			return CGlobal::MENU_TRANG_CHU;
		}
		static function getContion($key, &$ckValue, $defaultValue = '') {
		
		if (isset ( $_POST [$key] )) {
			$ckValue [$key] = $_POST [$key];
		} elseif (isset ( $_GET [$key] )) {
			$ckValue [$key] = $_GET [$key];
		} elseif (! isset ( $ckValue [$key] )) {
			$ckValue [$key] = $defaultValue;
		}
		
		return $ckValue [$key];
	}
	
	static function cutText($string, $setlength, $extraText = " ...") {
		$newtext = wordwrap($string, $setlength, "[]", true);
		$strs = explode("[]", $newtext);
		$result = $strs [0];
		if (strlen($string) > $setlength) {
			$result .= $extraText;
		}
		return $result;
	}
	
	static function word_limit($string, $length, $ellipsis="...") {
		return (count($words = explode(' ', $string)) > $length) ? implode(' ', array_slice($words, 0, $length)) . $ellipsis : $string;
	}

    static function FunctionDebug($data){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }

    static function addLogAction($infor_log = array()){
        if(!empty($infor_log)){
            $id = DB::insert('', $infor_log);
        }

    }

    static function getProductHot(){
        $i = 0; $j = 10;
        $cond = " status = 1 order by `position` ASC ,id DESC limit {$i},{$j}";
        $sql = "SELECT id,name,images,name_alias,price FROM ". TABLE_PRODUCT . " WHERE ".$cond;
        $res2 = DB::query($sql);
        $aryItemPro = array();
        if($res2) {
            while ($row = mysql_fetch_assoc($res2)) {
                $row ['images'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_PRODUCT,136,136);
                $row['link_detail'] = Url::build('detail_product', array('pro_id'=>$row ['id'], 'title'=>safe_title($row['name'])));
                $aryItemPro[] = $row;
            }
        }
        return $aryItemPro;
    }
    static function getNewsGroup(){
        $cond = " status = 1 ORDER BY id DESC limit 0,7";
        $sql = "SELECT id,name,images,create_time,description FROM ". TABLE_NEWS . " WHERE " . $cond;
        $res = DB::query($sql);
        $aryNews = array();
        if ($res) {
            while ($row = mysql_fetch_assoc($res)) {
                $row ['images_180'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_NEWS,180,120);
                $row['view_news'] = Url::build('detail_news', array('new_id' => $row['id'], 'title' => FunctionLib::safe_title($row['name'])));
                $row['description'] = SvLib::word_limit($row['description'],25);
                $aryNews[] = $row;
            }
        }
        return $aryNews;
    }
    //QuynhTM build menu header
    static function buildMenuHeader() {
        $query = 'SELECT id,level,name,parent_id,linkview,`order` FROM  ' . TABLE_CATEGORY . ' WHERE status = 1 ORDER BY parent_id asc,`order` desc';
        $query_id = DB::query($query);
        $arrList = array();
        if ($query_id) {
            while ($row = mysql_fetch_assoc($query_id)) {
                $row['linkview'] = Url::build('list_product', array('cat_id'=> $row['id'], 'title'=> safe_title($row['name'])));// list các tin bài cùng danh mục
                //$row['linkview'] = '';
                if($row['level'] == 1){
                    $arrList[$row['id']] = $row;
                }else{
                    if(isset($arrList[$row['parent_id']])){
                        $arrList[$row['parent_id']]['sub'][] = $row;
                    }
                }
            }
        }
        return SvLib::subval_sort($arrList,'order');
    }

    static function subval_sort($a, $subkey) {
        foreach ($a as $k => $v) {
            $b[$k] = strtolower($v[$subkey]);
        }
        asort($b);
        foreach ($b as $key => $val) {
            $c[] = $a[$key];
        }
        return $c;
    }
        
}//End class
	