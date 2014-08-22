-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2014 at 10:09 AM
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
('123', 'tes', 'cibeber', 10, 4, 'cibeber', '40531', '123', '', 'ratih', 'Perempuan', 'garut', '1992-02-04', '634', 'O', 'Islam', 'PNS', 'tes', 'tes', 'Belum Menikah', 1),
('2007030420082019', 'Iding Samsudin', 'Jl. Kepatihan No. 16', 12, 5, 'Cikalong', '13550', '2006200720082009', '', 'Hadi Purnomo', 'Perempuan', 'Jember', '1990-11-13', 'B909/Pemb./1605', 'B', 'Islam', 'Wiraswasta', 'Siti Faatimah', 'Iding Samsudin', 'Belum Menikah', 1),
('2002200320102011', 'Sugeng', 'Jl. Pekayon', 12, 5, 'Keworeko', '153467', '2009200812092020', '', 'Raden Ujang Kewo', 'Laki-laki', 'Tangerang', '1992-12-24', 'B909/Pemb./1605', 'O', 'Islam', 'Tani', 'Kolong', 'Kilang', 'Menikah', 2),
('327702088888888', 'RIZAL SULAEMAN', 'CIBEBER', 9, 8, 'CIBEBER', '877', '3277000202020012', '', 'Muhamad Ade', 'Laki-laki', 'CIMAHI', '2002-02-02', 'B909/Pemb./1605', 'A', 'Hindu', 'MAHASISWA', 'NUNUNG', 'UTAR', 'Menikah', 1),
('123', 'qw', 'qwe', 2, 1, 'buaya kali', '12490', '87654321234567', '', 'Mamad Kenyod', 'Laki-laki', 'Jember', '1992-12-31', 'Akta/.323./lahir', 'O', 'Islam', 'Wiraswasta', 'Siti Faatimah', 'Iding Samsudin', 'Menikah', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pengguna`
--

CREATE TABLE IF NOT EXISTS `jenis_pengguna` (
  `id_jenis_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis_pengguna` varchar(100) NOT NULL,
  PRIMARY KEY (`id_jenis_pengguna`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `jenis_pengguna`
--

INSERT INTO `jenis_pengguna` (`id_jenis_pengguna`, `nama_jenis_pengguna`) VALUES
(1, 'admin'),
(2, 'umum'),
(3, 'Ketua Pemberdayaan'),
(4, 'Ketua Tentara Ketertiban'),
(5, 'Ketua Ekonomi Pembangunan'),
(6, 'Ketua Pemerintahan');

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
(1, 'pemberdayaan'),
(2, 'tantrib'),
(3, 'ekonomi pembangunan'),
(4, 'pemerintahan');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `kelurahan`
--

INSERT INTO `kelurahan` (`id_kelurahan`, `nama_kelurahan`, `nama_lurah`, `kecamatan`, `alamat`, `no_telepon`, `kode_pos`) VALUES
(1, 'CIBEBER', '', 'CIMAHI SELATAN', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(2, 'CIBEREUM', '', 'CIMAHI SELATAN', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(3, 'LEWIGAJAH', '', 'CIMAHI SELATAN', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(4, 'MELONG', '', 'CIMAHI SELATAN', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(5, 'UTAMA', '', 'CIMAHI SELATAN', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(6, 'BAROS', '', 'CIMAHI TENGAH', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(7, 'CIGUGUR TENGAH', '', 'CIMAHI TENGAH', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(8, 'CIMAHI', '', 'CIMAHI TENGAH', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(9, 'KARANG MERAK', '', 'CIMAHI TENGAH', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(10, 'PADASUKA', '', 'CIMAHI TENGAH', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(11, 'SETIAMANAH', '', 'CIMAHI TENGAH', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(12, 'CIBABAT', '', 'CIMAHI UTARA', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(13, 'CIPAGERAN', '', 'CIMAHI UTARA', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(14, 'CITEUREUP', '', 'CIMAHI UTARA', 'Jl. Terusan no. 45', '(022)08137890', '15355'),
(15, 'PASIR KALIKI', '', 'CIMAHI UTARA', 'Jl. Terusan no. 45', '(022)08137890', '15355');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pejabat_kelurahan`
--

INSERT INTO `pejabat_kelurahan` (`id_pejabat`, `nip_pejabat`, `nama_pejabat`, `id_kelurahan`, `id_jenis_pengguna`) VALUES
(1, '2001080920040594', 'Suyono S. Pd.', 1, 3),
(2, '2005200620072008', 'Ade Lukman, S. Sos', 1, 4),
(3, '2003200420052006', 'Tatang Supardi, S. Sos', 2, 3),
(4, '2001200220042005', 'Kurdi, S. Sos', 2, 4),
(5, '234543456765', 'Mari BErdoa, S. Pd', 1, 5),
(6, '2004200398767656', 'Sapei, S. Kom', 3, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `id_jenis_pengguna`, `id_kelurahan`, `nama_pengguna`, `nip_pengguna`, `username`, `password`) VALUES
(2, 2, 1, 'Adel Hakim', '1990899020428945', 'cibeber', '_cibeber'),
(3, 3, 1, 'Sunarto Kuncoro S.Pd.', '2001080920040594', 'pemberdayaan', 'cibeber_pem'),
(4, 4, 1, 'Serem Sumarno, S. Sos', '2001200220032004', 'tantrib', 'cibeber_tan'),
(5, 2, 2, 'Lukman Hakim', '2011201220132014', 'cihanjuang', '_cihanjuang'),
(6, 3, 2, 'Tatang Supardi, S. Sos', '2003200420052006', 'cibereum', 'cibereum_pem'),
(7, 4, 2, 'Tarin Sutiono, S. Sos', '2009229088992345', 'tantrib', 'cibereum_tan'),
(8, 4, 2, 'Tarin Sutiono, S. Sos', '2009229088992345', 'tantrib', 'cibereum_tan'),
(9, 5, 1, 'Mari BErdoa, S. Pd', '123989827837', 'ekbang', 'cibeber_ekb'),
(10, 2, 3, 'supri suwarna', '1005200898789587', 'lewigajah', '_lewigajah'),
(11, 3, 3, 'Sapei, S. Kom', '2004200398767656', 'pemberdayaan', 'lewigajah_pem'),
(12, 1, 1, 'supriyadi', '2005200690954584', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_andonnikah`
--

CREATE TABLE IF NOT EXISTS `permintaan_andonnikah` (
  `id_permintaan_andonnikah` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(50) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `nama_pasangan` varchar(50) NOT NULL,
  `alamat_pasangan` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_disetujui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dibuat_oleh` varchar(100) NOT NULL,
  `disetujui_oleh` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_andonnikah`),
  KEY `fk_5` (`id_kelurahan`),
  KEY `fk_9` (`nik`),
  KEY `fk_38` (`id_pejabat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `permintaan_andonnikah`
--

INSERT INTO `permintaan_andonnikah` (`id_permintaan_andonnikah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `nama_pasangan`, `alamat_pasangan`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(7, 1, 1, '2009200812092020', '460/0077/Pembd./2013', '2015-07-16', 'S290-7bd-900/pemb.', '2014-01-29', 'Julaeha', 'kampung kidul', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(8, 1, 1, '2006200720082009', '230-Nik4h/pemb2.', '2014-01-17', 'S290-7bd-900/pemb.', '2014-01-03', 'Julaeha', 'kampung kidul', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(1, 1, 2, '2006200720082009', 'majalaya', 'Petani', 'Islam', 'majalaya', 'Petani', 'Islam', '460/0077/Pembd./s2013', '2014-01-16', 'S290-7b.d-900/pemb', '2014-01-29', 'Beli Rumah', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(2, 1, 2, '2006200720082009', 'ayah', 'guru', 'islam', 'cimahi', 'ibu rumah tangga', 'Islam', '290-Bd/pemb.', '2014-01-21', 'abcd', '0000-00-00', 'Bersih Diri', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(5, 1, 1, '2006200720082009', '230-Nik4h/pemb2.', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-29', 'Beasiswa', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(3, 1, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-06-16', 'S290-7bd-900/pemb.', '2014-01-01', 'Beli Rumah', 'Ngontrak', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(6, 1, 5, '2006200720082009', 'sdy/pem.120/kotak', '2014-02-05', 'pengsu/pemk/12.p', '2014-02-26', 'bangun usaha', '2014-02-26', 'Partai Politik', 'Asuransi', 12, '24', 'Jl.teuing', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(7, 1, 5, '2006200720082009', 'sdy/pem.120/kok', '2014-02-05', 'pengsu/pemk/12.p', '2014-02-27', 'bangun usaha', '2014-02-05', 'Sapei Foundation', 'Asuransi', 'Asuransi', 'jantungan', '1222/se.sds', '2014-02-26', 13, '45', 'jantung lewat pinggir', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(3, 1, 5, '2006200720082009', 'sdy/pem.120/kotaa', '2014-02-04', 'pengsu/pemk/12.p', '2014-02-04', 'bangun usaha', '2014-02-14', 'serba ada', 'dagang', 12, '12', 'Jember', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(3, 1, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 0, '2014-01-28', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(4, 1, 2, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-29', 'Senin', '2014-01-23', '13:00 - 14:00', 'Reuni Masal', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(5, 1, 2, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', 'Rabu', '2014-01-29', '12:00 - 15:00', 'Reuni Masal', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(6, 1, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', 'KDRT', 'Beli Rumah haji', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(6, 1, 5, '2006200720082009', 'sdy/pem.120/kotaw', '2014-02-12', 'pengsu/pemk/12.p', 'Tani', 'Jl. Tau', '2014-02-05', '2014-02-11', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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

INSERT INTO `permintaan_lahir` (`id_permintaan_lahir`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(3, 1, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
  `rt` int(11) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
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

INSERT INTO `permintaan_mati` (`id_permintaan_mati`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(3, 1, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 0, '2014-01-28', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(6, 1, 2, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', 'Beli Rumah', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(7, 1, 2, '123', '20', '2014-08-22', '21', '0000-00-00', 'melamar kerja', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `permintaan_rumahsakit`
--

INSERT INTO `permintaan_rumahsakit` (`id_permintaan_rumahsakit`, `id_kelurahan`, `id_pejabat`, `nik`, `no_kip`, `no_jamkesmas`, `peruntukan`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `masa_berlaku`, `nama_rumahsakit`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(9, 2, 1, '2006200720082009', 'ininomorkip', 'jamkesmas', '0', '460/0077/Pembd./2013', '2013-11-29', '78/rw/vii/2013', '2014-01-01', '2014-01-01', 'RSUD Cibabat Cimahi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(15, 3, 1, '2006200720082009', 'ininomorkip', 'jamkesmas', '0', '460/0077/Pembd./2013', '2014-01-09', 'S290-7bd-900/pemb.', '2014-01-01', '2014-01-02', 'RSUD Cibabat Cimahi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(18, 1, 1, '2009200812092020', '0948509345', '345234', '0', '460/0077/Pembd./2013', '2014-01-14', 'S290-7bd-900/pemb.', '2014-01-01', '2014-01-08', 'RSUD Cibabat Cimahi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(19, 1, 1, '2006200720082009', '0948509345', '345234', '0', '460/0077/Pembd./2014', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', '2014-01-01', 'RSUD Cibabat Cimahi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(20, 1, 1, '2009200812092020', '0948509345', '345234', '1', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-15', '2014-01-01', 'RSUD Cibabat Cimahi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `permintaan_sekolah`
--

INSERT INTO `permintaan_sekolah` (`id_permintaan_sekolah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_kip`, `nama_siswa`, `tempat_lahir_siswa`, `tanggal_lahir_siswa`, `hub_keluarga`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `nama_sekolah`, `masa_berlaku`, `keperluan`, `status`, `tgl_dibuat`, `tgl_disetujui`, `dibuat_oleh`, `disetujui_oleh`) VALUES
(4, 1, 1, '2009200812092020', '89898989809812', 'Darmaji', 'Jawa', '1890-12-03', 'Saudara', '460/0077/Pembd./2013', '2013-12-03', '78/rw/vii/2013', '2013-12-03', 'SDN 1 Mauk', '2013-12-31', 'Beasiswa Sekolah', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(6, 1, 1, '2006200720082009', '0948509345', 'Dewa', 'Tasik', '2014-01-01', 'Saudara', '460/0077/Pembd./2013', '2014-01-16', '78/rw/vii/2013', '2013-12-31', 'SDN 1 Mauk', '2014-01-16', 'Beli Rumah', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(3, 1, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

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
(3, 1, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE IF NOT EXISTS `surat` (
  `id_surat` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis_surat` int(11) NOT NULL,
  `nama_surat` varchar(50) NOT NULL,
  `controller` varchar(50) NOT NULL,
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id_surat`, `id_jenis_surat`, `nama_surat`, `controller`) VALUES
(1, 1, 'rumah sakit', 'rumahsakit'),
(2, 1, 'sekolah', 'sekolah'),
(3, 1, 'andon nikah', 'andonnikah'),
(4, 1, 'belum menikah', 'belummenikah'),
(5, 1, 'belum mempunyai rumah', 'bpr'),
(6, 1, 'ibadah haji', 'ibadahhaji'),
(7, 2, 'ijin keramaian', 'ik'),
(8, 2, 'pengantar SKCK', 'ps'),
(9, 2, 'bersih diri', 'bd'),
(19, 1, 'janda', 'janda'),
(20, 3, 'domisili yayasan', 'domisiliyayasan'),
(21, 3, 'domisili parpol', 'domisiliparpol'),
(22, 3, 'domisili perusahaan', 'domisiliperusahaan'),
(23, 3, 'keterangan tempat usaha', 'keterangantempatusaha'),
(24, 4, 'surat keterangan kelahiran', 'lahir'),
(25, 4, 'surat keterangan kematian', 'mati'),
(26, 4, 'surat keterangan waris', 'waris'),
(27, 4, 'surat keterangan serbaguna', 'serbaguna');

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
