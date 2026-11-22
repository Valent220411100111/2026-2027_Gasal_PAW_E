<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);
$judul = "Data Master Pelanggan";
include 'header.php';
?>
<div class="top"><h2>Data Master Pelanggan</h2>
<a class="btn hijau" href="pelanggan_form.php">Tambah Data</a></div>
<?php tampilPesan(); ?>
<table>
<tr><th>No</th><th>Kode</th><th>Nama</th><th>JK</th><th>Telp</th><th>Alamat</th><th>Tindakan</th></tr>
<?php
$no = 1;
$hasil = $conn->query("SELECT id, nama, jenis_kelamin, telp, alamat FROM pelanggan ORDER BY id");
while ($r = $hasil->fetch_assoc()):
?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= e($r['id']) ?></td>
  <td><?= e($r['nama']) ?></td>
  <td><?= e($r['jenis_kelamin']) ?></td>
  <td><?= e($r['telp']) ?></td>
  <td><?= e($r['alamat']) ?></td>
  <td>
    <a class="btn oranye" href="pelanggan_form.php?id=<?= urlencode($r['id']) ?>">Edit</a>
    <form method="post" action="pelanggan_hapus.php" style="display:inline"
          onsubmit="return confirm('Anda yakin akan menghapus pelanggan ini?');">
      <?= csrfField() ?>
      <input type="hidden" name="id" value="<?= e($r['id']) ?>">
      <button class="btn merah" type="submit">Hapus</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</table>
</div></body></html>
