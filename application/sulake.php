<?php 
/*-------------------------------------------- 
* SULAKEWEB - CONTENT MANAGEMENT SYSTEM 
* PROJECT REVISION CODENAME: SNOBO 
* -------------------------------------------- 
* COPYRIGHT 2012 COBE MAKAROV 
* -------------------------------------------- 
* SYSTEM RELEASED UNDER THE GNU PUBLIC 
* LICENSE V3. NONE OF THE DEVELOPERS ARE 
* AFFILIATED WITH THE SERVER(S) RAN WITH ANY 
* SULAKEWEB COPY 
* -------------------------------------------- 
* SOFTWARE COMPATIBLE WITH ALL OPERATING SYSTEMS 
* -------------------------------------------- 
* @author: Cobe Makarov 
* --------------------------------------------*/ 


/* 
* @name Sulake Class 
* @desc NULL 
* @author Cobe Makarov 
*/ 

if(!defined('SULAKE')){die('Direct Loading Fobidden');} 

class Sulake
{
    //The configuration variable
    var $configuration;
    
    //The class data holder variable
    var $class;
    
    //The variable that holds when that page has started
    var $executionStart;
    
    //Classes that shouldn't be initialized directly, but should still be included.
    private $ignored_classes = array('cache', 'mock');
    
    //Determines whether a certain job is authorized to run.
    var $job_authorization = array();
    
    public function __construct()
    {
        //Define our folder variables
        define('DS', '/');
        define('LB', '"\r\n"');
        
        //Fill our configuration variable
        $this->handleConfiguration();
        
        //Now let's set our environment
        $this->setEnvironment();
        
        //Let's cache our classes
        $this->initializeClasses();
        
        //Start the page load!
        $this->executionStart = microtime(true);
    }
    
    //Fills our configuration variable
    private function handleConfiguration()
    {
        //Include the configuration file
        include './application/configuration.php';
        
        //Set our variables
        $this->configuration = $_sulakeConfig;
        
    }
    
    //Sets our environment based on the configuration value
    private function setEnvironment()
    {
        switch ($this->configuration['system']['environment'])
        {
            case '0':
                error_reporting(0);
                break;
            
            case '1':
                error_reporting(E_ALL);
                break;
            
            case '2':
                error_reporting(E_ALL ^ E_STRICT);
                break;
            
            default:
                error_reporting(0);
        }
    }
    
    private function initializeClasses()
    {
        
        //Grab all the files within the classes folder.
        foreach (glob('./application/classes/'.'*.php') as $file)
        {
            include $file;
            
            //Read the proper class name.
            $proper = ucfirst($this->getName($file));
            
            //Get what we'll call it.
            $class = $this->getName($file);
            
            //Ignore em!
            if (in_array($class, $this->ignored_classes))
            {
                continue;
            }
            
            //If it's the database class, we need extra parameters
            if ($class == 'database')
            {
                $this->class[$class] = new $proper($this->configuration['database']);
                continue;
            }
            
            //If not let's just add it in
            $this->class[$class] = new $proper();
            
        } 
        
        //Require our interfaces
        $this->requireInterfaces();
    }
    
    private function requireInterfaces()
    {
        //Grab all the files within the interfaces folder
        foreach (glob('./application/classes/interfaces'.'*.php') as $file)
        {
            //Require them
            require $file;
        }
    }
    
    ############################## MISC Functions ##################################
    
    private function getName($class)
    {
        $periodSplit = explode('.', $class);
        
        return $periodSplit[2];
    }
    
    public function errorCheck()
    {
        if (isset($_SESSION['error']))
        {
            Template::setParameter('error', $_SESSION['error']);
            
            //Unset our session variable
            unset($_SESSION['error']);
        }
    }
    
    public function writeError($error)
    {
        //$this->class['template']->displayError($this->getCaller(), $error);
        echo $error;
    }
    
    private function getCaller()
    {
        //$debug = debug_
        return 'lol';
        //return $debug[2];
    }
    
    //Get the type of a variable
    public function getType($var)
    {
        if (is_array($var))
            return 'a';
        
        if (is_bool($var))
            return 'b';
        
        if (is_double($var))
            return 'd';
        
        if (is_numeric($var))
            return 'i';

        if (is_string($var))
            return 's';
    }
}
?>