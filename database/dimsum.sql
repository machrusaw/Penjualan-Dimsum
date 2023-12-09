-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2023 at 05:39 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_online`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_pelanggan` (IN `pelanggan_id` INT)   BEGIN
    DELETE FROM pelanggan WHERE id_pelanggan = pelanggan_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_produk` (IN `produk_id` INT)   BEGIN
  DECLARE EXIT HANDLER FOR NOT FOUND
  BEGIN
    SELECT 'Dimsum tidak ditemukan.';
  END;

  DELETE FROM `produk` WHERE `id_produk` = `produk_id`;
  DELETE FROM `pembelian_produk` WHERE `id_produk` = `produk_id`;

  SELECT 'Dimsum berhasil dihapus.';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loop_tambahjmlProduk` (IN `id_produk` INT)   BEGIN
    DECLARE i INT DEFAULT 1;
    
    WHILE i <= 12 DO
        INSERT INTO `produk` (`id_produk`, `stock`) VALUES (id_produk, 1);
        SET i = i + 1;
    END WHILE;
    
    SELECT CONCAT('Stok produk dengan id ', id_produk, ' telah ditambahkan sebanyak 12') AS message;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_barang` (IN `nama_produk` VARCHAR(100), IN `harga_produk` INT, IN `berat_produk` INT, IN `foto_produk` VARCHAR(100), IN `deskripsi_produk` TEXT, IN `stock` INT)   BEGIN
    INSERT INTO produk (nama_produk, harga_produk, berat_produk, foto_produk, deskripsi_produk, stock)
    VALUES (nama_produk, harga_produk, berat_produk, foto_produk, deskripsi_produk, stock);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_pelanggan` (IN `email_pelanggan` VARCHAR(100), IN `password_pelanggan` VARCHAR(50), IN `nama_pelanggan` VARCHAR(100), IN `telepon_pelanggan` VARCHAR(25))   BEGIN
    INSERT INTO pelanggan (email_pelanggan, password_pelanggan, nama_pelanggan, telepon_pelanggan)
    VALUES (email_pelanggan, password_pelanggan, nama_pelanggan, telepon_pelanggan);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ubah_produk` (IN `p_id_produk` INT, IN `p_nama_produk` VARCHAR(100), IN `p_harga_produk` INT, IN `p_berat_produk` INT, IN `p_foto_produk` VARCHAR(100), IN `p_deskripsi_produk` TEXT, IN `p_stock` INT)   BEGIN
    UPDATE `produk`
    SET
        `nama_produk` = p_nama_produk,
        `harga_produk` = p_harga_produk,
        `berat_produk` = p_berat_produk,
        `foto_produk` = p_foto_produk,
        `deskripsi_produk` = p_deskripsi_produk,
        `stock` = p_stock
    WHERE
        `id_produk` = p_id_produk;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_stock` (IN `prod_id` INT)   BEGIN
    DECLARE i INT DEFAULT 1;
    
    WHILE i <= 12 DO
        UPDATE `produk` SET `stock` = `stock` + 1 WHERE `id_produk` = prod_id;
        SET i = i + 1;
    END WHILE;
    
    SELECT CONCAT('Stok produk dengan id ', prod_id, ' telah diperbarui menjadi ', `stock`) AS message FROM `produk` WHERE `id_produk` = prod_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `username`, `password`) VALUES
(1, 'machrus', 'machrus', 'c810189334bd14013688c9e24d63479e'),
(18, 'Sandy', 'sandy', 'd686a53fb86a6c31fa6faa1d9333267e');

-- --------------------------------------------------------

