<?php
// Database connection settings
$host = 'localhost';
$dbname = 'mtla_database';
$username = 'Gubatzx';
$password = 'Gubat20';

// Connect to the database
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['audio'])) {
        $file = $_FILES['audio'];
        $path = "audio/";
        $file_name = basename($file['name']);
        $output_file_path = $path . $file_name;

        // Check if the file was successfully uploaded
        if ($file['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($file['tmp_name'], $output_file_path)) {
                // File uploaded successfully, now save the file name to the database
                $insertQuery = "INSERT INTO audio_ilocano (ilocano) VALUES (:ilocano)";
                $stmt = $db->prepare($insertQuery);
                $stmt->bindParam(':ilocano', $file_name);

                if ($stmt->execute()) {
                    $response = array("status" => 1, "filename" => $file_name, "message" => "File uploaded and saved to the database");
                } else {
                    $response = array("status" => 0, "message" => "Failed to save the file name to the database");
                }
            } else {
                $response = array("status" => 0, "message" => "Failed to move the uploaded file");
            }
        } else {
            $response = array("status" => 0, "message" => "File upload error");
        }
    } else {
        $response = array("status" => 0, "message" => "No audio file provided");
    }
} else {
    $response = array("status" => 0, "message" => "Invalid request method");
}

echo json_encode($response);
?>
