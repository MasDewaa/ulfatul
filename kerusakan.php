<?php
include __DIR__ . "/service/database.php";

$sql = "SELECT * FROM tb_kerusakan ORDER BY Waktu DESC";
$result = mysqli_query($db, $sql);

// Hitung total kerusakan bulan ini
$bulan_ini = date('Y-m'); // Format: 2025-06
$sql_total = "SELECT COUNT(*) AS total FROM tb_kerusakan WHERE DATE_FORMAT(Waktu, '%Y-%m') = '$bulan_ini'";
$result_total = mysqli_query($db, $sql_total);
$data_total = mysqli_fetch_assoc($result_total);
$total_bulan_ini = $data_total['total'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Rekapan Kerusakan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-custom {
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .card-time {
            position: fixed;
            top: 80px;
            left: 20px;
            z-index: 1000;
            width: 200px;
        }

        .main-container {
            padding-left: 240px;
            padding-right: 20px;
        }

        .btn-tambah {
            float: right;
        }
    </style>
</head>
<body>

   <!-- Navbar (Menu Navigasi) Mulai-->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-light sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Resort Sintel PD</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard.php">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="monitoring.php">Monitoring</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            JPL Divre II
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="DaftarJPL/index.php">Daftar JPL</a></li>
            <li><a class="dropdown-item" href="https://earth.google.com/earth/d/11M-Esgm-oZZu1n46caJ0ZCGJUBZhn6Cr?usp=sharing" target="_blank" rel="noopener noreferrer">Peta Lintas</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="kerusakan.php">Daftar Kerusakan JPL</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-light" type="submit">Search</button>
      </form>
      <form action="logout.php" method="POST" class="ms-2">
           <button type="submit" class="btn btn-danger">Logout</button>
      </form>
    </div>
  </div>
    </nav>
     <!-- Navbar (Menu Navigasi) End -->

      <!-- Coulum start -->
  <div class="row text-center align-items center mt-4">
    <div class="col-12 " style="font-family: Arial, sans-serif; color: #333;">
    <img src="/img/ppi.png" alt="PPI Logo" class="img-fluid" style="width: 150px; height: auto;"/>
    <img src="/img/KAI.png" alt="KAI Logo" class="img-fluid"style="width: 150px; height: auto;"/> 
    </div>
  </div>
  <!-- Coulum end -->


<!-- Card Waktu -->
<div class="card card-time text-center">
    <div class="card-header bg-primary text-white">Waktu Sekarang</div>
    <div class="card-body">
        <h5 id="tanggal" class="card-title"></h5>
        <h6 id="jam" class="card-text"></h6>
    </div>
</div>

<!-- Card Total Kerusakan Bulan Ini -->
<div class="card card-time text-center mt-3" style="top: 240px;">
    <div class="card-header bg-danger text-white">Kerusakan Bulan Ini</div>
    <div class="card-body">
        <h5 class="card-title"><?= $total_bulan_ini ?> kerusakan</h5>
        <p class="card-text">Periode: <?= date('F Y') ?></p>
    </div>
</div>

<!-- Container Utama -->
<div class="main-container">
    <div class="card card-custom mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="card-title">Rekapan Kerusakan JPL</h2>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-pencil-square"></i> Tambah Data
                </button>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nomor JPL</th>
                            <th>Waktu</th>
                            <th>Deskripsi Kerusakan</th>
                            <th>Nama Petugas</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['Nomor JPL']) ?></td>
                                    <td><?= date("d-m-Y H:i:s", strtotime($row['Waktu'])) ?></td>
                                    <td><?= htmlspecialchars($row['Deskripsi Kerusakan']) ?></td>
                                    <td><?= htmlspecialchars($row['Nama Petugas']) ?></td>
                                    <td><?= htmlspecialchars($row['Keterangan']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data kerusakan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="proses_tambah.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahLabel">Tambah Data Kerusakan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label class="form-label">Nomor JPL</label>
          <input type="text" name="nomor_jpl" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Waktu</label>
          <input type="datetime-local" name="waktu" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Deskripsi Kerusakan</label>
          <textarea name="deskripsi" class="form-control" required></textarea>
        </div>
        <div class="mb-2">
          <label class="form-label">Nama Petugas</label>
          <input type="text" name="petugas" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Keterangan</label>
          <textarea name="keterangan" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Script Jam & Bootstrap -->
<script>
    function updateDateTime() {
        const now = new Date();
        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        const day = days[now.getDay()];
        const date = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        document.getElementById("tanggal").innerText = `${day}, ${date} ${month} ${year}`;
        document.getElementById("jam").innerText = `${hours}:${minutes}:${seconds}`;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($db); ?>
