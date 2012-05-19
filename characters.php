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
//The current location
define('LOCATION', basename(__FILE__));

include('bootstrap.php');

if (!isset($_SESSION['account']['master_email']))
{
    $blowfis->redirect('index');
}

$blowfis->_template->setParameter('site_title', $blowfis->_configuration['site']['name']);
$blowfis->_template->setParameter('users_online', 0);

$blowfis->_template->addTemplate('page-characters');

$blowfis->_template->addCascading('sweb-index');
$blowfis->_template->addCascading('sweb-header');

$blowfis->_template->addJavascript('jquery.index');

$blowfis->_template->publishHTML();
?>