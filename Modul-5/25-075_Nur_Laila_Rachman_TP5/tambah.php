<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $telp   = $_POST['telp'];
    $alamat = $_POST['alamat'];
    $query = "INSERT INTO Supplier (Nama, Telp, Alamat) VALUES ('$nama', '$telp', '$alamat')";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Data Master Supplier Baru</title>
    <style>
        h2 { 
        color: #007bff; 
        }
        body { font-family: Arial, sans-serif; margin: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 80px; font-weight: bold; }
        input[type="text"] { width: 300px; padding: 6px; }
        .btn-simpan { background-color: #5cb85c; color: white; padding: 6px 15px; border: none; border-radius: 3px; cursor: pointer; }
        .btn-batal { background-color: #d9534f; color: white; padding: 6px 15px; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>

    <h2>Tambah Data Master Supplier Baru</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Nama" required>
        </div>
        <div class="form-group">
            <label>Telp</label>
            <input type="text" name="telp" placeholder="telp" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" placeholder="alamat" required>
        </div>
        <div class="form-group">
            <button type="submit" name="simpan" class="btn-simpan">Simpan</button>
            <a href="index.php" class="btn-batal">Batal</a>
        </div>
    </form>

</body>
</html>