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

if (!AUTHENICATED)
{
    $blowfis->redirect('index');
}

if (AUTHENICATED && !ACTIVATED)
{
    $blowfis->redirect('characters');
}

if (!file_exists('./application/cache/looks/'.$_SESSION['habbo']['look'].'.png'))
{
    file_put_contents('./application/cache/looks/'.$_SESSION['habbo']['look'].'.png',
                    file_get_contents('http://www.habbo.com/habbo-imaging/avatarimage?figure='.$_SESSION['habbo']['look'].'.gif')
                    );
}

$blowfis->_template->setParameter('site_title', $blowfis->_configuration['site']['name']);
$blowfis->_template->setParameter('users_online', 0);

foreach($_SESSION['habbo'] as $_key => $_value)
{
    $blowfis->_template->setParameter('habbo_'.$_key, $_value);
}

$blowfis->_template->addTemplate('page-header');
$blowfis->_template->addTemplate('page-article');
$blowfis->_template->addTemplate('page-me');

$blowfis->_template->addCascading('sweb-boxes');
$blowfis->_template->addCascading('sweb-body');
$blowfis->_template->addCascading('sweb-news');
$blowfis->_template->addCascading('sweb-header');

$blowfis->_template->addJavascript('jquery.global');
$blowfis->_template->addJavascript('jquery.articles');
$blowfis->_template->addJavascript('jquery.online');

$blowfis->_template->addFooter();
$blowfis->_template->publishHTML();
?>