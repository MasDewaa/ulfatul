<?php

    $server = "gateway01.us-west-2.prod.aws.tidbcloud.com";
    $port = "4000";
    $user = "23deaNrZSzmtKhb.root";
    $password = "nuJVkqoA8Tyktxqb";
    $db_name = "test";

    $db = mysqli_connect($server, $user, $password, $db_name, $port);

    if(mysqli_connect_error()){
        echo "Koneksi database rusak: " . mysqli_connect_error();
        die("Error!");
    }

?>
