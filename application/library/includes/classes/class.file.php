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
//Someone is trying to access this file directly!
if (!defined('BLOWFIS'))
{
   exit;
}

/*
 * author: Cobe Makarov
 * name: File Class
 * description: A class that CRUD's files.
 */

class File
{
   public function create($_fileName)
   {
       $_fileHandler = fopen($_fileName, 'c');

       $this->close($_fileHandler);
   }

   public function read($_fileName)
   {
       $_fileHandler = fopen($_fileName, 'r');

       $returningData = fgets($_fileHandler);

       $this->close($_fileHandler);

       return $returningData;
   }

   public function write($_fileName, $_requestedData)
   {
       $_fileHandler = fopen($_fileName, 'a');

       $_fileContents = $this->read($_fileName);

       if (!empty($_fileContents))
       {
           $_requestedData = "\r\n".$_requestedData;
       }

       fputs($_fileHandler, $_requestedData);

       $this->close($_fileHandler);
   }

   private function close($_requestedFile)
   {
       fclose($_requestedFile);
   }
}
?>
