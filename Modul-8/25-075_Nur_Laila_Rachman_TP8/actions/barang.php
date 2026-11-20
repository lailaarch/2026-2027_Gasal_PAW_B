<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$kembali = $base_url . "/barang/index.php";

if (isset($_GET['aksi']) && $_GET['aksi'] == "hapus") {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $cek = mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE barang_id = '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['pesan'] = "Barang tidak dapat dihapus karena masih digunakan pada transaksi!";
        $_SESSION['tipe']  = "bahaya";
    } else {
        mysqli_query($conn, "DELETE FROM barang WHERE id = '$id'");
        $_SESSION['pesan'] = "Barang berhasil dihapus.";
        $_SESSION['tipe']  = "sukses";
    }
    header("Location: " . $kembali);
    exit;
}

if (!isset($_POST['simpan'])) {
    header("Location: " . $kembali);
    exit;
}

$aksi        = $_POST['aksi'];
$id          = mysqli_real_escape_string($conn, $_POST['id']);
$kode_barang = mysqli_real_escape_string($conn, trim($_POST['kode_barang']));
$nama_barang = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));
$harga       = trim($_POST['harga']);
$stok        = trim($_POST['stok']);
$supplier_id = mysqli_real_escape_string($conn, $_POST['supplier_id']);

$pesan = "";
if ($kode_barang == "") {
    $pesan = "Kode barang wajib diisi.";
} elseif (strlen($kode_barang) > 10) {
    $pesan = "Kode barang maksimal 10 karakter.";
} elseif ($nama_barang == "") {
    $pesan = "Nama barang wajib diisi.";
} elseif (strlen($nama_barang) > 100) {
    $pesan = "Nama barang maksimal 100 karakter.";
} elseif (!ctype_digit($harga)) {
    $pesan = "Harga harus berupa angka bulat (0 atau lebih).";
} elseif (!ctype_digit($stok)) {
    $pesan = "Stok harus berupa angka bulat (0 atau lebih).";
} elseif ($supplier_id == "") {
    $pesan = "Supplier wajib dipilih.";
}

// Cek kode barang tidak boleh kembar
if ($pesan == "") {
    $cek = mysqli_query($conn, "SELECT id FROM barang WHERE kode_barang = '$kode_barang' AND id <> '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Kode barang sudah dipakai barang lain.";
    }
}

if ($pesan != "") {
    $_SESSION['pesan'] = $pesan;
    $_SESSION['tipe']  = "bahaya";
    if ($aksi == "ubah") {
        header("Location: " . $base_url . "/barang/form.php?id=" . $id);
    } else {
        header("Location: " . $base_url . "/barang/form.php");
    }
    exit;
}

if ($aksi == "tambah") {
    mysqli_query($conn, "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id)
                         VALUES ('$kode_barang', '$nama_barang', '$harga', '$stok', '$supplier_id')");
    $_SESSION['pesan'] = "Barang berhasil ditambahkan.";
} else {
    mysqli_query($conn, "UPDATE barang SET kode_barang = '$kode_barang', nama_barang = '$nama_barang',
                         harga = '$harga', stok = '$stok', supplier_id = '$supplier_id'
                         WHERE id = '$id'");
    $_SESSION['pesan'] = "Barang berhasil diubah.";
}
$_SESSION['tipe'] = "sukses";

header("Location: " . $kembali);
exit;
?>
