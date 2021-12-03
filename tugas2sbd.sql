-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2021 at 08:53 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tugas2sbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `IdGuru` varchar(4) NOT NULL,
  `namaGuru` varchar(50) NOT NULL,
  `tanggalLahirGuru` date NOT NULL,
  `alamatGuru` varchar(250) NOT NULL,
  `noTelpGuru` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`IdGuru`, `namaGuru`, `tanggalLahirGuru`, `alamatGuru`, `noTelpGuru`) VALUES
('G111', 'Amrulah', '1992-07-09', 'Jalan-jalan', '089999999999'),
('G112', 'Udin cemot', '1952-11-08', 'Jalan raya', '089786756543'),
('G113', 'JanrutLah', '1982-11-05', 'Jalan Kaki', '087676767676');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `IdJadwal` int(11) NOT NULL,
  `hari` varchar(15) NOT NULL,
  `sesi` int(1) NOT NULL,
  `IdKelasMapel` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`IdJadwal`, `hari`, `sesi`, `IdKelasMapel`) VALUES
(11111, 'Senin', 1, 'KM01'),
(11112, 'Selasa', 2, 'KM02'),
(11113, 'Rabu', 3, 'KM03');

-- --------------------------------------------------------

--
-- Table structure for table `kelasmapel`
--

CREATE TABLE `kelasmapel` (
  `IdKelasMapel` varchar(4) NOT NULL,
  `kodeMapel` varchar(4) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `IdGuru` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelasmapel`
--

INSERT INTO `kelasmapel` (`IdKelasMapel`, `kodeMapel`, `kelas`, `IdGuru`) VALUES
('KM01', 'M001', 'Kelas A', 'G111'),
('KM02', 'M002', 'Kelas B', 'G112'),
('KM03', 'M003', 'Kelas C', 'G113');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `kodeMapel` varchar(4) NOT NULL,
  `namaMapel` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`kodeMapel`, `namaMapel`) VALUES
('M001', 'fisika'),
('M002', 'Matematika'),
('M003', 'agama');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `idPresensi` varchar(4) NOT NULL,
  `idSiswa` varchar(4) NOT NULL,
  `IdKelasMapel` varchar(4) NOT NULL,
  `idGuru` varchar(4) NOT NULL,
  `pertemuanKe` int(2) NOT NULL,
  `tanggalPertemuan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`idPresensi`, `idSiswa`, `IdKelasMapel`, `idGuru`, `pertemuanKe`, `tanggalPertemuan`) VALUES
('P01', '1111', 'KM01', 'G111', 1, '2021-12-03'),
('P02', '1112', 'KM02', 'G111', 2, '2021-12-04'),
('P03', '1113', 'KM03', 'G113', 3, '2021-12-07');

-- --------------------------------------------------------

--
-- Table structure for table `registrasikelas`
--

