<?php
class CURL {
	var $callback = false;
	var $ch = false;
	function setCallback($func_name) {
	    $this->callback = $func_name;
	}
	function CURL($url = null) {
		if ($url) {
			$this->ch = curl_init($url);
		}
		else $this->ch = curl_init();
	}
	function doRequest($method, $url, $vars, $close = true, $setopt = array()) {
	    
	    curl_setopt($this->ch, CURLOPT_URL, $url);
	    curl_setopt($this->ch, CURLOPT_HEADER, ( isset( $setopt['CURLOPT_HEADER'] ) ? $setopt['CURLOPT_HEADER'] : 1 ) );
	    curl_setopt($this->ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	    curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, ( isset( $setopt['CURLOPT_FOLLOWLOCATION'] ) ? $setopt['CURLOPT_FOLLOWLOCATION'] : 1 ) );
	    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, ( isset( $setopt['CURLOPT_RETURNTRANSFER'] ) ? $setopt['CURLOPT_RETURNTRANSFER'] : 1 ) );
	    curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	    curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	    curl_setopt($this->ch, CURLOPT_TIMEOUT, ( isset( $setopt['CURLOPT_TIMEOUT'] ) ? $setopt['CURLOPT_TIMEOUT'] : 10 ));
	    
	    //dungbt them vao de post duoc len lighttpd
	    curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Expect:'));
	    
	    if ($method == 'POST') {
	        curl_setopt($this->ch, CURLOPT_POST, 1);
	        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $vars);
	    }
	    $data = curl_exec($this->ch);
		if($close) {
			curl_close($this->ch);
		}
	    if ($data) {
	        if ($this->callback)
	        {
	            $callback = $this->callback;
	            $this->callback = false;
	            return call_user_func($callback, $data);
	        } else {
	            return $data;
	        }
	    } else {
	        return curl_error($this->ch);
	    }
	}
	
	function close() {
		curl_close($this->ch);
	}
	
	function get($url, $close = true, $setopt = array()) {
	    return $this->doRequest('GET', $url, 'NULL', $close, $setopt);
	}
	
	function post($url, $vars, $close = true, $setopt = array()) {
	    return $this->doRequest('POST', $url, $vars, $close, $setopt);
	}
	
	
	
	/**
	 *get content by method CURL 
	 * @author PhongCT added
	 * @param string $url
	 * @return String HTML
	 */
	function get_content($url){
		
	  // Setup headers - I used the same headers from Firefox version 2.0.0.6
	  // below was split up because php.net said the line was too long. :/
	  $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	  $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	  $header[] = "Cache-Control: max-age=0";
	  $header[] = "Connection: keep-alive";
	  $header[] = "Keep-Alive: 300";
	  $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	  $header[] = "Accept-Language: en-us,en;q=0.5";
	  $header[] = "Pragma: "; // browsers keep this blank.
	
	  curl_setopt($this->ch, CURLOPT_URL, $url);
	  //curl_setopt($this->ch, CURLOPT_PROXY, '222.255.24.100:9999');
	  //curl_setopt($this->ch, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
	  curl_setopt($this->ch, CURLOPT_USERAGENT,  "Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en-US; rv:1.8.1.1) Gecko/20061223 Firefox/2.0.0.1");
	  curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
	  curl_setopt($this->ch, CURLOPT_REFERER, 'http://www.google.com');
	  curl_setopt($this->ch, CURLOPT_ENCODING, 'gzip,deflate');
	  curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
	  curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
	  $html = curl_exec($this->ch); // execute the curl command

	  //$this->close(); // close the connection
	  
	  return $html; // and finally, return $html
	}
	
	
	
	
	/**
	 * get url redirects
	 *
	 * @param string $url
	 * @return array $url
	 */
	function get_header_by_url() {
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => true,    // return headers
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_USERAGENT      => "spider", // who am i
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
		);
		curl_setopt_array( $this->ch, $options );
		$content = curl_exec( $this->ch );
		$err     = curl_errno( $this->ch );
		$errmsg  = curl_error( $this->ch );
		$header  = curl_getinfo( $this->ch );
		return $header;
	}
}

function getMessageFromCurl($data = ''){
	$output = var_export($data, true);
	$mess = explode('[error]', substr($output,1,-1));
	return $mess;
}