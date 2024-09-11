<?php
// Database configuration
include '../conz.php';

function searchEnglishWordInDatabase($englishWord, $conn) {
    $englishWord = $conn->real_escape_string($englishWord);

    $sql = "SELECT pangasinan FROM translation WHERE english = '$englishWord'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Translation found, return the Pangasinan translation as a plain string
        $row = $result->fetch_assoc();
        return $row['pangasinan'];
    } else {
        // Translation not found
        return "Translation not found in the database";
    }
}

function translateSentence($englishSentence, $conn) {
    $words = explode(' ', $englishSentence); // Split the sentence into words
    $translatedWords = array();

    foreach ($words as $word) {
        $translation = searchEnglishWordInDatabase($word, $conn);
        $translatedWords[] = $translation;
    }

    // Combine the translated words into a sentence
    $translatedSentence = implode(' ', $translatedWords);

    return $translatedSentence;
}

// Main code
if (isset($_GET['sentence'])) {
    $englishSentence = $_GET['sentence'];
    $result = translateSentence($englishSentence, $conn);

    // Send the response as plain text
    header('Content-Type: text/plain');
    echo $result;
} else {
    echo "English sentence parameter missing";
}

// Close the database connection
$conn->close();
?>
