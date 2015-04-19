"use strict"

function AddCity ()
{
    var cur_row = $(this).closest('tr');
    var row_idx = cur_row.prevAll().length;
    var row_count = $('#route_table tr').length;

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

$(document).ready(function() {
    $('#init_add_button').click(AddCity);
});
