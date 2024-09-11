<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "add_words";

// Create a connection to the database
$connection = new mysqli($host, $username, $password, $database);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Set headers to allow cross-origin requests (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE");

// Handle HTTP request methods
$method = $_SERVER["REQUEST_METHOD"];

// Show all records
if ($method === "GET") {
    $query = "SELECT * FROM ilocaadd";
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
    $translated_word_english = $_POST["translated_word_english"];
    $translated_word_pangasinan = $_POST["translated_word_pangasinan"];
    $translated_word_tagalog = $_POST["translated_word_tagalog"];


    $query = "INSERT INTO ilocaadd (word, part_of_speech, definition, example, translated_word_english, translated_word_pangasinan, translated_word_tagalog) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("sssssss", $word, $part_of_speech, $definition, $example, $translated_word_english, $translated_word_pangasinan, $translated_word_tagalog);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(array("message" => "Record added successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Unable to add record."));
    }
}

// Delete a record
if ($method === "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);

    $id = $_DELETE["id"];

    $query = "DELETE FROM ilocaadd WHERE id = ?";
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
