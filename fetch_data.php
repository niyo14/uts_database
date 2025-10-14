<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM sensor_data ORDER BY id_data DESC");

while($row = mysqli_fetch_assoc($result)){
    echo "<tr>
        <td>{$row['id_data']}</td>
        <td>{$row['id_sensor']}</td>
        <td>{$row['suhu']}</td>
        <td>{$row['kelembapan']}</td>
        <td>{$row['waktu_pengiriman']}</td>
        <td>
            <button class='btn btn-warning btn-sm' onclick=\"editData('{$row['id_data']}','{$row['id_sensor']}','{$row['suhu']}','{$row['kelembapan']}')\">Edit</button>
            <button class='btn btn-danger btn-sm' onclick=\"hapusData('{$row['id_data']}')\">Hapus</button>
        </td>
    </tr>";
}
?>
