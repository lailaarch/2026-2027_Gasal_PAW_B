<?php
include 'includes/koneksi.php';
if (isset($_SESSION['login'])) {
    header("Location: " . $base_url . "/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - LayCoffee Shop</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/style.css">
</head>
<body class="halaman-login">
    <div class="kotak-login">
        <h1>LayCoffee Shop</h1>
        <p>Sistem Penjualan - silakan login</p>

        <?php
        if (isset($_SESSION['pesan'])) {
            echo '<div class="alert alert-' . $_SESSION['tipe'] . '">' . $_SESSION['pesan'] . '</div>';
            unset($_SESSION['pesan']);
            unset($_SESSION['tipe']);
        }
        ?>

        <form method="POST" action="<?php echo $base_url; ?>/actions/login.php">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" maxlength="30" autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password">

            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
