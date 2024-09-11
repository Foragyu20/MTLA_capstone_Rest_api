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
    $query = "SELECT * FROM pangasinan_dictionary";
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
    $word = $_POST["word"];
    $part_of_speech = $_POST["part_of_speech"];
    $definition = $_POST["definition"];
    $example = $_POST["example"];



    $query = "INSERT INTO pangasinan_dictionary (word, part_of_speech,definition,example,) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssss", $word, $part_of_speech, $definition, $example);

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
    $word = $_PUT["word"];
    $part_of_speech = $_PUT["part_of_speech"];
    $definition = $_PUT["definition"];
    $example = $_PUT["example"];

    $query = "UPDATE pangasinan_dictionary SET word = ?, part_of_speech = ?, definition = ?, example = ? WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssssi", $word, $part_of_speech, $definition, $example, $id);

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

    $query = "DELETE FROM pangasinan_dictionary WHERE id = ?";
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
