<?php
include 'koneksi.php';
$id = $_GET['id'];
$query_pilih = "SELECT * FROM transaksi WHERE id=$id";
$result_pilih = mysqli_query($conn, $query_pilih);
$pilih = mysqli_fetch_assoc($result_pilih);

$query_barang = "SELECT barang.id, barang.kode_barang, barang.nama_barang, barang.harga
                 FROM barang
                 LEFT JOIN transaksi_detail ON barang.id = transaksi_detail.barang_id AND transaksi_detail.transaksi_id=$id
                 WHERE transaksi_detail.barang_id IS NULL";
$result_barang = mysqli_query($conn, $query_barang);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Detail Transaksi</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <?php if ($pilih) { ?>
        <div class="card">
            <h2>Tambah Detail Transaksi #<?php echo $id; ?></h2>
            <form method="POST" action="proses_detail.php">
                <input type="hidden" name="transaksi_id" value="<?php echo $id; ?>">
                <label>Barang</label>
                <select name="barang_id" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($result_barang)) {
                        echo "<option value='" . $row['id'] . "'>";
                        echo $row['kode_barang'] . " - " . $row['nama_barang'] . " (" . $row['harga'] . ")";
                        echo "</option>";
                    }
                    ?>
                </select>
                <label>Qty</label>
                <input type="number" name="qty" min="1" value="1" required>
                <button type="submit" name="simpan">Simpan Detail</button>
            </form>
            <br>
            <a href="detail_transaksi.php?id=<?php echo $id; ?>" class="btn">Kembali ke Detail</a>
        </div>
        <?php } else { ?>
            <div class="alert">Data transaksi tidak ditemukan.</div>
        <?php } ?>
    </div>
</body>
</html>