"use strict"

function UpdateStation (button)
{
    if ('Update' == button.innerText)
    {
        button.innerText = 'Confirm';
        var station_name = button.parentNode.parentNode.children[1].innerText;
        button.parentNode.parentNode.children[1].innerHTML = '<input type="text" value=' + station_name + '>';
    }
    else
    {
        var station_id = button.parentNode.parentNode.firstChild.innerText;
        var station_name = button.parentNode.parentNode.children[1].children[0].value;

        $.redirect('manage_station.php', 
            {
                'manage_station_update': 1,
                'station_id': station_id,
                'station_name': station_name
            }
        )
    }
}

function DeleteStation (button)
{
    var station_id = button.parentNode.parentNode.firstChild.innerText;

    $.redirect('manage_station.php', 
        {
            'manage_station_delete': 1,
            'station_id': station_id
        }
    );
}



$(document).ready(function() {
});
