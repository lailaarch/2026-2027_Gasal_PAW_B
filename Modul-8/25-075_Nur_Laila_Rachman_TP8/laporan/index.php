<?php
include '../includes/koneksi.php';
include '../includes/cek_login.php';

$mulai            = "";
$selesai          = "";
$error            = "";
$rekap            = array();
$total_pendapatan = 0;
$total_pelanggan  = 0;
$ada_filter       = false;

if (isset($_GET['mulai']) && isset($_GET['selesai'])) {
    $ada_filter = true;
    $mulai      = mysqli_real_escape_string($conn, $_GET['mulai']);
    $selesai    = mysqli_real_escape_string($conn, $_GET['selesai']);

    if ($mulai == "" || $selesai == "") {
        $error = "Tanggal wajib diisi.";
    } elseif ($mulai > $selesai) {
        $error = 'Tanggal "Dari" tidak boleh lebih besar dari tanggal "Sampai".';
    } else {
        // Total penjualan per hari
        $query = mysqli_query($conn, "SELECT waktu_transaksi AS tgl, SUM(total) AS total_harian
                                      FROM transaksi
                                      WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'
                                      GROUP BY waktu_transaksi
                                      ORDER BY waktu_transaksi ASC");
        while ($row = mysqli_fetch_assoc($query)) {
            $rekap[] = $row;
            $total_pendapatan = $total_pendapatan + $row['total_harian'];
        }

        // Jumlah pelanggan (tanpa hitung ganda)
        $q_pelanggan = mysqli_query($conn, "SELECT COUNT(DISTINCT pelanggan_id) AS jml
                                            FROM transaksi
                                            WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'");
        $d = mysqli_fetch_assoc($q_pelanggan);
        $total_pelanggan = $d['jml'];
    }
}

$judul = "Laporan Penjualan";
include '../includes/header.php';
?>
<div class="card no-print">
    <h2>Filter Laporan Penjualan</h2>
    <form method="GET" class="inline">
        Dari:
        <input type="date" name="mulai" value="<?php echo $mulai; ?>" style="width:auto">
        Sampai:
        <input type="date" name="selesai" value="<?php echo $selesai; ?>" style="width:auto">
        <button type="submit">Tampilkan</button>
    </form>
    <?php if (count($rekap) > 0) { ?>
        <button type="button" onclick="window.print()">Cetak</button>
        <a class="btn" href="<?php echo $base_url; ?>/actions/laporan_export.php?mulai=<?php echo $mulai; ?>&selesai=<?php echo $selesai; ?>">Excel</a>
    <?php } ?>
</div>

<?php if ($error != "") { ?>
    <div class="alert alert-bahaya"><?php echo $error; ?></div>
<?php } elseif ($ada_filter && count($rekap) == 0) { ?>
    <div class="alert">Tidak ada transaksi pada periode <?php echo $mulai; ?> s/d <?php echo $selesai; ?>.</div>
<?php } ?>

<?php if (count($rekap) > 0) { ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="card">
        <h2>Grafik Penjualan</h2>
        <div style="max-width:700px">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php foreach ($rekap as $r) { echo "'" . $r['tgl'] . "',"; } ?>],
                datasets: [{
                    label: 'Total Penjualan',
                    data: [<?php foreach ($rekap as $r) { echo $r['total_harian'] . ","; } ?>]
                }]
            }
        });
    </script>

    <div class="card">
        <h2>Rekapitulasi</h2>
        <table>
            <tr><th>No</th><th>Total</th><th>Tanggal</th></tr>
            <?php
            $no = 1;
            foreach ($rekap as $row) {
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td>Rp. <?php echo number_format($row['total_harian'], 0, ',', '.'); ?></td>
                <td><?php echo $row['tgl']; ?></td>
            </tr>
            <?php
                $no++;
            }
            ?>
        </table>
        <p>
            <b>Jumlah Pelanggan:</b> <?php echo $total_pelanggan; ?> Orang |
            <b>Jumlah Pendapatan:</b> Rp. <?php echo number_format($total_pendapatan, 0, ',', '.'); ?>
        </p>
    </div>
<?php } ?>
<?php include '../includes/footer.php'; ?>
