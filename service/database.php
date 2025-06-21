<?php
// Include configuration file
require_once __DIR__ . '/config.php';

// Database configuration using environment variables
$host = DB_HOST;
$port = DB_PORT;
$user = DB_USER;
$password = DB_PASSWORD;
$database = DB_NAME;
$db_type = DB_TYPE;

if ($db_type === 'postgresql') {
    // PostgreSQL connection
    $dsn = "pgsql:host=$host;port=$port;dbname=$database";
    try {
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Koneksi database PostgreSQL gagal: " . $e->getMessage());
    }
} else {
    // MySQL connection (fallback)
    $db = mysqli_connect($host, $user, $password, $database, $port);
    if ($db->connect_error) {
        die("Koneksi database MySQL gagal: " . $db->connect_error);
    }
}
?>
