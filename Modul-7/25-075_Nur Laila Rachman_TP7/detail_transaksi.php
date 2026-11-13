<?php
include 'koneksi.php';
$id = $_GET['id'];
$query_pilih = "SELECT transaksi.id, transaksi.waktu_transaksi, pelanggan.nama AS nama_pelanggan
                FROM transaksi
                INNER JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
                WHERE transaksi.id=$id";

$result_pilih = mysqli_query($conn, $query_pilih);
$pilih = mysqli_fetch_assoc($result_pilih);

$query_detail = "SELECT transaksi_detail.harga, transaksi_detail.qty, barang.kode_barang, barang.nama_barang
                 FROM transaksi_detail
                 INNER JOIN barang ON transaksi_detail.barang_id = barang.id
                 WHERE transaksi_detail.transaksi_id=$id";

$result_detail = mysqli_query($conn, $query_detail);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <?php include 'menu.php'; ?>
    <div class="container">
        <?php if ($pilih) { ?>
        <div class="card">
            <h2>Detail Transaksi #<?php echo $pilih['id']; ?></h2>
            <p>
                <b>Pelanggan:</b> <?php echo $pilih['nama_pelanggan']; ?>
                |
                <b>Tanggal:</b> <?php echo $pilih['waktu_transaksi']; ?>
            </p>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total = 0;

                    while ($row = mysqli_fetch_assoc($result_detail)) {
                        $subtotal = $row['harga'] * $row['qty'];
                        $total = $total + $subtotal;
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row['kode_barang'] . "</td>";
                        echo "<td>" . $row['nama_barang'] . "</td>";
                        echo "<td>" . $row['harga'] . "</td>";
                        echo "<td>" . $row['qty'] . "</td>";
                        echo "<td>" . $subtotal . "</td>";
                        echo "</tr>";
                    }
                    if ($no == 1) {
                        echo "<tr><td colspan='6'>Belum ada detail transaksi</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <p class="total">
                Total Transaksi: <?php echo $total; ?>
            </p>
            <a href="transaksi.php" class="btn">Kembali</a>
            <a href="tambah_detail.php?id=<?php echo $pilih['id']; ?>" class="btn">Tambah Detail</a>
        </div>
        <?php } else { ?>
            <div class="alert">Data transaksi tidak ditemukan.</div>
            <a href="transaksi.php" class="btn">Kembali</a>
        <?php } ?>
    </div>
</body>
</html>