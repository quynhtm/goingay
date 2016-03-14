<?php

function numberToWord($s, $lang = 'vi') {
    $funcrionLib = new FunctionLib();
    return $funcrionLib->numberToWord($s, $lang);
}

class FunctionLib {

    static $aryCategory = array(); //mảng danh mục

    /* ------------------------------------------------------------------------- */

    // Sets a cookie, abstract layer allows us to do some checking, etc
    /* ------------------------------------------------------------------------- */
    static function my_setcookie($name = "", $value = "", $expires = "") {
        $name = COOKIE_ID . "_" . $name;
        $expires = ($expires) ? $expires : time() + 60 * 60 * 24 * 365;
        $cookie_path = '/';
        $cookie_domain = "";
        if (preg_match("/muachung.vn/", $_SERVER['HTTP_HOST'])) {
            $cookie_domain = '.muachung.vn';
        }
        setcookie($name, $value, $expires, $cookie_path, $cookie_domain);
        //setcookie($name, $value, $expires, $cookie_path);
        $_COOKIE[$name] = $value;
    }

    static function get_cookie($name = "", $def = "") {
        $name = COOKIE_ID . "_" . $name;
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $def;
    }

    static function isCookieExisted($name = "") {
        return isset($_COOKIE[COOKIE_ID . "_" . $name]);
    }

    static function plainText($str) {
        $str = strip_tags($str);
        $str = self::trimSpace(str_replace(array(chr(13), chr(9), chr(10), chr(239)), " ", $str));
        return self::delDoubleSpace($str);
    }

