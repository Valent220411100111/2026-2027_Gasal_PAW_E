<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);
$judul = "Data Master Barang";
include 'header.php';
?>
<div class="top"><h2>Data Master Barang</h2>
<a class="btn hijau" href="barang_form.php">Tambah Data</a></div>
<?php tampilPesan(); ?>
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
  <td><?= e($r['kode_barang']) ?></td>
  <td><?= e($r['nama_barang']) ?></td>
  <td class="kanan"><?= number_format($r['harga'], 0, ',', '.') ?></td>
  <td class="kanan"><?= (int)$r['stok'] ?></td>
  <td><?= e($r['supplier']) ?></td>
  <td>
    <a class="btn oranye" href="barang_form.php?id=<?= (int)$r['id'] ?>">Edit</a>
    <form method="post" action="barang_hapus.php" style="display:inline"
          onsubmit="return confirm('Anda yakin akan menghapus barang ini?');">
      <?= csrfField() ?>
      <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
      <button class="btn merah" type="submit">Hapus</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</table>
</div></body></html>
