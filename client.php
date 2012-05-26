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

if (strlen($_SESSION['habbo']['auth_ticket']) < 1)
{
    $_auth = 'sw-'.$_SESSION['habbo']['username'].'-'.rand(1 , 9).rand(1 , 9).rand(1 , 9).rand(1 , 9);

    $blowfis->_database->prepare('UPDATE users SET auth_ticket = ?, ip_last = ?, ip_reg = ? WHERE id = ?')
        ->bindParameters(array($_auth, IP_ADDRESS, IP_ADDRESS, $_SESSION['habbo']['id']))->execute();
}

$blowfis->_database->prepare('UPDATE users SET ip_last = ?, ip_reg = ? WHERE id = ?')
        ->bindParameters(array(IP_ADDRESS, IP_ADDRESS, $_SESSION['habbo']['id']))->execute();

foreach($_SESSION['habbo'] as $_key => $_value)
{
    $blowfis->_template->setParameter('habbo_'.$_key, $_value);
}

$blowfis->_template->addTemplate('page-client');

$blowfis->_template->publishHTML();

?>