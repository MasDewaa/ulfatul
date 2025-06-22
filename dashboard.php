<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Home Page</title>
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
            <li><a class="dropdown-item" href="PetaLintas/index.php">Peta Lintas</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="kerusakan.php">Daftar Kerusakan JPL</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">Struktur Organisasi</a>
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

      <!-- carousel mulai -->
    <div class="container-fluid" >
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/KA.jpg" class="d-block w-100" alt="..." style="height:500px">
      <div class="carousel-caption">
        <h5>PT.Kereta Api Indonesia(Persero)</h5>
        <p> Badan Usaha Milik Negara Indonesia yang bergerak di bidang perkeretaapian</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/JPL.jpg" class="d-block w-100" alt="..." style="height:500px" >
      <div class="carousel-caption ">
        <h5>Pintu Perlintasan Sebidang</h5>
        <p> Suatu sistem pengamanan perpotongan antara jalan rel kereta api dengan jalan raya, jalan setapak, atau landasan pacu bandara, yang berada pada satu bidang datar.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/PPI Madiun.png" class="d-block w-100" alt="..." style="height:500px">
      <div class="carousel-caption ">
        <h5>Politeknik Perkeretaapian Indonesia Madiun</h5>
        <p>Perguruan Tinggi Kedinasan yang berdiri pada tahun 2014 di Kota Madiun, Jawa Timur di bawah naungan Badan Pengembangan SDM Perhubungan Darat Kementerian Perhubungan Republik Indonesia. Sekolah ini dibangun untuk memenuhi kebutuhan Sumber Daya Manusia Perkeretaapian</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
 <!-- carousel end -->

  <!-- Coulum start -->
  <div class="row text-center align-items center mt-4">
    <div class="col-12 " style="font-family: Arial, sans-serif; color: #333;">
    <img src="/img/ppi.png" alt="PPI Logo" class="img-fluid" style="width: 150px; height: auto;"/>
    <img src="/img/KAI.png" alt="KAI Logo" class="img-fluid"style="width: 150px; height: auto;"/> 
    <h2 class="mt-2">Website Monitoring JPL DIVRE II</h2>
    <p style="font-style: italic"> created by <span style="color: red">@Resort Sintel PD</span></p>
    </div>
  </div>
  <!-- Coulum end -->

  <!-- Card Start -->
  <div class="row">
  <div class="col-sm-6 mt-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Grafik Pemantauan</h5>
        <p class="card-text">Berisi Halaman menampilkan grafik nilai arus dan tegangan pada pintu perlintasan dalam satu periode</p>
        <a href="grafikmonitoring.php" class="btn btn-primary">Selengkapnya</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6 mt-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Notifikasi Kerusakan</h5>
        <p class="card-text">Penyimpanan terkait nontifikasi terkait anomali arus dan teganangan pintu perlintasan</p>
        <a href="#" class="btn btn-primary">Selengkapnya</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6 mt-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Lembar P3-STE</h5>
        <p class="card-text">Berisi pedoman perawatan dan pemeriksaan pintu perlintasan</p>
        <a href="#" class="btn btn-primary">Selengkapnya</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6 mt-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Wiring Diagram JPL</h5>
        <p class="card-text">Daftar Wiring diagram JPL Divre II</p>
        <a href="#" class="btn btn-primary">Download</a>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Card end -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
