<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "master_supplier";

$conn = mysqli_connect($hostname, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "CREATE DATABASE IF NOT EXISTS master_supplier";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "CREATE TABLE IF NOT EXISTS Supplier (
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    Nama VARCHAR(50) NOT NULL,
    Telp VARCHAR(25) NOT NULL,
    Alamat TEXT NOT NULL
)";


$query = "INSERT INTO Supplier (id, Nama, Telp, Alamat) 
VALUES 
(1, 'PT. Maju Bersama', '08123456', 'Surabaya'),
(2, 'PT. Senang Sekali', '081515563', 'Bangkalan'),
(3, 'PT. Segar Segar', '0845454663', 'Surabaya')";

?>