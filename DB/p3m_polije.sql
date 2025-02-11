-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 24, 2020 at 10:49 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `p3m_polije`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_anggota_dosen`
--

CREATE TABLE `tb_anggota_dosen` (
  `id_anggota` int(11) NOT NULL,
  `NIDSN` int(11) NOT NULL,
  `fokus_penelitian` varchar(100) NOT NULL,
  `id_sinta` int(11) NOT NULL,
  `file_cv` varchar(100) NOT NULL,
  `id_pengajuan_proposal` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_anggota_dosen`
--

INSERT INTO `tb_anggota_dosen` (`id_anggota`, `NIDSN`, `fokus_penelitian`, `id_sinta`, `file_cv`, `id_pengajuan_proposal`, `created_date`, `updated_date`) VALUES
(40, 1234561234, '242424', 42424, 'cv_1234561234_2020-04-20.pdfbus2.pdf', 18, '2020-04-20 00:00:00', '0000-00-00 00:00:00'),
(41, 2121212125, '123123', 123, 'cv_2121212125_2020-04-20.pdfbus.pdf', 18, '2020-04-20 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_anggota_mhs`
--

CREATE TABLE `tb_anggota_mhs` (
  `id_anggota` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `prodi` varchar(50) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `tahun_angkatan` year(4) NOT NULL,
  `id_pengajuan_proposal` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_anggota_mhs`
--

INSERT INTO `tb_anggota_mhs` (`id_anggota`, `nama`, `nim`, `prodi`, `jurusan`, `tahun_angkatan`, `id_pengajuan_proposal`, `created_date`, `updated_date`) VALUES
(25, 'Muhammad irfan', 'E41171111', 'TIF', 'Teknologi Informasi', 2017, 18, '2020-04-20 00:00:00', '0000-00-00 00:00:00'),
(26, 'Niko Wahyu', 'E412124', 'PERKOMPUTER', 'AMD', 2017, 18, '2020-04-20 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_event`
--

CREATE TABLE `tb_detail_event` (
  `id_detail_event` int(4) NOT NULL,
  `id_tahapan` int(2) NOT NULL,
  `id_jenis_event` int(2) NOT NULL,
  `waktu_mulai` date NOT NULL,
  `waktu_akhir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_dummy_dosen`
--

CREATE TABLE `tb_dummy_dosen` (
  `NIDSN` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `pangkat` varchar(50) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `jurusan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_dummy_dosen`
--

INSERT INTO `tb_dummy_dosen` (`NIDSN`, `email`, `password`, `nama_dosen`, `pangkat`, `jabatan`, `jurusan`) VALUES
(1234561234, 'dosen1@gmail.com', '$2y$10$waF/TBjs0nwnTvngwWQ6RubzwY9KRFj.745nlc8.JkDPM3xLJ1tFK', 'ini dosen 1', 'pns tingkat 3', 'sekertaris', 1),
(2121212123, 'dosen3@gmail.com', '$2y$10$waF/TBjs0nwnTvngwWQ6RubzwY9KRFj.745nlc8.JkDPM3xLJ1tFK', 'ini dosen 3', 'pns tingkat 2', 'bendahara 1', 2),
(2121212124, 'dosen4@gmail.com', '$2y$10$waF/TBjs0nwnTvngwWQ6RubzwY9KRFj.745nlc8.JkDPM3xLJ1tFK', 'ini dosen 4', 'pns tingkat 1', 'Kabag Kemahasiswaan', 3),
(2121212125, 'dosen5@gmail.com', '$2y$10$waF/TBjs0nwnTvngwWQ6RubzwY9KRFj.745nlc8.JkDPM3xLJ1tFK', 'ini dosen 5', 'pns tingkat 3', 'Kabag Pendidikan', 2),
(2121212126, 'dosen6@gmail.com', '$2y$10$waF/TBjs0nwnTvngwWQ6RubzwY9KRFj.745nlc8.JkDPM3xLJ1tFK', 'ini dosen 6', 'pns tingkat 2', 'WaKabag Kemahasiswaan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_dummy_jurusan`
--

CREATE TABLE `tb_dummy_jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_dummy_jurusan`
--

INSERT INTO `tb_dummy_jurusan` (`id_jurusan`, `nama_jurusan`, `created_date`, `updated_date`) VALUES
(1, 'Teknologi Informasi', '2020-04-02 00:00:00', '2020-04-10 00:00:00'),
(2, 'Rekam Medik', '2020-04-14 00:00:00', '2020-04-24 00:00:00'),
(3, 'Peternakan', '2020-04-08 00:00:00', '2020-04-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_event`
--

CREATE TABLE `tb_event` (
  `id_event` int(11) NOT NULL,
  `nama_event` varchar(50) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `jenis_event` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_event`
--

INSERT INTO `tb_event` (`id_event`, `nama_event`, `tanggal_mulai`, `tanggal_selesai`, `jenis_event`, `created_date`, `updated_date`) VALUES
(1, 'mememem', '2020-03-16', '2020-04-27', 'Penelitian Dosen PNBP', '2020-03-24 14:26:43', '2020-03-24 14:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `tb_fokus_penelitian`
--

CREATE TABLE `tb_fokus_penelitian` (
  `id_fokus_penelitian` int(2) NOT NULL,
  `bidang_fokus` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_fokus_penelitian`
--

INSERT INTO `tb_fokus_penelitian` (`id_fokus_penelitian`, `bidang_fokus`) VALUES
(1, 'Ketahanan dan Keamanan Pangan'),
(2, 'Teknologi Informasi dan Komunikasi'),
(3, 'Diversifikasi dan Konservasi Energi'),
(4, 'Sosial Humaniora');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis_event`
--

CREATE TABLE `tb_jenis_event` (
  `id_jenis_event` int(2) NOT NULL,
  `pendanaan` varchar(15) NOT NULL,
  `event` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jenis_event`
--

INSERT INTO `tb_jenis_event` (`id_jenis_event`, `pendanaan`, `event`) VALUES
(1, 'Mandiri', 'Penelitian'),
(2, 'Mandiri', 'Pengabdian'),
(3, 'PNBP', 'Penelitian'),
(4, 'PNBP', 'Pengabdian');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kerjaan_detail`
--

CREATE TABLE `tb_kerjaan_detail` (
  `id_kerjaan_detail` int(11) NOT NULL,
  `id_kerjaan` int(11) NOT NULL,
  `id_reviewer` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kerjaan_reviewer`
--

CREATE TABLE `tb_kerjaan_reviewer` (
  `id_kerjaan` int(11) NOT NULL,
  `id_reviewer` int(11) NOT NULL,
  `id_pengajuan_proposal` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kerjaan_reviewer`
--

INSERT INTO `tb_kerjaan_reviewer` (`id_kerjaan`, `id_reviewer`, `id_pengajuan_proposal`, `created_date`, `updated_date`) VALUES
(1, 21, 18, '2020-04-22 00:00:00', '2020-04-22 00:00:00'),
(2, 22, 18, '2020-04-22 00:00:00', '2020-04-22 00:00:00'),
(3, 21, 18, '2020-04-22 00:00:00', '2020-04-22 00:00:00'),
(4, 21, 18, '2020-04-22 00:00:00', '2020-04-22 00:00:00'),
(6, 24, 18, '2020-04-23 12:45:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_level_user`
--

CREATE TABLE `tb_level_user` (
  `id_level` tinyint(1) NOT NULL,
  `nm_level` varchar(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_level_user`
--

INSERT INTO `tb_level_user` (`id_level`, `nm_level`, `created_date`, `updated_date`) VALUES
(1, 'SUPERADMIN', '2020-03-13 19:26:37', '2020-03-13 19:26:37'),
(2, 'ADMIN', '2020-03-13 19:27:39', '2020-03-13 19:27:39'),
(3, 'DOSEN', '2020-03-14 20:23:38', '2020-03-14 20:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengajuan_proposal`
--

CREATE TABLE `tb_pengajuan_proposal` (
  `id_pengajuan_proposal` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `NIDSN_ketua` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `tahun_usulan` year(4) NOT NULL,
  `tanggal_mulai_kgt` date NOT NULL,
  `tanggal_akhir_kgt` date NOT NULL,
  `biaya` int(11) NOT NULL,
  `target_capaian` varchar(50) NOT NULL,
  `status_tkt` int(11) NOT NULL,
  `file_proposal` varchar(50) NOT NULL,
  `file_rab` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pengajuan_proposal`
--

INSERT INTO `tb_pengajuan_proposal` (`id_pengajuan_proposal`, `id_event`, `NIDSN_ketua`, `judul`, `tahun_usulan`, `tanggal_mulai_kgt`, `tanggal_akhir_kgt`, `biaya`, `target_capaian`, `status_tkt`, `file_proposal`, `file_rab`, `created_date`, `updated_date`) VALUES
(18, 1, 1234561234, 'Pendeteksi Hp Palsu Menggunakan Mikro Kontroller', 2020, '1999-07-11', '1999-07-11', 2000000, 'Penelitian International', 5, 'proposal_pendeteksi_hp_palsu_menggunakan_mikro_kon', 'rab_pendeteksi_hp_palsu_menggunakan_mikro_kontroll', '2020-04-20 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_penilaian_proposal`
--

CREATE TABLE `tb_penilaian_proposal` (
  `id_nilai` int(11) NOT NULL,
  `id_pengajuan_proposal` int(11) NOT NULL,
  `nilai` varchar(50) NOT NULL,
  `id_reviewer` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_permintaan_anggota`
--

CREATE TABLE `tb_permintaan_anggota` (
  `id_permintaan_anggota` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_pengajuan_proposal` int(11) NOT NULL,
  `status_permintaan` int(1) NOT NULL,
  `status_notifikasi` int(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_permintaan_anggota`
--

INSERT INTO `tb_permintaan_anggota` (`id_permintaan_anggota`, `id_anggota`, `id_pengajuan_proposal`, `status_permintaan`, `status_notifikasi`, `created_at`) VALUES
(7, 40, 18, 1, 1, '2020-04-20 11:53:29'),
(8, 41, 18, 0, 0, '2020-04-20 11:53:29');

-- --------------------------------------------------------

--
-- Table structure for table `tb_reviewer`
--

CREATE TABLE `tb_reviewer` (
  `id_reviewer` int(11) NOT NULL,
  `NIDSN` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_reviewer`
--

INSERT INTO `tb_reviewer` (`id_reviewer`, `NIDSN`, `created_date`, `updated_date`) VALUES
(21, 2121212124, '2020-04-22 10:01:06', '0000-00-00 00:00:00'),
(22, 2121212125, '2020-04-22 10:01:06', '0000-00-00 00:00:00'),
(24, 2121212126, '2020-04-23 12:45:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_soal`
--

CREATE TABLE `tb_soal` (
  `id_soal` int(5) NOT NULL,
  `id_jenis_soal` int(1) NOT NULL,
  `id_pengajuan_proposal` int(11) NOT NULL,
  `id_reviewer` int(11) NOT NULL,
  `jawaban` varchar(3) NOT NULL,
  `score` int(2) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_soal`
--

INSERT INTO `tb_soal` (`id_soal`, `id_jenis_soal`, `id_pengajuan_proposal`, `id_reviewer`, `jawaban`, `score`, `created_date`, `updated_date`) VALUES
(17, 0, 18, 2, '1b', 5, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(18, 0, 18, 2, '2d', 15, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(19, 0, 18, 2, '3d', 20, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(20, 0, 18, 2, '4c', 10, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(21, 0, 18, 2, '5a', 0, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(22, 1, 18, 2, '1b', 10, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(23, 1, 18, 2, '2b', 3, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(24, 1, 18, 2, '3b', 3, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(25, 1, 18, 2, '4b', 20, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(26, 1, 18, 2, '5e', 10, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(27, 1, 18, 2, '6b', 5, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(28, 1, 18, 2, '7b', 5, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(29, 1, 18, 2, '8c', 5, '2020-04-19 15:28:57', '2020-04-19 15:28:57'),
(30, 1, 18, 2, '9c', 10, '2020-04-19 15:28:57', '2020-04-19 15:28:57');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tahapan`
--

CREATE TABLE `tb_tahapan` (
  `id_tahapan` int(2) NOT NULL,
  `nama_tahapan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_tahapan`
--

INSERT INTO `tb_tahapan` (`id_tahapan`, `nama_tahapan`) VALUES
(1, 'Sosialisasi Proposal'),
(2, 'Penerimaan Proposal'),
(3, 'Review Proposal'),
(4, 'Pengumuman hasil'),
(5, 'Pelaksanaan kegiatan'),
(6, 'monev 1'),
(7, 'monev 2'),
(8, 'Laporan'),
(9, 'Laporan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tema`
--

CREATE TABLE `tb_tema` (
  `id_tema` tinyint(4) NOT NULL,
  `nm_tema` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `id_level` tinyint(1) NOT NULL,
  `is_reviewer` tinyint(1) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `id_level`, `is_reviewer`, `nama`, `username`, `password`, `created_date`, `updated_date`) VALUES
(1, 2, 0, 'ADMIN', 'admin', '$2y$10$kkpV2oKrs9APhK0YaMYl4OSydLD90Qgd2xsQyCLuLJoYht./rPa0S', '2020-03-13 00:00:00', '2020-03-13 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_anggota_dosen`
--
ALTER TABLE `tb_anggota_dosen`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `tb_anggota_mhs`
--
ALTER TABLE `tb_anggota_mhs`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `tb_detail_event`
--
ALTER TABLE `tb_detail_event`
  ADD PRIMARY KEY (`id_detail_event`);

--
-- Indexes for table `tb_dummy_dosen`
--
ALTER TABLE `tb_dummy_dosen`
  ADD PRIMARY KEY (`NIDSN`);

--
-- Indexes for table `tb_dummy_jurusan`
--
ALTER TABLE `tb_dummy_jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `tb_fokus_penelitian`
--
ALTER TABLE `tb_fokus_penelitian`
  ADD PRIMARY KEY (`id_fokus_penelitian`);

--
-- Indexes for table `tb_jenis_event`
--
ALTER TABLE `tb_jenis_event`
  ADD PRIMARY KEY (`id_jenis_event`);

--
-- Indexes for table `tb_kerjaan_detail`
--
ALTER TABLE `tb_kerjaan_detail`
  ADD PRIMARY KEY (`id_kerjaan_detail`);

--
-- Indexes for table `tb_kerjaan_reviewer`
--
ALTER TABLE `tb_kerjaan_reviewer`
  ADD PRIMARY KEY (`id_kerjaan`);

--
-- Indexes for table `tb_level_user`
--
ALTER TABLE `tb_level_user`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `tb_pengajuan_proposal`
--
ALTER TABLE `tb_pengajuan_proposal`
  ADD PRIMARY KEY (`id_pengajuan_proposal`);

--
-- Indexes for table `tb_penilaian_proposal`
--
ALTER TABLE `tb_penilaian_proposal`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `tb_permintaan_anggota`
--
ALTER TABLE `tb_permintaan_anggota`
  ADD PRIMARY KEY (`id_permintaan_anggota`);

--
-- Indexes for table `tb_reviewer`
--
ALTER TABLE `tb_reviewer`
  ADD PRIMARY KEY (`id_reviewer`);

--
-- Indexes for table `tb_soal`
--
ALTER TABLE `tb_soal`
  ADD PRIMARY KEY (`id_soal`);

--
-- Indexes for table `tb_tahapan`
--
ALTER TABLE `tb_tahapan`
  ADD PRIMARY KEY (`id_tahapan`);

--
-- Indexes for table `tb_tema`
--
ALTER TABLE `tb_tema`
  ADD PRIMARY KEY (`id_tema`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_anggota_dosen`
--
ALTER TABLE `tb_anggota_dosen`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tb_anggota_mhs`
--
ALTER TABLE `tb_anggota_mhs`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tb_detail_event`
--
ALTER TABLE `tb_detail_event`
  MODIFY `id_detail_event` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_dummy_jurusan`
--
ALTER TABLE `tb_dummy_jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_fokus_penelitian`
--
ALTER TABLE `tb_fokus_penelitian`
  MODIFY `id_fokus_penelitian` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_jenis_event`
--
ALTER TABLE `tb_jenis_event`
  MODIFY `id_jenis_event` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_kerjaan_detail`
--
ALTER TABLE `tb_kerjaan_detail`
  MODIFY `id_kerjaan_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kerjaan_reviewer`
--
ALTER TABLE `tb_kerjaan_reviewer`
  MODIFY `id_kerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_level_user`
--
ALTER TABLE `tb_level_user`
  MODIFY `id_level` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_pengajuan_proposal`
--
ALTER TABLE `tb_pengajuan_proposal`
  MODIFY `id_pengajuan_proposal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_penilaian_proposal`
--
ALTER TABLE `tb_penilaian_proposal`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_permintaan_anggota`
--
ALTER TABLE `tb_permintaan_anggota`
  MODIFY `id_permintaan_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_reviewer`
--
ALTER TABLE `tb_reviewer`
  MODIFY `id_reviewer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tb_soal`
--
ALTER TABLE `tb_soal`
  MODIFY `id_soal` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tb_tahapan`
--
ALTER TABLE `tb_tahapan`
  MODIFY `id_tahapan` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_tema`
--
ALTER TABLE `tb_tema`
  MODIFY `id_tema` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
