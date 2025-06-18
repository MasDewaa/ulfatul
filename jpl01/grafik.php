<?php
include "../service/database.php";

// Ambil parameter periode
$periode = isset($_GET['periode']) ? $_GET['periode'] : 'minggu';

if ($periode == 'bulan') {
    $where = "WHERE Waktu >= NOW() - INTERVAL 1 MONTH";
} elseif ($periode == 'hari') {
    $where = "WHERE Waktu >= NOW() - INTERVAL 1 DAY";
} else {
    $where = "WHERE Waktu >= NOW() - INTERVAL 7 DAY";
}

// Query data sesuai periode
$query = "SELECT id, Arus, Baterei, Motor1, Motor2, Waktu FROM tb_jpl01 $where ORDER BY id DESC LIMIT 100";
$result = mysqli_query($db, $query);

// Simpan hasil ke array
$dataPoints = array();
while ($row = mysqli_fetch_assoc($result)) {
    $dataPoints[] = array(
        "waktu" => $row['Waktu'],
        "arus" => (float)$row['Arus'],
        "baterei" => (float)$row['Baterei'],
        "motor1" => (float)$row['Motor1'],
        "motor2" => (float)$row['Motor2']
    );
}

// Tutup koneksi
mysqli_close($koneksi);

// Encode ke JSON
$json_data = json_encode(array_reverse($dataPoints)); // Dibalik agar waktu urut naik
?>

<!-- Tampilan grafik -->
<div class="container my-5">
  <h2 class="text-center mb-4">Grafik Monitoring JPL 01</h2>
  <div class="p-4 shadow rounded" style="background-color: #ffffff;">
    <canvas id="myChart" height="100"></canvas>
  </div>
</div>

<!-- Library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const data = <?php echo $json_data; ?>;
  const labels = data.map(item => item.waktu);
  const arusData = data.map(item => item.arus);
  const batereiData = data.map(item => item.baterei);
  const motor1Data = data.map(item => item.motor1);
  const motor2Data = data.map(item => item.motor2);

  const ctx = document.getElementById('myChart').getContext('2d');
  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Arus (A)',
          data: arusData,
          borderColor: '#e74c3c',
          fill: false,
          tension: 0.3
        },
        {
          label: 'Baterai (V)',
          data: batereiData,
          borderColor: '#3498db',
          fill: false,
          tension: 0.3
        },
        {
          label: 'Motor1 (V)',
          data: motor1Data,
          borderColor: '#f39c12',
          fill: false,
          tension: 0.3
        },
        {
          label: 'Motor2 (V)',
          data: motor2Data,
          borderColor: '#2ecc71',
          fill: false,
          tension: 0.3
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        },
        x: {
          ticks: {
            maxRotation: 90,
            minRotation: 45
          }
        }
      }
    }
  });
</script>
