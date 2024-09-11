<?php
require('autouploader2.php');

// Database connection
$db = new PDO("mysql:host=localhost;dbname=audio_database", "Gubatzx", "Gubat20");
$autoUploader = new AutoUploader($db);

// Perform the scan and upload
$autoUploader->scanAndUpload();

// Optionally, you can handle the response here, e.g., print the response to the screen
$response = $autoUploader->uploadAudio($file);
echo $response;
?>
