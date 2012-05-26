$(document).ready(function()
{
    $.post('backend.php', {grab_staff:true}, function(data)
    {
        $('#staff-population').html(data);
    })
})