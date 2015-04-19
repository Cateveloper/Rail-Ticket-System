<?PHP
require_once("./login.php");

$login_status = CheckLogin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Rail Tickets</title>
      <link rel="STYLESHEET" type="text/css" href="css/form.css" />
	  <script src="./js/jquery-1.11.2.min.js"></script>
	  <script src="./js/jquery.cookie.js"></script>
	  <script src="./js/index.js"></script>
</head>
<body>
    <div id='content'>
		
		<table>
		<tr>
		<td>
<?PHP
if (NOT_LOGIN == $login_status)
{
?>
        <form id='login' action='login.php' method='post' accept-charset='UTF-8'>
        <fieldset>
        <legend>Login</legend>
        <input type='hidden' name='submitted' id='submitted' value='1'/>

        <div class='container'>
            <label for='username' >User ID</label><br/>
            <input type='text' name='username' id='username' value='' maxlength="50" /><br/>
            <span id='login_username_errorloc' class='error'></span>
        </div>

        <div class='container'>
            <label for='password' >Password</label><br/>
            <input type='password' name='password' id='password' maxlength="50" /><br/>
            <span id='login_password_errorloc' class='error'></span>
        </div>

        <div class='container'>
            <input type='submit' name='Submit' value='Submit' />
        </div>

        <div class='short_explanation'>
            <a href='reset-pwd-req.php'>Forgot Password?</a>
        </div>
		
        <div class='short_explanation'>
            <a href='register.php'>New User</a>
        </div>		
        </fieldset>
        </form>

<?PHP
}
else if (IS_ADMIN == $login_status)
{
?>
        <fieldset>
        <legend>Admin</legend>
        <div class='container'>
            <a href='manage_station.php'>Manage Stations</a>
        </div>

        <div class='container'>
            <a href='manage_route.php'>Manage Train Routes</a>
        </div>

        <div class='container'>
            <a href='sign_out.php'>Sign Out</a>
        </div>
        </fieldset>

<?PHP
}
else
{
?>
        <fieldset>
        <legend>User Account</legend>

        <div class='container'>
            <label for='username' >Hi, <?php echo $_SESSION['user_name']; ?> !</label>
        </div>
		<hr/>
        <div class='container'>
            <label for='shop_cart' ><a href='shop_cart.php'>Shopping Cart</a></label>
        </div>		
		<hr/>
        <div class='container'>
            <label for='personal_info' ><a href='personal_info.php'>Personal Info</a></label>
        </div>
		<hr/>
        <div class='container'>
            <label for='order_history' ><a href='order_history.php'>Order History</a></label>
        </div>
		<hr/>
        <div class='container'>
            <label for='sign_out' ><a href='sign_out.php'>Sign Out</a></label>
        </div>
        </fieldset>
<?PHP
}
?>
		</td>
		<td valign='top'>
			<fieldset>
			<legend>Search</legend>

			<div class='container'>
                <table id='result_table' border="1" width='100%'>
                    <tr>
						<th>Route ID</th>
						<th>Start Station Name</th>
						<th>Destination Station Name</th>
						<th>Price</th>
						<th>Available Tickets</th>
                    <th></th>
                    </tr>
					<tr>
						<td>123</td>
						<td>Taipei</td>
						<td>Taichung</td>
						<td>1,000</td>
						<td>500</td>
						<td align="center"></td>
					</tr>
					<tr>
						<td>456</td>
						<td>Taipei</td>
						<td>Taichung</td>
						<td>1,000</td>
						<td>500</td>
						<td align="center"></td>
					</tr>					
				</table>	
			</div>
			</fieldset>		
		</td>
		</tr>
    </div>
</body>
