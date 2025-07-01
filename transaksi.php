<?php
include 'config.php';
include 'auth.php';

// Ambil semua transaksi yang sudah dikembalikan (status = 'Selesai')
$sql = "SELECT 
            py.nama_penyewa, 
            py.nama_barang, 
            py.tanggal_sewa, 
            py.tanggal_kembali,
            pg.tanggal_pengembalian,
            pg.status
        FROM penyewaan py
        JOIN pengembalian pg ON py.id = pg.id_penyewaan
        WHERE pg.status = 'Selesai'
        ORDER BY pg.tanggal_pengembalian DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi Penyewaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Riwayat Transaksi Penyewaan Barang (Selesai)</h3>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Nama Barang</th>
                <th>Tanggal Sewa</th>
                <th>Tanggal Kembali (Estimasi)</th>
                <th>Tanggal Pengembalian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): 
                $no = 1;
                while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_penyewa']) ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td><?= $row['tanggal_sewa'] ?></td>
                <td><?= $row['tanggal_kembali'] ?></td>
                <td><?= $row['tanggal_pengembalian'] ?></td>
                <td><span class="badge badge-success"><?= $row['status'] ?></span></td>
            </tr>
            <?php endwhile; else: ?>
            <tr>
                <td colspan="7" class="text-center">Belum ada transaksi yang selesai.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
