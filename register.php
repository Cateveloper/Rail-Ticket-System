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
		<input id="tx_name" type="text" value="name" onFocus="this.select();"/>
		<input id="tx_email" type="text" value="email" onFocus="this.select();"/>
		<input id="tx_phone" type="text" value="phone" onFocus="this.select();"/>
		<input id="tx_password" type="password" value="password" onFocus="this.select();"/>
		<input id="tx_name" type="password" value="password_chk" onFocus="this.select();"/>
		<textarea></textarea>
		<input type="submit" value="Send"/>
	</form>
</body>
</html>