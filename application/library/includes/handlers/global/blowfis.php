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
 * name: Blowfis Class
 * description: Basically the bootstrapper class, handles everything from configuration to class loading.
 */

class Blowfis
{
    ################################################
    //The configuration variable
    var $_configuration;

    ################################################
    //Classes that aren't initialized but included.
    var $_classBlacklist = array();

    ################################################
    //Execution Time
    var $_executionStart = 0;

    var $_fullPath;

    public function __construct()
    {
        ################################################
        //Create the folder definitions
        $this->createDefinitions();

        ################################################
        //Start our error handler
        $this->startErrors();

        ################################################
        //Parse the configuration values!
        $this->parseConfiguration();

        ################################################
        //Set our environment
        $this->setEnvironment();

        $this->_fullPath = ($this->_configuration['site']['folder'] != 'root') ? $this->_configuration['site']['origin'].$this->_configuration['site']['folder'] : $this->_configuration['site']['origin'];

        ################################################
        //Initialize all of our classes
        $this->initializeClasses();

        $this->_executionStart = microtime(true);

        date_default_timezone_set($this->_configuration['site']['timezone']);
    }

    private function createDefinitions()
    {
        ################################################
        //Important folders in order by root location.
        define('APPLICATION', './application/');
        define('LIBRARY', 'library/');
        define('INCLUDES', 'includes/');

        define('CLASSES', 'classes/');
        define('DATABASE', 'database/');
        define('INTERFACES', 'interfaces/');

        define('HANDLERS', 'handlers/');
        define('CONFIGURATION', 'configuration/');
        define('ERRORS', 'errors/');
        define('GLOBAL', 'global/');

        define('JOBS', 'jobs/');

        define('VIEWS', 'views/');

        define('CASCADING', 'cascading/');

        define('HTML', 'html/');
        define('PLUGINS', 'plugins/');
        define('SIMPLE', 'simple/');

        define('JAVASCRIPT', 'javascript/');

        ################################################
        //Some file system definitions
        define('DS', DIRECTORY_SEPARATOR);
        define('BR', "\r\n");
    }

    private function parseConfiguration()
    {
        if (file_exists(APPLICATION.LIBRARY.INCLUDES.HANDLERS.CONFIGURATION.'configuration.base.php'))
        {
            ################################################
            //Run the installer and stop all scripts!
            return;
        }

        include(APPLICATION.LIBRARY.INCLUDES.HANDLERS.CONFIGURATION.'configuration.php');

        ################################################
        //Set Blowfis' public configuration
        $this->_configuration = $_blowfisConfiguration;
    }

    private function startErrors()
    {
        include APPLICATION.LIBRARY.INCLUDES.HANDLERS.ERRORS.'handler.error.php';

        set_error_handler('writeError');
    }

    private function setEnvironment()
    {
        switch($this->_configuration['site']['environment'])
        {
            case 0:
                error_reporting(0);
                break;

            case 1:
                error_reporting(E_ALL);
                break;

            case 2:
                error_reporting(E_ALL ^ E_NOTICE);
                break;

            default:
                error_reporting(0);
                break;
        }
    }

    private function initializeClasses()
    {
        $this->requireInterfaces();

        $this->requirePlugins();

        ################################################
        //Grab all the files in the classes folder!
        foreach (glob(APPLICATION.LIBRARY.INCLUDES.CLASSES.'*.php') as $file)
        {
            include $file;

            $regularName = $this->retrieveClassName($file);

            $properName = ucfirst($regularName);

            ################################################
            //If this class is blacklisted..?
            if (in_array($regularName, $this->_classBlacklist))
            {
                continue;
            }

            $this->blowfisVariable($regularName);

            $this->$regularName = new $properName();
        }

        ################################################
        //Grab all the database classes
        foreach (glob(APPLICATION.LIBRARY.INCLUDES.CLASSES.DATABASE.'*.php') as $file)
        {
            include $file;

            ################################################
            //Find out what database class we should grab!
            $desiredClass = ($this->_configuration['database']['type'] == 0) ? 'MySQL' : 'MySQLi';

            if ($desiredClass == 'MySQLi')
            {
                $desiredClass = ($this->_configuration['database']['type'] == 1) ? 'MySQLi' : 'PDO';
            }

            $className = 'blowfis'.$desiredClass;

            if($this->retrieveClassName($file) != strtolower($desiredClass))
            {
                continue;
            }

            $this->_database = new $className($this->_configuration['database']);
            break;
        }
    }

    private function requireInterfaces()
    {
        ################################################
        //Grab all of the interfaces!
        foreach (glob(APPLICATION.LIBRARY.INCLUDES.CLASSES.INTERFACES.'*.php') as $file)
        {
            require $file;
        }
    }

    private function requirePlugins()
    {
        ################################################
        //Grab all of the interfaces!
        foreach (glob(APPLICATION.LIBRARY.INCLUDES.PLUGINS.'*.php') as $file)
        {
            require $file;
        }
    }

    ################################################
    //Miscellaneous Functions


    ################################################
    //Retrieve class name
    private function retrieveClassName($class_name)
    {
        $periodSplit = explode('.', $class_name);

        return $periodSplit[2];
    }


    ################################################
    //Redirect to an internal url
    public function redirect($requestedURL)
    {

        $_path = ($this->_configuration['site']['folder'] == 'root') ? $this->_configuration['site']['origin'] : $this->_configuration['site']['origin'].$this->_configuration['site']['folder'].'/';

        $_array = explode('.', $requestedURL);

        $_file = (end($_array) == 'php') ? $requestedURL : $requestedURL.'.php';

        if ((strpos($requestedURL, 'http://')) || (strpos($requestedURL, 'https://')))
        {
            return null;
        }

        if (!file_exists(str_replace($this->_configuration['site']['origin'], null, $_path) . $_file))
        {
            return null;
        }

        header('Location: '.$_path . $requestedURL);
    }

    ################################################
    //Get the type of variable
    public function getType($requestedVariable)
    {
        if (is_array($requestedVariable)) return 'a';

        if (is_bool($requestedVariable)) return 'b';

        if (is_double($requestedVariable)) return 'd';

        if (is_numeric($requestedVariable)) return 'i';

        if (is_string($requestedVariable)) return 's';

    }

    ################################################
    //Formats variables to how blowfis has em!
    public function blowfisVariable(&$requestedVariable)
    {
        $requestedVariable = '_'.$requestedVariable;
    }

    ################################################
    //Hashes a variable using the secret quote
    public function hashVariable($_requestedVariable)
    {
        return md5($_requestedVariable); //Phoenix is really lazy with these passwords!!
    }
}
?>