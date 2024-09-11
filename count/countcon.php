<?$host = "Gubat.local";
$username = "Gubatzx";
$password = "Gubat20";
$database = "audio_database";

// Create a connection to the database
$connection = new mysqli($host, $username, $password, $database);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>


