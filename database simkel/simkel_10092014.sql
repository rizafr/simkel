-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2014 at 06:38 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simkel`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_penduduk`
--

CREATE TABLE IF NOT EXISTS `data_penduduk` (
  `no_kk` varchar(30) NOT NULL,
  `nama_kep` varchar(50) NOT NULL,
  `alamat` varchar(30) NOT NULL,
  `rt` int(11) NOT NULL,
  `rw` int(11) NOT NULL,
  `dusun` varchar(30) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `kewarganegaraan` varchar(100) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL,
  `tempat_lahir` varchar(40) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_akta` varchar(30) NOT NULL,
  `gol_darah` varchar(5) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `nama_ibu` varchar(50) NOT NULL,
  `nama_ayah` varchar(50) NOT NULL,
  `status_perkawinan` varchar(50) NOT NULL,
  `id_kelurahan` int(11) NOT NULL,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_penduduk`
--

INSERT INTO `data_penduduk` (`no_kk`, `nama_kep`, `alamat`, `rt`, `rw`, `dusun`, `kode_pos`, `nik`, `kewarganegaraan`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `no_akta`, `gol_darah`, `agama`, `pekerjaan`, `nama_ibu`, `nama_ayah`, `status_perkawinan`, `id_kelurahan`) VALUES
('123', 'tes', 'cibeber', 10, 4, 'cibeber', '40531', '123', 'Indonesia', 'ratih', 'Perempuan', 'garut', '1992-02-04', '634', 'O', 'Islam', 'PNS', 'tes', 'tes', 'Belum Menikah', 3),
('123456', 'Utar', 'Cibeber', 10, 4, 'Cibeber', '40531', '123456', 'Indonesia', 'Ratih', 'Perempuan', 'garut', '1992-06-24', '344', 'O', 'Islam', 'Mahasiswa', 'Nunung H', 'Utar M', 'Belum Menikah', 3),
('2007030420082019', 'Iding Samsudin', 'Jl. Kepatihan No. 16', 12, 5, 'Cikalong', '13550', '2006200720082009', 'Indonesia', 'Hadi Purnomo', 'Perempuan', 'Jember', '1990-11-13', 'B909/Pemb./1605', 'B', 'Islam', 'Wiraswasta', 'Siti Faatimah', 'Iding Samsudin', 'Belum Menikah', 3),
('2002200320102011', 'Sugeng', 'Jl. Pekayon', 12, 5, 'Keworeko', '153467', '2009200812092020', 'Indonesia', 'Raden Ujang Kewo', 'Laki-laki', 'Tangerang', '1992-12-24', 'B909/Pemb./1605', 'O', 'Islam', 'Tani', 'Kolong', 'Kilang', 'Menikah', 3),
('327702088888888', 'RIZAL SULAEMAN', 'CIBEBER', 9, 8, 'CIBEBER', '877', '3277000202020012', 'Indonesia', 'Muhamad Ade', 'Laki-laki', 'CIMAHI', '2002-02-02', 'B909/Pemb./1605', 'A', 'Hindu', 'MAHASISWA', 'NUNUNG', 'UTAR', 'Menikah', 3),
('2345', 'Utar', 'Cibeber', 10, 4, 'Cibeber', '40531', '345678', 'Indonesia', 'Ratih Pujihati', 'Perempuan', 'Garut', '1992-02-04', '42321', 'O', 'Islam', 'Mahasiswa', 'nunung', 'utar', 'Belum Menikah', 3),
('123', 'qw', 'qwe', 2, 1, 'buaya kali', '12490', '87654321234567', 'Indonesia', 'Mamad Kenyod', 'Laki-laki', 'Jember', '1992-12-31', 'Akta/.323./lahir', 'O', 'Islam', 'Wiraswasta', 'Siti Faatimah', 'Iding Samsudin', 'Menikah', 3),
('2', 'w', 'e', 1, 1, 'k', '0', '9', 'Indonesia', 'i', 'Laki-laki', 'g', '1999-08-09', '8', 'O', 'Islam', 'u', 'u', 'u', 'Menikah', 3);

-- --------------------------------------------------------

--
-- Table structure for table `histori`
--

CREATE TABLE IF NOT EXISTS `histori` (
  `id_histori` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_layanan` varchar(150) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `rt` varchar(3) NOT NULL,
  `rw` varchar(3) NOT NULL,
  `id_pengguna` varchar(100) NOT NULL,
  `status` int(3) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_histori`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `histori`
--

INSERT INTO `histori` (`id_histori`, `jenis_layanan`, `nik`, `rt`, `rw`, `id_pengguna`, `status`, `tgl_dibuat`) VALUES
(1, 'Permintaan Rumah Sakit', '2006200720082009', '12', '5', 'Riza', 0, '0000-00-00 00:00:00'),
(2, 'Permintaan Rumah Sakit', '2006200720082009', '12', '5', '11', 0, '0000-00-00 00:00:00'),
(3, 'Permintaan Rumah Sakit', '2006200720082009', '12', '5', '11', 0, '0000-00-00 00:00:00'),
(4, 'Permintaan Rumah Sakit', '2009200812092020', '12', '5', '11', 0, '0000-00-00 00:00:00'),
(5, 'Permintaan Rumah Sakit', '345678', '10', '4', '12', 0, '2014-09-01 02:57:22'),
(6, 'Permintaan Rumah Sakit', '345678', '10', '4', '12', 0, '2014-09-01 02:57:57');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pengguna`
--

CREATE TABLE IF NOT EXISTS `jenis_pengguna` (
  `id_jenis_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis_pengguna` varchar(100) NOT NULL,
  PRIMARY KEY (`id_jenis_pengguna`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `jenis_pengguna`
--

INSERT INTO `jenis_pengguna` (`id_jenis_pengguna`, `nama_jenis_pengguna`) VALUES
(1, 'Admin'),
(2, 'Umum'),
(3, 'Ketua Pemberdayaan'),
(4, 'Ketua Ketentraman Ketertiban'),
(5, 'Ketua Ekonomi Pembangunan'),
(6, 'Ketua Pemerintahan'),
(7, 'Sekretaris Lurah'),
(8, 'Kepala Kelurahan');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_surat`
--

CREATE TABLE IF NOT EXISTS `jenis_surat` (
  `id_jenis_surat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis_surat` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jenis_surat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `jenis_surat`
--

INSERT INTO `jenis_surat` (`id_jenis_surat`, `nama_jenis_surat`) VALUES
(1, 'Pemberdayaan'),
(2, 'Ketentraman Ketertiban'),
(3, 'Ekonomi Pembangunan'),
(4, 'Pemerintahan');

-- --------------------------------------------------------

--
-- Table structure for table `kelurahan`
--

CREATE TABLE IF NOT EXISTS `kelurahan` (
  `id_kelurahan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelurahan` varchar(100) NOT NULL,
  `nama_lurah` varchar(100) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  PRIMARY KEY (`id_kelurahan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `kelurahan`
--

INSERT INTO `kelurahan` (`id_kelurahan`, `nama_kelurahan`, `nama_lurah`, `kecamatan`, `alamat`, `no_telepon`, `kode_pos`) VALUES
(3, 'Leuwigajah', 'Kepala Kelurahan', 'CIMAHI SELATAN', 'Jl. Terusan no. 45', '(022)08137890', '15355');

-- --------------------------------------------------------

--
-- Table structure for table `no_registrasi`
--

CREATE TABLE IF NOT EXISTS `no_registrasi` (
  `id_no_reg` int(11) NOT NULL AUTO_INCREMENT,
  `no_registrasi` varchar(15) NOT NULL,
  `nik` varchar(15) NOT NULL,
  PRIMARY KEY (`id_no_reg`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `no_registrasi`
--

INSERT INTO `no_registrasi` (`id_no_reg`, `no_registrasi`, `nik`) VALUES
(2, 'AN0001', '200620072008200'),
(3, 'AN0002', '200620072008200'),
(4, 'AN0003', '200920081209202'),
(5, 'AN0004', '200620072008200'),
(6, 'AN0005', '200620072008200'),
(7, 'AN0006', '200620072008200'),
(8, 'AN0007', '200620072008200'),
(9, 'AN0008', '200620072008200'),
(10, 'AN0009', '200620072008200'),
(11, 'AN0010', '200620072008200'),
(12, 'AN0011', '200920081209202'),
(13, 'AN0012', '200620072008200'),
(14, 'AN0013', '200620072008200'),
(15, 'AN0014', '200620072008200'),
(16, 'AN0015', '200920081209202'),
(17, 'RS0016', '200620072008200'),
(18, 'RS0017', '200620072008200'),
(19, 'RS0018', '200620072008200'),
(20, 'SS0019', '200620072008200'),
(21, 'SS0020', '200620072008200'),
(22, 'SS0021', '200620072008200'),
(23, 'SS0022', '200620072008200'),
(24, 'SS0023', '200620072008200'),
(25, '4000024', '200620072008200'),
(26, '4000024', '200620072008200'),
(27, 'RS0024', '200620072008200'),
(28, 'BM0024', '200620072008200'),
(29, 'BM0024', '200620072008200'),
(30, 'BM0024', '200620072008200'),
(31, 'BM0024', '200620072008200'),
(32, 'BM0024', '200620072008200'),
(33, 'BM0024', '200620072008200'),
(34, 'BM0024', '200620072008200'),
(35, 'RS0024', '200620072008200'),
(36, 'RS0025', '200620072008200'),
(37, '4000026', '200620072008200'),
(38, 'BM0027', '200620072008200'),
(39, 'RS0028', '200620072008200'),
(40, 'BM0029', '200620072008200'),
(41, 'RS0030', '200620072008200'),
(42, '4000031', '200620072008200'),
(43, 'RS0032', '200620072008200'),
(44, 'RS0032', '200620072008200'),
(45, 'BM0033', '200620072008200'),
(46, 'BPR0034', '200620072008200'),
(47, 'BPR0035', '200620072008200'),
(48, 'BPR0036', '200620072008200'),
(49, 'BPR0037', '200620072008200'),
(50, 'BPR0038', '200620072008200'),
(51, 'IH0001', '200620072008200'),
(52, 'IH0001', '200620072008200'),
(53, 'J0001', '200620072008200'),
(54, 'J0001', '200620072008200'),
(55, 'J0001', '200620072008200'),
(56, 'LA0001', '200620072008200'),
(57, 'LA0001', '200620072008200'),
(58, 'MTI0039', '200620072008200'),
(59, 'IKR0040', '200620072008200'),
(60, 'BDR0041', '200620072008200'),
(61, 'BDR0042', '200620072008200'),
(62, 'BDR0043', '200620072008200'),
(63, 'BDR0044', '200620072008200'),
(64, 'BDR0045', '200620072008200'),
(65, 'SKC0046', '200620072008200');

-- --------------------------------------------------------

--
-- Table structure for table `pejabat_kelurahan`
--

CREATE TABLE IF NOT EXISTS `pejabat_kelurahan` (
  `id_pejabat` int(11) NOT NULL AUTO_INCREMENT,
  `nip_pejabat` varchar(20) NOT NULL,
  `nama_pejabat` varchar(100) NOT NULL,
  `id_kelurahan` int(11) NOT NULL,
  `id_jenis_pengguna` int(11) NOT NULL,
  PRIMARY KEY (`id_pejabat`),
  KEY `fk_1` (`id_kelurahan`),
  KEY `fk_2` (`id_jenis_pengguna`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pejabat_kelurahan`
--

INSERT INTO `pejabat_kelurahan` (`id_pejabat`, `nip_pejabat`, `nama_pejabat`, `id_kelurahan`, `id_jenis_pengguna`) VALUES
(1, '2005200690954584', 'Pemberdaya, MT', 3, 3),
(3, '1992062420140910001', 'Trantib, ST', 3, 4),
(4, '19890989200409120001', 'Ekbang, SE', 3, 5),
(5, '19922406201409010001', 'Pemerintahan, S.Kom', 3, 6),
(6, '197860720018908001', 'Lurah Leuwigajah', 3, 8),
(7, '198702232001908002', 'Seklur', 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE IF NOT EXISTS `pengguna` (
  `id_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis_pengguna` int(11) NOT NULL,
  `id_kelurahan` int(11) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `nip_pengguna` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pengguna`),
  KEY `fk_3` (`id_kelurahan`),
  KEY `fk_4` (`id_jenis_pengguna`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `id_jenis_pengguna`, `id_kelurahan`, `nama_pengguna`, `nip_pengguna`, `username`, `password`) VALUES
(10, 1, 3, 'Admin', '1005200898789587', 'admin', 'admin'),
(11, 2, 3, 'Umum, S.Kom', '2004200398767656', 'umum', 'umum'),
(12, 3, 3, 'Pemberdaya, MT', '2005200690954584', 'pemberdaya', 'pemberdaya'),
(14, 4, 3, 'Trantib, ST', '1992062420140910001', 'trantib', 'trantib'),
(15, 5, 3, 'Ekbang, SE', '19890989200409120001', 'ekbang', 'ekbang'),
(16, 6, 3, 'Pemerintahan, S.Kom', '19922406201409010001', 'pemerintah', 'pemerintah'),
(17, 7, 3, 'Seklur', '198702232001908002', 'seklur', 'seklur'),
(18, 8, 3, 'Lurah Leuwigajah', '197860720018908001', 'lurah', 'lurah');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_andonnikah`
--

CREATE TABLE IF NOT EXISTS `permintaan_andonnikah` (
  `id_permintaan_andonnikah` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) NOT NULL,
  `no_registrasi` varchar(50) NOT NULL,
  `no_surat` varchar(100) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `nama_pasangan` varchar(50) DEFAULT NULL,
  `alamat_pasangan` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` varchar(100) DEFAULT NULL,
  `id_jenis_surat` int(10) NOT NULL,
  `id_surat` int(10) NOT NULL,
  `id_pengguna` int(10) NOT NULL,
  PRIMARY KEY (`id_permintaan_andonnikah`),
  KEY `fk_5` (`id_kelurahan`),
  KEY `fk_9` (`nik`),
  KEY `fk_38` (`id_pejabat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `permintaan_andonnikah`
--

INSERT INTO `permintaan_andonnikah` (`id_permintaan_andonnikah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_registrasi`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `nama_pasangan`, `alamat_pasangan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`) VALUES
(21, 3, 1, '2006200720082009', 'AN0010', '400 / AN0010 / KEL.LG', '2014-09-03', 'S290-7bd-900/pemb.', '2014-09-03', 'Julaeha', 'kampung kidul', 3, '15:09:17', '15:09:17', '11', '15:09:27', '11', '15:09:29', '8 jam 9 menit29 detik', 1, 3, 11),
(22, 3, 4, '2009200812092020', 'AN0011', '400 / AN0011 / KEL.LG', '2014-09-03', 'S290-7bd-900/pemb.', '2014-09-03', 'Julaeha ss', 'kampung kidul', 3, '15:10:01', '15:10:01', '11', '15:10:12', '11', '15:09:16', '8 jam 9 menit 16 detik ', 1, 3, 11),
(23, 3, 1, '2006200720082009', 'AN0012', '400 / AN0012 / KEL.LG', '2014-09-03', 'pengsu/pemk/12.p', '2014-09-04', 'Julaeha ss', 'kampung kidul', 3, '15:13:17', '15:13:17', '11', '15:13:27', '11', '15:13:28', '8 jam 13 menit 28 detik ', 1, 3, 11),
(24, 3, 1, '2006200720082009', 'AN0013', '400 / AN0013 / KEL.LG', '2014-09-03', 'S290-7bd-900/pemb.', '2014-09-02', 'Julaeha', 'kampung kidul', 3, '15:37:56', '15:37:56', '11', '16:43:55', '11', '16:44:12', '9 jam 44 menit 12 detik ', 1, 3, 11),
(25, 3, 1, '2006200720082009', 'AN0014', '400 / AN0014 / KEL.LG', '2014-09-03', 'S290-7bd-900/pemb.', '2014-09-03', 'Julaeha ss', 'kampung kidul', 3, '16:08:54', '16:08:54', '11', '16:44:08', '11', '16:44:15', '9 jam 44 menit 15 detik ', 1, 3, 11),
(26, 3, 1, '2009200812092020', 'AN0015', '400 / AN0015 / KEL.LG', '2014-09-03', 'S290-7bd-900/pemb.', '2014-09-03', 'Julaeha ss', 'cirebon', 3, '16:18:45', '16:18:45', '11', '16:25:21', '11', '16:44:17', '9 jam 44 menit 17 detik ', 1, 3, 11),
(27, 3, 1, '2006200720082009', '4000024', '400 / 4000024 / KEL.LG', '2014-09-07', 'S290-7bd-900/pemb.', '2014-09-03', 'Julaeha ss', 'kampung kidul', 3, '19:26:31', '19:26:31', 'Umum', '19:56:13', 'Umum', '09:22:02', '2 jam 22 menit 2 detik ', 1, 3, 11);

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_bd`
--

CREATE TABLE IF NOT EXISTS `permintaan_bd` (
  `id_permintaan_bd` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `alamat_ayah` varchar(100) DEFAULT NULL,
  `pekerjaan_ayah` varchar(50) DEFAULT NULL,
  `agama_ayah` varchar(50) DEFAULT NULL,
  `alamat_ibu` varchar(100) DEFAULT NULL,
  `pekerjaan_ibu` varchar(50) DEFAULT NULL,
  `agama_ibu` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `keperluan` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_bd`),
  UNIQUE KEY `alamat_ibu` (`alamat_ibu`),
  KEY `fk_11` (`id_kelurahan`),
  KEY `fk_12` (`id_pejabat`),
  KEY `fk_8` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_bd`
--

INSERT INTO `permintaan_bd` (`id_permintaan_bd`, `id_kelurahan`, `id_pejabat`, `nik`, `alamat_ayah`, `pekerjaan_ayah`, `agama_ayah`, `alamat_ibu`, `pekerjaan_ibu`, `agama_ibu`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(1, 3, 3, '2006200720082009', 'majalaya', 'Petani', 'Islam', 'majalaya', 'Petani', 'Islam', '460/0077/Pembd./s2013', '2014-01-02', 'S290-7b.d-900/pemb', '2014-01-29', 'Beli Rumah', 1, '00:00:00', '00:00:00', 'petugas', '00:00:00', 'petugas', '00:00:00', 0, 2, 9, 14, '98'),
(2, 3, 3, '2006200720082009', 'ayah', 'guru', 'islam', 'cimahi', 'ibu rumah tangga', 'Islam', '290-Bd/pemb.', '2014-01-21', 'abcd', '2014-08-29', 'Bersih Diri', 1, '00:00:00', '00:00:00', 'petugas', '00:00:00', 'petugas', '00:00:00', 0, 2, 9, 14, '99'),
(3, 3, 1, '2006200720082009', 'cimahi', 'pns', 'islam', 'cibeber', 'pns', 'islam', '400 / BDR0045 / KEL.LG', '2014-09-10', 'S290-7bd-900/pemb.', '2014-09-11', 'bangun usaha', 2, '10:57:50', '10:57:50', 'Umum, S.Kom', '11:02:04', 'Umum, S.Kom', NULL, NULL, 1, 3, 11, 'BDR0045');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_belummenikah`
--

CREATE TABLE IF NOT EXISTS `permintaan_belummenikah` (
  `id_permintaan_belummenikah` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `keperluan` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_belummenikah`),
  KEY `fk_13` (`id_kelurahan`),
  KEY `fk_14` (`id_pejabat`),
  KEY `fk_15` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `permintaan_belummenikah`
--

INSERT INTO `permintaan_belummenikah` (`id_permintaan_belummenikah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(6, 3, 1, '123456', '230-Nik4h/pemb2.', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-29', 'Menikah', 1, '08:00:00', '08:00:00', 'umum,S.Kom', '08:10:00', 'umum, S.Kom', '08:20:00', 20, 1, 4, 11, '8'),
(7, 3, 1, '2009200812092020', '230-Nik4h/pemb2.', '2014-01-08', 'S290-7bd-900/pemb.', '2014-01-29', 'Menikah', 1, '08:00:00', '08:00:00', 'umum,S.Kom', '08:10:00', 'umum, S.Kom', '08:20:00', 20, 1, 4, 11, '8'),
(8, 3, 1, '2006200720082009', NULL, NULL, 'S290-7bd-900/pemb.', '2014-09-24', 'bangun usaha', 3, '10:05:52', '10:05:52', 'Umum, S.Kom', '11:11:20', 'Umum, S.Kom', '11:16:41', 4, 1, 3, 11, 'BM0024'),
(9, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, 1, '10:08:03', '10:08:03', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'BM0024'),
(10, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, 1, '10:08:40', '10:08:40', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'BM0024'),
(11, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, 1, '10:09:36', '10:09:36', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'BM0024'),
(12, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, 1, '10:09:50', '10:09:50', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'BM0024'),
(13, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, 1, '10:11:22', '10:11:22', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'BM0024'),
(14, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, 1, '10:13:33', '10:13:33', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'BM0024'),
(15, 3, 1, '2006200720082009', NULL, NULL, 'sas', '0000-00-00', 'aa', 3, '10:26:55', '10:26:55', 'Umum, S.Kom', '11:08:55', 'Umum, S.Kom', '11:16:49', 4, 1, 3, 11, 'BM0027'),
(16, 3, 3, '2006200720082009', NULL, NULL, 'sas', '0000-00-00', 'aa', 3, '10:29:42', '10:29:42', 'Umum, S.Kom', '11:08:22', 'Umum, S.Kom', '11:21:18', 4, 1, 3, 11, 'BM0029'),
(17, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, 1, '13:32:12', '13:32:12', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'BM0033');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_bpr`
--

CREATE TABLE IF NOT EXISTS `permintaan_bpr` (
  `id_permintaan_bpr` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `no_registrasi` varchar(15) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `keperluan` varchar(100) DEFAULT NULL,
  `stl` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_bpr`),
  KEY `fk_16` (`id_kelurahan`),
  KEY `fk_17` (`id_pejabat`),
  KEY `fk_18` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `permintaan_bpr`
--

INSERT INTO `permintaan_bpr` (`id_permintaan_bpr`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `no_registrasi`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `stl`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`) VALUES
(7, 3, 1, '2006200720082009', '400 / BPR0036 / KEL.LG', 'BPR0036', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-17', 'bangun usaha', 'serumah', 3, '13:37:51', '13:37:51', 'Umum, S.Kom', '13:55:44', 'Umum, S.Kom', '13:55:46', 6, 1, 3, 11),
(8, 3, 1, '2006200720082009', '400 / BPR0037 / KEL.LG', 'BPR0037', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-11', 'bangun usaha', 'serumah', 3, '13:38:55', '13:38:55', 'Umum, S.Kom', '13:55:18', 'Umum, S.Kom', '13:55:22', 6, 1, 3, 11),
(9, 3, 1, '2006200720082009', '400 / BPR0038 / KEL.LG', 'BPR0038', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-09', 'bangun usaha', 'serumah', 3, '13:39:42', '13:39:42', 'Umum, S.Kom', '13:49:58', 'Umum, S.Kom', '13:55:03', 6, 1, 3, 11);

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_domisili_parpol`
--

CREATE TABLE IF NOT EXISTS `permintaan_domisili_parpol` (
  `id_permintaan_domisili_parpol` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `keperluan` varchar(100) DEFAULT NULL,
  `masa_berlaku` date DEFAULT NULL,
  `nama_parpol` varchar(150) DEFAULT NULL,
  `bergerak_bidang` varchar(100) DEFAULT NULL,
  `jumlah_anggota` int(100) DEFAULT NULL,
  `jam_kerja` varchar(50) DEFAULT NULL,
  `alamat_parpol` varchar(150) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_domisili_parpol`),
  KEY `fk_43` (`id_kelurahan`),
  KEY `fk_44` (`id_pejabat`),
  KEY `fk_45` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `permintaan_domisili_parpol`
--

INSERT INTO `permintaan_domisili_parpol` (`id_permintaan_domisili_parpol`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `masa_berlaku`, `nama_parpol`, `bergerak_bidang`, `jumlah_anggota`, `jam_kerja`, `alamat_parpol`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(6, 3, 4, '2006200720082009', '21', '2014-02-05', 'pengsu/pemk/12.p', '2014-02-26', 'bangun usaha', '2014-02-26', 'Partai Politik', 'Asuransi', 12, '24', 'Jl.teuing', 1, '00:00:00', '00:00:00', 'petugas', '00:00:00', 'petugas', '00:00:00', 0, 3, 21, 15, '21'),
(7, 3, 4, '123456', '21', '2014-02-05', 'pengsu/pemk/12.p', '2014-02-26', 'bangun usaha', '2014-02-26', 'Partai Politik', 'Asuransi', 12, '24', 'Jl.teuing', 1, '00:00:00', '00:00:00', 'petugas', '00:00:00', 'petugas', '00:00:00', 0, 3, 21, 15, '22'),
(8, 3, 4, '123456', '21', '2014-02-08', 'pengsu/pemk/12.p', '2014-02-26', 'bangun usaha', '2014-02-26', 'Partai Politik', 'Asuransi', 12, '24', 'Jl.teuing', 1, '00:00:00', '00:00:00', 'petugas', '00:00:00', 'petugas', '00:00:00', 0, 3, 21, 15, '22');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_domisili_perusahaan`
--

CREATE TABLE IF NOT EXISTS `permintaan_domisili_perusahaan` (
  `id_permintaan_domisili_perusahaan` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `keperluan` varchar(50) DEFAULT NULL,
  `masa_berlaku` date DEFAULT NULL,
  `nama_perusahaan` varchar(150) DEFAULT NULL,
  `jenis_perusahaan` varchar(100) DEFAULT NULL,
  `bergerak_bidang` varchar(100) DEFAULT NULL,
  `notaris` varchar(200) DEFAULT NULL,
  `no_notaris` varchar(20) DEFAULT NULL,
  `tanggal_notaris` date DEFAULT NULL,
  `jumlah_pegawai` int(11) DEFAULT NULL,
  `jam_kerja` varchar(100) DEFAULT NULL,
  `alamat_usaha` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_domisili_perusahaan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `permintaan_domisili_perusahaan`
--

INSERT INTO `permintaan_domisili_perusahaan` (`id_permintaan_domisili_perusahaan`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `masa_berlaku`, `nama_perusahaan`, `jenis_perusahaan`, `bergerak_bidang`, `notaris`, `no_notaris`, `tanggal_notaris`, `jumlah_pegawai`, `jam_kerja`, `alamat_usaha`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(7, 3, 1, '2006200720082009', 'sdy/pem.120/kok', '2014-02-05', 'pengsu/pemk/12.p', '2014-02-27', 'bangun usaha', '2014-02-05', 'Sapei Foundation', 'Asuransi', 'Asuransi', 'jantungan', '1222/se.sds', '2014-02-26', 13, '45', 'jantung lewat pinggir', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_domisili_yayasan`
--

CREATE TABLE IF NOT EXISTS `permintaan_domisili_yayasan` (
  `id_permintaan_domisili_yayasan` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `keperluan` varchar(100) DEFAULT NULL,
  `masa_berlaku` date DEFAULT NULL,
  `nama_yayasan` varchar(150) DEFAULT NULL,
  `bergerak_bidang` varchar(100) DEFAULT NULL,
  `jumlah_anggota` int(100) DEFAULT NULL,
  `jam_kerja` varchar(50) DEFAULT NULL,
  `alamat_usaha` varchar(150) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_domisili_yayasan`),
  KEY `fk_40` (`id_kelurahan`),
  KEY `fk_41` (`id_pejabat`),
  KEY `fk_42` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_domisili_yayasan`
--

INSERT INTO `permintaan_domisili_yayasan` (`id_permintaan_domisili_yayasan`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `masa_berlaku`, `nama_yayasan`, `bergerak_bidang`, `jumlah_anggota`, `jam_kerja`, `alamat_usaha`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(3, 3, 1, '2006200720082009', 'sdy/pem.120/kotaa', '2014-02-04', 'pengsu/pemk/12.p', '2014-02-04', 'bangun usaha', '2014-02-14', 'serba ada', 'dagang', 12, '12', 'Jember', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_ibadahhaji`
--

CREATE TABLE IF NOT EXISTS `permintaan_ibadahhaji` (
  `id_permintaan_ibadahhaji` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `rt` int(11) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_ibadahhaji`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `permintaan_ibadahhaji`
--

INSERT INTO `permintaan_ibadahhaji` (`id_permintaan_ibadahhaji`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-29', 'S290-7bd-900/pemb.', 0, '2014-01-28', 1, '08:00:00', '08:10:00', 'Umum, S.Kom', '08:15:00', 'Umum, S.Kom', '08:20:00', 20, 1, 6, 11, '4'),
(4, 3, 1, '2009200812092020', '400 / 4 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', 3, '2014-09-03', 2, '08:00:00', '08:10:00', 'Umum, S.Kom', NULL, 'Umum, S.Kom', '08:20:00', 20, 1, 3, 11, '4'),
(5, 3, 1, '3277000202020012', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 3, '2014-01-04', 1, '08:00:00', '08:10:00', 'Umum, S.Kom', '08:15:00', 'Umum, S.Kom', '08:20:00', 20, 1, 6, 11, '4'),
(7, 3, 1, '2006200720082009', '400 / IH0001 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', NULL, '2014-09-24', 3, '14:47:53', '14:47:53', 'Umum, S.Kom', NULL, 'Umum, S.Kom', '15:04:23', 8, 1, 3, 11, 'IH0001');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_ik`
--

CREATE TABLE IF NOT EXISTS `permintaan_ik` (
  `id_permintaan_ik` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `hari_kegiatan` varchar(100) DEFAULT NULL,
  `tanggal_kegiatan` date DEFAULT NULL,
  `waktu` varchar(50) DEFAULT NULL,
  `nama_kegiatan` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_ik`),
  KEY `fk_22` (`id_kelurahan`),
  KEY `fk_23` (`id_pejabat`),
  KEY `fk_24` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `permintaan_ik`
--

INSERT INTO `permintaan_ik` (`id_permintaan_ik`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `hari_kegiatan`, `tanggal_kegiatan`, `waktu`, `nama_kegiatan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(4, 3, 1, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-29', 'Senin', '2014-01-23', '13:00 - 14:00', 'Reuni Masal', 1, '08:00:00', '08:05:00', 'Umum, S.Kom', '08:20:00', 'Umum, S.Kom', '08:25:00', 25, 2, 7, 11, '32'),
(5, 3, 1, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', 'Rabu', '2014-01-29', '12:00 - 15:00', 'Reuni Masal', 1, '08:00:00', '08:05:00', 'Umum, S.Kom', '08:10:00', 'Umum, S.Kom', '08:30:00', 30, 2, 7, 11, '13'),
(6, 3, 1, '123456', '460/0077/Pembd./2013', '2014-01-18', 'S290-7bd-900/pemb.', '2014-01-01', 'Kamis', '2014-01-30', '12:00 - 15:00', 'Acara Karang Taruna', 1, '08:00:00', '08:05:00', 'Umum, S.Kom', '08:10:00', 'Umum, S.Kom', '08:30:00', 30, 2, 7, 11, '13'),
(7, 3, 1, '2006200720082009', '400 / IKR0040 / KEL.LG', '2014-09-10', 'S290-7bd-900/pemb.', '2014-09-10', 'a', '2014-09-18', '13:00 - 14:00', 'aa', 3, '09:56:03', '09:56:03', 'Umum, S.Kom', '09:57:40', 'Umum, S.Kom', '09:58:01', 2, 1, 3, 11, 'IKR0040');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_janda`
--

CREATE TABLE IF NOT EXISTS `permintaan_janda` (
  `id_permintaan_janda` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `sebab_janda` varchar(50) DEFAULT NULL,
  `keperluan` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_janda`),
  KEY `fk_35` (`id_kelurahan`),
  KEY `fk_36` (`id_pejabat`),
  KEY `fk_37` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `permintaan_janda`
--

INSERT INTO `permintaan_janda` (`id_permintaan_janda`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `sebab_janda`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(6, 3, 1, '2009200812092020', '400 / 21 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-11', 'meningga;', 'bangun usaha', 3, '08:00:00', '08:00:00', 'umum', '16:49:58', 'Umum, S.Kom', '16:50:24', 9, 1, 3, 11, '21'),
(7, 3, 1, '123456', '400 / 21 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-10', 'meningga;', 'bangun usaha', 3, '08:00:00', '08:00:00', 'umum', '16:50:37', 'Umum, S.Kom', '16:50:40', 9, 1, 3, 11, '21'),
(8, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-04', 'S290-7bd-900/pemb.', '2014-01-01', 'KDRT', 'Beli Rumah haji', 1, '08:00:00', '08:00:00', 'umum', '08:15:00', 'umum', '08:20:00', 0, 1, 19, 11, '21'),
(10, 3, 1, '2006200720082009', '400 / J0001 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-10', 'meningga;', 'bangun usaha', 3, '16:46:18', '16:46:18', 'Umum, S.Kom', '16:47:28', 'Umum, S.Kom', '16:47:31', 9, 1, 3, 11, 'J0001');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_keterangan_tempat_usaha`
--

CREATE TABLE IF NOT EXISTS `permintaan_keterangan_tempat_usaha` (
  `id_permintaan_keterangan_tempat_usaha` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `bidang_usaha` varchar(100) DEFAULT NULL,
  `alamat_usaha` varchar(100) DEFAULT NULL,
  `masa_berlaku` date DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_keterangan_tempat_usaha`),
  KEY `fk_46` (`id_kelurahan`),
  KEY `fk_47` (`id_pejabat`),
  KEY `fk_48` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `permintaan_keterangan_tempat_usaha`
--

INSERT INTO `permintaan_keterangan_tempat_usaha` (`id_permintaan_keterangan_tempat_usaha`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `bidang_usaha`, `alamat_usaha`, `masa_berlaku`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(6, 3, 1, '2006200720082009', 'sdy/pem.120/kotaw', '2014-02-12', 'pengsu/pemk/12.p', 'Tani', 'Jl. Tau', '2014-02-05', '2014-02-11', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_lahir`
--

CREATE TABLE IF NOT EXISTS `permintaan_lahir` (
  `id_permintaan_lahir` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `rt` int(11) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `rw` varchar(5) DEFAULT NULL,
  `nama_anak` varchar(200) DEFAULT NULL,
  `jenis_kelamin_anak` varchar(50) DEFAULT NULL,
  `tempat_lahir_anak` varchar(150) DEFAULT NULL,
  `tgl_lahir_anak` date DEFAULT NULL,
  `anak_ke` int(11) DEFAULT NULL,
  `jam_lahir` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) NOT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_lahir`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `permintaan_lahir`
--

INSERT INTO `permintaan_lahir` (`id_permintaan_lahir`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `rw`, `nama_anak`, `jenis_kelamin_anak`, `tempat_lahir_anak`, `tgl_lahir_anak`, `anak_ke`, `jam_lahir`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', '05', 'riza', 'laki-laki', 'cimahi', '2014-08-30', 2, '23:59', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL),
(4, 3, 5, '2006200720082009', NULL, '2014-09-09', 'S290-7bd-900/pemb.', NULL, '2014-09-11', NULL, 'riza', 'Perempuan', 'cimahi', NULL, 1, '23:33', 3, '19:51:38', '19:51:38', 'Umum, S.Kom', '19:54:29', 'Umum, S.Kom', '19:57:43', 12, 1, 3, 11, 'LA0001'),
(5, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '20:01:13', '20:01:13', 'Umum, S.Kom', NULL, NULL, NULL, NULL, 0, NULL, 11, 'LA0001');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_mati`
--

CREATE TABLE IF NOT EXISTS `permintaan_mati` (
  `id_permintaan_mati` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `tanggal_meninggal` date DEFAULT NULL,
  `jam_meninggal` varchar(10) DEFAULT NULL,
  `lokasi_meninggal` varchar(150) DEFAULT NULL,
  `penyebab_meninggal` varchar(100) DEFAULT NULL,
  `usia_meninggal` int(11) DEFAULT NULL,
  `keperluan` varchar(150) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_mati`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `permintaan_mati`
--

INSERT INTO `permintaan_mati` (`id_permintaan_mati`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `tanggal_meninggal`, `jam_meninggal`, `lokasi_meninggal`, `penyebab_meninggal`, `usia_meninggal`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(3, 3, 1, '2009200812092020', '400 /  / KEL.LG', '2014-09-09', 'pengsu/pemk/12.p', '2014-09-25', '2014-09-04', '12:23', '2014-09-04', 'kejang-kejang', 32, 'bangun usaha', 3, '00:00:00', '00:00:00', '', '20:26:05', 'Umum, S.Kom', '20:27:15', 13, 1, 3, 0, NULL),
(4, 3, 5, '2006200720082009', '400 / MTI0039 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-17', '2014-09-25', '12:23', '2014-09-25', 'kejang-kejang', 32, 'Pengurusan Ke Taspen', 0, '20:23:43', '20:23:43', 'Umum, S.Kom', '20:24:52', 'Umum, S.Kom', NULL, NULL, 1, 3, 11, 'MTI0039');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_ps`
--

CREATE TABLE IF NOT EXISTS `permintaan_ps` (
  `id_permintaan_ps` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_registrasi` varchar(100) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `keperluan` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_ps`),
  KEY `fk_25` (`id_kelurahan`),
  KEY `fk_26` (`id_pejabat`),
  KEY `fk_27` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `permintaan_ps`
--

INSERT INTO `permintaan_ps` (`id_permintaan_ps`, `id_kelurahan`, `id_pejabat`, `nik`, `no_registrasi`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`) VALUES
(6, 3, 3, '2006200720082009', NULL, '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', 'Beli Rumah', 1, '08:00:00', '08:00:00', 'petugas', '08:10:00', 'petugas', '08:20:00', 0, 2, 8, 14),
(7, 3, 3, '123', NULL, '20', '2014-08-22', '21', '2014-08-14', 'melamar kerja', 1, '08:00:00', '08:00:00', 'petugas', '08:10:00', 'petugas', '08:20:00', 0, 2, 8, 14),
(8, 3, 3, '123456', NULL, '20', '2014-08-22', '21', '2014-08-14', 'melamar kerja', 1, '08:00:00', '08:00:00', 'petugas', '08:10:00', 'petugas', '08:20:00', 0, 2, 8, 14),
(9, 3, 1, '2006200720082009', 'SKC0046', '400 / SKC0046 / KEL.LG', '2014-09-10', 'S290-7bd-900/pemb.', '2014-09-04', 'bangun usaha', 3, '11:28:33', '11:28:33', 'Umum, S.Kom', '11:29:42', 'Umum, S.Kom', '11:29:44', 4, 1, 3, 11);

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_rumahsakit`
--

CREATE TABLE IF NOT EXISTS `permintaan_rumahsakit` (
  `id_permintaan_rumahsakit` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_kip` varchar(50) DEFAULT NULL,
  `no_jamkesmas` varchar(50) DEFAULT NULL,
  `peruntukan` varchar(100) DEFAULT NULL,
  `no_surat` varchar(100) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(100) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `masa_berlaku` date NOT NULL,
  `nama_rumahsakit` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(15) NOT NULL,
  PRIMARY KEY (`id_permintaan_rumahsakit`),
  KEY `fk_28` (`id_kelurahan`),
  KEY `fk_29` (`id_pejabat`),
  KEY `fk_30` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `permintaan_rumahsakit`
--

INSERT INTO `permintaan_rumahsakit` (`id_permintaan_rumahsakit`, `id_kelurahan`, `id_pejabat`, `nik`, `no_kip`, `no_jamkesmas`, `peruntukan`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `masa_berlaku`, `nama_rumahsakit`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(40, 3, 1, '2006200720082009', 'aaaa', 'aaaa', '0', '400 / RS0018 / KEL.LG', '2014-09-07', 'S290-7bd-900/pemb.', '2014-09-02', '2014-09-17', 'aaaa', 3, '15:31:55', '15:31:55', 'Umum', '15:32:17', 'Umum', '15:32:19', 8, 1, 3, 11, 'RS0018'),
(41, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '09:43:22', '09:43:22', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'RS0024'),
(42, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '10:15:00', '10:15:00', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'RS0024'),
(43, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '10:23:02', '10:23:02', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'RS0025'),
(44, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '10:28:26', '10:28:26', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'RS0028'),
(45, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '12:05:42', '12:05:42', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'RS0030'),
(46, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '12:21:05', '12:21:05', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'RS0032'),
(47, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '12:23:49', '12:23:49', 'Umum, S.Kom', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'RS0032');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_sekolah`
--

CREATE TABLE IF NOT EXISTS `permintaan_sekolah` (
  `id_permintaan_sekolah` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_kip` varchar(100) DEFAULT NULL,
  `nama_siswa` varchar(100) DEFAULT NULL,
  `tempat_lahir_siswa` varchar(100) DEFAULT NULL,
  `tanggal_lahir_siswa` date DEFAULT NULL,
  `hub_keluarga` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `nama_sekolah` varchar(100) DEFAULT NULL,
  `masa_berlaku` date DEFAULT NULL,
  `keperluan` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_sekolah`),
  KEY `fk_31` (`id_kelurahan`),
  KEY `fk_32` (`id_pejabat`),
  KEY `fk_33` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `permintaan_sekolah`
--

INSERT INTO `permintaan_sekolah` (`id_permintaan_sekolah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_kip`, `nama_siswa`, `tempat_lahir_siswa`, `tanggal_lahir_siswa`, `hub_keluarga`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `nama_sekolah`, `masa_berlaku`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(8, 3, 1, '123456', 'tes', 'Andri', 'cimahi', '2009-09-09', 'Orang Tua', '23', '2014-08-24', '223', '2014-08-21', 'sdn 1 cibeber', '2014-08-30', 'SKTM sekolah', 1, '08:00:00', '08:10:00', 'umum, MT', '08:20:00', 'umum, MT', '08:30:00', 30, 1, 2, 11, '14'),
(9, 3, 1, '2006200720082009', 'tes', 'Andri', 'cimahi', '2009-09-09', 'Orang Tua', '23', '2014-08-03', '223', '2014-08-21', 'sdn 1 cibeber', '2014-08-30', 'SKTM sekolah', 1, '08:00:00', '08:10:00', 'umum, MT', '08:20:00', 'umum, MT', '08:30:00', 30, 1, 2, 11, '14'),
(10, 3, 1, '2009200812092020', 'tes', 'Sinta', 'cimahi', '2009-09-09', 'Orang Tua', '23', '2014-08-03', '223', '2014-08-21', 'sdn 1 cibeber', '2014-08-30', 'SKTM sekolah', 1, '08:00:00', '08:10:00', 'umum, MT', '08:20:00', 'umum, MT', '08:30:00', 30, 1, 2, 11, '14'),
(11, 3, 1, '2006200720082009', 'aaaa', 'riza', 'ciamahi', '0000-00-00', 'Saudara', '400 / SS0019 / KEL.LG', '2014-09-07', 'S290-7bd-900/pemb.', '2014-09-03', 'rancabelut', '2014-09-03', 'bangun usaha', 3, '16:08:43', '16:08:43', 'Umum', '18:10:52', 'Umum', '18:14:09', 11, 1, 3, NULL, 'SS0019'),
(12, 3, 1, '2006200720082009', 'aaaa', 'riza', 'ciamahi', '2014-09-03', 'Saudara', '400 / SS0020 / KEL.LG', '2014-09-07', 'S290-7bd-900/pemb.', '2014-09-03', 'rancabelut', '2014-09-04', 'bangun usaha', 3, '18:18:10', '18:18:10', 'Umum', '18:18:52', 'Umum', '18:18:55', 11, 1, 3, 11, 'SS0020'),
(13, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '18:44:19', '18:44:19', 'Umum', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'SS0021'),
(14, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '18:46:19', '18:46:19', 'Umum', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'SS0022'),
(15, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '18:47:10', '18:47:10', 'Umum', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'SS0023');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_serbaguna`
--

CREATE TABLE IF NOT EXISTS `permintaan_serbaguna` (
  `id_permintaan_serbaguna` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `rt` int(11) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_serbaguna`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `permintaan_serbaguna`
--

INSERT INTO `permintaan_serbaguna` (`id_permintaan_serbaguna`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL),
(4, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_waris`
--

CREATE TABLE IF NOT EXISTS `permintaan_waris` (
  `id_permintaan_waris` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `rt` int(11) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `waktu_antrian` time DEFAULT NULL,
  `antrian_oleh` varchar(100) DEFAULT NULL,
  `waktu_proses` time DEFAULT NULL,
  `proses_oleh` varchar(100) DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) DEFAULT NULL,
  `id_surat` int(10) DEFAULT NULL,
  `id_pengguna` int(10) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan_waris`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_waris`
--

INSERT INTO `permintaan_waris` (`id_permintaan_waris`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE IF NOT EXISTS `surat` (
  `id_surat` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis_surat` int(11) NOT NULL,
  `kode_surat` varchar(10) NOT NULL,
  `nama_surat` varchar(50) NOT NULL,
  `controller` varchar(50) NOT NULL,
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id_surat`, `id_jenis_surat`, `kode_surat`, `nama_surat`, `controller`) VALUES
(1, 1, '', 'SKTM Rumah Sakit', 'rumahsakit'),
(2, 1, '', 'SKTM Sekolah', 'sekolah'),
(3, 1, '400', 'Keterangan Andon Nikah', 'andonnikah'),
(4, 1, '', 'Keterangan Belum Menikah', 'belummenikah'),
(5, 1, '', 'Keterangan Belum Memiliki Rumah', 'bpr'),
(6, 1, '', 'Keterangan Ibadah Haji', 'ibadahhaji'),
(7, 2, '', 'Keterangan Ijin Keramaian', 'ik'),
(8, 2, '', 'SKCK', 'ps'),
(9, 2, '', 'Keterangan Bersih Diri', 'bd'),
(19, 1, '', 'Keterangan Janda', 'janda'),
(20, 3, '', 'Keterangan Domisili Yayasan', 'domisiliyayasan'),
(21, 3, '', 'Keterangan Domisili Parpol', 'domisiliparpol'),
(22, 3, '', 'Keterangan Domisili Perusahaan', 'domisiliperusahaan'),
(23, 3, '', 'Keterangan Tempat Usaha', 'keterangantempatusaha'),
(24, 4, '', 'Surat Keterangan Kelahiran', 'lahir'),
(25, 4, '', 'Surat Keterangan Kematian', 'mati');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pejabat_kelurahan`
--
ALTER TABLE `pejabat_kelurahan`
  ADD CONSTRAINT `fk_1` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_2` FOREIGN KEY (`id_jenis_pengguna`) REFERENCES `jenis_pengguna` (`id_jenis_pengguna`);

--
-- Constraints for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `fk_3` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_4` FOREIGN KEY (`id_jenis_pengguna`) REFERENCES `jenis_pengguna` (`id_jenis_pengguna`);

--
-- Constraints for table `permintaan_andonnikah`
--
ALTER TABLE `permintaan_andonnikah`
  ADD CONSTRAINT `fk_38` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_5` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_6` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`),
  ADD CONSTRAINT `fk_9` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_bd`
--
ALTER TABLE `permintaan_bd`
  ADD CONSTRAINT `fk_11` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_12` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_8` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_belummenikah`
--
ALTER TABLE `permintaan_belummenikah`
  ADD CONSTRAINT `fk_13` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_14` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_15` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_bpr`
--
ALTER TABLE `permintaan_bpr`
  ADD CONSTRAINT `fk_16` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_17` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_18` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_domisili_parpol`
--
ALTER TABLE `permintaan_domisili_parpol`
  ADD CONSTRAINT `fk_43` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_44` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_45` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_domisili_yayasan`
--
ALTER TABLE `permintaan_domisili_yayasan`
  ADD CONSTRAINT `fk_40` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_41` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_42` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_ibadahhaji`
--
ALTER TABLE `permintaan_ibadahhaji`
  ADD CONSTRAINT `fk_19` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_20` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_21` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_ik`
--
ALTER TABLE `permintaan_ik`
  ADD CONSTRAINT `fk_22` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_23` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_24` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_janda`
--
ALTER TABLE `permintaan_janda`
  ADD CONSTRAINT `fk_35` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_36` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_37` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_keterangan_tempat_usaha`
--
ALTER TABLE `permintaan_keterangan_tempat_usaha`
  ADD CONSTRAINT `fk_46` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_47` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_48` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_ps`
--
ALTER TABLE `permintaan_ps`
  ADD CONSTRAINT `fk_25` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_26` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_27` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_rumahsakit`
--
ALTER TABLE `permintaan_rumahsakit`
  ADD CONSTRAINT `fk_28` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_29` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_30` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

--
-- Constraints for table `permintaan_sekolah`
--
ALTER TABLE `permintaan_sekolah`
  ADD CONSTRAINT `fk_31` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `fk_32` FOREIGN KEY (`id_pejabat`) REFERENCES `pejabat_kelurahan` (`id_pejabat`),
  ADD CONSTRAINT `fk_33` FOREIGN KEY (`nik`) REFERENCES `data_penduduk` (`nik`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
