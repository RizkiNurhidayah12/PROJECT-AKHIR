<?php
include 'config.php';
include 'auth.php';

$id = $_GET['id'];
$hapus = $conn->query("DELETE FROM penyewaan WHERE id = $id");

if ($hapus) {
    header("Location: penyewaan.php");
    exit;
} else {
    echo "Gagal menghapus data: " . $conn->error;
}
?>
