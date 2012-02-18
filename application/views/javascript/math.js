
function getResult(web)
{
    var u = $.ajax({
      url: web,
      async: false
    }).responseText;
    
    return u;
}

function calcMultiples(second)
{
    var number = null;
    
    if (second)
    {
        number = $('#second-num').val();
    
        $('.second_multiples').html(getResult('action.php?do=multi&num=' + number));
    }
    else
    {
        number = $('#first-num').val();

        $('.first_multiples').html(getResult('action.php?do=multi&num=' + number));
    }
}

