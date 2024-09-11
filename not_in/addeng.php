<?php
// Assuming you have a database connection
include '../conz.php';

$query = "SELECT word, definition FROM english_dictionary
          WHERE word IN (SELECT english FROM translation)";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Output JSON for words not found in translation
    $output = [];
    while ($row = $result->fetch_assoc()) {
        $output[] = [
            'word' => $row['word'],
            'definition' => $row['definition']
        ];
    }

    echo json_encode($output);
} else {
    echo json_encode(['message' => 'All words in english_dictionary are present in translation']);
}

// Close the database connection
$conn->close();
?>
