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

define('PAGE', 'Index');

include('global.php');

if (!isset($_GET['action']))
{
    exit;
}

switch($_GET['action'])
{
    case 'login':
        $sulake->class['users']->authenicate(
                $_POST['loginEmail'], 
                $sulake->hashVariable($_POST['loginPassword'])
                );
        $sulake->redirect('index');
        break;
}
?>