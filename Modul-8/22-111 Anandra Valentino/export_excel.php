<?php
require 'koneksi.php';
require 'auth.php';
wajibLogin();
require 'fungsi.php';

$mulai   = $_GET['mulai']   ?? '';
$selesai = $_GET['selesai'] ?? '';
if (!validTanggal($mulai) || !validTanggal($selesai) || $mulai > $selesai) {
    http_response_code(400);
    die("Rentang tanggal tidak valid.");
}

$rekap = ambilRekap($conn, $mulai, $selesai);
$ring  = ambilRingkasan($conn, $mulai, $selesai);

// HTTP Response Header: browser diminta mengunduh respon sebagai file Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"rekap_penjualan_{$mulai}_sd_{$selesai}.xls\"");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html><head><meta charset="utf-8"></head><body>
<h3>Rekap Laporan Penjualan <?= $mulai ?> sampai <?= $selesai ?></h3>
<table border="1">
<tr><th>No</th><th>Total Pendapatan (Rp)</th><th>Tanggal Transaksi</th></tr>
<?php foreach ($rekap as $i => $r): ?>
<tr>
  <td><?= $i + 1 ?></td>
  <td><?= (int)$r['total_harian'] ?></td>
  <td><?= $r['tgl'] ?></td>
</tr>
<?php endforeach; ?>
<tr><td colspan="2"><b>Jumlah Pelanggan (unik)</b></td><td><?= (int)$ring['jml_pelanggan'] ?> Orang</td></tr>
<tr><td colspan="2"><b>Jumlah Pendapatan</b></td><td><?= (int)$ring['total_pendapatan'] ?></td></tr>
</table>
</body></html>
