<?php
require 'koneksi.php';
require 'auth.php';
wajibLogin();

function hitung($conn, $tabel) {
    return (int)$conn->query("SELECT COUNT(*) FROM `$tabel`")->fetch_row()[0];
}
$jmlTransaksi = hitung($conn, 'transaksi');
$totalOmzet   = (int)$conn->query("SELECT COALESCE(SUM(total),0) FROM transaksi")->fetch_row()[0];

$judul = "Home";
include 'header.php';
?>
<div class="top"><h2>Selamat Datang, <?= e($_SESSION['nama']) ?></h2></div>
<p>Anda login sebagai <b><?= e(namaLevel($_SESSION['level'])) ?></b> (username: <?= e($_SESSION['username']) ?>).</p>
<div class="kartu">
  <div>Jumlah Transaksi<b><?= $jmlTransaksi ?></b></div>
  <div>Total Pendapatan<b>Rp. <?= number_format($totalOmzet, 0, ',', '.') ?></b></div>
<?php if ((int)$_SESSION['level'] === 1): ?>
  <div>Data Barang<b><?= hitung($conn, 'barang') ?></b></div>
  <div>Data Supplier<b><?= hitung($conn, 'supplier') ?></b></div>
  <div>Data Pelanggan<b><?= hitung($conn, 'pelanggan') ?></b></div>
  <div>Data User<b><?= hitung($conn, 'user') ?></b></div>
<?php endif; ?>
</div>
</div></body></html>
