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
	if(isset($_GET["order_head_id"]))
		$order_head_id = intval($_GET["order_head_id"]);
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
					if($order_head_id > 0 )
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
				<a href='javascript:history.back()'>Go Back</a>
			</div>	
			
			</fieldset>	
		</form>

	</div>
</body>
</html>