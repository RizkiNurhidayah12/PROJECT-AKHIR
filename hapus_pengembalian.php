<?php
include 'config.php';
include 'auth.php';

$id = $_GET['id'];
$hapus = $conn->query("DELETE FROM pengembalian WHERE id = $id");

if ($hapus) {
    header("Location: pengembalian.php");
    exit;
} else {
    echo "Gagal menghapus data: " . $conn->error;
}
?>
