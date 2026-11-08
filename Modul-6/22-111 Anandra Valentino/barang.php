<?php
require 'koneksi.php';
$judul = "Data Master Barang";
include 'header.php';
$pesan = $_GET['pesan'] ?? '';
$tipe  = (($_GET['tipe'] ?? '') === 'ok') ? 'ok' : 'err';
?>
<div class="top"><h2>Data Master Barang</h2></div>
<?php if ($pesan): ?><div class="<?= $tipe ?>"><?= htmlspecialchars($pesan) ?></div><?php endif; ?>
<table>
<tr><th>No</th><th>Kode</th><th>Nama Barang</th><th class="kanan">Harga</th><th class="kanan">Stok</th><th>Supplier</th><th>Tindakan</th></tr>
<?php
$no = 1;
$hasil = $conn->query("SELECT b.id, b.kode_barang, b.nama_barang, b.harga, b.stok, s.nama AS supplier
                       FROM barang b JOIN supplier s ON s.id = b.supplier_id ORDER BY b.id");
while ($r = $hasil->fetch_assoc()):
?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= htmlspecialchars($r['kode_barang']) ?></td>
  <td><?= htmlspecialchars($r['nama_barang']) ?></td>
  <td class="kanan"><?= number_format($r['harga'], 0, ',', '.') ?></td>
  <td class="kanan"><?= $r['stok'] ?></td>
  <td><?= htmlspecialchars($r['supplier']) ?></td>
  <td>
    <form method="post" action="barang_hapus.php" style="display:inline"
          onsubmit="return confirm('Anda yakin akan menghapus barang ini?');">
      <input type="hidden" name="id" value="<?= $r['id'] ?>">
      <button class="btn merah" type="submit">Hapus</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</table>
</div></body></html>
