<?PHP
require_once("./utility.php");
require_once("./login.php");

$login_status = CheckLogin();

$total_amount = 0;
$total_qty = 0;
$order_head_id = 0;

if ($login_status == NOT_LOGIN)
	Redirect("index.php");
else
{
	if(isset($_COOKIE["shopping_cart"]))
	{
		$con = mysqli_connect($host_name, $user_id, $user_pwd, $db_name);
		if (!$con) {
			die('Could not connect: ' . mysqli_error($con));
		}

		mysqli_select_db($con, $db_name);
		mysqli_autocommit($con, FALSE);
		
		$insert_query = "INSERT INTO order_head(user_id, order_date) VALUES('".$_SESSION['user_id']."', now())";
		$result = mysqli_query($con, $insert_query);

		if(!$result)
		{
			mysqli_rollback($con);
			echo "1Oops, we couldn't place this order for you now. Please try again later. (If this keeps show up, please contact administrator.)<br/>";
			echo "<a href='javascript:history.back()'>Go Back</a>";
			exit();
		}		
		
		$order_head_id = mysqli_insert_id($con);
		
		$cookie = json_decode($_COOKIE["shopping_cart"],true);
		$order = $cookie['order'];

		for($x = 0 ; $x < count($order) ; $x++)
		{
			$item_id = $order[$x]['item_id'];
			$item_date = $order[$x]['item_date'];
			$item_qty = $order[$x]['item_qty'];
			$item_price = $order[$x]['item_price'];

			$insert_query = "INSERT INTO order_detail(order_head_id, ticket_date, item_id, qty, unit_price) VALUES('".$order_head_id."', '".$item_date."','".$item_id."','".$item_qty."','".$item_price."')";
			$result = mysqli_query($con, $insert_query);

			if(!$result)
			{
				mysqli_rollback($con);
				echo "2Oops, we couldn't place this order for you now. Please try again later. (If this keeps show up, please contact administrator.)<br/>";
				echo "<a href='javascript:history.back()'>Go Back</a>";
				exit();
			}
		}		
		
		mysqli_commit($con);
		
		mysqli_close($con);	
		
		setcookie("shopping_cart", "", time()+3600);
	}
}		
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="./css/form.css" type="text/css">
	<script src="./js/jquery-1.11.2.min.js"></script>	
	<script src="./js/jquery.cookie.js"></script>
	<title>Rail Tickets System</title>
</head>
<body>
	<div id="content" style="width:550px;">

		<form id="cart_form" action="personal_info.php" method="post">
		
			<fieldset>
			<legend>Order #<?php echo $order_head_id; ?></legend>

			<div class='container'>
                <table id='cart_table' border="1" width='100%'>
                    <tr>
						<th>Route Number</th>
						<th>Route Date</th>
						<th>Start Station Name</th>
						<th>Destination Station Name</th>
						<th>Departure Time</th>
						<th>Arrival Time</th>							
						<th>Price</th>
						<th>Qty</th>
                    </tr>
<?php
					if($order_head_id > 0)
					{
						$sql = " SELECT s.railroad_number, od.ticket_date, (SELECT city_name FROM city WHERE city_id = s.departure_city_id) as departure_city " .
							   " , (SELECT city_name FROM city WHERE city_id = s.arrival_city_id) as arrival_city, s.departure_time , s.arrival_time, " . 
							   " od.unit_price, od.qty FROM order_head oh JOIN order_detail od ON oh.order_head_id = od.order_head_id " .
							   " JOIN schedule s ON od.item_id = s.schedule_id " . 
							   " WHERE oh.order_head_id = $order_head_id AND oh.is_delete = 0 AND od.is_delete = 0 " . 
							   " ORDER BY od.order_detail_id " ;

						$result = DB_Query($sql);

						if ($result && mysqli_num_rows($result) > 0)
						{
							while($row = mysqli_fetch_array($result))
							{
?>						
								<tr>
									<td><?php echo $row["railroad_number"]; ?></td>
									<td><?php echo $row["ticket_date"]; ?></td>
									<td><?php echo $row["departure_city"]; ?></td>
									<td><?php echo $row["arrival_city"]; ?></td>
									<td><?php echo $row["departure_time"]; ?></td>
									<td><?php echo $row["arrival_time"]; ?></td>
									<td><?php echo $row["unit_price"]; ?></td>
									<td><?php echo $row["qty"]; ?></td>
								</tr>
<?php
								$total_qty += intval($row["qty"]);
								$total_amount += ( intval($row["unit_price"]) * intval($row["qty"]) );
							
							}
						}
					}
?>					
				</table>	
			</div>
			
			<div class='container'>
                <table id='result_table' border="0" width='100%'>
<?php
					if($total_qty > 0)
					{
?>					
						<tr>
							<td align="right">Total Qty Of Tickets : </td>
							<td align="right"><?php echo $total_qty; ?></td>
						</tr>
<?php
					}
					
					if($total_amount > 0)
					{					
?>
						<tr>
							<td align="right">Total Amount : </td>
							<td align="right"><?php echo $total_amount; ?></td>
						</tr>	
<?php
					}
?>					
				</table>	
			</div>	
		
			<div class='short_explanation' align="right">
				<a href='index.php'>Go back</a>
			</div>	
			
			</fieldset>	
		</form>

	</div>
</body>
</html>