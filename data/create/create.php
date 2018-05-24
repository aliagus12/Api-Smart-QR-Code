<?php

/*if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}*/

define('ROOT', '../../');
include_once ROOT . 'config/database.php';
include_once ROOT . 'object/attendance.php';

// requires headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object files

$database = new Database();
$db = $database->getConnection();
$attandance = new Attendance($db);

// get post data
//$data = json_decode(file_get_contents("php://input"));
if (isset($_POST['email'])) {
    if ($_POST) {
        // set product property values
        $attandance->email = $_POST['email'];
        $attandance->meet = isset($_GET['meet']) ? $_GET['meet'] : "";
        $attandance->location = isset($_GET['location']) ? $_GET['location'] : "";
        $attandance->time = isset($_GET['time']) ? $_GET['time'] : (int)(microtime(true) * 1000);
        // create the attandance data
        $isSuccess = $attandance->create();
        if ($isSuccess) {
            $response['email'] = $attandance->email;
            $response['meet'] = $attandance->meet;
            $response['location'] = $attandance->location;
            $response['time'] = $attandance->time;
        }
        $response['success'] = $isSuccess;
        echo json_encode($response);
    } else {
        http_response_code(400);
        echo '{';
        echo '"message": "Bad Request"';
        echo '}';
    }
} else {
    http_response_code(404);
    echo '{';
    echo '"message": "Not Found"';
    echo '}';
}