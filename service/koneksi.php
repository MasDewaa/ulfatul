<?php

    $server = "localhost";
    $user = "root";
    $password = "1234";
    $db_name = "db_ta"; 

    $db = mysqli_connect($server, $user, $password, $db_name);

    if(mysqli_connect_error()){
        echo "Koneksi database rusak: " . mysqli_connect_error();
        die("Error!");
    }

?>
