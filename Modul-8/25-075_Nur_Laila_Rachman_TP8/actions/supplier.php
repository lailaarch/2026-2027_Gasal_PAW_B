<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$kembali = $base_url . "/supplier/index.php";
if (isset($_GET['aksi']) && $_GET['aksi'] == "hapus") {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $cek = mysqli_query($conn, "SELECT * FROM barang WHERE supplier_id = '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['pesan'] = "Supplier tidak dapat dihapus karena masih memiliki barang!";
        $_SESSION['tipe']  = "bahaya";
    } else {
        mysqli_query($conn, "DELETE FROM supplier WHERE id = '$id'");
        $_SESSION['pesan'] = "Supplier berhasil dihapus.";
        $_SESSION['tipe']  = "sukses";
    }
    header("Location: " . $kembali);
    exit;
}

if (!isset($_POST['simpan'])) {
    header("Location: " . $kembali);
    exit;
}

$aksi   = $_POST['aksi'];
$id     = mysqli_real_escape_string($conn, $_POST['id']);
$nama   = mysqli_real_escape_string($conn, trim($_POST['nama']));
$telp   = mysqli_real_escape_string($conn, trim($_POST['telp']));
$alamat = mysqli_real_escape_string($conn, trim($_POST['alamat']));

$pesan = "";
if ($nama == "") {
    $pesan = "Nama supplier wajib diisi.";
} elseif (strlen($nama) > 100) {
    $pesan = "Nama supplier maksimal 100 karakter.";
} elseif ($telp != "" && (!ctype_digit($telp) || strlen($telp) < 8 || strlen($telp) > 12)) {
    $pesan = "No. telp harus angka 8-12 digit.";
}

if ($pesan != "") {
    $_SESSION['pesan'] = $pesan;
    $_SESSION['tipe']  = "bahaya";
    if ($aksi == "ubah") {
        header("Location: " . $base_url . "/supplier/form.php?id=" . $id);
    } else {
        header("Location: " . $base_url . "/supplier/form.php");
    }
    exit;
}

if ($aksi == "tambah") {
    mysqli_query($conn, "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')");
    $_SESSION['pesan'] = "Supplier berhasil ditambahkan.";
} else {
    mysqli_query($conn, "UPDATE supplier SET nama = '$nama', telp = '$telp', alamat = '$alamat' WHERE id = '$id'");
    $_SESSION['pesan'] = "Supplier berhasil diubah.";
}
$_SESSION['tipe'] = "sukses";

header("Location: " . $kembali);
exit;
?>
