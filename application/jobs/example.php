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

//Define our cron job id.
define('JOB_ID', 1);

//Make sure the system is allowed to run
if (!$sulake->job_authorization[JOB_ID])
    return;

//Run the cron.
$sulake->database->prepare('UPDATE users SET credits = ?')->bindParameters(array(0))->execute();
?>