--
-- Stand-in structure for view `daftar_pembelian`
-- (See below for the actual view)
--
CREATE TABLE `daftar_pembelian` (
`id_pembelian` int(11)
,`nama_pelanggan` varchar(100)
,`tanggal_pembelian` date
,`total_pembelian` int(11)
,`status_pembelian` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `detail_pembelian`
-- (See below for the actual view)
--
CREATE TABLE `detail_pembelian` (
`id_pembelian` int(11)
,`id_pelanggan` int(11)
,`id_ongkir` int(11)
,`tanggal_pembelian` date
,`total_pembelian` int(11)
,`nama_kota` varchar(100)
,`tarif` int(11)
,`alamat_pengiriman` text
,`status_pembelian` varchar(100)
,`resi_pengiriman` varchar(50)
,`id_pembelian_produk` int(11)
,`id_produk` int(11)
,`jumlah` int(11)
,`nama_produk` varchar(100)
,`harga` int(11)
,`berat` int(11)
,`subberat` int(11)
,`subharga` int(11)
,`email_pelanggan` varchar(100)
,`nama_pelanggan` varchar(100)
,`telepon_pelanggan` varchar(25)
,`alamat_pelanggan` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `laporan_pembelian`
-- (See below for the actual view)
--
CREATE TABLE `laporan_pembelian` (
`id_pembelian` int(11)
,`tanggal_pembelian` date
,`total_pembelian` int(11)
,`nama_pelanggan` varchar(100)
,`alamat_pelanggan` text
,`nama_kota` varchar(100)
,`tarif` int(11)
,`status_pembelian` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `aktivitas` varchar(255) DEFAULT NULL,
  `pengguna` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `tanggal`, `aktivitas`, `pengguna`) VALUES
(56, '2023-05-27', 'Aktivitas Tambah Produk: tes', 'Admin'),
(57, '2023-05-27', 'Update Produk: teshtcujhfvki', 'Admin'),
(58, '2023-05-27', 'Aktivitas Hapus Produk: teshtcujhfvki', 'Admin'),
(59, '2023-05-27', 'Pembelian dengan ID 36 telah dilakukan', 'Sistem'),
(60, '2023-05-27', 'Aktivitas Pembayaran dengan ID: 46', 'Pelanggan Machrusaw'),
(61, '2023-05-27', 'Aktivitas Tambah Produk: Dimsum sayur', 'Admin'),
(62, '2023-05-27', 'Update Produk: Dimsum sayur Enak', 'Admin'),
(63, '2023-05-27', 'Aktivitas Hapus Produk: Dimsum sayur Enak', 'Admin'),
(64, '2023-06-07', 'Pembelian dengan ID 37 telah dilakukan', 'Sistem'),
(65, '2023-06-07', 'Aktivitas Pembayaran dengan ID: 47', 'Pelanggan Machrusaw'),
(66, '2023-06-07', 'Pembelian dengan ID 38 telah dilakukan', 'Sistem'),
(67, '2023-06-07', 'Aktivitas Pembayaran dengan ID: 48', 'Pelanggan Machrusaw'),
(68, '2023-06-07', 'Pembelian dengan ID 39 telah dilakukan', 'Sistem'),
(69, '2023-06-07', 'Aktivitas Tambah Produk: ', 'Admin'),
(70, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(71, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(72, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(73, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(74, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(75, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(76, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(77, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(78, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(79, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(80, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(81, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(82, '2023-06-07', 'Aktivitas Hapus Produk: ', 'Admin'),
(83, '2023-06-07', 'Aktivitas Tambah Produk: asd', 'Admin'),
(84, '2023-06-07', 'Aktivitas Hapus Produk: asd', 'Admin'),
(85, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(86, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(87, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(88, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(89, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(90, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(91, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(92, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(93, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(94, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(95, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(96, '2023-06-07', 'Update Produk: Har Gao', 'Admin'),
(97, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(98, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(99, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(100, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(101, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(102, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(103, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(104, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(105, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(106, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(107, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(108, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(109, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(110, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(111, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(112, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(113, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(114, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(115, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(116, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(117, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(118, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(119, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(120, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(121, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(122, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(123, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(124, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(125, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(126, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(127, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(128, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(129, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(130, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(131, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(132, '2023-06-07', 'Update Produk: Xiao Long Bao', 'Admin'),
(133, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(134, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(135, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(136, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(137, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(138, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(139, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(140, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(141, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(142, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(143, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(144, '2023-06-07', 'Update Produk: Bao Zi', 'Admin'),
(145, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(146, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(147, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(148, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(149, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(150, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(151, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(152, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(153, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(154, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(155, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(156, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(157, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(158, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(159, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(160, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(161, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(162, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(163, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(164, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(165, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(166, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(167, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(168, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(169, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(170, '2023-06-08', 'Aktivitas Tambah Produk: Dimsum swad', 'Admin'),
(171, '2023-06-08', 'Aktivitas Hapus Produk: Dimsum swad', 'Admin'),
(172, '2023-06-08', 'Aktivitas Tambah Produk: Machrus', 'Admin'),
(173, '2023-06-08', 'Aktivitas Tambah Produk: awdsd', 'Admin'),
(174, '2023-06-08', 'Aktivitas Hapus Produk: Machrus', 'Admin'),
(175, '2023-06-08', 'Aktivitas Hapus Produk: awdsd', 'Admin'),
(176, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(177, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(178, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(179, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(180, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(181, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(182, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(183, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(184, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(185, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(186, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(187, '2023-06-08', 'Update Produk: Siu Mai', 'Admin'),
(188, '2023-06-08', 'Aktivitas Tambah Produk: kvb', 'Admin'),
(189, '2023-06-08', 'Aktivitas Hapus Produk: kvb', 'Admin'),
(190, '2023-06-08', 'Aktivitas Tambah Produk: wqqw', 'Admin'),
(191, '2023-06-08', 'Aktivitas Hapus Produk: wqqw', 'Admin'),
(192, '2023-06-08', 'Aktivitas Tambah Produk: sad', 'Admin'),
(193, '2023-06-08', 'Aktivitas Hapus Produk: sad', 'Admin'),
(194, '2023-06-08', 'Aktivitas Tambah Produk: nama', 'Admin'),
(195, '2023-06-08', 'Aktivitas Hapus Produk: nama', 'Admin'),
(196, '2023-06-08', 'Aktivitas Tambah Produk: satu', 'Admin'),
(197, '2023-06-08', 'Aktivitas Tambah Produk: q', 'Admin'),
(198, '2023-06-08', 'Aktivitas Tambah Produk: qw', 'Admin'),
(199, '2023-06-08', 'Aktivitas Tambah Produk: asd', 'Admin'),
(200, '2023-06-08', 'Aktivitas Tambah Produk: trs', 'Admin'),
(201, '2023-06-08', 'Aktivitas Tambah Produk: Sandy', 'Admin'),
(202, '2023-06-08', 'Aktivitas Tambah Produk: qweeqwq', 'Admin'),
(203, '2023-06-08', 'Aktivitas Tambah Produk: cxvbnm', 'Admin'),
(204, '2023-06-08', 'Aktivitas Hapus Produk: cxvbnm', 'Admin'),
(205, '2023-06-08', 'Aktivitas Hapus Produk: trs', 'Admin'),
(206, '2023-06-08', 'Aktivitas Hapus Produk: satu', 'Admin'),
(207, '2023-06-08', 'Aktivitas Hapus Produk: q', 'Admin'),
(208, '2023-06-08', 'Aktivitas Hapus Produk: qw', 'Admin'),
(209, '2023-06-08', 'Aktivitas Hapus Produk: asd', 'Admin'),
(210, '2023-06-08', 'Aktivitas Hapus Produk: Sandy', 'Admin'),
(211, '2023-06-08', 'Aktivitas Hapus Produk: qweeqwq', 'Admin'),
(212, '2023-06-08', 'Aktivitas Tambah Produk: s', 'Admin'),
(213, '2023-06-08', 'Aktivitas Tambah Produk: qsad', 'Admin'),
(214, '2023-06-08', 'Aktivitas Tambah Produk: tes', 'Admin'),
(215, '2023-06-08', 'Aktivitas Tambah Produk: Machrus', 'Admin'),
(216, '2023-06-08', 'Aktivitas Tambah Produk: wqe', 'Admin'),
(217, '2023-06-08', 'Aktivitas Hapus Produk: wqe', 'Admin'),
(218, '2023-06-08', 'Aktivitas Hapus Produk: Machrus', 'Admin'),
(219, '2023-06-08', 'Aktivitas Tambah Produk: Dimsum sayur', 'Admin'),
(220, '2023-06-08', 'Aktivitas Tambah Produk: sdfasd', 'Admin'),
(221, '2023-06-08', 'Aktivitas Tambah Produk: a', 'Admin'),
(222, '2023-06-08', 'Aktivitas Tambah Produk: wqe', 'Admin'),
(223, '2023-06-08', 'Aktivitas Tambah Produk: wq', 'Admin'),
(224, '2023-06-08', 'Aktivitas Tambah Produk: tes', 'Admin'),
(225, '2023-06-08', 'Aktivitas Hapus Produk: wq', 'Admin'),
(226, '2023-06-08', 'Update Produk: tes111', 'Admin'),
(227, '2023-06-08', 'Update Produk: tes111', 'Admin'),
(228, '2023-06-08', 'Update Produk: tes111', 'Admin'),
(229, '2023-06-08', 'Update Produk: tess', 'Admin'),
(230, '2023-06-08', 'Update Produk: tess', 'Admin'),
(231, '2023-06-08', 'Update Produk: tess', 'Admin'),
(232, '2023-06-08', 'Update Produk: tess', 'Admin'),
(233, '2023-06-08', 'Update Produk: tess', 'Admin'),
(234, '2023-06-08', 'Update Produk: tess', 'Admin'),
(235, '2023-06-08', 'Update Produk: tess', 'Admin'),
(236, '2023-06-08', 'Update Produk: tess', 'Admin'),
(237, '2023-06-08', 'Update Produk: tess', 'Admin'),
(238, '2023-06-08', 'Update Produk: tess', 'Admin'),
(239, '2023-06-08', 'Update Produk: tess', 'Admin'),
(240, '2023-06-08', 'Update Produk: tess', 'Admin'),
(241, '2023-06-08', 'Update Produk: tess', 'Admin'),
(242, '2023-06-08', 'Update Produk: tess', 'Admin'),
(243, '2023-06-08', 'Update Produk: tess', 'Admin'),
(244, '2023-06-08', 'Update Produk: tess', 'Admin'),
(245, '2023-06-08', 'Update Produk: tess', 'Admin'),
(246, '2023-06-08', 'Update Produk: tess', 'Admin'),
(247, '2023-06-08', 'Update Produk: tess', 'Admin'),
(248, '2023-06-08', 'Update Produk: tess', 'Admin'),
(249, '2023-06-08', 'Update Produk: tess', 'Admin'),
(250, '2023-06-08', 'Update Produk: tess', 'Admin'),
(251, '2023-06-08', 'Update Produk: tess', 'Admin'),
(252, '2023-06-08', 'Update Produk: tess', 'Admin'),
(253, '2023-06-08', 'Update Produk: tess', 'Admin'),
(254, '2023-06-08', 'Aktivitas Hapus Produk: tess', 'Admin'),
(255, '2023-06-08', 'Aktivitas Hapus Produk: wqe', 'Admin'),
(256, '2023-06-08', 'Aktivitas Hapus Produk: a', 'Admin'),
(257, '2023-06-08', 'Aktivitas Hapus Produk: sdfasd', 'Admin'),
(258, '2023-06-08', 'Aktivitas Hapus Produk: Dimsum sayur', 'Admin'),
(259, '2023-06-08', 'Aktivitas Hapus Produk: tes', 'Admin'),
(260, '2023-06-08', 'Aktivitas Hapus Produk: qsad', 'Admin'),
(261, '2023-06-08', 'Aktivitas Hapus Produk: s', 'Admin'),
(262, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(263, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(264, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(265, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(266, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(267, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(268, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(269, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(270, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(271, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(272, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(273, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(274, '2023-06-08', 'Pembelian dengan ID 40 telah dilakukan', 'Sistem'),
(275, '2023-06-08', 'Aktivitas Pembayaran dengan ID: 49', 'Pelanggan Machrusaw'),
(276, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(277, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(278, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(279, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(280, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(281, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(282, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(283, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(284, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(285, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(286, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(287, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(288, '2023-06-08', 'Pembelian dengan ID 41 telah dilakukan', 'Sistem'),
(289, '2023-06-08', 'Pembelian dengan ID 42 telah dilakukan', 'Sistem'),
(290, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(291, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(292, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(293, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(294, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(295, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(296, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(297, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(298, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(299, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(300, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(301, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(302, '2023-06-08', 'Pembelian dengan ID 43 telah dilakukan', 'Sistem'),
(303, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(304, '2023-06-08', 'Pembelian dengan ID 44 telah dilakukan', 'Sistem'),
(305, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(306, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(307, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(308, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(309, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(310, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(311, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(312, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(313, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(314, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(315, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(316, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(317, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(318, '2023-06-08', 'Pembelian dengan ID 45 telah dilakukan', 'Sistem'),
(319, '2023-06-08', 'Pembelian dengan ID 46 telah dilakukan', 'Sistem'),
(320, '2023-06-08', 'Pembelian dengan ID 47 telah dilakukan', 'Sistem'),
(321, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(322, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(323, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(324, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(325, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(326, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(327, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(328, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(329, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(330, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(331, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(332, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(333, '2023-06-08', 'Pembelian dengan ID 48 telah dilakukan', 'Sistem'),
(334, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(335, '2023-06-08', 'Pembelian dengan ID 49 telah dilakukan', 'Sistem'),
(336, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(337, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(338, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(339, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(340, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(341, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(342, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(343, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(344, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(345, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(346, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(347, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(348, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(349, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(350, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(351, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(352, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(353, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(354, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(355, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(356, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(357, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(358, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(359, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(360, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(361, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(362, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(363, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(364, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(365, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(366, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(367, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(368, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(369, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(370, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(371, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(372, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(373, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(374, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(375, '2023-06-08', 'Pembelian dengan ID 50 telah dilakukan', 'Sistem'),
(376, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(377, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(378, '2023-06-08', 'Pembelian dengan ID 51 telah dilakukan', 'Sistem'),
(379, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(380, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(381, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(382, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(383, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(384, '2023-06-08', 'Pembelian dengan ID 52 telah dilakukan', 'Sistem'),
(385, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(386, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(387, '2023-06-08', 'Pembelian dengan ID 53 telah dilakukan', 'Sistem'),
(388, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(389, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(390, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(391, '2023-06-08', 'Pembelian dengan ID 54 telah dilakukan', 'Sistem'),
(392, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(393, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(394, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(395, '2023-06-08', 'Pembelian dengan ID 55 telah dilakukan', 'Sistem'),
(396, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(397, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(398, '2023-06-08', 'Pembelian dengan ID 56 telah dilakukan', 'Sistem'),
(399, '2023-06-08', 'Update Produk: Har Gao', 'Admin'),
(400, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(401, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(402, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(403, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(404, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(405, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(406, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(407, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(408, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(409, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(410, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(411, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(412, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(413, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(414, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(415, '2023-06-08', 'Pembelian dengan ID 57 telah dilakukan', 'Sistem'),
(416, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(417, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(418, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(419, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(420, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(421, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(422, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(423, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(424, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(425, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(426, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(427, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(428, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(429, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(430, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(431, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(432, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(433, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(434, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(435, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(436, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(437, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(438, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(439, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(440, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(441, '2023-06-08', 'Pembelian dengan ID 58 telah dilakukan', 'Sistem'),
(442, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(443, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(444, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(445, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(446, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(447, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(448, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(449, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(450, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(451, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(452, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(453, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(454, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(455, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(456, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(457, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(458, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(459, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(460, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(461, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(462, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(463, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(464, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(465, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(466, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(467, '2023-06-08', 'Pembelian dengan ID 59 telah dilakukan', 'Sistem'),
(468, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(469, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(470, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(471, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(472, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(473, '2023-06-08', 'Pembelian dengan ID 60 telah dilakukan', 'Sistem'),
(474, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(475, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(476, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(477, '2023-06-08', 'Pembelian dengan ID 61 telah dilakukan', 'Sistem'),
(478, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(479, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(480, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(481, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(482, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(483, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(484, '2023-06-08', 'Pembelian dengan ID 62 telah dilakukan', 'Sistem'),
(485, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(486, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(487, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(488, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(489, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(490, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(491, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(492, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(493, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(494, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(495, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(496, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(497, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(498, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(499, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(500, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(501, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(502, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(503, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(504, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(505, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(506, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(507, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(508, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(509, '2023-06-08', 'Update Produk: Xiao Long Bao', 'Admin'),
(510, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(511, '2023-06-09', 'Update Produk: Bao Zi', 'Admin'),
(512, '2023-06-09', 'Update Produk: Mantou', 'Admin'),
(513, '2023-06-09', 'Update Produk: Zheng Feng Zhua', 'Admin'),
(514, '2023-06-09', 'Update Produk: Lo Mai Gai', 'Admin'),
(515, '2023-06-09', 'Update Produk: Chun Juan ', 'Admin'),
(516, '2023-06-09', 'Update Produk: Siu Mai', 'Admin'),
(517, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(518, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(519, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(520, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(521, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(522, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(523, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(524, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(525, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(526, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(527, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(528, '2023-06-09', 'Update Produk: Har Gao', 'Admin'),
(529, '2023-06-09', 'Aktivitas Pembayaran dengan ID: 50', 'Pelanggan Machrusaw');

-- --------------------------------------------------------

--
-- Table structure for table `ongkir`
--

CREATE TABLE `ongkir` (
  `id_ongkir` int(5) NOT NULL,
  `nama_kota` varchar(100) NOT NULL,
  `tarif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ongkir`
--

INSERT INTO `ongkir` (`id_ongkir`, `nama_kota`, `tarif`) VALUES
(1, 'Sidoarjo', 10000),
(2, 'Surabaya', 12000),
(3, 'Bangkalan', 20000),
(4, 'Bojonegoro', 25000),
(5, 'Bondowoso', 15000),
(6, 'Gresik', 10000),
(7, 'Jember', 15000),
(8, 'Jombang', 13000),
(9, 'Lamongan', 17000),
(10, 'Lumajang', 18000),
(11, 'Magetan', 14000),
(12, 'Nganjuk', 15000),
(13, 'Pacitan', 20000),
(14, 'Ponorogo', 25000),
(15, 'Situbondo', 12000),
(16, 'Tuban', 15000),
(17, 'Tulungagung', 13000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `email_pelanggan` varchar(100) NOT NULL,
  `password_pelanggan` varchar(50) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `telepon_pelanggan` varchar(25) NOT NULL,
  `alamat_pelanggan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `email_pelanggan`, `password_pelanggan`, `nama_pelanggan`, `telepon_pelanggan`, `alamat_pelanggan`) VALUES
(1, 'machrusa12@gmail.com', '12', 'Machrus', '123123', ''),
(2, 'sandy@gmail.com', 'sandy', 'sandy', '1234', 'sandy'),
(16, 'machrusa1@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Machrus', '12320', 'df'),
(17, 'machrusa242@gmail.com', 'e4a6222cdb5b34375400904f03d8e6a5', 'mac', '12320', 'df'),
(18, 'machrusa111@gmail.com', '3eabaa157b2699930e7ef651cf9e396b', 'wqdd', '123', 'zxzc'),
(19, 'machrusa13@gmail.com', '315aeca937f5587ad0b58678696bdfb9', 'Machrusaw', '0812234556678', 'bangkalan'),
(20, 'sandi1@gmail.com', 'd686a53fb86a6c31fa6faa1d9333267e', 'Sandy', '08123324534', 'Surabaya'),
(21, 'machrusa86@gmail.com', 'c810189334bd14013688c9e24d63479e', 'Machrus Ali', '1029192', 'jombang'),
(22, 'machrusaw@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Machrusaw', '12345', 'dssgvsdg');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `bukti` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pembelian`, `nama`, `jumlah`, `tanggal`, `bukti`) VALUES
(50, 57, '', 500000, '2023-06-09', '20230609053727buktitf1.jpg');

--
-- Triggers `pembayaran`
--
DELIMITER $$
CREATE TRIGGER `log_pembayaran_trigger` AFTER INSERT ON `pembayaran` FOR EACH ROW BEGIN
    DECLARE nama_pelanggan VARCHAR(255);

    SELECT pelanggan.nama_pelanggan INTO nama_pelanggan
    FROM pembelian
    JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan
    WHERE pembelian.id_pembelian = NEW.id_pembelian;

    INSERT INTO log_aktivitas (tanggal, aktivitas, pengguna)
    VALUES (CURDATE(), CONCAT('Aktivitas Pembayaran dengan ID: ', NEW.id_pembayaran), CONCAT('Pelanggan ', nama_pelanggan));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pembayaran_berhasil_trigger` AFTER INSERT ON `pembayaran` FOR EACH ROW BEGIN
    UPDATE pembelian
    SET status_pembelian = 'lunas'
    WHERE id_pembelian = NEW.id_pembelian;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_pembelian` BEFORE INSERT ON `pembayaran` FOR EACH ROW BEGIN
    DECLARE id_pembelian INT;
    DECLARE total_pembayaran INT;
    SELECT id_pembelian, jumlah INTO id_pembelian, total_pembayaran FROM pembayaran WHERE id_pembayaran = NEW.id_pembayaran;

    UPDATE pembelian SET status_pembelian = 'lunas' WHERE id_pembelian = id_pembelian;
    UPDATE pembelian SET total_pembelian = total_pembayaran WHERE id_pembelian = id_pembelian;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_ongkir` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_pembelian` int(11) NOT NULL,
  `nama_kota` varchar(100) NOT NULL,
  `tarif` int(11) NOT NULL,
  `alamat_pengiriman` text NOT NULL,
  `status_pembelian` varchar(100) NOT NULL DEFAULT 'pending',
  `resi_pengiriman` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_pelanggan`, `id_ongkir`, `tanggal_pembelian`, `total_pembelian`, `nama_kota`, `tarif`, `alamat_pengiriman`, `status_pembelian`, `resi_pengiriman`) VALUES
(57, 22, 5, '2023-06-08', 202500, 'Bondowoso', 15000, 'lamongan', 'Pesanan Diterima', ''),
(58, 22, 1, '2023-06-08', 135000, 'Sidoarjo', 10000, 'sd', 'pending', ''),
(59, 22, 1, '2023-06-08', 22500, 'Sidoarjo', 10000, 'lamongan', 'pending', ''),
(60, 22, 1, '2023-06-08', 110000, 'Sidoarjo', 10000, 'asd', 'pending', ''),
(61, 22, 4, '2023-06-08', 37500, 'Bojonegoro', 25000, 'ADS', 'pending', ''),
(62, 22, 2, '2023-06-08', 24500, 'Surabaya', 12000, 'XDFSA', 'pending', '');

--
-- Triggers `pembelian`
--
DELIMITER $$
CREATE TRIGGER `delete_pembayaran` AFTER DELETE ON `pembelian` FOR EACH ROW BEGIN
    DELETE FROM pembayaran WHERE id_pembelian = OLD.id_pembelian;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_pembelian` AFTER INSERT ON `pembelian` FOR EACH ROW BEGIN
    -- Variabel untuk menyimpan data log
    DECLARE tanggal_log DATE;
    DECLARE aktivitas_log VARCHAR(255);
    DECLARE pengguna_log VARCHAR(255);
    
    -- Mengisi data log
    SET tanggal_log = NEW.tanggal_pembelian;
    SET aktivitas_log = CONCAT('Pembelian dengan ID ', NEW.id_pembelian, ' telah dilakukan');
    SET pengguna_log = 'Sistem';
    
    -- Memasukkan data log ke dalam tabel log_aktivitas
    INSERT INTO log_aktivitas (tanggal, aktivitas, pengguna) VALUES (tanggal_log, aktivitas_log, pengguna_log);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_produk`
--

CREATE TABLE `pembelian_produk` (
  `id_pembelian_produk` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `berat` int(11) NOT NULL,
  `subberat` int(11) NOT NULL,
  `subharga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembelian_produk`
--

INSERT INTO `pembelian_produk` (`id_pembelian_produk`, `id_pembelian`, `id_produk`, `jumlah`, `nama`, `harga`, `berat`, `subberat`, `subharga`) VALUES
(62, 58, 12, 10, 'Xiao Long Bao', 12500, 50, 500, 125000),
(63, 59, 12, 1, 'Xiao Long Bao', 12500, 50, 50, 12500),
(64, 60, 12, 8, 'Xiao Long Bao', 12500, 50, 400, 100000),
(65, 61, 12, 1, 'Xiao Long Bao', 12500, 50, 50, 12500),
(66, 62, 12, 1, 'Xiao Long Bao', 12500, 50, 50, 12500);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `berat_produk` int(11) NOT NULL,
  `foto_produk` varchar(100) NOT NULL,
  `deskripsi_produk` text NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga_produk`, `berat_produk`, `foto_produk`, `deskripsi_produk`, `stock`) VALUES
(12, 'Xiao Long Bao', 12500, 50, '12.jpg', 'Xiao long bao juga dikenal dengan sebutan pangsit sup. Namun walau disebut pangsit sup, xiao long bao sebetulnya tidak berisi sup. Isi xiao long bao ialah potongan daging baik itu daging babi, kepiting, ataupun udang. 				', 14),
(13, 'Har Gao', 15000, 50, '13.png', 'Har gao atau hakau adalah pangsit berbentuk bulan sabit yang bungkusnya bening. Kulit hakau terbuat dari gandum dan tepung tapioka. Sementara, isinya biasanya memakai udang, lemak babi, dan rebung. Hakau dimasak dengan cara dikukus.		', 22),
(14, 'Bao Zi', 20000, 50, '14.jpg', 'Masyarakat Indonesia mengenal bao zi dengan sebutan bakpao. Namun umumnya bao ziukurannya lebih kecil daripada bakpao.		', 10),
(15, 'Mantou', 15000, 50, '15.jpg', 'Jika dilihat dari tampilan, mantau sama seperti bakpao. Namun mantau tidak diisi dengan daging ataupun isian lainnya.  Mantau hanya roti biasa yang terbuat dari tepung terigu. Selain itu, penyajian mantau juga digoreng, tidak dikukus seperti bakpao.		', 10),
(16, 'Zheng Feng Zhua', 25000, 50, '16.jpg', 'Walau bentuk dan bahannya jauh berbeda dengan dimsum kebanyakan, tetapi angsio ceker juga merupakan salah satu jenis dimsum. Angsio ceker dimasak dengan cara dikukus supaya rasa lebih manis, segar, dan lembut teksturnya.		', 10),
(17, 'Lo Mai Gai', 21000, 50, '17.jpg', 'Lo Mai Gai adalah salah satu jenis dimdum yang penyajiannya dengan dibungkus daun teratai. Isi hidangannya ialah nasi ketan, daging, dan sayuran.		', 10),
(18, 'Chun Juan ', 11000, 50, '18.jpg', 'Spring roll atau lumpia. Jenis dimsum goreng juga tak kalah populer dengan dimsum kukus.  Spring roll biasanya disantap saat Tahun Baru Imlek. Bungkus tepungnya yang tipis membuat rasanya lebih gurih dan renyah.		', 10),
(19, 'Siu Mai', 20000, 50, '19.jpg', 'Siu mai (dilafalkan shoo-my) adalah pangsit bundar berbentuk keranjang yang bagian atasnya terbuka. Siomai umumnya terbuat dari bungkusan tepung gandum tipis yang diisi dengan daging. Di Tiongkok, daging untuk isian siomai umumnya menggunakan daging babi dan udang.		', 10);

--
-- Triggers `produk`
--
DELIMITER $$
CREATE TRIGGER `hapus_produk_trigger` AFTER DELETE ON `produk` FOR EACH ROW BEGIN
    INSERT INTO log_aktivitas (tanggal, aktivitas, pengguna)
    VALUES (CURDATE(), CONCAT('Aktivitas Hapus Produk: ', OLD.nama_produk), 'Admin');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah_produk_trigger` AFTER INSERT ON `produk` FOR EACH ROW BEGIN
    INSERT INTO log_aktivitas (tanggal, aktivitas, pengguna)
    VALUES (CURDATE(), CONCAT('Aktivitas Tambah Produk: ', NEW.nama_produk), 'Admin');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_produk_trigger` AFTER UPDATE ON `produk` FOR EACH ROW BEGIN
    INSERT INTO log_aktivitas (tanggal, aktivitas, pengguna)
    VALUES (CURDATE(), CONCAT('Update Produk: ', NEW.nama_produk), 'Admin');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_pembayaran`
-- (See below for the actual view)
--
CREATE TABLE `view_pembayaran` (
`id_pembayaran` int(11)
,`id_pembelian` int(11)
,`nama` varchar(100)
,`jumlah` int(11)
,`tanggal` date
,`bukti` varchar(100)
,`id_pelanggan` int(11)
,`id_ongkir` int(11)
,`tanggal_pembelian` date
,`total_pembelian` int(11)
,`nama_kota` varchar(100)
,`tarif` int(11)
,`alamat_pengiriman` text
,`status_pembelian` varchar(100)
,`resi_pengiriman` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_produk`
-- (See below for the actual view)
--
CREATE TABLE `view_produk` (
`id_produk` int(11)
,`nama_produk` varchar(100)
,`harga_produk` int(11)
,`berat_produk` int(11)
,`foto_produk` varchar(100)
,`deskripsi_produk` text
);

-- --------------------------------------------------------

--
-- Structure for view `daftar_pembelian`
--
DROP TABLE IF EXISTS `daftar_pembelian`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daftar_pembelian`  AS SELECT `p`.`id_pembelian` AS `id_pembelian`, `pl`.`nama_pelanggan` AS `nama_pelanggan`, `p`.`tanggal_pembelian` AS `tanggal_pembelian`, `p`.`total_pembelian` AS `total_pembelian`, `p`.`status_pembelian` AS `status_pembelian` FROM (`pembelian` `p` join `pelanggan` `pl` on(`p`.`id_pelanggan` = `pl`.`id_pelanggan`)) ;

-- --------------------------------------------------------

--
-- Structure for view `detail_pembelian`
--
DROP TABLE IF EXISTS `detail_pembelian`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detail_pembelian`  AS SELECT `pb`.`id_pembelian` AS `id_pembelian`, `pb`.`id_pelanggan` AS `id_pelanggan`, `pb`.`id_ongkir` AS `id_ongkir`, `pb`.`tanggal_pembelian` AS `tanggal_pembelian`, `pb`.`total_pembelian` AS `total_pembelian`, `pb`.`nama_kota` AS `nama_kota`, `pb`.`tarif` AS `tarif`, `pb`.`alamat_pengiriman` AS `alamat_pengiriman`, `pb`.`status_pembelian` AS `status_pembelian`, `pb`.`resi_pengiriman` AS `resi_pengiriman`, `pp`.`id_pembelian_produk` AS `id_pembelian_produk`, `pp`.`id_produk` AS `id_produk`, `pp`.`jumlah` AS `jumlah`, `pp`.`nama` AS `nama_produk`, `pp`.`harga` AS `harga`, `pp`.`berat` AS `berat`, `pp`.`subberat` AS `subberat`, `pp`.`subharga` AS `subharga`, `p`.`email_pelanggan` AS `email_pelanggan`, `p`.`nama_pelanggan` AS `nama_pelanggan`, `p`.`telepon_pelanggan` AS `telepon_pelanggan`, `p`.`alamat_pelanggan` AS `alamat_pelanggan` FROM ((`pembelian` `pb` join `pembelian_produk` `pp` on(`pb`.`id_pembelian` = `pp`.`id_pembelian`)) join `pelanggan` `p` on(`pb`.`id_pelanggan` = `p`.`id_pelanggan`)) ;

-- --------------------------------------------------------

--
-- Structure for view `laporan_pembelian`
--
DROP TABLE IF EXISTS `laporan_pembelian`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `laporan_pembelian`  AS SELECT `pb`.`id_pembelian` AS `id_pembelian`, `pb`.`tanggal_pembelian` AS `tanggal_pembelian`, `pb`.`total_pembelian` AS `total_pembelian`, `p`.`nama_pelanggan` AS `nama_pelanggan`, `p`.`alamat_pelanggan` AS `alamat_pelanggan`, `o`.`nama_kota` AS `nama_kota`, `o`.`tarif` AS `tarif`, `pb`.`status_pembelian` AS `status_pembelian` FROM ((`pembelian` `pb` join `pelanggan` `p` on(`pb`.`id_pelanggan` = `p`.`id_pelanggan`)) join `ongkir` `o` on(`pb`.`id_ongkir` = `o`.`id_ongkir`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_pembayaran`
--
DROP TABLE IF EXISTS `view_pembayaran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_pembayaran`  AS SELECT `p`.`id_pembayaran` AS `id_pembayaran`, `p`.`id_pembelian` AS `id_pembelian`, `p`.`nama` AS `nama`, `p`.`jumlah` AS `jumlah`, `p`.`tanggal` AS `tanggal`, `p`.`bukti` AS `bukti`, `pb`.`id_pelanggan` AS `id_pelanggan`, `pb`.`id_ongkir` AS `id_ongkir`, `pb`.`tanggal_pembelian` AS `tanggal_pembelian`, `pb`.`total_pembelian` AS `total_pembelian`, `pb`.`nama_kota` AS `nama_kota`, `pb`.`tarif` AS `tarif`, `pb`.`alamat_pengiriman` AS `alamat_pengiriman`, `pb`.`status_pembelian` AS `status_pembelian`, `pb`.`resi_pengiriman` AS `resi_pengiriman` FROM (`pembayaran` `p` join `pembelian` `pb` on(`p`.`id_pembelian` = `pb`.`id_pembelian`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_produk`
--
DROP TABLE IF EXISTS `view_produk`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_produk`  AS SELECT `produk`.`id_produk` AS `id_produk`, `produk`.`nama_produk` AS `nama_produk`, `produk`.`harga_produk` AS `harga_produk`, `produk`.`berat_produk` AS `berat_produk`, `produk`.`foto_produk` AS `foto_produk`, `produk`.`deskripsi_produk` AS `deskripsi_produk` FROM `produk` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ongkir`
--
ALTER TABLE `ongkir`
  ADD PRIMARY KEY (`id_ongkir`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `fk_pembayaran_pembelian` (`id_pembelian`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `fk_pembelian_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `pembelian_produk`
--
ALTER TABLE `pembelian_produk`
  ADD PRIMARY KEY (`id_pembelian_produk`),
  ADD KEY `fk_pembelian_produk` (`id_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=530;

--
-- AUTO_INCREMENT for table `ongkir`
--
ALTER TABLE `ongkir`
  MODIFY `id_ongkir` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `pembelian_produk`
--
ALTER TABLE `pembelian_produk`
  MODIFY `id_pembelian_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_pembelian` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `fk_pembelian_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE;

--
-- Constraints for table `pembelian_produk`
--
ALTER TABLE `pembelian_produk`
  ADD CONSTRAINT `fk_pembelian_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
