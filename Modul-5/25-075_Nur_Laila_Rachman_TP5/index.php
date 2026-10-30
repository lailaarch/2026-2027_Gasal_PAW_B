<?php
include 'koneksi.php';
$query = "SELECT id, Nama, Telp, Alamat FROM Supplier";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title style="text">Data Master Supplier</title>
    <style>
        h2 { 
        color: #007bff; 
        }
        body { font-family: Arial, sans-serif; margin: 20px; }
        .btn-tambah { 
            background-color: #5cb85c; 
            color: white; padding: 8px 15px; 
            text-decoration: none; 
            border-radius: 
            4px; float: right; }
            table { 
            width: 100%;
            border-collapse: collapse; 
            margin-top: 20px; }
        th, td { 
            border: 1px solid #ddd; 
            padding: 10px; text-align: left; }
        th { 
        background-color: #e0f2f1; }
        .btn-edit { 
            background-color: #f0ad4e; 
            color: white; 
            padding: 5px 12px; 
            text-decoration: none; 
            border-radius: 3px; 
            margin-right: 5px; }
        .btn-hapus { 
            background-color: #d9534f; 
            color: white; 
            padding: 5px 12px; 
            text-decoration: none; 
            border-radius: 3px; }
    </style>
</head>
<body>
    <a href="tambah.php" class="btn-tambah">Tambah Data</a>
    <h2>Data Master Supplier</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Telp</th>
                <th>Alamat</th>
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
                    echo "<td>" . $row['Nama'] . "</td>";
                    echo "<td>" . $row['Telp'] . "</td>";
                    echo "<td>" . $row['Alamat'] . "</td>";
                    echo "<td>
                            <a href='edit.php?id=" . $row['id'] . "' class='btn-edit'>Edit</a>
                            <a href='hapus.php?id=" . $row['id'] . "' class='btn-hapus' onclick=\"return confirm('Anda yakin akan menghapus supplier ini?');\">Hapus</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>0 results</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>