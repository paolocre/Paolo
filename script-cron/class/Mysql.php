<?php
/************************************************
*
*   File Name: 	 mysql.php
*   Begin: 		 Sunday, Dec, 23, 2005
*   Author: 	 ahmet oï¿½uz mermerkaya 	
*   Email: 		 ahmetmermerkaya@hotmail.com
*   Description: Class to connect mysql database
*	Edit : 		 Sunday, Nov, 18, 2007
*   Version: 	 1.1
*
***********************************************/ 

   

class MySQL
{	
	private $dbLink;
	private $dbHost;
	private $dbUsername;
    private $dbPassword;
	private $dbName;
	public  $queryCount;
    private $result;
    private $item;
    private $collection = array();
    private $count;
	
    
    /**
    * @desc construit la class MySQL soit avec les paramètres soit avec les valeurs assigné par defaut
    * @param hostname, user, pwd, dbname
    */
	function MySQL()
	{
        $iNum=func_num_args();
        switch($iNum)
        {
        case 1:
          $this->dbHost = func_get_arg(0);
          break;
        case 2:
          $this->dbHost = func_get_arg(0);
          $this->dbName = func_get_arg(1);
          break;
        case 4:
          $this->dbHost = func_get_arg(0);
          $this->dbUsername = func_get_arg(1);
          $this->dbPassword = func_get_arg(2);
          $this->dbName = func_get_arg(3);
        default:
        } 
		$this->queryCount = 0;		
	}
	function __destruct()
	{
		$this->close();
	}
	//connect to database
	private function connect() {	
		$this->dbLink = mysql_connect($this->dbHost, $this->dbUsername, $this->dbPassword);		
		if (!$this->dbLink)	{			
			$this->ShowError();    
			return false;
		}
		else if (!mysql_select_db($this->dbName,$this->dbLink))	{
			$this->ShowError();  
			return false;
		}
		else {
			mysql_query("SET NAMES 'utf8'",$this->dbLink);
			return true;
		}
		unset ($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);		
	}	
	/*****************************
	 * Method to close connection *
	 *****************************/
	function close()
	{                                                                     
		@mysql_close($this->dbLink);
	}
	/*******************************************
	 * Checks for MySQL Errors
	 * If error exists show it and return false
	 * else return true	 
	 *******************************************/
	function ShowError()
	{
       // trace(mysql_error());
		$error = mysql_error();
	    //echo $error;		
	}	
	/****************************
	 * Method to run SQL queries
	 ****************************/
	function  query($sql)
	{	
		if (!$this->dbLink)	
			$this->connect();
			
		if (! $result = mysql_query($sql,$this->dbLink)) {
			$this->ShowError();			
			return false;
		}
		$this->queryCount++;	
		return $result;
	}
	/************************
	* Method to fetch values*
	*************************/
	function fetchObject($result)
	{
		if (!$Object=mysql_fetch_object($result))
		{
			$this->ShowError();
			return false;
		}
		else
		{
			return $Object;
		}
	}
	/*************************
	* Method to number of rows
	**************************/
	function numRows($result)
	{
		if (false === ($num = mysql_num_rows($result))) {
			$this->ShowError();
			return -1;
		}
		return $num;		
	}
	/*******************************
	 * Method to safely escape strings
	 *********************************/
	function escapeString($string)
    {
        if (get_magic_quotes_gpc()) 
        {
            return $string;
        } 
        else 
        {
            $string = mysql_escape_string($string);
            return $string;
        }
    }
    
    function free($result)
    {
        if (mysql_free_result($result)) {
            $this->ShowError();
            return false;
        }    
        return true;
    }
    
    function lastInsertId()
    {
        return mysql_insert_id($this->dbLink);
    }
    
    function getUniqueField($sql)
    {
        $row = mysql_fetch_row($this->query($sql));
        
        return $row[0];
    }
    
    /**
     * @desc ajout un item a un collection (array)
     * @param item 
     */
    public function add($item) 
    {
      $this->collection[$this->count++] = $item;
    }
 
        
    /**
    * @desc génére une collecition (tableau d'objets)
    * @param query sql 
    */
    function getCollection($query)
    {      
        $this->count = 0;
        try
        {
          $this->result = $this->query($query);
            if ( $this->result )
              {            
                while($this->item = $this->fetchObject($this->result) )
                  {  
                    $this->add($this->item);
                  }
                return $this->collection;
              }
            else
              {
            return 0;
              }
        }
        catch ( Exception $e)
        {
            trace( "Mysql exception: getCollection() " . $e->getMessage() );
        }
    }
    
    
}
?>