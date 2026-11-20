<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$aksi   = "tambah";
$id     = 0;
$nama   = "";
$telp   = "";
$alamat = "";

if (isset($_GET['id'])) {
    $aksi = "ubah";
    $id   = mysqli_real_escape_string($conn, $_GET['id']);

    $query = mysqli_query($conn, "SELECT * FROM supplier WHERE id = '$id'");
    if (mysqli_num_rows($query) == 0) {
        $_SESSION['pesan'] = "Data supplier tidak ditemukan.";
        $_SESSION['tipe']  = "bahaya";
        header("Location: " . $base_url . "/supplier/index.php");
        exit;
    }
    $row    = mysqli_fetch_assoc($query);
    $nama   = $row['nama'];
    $telp   = $row['telp'];
    $alamat = $row['alamat'];
}

if ($aksi == "tambah") {
    $judul = "Tambah Supplier";
} else {
    $judul = "Ubah Supplier";
}
include '../includes/header.php';
?>
<div class="card form-lebar">
    <h2><?php echo $judul; ?></h2>
    <form method="POST" action="<?php echo $base_url; ?>/actions/supplier.php">
        <input type="hidden" name="aksi" value="<?php echo $aksi; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label for="nama">Nama Supplier</label>
        <input type="text" id="nama" name="nama" maxlength="100" value="<?php echo htmlspecialchars($nama); ?>">

        <label for="telp">No. Telp</label>
        <input type="text" id="telp" name="telp" maxlength="12" value="<?php echo htmlspecialchars($telp); ?>">
        <small class="bantuan">Opsional, hanya angka (8-12 digit).</small>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" rows="3"><?php echo htmlspecialchars($alamat); ?></textarea>

        <div class="btn-baris">
            <button type="submit" name="simpan">Simpan</button>
            <a class="btn btn-secondary" href="<?php echo $base_url; ?>/supplier/index.php">Batal</a>
        </div>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
