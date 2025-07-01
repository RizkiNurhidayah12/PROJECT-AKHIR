<?php
include 'config.php';
include 'auth.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM pengembalian WHERE id = $id")->fetch_assoc();

// Ambil data penyewaan untuk dropdown
$penyewaan = $conn->query("SELECT id, nama_penyewa, nama_barang FROM penyewaan ORDER BY id DESC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_penyewaan = $_POST['id_penyewaan'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE pengembalian SET id_penyewaan=?, tanggal_pengembalian=?, status=? WHERE id=?");
    $stmt->bind_param("issi", $id_penyewaan, $tanggal_pengembalian, $status, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: pengembalian.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pengembalian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body class="p-5">
    <h3>Edit Data Pengembalian</h3>
    <form method="POST">
        <div class="form-group">
            <label>Pilih Data Penyewaan</label>
            <select name="id_penyewaan" class="form-control" required>
                <option value="">-- Pilih --</option>
                <?php while ($row = $penyewaan->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" <?= ($row['id'] == $data['id_penyewaan']) ? 'selected' : '' ?>>
                        <?= $row['nama_penyewa'] ?> - <?= $row['nama_barang'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal Pengembalian</label>
            <input type="date" name="tanggal_pengembalian" class="form-control" value="<?= $data['tanggal_pengembalian'] ?>" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Selesai" <?= $data['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                <option value="Terlambat" <?= $data['status'] == 'Terlambat' ? 'selected' : '' ?>>Terlambat</option>
                <option value="Rusak" <?= $data['status'] == 'Rusak' ? 'selected' : '' ?>>Rusak</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="pengembalian.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
