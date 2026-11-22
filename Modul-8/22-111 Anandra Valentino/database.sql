-- Modul 8: Database penjualan (pengembangan dari Modul 7) - session dan security
CREATE DATABASE IF NOT EXISTS penjualan CHARACTER SET utf8mb4;
USE penjualan;

DROP TABLE IF EXISTS pembayaran, transaksi_detail, transaksi, barang, supplier, pelanggan, `user`;

CREATE TABLE pelanggan (
  id VARCHAR(20) NOT NULL PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  telp VARCHAR(12),
  alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE supplier (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  telp VARCHAR(12),
  alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE barang (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(10) NOT NULL UNIQUE,
  nama_barang VARCHAR(100) NOT NULL,
  harga INT(11) NOT NULL,
  stok INT(11) NOT NULL,
  supplier_id INT(11) NOT NULL,
  FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE transaksi (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  waktu_transaksi DATE NOT NULL,
  keterangan TEXT,
  total INT(11) NOT NULL,
  pelanggan_id VARCHAR(20) NOT NULL,
  FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE transaksi_detail (
  transaksi_id INT(11) NOT NULL,
  barang_id INT(11) NOT NULL,
  harga INT(11) NOT NULL,
  qty INT(11) NOT NULL,
  PRIMARY KEY (transaksi_id, barang_id),
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  waktu_bayar DATETIME NOT NULL,
  total INT(11) NOT NULL,
  metode ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
  transaksi_id INT(11) NOT NULL,
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `user` (
  id_user TINYINT(2) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama VARCHAR(50) NOT NULL,
  alamat VARCHAR(150),
  hp VARCHAR(20),
  level TINYINT(1) NOT NULL
) ENGINE=InnoDB;

-- ===== DATA =====
INSERT INTO supplier (nama, telp, alamat) VALUES
('PT. Maju Bersama','08123456','Surabaya'),
('PT. Senang Sekali','081515563','Bangkalan'),
('PT. Segar Segar','0845454663','Surabaya'),
('CV. Sumber Rejeki','081234567','Sidoarjo'),
('PT. Jaya Abadi','082198765','Gresik'),
('CV. Makmur Sentosa','085611223','Malang'),
('PT. Berkah Niaga','087733445','Mojokerto'),
('CV. Tani Makmur','081355667','Pasuruan'),
('PT. Aneka Pangan','082277889','Surabaya'),
('CV. Cahaya Baru','085899001','Lamongan');

INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('BRG001','Beras 5 Kg',65000,50,1),
('BRG002','Minyak Goreng 2 L',38000,40,2),
('BRG003','Gula Pasir 1 Kg',16000,100,3),
('BRG004','Telur Ayam 1 Kg',28000,60,4),
('BRG005','Mie Instan',3500,500,5),
('BRG006','Kopi Bubuk 200 g',22000,80,6),
('BRG007','Teh Celup',12000,90,7),
('BRG008','Susu UHT 1 L',18000,70,8),
('BRG009','Sabun Mandi',4500,200,9),
('BRG010','Deterjen 1 Kg',25000,75,10),
('BRG011','Tepung Terigu 1 Kg',12000,60,1),
('BRG012','Garam Dapur',3000,150,2);

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('P001','Budi Santoso','L','081111111','Surabaya'),
('P002','Siti Aminah','P','081222222','Sidoarjo'),
('P003','Agus Wijaya','L','081333333','Gresik'),
('P004','Dewi Lestari','P','081444444','Malang'),
('P005','Rudi Hartono','L','081555555','Bangkalan'),
('P006','Rina Marlina','P','081666666','Surabaya'),
('P007','Eko Prasetyo','L','081777777','Mojokerto'),
('P008','Lina Kusuma','P','081888888','Pasuruan'),
('P009','Hadi Susanto','L','081999999','Lamongan'),
('P010','Maya Sari','P','082000000','Surabaya');

INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES
('2026-10-01','Pembelian rutin',130000,'P001'),
('2026-10-02','Pembelian rutin',38000,'P002'),
('2026-10-03','Pembelian eceran',48000,'P003'),
('2026-10-04','Pembelian rutin',56000,'P004'),
('2026-10-05','Pembelian eceran',35000,'P005'),
('2026-10-06','Pembelian rutin',44000,'P006'),
('2026-10-07','Pembelian eceran',48000,'P007'),
('2026-10-08','Pembelian rutin',54000,'P008'),
('2026-10-09','Pembelian eceran',27000,'P009'),
('2026-10-10','Pembelian rutin',50000,'P010');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1,1,65000,2),(2,2,38000,1),(3,3,16000,3),(4,4,28000,2),(5,5,3500,10),
(6,6,22000,2),(7,7,12000,4),(8,8,18000,3),(9,9,4500,6),(10,10,25000,2);

INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES
('2026-10-01 10:15:00',130000,'TUNAI',1),
('2026-10-02 11:20:00',38000,'TRANSFER',2),
('2026-10-03 09:05:00',48000,'EDC',3),
('2026-10-04 14:30:00',56000,'TUNAI',4),
('2026-10-05 16:45:00',35000,'TUNAI',5),
('2026-10-06 13:10:00',44000,'TRANSFER',6),
('2026-10-07 08:55:00',48000,'EDC',7),
('2026-10-08 15:25:00',54000,'TUNAI',8),
('2026-10-09 12:40:00',27000,'TRANSFER',9),
('2026-10-10 17:00:00',50000,'EDC',10);

INSERT INTO `user` (username, password, nama, alamat, hp, level) VALUES
('admin',MD5('admin123'),'Administrator','Surabaya','081000001',1),
('owner',MD5('owner123'),'Pak Owner','Surabaya','081000006',1),
('kasir1',MD5('kasir123'),'Andi Kasir','Surabaya','081000002',2),
('kasir2',MD5('kasir123'),'Bella Kasir','Sidoarjo','081000003',2),
('kasir3',MD5('kasir123'),'Eko Kasir','Bangkalan','081000007',2),
('kasir4',MD5('kasir123'),'Fitri Kasir','Mojokerto','081000008',2),
('kasir5',MD5('kasir123'),'Gita Kasir','Pasuruan','081000009',2),
('kasir6',MD5('kasir123'),'Hendra Kasir','Lamongan','081000010',2),
('kasir7',MD5('kasir123'),'Candra Kasir','Gresik','081000004',2),
('kasir8',MD5('kasir123'),'Dina Kasir','Malang','081000005',2);
-- Catatan: password awal disimpan MD5 (seperti modul sebelumnya). Saat user berhasil login,
-- hash otomatis diganti menjadi password_hash() (bcrypt) oleh login.php.
-- level: 1 = owner, 2 = kasir

-- ===== DATA TAMBAHAN MODUL 7 (untuk uji laporan harian) =====
-- Beberapa transaksi pada tanggal yang sama agar GROUP BY DATE() terlihat bekerja
INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES
('2026-10-02','Pembelian eceran',53000,'P003'),
('2026-10-02','Pembelian rutin',32000,'P001'),
('2026-10-05','Pembelian eceran',46000,'P002'),
('2026-10-11','Pembelian rutin',65000,'P004'),
('2026-10-12','Pembelian eceran',63000,'P001');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(11,5,3500,10),(11,9,4500,4),
(12,3,16000,2),
(13,6,22000,1),(13,7,12000,2),
(14,1,65000,1),
(15,2,38000,1),(15,10,25000,1);

INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES
('2026-10-02 12:05:00',53000,'TUNAI',11),
('2026-10-02 15:20:00',32000,'TRANSFER',12),
('2026-10-05 10:40:00',46000,'EDC',13),
('2026-10-11 09:15:00',65000,'TUNAI',14),
('2026-10-12 13:30:00',63000,'TRANSFER',15);
