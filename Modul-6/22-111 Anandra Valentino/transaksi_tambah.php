<?php
require 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['waktu_transaksi'];
    $pelanggan = $_POST['pelanggan_id'];
    $ket = trim($_POST['keterangan']);
    try {
        // total diisi 0, nilainya dihitung otomatis saat detail disimpan
        $stmt = $conn->prepare("INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (?,?,0,?)");
        $stmt->bind_param("sss", $tanggal, $ket, $pelanggan);
        $stmt->execute();
        header("Location: detail.php?id=" . $conn->insert_id);
        exit;
    } catch (mysqli_sql_exception $e) {
        kembali("transaksi_tambah.php", "Transaksi gagal disimpan, periksa kembali isian.");
    }
}
$judul = "Tambah Transaksi";
include 'header.php';
$pesan = $_GET['pesan'] ?? '';
?>
<div class="top"><h2 style="font-size:30px">Tambah Transaksi Baru</h2></div>
<?php if ($pesan): ?><div class="err"><?= htmlspecialchars($pesan) ?></div><?php endif; ?>
<form method="post">
  <div class="form-row"><label>Tanggal</label>
    <input type="date" name="waktu_transaksi" value="<?= date('Y-m-d') ?>" required></div>
  <div class="form-row"><label>Pelanggan</label>
    <select name="pelanggan_id" required>
      <option value="">-- pilih pelanggan --</option>
      <?php $q = $conn->query("SELECT id, nama FROM pelanggan ORDER BY nama");
      while ($p = $q->fetch_assoc()): ?>
      <option value="<?= htmlspecialchars($p['id']) ?>"><?= htmlspecialchars($p['id'] . ' - ' . $p['nama']) ?></option>
      <?php endwhile; ?>
    </select></div>
  <div class="form-row"><label>Keterangan</label>
    <input type="text" name="keterangan" placeholder="keterangan"></div>
  <div class="aksi"><button class="btn hijau" type="submit">Simpan &amp; Isi Detail</button>
  <a class="btn merah" href="index.php">Batal</a></div>
</form>
</div></body></html>
