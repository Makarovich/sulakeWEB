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


/* 
* @name Error handling!
* @desc NULL 
* @author Cobe Makarov 
*/ 

if(!defined('SULAKE')){die('Direct Loading Fobidden');} 

//Write out our error
function writeError($error_number, $error_message, $error_file, $error_line)
{
    global $sulake;
    
    //OBV: The administrator doesn't want any errors shown.
    if ($sulake->configuration['system']['environment'] == 0)
    {
        return;
    }
    
    $output = new simpleTemplate('error');

    $output->replace('title', $error_number);
    $output->replace('error', $error_message);
    $output->replace('file', $error_file);
    $output->replace('line', $error_line);

    die($output->result());    
}
?>