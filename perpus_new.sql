-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 05, 2013 at 08:26 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `perpus_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE IF NOT EXISTS `anggota` (
  `no_urut` int(8) NOT NULL AUTO_INCREMENT,
  `no_anggota` varchar(32) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `no_identitas` varchar(32) NOT NULL,
  `jenis_identitas` varchar(16) NOT NULL,
  `tgl_daftar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `alamat` varchar(128) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `foto` varchar(32) NOT NULL,
  `meminjam` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_urut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE IF NOT EXISTS `buku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_buku` varchar(16) NOT NULL,
  `kategori` int(2) NOT NULL DEFAULT '0',
  `judul` varchar(64) NOT NULL,
  `pengarang` varchar(64) NOT NULL,
  `tahun_terbit` int(4) NOT NULL,
  `penerbit` varchar(64) NOT NULL,
  `isbn` varchar(32) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `sinopsis` text NOT NULL,
  `stok` int(1) NOT NULL DEFAULT '1',
  `dipinjam` int(1) DEFAULT '0',
  PRIMARY KEY (`kode_buku`),
  UNIQUE KEY `id_buku_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kembali`
--

CREATE TABLE IF NOT EXISTS `kembali` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `no_pinjam` int(11) NOT NULL,
  `tgl_kembali` date NOT NULL,
  `penerima` varchar(32) NOT NULL,
  `denda` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pinjam`
--

CREATE TABLE IF NOT EXISTS `pinjam` (
  `no` int(3) NOT NULL AUTO_INCREMENT,
  `no_anggota` varchar(16) NOT NULL,
  `kode_buku` char(255) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_habis` date NOT NULL,
  `pemberi` varchar(32) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(32) NOT NULL,
  `uname` varchar(32) NOT NULL,
  `paswd` varchar(64) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `uname`, `paswd`, `type`) VALUES
(1, 'jacknb1ack', 'admin', '21232f297a57a5a743894a0e4a801fc3', 0),
(2, 'nama owner', 'owner', '72122ce96bfec66e2396d2e25225d70a', 1),
(3, 'Operator Pertama', 'operator1', 'e00b29d5b34c3f78df09d45921c9ec47', 3),
(4, 'Operator Kedua', 'operator2', 'aeb1db601951079c423d1ae373fed1ec', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
