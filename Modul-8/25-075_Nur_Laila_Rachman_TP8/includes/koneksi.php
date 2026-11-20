<?php
session_start();

$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "db_penjualan";

$root     = str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']);
$folder   = str_replace("\\", "/", dirname(__DIR__));
$base_url = str_ireplace($root, "", $folder);

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