    static function base64_url_encode($input) {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    static function _name_cleaner($name, $replace_string = "_") {
        return preg_replace("/[^a-zA-Z0-9\-\_]/", $replace_string, $name);
    }

    static function make_safe_name($name, $replace_string = "_") {
        return preg_replace("/[^\w\.]/", $replace_string, $name);
    }

    static function convertUnicodeCase($test) {
        $uppercase_utf8 = array("A", "Á", "À", "Ả", "Ã", "Ạ", "Â", "Ấ", "Ầ", "Ẩ", "Ẫ", "Ậ", "Ă", "Ắ", "Ằ", "Ẳ", "Ẵ", "Ặ", "E", "É", "È", "Ẻ", "Ẽ", "Ẹ", "Ê", "Ế", "Ề", "Ể", "Ễ", "Ệ", "I", "Í", "Ì", "Ỉ", "Ĩ", "Ị", "O", "Ó", "Ò", "Ỏ", "Õ", "Ọ", "Ô", "Ố", "Ồ", "Ổ", "Ỗ", "Ộ", "Ơ", "Ớ", "Ờ", "Ở", "Ỡ", "Ợ", "U", "Ú", "Ù", "Ủ", "Ũ", "Ụ", "Ư", "Ứ", "Ừ", "Ử", "Ữ", "Ự", "Y", "Ý", "Ỳ", "Ỷ", "Ỹ", "Ỵ", "Đ", " ", "~", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "_", "+", "=", "|", "\\", "{", "}", ":", ";", "<", ">", "/", "?");
        $lowercase_utf8 = array("a", "á", "à", "ả", "ã", "ạ", "â", "ấ", "ầ", "ẩ", "ẫ", "ậ", "ă", "ắ", "ằ", "ẳ", "ẵ", "ặ", "e", "é", "è", "ẻ", "ẽ", "ẹ", "ê", "ế", "ề", "ể", "ễ", "ệ", "i", "í", "ì", "ỉ", "ĩ", "ị", "o", "ó", "ò", "ỏ", "õ", "ọ", "ô", "ố", "ồ", "ổ", "ỗ", "ộ", "ơ", "ớ", "ờ", "ở", "ỡ", "ợ", "u", "ú", "ù", "ủ", "ũ", "ụ", "ư", "ứ", "ừ", "ử", "ữ", "ự", "y", "ý", "ỳ", "ỷ", "ỹ", "ỵ", "đ", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
        if (!$test) {
            return $test;
        } else {
            $new_test = str_replace($uppercase_utf8, $lowercase_utf8, $test);
            return $new_test;
        }
    }

    static function convertUnicodeCaseWithoutHtml($test) {
        $uppercase_utf8 = array("A", "Á", "À", "Ả", "Ã", "Ạ", "Â", "Ấ", "Ầ", "Ẩ", "Ẫ", "Ậ", "Ă", "Ắ", "Ằ", "Ẳ", "Ẵ", "Ặ", "E", "É", "È", "Ẻ", "Ẽ", "Ẹ", "Ê", "Ế", "Ề", "Ể", "Ễ", "Ệ", "I", "Í", "Ì", "Ỉ", "Ĩ", "Ị", "O", "Ó", "Ò", "Ỏ", "Õ", "Ọ", "Ô", "Ố", "Ồ", "Ổ", "Ỗ", "Ộ", "Ơ", "Ớ", "Ờ", "Ở", "Ỡ", "Ợ", "U", "Ú", "Ù", "Ủ", "Ũ", "Ụ", "Ư", "Ứ", "Ừ", "Ử", "Ữ", "Ự", "Y", "Ý", "Ỳ", "Ỷ", "Ỹ", "Ỵ", "Đ", "Q", "W", "R", "T", "U", "S", "D", "F", "G", "H", "J", "K", "L", "Z", "X", "C", "V", "B", "N", "M", "P");
        $lowercase_utf8 = array("a", "á", "à", "ả", "ã", "ạ", "â", "ấ", "ầ", "ẩ", "ẫ", "ậ", "ă", "ắ", "ằ", "ẳ", "ẵ", "ặ", "e", "é", "è", "ẻ", "ẽ", "ẹ", "ê", "ế", "ề", "ể", "ễ", "ệ", "i", "í", "ì", "ỉ", "ĩ", "ị", "o", "ó", "ò", "ỏ", "õ", "ọ", "ô", "ố", "ồ", "ổ", "ỗ", "ộ", "ơ", "ớ", "ờ", "ở", "ỡ", "ợ", "u", "ú", "ù", "ủ", "ũ", "ụ", "ư", "ứ", "ừ", "ử", "ữ", "ự", "y", "ý", "ỳ", "ỷ", "ỹ", "ỵ", "đ", "q", "w", "r", "t", "p", "s", "d", "f", "g", "h", "j", "k", "l", "z", "x", "c", "v", "b", "n", "m", "p");
        if (!$test) {
            return $test;
        } else {
            $new_test = str_replace($uppercase_utf8, $lowercase_utf8, $test);
            return $new_test;
        }
    }

    static function safe_title($text) {
        $text = FunctionLib::post_db_parse_html($text);
        $text = self::stripUnicode($text);
        $text = self::_name_cleaner($text, "-");
        $text = str_replace("----", "-", $text);
        $text = str_replace("---", "-", $text);
        $text = str_replace("--", "-", $text);
        $text = trim($text, '-');

        if ($text) {
            return $text;
        } else {
            return "shop";
        }
    }

    static function convert_one_br($text) {
        $text = str_replace("<br /><br /><br /><br /><br />", "<br />", $text);
        $text = str_replace("<br /><br /><br /><br />", "<br />", $text);
        $text = str_replace("<br /><br /><br />", "<br />", $text);
        $text = str_replace("<br /><br />", "<br />", $text);

        return trim($text, '<br />');
    }

    static function stripUnicode($str) {
        if (!$str)
            return false;
        $marTViet = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
            "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề"
            , "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
            , "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
            , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
            , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ");

        $marKoDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
            , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
            , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
            , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
            , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D");

        $str = str_replace($marTViet, $marKoDau, $str);
        return $str;
    }

    static function getExtension($file) {
        $tail = strtolower(strrchr($file, "."));
        return substr($tail, 1);
    }

    static function getParam($aVarName, $aVarAlt = "", $method = '') { // chi lay post va get
        $lVarName = $aVarAlt;
        switch (strtolower($method)) {
            case 'get':
                $lVarName = isset($_GET[$aVarName]) ? $_GET[$aVarName] : $aVarAlt;
                break;

            case 'post':
                $lVarName = isset($_POST[$aVarName]) ? $_POST[$aVarName] : $aVarAlt;
                break;

            default:
                $lVarName = isset($_GET[$aVarName]) ? $_GET[$aVarName] : (isset($_POST[$aVarName]) ? $_POST[$aVarName] : $aVarAlt);
                break;
        }
        if ($lVarName != $aVarAlt) {
            if (is_array($lVarName)) {
                $lReturnArray = array();
                foreach ($lVarName as $key => $value) {
                    $value = self::clean_value($value);
                    $key = self::clean_key($key);
                    $lReturnArray[$key] = $value;
                }
                return $lReturnArray;
            } else {
                return self::clean_value($lVarName); // Clean input and return it
            }
        }
        return $lVarName;
    }

    static function cleanHtml($aVarName, $aVarAlt = "") {
        $lVarName = $aVarName;
        if (!empty($lVarName)) {
            if (is_array($lVarName)) {
                $lReturnArray = array();
                foreach ($lVarName as $key => $value) {
                    $value = self::clean_value($value);
                    $key = self::clean_key($key);
                    $lReturnArray[$key] = $value;
                }
                return $lReturnArray;
            }
            return self::clean_value($lVarName); // Clean input and return it
        }
        return $aVarAlt;
    }

    static function getParamInt($aVarName, $aVarAlt = 0) {
        $lNum = 0;
        if ($aVarName) {
            if (isset($_POST[$aVarName])) {
                $lNum = $_POST[$aVarName];
            } elseif (isset($_GET[$aVarName])) {
                $lNum = $_GET[$aVarName];
            } else {
                $lNum = $aVarAlt;
            }
        }
        return (int) $lNum;
    }

    /* ------------------------------------------------------------------------- */

    // Key Cleaner - ensures no funny business with form elements
    /* ------------------------------------------------------------------------- */
    static function clean_key($key) {
        if ($key != "" && !is_numeric($key)) {
            $key = htmlspecialchars(urldecode($key));
            $key = preg_replace("/\.\./", "", $key);
            $key = preg_replace("/\_\_(.+?)\_\_/", "", $key);
            $key = preg_replace("/^([\w\.\-\_]+)$/", "$1", $key);
        }
        return $key;
    }

    /* ------------------------------------------------------------------------- */

    // Clean value
    /* ------------------------------------------------------------------------- */

    static function clean_value($val) {
        $strip_space_chr = 1;
        $get_magic_quotes = @get_magic_quotes_gpc();

        if ($val == "") {
            return "";
        }

        $val = trim($val);
        $val = str_replace("&#032;", " ", $val);

        if ($strip_space_chr) {
            $val = str_replace(chr(0xCA), "", $val);  //Remove sneaky spaces
        }
        //$val = str_replace( "&"            , "&amp;"         , $val );
        $val = str_replace("<!--", "", $val); //&#60;&#33;--
        $val = str_replace("-->", "", $val); //--&#62;
        $val = preg_replace("/<script/i", "&#60;script", $val);
        $val = str_replace(">", "&gt;", $val);
        $val = str_replace("<", "&lt;", $val);
        $val = str_replace("\"", "&quot;", $val);
        //$val = preg_replace( "/\n/"        , "<br />"        , $val ); // Convert literal newlines
        $val = preg_replace("/\\\$/", "&#036;", $val);
        $val = preg_replace("/\r/", "", $val); // Remove literal carriage returns
        $val = str_replace("!", "&#33;", $val);
        $val = str_replace("'", "&#39;", $val); // IMPORTANT: It helps to increase sql query safety.

        if ($get_magic_quotes) {
            $val = stripslashes($val);
        }

        $val = preg_replace("/\\\(?!&amp;#|\?#)/", "&#092;", $val);

        return $val;
    }

    //-----------------------------------------
    // parse_html
    // Converts the doHTML tag
    //-----------------------------------------
    static function post_db_parse_html($t = "") {
        if ($t == "") {
            return $t;
        }

        $t = str_replace("&#39;", "'", $t);
        $t = str_replace("&#33;", "!", $t);
        $t = str_replace("&#036;", "$", $t);
        $t = str_replace("&#124;", "|", $t);
        $t = str_replace("&amp;", "&", $t);
        $t = str_replace("&gt;", ">", $t);
        $t = str_replace("&lt;", "<", $t);
        $t = str_replace("&quot;", '"', $t);

        $t = preg_replace("/javascript/i", "j&#097;v&#097;script", $t);
        $t = preg_replace("/alert/i", "&#097;lert", $t);
        $t = preg_replace("/about:/i", "&#097;bout:", $t);
        $t = preg_replace("/onmouseover/i", "&#111;nmouseover", $t);
        $t = preg_replace("/onmouseout/i", "&#111;nmouseout", $t);
        $t = preg_replace("/onclick/i", "&#111;nclick", $t);
        $t = preg_replace("/onload/i", "&#111;nload", $t);
        $t = preg_replace("/onsubmit/i", "&#111;nsubmit", $t);
        $t = preg_replace("/applet/i", "&#097;pplet", $t);
        $t = preg_replace("/meta/i", "met&#097;", $t);

        return $t;
    }

    static function word_limit($string, $length, $ellipsis = "...") {
        return (count($words = explode(' ', $string)) > $length) ? implode(' ', array_slice($words, 0, $length)) . $ellipsis : $string;
    }

    static function make_single_space($t = "") {
        return ($t == "") ? $t : preg_replace("#[[:space:]]+#", " ", $t);
    }

    static function CheckDir($pDir) {
        if (is_dir($pDir))
            return true;
        if (!@mkdir($pDir, 0777, true)) {
            return false;
        }
        self::chmod_dir($pDir, 0777);
        return true;
    }

    static function chmod_dir($dir, $mod = 0777) {
        $parent_dir = dirname(str_replace(ROOT_PATH, '', $dir));
        if ($parent_dir != '' && $parent_dir != '.') {
            //echo $parent_dir.'/<br />';
            @chmod($dir, $mod);
            self::chmod_dir($parent_dir, $mod);
        }
        return true;
    }

    static function trimSpace($str = "") {
        if ($str == "") {
            return;
        }
        $str = str_replace("&nbsp;", " ", $str);
        $str = preg_replace('![\t ]*[\r\n]+[\t ]*!', ' ', $str);
        $str = trim($str);
        return $str;
    }

    static function delDoubleSpace($str) {
        return preg_replace('/  {2,}/', ' ', $str);
    }

    static function IsSearchE() {
        $lSearchEngineArray = array("Google", "yahoo", "Fast", "Slurp", "Ink", "Atomz", "Scooter", "Crawler", "MSNbot", "Poodle", "Genius");
        $SearchEngineList = join('|', $lSearchEngineArray);
        if (preg_match("/($SearchEngineList)/is", $_SERVER['HTTP_USER_AGENT'])) {
            return true; // search engine
        }
        return false; // user
    }

    static function session_started() {
        return isset($_SESSION);
    }

    static function empty_dir($name) {
        if ($dir = @opendir($name)) {
            while ($file = readdir($dir)) {
                if ($file != '..') {
                    @unlink($file);
                }
            }
            closedir($dir);
        }
    }

    static function getOption($options_array, $selected) {
        $input = '';
        if ($options_array)
            foreach ($options_array as $key => $text) {
                $input .= '<option value="' . $key . '"';
                if ($key === '' && $selected === '') {
                    $input .= ' selected';
                } else
                if ($selected !== '' && $key == $selected) {
                    $input .= ' selected';
                }
                $input .= '>' . $text . '</option>';
            }
        return $input;
    }

    //QuynhTM 
    static function getRadioList($name, $radios_array, $checked, $distance = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') {
        $input = '';
        if ($radios_array) {
            $i = 0;
            foreach ($radios_array as $key => $text) {
                $input .= '<input name="' . $name . '" id="' . $name . '_' . $i . '" type="radio" value="' . $key . '"';
                if ($key === '' && $checked === '') {
                    $input .= ' checked="checked"';
                } else
                if ($checked !== '' && $key == $checked) {
                    $input .= ' checked="checked"';
                }
                $input .= ' /> <label for="' . $name . '_' . $i . '" >' . $text . '</label>';
                $input .= $distance;
                $i++;
            }
        }
        return $input;
    }

    static function getOptionNum($min, $max, $default = 1) {
        $options = '';
        for ($i = $min; $i <= $max; $i++) {
            $options .= '<option value="';
            if ($i < 10)
                $options .= '0' . $i . '"';
            else
                $options .= $i . '"';
            if ($i == $default) {
                $options .= ' selected';
            }
            $options .= '>' . $i . '</option>';
        }
        return $options;
    }

    static function empty_all_dir($name, $remove_sub_dir = false, $remove_self = false) {
        if (is_dir($name)) {
            if ($dir = opendir($name)) {
                $dirs = array();
                while ($file = readdir($dir)) {
                    if ($file != '..' and $file != '.') {
                        if (is_dir($name . '/' . $file)) {
                            $dirs[] = $file;
                        } else {
                            @unlink($name . '/' . $file);
                        }
                    }
                }
                closedir($dir);
                foreach ($dirs as $dir_) {
                    if ($remove_self || $remove_sub_dir)
                        self::empty_all_dir($name . '/' . $dir_, true, true);
                    else
                        self::empty_all_dir($name . '/' . $dir_, false, false);
                }

                if ($remove_self) {
                    @rmdir($name);
                }
            }
        }
    }

    //for json
    static function JsonErr($msg = '', $mixed = array()) {
        $arr = array('err' => -1, 'msg' => $msg);
        if (!empty($mixed)) {
            $arr = $arr + $mixed;
        }
        return json_encode($arr);
    }

    static function JsonSuccess($msg, $mixed = array()) {
        $arr = array('err' => 0, 'msg' => $msg);
        if (!empty($mixed)) {
            $arr = $arr + $mixed;
        }
        return json_encode($arr);
    }

    static function numberFormat($number = 0) {
        if ($number >= 1000) {
            return number_format($number, 0, ',', '.');
        }
        return $number;
    }

    static function priceFormat($price = 0, $currency = '') {
        if ($currency == '') {
            $currency = CGlobal::$currency;
        }
        return self::numberFormat($price) . " $currency";
    }

    static function dateFormat($time = TIME_NOW, $format = 'd/m - H:i', $vietnam = false) {
        $return = date($format, $time);
        if ($vietnam) {
            $days = array('Mon' => 'Thứ 2', 'Tue' => 'Thứ 3', 'Wed' => 'Thứ 4', 'Thu' => 'Thứ 5', 'Fri' => 'Thứ 6', 'Sat' => 'Thứ 7', 'Sun' => 'Chủ nhật');
            $return = date('H:i - ', $time) . $days[date('D', $time)] . ', ngày ' . date('d/m/Y', $time);
        }
        return $return;
    }

    //duration time
    static function duration_time($time) {
        $time = TIME_NOW - $time;

        if ($time > 0) {
            if ($time > (365 * 86400)) {
                return floor($time / (365 * 86400)) . ' năm trước';
            }

            if ($time > (30 * 86400)) {
                return floor($time / (30 * 86400)) . ' tháng trước';
            }

            if ($time > (7 * 86400)) {
                return floor($time / (7 * 86400)) . ' tuần trước';
            }
            if ($time > 86400) {
                return floor($time / (86400)) . ' ngày trước';
            }

            if ($time > 3600) {
                return floor($time / (3600)) . ' giờ trước';
            }

            if ($time > 60) {
                return floor($time / (60)) . ' phút trước';
            }
        }
        return ' vài giây trước';
    }

    //clean & valid url
    static function convertURL($link = '') {
        $http = (preg_match_all("#^(http\:\/\/)#", $link) > 0) ? '' : 'http://';
        return $http . $link;
    }

    //hidden uid
    static function hiddenID($id = 0, $decode = false) {
        if ($decode) {
            $id = (1984 - 13 * 12) + $id;
        } else {
            $id = (13 * 12 - 1984) + $id;
        }
        return $id;
    }

    static function isUrlString($str = '') {
        return (bool) preg_match("#^[a-zA-Z][0-9-_a-zA-Z]*$#", $str);
    }

    static function getMenu($type = 1) {
        $type = ($type == 2 || $type == 3) ? $type : 1;
        $arr = array();
        foreach (CGlobal::$menu as $k => $v) {
            if ($v['position'] == $type) {
                $arr[$k] = $v;
            }
        }
        return $arr;
    }

    static function datetimeToTimestamp($datetime = '') {
        if (!$datetime || $datetime == '0000-00-00 00:00:00')
            return time();

        list($date, $time) = explode(' ', $datetime);
        list($year, $month, $day) = explode('-', $date);
        list($hour, $minute, $second) = explode(':', $time);
        return mktime($hour, $minute, $second, $month, $day, $year);
    }

    static function detectCity() {
        $city = FunctionLib::get_cookie('cityMC', 0);
        if (isset($_GET['province']) && $_GET['province'] != '') {
            $city = strtolower(trim($_GET['province']));
            foreach (CGlobal::$province as $p) {
                if ($p['status'] == '1' && $p['safe_name'] == $city) {
                    $city = $p['id'];
                    break;
                }
            }
        }
        return $city;
    }

    static function keyCity() {
        return 'cityMC';
    }

    static function curCity($admicro = false) {
        $city = self::get_cookie(self::keyCity(), 0);
        if ($city == 0) {
            if ($admicro) {
                //lay tinh thanh tu admicro
                return self::getCityAdmicro();
            } else {
                //tu lay tinh thanh neu click vao link tu email
                $from_mail = isset($_GET['utm_campaign']) ? $_GET['utm_campaign'] : '';
                if ($from_mail == 'MailSubscribed') {
                    $id = FunctionLib::getParamInt('id', 0);
                    $item = Item::getItem($id);
                    if ($item) {
                        $def_city = ($item['province_id'] > 0) ? $item['province_id'] : self::getCityAdmicro();
                        FunctionLib::my_setcookie(self::keyCity(), $def_city);
                        return $def_city;
                    }
                }
            }
        }
        return ($city == 'NaN') ? 22 : $city;
    }

    static function defaultCityCheck() {
        //$province = self::getParam('province');
        //return CGlobal::$current_page == 'home' && $province == '') && (!self::isCookieExisted(self::keyCity()) || (self::curCity() == 0));
        return (CGlobal::$current_page != 'subcribe') && (!self::isCookieExisted(self::keyCity()) || (self::curCity() == 0));
    }

    static function remove_4_js($t) {
        $t = str_replace("&#39;", "", $t);
        $t = str_replace("!", "&#33;", $t);
        $t = str_replace("$", "&#036;", $t);
        $t = str_replace("|", "&#124;", $t);
        $t = str_replace(">", "&gt;", $t);
        $t = str_replace("<", "&lt;", $t);
        $t = str_replace('"', "&quot;", $t);
        $t = str_replace('&quot;', "", $t);

        return trim($t);
    }

    static function strip_special_char($t) {
        $t = preg_replace("/[^a-zA-Z0-9\/\n\s\._,:;-]/", '', $t);
        return trim($t);
    }

    static function addCondition($condition = array(), $where = false, $type = "AND") {
        if (!empty($condition)) {
            $numCondition = count($condition);
            $newCondition = array();
            foreach ($condition as $k => $c) {
                if (strpos($c, ' = ') > 0) {
                    $newCondition[$k] = $c;
                } else {
                    $newCondition[$numCondition] = $c;
                    $numCondition++;
                }
            }
            //sort($newCondition);
            if ($where)
                return ' WHERE ' . implode(" $type ", $newCondition);
            return implode(" $type ", $newCondition);
        }
        return '';
    }

    static function checkExt() {
        $ext = strtolower(Url::get('type'));
        if ($ext) {
            $allow = array('json', 'xml');
            if (in_array($ext, $allow)) {
                return $ext;
            }
        }
        echo 'invalid type';
        exit();
    }

    static function createJson($arr = array()) {
        if (empty($arr)) {
            $arr['error'] = 'invalid';
        }
        header('Content-type: application/json; charset=utf-8');
        return json_encode($arr);
    }

    static function connectApi($key = '') {
        if ($key) {
            return Api::connect($key);
        }
        return false;
    }

    static function checkVersion() {
        $version = Url::get('ver');
        if (in_array($version, CGlobal::$listVersion)) {
            return true;
        } else {
            $listData = array('error' => 'invalid version');
            $type = Url::get('type');
            if ($type == 'xml') {
                $xml = XMLLib::array2XML($listData);
                echo $xml;
            } else {
                echo FunctionLib::createJson($listData);
            }
            exit();
        }
    }

    static function is_valid_email($email) {
        $result = true;
        $email = strtolower(trim($email));
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
            $result = false;
        }
        return $result;
    }

    static function ip_first($ips) {
        if (($pos = strpos($ips, ',')) != false) {
            return substr($ips, 0, $pos);
        } else {
            return $ips;
        }
    }

    static function ip_valid($ips) {
        if (isset($ips)) {
            $ip = self::ip_first($ips);
            $ipnum = ip2long($ip);
            if ($ipnum !== -1 && $ipnum !== false && (long2ip($ipnum) === $ip)) { // PHP 4 and PHP 5
                if (($ipnum < 167772160 || $ipnum > 184549375) && // Not in 10.0.0.0/8
                        ($ipnum < -1408237568 || $ipnum > -1407188993) && // Not in 172.16.0.0/12
                        ($ipnum < -1062731776 || $ipnum > -1062666241))   // Not in 192.168.0.0/16
                    return true;
            }
        }
        return false;
    }

    static function ip() {
        $check = array('HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED',
            'HTTP_VIA', 'HTTP_X_COMING_FROM', 'HTTP_COMING_FROM');
        foreach ($check as $c) {
            //if (self::ip_valid(&$_SERVER[$c])) {
            if (isset($_SERVER[$c]) && self::ip_valid($_SERVER[$c])) {
                return self::ip_first($_SERVER[$c]);
            }
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    static function orderCode($province = 0, $id = 0) {
        //$province = ($province == 22) ? '04' : ($province == 29 ? '08' : '01');
        //return "$province-$id-".TIME_NOW;
        return "$id-" . TIME_NOW;
    }

    static function runSendMailWhenClose($order_info = array()) {
        global $successOrderMail;
        if (!empty($successOrderMail)) {
            $order_info = $successOrderMail['info'];
            //gui mail thanh cong
            if (EmailLib::sendEmailAfterBuy($order_info)) {
                $order_info['log'] = MuaChungLog::orderLog($order_info['id'], array('checkout-email'), $successOrderMail, false, 'sys');
                DB::update(T_ORDERS, array('log' => $order_info['log']), 'id=' . $order_info['id']);
            }
            if (orderLib::isGold($order_info)) {
                Coupon::sendCouponAfterBuy($order_info);
            }
        }
    }

    static function getDistrict($city_id = 0) {
        $districtList = array();
        if ($city_id > 0 && isset(CGlobal::$province[$city_id])) {
            $key = "district" . $city_id;
            $districtList = CacheLib::get($key);
            if (empty($districtList)) {
                $districtList = DB::fetch_all("SELECT id, title, in_area FROM " . T_DISTRICT . " WHERE city_id = " . $city_id . " AND status = 1");
                CacheLib::set($key, $districtList);
            }
        }
        return $districtList;
    }

    static function sendSmsThank($order = array(), $card = array()) {
        if (!empty($order)) {
            $item = array();
            if (isset($order['item_id'])) {
                $item = DB::fetch('SELECT couponName FROM ' . T_ITEMS . ' WHERE id = ' . $order['item_id']);
            }
            include_once(ROOT_PATH . 'core/sendSMS.php');
            $sms = new sendSMS();
            $textSMS = '';
            if ($card) {
                if (!$item && isset($card['item_id'])) {
                    $item = DB::fetch('SELECT couponName FROM ' . T_ITEMS . ' WHERE id = ' . $card['item_id']);
                }
                if (!$item) {
                    $textSMS = "Quy khach da su dung the cao co serial la: " . $card['serial'] . " cua MuaChung.vn ngay " . date("d/m/Y") . ". Cam on Quy khach da ung ho MuaChung.vn.";
                } else {
                    $textSMS = "Quy khach da su dung the cao co serial la: " . $card['serial'] . " - " . $item['couponName'] . " ngay " . date("d/m/Y") . ". Cam on Quy khach da ung ho MuaChung.vn.";
                }
            } else {
//				$textSMS =
//"Quy khach da su dung ma so phieu: ".$order['coupon']." - ".$item['couponName']." ngay ".date("d/m/Y").". Cam on Quy khach da ung ho MuaChung.vn.";
            }
            if ($textSMS) {
                $sms->send($order['phone'], $textSMS, $order['id']);
            }
        }
    }

    /**
     * Kiểm tra xem sản phẩm có trong kho không
     * @author : DungNH
     * date created 2012/01/03
     * return: True or False và Số lương hàng có trong kho nếu có
     */
    static function checkItemStore($itemId, $storeId, &$numItem) {
        if (!$itemId && !$storeId)
            return false;

        $numItem = 0;
        $numEnd = DB::fetch("SELECT num_item FROM " . T_STORE_ITEM . " WHERE item_id = $itemId AND store_id = $storeId AND status = 1 LIMIT 1");
        if (!empty($numEnd)) {
            $numItem = $numEnd['num_item'];
            return true;
        } else {
            return false;
        }
    }

    static function trimID($strID, $character = ',') {
        $strID = trim($strID, $character);
        $strID = preg_replace("/$character+/", $character, $strID);
        $strID = preg_replace("/[^0123456789,]/", '', $strID);
        $arrID = explode($character, $strID);
        foreach ($arrID as $k => $v) {
            $v = (int) $v;
            if (trim($v) == '' || $v == 0)
                unset($arrID[$k]);
        }
        $strID = implode(",", array_unique($arrID));
        return $strID;
    }

    /**
     * Trừ số lượng item trong kho
     * @author : DungNH
     * date created 2012/01/03
     * $child_item_id: Trường hợp sản phẩm có nhiều giá thì phải truyền child_id của giá va
     * $insert: true nếu muốn thêm mới khi sản phẩm chưa có trong kho 
     * return: True or False và Số lương hàng có trong kho nếu có
     */
    static function exceptItem($numItem, $itemId, $storeId, $child_item_id = 0, $note = '', $item = array(), $add = false) {
        if (!$itemId && !$storeId && !$numItem)
            return false;

        $info = ($item) ? $item : Item::getItem($itemId);
        if (empty($info)) {
            $msg = "Không tồn tại hàng trong hệ thống";
            return false;
        }

        $user_id = User::id();
        $user_name = User::username();

        $numEnd = DB::fetch("SELECT num_item, extra_json, date_in FROM " . T_STORE_ITEM . " WHERE item_id = $itemId AND store_id = $storeId AND status = 1 LIMIT 1");

        if ($numEnd['extra_json'] != '') {
            $extra_json = json_decode($numEnd['extra_json']);
        }
//        echo 'abc';
//   		System::debug("SELECT num_item, extra_json, date_in FROM ". T_STORE_ITEM." WHERE item_id = $itemId AND store_id = $storeId AND status = 1 LIMIT 1");
//   		exit();
        $num_item = 0;
        if (!empty($numEnd)) {
            if (!$child_item_id) {//trường hợp sản phẩm có 1 giá
                //trừ số lượng item
                if ($add) {
                    $num_item = $numEnd['num_item'] + $numItem[$child_item_id];
                } else {
                    $num_item = $numEnd['num_item'] - $numItem[$child_item_id];
                }
//						if($num_item < 0) {
//							$msg = "Số lượng hàng trong kho không đủ";
//							return false;
//						}

                $aryItem['num_item'] = $num_item;
                $aryItem['user_upid'] = $user_id;
                $aryItem['name_edit'] = $user_name;
                $aryItem['date_up'] = time();
                //$aryItem['note'] = $note;
            } else {
                foreach ($numItem as $k => $n) {
                    //trường hợp sản phẩm có nhiều giá
                    $num_item = $extra_json->$k->num_item ? $extra_json->$k->num_item : 0;
//                		if($num_item < 0) {
//							$msg = "Số lượng hàng trong kho không đủ";
//							return false;
//						}
                    if ($add) {
                        $num_item = $num_item + $n;
                    } else {
                        $num_item = $num_item - $n;
                    }
                    $extra_json->$k->num_item = $num_item;
                    $extra_json->$k->user_upid = $user_id;
                    $extra_json->$k->name_edit = $user_name;
                    $extra_json->$k->date_up = time();
                    //$extra_json->$k->note = $note;
                    $aryItem['extra_json'] = json_encode($extra_json);
                }

                /**
                 * Lấy tổng số lượng các giá
                 * tuantt
                 */
                $num_end_item = 0;
                foreach ($extra_json as $k => $child) {
                    $num_end_item += $child->num_item;
                }
                $aryItem['num_item'] = $num_end_item;
            }
            //if(DB::query("UPDATE ".T_STORE_ITEM." SET num_item = num_item - $numItem WHERE item_id = $itemId AND store_id = $storeId"))
            DB::update(T_STORE_ITEM, $aryItem, "store_id = $storeId AND item_id = $itemId");
        } else {//khong ton tai thi tao san pham trong kho
            $aryItem = array();
            if (!$child_item_id) {//trường hợp sản phẩm có 1 giá
                $aryItem["store_id"] = $storeId;
                $aryItem["item_id"] = $itemId;
                $aryItem['user_inid'] = $user_id;
                $aryItem['name_create'] = $user_name;
                $aryItem['date_in'] = time();
                //$aryItem['note'] 			= $note;
                $aryItem['num_item'] = 0 - $numItem[$child_item_id];
            } else {//trường hợp sản phẩm có nhiều giá
                $aryExtraItem = array();
                $extra = unserialize($info['extra']);
                $eJson = array();
                foreach ($extra as $e) {
                    $aryListChild[$e['price_id']] = $e;
                }


                $num_end_item = 0;
                foreach ($numItem as $k1 => $n) {
                    foreach ($aryListChild as $k => $child) {
                        $num = 0;
                        $childId = $child['price_id'];
                        //Các giá trị item
                        $aryExtraItem[$childId]['store_id'] = $storeId;
                        $aryExtraItem[$childId]['item_id'] = $itemId;
                        $aryExtraItem[$childId]['title'] = $child['price_title'];
                        $aryExtraItem[$childId]['price'] = $child['price'];
                        $aryExtraItem[$childId]['child_item_id'] = $k1;
                        $aryExtraItem[$childId]['price_save'] = $child['price_save'];
                        $aryExtraItem[$childId]['price_save_money'] = $child['price_save_money'];
                        $aryExtraItem[$childId]['num_item'] = isset($aryExtraItem[$childId]['num_item']) ? $aryExtraItem[$childId]['num_item'] : $num;
                        if ($childId == $k1) {
                            if ($add) {
                                $num_item = $num + $n;
                            } else {
                                $num_item = $num - $n;
                            }
                            $aryExtraItem[$childId]['num_item'] = $num_item;
                        }
                        //$aryExtraItem[$childId]['note'] = $note; //Ghi chú
                        $aryExtraItem[$childId]['user_inid '] = $user_id; //ID người tạo
                        $aryExtraItem[$childId]['name_create'] = $user_name; //Tên người tao
                        $aryExtraItem[$childId]['date_in'] = time(); //Ngày tạo
                        $aryExtraItem[$childId]['category_id'] = $info['category_id'];

                        $num_end_item += $aryExtraItem[$childId]['num_item'];
                    }
                }
                $aryItem['extra_json'] = json_encode($aryExtraItem);
                $aryItem["store_id"] = $storeId;
                $aryItem["item_id"] = $itemId;
                //$aryItem['note'] = $note;

                $aryItem['user_inid'] = $user_id;
                $aryItem['name_create'] = $user_name;
                $aryItem['date_in'] = time();

                $aryItem['num_item'] = $num_end_item;
            }
            if (!DB::insert(T_STORE_ITEM, $aryItem)) {
                $msg = "Lỗi thao tác với Database";
                return false;
            }
        }
//        exit();
        //Tham số Thêm vào bảng log
        if ($add) {
            $aryStoreItemLog['num_input'] = $numItem[$child_item_id];
        } else {
            $aryStoreItemLog['num_output'] = $numItem[$child_item_id];
        }
        $aryStoreItemLog['store_id'] = $storeId;
        $aryStoreItemLog['item_id'] = $itemId;
        $aryStoreItemLog['num_end'] = $num_item;
        $aryStoreItemLog['note'] = $note;
        $aryStoreItemLog['user_inid'] = $user_id;
        $aryStoreItemLog['name_create'] = $user_name;
        $aryStoreItemLog['date_in'] = time();
        //Thêm id cod nếu là kho tổng, default=0
        $aryStoreItemLog['cod_id'] = 0;
        $aryStoreItemLog['store_to_id'] = 0;

        $aryStoreItemLog['child_item_id'] = $child_item_id;
        $aryStoreItemLog['num_end_cod'] = 0;
        //Tyle xuất = 2; 1 là nhập
        $aryStoreItemLog['type'] = 7;

        //Insert số lượng vào bảng store_item_log
        return DB::insert(T_STORE_ITEM_LOG, $aryStoreItemLog);
    }

    static function exceptItemNew($numItem, $itemId, $child_item_id = 0, $storeId, $note = '', $item = array(), $trans = array(), $add = false) {
        $notice = " vui lòng báo lại với kỹ thuật (các giao dịch có thể liên quan: " . implode(',', $trans) . ")";
        if (!$itemId && !$storeId && !$numItem)
        //return "Dữ liệu truyền vào bị lỗi".$notice;
        //System::debug($numItem); die;
            $item = !empty($item) ? $item : Item::getItem($itemId);
        if (empty($item)) {
            //$msg = $itemId." Không tồn tại hàng trong hệ thống";
            //return $msg;
        }

        $user_id = User::id();
        $user_name = User::username();
        //$numEnd = DB::fetch_row(DB::query("SELECT id,child_item_id,num_item, date_in FROM ". T_STORE_ITEM." WHERE item_id = $itemId AND store_id = $storeId AND status = 1 and child_item_id=".($child_item_id?$child_item_id:0) ));
        $numEnd = array();
        $aryEnd = DB::fetch_all("SELECT id,child_item_id,num_item, date_in FROM " . T_STORE_ITEM . " WHERE item_id = $itemId AND store_id = $storeId AND status = 1 and child_item_id=" . ($child_item_id ? $child_item_id : 0));

        foreach ($aryEnd as $store) {
            if ($child_item_id == $store['child_item_id']) {
                $numEnd = $store;
            }
        }

        $extra = '';
        if ($item['extra'] != '') {
            $extra = @unserialize($item['extra']);
            $total_price = DB::fetch("select count(item_id) as total from item_prices where item_id = $itemId", 'total');
        }
        if (!$extra) {
            //$msg = $itemId." Không tìm thấy giá trên hệ thống".$notice;
            //return $msg;
        }

        if ($total_price > 1) {//trường hợp sản phẩm có n giá
            //check xem trong kho da co gia nao chua
            if ($total_price != count($aryEnd)) {
                //$msg = $itemId." Lệch số lượng giá so với hàng trong kho".$notice;
                //return $msg;
            }
        }

        $num_item = 0;
        if ($trans) {
            $note .= " của các giao dịch (" . implode(',', $trans) . ")";
        }
        $tran_id = array_slice($trans, 0, 1);
        //die( System::debug($numEnd) );
        //truong hop trong kho da co
        if (!empty($numEnd)) {
            //trừ số lượng item
            if ($add) {
                $aryItem['num_item'] = $numEnd['num_item'] + $numItem;
            } else {
                $aryItem['num_item'] = $numEnd['num_item'] - $numItem;
            }
            $aryItem['user_upid'] = $user_id;
            $aryItem['name_edit'] = $user_name;
            $aryItem['date_up'] = time();
            //$aryItem['note'] = $note;
            //die( System::debug($aryItem) );
            if (DB::update(T_STORE_ITEM, $aryItem, "id = " . $numEnd['id'])) {
                self::insertStoreLog($storeId, $itemId, $aryItem['num_item'], $note, $child_item_id, $numItem, 7, $add, $tran_id[0]);
            }
        } else {
            //khong ton tai thi tao san pham trong kho
            $aryItem = array();
            if (count($extra) > 1) {//trường hợp sản phẩm có n giá
                foreach ($extra as $e) {
                    $aryListChild[$e['price_id']] = $e;
                }
                foreach ($aryListChild as $k => $child) {
                    $aryItem = array();
                    $num = 0;
                    //Các giá trị item
                    $aryItem['store_id'] = $storeId;
                    $aryItem['item_id'] = $itemId;
                    $aryItem['child_item_id'] = $k;

                    if (isset($numItem)) {
                        if ($add) {
                            $num = $num + $numItem;
                        } else {
                            $num = $num - $numItem;
                        }
                        //$aryItem['note'] = $note; //Ghi chú
                    }
                    $aryItem['num_item'] = $num;
                    $aryItem['user_inid'] = $user_id; //ID người tạo
                    $aryItem['name_create'] = $user_name; //Tên người tao
                    $aryItem['date_in'] = time(); //Ngày tạo
                    $aryItem['date_up'] = time();
                    $aryItem['item_type'] = $item['type'];
                    if (DB::insert(T_STORE_ITEM, $aryItem)) {
                        self::insertStoreLog($storeId, $itemId, $aryItem['num_item'], $note, $aryItem['child_item_id'], $numItem, 7, $add, $tran_id[0]);
                    }
                }
            } else {//trường hợp sản phẩm có 1 giá
                $aryItem["store_id"] = $storeId;
                $aryItem["item_id"] = $itemId;
                $aryItem['user_inid'] = $user_id;
                $aryItem['name_create'] = $user_name;
                $aryItem['date_in'] = time();
                //$aryItem['note'] 			= $note;
                $aryItem['num_item'] = 0 - $numItem;
                $aryItem['date_up'] = time();
                if (DB::insert(T_STORE_ITEM, $aryItem)) {
                    self::insertStoreLog($storeId, $itemId, $aryItem['num_item'], $note, 0, $numItem, 7, $add, $tran_id[0]);
                }
            }
        }
        return true;
    }

    static function insertStoreLog($storeId, $itemId, $numEnd, $note, $child_item_id, $num, $type, $add = false, $tranID = 0) {
        if ($num == 0) {
            return false;
        }
        $aryStoreItemLog['store_id'] = $storeId;
        $aryStoreItemLog['item_id'] = $itemId;
        $aryStoreItemLog['num_end'] = $numEnd;
        $aryStoreItemLog['note'] = $note;
        $aryStoreItemLog['user_inid'] = User::id();
        $aryStoreItemLog['name_create'] = User::username();
        $aryStoreItemLog['date_in'] = time();
        //Thêm id cod nếu là kho tổng, default=0
        $aryStoreItemLog['cod_id'] = 0;
        $aryStoreItemLog['store_to_id'] = 0;

        $aryStoreItemLog['child_item_id'] = $child_item_id;
        $aryStoreItemLog['num_end_cod'] = 0;
        //Tyle xuất = 2; 1 là nhập
        $aryStoreItemLog['type'] = $type;

        $aryStoreItemLog['tranID'] = $tranID;

        if ($add) {
            $aryStoreItemLog['num_input'] = $num;
        } else {
            $aryStoreItemLog['num_output'] = $num;
        }

        //Insert số lượng vào bảng store_item_log
        return DB::insert(T_STORE_ITEM_LOG, $aryStoreItemLog);
    }

    /**
     * Chuyển giá sang chữ
     *
     */
    function numberToWord($s, $lang = 'vi') {
        $ds = 0;
        $so = $hang = array();

        $viN = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
        $viRow = array("", "nghìn", "triệu", "tỷ");

        $enN = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine");
        $enRow = array("", "thousand", "million", "billion");

        if ($lang == 'vi') {
            $so = $viN;
            $hang = $viRow;
        } else {
            $so = $enN;
            $hang = $enRow;
        }

        $s = str_replace(",", "", $s);
        $ds = (int) $s;
        if ($ds == 0) {
            return "không ";
        }

        $i = $j = $donvi = $chuc = $tram = 0;
        $i = strlen($s);

        $Str = "";
        if ($i == 0)
            $Str = "";
        else {
            $j = 0;
            while ($i > 0) {
                $donvi = substr($s, $i - 1, 1);
                $i = $i - 1;
                if ($i > 0) {
                    $chuc = substr($s, $i - 1, 1);
                } else {
                    $chuc = -1;
                }
                $i = $i - 1;
                if ($i > 0) {
                    $tram = substr($s, $i - 1, 1);
                } else {
                    $tram = -1;
                }
                $i = $i - 1;
                if ($donvi > 0 || $chuc > 0 || $tram > 0 || $j == 3)
                    $Str = $hang[$j] . " " . $Str;
                $j = $j + 1;
                if ($j > 3)
                    $j = 1;
                if ($donvi == 1 && $chuc > 1)
                    $Str = "mốt" . " " . $Str;
                else {
                    if ($donvi == 5 && $chuc > 0)
                        $Str = "lăm" . " " . $Str;
                    else if ($donvi > 0)
                        $Str = $so[$donvi] . " " . $Str;
                }
                if ($chuc < 0)
                    break;
                else
                if ($chuc == 0 && $donvi > 0)
                    $Str = "lẻ" . " " . $Str;
                if ($chuc == 1)
                    $Str = "mười" . " " . $Str;
                if ($chuc > 1)
                    $Str = $so[$chuc] . " " . "mươi" . " " . $Str;
                if ($tram < 0)
                    break;
                else
                if ($tram > 0 || $chuc > 0 || $donvi > 0)
                    $Str = $so[$tram] . " " . "trăm" . " " . $Str;
            }
        }
        return strtoupper(substr($Str, 0, 1)) . substr($Str, 1, strlen($Str) - 1) . ($lang == 'vi' ? "đồng" : 'vnd');
    }

    static function optProvince_active($default = '') {
        $html = '<option value=""> -- Chọn tỉnh/thành -- </option>';
        foreach (CGlobal::$province_active as $v) {
            if ($v['status'] == '1') {
                $active = $default != '' && $v['id'] == $default;
                $html .= '<option value="' . $v['id'] . '"' . ($active ? ' selected' : '') . '>' . $v['title'] . '</option>';
            }
        }
        return $html;
    }

    /**
     * lấy số lượng order đang nợ hàng
     * $strItemId: chuỗi item_id: 111,222,333,444,...
     * $store_debit: 0 ko nợ hàng, 1 nợ hàng
     * @tuantt
     * */
    static function countOrderDebit($strItemId, $store_debit = 1, $store_id = 0) {
        $aryDebit = array();
        if ($strItemId != '') {
            $sql = "select count(item_id) as num_debit, GROUP_CONCAT(id) as str_id, id, pid, item_id, child_item_id, item_title, office,
                                    store_debit,status,extra,created from " . T_ORDERS . "
                             where store_debit = $store_debit and item_id in($strItemId) " . ($store_id > 0 ? " and office = $store_id" : '') .
                    " group by office, item_id,child_item_id,store_debit order by id desc";
            $re = DB::query($sql);
            while ($rows = mysql_fetch_assoc($re)) {
                $aryDebit[$rows['office']][$rows['item_id']][$rows['child_item_id']] = $rows;
            }
        }
        return $aryDebit;
    }

    static function getSaleOption($def_id = 0) {
        $res = DB::query("SELECT id, fullname, province FROM " . T_ACCOUNTS . " WHERE status > 0 AND is_active > 0 AND type = 1 ORDER BY province, fullname");
        $opt = '<option value="0"> - Chọn Sale - </option>';
        $now_province = -1;
        while ($user = @mysql_fetch_assoc($res)) {
            //tinh toan truoc id tinh thanh
            if (stripos($user['province'], ',') !== false) {
                $user['province'] = explode(',', $user['province']);
                $user['province'] = $user['province'][0];
            }
            //kiem tra gan group
            if ($now_province != $user['province']) {
                if ($now_province != -1) {
                    $opt .= '</optgroup>';
                }
                $now_province = $user['province'];
                if ($now_province == 0) {
                    $opt .= '<optgroup label="Khác">';
                } else {
                    $opt .= '<optgroup label="' . CGlobal::$province_active[$now_province]['title'] . '">';
                }
            }
            $opt .= '<option value="' . $user['id'] . '"' . ($user['id'] == $def_id ? ' selected' : '') . '>' . $user['fullname'] . '</option>';
        }
        return $opt;
    }

    static function getAllArrUser() {
        $key = "arr_user";
        $arr_user = CacheLib::get($key);
        if (empty($arr_user)) {
            $res = DB::query("SELECT * FROM " . T_ACCOUNTS . " WHERE status > 0 AND is_active > 0 AND type = 1 ORDER BY province, fullname");
            while ($r = @mysql_fetch_assoc($res)) {
                $arr_user[$r['id']] = $r;
            }
            CacheLib::set($key, $arr_user);
        }
        return $arr_user;
    }

    static function getIdUser($user_id = 0) {
        $user = array();
        if ($user_id) {
            $is_id = preg_match("#^[0-9]*$#", $user_id);
            $condition = !$is_id ? "username='$user_id'" : "id=$user_id";
            $sql = "SELECT * FROM " . T_ACCOUNTS . " WHERE $condition AND status = 1 LIMIT 0,1";
            $user = mysql_fetch_assoc(DB::query($sql));
        }
        return $user;
    }

    static function getUserSale() {
        $sale = array();
        //$key = "usale";
        //$sale = CacheLib::get($key);
        //if(empty($sale)){
        $res = DB::query("SELECT * FROM " . T_USER_SALE . " WHERE status = 1 ORDER BY province, fullname");
        while ($r = @mysql_fetch_assoc($res)) {
            $sale[$r['id']] = $r;
        }
        //CacheLib::set($key,$sale);
        //}
        return $sale;
    }

    static function getAllArrUserInSale($role = 0) {
        $arr_user = array();
        $sql = "SELECT * FROM " . T_USER_SALE . " WHERE status = 1 ";
        if ($role > 0) {
            if ($role == 2)
                $sql .= " AND (role = '" . $role . "' OR username ='ngapham' OR username ='hn_trangptt' OR username ='hn_thuyntk' OR username ='bongbambee') ";
            else
                $sql .= " AND role = '" . $role . "' ";
        }
        $sql .= "ORDER BY province, fullname";
        $res = DB::query($sql);
        while ($r = @mysql_fetch_assoc($res)) {
            $arr_user[$r['id']] = $r;
        }
        return $arr_user;
    }

    static function getAllArrUserSale() {
        $arr_user = array();
        //$sql = "SELECT * FROM " . T_USER_SALE . " WHERE status = 1 ";
        //if($role > 0) {
        //    if($role == 2) $sql .= " AND (role = '" . $role . "' OR username ='ngapham' OR username ='hn_trangptt' OR username ='hn_thuyntk' OR username ='bongbambee') ";
        //    else $sql .= " AND role = '" . $role . "' "; 
        //}
        //$sql .= "ORDER BY province, fullname";
        //$res = DB::query( $sql );

        $ary = self::getUserSale();
        foreach ($ary as $key => $r) {
            //while($r = @mysql_fetch_assoc($res)){
            if ($r['role'] > 0) {
                if ($r['fullname'] == "")
                    $r['fullname'] = $r['username'];
                if ($r['role'] == 1) {
                    $arr_user[$r['id']] = $r;
                } else {
                    $isSale = strpos($r['action'], 'sale_redit');
                    if ($isSale == TRUE) {
                        $arr_user[$r['id']] = $r;
                    }
                }
            }
        }
        return $arr_user;
    }

    static function getAllArrUserTest() {
        $arr_user = array();
        $ary = self::getUserSale();
        foreach ($ary as $key => $r) {
            if ($r['role'] > 0) {
                if ($r['fullname'] == "")
                    $r['fullname'] = $r['username'];
                if ($r['role'] == 2) {
                    $arr_user[$r['id']] = $r;
                } else {
                    $isSale = strpos($r['action'], 'test_redit');
                    if ($isSale == TRUE) {
                        $arr_user[$r['id']] = $r;
                    }
                }
            }
        }
        return $arr_user;
    }

    static function getAllArrUserContent() {
        $arr_user = array();
        $ary = self::getUserSale();
        foreach ($ary as $key => $r) {
            if ($r['role'] > 0) {
                if ($r['fullname'] == "")
                    $r['fullname'] = $r['username'];
                if ($r['role'] == 3) {
                    $arr_user[$r['id']] = $r;
                } else {
                    $isSale = strpos($r['action'], 'content_redit');
                    if ($isSale == TRUE) {
                        $arr_user[$r['id']] = $r;
                    }
                }
            }
        }
        return $arr_user;
    }

    static function getAllArrUserPhotograph() {
        $arr_user = array();
        $ary = self::getUserSale();
        foreach ($ary as $key => $r) {
            if ($r['role'] > 0) {
                if ($r['fullname'] == "")
                    $r['fullname'] = $r['username'];
                if ($r['role'] == 3) {
                    //$arr_user[$r['id']] = $r;
                    //}else{
                    $isSale = strpos($r['action'], 'content_rphoto');
                    if ($isSale == TRUE) {
                        $arr_user[$r['id']] = $r;
                    }
                }
            }
        }
        return $arr_user;
    }

    static function getAllArrUserCoordinator() {
        $arr_user = array();
        $ary = self::getUserSale();
        foreach ($ary as $key => $r) {
            if ($r['role'] > 0) {
                if ($r['fullname'] == "")
                    $r['fullname'] = $r['username'];
                if ($r['role'] == 4) {
                    $arr_user[$r['id']] = $r;
                } else {
                    $isSale = strpos($r['action'], 'cond_redit');
                    if ($isSale == TRUE) {
                        $arr_user[$r['id']] = $r;
                    }
                }
            }
        }
        return $arr_user;
    }

    static function getSale() {
        $key = "saledeal";
        $sale = CacheLib::get($key);
        if (empty($sale)) {
            $res = DB::query("SELECT * FROM " . T_ACCOUNTS . " WHERE status > 0 AND is_active > 0 AND type = 1 ORDER BY province, fullname");
            while ($r = @mysql_fetch_assoc($res)) {
                $sale[$r['id']] = $r;
            }
            CacheLib::set($key, $sale);
        }
        return $sale;
    }

    static function getArrUsers($option = "false", $def_id = 0) {
        $key = "users_mc";
        $user = CacheLib::get($key);
        if (empty($user)) {
            $res = DB::query("SELECT * FROM " . T_ACCOUNTS . " WHERE status > 0 AND is_active > 0 AND type = 1 ORDER BY province, fullname");
            while ($r = @mysql_fetch_assoc($res)) {
                $user[$r['id']] = $r;
            }
            CacheLib::set($key, $user);
        }

        if ($option) {
            $opt = '<option value="0"> - Chọn nhân viên - </option>';
            $now_province = -1;
            foreach ($user as $key => $value) {
                //tinh toan truoc id tinh thanh
                if (stripos($value['province'], ',') !== false) {
                    $value['province'] = explode(',', $value['province']);
                    $value['province'] = $value['province'][0];
                }
                //kiem tra gan group
                if ($now_province != $value['province']) {
                    if ($now_province != -1) {
                        $opt .= '</optgroup>';
                    }
                    $now_province = $value['province'];
                    if ($now_province == 0) {
                        $opt .= '<optgroup label="Khác">';
                    } else {
                        $opt .= '<optgroup label="' . (isset(CGlobal::$province_active[$now_province]['title']) ? CGlobal::$province_active[$now_province]['title'] : "") . '">';
                    }
                }
                $opt .= '<option value="' . $value['id'] . '"' . ($value['id'] == $def_id ? ' selected' : '') . '>' . $value['fullname'] . '</option>';
            }
            return $opt;
        }
        return $user;
    }

    //lấy danh sách văn phòng
    static $aryStore = array();

    static function listOffice() {
        $aryOffice = array();
        if (!empty(self::$aryStore)) {
            $aryOffice = self::$aryStore;
        } else {
            $sql = "SELECT * FROM office order by parent_id asc";
            $re = DB::query($sql);
            $aryRep = array('Kho ', 'MuaChung ', 'Muachung ');

            while ($row = mysql_fetch_assoc($re)) {
                $row['name'] = str_replace($aryRep, array('', '', ''), $row['name']);
                $aryOffice[$row['id']] = $row;
            }
            if (isset(DB::$db_result)) {
                mysql_free_result(DB::$db_result);
            }
            self::$aryStore = $aryOffice;
        }
        return $aryOffice;
    }

    /*
     * lấy tên office
     */

    static function getNameOffice($id) {
        $strOffice = '';
        if (!$id) {
            return '';
        }
        $sql = "select name from office where id = $id";
        $aryOffice = DB::fetch($sql);

        if ($aryOffice['name']) {
            $strOffice = $aryOffice['name'];
        }
        return $strOffice;
    }

    /*
     * lấy mảng office parent = 0
     */

    static function listParentOffice() {
        $aryOffice = array();
        $sql = "SELECT * FROM office WHERE parent_id = 0";
        $re = DB::query($sql);
        $aryRep = array('Kho ', 'MuaChung ', 'Muachung ');
        while ($row = mysql_fetch_assoc($re)) {
            $row['name'] = str_replace($aryRep, array('', '', ''), $row['name']);
            $aryOffice[$row['id']] = $row;
        }
        return $aryOffice;
    }

    static function getCategoryArr() {
        if (!empty(FunctionLib::$aryCategory)) {
            return FunctionLib::$aryCategory;
        }
        $items = array();
        $re = DB::query("SELECT * FROM " . T_CATEGORY . " WHERE status = 1  ORDER BY weight, safe_title");
        if ($re) {
            while ($row = mysql_fetch_assoc($re)) {
                $items[$row['type']][$row['id']] = $row;
            }
        }
        return $items;
    }

    static function getCategoryByID($id = 0, $type = 2) {
        $cat_list = CGlobal::$category;
        if (isset($cat_list[$type]) && isset($cat_list[$type][$id])) {
            return $cat_list[$type][$id];
        }
        return array();
    }

    //lấy danh sách khoang
    static $aryCabins = array();

    static function listCabins($office = '') {
        $cabins = array();
        if (!empty(self::$aryCabins) && $office = '') {
            $cabins = self::$aryCabins;
        } else {
            $sql = "SELECT * FROM office_cabins where 1=1";
            if ($office != '') {
                $office = FunctionLib::trimID($office);
                $sql .= " and office_id in ($office)";
            }
            $sql .= " order by id asc";
            $re = DB::query($sql);

            while ($row = mysql_fetch_assoc($re)) {
                $cabins[$row['id']] = $row;
            }
            if (isset(DB::$db_result)) {
                mysql_free_result(DB::$db_result);
            }
            self::$aryCabins = $cabins;
        }
        return $cabins;
    }

    //lấy số sp đang được lưu tạm
    static $numWareTemp = 0;

    static function getNumWareTemp() {
        global $display;
        $user = User::getUser(User::id());
        $condition = array();
        $search_value = '';
        $condition['store_id'] = "store_id=" . $user['office'];
        if ($user['cabin'] > 0) {
            $condition['cabin'] = "cabin_id=" . $user['cabin'];
        }
        $condition['user_inid'] = "user_inid=" . $user['id'];
        //$condition['time'] = "DATE_SUB(CURDATE(),INTERVAL 1 DAY) <  FROM_UNIXTIME(time_create, '%Y-%m-%d')";
        $time = TIME_NOW - 3600 * 24;
        $condition['time'] = "$time < time_create";
        $search_value = FunctionLib::addCondition($condition, true);

        $sql = "SELECT count(*) as total FROM " . T_WARE_TEMP . " $search_value ";
        $total = DB::fetch($sql, 'total');
        FunctionLib::$numWareTemp = $total;
        $display->add('num_temp', $total);
    }

    /**
     * Lay phi chuyen phat nhanh cua gio hang
     * @param int $nbItem So luong san pham trong gio hang
     * @param int $totalWeight Tong khoi luong do bang gram cua gio hang
     */
    static function getFeeCPN($nbItem, $totalWeight) {
        $f = 5000;
        if ($nbItem > 3)
            $f = 10000;
        if ($totalWeight <= 100) {
            $f += 20000;
        } elseif ($totalWeight <= 250) {
            $f += 25000;
        } elseif ($totalWeight <= 500) {
            $f += 35000;
        } elseif ($totalWeight <= 1000) {
            $f += 40000;
        } elseif ($totalWeight <= 1500) {
            $f += 55000;
        } elseif ($totalWeight <= 2000) {
            $f += 65000;
        } else {
            // Moi kg troi hon 2kg thi tinh them 5K
            $dura = $totalWeight - 2000;
            $oneKg = 5000;
            $fDura = $oneKg * ceil($dura / 1000);
            $f += 65000 + $fDura;
        }

        return $f;
    }

    static function getImplementationCosts($type = 0) {
        $arrCosts = array();
        if ($type == 0) {
            /** lương cho sale * */
        } elseif ($type == 1) {
            /** lương cho nội dung * */
            $arrCosts ['products'] = array(
                'quota' => 115,
                'new' => 20000,
                'redeal' => 10000
            );
            $arrCosts ['travel'] = array(
                'quota' => 115,
                //'none' => ceil(20000*2.5),
                //'other' => ceil(20000*1.5),
                'none' => 2.5, // service_method = 1
                'hotel' => 1.5 // service_method = 0 
            );
            $arrCosts ['photography'] = array(
                'quota' => 460,
                'in_door' => 1,
                'out_door' => 7,
                'other' => 70000,
                'none' => 56000
            );
        } elseif ($type == 2) {
            /** lương cho test * */
        }
        return $arrCosts;
    }

    static function getCurrProviceByIdOffice($idOffice = 0) {
        if ($idOffice == 0)
            return 0;
        $province = $parent_id = 0;
        $arrOffice = self::listOffice();
        $parent_id = $arrOffice [$idOffice] ['parent_id'];
        if ($parent_id == 0)
            $parent_id = $idOffice;
        //if($parent_id == 0 ) return 0;
        //echo $arrOffice [ $idOffice ] [ 'parent_id' ];
        $province = $arrOffice [$parent_id] ['province'];
        return $province;
    }

    static function getProviderItem($str_item) {
        $aryNcc = $aryContract = $arrContract = $arrProvider = $arrItem = $groupId = array();
        if ($str_item == '')
            return 0;
        $arr_appendixe_item = array();
        $appendixe_item = DB::fetch_all("SELECT appendix_id, item_id FROM " . T_APPENDIXE_ITEMS . " WHERE item_id IN ( $str_item ) ORDER BY appendix_id DESC");
        if (!empty($appendixe_item)) {
            foreach ($appendixe_item as $row_item) {
                $arr_appendixe_item[] = $row_item['appendix_id'];
                $str_item .= "," . $row_item['item_id'];
                $groupId[$row_item['appendix_id']]['id'] = $row_item['item_id'];
            }
        }
        if (!empty($arr_appendixe_item)) {
            $re_appendixes = DB::query("SELECT id, contract_id, item_id FROM " . T_APPENDIXES . " WHERE status > 0 AND (id IN (" . implode(",", $arr_appendixe_item) . ") OR item_id IN ( $str_item )) ORDER BY contract_id DESC, `index` ASC, startTime ASC");
            while ($rows = mysql_fetch_assoc($re_appendixes)) {
                $arrContract[] = $rows['contract_id'];
                $arrItem[$rows['item_id']] = $rows['item_id'];
                if (isset($groupId[$rows['id']]['id']) && $groupId[$rows['id']]['id'] > 0)
                    $aryNcc[$groupId[$rows['id']]['id']] = array('contract_id' => $rows['contract_id']);
                $aryNcc[$rows['item_id']] = array('contract_id' => $rows['contract_id']);

                $aryContract[$rows['contract_id']] ['id'] = $rows['contract_id'];
                $aryContract[$rows['contract_id']] ['item_id'] [$rows['item_id']] = $rows['item_id'];
                if (isset($groupId[$rows['id']]['id']) && $groupId[$rows['id']]['id'] > 0) {
                    $aryContract[$rows['contract_id']] ['item_id'] [$groupId[$rows['id']]['id']] = $groupId[$rows['id']]['id'];
                }
            }
        } else {
            $re_appendixes = DB::query("SELECT id, contract_id, item_id FROM " . T_APPENDIXES . " WHERE status > 0 AND item_id IN ( $str_item ) ORDER BY contract_id DESC, `index` ASC, startTime ASC");
            while ($rows = mysql_fetch_assoc($re_appendixes)) {
                $arrContract[] = $rows['contract_id'];
                $arrItem[$rows['item_id']] = $rows['item_id'];
                if (isset($groupId[$rows['id']]['id']) && $groupId[$rows['id']]['id'] > 0)
                    $aryNcc[$groupId[$rows['id']]['id']] = array('contract_id' => $rows['contract_id']);
                $aryNcc[$rows['item_id']] = array('contract_id' => $rows['contract_id']);

                $aryContract[$rows['contract_id']] ['id'] = $rows['contract_id'];
                $aryContract[$rows['contract_id']] ['item_id'] [$rows['item_id']] = $rows['item_id'];
                if (isset($groupId[$rows['id']]['id']) && $groupId[$rows['id']]['id'] > 0) {
                    $aryContract[$rows['contract_id']] ['item_id'] [$groupId[$rows['id']]['id']] = $groupId[$rows['id']]['id'];
                }
            }
        }
        if (!empty($arrContract)) {
            $re_contract = DB::query("SELECT id, provider_id FROM " . T_CONTRACTS . " WHERE id IN (" . implode(",", $arrContract) . ")");
            while ($rows = mysql_fetch_assoc($re_contract)) {
                $arrProvider[] = $rows['provider_id'];
                $aryContract[$rows['id']] ['provider_id'] = $rows['provider_id'];
            }

            $re_provider = DB::query("SELECT id, title, phone FROM " . T_PROVIDERS . " WHERE id IN (" . implode(",", $arrProvider) . ")");
            while ($rows = mysql_fetch_assoc($re_provider)) {
                foreach ($aryContract as $k_Contract => $v_Contract) {
                    if ($aryContract[$k_Contract] ['provider_id'] == $rows['id']) {
                        $aryContract[$k_Contract] ['provider_name'] = $rows['title'];
                        $aryContract[$k_Contract] ['provider_phone'] = $rows['phone'];
                    }
                }
            }
        }

        if (!empty($aryNcc)) {
            foreach ($aryNcc as $k_ncc => $v_ncc) {
                if (isset($aryContract[$v_ncc ['contract_id']]) && $v_ncc ['contract_id'] > 0) {
                    $aryNcc [$k_ncc] ['provider_id'] = $aryContract[$v_ncc ['contract_id']] ['provider_id'];
                    $aryNcc [$k_ncc] ['provider_name'] = $aryContract[$v_ncc ['contract_id']] ['provider_name'];
                    $aryNcc [$k_ncc] ['provider_phone'] = $aryContract[$v_ncc ['contract_id']] ['provider_phone'];
                }
            }
        }

        return $aryNcc;
    }

    static function insert_pay_order_office($val_o_insert) {
        if ($val_o_insert != '') {
            DB::query("INSERT INTO pay_order_office (office_id,total_price,price,parent_order_id, order_id, item_id, transaction_id, transaction_pay_type, transaction_type, customer_id, customer_pay_time) VALUES $val_o_insert");
        }
    }

	static function log_pay_order_office($val_o_insert) {
		if ($val_o_insert != '') {
			DB::query("INSERT INTO pay_order_office (user_created_id,user_created_name,office_id,total_price,price,parent_order_id, order_id, item_id, transaction_id, transaction_pay_type, transaction_type, customer_id, customer_pay_time) VALUES $val_o_insert");
		}
	}
    
    /*
     * Trả ra chuỗi hoặc mảng các thành phần đã được phân tích
     * $str_item: chuỗi hỗn tạp
     * $type: kiểu trả ra 0-string, 1-array
     */
    static function standardizeItemIdStr($str_item, $type=0) {
        if (empty($str_item))
            return 0;
        $str_item = trim(preg_replace('#([\s]+)|(,+)#', ',', trim($str_item)));
        $arrItem = explode(',', $str_item);
        $arrResult = array();
        foreach ($arrItem as $key => $cartId) {
            $cart_id = (int) trim($cartId);
            if ($cart_id > 0)
                $arrResult[] = $cart_id;
        }
        if (empty($arrResult))
            return ($type == 1)? array() : '';
        else
            return ($type == 1)? $arrResult : join(',', $arrResult);
    }

    //log file
    static function log( $str = '' ) {
        $view = FunctionLib::getParamInt('view', 0);
        $del = FunctionLib::getParamInt('del', 0);
        $logFile = ROOT_PATH."tools/log_error.txt";
        echo $view.' == '.$str;
        if( $del == 1 ) {
            @unlink($logFile);
            return;
        }
        if( $view == 0 && $str != '' ) {
            $user = User::getUser( User::id() );
            $log = fopen($logFile,'a+');
            fwrite($log, "<b>".$user['username']."</b>: Called on : ".date('d-m-Y H:i:s', TIME_NOW +3600*+7));
            //fwrite($log, file_get_contents("php://stdin"));
            fwrite($log, "[ $str ]\n");
            fclose($log);
        } else {
            $file = file_get_contents( $logFile );
            $arfile = array_filter( explode( "\n", $file ) );
            echo "Tổng lần lỗi: ".count($arfile)."<br>";
            foreach( $arfile as $log ) {
                echo $log."</br>";
            }
        }
    }
    
    
     /**
	 * Thêm rel = "nofollow" vào thẻ <a>
	 */
	static function relNofollow($input = '') {
		if ($input != '') {
			return preg_replace_callback('@&lt;a.+?href=&quot;(.+?)&quot;.*?&gt;@', array('FunctionLib', 'rel'), $input);
		}
		return '';
	}

	static function rel($m) {
		$aTag = $m[0];
		$currentURL = $m[1];
		if (strpos($currentURL, 'muachung') === false && strpos($currentURL, 'gaolut') === false) {
			if (strpos($aTag, 'rel=&quot;nofollow&quot;') !== false) {
				return $aTag;
			}
			// Them nofollow
			return substr($aTag, 0, -4) . ' rel=&quot;nofollow&quot;' . '&gt;';
		}
		return $m[0];
	}

    static function getOfficeByID($office_id, $city){
        if($office_id > 0){
            $office_list = FunctionLib::getOffice();
            if(isset($office_list[$city])){
                foreach($office_list[$city] as $office){
                    if($office['id'] == $office_id){
                        return $office;
                    }
                }
            }
        }
        return false;
    }

	/**
	 * End
	 */
	 
	 public static function getTree($aryInput, $strField, $objId = 0) {
		$aryBegin = array();
		$aryBegin = $aryInput;
		$aryOutput = array();
		$paren = $objId;
		if($aryBegin) {
			foreach($aryBegin as $i=>$Begin) {
				if($Begin[$strField] == $paren && $Begin['status'] == 1) {
					$aryOutput[$i] = $Begin;
					unset($aryBegin[$i]);
					$aryOutput[$i]['child'] = FunctionLib::getTree($aryBegin, $strField, $Begin['id']);
				}
				$paren = $objId;
			}
		}
		return $aryOutput;
	}

	public static function sortTree($arInput) {
		$arOut = array();
		foreach( $arInput as $k=>$in ) {
			if( isset( $in['child'] ) && !empty($in['child']) ) {
				$arOut[$in['id']] = $in;
				unset($arInput[$in['id']]);
			}
		}
		if( !empty($arInput) )
			foreach( $arInput as $k=>$in ) {
				$arOut[$in['id']] = $in;
			}
		return $arOut;
	}

	public static function clearStringSpecialInput($string){
		$array_result = array();
		$array = explode(',',$string);
		foreach($array as $k=>$v){
			if($v){
				$array_result[] = (int)$v;
			}
		}
		$string = trim(implode(',',$array_result));
		return $string;
	}

    public static function show_random($list) {
        if (!is_array($list)) return $list;
        $keys = array_keys($list);
        shuffle($keys);
        $random = array();
        foreach ($keys as $key) {
            $random[$key] = $list[$key];
        }
        return $random;
    }

    static function debug($array) {
        //if($_SERVER['HTTP_HOST'] != 'banbuonvpp.vn') {
            echo '<pre>';
            print_r($array);
            die;
        //}
    }
}

?>
