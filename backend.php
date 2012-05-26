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
//The current location
define('LOCATION', basename(__FILE__));

include('bootstrap.php');

################################################
//Only used by javascript files!

################################################
//Someone is trying to be a ripper.
//We're stopping people from getting valuable data
//All data is sent secretly through $_POST
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
    exit; //False request
}

foreach($_POST as $key => $value)
{
    switch($key)
    {
        case 'show_register':
            if (!$_POST[$key])
            {
                exit;
            }
            //Template HACK
            $output = new simpleTemplate('page-register');

            echo $output->result();
            break;

        case 'try_register':
            if (!$_POST[$key])
            {
                exit;
            }

            if (!isset($_POST['register_email']))
            {
                die('You left the e-mail field blank!');
            }

            if (!filter_var($_POST['register_email'], FILTER_VALIDATE_EMAIL))
            {
                die('That is not a valid e-mail address!');
            }

            if (!isset($_POST['register_password']))
            {
                die('You left the password field blank!');
            }

            $_email = $blowfis->_database->secure($_POST['register_email']);

            $_password = $blowfis->hashVariable($_POST['register_password']);

            $_accounts = $blowfis->_database->prepare('SELECT * FROM sulake_users WHERE email = ?')
                    ->bindParameters(array($_email))->execute();

            if ($_accounts->num_rows() > 0)
            {
                die('There is already an account associated with '.$_email);
            }
            else
            {
                $blowfis->_database->prepare('INSERT INTO sulake_users (email, password) VALUES (?, ?)')
                        ->bindParameters(array($_email, $_password))->execute();
                die('REGISTER = GOOD;');
            }
            break;

        case 'try_login':
            if (!$_POST[$key])
            {
                exit;
            }

            if (!isset($_POST['login_email']))
            {
                die('You left the e-mail field blank!');
            }

            if (!filter_var($_POST['login_email'], FILTER_VALIDATE_EMAIL))
            {
                die('The e-mail you entered is incorrect!');
            }

            if (!isset($_POST['login_password']))
            {
                die('You left the password field blank!');
            }

            $_email = $blowfis->_database->secure($_POST['login_email']);

            $_password = $blowfis->hashVariable($_POST['login_password']);

            $_account = $blowfis->_database->prepare('SELECT * FROM sulake_users WHERE email = ? AND password = ?')
                    ->bindParameters(array($_email, $_password))->execute();

            if ($_account->num_rows() > 0)
            {
                while($a = $_account->fetch_array())
                {
                    $_SESSION['account']['logged_in'] = true;
                    $_SESSION['account']['master_email'] = $_email;
                }
                die('LOGIN = GOOD;');
            }
            else
            {
                die('Incorrect email/password sequence!');
            }
            break;

        case 'load_characters':
            if (!$_POST[$key])
            {
                exit;
            }

            $_id = $_SESSION['account']['master_email'];

            $_accounts = $blowfis->_database->prepare('SELECT * FROM users WHERE mail = ?')
                    ->bindParameters(array($_id))->execute();

            if ($_accounts->num_rows() ==  0)
            {
                die('<div align="center">You do not have any characters!</div>');
            }
            else
            {
                $_output = null;

                while($a = $_accounts->fetch_array())
                {
                    $_simple = new simpleTemplate('widget-character');
                    $_simple->replace('username', $a['username']);
                    $_simple->replace('id', $a['id']);

                    $_output = $_output . $_simple->result();
                }

                echo $_output;
            }
            break;

        case 'create_character':
            if (!$_POST[$key])
            {
                exit;
            }

            if (!isset($_POST['creation_username']) || empty($_POST['creation_username']))
            {
                die('You left the username field blank!');
            }

            $_character = $blowfis->_database->prepare('SELECT * FROM users WHERE username = ?')
                    ->bindParameters(array($blowfis->_database->secure($_POST['creation_username'])))->execute();

            if ($_character->num_rows() > 0)
            {
                die('That username is taken, try again!');
            }

            $_limit = $blowfis->_database->prepare('SELECT * FROM users WHERE mail = ?')
                    ->bindParameters(array($_SESSION['account']['master_email']))->execute()->num_rows();

            if ($_limit > 2)
            {
                die('You already have the maximum amount of characters!');
            }

            $blowfis->_database->prepare('INSERT INTO users (mail, username, password, motto, account_created, ip_reg) VALUES (?, ?, ?, ?, ?, ?)')
                    ->bindParameters(array($_SESSION['account']['master_email'],
                        $_POST['creation_username'],
                        '',
                        $blowfis->_configuration['site']['name'].' new user!',
                        date('m.d.y'),
                        getenv('SERVER_ADDR')
                        ))->execute();

            die('CREATION = GOOD;');
            break;

        case 'activate_character':
            if (!$_POST[$key])
            {
                exit;
            }

            if (!isset($_POST['activation_id']))
            {
                exit;
            }

            $_account = $blowfis->_database->prepare('SELECT * FROM users WHERE id = ?')
                    ->bindParameters(array($_POST['activation_id']))->execute();

            while($_a = $_account->fetch_array())
            {
                foreach($_a as $_key => $_value)
                {
                    $_SESSION['habbo'][$_key] = $_value;
                }
            }
            die("ACTIVATION = GOOD;");
            break;

        case 'load_news':

            $_articles = $blowfis->_database->prepare('SELECT * FROM sulake_news LIMIT 1')->execute();

            while($_array = $_articles->fetch_array())
            {
                $template = new simpleTemplate('widget-article');
                $template->replace('id', $_array['id']);
                $template->replace('image', $_array['image']);
                $template->replace('title', $_array['title']);
                $template->replace('author', $_array['author']);
                $template->replace('story', $_array['story']);
                die($template->result());
            }
            break;

        case 'clear_session':
            session_destroy();
            break;

        case 'ready_marquee':

            if (!isset($_POST['article_id']))
            {
                exit;
            }

            $_article = $blowfis->_database->prepare('SELECT * FROM sulake_news WHERE id = ?')
                    ->bindParameters(array($_POST['article_id']))->execute();

            if (!$_article || $_article->num_rows() == 0)
            {
                die('is_null');
            }

            while($_array = $_article->fetch_array())
            {
                $template = new simpleTemplate('widget-article');
                $template->replace('id', $_array['id']);
                $template->replace('image', $_array['image']);
                $template->replace('title', $_array['title']);
                $template->replace('author', $_array['author']);
                $template->replace('story', substr($_array['story'], 1, 10));
                die($template->result());
            }
            break;

        case 'grab_online_group':

            /*$_users = $blowfis->_database->prepare('SELECT username FROM users WHERE online = ?')
                    ->bindParameters(array('1'))->execute();

            if ($_users->num_rows() == 0)
            {
                die('No users online!');
            }

            $_output = null;
            $_key = 0;

            while($_u = $_users->fetch_array())
            {
                if ($_key == (count($_u) - 1))
                {
                    $_output = $_output . $_u['username'];
                    break;
                }
                else
                {
                    $_output = $_output . $_u['username'] . ', ';
                }
            }

            die($_output); */
            die('Disabled.');
            break;

        case 'grab_room_group':

            $_rooms = $blowfis->_database->prepare('SELECT caption, users_now FROM rooms ORDER BY users_now DESC LIMIT 5')
                    ->execute();

            $_output = null;

            $_key = 0;

            while($_r = $_rooms->fetch_array())
            {
                $_key++;

                $_st = new simpleTemplate('widget-room');
                $_st->replace('key', $_key);
                $_st->replace('name', $_r['caption']);
                $_st->replace('count', $_r['users_now']);
                $_output = $_output . $_st->result();
            }

            die($_output);
            break;

        case 'grab_leaderboard':
            if (!isset($_POST['leaderboard_key']))
            {
                exit;
            }

            switch($_POST['leaderboard_key'])
            {
                case 1: //Richest Users!!

                    $_users = $blowfis->_database->prepare('SELECT username, credits FROM users ORDER BY credits DESC LIMIT 5')
                        ->execute();

                    $_output = null;

                    $_combined = null;

                    $_key = 0;

                    $_list = new simpleTemplate('widget-leaderboard');
                    $_list->replace('title', 'Richest Users');
                    $_list->replace('description', 'Here are the richest users in all of the hotel, check if you are on the list!');

                    while($_u = $_users->fetch_array())
                    {
                        $_key++;

                        $_st = new simpleTemplate('widget-room');
                        $_st->replace('key', $_key);
                        $_st->replace('name', $_u['username']);
                        $_st->replace('count', $_u['credits']);

                        $_combined = $_combined . $_st->result();
                    }

                    $_list->replace('list', $_combined);

                    $_output = $_list->result();

                    die($_output);
                    break;

                case 2: //Respected Users!!

                    $_users = $blowfis->_database->prepare('SELECT username, respect FROM users ORDER BY respect DESC LIMIT 5')
                        ->execute();

                    $_output = null;

                    $_combined = null;

                    $_key = 0;

                    $_list = new simpleTemplate('widget-leaderboard');
                    $_list->replace('title', 'Highest Respected Users');
                    $_list->replace('description', 'Here are the highest respected users in all of the hotel, check if you are on the list!');

                    while($_u = $_users->fetch_array())
                    {
                        $_key++;

                        $_st = new simpleTemplate('widget-room');
                        $_st->replace('key', $_key);
                        $_st->replace('name', $_u['username']);
                        $_st->replace('count', $_u['respect']);

                        $_combined = $_combined . $_st->result();
                    }

                    $_list->replace('list', $_combined);

                    $_output = $_list->result();

                    die($_output);
                    break;
            }
            break;

        case 'submit_comment':

            if (!isset($_POST['comment']))
            {
                die('You left the field blank!');
            }

            if (!isset($_POST['article']))
            {
                die('Something went horribly wrong.');
            }

            if (strlen($_POST['comment']) <= 4)
            {
                die('Your message is too short!');
            }

            if ($_POST['article'] == 0)
            {
                die('Something went horribly wrong..');
            }

            $_current = $_POST['article'];

            $_comments = $blowfis->_database->prepare('SELECT * FROM sulake_news_comments WHERE article = ?')
                    ->bindParameters(array($_current))->execute();

            while($_c = $_comments->fetch_array())
            {
                if (($_c['username'] == $_SESSION['habbo']['username']) && ($_c['date'] == date('m-d-y'))) //Woah, Don't spam me bro!
                {
                    die('You already commented on this article today!');
                }
            }

            $_comment = $blowfis->_database->secure($_POST['comment']);

            $blowfis->_database->prepare('INSERT INTO sulake_news_comments(username, date, comment, article) VALUES (?, ?, ?, ?)')
                    ->bindParameters(array($_SESSION['habbo']['username'], date('m-d-y'), $_comment, $_current))->execute();

            die('Comment has been submitted!');
            break;

        case 'load_comments':

            if (!isset($_POST['article']))
            {
                die('Something went horribly wrong.');
            }

            $_id = $_POST['article'];
            $_title = null;

            $_comments = $blowfis->_database->prepare('SELECT * FROM sulake_news_comments WHERE article = ? ORDER BY date DESC')
                    ->bindParameters(array($_id))->execute();

            $_article = $blowfis->_database->prepare('SELECT title FROM sulake_news WHERE id =  ?')
                    ->bindParameters(array($_id))->execute();

            while($_a = $_article->fetch_array())
            {
                $_title = $_a['title'];
            }

            if ($_comments->num_rows() == 0)
            {
                die('No comments to load!');
            }

            $_output = null;

            while($_c = $_comments->fetch_array())
            {
                $_st = new simpleTemplate('widget-comment');
                $_st->replace('username', $_c['username']);
                $_st->replace('date', $_c['date']);
                $_st->replace('comment', $_c['comment']);
                $_st->replace('article', $_title);

                //Here comes ze queries!
                $_user = $blowfis->_database->prepare('SELECT look FROM users WHERE username = ?')
                        ->bindParameters(array($_c['username']))->execute();

                while ($_u = $_user->fetch_array())
                {
                    $_st->replace('look', $_u['look']);
                }

                $_output = $_output . $_st->result();
            }

            die($_output);
            break;

        case 'grab_staff':

            $_staff = $blowfis->_database->prepare('SELECT * FROM users WHERE rank >= ?')
                ->bindParameters(array(5))->execute();

            if ($_staff->num_rows() == 0)
            {
                die('Wierdly enough.. there are no staff members!!');
            }

            $_output = null;

            while($_s = $_staff->fetch_array())
            {
                $_st = new simpleTemplate('widget-staff');
                $_st->replace('username', $_s['username']);
                $_st->replace('rank', $_s['rank']);
                $_st->replace('look', $_s['look']);
                $_st->replace('motto', $_s['motto']);

                $_output = $_output . $_st->result();
            }

            die($_output);
            break;

        case 'grab_online_count':

            $_count = $blowfis->_database->prepare('SELECT * FROM server_status')->execute();

            while ($_c = $_count->fetch_array())
            {
                die($_c['users_online'] . ' online right now!');
            }
            break;

        case 'update_motto':
            if (!isset($_POST['motto']) || empty($_POST['motto']))
            {
                die('You left the field blank!');
            }

            if (strlen($_POST['motto']) <= 2)
            {
                die('Your motto is too short!');
            }

            if (strlen($_POST['motto']) >= 30)
            {
                die('Your motto is too long!');
            }

            if ($_POST['motto'] == $_SESSION['habbo']['motto'])
            {
                die('Your motto is already '. $_POST['motto']);
            }

            $_motto = $blowfis->_database->secure($_POST['motto']);

            $blowfis->_database->prepare('UPDATE users SET motto = ? WHERE id = ?')
                    ->bindParameters(array($_motto, $_SESSION['habbo']['id']))->execute();

            die('Your motto has successfully been changed to '.$_motto);
            break;
    }
}
?>