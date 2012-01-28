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

if(!defined('SULAKE')){die('Direct Loading Fobidden');} 

//Define our variable as an array.
$_sulakeConfig = array();

//Database variables
$_sulakeConfig['database']['host'] = 'localhost';
$_sulakeConfig['database']['user'] = 'root';
$_sulakeConfig['database']['password'] = 'lol123';
$_sulakeConfig['database']['name'] = 'mcd';

//System variables
$_sulakeConfig['system']['name'] = 'Snobo';
$_sulakeConfig['system']['tagline'] = 'R.I.P Blowfis..';
$_sulakeConfig['system']['environment'] = '2';
$_sulakeConfig['system']['secret_quote'] = 'snobolovesblowfis';
?>