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
    $query = "SELECT * FROM ilocano_translation";
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

// Add a new record
if ($method === "POST") {
    $ilocano = $_POST["ilocano"];
    $englishIlocano = $_POST["englishIlocano"];
    $filipinoIlocano = $_POST["filipinoIlocano"];
    $pangasinanIlocano = $_POST["pangasinanIlocano"];

    $query = "INSERT INTO ilocano_translation (ilocano, englishIlocano, filipinoIlocano, pangasinanIlocano) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssss", $ilocano, $englishIlocano, $filipinoIlocano, $pangasinanIlocano);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(array("message" => "Record added successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Unable to add record."));
    }
}

// Edit an existing record
if ($method === "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);

    $id = $_PUT["id"];
    $ilocano = $_PUT["ilocano"];
    $englishIlocano = $_PUT["englishIlocano"];
    $filipinoIlocano = $_PUT["filipinoIlocano"];
    $pangasinanIlocano = $_PUT["pangasinanIlocano"];

    $query = "UPDATE ilocano_translation SET ilocano = ?, englishIlocano = ?, filipinoIlocano = ?, pangasinanIlocano = ? WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssssi", $ilocano, $englishIlocano, $filipinoIlocano, $pangasinanIlocano, $id);

    if ($stmt->execute()) {
        echo json_encode(array("message" => "Record updated successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Unable to update record."));
    }
}

// Delete a record
if ($method === "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);

    $id = $_DELETE["id"];

    $query = "DELETE FROM ilocano_translation WHERE id = ?";
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
