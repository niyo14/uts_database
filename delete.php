<?php
include 'koneksi.php';
$id_data = $_POST['id_data'];
mysqli_query($conn, "DELETE FROM sensor_data WHERE id_data='$id_data'");
?>
