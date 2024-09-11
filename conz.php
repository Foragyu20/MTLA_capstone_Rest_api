<?$servername = "Gubat.local";
$username = "Gubatzx"; // Change as necessary
$password = "Gubat20"; // Change as necessary
$dbname = "mtla_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>