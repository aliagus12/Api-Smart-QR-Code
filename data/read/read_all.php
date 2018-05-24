<?php

include_once ROOT. 'config/database.php';
include_once ROOT . 'object/attendance.php';

// requires headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files
/*include("/opt/lampp/htdocs/attandance_api/config/database.php");
include("/opt/lampp/htdocs/attandance_api/object/attendance.php");*/

//instantiate database and attandance objec
$database = new Database();
$db = $database->getConnection();

//initialize object
$attandance = new Attendance($db);

// query attandance
$stmt = $attandance->readAll();
$num = $stmt->rowCount();

//check if more than 0 recorc found
if($num > 0){
	// attandane array
	$attandance_arr = array();
	$attandance_arr["records"]= array();

	//retrive our table contents
	//fetch() is faster than fetchAll()
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//extract row
		//this will make $row['name'] to 
		//just $name only
		extract($row);

		$attandance_item = array(
			"email" => $email,
			"meet" => $meet,
			"location" => $location,
			"time" => $time
		);

		array_push($attandance_arr["records"], $attandance_item);
	}
	echo json_encode($attandance_arr);
} else {
	echo json_encode(
		array("message" => "No Data Attandance Found.")
	);
}

