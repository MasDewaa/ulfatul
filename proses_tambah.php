<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "db_ta";

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$nomor_jpl = $_POST['nomor_jpl'];
$waktu = $_POST['waktu'];
$deskripsi = $_POST['deskripsi'];
$petugas = $_POST['petugas'];
$keterangan = $_POST['keterangan'];

$sql = "INSERT INTO tb_kerusakan (`Nomor JPL`, `Waktu`, `Deskripsi Kerusakan`, `Nama Petugas`, `Keterangan`) 
        VALUES ('$nomor_jpl', '$waktu', '$deskripsi', '$petugas', '$keterangan')";

if (mysqli_query($conn, $sql)) {
    header("Location: kerusakan.php");
    exit();
} else {
    echo "Gagal menyimpan data: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
