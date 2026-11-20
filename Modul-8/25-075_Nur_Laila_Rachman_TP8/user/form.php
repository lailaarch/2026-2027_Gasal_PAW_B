<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$aksi     = "tambah";
$id       = 0;
$username = "";
$nama     = "";
$alamat   = "";
$hp       = "";
$level    = "";

if (isset($_GET['id'])) {
    $aksi = "ubah";
    $id   = mysqli_real_escape_string($conn, $_GET['id']);

    $query = mysqli_query($conn, "SELECT * FROM `user` WHERE id_user = '$id'");
    if (mysqli_num_rows($query) == 0) {
        $_SESSION['pesan'] = "Data user tidak ditemukan.";
        $_SESSION['tipe']  = "bahaya";
        header("Location: " . $base_url . "/user/index.php");
        exit;
    }
    $row      = mysqli_fetch_assoc($query);
    $username = $row['username'];
    $nama     = $row['nama'];
    $alamat   = $row['alamat'];
    $hp       = $row['hp'];
    $level    = $row['level'];
}

$akun_sendiri = false;
if ($aksi == "ubah" && $id == $_SESSION['id_user']) {
    $akun_sendiri = true;
}

if ($aksi == "tambah") {
    $judul = "Tambah User";
} else {
    $judul = "Ubah User";
}
include '../includes/header.php';
?>
<div class="card form-lebar">
    <h2><?php echo $judul; ?></h2>
    <form method="POST" action="<?php echo $base_url; ?>/actions/user.php" autocomplete="off">
        <input type="hidden" name="aksi" value="<?php echo $aksi; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label for="username">Username</label>
        <input type="text" id="username" name="username" maxlength="30" value="<?php echo htmlspecialchars($username); ?>">
        <small class="bantuan">3-30 karakter.</small>

        <label for="password">Password</label>
        <input type="password" id="password" name="password">
        <?php if ($aksi == "ubah") { ?>
            <small class="bantuan">Kosongkan jika tidak ingin mengganti password.</small>
        <?php } else { ?>
            <small class="bantuan">Minimal 6 karakter.</small>
        <?php } ?>

        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" maxlength="50" value="<?php echo htmlspecialchars($nama); ?>">

        <label for="alamat">Alamat</label>
        <input type="text" id="alamat" name="alamat" maxlength="150" value="<?php echo htmlspecialchars($alamat); ?>">

        <label for="hp">No. HP</label>
        <input type="text" id="hp" name="hp" maxlength="20" value="<?php echo htmlspecialchars($hp); ?>">
        <small class="bantuan">Opsional, hanya angka (8-15 digit).</small>

        <label for="level">Level</label>
        <select id="level" name="level" <?php if ($akun_sendiri) { echo "disabled"; } ?>>
            <option value="">-- Pilih Level --</option>
            <option value="1" <?php if ($level == 1) { echo "selected"; } ?>>1 - Owner</option>
            <option value="2" <?php if ($level == 2) { echo "selected"; } ?>>2 - Kasir</option>
        </select>
        <?php if ($akun_sendiri) { ?>
            <small class="bantuan">Level akun yang sedang Anda pakai tidak dapat diubah.</small>
        <?php } ?>

        <div class="btn-baris">
            <button type="submit" name="simpan">Simpan</button>
            <a class="btn btn-secondary" href="<?php echo $base_url; ?>/user/index.php">Batal</a>
        </div>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
