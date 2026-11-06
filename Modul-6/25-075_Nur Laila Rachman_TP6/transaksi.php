<?php
include 'koneksi.php';


$query_master = "SELECT transaksi.id, transaksi.waktu_transaksi, transaksi.keterangan, transaksi.total, pelanggan.nama AS nama_pelanggan
                 FROM transaksi
                 INNER JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
                 ORDER BY transaksi.id";
$result_master = mysqli_query($conn, $query_master);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $result_pertama = mysqli_query($conn, "SELECT id FROM transaksi ORDER BY id LIMIT 1");
    $pertama = mysqli_fetch_assoc($result_pertama);
    $id = $pertama['id'];
}

$query_pilih = "SELECT transaksi.id, transaksi.waktu_transaksi, pelanggan.nama AS nama_pelanggan
                FROM transaksi
                INNER JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
                WHERE transaksi.id=$id";
$result_pilih = mysqli_query($conn, $query_pilih);
$pilih = mysqli_fetch_assoc($result_pilih);


$query_detail = "SELECT transaksi_detail.harga, transaksi_detail.qty, barang.kode_barang, barang.nama_barang
                 FROM transaksi_detail
                 INNER JOIN barang ON transaksi_detail.barang_id = barang.id
                 WHERE transaksi_detail.transaksi_id=$id";
$result_detail = mysqli_query($conn, $query_detail);
$query_barang = "SELECT barang.id, barang.kode_barang, barang.nama_barang, barang.harga
                 FROM barang
                 LEFT JOIN transaksi_detail ON barang.id = transaksi_detail.barang_id AND transaksi_detail.transaksi_id=$id
                 WHERE transaksi_detail.barang_id IS NULL";
$result_barang = mysqli_query($conn, $query_barang);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">

        <!-- MASTER -->
        <div class="card">
            <h2>Data Transaksi (Master)</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Keterangan</th>
                        <th>Total</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result_master) > 0) {
                        while ($row = mysqli_fetch_assoc($result_master)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['waktu_transaksi'] . "</td>";
                            echo "<td>" . $row['nama_pelanggan'] . "</td>";
                            echo "<td>" . $row['keterangan'] . "</td>";
                            echo "<td>" . $row['total'] . "</td>";
                            echo "<td><a href='transaksi.php?id=" . $row['id'] . "' class='btn'>Lihat Detail</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>0 results</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php if ($pilih) { ?>

        <!-- DETAIL -->
        <div class="card">
            <h2>Detail Transaksi #<?php echo $pilih['id']; ?></h2>
            <p><b>Pelanggan:</b> <?php echo $pilih['nama_pelanggan']; ?> | <b>Tanggal:</b> <?php echo $pilih['waktu_transaksi']; ?></p>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total = 0;
                    while ($row = mysqli_fetch_assoc($result_detail)) {
                        $subtotal = $row['harga'] * $row['qty'];
                        $total = $total + $subtotal;
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row['kode_barang'] . "</td>";
                        echo "<td>" . $row['nama_barang'] . "</td>";
                        echo "<td>" . $row['harga'] . "</td>";
                        echo "<td>" . $row['qty'] . "</td>";
                        echo "<td>" . $subtotal . "</td>";
                        echo "</tr>";
                    }
                    if ($no == 1) {
                        echo "<tr><td colspan='6'>Belum ada detail transaksi</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <p class="total">Total Transaksi: <?php echo $total; ?></p>
        </div>

        <!-- FORM INPUT DETAIL -->
        <div class="card">
            <h2>Tambah Detail Transaksi</h2>
            <form method="POST" action="proses_detail.php">
                <input type="hidden" name="transaksi_id" value="<?php echo $pilih['id']; ?>">

                <label>Barang</label>
                <select name="barang_id" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($result_barang)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['kode_barang'] . " - " . $row['nama_barang'] . " (" . $row['harga'] . ")</option>";
                    }
                    ?>
                </select>

                <label>Qty</label>
                <input type="number" name="qty" min="1" value="1" required>

                <button type="submit" name="simpan">Simpan Detail</button>
            </form>
        </div>

        <?php } else { ?>
            <div class="alert">Data transaksi tidak ditemukan.</div>
        <?php } ?>

    </div>
</body>
</html>
