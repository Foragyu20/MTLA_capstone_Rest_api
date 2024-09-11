<?php
// Database connection parameters
include '../conz.php';
// Set headers to allow cross-origin requests (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, DELETE");

// Handle HTTP request methods
$method = $_SERVER["REQUEST_METHOD"];

// Show all records
if ($method === "GET") {
    $query = "SELECT * FROM audio_pangasinan";
    $result = $connection->query($query);

    if ($result) {
        $records = array();

        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }

        echo json_encode($records);
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Unable to fetch records."));
    }
}

// Delete a record
if ($method === "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);

    $id = $_DELETE["id"];

    $query = "DELETE FROM audio_pangasinan WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(array("message" => "Record deleted successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Unable to delete record."));
    }
}

// Close the database connection
$connection->close();
?>
