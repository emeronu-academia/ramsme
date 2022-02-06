<?php 
	/*
	* Test
	*/
	
	//database constants
	define('DB_HOST', 'localhost');
	define('DB_USER', 'intell77_MjNjM');
	define('DB_PASS', 'Majiyebo73@');
	define('DB_NAME', 'dbcdvk6zwga9hz');
	
	//connecting to database and getting the connection object
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	//Checking if any error occured while connecting
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
	}
	
	//creating a query
	$stmt = $conn->prepare("SELECT id, timestamp, name, phone, avenue, street FROM cbeas_subscription;");
	
	//executing the query 
	$stmt->execute();
	
	//binding results to the query 
	$stmt->bind_result($id, $timestamp, $name, $phone, $avenue, $street);
	
	$clients = array(); 
	
	//traversing through all the result 
	while($stmt->fetch()){
		$temp = array();
		$temp['id'] = $id;
		$temp['timestamp'] = $timestamp; 
		$temp['name'] = $name; 
		$temp['phone'] = $phone; 
		$temp['avenue'] = $avenue; 
		$temp['street'] = $street;
		array_push($clients, $temp);
	}
	
	//displaying the result in json format 
	echo json_encode($clients);
	
	