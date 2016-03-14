<?php
class DB{
	static $db_connect_id	=false;			// connection id of this database
	static $db_result		=false;			// current result of an query
	static $db_num_queries 	= 0;
	// Debug
	static $num_queries 	= 0;			// number of queries was done
	static $query_debug 	= "";
	static $query_time;
	
	static $replicate_query = true;			// mac dinh cho tat ca query, neu co quey khong dung replicate : false, xu ly xong phai tra ve true.
	static $slave_connect 	= false;		// connection id of this database
	static $master_connect 	= false;		// current result of an query
	static $temp_instance 	= false;		// 
	
	function DB(){}
	
	function __destruct() {
		DB::close();
	}
	
	static function db_connect($sqlserver, $sqluser, $sqlpassword, $dbname){
		$db_connect_id = mysql_connect($sqlserver, $sqluser, $sqlpassword);
		if ($db_connect_id && !empty($db_connect_id) && $db_connect_id != "NULL" && $db_connect_id != NULL){
			if (!$dbselect = mysql_select_db($dbname, $db_connect_id)){
				System::sendSVEmail ( 
								'manhquynh1984@gmail.com',
								'Select DB : '.$dbname.' ERROR - '.date('d-M-Y'),
								'Link:'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'].' <br/>'.
								'Ip:'.EnBacLib::ip().' <br/>
								 Server: '. $_SERVER['SERVER_ADDR'].'  <br/>
								 Time '. date('d-M-Y H:i:s') . ' <br/>
								 <b>$dbselect = '.var_export($dbselect, true).'</b><br/>'.
								 print_r($_REQUEST, true).'<hr/><hr/><hr/>
							 <br/>--end'
						);
						
				mysql_close($db_connect_id);
				$db_connect_id = $dbselect;
			}
			else {
				mysql_query ('SET NAMES UTF8', $db_connect_id);
			}
		}
		else {
			
			System::sendSVEmail ( 
								'manhquynh1984@gmail.com',
								'Connect DB Error: '.WEB_ROOT.' - '.date('d-M-Y'),
								'Link:'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'].' <br/>'.
								'Ip:'.EnBacLib::ip().' <br/>
								 Server: '. $_SERVER['SERVER_ADDR'].'  <br/>
								 Time '. date('d-M-Y H:i:s') . ' <br/><br/>'.
								 print_r($_REQUEST, true).'<hr/><hr/><hr/>
							 <br/>--end'
						);
						
			die('Error: Could not connect to the database!');
			return false;
		}
		return $db_connect_id;
	}

