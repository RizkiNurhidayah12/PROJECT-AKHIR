<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "inventory_db";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>