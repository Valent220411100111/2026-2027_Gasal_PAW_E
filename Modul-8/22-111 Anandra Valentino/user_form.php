<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);

$id     = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$self   = ($id > 0 && $id === (int)$_SESSION['id_user']);   // sedang mengedit akun sendiri
$data   = ['username' => '', 'nama' => '', 'alamat' => '', 'hp' => '', 'level' => 2];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCek();
    $password = $_POST['password'] ?? '';
    $data = [
        'username' => trim($_POST['username'] ?? ''),
        'nama'     => trim($_POST['nama'] ?? ''),
        'alamat'   => trim($_POST['alamat'] ?? ''),
        'hp'       => trim($_POST['hp'] ?? ''),
        // level akun sendiri tidak boleh diubah agar owner tidak mengunci dirinya sendiri
        'level'    => $self ? (int)$_SESSION['level'] : (int)($_POST['level'] ?? 0),
    ];
    if (!preg_match('/^[A-Za-z0-9_.]{3,30}$/', $data['username']))
        $errors[] = "Username 3 sampai 30 karakter (huruf, angka, titik, atau garis bawah).";
    if ($data['nama'] === '')                   $errors[] = "Nama wajib diisi.";
    elseif (mb_strlen($data['nama']) > 50)      $errors[] = "Nama maksimal 50 karakter.";
    if (mb_strlen($data['alamat']) > 150)       $errors[] = "Alamat maksimal 150 karakter.";
    if ($data['hp'] !== '' && !preg_match('/^[0-9+\-]{5,20}$/', $data['hp']))
        $errors[] = "HP hanya berisi angka, 5 sampai 20 karakter.";
    if (!in_array($data['level'], [1, 2], true)) $errors[] = "Level harus 1 (Owner) atau 2 (Kasir).";
    if ($id === 0 && $password === '')         $errors[] = "Password wajib diisi.";
    if ($password !== '' && strlen($password) < 6) $errors[] = "Password minimal 6 karakter.";

    if (!$errors) {
        try {
            if ($id > 0 && $password === '') {            // edit tanpa ganti password
                $stmt = $conn->prepare("UPDATE `user` SET username=?, nama=?, alamat=?, hp=?, level=? WHERE id_user=?");
                $stmt->bind_param("ssssii", $data['username'], $data['nama'], $data['alamat'], $data['hp'], $data['level'], $id);
            } elseif ($id > 0) {                          // edit dan ganti password
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE `user` SET username=?, password=?, nama=?, alamat=?, hp=?, level=? WHERE id_user=?");
                $stmt->bind_param("sssssii", $data['username'], $hash, $data['nama'], $data['alamat'], $data['hp'], $data['level'], $id);
            } else {                                      // tambah user baru
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO `user` (username, password, nama, alamat, hp, level) VALUES (?,?,?,?,?,?)");
                $stmt->bind_param("sssssi", $data['username'], $hash, $data['nama'], $data['alamat'], $data['hp'], $data['level']);
            }
            $stmt->execute();
            if ($self) {                                  // nama pada navigasi ikut diperbarui
                $_SESSION['username'] = $data['username'];
                $_SESSION['nama']     = $data['nama'];
            }
            kembali("user.php", "Data user berhasil disimpan.", 'ok');
        } catch (mysqli_sql_exception $e) {
            $errors[] = ($e->getCode() === 1062) ? "Username sudah dipakai." : "Data gagal disimpan.";
        }
    }
} elseif ($id > 0) {
    $stmt = $conn->prepare("SELECT username, nama, alamat, hp, level FROM `user` WHERE id_user=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) kembali("user.php", "Data user tidak ditemukan.");
    $data = $row;
}

$judul = ($id > 0) ? "Edit Data Master User" : "Tambah Data Master User Baru";
include 'header.php';
?>
<div class="top"><h2 style="font-size:30px"><?= e($judul) ?></h2></div>
<?php if ($errors): ?><div class="err"><?php foreach ($errors as $m) echo e($m) . '<br>'; ?></div><?php endif; ?>
<form method="post" autocomplete="off">
  <?= csrfField() ?>
  <input type="hidden" name="id" value="<?= $id ?>">
  <div class="form-row"><label>Username</label>
    <input type="text" name="username" value="<?= e($data['username']) ?>" placeholder="username" maxlength="30" required></div>
  <div class="form-row"><label>Password</label>
    <input type="password" name="password" placeholder="<?= $id > 0 ? 'kosongkan jika tidak diganti' : 'minimal 6 karakter' ?>"
           <?= $id > 0 ? '' : 'required' ?>></div>
  <div class="form-row"><label>Nama</label>
    <input type="text" name="nama" value="<?= e($data['nama']) ?>" placeholder="Nama" maxlength="50" required></div>
  <div class="form-row"><label>Alamat</label>
    <input type="text" name="alamat" value="<?= e($data['alamat']) ?>" placeholder="alamat" maxlength="150"></div>
  <div class="form-row"><label>HP</label>
    <input type="text" name="hp" value="<?= e($data['hp']) ?>" placeholder="hp" maxlength="20"></div>
  <div class="form-row"><label>Level</label>
    <select name="level" <?= $self ? 'disabled' : '' ?>>
      <option value="1" <?= (int)$data['level'] === 1 ? 'selected' : '' ?>>1 - Owner</option>
      <option value="2" <?= (int)$data['level'] === 2 ? 'selected' : '' ?>>2 - Kasir</option>
    </select></div>
  <div class="aksi"><button class="btn hijau" type="submit"><?= $id > 0 ? 'Update' : 'Simpan' ?></button>
  <a class="btn merah" href="user.php">Batal</a></div>
</form>
</div></body></html>
