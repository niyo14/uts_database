<?php
include 'koneksi.php';

// ambil data baik dari GET maupun POST
$id_sensor = $_REQUEST['id_sensor'] ?? null;
$suhu = $_REQUEST['suhu'] ?? null;
$kelembapan = $_REQUEST['kelembapan'] ?? null;

if ($id_sensor && $suhu && $kelembapan) {
    $sql = "INSERT INTO sensor_data (id_sensor, suhu, kelembapan, waktu_pengiriman)
            VALUES ('$id_sensor', '$suhu', '$kelembapan', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "Data berhasil disimpan ke database lab_iot";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Data tidak lengkap! Pastikan id_sensor, suhu, dan kelembapan dikirim.";
}

mysqli_close($conn);
?>
