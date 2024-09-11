<?php
// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtla_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select words from english_dictionary that are not in translation
$query = "SELECT word FROM pangasinan_dictionary
          WHERE word NOT IN (SELECT pangasinan FROM translation)";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Output JSON for words not found in translation
    $output = [];
    while ($row = $result->fetch_assoc()) {
        $output[] = ['word' => $row['word']];
    }

    echo json_encode($output);
} else {
    echo json_encode([['word' => 'All words in pangasinan_dictionary are present in translation']]);
}

// Close the database connection
$conn->close();
?>
