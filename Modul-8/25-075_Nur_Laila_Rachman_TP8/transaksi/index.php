<?php
include '../includes/koneksi.php';
include '../includes/cek_login.php';

$judul = "Transaksi";
$query = mysqli_query($conn, "SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
                              FROM transaksi
                              INNER JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
                              ORDER BY transaksi.id");

include '../includes/header.php';
?>
<div class="card">
    <h2>Data Transaksi (Master)</h2>
    <table>
        <tr>
            <th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th><th>Tindakan</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['waktu_transaksi']; ?></td>
            <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
            <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
            <td>Rp. <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
            <td class="kolom-aksi">
                <a class="btn btn-kecil" href="<?php echo $base_url; ?>/transaksi/detail.php?id=<?php echo $row['id']; ?>">Lihat Detail</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
