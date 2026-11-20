<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$judul = "Data Barang";
$query = mysqli_query($conn, "SELECT barang.*, supplier.nama AS nama_supplier
                              FROM barang
                              INNER JOIN supplier ON barang.supplier_id = supplier.id
                              ORDER BY barang.id");

include '../includes/header.php';
?>
<div class="card">
    <div class="card-judul">
        <h2>Data Barang</h2>
        <a class="btn" href="<?php echo $base_url; ?>/barang/form.php">+ Tambah Barang</a>
    </div>
    <p>Barang yang sudah digunakan pada transaksi tidak dapat dihapus.</p>
    <table>
        <tr>
            <th>No</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Stok</th><th>Supplier</th><th>Tindakan</th>
        </tr>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo htmlspecialchars($row['kode_barang']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
            <td>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
            <td><?php echo $row['stok']; ?></td>
            <td><?php echo htmlspecialchars($row['nama_supplier']); ?></td>
            <td class="kolom-aksi">
                <a class="btn btn-kecil btn-secondary" href="<?php echo $base_url; ?>/barang/form.php?id=<?php echo $row['id']; ?>">Ubah</a>
                <a class="btn btn-kecil btn-danger" href="<?php echo $base_url; ?>/actions/barang.php?aksi=hapus&id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Anda yakin akan menghapus barang ini?');">Hapus</a>
            </td>
        </tr>
        <?php
            $no++;
        }
        ?>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
