<?php
include 'config.php';
include 'auth.php';

$id = $_GET['id'];
$hapus = $conn->query("DELETE FROM pengeluaran_barang WHERE id = $id");

if ($hapus) {
    header("Location: pengeluaran.php");
    exit();
} else {
    echo "Gagal menghapus data: " . $conn->error;
}
?>
