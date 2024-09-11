<?php
include 'countcon.php';
$englishDictionaryCountQuery = "SELECT COUNT(*) AS total FROM english_dictionary";
$englishDictionaryResult = $mtlaConn->query($englishDictionaryCountQuery);
$englishDictionaryTotalRecords = 0;
if ($englishDictionaryResult && $englishDictionaryResult->num_rows > 0) {
    $row = $englishDictionaryResult->fetch_assoc();
    $englishDictionaryTotalRecords = $row['total'];
}
$mtlaConn->close();
echo json_encode(array("totalRecords" => $englishDictionaryTotalRecords));
?>