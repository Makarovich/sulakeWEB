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
* @name  Class 
* @desc NULL 
* @author Cobe Makarov 
*/ 

if(!defined('SULAKE')){die('Direct Loading Fobidden');} 

class Cache
{ 
   //Our class array
    private $array;

    public function __construct($array)
    {
        //The parameter they gave us is NOT an array..
        if (!is_array($array))
        {
            return;
        }
        
        //If it is, set our class array with the values
        $this->array = $array;
    }
    
    //Convert all the array values to the session
    public function intoSession()
    {
        foreach ($this->array as $key => $value)
        {
            $_SESSION[$key] = $value;
        }
    }
    
    //Get a value from the parameter-defined key
    public function recieveValue($key)
    {
        return $this->array[$key];
    }
    
    //Convert all the array values to template parameters
    public function toTPL($name)
    {
       global $sulake;
       
       foreach ($this->array as $key => $value)
       {        
           $sulake->template->setParameter($name.'-'.$key, $value);
       } 
    }
} 
?>