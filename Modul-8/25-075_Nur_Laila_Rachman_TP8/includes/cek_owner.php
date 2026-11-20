<?php
if (!isset($_SESSION['login'])) {
    header("Location: " . $base_url . "/login.php");
    exit;
}
if ($_SESSION['level'] != 1) {
    die("Anda tidak punya hak akses ke halaman ini.");
}
?>
