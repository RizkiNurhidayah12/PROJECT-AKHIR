<?php include 'config.php'; include 'auth.php';
$id = $_GET['id'];
$conn->query("DELETE FROM pemasukan_barang WHERE id=$id");
header("Location: dashboard.php");
?>