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
        if (!file_exists('./cache/looks/'.$look.'.png'))
        {                    
            file_put_contents(
                    './cache/looks/'.$look.'.png', 
                    file_get_contents('http://www.habbo.com/habbo-imaging/avatarimage?figure='.$look.'.gif')
                    ); 
        } 
            return './cache/looks/'.$look.'.png'; 
    }
    
    //Grabs the news and sets it as a template parameter.
    public function grabNews($id, $return = false)
    {
        global $sulake;
        
        $news = $sulake->database->prepare('SELECT id, title, image FROM sulake_news WHERE id = ?')
                ->bindParameters(array($id))->execute();
        
        $output = null;
        
        if ($news->num_rows() == 0)
        {
            if ($return)
            {
                return 'is_null';
            }
            
            $sulake->template->setParameter('paper-marquee', 'No news articles found!');
            return;
        }
        
        while($news_array = $news->fetchArray())
        {
            $simple = new simpleTemplate('news-marquee');
            $simple->replace('id', $news_array['id']);
            $simple->replace('title', $news_array['title']);
            $simple->replace('image', $news_array['image']);
            $output = $simple->result();
        }
        
        if ($return)
        {
            return $output;
        }
        
        $sulake->template->setParameter('paper-marquee', $output);
    }
} 
?>