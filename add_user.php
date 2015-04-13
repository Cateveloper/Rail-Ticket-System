<?php
include 'utility.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = ($_POST['tx_name']);
	$email = ($_POST['tx_email']);
	$phone = ($_POST['tx_phone']);
	$password = ($_POST['tx_password']);

	$check_duplicate = "SELECT * FROM users WHERE email = '".$email."'";
	
	$result_dup = DB_Query ($check_duplicate);
	
	$row_count = $result_dup->num_rows;
	
	echo "row_count:".$row_count;
	if($row_count == 0 )
	{
		$insert_query = "INSERT INTO users(user_name, email, phone, password) VALUES('".$name."','".$email."','".$phone."','".md5($password)."')";

		$result = DB_Query ($insert_query);
		
		if($result != false)
			echo "<a href='index.php'>insert success</a>";
		else
			echo "<a href='index.php'>insert failed</a>";
	}
	else
	{
		echo "Oops, someone has the same email like you. Please change another email address.<br/>";
		echo "<a href='javascript:history.back()'>Go Back</a>";
	}
}

?>