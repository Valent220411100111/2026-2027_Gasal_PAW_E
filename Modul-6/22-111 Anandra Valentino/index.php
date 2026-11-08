<?php
require 'koneksi.php';
$judul = "Data Transaksi";
include 'header.php';
$pesan = $_GET['pesan'] ?? '';
$tipe  = (($_GET['tipe'] ?? '') === 'ok') ? 'ok' : 'err';
?>
<div class="top"><h2>Data Transaksi (Master)</h2>
<a class="btn hijau" href="transaksi_tambah.php">Tambah Transaksi</a></div>
<?php if ($pesan): ?><div class="<?= $tipe ?>"><?= htmlspecialchars($pesan) ?></div><?php endif; ?>
<table>
<tr><th>No</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th class="kanan">Total (Rp)</th><th>Tindakan</th></tr>
<?php
$no = 1;
$hasil = $conn->query("SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, p.nama
                       FROM transaksi t
                       JOIN pelanggan p ON p.id = t.pelanggan_id
                       ORDER BY t.id");
while ($r = $hasil->fetch_assoc()):
?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= htmlspecialchars($r['waktu_transaksi']) ?></td>
  <td><?= htmlspecialchars($r['nama']) ?></td>
  <td><?= htmlspecialchars($r['keterangan']) ?></td>
  <td class="kanan"><?= number_format($r['total'], 0, ',', '.') ?></td>
  <td><a class="btn biru" href="detail.php?id=<?= $r['id'] ?>">Detail</a></td>
</tr>
<?php endwhile; ?>
</table>
</div></body></html>
