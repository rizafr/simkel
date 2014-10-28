-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2014 at 05:26 AM
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
-- Table structure for table `berita`
--

CREATE TABLE IF NOT EXISTS `berita` (
  `id_berita` int(11) NOT NULL AUTO_INCREMENT,
  `judul_berita` varchar(250) NOT NULL,
  `isi_berita` varchar(500) NOT NULL,
  PRIMARY KEY (`id_berita`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `judul_berita`, `isi_berita`) VALUES
(1, 'Syarat SKCK : ', 'Membawa formulir dari RT dan RW setempat'),
(3, 'Pengumuman', 'masuk jam 16.00'),
(4, 'Laporan SKCK', 'Membawa persyaratan');

-- --------------------------------------------------------

--
-- Table structure for table `data_arsip`
--

CREATE TABLE IF NOT EXISTS `data_arsip` (
  `id_data_arsip` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(30) NOT NULL,
  `nama_surat` varchar(100) NOT NULL,
  `no_surat` varchar(10) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `ruangan` varchar(20) NOT NULL,
  `lemari` varchar(20) NOT NULL,
  `rak` varchar(20) NOT NULL,
  `kotak` varchar(20) NOT NULL,
  `data_file` varchar(400) NOT NULL,
  `path_file` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id_data_arsip`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `data_arsip`
--

INSERT INTO `data_arsip` (`id_data_arsip`, `nik`, `nama_surat`, `no_surat`, `tanggal_surat`, `ruangan`, `lemari`, `rak`, `kotak`, `data_file`, `path_file`) VALUES
(1, '123456', 'SKTM Sekolah', '400/23/LG', '2014-06-01', '33', '22', '11', '11', 'aaa', NULL),
(2, '123456', 'SKTM Sekolah', '400/23/LG', '2014-06-01', '3333', '2222', '1111', '1111', 'rssrsrss', NULL),
(3, '2006200720082009', 'Keterangan Domisili Perusahaan', '400 / AN00', '2014-06-01', '555', '3333', '33', '777', 'domisili', NULL),
(5, '123456', 'Keterangan Belum Menikah', '22', '2014-09-12', '4', '5', '7', '8', 'Buku Panduan Simkel v2.0.0.pdf', NULL),
(6, '123456', 'Keterangan Domisili Yayasan', '200', '2014-09-12', '3', '3', '7', '5', 'Buku Panduan Simkel v2.0.0.pdf', NULL),
(7, '2006200720082009', 'Keterangan Andonnikah', '400 / 4000', '2014-09-17', '3', '3', '3', '3', 'coretan sql.txt', NULL),
(8, '123456', 'Keterangan Andonnikah', '400 / 4000', '2014-09-19', '5', '4', '3', '3', 'Buku Panduan Simkel v2.0.0.pdf', NULL),
(10, '2006200720082009', 'Keterangan Andonnikah', '400 / 4000', '2014-09-23', 'a', 'a', 'a', 'a', 'retro_img.png', NULL),
(11, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '33', '33', 'cropped-header-2.png', '../etc/data/upload/'),
(12, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '33', '33', 'Konten Website.pptx', '../etd/data/upload/Keterangan Andonnikah.pptx'),
(13, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '33', '33', 'Konten Website.pptx', '../etc/data/upload/Keterangan Andonnikah.pptx'),
(14, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '1', '3333', '33', '33', 'cropped-header-2.png', '../etc/data/upload/Keterangan Andonnikah/2014-09-29/cropped-header-2.png.png'),
(15, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '33', '33', 'cropped-header-2.png', '../etc/data/upload/Keterangan Andonnikah_2014-09-29.png'),
(16, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '33', '33', 'HEADER.png', 'etc/data/upload/Keterangan Andonnikah_2014-09-29.png'),
(17, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '1', '33', 'HEADER.png', 'etc/data/upload/HEADER.png_2014-09-29.png'),
(18, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '33', '33', 'HEADER.png', '../etc/data/upload/HEADER.png_Keterangan Andonnikah_2014-09-29.png'),
(19, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '1', '1', 'ANDONNIKAH_Raden Ujang Kewo_2009200812092020_2014-09-29 (1).docx', '../etc/data/upload/ANDONNIKAH_Raden Ujang Kewo_2009200812092020_2014-09-29 (1)_Keterangan Andonnikah_2014-09-29.docx'),
(20, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '1', '3333', '1', '33', 'upload-download-file.zip', 'etc/data/upload/upload-download-file_Keterangan Andonnikah_2014-09-29.zip'),
(21, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '1', '33', 'PROGRAM SEMESTER_Keterangan Andonnikah_2014-09-29.xlsx', 'etc/data/upload/PROGRAM SEMESTER_Keterangan Andonnikah_2014-09-29.xls'),
(22, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '1', '33', 'Keterangan Andonnikah.pptx', 'upload/andonnikah_Hadi Purnomo_Keterangan Andonnikah_2014-09-29.doc'),
(23, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '33', '33', 'Propsl Mushola Ar Rojaa__.docx', 'etc/data/upload/Propsl Mushola Ar Rojaa__.docx'),
(24, '2009200812092020', 'Keterangan Andonnikah', '400 / 4000', '2014-09-29', '33', '3333', '1', '33', '1.jpg', 'etc/data/upload/1.jpg'),
(25, '2006200720082009', 'Keterangan Andonnikah', '400 / 4000', '2014-09-30', '3', '3', '1111', '3', 'people1.png', 'etc/data/upload/people1.png'),
(26, '123456', 'SKTM rumah sakit', '400 / KRS0', '2014-09-30', '2', '3', '3', '3', 'Cimahi-286x300.png', 'etc/data/upload/Cimahi-286x300.png'),
(27, '123456', 'Keterangan Andonnikah', '400 / 4000', '2014-09-30', '4', '5', '6', '2', 'Cimahi-286x300.png', 'etc/data/upload/Cimahi-286x300.png');

-- --------------------------------------------------------

--
-- Table structure for table `data_pegawai`
--

CREATE TABLE IF NOT EXISTS `data_pegawai` (
  `id_data_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `nip_pengguna` varchar(20) NOT NULL,
  `nama_pengguna` varchar(150) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `golongan` varchar(10) NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  PRIMARY KEY (`id_data_pegawai`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `data_pegawai`
--

INSERT INTO `data_pegawai` (`id_data_pegawai`, `nip_pengguna`, `nama_pengguna`, `jabatan`, `golongan`, `alamat`, `no_telp`) VALUES
(1, '1978240120040506001', 'Ratih Pujihati', 'Kasi Pemberdaya', 'IIIa', 'Cibeber', '0865793892'),
(2, '1977240120040506002', 'Nana', 'Kasi Trantib', 'IIIa', 'Cimahi', '086759934379'),
(3, '1988240120040506001', 'Tata', 'Kasi Ekonomi Pembangunan', 'IIIa', 'Cimahi', '0865793892'),
(4, '1989240120040506002', 'Hani', 'Kasi Pemerintahan', 'IIIa', 'Cimahi', '086759934379'),
(5, '1987240120040506001', 'Riza Fauzi Rahman', 'Staf IT', 'IIIa', 'Cibeber', '0865793892'),
(6, '1978240120070506001', 'Riza', 'Staf IT', 'IIIa', 'Cimahi', '0865793892'),
(7, '1978240120040506001', 'Rully', 'Sekretaris Lurah', 'IIIa', 'Cimahi', '0865793892'),
(8, '1989240120040506002', 'Pa Lurah', 'Kepala Kelurahan', 'IIIa', 'Cimahi', '086759934379'),
(9, '111111111111111', 'nama', 'jabatan', 'IV A', 'Leuwigajah', '1111111');

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
(2, 'Staf'),
(3, 'Kasi Pemberdayaan'),
(4, 'Kasi Ketentraman Ketertiban'),
(5, 'Kasi Ekonomi Pembangunan'),
(6, 'Kasi Pemerintahan'),
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
  `nik` varchar(50) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_no_reg`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

--
-- Dumping data for table `no_registrasi`
--

INSERT INTO `no_registrasi` (`id_no_reg`, `no_registrasi`, `nik`, `tgl_dibuat`) VALUES
(2, 'AN0001', '2006200720082009', '2014-09-25 07:07:59'),
(3, 'AN0002', '2006200720082009', '2014-09-23 07:07:59'),
(4, 'AN0003', '2009200812092020', '2014-09-23 07:07:59'),
(5, 'AN0004', '2006200720082009', '2014-09-25 07:07:59'),
(6, 'AN0005', '2006200720082009', '2014-09-23 07:07:59'),
(7, 'AN0006', '2006200720082009', '2014-09-23 07:07:59'),
(8, 'AN0007', '2006200720082009', '2014-09-23 07:07:59'),
(9, 'AN0008', '2006200720082009', '2014-09-23 07:07:59'),
(10, 'AN0009', '2006200720082009', '2014-09-23 07:07:59'),
(11, 'AN0010', '2006200720082009', '2014-09-23 07:07:59'),
(12, 'AN0011', '2009200812092020', '2014-09-23 07:07:59'),
(13, 'AN0012', '2006200720082009', '2014-09-23 07:07:59'),
(14, 'AN0013', '2006200720082009', '2014-09-23 07:07:59'),
(15, 'AN0014', '2006200720082009', '2014-09-23 07:07:59'),
(16, 'AN0015', '2009200812092020', '2014-09-23 07:07:59'),
(17, 'RS0016', '2006200720082009', '2014-09-23 07:07:59'),
(18, 'RS0017', '2006200720082009', '2014-09-23 07:07:59'),
(19, 'RS0018', '2006200720082009', '2014-09-23 07:07:59'),
(20, 'SS0019', '2006200720082009', '2014-09-23 07:07:59'),
(21, 'SS0020', '2006200720082009', '2014-09-23 07:07:59'),
(22, 'SS0021', '2006200720082009', '2014-09-23 07:07:59'),
(23, 'SS0022', '2006200720082009', '2014-09-23 07:07:59'),
(24, 'SS0023', '2006200720082009', '2014-09-23 07:07:59'),
(25, '4000024', '2006200720082009', '2014-09-25 07:07:59'),
(26, '4000024', '2006200720082009', '2014-09-25 07:07:59'),
(27, 'RS0024', '2006200720082009', '2014-09-23 07:07:59'),
(28, 'BM0024', '2006200720082009', '2014-09-23 07:07:59'),
(29, 'BM0024', '2006200720082009', '2014-09-23 07:07:59'),
(30, 'BM0024', '2006200720082009', '2014-09-23 07:07:59'),
(31, 'BM0024', '2006200720082009', '2014-09-23 07:07:59'),
(32, 'BM0024', '2006200720082009', '2014-09-23 07:07:59'),
(33, 'BM0024', '2006200720082009', '2014-09-23 07:07:59'),
(34, 'BM0024', '2006200720082009', '2014-09-23 07:07:59'),
(35, 'RS0024', '2006200720082009', '2014-09-23 07:07:59'),
(36, 'RS0025', '2006200720082009', '2014-09-23 07:07:59'),
(37, '4000026', '2006200720082009', '2014-09-23 07:07:59'),
(38, 'BM0027', '2006200720082009', '2014-09-23 07:07:59'),
(39, 'RS0028', '2006200720082009', '2014-09-23 07:07:59'),
(40, 'BM0029', '2006200720082009', '2014-09-23 07:07:59'),
(41, 'RS0030', '2006200720082009', '2014-09-23 07:07:59'),
(42, '4000031', '2006200720082009', '2014-09-23 07:07:59'),
(43, 'RS0032', '2006200720082009', '2014-09-23 07:07:59'),
(44, 'RS0032', '2006200720082009', '2014-09-23 07:07:59'),
(45, 'BM0033', '2006200720082009', '2014-09-23 07:07:59'),
(46, 'BPR0034', '2006200720082009', '2014-09-23 07:07:59'),
(47, 'BPR0035', '2006200720082009', '2014-09-23 07:07:59'),
(48, 'BPR0036', '2006200720082009', '2014-09-23 07:07:59'),
(49, 'BPR0037', '2006200720082009', '2014-09-23 07:07:59'),
(50, 'BPR0038', '2006200720082009', '2014-09-23 07:07:59'),
(51, 'IH0001', '2006200720082009', '2014-09-23 07:07:59'),
(52, 'IH0001', '2006200720082009', '2014-09-23 07:07:59'),
(53, 'J0001', '2006200720082009', '2014-09-23 07:07:59'),
(54, 'J0001', '2006200720082009', '2014-09-23 07:07:59'),
(55, 'J0001', '2006200720082009', '2014-09-23 07:07:59'),
(56, 'LA0001', '2006200720082009', '2014-09-23 07:07:59'),
(57, 'LA0001', '2006200720082009', '2014-09-23 07:07:59'),
(58, 'MTI0039', '2006200720082009', '2014-09-23 07:07:59'),
(59, 'IKR0040', '2006200720082009', '2014-09-23 07:07:59'),
(60, 'BDR0041', '2006200720082009', '2014-09-23 07:07:59'),
(61, 'BDR0042', '2006200720082009', '2014-09-23 07:07:59'),
(62, 'BDR0043', '2006200720082009', '2014-09-23 07:07:59'),
(63, 'BDR0044', '2006200720082009', '2014-09-23 07:07:59'),
(64, 'BDR0045', '2006200720082009', '2014-09-23 07:07:59'),
(65, 'SKC0046', '2006200720082009', '2014-09-23 07:07:59'),
(66, 'KRS0047', '123456', '2014-09-23 07:07:59'),
(67, '4000048', '123456', '2014-09-23 07:07:59'),
(68, '4000049', '123456', '2014-09-23 07:07:59'),
(69, '4000050', '2006200720082009', '2014-09-23 07:07:59'),
(70, '4000051', '2009200812092020', '2014-09-23 07:07:59'),
(71, '4000052', '2006200720082009', '2014-09-23 07:07:59'),
(72, '4000053', '2006200720082009', '2014-09-23 07:07:59'),
(73, '4000054', '2006200720082009', '2014-09-23 07:07:59'),
(74, '4000055', '123456', '2014-09-23 07:07:59'),
(75, 'KRS0056', '123456', '2014-09-23 07:07:59'),
(76, '4000057', '2006200720082009', '2014-09-23 07:07:59'),
(77, '4000058', '2006200720082009', '2014-09-23 07:07:59'),
(78, '4000059', '2006200720082009', '2014-09-23 07:07:59'),
(79, 'SER0060', '123456', '2014-09-23 07:07:59'),
(80, '4000061', '123456', '2014-09-23 07:07:59'),
(81, '4000062', '123456', '2014-09-23 07:07:59'),
(82, '4000063', '2006200720082009', '2014-09-23 07:07:59'),
(83, '4000064', '123456', '2014-09-23 07:07:59'),
(84, '4000065', '2006200720082009', '2014-09-23 07:07:59'),
(85, 'SER0066', '2006200720082009', '2014-09-23 07:07:59'),
(86, '4000067', '2009200812092020', '2014-09-29 04:46:33'),
(87, '4000068', '2009200812092020', '2014-09-29 05:18:08'),
(88, '4000069', '2009200812092020', '2014-09-29 05:21:57'),
(89, '4000070', '2009200812092020', '2014-09-29 06:45:37'),
(90, '4000071', '2009200812092020', '2014-09-29 06:48:58'),
(91, '4000072', '2009200812092020', '2014-09-29 06:53:50'),
(92, '4000073', '2009200812092020', '2014-09-29 06:56:47'),
(93, '4000074', '2009200812092020', '2014-09-29 07:00:13'),
(94, '4000075', '2009200812092020', '2014-09-29 07:04:29'),
(95, '4000076', '2009200812092020', '2014-09-29 07:14:38'),
(96, '4000077', '2009200812092020', '2014-09-29 07:23:59'),
(97, '4000078', '2009200812092020', '2014-09-29 07:43:42'),
(98, '4000079', '2009200812092020', '2014-09-29 07:44:27'),
(99, '4000080', '2009200812092020', '2014-09-29 08:09:07'),
(100, '4000081', '2009200812092020', '2014-09-29 08:20:55'),
(101, '4000082', '2006200720082009', '2014-09-30 02:52:02'),
(102, 'KRS0083', '2006200720082009', '2014-09-30 02:54:54'),
(103, 'KRS0084', '2006200720082009', '2014-09-30 02:55:15'),
(104, '4000085', '123456', '2014-09-30 03:38:53'),
(105, '4000086', '2006200720082009', '2014-09-30 04:08:25'),
(106, '4740087', '123456', '2014-10-28 02:14:19');

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
  `id_data_pegawai` int(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pengguna`),
  KEY `fk_3` (`id_kelurahan`),
  KEY `fk_4` (`id_jenis_pengguna`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `id_jenis_pengguna`, `id_kelurahan`, `id_data_pegawai`, `username`, `password`) VALUES
(10, 1, 3, 6, 'admin', 'admin'),
(11, 2, 3, 5, 'umum', 'umum'),
(12, 3, 3, 1, 'pemberdaya', 'pemberdaya'),
(14, 4, 3, 2, 'trantib', 'trantib'),
(15, 5, 3, 3, 'ekbang', 'ekbang'),
(16, 6, 3, 4, 'pemerintah', 'pemerintah'),
(17, 7, 3, 7, 'seklur', 'seklur'),
(18, 8, 3, 8, 'lurah', 'lurah'),
(19, 2, 3, 1, 'uu', 'uu'),
(20, 2, 3, 9, 'nama', 'nama'),
(21, 1, 3, 0, 'admin', 'admin'),
(22, 2, 3, 1, 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_ajb`
--

CREATE TABLE IF NOT EXISTS `permintaan_ajb` (
  `id_permintaan_ajb` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  `luas_tanah` int(15) NOT NULL,
  `luas_bangunan` int(15) NOT NULL,
  `no_persil` varchar(30) NOT NULL,
  `no_kohir` varchar(30) NOT NULL,
  `blok_tanah` varchar(50) NOT NULL,
  `rt_tanah` varchar(5) NOT NULL,
  `rw_tanah` varchar(5) NOT NULL,
  `kel_tanah` varchar(50) NOT NULL,
  `kec_tanah` varchar(50) NOT NULL,
  `no_akta` varchar(50) NOT NULL,
  `nama_pemilik` varchar(200) NOT NULL,
  `alamat_pemilik` varchar(300) NOT NULL,
  `pekerjaan_pemilik` varchar(200) NOT NULL,
  `batas_utara` varchar(200) NOT NULL,
  `batas_barat` varchar(200) NOT NULL,
  `batas_selatan` varchar(200) NOT NULL,
  `batas_timur` varchar(200) NOT NULL,
  `no_pbb` varchar(100) NOT NULL,
  `harga_tanah` int(15) NOT NULL,
  `harga_bangunan` int(15) NOT NULL,
  `keperluan` varchar(250) NOT NULL,
  PRIMARY KEY (`id_permintaan_ajb`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_andonnikah`),
  KEY `fk_5` (`id_kelurahan`),
  KEY `fk_9` (`nik`),
  KEY `fk_38` (`id_pejabat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `permintaan_andonnikah`
--

INSERT INTO `permintaan_andonnikah` (`id_permintaan_andonnikah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_registrasi`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `nama_pasangan`, `alamat_pasangan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_telp`, `ket`) VALUES
(43, 3, 1, '123456', '4000055', '400 / 4000055 / KEL.LG', '2014-09-13', '2', '2014-09-26', 'tes', 'cibeber', 3, '19:47:33', '19:47:33', '11', '19:48:29', '11', '19:48:37', '00:01:04', 1, 3, 11, '', ''),
(44, 3, 1, '2006200720082009', '4000055', '400 / 4000055 / KEL.LG', '2014-09-13', '2', '2014-09-26', 'tes', 'cibeber', 3, '19:47:33', '19:47:33', '11', '19:48:30', '11', '19:48:40', '00:01:07', 1, 3, 11, '', ''),
(45, 3, 1, '2006200720082009', '4000057', '400 / 4000057 / KEL.LG', '2014-09-19', '12aaaa', '2014-09-20', 'tes', 'aaaa', 3, '09:58:38', '09:58:38', '11', '12:39:30', '11', '20:04:00', '10:05:22', 1, 3, 11, '', ''),
(46, 3, 1, '2006200720082009', '4000058', '400 / 4000058 / KEL.LG', '2014-09-17', 'aaaaa', '2014-09-19', 'aaaa', 'aaa', 3, '10:00:43', '10:00:43', '11', '10:05:49', '11', '10:06:00', '00:05:17', 1, 3, 11, '', ''),
(47, 3, 1, '2006200720082009', '4000059', '400 / 4000059 / KEL.LG', '2014-09-19', 'aaaaa', '2014-09-20', 'aaaa', 'aaa', 3, '12:29:40', '12:29:40', '11', '12:39:02', '11', '21:17:31', '08:47:51', 1, 3, 11, '', ''),
(49, 3, 1, '123456', '4000062', '400 / 4000062 / KEL.LG', '2014-09-19', '2345', '2014-09-19', 'tes', 'tes', 3, '14:36:24', '14:36:24', '11', '14:46:18', '11', '14:47:06', '00:10:42', 1, 3, 11, '', ''),
(50, 3, 1, '2006200720082009', '4000063', '400 / 4000063 / KEL.LG', '2014-09-29', 'sdada', '2014-09-19', 'dsadsa', 'cimahi', 3, '15:27:19', '15:27:19', '11', '11:40:39', '11', '11:42:36', '04:15:17', 1, 3, 11, '', ''),
(51, 3, 1, '123456', '4000064', '400 / 4000064 / KEL.LG', '2014-09-23', 'S290-7bd-900/pemb.', '2014-09-20', 'Julaeha', 'kampung kidul', 3, '15:30:11', '15:30:11', '11', '12:33:45', '11', '12:46:28', '03:16:17', 1, 3, 11, '', ''),
(52, 3, 1, '2006200720082009', '4000065', '400 / 4000065 / KEL.LG', '2014-09-23', 'S290-7bd-900/pemb.', '2014-09-20', 'Julaeha', 'kampung kidul', 3, '12:29:53', '12:29:53', '11', '12:31:50', '11', '12:49:36', '00:19:43', 1, 3, 11, '', ''),
(53, 3, 1, '2009200812092020', '4000067', '400 / 4000067 / KEL.LG', '2014-09-29', '23333333333', '2014-09-27', 'dsadsa', 'cimahi', 3, '11:46:33', '11:46:33', '11', '11:47:30', '11', '11:48:02', '00:01:29', 1, 3, 11, '', ''),
(54, 3, 1, '2009200812092020', '4000068', '400 / 4000068 / KEL.LG', '2014-09-29', '23333333333', '2014-09-27', 'dsadsa', 'cimahi', 3, '12:18:08', '12:18:08', '11', '12:18:57', '11', '12:20:19', '00:02:11', 1, 3, 11, '', ''),
(55, 3, 1, '2009200812092020', '4000069', '400 / 4000069 / KEL.LG', '2014-09-29', 'sdada', '2014-09-20', 'dsadsa', 'cimahi', 3, '12:21:56', '12:21:56', '11', '12:22:39', '11', '12:23:03', '00:01:07', 1, 3, 11, '', ''),
(56, 3, 1, '2009200812092020', '4000070', '400 / 4000070 / KEL.LG', '2014-09-29', 'sdada', '2014-09-20', 'dsadsa', 'sdsad', 3, '13:45:37', '13:45:37', '11', '13:46:12', '11', '13:46:36', '00:00:59', 1, 3, 11, '', ''),
(57, 3, 1, '2009200812092020', '4000071', '400 / 4000071 / KEL.LG', '2014-09-29', '23333333333', '2014-09-27', 'dsadsa', 'cimahi', 3, '13:48:58', '13:48:58', '11', '13:50:43', '11', '13:51:26', '00:02:28', 1, 3, 11, '', ''),
(58, 3, 1, '2009200812092020', '4000072', '400 / 4000072 / KEL.LG', '2014-09-29', '23333333333', '2014-09-20', 'dsadsa', 'cimahi', 3, '13:53:50', '13:53:50', '11', '13:54:36', '11', '13:54:57', '00:01:07', 1, 3, 11, '', ''),
(59, 3, 1, '2009200812092020', '4000073', '400 / 4000073 / KEL.LG', '2014-09-29', '23333333333', '2014-09-26', 'dsadsa', 'sdsad', 3, '13:56:47', '13:56:47', '11', '13:57:28', '11', '13:57:50', '00:01:03', 1, 3, 11, '', ''),
(60, 3, 1, '2009200812092020', '4000074', '400 / 4000074 / KEL.LG', '2014-09-29', '23333333333', '2014-09-19', 'dsadsa', 'cimahi', 3, '14:00:13', '14:00:13', '11', '14:00:46', '11', '14:01:05', '00:00:52', 1, 3, 11, '', ''),
(61, 3, 1, '2009200812092020', '4000075', '400 / 4000075 / KEL.LG', '2014-09-29', '23333333333', '2014-09-19', 'dsadsa', 'cimahi', 3, '14:04:29', '14:04:29', '11', '14:05:06', '11', '14:05:50', '00:01:21', 1, 3, 11, '', ''),
(62, 3, 1, '2009200812092020', '4000076', '400 / 4000076 / KEL.LG', '2014-09-29', '23333333333', '2014-09-25', 'dsadsa', 'cimahi', 3, '14:14:38', '14:14:38', '10', '14:15:23', '10', '14:15:50', '00:01:12', 1, 3, 10, '', ''),
(63, 3, 1, '2009200812092020', '4000077', '400 / 4000077 / KEL.LG', '2014-09-29', '23333333333', '2014-09-26', 'dsadsa', 'cimahi', 3, '14:23:59', '14:23:59', '10', '14:29:37', '10', '14:30:19', '00:06:20', 1, 3, 10, '', ''),
(64, 3, 1, '2009200812092020', '4000078', '400 / 4000078 / KEL.LG', '2014-09-29', '23333333333', '2014-09-30', 'dsadsa', 'cimahi', 3, '14:43:42', '14:43:42', '10', '14:47:24', '10', '14:47:43', '00:04:01', 1, 3, 10, '', ''),
(65, 3, 1, '2009200812092020', '4000079', '400 / 4000079 / KEL.LG', '2014-09-29', '23333333333', '2014-09-27', 'dsadsa', 'cimahi', 3, '14:44:27', '14:44:27', '10', '14:45:09', '10', '14:45:54', '00:01:27', 1, 3, 10, '', ''),
(66, 3, 1, '2009200812092020', '4000080', '400 / 4000080 / KEL.LG', '2014-09-29', '23333333333', '2014-09-24', 'dsadsa', 'cimahi', 3, '15:09:07', '15:09:07', '10', '15:09:52', '10', '15:10:13', '00:01:06', 1, 3, 10, '', ''),
(67, 3, 1, '2009200812092020', '4000081', '400 / 4000081 / KEL.LG', '2014-09-29', '23333333333', '2014-09-26', 'dsadsa', 'cimahi', 3, '15:20:55', '15:20:55', '10', '15:21:39', '10', '15:22:10', '00:01:15', 1, 3, 10, '', ''),
(68, 3, 1, '2006200720082009', '4000082', '400 / 4000082 / KEL.LG', '2014-09-30', '12aa', '2014-09-30', 'tes', 'cibeber', 3, '09:52:02', '09:52:02', '11', '09:52:42', '11', '09:52:52', '00:00:50', 1, 3, 11, '', ''),
(69, 3, 1, '123456', '4000085', '400 / 4000085 / KEL.LG', '2014-09-30', '2345', '2014-09-10', 'tes', 'cimahi', 3, '10:38:53', '10:38:53', '11', '10:40:53', '11', '10:41:13', '00:02:20', 1, 3, 11, '', ''),
(70, 3, 1, '123456', '4740087', '400 / 4740087 / KEL.LG', '2014-10-28', '0012', '2014-10-03', 'tes', 'tes', 2, '09:14:19', '09:14:19', '11', '09:16:00', '11', NULL, NULL, 1, 3, 11, '-', '-');

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
  `nama_ayah` varchar(200) NOT NULL,
  `nama_ibu` varchar(200) NOT NULL,
  `nik_ayah` varchar(15) NOT NULL,
  `nik_ibu` varchar(15) NOT NULL,
  `tempat_lahir_ayah` varchar(200) NOT NULL,
  `tanggal_lahir_ayah` date NOT NULL,
  `tempat_lahir_ibu` varchar(200) NOT NULL,
  `tanggal_lahir_ibu` date NOT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_bd`),
  UNIQUE KEY `alamat_ibu` (`alamat_ibu`),
  KEY `fk_11` (`id_kelurahan`),
  KEY `fk_12` (`id_pejabat`),
  KEY `fk_8` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_bd`
--

INSERT INTO `permintaan_bd` (`id_permintaan_bd`, `id_kelurahan`, `id_pejabat`, `nik`, `alamat_ayah`, `pekerjaan_ayah`, `agama_ayah`, `alamat_ibu`, `pekerjaan_ibu`, `agama_ibu`, `nama_ayah`, `nama_ibu`, `nik_ayah`, `nik_ibu`, `tempat_lahir_ayah`, `tanggal_lahir_ayah`, `tempat_lahir_ibu`, `tanggal_lahir_ibu`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(1, 3, 3, '2006200720082009', 'majalaya', 'Petani', 'Islam', 'majalaya', 'Petani', 'Islam', '', '', '', '', '', '0000-00-00', '', '0000-00-00', '460/0077/Pembd./s2013', '2014-01-02', 'S290-7b.d-900/pemb', '2014-01-29', 'Beli Rumah', 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 2, 9, 14, '98', '', ''),
(2, 3, 3, '2006200720082009', 'ayah', 'guru', 'islam', 'cimahi', 'ibu rumah tangga', 'Islam', '', '', '', '', '', '0000-00-00', '', '0000-00-00', '290-Bd/pemb.', '2014-01-21', 'abcd', '2014-08-29', 'Bersih Diri', 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 2, 9, 14, '99', '', ''),
(3, 3, 1, '2006200720082009', 'cimahi', 'pns', 'islam', 'cibeber', 'pns', 'islam', '', '', '', '', '', '0000-00-00', '', '0000-00-00', '400 / BDR0045 / KEL.LG', '2014-09-10', 'S290-7bd-900/pemb.', '2014-09-11', 'bangun usaha', 2, '10:57:50', '10:57:50', '11', '11:02:04', '11', NULL, NULL, 1, 3, 11, 'BDR0045', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_belum_bekerja`
--

CREATE TABLE IF NOT EXISTS `permintaan_belum_bekerja` (
  `id_permintaan_belum_bekerja` int(11) NOT NULL,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `no_kip` varchar(20) NOT NULL,
  `no_surat` varchar(30) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(20) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `status` int(5) NOT NULL,
  `jam_masuk` time NOT NULL,
  `waktu_antrian` time NOT NULL,
  `antrian_oleh` varchar(200) NOT NULL,
  `waktu_proses` time NOT NULL,
  `proses_oleh` varchar(200) NOT NULL,
  `waktu_selesai` time NOT NULL,
  `waktu_total` int(15) NOT NULL,
  `id_jenis_surat` int(13) NOT NULL,
  `id_surat` int(13) NOT NULL,
  `id_pengguna` int(13) NOT NULL,
  `no_registrasi` varchar(20) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(300) NOT NULL,
  `keperluan` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_belummenikah`),
  KEY `fk_13` (`id_kelurahan`),
  KEY `fk_14` (`id_pejabat`),
  KEY `fk_15` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `permintaan_belummenikah`
--

INSERT INTO `permintaan_belummenikah` (`id_permintaan_belummenikah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(6, 3, 1, '123456', '230-Nik4h/pemb2.', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-29', 'Menikah', 1, '08:00:00', '08:00:00', '11', '08:10:00', '11', '08:20:00', 20, 1, 4, 11, '8', '', ''),
(7, 3, 1, '2009200812092020', '230-Nik4h/pemb2.', '2014-01-08', 'S290-7bd-900/pemb.', '2014-01-29', 'Menikah', 1, '08:00:00', '08:00:00', '11', '08:10:00', '11', '08:20:00', 20, 1, 4, 11, '8', '', ''),
(8, 3, 1, '2006200720082009', NULL, NULL, 'S290-7bd-900/pemb.', '2014-09-24', 'bangun usaha', 3, '10:05:52', '10:05:52', '11', '11:11:20', '11', '11:16:41', 4, 1, 3, 11, 'BM0024', '', ''),
(15, 3, 1, '2006200720082009', NULL, NULL, 'sas', '0000-00-00', 'aa', 3, '10:26:55', '10:26:55', '11', '11:08:55', '11', '11:16:49', 4, 1, 3, 11, 'BM0027', '', ''),
(16, 3, 3, '2006200720082009', NULL, NULL, 'sas', '0000-00-00', 'aa', 3, '10:29:42', '10:29:42', '11', '11:08:22', '11', '11:21:18', 4, 1, 3, 11, 'BM0029', '', '');

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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_bpr`),
  KEY `fk_16` (`id_kelurahan`),
  KEY `fk_17` (`id_pejabat`),
  KEY `fk_18` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `permintaan_bpr`
--

INSERT INTO `permintaan_bpr` (`id_permintaan_bpr`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `no_registrasi`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `stl`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_telp`, `ket`) VALUES
(7, 3, 1, '2006200720082009', '400 / BPR0036 / KEL.LG', 'BPR0036', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-17', 'bangun usaha', 'serumah', 3, '13:37:51', '13:37:51', '11', '13:55:44', '12', '13:55:46', 6, 1, 3, 11, '', ''),
(8, 3, 1, '2006200720082009', '400 / BPR0037 / KEL.LG', 'BPR0037', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-11', 'bangun usaha', 'serumah', 3, '13:38:55', '13:38:55', '12', '13:55:18', '11', '13:55:22', 6, 1, 3, 11, '', ''),
(9, 3, 1, '2006200720082009', '400 / BPR0038 / KEL.LG', 'BPR0038', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-09', 'bangun usaha', 'serumah', 3, '13:39:42', '13:39:42', '12', '13:49:58', '11', '13:55:03', 6, 1, 3, 11, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_domisili_panitia_pembangunan`
--

CREATE TABLE IF NOT EXISTS `permintaan_domisili_panitia_pembangunan` (
  `id_permintaan_domisili_panitia_pembangunan` int(15) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(15) NOT NULL,
  `id_pejabat` int(15) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `no_surat` varchar(30) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(35) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `status` int(4) NOT NULL,
  `jam_masuk` time NOT NULL,
  `waktu_antrian` time NOT NULL,
  `antrian_oleh` varchar(100) NOT NULL,
  `waktu_proses` time NOT NULL,
  `proses_oleh` varchar(100) NOT NULL,
  `waktu_selesai` time NOT NULL,
  `waktu_total` int(100) NOT NULL,
  `id_jenis_surat` int(15) NOT NULL,
  `id_surat` int(15) NOT NULL,
  `id_pengguna` int(15) NOT NULL,
  `no_registrasi` varchar(10) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  `nama_pembangunan` varchar(300) NOT NULL,
  `alamat_pembangunan` varchar(300) NOT NULL,
  `nama_ketua` varchar(100) NOT NULL,
  `nama_sekretaris` varchar(100) NOT NULL,
  `nama_bendahara` varchar(100) NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_domisili_panitia_pembangunan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_domisili_parpol`),
  KEY `fk_43` (`id_kelurahan`),
  KEY `fk_44` (`id_pejabat`),
  KEY `fk_45` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `permintaan_domisili_parpol`
--

INSERT INTO `permintaan_domisili_parpol` (`id_permintaan_domisili_parpol`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `masa_berlaku`, `nama_parpol`, `bergerak_bidang`, `jumlah_anggota`, `jam_kerja`, `alamat_parpol`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(6, 3, 4, '2006200720082009', '21', '2014-02-05', 'pengsu/pemk/12.p', '2014-02-26', 'bangun usaha', '2014-02-26', 'Partai Politik', 'Asuransi', 12, '24', 'Jl.teuing', 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 3, 21, 15, '21', '', ''),
(7, 3, 4, '123456', '21', '2014-02-05', 'pengsu/pemk/12.p', '2014-02-26', 'bangun usaha', '2014-02-26', 'Partai Politik', 'Asuransi', 12, '24', 'Jl.teuing', 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 3, 21, 15, '22', '', ''),
(8, 3, 4, '123456', '21', '2014-02-08', 'pengsu/pemk/12.p', '2014-02-26', 'bangun usaha', '2014-02-26', 'Partai Politik', 'Asuransi', 12, '24', 'Jl.teuing', 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 3, 21, 15, '22', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_domisili_penduduk`
--

CREATE TABLE IF NOT EXISTS `permintaan_domisili_penduduk` (
  `id_permintaan_domisili_penduduk` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  `keperluan` varchar(300) NOT NULL,
  `masa_berlaku` date NOT NULL,
  PRIMARY KEY (`id_permintaan_domisili_penduduk`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `jabatan` varchar(150) NOT NULL,
  `notaris` varchar(100) NOT NULL,
  `telp_kantor` varchar(15) NOT NULL,
  `akta_pendiri_perusahaan` varchar(30) NOT NULL,
  `nama_perusahaan` varchar(150) DEFAULT NULL,
  `bergerak_bidang` varchar(100) DEFAULT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_domisili_perusahaan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `permintaan_domisili_perusahaan`
--

INSERT INTO `permintaan_domisili_perusahaan` (`id_permintaan_domisili_perusahaan`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `jabatan`, `notaris`, `telp_kantor`, `akta_pendiri_perusahaan`, `nama_perusahaan`, `bergerak_bidang`, `jumlah_pegawai`, `jam_kerja`, `alamat_usaha`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(7, 3, 1, '2006200720082009', 'sdy/pem.120/kok', '2014-02-05', 'pengsu/pemk/12.p', '2014-02-27', 'bangun usaha', '', '', '', '', 'Sapei Foundation', 'Asuransi', 13, '45', 'jantung lewat pinggir', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL, '', '');

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
  `nama_yayasan` varchar(150) DEFAULT NULL,
  `alamat_yayasan` varchar(300) DEFAULT NULL,
  `no_akta_notaris` varchar(20) NOT NULL,
  `notaris` varchar(200) NOT NULL,
  `nama_ketua` varchar(200) NOT NULL,
  `nama_sekretaris` varchar(200) NOT NULL,
  `nama_bendahara` varchar(200) NOT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_domisili_yayasan`),
  KEY `fk_40` (`id_kelurahan`),
  KEY `fk_41` (`id_pejabat`),
  KEY `fk_42` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_domisili_yayasan`
--

INSERT INTO `permintaan_domisili_yayasan` (`id_permintaan_domisili_yayasan`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `nama_yayasan`, `alamat_yayasan`, `no_akta_notaris`, `notaris`, `nama_ketua`, `nama_sekretaris`, `nama_bendahara`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(3, 3, 1, '2006200720082009', 'sdy/pem.120/kotaa', '2014-02-04', 'pengsu/pemk/12.p', '2014-02-04', 'bangun usaha', 'serba ada', 'Jember', '', '', '', '', '', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL, '', '');

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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_ibadahhaji`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `permintaan_ibadahhaji`
--

INSERT INTO `permintaan_ibadahhaji` (`id_permintaan_ibadahhaji`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-29', 'S290-7bd-900/pemb.', 0, '2014-01-28', 1, '08:00:00', '08:10:00', 'Umum, S.Kom', '08:15:00', 'Umum, S.Kom', '08:20:00', 20, 1, 6, 11, '4', '', ''),
(4, 3, 1, '2009200812092020', '400 / 4 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', 3, '2014-09-03', 2, '08:00:00', '08:10:00', 'Umum, S.Kom', NULL, 'Umum, S.Kom', '08:20:00', 20, 1, 3, 11, '4', '', ''),
(5, 3, 1, '3277000202020012', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 3, '2014-01-04', 1, '08:00:00', '08:10:00', 'Umum, S.Kom', '08:15:00', 'Umum, S.Kom', '08:20:00', 20, 1, 6, 11, '4', '', ''),
(7, 3, 1, '2006200720082009', '400 / IH0001 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', NULL, '2014-09-24', 3, '14:47:53', '14:47:53', 'Umum, S.Kom', NULL, 'Umum, S.Kom', '15:04:23', 8, 1, 3, 11, 'IH0001', '', '');

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
  `hiburan` varchar(250) NOT NULL,
  `tempat_kegiatan` varchar(250) NOT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_ik`),
  KEY `fk_22` (`id_kelurahan`),
  KEY `fk_23` (`id_pejabat`),
  KEY `fk_24` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `permintaan_ik`
--

INSERT INTO `permintaan_ik` (`id_permintaan_ik`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `hari_kegiatan`, `tanggal_kegiatan`, `waktu`, `nama_kegiatan`, `hiburan`, `tempat_kegiatan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(4, 3, 1, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-29', 'Senin', '2014-01-23', '13:00 - 14:00', 'Reuni Masal', '', '', 1, '08:00:00', '08:05:00', 'Umum, S.Kom', '08:20:00', 'Umum, S.Kom', '08:25:00', 25, 2, 7, 11, '32', '', ''),
(5, 3, 1, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', 'Rabu', '2014-01-29', '12:00 - 15:00', 'Reuni Masal', '', '', 1, '08:00:00', '08:05:00', 'Umum, S.Kom', '08:10:00', 'Umum, S.Kom', '08:30:00', 30, 2, 7, 11, '13', '', ''),
(6, 3, 1, '123456', '460/0077/Pembd./2013', '2014-01-18', 'S290-7bd-900/pemb.', '2014-01-01', 'Kamis', '2014-01-30', '12:00 - 15:00', 'Acara Karang Taruna', '', '', 1, '08:00:00', '08:05:00', 'Umum, S.Kom', '08:10:00', 'Umum, S.Kom', '08:30:00', 30, 2, 7, 11, '13', '', ''),
(7, 3, 1, '2006200720082009', '400 / IKR0040 / KEL.LG', '2014-09-10', 'S290-7bd-900/pemb.', '2014-09-10', 'a', '2014-09-18', '13:00 - 14:00', 'aa', '', '', 3, '09:56:03', '09:56:03', 'Umum, S.Kom', '09:57:40', 'Umum, S.Kom', '09:58:01', 2, 1, 3, 11, 'IKR0040', '', '');

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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_janda`),
  KEY `fk_35` (`id_kelurahan`),
  KEY `fk_36` (`id_pejabat`),
  KEY `fk_37` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `permintaan_janda`
--

INSERT INTO `permintaan_janda` (`id_permintaan_janda`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `sebab_janda`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(6, 3, 1, '2009200812092020', '400 / 21 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-11', 'meningga;', 'bangun usaha', 3, '08:00:00', '08:00:00', 'umum', '16:49:58', 'Umum, S.Kom', '16:50:24', 9, 1, 3, 11, '21', '', ''),
(7, 3, 1, '123456', '400 / 21 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-10', 'meningga;', 'bangun usaha', 3, '08:00:00', '08:00:00', 'umum', '16:50:37', 'Umum, S.Kom', '16:50:40', 9, 1, 3, 11, '21', '', ''),
(8, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-04', 'S290-7bd-900/pemb.', '2014-01-01', 'KDRT', 'Beli Rumah haji', 1, '08:00:00', '08:00:00', 'umum', '08:15:00', 'umum', '08:20:00', 0, 1, 19, 11, '21', '', ''),
(10, 3, 1, '2006200720082009', '400 / J0001 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-10', 'meningga;', 'bangun usaha', 3, '16:46:18', '16:46:18', 'Umum, S.Kom', '16:47:28', 'Umum, S.Kom', '16:47:31', 9, 1, 3, 11, 'J0001', '', '');

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
  `keperluan` varchar(300) DEFAULT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_keterangan_tempat_usaha`),
  KEY `fk_46` (`id_kelurahan`),
  KEY `fk_47` (`id_pejabat`),
  KEY `fk_48` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `permintaan_keterangan_tempat_usaha`
--

INSERT INTO `permintaan_keterangan_tempat_usaha` (`id_permintaan_keterangan_tempat_usaha`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `bidang_usaha`, `alamat_usaha`, `keperluan`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(6, 3, 1, '2006200720082009', 'sdy/pem.120/kotaw', '2014-02-12', 'pengsu/pemk/12.p', 'Tani', 'Jl. Tau', '2014-02-05', '2014-02-11', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL, '', '');

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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_lahir`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `permintaan_lahir`
--

INSERT INTO `permintaan_lahir` (`id_permintaan_lahir`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `rw`, `nama_anak`, `jenis_kelamin_anak`, `tempat_lahir_anak`, `tgl_lahir_anak`, `anak_ke`, `jam_lahir`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', '05', 'riza', 'laki-laki', 'cimahi', '2014-08-30', 2, '23:59', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL, '', ''),
(4, 3, 5, '2006200720082009', NULL, '2014-09-09', 'S290-7bd-900/pemb.', NULL, '2014-09-11', NULL, 'riza', 'Perempuan', 'cimahi', NULL, 1, '23:33', 3, '19:51:38', '19:51:38', 'Umum, S.Kom', '19:54:29', 'Umum, S.Kom', '19:57:43', 12, 1, 3, 11, 'LA0001', '', ''),
(5, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '20:01:13', '20:01:13', 'Umum, S.Kom', NULL, NULL, NULL, NULL, 0, NULL, 11, 'LA0001', '', '');

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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_mati`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `permintaan_mati`
--

INSERT INTO `permintaan_mati` (`id_permintaan_mati`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `tanggal_meninggal`, `jam_meninggal`, `lokasi_meninggal`, `penyebab_meninggal`, `usia_meninggal`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(3, 3, 1, '2009200812092020', '400 /  / KEL.LG', '2014-09-09', 'pengsu/pemk/12.p', '2014-09-25', '2014-09-04', '12:23', '2014-09-04', 'kejang-kejang', 32, 'bangun usaha', 3, '00:00:00', '00:00:00', '', '20:26:05', 'Umum, S.Kom', '20:27:15', 13, 1, 3, 0, NULL, '', ''),
(4, 3, 5, '2006200720082009', '400 / MTI0039 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-17', '2014-09-25', '12:23', '2014-09-25', 'kejang-kejang', 32, 'Pengurusan Ke Taspen', 0, '20:23:43', '20:23:43', 'Umum, S.Kom', '20:24:52', 'Umum, S.Kom', NULL, NULL, 1, 3, 11, 'MTI0039', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_na`
--

CREATE TABLE IF NOT EXISTS `permintaan_na` (
  `id_permintaan_na` int(11) NOT NULL,
  `id_kelurahan` int(11) NOT NULL,
  `id_pejabat` int(11) NOT NULL,
  `nik` varchar(15) NOT NULL,
  `no_kip` varchar(15) NOT NULL,
  `no_surat` varchar(15) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `no_surat_pengantar` varchar(15) NOT NULL,
  `tanggal_surat_pengantar` date NOT NULL,
  `status` int(5) NOT NULL,
  `jam_masuk` time NOT NULL,
  `waktu_antrian` time NOT NULL,
  `antrian_oleh` varchar(150) NOT NULL,
  `waktu_proses` time NOT NULL,
  `proses_oleh` varchar(150) NOT NULL,
  `waktu_selesai` time NOT NULL,
  `waktu_total` int(11) NOT NULL,
  `id_jenis_surat` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `no_registrasi` varchar(10) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(300) NOT NULL,
  `nama_istri` varchar(200) NOT NULL,
  `bin_istri` varchar(150) NOT NULL,
  `tempat_lahir_istri` varchar(100) NOT NULL,
  `tanggal_lahir_istri` date NOT NULL,
  `kewarganegaraan_istri` varchar(30) NOT NULL,
  `agama_istri` varchar(10) NOT NULL,
  `pekerjaan_istri` varchar(100) NOT NULL,
  `alamat_istri` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_orang_yang_sama`
--

CREATE TABLE IF NOT EXISTS `permintaan_orang_yang_sama` (
  `id_permintaan_orang_yang_sama` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  `keperluan` varchar(300) NOT NULL,
  `perbedaan_penulisan` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_orang_yang_sama`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_pbb_mutasi`
--

CREATE TABLE IF NOT EXISTS `permintaan_pbb_mutasi` (
  `id_permintaan_mutasi_pbb` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  `keperluan` varchar(300) NOT NULL,
  `masa_berlaku` date NOT NULL,
  `no_pbb` varchar(50) NOT NULL,
  `atas_nama` varchar(200) NOT NULL,
  `kepada` varchar(200) NOT NULL,
  `luas_tanah` int(50) NOT NULL,
  `bukti_kepemilikan` varchar(200) NOT NULL,
  `no_bukti_kepemilikan` varchar(200) NOT NULL,
  `tanggal_bukti_kepemilikan` varchar(200) NOT NULL,
  `atas_nama_bukti_kepemilikan` varchar(200) NOT NULL,
  PRIMARY KEY (`id_permintaan_mutasi_pbb`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(100) NOT NULL,
  PRIMARY KEY (`id_permintaan_ps`),
  KEY `fk_25` (`id_kelurahan`),
  KEY `fk_26` (`id_pejabat`),
  KEY `fk_27` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `permintaan_ps`
--

INSERT INTO `permintaan_ps` (`id_permintaan_ps`, `id_kelurahan`, `id_pejabat`, `nik`, `no_registrasi`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_telp`, `ket`) VALUES
(6, 3, 3, '2006200720082009', NULL, '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', 'Beli Rumah', 1, '08:00:00', '08:00:00', '12', '08:10:00', '12', '08:20:00', 0, 2, 8, 14, '', ''),
(7, 3, 3, '123', NULL, '20', '2014-08-22', '21', '2014-08-14', 'melamar kerja', 1, '08:00:00', '08:00:00', '12', '08:10:00', '12', '08:20:00', 0, 2, 8, 14, '', ''),
(8, 3, 3, '123456', NULL, '20', '2014-08-22', '21', '2014-08-14', 'melamar kerja', 1, '08:00:00', '08:00:00', '12', '08:10:00', '12', '08:20:00', 0, 2, 8, 14, '', ''),
(9, 3, 1, '2006200720082009', 'SKC0046', '400 / SKC0046 / KEL.LG', '2014-09-10', 'S290-7bd-900/pemb.', '2014-09-04', 'bangun usaha', 3, '11:28:33', '11:28:33', '12', '11:29:42', '12', '11:29:44', 4, 1, 3, 11, '', '');

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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_rumahsakit`),
  KEY `fk_28` (`id_kelurahan`),
  KEY `fk_29` (`id_pejabat`),
  KEY `fk_30` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `permintaan_rumahsakit`
--

INSERT INTO `permintaan_rumahsakit` (`id_permintaan_rumahsakit`, `id_kelurahan`, `id_pejabat`, `nik`, `no_kip`, `no_jamkesmas`, `peruntukan`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `masa_berlaku`, `nama_rumahsakit`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(40, 3, 1, '2006200720082009', 'aaaa', 'aaaa', '0', '400 / RS0018 / KEL.LG', '2014-09-07', 'S290-7bd-900/pemb.', '2014-09-02', '2014-09-17', 'aaaa', 3, '15:31:55', '15:31:55', '11', '15:32:17', '11', '15:32:19', 8, 1, 3, 11, 'RS0018', '', ''),
(42, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '10:15:00', '10:15:00', '11', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'RS0024', '', ''),
(43, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '10:23:02', '10:23:02', '11', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'RS0025', '', ''),
(44, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '10:28:26', '10:28:26', '11', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'RS0028', '', ''),
(45, 3, 1, '2006200720082009', '888', '57', '0', '400 / RS0030 / KEL.LG', '2014-09-30', 'ssss', '2014-09-05', '2014-09-19', 'rs rumah sakit', 3, '12:05:42', '12:05:42', '11', '09:54:38', '10', '11:32:27', 1, 1, 3, 11, 'RS0030', '', ''),
(46, 3, 1, '2006200720082009', '3', '4', '0', '400 / RS0032 / KEL.LG', '2014-09-11', '3', '2014-09-11', '2014-09-20', 'rs rumah sakit', 3, '12:21:05', '12:21:05', '11', '12:20:08', '11', '12:20:21', 5, 1, 3, 11, 'RS0032', '', ''),
(47, 3, 1, '2006200720082009', '888', '57', '0', '400 / RS0032 / KEL.LG', '2014-09-12', '45', '2014-09-11', '2014-09-27', 'rs rumah sakit', 3, '12:23:49', '12:23:49', '11', '11:59:08', '11', '11:59:24', 4, 1, 3, 11, 'RS0032', '', ''),
(48, 3, NULL, '123456', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '12:00:00', '12:00:00', '11', NULL, NULL, NULL, NULL, NULL, NULL, 19, 'KRS0047', '', ''),
(49, 3, 1, '123456', '888', '57', '0', '400 / KRS0056 / KEL.LG', '2014-09-30', 'aaaaa', '2014-09-26', '2014-09-19', 'rs rumah sakit', 3, '13:10:39', '13:10:39', '11', '09:55:58', '10', '09:56:10', 4, 1, 3, 11, 'KRS0056', '', ''),
(50, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 1, '09:54:53', '09:54:53', '10', NULL, NULL, NULL, NULL, NULL, NULL, 10, 'KRS0083', '', '');

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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_sekolah`),
  KEY `fk_31` (`id_kelurahan`),
  KEY `fk_32` (`id_pejabat`),
  KEY `fk_33` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `permintaan_sekolah`
--

INSERT INTO `permintaan_sekolah` (`id_permintaan_sekolah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_kip`, `nama_siswa`, `tempat_lahir_siswa`, `tanggal_lahir_siswa`, `hub_keluarga`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `nama_sekolah`, `masa_berlaku`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(8, 3, 1, '123456', 'tes', 'Andri', 'cimahi', '2009-09-09', 'Orang Tua', '23', '2014-08-24', '223', '2014-08-21', 'sdn 1 cibeber', '2014-08-30', 'SKTM sekolah', 1, '08:00:00', '08:10:00', '11', '08:20:00', '11', '08:30:00', 30, 1, 2, 11, '14', '', ''),
(9, 3, 1, '2006200720082009', 'tes', 'Andri', 'cimahi', '2009-09-09', 'Orang Tua', '23', '2014-08-03', '223', '2014-08-21', 'sdn 1 cibeber', '2014-08-30', 'SKTM sekolah', 1, '08:00:00', '08:10:00', '11', '08:20:00', '11', '08:30:00', 30, 1, 2, 11, '14', '', ''),
(10, 3, 1, '2009200812092020', 'tes', 'Sinta', 'cimahi', '2009-09-09', 'Orang Tua', '23', '2014-08-03', '223', '2014-08-21', 'sdn 1 cibeber', '2014-08-30', 'SKTM sekolah', 1, '08:00:00', '08:10:00', '11', '08:20:00', '11', '08:30:00', 30, 1, 2, 11, '14', '', ''),
(11, 3, 1, '2006200720082009', 'aaaa', 'riza', 'ciamahi', '0000-00-00', 'Saudara', '400 / SS0019 / KEL.LG', '2014-09-07', 'S290-7bd-900/pemb.', '2014-09-03', 'rancabelut', '2014-09-03', 'bangun usaha', 3, '16:08:43', '16:08:43', '11', '18:10:52', '11', '18:14:09', 11, 1, 3, NULL, 'SS0019', '', ''),
(12, 3, 1, '2006200720082009', 'aaaa', 'riza', 'ciamahi', '2014-09-03', 'Saudara', '400 / SS0020 / KEL.LG', '2014-09-07', 'S290-7bd-900/pemb.', '2014-09-03', 'rancabelut', '2014-09-04', 'bangun usaha', 3, '18:18:10', '18:18:10', '11', '18:18:52', '11', '18:18:55', 11, 1, 3, 11, 'SS0020', '', ''),
(13, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '18:44:19', '18:44:19', '11', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'SS0021', '', ''),
(14, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '18:46:19', '18:46:19', '11', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'SS0022', '', ''),
(15, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '18:47:10', '18:47:10', '11', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'SS0023', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_serbaguna`
--

CREATE TABLE IF NOT EXISTS `permintaan_serbaguna` (
  `id_permintaan_serbaguna` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `keperluan` varchar(300) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_serbaguna`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `permintaan_serbaguna`
--

INSERT INTO `permintaan_serbaguna` (`id_permintaan_serbaguna`, `id_kelurahan`, `id_pejabat`, `nik`, `keperluan`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(3, 3, 1, '2009200812092020', NULL, '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', '2014-01-28', 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 0, 0, 0, NULL, '', ''),
(4, 3, 1, '2009200812092020', NULL, '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', '2014-01-28', 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 0, 0, 0, NULL, '', ''),
(5, 3, NULL, '123456', NULL, NULL, NULL, NULL, NULL, 1, '14:34:01', '14:34:01', '11', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'SER0060', '', ''),
(6, 3, 1, '2006200720082009', 'menanam modal', '400 / SER0066 / KEL.LG', '2014-09-23', 'aaaaa', '0000-00-00', 2, '12:56:25', '12:56:25', '11', '12:57:15', '11', NULL, NULL, 1, 3, 11, 'SER0066', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_sertifikat`
--

CREATE TABLE IF NOT EXISTS `permintaan_sertifikat` (
  `id_permintaan_sertifikat` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  `luas_tanah` int(15) NOT NULL,
  `luas_bangunan` int(15) NOT NULL,
  `blok_tanah` varchar(50) NOT NULL,
  `rt_tanah` varchar(5) NOT NULL,
  `rw_tanah` varchar(5) NOT NULL,
  `kel_tanah` varchar(50) NOT NULL,
  `kec_tanah` varchar(50) NOT NULL,
  `bukti_kepemilikan` varchar(150) NOT NULL,
  `no_kepemilikan` varchar(50) NOT NULL,
  `nama_pemilik` varchar(200) NOT NULL,
  `alamat_pemilik` varchar(300) NOT NULL,
  `pekerjaan_pemilik` varchar(200) NOT NULL,
  `batas_utara` varchar(200) NOT NULL,
  `batas_barat` varchar(200) NOT NULL,
  `batas_selatan` varchar(200) NOT NULL,
  `batas_timur` varchar(200) NOT NULL,
  `no_pbb` varchar(100) NOT NULL,
  `harga_tanah` int(15) NOT NULL,
  `harga_bangunan` int(15) NOT NULL,
  `keperluan` varchar(250) NOT NULL,
  PRIMARY KEY (`id_permintaan_sertifikat`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `berdasarkan` varchar(100) DEFAULT NULL,
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
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  `hari_meninggal` varchar(10) NOT NULL,
  `tanggal_meninggal` date NOT NULL,
  `tempat_meninggal` varchar(100) NOT NULL,
  `sebab_meninggal` varchar(100) NOT NULL,
  `keperluan` varchar(250) NOT NULL,
  PRIMARY KEY (`id_permintaan_waris`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permintaan_waris`
--

INSERT INTO `permintaan_waris` (`id_permintaan_waris`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `berdasarkan`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`, `hari_meninggal`, `tanggal_meninggal`, `tempat_meninggal`, `sebab_meninggal`, `keperluan`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', '12', '2014-01-28', 1, '00:00:00', '00:00:00', '', '00:00:00', '', '00:00:00', 0, 0, 0, 0, NULL, '', '', '', '0000-00-00', '', '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id_surat`, `id_jenis_surat`, `kode_surat`, `nama_surat`, `controller`) VALUES
(1, 1, '', 'SKTM Rumah Sakit', 'rumahsakit'),
(2, 1, '', 'SKTM Pendidikan', 'sekolah'),
(3, 1, '400', 'Andon Nikah', 'andonnikah'),
(4, 1, '', 'Belum Pernah Nikah', 'belummenikah'),
(5, 3, '', 'Belum Punya Rumah', 'bpr'),
(6, 4, '', 'Domisili Khusus Haji', 'ibadahhaji'),
(7, 2, '', 'Ijin Keramaian', 'ik'),
(8, 2, '', 'SKCK', 'ps'),
(9, 2, '', 'Bersih Diri', 'bd'),
(19, 1, '', 'Keterangan Janda / Duda', 'janda'),
(20, 2, '', 'Domisili Yayasan', 'domisiliyayasan'),
(21, 3, '', 'Domisili Parpol', 'domisiliparpol'),
(22, 3, '', 'Domisili Perusahaan', 'domisiliperusahaan'),
(23, 3, '', 'Ket. Usaha', 'keterangantempatusaha'),
(24, 4, '', 'Kelahiran', 'lahir'),
(25, 4, '', 'Kematian', 'mati'),
(26, 4, '', 'KTP', 'ktp'),
(27, 4, '', 'KK', 'kk'),
(28, 4, '', 'KIPEM', 'kipem'),
(29, 4, '', 'Lahir Mati', 'lahirmati'),
(30, 4, '', 'Orang yang Sama', 'orangyangsama'),
(31, 4, '', 'Pindah', 'pindah'),
(32, 4, '', 'Ahli Waris', 'ahliwaris'),
(34, 4, '', 'Domisili Penduduk', 'domisilspenduduk'),
(35, 4, '', 'Ket. Tanah & Bangunan (AJB)', 'ktbajb'),
(36, 4, '', 'Ket. Tanah & Bangunan (Sertifikat)', 'ktbsertifikat'),
(37, 4, '', 'Adm. Pensiun / SPTB', 'pensiun'),
(38, 4, '', 'Surat Kuasa', 'suratkuasa'),
(39, 4, '', 'Mutasi Balik Nama PBB', 'mutasipbb'),
(40, 4, '', 'Penerbitan SPPT PBB', 'penerbitanpbb'),
(41, 4, '', 'Split PBB Pemecahan', 'splitpbb'),
(42, 3, '', 'Domisili Panitia Pembangunan', 'domisilipanitiapemb'),
(43, 3, '', 'IMB', 'imb'),
(44, 3, '', 'Ket. Belum Punya Pekerjaan', 'belumbekerja'),
(45, 3, '', 'Rekomendasi Proposal Pemb', 'rekomendasiproposalpemb'),
(46, 3, '', 'SIUP / TDP', 'siup'),
(47, 1, '', 'Nikah (N.A)', 'na'),
(48, 2, '', 'Penelitian', 'penelitian'),
(49, 2, '', 'Pemberitahuan Tetangga/Gangguan', 'gangguan'),
(50, 2, '', 'Kartu Identitas Kerja', 'kartuidentitaskerja');

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
