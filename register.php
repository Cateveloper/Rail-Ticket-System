<?PHP
require_once("./login.php");

$login_status = CheckLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/form.css" type="text/css">
	<script src="js/jquery-1.11.2.min.js"></script>	
	<script src="js/register.js"></script>
	<script src="js/utility.js"></script>
	<title>Rail Tickets System</title>
</head>
<body>
	<div id="content">
	<form id="register_form" action="add_user.php" method="post">
	
		<fieldset >
		<legend>Register</legend>
		
		<div class='short_explanation'>* required fields</div>
		
		<div class='container'>
			<label for='username' >Name*:</label><br/>
			<input type='text' name='tx_name' id='tx_name' maxlength="50" />
			<span id='login_username_errorloc' class='error'></span>
		</div>
		<div class='container'>
			<label for='email' >Email*:(use as login ID)</label><br/>
			<input type='text' name='tx_email' id='tx_email' maxlength="100" /><br/>
			<span id='login_email_errorloc' class='error'></span>
		</div>
		<div class='container'>
			<label for='phone' >Phone:</label><br/>
			<input type='text' name='tx_phone' id='tx_phone' maxlength="50" /><br/>
			<span id='login_phone_errorloc' class='error'></span>
		</div>
		<div class='container'>
			<label for='password' >Password*:</label><br/>
			<input type='password' name='tx_password' id='tx_password' maxlength="50" /><br/>
			<span id='login_password_errorloc' class='error'></span>
		</div>		
		<div class='container'>
			<label for='password' >Re-enter Password*:</label><br/>
			<input type='password' name='tx_password_chk' id='tx_password_chk' maxlength="50" /><br/>
			<span id='login_passwordck_errorloc' class='error'></span>
		</div>
		
		<div class='container'>
			<input type='submit' name='Submit' value='Submit' />
		</div>
		
        <div class='short_explanation'>
            <a href='index.php'>Go back</a>
        </div>		
		</fieldset>	
	</form>
	</div>
</body>
</html>