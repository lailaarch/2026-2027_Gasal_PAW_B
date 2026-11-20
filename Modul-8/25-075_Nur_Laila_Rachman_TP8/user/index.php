<?php
include '../includes/koneksi.php';
include '../includes/cek_owner.php';

$judul = "Data User";
$query = mysqli_query($conn, "SELECT * FROM `user` ORDER BY id_user");

include '../includes/header.php';
?>
<div class="card">
    <div class="card-judul">
        <h2>Data User</h2>
        <a class="btn" href="<?php echo $base_url; ?>/user/form.php">+ Tambah User</a>
    </div>
    <table>
        <tr>
            <th>No</th><th>Username</th><th>Nama</th><th>Alamat</th><th>HP</th><th>Level</th><th>Tindakan</th>
        </tr>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($query)) {
            if ($row['level'] == 1) {
                $level_teks = "Owner";
            } elseif ($row['level'] == 2) {
                $level_teks = "Kasir";
            } else {
                $level_teks = "Tidak dikenal";
            }
        ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['nama']); ?></td>
            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
            <td><?php echo htmlspecialchars($row['hp']); ?></td>
            <td><span class="badge"><?php echo $level_teks; ?></span></td>
            <td class="kolom-aksi">
                <a class="btn btn-kecil btn-secondary" href="<?php echo $base_url; ?>/user/form.php?id=<?php echo $row['id_user']; ?>">Ubah</a>
                <?php // Akun yang sedang dipakai tidak boleh dihapus ?>
                <?php if ($row['id_user'] != $_SESSION['id_user']) { ?>
                    <a class="btn btn-kecil btn-danger" href="<?php echo $base_url; ?>/actions/user.php?aksi=hapus&id=<?php echo $row['id_user']; ?>"
                       onclick="return confirm('Anda yakin akan menghapus user ini?');">Hapus</a>
                <?php } ?>
            </td>
        </tr>
        <?php
            $no++;
        }
        ?>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
