<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: user.php"); exit; }
csrfCek();
$id = (int)$_POST['id'];

// akun yang sedang dipakai login tidak boleh dihapus
if ($id === (int)$_SESSION['id_user']) {
    kembali("user.php", "Akun yang sedang Anda pakai tidak dapat dihapus.");
}

try {
    // jangan sampai sistem kehabisan owner
    $stmt = $conn->prepare("SELECT level FROM `user` WHERE id_user = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $target = $stmt->get_result()->fetch_assoc();
    if (!$target) kembali("user.php", "Data user tidak ditemukan.");

    if ((int)$target['level'] === 1) {
        $jmlOwner = (int)$conn->query("SELECT COUNT(*) FROM `user` WHERE level = 1")->fetch_row()[0];
        if ($jmlOwner <= 1) kembali("user.php", "Owner terakhir tidak dapat dihapus.");
    }

    $stmt = $conn->prepare("DELETE FROM `user` WHERE id_user = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    kembali("user.php", "User berhasil dihapus.", 'ok');
} catch (mysqli_sql_exception $e) {
    kembali("user.php", "User gagal dihapus.");
}
