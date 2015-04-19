<?php
include './utility.php';

if(!isset($_GET["email"]))
	add_user();
else
	check_duplicate();

function add_user()
{
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$name = trim($_POST['tx_name']);
		$email = trim($_POST['tx_email']);
		$phone = trim($_POST['tx_phone']);
		$password = trim($_POST['tx_password']);

		$insert_query = "INSERT INTO users(user_name, email, phone, password) VALUES('".$name."','".$email."','".$phone."','".md5($password)."')";

		$result = DB_Query ($insert_query);
		
		if($result != false)
			Redirect('index.php');
		else
		{
			echo "Oops, we couldn't register you now. Please try again. (If this keeps show up, please contact administrator.)<br/>";
			echo "<a href='javascript:history.back()'>Go Back</a>";
		}
	}
}

function check_duplicate()
{
	$check_duplicate = "SELECT * FROM users WHERE email = '".$_GET["email"]."'";
	
	$result_dup = DB_Query ($check_duplicate);
	
	$row_count = mysqli_num_rows($result_dup);
	
	echo $row_count;
}
?>