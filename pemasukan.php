<?php
include 'config.php';
include 'auth.php';

// Simpan data jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
   $harga_barang = $_POST['harga_barang'];
$keterangan = $_POST['keterangan'];


   $stmt = $conn->prepare("INSERT INTO pemasukan_barang (nama_barang, jumlah, tanggal_masuk, harga_barang, keterangan) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sisis", $nama_barang, $jumlah, $tanggal_masuk, $harga_barang, $keterangan);
 $stmt->execute();
    $stmt->close();

    // Redirect kembali ke halaman ini
    header("Location: pemasukan.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pemasukan Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Pemasukan Barang ke Gudang</h2>

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
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control" required>
        </div>
        <div class="form-group">
    <label>Harga Barang</label>
    <input type="number" name="harga_barang" class="form-control" required>
</div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>

    <h4>Riwayat Pemasukan Barang</h4>
    <table class="table table-bordered table-striped">
     <thead class="thead-dark">
    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Harga per Item</th>
        <th>Tanggal Masuk</th>
        <th>Keterangan</th>
    </tr>
</thead>

        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM pemasukan_barang ORDER BY tanggal_masuk DESC");
            $no = 1;
            while ($row = $result->fetch_assoc()) {
             echo "<tr>
        <td>{$no}</td>
        <td>" . htmlspecialchars($row['nama_barang']) . "</td>
        <td>{$row['jumlah']}</td>
        <td>Rp " . number_format($row['harga_barang'], 0, ',', thousands_separator: '.') . "</td>
        <td>{$row['tanggal_masuk']}</td>
        <td>" . htmlspecialchars($row['keterangan']) . "</td>
    </tr>";

                $no++;
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
