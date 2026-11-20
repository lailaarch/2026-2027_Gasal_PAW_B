<?php
include '../includes/koneksi.php';

session_unset();
session_destroy();

header("Location: " . $base_url . "/login.php");
exit;
?>
