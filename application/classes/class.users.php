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
    //The email this occurance is working with.
    var $master_email = null;
    
    //How many accounts we need to catch
    var $account_num = 0;
    
    //When a user is authenicated
    public function authenicate($email, $password)
    {
        global $sulake;
        
        $result = $sulake->database->prepare('SELECT * FROM sulake_users WHERE email = ? AND password = ?')
                ->bindParameters(array($email, $password))->execute();
                
        if($result->num_rows() == 1)
        {
            while($user_array = $result->fetchArray())
            {
                $_SESSION['master_email'] = $user_array['email'];
                $_SESSION['account_num'] = $user_array['accounts'];
            }
            
            $sulake->redirect('characters');
        }
        else
        {
            $_SESSION['error'] = 'There isn\'t an account associated with that e-mail address.';
            $sulake->redirect('index');
        }
    }
    
    //Grab all the users associated with this email
    public function grabUsers()
    {
        global $sulake;
        
        $users = $sulake->database->prepare('SELECT * FROM users WHERE mail = ? LIMIT '.$_SESSION['account_num'])
                ->bindParameters(array($_SESSION['master_email']))->execute();
        
        return $users;
    }
} 
?>