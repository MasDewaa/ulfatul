<?php 
    //koneksi ke database
    $host = "gateway01.us-west-2.prod.aws.tidbcloud.com";
    $port = "4000";
    $user = "23deaNrZSzmtKhb.root";
    $password = "nuJVkqoA8Tyktxqb";
    $database = "test";

    $konek = mysqli_connect($host, $user, $password, $database, $port);

    //baca data dari tabel
    $sql = mysqli_query($konek, "select * from tb_jpl01 order by id desc");

    //pembacaan data terbaru
    $data = mysqli_fetch_array($sql);
    $Baterei = $data['Baterei'];

    //pemberian nilai 0 jika tidak terdeteksi tegangan
    if($Baterei == "") $Baterei = 0 ;

    //cetak tegangan charger
    echo $Baterei ;

?>