<?php
require 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']); $telp = trim($_POST['telp']); $alamat = trim($_POST['alamat']);
    $stmt = $conn->prepare("INSERT INTO supplier (nama, telp, alamat) VALUES (?,?,?)");
    $stmt->bind_param("sss", $nama, $telp, $alamat);
    $stmt->execute();
    header("Location: index.php"); exit;
}
$judul = "Tambah Data Master Supplier Baru";
include 'header.php';
?>
<div class="top"><h2 style="font-size:30px">Tambah Data Master Supplier Baru</h2></div>
<form method="post">
  <div class="form-row"><label>Nama</label><input type="text" name="nama" placeholder="Nama" required maxlength="100"></div>
  <div class="form-row"><label>Telp</label><input type="text" name="telp" placeholder="telp" maxlength="12"></div>
  <div class="form-row"><label>Alamat</label><input type="text" name="alamat" placeholder="alamat"></div>
  <div class="aksi"><button class="btn hijau" type="submit">Simpan</button>
  <a class="btn merah" href="index.php">Batal</a></div>
</form>
</div></body></html>
