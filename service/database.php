<?php
$host = "sgp.domcloud.co";
$port = 3306;
$user = "monitoringjpl";
$password = "fR(5t61ieXG45g(VW-"; // Ganti sesuai di dashboard
$database = "monitoringjpl_db"; // Ganti sesuai nama database kamu

// Buat koneksi
$db = mysqli_connect($host, $user, $password, $database, $port);

if ($db->connect_error) {
    die("Koneksi database gagal: " . $db->connect_error);
}
mysqli_query($db, "SET time_zone = '+07:00'");
date_default_timezone_set("Asia/Jakarta");
?>
