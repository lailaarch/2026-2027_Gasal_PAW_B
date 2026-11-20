<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$kembali = $base_url . "/user/index.php";
if (isset($_GET['aksi']) && $_GET['aksi'] == "hapus") {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    if ($id == $_SESSION['id_user']) {
        $_SESSION['pesan'] = "Anda tidak dapat menghapus akun yang sedang digunakan.";
        $_SESSION['tipe']  = "bahaya";
    } else {
        mysqli_query($conn, "DELETE FROM `user` WHERE id_user = '$id'");
        $_SESSION['pesan'] = "User berhasil dihapus.";
        $_SESSION['tipe']  = "sukses";
    }
    header("Location: " . $kembali);
    exit;
}

if (!isset($_POST['simpan'])) {
    header("Location: " . $kembali);
    exit;
}

$aksi     = $_POST['aksi'];
$id       = mysqli_real_escape_string($conn, $_POST['id']);
$username = mysqli_real_escape_string($conn, trim($_POST['username']));
$password = $_POST['password'];
$nama     = mysqli_real_escape_string($conn, trim($_POST['nama']));
$alamat   = mysqli_real_escape_string($conn, trim($_POST['alamat']));
$hp       = mysqli_real_escape_string($conn, trim($_POST['hp']));

if ($aksi == "ubah" && $id == $_SESSION['id_user']) {
    $level = $_SESSION['level'];
} else {
    $level = $_POST['level'];
}

// Validasi
$pesan = "";
if (strlen($username) < 3 || strlen($username) > 30) {
    $pesan = "Username harus 3-30 karakter.";
} elseif ($aksi == "tambah" && $password == "") {
    $pesan = "Password wajib diisi.";
} elseif ($password != "" && strlen($password) < 6) {
    $pesan = "Password minimal 6 karakter.";
} elseif ($nama == "") {
    $pesan = "Nama wajib diisi.";
} elseif (strlen($nama) > 50) {
    $pesan = "Nama maksimal 50 karakter.";
} elseif (strlen($alamat) > 150) {
    $pesan = "Alamat maksimal 150 karakter.";
} elseif ($hp != "" && (!ctype_digit($hp) || strlen($hp) < 8 || strlen($hp) > 15)) {
    $pesan = "No. HP harus angka 8-15 digit.";
} elseif ($level != 1 && $level != 2) {
    $pesan = "Level wajib dipilih.";
}

if ($pesan == "") {
    $cek = mysqli_query($conn, "SELECT id_user FROM `user` WHERE username = '$username' AND id_user <> '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Username sudah dipakai.";
    }
}

if ($pesan != "") {
    $_SESSION['pesan'] = $pesan;
    $_SESSION['tipe']  = "bahaya";
    if ($aksi == "ubah") {
        header("Location: " . $base_url . "/user/form.php?id=" . $id);
    } else {
        header("Location: " . $base_url . "/user/form.php");
    }
    exit;
}

if ($aksi == "tambah") {
    $pass_md5 = md5($password);
    mysqli_query($conn, "INSERT INTO `user` (username, password, nama, alamat, hp, level)
                         VALUES ('$username', '$pass_md5', '$nama', '$alamat', '$hp', '$level')");
    $_SESSION['pesan'] = "User berhasil ditambahkan.";
} else {
    mysqli_query($conn, "UPDATE `user` SET username = '$username', nama = '$nama', alamat = '$alamat',
                         hp = '$hp', level = '$level' WHERE id_user = '$id'");

    if ($password != "") {
        $pass_md5 = md5($password);
        mysqli_query($conn, "UPDATE `user` SET password = '$pass_md5' WHERE id_user = '$id'");
    }

    if ($id == $_SESSION['id_user']) {
        $_SESSION['nama']     = $nama;
        $_SESSION['username'] = $username;
    }
    $_SESSION['pesan'] = "User berhasil diubah.";
}
$_SESSION['tipe'] = "sukses";

header("Location: " . $kembali);
exit;
?>
