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
* @name Habbo Class 
* @desc NULL 
* @author Cobe Makarov 
*/ 

if(!defined('SULAKE')){die('Direct Loading Fobidden');} 

class Habbo
{ 
   
    //Grab a cached look
    public function grabLook($look)
    {
        if (!file_exists('./cache/looks/'.$look))
        {                    
            file_put_contents(
                    './cache/looks/'.$look.'.png', 
                    file_get_contents('http://www.habbo.com/habbo-imaging/avatarimage?figure='.$look.'.gif')
                    ); 
        } 
            return './cache/looks/'.$look.'.png'; 
    }
    
    //Grabs the news and sets it as a template parameter.
    public function grabNews()
    {
        global $sulake;
        
        $news = $sulake->database->prepare('SELECT * FROM `sulake.news`')->execute();
        
        $output = null;
        
        
        while($news_array = $news->fetchArray())
        {
            $simple = new simpleTemplate('news-list');
            $simple->replace('id', $news_array['id']);
            $simple->replace('title', $news_array['title']);
            $simple->replace('author', $news_array['author']);
            $simple->replace('date', $news_array['date']);
            $output .= $simple->result();
        }
        
        $sulake->template->setParameter('news-list', $output);
    }
} 
?>