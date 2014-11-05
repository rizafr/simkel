-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2014 at 01:11 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

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
(27, '123456', 'Keterangan Andonnikah', '400 / 4000', '2014-09-30', '4', '5', '6', '2', 'Cimahi-286x300.png', 'etc/data/upload/Cimahi-286x300.png'),
(28, '2006200720082009', 'Keterangan Bersih Diri', '400 / BDR0', '2014-09-10', '44', '22', '1', '5', 'twitder logo.jpg', 'etc/data/upload/twitder logo.jpg'),
(29, '2006200720082009', 'SKTM rumah sakit', '400 / RS00', '2014-10-31', '3', '3', '3', '2', 'add.png', 'etc/data/upload/add.png'),
(30, '2006200720082009', 'SKTM rumah sakit', '400 / RS00', '2014-10-31', '3', '3', '3', '2', 'add.png', 'etc/data/upload/add.png'),
(31, '123456', 'Keterangan Andonnikah', '400 / 4000', '2014-09-30', '2', '1', '2', '1', 'VBF.docx', 'etc/data/upload/VBF.docx'),
(32, '2006200720082009', 'SKTM rumah sakit', '400 / RS00', '2014-11-04', '6', '6', '6', '6', 'Koala.jpg', 'etc/data/upload/Koala.jpg'),
(33, '2006200720082009', 'SKTM Sekolah', '400 / SS00', '2014-11-04', '3', '3', '3', '3', 'Blue hills.jpg', 'etc/data/upload/Blue hills.jpg'),
(34, '2006200720082009', 'SKTM rumah sakit', '16 / 12 / ', '2014-11-04', '111', '1', '1', '1', 'Winter.jpg', 'etc/data/upload/Winter.jpg'),
(35, '3277015905550004', 'SKTM rumah sakit', '400 / 4010', '2014-11-04', '3', '1', '1', '1', 'Koala.jpg', 'etc/data/upload/Koala.jpg'),
(36, '', 'Keterangan Belum Menikah', '', '0000-00-00', '1', '1', '1', '1', 'Penguins.jpg', 'etc/data/upload/Penguins.jpg'),
(37, '3277011908960023', 'SKTM rumah sakit', '400 / 4010', '2014-11-04', '1', '2', '3', '4', 'Untitled.png', 'etc/data/upload/Untitled.png');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `data_pegawai`
--

