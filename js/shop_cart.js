$(document).ready(function() {
	$("#cart_form").submit(submit_confirm);

	//$("#result_table tr:eq(0)").children().first().hide();

	$("#cart_table tr:gt(0)").each(function(){
		var schedule_item = $(this).children().first();
		
		var id = schedule_item.text();
		
		//schedule_item.hide();
		
		var last_td = $(this).children().last();
		last_td.append('<input type="button" value="Edit" onclick="modify_qty('+id+')">');
		last_td.append('<input type="button" value="Delete" onclick="delete_qty('+id+')">');
					
	});
});

function modify_qty(item_id){
	var cookie_json = "";
	var cookie_order = [];
	var qty = 0;

	if($.cookie('shopping_cart') != undefined)
	{
		cookie_json = $.parseJSON($.cookie('shopping_cart'));
				
		cookie_order = cookie_json.order;
	}
	
	for(var i = 0; i < cookie_order.length ; i++)
	{
		if(cookie_order[i].item_id == item_id)
		{
			qty = $('#tx_qty_'+item_id).val();
			
			cookie_order[i].item_qty = qty;
			
			$.cookie('shopping_cart', JSON.stringify({
				"order":cookie_order
			}),{expires: 1},{json:true});	
			
			location.reload();
			
			break;
		}
	}
}

function delete_qty(item_id){
	var cookie_json = "";
	var cookie_order = [];

	if($.cookie('shopping_cart') != undefined)
	{
		cookie_json = $.parseJSON($.cookie('shopping_cart'));
				
		cookie_order = cookie_json.order;
	}
	
	for(var i = 0; i < cookie_order.length ; i++)
	{
		if(cookie_order[i].item_id == item_id)
		{
			cookie_order.splice(i, 1);
			
			$.cookie('shopping_cart', JSON.stringify({
				"order":cookie_order
			}),{expires: 1},{json:true});	
			
			location.reload();
			
			break;
		}
	}
}

var submit_confirm = function() {

	var rtn = confirm("Are you sure you want to place this order?");
	
	return rtn;
}