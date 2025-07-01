<?php include 'config.php'; include 'auth.php';
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM barang WHERE id=$id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Barang</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="<?= $data['nama_barang'] ?>" required>
        </div>
        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah'] ?>" required>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"><?= $data['keterangan'] ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?php
if (isset($_POST['update'])) {
    $nama = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $ket = $_POST['keterangan'];
    $conn->query("UPDATE barang SET nama_barang='$nama', jumlah='$jumlah', keterangan='$ket' WHERE id=$id");
    header("Location: dashboard.php");
}
?>
</body>
</html>