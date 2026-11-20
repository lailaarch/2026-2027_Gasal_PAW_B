<?php
include '../includes/koneksi.php';
include '../includes/cek_login.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);

$cek = mysqli_query($conn, "SELECT id FROM transaksi WHERE id = '$id'");
if (mysqli_num_rows($cek) == 0) {
    $_SESSION['pesan'] = "Data transaksi tidak ditemukan.";
    $_SESSION['tipe']  = "bahaya";
    header("Location: " . $base_url . "/transaksi/index.php");
    exit;
}

$daftar_barang = mysqli_query($conn, "SELECT * FROM barang
                                      WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id = '$id')
                                      ORDER BY nama_barang");

$judul = "Tambah Detail Transaksi";
include '../includes/header.php';
?>
<div class="card form-lebar">
    <h2>Tambah Detail Transaksi #<?php echo $id; ?></h2>
    <form method="POST" action="<?php echo $base_url; ?>/actions/detail_transaksi.php">
        <input type="hidden" name="transaksi_id" value="<?php echo $id; ?>">

        <label for="barang_id">Barang</label>
        <select id="barang_id" name="barang_id">
            <option value="">-- Pilih Barang --</option>
            <?php while ($b = mysqli_fetch_assoc($daftar_barang)) { ?>
                <option value="<?php echo $b['id']; ?>">
                    <?php echo htmlspecialchars($b['kode_barang'] . " - " . $b['nama_barang']); ?>
                    (Rp. <?php echo number_format($b['harga'], 0, ',', '.'); ?>)
                </option>
            <?php } ?>
        </select>

        <label for="qty">Qty</label>
        <input type="number" id="qty" name="qty" min="1" value="1">

        <div class="btn-baris">
            <button type="submit" name="simpan">Simpan Detail</button>
            <a class="btn btn-secondary" href="<?php echo $base_url; ?>/transaksi/detail.php?id=<?php echo $id; ?>">Kembali ke Detail</a>
        </div>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
