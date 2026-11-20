<?php
include '../includes/koneksi.php';

if (!isset($_POST['login'])) {
    header("Location: " . $base_url . "/login.php");
    exit;
}

$user_input = mysqli_real_escape_string($conn, $_POST['username']);
$pass_input = $_POST['password'];

if ($user_input == "" || $pass_input == "") {
    $_SESSION['pesan'] = "Username dan password wajib diisi.";
    $_SESSION['tipe']  = "bahaya";
    header("Location: " . $base_url . "/login.php");
    exit;
}

$pass_md5 = md5($pass_input);
$query = mysqli_query($conn, "SELECT * FROM `user` WHERE username = '$user_input' AND password = '$pass_md5'");

if (mysqli_num_rows($query) == 0) {
    $_SESSION['pesan'] = "Username atau password salah.";
    $_SESSION['tipe']  = "bahaya";
    header("Location: " . $base_url . "/login.php");
    exit;
}

$user = mysqli_fetch_assoc($query);

// Hanya level 1 (Owner) dan 2 (Kasir) yang boleh masuk
if ($user['level'] != 1 && $user['level'] != 2) {
    $_SESSION['pesan'] = "Level akun ini tidak punya akses. Hubungi owner.";
    $_SESSION['tipe']  = "bahaya";
    header("Location: " . $base_url . "/login.php");
    exit;
}

$_SESSION['login']    = true;
$_SESSION['id_user']  = $user['id_user'];
$_SESSION['username'] = $user['username'];
$_SESSION['nama']     = $user['nama'];
$_SESSION['level']    = $user['level'];

header("Location: " . $base_url . "/index.php");
exit;
?>
