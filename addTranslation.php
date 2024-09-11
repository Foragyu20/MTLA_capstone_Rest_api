<?php
include 'conz.php';
// Set the content type to application/json
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input data from the JSON request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate input data
    if (empty($data['english_word']) || empty($data['pangasinan_word']) || empty($data['ilocano_word']) || empty($data['tagalog_word']) || empty($data['definition']) || empty($data['part_of_speech'])) {
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    // Extract input data
    $english_word = $conn->real_escape_string($data['english_word']);
    $pangasinan_word = $conn->real_escape_string($data['pangasinan_word']);
    $ilocano_word = $conn->real_escape_string($data['ilocano_word']);
    $tagalog_word = $conn->real_escape_string($data['tagalog_word']);
    $english_example = $conn->real_escape_string($data['english_example']);
    $pangasinan_example = $conn->real_escape_string($data['pangasinan_example']);
    $ilocano_example = $conn->real_escape_string($data['ilocano_example']);
    $tagalog_example = $conn->real_escape_string($data['tagalog_example']);
    $definition = $conn->real_escape_string($data['definition']);
    $part_of_speech = $conn->real_escape_string($data['part_of_speech']);

    // Insert data into database
    $sql = "INSERT INTO translation_dictionary (english_word, pangasinan_word, ilocano_word, tagalog_word, english_example, pangasinan_example, ilocano_example, tagalog_example, definition, part_of_speech)
            VALUES ('$english_word', '$pangasinan_word', '$ilocano_word', '$tagalog_word', '$english_example', '$pangasinan_example', '$ilocano_example', '$tagalog_example', '$definition', '$part_of_speech')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Record added successfully']);
    } else {
        echo json_encode(['error' => 'Error: ' . $sql . '<br>' . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
