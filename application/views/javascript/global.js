var currentNews = 1;
var constantOnline = null;

getOnline();
secretFunction();

function getOnline()
{
    $.post('action.php', {online: true}, function(data)
    {
       if (data == constantOnline)
       {
           return;
       }
       
       constantOnline = data;
       
       $('.online').fadeOut('slow', function(){
        $('.online').html(data);
        $('.online').fadeIn('slow'); 
       })
    });

    setInterval('getOnline()', 600);
}

function secretFunction()
{
    /* $(document.body).each(function()
    {
       $('div').each(function()
       {
           $(this).draggable();
       })
    }) */
}

function loadNews(id)
{
    $.post('action.php', {load_news: true, news_id: id}, function(data)
    {
        $('.news-container').fadeOut('slow', function(){
            $('.news-container').html(data);
            $('.news-container').fadeIn('slow');
        })
    });
    
}

function changeMarquee(direction)
{
    if (direction == 'down' && currentNews == 1)
    {
        return;
    }
    
    defaultNews = currentNews;
    
    requested_id = (direction == 'up') ? currentNews + 1 : currentNews - 1;
    
    currentNews = requested_id;
    
    $.post('action.php', {marquee: true, article_id: requested_id}, function(data)
    {
       if (data == 'is_null')
       {
           currentNews = defaultNews;
           return;
       }
        
       $('#marquee-data').fadeOut('slow', function(){
           $('#marquee-data').html(data);
           $('#marquee-data').fadeIn('slow');
       })
    });
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

function loadLook(lookVariable)
{
    $.post('action.php', {grab_head: true, look: lookVariable}, function(data)
    {
       $('#lookID').html('<img>' + data + '</img>');
    });
}

function logoutUser()
{
   $.post('action.php', {logout: true}, function(data)
    {
       alert(data);
       window.location = 'index.php';
    });
}

function updateMotto()
{
    var desiredMotto = $("#motto-field").val();
    	
    $.post('action.php', {motto: desiredMotto}, function()
    {
       $("#motto-field").text(desiredMotto); 
    });
                                
}

/* Any undocumented javascript functions */
$('.header .username').hover(function()
{
   $('.stats').fadeIn('slow');
});

$('.stats').mouseleave(function()
{
   $(this).fadeOut('slow'); 
});

$("#motto-field").blur(function()
{
    updateMotto();
});

$("#motto-field").keyup(function(event)
{
    if (event.which == 13)
    {
        $(this).blur();
    }
    return;
});
/* End the functions.*/