INSERT INTO `data_pegawai` (`id_data_pegawai`, `nip_pengguna`, `nama_pengguna`, `jabatan`, `golongan`, `alamat`, `no_telp`) VALUES
(1, '1978240120040506001', 'Ratih Pujihati', 'Kasi Pemberdaya', 'IIIa', 'Cibeber', '0865793892'),
(4, '197308102005011000', 'AGUS IRWAN KUSTIAWAN, S.IP', 'Kasi Pemerintahan', 'IIIa', 'Cimahi', '-'),
(5, '1987240120040506001', 'Riza Fauzi Rahman', 'Staf IT', 'IIIa', 'Cibeber', '0865793892'),
(6, '197101272005011004', 'RULLY SULFANORIDA,ST', 'Sekretaris', 'III.C', 'Citeureup', '0818430711'),
(8, '195909161981011000', 'AGUS ANWAR ,S.SOS', 'Lurah', 'IIID - PNS', 'Cimahi', '-'),
(11, '197011102008011007', 'SIR''AN', 'FUNGSIONAL UMUM', 'II.B', 'CIBEBER RT.05 RW.06 NO.38', '081910062860'),
(12, '197412022007011000', 'IYAN SUKMANA,S.IP', 'kasi tramtib', 'III.B', 'cibeber', '085315737471'),
(13, '198005102007011000', 'JAJANG BINTAYA, SE', 'KASI PEMBERDAYAAN', 'III.B', 'BANDUNG BARAT', '082115111998'),
(14, '198001072008012000', 'NURDANINGSIH, S.Sos', 'FUNGSIONAL UMUM', 'III.A', 'Utama', '081321131231'),
(16, '198307082010011000', 'TAUFIK RAHMAN', 'Fungsional Umum', 'II.B', 'Jl.Pajagalan Kab Bandung Barat', '081910502114'),
(17, '198101292010011005', 'WANDA, SE', 'STAF', 'III.A', 'BANDUNG', '004'),
(18, '19850118 200604 1 00', 'DEVI JANUAR HADI, S.Si., M.Si', 'KASI EKONOMI PEMBANGUNAN', 'III.c ', 'BANDUNG BARAT', '123');

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
('3277011910060636', 'SARYONO', 'KP.CIBOGO', 5, 6, 'CIBOGO', '40532', '3277011908960023', '', 'ANGGI EKO NURSAPUTRA', 'Laki-laki', 'CIMAHI', '1996-08-19', '-', 'O', 'Islam', 'Belum Bekerja', 'ENOK RODIAH', 'SARYONO', 'Belum Menikah', 3),
('3277011609140027', 'EUIS SADRIAH NUR ASIKIN', 'Jl. Taruna Bakti No.16  ', 7, 11, 'Leuwigajah', '40532', '3277015905550004', '', 'EUIS BADRIAH NUR ASIKIN', 'Perempuan', 'Bandung', '1990-11-13', '-', 'O', 'Islam', 'Pensiunan', 'HJ.MARFUAH', 'HJ.ASIKIN', 'Menikah', 3),
('2345', 'Utar', 'Cibeber', 10, 4, 'Cibeber', '40531', '345678', 'Indonesia', 'Ratih Pujihati', 'Perempuan', 'Garut', '1992-02-04', '42321', 'O', 'Islam', 'Mahasiswa', 'nunung', 'utar', 'Belum Menikah', 3),
('12345678', 'Riza Fauzi Rahman', 'Leuwigajah', 2, 1, 'cibeber', '12490', '87654321234567', 'Indonesia', 'Mamad Kenyod', 'Laki-laki', 'Jember', '1992-12-31', 'Akta/.323./lahir', 'O', 'Islam', 'Wiraswasta', 'Siti Faatimah', 'Iding Samsudin', 'Menikah', 3),
('2', 'w', 'e', 1, 1, 'k', '0', '9', 'Indonesia', 'i', 'Laki-laki', 'g', '1999-08-09', '8', 'O', 'Islam', 'u', 'u', 'u', 'Menikah', 3),
('123456789', 'SIR AN', 'CIBEBER', 0, 0, '', '44152', '987654321', '', 'SIR AN', 'Laki-laki', 'LOMBOK', '1976-01-01', '123', 'O', 'Islam', 'PNS', 'IBU IBI', 'AYAH', 'Menikah', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130 ;

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
(106, '4740087', '123456', '2014-10-28 02:14:19'),
(107, '4740088', '123456', '2014-10-28 05:01:07'),
(108, '4010089', '2006200720082009', '2014-10-29 01:49:43'),
(109, '4010090', '123456', '2014-10-31 06:22:38'),
(110, '4740091', '20062007200', '2014-11-03 09:20:10'),
(111, 'IHJ0092', '2006200720082009', '2014-11-04 07:24:13'),
(112, '4740093', '2006200720082009', '2014-11-04 07:34:42'),
(113, '148.40094', '2006200720082009', '2014-11-04 08:21:42'),
(114, '4010001', '2006200720082009', '2014-11-04 08:22:51'),
(115, '4010001', '2006200720082009', '2014-11-04 08:23:56'),
(116, '4010001', '2006200720082009', '2014-11-04 08:24:29'),
(117, '4010001', '2006200720082009', '2014-11-04 08:25:12'),
(118, '4010001', '123456', '2014-11-04 08:26:44'),
(119, '4010001', '3277015905550004', '2014-11-04 08:27:22'),
(120, '4010001', '123456', '2014-11-04 08:28:50'),
(121, '4010001', '123456', '2014-11-04 08:30:01'),
(122, '4010001', '123456', '2014-11-04 08:41:25'),
(123, '4010001', '123456', '2014-11-04 08:41:51'),
(124, '4010001', '123456', '2014-11-04 08:44:58'),
(125, '4010001', '123456', '2014-11-04 08:50:40'),
(126, '4700001', '3277011908960023', '2014-11-04 08:51:48'),
(127, '4740001', '123456', '2014-11-04 09:00:30'),
(128, '4700001', '987654321', '2014-11-04 09:04:29'),
(129, '4010001', '3277011908960023', '2014-11-04 09:04:50');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pejabat_kelurahan`
--

INSERT INTO `pejabat_kelurahan` (`id_pejabat`, `nip_pejabat`, `nama_pejabat`, `id_kelurahan`, `id_jenis_pengguna`) VALUES
(1, '198005102007011009', 'JAJANG BINTAYA, S.E', 3, 3),
(3, '197402122007011009', 'IYAN SUKMANA, S.IP', 3, 4),
(4, '198501182006041004', 'DEVI JANUAR HADI, S.Si, M.Si', 3, 5),
(5, '197308102005011009', 'AGUS IRWAN KUSTIAWAN, S.IP', 3, 6),
(6, '195909161981011004', 'AGUS ANWAR, S.SOS', 3, 8),
(7, '197101272005011004', 'RULLY SULFANORIDA, ST', 3, 7);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `id_jenis_pengguna`, `id_kelurahan`, `id_data_pegawai`, `username`, `password`) VALUES
(10, 1, 3, 6, 'admin', 'admin'),
(11, 2, 3, 5, 'umum', 'umum'),
(14, 4, 3, 2, 'trantib', 'trantib'),
(15, 5, 3, 3, 'ekbang', 'ekbang'),
(16, 6, 3, 4, 'pemerintah', 'pemerintah'),
(17, 7, 3, 7, 'seklur', 'seklur'),
(18, 8, 3, 8, 'lurah', 'lurah'),
(19, 2, 3, 1, 'uu', 'uu'),
(20, 2, 3, 9, 'nama', 'nama'),
(21, 1, 3, 0, 'admin', 'admin'),
(23, 2, 3, 7, 'rully', '1234'),
(24, 2, 3, 10, 'tes', '1234'),
(25, 2, 3, 11, 'siran', '1234'),
(26, 2, 3, 14, 'NURDA', '1234'),
(27, 2, 3, 16, 'OPIK', '1234'),
(28, 1, 3, 12, 'IYAN', '1234'),
(29, 1, 3, 13, 'JABIN', '1234'),
(30, 2, 3, 13, 'JABIN KASEP', '1234'),
(31, 2, 3, 12, 'ISUK KENEH', '1234'),
(32, 2, 3, 17, 'WANDA', '1234'),
(33, 1, 3, 17, 'WANDA ADMIN', '1234'),
(34, 1, 3, 18, 'DEVI ADMIN', '1234'),
(35, 2, 3, 18, 'DEVI STAF', '1234');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `permintaan_ajb`
--

INSERT INTO `permintaan_ajb` (`id_permintaan_ajb`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`, `luas_tanah`, `luas_bangunan`, `no_persil`, `no_kohir`, `blok_tanah`, `rt_tanah`, `rw_tanah`, `kel_tanah`, `kec_tanah`, `no_akta`, `nama_pemilik`, `alamat_pemilik`, `pekerjaan_pemilik`, `batas_utara`, `batas_barat`, `batas_selatan`, `batas_timur`, `no_pbb`, `harga_tanah`, `harga_bangunan`, `keperluan`) VALUES
(1, 3, 2, '123456', '23', '2014-11-04', '33', '2014-11-07', 3, '12:20:55', '12:23:55', '11', '12:28:55', '11', '12:34:55', 30, 4, 35, 11, '12', '086789', '2', 45, 34, '-', '-', '-', '7', '8', 'leuwigajah', 'cimahi', '-', 'tes', 'tes', 'tes', 'tes', 'tes', 'tes', 'tes', 'tes', 450000, 500000, '-');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `permintaan_andonnikah`
--

