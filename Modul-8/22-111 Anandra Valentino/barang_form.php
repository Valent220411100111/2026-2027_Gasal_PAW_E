<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);

$id     = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$data   = ['kode_barang' => '', 'nama_barang' => '', 'harga' => '', 'stok' => '', 'supplier_id' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCek();
    foreach ($data as $k => $v) $data[$k] = trim($_POST[$k] ?? '');

    if (!preg_match('/^[A-Za-z0-9_-]{1,10}$/', $data['kode_barang']))
        $errors[] = "Kode barang wajib diisi (huruf/angka, maksimal 10 karakter).";
    if ($data['nama_barang'] === '')               $errors[] = "Nama barang wajib diisi.";
    elseif (mb_strlen($data['nama_barang']) > 100) $errors[] = "Nama barang maksimal 100 karakter.";
    if (!ctype_digit($data['harga']))              $errors[] = "Harga harus berupa angka bulat 0 atau lebih.";
    if (!ctype_digit($data['stok']))               $errors[] = "Stok harus berupa angka bulat 0 atau lebih.";
    if (!ctype_digit($data['supplier_id']))        $errors[] = "Supplier wajib dipilih.";

    if (!$errors) {
        $harga = (int)$data['harga'];
        $stok  = (int)$data['stok'];
        $sup   = (int)$data['supplier_id'];
        try {
            if ($id > 0) {
                $stmt = $conn->prepare("UPDATE barang SET kode_barang=?, nama_barang=?, harga=?, stok=?, supplier_id=? WHERE id=?");
                $stmt->bind_param("ssiiii", $data['kode_barang'], $data['nama_barang'], $harga, $stok, $sup, $id);
            } else {
                $stmt = $conn->prepare("INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES (?,?,?,?,?)");
                $stmt->bind_param("ssiii", $data['kode_barang'], $data['nama_barang'], $harga, $stok, $sup);
            }
            $stmt->execute();
            kembali("barang.php", "Data barang berhasil disimpan.", 'ok');
        } catch (mysqli_sql_exception $e) {
            $errors[] = ($e->getCode() === 1062) ? "Kode barang sudah dipakai." : "Data gagal disimpan.";
        }
    }
} elseif ($id > 0) {
    $stmt = $conn->prepare("SELECT kode_barang, nama_barang, harga, stok, supplier_id FROM barang WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) kembali("barang.php", "Data barang tidak ditemukan.");
    $data = $row;
}

$judul = ($id > 0) ? "Edit Data Master Barang" : "Tambah Data Master Barang Baru";
include 'header.php';
?>
<div class="top"><h2 style="font-size:30px"><?= e($judul) ?></h2></div>
<?php if ($errors): ?><div class="err"><?php foreach ($errors as $m) echo e($m) . '<br>'; ?></div><?php endif; ?>
<form method="post">
  <?= csrfField() ?>
  <input type="hidden" name="id" value="<?= $id ?>">
  <div class="form-row"><label>Kode Barang</label>
    <input type="text" name="kode_barang" value="<?= e($data['kode_barang']) ?>" placeholder="mis. BRG013" maxlength="10" required></div>
  <div class="form-row"><label>Nama Barang</label>
    <input type="text" name="nama_barang" value="<?= e($data['nama_barang']) ?>" placeholder="Nama barang" maxlength="100" required></div>
  <div class="form-row"><label>Harga</label>
    <input type="number" name="harga" value="<?= e($data['harga']) ?>" min="0" required></div>
  <div class="form-row"><label>Stok</label>
    <input type="number" name="stok" value="<?= e($data['stok']) ?>" min="0" required></div>
  <div class="form-row"><label>Supplier</label>
    <select name="supplier_id" required>
      <option value="">-- pilih supplier --</option>
      <?php $q = $conn->query("SELECT id, nama FROM supplier ORDER BY nama");
      while ($s = $q->fetch_assoc()): ?>
      <option value="<?= (int)$s['id'] ?>" <?= (string)$data['supplier_id'] === (string)$s['id'] ? 'selected' : '' ?>><?= e($s['nama']) ?></option>
      <?php endwhile; ?>
    </select></div>
  <div class="aksi"><button class="btn hijau" type="submit"><?= $id > 0 ? 'Update' : 'Simpan' ?></button>
  <a class="btn merah" href="barang.php">Batal</a></div>
</form>
</div></body></html>
