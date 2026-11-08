<?php
require 'koneksi.php';
$id = (int)($_GET['id'] ?? 0);

// ---- MASTER: data transaksi + nama pelanggan ----
$stmt = $conn->prepare("SELECT t.*, p.nama AS pelanggan
                        FROM transaksi t JOIN pelanggan p ON p.id = t.pelanggan_id
                        WHERE t.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$m = $stmt->get_result()->fetch_assoc();
if (!$m) { header("Location: index.php"); exit; }

// ---- DETAIL: barang pada transaksi ini ----
$stmt = $conn->prepare("SELECT d.barang_id, b.kode_barang, b.nama_barang, d.harga, d.qty, (d.harga * d.qty) AS subtotal
                        FROM transaksi_detail d JOIN barang b ON b.id = d.barang_id
                        WHERE d.transaksi_id = ? ORDER BY b.nama_barang");
$stmt->bind_param("i", $id);
$stmt->execute();
$detail = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// id barang yang sudah masuk detail -> dinonaktifkan di dropdown
$dipakai = array_column($detail, 'barang_id');

$judul = "Detail Transaksi #" . $id;
include 'header.php';
$pesan = $_GET['pesan'] ?? '';
$tipe  = (($_GET['tipe'] ?? '') === 'ok') ? 'ok' : 'err';
?>
<div class="top"><h2>Detail Transaksi #<?= $id ?></h2>
<a class="btn merah" href="index.php">Kembali</a></div>
<?php if ($pesan): ?><div class="<?= $tipe ?>"><?= htmlspecialchars($pesan) ?></div><?php endif; ?>

<table class="master">
  <tr><td>No. Transaksi</td><td><?= $m['id'] ?></td></tr>
  <tr><td>Tanggal</td><td><?= htmlspecialchars($m['waktu_transaksi']) ?></td></tr>
  <tr><td>Pelanggan</td><td><?= htmlspecialchars($m['pelanggan_id'] . ' - ' . $m['pelanggan']) ?></td></tr>
  <tr><td>Keterangan</td><td><?= htmlspecialchars($m['keterangan']) ?></td></tr>
  <tr><td>Total</td><td><b>Rp <?= number_format($m['total'], 0, ',', '.') ?></b></td></tr>
</table>

<h3>Detail Barang</h3>
<table>
<tr><th>No</th><th>Kode</th><th>Barang</th><th class="kanan">Harga</th><th class="kanan">Qty</th><th class="kanan">Subtotal</th><th>Tindakan</th></tr>
<?php if (!$detail): ?><tr><td colspan="7">Belum ada barang pada transaksi ini.</td></tr><?php endif; ?>
<?php foreach ($detail as $i => $d): ?>
<tr>
  <td><?= $i + 1 ?></td>
  <td><?= htmlspecialchars($d['kode_barang']) ?></td>
  <td><?= htmlspecialchars($d['nama_barang']) ?></td>
  <td class="kanan"><?= number_format($d['harga'], 0, ',', '.') ?></td>
  <td class="kanan"><?= $d['qty'] ?></td>
  <td class="kanan"><?= number_format($d['subtotal'], 0, ',', '.') ?></td>
  <td>
    <form method="post" action="hapus_detail.php" style="display:inline"
          onsubmit="return confirm('Hapus barang ini dari transaksi?');">
      <input type="hidden" name="transaksi_id" value="<?= $id ?>">
      <input type="hidden" name="barang_id" value="<?= $d['barang_id'] ?>">
      <button class="btn merah" type="submit">Hapus</button>
    </form>
  </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Tambah Barang ke Transaksi</h3>
<form method="post" action="simpan_detail.php">
  <input type="hidden" name="transaksi_id" value="<?= $id ?>">
  <div class="form-row"><label>Barang</label>
    <select name="barang_id" required>
      <option value="">-- pilih barang --</option>
      <?php
      $q = $conn->query("SELECT id, kode_barang, nama_barang, harga FROM barang ORDER BY nama_barang");
      while ($b = $q->fetch_assoc()):
          $sudah = in_array($b['id'], $dipakai);
      ?>
      <option value="<?= $b['id'] ?>" <?= $sudah ? 'disabled' : '' ?>>
        <?= htmlspecialchars($b['kode_barang'] . ' - ' . $b['nama_barang'] . ' (Rp ' . number_format($b['harga'], 0, ',', '.') . ')') ?><?= $sudah ? ' - sudah dipilih' : '' ?>
      </option>
      <?php endwhile; ?>
    </select></div>
  <div class="form-row"><label>Qty</label>
    <input type="number" name="qty" min="1" value="1" required></div>
  <div class="aksi"><button class="btn hijau" type="submit">Simpan Detail</button></div>
</form>
</div></body></html>
