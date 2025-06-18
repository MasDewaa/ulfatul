<?php 
    //koneksi ke database
    $konek = mysqli_connect ("localhost","root","","db_ta");

    //baca data dari tabel
    $sql = mysqli_query($konek, "select * from tb_jpl01 order by id desc");

    //pembacaan data terbaru
    $data = mysqli_fetch_array($sql);
    $Motor2 = $data['Motor2'];

    //pemberian nilai 0 jika tidak terdeteksi tegangan
    if($Motor2 == "") $Motor2 = 0 ;

    //cetak tegangan charger
    echo $Motor2 ;

?>