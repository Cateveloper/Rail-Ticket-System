<?PHP
require_once("./utility.php");
require_once("./login.php");

$login_status = CheckLogin();

if ($login_status != NOT_LOGIN)
{
	echo $_COOKIE["shopping_cart"];
}
else
	Redirect("index.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="./css/form.css" type="text/css">
	<script src="./js/jquery-1.11.2.min.js"></script>	
	<script src="./js/shop_cart.js"></script>
	<title>Rail Tickets System</title>
</head>
<body>
	<div id="content">

		<form id="cart_form" action="personal_info.php" method="post">
		
			<fieldset>
			<legend>Shopping Cart</legend>

			<div class='container'>
                <table id='cart_table' border="1" width='100%'>
                    <tr>
						<th>Route ID</th>
						<th>Start Station Name</th>
						<th>Destination Station Name</th>
						<th>Price</th>
						<th>Number</th>
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
			
			<div class='container'>
                <table id='result_table' border="0" width='100%'>
					<tr>
						<td align="right">Total Number Of Tickets : </td>
						<td align="right">123</td>
					</tr>
					<tr>
						<td align="right">Total Amount : </td>
						<td align="right">1230</td>
					</tr>					
				</table>	
			</div>	

			<div class='container' align="right">
				<input type='submit' name='Submit' id='Submit' value='Submit' />
			</div>
			
			<div class='short_explanation' align="right">
				<a href='index.php'>Go back</a>
			</div>	
			
			</fieldset>	
		</form>

	</div>
</body>
</html>