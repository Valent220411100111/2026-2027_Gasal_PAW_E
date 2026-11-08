<?php
require 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: index.php"); exit; }
$tid = (int)$_POST['transaksi_id'];
$bid = (int)$_POST['barang_id'];
$url = "detail.php?id=" . $tid;
try {
    $conn->begin_transaction();
    $stmt = $conn->prepare("DELETE FROM transaksi_detail WHERE transaksi_id=? AND barang_id=?");
    $stmt->bind_param("ii", $tid, $bid);
    $stmt->execute();
    // total dihitung ulang agar tetap sesuai dengan isi detail
    $stmt = $conn->prepare("UPDATE transaksi SET total = (SELECT COALESCE(SUM(harga * qty), 0)
                            FROM transaksi_detail WHERE transaksi_id = ?) WHERE id = ?");
    $stmt->bind_param("ii", $tid, $tid);
    $stmt->execute();
    $conn->commit();
    kembali($url, "Barang dihapus dari transaksi dan total diperbarui.", 'ok');
} catch (mysqli_sql_exception $e) {
    $conn->rollback();
    kembali($url, "Barang gagal dihapus dari transaksi.");
}
?>
