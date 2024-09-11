<?php
include 'countcon.php';

$quizCountQuery = "SELECT COUNT(*) AS total FROM quiz";
$quizResult = $quizConn->query($quizCountQuery);
$quizTotalRecords = 0;

if ($quizResult && $quizResult->num_rows > 0) {
    $row = $quizResult->fetch_assoc();
    $quizTotalRecords = $row['total'];
}

$quizConn->close();

// Output the result as JSON
echo json_encode(array("totalRecords" => $quizTotalRecords));
?>
