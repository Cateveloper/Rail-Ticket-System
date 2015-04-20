<?PHP
require_once("./utility.php");
require_once("./login.php");

$login_status = CheckLogin();

$total_amount = 0;
$total_qty = 0;

if ($login_status == NOT_LOGIN)
	Redirect("index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="./css/form.css" type="text/css">
	<script src="./js/jquery-1.11.2.min.js"></script>	
	<script src="./js/jquery.cookie.js"></script>
	<script src="./js/shop_cart.js"></script>
	<title>Rail Tickets System</title>
</head>
<body>
	<div id="content" style="width:550px;">

		<form id="cart_form" action="cart_confirm.php" method="post">
		
			<fieldset>
			<legend>Shopping Cart</legend>

			<div class='container'>
                <table id='cart_table' border="1" width='100%'>
                    <tr>
						<th>Schedule ID</th>
						<th>Route Number</th>
						<th>Route Date</th>
						<th>Start Station Name</th>
						<th>Destination Station Name</th>
						<th>Departure Time</th>
						<th>Arrival Time</th>							
						<th>Price</th>
						<th>Available Qty</th>						
						<th>Qty</th>
						<th></th>
                    </tr>
<?php
					if(isset($_COOKIE["shopping_cart"]))
					{
						$cookie = json_decode($_COOKIE["shopping_cart"],true);
						$order = $cookie['order'];

						for($x = 0 ; $x < count($order) ; $x++)
						{
							$item_id = $order[$x]['item_id'];
							$item_date = $order[$x]['item_date'];
							$item_qty = $order[$x]['item_qty'];
							$train_total_qty = 0;
							$ordered_qty = 0;
							
							$sql = "SELECT railroad_number, (SELECT city_name FROM city WHERE city_id = departure_city_id) as departure_city " .
								   ", (SELECT city_name FROM city WHERE city_id = arrival_city_id) as arrival_city " . 
								   ", departure_time , arrival_time, price FROM schedule WHERE schedule_id=$item_id AND is_delete = 0 ";

							$result = DB_Query($sql);

							if (!$result || mysqli_num_rows($result) <= 0)
							{
								echo "<tr><td colspan='10'>Oops, some internal error happens, please try again later or contact administrator.</td></tr>";
							}
							else
							{
								$sql = "SELECT number_seats FROM schedule s JOIN train t ON s.train_id = t.train_id WHERE s.schedule_id = $item_id";
								$result_train_qty = DB_Query($sql);
								if ($result_train_qty && mysqli_num_rows($result_train_qty) > 0)
								{
									$row = mysqli_fetch_assoc($result_train_qty);
									$train_total_qty = intval($row["number_seats"]);
								}
								
								$sql = "SELECT SUM(qty) AS order_qty FROM order_detail WHERE is_delete = 0 AND item_id = $item_id AND ticket_date = $item_date";
								$result_order_qty = DB_Query($sql);
								if ($result_order_qty && mysqli_num_rows($result_order_qty) > 0)
								{
									$row = mysqli_fetch_assoc($result_order_qty);
									$ordered_qty = intval($row["order_qty"]);
								}								
								
								
								
								//if avaiable ticket is less than qty, set qty to avaliable ticket number
								if( ($train_total_qty - $ordered_qty) < $item_qty )
								{
?> 
									<script>alert("<?php echo $row["railroad_number"]; ?> does not have enough tickts. The maximum tickets is <?php echo $train_total_qty - $ordered_qty ; ?>");</script>
<?php
									$item_qty = $train_total_qty - $ordered_qty;
									$order[$x]['item_qty'] = $item_qty;
								}
								
								$row = mysqli_fetch_assoc($result);
								if($item_qty > 0)
								{
?>													
									<tr>
										<td><?php echo $item_id; ?></td>
										<td><?php echo $row["railroad_number"]; ?></td>
										<td><?php echo $item_date; ?></td>
										<td><?php echo $row["departure_city"]; ?></td>
										<td><?php echo $row["arrival_city"]; ?></td>
										<td><?php echo $row["departure_time"]; ?></td>
										<td><?php echo $row["arrival_time"]; ?></td>
										<td><?php echo $row["price"]; ?></td>
										<td><?php echo $train_total_qty - $ordered_qty ; ?></td>
										<td><input type='text' class="num" name='tx_qty_<?php echo $item_id; ?>' id='tx_qty_<?php echo $item_id; ?>' maxlength="5" value="<?php echo $item_qty; ?>"/></td>
										<td align="center"></td>
									</tr>
<?php
								}
								else
								{
									unset($order[$x]);
								}
							}
							$total_qty += intval($item_qty);
							$total_amount += ( intval($row["price"]) * $item_qty );
						}
						
						//store data back into cookie
						$cookie['order'] = $order;
						$cookie_out = json_encode($cookie);
						setcookie("shopping_cart", $cookie_out, time()+3600);
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

<?php
		if(isset($_COOKIE["shopping_cart"]))
		{
?>		
			<div class='container' align="right">
				<input type='submit' name='Submit' id='Submit' value='Submit' />
			</div>
<?php
		}
?>			
			<div class='short_explanation' align="right">
				<a href='index.php'>Go back</a>
			</div>	
			
			</fieldset>	
		</form>

	</div>
</body>
</html>