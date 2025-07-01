<?php
include 'config.php';
include 'auth.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM pemasukan_barang WHERE id = $id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $keterangan = $_POST['keterangan'];

    $update = $conn->query("UPDATE pemasukan_barang SET 
        nama_barang='$nama_barang', 
        jumlah=$jumlah, 
        tanggal_masuk='$tanggal_masuk', 
        keterangan='$keterangan' 
        WHERE id=$id");

    if ($update) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Gagal update data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pemasukan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body class="p-5">
    <h3>Edit Data Pemasukan Barang</h3>
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
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control" value="<?= $data['tanggal_masuk'] ?>" required>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"><?= $data['keterangan'] ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
