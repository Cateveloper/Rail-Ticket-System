<?PHP
require_once("./utility.php");
require_once("./login.php");

$name = "";
$email = "";
$phone = "";
$err = "";
$update_err = "";
$show_msg = "";

$login_status = CheckLogin();

if ($login_status != NOT_LOGIN)
{
	if (empty($_SESSION['user_id']))
		Redirect("index.php");
	else
	{
		if(isset($_POST["updated"]) && $_POST["updated"] == "1")
			update_person_info($_SESSION['user_id']);
			
		get_person_info($_SESSION['user_id']);

	}
}
else
	Redirect("index.php");

function get_person_info($id)
{
	global $name, $email, $phone, $err;
	
    $sql = "SELECT user_name, email, phone FROM users WHERE user_id='$id'";

    $result = DB_Query($sql);

    if (!$result || mysqli_num_rows($result) <= 0)
    {
        $err = "Oops, some internal error happens, please try again later or contact administrator.";
    }
        
    $row = mysqli_fetch_assoc($result);

	$name = $row['user_name'];
	$email = $row['email'];
    $phone = $row['phone'];	
}

function update_person_info($id)
{
	global $update_err, $show_msg;
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$name = trim($_POST['tx_name']);
		$phone = trim($_POST['tx_phone']);
		$old_password = trim($_POST['tx_password']);
		$new_password = trim($_POST['tx_new_password']);

		//check old password matches or not
		if($old_password != "" && $new_password != "" )
		{
			$check_query = "SELECT * FROM users WHERE user_id = '$id' AND password = MD5('$old_password')";
			$check_result = DB_Query($check_query);

			if (!$check_result || mysqli_num_rows($check_result) <= 0)
				$update_err = 'Update password failed. Old password didnt match';
			else
			{
				$change_pw_query = "UPDATE users SET password = MD5('$new_password') WHERE user_id = '$id'";
				$pw_result = DB_Query($change_pw_query);		

				if (!$pw_result)
					$update_err = 'Update password failed.';
				else
					$show_msg = "Update password succeeded";
			}
		}
		
		$update_query = "UPDATE users SET user_name = '".$name."', phone = '".$phone."' WHERE user_id='$id' ";

		$update_result = DB_Query ($update_query);
		
		if(!$update_result)
		{
			if($update_err != "")
				$update_err = $update_err . "<br/>";
			$update_err = $update_err . "Update name/phone failed.";
		}
		else
		{
			if($show_msg != "")
				$show_msg = $show_msg . "<br/>";
			$show_msg = $show_msg . "Update name/phone succeeded";		
		}
	}	
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

		<form id="info_form" action="personal_info.php" method="post">
		
			<fieldset >
			<legend>Perosonal Info</legend>
			
			<input type='hidden' name='updated' id='updated' value='0'/>
			<div class='short_explanation'><label for='show_msg' ><?php echo $show_msg; ?></label></div>
			<div class='short_explanation'><span id='error_msg' class='error'><?php echo $err; ?></span></div>
			<div class='short_explanation'><span id='upd_error_msg' class='error'><?php echo $update_err; ?></span></div>
			
			<div class='container'>
				<label for='username' >Name:</label><br/>
				<input type='text' name='tx_name' id='tx_name' maxlength="50" value="<?php echo $name; ?>"/>
				<span id='login_username_errorloc' class='error'></span>
			</div>
			<div class='container'>
				<label for='email' >Email:</label><br/>
				<input type='text' name='tx_email' id='tx_email' maxlength="100" value="<?php echo $email; ?>" readonly/><br/>
				<span id='login_email_errorloc' class='error'></span>
			</div>
			<div class='container'>
				<label for='phone' >Phone:</label><br/>
				<input type='text' name='tx_phone' id='tx_phone' maxlength="50" value="<?php echo $phone; ?>"/><br/>
				<span id='login_phone_errorloc' class='error'></span>
			</div>
			<div class='container'>
				<label for='password' >Old Password:</label><br/>
				<input type='password' name='tx_password' id='tx_password' maxlength="50" /><br/>
				<span id='login_password_errorloc' class='error'></span>
			</div>			
			<div class='container'>
				<label for='password' >New Password:</label><br/>
				<input type='password' name='tx_new_password' id='tx_new_password' maxlength="50" /><br/>
				<span id='login_new_password_errorloc' class='error'></span>
			</div>		
			<div class='container'>
				<label for='password' >Re-enter New Password:</label><br/>
				<input type='password' name='tx_new_password_chk' id='tx_new_password_chk' maxlength="50" /><br/>
				<span id='login_new_passwordck_errorloc' class='error'></span>
			</div>
			
			<div class='container'>
				<input type='submit' name='Submit' value='Submit' />
			</div>
			
			<div class='short_explanation'>
				<a href='index.php'>Go home</a>
			</div>
			
			</fieldset>	
		</form>

	</div>
</body>
</html>