	static function query($query , $call_pos = ''){
		self::$db_result = false;
		
		if (!empty($query)){

			if (is_debug() && User::is_root()) {
				$start_time = microtime(true);
			}
			
			if(!self::$master_connect){
				//self::$master_connect = self::db_connect( 'server' , 'user_name' , 'password' , 'db_name');
				self::$temp_instance = new DB();
				self::$master_connect = self::db_connect( DB_MASTER_SERVER , DB_MASTER_USER , DB_MASTER_PASSWORD , DB_MASTER_NAME);
			}
			
			$connection_switch = self::$master_connect;
			
			self::$db_connect_id = $connection_switch;
			
			if(!self::$db_connect_id || !(self::$db_result = @mysql_query($query, self::$db_connect_id))){	
				if(!preg_match('#localhost#', WEB_ROOT) && !preg_match('#alpha#', WEB_ROOT)) {
					$error_code = (!self::$db_connect_id) ? ' $master_connect='. var_export(self::$master_connect, true) :  '<b>mysql_error: '.mysql_error(self::$db_connect_id).'  in <br/>
								['.$query .']</b>'; 
					System::sendSVEmail ( 
								'manhquynh1984@gmail.com',
								'Error '.WEB_ROOT.' - '.date('d-M-Y'),
								'Link:'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'].' <br/>'.
								'Ip:'.EnBacLib::ip().' <br/>
								 Server: '. $_SERVER['SERVER_ADDR'].'  <br/>
								 Time '. date('d-M-Y H:i:s') . ' <br/>
								 Error_code=
								 '.$error_code .'</b><br/>'.
								print_r($_REQUEST, true).'<hr/><hr/><hr/>'.
								print_r(debug_backtrace(), true).'
							 <br/>--end'
						);
				}
								
				if(is_debug()){
					echo '<hr/><p><font face="Courier New,Courier" size=4><b>'.mysql_error(self::$db_connect_id).'  in '.$query .'</b></font><br>'.($call_pos?"<b>Run at:</b> $call_pos":"");
					echo '===============<pre style="text-align: left">'; print_r(debug_backtrace()); echo '</pre>===============';
					exit;
				}
				else{
					echo '<p><font face="Courier New,Courier" size=4><b>Có lỗi khi truy vấn cở sở dữ liệu</b></font><br>';
					
					$module_name = (Module::$name!='') ? Module::$name : "-- Enbac system";
					
					$fp = fopen(ROOT_PATH.'_cache/query_db_errors.'.date('d_M_Y').'.txt', 'a');
					fwrite($fp, "\n\r\n\r\n\r\\" .date('h:i:s d/m/Y') .' - Module '.$module_name. ': '.mysql_error(self::$db_connect_id).'  in '.$query .' '.'\n===============\n<pre style="text-align: left">' .print_r(debug_backtrace(), true). '</pre>\n===============\n');
					fclose($fp);
					exit;
				}
			}
			self::$db_num_queries++;
			
			if (is_debug() && User::is_root()) {
				
				$module_name = (Module::$name!='') ? Module::$name : "-- Save system";
				
				$effect_rows = mysql_affected_rows ( self::$db_connect_id );
				$rtime = microtime ();
				$rtime = explode ( " ", $rtime );
				$rtime = $rtime [1] + $rtime [0];
				$end_time = $rtime;
				$doing_time = round ( ($end_time - $start_time), 5 ) . "s";
				$backTrace = debug_backtrace();
				$backTrace = array_reverse($backTrace);
				$traceText = praseTrace($backTrace);
				
				if (preg_match ( "/^select/i", $query )) {
					$eid = mysql_query ( "EXPLAIN $query", self::$db_connect_id );
					CGlobal::$query_debug .= 
					"<tr>
						<td colspan='8' style='background-color:#FFC5Cb'>".$module_name." - <b>Query :</b> $query</td>
					</tr>
					<tr bgcolor='#edeceb'>
						<td><b>Table</b></td>
						<td><b>Type</b></td>
						<td><b>Possible keys</b></td>
						<td><b>Key</b></td>
						<td><b>Key len</b></td>
						<td><b>Ref</b></td>
						<td><b>Rows</b></td>
						<td><b>Extra</b></td>
					</tr>";
					while ( $array = mysql_fetch_array ( $eid ) ) {
						$type_col = '#FFFFFF';
						if ($array ['type'] == 'ref' or $array ['type'] == 'eq_ref' or $array ['type'] == 'const') {
							$type_col = '#D8FFD4';
						} else if ($array ['type'] == 'ALL') {
							$type_col = '#FFEEBA';
						}
						
						CGlobal::$query_debug .= 
						"<tr bgcolor='#FFFFFF'>
						      <td>$array[table]&nbsp;</td>
						      <td bgcolor='$type_col'>$array[type]&nbsp;</td>
						      <td>$array[possible_keys]&nbsp;</td>
						      <td>$array[key]&nbsp;</td>
						      <td>$array[key_len]&nbsp;</td>
						      <td>$array[ref]&nbsp;</td>
						      <td>$array[rows]&nbsp;</td>
						      <td>$array[Extra]&nbsp;</td>
						</tr>\n";
					}
					
					CGlobal::$query_time += $doing_time;
					
					if ($doing_time > 0.01) {
						$doing_time = "<span style='color:red'><b>$doing_time</b></span>";
					}
					
					CGlobal::$query_debug .= 
						"<tr>
							<td colspan='8' bgcolor='#fff'>
								<b>MySQL time</b>: $doing_time</b> <a href='javascript:void(0)' onclick=\"jQuery(this).parent().parent().next().toggle()\">Show/Hide detail...</a></div>
							</td>
						</tr>
						<tr style='display:none'>
							<td colspan='8'>
								$traceText
							</td>
						</tr>";
				} else {
					if ($doing_time > 0.01) {
						$doing_time = "<span style='color:red'><b>$doing_time</b></span>";
					}
					CGlobal::$query_debug .= 
					"<tr>
						<td bgcolor='#edeceb' colspan='8'>".$module_name." - <b>Non Select Query : </b>$query</td>
					</tr>
					<tr>
						<td bgcolor='#fff' colspan='8'>
							<div><a href='javascript:void(0)' onclick=\"jQuery(this).parent().next().toggle()\">Show/Hide detail...</a></div>
							<div style='display:none'>$traceText</div>
						</td>
					</tr>
					<tr>
						<td bgcolor='#fff' colspan='8'><b>MySQL time</b>: $doing_time</span></td>
					</tr>";
				}
				
			}	
		}
		
		return self::$db_result;
	}
	
