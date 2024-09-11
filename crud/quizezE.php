<?php
// Database connection parameters
include '../conz.php';
// Set headers to allow cross-origin requests (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

// Handle HTTP request methods
$method = $_SERVER["REQUEST_METHOD"];
// Edit an existing record
if ($method === "POST") {
    parse_str(file_get_contents("php://input"), $_POST);

    $id = $_POST["id"];
    $question = $_POST["question"];
    $option1 = $_POST["option1"];
    $option2 = $_POST["option2"];
    $option3 = $_POST["option3"];
    $option4 = $_POST["option4"];
    $correct_answer = $_POST["correct_answer"];
    $query = "UPDATE quiz SET question = ?, option1 = ?, option2 = ?, option3 = ?, option4 = ?, correct_answer = ?, WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssssssi", $question, $option1, $option2, $option3, $option4, $correct_answer, $id);

    if ($stmt->execute()) {
        echo json_encode(array("message" => "Record updated successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Unable to update record."));
    }
}



// Close the database connection
$connection->close();
?>
