<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Suhu & Kelembapan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="text-center mb-4">🌡️ Monitoring Suhu & Kelembapan Laboratorium</h2>

    <div class="d-flex justify-content-between mb-3">
        <button id="btnTambah" class="btn btn-success">Tambah Data</button>
        <button id="btnRefresh" class="btn btn-primary">Refresh Data</button>
    </div>

    <!-- Indikator auto refresh -->
    <p class="text-muted small">🔄 Data otomatis diperbarui setiap 5 detik</p>

    <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>ID Sensor</th>
                <th>Suhu (°C)</th>
                <th>Kelembapan (%)</th>
                <th>Waktu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="tabelData"></tbody>
    </table>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalJudul"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_data">
        <div class="mb-3">
          <label>ID Sensor</label>
          <input type="text" id="id_sensor" class="form-control">
        </div>
        <div class="mb-3">
          <label>Suhu (°C)</label>
          <input type="number" id="suhu" step="0.1" class="form-control">
        </div>
        <div class="mb-3">
          <label>Kelembapan (%)</label>
          <input type="number" id="kelembapan" step="0.1" class="form-control">
        </div>
        <button id="btnSimpan" class="btn btn-primary w-100">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function loadData() {
    $.get("fetch_data.php", function(data){
        $("#tabelData").html(data);
    });
}

$(document).ready(function(){
    // 🔹 Muat data pertama kali
    loadData();

    // 🔹 Tombol manual masih bisa dipakai
    $("#btnRefresh").click(loadData);

    // 🔹 Tambahkan fungsi auto-refresh setiap 5 detik
    setInterval(loadData, 5000); // <-- baris baru penting!

    // Tambah data
    $("#btnTambah").click(function(){
        $("#modalJudul").text("Tambah Data Sensor");
        $("#id_data").val('');
        $("#id_sensor, #suhu, #kelembapan").val('');
        $("#modalForm").modal("show");
    });

    // Simpan data (insert / update)
    $("#btnSimpan").click(function(){
        let id_data = $("#id_data").val();
        let id_sensor = $("#id_sensor").val();
        let suhu = $("#suhu").val();
        let kelembapan = $("#kelembapan").val();
        let url = id_data ? "update.php" : "insert_manual.php";

        $.post(url, {id_data, id_sensor, suhu, kelembapan}, function(){
            $("#modalForm").modal("hide");
            loadData();
        });
    });
});

function hapusData(id){
    if(confirm("Yakin ingin menghapus data ini?")){
        $.post("delete.php", {id_data:id}, function(){
            loadData();
        });
    }
}

function editData(id, sensor, suhu, kelembapan){
    $("#modalJudul").text("Edit Data Sensor");
    $("#id_data").val(id);
    $("#id_sensor").val(sensor);
    $("#suhu").val(suhu);
    $("#kelembapan").val(kelembapan);
    $("#modalForm").modal("show");
}
</script>
</body>
</html>
