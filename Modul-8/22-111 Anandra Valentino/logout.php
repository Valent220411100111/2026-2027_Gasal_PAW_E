<?php
require 'auth.php';

// 1. kosongkan semua data session
$_SESSION = [];

// 2. hapus cookie session di browser
if (ini_get("session.use_cookies")) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}

// 3. hancurkan session di server, lalu arahkan ke halaman login
session_destroy();
header("Location: login.php?pesan=" . urlencode("Anda telah logout.") . "&tipe=ok");
exit;
