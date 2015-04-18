<?PHP
require_once("./login.php");

$login_status = CheckLogin();

if (NOT_LOGIN == $login_status)
{
    Redirect('index.php');
}
else if (IS_ADMIN == $login_status)
{
    echo 'is admin<br>';
}
else
{
    echo 'is user<br>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="./css/form.css" type="text/css">
	<script src="./js/jquery-1.11.2.min.js"></script>	
	<script src="./js/personal_info.js"></script>
	<script src="./js/utility.js"></script>
	<title>Rail Tickets System</title>
</head>
<body>
	<div id="content">
	
		<table>
		<tr><td valign='top'>
        <fieldset>
        <legend>User Account</legend>

        <div class='container'>
            <label for='username' >Hi, XXXX !</label>
        </div>
		<hr/>
        <div class='container'>
            <label for='personal_info' ><a href='personal_info.php'>Personal Info</a></label>
        </div>
		<hr/>
        <div class='container'>
            <label for='order_history' ><a href='register.php'>Order History</a></label>
        </div>

        </fieldset>	
		</td>
		<td>
		<form id="info_form" action="personal_info.php" method="post">
		
			<fieldset >
			<legend>Perosonal Info</legend>
			
			<div class='container'>
				<label for='username' >Name:</label><br/>
				<input type='text' name='tx_name' id='tx_name' maxlength="50" />
				<span id='login_username_errorloc' class='error'></span>
			</div>
			<div class='container'>
				<label for='email' >Email:</label><br/>
				<input type='text' name='tx_email' id='tx_email' maxlength="100" readonly/><br/>
				<span id='login_email_errorloc' class='error'></span>
			</div>
			<div class='container'>
				<label for='phone' >Phone:</label><br/>
				<input type='text' name='tx_phone' id='tx_phone' maxlength="50" /><br/>
				<span id='login_phone_errorloc' class='error'></span>
			</div>
			<div class='container'>
				<label for='password' >New Password:</label><br/>
				<input type='password' name='tx_new_password' id='tx_new_password' maxlength="50" /><br/>
				<span id='login_password_errorloc' class='error'></span>
			</div>		
			<div class='container'>
				<label for='password' >Re-enter New Password:</label><br/>
				<input type='password' name='tx_new_password_chk' id='tx_new_password_chk' maxlength="50" /><br/>
				<span id='login_passwordck_errorloc' class='error'></span>
			</div>
			
			<div class='container'>
				<input type='submit' name='Submit' value='Submit' />
			</div>
			</fieldset>	
		</form>
		</td></tr>
		</table>
	</div>
</body>
</html>