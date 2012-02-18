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

define('PAGE', 'Index');

include('global.php');

if (!isset($_GET['do']))
{
    exit; //False request
}

switch($_GET['do'])
{
    case 'login':
        $sulake->users->authenicate(
                $_POST['loginEmail'], 
                $sulake->hashVariable($_POST['loginPassword'])
                );
        break;
    
    case 'email_exists':
        
        if (!isset($_GET['email']))
        {
            exit; //false request
        }
        
        echo $sulake->database->prepare('SELECT * FROM `sulake.users` WHERE email = ? LIMIT 1')
                ->bindParameters(array($_GET['email']))->execute()->num_rows();
        break;
        
    case 'populate':
        
        $data = $sulake->database->prepare('SELECT * FROM users WHERE mail = ?')
                ->bindParameters(array($_SESSION['master_email']))->execute();
        
        if ($data->num_rows() < 2)
        {
            echo '0';
        }
        else
        {
            $output = null;
            
            $key = 0;
            
            while($d = $data->fetchArray())
            {
                if ($key == 0)
                {
                    $key = 1;
                    continue; //We already have our first user, so skip it.
                }
                
                $output = new simpleTemplate('more-characters');
                $output->replace('username', $d['username']);
                $output->replace('id', $d['id']);
                $output->replace('credits', $d['credits']);
                $output->replace('motto', $d['motto']);
                $output->replace('look', $sulake->habbo->grabLook($d['look']));
                
                echo $output->result();
            }
        }
        break;
        
    case 'activate':
        
        if (!isset($_GET['id']))
        {
            exit; //False request
        }
        
        $user = $sulake->database->prepare('SELECT * FROM users WHERE mail = ? AND id = ?')
                ->bindParameters(array($_SESSION['master_email'], $_GET['id']))->execute();
        
        $userCache = new Cache($user->fetchArray());
        
        $userCache->intoSession();       
        
        $sulake->redirect('index');
        break;
        
    case 'online':
        
        $online = $sulake->database->prepare('SELECT * FROM users WHERE online = 0')->execute()->num_rows();
        echo 'There\'s <b>'.$online.'</b> online users';
        break;
    
    case 'load_news':
        
        if (!isset($_GET['id']))
        {
            exit; //False request
        }
        
        $news = $sulake->database->prepare('SELECT * FROM `sulake.news` WHERE id = ?')
                ->bindParameters(array($_GET['id']))->execute();
        
        while($news_array = $news->fetchArray())
        {
            $output = new simpleTemplate('news-article');
            $output->replace('author', $news_array['author']);
            $output->replace('title', $news_array['title']);
            $output->replace('date', $news_array['date']);
            $output->replace('story', $news_array['story']);
            $output->replace('image', $news_array['image']);
            
            echo $output->result();
        }
        break;
        
    case 'multi':
        
        if (!isset($_GET['num']))
        {
            exit; //False request
        }
        
        if (!is_numeric($_GET['num']))
        {
            die('That is not a number!');
        }
        $number = $_GET['num'];
        
        $count = 0;
        
        $multiples = array();
        
        $output = null;
        
        for($count = 0; $count <= 100; $count++)
        {
            $div = $number / $count;
            
            if ($div == 0)
            {
                continue;
            }
            
            if ($div == 1)
            {
                continue;
            }
            
            if (!(strpos($div, '.')))
            {
                array_push($multiples, $count);
            }
        }
        
        foreach(array_values($multiples) as $numb)
        {
            $output .= $numb.', ';
        }
        
        echo $output;
        break;
}
?>