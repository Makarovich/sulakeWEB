<?php 
ob_start(); 
session_start(); 
/*-------------------------------------------- 
* SULAKEWEB - CONTENT MANAGEMENT SYSTEM 
* PROJECT REVISION CODENAME: SNOBO 
* -------------------------------------------- 
* COPYRIGHT 2012 COBE MAKAROV 
* -------------------------------------------- 
* SYSTEM RELEASED UNDER THE GNU PUBLIC 
* LICENSE V3. NONE OF THE DEVELOPERS ARE 
* AFFILIATED WITH THE SERVER(S) RAN WITH ANY 
* CONTENT MANAGEMENT SYSTEM SULAKEWEB 
* -------------------------------------------- 
* SOFTWARE COMPATIBLE WITH ALL OPERATING SYSTEMS 
* -------------------------------------------- 
* @author: Cobe Makarov 
* --------------------------------------------*/ 

//Needed for security reasons 
define('SULAKE', null); 

//The grand-poo-ba of classes within sulakeWEB 
require('./application/sulake.php'); 

//Initialize the variable for the sulake class 
$sulake = new Sulake(); 

//Set the title 
$sulake->class['template']->SetParameter('title', $sulake->configuration['system']['name'].'~'.PAGE); 

//Check for errors 
$sulake->errorCheck(); 

//Convert all the session variables to template parameters 
//$sulake->class['users']->toTPL(); 

//Define if the user is logged in 
//define('LOGGED_IN', $sulake->class['users']->userLogged()); 

//Start running the jobs 
$sulake->class['jobs']->start(); 
?>