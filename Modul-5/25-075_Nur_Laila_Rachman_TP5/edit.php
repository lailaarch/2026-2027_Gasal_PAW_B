<?php
include 'koneksi.php';
$id = $_GET['id'];
$query_select = "SELECT * FROM Supplier WHERE id=$id";
$result_select = mysqli_query($conn, $query_select);
$data = mysqli_fetch_assoc($result_select);

if (isset($_POST['update'])) {
    $nama   = $_POST['nama'];
    $telp   = $_POST['telp'];
    $alamat = $_POST['alamat'];
    $query_update = "UPDATE Supplier SET Nama='$nama', Telp='$telp', Alamat='$alamat' WHERE id=$id";
    if (mysqli_query($conn, $query_update)) {
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
    <title>Edit Data Master Supplier</title>
    <style>
        h2 { 
        color: #007bff; 
        }
        body { font-family: Arial, sans-serif; margin: 30px; }
        .form-group { 
        margin-bottom: 15px; }
        label { display: inline-block; width: 80px; font-weight: bold; }
        input[type="text"] { width: 300px; padding: 6px; }
        .btn-update { background-color: #5cb85c; color: white; padding: 6px 15px; border: none; border-radius: 3px; cursor: pointer; }
        .btn-batal { background-color: #d9534f; color: white; padding: 6px 15px; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>

    <h2>Edit Data Master Supplier</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" value="<?php echo $data['Nama']; ?>" required>
        </div>
        <div class="form-group">
            <label>Telp</label>
            <input type="text" name="telp" value="<?php echo $data['Telp']; ?>" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="<?php echo $data['Alamat']; ?>" required>
        </div>
        <div class="form-group">
            <button type="submit" name="update" class="btn-update">Update</button>
            <a href="index.php" class="btn-batal">Batal</a>
        </div>
    </form>

</body>
</html>