<?php
if ($_SESSION['level'] == 1) {
    $nama_level = "Owner";
} else {
    $nama_level = "Kasir";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $judul; ?> - LayCoffee Shop</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/style.css">
</head>
<body>
<header>
    <a class="brand" href="<?php echo $base_url; ?>/index.php">LayCoffee Shop</a>

    <ul class="menu">
        <li><a href="<?php echo $base_url; ?>/index.php">Home</a></li>

        <?php if ($_SESSION['level'] == 1) { ?>
        <li class="ada-sub">
            <a href="#">Data Master &#9662;</a>
            <ul class="sub">
                <li><a href="<?php echo $base_url; ?>/barang/index.php">Data Barang</a></li>
                <li><a href="<?php echo $base_url; ?>/supplier/index.php">Data Supplier</a></li>
                <li><a href="<?php echo $base_url; ?>/pelanggan/index.php">Data Pelanggan</a></li>
                <li><a href="<?php echo $base_url; ?>/user/index.php">Data User</a></li>
            </ul>
        </li>
        <?php } ?>

        <li><a href="<?php echo $base_url; ?>/transaksi/index.php">Transaksi</a></li>
        <li><a href="<?php echo $base_url; ?>/laporan/index.php">Laporan</a></li>
    </ul>

    <ul class="menu menu-user">
        <li class="ada-sub">
            <a href="#"><?php echo $_SESSION['nama']; ?> (<?php echo $nama_level; ?>) &#9662;</a>
            <ul class="sub sub-kanan">
                <li><a href="<?php echo $base_url; ?>/actions/logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</header>

<div class="container">
    <?php
    if (isset($_SESSION['pesan'])) {
        echo '<div class="alert alert-' . $_SESSION['tipe'] . '">' . $_SESSION['pesan'] . '</div>';
        unset($_SESSION['pesan']);
        unset($_SESSION['tipe']);
    }
    ?>
