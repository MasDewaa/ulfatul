<?php
// Koneksi ke database
    $host = "gateway01.us-west-2.prod.aws.tidbcloud.com";
    $port = "4000";
    $user = "23deaNrZSzmtKhb.root";
    $password = "nuJVkqoA8Tyktxqb";
    $database = "test";

    $koneksi = mysqli_connect($host, $user, $password, $database, $port);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Tentukan periode waktu berdasarkan parameter GET, default ke 'minggu'
$periode = isset($_GET['periode']) ? $_GET['periode'] : 'minggu';
$where = "";
if ($periode == 'bulan') {
    $where = "WHERE Waktu >= NOW() - INTERVAL 1 MONTH";
} elseif ($periode == 'hari') {
    $where = "WHERE Waktu >= NOW() - INTERVAL 1 DAY";
} else {
    $where = "WHERE Waktu >= NOW() - INTERVAL 7 DAY";
}

// Ambil data dari database
// Mengambil semua data untuk periode yang dipilih
$query = "SELECT id, Arus, Baterei, Motor1, Motor2, Waktu FROM tb_jpl01 $where ORDER BY Waktu ASC"; // Order by ASC for proper chart progression
$result = mysqli_query($koneksi, $query);

// Siapkan data untuk grafik
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

// Encode data ke format JSON
$json_data = json_encode($dataPoints, JSON_NUMERIC_CHECK);
$current_periode = $periode; // Simpan nilai periode yang sedang digunakan
// Tutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Monitoring JPL 01 PD-PLA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <script type="text/javascript" src="../jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@1.2.1/dist/chartjs-plugin-zoom.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #ede7f6);
            margin: 0;
            padding-top: 80px;
            color: #333;
        }
        .navbar-brand {
            font-weight: bold;
            color: #673ab7 !important;
        }
        h1, h2 {
            font-weight: 600;
            color: #3f51b5;
        }
        .indicator {
            padding: 10px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .indicator-value {
            font-size: 2.5rem;
            font-weight: bold;
            display: flex;
            align-items: baseline;
            gap: 5px;
        }
        .indicator-value span {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .indicator:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .container.mb-5 {
            margin-top: 40px;
        }
        .label {
            margin-top: 10px;
            font-size: 1rem;
            color: #555;
            text-align: center;
        }
        .logo-img {
            max-width: 100px;
            height: auto;
            margin: 0 10px;
        }
        footer {
            text-align: center;
            padding: 20px;
            background: #3f51b5;
            color: white;
            margin-top: 40px;
        }
        .indicator.red {
            background: #f44336;
            color: white;
            box-shadow: 0 0 15px #e57373;
        }
        .indicator.yellow {
            background: #fff176;
            color: #333;
            box-shadow: 0 0 15px #fdd835;
        }
        .indicator.green {
            background: #66bb6a;
            color: white;
            box-shadow: 0 0 15px #81c784;
        }
        .card-title {
            font-size: 1rem;
            color: #3f51b5;
        }
        @media (max-width: 576px) {
            .logo-img {
                max-width: 70px;
                margin: 0 5px;
            }
            h2 {
                font-size: 1.5rem;
            }
            .indicator-value {
                font-size: 2rem;
            }
            .indicator-value span {
                font-size: 2rem;
            }
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        .pulse {
            animation: pulse 3s infinite;
        }

        /* Gaya baru untuk wrapper grafik agar responsif dan bisa digeser */
        .chart-wrapper {
            position: relative;
            height: 400px; /* Tinggi grafik */
            width: 100%;
        }
        /* Style untuk tombol panah */
        .pan-button {
            font-size: 1.5rem;
            padding: 5px 15px;
        }
    </style>

    <script type="text/javascript">
        // Fungsi untuk memperbarui nilai indikator secara berkala
        $(document).ready(function () {
            setInterval(function () {
                $("#Arus").load("arus.php");
                $("#Baterei").load("baterei.php");
                $("#Motor1").load("motor1.php");
                $("#Motor2").load("motor2.php");
            }, 5000); // Setiap 5 detik

            setInterval(parseAndUpdate, 5100); // Sedikit setelah load data agar nilai terbaru tersedia
        });

        // Fungsi untuk memperbarui warna indikator berdasarkan nilai
        function updateIndicatorColor(id, value, safeRange, thresholdRange) {
            const el = document.getElementById(id).closest('.indicator');
            el.classList.remove("green", "yellow", "red");

            if (value >= safeRange[0] && value <= safeRange[1]) {
                el.classList.add("green");
            } else if (value >= thresholdRange[0] && value <= thresholdRange[1]) {
                el.classList.add("yellow");
            } else {
                el.classList.add("red");
            }
        }

        // Fungsi untuk mengambil nilai dari DOM dan memperbarui warna serta kesimpulan
        function parseAndUpdate() {
            const arus = parseFloat(document.getElementById("Arus").innerText) || 0;
            const motor1 = parseFloat(document.getElementById("Motor1").innerText) || 0;
            const motor2 = parseFloat(document.getElementById("Motor2").innerText) || 0;
            const bat = parseFloat(document.getElementById("Baterei").innerText) || 0;

            updateIndicatorColor("Arus", arus, [0, 4.9], [5, 6]);
            updateIndicatorColor("Motor1", motor1, [24, 28.9], [21, 23.9]);
            updateIndicatorColor("Motor2", motor2, [24, 28.9], [21, 23.9]);
            updateIndicatorColor("Baterei", bat, [24, 28.9], [21, 23.9]);

            updateKesimpulan();
        }
    </script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Website Monitoring JPL</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarJPL" aria-controls="navbarJPL" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarJPL">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="jplDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Daftar JPL</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="jplDropdown">
                        <li><a class="dropdown-item" href="monitor.php">JPL 01</a></li>
                        <li><a class="dropdown-item" href="monitor_jpl02.php">JPL 02</a></li>
                        <li><a class="dropdown-item" href="monitor_jpl03.php">JPL 03</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="periodeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Periode</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="periodeDropdown">
                        <li><a class="dropdown-item" href="?periode=hari">1 Hari</a></li>
                        <li><a class="dropdown-item" href="?periode=minggu">1 Minggu</a></li>
                        <li><a class="dropdown-item" href="?periode=bulan">1 Bulan</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-2">
    <div class="row d-flex justify-content-center gap-3 flex-wrap">
        <div class="col-md-5">
            <div class="card shadow-sm" style="background-color: #e0f7fa;">
                <div class="card-body text-center">
                    <h5 class="card-title mb-2">🕒 Waktu Sekarang</h5>
                    <p id="clock" class="fw-bold fs-5 mb-0 text-dark">Memuat waktu...</p>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm pulse" id="kesimpulanCard" style="background-color: #e0f7fa;">
                <div class="card-body text-center">
                    <h5 class="card-title mb-2">📋 Kesimpulan</h5>
                    <p id="kesimpulanText" class="fw-bold fs-5 mb-0 text-dark">Memuat...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-center">
    <img src="/DeteksiPerlintasan/img/PPI.png" class="logo-img" alt="Logo PPI" style="margin-top: 10px;" />
    <img src="/DeteksiPerlintasan/img/KAI.png" class="logo-img" alt="Logo KAI" style="margin-top: 10px;" />
    <h2 class="mt-3">JPLE 01 PD-PLA</h2>
</div>

<div class="container my-4">
    <div class="row row-cols-1 row-cols-md-2 g-4 text-center">
        <div class="col">
            <div class="indicator" id="arus-wrapper">
                <div class="indicator-value"><span id="Arus">0</span> A</div>
            </div>
            <div class="label">Arus Charger</div>
        </div>
        <div class="col">
            <div class="indicator" id="motor1-wrapper">
                <div class="indicator-value"><span id="Motor1">0</span> V DC</div>
            </div>
            <div class="label">Tegangan Batterai</div>
        </div>
        <div class="col">
            <div class="indicator" id="motor2-wrapper">
                <div class="indicator-value"><span id="Motor2">0</span> V DC</div>
            </div>
            <div class="label">Tegangan Motor 2</div>
        </div>
        <div class="col">
            <div class="indicator" id="baterai-wrapper">
                <div class="indicator-value"><span id="Baterei">0</span> V DC</div>
            </div>
            <div class="label">Tegangan Motor 1</div>
        </div>
    </div>
</div>


<div class="container my-4">
    <h5 class="text-center mb-3" style="font-size: 24px;">Keterangan Warna Indikator</h5>
    <div class="d-flex flex-column align-items-start mx-auto" style="max-width: 700px; gap: 15px;">
        <div class="d-flex align-items-center">
            <div style="width: 30px; height: 30px; background-color: red; border-radius: 5px; margin-right: 10px;"></div>
            <span style="font-size: 18px;"><strong>Status:</strong> Indikasi Gangguan — Range Arus 0–1 / 7–10 Ampere, Range Tegangan 0–20,9 Volt</span>
        </div>
        <div class="d-flex align-items-center">
            <div style="width: 30px; height: 30px; background-color: yellow; border-radius: 5px; margin-right: 10px; border: 1px solid #aaa;"></div>
            <span style="font-size: 18px;"><strong>Status:</strong> Batas Aman — Range Arus 1,1–2 Ampere, Range Tegangan 21–23,9 Volt</span>
        </div>
        <div class="d-flex align-items-center">
            <div style="width: 30px; height: 30px; background-color: green; border-radius: 5px; margin-right: 10px;"></div>
            <span style="font-size: 18px;"><strong>Status:</strong> Aman — Range Arus 4–6 Ampere, Range Tegangan 24–28,9 Volt</span>
        </div>
    </div>
</div>


<div class="container my-5">
    <h2 class="text-center mb-4">Grafik Monitoring JPL 01</h2>
    <div class="text-center mb-3">
        <label for="dataSelector" class="form-label fs-5">Pilih Data yang Ditampilkan</label>
        <select id="dataSelector" class="form-select w-auto mx-auto">
            <option value="all">Semua</option>
            <option value="arus">Arus Charger</option>
            <option value="baterei">Tegangan Batterai</option>
            <option value="motor1">Tegangan Motor 1</option>
            <option value="motor2">Tegangan Motor 2</option>
        </select>
    </div>
    <div class="p-4 shadow rounded" style="background-color: #ffffff;">
        <div class="chart-wrapper">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="text-center mt-3">
        <div class="d-flex justify-content-center mb-2">
            <button id="panLeftButton" class="btn btn-primary pan-button me-3"> &lt; </button>
            <button id="resetZoomButton" class="btn btn-secondary btn-sm me-3">Reset Zoom</button>
            <button id="panRightButton" class="btn btn-primary pan-button"> &gt; </button>
        </div>
        <p class="text-muted">Gunakan tombol panah untuk menggeser grafik. Gunakan scroll mouse (jika ada) untuk zoom in/out.</p>
    </div>
</div>

<div class="text-center mb-4">
    <button onclick="exportToPDF()" class="btn btn-danger me-2">Export PDF</button>
    <button onclick="exportToExcel()" class="btn btn-success">Export Excel</button>
</div>

<script>
    // Data yang diambil dari PHP
    const originalData = <?php echo $json_data; ?>; // Data sudah terurut ASC dari PHP

    const currentPeriode = "<?php echo $current_periode; ?>";
    const ctx = document.getElementById('myChart').getContext('2d');
    let myChart; // Variabel untuk menyimpan instance chart

    const initialVisibleDataPoints = 25; // Jumlah data yang ingin terlihat pada tampilan awal
    const panStep = initialVisibleDataPoints; // Seberapa banyak titik data yang digeser setiap kali tombol diklik
    const minZoomedWidthPerPoint = 30; // Lebar minimum yang diinginkan per titik data saat di-zoom (untuk export PDF)

    // Fungsi untuk menghasilkan dataset berdasarkan pilihan
    function generateDatasets(selectedChartType) {
        const datasets = [];

        const labels = originalData.map(item => item.waktu);
        const arusData = originalData.map(item => item.arus);
        const batereiData = originalData.map(item => item.baterei);
        const motor1Data = originalData.map(item => item.motor1);
        const motor2Data = originalData.map(item => item.motor2);

        if (selectedChartType === 'all' || selectedChartType === 'arus') {
            datasets.push({
                label: 'Arus (A)',
                data: arusData,
                borderColor: '#e74c3c',
                backgroundColor: 'rgba(231, 76, 60, 0.2)', // Warna latar belakang area (opsional)
                fill: false,
                tension: 0.3
            });
        }
        if (selectedChartType === 'all' || selectedChartType === 'baterei') {
            datasets.push({
                label: 'Baterai (V)',
                data: batereiData,
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                fill: false,
                tension: 0.3
            });
        }
        if (selectedChartType === 'all' || selectedChartType === 'motor1') {
            datasets.push({
                label: 'Motor1 (V)',
                data: motor1Data,
                borderColor: '#f39c12',
                backgroundColor: 'rgba(243, 156, 18, 0.2)',
                fill: false,
                tension: 0.3
            });
        }
        if (selectedChartType === 'all' || selectedChartType === 'motor2') {
            datasets.push({
                label: 'Motor2 (V)',
                data: motor2Data,
                borderColor: '#2ecc71',
                backgroundColor: 'rgba(46, 204, 113, 0.2)',
                fill: false,
                tension: 0.3
            });
        }
        return { labels, datasets };
    }

    // Fungsi untuk merender atau memperbarui grafik
    function renderChart() {
        if (myChart) {
            myChart.destroy(); // Hancurkan chart sebelumnya jika ada
        }

        const selectedChartType = document.getElementById('dataSelector').value;
        const { labels, datasets } = generateDatasets(selectedChartType);

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Penting untuk kontrol ukuran
                scales: {
                    x: {
                        type: 'category', // Pastikan tipe category untuk label string waktu
                        autoSkip: true, // Biarkan Chart.js auto-skip label jika terlalu padat
                        maxRotation: 45,
                        minRotation: 0,
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            }
                        }
                    },
                    zoom: {
                        pan: {
                            enabled: false, // MATIKAN pan dengan drag mouse
                            mode: 'x',
                        },
                        zoom: {
                            wheel: {
                                enabled: true, // Aktifkan zoom dengan roda mouse
                            },
                            pinch: {
                                enabled: true // Aktifkan zoom dengan cubit (layar sentuh)
                            },
                            mode: 'x', // Hanya zoom secara horizontal
                            limits: {
                                x: {
                                    minRange: initialVisibleDataPoints // Batasi zoom-in minimum agar selalu terlihat minimal 25 data
                                }
                            }
                        },
                    }
                }
            }
        });

        // Set batas awal sumbu X agar hanya menampilkan 25 data terakhir
        if (labels.length > initialVisibleDataPoints) {
            const startIdx = labels.length - initialVisibleDataPoints;
            const endIdx = labels.length - 1;
            myChart.zoomScale('x', { min: startIdx, max: endIdx });
        } else {
            // Jika data kurang dari 25, tampilkan semua
            myChart.zoomScale('x', { min: 0, max: labels.length > 0 ? labels.length - 1 : 0 });
        }
        myChart.update();
        updatePanButtonsState(); // Perbarui status tombol panah
    }

    // Fungsi untuk menggeser grafik
    function panChart(direction) {
        if (!myChart) return;

        const xScale = myChart.scales.x;
        const currentMin = xScale.min;
        const currentMax = xScale.max;
        const dataLength = originalData.length;

        let newMin, newMax;

        if (direction === 'left') {
            newMin = Math.max(0, currentMin - panStep);
            newMax = newMin + (currentMax - currentMin);
            // Sesuaikan jika geser terlalu jauh ke kiri
            if (newMax > currentMax) {
                newMax = currentMax;
                newMin = newMax - (currentMax - currentMin);
            }
             if (newMin < 0) { // Pastikan tidak melewati batas kiri
                newMin = 0;
                newMax = initialVisibleDataPoints - 1; // Kembali ke tampilan awal jika terlalu kiri
             }


        } else { // direction === 'right'
            newMax = Math.min(dataLength - 1, currentMax + panStep);
            newMin = newMax - (currentMax - currentMin);
            // Sesuaikan jika geser terlalu jauh ke kanan
            if (newMin < currentMin) {
                newMin = currentMin;
                newMax = newMin + (currentMax - currentMin);
            }
            if (newMax > dataLength - 1) { // Pastikan tidak melewati batas kanan
                newMax = dataLength - 1;
                newMin = newMax - (initialVisibleDataPoints -1);
                if (newMin < 0) newMin = 0; // Handle case where data is less than initialVisibleDataPoints
            }
        }
        myChart.zoomScale('x', { min: newMin, max: newMax });
        myChart.update();
        updatePanButtonsState(); // Perbarui status tombol panah setelah geser
    }

    // Fungsi untuk memperbarui status tombol panah
    function updatePanButtonsState() {
        if (!myChart) return;
        const xScale = myChart.scales.x;
        const dataLength = originalData.length;

        document.getElementById('panLeftButton').disabled = xScale.min <= 0;
        document.getElementById('panRightButton').disabled = xScale.max >= dataLength - 1;
    }


    // Event listener untuk dropdown pemilihan data
    document.getElementById('dataSelector').addEventListener('change', function () {
        renderChart(); // Render ulang grafik dengan data yang dipilih
    });

    // Tombol reset zoom
    document.getElementById('resetZoomButton').addEventListener('click', function() {
        if (myChart) {
            myChart.resetZoom();
            // Atur ulang tampilan awal 25 data terakhir setelah reset
            const labels = originalData.map(item => item.waktu);
            if (labels.length > initialVisibleDataPoints) {
                const startIdx = labels.length - initialVisibleDataPoints;
                const endIdx = labels.length - 1;
                myChart.zoomScale('x', { min: startIdx, max: endIdx });
            } else {
                 myChart.zoomScale('x', { min: 0, max: labels.length > 0 ? labels.length - 1 : 0 });
            }
            myChart.update();
            updatePanButtonsState(); // Perbarui status tombol panah setelah reset
        }
    });

    // Event listener untuk tombol panah
    document.getElementById('panLeftButton').addEventListener('click', function() {
        panChart('left');
    });

    document.getElementById('panRightButton').addEventListener('click', function() {
        panChart('right');
    });

    // Render grafik saat halaman pertama kali dimuat
    renderChart();


    // Fungsi untuk ekspor data ke PDF
    function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');

        const headers = [["No", "Waktu", "Arus (A)", "Baterai (V)", "Motor1 (V)", "Motor2 (V)"]];

        let selectedPeriodText = "";
        if (currentPeriode === 'hari') {
            selectedPeriodText = "1 Hari";
        } else if (currentPeriode === 'minggu') {
            selectedPeriodText = "1 Minggu";
        } else if (currentPeriode === 'bulan') {
            selectedPeriodText = "1 Bulan";
        } else {
            selectedPeriodText = "Tidak Ditentukan";
        }

        // Untuk PDF, kita akan merender ulang chart ke canvas sementara dengan semua data
        const tempCanvas = document.createElement('canvas');
        const tempCtx = tempCanvas.getContext('2d');
        const chartWrapperElement = document.querySelector('.chart-wrapper');

        // Atur dimensi canvas sementara agar bisa menampung semua data
        // Hitung lebar berdasarkan jumlah total data untuk menjaga proporsi
        const fullChartWidth = originalData.length * minZoomedWidthPerPoint; // Perkiraan lebar penuh
        tempCanvas.width = fullChartWidth;
        tempCanvas.height = chartWrapperElement.clientHeight;

        // Render chart ke canvas sementara dengan semua data
        const tempChart = new Chart(tempCtx, {
            type: 'line',
            data: {
                labels: originalData.map(item => item.waktu),
                datasets: generateDatasets(document.getElementById('dataSelector').value).datasets
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'category',
                        autoSkip: true, // Bisa di-true karena lebar kanvas besar
                        maxRotation: 45,
                        minRotation: 0,
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: false
                    },
                    zoom: {
                        enabled: false // Nonaktifkan zoom/pan pada chart untuk PDF
                    }
                }
            }
        });

        // Pastikan chart telah selesai dirender sebelum mengambil gambar
        setTimeout(() => {
            const imgData = tempCanvas.toDataURL('image/png', 1.0);

            const imgWidth = 180;
            const imgHeight = (tempCanvas.height * imgWidth) / tempCanvas.width;

            let yPos = 15;
            doc.text("Data Monitoring Sensor JPL 01", 14, yPos);
            yPos += 7;
            doc.text("Periode: " + selectedPeriodText, 14, yPos);
            yPos += 10;

            doc.addImage(imgData, 'PNG', 14, yPos, imgWidth, imgHeight);
            yPos += imgHeight + 10;

            const tableData = originalData.map((item, index) => [
                index + 1,
                item.waktu,
                item.arus,
                item.baterei,
                item.motor1,
                item.motor2
            ]);

            doc.autoTable({
                startY: yPos,
                head: headers,
                body: tableData,
                styles: { fontSize: 8 },
                margin: { left: 14, right: 14 },
            });

            doc.save("data-monitoring-jpl01.pdf");

            tempChart.destroy();
        }, 500);
    }

    // Fungsi untuk ekspor data ke Excel
    function exportToExcel() {
        // Buat data header
        const headers = ["No", "Waktu", "Arus (A)", "Baterai (V)", "Motor1 (V)", "Motor2 (V)"];

        // Siapkan data untuk tabel
        const excelData = [headers]; // Baris pertama adalah header
        originalData.forEach((item, index) => {
            excelData.push([
                index + 1,
                item.waktu,
                item.arus,
                item.baterei,
                item.motor1,
                item.motor2
            ]);
        });

        // Buat workbook dan worksheet
        const ws = XLSX.utils.aoa_to_sheet(excelData);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Data Monitoring JPL 01");

        // Tentukan nama file
        const fileName = `data-monitoring-jpl01-${currentPeriode}.xlsx`;

        // Unduh file
        XLSX.writeFile(wb, fileName);
    }

    // Fungsi untuk memperbarui kesimpulan berdasarkan status indikator
    function updateKesimpulan() {
        const indikatorList = ['arus-wrapper', 'motor1-wrapper', 'motor2-wrapper', 'baterai-wrapper'];
        let hasRed = false;
        let hasYellow = false;

        indikatorList.forEach(id => {
            const el = document.getElementById(id).closest('.indicator');
            if (el.classList.contains('red')) {
                hasRed = true;
            } else if (el.classList.contains('yellow')) {
                hasYellow = true;
            }
        });

        const card = document.getElementById('kesimpulanCard');
        const text = document.getElementById('kesimpulanText');

        if (hasRed) {
            card.style.backgroundColor = '#f44336';
            text.textContent = 'Indikasi Gangguan';
            text.style.color = 'white';
        } else if (hasYellow) {
            card.style.backgroundColor = '#ffeb3b';
            text.textContent = 'Perlu Pemeriksaan';
            text.style.color = '#333';
        } else {
            card.style.backgroundColor = '#4caf50';
            text.textContent = 'Normal';
            text.style.color = 'white';
        }
    }
</script>

<footer>
    &copy; 2025 Ulfatul Rahmad. Semua hak cipta dilindungi.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fungsi untuk memperbarui jam digital
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateStr = now.toLocaleDateString('id-ID', options);
        const timeStr = now.toLocaleTimeString('id-ID');
        document.getElementById('clock').innerText = `${dateStr}, ${timeStr}`;
    }

    // Perbarui jam setiap detik
    setInterval(updateClock, 1000);
    updateClock(); // Panggil pertama kali agar langsung tampil
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
</body>
</html>