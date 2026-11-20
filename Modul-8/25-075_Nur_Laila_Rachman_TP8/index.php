<?php
include 'includes/koneksi.php';
include 'includes/cek_login.php';

$judul = "Home";

$q = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM barang");
$d = mysqli_fetch_assoc($q);
$jml_barang = $d['jml'];

$q = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM pelanggan");
$d = mysqli_fetch_assoc($q);
$jml_pelanggan = $d['jml'];

$q = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM transaksi");
$d = mysqli_fetch_assoc($q);
$jml_transaksi = $d['jml'];

include 'includes/header.php';
?>
<div class="card">
    <h2>Selamat datang, <?php echo $_SESSION['nama']; ?></h2>
    <p>Anda login sebagai <span class="badge"><?php echo $nama_level; ?></span>.
       Pengelolaan transaksi penjualan Coffee Shop dengan konsep master-detail.</p>
    <p><b>Jumlah barang:</b> <?php echo $jml_barang; ?></p>
    <p><b>Jumlah pelanggan:</b> <?php echo $jml_pelanggan; ?></p>
    <p><b>Jumlah transaksi:</b> <?php echo $jml_transaksi; ?></p>
    <a class="btn" href="<?php echo $base_url; ?>/transaksi/index.php">Kelola Transaksi</a>
</div>
<?php include 'includes/footer.php'; ?>
