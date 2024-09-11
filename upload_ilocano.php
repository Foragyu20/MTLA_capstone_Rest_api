<?php
class Uploads {
    private $respond;
    private $db; // Database connection, you should create and initialize this

    public function __construct($db) {
        $this->db = $db; // Initialize the database connection
    }

    public function uploadAudio($file) {
        $path = "audio/";
        $file_name = basename($file['name']);
        $output_file_path = $path . $file_name;

        // Check if the file was successfully uploaded
        if ($file['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($file['tmp_name'], $output_file_path)) {
                // File uploaded successfully, now save the file name to the database
                $insertQuery = "INSERT INTO audio_ilocano (ilocano) VALUES (:ilocano)";
                $stmt = $this->db->prepare($insertQuery);
                $stmt->bindParam(':ilocano', $file_name);
                
                if ($stmt->execute()) {
                    $this->respond = array("status" => 1, "filename" => $file_name, "message" => "File uploaded and saved to the database");
                } else {
                    $this->respond = array("status" => 0, "message" => "Failed to save the file name to the database");
                }
            } else {
                $this->respond = array("status" => 0, "message" => "Failed to move the uploaded file");
            }
        } else {
            $this->respond = array("status" => 0, "message" => "File upload error");
        }

        return json_encode($this->respond);
    }
}
