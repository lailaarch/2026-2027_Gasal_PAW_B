<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$judul = "Data Supplier";
$query = mysqli_query($conn, "SELECT * FROM supplier ORDER BY id");

include '../includes/header.php';
?>
<div class="card">
    <div class="card-judul">
        <h2>Data Supplier</h2>
        <a class="btn" href="<?php echo $base_url; ?>/supplier/form.php">+ Tambah Supplier</a>
    </div>
    <p>Supplier yang masih memiliki barang tidak dapat dihapus.</p>
    <table>
        <tr>
            <th>No</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Tindakan</th>
        </tr>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo htmlspecialchars($row['nama']); ?></td>
            <td><?php echo htmlspecialchars($row['telp']); ?></td>
            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
            <td class="kolom-aksi">
                <a class="btn btn-kecil btn-secondary" href="<?php echo $base_url; ?>/supplier/form.php?id=<?php echo $row['id']; ?>">Ubah</a>
                <a class="btn btn-kecil btn-danger" href="<?php echo $base_url; ?>/actions/supplier.php?aksi=hapus&id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Anda yakin akan menghapus supplier ini?');">Hapus</a>
            </td>
        </tr>
        <?php
            $no++;
        }
        ?>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
