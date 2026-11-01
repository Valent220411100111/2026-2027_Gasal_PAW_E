<?php
require 'koneksi.php';
$judul = "Data Master Supplier";
include 'header.php';
$pesan = $_GET['pesan'] ?? '';
?>
<div class="top"><h2>Data Master Supplier</h2>
<a class="btn hijau" href="tambah.php">Tambah Data</a></div>
<?php if ($pesan): ?><div class="err"><?= htmlspecialchars($pesan) ?></div><?php endif; ?>
<table>
<tr><th>No</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Tindakan</th></tr>
<?php
$no = 1;
$hasil = $conn->query("SELECT * FROM supplier ORDER BY id");
while ($r = $hasil->fetch_assoc()):
?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= htmlspecialchars($r['nama']) ?></td>
  <td><?= htmlspecialchars($r['telp']) ?></td>
  <td><?= htmlspecialchars($r['alamat']) ?></td>
  <td>
    <a class="btn oranye" href="edit.php?id=<?= $r['id'] ?>">Edit</a>
    <form method="post" action="hapus.php" style="display:inline"
          onsubmit="return confirm('Anda yakin akan menghapus supplier ini?');">
      <input type="hidden" name="id" value="<?= $r['id'] ?>">
      <button class="btn merah" type="submit">Hapus</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</table>
</div></body></html>
