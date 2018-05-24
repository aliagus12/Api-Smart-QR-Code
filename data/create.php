<?php

if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// requires headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object files
include_once ROOT. 'config/database.php';
include_once ROOT. 'object/attandance.php';

$database = new Database();
$db = $database->getConnection();
$attendance = new Attendance($db);

// get post data
//$data = json_decode(file_get_contents("php://input"));
if (isset($_POST['email'])) {
    if ($_POST) {
        // set product property values
        $attendance->email = $_POST['email'];
        $attendance->meet = isset($_GET['meet']) ? $_GET['meet'] : "";
        $attendance->location = isset($_GET['location']) ? $_GET['location'] : "";
        $attendance->time = isset($_GET['time']) ? $_GET['time'] : (int)(microtime(true) * 1000);
        // create the attandance data
        $isSuccess = $attendance->create();
        if ($isSuccess) {
            $response['email'] = $attendance->email;
            $response['meet'] = $attendance->meet;
            $response['location'] = $attendance->location;
            $response['time'] = $attendance->time;
        }
        $response['success'] = $isSuccess;
        echo json_encode($response);
    } else {
        echo '{';
        echo '"message": "Error"';
        echo '}';
    }
} else {
    echo '{';
    echo '"message": "Bad Request"';
    echo '}';
}