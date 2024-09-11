<?php
include 'countcon.php';
$ilocanoDictionaryCountQuery = "SELECT COUNT(*) AS total FROM ilocano_dictionary";
$ilocanoDictionaryResult = $mtlaConn->query($ilocanoDictionaryCountQuery);
$ilocanoDictionaryTotalRecords = 0;

if ($ilocanoDictionaryResult && $ilocanoDictionaryResult->num_rows > 0) {
    $row = $ilocanoDictionaryResult->fetch_assoc();
    $ilocanoDictionaryTotalRecords = $row['total'];
}

$mtlaConn->close();
echo json_encode(array("totalRecords" => $ilocanoDictionaryTotalRecords));
?>