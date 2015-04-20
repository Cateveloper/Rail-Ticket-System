"use strict"

function UpdateRoute (button)
{
    alert("not finished yet");
}

function DeleteRoute (button)
{
    var route_id = button.parentNode.parentNode.firstChild.innerText;

    $.redirect('manage_route.php',
        {
            'manage_route_delete': 1,
            'route_id': route_id
        }
    );
}

function AddCity ()
{
    var cur_row = $(this).closest('tr');
    var row_idx = cur_row.prevAll().length;
    var row_count = $('#route_info tr').length;

    if (0 == row_idx)
    {
        if (1 == row_count)
        {
            cur_row.after(CreateConnectRow(true));
            cur_row.after(CreateCityRow());
            return;
        }

        cur_row.after(CreateConnectRow());
        cur_row.after(CreateCityRow());
        return;
    }

    cur_row.before(CreateConnectRow());
    cur_row.before(CreateCityRow());
}

function DeleteCity ()
{
    var cur_row = $(this).closest('tr');
    var row_idx = cur_row.prevAll().length;

    if (1 != row_idx)
    {
        cur_row.prev().remove();
        cur_row.remove();
    }
    else
    {
        cur_row.next().remove();
        cur_row.remove();
    }
}

function CreateNewRow ()
{
    return $('<tr><td></td><td></td><td></td></tr>');
}

function CreateCityRow ()
{
    var row = CreateNewRow();
    row.children('td').eq(0).append(CreateDeleteButton());
    row.children('td').eq(1).append(CreateDropDownList());
    row.children('td').eq(2).append(CreateTimePicker());
    return row;
}

function CreateConnectRow (is_end_row)
{
    if (is_end_row === undefined)
    {
        is_end_row = false;
    }

    var row = CreateNewRow();

    if (is_end_row)
    {
        row.children('td').eq(1).append(CreateAddButton());
    }
    else
    {
        row.children('td').eq(0).append(CreateAddButton());
        row.children('td').eq(1).append($('<p align="center">to</p>'));
        row.children('td').eq(2).append($('<label for="price"></label><input type="text" name="price" maxlength="50" />'));
    }

    return row;
}

function CreateAddButton ()
{
    var add_button = $('<button/>',
        {
            text: 'Add City',
            type: 'button',
            click: AddCity
        }
    );

    return add_button;
}

function CreateDeleteButton ()
{
    var delete_button = $('<button/>',
        {
            text: 'Delete City',
            type: 'button',
            click: DeleteCity
        }
    );

    return delete_button;
}

function CreateTimePicker ()
{
    var time_picker = $('<input type="text" >');
    time_picker.datetimepicker({
        datepicker:false,
        format:'H:i'
    });
    return time_picker;
}

function CreateDropDownList ()
{
    var drop_down_list = $('<select />');
    $('<option />', {value: -1, text: '### Select Station ###'}).appendTo(drop_down_list);

    for (var key in station_data)
    {
        $('<option />', {value: key, text: station_data[key]}).appendTo(drop_down_list);
    }

    return drop_down_list;
}

function CheckRouteForm ()
{
    if (!$('#route_number').val())
    {
        alert("Specify a route number");
        return;
    }

    var row_count = $('#route_info tr').length;
    var valid_route = true;

    if (1 != (row_count % 2))
    {
        alert("Error: row number is not odd number");
        return;
    }

    var station_count = (row_count - 1) / 2;

    if (station_count <= 1)
    {
        alert("Need at least two stations");
        return;
    }

    var connect_count = station_count - 1;
    var all_rows = $('#route_info tr');

    for (var station_idx = 0; station_idx < station_count; ++station_idx)
    {
        var row_idx = 1 + station_idx * 2;
        var cur_row = all_rows.eq(row_idx);
        
        var select = cur_row.find('td').eq(1).find('select').eq(0);
        if (-1 == select.children('option').filter(':selected').val())
        {
            valid_route = false;
            break;
        }
        select.attr('name', 'station_idx_' + station_idx);

        var train_time = cur_row.find('td').eq(2).children().first();
        if (!train_time.val())
        {
            valid_route = false;
            break;
        }
        train_time.attr('name', 'train_time_' + station_idx);
    }

    for (var connect_idx = 0; connect_idx < connect_count; ++connect_idx)
    {
        var row_idx = 2 + connect_idx * 2;
        var cur_row = all_rows.eq(row_idx);

        var price = cur_row.find('td').eq(2).find('input').first();

        if (!price.val())
        {
            valid_route = false;
            break;
        }
        price.attr('name', 'price_' + connect_idx);
    }

    if (!valid_route)
    {
        alert('Invalid route. Please check your inputs');
        return;
    }

    if ('Add Route' == $('#submit_button').val())
    {
        $('#manage_route_submitted').val(1);
    }
    else
    {
        $('#manage_route_submitted').val(2);
    }

    $('#station_count').val(station_count);
    $('#route_form').submit();
}

$(document).ready(function() {
    $('#init_add_button').click(AddCity);
    $('#submit_button').click(CheckRouteForm);
});
