-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2018 at 01:12 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bkd_akademik`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_angkatan`
--

CREATE TABLE `master_angkatan` (
  `id_angkatan` int(20) NOT NULL,
  `angkatan` varchar(20) NOT NULL,
  `id_master_unit` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_angkatan`
--

INSERT INTO `master_angkatan` (`id_angkatan`, `angkatan`, `id_master_unit`) VALUES
(3, '2015', 34),
(4, '2016', 34),
(5, '2017', 34),
(6, '2018', 34),
(7, '2015', 35),
(8, '2016', 35),
(9, '2017', 35),
(10, '2018', 35),
(11, '2015', 36),
(12, '2016', 36),
(13, '2017', 36),
(14, '2018', 36),
(15, '2015', 47),
(16, '2016', 47),
(17, '2017', 47),
(18, '2018', 47),
(19, '2015', 39),
(20, '2016', 39),
(21, '2017', 39),
(22, '2018', 39);

-- --------------------------------------------------------

--
-- Table structure for table `master_level`
--

CREATE TABLE `master_level` (
  `level_id` varchar(200) NOT NULL,
  `level_nama` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_level`
--

INSERT INTO `master_level` (`level_id`, `level_nama`) VALUES
('1', 'admin'),
('2', 'Mahasiswa');

-- --------------------------------------------------------

--
-- Table structure for table `master_main_menu`
--

CREATE TABLE `master_main_menu` (
  `main_id` int(2) NOT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_main_menu`
--

INSERT INTO `master_main_menu` (`main_id`, `nama_menu`, `keterangan`, `icon`) VALUES
(1, 'Akademik', NULL, 'icon-stack2'),
(2, 'Final Project', NULL, 'icon-graduation'),
(3, 'User Control', NULL, 'icon-key'),
(4, 'Tugas Akhir', NULL, 'icon-stack2'),
(5, 'Alumni', NULL, 'icon-users2');

-- --------------------------------------------------------

--
-- Table structure for table `master_menu`
--

CREATE TABLE `master_menu` (
  `menu_id` int(11) NOT NULL,
  `menu_nama` varchar(100) NOT NULL,
  `menu_uri` varchar(100) NOT NULL,
  `menu_allowed` varchar(100) NOT NULL,
  `main_menu` int(2) NOT NULL,
  `induk` int(3) DEFAULT '0',
  `child` int(3) NOT NULL,
  `folder` varchar(20) CHARACTER SET latin1 NOT NULL,
  `icon` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_menu`
--

INSERT INTO `master_menu` (`menu_id`, `menu_nama`, `menu_uri`, `menu_allowed`, `main_menu`, `induk`, `child`, `folder`, `icon`) VALUES
(7, 'List Final Project', 'akademik/daftar_tugas.php', '+1', 0, 0, 0, 'akademik', 'icon-graduation'),
(2, 'Input Jurusan', 'akademik/master_jurusan.php', '+1', 1, 0, 0, 'akademik', ''),
(3, 'Input User Control', 'akademik/master_user.php', '+1', 0, 0, 0, 'akademik', 'icon-users'),
(4, 'Input Angkatan', 'akademik/master_angkatan.php', '+1', 1, 0, 0, 'akademik', ''),
(6, 'Final Project', 'master_kelas/input_data_ta.php', '+2', 4, 0, 0, 'master_kelas', '');

-- --------------------------------------------------------

--
-- Table structure for table `master_tahun_ajaran`
--

CREATE TABLE `master_tahun_ajaran` (
  `id_tahun_ajaran` int(2) NOT NULL,
  `nama_tahun_ajaran` varchar(50) NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_tahun_ajaran`
--

INSERT INTO `master_tahun_ajaran` (`id_tahun_ajaran`, `nama_tahun_ajaran`, `active`) VALUES
(15, '2019-2020', 0),
(9, '2017-2018', 0),
(14, '2018-2019', 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_unit`
--

CREATE TABLE `master_unit` (
  `id_master_unit` int(3) NOT NULL,
  `unit` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_unit`
--

INSERT INTO `master_unit` (`id_master_unit`, `unit`) VALUES
(35, 'D-III Teknik Mekatronika'),
(34, 'D-III Teknik Informatika'),
(36, 'D-III Teknik Elektronika'),
(47, 'D-III Akuntansi'),
(39, 'D-IV AKP');

-- --------------------------------------------------------

--
-- Table structure for table `master_upload_data`
--

CREATE TABLE `master_upload_data` (
  `id_upload` int(20) NOT NULL,
  `id_nama` varchar(50) NOT NULL,
  `nim` int(20) NOT NULL,
  `id_unit` int(20) NOT NULL,
  `id_angkatan` int(50) NOT NULL,
  `judul_tugas` varchar(100) NOT NULL,
  `id_user` int(20) NOT NULL,
  `data` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_upload_data`
--

INSERT INTO `master_upload_data` (`id_upload`, `id_nama`, `nim`, `id_unit`, `id_angkatan`, `judul_tugas`, `id_user`, `data`) VALUES
(92, 'Reza Aulya', 2015302021, 34, 3, 'sakit hati', 90, 'FINAL_PROJECT_2015302021.pdf'),
(95, 'Ahd Muhajir', 2015302002, 34, 3, 'sakit hati', 93, 'FINAL_PROJECT_2015302002.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `master_user`
--

CREATE TABLE `master_user` (
  `u_id` int(10) NOT NULL,
  `u_username` varchar(50) NOT NULL COMMENT 'Username Email',
  `u_password` char(125) NOT NULL COMMENT 'User Password SHA1()',
  `u_first_name` varchar(50) NOT NULL COMMENT 'User First Name',
  `angkatan` int(20) NOT NULL,
  `user_level` varchar(100) NOT NULL,
  `prodi` varchar(20) NOT NULL,
  `id_jabatan` int(4) NOT NULL,
  `u_sys_created_by` int(11) NOT NULL COMMENT 'User ID',
  `u_sys_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Sysdate',
  `u_sys_lastlogin_date` timestamp NULL DEFAULT NULL COMMENT 'Sysdate',
  `u_sys_modified_by` int(11) DEFAULT NULL COMMENT 'User ID',
  `u_sys_modified_date` timestamp NULL DEFAULT NULL COMMENT 'Sysdate',
  `active` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Table User CMS';

--
-- Dumping data for table `master_user`
--

INSERT INTO `master_user` (`u_id`, `u_username`, `u_password`, `u_first_name`, `angkatan`, `user_level`, `prodi`, `id_jabatan`, `u_sys_created_by`, `u_sys_created_date`, `u_sys_lastlogin_date`, `u_sys_modified_by`, `u_sys_modified_date`, `active`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '', 0, '1', '', 1, 1, '2016-10-23 03:17:45', '2018-12-04 14:40:19', 1, '2018-09-29 11:46:56', 1),
(93, '2015302002', '10f476d580672fa50834afc08b16bcb2ff696969', 'Ahd Muhajir', 3, '2', '34', 0, 1, '2018-10-08 10:25:33', '2018-11-08 10:40:17', 1, '2018-10-08 13:12:16', 1),
(91, '2015302009', 'e98def242dbd2a0940256cadaa614d9a8154fe2a', 'Fahrul Razi', 3, '2', '34', 0, 1, '2018-10-08 08:48:33', '2018-10-08 08:48:52', 1, '2018-10-08 12:56:40', 1),
(92, '2015302001', '0678e128b16207f2a7c134ea46e0a096fb7312ab', 'Ade Irwanda', 3, '2', '34', 0, 1, '2018-10-08 09:12:09', '2018-10-08 13:09:39', NULL, NULL, 1),
(90, '2015302021', 'c2b6d881dc1c16a3193aa8a48ecbcfe9df0b3b6e', 'Reza Aulya', 3, '2', '34', 0, 1, '2018-10-08 06:58:09', '2018-11-27 08:54:16', NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_angkatan`
--
ALTER TABLE `master_angkatan`
  ADD PRIMARY KEY (`id_angkatan`);

--
-- Indexes for table `master_level`
--
ALTER TABLE `master_level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `master_main_menu`
--
ALTER TABLE `master_main_menu`
  ADD PRIMARY KEY (`main_id`);

--
-- Indexes for table `master_menu`
--
ALTER TABLE `master_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `master_tahun_ajaran`
--
ALTER TABLE `master_tahun_ajaran`
  ADD PRIMARY KEY (`id_tahun_ajaran`);

--
-- Indexes for table `master_unit`
--
ALTER TABLE `master_unit`
  ADD PRIMARY KEY (`id_master_unit`);

--
-- Indexes for table `master_upload_data`
--
ALTER TABLE `master_upload_data`
  ADD PRIMARY KEY (`id_upload`);

--
-- Indexes for table `master_user`
--
ALTER TABLE `master_user`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_username` (`u_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_angkatan`
--
ALTER TABLE `master_angkatan`
  MODIFY `id_angkatan` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `master_main_menu`
--
ALTER TABLE `master_main_menu`
  MODIFY `main_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `master_menu`
--
ALTER TABLE `master_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `master_tahun_ajaran`
--
ALTER TABLE `master_tahun_ajaran`
  MODIFY `id_tahun_ajaran` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `master_unit`
--
ALTER TABLE `master_unit`
  MODIFY `id_master_unit` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `master_upload_data`
--
ALTER TABLE `master_upload_data`
  MODIFY `id_upload` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `master_user`
--
ALTER TABLE `master_user`
  MODIFY `u_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
