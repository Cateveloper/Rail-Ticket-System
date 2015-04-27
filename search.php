<?php

function Search()
{
	global $search_result;

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$d_city = trim($_POST['d_city']);
		$a_city = trim($_POST['a_city']);
		$d_time = trim($_POST['d_time']);
		$a_time = trim($_POST['a_time']);
		$d_date = trim($_POST['d_date']);

		$insert_query = "SELECT schedule_id, railroad_number, '".$d_date."' AS d_date, (SELECT city_name FROM city WHERE city_id = schedule.departure_city_id) as departure_city, " .
						" (SELECT city_name FROM city WHERE city_id = schedule.arrival_city_id) as arrival_city, " .
						" departure_time, arrival_time, price FROM schedule WHERE is_delete = 0 ";

		if($d_city != "")
			$insert_query = $insert_query . " AND departure_city_id = $d_city ";

		if($a_city != "")
			$insert_query = $insert_query . " AND arrival_city_id = $a_city ";
			
		if($d_time != "")
			$insert_query = $insert_query . " AND departure_time >= '$d_time' ";			

		if($a_time != "")
			$insert_query = $insert_query . " AND arrival_time >= '$a_time' ";	
			
		$search_result = DB_Query ($insert_query);
	}

}

?>