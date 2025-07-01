<?php
include 'config.php';
include 'auth.php';

$pesan = '';

// Proses simpan penyewaan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_penyewa = $_POST['nama_penyewa'];
    $nama_barang = $_POST['nama_barang'];
    $tanggal_sewa = $_POST['tanggal_sewa'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $keterangan = $_POST['keterangan'];

    $stmt = $conn->prepare("INSERT INTO penyewaan (nama_penyewa, nama_barang, tanggal_sewa, tanggal_kembali, keterangan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama_penyewa, $nama_barang, $tanggal_sewa, $tanggal_kembali, $keterangan);

    if ($stmt->execute()) {
        $pesan = "✅ Penyewaan berhasil disimpan.";
    } else {
        $pesan = "❌ Gagal menyimpan data.";
    }
}

// Ambil data penyewaan
$penyewaan = $conn->query("SELECT * FROM penyewaan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Penyewaan Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Penyewaan Barang</h3>

    <?php if ($pesan): ?>
        <div class="alert alert-info"><?= $pesan ?></div>
    <?php endif; ?>

    <!-- Formulir Penyewaan -->
    <form method="POST" class="mb-4">
        <div class="form-group">
            <label>Nama Penyewa</label>
            <input type="text" name="nama_penyewa" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal Sewa</label>
            <input type="date" name="tanggal_sewa" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>

    <!-- Tabel Penyewaan -->
    <h4>Data Barang yang Disewa</h4>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Nama Barang</th>
                <th>Tanggal Sewa</th>
                <th>Tanggal Kembali</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($penyewaan->num_rows > 0): 
                $no = 1;
                while ($row = $penyewaan->fetch_assoc()):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_penyewa']) ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td><?= $row['tanggal_sewa'] ?></td>
                <td><?= $row['tanggal_kembali'] ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                <td>
                    <a href="edit_penyewaan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="hapus_penyewaan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; else: ?>
            <tr>
                <td colspan="7" class="text-center">Belum ada data penyewaan.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
