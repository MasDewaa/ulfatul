<?php
    $server = "gateway01.us-west-2.prod.aws.tidbcloud.com";
    $port = "4000";
    $user = "23deaNrZSzmtKhb.root";
    $password = "nuJVkqoA8Tyktxqb";
    $db_name = "test";

    $db = mysqli_connect($server, $user, $password, $db_name, $port);
if ($db->connect_error) {
    die("Koneksi database gagal: " . $db->connect_error);
}
?>
