<?php
include 'koneksi.php';
$id_data = $_POST['id_data'];
$id_sensor = $_POST['id_sensor'];
$suhu = $_POST['suhu'];
$kelembapan = $_POST['kelembapan'];

mysqli_query($conn, "UPDATE sensor_data 
SET id_sensor='$id_sensor', suhu='$suhu', kelembapan='$kelembapan'
WHERE id_data='$id_data'");
?>