	// function  close
	// Close SQL connection
	// should be called at very end of all scripts
	// ------------------------------------------------------------------------------------------
	static function close($con_id=false){
		if($con_id){
			$result = @mysql_close($con_id);
			return $result;
		}
		else{
			if (isset(self::$db_result) && self::$db_result){
				@mysql_free_result(self::$db_result);
				self::$db_result=false;
			}
				
			if (isset(self::$master_connect) && self::$master_connect){
				@mysql_close(self::$master_connect);
				self::$master_connect = false;
			}
			
			if (isset(self::$slave_connect) && self::$slave_connect){
				@mysql_close(self::$slave_connect);
				self::$slave_connect = false;
			}
		}
		return true;
	}
	
	static function count($table, $condition=false,$call_pos=''){
		return self::fetch('SELECT COUNT(*) AS total FROM `'.$table.'`'.($condition?' WHERE '.$condition:''),'total',0,$call_pos);
	}
	
	//Lay ra mot ban ghi trong bang $table thoa man dieu kien $condition
	//Neu bang duoc cache thi lay tu cache, neu khong query tu CSDL
	static function select($table, $condition, $getField = '',$call_pos = ''){
        $getField = ($getField != '')? $getField : '*';
		if($result = self::select_id($table, $condition,$getField,$call_pos)){
			return $result;
		}
		else{
			return self::exists('SELECT '.$getField.' FROM `'.$table.'` WHERE '.$condition.' LIMIT 0,1',$call_pos);
		}
	}
	
	static function select_id($table, $condition, $getField = '',$call_pos=''){
        $getField = ($getField != '')? $getField : '*';
		if($condition and !preg_match('/[^a-zA-Z0-9_#-\.]/',$condition)){
			return self::exists_id($table,$getField,$condition,$call_pos);
		}
		else{
			return false;
		}
	}
	
	//Lay ra tat ca cac ban ghi trong bang $table thoa man dieu kien $condition sap xep theo thu tu $order
	//Neu bang duoc cache thi lay tu cache, neu khong query tu CSDL
	static function select_all($table, $condition=false, $order = false,$call_pos=''){
		if($order){
			$order = ' ORDER BY '.$order;
		}
		if($condition){
			$condition = ' WHERE '.$condition;
		}
		self::query('SELECT * FROM `'.$table.'` '.$condition.' '.$order,$call_pos);
		return self::fetch_all();
	}
	
	

	//Tra ve ban ghi query tu CSDL bang lenh SQL $query neu co
	//Neu khong co tra ve false
	//$query: cau lenh SQL se thuc hien
	static function exists($query,$call_pos=''){
		self::query($query,$call_pos);
		if(self::num_rows()>=1){
			return self::fetch();
		}
		return false;
	}
	
	static function query_debug(){
		return self::$query_debug;
	}
	
	//Tra ve ban ghi trong bang $table co id la $id
	//Neu khong co tra ve false
	//$table: bang can truy van
	//$id: ma so ban ghi can lay
	static function exists_id($table, $id, $getField = '',$call_pos = ''){
		if($table && $id){
            $getField = ($getField != '')? $getField : '*';
			return  self::exists('SELECT '.$getField.' FROM `'.$table.'` WHERE id="'.$id.'" LIMIT 0,1',$call_pos);
		}
		return false;
	}
	
