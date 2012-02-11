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

$sulake->template->addTPL('header');

$sulake->template->appendTPL('<div class="container">');

$sulake->template->addTPL('news-widget');
$sulake->template->addTPL('me');

$sulake->template->appendTPL('</div>');

$sulake->template->addCSS('global');
$sulake->template->addJavascript('global', true);

$sulake->template->setParameter('habbo-look', $sulake->habbo->grabLook($sessionCache->recieveValue('look')));

$sulake->habbo->grabNews();

$sulake->template->addFooter();

$sulake->template->publishHTML();
?>