-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2024 at 04:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `diskon`
--

CREATE TABLE `diskon` (
  `id` int(11) NOT NULL,
  `diskon` int(3) NOT NULL,
  `deskripsi` text NOT NULL,
  `minimum_transaksi` decimal(10,2) DEFAULT NULL,
  `expired_date` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diskon`
--

INSERT INTO `diskon` (`id`, `diskon`, `deskripsi`, `minimum_transaksi`, `expired_date`, `is_deleted`, `deleted_at`) VALUES
(1, 25, 'Diskon tanggal gajian', 40000.00, '2024-04-19', 0, NULL),
(6, 99, 'Diskon Sultanzzz', 10000000.00, '2024-04-18', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` varchar(16) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nomor_telepon` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_registrasi` date NOT NULL,
  `expired_date` date NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '0 inactive, 1 active',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `nik`, `nama`, `nomor_telepon`, `alamat`, `tanggal_registrasi`, `expired_date`, `status`, `is_deleted`, `deleted_at`) VALUES
('3281240308000001', '1234567890123457', 'Muhammad Rayhan Fathurrakhman', '081224018624', 'Sanggar Indah Lestari, blok F4 no 4, RT 6/RW 12, Desa Nagrak, Kecamatan Cangkuang, Kab. Bandung, Jawa Barat, Indonesia', '2024-03-08', '2024-05-16', 1, 0, NULL),
('4238240301000002', '1234567890123456', 'Gojo Satoru', '081224018624', 'Jl. Halo halo bandung', '2024-03-01', '2024-04-27', 0, 0, NULL),
('7563240312000003', '1122334455667789', 'Bika ambon', '0829838136', 'unuynjuyjnuy', '2024-03-12', '2024-06-15', 1, 0, NULL),
('9985240416000004', '1234567890123409', 'Gol D. Roger', '081231311213', 'Logue Town', '2024-04-16', '2025-11-01', 1, 1, '2024-04-17 02:25:50');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` varchar(7) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `harga`, `stok`, `is_deleted`, `deleted_at`) VALUES
('BRG0001', 'Pemutih Baju X 250ml', 15000.00, 90, 0, NULL),
('BRG0002', 'Gayung Super Saderek', 9000.00, 4, 0, NULL),
('BRG0003', 'Ikan Girang', 13000.14, 80, 0, NULL),
('BRG0004', 'Boneka Panda', 80000.00, 77, 1, '2024-04-17 01:56:25'),
('BRG0005', 'Member Card', 50000.00, 997, 0, NULL),
('BRG0006', 'Perpanjang Membership 1 Bulan', 10000.00, 2147482580, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` varchar(12) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `member_id` varchar(16) DEFAULT NULL,
  `subtotal_harga` decimal(10,2) NOT NULL,
  `diskon_id` int(11) DEFAULT NULL,
  `diskon` int(3) DEFAULT NULL,
  `cash` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal_transaksi`, `user_id`, `member_id`, `subtotal_harga`, `diskon_id`, `diskon`, `cash`) VALUES
('202404100007', '2024-04-10', 1, '3281240308000001', 18000.00, NULL, NULL, 35000.00),
('202404100014', '2024-04-10', 1, NULL, 95000.28, NULL, NULL, 80000.00),
('202404110001', '2024-04-11', 9, NULL, 18000.00, NULL, NULL, 20000.00),
('202404130001', '2024-04-13', 1, '7563240312000003', 27000.00, NULL, NULL, 30000.00),
('202404130002', '2024-04-13', 1, NULL, 60000.00, NULL, NULL, 60000.00),
('202404130003', '2024-04-13', 1, '4238240301000002', 75000.00, 1, 25, 60000.00),
('202404160001', '2024-04-16', 8, '7563240312000003', 470000.00, 1, 25, 360000.00),
('202404160002', '2024-04-16', 1, '7563240312000003', 10200000.00, 6, 99, 102000.00),
('202404170001', '2024-04-17', 1, '7563240312000003', 45000.00, 1, 25, 35000.00),
('202404170002', '2024-04-17', 9, '7563240312000003', 115000.00, 1, 25, 87000.00);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id` int(11) NOT NULL,
  `transaksi_id` varchar(12) NOT NULL,
  `produk_id` varchar(7) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id`, `transaksi_id`, `produk_id`, `harga_satuan`, `qty`) VALUES
(1, '202404100007', 'BRG0002', 9000.00, 2),
(14, '202404100014', 'BRG0003', 13000.14, 2),
(15, '202404100014', 'BRG0001', 15000.00, 4),
(16, '202404100014', 'BRG0002', 9000.00, 1),
(17, '202404110001', 'BRG0002', 9000.00, 2),
(18, '202404130001', 'BRG0002', 9000.00, 3),
(19, '202404130002', 'BRG0001', 15000.00, 4),
(20, '202404130003', 'BRG0002', 9000.00, 5),
(21, '202404130003', 'BRG0001', 15000.00, 2),
(22, '202404160001', 'BRG0006', 10000.00, 47),
(23, '202404160002', 'BRG0006', 10000.00, 1020),
(24, '202404170001', 'BRG0001', 15000.00, 3),
(25, '202404170002', 'BRG0005', 50000.00, 2),
(26, '202404170002', 'BRG0001', 15000.00, 1);

--
-- Triggers `transaksi_detail`
--
DELIMITER $$
CREATE TRIGGER `kurang_stok` AFTER INSERT ON `transaksi_detail` FOR EACH ROW BEGIN
	update produk set produk.stok = produk.stok - new.qty where id = new.produk_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) UNSIGNED NOT NULL COMMENT '"0" for admin, "1" for petugas',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '0 inactive, 1 active',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `email`, `password`, `role`, `created_at`, `status`, `is_deleted`, `deleted_at`) VALUES
(1, 'M. Rayhan F', 'administrator', 'rayfathur2006@gmail.com', '$2y$10$SdVi/8EjkGEgiukhf7WvrOa47wfTWL4McQhzHWJgRYo9HxeihEU8m', 0, '2024-03-21 02:16:22', 1, 0, NULL),
(8, 'petugas', '123456', 'petugas@gmail.com', '$2y$10$foKgN2fd8s5EHkvj1jj7wO2.APYYf8IMKjblmz22OMhbmft9PPjOS', 1, '2024-03-23 13:30:52', 1, 0, NULL),
(9, 'King Slayer', 'vice_petugas', 'vicepetugas@outlook.com', '$2y$10$4JAVyVKASbnDsQp1EPVZpeQcZPpALBNKKlKPLtQL0Bf.XV8ZpdgRe', 1, '2024-03-23 13:32:11', 1, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diskon`
--
ALTER TABLE `diskon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`member_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `diskon_id` (`diskon_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diskon`
--
ALTER TABLE `diskon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_5` FOREIGN KEY (`diskon_id`) REFERENCES `diskon` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_6` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`);

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_3` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `transaksi_detail_ibfk_5` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
