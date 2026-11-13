<?php
include 'koneksi.php';

$query = "SELECT barang.id, barang.kode_barang, barang.nama_barang, barang.harga, barang.stok, supplier.nama AS nama_supplier
          FROM barang
          INNER JOIN supplier ON barang.supplier_id = supplier.id
          ORDER BY barang.id";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <div class="card">
            <h2>Data Barang</h2>
            <p>Barang yang sudah digunakan pada transaksi tidak dapat dihapus.</p>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Supplier</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row['kode_barang'] . "</td>";
                            echo "<td>" . $row['nama_barang'] . "</td>";
                            echo "<td>" . $row['harga'] . "</td>";
                            echo "<td>" . $row['stok'] . "</td>";
                            echo "<td>" . $row['nama_supplier'] . "</td>";
                            echo "<td>
                                    <a href='hapus_barang.php?id=" . $row['id'] . "' class='btn btn-danger' onclick=\"return confirm('Anda yakin akan menghapus barang ini?');\">Hapus</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>0 results</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
