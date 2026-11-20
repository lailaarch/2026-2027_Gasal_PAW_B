<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$aksi          = "tambah";
$id            = "";
$nama          = "";
$jenis_kelamin = "";
$telp          = "";
$alamat        = "";

if (isset($_GET['id'])) {
    $aksi = "ubah";
    $id   = mysqli_real_escape_string($conn, $_GET['id']);

    $query = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id = '$id'");
    if (mysqli_num_rows($query) == 0) {
        $_SESSION['pesan'] = "Data pelanggan tidak ditemukan.";
        $_SESSION['tipe']  = "bahaya";
        header("Location: " . $base_url . "/pelanggan/index.php");
        exit;
    }
    $row           = mysqli_fetch_assoc($query);
    $nama          = $row['nama'];
    $jenis_kelamin = $row['jenis_kelamin'];
    $telp          = $row['telp'];
    $alamat        = $row['alamat'];
}

if ($aksi == "tambah") {
    $judul = "Tambah Pelanggan";
} else {
    $judul = "Ubah Pelanggan";
}
include '../includes/header.php';
?>
<div class="card form-lebar">
    <h2><?php echo $judul; ?></h2>
    <form method="POST" action="<?php echo $base_url; ?>/actions/pelanggan.php">
        <input type="hidden" name="aksi" value="<?php echo $aksi; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label>ID Pelanggan</label>
        <?php if ($aksi == "ubah") { ?>
            <input type="text" value="<?php echo $id; ?>" readonly>
        <?php } else { ?>
            <input type="text" value="(dibuat otomatis, mis. PLG009)" readonly>
        <?php } ?>

        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" maxlength="100" value="<?php echo htmlspecialchars($nama); ?>">

        <label for="jenis_kelamin">Jenis Kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin">
            <option value="">-- Pilih --</option>
            <option value="L" <?php if ($jenis_kelamin == "L") { echo "selected"; } ?>>Laki-laki</option>
            <option value="P" <?php if ($jenis_kelamin == "P") { echo "selected"; } ?>>Perempuan</option>
        </select>

        <label for="telp">No. Telp</label>
        <input type="text" id="telp" name="telp" maxlength="12" value="<?php echo htmlspecialchars($telp); ?>">
        <small class="bantuan">Opsional, hanya angka (8-12 digit).</small>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" rows="3"><?php echo htmlspecialchars($alamat); ?></textarea>

        <div class="btn-baris">
            <button type="submit" name="simpan">Simpan</button>
            <a class="btn btn-secondary" href="<?php echo $base_url; ?>/pelanggan/index.php">Batal</a>
        </div>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
