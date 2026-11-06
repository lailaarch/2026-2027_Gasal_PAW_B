<?php
include 'koneksi.php';

$result_barang = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM barang");
$data_barang = mysqli_fetch_assoc($result_barang);

$result_pelanggan = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM pelanggan");
$data_pelanggan = mysqli_fetch_assoc($result_pelanggan);

$result_transaksi = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM transaksi");
$data_transaksi = mysqli_fetch_assoc($result_transaksi);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>LayCoffee Shop - Sistem Penjualan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <div class="card">
            <h2>Dashboard</h2>
            <p>Pengelolaan transaksi penjualan Coffee Shop dengan konsep master-detail.</p>
            <p><b>Jumlah barang:</b> <?php echo $data_barang['jumlah']; ?></p>
            <p><b>Jumlah pelanggan:</b> <?php echo $data_pelanggan['jumlah']; ?></p>
            <p><b>Jumlah transaksi:</b> <?php echo $data_transaksi['jumlah']; ?></p>
            <a class="btn" href="transaksi.php">Kelola Transaksi</a>
        </div>
    </div>
</body>
</html>
