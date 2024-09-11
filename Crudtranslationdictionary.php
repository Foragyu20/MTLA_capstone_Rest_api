<?php
// Database connection parameters
include 'conz.php';
// Set headers to allow cross-origin requests (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Handle HTTP request methods
$method = $_SERVER["REQUEST_METHOD"];

// Show all records
if ($method === "GET") {
    $query = "SELECT * FROM translation_dictionary";
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
    $data = json_decode(file_get_contents("php://input"), true);
    $english_word = $data["english_word"];
    $pangasinan_word = $data["pangasinan_word"];
    $ilocano_word = $data["ilocano_word"];
    $tagalog_word = $data["tagalog_word"];
    $english_example = $data["english_example"];
    $pangasinan_example = $data["pangasinan_example"];
    $ilocano_example = $data["ilocano_example"];
    $tagalog_example = $data["tagalog_example"];
    $definition = $data["definition"];
    $part_of_speech = $data["part_of_speech"];

    $query = "INSERT INTO translation_dictionary (english_word, pangasinan_word, ilocano_word, tagalog_word, english_example, pangasinan_example, ilocano_example, tagalog_example, definition, part_of_speech) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssssssssss", $english_word, $pangasinan_word, $ilocano_word, $tagalog_word, $english_example, $pangasinan_example, $ilocano_example, $tagalog_example, $definition, $part_of_speech);

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
 

    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"];
    $english_word = $data["english_word"];
    $pangasinan_word = $data["pangasinan_word"];
    $ilocano_word = $data["ilocano_word"];
    $tagalog_word = $data["tagalog_word"];
    $english_example = $data["english_example"];
    $pangasinan_example = $data["pangasinan_example"];
    $ilocano_example = $data["ilocano_example"];
    $tagalog_example = $data["tagalog_example"];
    $definition = $data["definition"];
    $part_of_speech = $data["part_of_speech"];

    $query = "UPDATE translation_dictionary SET english_word = ?, pangasinan_word = ?, ilocano_word = ?, tagalog_word = ?, english_example = ?, pangasinan_example = ?, ilocano_example = ?, tagalog_example = ?, definition = ?, part_of_speech = ? WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssssssssssi", $english_word, $pangasinan_word, $ilocano_word, $tagalog_word, $english_example, $pangasinan_example, $ilocano_example, $tagalog_example, $definition, $part_of_speech, $id);

    if ($stmt->execute()) {
        echo json_encode(array("message" => "Record updated successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Unable to update record."));
    }
}

// Delete a record
if ($method === "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data["id"];

    $query = "DELETE FROM translation_dictionary WHERE id = ?";
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
