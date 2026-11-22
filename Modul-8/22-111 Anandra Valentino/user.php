<?php
require 'koneksi.php';
require 'auth.php';
wajibLevel([1]);
$judul = "Data Master User";
include 'header.php';
?>
<div class="top"><h2>Data Master User</h2>
<a class="btn hijau" href="user_form.php">Tambah Data</a></div>
<?php tampilPesan(); ?>
<table>
<tr><th>No</th><th>Username</th><th>Nama</th><th>Alamat</th><th>HP</th><th>Level</th><th>Tindakan</th></tr>
<?php
$no = 1;
$hasil = $conn->query("SELECT id_user, username, nama, alamat, hp, level FROM `user` ORDER BY id_user");
while ($r = $hasil->fetch_assoc()):
    $self = ((int)$r['id_user'] === (int)$_SESSION['id_user']);
?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= e($r['username']) ?></td>
  <td><?= e($r['nama']) ?></td>
  <td><?= e($r['alamat']) ?></td>
  <td><?= e($r['hp']) ?></td>
  <td><?= e(namaLevel($r['level'])) ?></td>
  <td>
    <a class="btn oranye" href="user_form.php?id=<?= (int)$r['id_user'] ?>">Edit</a>
    <?php if (!$self): ?>
    <form method="post" action="user_hapus.php" style="display:inline"
          onsubmit="return confirm('Anda yakin akan menghapus user ini?');">
      <?= csrfField() ?>
      <input type="hidden" name="id" value="<?= (int)$r['id_user'] ?>">
      <button class="btn merah" type="submit">Hapus</button>
    </form>
    <?php else: ?><small>(akun Anda)</small><?php endif; ?>
  </td>
</tr>
<?php endwhile; ?>
</table>
</div></body></html>
