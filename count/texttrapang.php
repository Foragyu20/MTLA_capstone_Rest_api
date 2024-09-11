<?php
include 'countcon.php';
$pangasinanCountQuery = "SELECT COUNT(*) AS total FROM translation_dictionary";
$pangasinanResult = $textTranslateConn->query($pangasinanCountQuery);
$pangasinanTotalRecords = 0;
if ($pangasinanResult && $pangasinanResult->num_rows > 0) {
    $row = $pangasinanResult->fetch_assoc();
    $pangasinanTotalRecords = $row['total'];
}
$textTranslateConn->close();
echo json_encode(array("totalRecords" => $pangasinanTotalRecords));
?>
