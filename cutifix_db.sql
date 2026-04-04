-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2020 at 06:06 AM
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
-- Database: `cutifix_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_keluarga`
--

CREATE TABLE `data_keluarga` (
  `id_keluarga` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `nama_keluarga` text NOT NULL,
  `posisi_keluarga` text NOT NULL,
  `tempat_lahir_keluarga` text NOT NULL,
  `tgl_lahir_keluarga` date NOT NULL,
  `alamat_keluarga` text NOT NULL,
  `telp_keluarga` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_keluarga`
--

INSERT INTO `data_keluarga` (`id_keluarga`, `karyawan_id`, `nama_keluarga`, `posisi_keluarga`, `tempat_lahir_keluarga`, `tgl_lahir_keluarga`, `alamat_keluarga`, `telp_keluarga`) VALUES
(1, 64, 'Ratna Damayanti', 'Istri', 'Magelang', '1982-12-13', 'Jln Dewi Sartika no 45', '089668223378'),
(2, 64, 'Adonia Vincent Natanael', 'Anak', 'Magelang', '2003-01-02', 'Jln Dewi Sartika no 45', '08995676543');

-- --------------------------------------------------------

--
-- Table structure for table `data_pegawai`
--

CREATE TABLE `data_pegawai` (
  `id_karyawan` int(11) NOT NULL,
  `pegawai_id` int(11) NOT NULL,
  `telp` text NOT NULL,
  `nama_sekolah` text DEFAULT NULL,
  `jurusan` text DEFAULT NULL,
  `tahun_lulus` text DEFAULT NULL,
  `nama_jenjang` text DEFAULT NULL,
  `kota_lahir` text DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `agama` text DEFAULT NULL,
  `status_nikah` text DEFAULT NULL,
  `jenis_kelamin` text DEFAULT NULL,
  `gol_darah` text DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `data_pegawai`
--

INSERT INTO `data_pegawai` (`id_karyawan`, `pegawai_id`, `telp`, `nama_sekolah`, `jurusan`, `tahun_lulus`, `nama_jenjang`, `kota_lahir`, `tgl_lahir`, `agama`, `status_nikah`, `jenis_kelamin`, `gol_darah`, `alamat`) VALUES
(1327, 64, '08995625604', 'SMU 1 KUDUS', 'IPS', '1998', 'SMU', 'Kudus', '1979-05-14', 'Kristen', 'Menikah', 'Laki-Laki', 'B', 'Jl. Dewi Sartika no 45 '),
(1328, 61, '08995625604', 'SMU 1 KUDUS', 'IPS', '1998', 'SMU', 'Kudus', '2020-04-05', 'Islam', 'Menikah', 'Laki-Laki', 'O', 'Kojan rt 02 rw 01');

-- --------------------------------------------------------

--
-- Table structure for table `formcuti_lain`
--

CREATE TABLE `formcuti_lain` (
  `id` int(11) NOT NULL,
  `kode_unik2` varchar(250) NOT NULL,
  `id_user` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `tgl_input` date NOT NULL,
  `nik` text NOT NULL,
  `nama` text NOT NULL,
  `jabatan` text NOT NULL,
  `bagian` text NOT NULL,
  `keterangan` text NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `jenis_cuti` text NOT NULL,
  `telp` text NOT NULL,
  `cuti` date NOT NULL,
  `cuti2` date NOT NULL,
  `masuk` date NOT NULL,
  `atasan` text NOT NULL,
  `is_approve` int(11) NOT NULL,
  `kabag` text NOT NULL,
  `nama_kabag` text NOT NULL,
  `direktur` text NOT NULL,
  `nama_direktur` text NOT NULL,
  `alasan_ditolak` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `formcuti_lain`
--

INSERT INTO `formcuti_lain` (`id`, `kode_unik2`, `id_user`, `role_id`, `tgl_input`, `nik`, `nama`, `jabatan`, `bagian`, `keterangan`, `alamat`, `jenis_cuti`, `telp`, `cuti`, `cuti2`, `masuk`, `atasan`, `is_approve`, `kabag`, `nama_kabag`, `direktur`, `nama_direktur`, `alasan_ditolak`) VALUES
(14, '20200405142726CTL0001', 55, 4, '2020-04-05', '123456789', 'Donny Kurniawan', 'Staf', 'Keuangan', 'Cuti Bebas', 'Panjang RT/RW : 01/01', 'Cuti Lain', '08995625604', '2020-04-21', '2020-04-19', '2020-04-23', 'Donny Kurniawan', 1, 'Keuangan', 'Haryo Sujono', 'Keuangan', 'Gilang Ramadhan', ''),
(15, '20200405161924CTL0002', 54, 3, '2020-04-05', '12345678', 'Donny Kurniawan', 'Kepala Urusan', 'Keuangan', 'Studi Banding - Edit', 'Kojan rt 02 rw 01', 'Cuti Lain', '08995625604', '2020-04-20', '2020-04-05', '2020-04-13', '', 0, '', '', '', '', ''),
(16, '20200405163039CTL0003', 54, 3, '2020-04-05', '12345678', 'Donny Kurniawan', 'Kepala Urusan', 'Keuangan', 'Cek dan Ricek', 'Kojan rt 02 rw 01', 'Cuti Lain', '08995625604', '2020-04-28', '2020-04-22', '2020-04-01', '', 1, '', '', '', '', ''),
(17, '20200407021631CTL0004', 54, 3, '2020-04-07', '12345678', 'Donny Kurniawan', 'Kepala Urusan', 'Keuangan', 'Acara Khajatan', 'Kojan rt 02 rw 01', 'Cuti Lain', '08995625604', '2020-04-08', '2020-04-07', '2020-04-07', '', 1, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `form_cuti`
--

CREATE TABLE `form_cuti` (
  `id` int(11) NOT NULL,
  `kode_unik` varchar(250) NOT NULL,
  `id_user` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `input` date NOT NULL,
  `nik` int(11) NOT NULL,
  `nama` text NOT NULL,
  `bagian` text NOT NULL,
  `jabatan` varchar(250) NOT NULL,
  `jenis_cuti` text NOT NULL,
  `keterangan` text NOT NULL,
  `jml_cuti` int(11) NOT NULL,
  `sisa_cuti` int(11) NOT NULL,
  `cuti` date NOT NULL,
  `cuti2` date NOT NULL,
  `masuk` date NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `telp` varchar(30) NOT NULL,
  `atasan` varchar(150) NOT NULL,
  `alasan_ditolak` text NOT NULL,
  `nama_kabid` text NOT NULL,
  `is_approve` int(1) NOT NULL COMMENT '0 = Terima, 1 = Tunggu, 2 = Tolak'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `form_cuti`
--

INSERT INTO `form_cuti` (`id`, `kode_unik`, `id_user`, `role_id`, `input`, `nik`, `nama`, `bagian`, `jabatan`, `jenis_cuti`, `keterangan`, `jml_cuti`, `sisa_cuti`, `cuti`, `cuti2`, `masuk`, `alamat`, `telp`, `atasan`, `alasan_ditolak`, `nama_kabid`, `is_approve`) VALUES
(58, '20200405142656CT0001', 55, 4, '2020-04-05', 123456789, 'Donny Kurniawan', 'Keuangan', 'Staf', 'Cuti Tahunan', 'Cuti Bebas', 3, 9, '2020-04-06', '2020-04-14', '2020-04-17', 'Panjang RT/RW : 01/01', '08995625604', 'Donny Kurniawan', 'Kekurangan Tenaga ', 'Ratna Damayanti, Spd', 0),
(61, '20200405161025CT0002', 54, 3, '2020-04-05', 12345678, 'Donny Kurniawan', 'Keuangan', 'Kepala Urusan', 'Cuti Tahunan', 'Coba dan mencoba', 4, 8, '2020-04-05', '2020-04-07', '2020-04-08', 'Kojan rt 02 rw 01', '08995625604', '', '', '', 0),
(62, '20200407021613CT0003', 54, 3, '2020-04-07', 12345678, 'Donny Kurniawan', 'Keuangan', 'Kepala Urusan', 'Cuti Tahunan', 'Coba dan mencoba', 3, 5, '2020-04-07', '2020-04-07', '2020-04-07', 'Kojan rt 02 rw 01', '08995625604', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `history_cuti`
--

CREATE TABLE `history_cuti` (
  `id` int(11) NOT NULL,
  `kode_unik` varchar(250) NOT NULL,
  `id_user` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `input` date NOT NULL,
  `nik` int(11) NOT NULL,
  `nama` text NOT NULL,
  `bagian` text NOT NULL,
  `jabatan` varchar(250) NOT NULL,
  `jenis_cuti` text NOT NULL,
  `keterangan` text NOT NULL,
  `jml_cuti` int(11) NOT NULL,
  `sisa_cuti` int(11) NOT NULL,
  `cuti` date NOT NULL,
  `cuti2` date NOT NULL,
  `masuk` date NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `telp` varchar(30) NOT NULL,
  `atasan` varchar(150) NOT NULL,
  `alasan_ditolak` text NOT NULL,
  `nama_kabid` text NOT NULL,
  `is_approve` int(1) NOT NULL COMMENT '0 = Terima, 1 = Tunggu, 2 = Tolak'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history_cuti`
--

INSERT INTO `history_cuti` (`id`, `kode_unik`, `id_user`, `role_id`, `input`, `nik`, `nama`, `bagian`, `jabatan`, `jenis_cuti`, `keterangan`, `jml_cuti`, `sisa_cuti`, `cuti`, `cuti2`, `masuk`, `alamat`, `telp`, `atasan`, `alasan_ditolak`, `nama_kabid`, `is_approve`) VALUES
(56, '20200405140144CT0001', 55, 4, '2019-04-05', 123456789, 'Donny Kurniawan', 'Keuangan', 'Staf', 'Cuti Tahunan', 'Cuti Bebas', 12, 0, '2020-04-07', '2020-04-07', '2020-04-06', 'Panjang RT/RW : 01/01', '08995625604', '', '', '', 1),
(57, '20200405140342CT0001', 55, 4, '2020-04-05', 123456789, 'Donny Kurniawan', 'Keuangan', 'Staf', 'Cuti Tahunan', 'Cuti Bebas', 12, 0, '2020-04-13', '2020-04-13', '2020-04-13', 'Jl. Dewi Sartika no 45 -edit', '08995625604', '', '', '', 1),
(58, '20200405140342CT0001', 55, 4, '2018-04-04', 123456789, 'Donny Kurniawan', 'Keuangan', 'Staf', 'Cuti Tahunan', 'Cuti Bebas', 12, 0, '2020-04-13', '2020-04-13', '2020-04-13', 'Jl. Dewi Sartika no 45 -edit', '08995625604', '', '', '', 1),
(59, '20200405140342CT0001', 54, 4, '2018-04-04', 123456789, 'Donny Kurniawan', 'Keuangan', 'Kepala Urusan', 'Cuti Tahunan', 'Cuti Bebas', 12, 0, '2020-04-13', '2020-04-13', '2020-04-13', 'Jl. Dewi Sartika no 45 -edit', '08995625604', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_user`
--

CREATE TABLE `mst_user` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `jabatan` varchar(128) NOT NULL,
  `bagian` varchar(128) NOT NULL,
  `nik` varchar(250) NOT NULL,
  `image` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `date_created` date NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_user`
--

INSERT INTO `mst_user` (`id`, `nama`, `jabatan`, `bagian`, `nik`, `image`, `username`, `password`, `date_created`, `role_id`, `is_active`) VALUES
(9, 'Donny Kurniawan', 'Admin', 'EDP', '18030110', 'avatar4.png', 'admin', '$2y$10$dR5WhOrVZW/n/zNoBuOYZOzV5TYZnsFl2FenIjwK7U8dbpSEujiMq', '0000-00-00', 1, 1),
(59, 'Permana', 'Staf', 'Front Office', '0111844', 'default.jpg', 'permana', '$2y$10$SauLMIxjf7MVDS.8C2L8yOmfsJBpdEg.uKfD25aT4vBa9hzUabRJ2', '2020-04-03', 4, 1),
(58, 'Andini', 'Staf', '', '65432345', 'default.jpg', 'andini', '$2y$10$9iCyUPRGGuoBsJ/yr2KTmuv5Fs8MHSlifdcFGoWBSQ5co.FcH4DGu', '2020-04-03', 4, 0),
(57, 'Paijo', 'Staf', 'SDM', '54321', 'default.jpg', 'paijo', '$2y$10$6IeRE3sQ8DixnBxcsVzdeO5g6Wt0OTZEYUSbXTXEzsvbppQQwUXWC', '2020-04-02', 2, 1),
(56, 'Donny Kurniawan', 'Staf', 'SDM', '87654321', 'avatar52.png', 'sdm', '$2y$10$IsYum9poMjzb.ZMNKeZgyunYP7elE3NYGVvGY6GrwZBKJrwkuEnei', '0000-00-00', 2, 1),
(55, 'Donny Kurniawan', 'Staf', 'Keuangan', '123456789', 'avatar6.png', 'staf', '$2y$10$2iPnjNPAtUTsE4wR09iVsOGlCS69bCALN7A7Az4j13NNMrYVCWTSS', '0000-00-00', 4, 1),
(54, 'Donny Kurniawan', 'Kepala Urusan', 'Keuangan', '12345678', 'avatar04.png', 'kaur', '$2y$10$HspvVdfj4YwDXYgPWpKLgeDxRmzolsuqegOHmH7Fqqbn4YOgPQ3ue', '0000-00-00', 3, 1),
(60, 'Auntis', 'Staf', 'Keuangan', '9874566321', 'default.jpg', 'auntis', '$2y$10$X5Ml0H6pO3KgSFiuQERbYeFQyHpC1XkwxXJNh.L2kZo/OSf4Pq32y', '2020-04-03', 3, 1),
(61, 'Harjo Waringin, SPd', 'Staf', 'Keuangan', '5432345', 'default.jpg', 'harjo', '$2y$10$82pJDQldR8CeGvxFUh26g.hnxpNLD5.5IYsFNHgUf6EzliLSxQuxi', '2020-04-03', 4, 1),
(64, 'Donny Kurniawan', 'Staf', 'Keuangan', 'PEG-2019-0003', 'default.jpg', '12345', '$2y$10$WDbWm3oEMV5tnlgZtdD4Z.f/BIWZqlVHUxMPqzmHdnIkb4rvfSczO', '2020-04-03', 4, 1),
(65, 'Donny Kurniawan', 'Staf', 'Security', 'PEG-2020-0004', 'default.jpg', 'security', '$2y$10$M0DP4Y2ndIXy2O9YPdXtbuiMSFCcPBCe2zDeedLdyjxmAO24a3vNO', '2020-04-11', 4, 1),
(66, 'Donny Kurniawan', 'Kepala Urusan', 'Security', 'PEG-2020-0005', 'default.jpg', 'kepala', '$2y$10$TAvA5nJ5XciZs85qQADgA.UpTNf27IYnboMtAdJ1LukgJOd0TJOI6', '2020-04-11', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 4, 4),
(4, 2, 2),
(5, 3, 3),
(12, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(0, 'Menu'),
(1, 'Admin'),
(2, 'Sdm'),
(3, 'Kaur'),
(4, 'Staf');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Sdm'),
(3, 'Kaur'),
(4, 'Staf');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Beranda', 'admin', 'fas fa-fw fa-home', 1),
(2, 4, 'Dashboard', 'staf', 'fas fa-fw fa-home', 1),
(17, 4, 'Input Cuti', 'staf/add_cuti', 'far fa-fw fa-edit', 1),
(18, 3, 'Dashboard', 'kaur', 'fas fa-fw fa-home', 1),
(19, 3, 'Input Cuti', 'kaur/add_cuti', 'far fa-fw fa-edit', 1),
(20, 3, 'Tambah User', 'kaur/add_staf', 'fas fa-fw fa-user-plus', 0),
(21, 3, 'List Staf', 'kaur/list_staf', 'fas fa-fw fa-users', 1),
(22, 2, 'Beranda', 'sdm', 'fas fa-fw fa-home', 1),
(23, 2, 'Karyawan', 'sdm/list_kary', 'fas fa-fw fa-users', 1),
(24, 2, 'List Cuti', 'sdm/list_cuti_kary', 'far fa-fw fa-list-alt', 1),
(25, 2, 'List Cuti Lain', 'sdm/list_cuti_diluartanggungan_kary', 'far fa-fw fa-list-alt', 1),
(26, 4, 'History', 'staf/view_cutitahunan', 'fas fa-fw fa-history', 1),
(27, 3, 'History', 'kaur/view_cutitahunan', 'fas fa-fw fa-history', 1),
(28, 2, 'Approval', 'sdm/cuti_kaur', 'fas fa-fw fa-check-circle', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_keluarga`
--
ALTER TABLE `data_keluarga`
  ADD PRIMARY KEY (`id_keluarga`);

--
-- Indexes for table `data_pegawai`
--
ALTER TABLE `data_pegawai`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `formcuti_lain`
--
ALTER TABLE `formcuti_lain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_cuti`
--
ALTER TABLE `form_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_cuti`
--
ALTER TABLE `history_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_user`
--
ALTER TABLE `mst_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_keluarga`
--
ALTER TABLE `data_keluarga`
  MODIFY `id_keluarga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_pegawai`
--
ALTER TABLE `data_pegawai`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1329;

--
-- AUTO_INCREMENT for table `formcuti_lain`
--
ALTER TABLE `formcuti_lain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `form_cuti`
--
ALTER TABLE `form_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `history_cuti`
--
ALTER TABLE `history_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `mst_user`
--
ALTER TABLE `mst_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
