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

if (!AUTHENICATED)
{
    $blowfis->redirect('index');
}

if (AUTHENICATED && !ACTIVATED)
{
    $blowfis->redirect('characters');
}

foreach($_GET as $_key => $_value) // Some small $_GET hacking!
{
    if (!is_int($_key))
    {
        exit; // Someone is being an idiot..
    }

    $_GET['article-id'] = $_key;
    break;
}

$_article = $blowfis->_database->prepare('SELECT * FROM sulake_news WHERE id = ?')
        ->bindParameters(array($_GET['article-id']))->execute();

while($_a = $_article->fetch_array())
{
    $blowfis->_template->setParameter('article_title', $_a['title']);
    $blowfis->_template->setParameter('article_author', $_a['author']);
    $blowfis->_template->setParameter('article_date', $_a['date']);
    $blowfis->_template->setParameter('article_story', $_a['story']);
    $blowfis->_template->setParameter('article_image', $_a['image']);
}

$blowfis->_template->setParameter('article_id', $_GET['article-id']);

$blowfis->_template->setParameter('site_title', $blowfis->_configuration['site']['name']);
$blowfis->_template->setParameter('users_online', 0);

foreach($_SESSION['habbo'] as $_key => $_value)
{
    $blowfis->_template->setParameter('habbo_'.$_key, $_value);
}

$blowfis->_template->addTemplate('page-header');
$blowfis->_template->addTemplate('page-hard-article');

$blowfis->_template->addCascading('sweb-boxes');
$blowfis->_template->addCascading('sweb-body');
$blowfis->_template->addCascading('sweb-header');

$blowfis->_template->addJavascript('jquery.global');
$blowfis->_template->addJavascript('jquery.articles');
$blowfis->_template->addJavascript('jquery.comments');
$blowfis->_template->addJavascript('jquery.online');

$blowfis->_template->addFooter();
$blowfis->_template->publishHTML();

?>