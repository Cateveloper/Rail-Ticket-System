var check_pw_strength = function (pw){

	if (!pw.match(/[A-Z]/g))
	{
		return "at lease contains one upper case letter";
	}
	
	if (!pw.match(/[0-9]/g))
	{
		return "at lease contains one number digit";
	}

	if (!pw.match(/(.*[!,@,#,$,%,^,&,*,?,_,~])/))
	{
		return "at lease contains one !@#$%^&*?_~";
	}	
	
	return "";
}