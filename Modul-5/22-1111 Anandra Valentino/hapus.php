<?php
require 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    try {
        $stmt = $conn->prepare("DELETE FROM supplier WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: index.php");
    } catch (mysqli_sql_exception $e) {
        // supplier masih dipakai oleh tabel barang (foreign key)
        header("Location: index.php?pesan=" . urlencode("Supplier tidak bisa dihapus karena masih dipakai data barang."));
    }
}
exit;
