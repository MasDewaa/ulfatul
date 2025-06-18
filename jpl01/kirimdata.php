<?php 
   //koneksi ke database
   $konek = mysqli_connect ("localhost","root","","db_ta");
  
   //baca data dari esp32
   $v1 = $_GET['v1'];
   $v2 = $_GET['v2'];
   $v3 = $_GET['v3'];
   $current = $_GET['current'];

    //auto increment = 1
    mysqli_query($konek, "ALTER TABLE tb_jpl01 AUTO_INCREMENT=1");

    //simpan data dari sensor ke tb_jpl01
    $simpan = mysqli_query($konek, "insert into tb_jpl01(Baterei , Motor1 , Motor2 , Arus)values('$v1', '$v2' ,'$v3' , '$current')");

    //uji ketika data tersimpan
    if($simpan)
        echo "Berhasil dikirim";
    else
        echo "data gagal terkirim";


?>