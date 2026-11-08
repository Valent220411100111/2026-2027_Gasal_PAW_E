<?php
require 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: barang.php"); exit; }
$id = (int)$_POST['id'];

try {
    // 1. cek apakah barang sudah dipakai pada transaksi_detail
    $stmt = $conn->prepare("SELECT COUNT(*) AS jml FROM transaksi_detail WHERE barang_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $jml = (int)$stmt->get_result()->fetch_assoc()['jml'];

    if ($jml > 0) {
        // 2a. sudah dipakai -> batalkan penghapusan, tampilkan notifikasi
        kembali("barang.php", "Barang tidak dapat dihapus karena masih digunakan pada $jml transaksi.");
    }

    // 2b. belum dipakai -> hapus seperti biasa
    $stmt = $conn->prepare("DELETE FROM barang WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    kembali("barang.php", "Barang berhasil dihapus.", 'ok');
} catch (mysqli_sql_exception $e) {
    kembali("barang.php", "Barang gagal dihapus.");
}
?>
