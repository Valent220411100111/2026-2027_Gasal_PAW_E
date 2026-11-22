<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);                       // hanya owner
$judul = "Data Master Supplier";
include 'header.php';
?>
<div class="top"><h2>Data Master Supplier</h2>
<a class="btn hijau" href="supplier_form.php">Tambah Data</a></div>
<?php tampilPesan(); ?>
<table>
<tr><th>No</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Tindakan</th></tr>
<?php
$no = 1;
$hasil = $conn->query("SELECT id, nama, telp, alamat FROM supplier ORDER BY id");
while ($r = $hasil->fetch_assoc()):
?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= e($r['nama']) ?></td>
  <td><?= e($r['telp']) ?></td>
  <td><?= e($r['alamat']) ?></td>
  <td>
    <a class="btn oranye" href="supplier_form.php?id=<?= (int)$r['id'] ?>">Edit</a>
    <form method="post" action="supplier_hapus.php" style="display:inline"
          onsubmit="return confirm('Anda yakin akan menghapus supplier ini?');">
      <?= csrfField() ?>
      <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
      <button class="btn merah" type="submit">Hapus</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</table>
</div></body></html>
