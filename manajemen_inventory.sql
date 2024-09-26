-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 11:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manajemen_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kontak` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `kontak`, `email`, `password`) VALUES
(1, 'Admin Satu', '081234567890', 'admin@example.com', 'f5bb0c8de146c67b44babbf4e6584cc0');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jenis_barang` varchar(50) DEFAULT NULL,
  `kuantitas_stok` int(11) NOT NULL,
  `lokasi_gudang` varchar(100) DEFAULT NULL,
  `barcode` varchar(50) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `storage_unit_id` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `nama_barang`, `jenis_barang`, `kuantitas_stok`, `lokasi_gudang`, `barcode`, `vendor_id`, `storage_unit_id`, `harga`) VALUES
(1, 'DELL XPS NEW', 'Elektronik', 1000, 'Gudang 1', '1020310', 1, 1, 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `storage_unit`
--

CREATE TABLE `storage_unit` (
  `id` int(11) NOT NULL,
  `nama_gudang` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storage_unit`
--

INSERT INTO `storage_unit` (`id`, `nama_gudang`, `lokasi`) VALUES
(1, 'Gudang 1', 'Jl. Rungkut Industri III'),
(2, 'Gudang 2', 'Jl. Merpati'),
(3, 'Gudang 3', 'Jl. Elang');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kontak` varchar(15) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `nomor_invoice` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `nama`, `kontak`, `nama_barang`, `nomor_invoice`) VALUES
(1, 'PT DELL INDONESIA', '0321132', 'DELL XPS NEW', 'JKSDAKJX1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `storage_unit_id` (`storage_unit_id`);

--
-- Indexes for table `storage_unit`
--
ALTER TABLE `storage_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_invoice` (`nomor_invoice`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `storage_unit`
--
ALTER TABLE `storage_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`storage_unit_id`) REFERENCES `storage_unit` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
