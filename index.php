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

if (isset($_SESSION['id']))
{
    $sulake->redirect('me');
    return;
}

if (isset($_SESSION['master_email']))
{
    $sulake->redirect('characters');
}

$sulake->template->addTPL('index-header');
$sulake->template->addTPL('index');

$sulake->template->addCSS('index');
$sulake->template->addJavascript('index');

$sulake->template->addFooter();

$sulake->template->publishHTML();
?>