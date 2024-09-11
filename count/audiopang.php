<?php
include 'countcon.php';

$countQuery = "SELECT COUNT(*) AS total FROM audio_pangasinan";
$result = $connection->query($countQuery);
$totalRecords = 0;
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalRecords = $row['total'];
}

echo json_encode(array("totalRecords" => $totalRecords));
$connection->close();
?>
