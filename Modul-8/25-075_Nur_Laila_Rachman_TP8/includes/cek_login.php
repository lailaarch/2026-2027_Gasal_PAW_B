<?php
if (!isset($_SESSION['login'])) {
    header("Location: " . $base_url . "/login.php");
    exit;
}
?>
