<?php
/**
 * TRUE if you want to be in debug-mode
 * FALSE if not
 */
define("DEBUG", FALSE);
/**
 * Command to set the table lock for READ
 */
define("LOCKED_FOR_READ", "READ");
/**
 * Command to set the table lock for WRITE
 */
define("LOCKED_FOR_WRITE", "WRITE");

/**
 * This class handles connections to a mysql database.
 * The class is constructed to make it easy for someone to handle a mysql database
 * 
 * @author Staffan Olin
 * @version 0.2, 05.02.2002
 * 
 * @modified_by Staffan Olin [staffan.olin@cheerful.com]
 * @modification_date 2002.05.26
 * @modifications Fixed some bugs
 */
class mySQL {

	/**
    * The connection resource id
    *
    * @var  object
    */
	var $connection;

	/**
    * The selected database
    *
    * @var  object
    */
	var $selectedDb;

	/**
    * The result from a select-query
    *
    * @var  object
    */
	var $result;

	/**
    * Flag that tells if you are connected to the database or not
    *
    * @var  boolean
    */
	var $isConnected;

	/**
    * Flag that tells if you the tables are locked or not
    *
    * @var  boolean
    */
	var $isLocked;
	
	/**
	 *This will indicate what querytype the last query was
	 *
	 * @var	string
	 */
	var $queryType;

	/**
	 * This is the constructor of this mysql class.
	 * It creates a connection to the database, and if possible it sets the database to
	 * You can specify if you want to use persistant connections or not.
	 *
	 * @param 	string	The host to the mySQL server
	 * @param	string	The username you use to log on to the mySQL server
	 * @param	string	The password you use to log on to the mySQL server
	 * @param	string	The name of the database you wish to use
	 * @param	boolean	TRUE if you want to use persistant connections. Default is TRUE
	 * @return	boolean	TRUE when connection was successfull
	 * @access	public
	 */	
	function mySQL($sHost, $sUser, $sPassword, $sDatabase="", $bPersistant=TRUE) {
		$conFunc = "";
		/*if(!defined("DEBUG")) {
			define("DEBUG", FALSE);
		}
		if($this->getConnected()) {
			$this->closeConnection();
		}
		if($this->connection = ($bPersistant ? mysql_pconnect($sHost, $sUser, $sPassword) : mysql_connect($sHost, $sUser, $sPassword))) {
		//if($this->connection = ($bPersistant ? mysql_pconnect($sHost, $sUser, $sPassword) : mysql_connect($sHost, $sUser, $sPassword))) {
			$this->setConnected(TRUE);
			if($sDatabase) {
				$this->setDb($sDatabase);
			}
			//set charset to utf8
			mysql_query("SET NAMES 'utf8'", $this->connection);
			return TRUE;
		} 
		else {
			$this->setConnected(FALSE);
			return FALSE;
		}*/
	}
	
	/**
	 * This is the destructor of this class. It frees the result of a query,
	 * it unlocks all locked tables and close the connection to the database
	 * It does not return anything at all, so you will not know if it was sauccessfull
	 *
	 * @access	public
	 */
	function _mySQL() {
		if($this->result) {
			$this->freeResult();
		}
		if($this->getLocked()) {
			$this->unlock();
		}
		if($this->getConnected()) {
			$this->closeConnection();
		}
	}
	
	/**
	 * This function frees the result from a query if there is any result.
	 *
	 * @access	public
	 */
	function freeResult() {
		if($this->result) {
			@mysql_free_result($this->result);
		}
	}
	
