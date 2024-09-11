<?php
// Database configuration
include 'conz.php';

function searchAndDelete($username, $conn) {
    $username = $conn->real_escape_string($username);

    // Search for the user
    $sql = "SELECT Id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, delete the user
        $row = $result->fetch_assoc();
        $userId = $row['Id'];

        $deleteSql = "DELETE FROM users WHERE Id = $userId";
        if ($conn->query($deleteSql) === TRUE) {
            echo "User deleted successfully";
        } else {
            echo "Error deleting user: " . $conn->error;
        }
    } else {
        echo "User not found";
    }
}

// Close the database connection
$conn->close();
?>
