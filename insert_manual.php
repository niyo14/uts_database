<?php
include 'koneksi.php';
$id_sensor = $_POST['id_sensor'];
$suhu = $_POST['suhu'];
$kelembapan = $_POST['kelembapan'];

mysqli_query($conn, "INSERT INTO sensor_data (id_sensor, suhu, kelembapan, waktu_pengiriman)
VALUES ('$id_sensor','$suhu','$kelembapan',NOW())");
?>
