<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);

// kode pelanggan (id) bertipe teks. Mode edit: kode lama dibawa lewat parameter id / id_lama
$idLama = $_GET['id'] ?? $_POST['id_lama'] ?? '';
$edit   = ($idLama !== '');
$data   = ['id' => $idLama, 'nama' => '', 'jenis_kelamin' => 'L', 'telp' => '', 'alamat' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCek();
    $data = [
        'id'            => $edit ? $idLama : trim($_POST['id'] ?? ''),
        'nama'          => trim($_POST['nama'] ?? ''),
        'jenis_kelamin' => $_POST['jenis_kelamin'] ?? '',
        'telp'          => trim($_POST['telp'] ?? ''),
        'alamat'        => trim($_POST['alamat'] ?? ''),
    ];
    if (!preg_match('/^[A-Za-z0-9_-]{1,20}$/', $data['id']))
        $errors[] = "Kode pelanggan wajib diisi (huruf/angka, maksimal 20 karakter).";
    if ($data['nama'] === '')                $errors[] = "Nama wajib diisi.";
    elseif (mb_strlen($data['nama']) > 100)  $errors[] = "Nama maksimal 100 karakter.";
    if (!in_array($data['jenis_kelamin'], ['L', 'P'], true))
        $errors[] = "Jenis kelamin harus L atau P.";
    if ($data['telp'] !== '' && !preg_match('/^[0-9+\-]{5,12}$/', $data['telp']))
        $errors[] = "Telp hanya berisi angka, 5 sampai 12 karakter.";

    if (!$errors) {
        try {
            if ($edit) {
                $stmt = $conn->prepare("UPDATE pelanggan SET nama=?, jenis_kelamin=?, telp=?, alamat=? WHERE id=?");
                $stmt->bind_param("sssss", $data['nama'], $data['jenis_kelamin'], $data['telp'], $data['alamat'], $idLama);
            } else {
                $stmt = $conn->prepare("INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES (?,?,?,?,?)");
                $stmt->bind_param("sssss", $data['id'], $data['nama'], $data['jenis_kelamin'], $data['telp'], $data['alamat']);
            }
            $stmt->execute();
            kembali("pelanggan.php", "Data pelanggan berhasil disimpan.", 'ok');
        } catch (mysqli_sql_exception $e) {
            $errors[] = ($e->getCode() === 1062) ? "Kode pelanggan sudah dipakai." : "Data gagal disimpan.";
        }
    }
} elseif ($edit) {
    $stmt = $conn->prepare("SELECT id, nama, jenis_kelamin, telp, alamat FROM pelanggan WHERE id=?");
    $stmt->bind_param("s", $idLama);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) kembali("pelanggan.php", "Data pelanggan tidak ditemukan.");
    $data = $row;
}

$judul = $edit ? "Edit Data Master Pelanggan" : "Tambah Data Master Pelanggan Baru";
include 'header.php';
?>
<div class="top"><h2 style="font-size:30px"><?= e($judul) ?></h2></div>
<?php if ($errors): ?><div class="err"><?php foreach ($errors as $m) echo e($m) . '<br>'; ?></div><?php endif; ?>
<form method="post">
  <?= csrfField() ?>
  <input type="hidden" name="id_lama" value="<?= e($idLama) ?>">
  <div class="form-row"><label>Kode</label>
    <input type="text" name="id" value="<?= e($data['id']) ?>" placeholder="mis. P011" maxlength="20"
           <?= $edit ? 'readonly' : 'required' ?>></div>
  <div class="form-row"><label>Nama</label>
    <input type="text" name="nama" value="<?= e($data['nama']) ?>" placeholder="Nama" maxlength="100" required></div>
  <div class="form-row"><label>Jenis Kelamin</label>
    <select name="jenis_kelamin">
      <option value="L" <?= $data['jenis_kelamin'] === 'L' ? 'selected' : '' ?>>L (Laki-laki)</option>
      <option value="P" <?= $data['jenis_kelamin'] === 'P' ? 'selected' : '' ?>>P (Perempuan)</option>
    </select></div>
  <div class="form-row"><label>Telp</label>
    <input type="text" name="telp" value="<?= e($data['telp']) ?>" placeholder="telp" maxlength="12"></div>
  <div class="form-row"><label>Alamat</label>
    <input type="text" name="alamat" value="<?= e($data['alamat']) ?>" placeholder="alamat"></div>
  <div class="aksi"><button class="btn hijau" type="submit"><?= $edit ? 'Update' : 'Simpan' ?></button>
  <a class="btn merah" href="pelanggan.php">Batal</a></div>
</form>
</div></body></html>
