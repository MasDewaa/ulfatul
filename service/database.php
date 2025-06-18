<?php
$server = "localhost";
$user = "root";
$password = "1234";
$db_name = "db_ta";

$db = new mysqli($server, $user, $password, $db_name);

if ($db->connect_error) {
    die("Koneksi database gagal: " . $db->connect_error);
}
?>
