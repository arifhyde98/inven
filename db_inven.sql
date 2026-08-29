-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2020 at 03:57 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inven`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses_menu`
--

CREATE TABLE `akses_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akses_menu`
--

INSERT INTO `akses_menu` (`id`, `role_id`, `menu_id`) VALUES
(2, 4, 0),
(5, 1, 1),
(6, 2, 2),
(16, 1, 6),
(17, 2, 6),
(23, 1, 3),
(24, 2, 3),
(27, 1, 4),
(28, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `barcode` varchar(15) NOT NULL,
  `nama_barang` varchar(128) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `kategori` varchar(128) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `profit` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_suplier` int(11) DEFAULT NULL,
  `kode_penjualan` varchar(50) DEFAULT NULL,
  `kode_pembelian` varchar(50) DEFAULT NULL,
  `exp_date` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `barcode`, `nama_barang`, `gambar`, `kategori`, `harga_beli`, `harga_jual`, `profit`, `stok`, `satuan`, `id_cabang`, `keterangan`, `id_suplier`, `kode_penjualan`, `kode_pembelian`, `exp_date`) VALUES
(85, '899522750027', 'Larutan Cap Kaki Tiga Leci', 'default.png', 'Minuman', 4500, 5500, 1000, 15, 'btl', 1, '', NULL, '', '', '07-02-2020'),
(86, '899600160026', 'Le MineralE', 'default.png', 'Minuman', 2000, 3000, 1000, 4, 'btl', 1, '', NULL, '', '', '31-01-2020'),
(87, '497012972751', 'Spidol Snowman', 'default.png', 'Alat', 8000, 10000, 2000, 7, 'pcs', 1, '', NULL, '', '', '11-04-2020'),
(88, '899999904966', 'Rexona Men Roll On', 'default.png', 'Alat', 14000, 17000, 3000, 8, 'btl', 1, '', NULL, '', '', '25-01-2020'),
(89, '899700951005', 'YOUC 1000', 'default.png', 'Minuman', 7000, 10000, 3000, 8, 'btl', 1, '', NULL, '', '', ''),
(90, '899276114511', 'Fanta Soda 250ml', 'default.png', 'Minuman', 3000, 4500, 1500, 13, 'btl', 8, '', NULL, '', '', '17-03-2020'),
(91, '899277258601', 'Adem Sari Cingku', 'default.png', 'Minuman', 4000, 5500, 1500, 37, 'btl', 8, '', NULL, '', '', '07-03-2020'),
(92, '899275211251', 'Mizone White Tea', 'default.png', 'Minuman', 4000, 5000, 1000, 11, 'btl', 9, '', NULL, '', '', ''),
(93, '899703556341', 'Pocari Sweat 500ml', 'default.png', 'Minuman', 5000, 6500, 1500, 10, 'btl', 9, '', NULL, '', '', ''),
(94, '899886660594', 'Fresh Nature', 'default.png', 'Parfum', 10000, 12000, 2000, 30, 'btl', 8, '', NULL, '', '', '10-03-2020'),
(95, '899279601113', 'Milk Cleanser Bengkuang', 'default.png', 'Alat', 5000, 6000, 1000, 19, 'btl', 8, '', NULL, '', '', '13-06-2020'),
(96, '899529689004', 'Indomie Goreng Iga Penyet', 'default.png', 'Makanan', 1700, 2500, 800, 0, 'pcs', 1, '', 9, '', 'PSN0071395', ''),
(97, '899529636427', 'Indomie Ayam Bawang', 'default.png', 'Makanan', 1675, 2500, 825, 2, 'pcs', 1, '', 8, '', 'PSN0070495', ''),
(98, '899529670706', 'Indomie Rendang', 'default.png', 'Makanan', 1700, 2500, 800, 110, 'pcs', 1, '', 9, '', 'PSN0072607', ''),
(99, '899600160026', 'Le Mineral 600ML', 'default.png', 'Minuman', 1583, 3000, 1417, 48, 'pcs', 8, '', 9, '', 'PSN0087696', '01-03-2020'),
(102, '899529620981', 'Indomie Soto Lamongan', 'default.png', 'Makanan', 1650, 2500, 850, 74, 'pcs', 1, '', 9, '', 'PSN0094691', '20-09-2020'),
(103, '899529644451', 'Djarum Super', 'default.png', 'Rokok', 18000, 19000, 1000, 3, 'bks', 1, '', 9, '', 'PSN0094691', '28-01-2020'),
(104, '899529686242', 'Sampoerna Mild', 'default.png', 'Rokok', 23000, 24000, 1000, 26, 'bks', 1, '', 8, '', 'PSN0084600', '16-03-2020'),
(105, '899529657671', 'Indomie Rendang', 'default.png', 'Makanan', 1675, 2500, 825, 86, 'pcs', 1, '', 8, '', 'PSN0084600', '15-03-2020'),
(106, '899529645260', 'Aqua', 'default.png', 'Minuman', 1042, 2500, 1458, 0, 'pcs', 1, '', 9, '', 'PSN0031694', '04-04-2020'),
(108, '899529680827', 'sdf', 'default.png', 'Elektronik', 1, 2, 1, 0, 'bks', 1, '', NULL, '', '', '31-01-2020'),
(109, '899529675677', 'Mie Gelas', 'default.png', 'Makanan', 1000, 2000, 1000, 0, 'bks', 1, '', NULL, '', '', '14-03-2020');

-- --------------------------------------------------------

--
-- Table structure for table `data_cabang`
--

CREATE TABLE `data_cabang` (
  `id` int(11) NOT NULL,
  `nama_cabang` varchar(128) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jumlah_barang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_cabang`
--

INSERT INTO `data_cabang` (`id`, `nama_cabang`, `alamat`, `jumlah_barang`) VALUES
(1, 'Cabang Utama Bandung', 'Kp. Jelekong Rt01 Rw09', 15),
(8, 'Cabang Bandung Selatan', 'Kp. Manggahang RT01/04', 5),
(9, 'Cabang Jawa Tengah', 'Kp. Lembur Tengah', 2);

-- --------------------------------------------------------

--
-- Table structure for table `data_hutang`
--

CREATE TABLE `data_hutang` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `tanggal` varchar(128) NOT NULL,
  `kode` varchar(128) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `total_hutang` int(11) NOT NULL,
  `sisa_hutang` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_hutang`
--

INSERT INTO `data_hutang` (`id`, `nama`, `tanggal`, `kode`, `id_cabang`, `total_hutang`, `sisa_hutang`, `catatan`, `bukti`, `status`) VALUES
(13, 'Widodo', '17-01-2020', 'HUT1702020241', 1, 100000, 100000, 'Awsdw', 'default.png', 0),
(14, 'Opik', '17-01-2020', 'HUT1702020696', 8, 12500, 0, 'Rokok', 'default.png', 1),
(15, 'Ucup', '17-01-2020', 'HUT1702020134', 8, 10000, 0, 'Soklin 1 Gantung', 'default.png', 1),
(16, 'Riskuy', '17-01-2020', 'HUT1702020981', 8, 25000, 15000, 'Sampoerna Mild', 'eb8d2978d49649799aac9e13b4c87de3.jpeg', 0),
(18, 'Cep', '17-01-2020', 'HUT1702020738', 1, 250000, 0, 'Rokok Magnum\r\nSampo\r\nOky Jeruk', '68a7d5eb5484e0970c75cbfdf3ccd63f.PNG', 1);

-- --------------------------------------------------------

--
-- Table structure for table `isi_pesanan_barang`
--

CREATE TABLE `isi_pesanan_barang` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `stok_sekarang` int(11) NOT NULL,
  `stok_pesan` int(11) NOT NULL,
  `stok_terima` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `total_beli` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `isi_pesanan_barang`
--

INSERT INTO `isi_pesanan_barang` (`id`, `kode`, `nama`, `id_barang`, `stok_sekarang`, `stok_pesan`, `stok_terima`, `harga_beli`, `total_beli`, `status`, `id_cabang`) VALUES
(150, 'PSN0055582', 'YOUC 1000', 89, 0, 10, 20, 7000, 70000, 1, 1),
(151, 'PSN0055582', 'Rexona Men Roll On', 88, 0, 10, 20, 14000, 140000, 1, 1),
(152, 'PSN0055582', 'Spidol Snowman', 87, 0, 10, 20, 8000, 80000, 1, 1),
(153, 'PSN0055582', 'Le Mineral', 86, 0, 10, 20, 2000, 20000, 1, 1),
(154, 'PSN0055582', 'Larutan Cap Kaki Tiga Leci', 85, 0, 10, 20, 4500, 45000, 1, 1),
(155, 'PSN0014086', 'YOUC 1000', 89, 5, 20, 20, 7000, 140000, 1, 1),
(156, 'PSN0014086', 'Rexona Men Roll On', 88, 9, 20, 20, 14000, 280000, 1, 1),
(157, 'PSN0014086', 'Spidol Snowman', 87, 9, 20, 20, 8000, 160000, 1, 1),
(158, 'PSN0014086', 'Le Mineral', 86, 9, 20, 20, 2000, 40000, 1, 1),
(159, 'PSN0014086', 'Larutan Cap Kaki Tiga Leci', 85, 5, 20, 20, 4500, 90000, 1, 1),
(160, 'PSN0064697', 'Fanta Soda 250ml', 90, 0, 20, 1, 3000, 60000, 1, 8),
(161, 'PSN0064697', 'Adem Sari Cingku', 91, 0, 20, 10, 4000, 80000, 1, 8),
(162, 'PSN0064697', 'Fresh Nature', 94, 0, 20, 12, 10000, 200000, 1, 8),
(163, 'PSN0064697', 'Milk Cleanser Bengkuang', 95, 0, 20, 12, 5000, 100000, 1, 8),
(164, 'PSN007651', 'Mizone White Tea', 92, 0, 20, 1, 4000, 80000, 1, 9),
(165, 'PSN007651', 'Pocari Sweat 500ml', 93, 0, 20, 10, 5000, 100000, 1, 9),
(166, 'PSN0010331', 'Indomie Rendang', 105, 80, 1, 1, 1675, 1675, 1, 1),
(167, 'PSN0010331', 'Sampoerna Mild', 104, 7, 3, 1, 23000, 69000, 1, 1),
(168, 'PSN0028882', 'Mizone White Tea', 92, 0, 10, 1, 4000, 40000, 1, 9),
(169, 'PSN0061292', 'Indomie Rendang', 105, 81, 4, 1, 1675, 6700, 1, 1),
(170, 'PSN0061292', 'Sampoerna Mild', 104, 10, 15, 1, 23000, 345000, 1, 1),
(171, 'PSN0037522', 'Mizone White Tea', 92, 10, 1, 1, 4000, 4000, 1, 9),
(172, 'PSN0037522', 'Pocari Sweat 500ml', 93, 0, 10, 10, 5000, 50000, 1, 9),
(177, 'PSN0095248', 'Indomie Rendang', 105, 85, 1, 1, 1675, 1675, 1, 1),
(178, 'PSN0095248', 'Sampoerna Mild', 104, 25, 1, 1, 23000, 23000, 1, 1),
(179, 'PSN002084', 'Aqua', 106, 239, 1, 0, 1042, 1042, 0, 1),
(180, 'PSN002084', 'Indomie Rendang', 105, 86, 1, 0, 1675, 1675, 0, 1),
(181, 'PSN0072179', 'Fanta Soda 250ml', 90, 2, 1, 1, 3000, 3000, 1, 8),
(182, 'PSN0072179', 'Adem Sari Cingku', 91, 2, 10, 10, 4000, 40000, 1, 8),
(183, 'PSN0037731', 'Adem Sari Cingku', 91, 2, 13, 10, 4000, 52000, 1, 8),
(184, 'PSN0037731', 'Fresh Nature', 94, 5, 12, 12, 10000, 120000, 1, 8),
(185, 'PSN0066175', 'Fanta Soda 250ml', 90, 2, 12, 1, 3000, 36000, 1, 8),
(186, 'PSN0066175', 'Adem Sari Cingku', 91, 2, 13, 10, 4000, 52000, 1, 8),
(187, 'PSN0066175', 'Fresh Nature', 94, 5, 14, 12, 10000, 140000, 1, 8),
(188, 'PSN0066175', 'Milk Cleanser Bengkuang', 95, 7, 12, 12, 5000, 60000, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `isi_stok_opname`
--

CREATE TABLE `isi_stok_opname` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `stok_aplikasi` int(11) NOT NULL,
  `stok_fisik` int(11) NOT NULL,
  `selisih_total` int(11) NOT NULL,
  `selisih_harga` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `isi_stok_opname`
--

INSERT INTO `isi_stok_opname` (`id`, `kode`, `id_barang`, `nama`, `stok_aplikasi`, `stok_fisik`, `selisih_total`, `selisih_harga`, `id_cabang`, `status`) VALUES
(68, 'SON0055777', 85, 'Larutan Cap Kaki Tiga Leci', 22, 29, 7, 38500, 1, 1),
(69, 'SON0055777', 86, 'Le Mineral', 26, 25, -1, -3000, 1, 1),
(70, 'SON0055777', 87, 'Spidol Snowman', 23, 22, -1, -10000, 1, 1),
(71, 'SON0055777', 88, 'Rexona Men Roll On', 23, 20, -3, -51000, 1, 1),
(72, 'SON0055777', 89, 'YOUC 1000', 25, 26, 1, 10000, 1, 1),
(73, 'SON0055777', 96, 'Indomie Goreng Iga Penyet', 80, 90, 10, 25000, 1, 1),
(74, 'SON0055777', 97, 'Indomie Ayam Bawang', 40, 10, -30, -75000, 1, 1),
(75, 'SON0055777', 98, 'Indomie Rendang', 110, 112, 2, 5000, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_barang`
--

INSERT INTO `kategori_barang` (`id`, `nama_kategori`) VALUES
(20, 'Rokok'),
(21, 'Makanan'),
(22, 'Minuman'),
(23, 'Alat'),
(25, 'Elektronik'),
(26, 'Mie'),
(27, 'Sampo'),
(28, 'Sabun'),
(29, 'Parfum');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `profit` int(11) NOT NULL,
  `harga_total` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `menu`) VALUES
