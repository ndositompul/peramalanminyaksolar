-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2022 at 08:14 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_peramalan`
--

-- --------------------------------------------------------

--
-- Table structure for table `alpha`
--

CREATE TABLE `alpha` (
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alpha`
--

INSERT INTO `alpha` (`nilai`) VALUES
(0.1);

-- --------------------------------------------------------

--
-- Table structure for table `data_penjualan`
--

CREATE TABLE `data_penjualan` (
  `kd_penjualan` int(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `periode` date NOT NULL,
  `jumlah` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_penjualan`
--

INSERT INTO `data_penjualan` (`kd_penjualan`, `nama`, `periode`, `jumlah`) VALUES
(63, 'Tahun 2020', '2020-12-01', 16220816),
(65, 'Tahun 2021', '2021-12-01', 17289722),
(66, 'Tahun2019', '2019-12-01', 4908653);

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `kd_penjualan` int(11) NOT NULL,
  `periode` varchar(255) NOT NULL,
  `jumlah` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`kd_penjualan`, `periode`, `jumlah`) VALUES
(57, '2019', 4908653),
(58, '2020', 16220816),
(59, '2021', 17289722),
(60, '2022', 0);

-- --------------------------------------------------------

--
-- Table structure for table `peramalan`
--

CREATE TABLE `peramalan` (
  `kd_peramalan` int(255) NOT NULL,
  `periode` date NOT NULL,
  `jumlah` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peramalan`
--

INSERT INTO `peramalan` (`kd_peramalan`, `periode`, `jumlah`) VALUES
(1714, '2019-12-01', 4908653),
(1715, '2020-12-01', 16220816),
(1716, '2021-12-01', 17289722);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` enum('pemilik','admin') NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `role`, `password`) VALUES
(1, 'Adminisitrator', 'admin', 'admin', '$2y$10$wMgi9s3FEDEPEU6dEmbp8eAAEBUXIXUy3np3ND2Oih.MOY.q/Kpoy'),
(7, 'Pimpinan', 'pimpinan', 'pemilik', '$2y$10$YLcUt/RyBJ7hd4Aeg3d8CObylgQ1MG9DW/cQIde.s3bzhcQSDCxke');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alpha`
--
ALTER TABLE `alpha`
  ADD PRIMARY KEY (`nilai`);

--
-- Indexes for table `data_penjualan`
--
ALTER TABLE `data_penjualan`
  ADD PRIMARY KEY (`kd_penjualan`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`kd_penjualan`);

--
-- Indexes for table `peramalan`
--
ALTER TABLE `peramalan`
  ADD PRIMARY KEY (`kd_peramalan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_penjualan`
--
ALTER TABLE `data_penjualan`
  MODIFY `kd_penjualan` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `kd_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `peramalan`
--
ALTER TABLE `peramalan`
  MODIFY `kd_peramalan` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1717;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
