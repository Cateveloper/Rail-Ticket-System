<?PHP
require_once("./utility.php");
require_once("./login.php");

$login_status = CheckLogin();

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
	<script src="./js/orderhead_view.js"></script>
	<title>Rail Tickets System</title>
</head>
<body>
	<div id="content" style="width:550px;">

		<form id="oh_form" action="personal_info.php" method="post">
		
			<fieldset>
			<legend>Order History</legend>

			<div class='container'>
                <table id='order_head_table' border="1" width='100%' style="text-align:center;">
                    <tr>
						<th>Order Number</th>
						<th>Order Date</th>
						<th></th>
                    </tr>
<?php
					if(!empty($_SESSION['user_id']))
					{
						$sql = " SELECT order_head_id, order_date FROM order_head WHERE user_id = ".$_SESSION['user_id']." AND is_delete = 0 " ;

						$result = DB_Query($sql);

						if ($result && mysqli_num_rows($result) > 0)
						{
							while($row = mysqli_fetch_array($result))
							{
?>						
								<tr>
									<td><?php echo $row["order_head_id"]; ?></td>
									<td style="width:250px;"><?php echo $row["order_date"]; ?></td>
									<td align="center"></td>
								</tr>
<?php
							}
						}
					}
?>					
				</table>	
			</div>
		
			<div class='short_explanation' align="right">
				<a href='index.php'>Go Back</a>
			</div>	
			
			</fieldset>	
		</form>

	</div>
</body>
</html>