INSERT INTO `permintaan_andonnikah` (`id_permintaan_andonnikah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_registrasi`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `nama_pasangan`, `alamat_pasangan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_telp`, `ket`) VALUES
(66, 3, 1, '2009200812092020', '4000080', '400 / 4000080 / KEL.LG', '2014-09-29', '23333333333', '2014-09-24', 'dsadsa', 'cimahi', 3, '15:09:07', '15:09:07', '10', '15:09:52', '10', '15:10:13', '00:01:06', 1, 3, 10, '', ''),
(67, 3, 1, '2009200812092020', '4000081', '400 / 4000081 / KEL.LG', '2014-09-29', '23333333333', '2014-09-26', 'dsadsa', 'cimahi', 3, '15:20:55', '15:20:55', '10', '15:21:39', '10', '15:22:10', '00:01:15', 1, 3, 10, '', ''),
(68, 3, 1, '2006200720082009', '4000082', '400 / 4000082 / KEL.LG', '2014-09-30', '12aa', '2014-09-30', 'tes', 'cibeber', 3, '09:52:02', '09:52:02', '11', '09:52:42', '11', '09:52:52', '00:00:50', 1, 3, 11, '', ''),
(69, 3, 1, '123', '4000082', '400 / 4000082 / KEL.LG', '2014-09-30', '12aa', '2014-09-30', 'tes', 'cibeber', 3, '09:52:02', '09:52:02', '11', '09:52:42', '11', '09:52:52', '00:00:50', 1, 3, 11, '', ''),
(70, 3, 1, '123456', '4000082', '400 / 4000082 / KEL.LG', '2014-09-30', '12aa', '2014-09-30', 'tes', 'cibeber', 3, '09:52:02', '09:52:02', '11', '09:52:42', '11', '16:27:18', '06:35:16', 1, 3, 11, '', ''),
(77, 3, 1, '2006200720082009', '4740093', '400 / 4740093 / KEL.LG', '2014-11-04', '222222', '2014-11-12', 'ratih', 'cibeber', 2, '14:34:42', '14:34:42', '11', '14:35:13', '11', NULL, NULL, 1, 3, 11, '-', '-'),
(78, 3, NULL, '123456', '4740001', NULL, NULL, NULL, NULL, NULL, NULL, 1, '16:00:30', '16:00:30', '35', NULL, NULL, NULL, NULL, 0, 0, 35, '1234', '');

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
(3, 3, 1, '2006200720082009', 'cimahi', 'pns', 'islam', 'cibeber', 'pns', 'islam', '', '', '', '', '', '0000-00-00', '', '0000-00-00', '400 / BDR0045 / KEL.LG', '2014-09-10', 'S290-7bd-900/pemb.', '2014-09-11', 'bangun usaha', 3, '10:57:50', '10:57:50', '11', '11:02:04', '11', '14:37:39', 3, 1, 3, 11, 'BDR0045', '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `permintaan_belummenikah`
--

INSERT INTO `permintaan_belummenikah` (`id_permintaan_belummenikah`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(8, 3, 1, '2006200720082009', NULL, NULL, 'S290-7bd-900/pemb.', '2014-09-24', 'bangun usaha', 3, '10:05:52', '10:05:52', '11', '11:11:20', '11', '11:16:41', 4, 1, 3, 11, 'BM0024', '', ''),
(15, 3, 1, '2006200720082009', NULL, NULL, 'sas', '0000-00-00', 'aa', 3, '10:26:55', '10:26:55', '11', '11:08:55', '11', '11:16:49', 4, 1, 3, 11, 'BM0027', '', ''),
(16, 3, 3, '2006200720082009', NULL, NULL, 'sas', '0000-00-00', 'aa', 3, '10:29:42', '10:29:42', '11', '11:08:22', '11', '11:21:18', 4, 1, 3, 11, 'BM0029', '', ''),
(17, 3, 1, '3277011908960023', NULL, NULL, '94/05/RW.06/2014', '2014-11-01', 'Keterangan Belum Menikah', 3, '15:51:48', '15:51:48', '25', '15:54:51', '25', '15:55:03', 15, 1, 3, 25, '4700001', '-', '-'),
(18, 3, NULL, '987654321', NULL, NULL, NULL, NULL, NULL, 1, '16:04:29', '16:04:29', '35', NULL, NULL, NULL, NULL, NULL, NULL, 35, '4700001', '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `permintaan_domisili_panitia_pembangunan`
--

INSERT INTO `permintaan_domisili_panitia_pembangunan` (`id_permintaan_domisili_panitia_pembangunan`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`, `nama_pembangunan`, `alamat_pembangunan`, `nama_ketua`, `nama_sekretaris`, `nama_bendahara`, `keperluan`) VALUES
(1, 3, 3, '123456', '23', '2014-11-04', '23', '2014-11-06', 3, '07:09:07', '07:15:07', '11', '07:20:07', '11', '07:30:07', 30, 3, 22, 11, '12', '086789', '-', 'tes', 'tes', 'tes', 'tes', 'tes', 'tes');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `permintaan_domisili_penduduk`
--

INSERT INTO `permintaan_domisili_penduduk` (`id_permintaan_domisili_penduduk`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`, `keperluan`, `masa_berlaku`) VALUES
(1, 3, 5, '123456', '3', '2014-11-03', '3', '2014-11-02', 3, '12:20:55', '12:23:55', '11', '12:28:55', '11', '12:34:55', 30, 4, 34, 3, '3', '3', '33', '33', '2014-11-14');

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
  `no_registrasi` varchar(50) DEFAULT NULL,
  `no_telp` varchar(13) NOT NULL,
  `ket` varchar(150) NOT NULL,
  PRIMARY KEY (`id_permintaan_domisili_perusahaan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `permintaan_domisili_perusahaan`
--

INSERT INTO `permintaan_domisili_perusahaan` (`id_permintaan_domisili_perusahaan`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `keperluan`, `jabatan`, `notaris`, `telp_kantor`, `akta_pendiri_perusahaan`, `nama_perusahaan`, `bergerak_bidang`, `jumlah_pegawai`, `jam_kerja`, `alamat_usaha`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `no_registrasi`, `no_telp`, `ket`) VALUES
(7, 3, 1, '2006200720082009', 'sdy/pem.120/kok', '2014-02-05', 'pengsu/pemk/12.p', '2014-02-27', 'bangun usaha', '', '', '', '', 'Sapei Foundation', 'Asuransi', 13, '45', 'jantung lewat pinggir', 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 3, 22, NULL, '', '');

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
(3, 3, 1, '2006200720082009', 'sdy/pem.120/kotaa', '2014-02-04', 'pengsu/pemk/12.p', '2014-02-04', 'bangun usaha', 'serba ada', 'Jember', '3', 'rrr', 't', 't', 't', 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 2, 20, 11, NULL, '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `permintaan_ibadahhaji`
--

INSERT INTO `permintaan_ibadahhaji` (`id_permintaan_ibadahhaji`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-29', 'S290-7bd-900/pemb.', 0, '2014-01-28', 1, '08:00:00', '08:10:00', '11', '08:15:00', '11', '08:20:00', 20, 1, 6, 11, '4', '', ''),
(4, 3, 1, '2009200812092020', '400 / 4 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', 3, '2014-09-03', 2, '08:00:00', '08:10:00', '11', NULL, '11', '08:20:00', 20, 1, 3, 11, '4', '', ''),
(5, 3, 1, '3277000202020012', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 3, '2014-01-04', 1, '08:00:00', '08:10:00', '11', '08:15:00', '11', '08:20:00', 20, 1, 6, 11, '4', '', ''),
(7, 3, 1, '2006200720082009', '400 / IH0001 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', NULL, '2014-09-24', 3, '14:47:53', '14:47:53', '11', NULL, '11', '15:04:23', 8, 1, 3, 11, 'IH0001', '', ''),
(8, 3, 1, '2006200720082009', '400 / IHJ0092 / KEL.LG', '2014-11-04', '45', NULL, '2014-11-11', 2, '14:24:13', '14:24:13', '11', NULL, '11', NULL, NULL, 1, 3, 11, 'IHJ0092', '-', '-');

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
(4, 3, 1, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-29', 'Senin', '2014-01-23', '13:00 - 14:00', 'Reuni Masal', '', '', 1, '08:00:00', '08:05:00', '11', '08:20:00', '11', '08:25:00', 25, 2, 7, 11, '32', '', ''),
(5, 3, 1, '2006200720082009', '460/0077/Pembd./2013', '2014-01-16', 'S290-7bd-900/pemb.', '2014-01-01', 'Rabu', '2014-01-29', '12:00 - 15:00', 'Reuni Masal', '', '', 1, '08:00:00', '08:05:00', '11', '08:10:00', '11', '08:30:00', 30, 2, 7, 11, '13', '', ''),
(6, 3, 1, '123456', '460/0077/Pembd./2013', '2014-01-18', 'S290-7bd-900/pemb.', '2014-01-01', 'Kamis', '2014-01-30', '12:00 - 15:00', 'Acara Karang Taruna', '', '', 1, '08:00:00', '08:05:00', '11', '08:10:00', '11', '08:30:00', 30, 2, 7, 11, '13', '', ''),
(7, 3, 1, '2006200720082009', '400 / IKR0040 / KEL.LG', '2014-09-10', 'S290-7bd-900/pemb.', '2014-09-10', 'Selasa', '2014-09-18', '13:00 - 14:00', 'Sunatan Massal', 'Dangdutan', 'Lapangan', 3, '09:56:03', '09:56:03', '11', '09:57:40', '11', '09:58:01', 2, 1, 3, 11, 'IKR0040', '', '');

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
(6, 3, 1, '2006200720082009', 'sdy/pem.120/kotaw', '2014-02-12', 'pengsu/pemk/12.p', 'Tani', 'Jl. Tau', '2014-02-05', '2014-02-11', 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 3, 22, 11, NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_kipem`
--

CREATE TABLE IF NOT EXISTS `permintaan_kipem` (
  `id_permintaan_kipem` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id_permintaan_kipem`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_kk`
--

CREATE TABLE IF NOT EXISTS `permintaan_kk` (
  `id_permintaan_kk` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id_permintaan_kk`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_ktp`
--

CREATE TABLE IF NOT EXISTS `permintaan_ktp` (
  `id_permintaan_ktp` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id_permintaan_ktp`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `hari_lahir` date NOT NULL,
  `nama_ayah` varchar(200) NOT NULL,
  `agama_ayah` varchar(10) NOT NULL,
  `pekerjaan_ayah` varchar(200) NOT NULL,
  `alamat_ayah` varchar(300) NOT NULL,
  `umur_ayah` int(12) NOT NULL,
  `nama_ibu` varchar(200) NOT NULL,
  `agama_ibu` varchar(10) NOT NULL,
  `pekerjaan_ibu` varchar(200) NOT NULL,
  `alamat_ibu` varchar(300) NOT NULL,
  `umur_ibu` int(10) NOT NULL,
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

INSERT INTO `permintaan_lahir` (`id_permintaan_lahir`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `rw`, `nama_anak`, `jenis_kelamin_anak`, `tempat_lahir_anak`, `tgl_lahir_anak`, `anak_ke`, `jam_lahir`, `hari_lahir`, `nama_ayah`, `agama_ayah`, `pekerjaan_ayah`, `alamat_ayah`, `umur_ayah`, `nama_ibu`, `agama_ibu`, `pekerjaan_ibu`, `alamat_ibu`, `umur_ibu`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', 12, '2014-01-28', '05', 'riza', 'laki-laki', 'cimahi', '2014-08-30', 2, '23:59', '0000-00-00', '', '', '', '', 0, '', '', '', '', 0, 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 0, 0, 11, NULL, '', ''),
(4, 3, 5, '2006200720082009', NULL, '2014-09-09', 'S290-7bd-900/pemb.', NULL, '2014-09-11', NULL, 'riza', 'Perempuan', 'cimahi', NULL, 1, '23:33', '0000-00-00', '', '', '', '', 0, '', '', '', '', 0, 3, '19:51:38', '19:51:38', '11', '19:54:29', '11', '19:57:43', 12, 1, 3, 11, 'LA0001', '', ''),
(5, 3, NULL, '2006200720082009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', '', '', '', '', 0, '', '', '', '', 0, 1, '20:01:13', '20:01:13', '11', NULL, '11', NULL, NULL, 0, NULL, 11, 'LA0001', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_lahir_baru`
--

CREATE TABLE IF NOT EXISTS `permintaan_lahir_baru` (
  `id_permintaan_lahir_baru` int(11) NOT NULL AUTO_INCREMENT,
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
  `hari_lahir` date NOT NULL,
  `kota_lahir` varchar(100) NOT NULL,
  `jenis_kelahiran` varchar(50) NOT NULL,
  `berat` varchar(10) NOT NULL,
  `panjang` varchar(10) NOT NULL,
  `penolong_kelahiran` varchar(100) NOT NULL,
  `nama_ayah` varchar(200) NOT NULL,
  `pekerjaan_ayah` varchar(200) NOT NULL,
  `alamat_ayah` varchar(300) NOT NULL,
  `umur_ayah` int(12) NOT NULL,
  `nama_ibu` varchar(200) NOT NULL,
  `pekerjaan_ibu` varchar(200) NOT NULL,
  `alamat_ibu` varchar(300) NOT NULL,
  `umur_ibu` int(10) NOT NULL,
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
  `tgl_pencatatan_perkawinan` date NOT NULL,
  `nama_pelapor` varchar(200) NOT NULL,
  `nama_saksi1` varchar(200) NOT NULL,
  `nama_saksi2` varchar(200) NOT NULL,
  `nama_kk` varchar(200) NOT NULL,
  `no_kk` varchar(100) NOT NULL,
  `tanggal_lahir_ayah` date NOT NULL,
  `tanggal_lahir_ibu` date NOT NULL,
  `tanggal_pencatatan_perkawinan` date NOT NULL,
  PRIMARY KEY (`id_permintaan_lahir_baru`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `nama_meninggal` varchar(250) NOT NULL,
  `tempat_lahir_meninggal` varchar(200) NOT NULL,
  `tanggal_lahir_meninggal` date NOT NULL,
  `agama_meninggal` varchar(15) NOT NULL,
  `pekerjaan_meninggal` varchar(200) NOT NULL,
  `alamat_meninggal` varchar(300) NOT NULL,
  `hari_meninggal` varchar(20) NOT NULL,
  `tanggal_meninggal` date NOT NULL,
  `tempat_meninggal` varchar(200) NOT NULL,
  `sebab_meninggal` varchar(200) NOT NULL,
  PRIMARY KEY (`id_permintaan_mati`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `permintaan_mati`
--

INSERT INTO `permintaan_mati` (`id_permintaan_mati`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`, `nama_meninggal`, `tempat_lahir_meninggal`, `tanggal_lahir_meninggal`, `agama_meninggal`, `pekerjaan_meninggal`, `alamat_meninggal`, `hari_meninggal`, `tanggal_meninggal`, `tempat_meninggal`, `sebab_meninggal`) VALUES
(3, 3, 1, '2009200812092020', '400 /  / KEL.LG', '2014-09-09', 'pengsu/pemk/12.p', '2014-09-25', 3, '00:00:00', '00:00:00', '11', '20:26:05', '11', '20:27:15', 13, 1, 3, 0, NULL, '', '', '', '', '0000-00-00', '', '', '', '', '0000-00-00', '', ''),
(4, 3, 5, '2006200720082009', '400 / MTI0039 / KEL.LG', '2014-09-09', 'S290-7bd-900/pemb.', '2014-09-17', 0, '20:23:43', '20:23:43', '11', '20:24:52', '11', NULL, NULL, 1, 3, 11, 'MTI0039', '', '', '', '', '0000-00-00', '', '', '', '', '0000-00-00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_mati_baru`
--

CREATE TABLE IF NOT EXISTS `permintaan_mati_baru` (
  `id_permintaan_mati_baru` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_pejabat` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `no_surat_pengantar` varchar(50) DEFAULT NULL,
  `rt` int(11) DEFAULT NULL,
  `tanggal_surat_pengantar` date DEFAULT NULL,
  `rw` varchar(5) DEFAULT NULL,
  `nama_ayah` varchar(200) NOT NULL,
  `pekerjaan_ayah` varchar(200) NOT NULL,
  `alamat_ayah` varchar(300) NOT NULL,
  `umur_ayah` int(12) NOT NULL,
  `nama_ibu` varchar(200) NOT NULL,
  `pekerjaan_ibu` varchar(200) NOT NULL,
  `alamat_ibu` varchar(300) NOT NULL,
  `umur_ibu` int(10) NOT NULL,
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
  `nama_pelapor` varchar(200) NOT NULL,
  `nama_saksi1` varchar(200) NOT NULL,
  `nama_saksi2` varchar(200) NOT NULL,
  `tanggal_lahir_ayah` date NOT NULL,
  `tanggal_lahir_ibu` date NOT NULL,
  `tanggal_pencatatan_perkawinan` date NOT NULL,
  `nik_jenazah` varchar(15) NOT NULL,
  `nama_jenazah` varchar(200) NOT NULL,
  `jk_jenazah` varchar(15) NOT NULL,
  `tanggal_lahir_jenazah` date NOT NULL,
  `umur_jenazah` int(5) NOT NULL,
  `tempat_lahir_jenazah` varchar(200) NOT NULL,
  `agama_jenazah` varchar(20) NOT NULL,
  `pekerjaan_jenazah` varchar(100) NOT NULL,
  `alamat_jenazah` varchar(300) NOT NULL,
  `anak_ke` int(5) NOT NULL,
  `tanggal_kematian` date NOT NULL,
  `jam_meninggal` time NOT NULL,
  `sebab_kematian` varchar(150) NOT NULL,
  `tempat_kematian` varchar(100) NOT NULL,
  `yang_menerangkan` varchar(150) NOT NULL,
  `nama_kk` varchar(150) NOT NULL,
  `no_kk` varchar(15) NOT NULL,
  PRIMARY KEY (`id_permintaan_mati_baru`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `permintaan_mati_baru`
--

INSERT INTO `permintaan_mati_baru` (`id_permintaan_mati_baru`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `rt`, `tanggal_surat_pengantar`, `rw`, `nama_ayah`, `pekerjaan_ayah`, `alamat_ayah`, `umur_ayah`, `nama_ibu`, `pekerjaan_ibu`, `alamat_ibu`, `umur_ibu`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`, `nama_pelapor`, `nama_saksi1`, `nama_saksi2`, `tanggal_lahir_ayah`, `tanggal_lahir_ibu`, `tanggal_pencatatan_perkawinan`, `nik_jenazah`, `nama_jenazah`, `jk_jenazah`, `tanggal_lahir_jenazah`, `umur_jenazah`, `tempat_lahir_jenazah`, `agama_jenazah`, `pekerjaan_jenazah`, `alamat_jenazah`, `anak_ke`, `tanggal_kematian`, `jam_meninggal`, `sebab_kematian`, `tempat_kematian`, `yang_menerangkan`, `nama_kk`, `no_kk`) VALUES
(1, 3, 1, '123456', '23', '2014-11-03', '23333333333', 3, '2014-11-03', '3', 'tes', 'tes', 'tes', 98, 'tes', 'tes', 'tes', 80, 3, '12:20:55', '12:23:55', '11', '12:28:55', '11', '12:34:55', 30, 4, 58, 11, '34', '444', '-', 'pelapor', 'saksi1', 'saksi2', '1963-06-05', '1963-09-09', '1990-09-09', '444', '444', 'r', '1990-09-09', 33, 'rte', 'tes', 'tes', 'tes', 7, '1990-09-09', '19:09:54', 'tes', 'tes', 'tes', 'rrr', 'rrr'),
(2, 3, 3, '123456', '23', '2014-11-03', '23333333333', 3, '2014-11-03', '3', 'tes', 'tes', 'tes', 98, 'tes', 'tes', 'tes', 80, 3, '12:20:55', '12:23:55', '11', '12:28:55', '11', '12:34:55', 30, 4, 58, 11, '34', '444', '-', 'pelapor', 'saksi1', 'saksi2', '1963-06-05', '1963-09-09', '1990-09-09', '444', '444', 'r', '1990-09-09', 33, 'rte', 'tes', 'tes', 'tes', 7, '1990-09-09', '19:09:54', 'tes', 'tes', 'tes', 'rrr', 'rrr');

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
  `nama_ibu` varchar(200) NOT NULL,
  `nama_ayah` varchar(200) NOT NULL
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `permintaan_orang_yang_sama`
--

INSERT INTO `permintaan_orang_yang_sama` (`id_permintaan_orang_yang_sama`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`, `keperluan`, `perbedaan_penulisan`) VALUES
(1, 3, 3, '123456', '221', '2014-11-04', '23', '2014-11-19', 3, '12:20:55', '12:23:55', '11', '12:28:55', '11', '12:34:55', 30, 4, 30, 11, '12', '555', '33', '33', '33');

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
-- Table structure for table `permintaan_pbb_penerbitan`
--

CREATE TABLE IF NOT EXISTS `permintaan_pbb_penerbitan` (
  `id_permintaan_penerbitan_pbb` int(11) NOT NULL AUTO_INCREMENT,
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
  `atas_nama` varchar(200) NOT NULL,
  `alamat_tanah` varchar(300) NOT NULL,
  `rt_tanah` varchar(10) NOT NULL,
  `rw_tanah` varchar(10) NOT NULL,
  `luas_bangunan` int(20) NOT NULL,
  `luas_tanah` int(50) NOT NULL,
  `bukti_kepemilikan` varchar(200) NOT NULL,
  `no_bukti_kepemilikan` varchar(200) NOT NULL,
  `tanggal_bukti_kepemilikan` varchar(200) NOT NULL,
  `atas_nama_bukti_kepemilikan` varchar(200) NOT NULL,
  PRIMARY KEY (`id_permintaan_penerbitan_pbb`),
  KEY `fk_19` (`id_kelurahan`),
  KEY `fk_20` (`id_pejabat`),
  KEY `fk_21` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_pbb_split`
--

CREATE TABLE IF NOT EXISTS `permintaan_pbb_split` (
  `id_permintaan_split_pbb` int(11) NOT NULL AUTO_INCREMENT,
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
  `nomor_split_pbb` varchar(30) NOT NULL,
  `kepada` varchar(200) NOT NULL,
  `atas_nama` varchar(200) NOT NULL,
  `luas_tanah` int(50) NOT NULL,
  `bukti_kepemilikan` varchar(200) NOT NULL,
  `no_bukti_kepemilikan` varchar(200) NOT NULL,
  `tanggal_bukti_kepemilikan` varchar(200) NOT NULL,
  `atas_nama_bukti_kepemilikan` varchar(200) NOT NULL,
  PRIMARY KEY (`id_permintaan_split_pbb`),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `permintaan_rumahsakit`
--

INSERT INTO `permintaan_rumahsakit` (`id_permintaan_rumahsakit`, `id_kelurahan`, `id_pejabat`, `nik`, `no_kip`, `no_jamkesmas`, `peruntukan`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `masa_berlaku`, `nama_rumahsakit`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`) VALUES
(40, 3, 1, '2006200720082009', 'aaaa', 'aaaa', '0', '400 / RS0018 / KEL.LG', '2014-09-07', 'S290-7bd-900/pemb.', '2014-09-02', '2014-09-17', 'aaaa', 3, '15:31:55', '15:31:55', '11', '15:32:17', '11', '15:32:19', 8, 1, 3, 11, 'RS0018', '', ''),
(42, 3, 1, '2006200720082009', '-', '55', '0', '400 / RS0024 / KEL.LG', '2014-11-04', '45', '2014-11-05', '2014-11-19', '-', 3, '10:15:00', '10:15:00', '11', '13:59:08', '11', '13:59:15', 3, 1, 3, 11, 'RS0024', '', '-'),
(43, 3, 1, '2006200720082009', '3', '2', '0', '400 / RS0025 / KEL.LG', '2014-10-31', '1', '2014-10-02', '2014-10-03', 'Cibabat', 3, '10:23:02', '10:23:02', '11', '14:13:43', '11', '14:32:19', 4, NULL, NULL, 11, 'RS0025', '', 'r'),
(44, 3, 1, '2006200720082009', '2', '12', '0', '400 / RS0028 / KEL.LG', '2014-10-31', '1', '2014-10-03', '2014-10-04', '1', 3, '10:28:26', '10:28:26', '11', '13:23:10', '11', '14:28:06', 3, 1, 3, 11, 'RS0028', '', '1'),
(45, 3, 1, '2006200720082009', '888', '57', '0', '400 / RS0030 / KEL.LG', '2014-09-30', 'ssss', '2014-09-05', '2014-09-19', 'rs rumah sakit', 3, '12:05:42', '12:05:42', '11', '09:54:38', '10', '11:32:27', 1, 1, 3, 11, 'RS0030', '', ''),
(46, 3, 1, '2006200720082009', '3', '4', '0', '400 / RS0032 / KEL.LG', '2014-09-11', '3', '2014-09-11', '2014-09-20', 'rs rumah sakit', 3, '12:21:05', '12:21:05', '11', '12:20:08', '11', '12:20:21', 5, 1, 3, 11, 'RS0032', '', ''),
(47, 3, 1, '2006200720082009', '888', '57', '0', '400 / RS0032 / KEL.LG', '2014-09-12', '45', '2014-09-11', '2014-09-27', 'rs rumah sakit', 3, '12:23:49', '12:23:49', '11', '11:59:08', '11', '11:59:24', 4, 1, 3, 11, 'RS0032', '', ''),
(49, 3, 1, '123456', '888', '57', '0', '400 / KRS0056 / KEL.LG', '2014-09-30', 'aaaaa', '2014-09-26', '2014-09-19', 'rs rumah sakit', 3, '13:10:39', '13:10:39', '11', '09:55:58', '10', '09:56:10', 4, NULL, NULL, 11, 'KRS0056', '', ''),
(50, 3, 1, '2006200720082009', '-', '-', '0', '400 / KRS0083 / KEL.LG', '2014-11-03', '25/RT.12/RW.05/2014', '2014-11-03', '2014-11-10', '-', 3, '09:54:53', '09:54:53', '10', '14:42:22', '23', '14:49:38', 4, 1, 3, 10, 'KRS0083', '', '-'),
(54, 3, 3, '2006200720082009', '--', '-', '0', '16 / 12 / KEL.LG', '2014-11-04', '161', '2014-09-14', '2014-09-14', 'dustira', 3, '15:22:51', '15:22:51', '11', '15:29:41', '11', '15:30:08', 0, 1, 3, 11, '4010001', '-', '-'),
(55, 3, 1, '3277015905550004', '-', '-', '0', '400 / 4010001 / KEL.LG', '2014-11-04', '461/RW.11/11/2014', '2014-11-03', '2014-11-11', 'RSUD CIBABAT-CIMAHI', 3, '15:27:22', '15:27:22', '25', '15:32:46', '25', '15:33:22', 0, 1, 3, 25, '4010001', '-', '-'),
(56, 3, 3, '123456', '-', '-', '0', '400 / 4010001 / KEL.LG', '2014-11-04', '400/024/RW.05', '2014-11-04', '2014-12-04', 'RSUD Cibabat', 3, '15:30:01', '15:30:01', '32', '15:34:01', '32', '15:34:38', 0, 1, 3, 32, '4010001', '-', '-'),
(57, 3, 1, '123456', '-', '-', '0', '400 / 4010001 / KEL.LG', '2014-11-04', '122', '2014-11-14', '2014-11-14', 'dustira', 3, '15:50:40', '15:50:40', '31', '15:52:01', '31', '15:52:27', 0, 1, 3, 31, '4010001', '-', '-'),
(58, 3, 1, '3277011908960023', '-', '-', '0', '400 / 4010001 / KEL.LG', '2014-11-04', '94/05/RW.06/2014', '2014-11-04', '0000-00-00', '-', 3, '16:04:50', '16:04:50', '26', '16:07:19', '26', '16:07:39', 0, 1, 3, 26, '4010001', '/', '-');

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
(12, 3, 1, '2006200720082009', 'aaaa', 'riza', 'ciamahi', '2014-09-03', 'Saudara', '400 / SS0020 / KEL.LG', '2014-09-07', 'S290-7bd-900/pemb.', '2014-09-03', 'rancabelut', '2014-09-04', 'bangun usaha', 3, '18:18:10', '18:18:10', '11', '18:18:52', '11', '18:18:55', 11, 1, 3, 11, 'SS0020', '', ''),
(13, 3, 1, '2006200720082009', '-', 'ririn', 'tes', '2014-09-10', 'Saudara', '400 / SS0021 / KEL.LG', '2014-11-04', '34/', '2014-09-10', 'sdn', '2014-09-08', '-', 3, '18:44:19', '18:44:19', '11', '14:12:38', '11', '14:14:23', 5, 1, 3, 11, 'SS0021', '', '-');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `permintaan_sertifikat`
--

INSERT INTO `permintaan_sertifikat` (`id_permintaan_sertifikat`, `id_kelurahan`, `id_pejabat`, `nik`, `no_surat`, `tanggal_surat`, `no_surat_pengantar`, `tanggal_surat_pengantar`, `status`, `jam_masuk`, `waktu_antrian`, `antrian_oleh`, `waktu_proses`, `proses_oleh`, `waktu_selesai`, `waktu_total`, `id_jenis_surat`, `id_surat`, `id_pengguna`, `no_registrasi`, `no_telp`, `ket`, `luas_tanah`, `luas_bangunan`, `blok_tanah`, `rt_tanah`, `rw_tanah`, `kel_tanah`, `kec_tanah`, `bukti_kepemilikan`, `no_kepemilikan`, `nama_pemilik`, `alamat_pemilik`, `pekerjaan_pemilik`, `batas_utara`, `batas_barat`, `batas_selatan`, `batas_timur`, `no_pbb`, `harga_tanah`, `harga_bangunan`, `keperluan`) VALUES
(1, 3, 3, '123456', '12', '2014-11-04', '12', '2014-11-02', 3, '12:20:55', '12:23:55', '11', '12:28:55', '11', '12:34:55', 30, 4, 36, 11, '12', '134', '-', 45, 45, '4', '4', '4', 't', 't', 't', '5', 't', 'r', 'r', 't', 't', 't', 't', 't', 5, 5, '-');

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
(3, 3, 1, '2009200812092020', '460/0077/Pembd./2013', '2014-01-30', 'S290-7bd-900/pemb.', '12', '2014-01-28', 1, '00:00:00', '00:00:00', '11', '00:00:00', '11', '00:00:00', 0, 4, 32, 11, NULL, '', '', '', '0000-00-00', '', '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

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
(24, 4, '', 'Kelahiran Lama', 'lahir'),
(25, 4, '', 'Kematian Lama', 'mati'),
(26, 4, '', 'KTP', 'ktp'),
(27, 4, '', 'KK', 'kk'),
(28, 4, '', 'KIPEM', 'kipem'),
(29, 4, '', 'Lahir Mati', 'lahirmati'),
(30, 4, '', 'Orang yang Sama', 'orangyangsama'),
(31, 4, '', 'Pindah', 'pindah'),
(32, 4, '', 'Ahli Waris', 'ahliwaris'),
(34, 4, '', 'Domisili Penduduk', 'domisilipenduduk'),
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
(50, 2, '', 'Kartu Identitas Kerja', 'kartuidentitaskerja'),
(57, 4, '', 'Kelahiran Baru', 'lahirbaru'),
(58, 4, '', 'Kematian Baru', 'matibaru');

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
