<?php
// ===== Session: dimulai di setiap halaman lewat file ini =====
session_set_cookie_params([
    'lifetime' => 0,          // cookie hilang saat browser ditutup
    'path'     => '/',
    'httponly' => true,       // cookie tidak bisa dibaca JavaScript
    'samesite' => 'Lax',      // cookie tidak dikirim pada request lintas situs
]);
session_start();

const BATAS_IDLE = 1800;      // sesi berakhir setelah 30 menit tidak aktif

// Escape output agar aman dari XSS
function e($teks) {
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

function sudahLogin() {
    return isset($_SESSION['id_user']);
}

function namaLevel($level) {
    return ((int)$level === 1) ? 'Owner' : (((int)$level === 2) ? 'Kasir' : '-');
}

// ===== Proteksi halaman: harus sudah login =====
function wajibLogin() {
    if (!sudahLogin()) {
        header("Location: login.php");
        exit;
    }
    if (isset($_SESSION['aktif_terakhir']) && time() - $_SESSION['aktif_terakhir'] > BATAS_IDLE) {
        session_unset();
        session_destroy();
        header("Location: login.php?pesan=" . urlencode("Sesi berakhir, silakan login kembali."));
        exit;
    }
    $_SESSION['aktif_terakhir'] = time();
}

// ===== Proteksi halaman: harus login dan levelnya termasuk yang diizinkan =====
function wajibLevel($boleh) {
    wajibLogin();
    if (!in_array((int)$_SESSION['level'], $boleh, true)) {
        http_response_code(403);
        $judul = "Akses Ditolak";
        include 'header.php';
        echo '<div class="err">Anda tidak memiliki hak akses ke halaman ini.</div>';
        echo '<a class="btn biru" href="index.php">Kembali ke Home</a></div></body></html>';
        exit;
    }
}

// ===== CSRF: token acak per sesi, wajib dikirim pada setiap form POST =====
function csrfToken() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
function csrfField() {
    return '<input type="hidden" name="csrf" value="' . csrfToken() . '">';
}
function csrfCek() {
    if (!isset($_POST['csrf'], $_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        http_response_code(400);
        die("Permintaan tidak valid (token CSRF salah).");
    }
}

// ===== Notifikasi lewat parameter URL (pesan dan tipe ok/err) =====
function kembali($url, $pesan, $tipe = 'err') {
    $sep = (strpos($url, '?') === false) ? '?' : '&';
    header("Location: " . $url . $sep . "pesan=" . urlencode($pesan) . "&tipe=" . $tipe);
    exit;
}
function tampilPesan() {
    $p = $_GET['pesan'] ?? '';
    if ($p === '') return;
    $t = (($_GET['tipe'] ?? '') === 'ok') ? 'ok' : 'err';
    echo '<div class="' . $t . '">' . e($p) . '</div>';
}
