<?php
include 'countcon.php';
$ilocanoCountQuery = "SELECT COUNT(*) AS total FROM translation";
$ilocanoResult = $textTranslateConn->query($ilocanoCountQuery);
$ilocanoTotalRecords = 0;
if ($ilocanoResult && $ilocanoResult->num_rows > 0) {
    $row = $ilocanoResult->fetch_assoc();
    $ilocanoTotalRecords = $row['total'];
}
$textTranslateConn->close();
echo json_encode(array("totalRecords" => $ilocanoTotalRecords));
?>
