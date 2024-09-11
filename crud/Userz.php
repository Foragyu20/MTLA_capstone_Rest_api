<?php
// Database connection parameters
include '../conz.php';

// Set headers to allow cross-origin requests (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Handle HTTP request methods
$method = $_SERVER["REQUEST_METHOD"];

// Show all records
if ($method === "GET") {
    $query = "SELECT username, recent_log, expire FROM users";
    $result = $connection->query($query);

    if ($result) {
        $records = array();

        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
        echo json_encode($records);
    } else {
        http_response_code(500);
        json_encode(array("message" => "Unable to fetch records."));
    }
}

$connection->close();
?>