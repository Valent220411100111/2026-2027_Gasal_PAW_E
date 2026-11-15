<?php
require 'koneksi.php';
require 'fungsi.php';

$mulai   = $_GET['mulai']   ?? '';
$selesai = $_GET['selesai'] ?? '';
$diminta = ($mulai !== '' || $selesai !== '');
$error   = '';
$rekap   = [];
$ring    = ['jml_pelanggan' => 0, 'total_pendapatan' => 0];

if ($diminta) {
    if (!validTanggal($mulai) || !validTanggal($selesai)) {
        $error = "Isi tanggal mulai dan tanggal selesai dengan benar.";
    } elseif ($mulai > $selesai) {
        $error = "Tanggal mulai tidak boleh lebih besar dari tanggal selesai.";
    } else {
        $rekap = ambilRekap($conn, $mulai, $selesai);
        $ring  = ambilRingkasan($conn, $mulai, $selesai);
    }
}
$labels = array_column($rekap, 'tgl');
$nilai  = array_map('intval', array_column($rekap, 'total_harian'));
$qs     = 'mulai=' . urlencode($mulai) . '&selesai=' . urlencode($selesai);
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8">
<title>Laporan Penjualan</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<style>
body{font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#333;margin:0}
.wrap{width:900px;max-width:94%;margin:20px auto}
h2{color:#3a87ad;font-weight:normal;font-size:26px;margin:0 0 12px}
h2 small{font-size:14px;color:#777}
h3{color:#3a87ad;font-weight:normal;margin:22px 0 8px}
.filter{background:#f5f5f5;border:1px solid #ddd;padding:12px;border-radius:4px;margin-bottom:14px}
.filter input{padding:6px;border:1px solid #ccc;border-radius:3px;margin:0 12px 0 4px}
.btn{display:inline-block;padding:7px 14px;color:#fff;border:0;border-radius:3px;font-size:13px;cursor:pointer;text-decoration:none}
.hijau{background:#62a82b}.oranye{background:#e0600c}
.aksi{margin-bottom:12px}
.err{background:#f2dede;color:#a94442;padding:10px;border-radius:3px;margin-bottom:12px}
.info{background:#d9edf7;color:#31708f;padding:10px;border-radius:3px;margin-bottom:12px}
.chart-box{position:relative;width:100%;height:320px}
table{width:100%;border-collapse:collapse;border:1px solid #ddd}
th{background:#d9edf7;text-align:left;padding:9px 8px}
td{padding:9px 8px;border-top:1px solid #ddd}
.kanan{text-align:right}
table.ringkasan{width:50%;margin-top:18px}
@media print {
  .no-print{display:none !important}
  body{margin:0}
  .wrap{width:100%;margin:0}
  *{-webkit-print-color-adjust:exact;print-color-adjust:exact}
}
</style></head><body><div class="wrap">

<h2>Rekap Laporan Penjualan
<?php if ($rekap): ?><small><?= $mulai ?> sampai <?= $selesai ?></small><?php endif; ?></h2>

<div class="filter no-print">
<form method="get">
  Dari <input type="date" name="mulai" value="<?= htmlspecialchars($mulai) ?>" required>
  Sampai <input type="date" name="selesai" value="<?= htmlspecialchars($selesai) ?>" required>
  <button class="btn hijau" type="submit">Tampilkan</button>
</form>
</div>

<?php if ($error): ?>
  <div class="err no-print"><?= htmlspecialchars($error) ?></div>
<?php elseif (!$diminta): ?>
  <div class="info no-print">Pilih rentang tanggal, lalu tekan Tampilkan.</div>
<?php elseif (!$rekap): ?>
  <div class="info">Tidak ada transaksi pada rentang tanggal tersebut.</div>
<?php endif; ?>

<?php if ($rekap): ?>
<div class="aksi no-print">
  <button class="btn oranye" type="button" onclick="window.print()">Cetak</button>
  <a class="btn oranye" href="export_excel.php?<?= $qs ?>">Excel</a>
</div>

<div class="chart-box"><canvas id="grafik"></canvas></div>
<script>
new Chart(document.getElementById('grafik'), {
  type: 'bar',
  data: {
    labels: <?= json_encode($labels) ?>,
    datasets: [{
      label: 'Total Penjualan (Rp)',
      data: <?= json_encode($nilai) ?>,
      backgroundColor: 'rgba(58,135,173,0.7)'
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    animation: false,
    scales: {
      x: { title: { display: true, text: 'Tanggal Transaksi' } },
      y: { beginAtZero: true,
           title: { display: true, text: 'Total Pendapatan (Rp)' },
           ticks: { callback: function (v) { return v.toLocaleString('id-ID'); } } }
    }
  }
});
</script>

<h3>Rekapitulasi Penjualan Harian</h3>
<table class="rekap">
<tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>
<?php foreach ($rekap as $i => $r): ?>
<tr>
  <td><?= $i + 1 ?></td>
  <td><?= rupiah($r['total_harian']) ?></td>
  <td><?= tglIndo($r['tgl']) ?></td>
</tr>
<?php endforeach; ?>
</table>

<table class="ringkasan">
<tr><th>Jumlah Pelanggan</th><th>Jumlah Pendapatan</th></tr>
<tr><td class="kanan"><?= (int)$ring['jml_pelanggan'] ?> Orang</td>
    <td class="kanan"><?= rupiah($ring['total_pendapatan']) ?></td></tr>
</table>
<?php endif; ?>

</div></body></html>
