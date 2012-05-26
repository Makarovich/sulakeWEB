<?php
/*--------------------------------------------
* PROJECT NAME - PROJECT MOTTO
* BUILT ON BLOWFIS FRAMEWORK VERSION 2
* --------------------------------------------
* COPYRIGHT YEAR AUTHOR
* BLOWFIS COPYRIGHT 2012 COBE MAKAROV
* --------------------------------------------
* BLOWFIS FRAMEWORK RELEASED UNDER THE GNU
* PUBLIC LICENSE V3. COBE MAKAROV IS NOT
* AFFILIATED WITH THE SERVER(S) RAN WITH ANY
* WEB APPLICATION BUILT UPON BLOWFIS VERSION 2
* --------------------------------------------
* @author: AUTHOR
* @framework-author: Cobe Makarov
* --------------------------------------------*/

################################################
//Someone is trying to access this file directly!
if (!defined('BLOWFIS'))
{
   exit;
}

/*
 * author: Cobe Makarov
 * name: Example Plugin
 * description: Just an example..
 */

class Example implements iPlugin
{
    public function __start()
    {
        global $blowfis;

        if ($blowfis->_template->templateLoaded('indexHeader.html'))
        {
            $blowfis->_template->_templateContent = str_replace($blowfis->_template->_templateCache['indexHeader.html'],
                    'I just replaced the indexHeader.html with this lil message!',
                    $blowfis->_template->_templateContent);
        }
    }

    public function __stop()
    {


    }
}
?>
