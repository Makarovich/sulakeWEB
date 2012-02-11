
var constantOnline = null;

getOnline();

function getOnline()
{
    var Online = getResult('action.php?do=online');
    
    if (constantOnline == Online)
    {
        return;
    }
    
    constantOnline = Online;
    
    $('.online').fadeOut('slow', function(){
       $('.online').html(Online);
       $('.online').fadeIn('slow'); 
    })
    
    setInterval('getOnline()', 600);
}

function loadNews(id)
{
    $('.more_news').fadeOut('slow', function(){
        $('.more_news').html(getResult('action.php?do=load_news&id=' + id));
        $('.more_news').fadeIn('slow');
    })
}

function getResult(web)
{
    var u = $.ajax({
      url: web,
      async: false
    }).responseText;
    
    return u;
}

function setMessage(message)
{
    $('.message').html(message);
}
