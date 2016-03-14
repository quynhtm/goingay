<?php
class Url{
	static function build_all($except=array(), $addition=false){
		if(is_array($except))
			$except+=array('form_block_id','ebug','tbug','delcache','delscache','utm_source','utm_campaign','utm_content','utm_medium');
		else
			$except=array('form_block_id','ebug','tbug','delcache','delscache','utm_source','utm_campaign','utm_content','utm_medium');
		
		$url  = '';
		$page = '';
		$params = array();
		foreach($_POST as $key=>$value){
			if(!in_array($key, $except) && $key!='form_block_id'){
				if(!is_array($value)){
					if($key=='page'){
						$page=($value);
					}
					else/*if($value!='')*/
						//$url.=($url?'&':'').urlencode($key).'='.urlencode($value);
						//$params[urlencode($key)] = urlencode($value);
						$params[urlencode($key)] = $value;//phongct tạm bỏ cái $value đi vì lý do dấu space bị biến thành dấu [+]
				}
			}
		}
		
		foreach($_GET as $key=>$value){	
			
			if(!in_array($key, $except) && $key!='form_block_id' && !isset($_POST[$key])){
				if($key=='page'){
					$page=($value);
				}
				else/*if($value!='')*/
					//$url.=($url?'&':'').urlencode($key).'='.urlencode($value);
					$params[$key] = $value;
			}
		}
		
		if($addition){
				$per_param_temp = array();
				$all_param = explode('&',$addition);
				foreach ($all_param as $value){
					$per_param_temp = explode('=',$value);
					$params[$per_param_temp[0]] = $per_param_temp[1];
				}
				
		}
		
		$url = Url::build($page,$params);
		return $url?$url:WEB_DIR;
	}
	
	static function build_current($params=array(),$anchor=''){
		return Url::build((isset(EnBac::$page['name'])?EnBac::$page['name']:'home'),$params,$anchor);
	}
	
