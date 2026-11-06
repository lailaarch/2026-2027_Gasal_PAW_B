<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query_cek = "SELECT * FROM transaksi_detail WHERE barang_id=$id";
    $result_cek = mysqli_query($conn, $query_cek);
    if (mysqli_num_rows($result_cek) > 0) {
        echo "<script>
                alert('Barang tidak dapat dihapus karena masih digunakan pada transaksi!');
                window.location = 'barang.php';
              </script>";
    } else {
        $query = "DELETE FROM barang WHERE id=$id";
        if (mysqli_query($conn, $query)) {
            header("Location: barang.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
