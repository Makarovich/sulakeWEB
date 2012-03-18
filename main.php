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

echo (isset($_SESSION['test'])) ? $_SESSION['test'] : null;

$sulake->template->addTPL('header');

$sulake->template->addTPL('main');

$sulake->template->addCSS('global');
$sulake->template->addJavascript('global', true);

$sulake->habbo->grabNews(1);

$sulake->template->setParameter('habbo-look-image', $sulake->habbo->grabLook($sessionCache->recieveValue('look')));

$sulake->template->addFooter();

$sulake->template->publishHTML();
?>