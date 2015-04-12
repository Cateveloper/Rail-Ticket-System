<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/form.css" type="text/css">
	<script src="js/jquery-1.11.2.min.js"></script>	
	<script src="js/register.js"></script>
	<title>Rail Tickets System</title>
</head>
<body>
	<form id="register_form" action="index.php" method="post" class="message">
		Name : <input id="tx_name" type="text" onFocus="this.select();"/>
		Email : <input id="tx_email" type="text" onFocus="this.select();"/>
		Phone : <input id="tx_phone" type="text" onFocus="this.select();"/>
		Password : <input id="tx_password" type="password" onFocus="this.select();"/>
		Re-enter Password : <input id="tx_password_chk" type="password" onFocus="this.select();"/>
		<input id="register_submit" type="submit" value="Send"/>
	</form>
</body>
</html>