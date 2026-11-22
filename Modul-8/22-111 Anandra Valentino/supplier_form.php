<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);

$id     = (int)($_GET['id'] ?? $_POST['id'] ?? 0);   // 0 = tambah baru, >0 = edit
$data   = ['nama' => '', 'telp' => '', 'alamat' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCek();
    $data = [
        'nama'   => trim($_POST['nama']   ?? ''),
        'telp'   => trim($_POST['telp']   ?? ''),
        'alamat' => trim($_POST['alamat'] ?? ''),
    ];
    if ($data['nama'] === '')                    $errors[] = "Nama wajib diisi.";
    elseif (mb_strlen($data['nama']) > 100)      $errors[] = "Nama maksimal 100 karakter.";
    if ($data['telp'] !== '' && !preg_match('/^[0-9+\-]{5,12}$/', $data['telp']))
        $errors[] = "Telp hanya berisi angka, 5 sampai 12 karakter.";

    if (!$errors) {
        try {
            if ($id > 0) {
                $stmt = $conn->prepare("UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?");
                $stmt->bind_param("sssi", $data['nama'], $data['telp'], $data['alamat'], $id);
            } else {
                $stmt = $conn->prepare("INSERT INTO supplier (nama, telp, alamat) VALUES (?,?,?)");
                $stmt->bind_param("sss", $data['nama'], $data['telp'], $data['alamat']);
            }
            $stmt->execute();
            kembali("supplier.php", "Data supplier berhasil disimpan.", 'ok');
        } catch (mysqli_sql_exception $e) {
            $errors[] = "Data gagal disimpan.";
        }
    }
} elseif ($id > 0) {
    $stmt = $conn->prepare("SELECT nama, telp, alamat FROM supplier WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) kembali("supplier.php", "Data supplier tidak ditemukan.");
    $data = $row;
}

$judul = ($id > 0) ? "Edit Data Master Supplier" : "Tambah Data Master Supplier Baru";
include 'header.php';
?>
<div class="top"><h2 style="font-size:30px"><?= e($judul) ?></h2></div>
<?php if ($errors): ?><div class="err"><?php foreach ($errors as $m) echo e($m) . '<br>'; ?></div><?php endif; ?>
<form method="post">
  <?= csrfField() ?>
  <input type="hidden" name="id" value="<?= $id ?>">
  <div class="form-row"><label>Nama</label>
    <input type="text" name="nama" value="<?= e($data['nama']) ?>" placeholder="Nama" maxlength="100" required></div>
  <div class="form-row"><label>Telp</label>
    <input type="text" name="telp" value="<?= e($data['telp']) ?>" placeholder="telp" maxlength="12"></div>
  <div class="form-row"><label>Alamat</label>
    <input type="text" name="alamat" value="<?= e($data['alamat']) ?>" placeholder="alamat"></div>
  <div class="aksi"><button class="btn hijau" type="submit"><?= $id > 0 ? 'Update' : 'Simpan' ?></button>
  <a class="btn merah" href="supplier.php">Batal</a></div>
</form>
</div></body></html>