	static function build($page,$params=array(),$anchor=''){
		$request_string = '';
		$ext = '.html';
		$other_params ='';
		if(!REWRITE_ON){
				if($page=='home')
						$request_string = '';
				else{
					$request_string = '?page='.$page;
				}
		
				if ($params){
					foreach ($params as $param=>$value){
						if(is_numeric($param)){
							if(isset($_REQUEST[$value]) && $value!='page'){
								$request_string .= ($request_string?'&':'?').$value.'='.$_REQUEST[$value];
							}
						}
						elseif($param!='page'){
							$request_string .= ($request_string?'&':'?').$param.'='.($value);
						}
					}
				}
		}
		else{
				$array_page = array(	
										'home' => '',
										'sign_in'	 	=> 'dang-nhap',
										'list_news'	 	=> 'tin-tuc',
										//'detail_product'	 	=> 'chi-tiet-san-pham',
										//'detail_news'	 	=> 'chi-tiet',
										'sv_register'	 	=> 'dangky',
										'list_product' 		=>	'danh-muc-san-pham',
										'forgot_password'	 	=> 'khoiphuc-matkhau',
										'profile'			=> 'profile',
										'account'			=> 'account',
										'so_myshop'			=> 'quantri',
										'brand'=>'thuong-hieu',
										'network'=>'nha-mang',
										'sign_out' => 'thoat',
										'sign_in'=>'dangnhap'
										);
				if (!empty($params)){
                    $params_order = array();
                    $prefix_params = array();
                    // thu tu cac param truyen vao theo tung trang
                    switch ($page){
                        case 'brand':
                            $params_order[$page] = array('id',  'title');
                            break;
                        case 'network':
                            $params_order[$page] = array('network_id',  'title');
                            break;
                        case 'detail_product':
                                //$params_order[$page] = array('pro_id',  'title');
                                /*$prefix_params[$page] = array('id'=>'p');*/
                                $params_order[$page] = array('pro_id','title');
                                $prefix_params[$page] = array('pro_id' => 'p-');
                                break;
                        case 'detail_news':
                                $params_order[$page] = array('new_id','title');
                                $prefix_params[$page] = array('new_id' => 'news-');
                                break;
                        case 'list_product':
                                $params_order[$page] = array('cat_id','title');
                                $prefix_params[$page] = array('cat_id' => 'c');
                                break;
                        case 'tin_tuc':
                                $params_order[$page] = array('news_id','ebname','page_no');
                                $prefix_params[$page] = array('page_no' => 'trang-');
                                break;

                        case 'sv_notice':
                                $params_order[$page] = array('news_id','title');
                                $prefix_params[$page] = array('news_id' => 'n');
                                break;
                        case 'tin_tuc':
                                $params_order[$page] = array('news_id','ebname','page_no');
                                $prefix_params[$page] = array('page_no' => 'trang-');
                                break;
                        case 'pay':
                                $params_order[$page] = array('step');
                                $prefix_params[$page] = array('step' => 'buoc-');
                                break;
                        case 'profile':
                                $params_order[$page] = array('cmd');
                                break;
                        case 'account':
                                $params_order[$page] = array('user_name', 'category_id', 'pID', 'title');//category_id=66&pID=157248
                                $prefix_params[$page] = array( 'category_id' => 'c','pID'=>'p');
                                break;
                    }

                    $new_params = (isset($params_order[$page])) ? array_fill_keys($params_order[$page], '') : array();
                    $new_params += array('other_params'=>'');

                    foreach ($params as $param=>$value){
                        if(is_numeric($param)){ // truong hop chi truyen vao param khong co gia tri di kem thi lay gia tri dang co tren url
                            if(isset($_REQUEST[$value]) && $value!='page'){
                                $param = $value;
                                $value = $_REQUEST[$value];
                            }
                        }
                        if(!is_numeric($param)&&$param!='page'){
                            if(isset($new_params[$param])){
                                if(isset($prefix_params[$page][$param])){
                                    $new_value = $prefix_params[$page][$param].($value);
                                }
                                else{
                                    $new_value = $value;
                                }
                                $new_params[$param] = $new_value;
                            }
                            else{
                                if($new_params['other_params']){
                                    $new_params['other_params'] .= '&'.$param.'='.$value;
                                }
                                else{
                                    $new_params['other_params'] = '?'.$param.'='.$value;
                                }
                            }
                        }
                    }
                    //check trang can add them ten trang vao
                    if(isset($params_order[$page])){

                        foreach ($new_params as $key=>$value){
                            if($value && $key!='other_params' && $params_order[$page]){
                                $request_string .= ($request_string) ? '/' : '';
                                $request_string .= $value;
                            }
                        }
                    }
                    if($request_string){
                        $page = (isset($array_page[$page])) ? $array_page[$page].'/' : '';
                        $request_string = $page.$request_string.$ext.$new_params['other_params'];
                    }
                    else{ // neu khong dc rewrite
                        $page = (isset($array_page[$page])) ? $array_page[$page] : $page;
                        $request_string = $page.$ext.$new_params['other_params'];
                    }
				}
				else{
                    if($page=='home' || $page == '')
                        $request_string = '';
                    else{
                        $request_string = (isset($array_page[$page])) ? $array_page[$page].$ext : $page.$ext;
                    }
				}
				
				if($page == 'account/') {
					$request_string = str_replace($page, '', $request_string);
					$request_string = str_replace($params['user_name'].'.html', $params['user_name'], $request_string);
				}
				
		}	
		return WEB_ROOT.$request_string.$anchor;
	}
	
	static function redirect_current($params=array(),$anchor = '',$msg=''){
		Url::redirect(EnBac::$page['name'],$params,$anchor,$msg);
	}
	
	static function redirect_href($params=false){
		if(Url::check('href')){
			Url::redirect_url(Url::attach($_REQUEST['href'],$params));
			return true;
		}
	}
	
	static function check($params){
		if(!is_array($params)){
			$params=array(0=>$params);
		}
		
		foreach($params as $param=>$value){
			if(is_numeric($param)){
				if(!isset($_REQUEST[$value])){
					return false;
				}
			}
			else{
				if(!isset($_REQUEST[$param])){
					return false;
				}
				else{
					if($_REQUEST[$param]!=$value){
						return false;
					}
				}
			}
		}
		return true;
	}
	
