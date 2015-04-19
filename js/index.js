$(document).ready(function() {
	$("#result_table tr:gt(0)").each(function(){
		//alert($(this).children().last().text());	
		var id = $(this).children().first().text();
		var last_td = $(this).children().last();
		last_td
			.append('<input type="button" value="Add to cart">')  
			.click(function(){ 
				add_to_cart(id, last_td);
			});		
		//alert($(this).nextAll().last().text());
		//alert($(this).nextAll().first().text());
	});
});

function add_to_cart(item_id, last_td){
	var original_cookie = "";
	var shopping_cart = "";

	if($.cookie('shopping_cart') != undefined)
		original_cookie = $.cookie('shopping_cart');
	
	if(original_cookie.indexOf(item_id) < 0)
	{
		if(original_cookie != "")
			shopping_cart = original_cookie + "|";
			
		$.cookie('shopping_cart', shopping_cart + item_id + ":1");
	}
	//alert("cookie:"+$.cookie('shopping_cart'));
	
	last_td.children().first().remove();
	last_td.append('<img id="theImg" src="./image/check.jpg" />');
}