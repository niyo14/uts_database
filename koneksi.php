<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab_iot"; // nama database kamu

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
// echo "Koneksi berhasil"; // bisa kamu aktifkan untuk tes
?>