	/**
	 * Insert 1 hoac nhieu ban ghi = cach truyen vao 1 mang - tuy cach bo tri cua mang ma insert so luong ban ghi tuong ung
	 * 
	 * @param string $table: ten table
	 * @param array $mixed_values: array value
	 * @param boolean $replace: replace can cu vao field key
	 * @param string $call_pos: de debug
	 */
	static function insert($table, $mixed_values, $replace=false,$call_pos=''){
		if(empty($mixed_values)) return false;
		if($replace){
			$query='REPLACE';
		}
		else{
			$query='INSERT INTO';
		}
		
		$query.=' `'.$table.'`(';
		
		if(!isset($mixed_values[0]) || !is_array($mixed_values[0])) {
			$field = '`'.implode('`,`', array_keys($mixed_values)).'`';
			$mixed_values = array(0=>$mixed_values);
		}
		
		if(is_array($mixed_values)){
			
			$aryQuery = array();
			foreach ($mixed_values as $values) {
				
				$temp_query = '';
				$i=0;
				foreach($values as $key=>$value){

					if($i != 0){
						$temp_query.=',';
					}
					
					if(!isset($field)) {
						$field = '`'.implode('`,`', array_keys($values)).'`';
					}
	
					if($value==='NULL'){
						$temp_query.='NULL';
					}
					else{
						$temp_query.='\''.addslashes($value).'\'';
					}
					$i = 1;
				}
				
				array_push($aryQuery, '(' . $temp_query . ')');
				
			}
			$query.= $field. ') VALUES ';
			
			$query.= implode(',', $aryQuery);

			if(self::query($query,$call_pos)){
				$id = self::insert_id();		
				return $id;
			}
		}
	}
	
	static function delete($table, $condition,$call_pos=''){
		$query='DELETE FROM `'.$table.'` WHERE '.$condition;

		if(self::query($query,$call_pos)){
			return true;
		}
	}
	
	static function delete_id($table, $id,$call_pos=''){
		return self::delete($table, 'id="'.addslashes($id).'"',$call_pos);
	}
	
	static function update($table, $values, $condition,$call_pos=''){
		$query='UPDATE `'.$table.'` SET ';
		$i=0;
		
		if($values){
			foreach($values as $key=>$value){
				if($key===0 or is_numeric($key)){
					$key=$value;
					$value=Url::get($value);
				}
				
				if($i<>0){
					$query.=',';
				}
				
				if($key){
					if($value==='NULL'){
						$query.='`'.$key.'`=NULL';
					}
					else{
						$query.='`'.$key.'`=\''.self::escape($value).'\'';
					}
					$i++;
				}
			}
			$query.=' WHERE '.$condition;
		
			if(self::query($query,$call_pos)){
				return mysql_affected_rows();
			}
		}
		return false;
	}
	
	static function update_id($table, $values, $id){
		return self::update($table, $values, 'id="'.$id.'"');
	}
	
	static function num_rows($query_id = 0){
		if (!$query_id){
			$query_id = self::$db_result;
		}

		if ($query_id){
			$result = @mysql_num_rows($query_id);

			return $result;
		}
		else{
			return false;
		}
	}
	
	static function affected_rows(){
		if (isset(self::$db_connect_id) and self::$db_connect_id){
			$result = @mysql_affected_rows(self::$db_connect_id);

			return $result;
		}
		else{
			return false;
		}
	}
	
    /*========================================================================*/
    // Fetch a row based on the last query
    // Added by Nova 12.06.08
    /*========================================================================*/
    static function fetch_row($query_id = "") {
    
    	if ($query_id == ""){
    		$query_id =  self::$db_result;
    	}
    	
        $record_row = mysql_fetch_array($query_id, MYSQL_ASSOC);
        return $record_row;
    }
    
