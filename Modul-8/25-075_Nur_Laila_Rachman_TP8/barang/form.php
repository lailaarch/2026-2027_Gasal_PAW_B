<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$aksi        = "tambah";
$id          = 0;
$kode_barang = "";
$nama_barang = "";
$harga       = "";
$stok        = 0;
$supplier_id = "";

if (isset($_GET['id'])) {
    $aksi = "ubah";
    $id   = mysqli_real_escape_string($conn, $_GET['id']);

    $query = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id'");
    if (mysqli_num_rows($query) == 0) {
        $_SESSION['pesan'] = "Data barang tidak ditemukan.";
        $_SESSION['tipe']  = "bahaya";
        header("Location: " . $base_url . "/barang/index.php");
        exit;
    }
    $row         = mysqli_fetch_assoc($query);
    $kode_barang = $row['kode_barang'];
    $nama_barang = $row['nama_barang'];
    $harga       = $row['harga'];
    $stok        = $row['stok'];
    $supplier_id = $row['supplier_id'];
}

$daftar_supplier = mysqli_query($conn, "SELECT id, nama FROM supplier ORDER BY nama");

if ($aksi == "tambah") {
    $judul = "Tambah Barang";
} else {
    $judul = "Ubah Barang";
}
include '../includes/header.php';
?>
<div class="card form-lebar">
    <h2><?php echo $judul; ?></h2>
    <form method="POST" action="<?php echo $base_url; ?>/actions/barang.php">
        <input type="hidden" name="aksi" value="<?php echo $aksi; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label for="kode_barang">Kode Barang</label>
        <input type="text" id="kode_barang" name="kode_barang" maxlength="10" value="<?php echo htmlspecialchars($kode_barang); ?>">

        <label for="nama_barang">Nama Barang</label>
        <input type="text" id="nama_barang" name="nama_barang" maxlength="100" value="<?php echo htmlspecialchars($nama_barang); ?>">

        <label for="harga">Harga (Rp)</label>
        <input type="number" id="harga" name="harga" min="0" value="<?php echo $harga; ?>">

        <label for="stok">Stok</label>
        <input type="number" id="stok" name="stok" min="0" value="<?php echo $stok; ?>">

        <label for="supplier_id">Supplier</label>
        <select id="supplier_id" name="supplier_id">
            <option value="">-- Pilih Supplier --</option>
            <?php while ($s = mysqli_fetch_assoc($daftar_supplier)) { ?>
                <option value="<?php echo $s['id']; ?>" <?php if ($supplier_id == $s['id']) { echo "selected"; } ?>>
                    <?php echo htmlspecialchars($s['nama']); ?>
                </option>
            <?php } ?>
        </select>

        <div class="btn-baris">
            <button type="submit" name="simpan">Simpan</button>
            <a class="btn btn-secondary" href="<?php echo $base_url; ?>/barang/index.php">Batal</a>
        </div>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
