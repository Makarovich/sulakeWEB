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

ob_start();
session_start();

################################################
//Telling the system we have some auth!
define('BLOWFIS', true);

################################################
//Grabing our main global class, Blowfis!
require('blowfis.php');

$blowfis = new Blowfis();

################################################
//The website title
define('TITLE', $blowfis->_configuration['site']['name']);

################################################
//DEPRICATED: Start the Steve Jobs class
//$blowfis->_jobs->start();

################################################
//Definitions for session

define('AUTHENICATED', isset($_SESSION['account']['master_email']));
define('ACTIVATED', isset($_SESSION['habbo']['username']));

if (ACTIVATED)
{
    $_user = $blowfis->_database->prepare('SELECT * FROM users WHERE id = ?')
            ->bindParameters(array($_SESSION['habbo']['id']))->execute();

    while($_u = $_user->fetch_array())
    {
        foreach($_u as $_key => $_value)
        {
            $_SESSION['habbo'][$_key] = $_value; // Update our SESSION!!!
        }
    }
}
?>