<?php
/*--------------------------------------------
* SULAKEWEB - THE END.
* BUILT ON BLOWFIS FRAMEWORK VERSION 2
* --------------------------------------------
* COPYRIGHT 2011-2012 COBE MAKAROV
* BLOWFIS COPYRIGHT 2012 COBE MAKAROV
* --------------------------------------------
* BLOWFIS FRAMEWORK RELEASED UNDER THE GNU
* PUBLIC LICENSE V3. COBE MAKAROV IS NOT
* AFFILIATED WITH THE SERVER(S) RAN WITH ANY
* WEB APPLICATION BUILT UPON BLOWFIS VERSION 2
* --------------------------------------------
* @author: Cobe Makarov
* @framework-author: Cobe Makarov
* --------------------------------------------*/

################################################
//Someone is trying to access this file directly!
if (!defined('BLOWFIS'))
{
   exit;
}

/*
 * author: Cobe Makarov
 * name: MySQL Class
 * description: A class that parses some MySQL functions and such
 */

class blowfisMySQL implements Database
{
    ################################################
    //The variable that holds the database obj.
    private $_link;

    ################################################
    //The count of queries ran per page
    public $_queryCount = 0;

    ################################################
    //The database host
    private $_databaseHost;

    ################################################
    //The database name
    private $_databaseName;

    ################################################
    //The database user
    private $_databaseUser;

    ################################################
    //The database password
    private $_databasePassword;

    ################################################
    //Did we successfully connect?
    private $_databaseConnected;

    ################################################
    //The query that the class is working with
    var $_classQuery;

    public function __construct($database)
    {
        ################################################
        //Set our db values..
        $this->_databaseHost = $database['host'];
        $this->_databaseName = $database['name'];
        $this->_databaseUser = $database['user'];
        $this->_databasePassword = $database['password'];

        $this->connect();
    }

    private function connect()
    {
        if ($this->_databaseConnected)
        {
            ################################################
            //System forbids this anyways, but...
            return;
        }

        ################################################
        //Let's try to connect!
        try
        {
            $this->_link = mysql_connect(
                    $this->_databaseHost,
                    $this->_databaseUser,
                    $this->_databasePassword);

            mysql_select_db($this->_databaseName, $this->_link);
        }
        catch(Exception $e)
        {
            trigger_error($e->getMessage());
        }

        $this->_databaseConnected = true;
    }

    public function disconnect()
    {
        ################################################
        //Close the database connection and tell the system
        //We're done!
        $this->_link->close();

        $this->_databaseConnected = false;
    }

    public function secure($requestedVariable)
    {
        return mysql_real_escape_string($requestedVariable, $this->_link);
    }

    public function prepare($databaseQuery)
    {
        ################################################
        //Since MySQL doesn't prepare it's queries..
        $this->_classQuery = $databaseQuery;

        return $this;
    }

    public function bindParameters($requestedParameters)
    {
        ################################################
        //Since MySQL doesn't prepare it's queries.. nor bind it's parameters..

        $parameter_count = substr_count($this->_classQuery, '?');

        $parameter_key = 0;

        $parameter_real_count = count($requestedParameters);

        for($i = 0; $i < $parameter_count; $i++)
        {
           if ($parameter_key > $parameter_real_count)
           {
               break;
           }

           $this->_classQuery = preg_replace('/\?/', $requestedParameters[$parameter_key], $this->_classQuery, 1);

           $parameter_key++;
        }

        return $this;
    }

    public function execute()
    {
        $this->_queryCount++;

        return new mysqlResult($this->_classQuery, $this->_link);
    }
}

class mysqlResult implements ResultObj
{
    ################################################
    //Our query object
    private $_queryObj;

    ################################################
    //The MySQL connection variable
    private $_queryResult;

    public function __construct($queryObject, $connectionVariable)
    {
        $this->_queryObj = $queryObject;

        $this->_queryResult = mysql_query($this->_queryObj, $connectionVariable);
    }

    public function result()
    {
        return $this->_queryResult;
    }

    public function fetch_array()
    {
        while ($_return = mysql_fetch_array($this->_queryResult))
        {
            return $_return;
        }
    }

    public function num_rows()
    {
        if (!$this->_queryResult)
        {
            return 0;
        }
        
        return (int)mysql_num_rows($this->_queryResult);
    }
}
?>
