<?php
include '../includes/koneksi.php';
include '../includes/cek_login.php';

$mulai   = mysqli_real_escape_string($conn, $_GET['mulai']);
$selesai = mysqli_real_escape_string($conn, $_GET['selesai']);

if ($mulai == "" || $selesai == "" || $mulai > $selesai) {
    $_SESSION['pesan'] = "Tanggal laporan belum dipilih atau tidak valid.";
    $_SESSION['tipe']  = "bahaya";
    header("Location: " . $base_url . "/laporan/index.php");
    exit;
}

$query = mysqli_query($conn, "SELECT waktu_transaksi AS tgl, SUM(total) AS total_harian
                              FROM transaksi
                              WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'
                              GROUP BY waktu_transaksi
                              ORDER BY waktu_transaksi ASC");

// Header supaya browser mengunduh file sebagai Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");
?>
<h2>Laporan Penjualan</h2>
<p>Periode: <?php echo $mulai; ?> sampai <?php echo $selesai; ?></p>
<table border="1">
    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>
    <?php
    $no    = 1;
    $total = 0;
    while ($row = mysqli_fetch_assoc($query)) {
        $total = $total + $row['total_harian'];
    ?>
    <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $row['total_harian']; ?></td>
        <td><?php echo $row['tgl']; ?></td>
    </tr>
    <?php
        $no++;
    }
    ?>
    <tr>
        <th>Total Keseluruhan</th>
        <th colspan="2"><?php echo $total; ?></th>
    </tr>
</table>
