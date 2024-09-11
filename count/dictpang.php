<?php
include 'countcon.php';
$pangasinanDictionaryCountQuery = "SELECT COUNT(*) AS total FROM pangasinan_dictionary";
$pangasinanDictionaryResult = $mtlaConn->query($pangasinanDictionaryCountQuery);
$pangasinanDictionaryTotalRecords = 0;

if ($pangasinanDictionaryResult && $pangasinanDictionaryResult->num_rows > 0) {
    $row = $pangasinanDictionaryResult->fetch_assoc();
    $pangasinanDictionaryTotalRecords = $row['total'];
}
$mtlaConn->close();

// Output the result as JSON
echo json_encode(array("totalRecords" => $pangasinanDictionaryTotalRecords));
?>