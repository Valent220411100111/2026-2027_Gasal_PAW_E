<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: pelanggan.php"); exit; }
csrfCek();
$id = $_POST['id'] ?? '';

try {
    // pelanggan yang sudah punya transaksi tidak boleh dihapus
    $stmt = $conn->prepare("SELECT COUNT(*) FROM transaksi WHERE pelanggan_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $jml = (int)$stmt->get_result()->fetch_row()[0];
    if ($jml > 0) {
        kembali("pelanggan.php", "Pelanggan tidak dapat dihapus karena sudah memiliki $jml transaksi.");
    }
    $stmt = $conn->prepare("DELETE FROM pelanggan WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    kembali("pelanggan.php", "Pelanggan berhasil dihapus.", 'ok');
} catch (mysqli_sql_exception $e) {
    kembali("pelanggan.php", "Pelanggan gagal dihapus.");
}
