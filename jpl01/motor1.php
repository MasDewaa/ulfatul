<?php 
include "../service/database.php";

    //baca data dari tabel
    $sql = mysqli_query($db, "select * from tb_jpl01 order by id desc");

    //pembacaan data terbaru
    $data = mysqli_fetch_array($sql);
    $Motor1 = $data['Motor1'];

    //pemberian nilai 0 jika tidak terdeteksi tegangan
    if($Motor1 == "") $Motor1 = 0 ;

    //cetak tegangan charger
    echo $Motor1 ;

?>