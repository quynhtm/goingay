<?php
class String{
    static $allowedTags = '<h1><b><i><a><ul><li><hr><strong><table><tr><td><h2><span><br><center><ol><p>';
    static $stripAttrib ='javascript:|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup';

    function display_sort_title($str,$word_number){
        $c = str_word_count($str);
        $array1=array($c);
        $new_str='';
       
        if($c>=$word_number){
            $array1 = explode(" ",$str);
            $i=0;
            while($i<sizeof($array1)){
                if($i<$word_number){
                    $new_str.=$array1[$i].' ';
                }
                $i++;
            }
            return $new_str.'...';
        }
        else{
            return $str;   
        }
    }
   
    static function string2js($st){
        return strtr($st, array('\''=>'\\\'','\\'=>'\\\\','\n'=>'',chr(10)=>'\\
',chr(13)=>''));
    }
   
    /**
    * @return string
    * @param string
    * @desc Strip forbidden tags and delegate tag-source check to removeEvilAttributes()
    */
    static function removeEvilTags($source){
        $source = strip_tags(preg_replace( array(
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?>.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu'
        ), '', $source), String::$allowedTags);
       
        return preg_replace('/<(.*?)>/ie', "'<'.String::removeEvilAttributes('\\1').'>'", $source);
    }
   
    /**
    * @return string
    * @param string
    * @desc Strip forbidden attributes from a tag
    */
    static function removeEvilAttributes($tagSource){
        return stripslashes(preg_replace("/".String::$stripAttrib."/i", 'forbidden', $tagSource));
    }
   
    static function html2txt($document){
        $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
                      '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
                      '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                      '@<![\s\S]*?--[ \t\n\r]*>@',        // Strip multi-line comments including CDATA
                      '/\\[([\s]*[0-9]{1,2}[\s]*)\]/eis'  // Strip [1][2][3]
        );
        $text = preg_replace($search, '', $document);
        return $text;
    }
   
}