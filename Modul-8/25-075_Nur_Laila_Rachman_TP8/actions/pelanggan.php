<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$kembali = $base_url . "/pelanggan/index.php";

if (isset($_GET['aksi']) && $_GET['aksi'] == "hapus") {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Pelanggan tidak boleh dihapus kalau sudah punya transaksi
    $cek = mysqli_query($conn, "SELECT * FROM transaksi WHERE pelanggan_id = '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['pesan'] = "Pelanggan tidak dapat dihapus karena sudah memiliki transaksi!";
        $_SESSION['tipe']  = "bahaya";
    } else {
        mysqli_query($conn, "DELETE FROM pelanggan WHERE id = '$id'");
        $_SESSION['pesan'] = "Pelanggan berhasil dihapus.";
        $_SESSION['tipe']  = "sukses";
    }
    header("Location: " . $kembali);
    exit;
}

if (!isset($_POST['simpan'])) {
    header("Location: " . $kembali);
    exit;
}

$aksi          = $_POST['aksi'];
$id            = mysqli_real_escape_string($conn, $_POST['id']);
$nama          = mysqli_real_escape_string($conn, trim($_POST['nama']));
$jenis_kelamin = $_POST['jenis_kelamin'];
$telp          = mysqli_real_escape_string($conn, trim($_POST['telp']));
$alamat        = mysqli_real_escape_string($conn, trim($_POST['alamat']));

$pesan = "";
if ($nama == "") {
    $pesan = "Nama pelanggan wajib diisi.";
} elseif (strlen($nama) > 100) {
    $pesan = "Nama pelanggan maksimal 100 karakter.";
} elseif ($jenis_kelamin != "L" && $jenis_kelamin != "P") {
    $pesan = "Jenis kelamin wajib dipilih.";
} elseif ($telp != "" && (!ctype_digit($telp) || strlen($telp) < 8 || strlen($telp) > 12)) {
    $pesan = "No. telp harus angka 8-12 digit.";
}

if ($pesan != "") {
    $_SESSION['pesan'] = $pesan;
    $_SESSION['tipe']  = "bahaya";
    if ($aksi == "ubah") {
        header("Location: " . $base_url . "/pelanggan/form.php?id=" . $id);
    } else {
        header("Location: " . $base_url . "/pelanggan/form.php");
    }
    exit;
}

if ($aksi == "tambah") {
    $q = mysqli_query($conn, "SELECT id FROM pelanggan ORDER BY id DESC LIMIT 1");
    if (mysqli_num_rows($q) > 0) {
        $terakhir = mysqli_fetch_assoc($q);
        $nomor    = intval(substr($terakhir['id'], 3)); 
    } else {
        $nomor = 0;
    }
    $id_baru = "PLG" . str_pad($nomor + 1, 3, "0", STR_PAD_LEFT);   

    mysqli_query($conn, "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat)
                         VALUES ('$id_baru', '$nama', '$jenis_kelamin', '$telp', '$alamat')");
    $_SESSION['pesan'] = "Pelanggan berhasil ditambahkan dengan ID " . $id_baru . ".";
} else {
    mysqli_query($conn, "UPDATE pelanggan SET nama = '$nama', jenis_kelamin = '$jenis_kelamin',
                         telp = '$telp', alamat = '$alamat' WHERE id = '$id'");
    $_SESSION['pesan'] = "Pelanggan berhasil diubah.";
}
$_SESSION['tipe'] = "sukses";

header("Location: " . $kembali);
exit;
?>
