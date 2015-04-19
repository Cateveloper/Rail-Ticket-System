$(document).ready(function() {
	//$("#register_form").on("submit", Validation);
	$("#info_form").submit(validation);
});

var clean = function(){
	$('#login_username_errorloc').text("");
	$('#login_password_errorloc').text("");
	$('#login_new_password_errorloc').text("");
	$('#login_new_passwordck_errorloc').text("");
}

var validation = function() {

	clean();

	var username = $('#tx_name').val();
	var password = $('#tx_password').val();
	var new_password = $('#tx_new_password').val();
	var new_re_password = $('#tx_new_password_chk').val();
	
	if(username.length == 0)
	{
		$('#login_username_errorloc').text("Please enter Name!");
		return false;
	}
	
	if(new_password.length > 0 && password.length == 0)
	{
		$('#login_password_errorloc').text("Please enter old password!");
		return false;
	}
	else if(new_password.length > 0 && password.length > 0)
	{
		var pw_strength = check_pw_strength($('#tx_new_password').val());
		if( pw_strength == "")
		{
			if(new_re_password.length == 0)
			{
				$('#login_new_passwordck_errorloc').text("Please enter second password to check!");
				return false;
			}
			
			if(new_password.length > 0 && new_re_password.length > 0 && new_password != new_re_password )
			{
				$('#login_new_passwordck_errorloc').text("These two passwords should match");
				return false;
			}
		}
		else
		{
			$('#login_new_password_errorloc').text(pw_strength);
			return false;
		}
	}
	
	$('#updated').val("1");
	
	return true;
}
