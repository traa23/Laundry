-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2025 at 10:45 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nama_karyawan` varchar(25) NOT NULL,
  `alamat` varchar(25) NOT NULL,
  `no_hp` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama_karyawan`, `alamat`, `no_hp`) VALUES
(1, 'nopal', 'jl.limbungan', '5465465165'),
(2, 'Exel', 'Bandung', '085266666666'),
(3, 'Azizah', 'rusia', '966655855'),
(4, 'agnes monica', 'bangladesh', '8888777888'),
(5, 'putra', 'new york', '787878787878');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` int(11) NOT NULL,
  `jenis_layanan` varchar(25) NOT NULL,
  `berat` decimal(10,2) NOT NULL,
  `harga` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `jenis_layanan`, `berat`, `harga`) VALUES
(1, 'cuci setrika', '1.00', '6500.00'),
(2, 'cuci', '1.00', '4000.00'),
(3, 'setrika', '1.00', '3500.00'),
(4, 'express', '1.00', '10000.00'),
(5, 'cuci kering', '1.00', '15000.00');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(25) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `no_hp`) VALUES
(1, 'ifood', 'jl.harapanraya', '26545142'),
(2, 'wahyu', 'jl.riau', '56451521'),
(3, 'uni', 'payakumbuh', '45498451'),
(4, 'mangole', 'jakartabarat', '877545432'),
(5, 'nabila', 'jl.utama', '541213216');

-- --------------------------------------------------------

--
-- Table structure for table `transaksilaundry`
--

CREATE TABLE `transaksilaundry` (
  `Id_transaksi` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `total_harga` decimal(7,2) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `metode` varchar(25) NOT NULL,
  `total_berat` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksilaundry`
--

INSERT INTO `transaksilaundry` (`Id_transaksi`, `id_karyawan`, `id_pelanggan`, `id_layanan`, `total_harga`, `tanggal_transaksi`, `status`, `metode`, `total_berat`) VALUES
(1, 1, 2, 3, '7000.00', '2025-06-26', 1, 'cash', '2.00'),
(2, 2, 5, 2, '20000.00', '2025-06-25', 0, 'transfer', '5.00'),
(3, 3, 1, 1, '13000.00', '2025-06-27', 0, 'cash', '2.00'),
(4, 4, 3, 5, '15000.00', '2025-06-17', 1, 'cash', '1.00'),
(5, 5, 4, 4, '50000.00', '2025-06-13', 1, 'transfer', '5.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `transaksilaundry`
--
ALTER TABLE `transaksilaundry`
  ADD PRIMARY KEY (`Id_transaksi`),
  ADD UNIQUE KEY `id_karyawan` (`id_karyawan`,`id_pelanggan`,`id_layanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id_layanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `transaksilaundry`
--
ALTER TABLE `transaksilaundry`
  MODIFY `Id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
