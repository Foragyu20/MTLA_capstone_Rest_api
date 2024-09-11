<?php
// Database connection
include 'conz.php';
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $english_word = $_POST['english_word'];
    $pangasinan_word = $_POST['pangasinan_word'];
    $ilocano_word = $_POST['ilocano_word'];
    $tagalog_word = $_POST['tagalog_word'];
    $english_example = $_POST['english_example'];
    $pangasinan_example = $_POST['pangasinan_example'];
    $ilocano_example = $_POST['ilocano_example'];
    $tagalog_example = $_POST['tagalog_example'];
    $definition = $_POST['definition'];
    $part_of_speech = $_POST['part_of_speech'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE translation_dictionary SET english_word=?, pangasinan_word=?, ilocano_word=?, tagalog_word=?, english_example=?, pangasinan_example=?, ilocano_example=?, tagalog_example=?, definition=?, part_of_speech=? WHERE id=?");
    $stmt->bind_param("ssssssssssi", $english_word, $pangasinan_word, $ilocano_word, $tagalog_word, $english_example, $pangasinan_example, $ilocano_example, $tagalog_example, $definition, $part_of_speech, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["message" => "Record updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating record: " . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
?>
