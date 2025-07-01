<?php
include 'config.php';
include 'auth.php';

$pesan = '';

// Proses simpan pengembalian
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_penyewaan = $_POST['id_penyewaan'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO pengembalian (id_penyewaan, tanggal_pengembalian, status) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id_penyewaan, $tanggal_pengembalian, $status);

    if ($stmt->execute()) {
        $pesan = "✅ Pengembalian berhasil dicatat.";
    } else {
        $pesan = "❌ Gagal mencatat pengembalian.";
    }
}

// Ambil data penyewaan untuk dropdown
$penyewaan = $conn->query("SELECT id, nama_penyewa, nama_barang FROM penyewaan ORDER BY id DESC");

// Ambil data pengembalian
$pengembalian = $conn->query("SELECT p.*, py.nama_penyewa, py.nama_barang 
                              FROM pengembalian p
                              JOIN penyewaan py ON p.id_penyewaan = py.id
                              ORDER BY p.id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengembalian Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Form Pengembalian Barang</h3>

    <?php if ($pesan): ?>
        <div class="alert alert-info"><?= $pesan ?></div>
    <?php endif; ?>

    <!-- Form Pengembalian -->
    <form method="POST" class="mb-4">
        <div class="form-group">
            <label>Pilih Data Penyewaan</label>
            <select name="id_penyewaan" class="form-control" required>
                <option value="">-- Pilih --</option>
                <?php while ($row = $penyewaan->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>">
                        <?= $row['nama_penyewa'] ?> - <?= $row['nama_barang'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal Pengembalian</label>
            <input type="date" name="tanggal_pengembalian" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Selesai">Selesai</option>
                <option value="Terlambat">Terlambat</option>
                <option value="Rusak">Rusak</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>

    <!-- Tabel Pengembalian -->
    <h4>Data Pengembalian</h4>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Nama Barang</th>
                <th>Tanggal Pengembalian</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($pengembalian->num_rows > 0): 
                $no = 1;
                while ($row = $pengembalian->fetch_assoc()):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_penyewa']) ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td><?= $row['tanggal_pengembalian'] ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td>
                    <a href="edit_pengembalian.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="hapus_pengembalian.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; else: ?>
            <tr>
                <td colspan="6" class="text-center">Belum ada data pengembalian.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
