<?php
// Fungsi bersama untuk halaman laporan dan ekspor Excel

// Pastikan string berformat tanggal Y-m-d yang benar (mis. 2026-10-01)
function validTanggal($t) {
    $d = DateTime::createFromFormat('Y-m-d', $t);
    return $d && $d->format('Y-m-d') === $t;
}

// Rekap total pendapatan per hari pada rentang tanggal (agregasi SUM + GROUP BY DATE)
function ambilRekap($conn, $mulai, $selesai) {
    $stmt = $conn->prepare(
        "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian
         FROM transaksi
         WHERE waktu_transaksi BETWEEN ? AND ?
         GROUP BY DATE(waktu_transaksi)
         ORDER BY tgl ASC");
    $stmt->bind_param("ss", $mulai, $selesai);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Ringkasan kumulatif: pelanggan unik dan total pendapatan keseluruhan pada periode
function ambilRingkasan($conn, $mulai, $selesai) {
    $stmt = $conn->prepare(
        "SELECT COUNT(DISTINCT pelanggan_id) AS jml_pelanggan,
                COALESCE(SUM(total), 0)      AS total_pendapatan
         FROM transaksi
         WHERE waktu_transaksi BETWEEN ? AND ?");
    $stmt->bind_param("ss", $mulai, $selesai);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function rupiah($angka) {
    return 'Rp. ' . number_format($angka, 0, ',', '.');
}

// 2026-10-01 -> 01 Okt 2026
function tglIndo($t) {
    $bln = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $p = explode('-', $t);
    return $p[2] . ' ' . $bln[(int)$p[1]] . ' ' . $p[0];
}
