<?php $lv = (int)($_SESSION['level'] ?? 0); ?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8">
<title><?= e($judul) ?> - Sistem Penjualan</title>
<style>
body{font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#333;margin:0;background:#fff}
.nav{background:linear-gradient(#0b5aa8,#07305f);height:48px;position:relative}
.nav a{color:#fff;text-decoration:none}
.nav .brand{float:left;color:#fff;line-height:48px;padding:0 20px 0 16px;font-weight:bold}
.nav > a,.dd > a{float:left;line-height:48px;padding:0 16px;display:block}
.nav > a:hover,.dd > a:hover{background:rgba(255,255,255,.15)}
.dd{float:left;position:relative}
.dd-menu{display:none;position:absolute;left:0;top:48px;background:#07305f;min-width:180px;z-index:10}
.dd-menu a{display:block;line-height:38px;padding:0 16px}
.dd-menu a:hover{background:#0b5aa8}
.dd:hover .dd-menu,.dd:focus-within .dd-menu{display:block}
.kanan-nav{float:right}
.kanan-nav .dd-menu{left:auto;right:0}
.wrap{width:900px;max-width:94%;margin:20px auto}
h2{color:#3a87ad;font-weight:normal;font-size:24px;margin:0;display:inline-block}
h2 small{font-size:14px;color:#777}
h3{color:#3a87ad;font-weight:normal;font-size:20px;margin:24px 0 10px}
.top{border-bottom:1px solid #eee;padding-bottom:12px;margin-bottom:18px;overflow:hidden}
.top a.btn{float:right}
.btn{display:inline-block;padding:6px 12px;color:#fff;border:0;border-radius:3px;font-size:13px;cursor:pointer;text-decoration:none}
.hijau{background:#62a82b}.oranye{background:#e0600c}.merah{background:#c9202b}.biru{background:#2a7ab9}
table{width:100%;border-collapse:collapse;border:1px solid #ddd}
th{background:#d9edf7;text-align:left;padding:10px 8px}
td{padding:10px 8px;border-top:1px solid #ddd}
.kanan{text-align:right}
.master td{border:0;padding:5px 8px}
.master td:first-child{width:140px;font-weight:bold}
.form-row{margin:14px 0;display:flex;align-items:center}
.form-row label{width:180px;text-align:right;padding-right:16px;font-weight:bold}
.form-row input,.form-row select,.form-row textarea{padding:8px;border:1px solid #ccc;border-radius:4px;width:316px;box-sizing:border-box;font-family:inherit;font-size:14px}
.aksi{margin-left:196px}
.err{background:#f2dede;color:#a94442;padding:10px;margin-bottom:12px;border-radius:3px}
.ok{background:#dff0d8;color:#3c763d;padding:10px;margin-bottom:12px;border-radius:3px}
.info{background:#d9edf7;color:#31708f;padding:10px;margin-bottom:12px;border-radius:3px}
.kartu{display:flex;gap:14px;flex-wrap:wrap;margin-top:18px}
.kartu div{flex:1;min-width:170px;background:#d9edf7;border-radius:4px;padding:14px}
.kartu b{display:block;font-size:24px;color:#07305f}
.filter{background:#f5f5f5;border:1px solid #ddd;padding:12px;border-radius:4px;margin-bottom:14px}
.filter input{padding:6px;border:1px solid #ccc;border-radius:3px;margin:0 12px 0 4px}
.tombol-lap{margin-bottom:12px}
.chart-box{position:relative;width:100%;height:320px}
table.ringkasan{width:50%;margin-top:18px}
@media print {
  .no-print{display:none !important}
  body{margin:0}
  .wrap{width:100%;margin:0}
  *{-webkit-print-color-adjust:exact;print-color-adjust:exact}
}
</style></head><body>
<div class="nav no-print">
  <span class="brand">Sistem Penjualan</span>
  <a href="index.php">Home</a>
  <?php if ($lv === 1): ?>
  <div class="dd"><a href="#">Data Master &#9662;</a>
    <div class="dd-menu">
      <a href="barang.php">Data Barang</a>
      <a href="supplier.php">Data Supplier</a>
      <a href="pelanggan.php">Data Pelanggan</a>
      <a href="user.php">Data User</a>
    </div>
  </div>
  <?php endif; ?>
  <a href="transaksi.php">Transaksi</a>
  <a href="laporan.php">Laporan</a>
  <div class="dd kanan-nav"><a href="#"><?= e($_SESSION['nama'] ?? '') ?> &#9662;</a>
    <div class="dd-menu"><a href="logout.php">Logout</a></div>
  </div>
</div>
<div class="wrap">
