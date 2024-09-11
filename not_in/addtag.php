<?php
// Assuming you have a database connection
include '../conz.php';

// Query to select words from english_dictionary that are not in translation
$query = "SELECT word FROM tagalog_dictionary
          WHERE word NOT IN (SELECT tagalog FROM translation)";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Output JSON for words not found in translation
    $output = [];
    while ($row = $result->fetch_assoc()) {
        $output[] = ['word' => $row['word']];
    }

    echo json_encode($output);
} else {
    echo json_encode([['word' => 'All words in tagalog_dictionary are present in translation']]);
}

// Close the database connection
$conn->close();
?>
