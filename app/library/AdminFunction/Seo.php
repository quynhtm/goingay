<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 08/2016
* @Version	 : 1.0
*/
class SeoMeta{

	public static function SEO($img='', $meta_title='', $meta_keywords='', $meta_description='', $url=''){
		if($img == ''){
			$img = Config::get('config.WEB_ROOT').'uploads/default.jpg';
		}
		if($meta_title ==''){
			$meta_title = CGlobal::web_name;
		}
		if($meta_keywords == ''){
			$meta_keywords = $meta_title;
		}
		if($meta_description == ''){
			$meta_description = $meta_title;
		}
		
		$str = '';
		$str .= '<title>'.$meta_title.'</title>';
		$str .= '<meta name="robots" content="index,follow">';
		$str .= '<meta http-equiv="REFRESH" content="1800">';
		$str .= '<meta name="revisit-after" content="days">';
		$str .= '<meta http-equiv="content-language" content="vi"/>';
		$str .= '<meta name="copyright" content="'.CGlobal::web_name.'">';
		$str .= '<meta name="author" content="'.CGlobal::web_name.'">';
		
		//Google
		$str .= '<meta name="keywords" content="'.$meta_keywords.'">';
		$str .= '<meta name="description" content="'.$meta_description.'">';
		
		//Facebook
		$str .= '<meta content="article" property="og:type">';
		$str .= '<meta content="'.$meta_title.'" property="og:title">';
		$str .= '<meta content="'.$meta_description.'" property="og:description">';
		$str .= '<meta content="'.CGlobal::web_name.'" property="og:site_name">';
		$str .= '<meta content="'.$img.'" itemprop="thumbnailUrl" property="og:image">';
		
		//Twitter
		$str .= '<meta name="twitter:title" content="'.$meta_title.'">';
		$str .= '<meta name="twitter:description" content="'.$meta_description.'">';
		$str .= '<meta name="twitter:image" content="'.$img.'">';
		
		if($url != ''){
			$str .= '<link rel="canonical" href="'.$url.'">';
			$str .= '<meta property="og:url" itemprop="url" content="'.$url.'">';
			$str .= '<meta name="twitter:url" content="'.$url.'">';
		}
		
		CGlobal::$extraMeta = $str;
	}
}