    /*
     @author PhongCT
     @todo get one row by sql query
     @param $sql string query
     @return array row
     */
    static function get_row($sql = "") {
    
    	if ($sql != ""){
		self::query($sql);	
    	}
	
		$query_id =  self::$db_result;
	
        $record_row = mysql_fetch_array($query_id, MYSQL_ASSOC);
        return $record_row;
    }

    /*
     @author PhongCT
     @todo get the first col in  first row
     @param $sql string query
     @return value (string - int ...)
     */
    static function get_one($sql = "") {
    
    	if ($sql != ""){
			self::query($sql);	
    	}
	
		$query_id =  self::$db_result;
		$record_row = mysql_fetch_array($query_id);
        return (isset($record_row[0])) ? $record_row[0] : 0;
    }

	/**
	 *get_assoc
	 *@author phongct
	 *
	 *@param string $sql : String sql
	 *@param boolean $groupResult
	 * 	$groupResult = fase: Array( [key1] => value1, [key2] => value 2 )
	 * 	$groupResult = true Array(  [key1] => Array ([0] =>  value1 ),  [key2] => Array ( [0] => value2 ) )
	 *
	 */
	static function get_assoc( $sql = "", $groupResult=false){
		if ($sql != ""){
			self::query($sql);	
		}
		
		$query_id =  self::$db_result;
		
		$results = array ();
		
		if (@mysql_num_fields ($query_id) > 2) {
			while ( is_array ( $row = mysql_fetch_assoc($query_id) ) ) {
				reset ( $row );
				$key = current ( $row );
				//unset ( $row [key ( $row )] );
				if ($groupResult) {
					$results [$key] [] = $row;
				} else {
					$results [$key] = $row;
				}
			}
		} elseif (@mysql_num_fields ($query_id) == 2) {
			while (is_array($row = mysql_fetch_array($query_id))) {
                if ($groupResult) {
                    $results[$row[0]][] = $row[1];
                } else {
                    $results[$row[0]] = $row[1];
                }
            }
		}
		elseif (@mysql_num_fields ($query_id) == 1) {
			while (is_array($row = mysql_fetch_array($query_id))) {
                if ($groupResult) {
                    $results['id'][] = $row[0];
                } else {
                    $results[] = $row[0];
                }
            }
		}
		
		return $results;
	}

    static function fetch($sql = false, $field = false, $default = false,$call_pos=''){
		if($sql){
			self::query($sql,$call_pos);
		}
		
		$query_id = self::$db_result;
		if ($query_id){
			if($result = @mysql_fetch_assoc($query_id)){
				if($field && isset($result[$field])){
					return $result[$field];
				}
				elseif ($default!==false){
					return $default;
				}
				return $result;
			}
			elseif ($default!==false){
				return $default;
			}
			return $default;
		}
		else{
			return false;
		}
	}

	static function fetch_all($sql=false,$call_pos=''){
		if($sql){
			self::query($sql,$call_pos);
		}
		$query_id = self::$db_result;

		if ($query_id){
			$result=array();
			while($row = @mysql_fetch_assoc($query_id)){
				if(isset($row['id']))
					$result[$row['id']] = $row;
				else 
					$result[] = $row;
			}

			return $result;
		}
		else{
			return false;
		}
	}

	static function fetch_array($sql=false,$call_pos=''){
		if($sql){
			self::query($sql,$call_pos);
		}
		$query_id = self::$db_result;

		if ($query_id){
			$result=array();
			while($row = @mysql_fetch_array($query_id)){				
				$result[] = $row;
			}

			return $result;
		}
		else{
			return false;
		}
	}

	static function fetch_all_array($sql=false,$call_pos=''){
		if($sql){
			self::query($sql,$call_pos);
		}
		$query_id = self::$db_result;

		if ($query_id){
			$result=array();
			while($row = @mysql_fetch_assoc($query_id)){
				$result[] = $row;
			}

			return $result;
		}
		else{
			return false;
		}
	}
	
	static function insert_id(){
		if (self::$db_connect_id){
			$result = mysql_insert_id(self::$db_connect_id);
			return $result;
		}
		else{
			return false;
		}
	}
	
	static function escape($sql){
		return addslashes($sql);
	}
	
	static function num_queries(){
		return self::$db_num_queries;
	}	
}
?>