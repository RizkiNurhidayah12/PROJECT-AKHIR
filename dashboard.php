<?php include 'config.php'; include 'auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Inventory</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar {
            height: 100vh; background-color: #343a40; padding: 20px; color: #fff;
        }
        .sidebar a {
            display: block; color: #fff; margin: 10px 0; text-decoration: none;
        }
        .sidebar a:hover { text-decoration: underline; }
        .dashboard-content { padding: 30px; }
        .dashboard-card {
            background-color: #fff; border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05); padding: 30px; margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <h4>Menu</h4>
                <a href="dashboard.php">🏠 Dashboard</a>
                <a href="pemasukan.php">📦 Pemasukan Barang</a>
                <a href="pengeluaran.php">📤 Pengeluaran Barang</a>
                <a href="penyewaan.php">📝 Penyewaan Barang</a>
                <a href="pengembalian.php">↩️ Pengembalian Barang</a>
                <a href="transaksi.php">📑 Data Transaksi</a>
                <a href="logout.php" class="btn btn-danger mt-4 btn-sm">Logout</a>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 dashboard-content">
                <div class="dashboard-card">
                    <h4 class="mb-4">📦 Data Barang Masuk ke Gudang</h4>
                    <a href="pemasukan.php" class="btn btn-success btn-sm mb-3">+ Tambah Pemasukan</a>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Masuk</th>
                                <th>Tanggal Masuk</th>
                                <th>Harga</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = "SELECT * FROM pemasukan_barang ORDER BY tanggal_masuk DESC";
                            $masuk = $conn->query($query);
                            if (!$masuk) {
                                die("Query gagal: " . $conn->error);
                            }
                            while ($row = $masuk->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>" . htmlspecialchars($row['nama_barang']) . "</td>
                                    <td>{$row['jumlah']}</td>
                                            <td>Rp " . number_format($row['harga_barang'], 0, ',', thousands_separator: '.') . "</td>
                                    <td>{$row['tanggal_masuk']}</td>
                                    <td>" . htmlspecialchars($row['keterangan']) . "</td>
                                    <td>
                                        <a href='edit_pemasukan.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='hapus_pemasukan.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
                                    </td>
                                </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
