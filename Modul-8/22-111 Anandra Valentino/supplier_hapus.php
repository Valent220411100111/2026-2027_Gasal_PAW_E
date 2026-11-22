<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: supplier.php"); exit; }
csrfCek();
$id = (int)$_POST['id'];

try {
    // supplier yang masih memasok barang tidak boleh dihapus
    $stmt = $conn->prepare("SELECT COUNT(*) FROM barang WHERE supplier_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $jml = (int)$stmt->get_result()->fetch_row()[0];
    if ($jml > 0) {
        kembali("supplier.php", "Supplier tidak dapat dihapus karena masih memasok $jml barang.");
    }
    $stmt = $conn->prepare("DELETE FROM supplier WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    kembali("supplier.php", "Supplier berhasil dihapus.", 'ok');
} catch (mysqli_sql_exception $e) {
    kembali("supplier.php", "Supplier gagal dihapus.");
}
