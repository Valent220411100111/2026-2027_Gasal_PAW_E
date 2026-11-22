<?php
require 'koneksi.php';
require 'auth.php';

// User yang sudah login tidak boleh membuka halaman login
if (sudahLogin()) {
    header("Location: index.php");
    exit;
}

$pesan    = $_GET['pesan'] ?? '';
$tipe     = (($_GET['tipe'] ?? '') === 'ok') ? 'ok' : 'err';
$username = '';

// hash palsu agar waktu proses sama walaupun username tidak ditemukan
const HASH_PALSU = '$2y$10$abcdefghijklmnopqrstuvabcdefghijklmnopqrstuvwxyz01234';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCek();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $tipe = 'err';

    if ($username === '' || $password === '') {
        $pesan = "Username dan password wajib diisi.";
    } else {
        $stmt = $conn->prepare("SELECT id_user, username, password, nama, level FROM `user` WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $u = $stmt->get_result()->fetch_assoc();

        $hash = $u['password'] ?? HASH_PALSU;
        $upgrade = false;
        if (strlen($hash) === 32 && ctype_xdigit($hash)) {
            // hash lama (MD5) dari modul sebelumnya
            $valid   = hash_equals($hash, md5($password));
            $upgrade = $valid;
        } else {
            $valid = password_verify($password, $hash);
        }

        if (!$u || !$valid) {
            $pesan = "Username atau password salah.";      // pesan sengaja dibuat umum
        } elseif (!in_array((int)$u['level'], [1, 2], true)) {
            $pesan = "Level akun ini tidak memiliki hak akses.";
        } else {
            if ($upgrade) {                                 // ganti MD5 menjadi bcrypt
                $baru = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE `user` SET password = ? WHERE id_user = ?");
                $stmt->bind_param("si", $baru, $u['id_user']);
                $stmt->execute();
            }
            session_regenerate_id(true);                    // cegah session fixation
            $_SESSION['id_user']        = (int)$u['id_user'];
            $_SESSION['username']       = $u['username'];
            $_SESSION['nama']           = $u['nama'];
            $_SESSION['level']          = (int)$u['level'];
            $_SESSION['aktif_terakhir'] = time();
            header("Location: index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8">
<title>Login - Sistem Penjualan</title>
<style>
body{font-family:Helvetica,Arial,sans-serif;background:#eef3f8;margin:0}
.box{width:340px;margin:90px auto;background:#fff;border:1px solid #ddd;border-radius:6px;padding:26px;box-shadow:0 2px 8px rgba(0,0,0,.08)}
h2{margin:0 0 18px;color:#0b5aa8;font-weight:normal;text-align:center}
label{display:block;margin:12px 0 4px;font-weight:bold;font-size:13px}
input{width:100%;box-sizing:border-box;padding:9px;border:1px solid #ccc;border-radius:4px;font-size:14px}
button{width:100%;margin-top:18px;padding:10px;background:#62a82b;color:#fff;border:0;border-radius:4px;font-size:14px;cursor:pointer}
.err{background:#f2dede;color:#a94442;padding:9px;border-radius:3px;font-size:13px}
.ok{background:#dff0d8;color:#3c763d;padding:9px;border-radius:3px;font-size:13px}
</style></head><body>
<div class="box">
  <h2>Sistem Penjualan</h2>
  <?php if ($pesan !== ''): ?><div class="<?= $tipe ?>"><?= e($pesan) ?></div><?php endif; ?>
  <form method="post" autocomplete="off">
    <?= csrfField() ?>
    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?= e($username) ?>" maxlength="30" autofocus required>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
  </form>
</div>
</body></html>
