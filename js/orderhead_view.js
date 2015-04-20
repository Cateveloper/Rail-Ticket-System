$(document).ready(function() {
	add_button();
});

function add_button(){

	$("#order_head_table tr:gt(0)").each(function(){
		var order_head_id = $(this).children().first().text();
		var last_td = $(this).children().last();
		
		last_td
			.append('<input type="button" value="View Detail"/>')
			.click(function(){
				view_detail(order_head_id);
			});
	});
}

function view_detail(id){
	window.location.href = "orderdetail_view.php?order_head_id="+id;
}