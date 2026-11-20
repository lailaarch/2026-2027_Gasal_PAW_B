<?php
include '../includes/koneksi.php';
include '../includes/cek_login.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);

$q_master = mysqli_query($conn, "SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
                                 FROM transaksi
                                 INNER JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
                                 WHERE transaksi.id = '$id'");
if (mysqli_num_rows($q_master) == 0) {
    $_SESSION['pesan'] = "Data transaksi tidak ditemukan.";
    $_SESSION['tipe']  = "bahaya";
    header("Location: " . $base_url . "/transaksi/index.php");
    exit;
}
$transaksi = mysqli_fetch_assoc($q_master);

$q_detail = mysqli_query($conn, "SELECT transaksi_detail.*, barang.kode_barang, barang.nama_barang
                                 FROM transaksi_detail
                                 INNER JOIN barang ON transaksi_detail.barang_id = barang.id
                                 WHERE transaksi_detail.transaksi_id = '$id'");

$total = 0;
$judul = "Detail Transaksi";
include '../includes/header.php';
?>
<div class="card">
    <h2>Detail Transaksi #<?php echo $transaksi['id']; ?></h2>
    <p>
        <b>Pelanggan:</b> <?php echo htmlspecialchars($transaksi['nama_pelanggan']); ?> |
        <b>Tanggal:</b> <?php echo $transaksi['waktu_transaksi']; ?>
    </p>
    <table>
        <tr>
            <th>No</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th>
        </tr>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($q_detail)) {
            $subtotal = $row['harga'] * $row['qty'];
            $total    = $total + $subtotal;
        ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo htmlspecialchars($row['kode_barang']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
            <td>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
            <td><?php echo $row['qty']; ?></td>
            <td>Rp. <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
        </tr>
        <?php
            $no++;
        }
        ?>
    </table>

    <p class="total">Total Transaksi: Rp. <?php echo number_format($total, 0, ',', '.'); ?></p>
    <a href="<?php echo $base_url; ?>/transaksi/index.php" class="btn btn-secondary">Kembali</a>
    <a href="<?php echo $base_url; ?>/transaksi/tambah_detail.php?id=<?php echo $transaksi['id']; ?>" class="btn">Tambah Detail</a>
</div>
<?php include '../includes/footer.php'; ?>
