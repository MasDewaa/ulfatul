<?php
$host = "sgp.domcloud.co";
$port = 3306;
$user = "jumbo-stranger-nee";
$password = "e3+jfJ5LL36g(Xr6U+"; // Ganti sesuai di dashboard
$database = "jumbo_stranger_nee_db"; // Ganti sesuai nama database kamu

// Buat koneksi
$db = mysqli_connect($host, $user, $password, $database, $port);

if ($db->connect_error) {
    die("Koneksi database gagal: " . $db->connect_error);
}
?>