(1, 'Superadmin'),
(2, 'Admin'),
(3, 'Cetak'),
(4, 'Export'),
(6, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_cicilan`
--

CREATE TABLE `pembayaran_cicilan` (
  `id` int(11) NOT NULL,
  `id_cicilan` varchar(50) NOT NULL,
  `id_pembelian` varchar(50) NOT NULL,
  `id_user` varchar(128) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `sisa_cicilan` int(11) NOT NULL,
  `uang` int(11) NOT NULL,
  `sisa_cicilan_akhir` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran_cicilan`
--

INSERT INTO `pembayaran_cicilan` (`id`, `id_cicilan`, `id_pembelian`, `id_user`, `id_cabang`, `tanggal`, `sisa_cicilan`, `uang`, `sisa_cicilan_akhir`, `kembalian`) VALUES
(106, 'IPC07012010861', 'JBR07012029230', 'lucasridwan_2301', 1, '07-01-2020 15:44:57', 115000, 15000, 100000, 0),
(107, 'IPC07012034616', 'JBR07012019606', 'lucasridwan_2301', 1, '07-01-2020 15:45:22', 25000, 0, 25000, 0),
(108, 'IPC07012034616', 'JBR07012019606', 'lucasridwan_2301', 1, '07-01-2020 15:45:50', 25000, 15000, 10000, 0),
(109, 'IPC07012034616', 'JBR07012019606', 'lucasridwan_2301', 1, '07-01-2020 15:46:01', 10000, 20000, 0, 10000),
(110, 'IPC07012020157', 'JBR07012042395', 'joona_682', 1, '07-01-2020 16:30:59', 89000, 10000, 79000, 0),
(111, 'IPC07012020157', 'JBR07012042395', 'joona_682', 1, '07-01-2020 16:32:49', 79000, 10000, 69000, 0),
(112, 'IPC07012020157', 'JBR07012042395', 'joona_682', 1, '07-01-2020 16:33:06', 69000, 100000, 0, 31000),
(113, 'IPC07012081435', 'JBR07012089182', 'deniroy_1225', 1, '07-01-2020 16:49:13', 147000, 40000, 107000, 0),
(114, 'IPC07012081435', 'JBR07012089182', 'deniroy_1225', 1, '07-01-2020 16:51:12', 107000, 57000, 50000, 0),
(115, 'IPC07012081435', 'JBR07012089182', 'deniroy_1225', 1, '07-01-2020 16:51:25', 50000, 100000, 0, 50000),
(116, 'IPC07012010861', 'JBR07012029230', 'lucasridwan_2301', 1, '07-01-2020 17:20:38', 100000, 10000, 90000, 0),
(117, 'IPC07012010861', 'JBR07012029230', 'lucasridwan_2301', 1, '07-01-2020 17:20:42', 90000, 10000, 80000, 0),
(118, 'IPC07012010861', 'JBR07012029230', 'lucasridwan_2301', 1, '07-01-2020 17:20:47', 80000, 20000, 60000, 0),
(119, 'IPC07012010861', 'JBR07012029230', 'lucasridwan_2301', 1, '07-01-2020 17:20:52', 60000, 10000, 50000, 0),
(120, 'IPC07012010861', 'JBR07012029230', 'lucasridwan_2301', 1, '07-01-2020 17:20:57', 50000, 100000, 0, 50000),
(121, 'IPC17012082840', 'JBR17012015618', 'deniroy_1225', 1, '17-01-2020 16:57:30', 35000, 10000, 25000, 0),
(122, 'IPC17012082840', 'JBR17012015618', 'deniroy_1225', 1, '17-01-2020 19:49:14', 25000, 1000, 24000, 0),
(123, 'IPC23012096202', 'JBR2301206840', 'deniroy_1225', 1, '23-01-2020 11:02:57', 21500, 1500, 20000, 0),
(124, 'IPC25012043602', 'JBR2501202822', 'deniroy_1225', 1, '25-01-2020 09:10:57', 21500, 0, 21500, 0),
(125, 'IPC25012088568', 'JBR25012063597', 'ucok_8832', 8, '25-01-2020 09:29:21', 16500, 10000, 6500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_hutang`
--

CREATE TABLE `pembayaran_hutang` (
  `id` int(11) NOT NULL,
  `kode` varchar(128) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `tanggal` varchar(128) NOT NULL,
  `sisa_hutang` int(11) NOT NULL,
  `uang` int(11) NOT NULL,
  `sisa_hutang_akhir` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran_hutang`
--

INSERT INTO `pembayaran_hutang` (`id`, `kode`, `nama`, `id_cabang`, `tanggal`, `sisa_hutang`, `uang`, `sisa_hutang_akhir`, `kembalian`) VALUES
(24, 'HUT1702020241', 'Widodo', 1, '17-01-2020 21:55:08', 100000, 0, 100000, 0),
(25, 'HUT1702020696', 'Opik', 1, '17-01-2020 21:55:30', 12500, 0, 12500, 0),
(26, 'HUT1702020134', 'Ucup', 8, '17-01-2020 22:01:57', 10000, 0, 10000, 0),
(27, 'HUT1702020134', 'Ucup', 8, '17-01-2020 22:02:08', 10000, 20000, 0, 10000),
(28, 'HUT1702020981', 'Riskuy', 8, '17-01-2020 22:12:22', 25000, 0, 25000, 0),
(30, 'HUT1702020981', 'Riskuy', 8, '17-01-2020 22:18:43', 25000, 10000, 15000, 0),
(31, 'HUT1702020696', 'Opik', 8, '17-01-2020 22:19:16', 12500, 1000, 11500, 0),
(32, 'HUT1702020696', 'Opik', 8, '17-01-2020 22:19:22', 11500, 1500, 10000, 0),
(33, 'HUT1702020696', 'Opik', 8, '17-01-2020 22:19:43', 10000, 15000, 0, 5000),
(34, 'HUT1702020738', 'Cep', 1, '17-01-2020 22:23:07', 250000, 0, 250000, 0),
(35, 'HUT1702020738', 'Cep', 1, '17-01-2020 22:24:02', 250000, 20000, 230000, 0),
(36, 'HUT1702020738', 'Cep', 1, '17-01-2020 22:24:08', 230000, 40000, 190000, 0),
(37, 'HUT1702020738', 'Cep', 1, '17-01-2020 22:24:32', 190000, 200000, 0, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_umum`
--

CREATE TABLE `pengaturan_umum` (
  `id` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `pemilik` varchar(255) NOT NULL,
  `alamat_perusahaan` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `footer` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengaturan_umum`
--

INSERT INTO `pengaturan_umum` (`id`, `nama_perusahaan`, `pemilik`, `alamat_perusahaan`, `title`, `footer`, `favicon`) VALUES
(1, 'Joona InventoryX', 'Cep Guna', 'Kp. Jelekong Rt01/04, Kec. Baleendah, Kab. Bandung', 'JInventory', 'Copyright © 2019 Joona Code | Developed By Cep Guna Widodo', '62755567b61840c84f1b3471e048e69b.png');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_barang`
--

CREATE TABLE `pesanan_barang` (
  `id` int(50) NOT NULL,
  `kode` varchar(128) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `suplier` varchar(128) DEFAULT NULL,
  `tempat` varchar(128) NOT NULL,
  `tanggal_pesan` varchar(50) NOT NULL,
  `tanggal_terima` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `jenis_pesanan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pesanan_barang`
--

INSERT INTO `pesanan_barang` (`id`, `kode`, `nama`, `suplier`, `tempat`, `tanggal_pesan`, `tanggal_terima`, `status`, `jenis_pesanan`) VALUES
(147, 'PSN0055582', 'Pesan Cabang 1', 'SUP002', '1', '06-01-2020', '06-01-2020', 1, 1),
(148, 'PSN0014086', 'Pesanan Stok Baru', 'SUP002', '1', '06-01-2020', '07-01-2020', 1, 1),
(149, 'PSN0064697', 'Pesan cabang 2', 'SUP002', '8', '06-01-2020', '07-01-2020', 1, 1),
(150, 'PSN007651', 'Pesan cabang 3', 'SUP001', '9', '06-01-2020', '07-01-2020', 1, 1),
(151, 'PSN0071395', 'Beli Iga Penyet', 'SUP002', '1', '07-01-2020', '07-01-2020', 1, 2),
(152, 'PSN0070495', 'Beli  indomie bawang 1dus', 'SUP001', '8', '07-01-2020', '07-01-2020', 1, 2),
(153, 'PSN0072607', 'Beli indomie rendang 3dus', 'SUP002', '9', '07-01-2020', '07-01-2020', 1, 2),
(155, 'PSN0087696', 'Pesan Le Mineral 2dus', 'SUP002', '8', '07-01-2020', '07-01-2020', 1, 2),
(157, 'PSN0094691', 'Pesan rokok dan mie', 'SUP002', '1', '07-01-2020', '07-01-2020', 1, 2),
(158, 'PSN0084600', 'Pesan barang tes', 'SUP001', '1', '07-01-2020', '07-01-2020', 1, 2),
(160, 'PSN0010331', 'ASd', 'SUP002', '1', '11-01-2020', '11-01-2020', 1, 1),
(162, 'PSN0031694', 'Aqa', 'SUP002', '1', '11-01-2020', '11-01-2020', 1, 2),
(163, 'PSN0028882', 'Asds', '-', '9', '11-01-2020', '11-01-2020', 1, 1),
(164, 'PSN0061292', 'RRTt', 'SUP002', '1', '11-01-2020', '11-01-2020', 1, 1),
(165, 'PSN0037522', 'asd', 'SUP002', '9', '11-01-2020', '11-01-2020', 1, 1),
(168, 'PSN0095248', 'dsa', '-', '1', '22-01-2020', '22-01-2020', 1, 1),
(169, 'PSN002084', 'sdfds', 'SUP002', '1', '22-01-2020', '', 0, 1),
(170, 'PSN0066391', 'asd', '-', '1', '22-01-2020', '', 0, 2),
(171, 'PSN0072179', 'sdfs', '-', '8', '23-01-2020', '24-01-2020', 1, 1),
(172, 'PSN0037731', 'asd', '-', '8', '24-01-2020', '24-01-2020', 1, 1),
(173, 'PSN0066175', 'Dss', 'SUP002', '8', '25-01-2020', '24-01-2020', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_manual`
--

CREATE TABLE `pesanan_manual` (
  `id` int(11) NOT NULL,
  `kode` varchar(128) NOT NULL,
  `nama_barang` varchar(128) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_total` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pesanan_manual`
--

INSERT INTO `pesanan_manual` (`id`, `kode`, `nama_barang`, `kategori`, `satuan`, `harga_beli`, `jumlah`, `harga_total`, `id_user`, `id_cabang`) VALUES
(65, 'PSN0071395', 'Indomie Goreng Iga Penyet', 'Makanan', 'kds', 68000, 2, 136000, 1, 1),
(66, 'PSN0070495', 'Indomie Ayam Bawang', 'Makanan', 'kds', 67000, 1, 67000, 1, 1),
(67, 'PSN0072607', 'Indomie Rendang', 'Makanan', 'kds', 68000, 3, 204000, 1, 1),
(69, 'PSN0087696', 'Le Mineral 600ML', 'Minuman', 'kds', 38000, 2, 76000, 1, 1),
(72, 'PSN0094691', 'Indomie Soto Lamongan', 'Makanan', 'kds', 66000, 2, 132000, 1, 1),
(73, 'PSN0094691', 'Djarum Super', 'Rokok', 'bks', 18000, 10, 180000, 1, 1),
(74, 'PSN0084600', 'Sampoerna Mild', 'Rokok', 'bks', 23000, 7, 161000, 1, 1),
(75, 'PSN0084600', 'Indomie Rendang', 'Makanan', 'kds', 67000, 2, 134000, 1, 1),
(81, 'PSN0031694', 'Aqua', 'Minuman', 'kds', 25000, 10, 250000, 1, 1),
(82, 'PSN0066391', 'asda', 'Alat', 'bks', 23, 23, 529, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pengeluaran`
--

CREATE TABLE `riwayat_pengeluaran` (
  `id` int(11) NOT NULL,
  `kode_pesanan` varchar(128) DEFAULT NULL,
  `id_cabang` int(11) NOT NULL,
  `total_pengeluaran` int(11) NOT NULL,
  `tanggal_ind` varchar(50) NOT NULL,
  `bulan_ind` varchar(50) NOT NULL,
  `single_bulan` varchar(10) NOT NULL,
  `single_tahun` int(11) NOT NULL,
  `bukti_pengeluaran` varchar(255) NOT NULL,
  `status_bukti` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `jenis` int(11) NOT NULL,
  `hari` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `riwayat_pengeluaran`
--

INSERT INTO `riwayat_pengeluaran` (`id`, `kode_pesanan`, `id_cabang`, `total_pengeluaran`, `tanggal_ind`, `bulan_ind`, `single_bulan`, `single_tahun`, `bukti_pengeluaran`, `status_bukti`, `catatan`, `jenis`, `hari`) VALUES
(78, '', 1, 40000, '11-01-2020', '01-2020', '01', 2020, 'default.png', 2, 'tidak asad', 2, 3),
(79, 'PSN0061292', 1, 351700, '11-02-2020', '02-2020', '02', 2020, '', 1, 'Pesanan - Kode : PSN0061292', 1, 3),
(80, 'PSN0037522', 1, 54000, '11-09-2020', '09-2022', '09', 2022, '', 1, 'Pesanan - Kode : PSN0037522', 1, 3),
(81, '', 1, 1000000, '11-10-2020', '10-2023', '10', 2023, 'default.png', 2, 'asdasdas', 2, 3),
(84, 'PSN0095248', 1, 24675, '22-11-2020', '11-2024', '11', 2024, 'ab749efb03d6ab11d72f0d28e05a48e7.png', 2, '', 0, 3),
(85, 'PSN002084', 1, 2717, '22-12-2020', '12-2021', '12', 2021, '', 0, '', 0, 3),
(86, 'PSN0066391', 1, 529, '22-01-2020', '01-2020', '01', 2020, '', 0, '', 0, 3),
(87, 'PSN0072179', 8, 43000, '23-01-2020', '01-2020', '01', 2020, '', 1, '', 0, 4),
(88, 'PSN0037731', 8, 172000, '24-01-2020', '01-2020', '01', 2020, '', 1, '', 0, 5),
(89, 'PSN0066175', 8, 288000, '24-01-2020', '01-2020', '01', 2020, '', 1, '', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_penjualan`
--

CREATE TABLE `riwayat_penjualan` (
  `id` int(11) NOT NULL,
  `id_pembelian` varchar(128) NOT NULL,
  `id_pembayaran_cicilan` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_keranjang` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `total_pembayaran` int(11) NOT NULL,
  `tanggal` varchar(20) NOT NULL,
  `tanggal_ind` varchar(128) NOT NULL,
  `bulan_ind` varchar(50) NOT NULL,
  `single_bulan` varchar(10) NOT NULL,
  `single_tahun` int(11) NOT NULL,
  `uang` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `pendapatan` int(11) NOT NULL,
  `hari` int(11) NOT NULL,
  `metode_bayar` varchar(50) NOT NULL,
  `status_utang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `riwayat_penjualan`
--

INSERT INTO `riwayat_penjualan` (`id`, `id_pembelian`, `id_pembayaran_cicilan`, `id_user`, `id_keranjang`, `id_cabang`, `total_pembayaran`, `tanggal`, `tanggal_ind`, `bulan_ind`, `single_bulan`, `single_tahun`, `uang`, `kembalian`, `pendapatan`, `hari`, `metode_bayar`, `status_utang`) VALUES
(192, 'JBR06012059792', '', '', 1499, 1, 45500, '06-01-2020 23:59:03', '06-01-2020', '01-2020', '01', 2020, 50000, 4500, 10000, 1, 'tunai', 0),
(193, 'JBR06012031992', '', '', 2077, 1, 62000, '06-01-2020 23:59:39', '06-01-2020', '01-2020', '01', 2020, 70000, 8000, 16000, 1, 'tunai', 0),
(194, 'JBR06012064469', '', '', 508, 9, 11500, '06-01-2020 00:11:08', '06-01-2020', '01-2020', '01', 2020, 20000, 8500, 2500, 1, 'tunai', 0),
(195, 'JBR06012029043', '', '', 4678, 9, 90000, '06-01-2020 00:11:38', '06-01-2020', '01-2020', '01', 2020, 100000, 10000, 20000, 1, 'tunai', 0),
(196, 'JBR06012092828', '', '', 6402, 9, 6500, '06-01-2020 00:12:53', '06-01-2020', '01-2020', '01', 2020, 6500, 0, 1500, 1, 'tunai', 0),
(197, 'JBR07012041093', '', '', 1969, 9, 39500, '07-01-2020 00:14:49', '07-01-2020', '01-2020', '01', 2020, 40000, 500, 8500, 2, 'tunai', 0),
(198, 'JBR07012027161', '', '', 7377, 9, 32500, '07-01-2020 00:15:10', '07-01-2020', '01-2020', '01', 2020, 50000, 17500, 7500, 2, 'tunai', 0),
(199, 'JBR06012084532', '', '', 8427, 8, 21500, '06-01-2020 00:16:47', '06-01-2020', '01-2020', '01', 2020, 25000, 3500, 5500, 1, 'tunai', 0),
(200, 'JBR06012072123', '', '', 7578, 8, 28000, '06-01-2020 00:17:07', '06-01-2020', '01-2020', '01', 2020, 30000, 2000, 6000, 1, 'tunai', 0),
(201, 'JBR06012091152', '', '', 9089, 8, 41000, '06-01-2020 00:17:31', '06-01-2020', '01-2020', '01', 2020, 50000, 9000, 12000, 1, 'tunai', 0),
(202, 'JBR07012036629', '', '', 5112, 8, 55500, '07-01-2020 00:19:48', '07-01-2020', '01-2020', '01', 2020, 60000, 4500, 11500, 2, 'tunai', 0),
(203, 'JBR07012031056', '', '', 9306, 1, 64000, '07-01-2020 00:21:40', '07-01-2020', '01-2020', '01', 2020, 70000, 6000, 13000, 2, 'tunai', 0),
(204, 'JBR07012073616', '', '', 9463, 1, 8500, '07-01-2020 00:21:51', '07-01-2020', '01-2020', '01', 2020, 8500, 0, 2000, 2, 'tunai', 0),
(205, 'JBR07012029230', 'IPC07012010861', 'lucasridwan_2301', 4181, 1, 115000, '07-01-2020 15:44:57', '07-01-2020', '01-2022', '01', 2022, 100000, 0, 21000, 2, 'cicilan', 0),
(206, 'JBR07012019606', 'IPC07012034616', 'lucasridwan_2301', 2606, 1, 25000, '07-01-2020 15:45:22', '07-01-2020', '01-2021', '01', 2021, 20000, 0, 8000, 2, 'cicilan', 0),
(207, 'JBR0701206695', '', '', 3546, 1, 42500, '07-01-2020 16:29:36', '07-01-2020', '01-2021', '01', 2021, 50000, 7500, 9000, 2, 'tunai', 0),
(208, 'JBR07012042395', 'IPC07012020157', 'joona_682', 7371, 1, 89000, '07-01-2020 16:30:59', '07-01-2020', '04-2020', '04', 2020, 100000, 0, 22000, 2, 'cicilan', 0),
(209, 'JBR07012025775', '', '', 445, 1, 93500, '07-01-2020 16:48:04', '07-01-2020', '04-2020', '04', 2020, 100000, 6500, 14000, 2, 'tunai', 0),
(210, 'JBR07012089182', 'IPC07012081435', 'deniroy_1225', 3314, 1, 147000, '07-01-2020 16:49:13', '07-01-2020', '03-2020', '03', 2020, 100000, 0, 39000, 2, 'cicilan', 0),
(211, 'JBR07012016177', '', '', 8613, 9, 50000, '07-01-2020 16:55:47', '07-01-2020', '03-2020', '03', 2020, 100000, 50000, 10000, 2, 'tunai', 0),
(212, 'JBR17012015618', 'IPC17012082840', 'deniroy_1225', 2272, 1, 35000, '17-01-2020 16:57:30', '17-01-2020', '02-2020', '02', 2020, 1000, 24000, 9100, 5, 'cicilan', 1),
(213, 'JBR22012094917', '', '', 7044, 1, 24000, '22-01-2020 19:09:33', '22-01-2020', '02-2020', '02', 2020, 25000, 1000, 3283, 3, 'tunai', 0),
(214, 'JBR23012016102', '', '', 7172, 1, 2500, '23-01-2020 10:19:03', '23-01-2020', '01-2020', '01', 2020, 1, 2499, 1458, 4, 'tunai', 0),
(215, 'JBR23012015307', '', '', 1960, 1, 2500, '23-01-2020 10:19:32', '23-01-2020', '01-2020', '01', 2020, 5500, 3000, 1458, 4, 'tunai', 0),
(216, 'JBR23012088031', '', '', 6485, 1, 19000, '23-01-2020 10:20:32', '23-01-2020', '01-2020', '01', 2020, 1, 18999, 1000, 4, 'tunai', 0),
(217, 'JBR23012050491', '', '', 6154, 1, 2500, '23-01-2020 10:32:08', '23-01-2020', '01-2020', '01', 2020, 1, 2499, 1458, 4, 'tunai', 0),
(218, 'JBR23012093364', '', '', 6386, 1, 2500, '23-01-2020 10:35:06', '23-01-2020', '01-2020', '01', 2020, 122222, 119722, 1458, 4, 'tunai', 0),
(219, 'JBR2301202836', '', '', 2090, 1, 2500, '23-01-2020 10:35:22', '23-01-2020', '01-2020', '01', 2020, 1, 2499, 1458, 4, 'tunai', 0),
(220, 'JBR23012018706', '', '', 6496, 1, 2500, '23-01-2020 10:36:35', '23-01-2020', '01-2020', '01', 2020, 2, 2498, 1458, 4, 'tunai', 0),
(221, 'JBR23012084186', '', '', 5030, 1, 2500, '23-01-2020 10:54:55', '23-01-2020', '01-2020', '01', 2020, 2500, 0, 1458, 4, 'tunai', 0),
(222, 'JBR23012084435', '', '', 8943, 8, 16500, '23-01-2020 11:01:45', '23-01-2020', '01-2020', '01', 2020, 17000, 500, 3500, 4, 'tunai', 0),
(223, 'JBR2301206840', 'IPC23012096202', 'deniroy_1225', 976, 1, 21500, '23-01-2020 11:02:57', '23-01-2020', '01-2020', '01', 2020, 1500, 20000, 2458, 4, 'cicilan', 1),
(224, 'JBR23012047458', '', '', 2222, 1, 1075000, '23-01-2020 15:39:32', '23-01-2020', '01-2020', '01', 2020, 2000000, 925000, 471932, 4, 'tunai', 0),
(225, 'JBR23012064463', '', '', 9260, 8, 275500, '23-01-2020 15:50:51', '23-01-2020', '01-2020', '01', 2020, 300000, 24500, 58500, 4, 'tunai', 0),
(226, 'JBR24012035487', '', '', 2371, 1, 120000, '24-01-2020 02:07:34', '24-01-2020', '01-2020', '01', 2020, 300000, 180000, 26475, 5, 'tunai', 0),
(227, 'JBR24012044677', '', '', 4794, 1, 5500, '24-01-2020 10:10:48', '24-01-2020', '01-2020', '01', 2020, 6000, 500, 1000, 5, 'tunai', 0),
(228, 'JBR25012047616', '', '', 3953, 1, 21500, '25-01-2020 09:07:09', '25-01-2020', '01-2020', '01', 2020, 234, 0, 2458, 6, 'tunai', 0),
(229, 'JBR2501202822', 'IPC25012043602', 'deniroy_1225', 8295, 1, 21500, '25-01-2020 09:10:57', '25-01-2020', '01-2020', '01', 2020, 0, 21500, 2458, 6, 'cicilan', 1),
(230, 'JBR25012091876', '', '', 4710, 8, 10000, '25-01-2020 09:28:53', '25-01-2020', '01-2020', '01', 2020, 10000, 0, 3000, 6, 'tunai', 0),
(231, 'JBR25012063597', 'IPC25012088568', 'ucok_8832', 7098, 8, 16500, '25-01-2020 09:29:21', '25-01-2020', '01-2020', '01', 2020, 10000, 6500, 3500, 6, 'cicilan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role`) VALUES
(1, 'Super Admin'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `satuan_barang`
--

CREATE TABLE `satuan_barang` (
  `id` int(11) NOT NULL,
  `nama_satuan` varchar(50) NOT NULL,
  `nama_asli` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `satuan_barang`
--

INSERT INTO `satuan_barang` (`id`, `nama_satuan`, `nama_asli`) VALUES
(12, 'bks', 'Bungkus'),
(13, 'pcs', 'Picis'),
(14, 'btl', 'Botol'),
(15, 'kds', 'Kardus'),
(16, 'gtg', 'Gantung');

-- --------------------------------------------------------

--
-- Table structure for table `semua_data_keranjang`
--

CREATE TABLE `semua_data_keranjang` (
  `id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `id_keranjang` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `harga_total` int(11) NOT NULL,
  `id_del` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `profit` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `id_barang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semua_data_keranjang`
--

INSERT INTO `semua_data_keranjang` (`id`, `barcode`, `id_keranjang`, `nama`, `jumlah`, `satuan`, `harga`, `harga_total`, `id_del`, `harga_beli`, `harga_jual`, `profit`, `id_user`, `id_cabang`, `id_barang`) VALUES
(672, '899999904966', 1499, 'Rexona Men Roll On', 1, 'btl', 17000, 17000, 672, 14000, 17000, 3000, 1, 1, 88),
(673, '899522750027', 1499, 'Larutan Cap Kaki Tiga Leci', 1, 'btl', 5500, 5500, 673, 4500, 5500, 1000, 1, 1, 85),
(674, '899700951005', 1499, 'YOUC 1000', 1, 'btl', 10000, 10000, 674, 7000, 10000, 3000, 1, 1, 89),
(675, '497012972751', 1499, 'Spidol Snowman', 1, 'pcs', 10000, 10000, 675, 8000, 10000, 2000, 1, 1, 87),
(676, '899600160026', 1499, 'Le Mineral', 1, 'btl', 3000, 3000, 676, 2000, 3000, 1000, 1, 1, 86),
(677, '899522750027', 2077, 'Larutan Cap Kaki Tiga Leci', 4, 'btl', 5500, 22000, 677, 4500, 5500, 4000, 1, 1, 85),
(678, '899700951005', 2077, 'YOUC 1000', 4, 'btl', 10000, 40000, 678, 7000, 10000, 12000, 1, 1, 89),
(679, '899275211251', 508, 'Mizone White Tea', 1, 'btl', 5000, 5000, 679, 4000, 5000, 1000, 105, 9, 92),
(680, '899703556341', 508, 'Pocari Sweat 500ml', 1, 'btl', 6500, 6500, 680, 5000, 6500, 1500, 105, 9, 93),
(681, '899703556341', 4678, 'Pocari Sweat 500ml', 10, 'btl', 6500, 65000, 681, 5000, 6500, 15000, 105, 9, 93),
(682, '899275211251', 4678, 'Mizone White Tea', 5, 'btl', 5000, 25000, 682, 4000, 5000, 5000, 105, 9, 92),
(683, '899703556341', 6402, 'Pocari Sweat 500ml', 1, 'btl', 6500, 6500, 683, 5000, 6500, 1500, 105, 9, 93),
(684, '899703556341', 1969, 'Pocari Sweat 500ml', 3, 'btl', 6500, 19500, 684, 5000, 6500, 4500, 105, 9, 93),
(685, '899275211251', 1969, 'Mizone White Tea', 4, 'btl', 5000, 20000, 685, 4000, 5000, 4000, 105, 9, 92),
(686, '899703556341', 7377, 'Pocari Sweat 500ml', 5, 'btl', 6500, 32500, 686, 5000, 6500, 7500, 105, 9, 93),
(687, '899279601113', 8427, 'Milk Cleanser Bengkuang', 1, 'btl', 6000, 6000, 687, 5000, 6000, 1000, 106, 8, 95),
(688, '899277258601', 8427, 'Adem Sari Cingku', 2, 'btl', 5500, 11000, 688, 4000, 5500, 3000, 106, 8, 91),
(689, '899276114511', 8427, 'Fanta Soda 250ml', 1, 'btl', 4500, 4500, 689, 3000, 4500, 1500, 106, 8, 90),
(690, '899277258601', 7578, 'Adem Sari Cingku', 1, 'btl', 5500, 5500, 690, 4000, 5500, 1500, 106, 8, 91),
(691, '899886660594', 7578, 'Fresh Nature', 1, 'btl', 12000, 12000, 691, 10000, 12000, 2000, 106, 8, 94),
(692, '899276114511', 7578, 'Fanta Soda 250ml', 1, 'btl', 4500, 4500, 692, 3000, 4500, 1500, 106, 8, 90),
(693, '899279601113', 7578, 'Milk Cleanser Bengkuang', 1, 'btl', 6000, 6000, 693, 5000, 6000, 1000, 106, 8, 95),
(694, '899277258601', 9089, 'Adem Sari Cingku', 5, 'btl', 5500, 27500, 694, 4000, 5500, 7500, 106, 8, 91),
(695, '899276114511', 9089, 'Fanta Soda 250ml', 3, 'btl', 4500, 13500, 695, 3000, 4500, 4500, 106, 8, 90),
(696, '899886660594', 5112, 'Fresh Nature', 3, 'btl', 12000, 36000, 696, 10000, 12000, 6000, 106, 8, 94),
(697, '899276114511', 5112, 'Fanta Soda 250ml', 3, 'btl', 4500, 13500, 697, 3000, 4500, 4500, 106, 8, 90),
(698, '899279601113', 5112, 'Milk Cleanser Bengkuang', 1, 'btl', 6000, 6000, 698, 5000, 6000, 1000, 106, 8, 95),
(699, '899522750027', 9306, 'Larutan Cap Kaki Tiga Leci', 2, 'btl', 5500, 11000, 699, 4500, 5500, 2000, 1, 1, 85),
(700, '899600160026', 9306, 'Le Mineral', 2, 'btl', 3000, 6000, 700, 2000, 3000, 2000, 1, 1, 86),
(701, '899999904966', 9306, 'Rexona Men Roll On', 1, 'btl', 17000, 17000, 701, 14000, 17000, 3000, 1, 1, 88),
(702, '497012972751', 9306, 'Spidol Snowman', 3, 'pcs', 10000, 30000, 702, 8000, 10000, 6000, 1, 1, 87),
(703, '899522750027', 9463, 'Larutan Cap Kaki Tiga Leci', 1, 'btl', 5500, 5500, 703, 4500, 5500, 1000, 1, 1, 85),
(704, '899600160026', 9463, 'Le Mineral', 1, 'btl', 3000, 3000, 704, 2000, 3000, 1000, 1, 1, 86),
(707, '899999904966', 4181, 'Rexona Men Roll On', 5, 'btl', 17000, 85000, 707, 14000, 17000, 15000, 1, 1, 88),
(708, '497012972751', 4181, 'Spidol Snowman', 3, 'pcs', 10000, 30000, 708, 8000, 10000, 6000, 1, 1, 87),
(709, '899529670706', 2606, 'Indomie Rendang', 10, 'pcs', 2500, 25000, 709, 1700, 2500, 8000, 1, 1, 98),
(710, '899700951005', 3546, 'YOUC 1000', 1, 'btl', 10000, 10000, 710, 7000, 10000, 3000, 1, 1, 89),
(711, '899999904966', 3546, 'Rexona Men Roll On', 1, 'btl', 17000, 17000, 711, 14000, 17000, 3000, 1, 1, 88),
(712, '899522750027', 3546, 'Larutan Cap Kaki Tiga Leci', 1, 'btl', 5500, 5500, 712, 4500, 5500, 1000, 1, 1, 85),
(713, '497012972751', 3546, 'Spidol Snowman', 1, 'pcs', 10000, 10000, 713, 8000, 10000, 2000, 1, 1, 87),
(714, '899700951005', 7371, 'YOUC 1000', 5, 'btl', 10000, 50000, 714, 7000, 10000, 15000, 1, 1, 89),
(715, '899522750027', 7371, 'Larutan Cap Kaki Tiga Leci', 4, 'btl', 5500, 22000, 715, 4500, 5500, 4000, 1, 1, 85),
(716, '899999904966', 7371, 'Rexona Men Roll On', 1, 'btl', 17000, 17000, 716, 14000, 17000, 3000, 1, 1, 88),
(718, '899999904966', 445, 'Rexona Men Roll On', 1, 'btl', 17000, 17000, 718, 14000, 17000, 3000, 1, 1, 88),
(719, '899700951005', 445, 'YOUC 1000', 1, 'btl', 10000, 10000, 719, 7000, 10000, 3000, 1, 1, 89),
(720, '899522750027', 445, 'Larutan Cap Kaki Tiga Leci', 1, 'btl', 5500, 5500, 720, 4500, 5500, 1000, 1, 1, 85),
(721, '497012972751', 445, 'Spidol Snowman', 2, 'pcs', 10000, 20000, 721, 8000, 10000, 4000, 1, 1, 87),
(722, '899600160026', 445, 'Le MineralE', 1, 'btl', 3000, 3000, 722, 2000, 3000, 1000, 1, 1, 86),
(723, '', 445, 'Djarum Super', 2, 'bks', 19000, 38000, 723, 18000, 19000, 2000, 1, 1, 103),
(724, '899999904966', 3314, 'Rexona Men Roll On', 1, 'btl', 17000, 17000, 724, 14000, 17000, 3000, 1, 1, 88),
(725, '497012972751', 3314, 'Spidol Snowman', 3, 'pcs', 10000, 30000, 725, 8000, 10000, 6000, 1, 1, 87),
(726, '899700951005', 3314, 'YOUC 1000', 10, 'btl', 10000, 100000, 726, 7000, 10000, 30000, 1, 1, 89),
(727, '899275211251', 8613, 'Mizone White Tea', 10, 'btl', 5000, 50000, 727, 4000, 5000, 10000, 105, 9, 92),
(737, '899529620981', 2272, 'Indomie Soto Lamongan', 6, 'pcs', 2500, 15000, 737, 1650, 2500, 5100, 1, 1, 102),
(738, '899999904966', 2272, 'Rexona Men Roll On', 1, 'btl', 17000, 17000, 738, 14000, 17000, 3000, 1, 1, 88),
(739, '899600160026', 2272, 'Le MineralE', 1, 'btl', 3000, 3000, 739, 2000, 3000, 1000, 1, 1, 86),
(740, '', 7044, 'Aqua', 1, 'pcs', 2500, 2500, 740, 1042, 2500, 1458, 1, 1, 106),
(741, '899529644451', 7044, 'Djarum Super', 1, 'bks', 19000, 19000, 741, 18000, 19000, 1000, 1, 1, 103),
(742, '899529636427', 7044, 'Indomie Ayam Bawang', 1, 'pcs', 2500, 2500, 742, 1675, 2500, 825, 1, 1, 97),
(743, '', 7172, 'Aqua', 1, 'pcs', 2500, 2500, 743, 1042, 2500, 1458, 1, 1, 106),
(744, '', 1960, 'Aqua', 1, 'pcs', 2500, 2500, 744, 1042, 2500, 1458, 1, 1, 106),
(745, '899529644451', 6485, 'Djarum Super', 1, 'bks', 19000, 19000, 745, 18000, 19000, 1000, 1, 1, 103),
(746, '', 6154, 'Aqua', 1, 'pcs', 2500, 2500, 746, 1042, 2500, 1458, 1, 1, 106),
(747, '', 6386, 'Aqua', 1, 'pcs', 2500, 2500, 747, 1042, 2500, 1458, 1, 1, 106),
(748, '', 2090, 'Aqua', 1, 'pcs', 2500, 2500, 748, 1042, 2500, 1458, 1, 1, 106),
(749, '', 6496, 'Aqua', 1, 'pcs', 2500, 2500, 749, 1042, 2500, 1458, 1, 1, 106),
(750, '', 5030, 'Aqua', 1, 'pcs', 2500, 2500, 750, 1042, 2500, 1458, 1, 1, 106),
(751, '899886660594', 8943, 'Fresh Nature', 1, 'btl', 12000, 12000, 751, 10000, 12000, 2000, 106, 8, 94),
(752, '899276114511', 8943, 'Fanta Soda 250ml', 1, 'btl', 4500, 4500, 752, 3000, 4500, 1500, 106, 8, 90),
(753, '', 976, 'Aqua', 1, 'pcs', 2500, 2500, 753, 1042, 2500, 1458, 1, 1, 106),
(754, '899529644451', 976, 'Djarum Super', 1, 'bks', 19000, 19000, 754, 18000, 19000, 1000, 1, 1, 103),
(755, '', 2222, 'Aqua', 229, 'pcs', 2500, 572500, 755, 1042, 2500, 333882, 1, 1, 106),
(756, '899529636427', 2222, 'Indomie Ayam Bawang', 34, 'pcs', 2500, 85000, 756, 1675, 2500, 28050, 1, 1, 97),
(757, '899529689004', 2222, 'Indomie Goreng Iga Penyet', 75, 'pcs', 2500, 187500, 757, 1700, 2500, 60000, 1, 1, 96),
(758, '899600160026', 2222, 'Le MineralE', 20, 'btl', 3000, 60000, 758, 2000, 3000, 20000, 1, 1, 86),
(759, '899999904966', 2222, 'Rexona Men Roll On', 10, 'btl', 17000, 170000, 759, 14000, 17000, 30000, 1, 1, 88),
(762, '899277258601', 9260, 'Adem Sari Cingku', 10, 'btl', 5500, 55000, 762, 4000, 5500, 15000, 106, 8, 91),
(763, '899276114511', 9260, 'Fanta Soda 250ml', 9, 'btl', 4500, 40500, 763, 3000, 4500, 13500, 106, 8, 90),
(765, '899886660594', 9260, 'Fresh Nature', 10, 'btl', 12000, 120000, 765, 10000, 12000, 20000, 106, 8, 94),
(766, '899279601113', 9260, 'Milk Cleanser Bengkuang', 10, 'btl', 6000, 60000, 766, 5000, 6000, 10000, 106, 8, 95),
(767, '899529636427', 2371, 'Indomie Ayam Bawang', 3, 'pcs', 2500, 7500, 767, 1675, 2500, 2475, 1, 1, 97),
(768, '899529689004', 2371, 'Indomie Goreng Iga Penyet', 5, 'pcs', 2500, 12500, 768, 1700, 2500, 4000, 1, 1, 96),
(769, '497012972751', 2371, 'Spidol Snowman', 10, 'pcs', 10000, 100000, 769, 8000, 10000, 20000, 1, 1, 87),
(770, '899522750027', 4794, 'Larutan Cap Kaki Tiga Leci', 1, 'btl', 5500, 5500, 770, 4500, 5500, 1000, 1, 1, 85),
(771, '899529645260', 3953, 'Aqua', 1, 'pcs', 2500, 2500, 771, 1042, 2500, 1458, 1, 1, 106),
(772, '899529644451', 3953, 'Djarum Super', 1, 'bks', 19000, 19000, 772, 18000, 19000, 1000, 1, 1, 103),
(773, '899529645260', 8295, 'Aqua', 1, 'pcs', 2500, 2500, 773, 1042, 2500, 1458, 1, 1, 106),
(774, '899529644451', 8295, 'Djarum Super', 1, 'bks', 19000, 19000, 774, 18000, 19000, 1000, 1, 1, 103),
(775, '899277258601', 4710, 'Adem Sari Cingku', 1, 'btl', 5500, 5500, 775, 4000, 5500, 1500, 106, 8, 91),
(776, '899276114511', 4710, 'Fanta Soda 250ml', 1, 'btl', 4500, 4500, 776, 3000, 4500, 1500, 106, 8, 90),
(777, '899276114511', 7098, 'Fanta Soda 250ml', 1, 'btl', 4500, 4500, 777, 3000, 4500, 1500, 106, 8, 90),
(778, '899886660594', 7098, 'Fresh Nature', 1, 'btl', 12000, 12000, 778, 10000, 12000, 2000, 106, 8, 94);

-- --------------------------------------------------------

--
-- Table structure for table `stok_barang`
--

CREATE TABLE `stok_barang` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `tgl` int(11) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `in_out` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_barang`
--

INSERT INTO `stok_barang` (`id`, `id_barang`, `tgl`, `tanggal`, `jumlah`, `keterangan`, `status`, `in_out`) VALUES
(674, 85, 1578329513, '', 0, 'Data awal', 1, 0),
(675, 86, 1578329544, '', 0, 'Data awal', 1, 0),
(676, 87, 1578329589, '', 0, 'Data awal', 1, 0),
(677, 88, 1578329655, '', 0, 'Data awal', 1, 0),
(678, 89, 1578329712, '', 0, 'Data awal', 1, 0),
(679, 90, 1578329750, '', 0, 'Data awal', 1, 0),
(680, 91, 1578329780, '', 0, 'Data awal', 1, 0),
(681, 92, 1578329830, '', 0, 'Data awal', 1, 0),
(682, 93, 1578329859, '', 0, 'Data awal', 1, 0),
(683, 89, 1578329918, '06-01-2020', 10, 'Pembelian Stok Barang - Kode : PSN0055582', 1, 0),
(684, 88, 1578329918, '06-01-2020', 10, 'Pembelian Stok Barang - Kode : PSN0055582', 1, 0),
(685, 87, 1578329918, '06-01-2020', 10, 'Pembelian Stok Barang - Kode : PSN0055582', 1, 0),
(686, 86, 1578329918, '06-01-2020', 10, 'Pembelian Stok Barang - Kode : PSN0055582', 1, 0),
(687, 85, 1578329918, '06-01-2020', 10, 'Pembelian Stok Barang - Kode : PSN0055582', 1, 0),
(688, 88, 1578329942, '', 1, 'Barang terjual - ID : JBR06012059792', 2, 0),
(689, 85, 1578329942, '', 1, 'Barang terjual - ID : JBR06012059792', 2, 0),
(690, 89, 1578329943, '', 1, 'Barang terjual - ID : JBR06012059792', 2, 0),
(691, 87, 1578329943, '', 1, 'Barang terjual - ID : JBR06012059792', 2, 0),
(692, 86, 1578329943, '', 1, 'Barang terjual - ID : JBR06012059792', 2, 0),
(693, 85, 1578329979, '', 4, 'Barang terjual - ID : JBR06012031992', 2, 0),
(694, 89, 1578329979, '', 4, 'Barang terjual - ID : JBR06012031992', 2, 0),
(695, 94, 1578330090, '', 0, 'Data awal', 1, 0),
(696, 95, 1578330194, '', 0, 'Data awal', 1, 0),
(697, 89, 1578330456, '07-01-2020', 20, 'Pembelian Stok Barang - Kode : PSN0014086', 1, 0),
(698, 88, 1578330457, '07-01-2020', 20, 'Pembelian Stok Barang - Kode : PSN0014086', 1, 0),
(699, 87, 1578330457, '07-01-2020', 20, 'Pembelian Stok Barang - Kode : PSN0014086', 1, 0),
(700, 86, 1578330457, '07-01-2020', 20, 'Pembelian Stok Barang - Kode : PSN0014086', 1, 0),
(701, 85, 1578330457, '07-01-2020', 20, 'Pembelian Stok Barang - Kode : PSN0014086', 1, 0),
(702, 90, 1578330583, '07-01-2020', 20, 'Pembelian Stok Barang - Kode : PSN0064697', 1, 0),
(703, 91, 1578330583, '07-01-2020', 20, 'Pembelian Stok Barang - Kode : PSN0064697', 1, 0),
(704, 94, 1578330584, '07-01-2020', 20, 'Pembelian Stok Barang - Kode : PSN0064697', 1, 0),
(705, 95, 1578330584, '07-01-2020', 20, 'Pembelian Stok Barang - Kode : PSN0064697', 1, 0),
(706, 92, 1578330621, '07-01-2020', 20, 'Pembelian Stok Barang - Kode : PSN007651', 1, 0),
(707, 93, 1578330622, '07-01-2020', 20, 'Pembelian Stok Barang - Kode : PSN007651', 1, 0),
(708, 92, 1578330668, '', 1, 'Barang terjual - ID : JBR07012064469', 2, 0),
(709, 93, 1578330668, '', 1, 'Barang terjual - ID : JBR07012064469', 2, 0),
(710, 93, 1578330697, '', 10, 'Barang terjual - ID : JBR07012029043', 2, 0),
(711, 92, 1578330698, '', 5, 'Barang terjual - ID : JBR07012029043', 2, 0),
(712, 93, 1578330773, '', 1, 'Barang terjual - ID : JBR07012092828', 2, 0),
(713, 93, 1578330889, '', 3, 'Barang terjual - ID : JBR07012041093', 2, 0),
(714, 92, 1578330889, '', 4, 'Barang terjual - ID : JBR07012041093', 2, 0),
(715, 93, 1578330910, '', 5, 'Barang terjual - ID : JBR07012027161', 2, 0),
(716, 95, 1578331007, '', 1, 'Barang terjual - ID : JBR07012084532', 2, 0),
(717, 91, 1578331007, '', 2, 'Barang terjual - ID : JBR07012084532', 2, 0),
(718, 90, 1578331007, '', 1, 'Barang terjual - ID : JBR07012084532', 2, 0),
(719, 91, 1578331026, '', 1, 'Barang terjual - ID : JBR07012072123', 2, 0),
(720, 94, 1578331026, '', 1, 'Barang terjual - ID : JBR07012072123', 2, 0),
(721, 90, 1578331027, '', 1, 'Barang terjual - ID : JBR07012072123', 2, 0),
(722, 95, 1578331027, '', 1, 'Barang terjual - ID : JBR07012072123', 2, 0),
(723, 91, 1578331051, '', 5, 'Barang terjual - ID : JBR07012091152', 2, 0),
(724, 90, 1578331051, '', 3, 'Barang terjual - ID : JBR07012091152', 2, 0),
(725, 94, 1578331188, '', 3, 'Barang terjual - ID : JBR07012036629', 2, 0),
(726, 90, 1578331188, '', 3, 'Barang terjual - ID : JBR07012036629', 2, 0),
(727, 95, 1578331188, '', 1, 'Barang terjual - ID : JBR07012036629', 2, 0),
(728, 85, 1578331299, '', 2, 'Barang terjual - ID : JBR07012031056', 2, 0),
(729, 86, 1578331299, '', 2, 'Barang terjual - ID : JBR07012031056', 2, 0),
(730, 88, 1578331300, '', 1, 'Barang terjual - ID : JBR07012031056', 2, 0),
(731, 87, 1578331300, '', 3, 'Barang terjual - ID : JBR07012031056', 2, 0),
(732, 85, 1578331311, '', 1, 'Barang terjual - ID : JBR07012073616', 2, 0),
(733, 86, 1578331311, '', 1, 'Barang terjual - ID : JBR07012073616', 2, 0),
(734, 96, 1578331513, '07-01-2020', 80, 'Pembelian Barang - Kode : PSN0071395', 1, 0),
(735, 97, 1578331606, '07-01-2020', 40, 'Pembelian Barang - Kode : PSN0070495', 1, 0),
(736, 98, 1578331675, '07-01-2020', 120, 'Pembelian Barang - Kode : PSN0072607', 1, 0),
(737, 99, 1578367492, '07-01-2020', 48, 'Pembelian Barang - Kode : PSN0087696', 1, 0),
(738, 88, 1578386697, '', 5, 'Barang terjual - ID : JBR07012029230', 2, 0),
(739, 87, 1578386697, '', 3, 'Barang terjual - ID : JBR07012029230', 2, 0),
(740, 98, 1578386722, '', 10, 'Barang terjual - ID : JBR07012019606', 2, 0),
(743, 102, 1578389253, '07-01-2020', 80, 'Pembelian Barang - Kode : PSN0094691', 1, 0),
(744, 103, 1578389253, '07-01-2020', 10, 'Pembelian Barang - Kode : PSN0094691', 1, 0),
(745, 89, 1578389376, '', 1, 'Barang terjual - ID : JBR0701206695', 2, 0),
(746, 88, 1578389376, '', 1, 'Barang terjual - ID : JBR0701206695', 2, 0),
(747, 85, 1578389376, '', 1, 'Barang terjual - ID : JBR0701206695', 2, 0),
(748, 87, 1578389376, '', 1, 'Barang terjual - ID : JBR0701206695', 2, 0),
(749, 89, 1578389459, '', 5, 'Barang terjual - ID : JBR07012042395', 2, 0),
(750, 85, 1578389459, '', 4, 'Barang terjual - ID : JBR07012042395', 2, 0),
(751, 88, 1578389459, '', 1, 'Barang terjual - ID : JBR07012042395', 2, 0),
(752, 103, 1578389495, '', 5, 'Stok In : Beli 5 ', 1, 1),
(753, 103, 1578389509, '', 5, 'Stok Out : Barang rusak', 2, 1),
(754, 104, 1578390363, '07-01-2020', 7, 'Pembelian Barang - Kode : PSN0084600', 1, 0),
(755, 105, 1578390363, '07-01-2020', 80, 'Pembelian Barang - Kode : PSN0084600', 1, 0),
(756, 88, 1578390483, '', 1, 'Barang terjual - ID : JBR07012025775', 2, 0),
(757, 89, 1578390484, '', 1, 'Barang terjual - ID : JBR07012025775', 2, 0),
(758, 85, 1578390484, '', 1, 'Barang terjual - ID : JBR07012025775', 2, 0),
(759, 87, 1578390484, '', 2, 'Barang terjual - ID : JBR07012025775', 2, 0),
(760, 86, 1578390484, '', 1, 'Barang terjual - ID : JBR07012025775', 2, 0),
(761, 103, 1578390484, '', 2, 'Barang terjual - ID : JBR07012025775', 2, 0),
(762, 88, 1578390553, '', 1, 'Barang terjual - ID : JBR07012089182', 2, 0),
(763, 87, 1578390553, '', 3, 'Barang terjual - ID : JBR07012089182', 2, 0),
(764, 89, 1578390553, '', 10, 'Barang terjual - ID : JBR07012089182', 2, 0),
(765, 105, 1578390599, '', 10, 'Stok In : Tambah stok 10', 1, 1),
(766, 105, 1578390615, '', 10, 'Stok Out : Barang kadaluarsa', 2, 1),
(767, 92, 1578390947, '', 10, 'Barang terjual - ID : JBR07012016177', 2, 0),
(768, 105, 1578751386, '11-01-2020', 1, 'Pembelian Stok Barang - Kode : PSN0010331', 1, 0),
(769, 104, 1578751386, '11-01-2020', 3, 'Pembelian Stok Barang - Kode : PSN0010331', 1, 0),
(770, 106, 1578751829, '11-01-2020', 240, 'Pembelian Barang - Kode : PSN0031694', 1, 0),
(771, 92, 1578752100, '11-01-2020', 10, 'Pembelian Barang - Kode : PSN0028882', 1, 0),
(772, 105, 1578752485, '11-01-2020', 4, 'Pembelian Stok Barang - Kode : PSN0061292', 1, 0),
(773, 104, 1578752486, '11-01-2020', 15, 'Pembelian Stok Barang - Kode : PSN0061292', 1, 0),
(774, 92, 1578752707, '11-01-2020', 1, 'Pembelian Barang - Kode : PSN0037522', 1, 0),
(775, 93, 1578752707, '11-01-2020', 10, 'Pembelian Barang - Kode : PSN0037522', 1, 0),
(776, 102, 1579255050, '', 6, 'Barang terjual - ID : JBR17012015618', 2, 0),
(777, 88, 1579255050, '', 1, 'Barang terjual - ID : JBR17012015618', 2, 0),
(778, 86, 1579255050, '', 1, 'Barang terjual - ID : JBR17012015618', 2, 0),
(779, 106, 1579694972, '', 1, 'Barang terjual - ID : JBR22012094917', 2, 0),
(780, 103, 1579694972, '', 1, 'Barang terjual - ID : JBR22012094917', 2, 0),
(781, 97, 1579694973, '', 1, 'Barang terjual - ID : JBR22012094917', 2, 0),
(782, 105, 1579701793, '22-01-2020', 1, 'Pembelian Stok Barang - Kode : PSN0095248', 1, 0),
(783, 104, 1579701793, '22-01-2020', 1, 'Pembelian Stok Barang - Kode : PSN0095248', 1, 0),
(784, 106, 1579749543, '', 1, 'Barang terjual - ID : JBR23012016102', 2, 0),
(785, 106, 1579749572, '', 1, 'Barang terjual - ID : JBR23012015307', 2, 0),
(786, 103, 1579749632, '', 1, 'Barang terjual - ID : JBR23012088031', 2, 0),
(787, 106, 1579750328, '', 1, 'Barang terjual - ID : JBR23012050491', 2, 0),
(788, 106, 1579750506, '', 1, 'Barang terjual - ID : JBR23012093364', 2, 0),
(789, 106, 1579750522, '', 1, 'Barang terjual - ID : JBR2301202836', 2, 0),
(790, 106, 1579750595, '', 1, 'Barang terjual - ID : JBR23012018706', 2, 0),
(791, 106, 1579751695, '', 1, 'Barang terjual - ID : JBR23012084186', 2, 0),
(792, 94, 1579752105, '', 1, 'Barang terjual - ID : JBR23012084435', 2, 0),
(793, 90, 1579752105, '', 1, 'Barang terjual - ID : JBR23012084435', 2, 0),
(794, 106, 1579752177, '', 1, 'Barang terjual - ID : JBR2301206840', 2, 0),
(795, 103, 1579752177, '', 1, 'Barang terjual - ID : JBR2301206840', 2, 0),
(797, 108, 1579762110, '', 0, 'Data awal', 1, 0),
(798, 106, 1579768771, '', 229, 'Barang terjual - ID : JBR23012047458', 2, 0),
(799, 97, 1579768771, '', 34, 'Barang terjual - ID : JBR23012047458', 2, 0),
(800, 96, 1579768771, '', 75, 'Barang terjual - ID : JBR23012047458', 2, 0),
(801, 86, 1579768771, '', 20, 'Barang terjual - ID : JBR23012047458', 2, 0),
(802, 88, 1579768772, '', 10, 'Barang terjual - ID : JBR23012047458', 2, 0),
(803, 91, 1579769450, '', 10, 'Barang terjual - ID : JBR23012064463', 2, 0),
(804, 90, 1579769450, '', 9, 'Barang terjual - ID : JBR23012064463', 2, 0),
(805, 94, 1579769451, '', 10, 'Barang terjual - ID : JBR23012064463', 2, 0),
(806, 95, 1579769451, '', 10, 'Barang terjual - ID : JBR23012064463', 2, 0),
(807, 109, 1579770916, '', 0, 'Data awal', 1, 0),
(808, 90, 1579799634, '24-01-2020', 12, 'Pembelian Stok Barang - Kode : PSN0066175', 1, 0),
(809, 91, 1579799634, '24-01-2020', 13, 'Pembelian Stok Barang - Kode : PSN0066175', 1, 0),
(810, 94, 1579799634, '24-01-2020', 14, 'Pembelian Stok Barang - Kode : PSN0066175', 1, 0),
(811, 95, 1579799634, '24-01-2020', 12, 'Pembelian Stok Barang - Kode : PSN0066175', 1, 0),
(812, 91, 1579799640, '24-01-2020', 13, 'Pembelian Stok Barang - Kode : PSN0037731', 1, 0),
(813, 94, 1579799640, '24-01-2020', 12, 'Pembelian Stok Barang - Kode : PSN0037731', 1, 0),
(814, 90, 1579799645, '24-01-2020', 1, 'Pembelian Stok Barang - Kode : PSN0072179', 1, 0),
(815, 91, 1579799645, '24-01-2020', 10, 'Pembelian Stok Barang - Kode : PSN0072179', 1, 0),
(816, 97, 1579806454, '', 3, 'Barang terjual - ID : JBR24012035487', 2, 0),
(817, 96, 1579806454, '', 5, 'Barang terjual - ID : JBR24012035487', 2, 0),
(818, 87, 1579806454, '', 10, 'Barang terjual - ID : JBR24012035487', 2, 0),
(819, 85, 1579835448, '', 1, 'Barang terjual - ID : JBR24012044677', 2, 0),
(820, 106, 1579918029, '', 1, 'Barang terjual - ID : JBR25012047616', 2, 0),
(821, 103, 1579918029, '', 1, 'Barang terjual - ID : JBR25012047616', 2, 0),
(822, 106, 1579918257, '', 1, 'Barang terjual - ID : JBR2501202822', 2, 0),
(823, 103, 1579918257, '', 1, 'Barang terjual - ID : JBR2501202822', 2, 0),
(824, 91, 1579919333, '', 1, 'Barang terjual - ID : JBR25012091876', 2, 0),
(825, 90, 1579919333, '', 1, 'Barang terjual - ID : JBR25012091876', 2, 0),
(826, 90, 1579919361, '', 1, 'Barang terjual - ID : JBR25012063597', 2, 0),
(827, 94, 1579919361, '', 1, 'Barang terjual - ID : JBR25012063597', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stok_opname`
--

CREATE TABLE `stok_opname` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `tempat` varchar(128) NOT NULL,
  `status` varchar(128) NOT NULL,
  `catatan` text DEFAULT NULL,
  `disabled` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_opname`
--

INSERT INTO `stok_opname` (`id`, `kode`, `nama`, `tanggal`, `tempat`, `status`, `catatan`, `disabled`) VALUES
(20, 'SON0055777', 'Stok opname contoh', '07-01-2020', '1', 'Stok Opname', 'Contoh opname', 1);

-- --------------------------------------------------------

--
-- Table structure for table `suplier`
--

CREATE TABLE `suplier` (
  `id` int(11) NOT NULL,
  `id_suplier` varchar(128) NOT NULL,
  `nama_suplier` varchar(128) NOT NULL,
  `alamat_suplier` varchar(128) NOT NULL,
  `telp` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suplier`
--

INSERT INTO `suplier` (`id`, `id_suplier`, `nama_suplier`, `alamat_suplier`, `telp`) VALUES
(8, 'SUP001', 'Toko Sari', 'Jln Batugajah', '087822456789'),
(9, 'SUP002', 'Toko Asep Etoy', 'Jelekong sisi pangkalan ojek', '081892654732');

-- --------------------------------------------------------

--
-- Table structure for table `tes`
--

CREATE TABLE `tes` (
  `id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(5) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profile` varchar(255) NOT NULL,
  `penempatan_cabang` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `email`, `jenis_kelamin`, `password`, `foto_profile`, `penempatan_cabang`, `role_id`, `status`) VALUES
(1, 'Bill', 'sadmin', 'cep@gmail.com', 'l', '$2y$10$F9hCjhSURFO9MH8VyBpSRewLS281zBZeQPb7RIzsEj1S.aGiHp7Wa', '76390086f33b99b830e90b16fcd346aa.png', 1, 1, 1),
(105, 'James', 'admin2', 'ajt@gmail.com', 'l', '$2y$10$ceNcAeK5mf9rhMWeD9lu8uRwMuah3rSIr7Yn8CiahxDtquAJntcTW', 'default.png', 9, 2, 1),
(106, 'Izzy', 'admin1', 'ab@gmail.com', 'p', '$2y$10$P8N4YfU2EC4uymGgL3LdXei7wTKWhF9GH7I57BWP4dE7XIQr6RqR6', 'fe1e54432754fe672cabe82abf1bcedf.png', 8, 2, 1),
(108, 'Evan', 'admin3', 'evan@gmail.com', 'l', '$2y$10$.N80ed85rbqIdySO/sae9.LeViPPGRly.97.U44f2LggkM26Pp0n2', 'default.png', 1, 2, 1),
(109, 'asd', 'asd', 'asdasd@as.com', 'p', '$2y$10$9Hry3UcKsiNzwzG20Ki3/.TyLpCgMugpfU5ZWrInAYhNGjH8C2JiO', 'default.png', 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_langganan`
--

CREATE TABLE `user_langganan` (
  `id` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `tlp_user` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `penempatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_langganan`
--

INSERT INTO `user_langganan` (`id`, `id_user`, `nama_user`, `tlp_user`, `alamat`, `penempatan`) VALUES
(47, 'lucasridwan_2301', 'Lucas Ridwan', '-', '-', 1),
(48, 'joona_682', 'Joona', '-', '-', 1),
(49, 'deniroy_1225', 'Deni Roy', '0878325421232', 'Bandung', 1),
(50, 'ucok_8832', 'Ucok', '34232', 'Ass', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses_menu`
--
ALTER TABLE `akses_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_cabang`
--
ALTER TABLE `data_cabang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_hutang`
--
ALTER TABLE `data_hutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `isi_pesanan_barang`
--
ALTER TABLE `isi_pesanan_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `isi_stok_opname`
--
ALTER TABLE `isi_stok_opname`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran_cicilan`
--
ALTER TABLE `pembayaran_cicilan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran_hutang`
--
ALTER TABLE `pembayaran_hutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaturan_umum`
--
ALTER TABLE `pengaturan_umum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan_barang`
--
ALTER TABLE `pesanan_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan_manual`
--
ALTER TABLE `pesanan_manual`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_pengeluaran`
--
ALTER TABLE `riwayat_pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_penjualan`
--
ALTER TABLE `riwayat_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan_barang`
--
ALTER TABLE `satuan_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semua_data_keranjang`
--
ALTER TABLE `semua_data_keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suplier`
--
ALTER TABLE `suplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tes`
--
ALTER TABLE `tes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_langganan`
--
ALTER TABLE `user_langganan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses_menu`
--
ALTER TABLE `akses_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `data_cabang`
--
ALTER TABLE `data_cabang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `data_hutang`
--
ALTER TABLE `data_hutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `isi_pesanan_barang`
--
ALTER TABLE `isi_pesanan_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `isi_stok_opname`
--
ALTER TABLE `isi_stok_opname`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=781;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran_cicilan`
--
ALTER TABLE `pembayaran_cicilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `pembayaran_hutang`
--
ALTER TABLE `pembayaran_hutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `pengaturan_umum`
--
ALTER TABLE `pengaturan_umum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pesanan_barang`
--
ALTER TABLE `pesanan_barang`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `pesanan_manual`
--
ALTER TABLE `pesanan_manual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `riwayat_pengeluaran`
--
ALTER TABLE `riwayat_pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `riwayat_penjualan`
--
ALTER TABLE `riwayat_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `satuan_barang`
--
ALTER TABLE `satuan_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `semua_data_keranjang`
--
ALTER TABLE `semua_data_keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=781;

--
-- AUTO_INCREMENT for table `stok_barang`
--
ALTER TABLE `stok_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=828;

--
-- AUTO_INCREMENT for table `stok_opname`
--
ALTER TABLE `stok_opname`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `suplier`
--
ALTER TABLE `suplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tes`
--
ALTER TABLE `tes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `user_langganan`
--
ALTER TABLE `user_langganan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
