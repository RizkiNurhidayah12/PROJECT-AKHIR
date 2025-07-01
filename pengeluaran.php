<?php
include 'config.php';
include 'auth.php';

// Menyimpan data jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $tanggal_keluar = $_POST['tanggal_keluar'];
    $keterangan = $_POST['keterangan'];

    $stmt = $conn->prepare("INSERT INTO pengeluaran_barang (nama_barang, jumlah, tanggal_keluar, keterangan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $nama_barang, $jumlah, $tanggal_keluar, $keterangan);
    $stmt->execute();
    $stmt->close();

    header("Location: pengeluaran.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengeluaran Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Pengeluaran Barang dari Gudang</h2>

    <form method="POST" class="mb-4">
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>

    <h4>Riwayat Pengeluaran Barang</h4>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Keluar</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM pengeluaran_barang ORDER BY tanggal_keluar DESC");
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>" . htmlspecialchars($row['nama_barang']) . "</td>
                        <td>{$row['jumlah']}</td>
                        <td>{$row['tanggal_keluar']}</td>
                        <td>" . htmlspecialchars($row['keterangan']) . "</td>
                        <td>
                            <a href='edit_pengeluaran.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='hapus_pengeluaran.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
                        </td>
                    </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
