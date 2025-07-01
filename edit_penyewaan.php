<?php
include 'config.php';
include 'auth.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM penyewaan WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_penyewa = $_POST['nama_penyewa'];
    $nama_barang = $_POST['nama_barang'];
    $tanggal_sewa = $_POST['tanggal_sewa'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $keterangan = $_POST['keterangan'];

    $stmt = $conn->prepare("UPDATE penyewaan SET nama_penyewa=?, nama_barang=?, tanggal_sewa=?, tanggal_kembali=?, keterangan=? WHERE id=?");
    $stmt->bind_param("sssssi", $nama_penyewa, $nama_barang, $tanggal_sewa, $tanggal_kembali, $keterangan, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: penyewaan.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Penyewaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body class="p-5">
    <h3>Edit Data Penyewaan</h3>
    <form method="POST">
        <div class="form-group">
            <label>Nama Penyewa</label>
            <input type="text" name="nama_penyewa" class="form-control" value="<?= htmlspecialchars($data['nama_penyewa']) ?>" required>
        </div>
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($data['nama_barang']) ?>" required>
        </div>
        <div class="form-group">
            <label>Tanggal Sewa</label>
            <input type="date" name="tanggal_sewa" class="form-control" value="<?= $data['tanggal_sewa'] ?>" required>
        </div>
        <div class="form-group">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control" value="<?= $data['tanggal_kembali'] ?>" required>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"><?= htmlspecialchars($data['keterangan']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="penyewaan.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
