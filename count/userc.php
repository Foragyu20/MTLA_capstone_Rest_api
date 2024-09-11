<?php
include 'countcon.php';
$CountQuery = "SELECT COUNT(*) AS total FROM users";
$Userr = $uz->query($CountQuery);
$user = 0;
if ($Userr && $Userr->num_rows > 0) {
    $row = $Userr->fetch_assoc();
    $user = $row['total'];
}
$uz->close();
echo json_encode(array("totalRecords" => $user));
?>
