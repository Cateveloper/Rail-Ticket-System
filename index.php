<?PHP
require_once("./login.php");
require_once("./search.php");

$login_status = CheckLogin();

$search_result = null;

if (isset($_POST['searched']))
{
    Search();
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Rail Tickets</title>
	  <link rel="STYLESHEET" type="text/css" href="datetimepicker-master/jquery.datetimepicker.css" />
      <link rel="STYLESHEET" type="text/css" href="css/form.css" />
	  <script src="./js/jquery-1.11.2.min.js"></script>
	  <script src="./js/jquery.cookie.js"></script>
	  <script src="./js/index.js"></script>
	  <script src="datetimepicker-master/jquery.datetimepicker.js"></script>
</head>
<body>
    <div id='content'>
		
		<table>
		<tr>
		<td valign='top'>
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
            <label for='order_history' ><a href='orderhead_view.php'>Order History</a></label>
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

			<form id="search_form" action="index.php" method="post">
				<input type='hidden' name='searched' id='searched' value='1'/>
				
				<div class='short_explanation'>* required fields</div>
				<div class='container'>
					<table id='search_table' width='100%'>
						<tr>
							<td><label for='Departure_Station' >Departure Station</label></td>
							<td>
<?php
								$sql = " SELECT city_id, city_name FROM city WHERE is_delete = 0 " ;

								$result = DB_Query($sql);

								if ($result && mysqli_num_rows($result) > 0)
								{
									echo "<select id='d_city' name='d_city'>";
									echo "<option value=''>## Station Name ##</option>";
									while($row = mysqli_fetch_array($result))
									{
?>						
										<option value="<?php echo $row["city_id"]; ?>"><?php echo $row["city_name"]; ?></option>
<?php
									}
									echo "</select>";
								}							
?>
							</td>
							<td><label for='Arrival_Station' >Arrival Station</label></td>
							<td>
<?php
								$sql = " SELECT city_id, city_name FROM city WHERE is_delete = 0 " ;

								$result = DB_Query($sql);

								if ($result && mysqli_num_rows($result) > 0)
								{
									echo "<select id='a_city' name='a_city'>";
									echo "<option value=''>## Station Name ##</option>";
									while($row = mysqli_fetch_array($result))
									{
?>						
										<option value="<?php echo $row["city_id"]; ?>"><?php echo $row["city_name"]; ?></option>
<?php
									}
									echo "</select>";
								}							
?>							
							</td>
						</tr>	
						<tr>
							<td><label for='Departure_Time' >Departure Time</label></td>
							<td><input type="text" id="d_time" class="num" name="d_time" /></td>
							<td><label for='Arrival_Time' >Arrival Time</label></td>
							<td><input type="text" id="a_time" class="num" name="a_time" /></td>
						</tr>	
						<tr>
							<td><label for='Departure_Date' >Departure Date*</label></td>
							<td><input type="text" id="d_date" name="d_date" /></td>
							<td></td>
							<td></td>
						</tr>							
					</table>
				</div>	
				
				<div class='container'>
					<input type='submit' name='search' value='search' />
				</div>
			</form>
<?php
			if ($search_result && mysqli_num_rows($search_result) > 0)
			{
?>
				<div class='container'>
					<table id='result_table' border="1" width='100%'>
						<tr>
							<th>Schedule ID</th>
							<th>Route Number</th>
							<th>Route Date</th>
							<th>Departure Station Name</th>
							<th>Arrival Station Name</th>
							<th>Departure Time</th>
							<th>Arrival Time</th>						
							<th>Price</th>
							<th>Available Tickets</th>
							<th></th>
						</tr>
<?php
				while($row = mysqli_fetch_array($search_result))
				{
					$ordered_qty = 0;
					$train_total_qty = 0;
?>
						<tr>
							<td><?php echo $row["schedule_id"]; ?></td>
							<td><?php echo $row["railroad_number"]; ?></td>
							<td><?php echo $row["d_date"]; ?></td>
							<td><?php echo $row["departure_city"]; ?></td>
							<td><?php echo $row["arrival_city"]; ?></td>
							<td><?php echo $row["departure_time"]; ?></td>
							<td><?php echo $row["arrival_time"]; ?></td>						
							<td><?php echo $row["price"]; ?></td>
<?php
							$sql = "SELECT number_seats FROM schedule s JOIN train t ON s.train_id = t.train_id WHERE s.schedule_id = ".$row["schedule_id"];
							$sql2 = "SELECT SUM(qty) AS order_qty FROM order_detail WHERE is_delete = 0 AND item_id = ".$row["schedule_id"]." AND ticket_date = '". $row["d_date"]. "'";
							$result_train_qty = DB_Query($sql);
							if ($result_train_qty && mysqli_num_rows($result_train_qty) > 0)
							{
								$row = mysqli_fetch_assoc($result_train_qty);
								$train_total_qty = intval($row["number_seats"]);
							}
							
							
							$result_order_qty = DB_Query($sql2);
							if ($result_order_qty && mysqli_num_rows($result_order_qty) > 0)
							{
								$row = mysqli_fetch_assoc($result_order_qty);
								$ordered_qty = intval($row["order_qty"]);
							}	
?>							
							<td><?php echo $train_total_qty - $ordered_qty ; ?></td>
							<td align="center"></td>
						</tr>
<?php
				}
?>
					</table>	
				</div>
<?php				
			}
?>			
			</fieldset>		
		</td>
		</tr>
    </div>
</body>
