<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: barang.php"); exit; }
csrfCek();
$id = (int)$_POST['id'];

try {
    // barang yang sudah dipakai pada transaksi_detail tidak boleh dihapus
    $stmt = $conn->prepare("SELECT COUNT(*) FROM transaksi_detail WHERE barang_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $jml = (int)$stmt->get_result()->fetch_row()[0];
    if ($jml > 0) {
        kembali("barang.php", "Barang tidak dapat dihapus karena masih digunakan pada $jml transaksi.");
    }
    $stmt = $conn->prepare("DELETE FROM barang WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    kembali("barang.php", "Barang berhasil dihapus.", 'ok');
} catch (mysqli_sql_exception $e) {
    kembali("barang.php", "Barang gagal dihapus.");
}
