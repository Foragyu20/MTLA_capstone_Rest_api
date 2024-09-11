<?php
class AutoUploader {
    private $db;
    public $respond = array();

    public function __construct($db) {
        $this->db = $db;
    }

    public function scanAndUpload() {
        $audioDirectory = "p/"; // Directory where new audio files are placed

        // Get a list of all files in the directory
        $files = scandir($audioDirectory);

        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $filePath = $audioDirectory . $file;

                // Check if the file exists and is a file (not a directory)
                if (is_file($filePath)) {
                    $this->uploadAudio($filePath);
                }
            }
        }
    }

    public function uploadAudio($filePath) {
        $path = "audio/";
        $file_name = basename($filePath);
        $output_file_path = $path . $file_name;

        // Check if the file was successfully copied
        if (copy($filePath, $output_file_path)) {
            // File copied successfully, now save the file name to the database
            $insertQuery = "INSERT INTO audio_pangasinan (pangasinan) VALUES (:pangasinan)";
            $stmt = $this->db->prepare($insertQuery);
            $stmt->bindParam(':pangasinan', $file_name);

            if ($stmt->execute()) {
                $this->respond[] = array("status" => 1, "filename" => $file_name, "message" => "File copied and saved to the database");
            } else {
                $this->respond[] = array("status" => 0, "message" => "Failed to save the file name to the database");
            }
        } else {
            $this->respond[] = array("status" => 0, "message" => "Failed to copy the file");
        }
    }
}

// Usage
$db = new PDO("mysql:host=localhost;dbname=audio_database", "root", "");
$autoUploader = new AutoUploader($db);
$autoUploader->scanAndUpload();

// Optionally, you can handle the responses here
foreach ($autoUploader->respond as $response) {
    echo json_encode($response) . PHP_EOL;
}
?>
