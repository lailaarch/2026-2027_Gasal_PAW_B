<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $transaksi_id = $_POST['transaksi_id'];
    $barang_id    = $_POST['barang_id'];
    $qty          = $_POST['qty'];

    $query_barang = "SELECT harga FROM barang WHERE id=$barang_id";
    $result_barang = mysqli_query($conn, $query_barang);
    $barang = mysqli_fetch_assoc($result_barang);
    $harga = $barang['harga'];

    $query_insert = "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
                     VALUES ($transaksi_id, $barang_id, $harga, $qty)";

    if (mysqli_query($conn, $query_insert)) {
        $query_total = "SELECT SUM(harga * qty) AS total FROM transaksi_detail WHERE transaksi_id=$transaksi_id";
        $result_total = mysqli_query($conn, $query_total);
        $data_total = mysqli_fetch_assoc($result_total);
        $total = $data_total['total'];

        $query_update = "UPDATE transaksi SET total=$total WHERE id=$transaksi_id";
        if (mysqli_query($conn, $query_update)) {
            header("Location: transaksi.php?id=$transaksi_id");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
