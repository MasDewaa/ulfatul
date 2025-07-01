<?php
include "service/database.php";

$nomor_jpl = $_POST['nomor_jpl'];
$waktu = $_POST['waktu'];
$deskripsi = $_POST['deskripsi'];
$petugas = $_POST['petugas'];
$keterangan = $_POST['keterangan'];

$sql = "INSERT INTO tb_kerusakan (`Nomor JPL`, `Waktu`, `Deskripsi Kerusakan`, `Nama Petugas`, `Keterangan`) 
        VALUES ('$nomor_jpl', '$waktu', '$deskripsi', '$petugas', '$keterangan')";

if (mysqli_query($db, $sql)) {
    header("Location: kerusakan.php");
    exit();
} else {
    echo "Gagal menyimpan data: " . mysqli_error($db);
}

mysqli_close($db);
