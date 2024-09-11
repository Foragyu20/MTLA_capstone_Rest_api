<?php
include 'countcon.php';

$tagalogDictionaryCountQuery = "SELECT COUNT(*) AS total FROM tagalog_dictionary";

$tagalogDictionaryResult = $mtlaConn->query($tagalogDictionaryCountQuery);

$tagalogDictionaryTotalRecords = 0;

if ($tagalogDictionaryResult && $tagalogDictionaryResult->num_rows > 0) {
    $row = $tagalogDictionaryResult->fetch_assoc();
    $tagalogDictionaryTotalRecords = $row['total'];
}

$mtlaConn->close();

echo json_encode(array("totalRecords" => $tagalogDictionaryTotalRecords));
?>
