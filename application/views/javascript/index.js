var showing = 'login';

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

function showRegister()
{
    var not = (showing == 'login') ? 'register' : 'login';

    $('.'+ showing + 'Form').fadeOut('slow', function()
    {
        $('.'+ not + 'Form').fadeIn('slow');
    });
    showing = not;   
}

function makeGood(div)
{
    $(div).removeClass().addClass('goodForm');
}

function makeBad(div)
{
    $(div).removeClass().addClass('badForm');
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

function checkEmail()
{
   var exists = (getResult('action.php?do=email_exists&email=' + $('#registerEmail').val()) == '1') ? true : false;
   
   if (exists)
    {
        makeBad('#registerEmail');
        setMessage($('#registerEmail').val() + ' already exists within the database!');
    }
    else
    {
        makeGood('#registerEmail');
        setMessage($('#registerEmail').val() + ' is good to go!');
    }
}

function strLength(str)
{
    return str.length;
}

function checkPassword(second)
{
    var password_one = $('#registerPassword').val();
    var password_two = $('#registerPassword2').val();
    var pOne_length = $('#registerPassword').val().length;
    var pTwo_length = $('#registerPassword2').val().length;
    
    if (!second)
    {
        if (6 > pOne_length)
        {
            makeBad('#registerPassword');
            setMessage('Your first password is too short');
            return;
        }
        
        if (pOne_length > 26)
        {
            makeBad('#registerPassword');
            setMessage('Your first password is too long');
            return;
        }
        
        makeGood('#registerPassword');
        setMessage('Your first password is perfect!');
    }
    else
    {
        
    }
}

function populateContainer()
{
    $.post('action.php', {populate: true}, function(data)
    {
       $('.more_container').html(data);
    });
}

function activateUser(id)
{
    $.post('action.php', {activate: true, user_id: id}, function()
    {
        window.location = 'index.php';
    });
}
