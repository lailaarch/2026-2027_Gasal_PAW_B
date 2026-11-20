<?php
include '../includes/koneksi.php';
include '../includes/cek_login.php';

if (!isset($_POST['simpan'])) {
    header("Location: " . $base_url . "/transaksi/index.php");
    exit;
}

$transaksi_id = mysqli_real_escape_string($conn, $_POST['transaksi_id']);
$barang_id    = mysqli_real_escape_string($conn, $_POST['barang_id']);
$qty          = trim($_POST['qty']);

$kembali = $base_url . "/transaksi/tambah_detail.php?id=" . $transaksi_id;

$pesan = "";
if ($barang_id == "") {
    $pesan = "Barang wajib dipilih.";
} elseif (!ctype_digit($qty) || $qty < 1) {
    $pesan = "Qty harus berupa angka minimal 1.";
}

if ($pesan == "") {
    $cek = mysqli_query($conn, "SELECT * FROM transaksi_detail
                                WHERE transaksi_id = '$transaksi_id' AND barang_id = '$barang_id'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Barang ini sudah ada pada transaksi.";
    }
}

if ($pesan == "") {
    $q_barang = mysqli_query($conn, "SELECT harga FROM barang WHERE id = '$barang_id'");
    if (mysqli_num_rows($q_barang) == 0) {
        $pesan = "Barang tidak ditemukan.";
    } else {
        $barang = mysqli_fetch_assoc($q_barang);
        $harga  = $barang['harga'];
    }
}

if ($pesan != "") {
    $_SESSION['pesan'] = $pesan;
    $_SESSION['tipe']  = "bahaya";
    header("Location: " . $kembali);
    exit;
}

mysqli_query($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
                     VALUES ('$transaksi_id', '$barang_id', '$harga', '$qty')");

$q_total = mysqli_query($conn, "SELECT SUM(harga * qty) AS total FROM transaksi_detail
                                WHERE transaksi_id = '$transaksi_id'");
$data_total = mysqli_fetch_assoc($q_total);
$total      = $data_total['total'];
mysqli_query($conn, "UPDATE transaksi SET total = '$total' WHERE id = '$transaksi_id'");

$_SESSION['pesan'] = "Detail transaksi berhasil ditambahkan.";
$_SESSION['tipe']  = "sukses";

header("Location: " . $base_url . "/transaksi/detail.php?id=" . $transaksi_id);
exit;
?>
