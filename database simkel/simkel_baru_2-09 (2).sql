-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2014 at 10:47 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simkel`
--
CREATE DATABASE `simkel` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `simkel`;

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
  `id_no_reg` int(11) NOT NULL,
  `no_reg` varchar(15) NOT NULL,
  `nik` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(11, 2, 3, 'Umum', '2004200398767656', 'umum', 'umum'),
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
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_registrasi` varchar(50) NOT NULL,
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
  `waktu_total` int(10) DEFAULT NULL,
  `id_jenis_surat` int(10) NOT NULL,
  `id_surat` int(10) NOT NULL,
  `id_pengguna` int(10) NOT NULL,
  PRIMARY KEY (`id_permintaan_andonnikah`),
  KEY `fk_5` (`id_kelurahan`),
  KEY `fk_9` (`nik`),
  KEY `fk_38` (`id_pejabat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_bd`
--

CREATE TABLE IF NOT EXISTS `permintaan_bd` (
  `id_permintaan_bd` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `alamat_ayah` varchar(100) NOT NULL,
  `pekerjaan_ayah` varchar(50) NOT NULL,
  `agama_ayah` varchar(50) NOT NULL,
  `alamat_ibu` varchar(100) NOT NULL,
  `pekerjaan_ibu` varchar(50) NOT NULL,
  `agama_ibu` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_bd`),
  UNIQUE KEY `alamat_ibu` (`alamat_ibu`),
  KEY `fk_11` (`id_kelurahan`),
  KEY `fk_12` (`id_pejabat`),
  KEY `fk_8` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `permintaan_bd`
--

INSERT INTO `permintaan_bd` (`id_permintaan_bd`, `id_kelurahan`, `id_pejabat`, `nik`, `alamat_ayah`, `pekerjaan_ayah`, `agama_ayah`, `alamat_ibu`, `pekerjaan_ibu`, `agama_ibu`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(1, 3, 1, '2006200720082009', 'majalaya', 'Petani', 'Islam', 'majalaya', 'Petani', 'Islam', '460/0077/Pembd./s2013', '2014-01-16', 'S290-7b.d-900/pemb', '2014-01-29', 'Beli Rumah', 1, '2014-08-29 10:30:29', '2014-08-29 05:26:21', 'tes', 'tes'),
(2, 3, 1, '2006200720082009', 'ayah', 'guru', 'islam', 'cimahi', 'ibu rumah tangga', 'Islam', '290-Bd/pemb.', '2014-01-21', 'abcd', '2014-08-29', 'Bersih Diri', 1, '2014-08-29 12:12:04', '2014-08-23 06:32:19', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_belummenikah`
--

CREATE TABLE IF NOT EXISTS `permintaan_belummenikah` (
  `id_permintaan_belummenikah` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_belummenikah`),
  KEY `fk_13` (`id_kelurahan`),
  KEY `fk_14` (`id_pejabat`),
  KEY `fk_15` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `permintaan_belummenikah`
--

INSERT INTO `permintaan_belummenikah` (`id_permintaan_belummenikah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(5, 3, 1, '2006200720082009', '230-Nik4h/pemb2.', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-29', 'Beasiswa', 1, '2014-08-29 11:20:12', '2014-08-29 09:07:29', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_bpr`
--

CREATE TABLE IF NOT EXISTS `permintaan_bpr` (
  `id_permintaan_bpr` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `stl` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_bpr`),
  KEY `fk_16` (`id_kelurahan`),
  KEY `fk_17` (`id_pejabat`),
  KEY `fk_18` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_bpr`
--

INSERT INTO `permintaan_bpr` (`id_permintaan_bpr`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `stl`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-06-16', 'S290-7bd-900/pemb.', '2014-01-01', 'Beli Rumah', 'Ngontrak', 1, '2014-08-29 12:12:35', '2014-08-23 06:30:29', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_domisili_parpol`
--

CREATE TABLE IF NOT EXISTS `permintaan_domisili_parpol` (
  `id_permintaan_domisili_parpol` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `masa_berlaku` date NOT NULL,
  `nama_parpol` varchar(150) NOT NULL,
  `bergerak_bidang` varchar(100) NOT NULL,
  `jumlah_anggota` int(100) NOT NULL,
  `jam_kerja` varchar(50) NOT NULL,
  `alamat_parpol` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_domisili_parpol`),
  KEY `fk_43` (`id_kelurahan`),
  KEY `fk_44` (`id_pejabat`),
  KEY `fk_45` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `permintaan_domisili_parpol`
--

INSERT INTO `permintaan_domisili_parpol` (`id_permintaan_domisili_parpol`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `masa_berlaku`, `nama_parpol`, `bergerak_bidang`, `jumlah_anggota`, `jam_kerja`, `alamat_parpol`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(6, 3, 1, '2006200720082009', 'sdy/pem.120/kotak', '2014-02-05', 'pengsu/pemk/12.p', '2014-02-26', 'bangun usaha', '2014-02-26', 'Partai Politik', 'Asuransi', 12, '24', 'Jl.teuing', 1, '2014-08-29 12:13:00', '2014-08-23 08:46:37', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_domisili_perusahaan`
--

CREATE TABLE IF NOT EXISTS `permintaan_domisili_perusahaan` (
  `id_permintaan_domisili_perusahaan` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `keperluan` varchar(50) NOT NULL,
  `masa_berlaku` date NOT NULL,
  `nama_perusahaan` varchar(150) NOT NULL,
  `jenis_perusahaan` varchar(100) NOT NULL,
  `bergerak_bidang` varchar(100) NOT NULL,
  `notaris` varchar(200) NOT NULL,
  `no_notaris` varchar(20) NOT NULL,
  `tanggal_notaris` date NOT NULL,
  `jumlah_pegawai` int(11) NOT NULL,
  `jam_kerja` varchar(100) NOT NULL,
  `alamat_usaha` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_domisili_perusahaan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `permintaan_domisili_perusahaan`
--

INSERT INTO `permintaan_domisili_perusahaan` (`id_permintaan_domisili_perusahaan`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `masa_berlaku`, `nama_perusahaan`, `jenis_perusahaan`, `bergerak_bidang`, `notaris`, `no_notaris`, `tanggal_notaris`, `jumlah_pegawai`, `jam_kerja`, `alamat_usaha`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(7, 3, 1, '2006200720082009', 'sdy/pem.120/kok', '2014-02-05', 'pengsu/pemk/12.p', '2014-02-27', 'bangun usaha', '2014-02-05', 'Sapei Foundation', 'Asuransi', 'Asuransi', 'jantungan', '1222/se.sds', '2014-02-26', 13, '45', 'jantung lewat pinggir', 1, '2014-08-29 12:13:30', '2014-08-23 06:35:33', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_domisili_yayasan`
--

CREATE TABLE IF NOT EXISTS `permintaan_domisili_yayasan` (
  `id_permintaan_domisili_yayasan` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `masa_berlaku` date NOT NULL,
  `nama_yayasan` varchar(150) NOT NULL,
  `bergerak_bidang` varchar(100) NOT NULL,
  `jumlah_anggota` int(100) NOT NULL,
  `jam_kerja` varchar(50) NOT NULL,
  `alamat_usaha` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_domisili_yayasan`),
  KEY `fk_40` (`id_kelurahan`),
  KEY `fk_41` (`id_pejabat`),
  KEY `fk_42` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_domisili_yayasan`
--

INSERT INTO `permintaan_domisili_yayasan` (`id_permintaan_domisili_yayasan`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `masa_berlaku`, `nama_yayasan`, `bergerak_bidang`, `jumlah_anggota`, `jam_kerja`, `alamat_usaha`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(3, 3, 1, '2006200720082009', 'sdy/pem.120/kotaa', '2014-02-04', 'pengsu/pemk/12.p', '2014-02-04', 'bangun usaha', '2014-02-14', 'serba ada', 'dagang', 12, '12', 'Jember', 1, '2014-08-29 12:13:51', '2014-08-23 08:34:35', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_ibadahhaji`
--

CREATE TABLE IF NOT EXISTS `permintaan_ibadahhaji` (
  `id_permintaan_ibadahhaji` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `rt` int(11) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_ibadahhaji`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_ibadahhaji`
--

INSERT INTO `permintaan_ibadahhaji` (`id_permintaan_ibadahhaji`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 0, '2014-01-28', 1, '2014-08-29 12:14:09', '2014-08-23 07:41:36', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_ik`
--

CREATE TABLE IF NOT EXISTS `permintaan_ik` (
  `id_permintaan_ik` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `hari_kegiatan` varchar(100) NOT NULL,
  `tanggal_kegiatan` date NOT NULL,
  `waktu` varchar(50) NOT NULL,
  `nama_kegiatan` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_ik`),
  KEY `fk_22` (`id_kelurahan`),
  KEY `fk_23` (`id_pejabat`),
  KEY `fk_24` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `permintaan_ik`
--

INSERT INTO `permintaan_ik` (`id_permintaan_ik`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `hari_kegiatan`, `tanggal_kegiatan`, `waktu`, `nama_kegiatan`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(4, 3, 1, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-29', 'Senin', '2014-01-23', '13:00 - 14:00', 'Reuni Masal', 1, '2014-08-29 12:14:38', '2014-08-23 07:32:30', 'tes', 'tes'),
(5, 3, 1, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', 'Rabu', '2014-01-29', '12:00 - 15:00', 'Reuni Masal', 1, '2014-08-29 12:14:42', '2014-08-23 06:37:34', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_janda`
--

CREATE TABLE IF NOT EXISTS `permintaan_janda` (
  `id_permintaan_janda` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `sebab_janda` varchar(50) NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_janda`),
  KEY `fk_35` (`id_kelurahan`),
  KEY `fk_36` (`id_pejabat`),
  KEY `fk_37` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `permintaan_janda`
--

INSERT INTO `permintaan_janda` (`id_permintaan_janda`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `sebab_janda`, `keperluan`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(6, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', 'KDRT', 'Beli Rumah haji', 1, '2014-08-29 12:15:03', '2014-08-23 08:40:36', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_keterangan_tempat_usaha`
--

CREATE TABLE IF NOT EXISTS `permintaan_keterangan_tempat_usaha` (
  `id_permintaan_keterangan_tempat_usaha` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `bidang_usaha` varchar(100) NOT NULL,
  `alamat_usaha` varchar(100) NOT NULL,
  `masa_berlaku` date NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_keterangan_tempat_usaha`),
  KEY `fk_46` (`id_kelurahan`),
  KEY `fk_47` (`id_pejabat`),
  KEY `fk_48` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `permintaan_keterangan_tempat_usaha`
--

INSERT INTO `permintaan_keterangan_tempat_usaha` (`id_permintaan_keterangan_tempat_usaha`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `bidang_usaha`, `alamat_usaha`, `masa_berlaku`, `tanggal_surat_pengantar`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(6, 3, 1, '2006200720082009', 'sdy/pem.120/kotaw', '2014-02-12', 'pengsu/pemk/12.p', 'Tani', 'Jl. Tau', '2014-02-05', '2014-02-11', 1, '2014-08-29 12:15:27', '2014-08-23 06:36:36', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_lahir`
--

CREATE TABLE IF NOT EXISTS `permintaan_lahir` (
  `id_permintaan_lahir` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `rt` int(11) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `rw` varchar(5) NOT NULL,
  `nama_anak` varchar(200) NOT NULL,
  `jenis_kelamin_anak` varchar(50) NOT NULL,
  `tempat_lahir_anak` varchar(150) NOT NULL,
  `tgl_lahir_anak` date NOT NULL,
  `anak_ke` int(11) NOT NULL,
  `jam_lahir` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_lahir`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_lahir`
--

INSERT INTO `permintaan_lahir` (`id_permintaan_lahir`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `rw`, `nama_anak`, `jenis_kelamin_anak`, `tempat_lahir_anak`, `tgl_lahir_anak`, `anak_ke`, `jam_lahir`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', '05', 'riza', 'laki-laki', 'cimahi', '2014-08-30', 2, '23:59', 1, '2014-08-30 05:11:10', '2014-08-23 08:00:00', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_mati`
--

CREATE TABLE IF NOT EXISTS `permintaan_mati` (
  `id_permintaan_mati` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `tanggal_meninggal` date NOT NULL,
  `jam_meninggal` varchar(10) NOT NULL,
  `lokasi_meninggal` varchar(150) NOT NULL,
  `penyebab_meninggal` varchar(100) NOT NULL,
  `usia_meninggal` int(11) NOT NULL,
  `keperluan` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_mati`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_mati`
--

INSERT INTO `permintaan_mati` (`id_permintaan_mati`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `tanggal_meninggal`, `jam_meninggal`, `lokasi_meninggal`, `penyebab_meninggal`, `usia_meninggal`, `keperluan`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', '2014-01-28', '0000-00-00', '12:23', 'RS Hasan Sadikin', 'Sakit', 32, 'Pengurusan Ke Taspen', 1, '2014-08-30 05:34:29', '2014-08-23 06:26:00', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_ps`
--

CREATE TABLE IF NOT EXISTS `permintaan_ps` (
  `id_permintaan_ps` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_ps`),
  KEY `fk_25` (`id_kelurahan`),
  KEY `fk_26` (`id_pejabat`),
  KEY `fk_27` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `permintaan_ps`
--

INSERT INTO `permintaan_ps` (`id_permintaan_ps`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(6, 3, 1, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', 'Beli Rumah', 1, '2014-08-29 12:17:59', '2014-08-23 08:00:00', 'tes', 'tes'),
(7, 3, 1, '123', '20', '2014-08-22', '21', '2014-08-14', 'melamar kerja', 1, '2014-08-29 12:18:01', '2014-08-23 10:00:00', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_rumahsakit`
--

CREATE TABLE IF NOT EXISTS `permintaan_rumahsakit` (
  `id_permintaan_rumahsakit` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_kip` varchar(50) NOT NULL,
  `no_jamkesmas` varchar(50) NOT NULL,
  `peruntukan` varchar(100) NOT NULL,
  `no_surat` varchar(100) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(100) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `masa_berlaku` date NOT NULL,
  `nama_rumahsakit` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_rumahsakit`),
  KEY `fk_28` (`id_kelurahan`),
  KEY `fk_29` (`id_pejabat`),
  KEY `fk_30` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `permintaan_rumahsakit`
--

INSERT INTO `permintaan_rumahsakit` (`id_permintaan_rumahsakit`, `id_kelurahan`, `id_pejabat`, `nik`, `no_kip`, `no_jamkesmas`, `peruntukan`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `masa_berlaku`, `nama_rumahsakit`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(9, 3, 1, '2006200720082009', 'ininomorkip', 'jamkesmas', '0', '460/0077/Pembd./2013', '2013-11-29', '78/rw/vii/2013', '2014-01-01', '2014-01-01', 'RSUD Cibabat Cimahi', 1, '2014-08-29 02:06:14', '2014-08-29 01:12:13', 'tes', 'Pey, MT'),
(15, 3, 1, '2006200720082009', 'ininomorkip', 'jamkesmas', '0', '460/0077/Pembd./2013', '2014-01-09', 'S290-7bd-900/pemb.', '2014-01-01', '2014-01-02', 'RSUD Cibabat Cimahi', 1, '2014-08-31 13:06:16', '2014-08-23 07:00:00', 'tes', 'Pey, MT'),
(18, 3, 1, '2009200812092020', '0948509345', '345234', '0', '460/0077/Pembd./2013', '2014-01-14', 'S290-7bd-900/pemb.', '2014-01-01', '2014-01-08', 'RSUD Cibabat Cimahi', 1, '2014-08-31 13:06:19', '2014-08-23 07:00:00', 'tes', 'Pey, MT'),
(19, 3, 1, '2006200720082009', '0948509345', '345234', '0', '460/0077/Pembd./2014', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', '2014-01-01', 'RSUD Cibabat Cimahi', 1, '2014-08-31 13:06:21', '2014-08-23 07:00:00', 'tes', 'Pey, MT'),
(20, 3, 1, '2009200812092020', '0948509345', '345234', '1', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-15', '2014-01-01', 'RSUD Cibabat Cimahi', 1, '2014-08-31 13:06:24', '2014-08-23 12:00:00', 'tes', 'Pey, MT'),
(24, 3, 1, '2009200812092020', '111', '1111', '0', '1111', '2014-08-23', '1111', '2014-07-30', '2014-08-07', 'cibeber', 1, '2014-08-31 13:06:28', '2014-08-23 10:00:00', 'tes', 'Pey, MT'),
(25, 3, 1, '2009200812092020', '111', '1111', '0', '1111', '2014-08-23', '1111', '2014-07-30', '2014-08-07', 'cibeber', 1, '2014-08-31 13:06:31', '2014-08-23 10:00:00', 'tes', 'Pey, MT'),
(26, 3, 1, '2006200720082009', 'wew', 'we', '0', 'we', '2014-08-23', 'swqeqwqweqeqw', '2014-07-30', '2014-07-30', 'sdada', 1, '2014-08-31 13:06:34', '2014-08-23 10:00:00', 'tes', 'Pey, MT'),
(27, 3, 1, '2006200720082009', 'wew', 'we', '0', 'we', '2014-08-23', 'swqeqwqweqeqw', '2014-07-30', '2014-07-30', 'sdada', 1, '2014-08-31 13:06:36', '2014-08-24 06:40:02', 'tes', 'Pey, MT'),
(28, 3, 1, '2006200720082009', 'ww', 'q', '0', 'wsadadasdada', '2014-08-23', 'wq', '2014-07-29', '2014-07-30', 'asaczz', 1, '2014-08-31 13:06:39', '2014-08-23 11:00:00', 'tes', 'Pey, MT'),
(29, 3, 1, '2006200720082009', 'weqeq', 'q', '0', 'sad', '2014-08-23', 'sa', '2013-12-29', '2016-01-31', 'sada', 1, '2014-08-31 13:06:42', '2014-08-24 06:39:56', 'tes', 'Pey, MT'),
(30, 3, 1, '2006200720082009', 'weqeq', 'q', '0', 'sad', '2014-08-23', 'sa', '2013-12-29', '2016-01-31', 'sada', 1, '2014-08-31 13:06:44', '2014-08-23 11:00:00', 'tes', 'Pey, MT'),
(31, 3, 1, '2006200720082009', '3242', '3434', '0', '35252', '2014-08-23', 'kakaka', '2014-12-31', '2014-12-31', 'dsa', 1, '2014-08-31 13:06:47', '2014-08-23 10:00:00', 'tes', 'Pey, MT'),
(32, 3, 1, '2009200812092020', 'sdsada', 'sda', '0', 'sdaa', '2014-08-23', 'sdada', '2014-12-31', '2014-12-31', 'wdqd', 1, '2014-08-31 13:06:49', '2014-08-23 10:00:00', 'tes', 'Pey, MT'),
(33, 3, 1, '345678', '555', '555', '0', '666', '2014-09-01', '45', '2014-03-12', '2014-05-12', 'dustira', 1, '2014-09-01 02:58:06', '2014-09-01 02:58:06', 'Pey, MT', 'Pey, MT'),
(34, 3, 1, '345678', '555', '555', '0', '666', '2014-09-01', '45', '2014-03-12', '2014-05-12', 'dustira', 1, '2014-09-01 02:58:09', '2014-09-01 02:58:09', 'Pey, MT', 'Pey, MT');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_sekolah`
--

CREATE TABLE IF NOT EXISTS `permintaan_sekolah` (
  `id_permintaan_sekolah` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_kip` varchar(100) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `tempat_lahir_siswa` varchar(100) NOT NULL,
  `tanggal_lahir_siswa` date NOT NULL,
  `hub_keluarga` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `nama_sekolah` varchar(100) NOT NULL,
  `masa_berlaku` date NOT NULL,
  `keperluan` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_sekolah`),
  KEY `fk_31` (`id_kelurahan`),
  KEY `fk_32` (`id_pejabat`),
  KEY `fk_33` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `permintaan_sekolah`
--

INSERT INTO `permintaan_sekolah` (`id_permintaan_sekolah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_kip`, `nama_siswa`, `tempat_lahir_siswa`, `tanggal_lahir_siswa`, `hub_keluarga`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `nama_sekolah`, `masa_berlaku`, `keperluan`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(4, 3, 1, '2009200812092020', '89898989809812', 'Darmaji', 'Jawa', '1890-12-03', 'Saudara', '460/0077/Pembd./2013', '2013-12-03', '78/rw/vii/2013', '2013-12-03', 'SDN 1 Mauk', '2013-12-31', 'Beasiswa Sekolah', 1, '2014-08-29 12:21:09', '2014-08-23 08:00:00', 'tes', 'tes'),
(6, 3, 1, '2006200720082009', '0948509345', 'Dewa', 'Tasik', '2014-01-01', 'Saudara', '460/0077/Pembd./2013', '2014-01-16', '78/rw/vii/2013', '2013-12-31', 'SDN 1 Mauk', '2014-01-16', 'Beli Rumah', 1, '2014-08-29 12:21:13', '2014-08-23 09:00:00', 'tes', 'tes'),
(7, 3, 1, '9', 'tes', 'tess', 'cimahi', '2009-09-09', 'Orang Tua', '23', '2014-08-24', '223', '2014-08-21', 'sdn 1 cibeber', '2014-08-30', 'SKTM sekolah', 1, '2014-08-29 12:21:16', '2014-08-23 04:00:00', 'tes', 'tes'),
(8, 3, 1, '9', 'tes', 'tess', 'cimahi', '2009-09-09', 'Orang Tua', '23', '2014-08-24', '223', '2014-08-21', 'sdn 1 cibeber', '2014-08-30', 'SKTM sekolah', 1, '2014-08-29 12:21:20', '2014-08-23 09:00:00', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_serbaguna`
--

CREATE TABLE IF NOT EXISTS `permintaan_serbaguna` (
  `id_permintaan_serbaguna` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `rt` int(11) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_serbaguna`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_serbaguna`
--

INSERT INTO `permintaan_serbaguna` (`id_permintaan_serbaguna`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', 1, '2014-08-29 12:21:40', '2014-08-23 08:00:00', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_waris`
--

CREATE TABLE IF NOT EXISTS `permintaan_waris` (
  `id_permintaan_waris` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `rt` int(11) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_waris`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_waris`
--

INSERT INTO `permintaan_waris` (`id_permintaan_waris`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', 1, '2014-08-29 12:21:59', '2014-08-23 07:00:00', 'tes', 'tes');

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
