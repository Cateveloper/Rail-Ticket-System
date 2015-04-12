$(document).ready(function() {
	$( "#register_form" ).bind( "onsubmit", test);
});

var test = function (){
	alert("test");
	
	return false;
}