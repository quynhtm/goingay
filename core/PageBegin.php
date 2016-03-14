<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
	global $breakcumb;
	$post_featured_image = '';
	$post_title = '';
	$breakcumb = SvLib::buildBreadCrumb($breakcumb);
	//lấy mô tả khi vào trang chi tiết
	$new_id = (int) Url::get('new_id', 0);
	if ($new_id > 0) {
		$cond = 'status = 1 AND id=' . $new_id;
		$sql = "SELECT name,description,images,id FROM ".TABLE_NEWS." WHERE " . $cond . " limit 0,1";
		$new = DB::get_row($sql);
		$post_title = $new['name'];
		$post_featured_image = SvImg::getThumbImage($new['images'],$new['id'],SvImg::FOLDER_NEWS,150,100);
		CGlobal::$website_title = ($new['name'] !== '') ? $new['name'].' - langquetoi.com' : CGlobal::$website_title;
		CGlobal::$meta_desc = ($new['description'] !== '') ? $new['description'] : CGlobal::$meta_desc;
	}
	$pro_id = (int) Url::get('pro_id', 0);
	if ($pro_id > 0) {
		$cond = 'status = 1 AND id=' . $pro_id;
		$sql = "SELECT name, description,images,id FROM ".TABLE_PRODUCT." WHERE " . $cond . " limit 0,1";
		$pro = DB::get_row($sql);
		if(!empty($pro) && !empty($pro['images'])) {
			$post_featured_image = SvImg::getThumbImage($pro['images'],$pro['id'],SvImg::FOLDER_PRODUCT,150,100);
		}
		$post_title = $pro['name'];
		CGlobal::$website_title = ($pro['name'] !== '') ? $pro['name'].' - langquetoi.com' : CGlobal::$website_title;
	}
	//title page admin
	$name_page = Url::tget('page', '');
	if($name_page != '' && in_array($name_page, array_keys(CGlobal::$arrPageAdmin))){
		CGlobal::$website_title = CGlobal::$arrPageAdmin[$name_page];
	}

	?>
	<meta http-equiv="EXPIRES" content="0" />
	<meta name="RESOURCE-TYPE" content="DOCUMENT" />
	<meta name="DISTRIBUTION" content="GLOBAL" />
	<meta name="AUTHOR" content="LANGQUETOI" />
	<meta name="KEYWORDS" content="<?php echo CGlobal::$keywords?>">
	<meta name="DESCRIPTION" content="<?php echo CGlobal::$meta_desc; ?>">
	<meta name="COPYRIGHT" content="Copyright (c) by langquetoi.com" />
	<?php if( isset($_GET['page']) && in_array($_GET['page'], CGlobal::$pg_noIndex)){?>
		<meta name="ROBOTS" content="NOINDEX, NOFOLLOW, NOARCHIVE, NOSNIPPET" />
	<?php }else{?>
		<meta name="ROBOTS" content="<?php echo CGlobal::$robotContent?>" />
		<meta name="Googlebot" content="<?php echo CGlobal::$gBContent?>">
	<?php } ?>

	<meta name="RATING" content="GENERAL" />
	<meta name="GENERATOR" content="langquetoi.com" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="image_src" href="<?php echo $post_featured_image; ?>" />

	<title><?php echo ucfirst(CGlobal::$website_title)?></title>
	<base href="<?php echo WEB_ROOT?>">
	<link rel="shortcut icon" href="<?php echo STATIC_URL?>favicon.ico?v=1.1" />
	<?php echo EnBac::$extraHeaderCSS;?>

	<script>
		var query_string = "?<?php echo urlencode($_SERVER['QUERY_STRING']);?>",
			BASE_URL = "<?php echo WEB_ROOT?>",
			STATIC_URL = "<?php echo STATIC_URL?>",
			WEB_DIR  = "<?php echo WEB_DIR?>",
			IS_ROOT  = <?php echo (int)User::is_root();?>,
			IS_BACK_END = 0,
			IS_ADMIN = <?php echo (int)User::is_admin();?>,
			IS_LOGIN = <?php echo (User::is_login()?User::id():0);?>,
			IS_BLOCK = <?php echo (User::is_block()?1:0);?>,
			OPENID_ON= <?php echo (int)OPENID_ON;?>,
			DEBUG= <?php echo (int)is_debug();?>,
			TIME_NOW = <?php echo TIME_NOW;?>;
	</script>
	<script type="text/javascript" src="<?php echo STATIC_URL?>style/bootstrap/js/jquery.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/jquery/jquery.jcache.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/jquery/jquery.json-2.2.min.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>"></script>


	<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/save/bm.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/save/function.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/save/fix.resize.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>"></script>


	<?php if(User::is_login()){ ?>
		<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/save/admin.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>"></script>
	<?php } ?>

	<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/save/library.js<?php echo (CGlobal::$js_ver) ? '?v='.(CGlobal::$js_ver) : ''?>"></script>
	<?php
	if(Url::get('keywords') && EnBacLib::trimSpace(EnBacLib::cleanHtml(Url::get('keywords')))){echo '<script type="text/javascript" src="'.STATIC_URL.'javascript/jquery/packed/jquery.highlight-2.js"></script>';}
	?>

	<?php echo EnBac::$extraHeader;?>
	<?php echo EnBac::$extraHeaderJS;?>
	<?php
	if(is_debug()) {
		//for debug js
		?>
		<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/dfocus.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL?>javascripts/save/prettyprint.js"></script>
	<?php
	}
	else {
	?>
		<script type="text/javascript">
			// hide top_layout_home
			jQuery(document).ready(function(){
				if(Bm.get_ele('top_layout_home')){
					if(Bm.util_trim(document.getElementById('top_layout_home').innerHTML) == '<div class="clear"></div>'){
						document.getElementById('top_layout_home').style.display='none';
					}
				}
			});
		</script>
		<?php
	}
	?>
</head>
<body class="skin-blue">
<script src='http://connect.facebook.net/en_US/all.js#xfbml=1'></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"> </script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=687712774621598&version=v2.0";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>


<center><div id="wrap" class="wrap1" align="center">