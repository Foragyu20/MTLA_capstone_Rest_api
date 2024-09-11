<?php
// Database connection details
$host = 'localhost';
$dbname = 'mtla_database';
$username = 'Gubatzx';
$password = 'Gubat20';

try {
    // Create a PDO instance for the database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve user input from POST data
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = $_POST['password'];

        // Retrieve the user's hashed password, id, and recent_log from the database
        $stmt = $pdo->prepare('SELECT id, password, recent_log FROM users WHERE username = ?');
        $stmt->execute([$username]);

        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password'])) {
            // Password is correct, login successful
            // Update the recent_log column with the current date
            $updateRecentLogStmt = $pdo->prepare('UPDATE users SET recent_log = CURRENT_DATE() WHERE id = ?');
            $updateRecentLogStmt->execute([$row['id']]);

            // Calculate expiration date (30 days from recent_log) and update the expire column
            $expirationDate = date('Y-m-d', strtotime($row['recent_log'] . ' +30 days'));
            $updateExpireStmt = $pdo->prepare('UPDATE users SET expire = ? WHERE id = ?');
            $updateExpireStmt->execute([$expirationDate, $row['id']]);

            echo json_encode(['success' => "0", 'message' => 'Login successful', 'username' => $username]);
        } else {
            // Incorrect username or password
            echo json_encode(['success' => "0", 'message' => 'Incorrect username or password']);
        }
    } else {
        // Handle GET request or other HTTP methods
        echo json_encode(['success' => "0", 'message' => 'Invalid request']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => "0", 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
