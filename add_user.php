<?php
include 'utility.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = ($_POST['tx_name']);
	$email = ($_POST['tx_email']);
	$phone = ($_POST['tx_phone']);
	$password = ($_POST['tx_password']);

	$insert_query = "INSERT INTO users(user_name, email, phone, password) VALUES('".$name."','".$email."','".$phone."','".$password."')";

	$result = DB_Query ($insert_query);
	
	if($result != false)
		echo "<a href='index.php'>insert success</a>";
	else
		echo "<a href='index.php'>insert failed</a>";
}

?>