CREATE TABLE `registrasikelas` (
  `IdSiswa` varchar(4) NOT NULL,
  `idKelasMapel` varchar(4) NOT NULL,
  `nilaiAkhir` int(3) DEFAULT NULL,
  `predikat` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registrasikelas`
--

INSERT INTO `registrasikelas` (`IdSiswa`, `idKelasMapel`, `nilaiAkhir`, `predikat`) VALUES
('1111', 'KM01', 90, 'A'),
('1112', 'KM02', 70, 'B'),
('1113', 'KM03', 50, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `idSiswa` varchar(4) NOT NULL,
  `namaSiswa` varchar(50) NOT NULL,
  `tanggalLahirSiswa` date NOT NULL,
  `alamatSiswa` varchar(250) NOT NULL,
  `noTelpSiswa` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`idSiswa`, `namaSiswa`, `tanggalLahirSiswa`, `alamatSiswa`, `noTelpSiswa`) VALUES
('1111', 'Ahmad Jamal', '2002-09-09', 'GG. Angka 10', '081234567890'),
('1112', 'Jamet ku', '2001-11-12', 'Jln.Tol', '08123409876'),
('1113', 'Hamid kus', '2009-12-09', 'GG.lewat', '08987654321'),
('1114', 'dadan', '2019-02-09', 'GG. Angsa', '08666666666'),
('1115', 'Abdul', '2001-07-11', 'GG. Angkasa', '0898989898');

--
-- Triggers `siswa`
--
DELIMITER $$
CREATE TRIGGER `hasil_transaksi` AFTER INSERT ON `siswa` FOR EACH ROW BEGIN 
INSERT INTO viewtransaksi
SET idSiswa = new.idSiswa, Tanggal = now(), Keterangan = 'Lunas';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `viewtransaksi`
--

CREATE TABLE `viewtransaksi` (
  `Iuran` int(10) NOT NULL,
  `idSiswa` varchar(4) CHARACTER SET latin1 NOT NULL,
  `Tanggal` date NOT NULL DEFAULT current_timestamp(),
  `Harga` int(100) NOT NULL DEFAULT 100000,
  `Keterangan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `viewtransaksi`
--

INSERT INTO `viewtransaksi` (`Iuran`, `idSiswa`, `Tanggal`, `Harga`, `Keterangan`) VALUES
(1, '1114', '2021-12-04', 100000, 'Lunas'),
(2, '1115', '2021-12-04', 100000, 'Lunas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`IdGuru`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`IdJadwal`),
  ADD KEY `FK_IdkelasMapel` (`IdKelasMapel`);

--
-- Indexes for table `kelasmapel`
--
ALTER TABLE `kelasmapel`
  ADD PRIMARY KEY (`IdKelasMapel`,`kodeMapel`,`kelas`),
  ADD KEY `kelasmapel_ibfk_1` (`kodeMapel`),
  ADD KEY `kelasmapel_ibfk_2` (`IdGuru`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`kodeMapel`) USING BTREE;

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`idPresensi`,`idSiswa`),
  ADD KEY `fkIdSiswa2` (`idSiswa`),
  ADD KEY `presensi_ibfk_1` (`IdKelasMapel`),
  ADD KEY `presensi_ibfk_2` (`idGuru`);

--
-- Indexes for table `registrasikelas`
--
ALTER TABLE `registrasikelas`
  ADD PRIMARY KEY (`IdSiswa`,`idKelasMapel`),
  ADD KEY `fkIdKelasMapel` (`idKelasMapel`,`IdSiswa`) USING BTREE;

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`idSiswa`);

--
-- Indexes for table `viewtransaksi`
--
ALTER TABLE `viewtransaksi`
  ADD PRIMARY KEY (`Iuran`,`idSiswa`) USING BTREE,
  ADD KEY `idSiswa` (`idSiswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `IdJadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11114;

--
-- AUTO_INCREMENT for table `viewtransaksi`
--
ALTER TABLE `viewtransaksi`
  MODIFY `Iuran` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `FK_IdkelasMapel` FOREIGN KEY (`IdKelasMapel`) REFERENCES `kelasmapel` (`IdKelasMapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelasmapel`
--
ALTER TABLE `kelasmapel`
  ADD CONSTRAINT `kelasmapel_ibfk_1` FOREIGN KEY (`kodeMapel`) REFERENCES `mapel` (`kodeMapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kelasmapel_ibfk_2` FOREIGN KEY (`IdGuru`) REFERENCES `guru` (`IdGuru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `fkIdSiswa2` FOREIGN KEY (`idSiswa`) REFERENCES `siswa` (`idSiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`IdKelasMapel`) REFERENCES `kelasmapel` (`IdKelasMapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presensi_ibfk_2` FOREIGN KEY (`idGuru`) REFERENCES `guru` (`IdGuru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `registrasikelas`
--
ALTER TABLE `registrasikelas`
  ADD CONSTRAINT `fkIdKelasMapel` FOREIGN KEY (`idKelasMapel`) REFERENCES `kelasmapel` (`IdKelasMapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkIdSiswa` FOREIGN KEY (`IdSiswa`) REFERENCES `siswa` (`idSiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `viewtransaksi`
--
ALTER TABLE `viewtransaksi`
  ADD CONSTRAINT `viewtransaksi_ibfk_1` FOREIGN KEY (`idSiswa`) REFERENCES `siswa` (`idSiswa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
