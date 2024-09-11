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
    $query = "SELECT * FROM quizhar";
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
    $question = $_POST["question"];
    $option_1 = $_POST["option_1"];
    $option_2 = $_POST["option_2"];
    $option_3 = $_POST["option_3"];
    $option_4 = $_POST["option_4"];
    $correct_answer = $_POST["correct_answer"];
    

    $query = "INSERT INTO quizhar (question, option_1,option_2,option_3,option_4,correct_answer) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssssss", $question, $option_1, $option_2, $option_3, $option_4, $correct_answer);

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
    $question = $_PUT["question"];
    $option_1 = $_PUT["option_1"];
    $option_2 = $_PUT["option_2"];
    $option_3 = $_PUT["option_3"];
    $option_4 = $_PUT["option_4"];
    $correct_answer = $_PUT["correct_answer"];
   
    $query = "UPDATE quizhar SET question = ?, option_1 = ?, option_2 = ?, option_3 = ?, option_4 = ?, correct_answer = ? WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssssssi", $question, $option_1, $option_2, $option_3, $option_4, $correct_answer, $id);

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

    $query = "DELETE FROM quizhar WHERE id = ?";
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
