<?php
// Set the appropriate Content-Type for OGG audio files
header('Content-Type: audio/mp3');

// Specify the file name or path to the OGG audio file
$file_name = 'audio/' . $_GET['file_name'];

if (file_exists($file_name)) {
    // Open the OGG audio file
    $file = fopen($file_name, 'rb');

    // Stream the audio content
    while (!feof($file)) {
        echo fread($file, 1024);
        ob_flush();
        flush();
    }

    fclose($file);
} else {
    // Handle file not found error
    http_response_code(404);
    echo 'File not found';
}
?>
