<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$judul = "Data Pelanggan";
$query = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id");

include '../includes/header.php';
?>
<div class="card">
    <div class="card-judul">
        <h2>Data Pelanggan</h2>
        <a class="btn" href="<?php echo $base_url; ?>/pelanggan/form.php">+ Tambah Pelanggan</a>
    </div>
    <p>Pelanggan yang sudah memiliki transaksi tidak dapat dihapus.</p>
    <table>
        <tr>
            <th>ID</th><th>Nama</th><th>JK</th><th>Telp</th><th>Alamat</th><th>Tindakan</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['nama']); ?></td>
            <td><?php echo $row['jenis_kelamin']; ?></td>
            <td><?php echo htmlspecialchars($row['telp']); ?></td>
            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
            <td class="kolom-aksi">
                <a class="btn btn-kecil btn-secondary" href="<?php echo $base_url; ?>/pelanggan/form.php?id=<?php echo $row['id']; ?>">Ubah</a>
                <a class="btn btn-kecil btn-danger" href="<?php echo $base_url; ?>/actions/pelanggan.php?aksi=hapus&id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Anda yakin akan menghapus pelanggan ini?');">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
