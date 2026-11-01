-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 01, 2026 at 05:13 PM
-- Server version: 8.0.42
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `supplier_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Beras 5 Kg', 65000, 50, 1),
(2, 'BRG002', 'Minyak Goreng 2 L', 38000, 40, 2),
(3, 'BRG003', 'Gula Pasir 1 Kg', 16000, 100, 3),
(4, 'BRG004', 'Telur Ayam 1 Kg', 28000, 60, 4),
(5, 'BRG005', 'Mie Instan', 3500, 500, 5),
(6, 'BRG006', 'Kopi Bubuk 200 g', 22000, 80, 6),
(7, 'BRG007', 'Teh Celup', 12000, 90, 7),
(8, 'BRG008', 'Susu UHT 1 L', 18000, 70, 8),
(9, 'BRG009', 'Sabun Mandi', 4500, 200, 9),
(10, 'BRG010', 'Deterjen 1 Kg', 25000, 75, 10);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('P001', 'Budi Santoso', 'L', '081111111', 'Surabaya'),
('P002', 'Siti Aminah', 'P', '081222222', 'Sidoarjo'),
('P003', 'Agus Wijaya', 'L', '081333333', 'Gresik'),
('P004', 'Dewi Lestari', 'P', '081444444', 'Malang'),
('P005', 'Rudi Hartono', 'L', '081555555', 'Bangkalan'),
('P006', 'Rina Marlina', 'P', '081666666', 'Surabaya'),
('P007', 'Eko Prasetyo', 'L', '081777777', 'Mojokerto'),
('P008', 'Lina Kusuma', 'P', '081888888', 'Pasuruan'),
('P009', 'Hadi Susanto', 'L', '081999999', 'Lamongan'),
('P010', 'Maya Sari', 'P', '082000000', 'Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int NOT NULL,
  `waktu_bayar` datetime NOT NULL,
  `total` int NOT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') NOT NULL,
  `transaksi_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-10-01 10:15:00', 130000, 'TUNAI', 1),
(2, '2026-10-02 11:20:00', 38000, 'TRANSFER', 2),
(3, '2026-10-03 09:05:00', 48000, 'EDC', 3),
(4, '2026-10-04 14:30:00', 56000, 'TUNAI', 4),
(5, '2026-10-05 16:45:00', 35000, 'TUNAI', 5),
(6, '2026-10-06 13:10:00', 44000, 'TRANSFER', 6),
(7, '2026-10-07 08:55:00', 48000, 'EDC', 7),
(8, '2026-10-08 15:25:00', 54000, 'TUNAI', 8),
(9, '2026-10-09 12:40:00', 27000, 'TRANSFER', 9),
(10, '2026-10-10 17:00:00', 50000, 'EDC', 10);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT. Maju Bersama Sama', '08123456', 'Surabaya'),
(2, 'PT. Senang Sekali', '081515563', 'Bangkalan'),
(3, 'PT. Segar Segar', '0845454663', 'Surabaya'),
(4, 'CV. Sumber Rejeki', '081234567', 'Sidoarjo'),
(5, 'PT. Jaya Abadi', '082198765', 'Gresik'),
(6, 'CV. Makmur Sentosa', '085611223', 'Malang'),
(7, 'PT. Berkah Niaga', '087733445', 'Mojokerto'),
(8, 'CV. Tani Makmur', '081355667', 'Pasuruan'),
(9, 'PT. Aneka Pangan', '082277889', 'Surabaya'),
(10, 'CV. Cahaya Baru', '085899001', 'Lamongan'),
(11, 'PT Pukat', '0881234567', 'Tel Aviv');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `waktu_transaksi` date NOT NULL,
  `keterangan` text,
  `total` int NOT NULL,
  `pelanggan_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-01', 'Pembelian rutin', 130000, 'P001'),
(2, '2026-10-02', 'Pembelian rutin', 38000, 'P002'),
(3, '2026-10-03', 'Pembelian eceran', 48000, 'P003'),
(4, '2026-10-04', 'Pembelian rutin', 56000, 'P004'),
(5, '2026-10-05', 'Pembelian eceran', 35000, 'P005'),
(6, '2026-10-06', 'Pembelian rutin', 44000, 'P006'),
(7, '2026-10-07', 'Pembelian eceran', 48000, 'P007'),
(8, '2026-10-08', 'Pembelian rutin', 54000, 'P008'),
(9, '2026-10-09', 'Pembelian eceran', 27000, 'P009'),
(10, '2026-10-10', 'Pembelian rutin', 50000, 'P010');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int NOT NULL,
  `barang_id` int NOT NULL,
  `harga` int NOT NULL,
  `qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 65000, 2),
(2, 2, 38000, 1),
(3, 3, 16000, 3),
(4, 4, 28000, 2),
(5, 5, 3500, 10),
(6, 6, 22000, 2),
(7, 7, 12000, 4),
(8, 8, 18000, 3),
(9, 9, 4500, 6),
(10, 10, 25000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` tinyint NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `level` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator', 'Surabaya', '081000001', 1),
(2, 'kasir1', 'de28f8f7998f23ab4194b51a6029416f', 'Andi Kasir', 'Surabaya', '081000002', 2),
(3, 'kasir2', 'de28f8f7998f23ab4194b51a6029416f', 'Bella Kasir', 'Sidoarjo', '081000003', 2),
(4, 'gudang1', 'cbb7449d78314665f9e7c7dd0a18a68a', 'Candra Gudang', 'Gresik', '081000004', 3),
(5, 'gudang2', 'cbb7449d78314665f9e7c7dd0a18a68a', 'Dina Gudang', 'Malang', '081000005', 3),
(6, 'owner', '5be057accb25758101fa5eadbbd79503', 'Pak Owner', 'Surabaya', '081000006', 1),
(7, 'kasir3', 'de28f8f7998f23ab4194b51a6029416f', 'Eko Kasir', 'Bangkalan', '081000007', 2),
(8, 'kasir4', 'de28f8f7998f23ab4194b51a6029416f', 'Fitri Kasir', 'Mojokerto', '081000008', 2),
(9, 'staff1', 'de9bf5643eabf80f4a56fda3bbb84483', 'Gita Staff', 'Pasuruan', '081000009', 3),
(10, 'staff2', 'de9bf5643eabf80f4a56fda3bbb84483', 'Hendra Staff', 'Lamongan', '081000010', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transaksi_id`,`barang_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
