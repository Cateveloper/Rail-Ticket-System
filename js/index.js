$(document).ready(function() {
	add_button();
	
	$('#d_time').datetimepicker({
        datepicker:false,
        format:'H:i'
    });
	
	$('#a_time').datetimepicker({
        datepicker:false,
        format:'H:i'
    });	
	
	$('#d_date').datetimepicker({
        timepicker:false,
        format:'Y-m-d'
    });	
	
	$("#search_form").submit(search_confirm);
});

function add_button(){
	var cookie_json = "";
	var cookie_order = [];

	if($.cookie('shopping_cart') != undefined)
	{
		cookie_json = $.parseJSON($.cookie('shopping_cart'));		
		cookie_order = cookie_json.order;
	}

	$("#result_table tr:eq(0)").children().first().hide();

	$("#result_table tr:gt(0)").each(function(){
		var item_contain = false;
		var schedule_item = $(this).children().first();
		var schedule_date = $(this).children().eq(2).text();
		var item_price = $(this).children().eq(7).text();
		var id = schedule_item.text();
		var last_td = $(this).children().last();
		
		schedule_item.hide();
		
		for(var i = 0; i < cookie_order.length ; i++)
		{
			if(cookie_order[i].item_id == id)
				item_contain = true;
		}

		if(item_contain)
			last_td.append('<img id="theImg" src="./image/check.jpg" />');
		else
			last_td
				.append('<input type="button" value="Add to cart"/>')
				.click(function(){
					add_to_cart(id, schedule_date, last_td, item_price);
				});
	});
}

function add_to_cart(item_id, item_date, last_td, item_price){
	var cookie_json = "";
	var cookie_order = [];
	var item_contain = false;

	if($.cookie('shopping_cart') != undefined)
	{
		cookie_json = $.parseJSON($.cookie('shopping_cart'));
				
		cookie_order = cookie_json.order;
	}
	
	for(var i = 0; i < cookie_order.length ; i++)
	{
		if(cookie_order[i].item_id == item_id)
			item_contain = true;
	}
	
	if(!item_contain)
	{
		var new_obj = {};
		
		new_obj.item_id = item_id;
		new_obj.item_date = item_date;
		new_obj.item_qty = 1;
		new_obj.item_price = item_price;
	
		cookie_order.push(new_obj);
	
		$.cookie('shopping_cart', JSON.stringify({
			"order":cookie_order
		}),{expires: 1},{json:true});
	}
	
	last_td.children().first().remove();
	last_td.append('<img id="theImg" src="./image/check.jpg" />');
}

function search_confirm(){

}