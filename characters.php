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

define('PAGE', 'Characters');

include('global.php');

$users = $sulake->users->grabUsers();

$sulake->template->addTPL('index-header');
$sulake->template->addTPL('characters');

$sulake->template->addCSS('index');
$sulake->template->addJavascript('index');

$user = $users->fetchArray();

foreach($user as $key => $value)
{
    if ($key == 'look')
    {
        $value = $sulake->habbo->grabLook($value);
    }
    $sulake->template->setParameter('user-'.$key, $value);
}

$sulake->template->addFooter();

$sulake->template->publishHTML();
?>