	/**
	 * This function executes a query to the database.
	 * The function does not return the result of the query, you must call the
	 * function getQueryResult() to fetch the result
	 *
	 * @param 	string	The query-string to execute
	 * @return	boolean	TRUE if the query was successfull
	 * @access	public
	 */
	function query($query) {
		if(strlen(trim($query)) == 0) {
			$this->printError("No query got in function query()");
			return FALSE;
		}
		if(!$this->getConnected()) {
			$this->printError("Not connected in function query()");
			return FALSE;
		}
		$queryType = substr(trim($query), 0, strpos($query, " "));
		$this->setQueryType($queryType);
		$this->result = mysql_query($query, $this->connection);
		if($this->result) {
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Sets the querytype of the last query executed
	 * For example it can be SELECT, UPDATE, DELETE etc.
	 *
	 * @access	private
	 */
	function setQueryType($type) {
		$this->queryType = strtoupper($type);
	}
	
	/**
	 * Returns the querytype
	 *
	 * @return	string
	 * @access	private
	 */
	function getQueryType() {
		return $this->queryType;
	}
	
	/**
	 * This function returns number of rows got when executing a query
	 *
	 * @return	mixed	FALSE if there is no query-result.
	 *					If the queryType is SELECT then it will use the function MYSQL_NUM_ROWS
	 *					Otherwise it uses the MYSQL_AFFECTED_ROWS
	 * @access	public
	 */
	function getNumRows() {
		if($this->result) {
			if(DEBUG == TRUE) {
				print("<font style=\"background-color: red\">".$this->getQueryType()."</font><br>");
			}
			return mysql_affected_rows($this->connection);
		}
		return FALSE;
	}
	
	/**
	 * The function returns the result from a call to the query() function
	 *
	 * @return	object
	 * @access	public
	 */
	function getQueryResult() {
		return $this->result;
	}
	
	/**
	 * This function returns the query result as an array for each row in the query result
	 *
	 * @return	array
	 * @access	public
	 */
	function fetchArray() {
		if($this->result) {
			return mysql_fetch_array($this->result);
		}
		return FALSE;
	}
	
	/**
	 * This function returns the query result as an object for each row in the query result
	 *
	 * @return	object
	 * @access	public
	 */
	function fetchObject() {
		if($this->result) {
			return mysql_fetch_object($this->result);
		}
		return FALSE;
	}
	
	/**
	 * This function returns the query result as an array for each row in the query result
	 *
	 * @return	array
	 * @access	public
	 */
	function fetchRow() {
		if($this->result) {
			return mysql_fetch_row($this->result);
		}
		return FALSE;
	}
	
	/**
	 * This function sets the database
	 *
	 * @return	boolean	TRUE if the database was set
	 * @access	public
	 */
	function setDb($sDatabase) {
		if(!$this->getConnected()) {
			$this->printError("Not connected in function setDb()");
			return FALSE;
		}
		if($this->selectedDb = mysql_select_db($sDatabase, $this->connection)) {
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * This function returns a flag so you can see if you are connected to the database
	 * or not
	 *
	 * @return	boolean	TRUE when connected to the database
	 * @access	public
	 */
	function getConnected() {
		return $this->isConnected;
	}

	/**
	 * This function sets the flag so you can see if you are connected to the database
	 *
	 * @param	$bStatus	The status of the connection. TRUE if you are connected,
	 *						FALSE if you are not
	 * @access	public
	 */
	function setConnected($bStatus) {
		$this->isConnected = $bStatus;
	}
	
	/**
	 * The function unlocks tables if there are locked tables and the closes the
	 * connection to the database.
	 *
	 * @access	public
	 */
	function closeConnection() {
		if($this->getLocked()) {
			$this->unlock();
		}
		if($this->getConnected()) {
			mysql_close($this->connection);
			$this->setConnected(FALSE);
		}
	}
	
	/**
	 * Unlocks all tables that are locked
	 *
	 * @access	public
	 */
	function unlock() {
		if(!$this->getConnected()) {
			$this->setLocked(FALSE);
		}			
		if($this->getLocked()) {
			$this->query("UNLOCK TABLES"); 
			$this->setLocked(FALSE);
		}
	}

	/**
	 * This function locks the table(s) that you specify
	 * The type of lock must be specified at the end of the string.
	 *
	 * @param	string	a string containing the table(s) to lock, 
	 *					as well as the type of lock to use (READ or WRITE) 
	 *					at the end of the string
	 * @return	boolean	TRUE if the tables was successfully locked
	 * @access	private
	 */
	function lock($sCommand) {
		if($this->query("LOCK TABLE ".$sCommand)) {
			$this->setLocked(TRUE);
			return TRUE;
		}
		
		$this->setLocked(FALSE);
		return FALSE;
	}
	
	/**
	 * This functions sets read lock to specified table(s)
	 *
	 * @param	string	a string containing the table(s) to read-lock
	 * @return	boolean	TRUE on success
	 */
	function setReadLock($sTable) {
		return $this->lock($sTable." ".LOCKED_FOR_READ);
	}
	
	/**
	 * This functions sets write lock to specified table(s)
	 *
	 * @param	string	a string containing the table(s) to read-lock
	 * @return	boolean TRUE on success
	 */
	function setWriteLock($sTable) {
		return $this->lock($sTable." ".LOCKED_FOR_WRITE);
	}
		
	/**
	 * Sets the flag that indicates if there is any tables locked
	 *
	 * @param	boolean	The flag that will indicate the lock. TRUE if locked
	 */
	function setLocked($bStatus) {
		$this->isLocked = $bStatus;
	}
	
	/**
	 * Returns TRUE if there is any locked tables
	 *
	 * @return	boolean TRUE if there are locked tables
	 */
	function getLocked() {
		return $this->isLocked;
	}

	/**
	 * Prints an error to the screen. Can be used to kill the application
	 *
	 * @param	string	The text to display
	 * @param	boolean	TRUE if you want to kill the application. Default is FALSE
	 */
	function printError($text, $killApp=FALSE) {
		if($text) {
			print("<b>Error</b><br />".$text);
		}
		if($killApp) {
			exit();
		}
	}
	
	/**
	 * Display any mysql-error
	 *
	 * @return	mixed	String with the error if there is any error.
	 *					Otherwise it returns FALSE
	 */
	function getMysqlError() {
		if(mysql_error()) {
			return "<br /><b>Mysql Error Number ".mysql_errno()."</b><br />".mysql_error();
		}
		return FALSE;
	}
	
	/**
	 * select assoc
	 *
	 *  @param string $sql : String sql
	 *  @param boolean $groupResult
	 * 	$groupResult = fase: Array( [key1] => value1, [key2] => value 2 )
	 * 	$groupResult = true Array(  [key1] => Array ([0] =>  value1 ),  [key2] => Array ( [0] => value2 ) )
	 *
	 */
	function get_assoc( $query = "", $groupResult=false){
		if ($query != ""){
			$this->query($query);
		}
		$query_id =  $this->result;
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
		} 
		elseif (@mysql_num_fields ($query_id) == 2) {
			while (is_array($row = mysql_fetch_array($query_id))) {
                if ($groupResult) {
                    $results[$row[0]][] = $row[1];
                } 
                else {
                    $results[$row[0]] = $row[1];
                }
            }
		}
		return $results;
	}
	
	
    
    /**
     * @todo get the first col in  first row 
     * @param $sql string query
     * @return value (string - int ...) 
     */
    function get_one($query = "") {
   		if ($query != ""){
			$this->query($query);
		}
		$query_id =  $this->result;
        $record_row = mysql_fetch_array($query_id);
        return (isset($record_row[0])) ? $record_row[0] : 0;
    }
}