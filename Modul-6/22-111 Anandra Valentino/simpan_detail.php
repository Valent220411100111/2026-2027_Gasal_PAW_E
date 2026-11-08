<?php
require 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: index.php"); exit; }

$tid = (int)$_POST['transaksi_id'];
$bid = (int)($_POST['barang_id'] ?? 0);
$qty = (int)($_POST['qty'] ?? 0);
$url = "detail.php?id=" . $tid;

if ($bid <= 0 || $qty <= 0) {
    kembali($url, "Pilih barang dan isi qty minimal 1.");
}

try {
    $conn->begin_transaction();

    // 1. harga diambil dari tabel barang (bukan dari input pengguna)
    $stmt = $conn->prepare("SELECT harga FROM barang WHERE id = ?");
    $stmt->bind_param("i", $bid);
    $stmt->execute();
    $barang = $stmt->get_result()->fetch_assoc();
    if (!$barang) {
        $conn->rollback();
        kembali($url, "Barang tidak ditemukan.");
    }

    // 2. tolak barang yang sudah ada di transaksi ini (validasi sisi server)
    $stmt = $conn->prepare("SELECT 1 FROM transaksi_detail WHERE transaksi_id = ? AND barang_id = ?");
    $stmt->bind_param("ii", $tid, $bid);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $conn->rollback();
        kembali($url, "Barang tersebut sudah ada pada transaksi ini.");
    }

    // 3. simpan detail transaksi
    $harga = (int)$barang['harga'];
    $stmt = $conn->prepare("INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES (?,?,?,?)");
    $stmt->bind_param("iiii", $tid, $bid, $harga, $qty);
    $stmt->execute();

    // 4. hitung ulang total = jumlah (harga x qty) seluruh detail transaksi ini
    $stmt = $conn->prepare("UPDATE transaksi
                            SET total = (SELECT COALESCE(SUM(harga * qty), 0)
                                         FROM transaksi_detail WHERE transaksi_id = ?)
                            WHERE id = ?");
    $stmt->bind_param("ii", $tid, $tid);
    $stmt->execute();

    $conn->commit();
    kembali($url, "Detail tersimpan dan total transaksi diperbarui.", 'ok');
} catch (mysqli_sql_exception $e) {
    $conn->rollback();
    kembali($url, "Detail transaksi gagal disimpan.");
}
?>