	//Chuyen sang trang chi ra voi $url
	static function redirect($page=false,$params=false, $anchor='',$msg=''){
		if($msg){
			self::setMsg($msg);
		}
		if(!$page && !$params){
			Url::redirect_url();
		}
		else{
			Url::redirect_url(Url::build($page, $params,$anchor));
		}
	}
	
	//Chuyen sang trang chi ra voi $url
	static function redirect_meta($page=false,$params=false, $anchor='',$msg=''){
		if($msg){
			self::setMsg($msg);
		}
		if(!$page && !$params){
			Url::redirect_url_meta();
		}
		else{
			Url::redirect_url_meta(Url::build($page, $params,$anchor));
		}
	}
	
	static function redirect_url($url=false){
		$url = str_replace(array(WEB_ROOT,WEB_DIR),'',$url);
		header('Location:'.WEB_DIR.$url);
		System::halt();
	}
	
	static function redirect_url_meta($url=false){
		$url = str_replace(array(WEB_ROOT,WEB_DIR),'',$url);
		echo "<meta http-equiv='refresh' content='0;url=".WEB_DIR.$url."'>";
		System::halt();
	}
	
	static function access_denied(){
		Url::redirect('home');
		//header("Location: ".WEB_ROOT."err/error.html");
		//die();
	}
	
	/**
	 * Sử dụng meta tag to redirect
	 */
	static function access_denied_meta(){
		Url::redirect_meta('home');
	}
	
	static function get($name,$default=''){
		if (isset($_POST[$name])){
			return $_POST[$name];
		}
		elseif(isset($_GET[$name])){
			return $_GET[$name];
		}
		elseif (isset($_REQUEST[$name])){
			return $_REQUEST[$name];
		}
		elseif(isset($_COOKIE[$name])){
			return $_COOKIE[$name];
		}
		else{
			return $default;		
		}
	}
	
	static function tget($name,$default=''){
	if (isset($_POST[$name])){
			return trim($_POST[$name]);
		}
		elseif(isset($_GET[$name])){
			return trim($_GET[$name]);
		}
		elseif (isset($_REQUEST[$name])){
			return trim($_REQUEST[$name]);
		}
		elseif(isset($_COOKIE[$name])){
			return trim($_COOKIE[$name]);
		}
		else{
			return $default;		
		}
	}
	static function sget($name,$default=''){
		return strtr(Url::get($name, $default),array('"'=>'\\"'));
	}
	
	static function cdouble( $doubleval ){
		//if(!is_numeric($doubleval))
		{
			$doubleval=strtr($doubleval,array('.'=>''));
			$doubleval=strtr($doubleval,array(','=>'.'));
		}
		return doubleval($doubleval);
	}
	
	static function open_popup($url=false,$width=false,$height=false,$top=false,$left=false,$event=false,$resizable=0,$toolbar=0,$status=0,$scrollbars=0,$address_bar=0,$menubar=0){
		if(!$url)
			$url	='about:blank';
		elseif(strpos($url,'?')===false)
			$url.='?is_popup=1';
		else 
			$url.='&is_popup=1';
			
		if(!$width)
			$width	=300;
		if(!$height)
			$height	=400;
			
		if(!$top)
			$top	='\' + (screen.height -'.$height.')/2 +\'';		
		if(!$left)
			$left	='\' + (screen.width -'.$width.')/2 +\'';
		
		if(!$event)
			$event	='onclick';	

		return $event.'="window.open(\''.$url.'\' ,\'\',\'status='.$status.',toolbar='.$toolbar.',scrollbars='.$scrollbars.',resizable='.$resizable.',width='.$width.',height='.$height.',top='.$top.',left='.$left.',location ='.$address_bar.',menubar ='.$menubar.'\');"';	
	}
	static function setMsg($msg=''){
		if($msg){
			$_SESSION['msg']=$msg;
		}else{
			unset($_SESSION['msg']);
		}
	}
	static function getMsg(){
		$msg='';
		if(isset($_SESSION['msg'])){
			$msg=$_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		return $msg;
	}
};