<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8">
<title><?= htmlspecialchars($judul) ?></title>
<style>
body{font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#333;margin:0;background:#fff}
.nav{background:linear-gradient(#0b5aa8,#07305f);height:48px}
.nav a{float:left;color:#fff;line-height:48px;padding:0 18px;text-decoration:none}
.nav a:hover{background:rgba(255,255,255,.15)}
.wrap{width:900px;max-width:94%;margin:20px auto}
h2{color:#3a87ad;font-weight:normal;font-size:24px;margin:0;display:inline-block}
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
.form-row input,.form-row select{padding:8px;border:1px solid #ccc;border-radius:4px;width:316px;box-sizing:border-box}
.aksi{margin-left:196px}
.err{background:#f2dede;color:#a94442;padding:10px;margin-bottom:12px;border-radius:3px}
.ok{background:#dff0d8;color:#3c763d;padding:10px;margin-bottom:12px;border-radius:3px}
</style></head><body>
<div class="nav"><a href="index.php">Transaksi</a><a href="barang.php">Barang</a></div><div class="wrap">
