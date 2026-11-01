<?php
require 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id']; $nama = trim($_POST['nama']);
    $telp = trim($_POST['telp']); $alamat = trim($_POST['alamat']);
    $stmt = $conn->prepare("UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?");
    $stmt->bind_param("sssi", $nama, $telp, $alamat, $id);
    $stmt->execute();
    header("Location: index.php"); exit;
}
$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM supplier WHERE id=?");
$stmt->bind_param("i", $id); $stmt->execute();
$r = $stmt->get_result()->fetch_assoc();
if (!$r) { header("Location: index.php"); exit; }
$judul = "Edit Data Master Supplier";
include 'header.php';
?>
<div class="top"><h2 style="font-size:30px">Edit Data Master Supplier</h2></div>
<form method="post">
  <input type="hidden" name="id" value="<?= $r['id'] ?>">
  <div class="form-row"><label>Nama</label><input type="text" name="nama" value="<?= htmlspecialchars($r['nama']) ?>" required maxlength="100"></div>
  <div class="form-row"><label>Telp</label><input type="text" name="telp" value="<?= htmlspecialchars($r['telp']) ?>" maxlength="12"></div>
  <div class="form-row"><label>Alamat</label><input type="text" name="alamat" value="<?= htmlspecialchars($r['alamat']) ?>"></div>
  <div class="aksi"><button class="btn hijau" type="submit">Update</button>
  <a class="btn merah" href="index.php">Batal</a></div>
</form>
</div></body></html>
