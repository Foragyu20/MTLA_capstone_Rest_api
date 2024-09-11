<?php
// Database connection details
$host = 'localhost';
$dbname = 'mtla_database';
$username = 'Gubatzx';
$password = 'Gubat20';

// Include PHPMailer autoloader
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    // Create a PDO instance for the database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve user input from POST data and sanitize it
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password']; // You should hash the password here.

    // Check if the username already exists
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Username already exists.']);
    } else {
        // Hash the password using a secure hashing algorithm (e.g., password_hash)
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert the new user into the database
        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $stmt->execute([$username, $hashedPassword]);

        // Send confirmation email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';   // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                  // Enable SMTP authentication
    $mail->Username   = 'testingforagyu@gmail.com';   // SMTP username
    $mail->Password   = 'askd tzge efdw jgua';      // SMTP password
    $mail->SMTPSecure = 'tls';                 // Enable TLS encryption; `ssl` also accepted
    $mail->Port       = 587;       

        $mail->setFrom('testingforagyu@gmail.com', 'Filpen');
        $mail->addAddress($username, 'hello'); // Replace $userEmail with the user's email
        $mail->isHTML(true);
        $mail->Subject = 'Registration Confirmation';
        $mail->Body = 'Thank you for registering!';

        $mail->send();
$generatedToken = $username;
        // Inside the registration success block
echo json_encode(['success' => "0", 'token' => $generatedToken, 'message' => 'Registration successful. Confirmation email sent.','username' => $username]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => "0", 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => "0", 'message' => 'Email sending error: ' . $e->getMessage()]);
}
?>
