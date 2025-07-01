<?php
include 'config.php';
include 'auth.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM pengeluaran_barang WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $tanggal_keluar = $_POST['tanggal_keluar'];
    $keterangan = $_POST['keterangan'];

    $stmt = $conn->prepare("UPDATE pengeluaran_barang SET nama_barang=?, jumlah=?, tanggal_keluar=?, keterangan=? WHERE id=?");
    $stmt->bind_param("sissi", $nama_barang, $jumlah, $tanggal_keluar, $keterangan, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: pengeluaran.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pengeluaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body class="p-5">
    <h3>Edit Data Pengeluaran Barang</h3>
    <form method="POST">
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($data['nama_barang']) ?>" required>
        </div>
        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah'] ?>" required>
        </div>
        <div class="form-group">
            <label>Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" class="form-control" value="<?= $data['tanggal_keluar'] ?>" required>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"><?= htmlspecialchars($data['keterangan']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="pengeluaran.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
