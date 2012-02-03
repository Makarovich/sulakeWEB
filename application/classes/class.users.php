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

class Users
{ 
   
    
    //When a user is authenicated
    public function authenicate($email, $password)
    {
        global $sulake;
        
        $result = $sulake->class['database']->prepare('SELECT * FROM `sulake.users` WHERE email = ? AND password = ?')
                ->bindParameters(array($email, $password))->execute();
                
        if($result->num_rows() == 1)
        {
            echo 'mk gd';
        }
        else
        {
            $_SESSION['error'] = 'There isn\'t an account associated with that e-mail address.';
        }
    }
} 
?>