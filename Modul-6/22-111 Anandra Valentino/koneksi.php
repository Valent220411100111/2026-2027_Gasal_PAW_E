<?php
// Semua error MySQL dilempar sebagai mysqli_sql_exception agar bisa ditangkap try-catch
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "penjualan";

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Fungsi bantu: kembali ke halaman tertentu membawa notifikasi
function kembali($url, $pesan, $tipe = 'err') {
    $sep = (strpos($url, '?') === false) ? '?' : '&';
    header("Location: " . $url . $sep . "pesan=" . urlencode($pesan) . "&tipe=" . $tipe);
    exit;
}
?>
