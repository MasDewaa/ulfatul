<?php 
    include "../service/database.php";

    //baca data dari tabel
    $sql = mysqli_query($db, "select * from tb_jpl01 order by id desc");

    //pembacaan data terbaru
    $data = mysqli_fetch_array($sql);
    $Baterei = $data['Baterei'];

    //pemberian nilai 0 jika tidak terdeteksi tegangan
    if($Baterei == "") $Baterei = 0 ;

    //cetak tegangan charger
    echo $Baterei ;

?>