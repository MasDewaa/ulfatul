<?php 
include "../service/database.php";

// Baca data dari tabel
$sql = mysqli_query($db, "SELECT * FROM tb_jpl01 ORDER BY id DESC");

// Baca data terbaru
$data = mysqli_fetch_array($sql);
$Arus = $data['Arus'];

// Beri nilai 0 jika kosong
if ($Arus == "") $Arus = 0;

// Cetak Arus
echo $Arus;
?>
