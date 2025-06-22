<?php 
include "../service/database.php";

// Baca dan aman kan input
$v1 = mysqli_real_escape_string($db, $_GET['v1']);
$v2 = mysqli_real_escape_string($db, $_GET['v2']);
$v3 = mysqli_real_escape_string($db, $_GET['v3']);
$current = mysqli_real_escape_string($db, $_GET['current']);

// Simpan data ke tabel (tidak reset AUTO_INCREMENT)
$simpan = mysqli_query($db, "
    INSERT INTO tb_jpl01 (Baterei, Motor1, Motor2, Arus)
    VALUES ('$v1', '$v2', '$v3', '$current')
");

// Respon
if ($simpan) {
    echo "Berhasil dikirim";
} else {
    echo "Data gagal terkirim: " . mysqli_error($db);
}
?>
