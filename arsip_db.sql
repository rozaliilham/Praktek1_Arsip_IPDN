-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2022 at 01:05 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arsip_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `mst_kategori`
--

CREATE TABLE `mst_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` text NOT NULL,
  `status_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_kategori`
--

INSERT INTO `mst_kategori` (`id_kategori`, `nama_kategori`, `status_kategori`) VALUES
(1, 'Dokumen Pembelian', 1),
(2, 'Surat Internal', 1),
(3, 'Surat Ketetapan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_user`
--

CREATE TABLE `mst_user` (
  `id_user` int(11) NOT NULL,
  `nama` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `level` text NOT NULL,
  `date_created` date NOT NULL,
  `image` text NOT NULL,
  `is_active` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_user`
--

INSERT INTO `mst_user` (`id_user`, `nama`, `email`, `password`, `level`, `date_created`, `image`, `is_active`) VALUES
(15, 'Donny Kurniawan', 'admin@gmail.com', '$2y$10$1CGoPtKRjQXU.kjmLiIoueroxm6TSleJ8NjyIKTKeDzOqvmyJcYwW', 'Admin', '2019-10-02', 'default.jpg', 1),
(16, 'Ratna Damayanti', 'user@gmail.com', '$2y$10$phlL8FV8AvKrFCLZhNfX5uO0QwSd0KgBQFr3jl.YyveXIAld9HqtW', 'User', '2019-10-02', 'avatar2.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_arsip`
--

CREATE TABLE `tb_arsip` (
  `id_arsip` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `kode_arsip` text NOT NULL,
  `tgl_upload` date NOT NULL,
  `jam_upload` time NOT NULL,
  `nama_file` text NOT NULL,
  `jenis_file` text NOT NULL,
  `petugas_arsip` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `file_arsip` varchar(250) NOT NULL,
  `status_arsip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_arsip`
--

INSERT INTO `tb_arsip` (`id_arsip`, `kategori_id`, `kode_arsip`, `tgl_upload`, `jam_upload`, `nama_file`, `jenis_file`, `petugas_arsip`, `keterangan`, `file_arsip`, `status_arsip`) VALUES
(7, 1, 'MN-002', '2022-02-08', '06:55:56', 'Pembelian Mesin Genset', 'pdf', 15, '<p xss=\"removed\" xss=removed>Pada setiap transaksi pembelian barang dagang, pasti terdapat dokumen-dokumen yang menyangkut administrasi pembelian barang. Dokumen-dokumen tersebut terdiri atas beberapa hal, seperti surat permintaan pembeli, surat penawaran barang, dan faktur pembelian. Selain itu, transaksi pembelian barang terkait pula dengan hal-hal seperti biaya angkut, potongan pembelian, serta transaksi tunai dan kredit. Lalu, apakah yang dimaksud dengan pembelian barang? Apa juga yang dimaksud dengan faktur pembelian? Bagaimana cara mengisi formulir permintaan barang? Mari kita pelajari bab berikut untuk menjawab pertanyaan-pertanyaan tersebut.<br></p>', 'example3.pdf', 0),
(8, 2, 'SR-003', '2022-02-08', '06:57:25', 'Surat Pengangkatan', 'pdf', 15, '<p>Dan jika ditinjau dari fungsinya, surat merupakan suatu alat atau sarana komunikasi tertulis. Surat dipandang sebagai alat komunikasi tulis yang paling efisien, efektif, ekonomis dan praktis. Dibandingkan dengan alat komunikasi lisan, surat mempunyai kelebihan-kelebihan. Apa yang dikomunikasikan kepada pihak lain secara tertulis, misalnya berupa pengumuman, pemberitahuan, dan sebagainya, akan sampai kepada alamat yang dituju sesuai dengan sumber aslinya.<br></p>', 'example6.pdf', 0),
(9, 3, 'SK-0098', '2022-02-08', '06:58:52', 'Surat Ketetapan Pajak', 'pdf', 15, '<p xss=removed>Mendapatkan surat ketika kurang membayar pajak dari jumlah yang seharusnya adalah hal yang wajar. Apalagi, bila ada sanksi yang dikenakan, itu menjadi suatu bentuk peringatan yang sudah biasa. Namun, tahukah Anda bahwa ternyata jika Anda membayar pajak lebih dari pada yang terutang, maka Anda juga akan mendapat Surat Ketetapan Pajak Lebih Bayar dari Direktur Jenderal Pajak?</p><p xss=removed>Jika Anda membayar pajak kurang dari jumlah pajak terutang, maka Anda akan mendapat Surat Ketetapan Pajak Kurang Bayar Tambahan. Surat ini perlu dipahami karena ada sanksi yang diberikan kepada Wajib Pajak. Sanksi yang diberikan dapat membebani Wajib Pajak, maka perlu untuk simak pemahaman mengenai Surat Ketetapan Pajak Kurang Bayar Tambahan.</p>', 'example10.pdf', 1),
(10, 1, 'PBM-001', '2022-02-08', '07:00:51', 'Surat Pembelian Tanah', 'pdf', 16, '<p xss=removed>Surat perjanjian jual beli tanah adalah dokumen kesepakatan tertulis antara penjual dan pembeli dalam satu transaksi jual beli tanah. Kedepannya, surat ini bisa dijadikan pedoman untuk menghindari konflik antara pihak penjual dan pembeli.</p><p xss=removed>Dokumen surat perjanjian jual beli tanah ini umumnya dibuat dengan bantuan notaris. . Namun tidak menutup kemungkinan Anda tetap bisa menerbitkan akta di bawah tangan dengan membuat contoh surat jual beli tanah bermaterai. Tetapi jika dipandang secara hukum, memang surat kuasa jual beli tanah notaris memiliki kekuatan yang lebih kuat dibanding akta di bawah tangan.</p>', 'Example13.pdf', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_kategori`
--
ALTER TABLE `mst_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `mst_user`
--
ALTER TABLE `mst_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tb_arsip`
--
ALTER TABLE `tb_arsip`
  ADD PRIMARY KEY (`id_arsip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_kategori`
--
ALTER TABLE `mst_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mst_user`
--
ALTER TABLE `mst_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tb_arsip`
--
ALTER TABLE `tb_arsip`
  MODIFY `id_arsip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
