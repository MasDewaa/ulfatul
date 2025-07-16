<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Daftar JPL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .center-box {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        .custom-card {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        #toggle-items {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
            font-size: 1.1em;
            display: inline-block;
            transition: background 0.2s;
        }
        #toggle-items:hover {
            background-color: #0056b3;
        }
        #item-list {
            list-style: none;
            padding: 0;
            margin: 0;
            margin-top: 15px;
            display: none;
        }
        #item-list li {
            margin-bottom: 10px;
        }
        #item-list a {
            display: block;
            padding: 12px 20px;
            background-color: #e9ecef;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.2s, color 0.2s;
        }
        #item-list a:hover {
            background-color: #007bff;
            color: #fff;
        }
        @media (max-width: 600px) {
            .custom-card {
                padding: 15px;
                max-width: 100%;
            }
            .center-box {
                min-height: 60vh;
            }
        }
    </style>
</head>

<body>
      <!-- Navbar (Menu Navigasi) Mulai-->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-light sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Website Monitoring JPL</a>
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
            <li><a class="dropdown-item" href="https://earth.google.com/earth/d/11M-Esgm-oZZu1n46caJ0ZCGJUBZhn6Cr?usp=sharing">Peta Lintas</a></li>
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
     <div class="center-box">
    <div class="custom-card">
        <h1 style="color: #333; margin-bottom: 20px;">Daftar JPL</h1>
        <div id="toggle-items">Tampilkan Pilihan &#9660;</div>
        <ul id="item-list">
            <li><a href="jpl01/monitor.php">JPL 01 PD-PLA</a></li>
            <li><a href="monitor_jaringan.html">JPL 02 PD-PLA</a></li>
            <li><a href="monitor_aplikasi.html">JPL 03 PD-PLA</a></li>
            <li><a href="monitor_database.html">JPL 04 PD-PLA</a></li>
        </ul>
    </div>
</div>

    <script>
        const toggleButton = document.getElementById('toggle-items');
        const itemList = document.getElementById('item-list');
        let isVisible = false; // Status awal: item tersembunyi

        toggleButton.addEventListener('click', () => {
            if (isVisible) {
                // Jika sedang terlihat, sembunyikan
                itemList.style.display = 'none';
                toggleButton.textContent = 'Tampilkan Pilihan \u25BC'; // Ganti panah ke bawah
                isVisible = false;
            } else {
                // Jika sedang tersembunyi, tampilkan
                itemList.style.display = 'block';
                toggleButton.textContent = 'Sembunyikan Pilihan \u25B2'; // Ganti panah ke atas
                isVisible = true;
            }
        });
    </script>
</body>
</html>