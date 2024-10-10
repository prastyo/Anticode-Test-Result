-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2024 at 10:45 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `master_desa`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_agama`
--

CREATE TABLE `data_agama` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_agama`
--

INSERT INTO `data_agama` (`id`, `nama`) VALUES
(5, 'Budha'),
(4, 'Hindu'),
(1, 'Islam'),
(3, 'Katholik'),
(7, 'Kepercayaan Terhadap Tuhan YME/Lainnya'),
(6, 'Khonghucu'),
(2, 'Kristen');

-- --------------------------------------------------------

--
-- Table structure for table `data_akseptor_kb`
--

CREATE TABLE `data_akseptor_kb` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_akseptor_kb`
--

INSERT INTO `data_akseptor_kb` (`id`, `nama`) VALUES
(2, 'IUD'),
(4, 'Kondom'),
(99, 'Lainnya'),
(1, 'Pil'),
(7, 'Sterilisasi Pria'),
(6, 'Sterilisasi Wanita'),
(3, 'Suntik'),
(5, 'Susuk KB');

-- --------------------------------------------------------

--
-- Table structure for table `data_asuransi`
--

CREATE TABLE `data_asuransi` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_asuransi`
--

INSERT INTO `data_asuransi` (`id`, `nama`) VALUES
(99, 'Asuransi Lainnya'),
(3, 'BPJS Non Penerima Bantuan Iuran'),
(2, 'BPJS Penerima Bantuan Iuran'),
(1, 'Tidak/Belum Punya');

-- --------------------------------------------------------

--
-- Table structure for table `data_bahasa`
--

CREATE TABLE `data_bahasa` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inisial` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_bahasa`
--

INSERT INTO `data_bahasa` (`id`, `nama`, `inisial`) VALUES
(1, 'Latin', 'L'),
(2, 'Daerah', 'D'),
(3, 'Arab', 'A'),
(4, 'Arab dan Latin', 'AL'),
(5, 'Arab dan Daerah', 'AD'),
(6, 'Arab, Latin dan Daerah', 'ALD');

-- --------------------------------------------------------

--
-- Table structure for table `data_cacat`
--

CREATE TABLE `data_cacat` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_cacat`
--

INSERT INTO `data_cacat` (`id`, `nama`) VALUES
(1, 'Cacat Fisik'),
(5, 'Cacat Fisik dan Mental'),
(6, 'Cacat Lainnya'),
(4, 'Cacat Mental/Jiwa'),
(2, 'Cacat Netra/Buta'),
(3, 'Cacat Rungu/Wicara'),
(7, 'Tidak Cacat');

-- --------------------------------------------------------

--
-- Table structure for table `data_golongan_darah`
--

CREATE TABLE `data_golongan_darah` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_golongan_darah`
--

INSERT INTO `data_golongan_darah` (`id`, `nama`) VALUES
(1, 'A'),
(5, 'A+'),
(6, 'A-'),
(3, 'AB'),
(9, 'AB+'),
(10, 'AB-'),
(2, 'B'),
(7, 'B+'),
(8, 'B-'),
(4, 'O'),
(11, 'O+'),
(12, 'O-'),
(13, 'Tidak Tahu');

-- --------------------------------------------------------

--
-- Table structure for table `data_hubungan_keluarga`
--

CREATE TABLE `data_hubungan_keluarga` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_hubungan_keluarga`
--

INSERT INTO `data_hubungan_keluarga` (`id`, `nama`) VALUES
(4, 'Anak'),
(6, 'Cucu'),
(9, 'Famili Lain'),
(3, 'Istri'),
(1, 'Kepala Keluarga'),
(11, 'Lainnya'),
(5, 'Menantu'),
(8, 'Mertua'),
(7, 'Orangtua'),
(10, 'Pembantu'),
(2, 'Suami');

-- --------------------------------------------------------

--
-- Table structure for table `data_jabatan`
--

CREATE TABLE `data_jabatan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_jabatan`
--

INSERT INTO `data_jabatan` (`id`, `nama`) VALUES
(3, 'Kaun Pemerintahan'),
(7, 'Kaur Keamanan dan Ketertiban'),
(5, 'Kaur Keuangan'),
(6, 'Kaur Pembangunan'),
(4, 'Kaur Umum'),
(1, 'Kepala Desa'),
(2, 'Sekretaris Desa');

-- --------------------------------------------------------

--
-- Table structure for table `data_jenis_persalinan`
--

CREATE TABLE `data_jenis_persalinan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_jenis_persalinan`
--

INSERT INTO `data_jenis_persalinan` (`id`, `nama`) VALUES
(3, 'Caesar'),
(2, 'Dibantu alat'),
(1, 'Normal'),
(4, 'Persalinan di air');

-- --------------------------------------------------------

--
-- Table structure for table `data_kawin`
--

CREATE TABLE `data_kawin` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_kawin`
--

INSERT INTO `data_kawin` (`id`, `nama`) VALUES
(1, 'Belum Kawin'),
(3, 'Cerai Hidup'),
(4, 'Cerai Mati'),
(2, 'Kawin');

-- --------------------------------------------------------

--
-- Table structure for table `data_kursus`
--

CREATE TABLE `data_kursus` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_kursus`
--

INSERT INTO `data_kursus` (`id`, `nama`) VALUES
(1, 'Kursus Komputer'),
(2, 'Kursus Menjahit'),
(3, 'Pelatihan Kelistrikan'),
(4, 'Kursus Mekanik Motor'),
(5, 'Pelatihan Security'),
(6, 'Kursus Otomotif'),
(7, 'Kursus Bahasa Inggris'),
(8, 'Kursus Tata Kecantikan Kulit'),
(9, 'Kursus Megemudi'),
(10, 'Kursus Tata Boga'),
(11, 'Kursus Meubeler'),
(12, 'Kursus Las'),
(13, 'Kursus Sablon'),
(14, 'Kursus Penerbangan'),
(15, 'Kursus Desain Interior'),
(16, 'Kursus Teknisi HP'),
(17, 'Kursus Garment'),
(18, 'Kursus Akupuntur'),
(19, 'Kursus Senam'),
(20, 'Kursus Pendidik PAUD'),
(21, 'Kursus Baby Sitter'),
(22, 'Kursus Desain Grafis'),
(23, 'Kursus Bahasa Indonesia'),
(24, 'Kursus Photografi'),
(25, 'Kursus Expor Impor'),
(26, 'Kursus Jurnalistik'),
(27, 'Kursus Bahasa Arab'),
(28, 'Kursus Bahasa Jepang'),
(29, 'Kursus Anak Buah Kapal'),
(30, 'Kursus Refleksi'),
(31, 'Kursus Akupuntur'),
(32, 'Kursus Perhotelan'),
(33, 'Kursus Tata Rias'),
(34, 'Kursus Administrasi Perkantoran'),
(35, 'Kursus Broadcasting'),
(36, 'Kursus Kerajinan Tangan'),
(37, 'Kursus Sosial Media Marketing'),
(38, 'Kursus Internet Marketing'),
(39, 'Kursus Sekretaris'),
(40, 'Kursus Perpajakan'),
(41, 'Kursus Publik Speaking'),
(42, 'Kursus Publik Relation'),
(43, 'Kursus Batik'),
(44, 'Kursus Pengobatan Tradisional');

-- --------------------------------------------------------

--
-- Table structure for table `data_pekerjaan`
--

CREATE TABLE `data_pekerjaan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_pekerjaan`
--

INSERT INTO `data_pekerjaan` (`id`, `nama`) VALUES
(1, 'Akuntan'),
(2, 'Anggota BPK'),
(3, 'Anggota DPD'),
(4, 'Anggota DPR-RI'),
(5, 'Anggota DPRD Kabupaten/Kota'),
(6, 'Anggota DPRD Provinsi'),
(7, 'Anggota Kabinet Kementerian'),
(8, 'Anggota Mahkamah Konstitusi'),
(9, 'Apoteker'),
(10, 'Arsitek'),
(11, 'Belum/Tidak Bekerja'),
(12, 'Biarawati'),
(13, 'Bidan'),
(14, 'Bupati'),
(15, 'Buruh Harian Lepas'),
(16, 'Buruh Nelayan/Perikanan'),
(17, 'Buruh Peternakan'),
(18, 'Buruh Tani/Perkebunan'),
(19, 'Dokter'),
(20, 'Dosen'),
(21, 'Duta Besar'),
(22, 'Gubernur'),
(23, 'Guru'),
(24, 'Imam Masjid'),
(25, 'Industri'),
(26, 'Juru Masak'),
(27, 'Karyawan BUMD'),
(28, 'Karyawan BUMN'),
(29, 'Karyawan Honorer'),
(30, 'Karyawan Swasta'),
(31, 'Kepala Desa'),
(32, 'Kepolisian RI (Polri)'),
(33, 'Konstruksi'),
(34, 'Konsultan'),
(35, 'Lainnya'),
(36, 'Mekanik'),
(37, 'Mengurus Rumah Tangga'),
(38, 'Nelayan/Perikanan'),
(39, 'Notaris'),
(40, 'Paraji'),
(41, 'Paranormal'),
(42, 'Pastor'),
(43, 'Pedagang'),
(44, 'Pegawai Negeri Sipil (PNS)'),
(45, 'Pelajar/Mahasiswa'),
(46, 'Pelaut'),
(47, 'Pembantu Rumah Tangga'),
(48, 'Penata Busana'),
(49, 'Penata Rambut'),
(50, 'Penata Rias'),
(51, 'Pendeta'),
(52, 'Peneliti'),
(53, 'Pengacara'),
(54, 'Pensiunan'),
(55, 'Penterjemah'),
(56, 'Penyiar Radio'),
(57, 'Penyiar Televisi'),
(58, 'Perancang Busana'),
(59, 'Perangkat Desa'),
(60, 'Perawat'),
(61, 'Perdagangan'),
(62, 'Petani/Pekebun'),
(63, 'Peternak'),
(64, 'Pialang'),
(65, 'Pilot'),
(66, 'Presiden'),
(67, 'Promotor Acara'),
(68, 'Psikiater/Psikolog'),
(69, 'Seniman'),
(70, 'Sopir'),
(71, 'Tabib'),
(72, 'Tentara Nasional Indonesia (TNI)'),
(73, 'Transportasi'),
(74, 'Tukang Batu'),
(75, 'Tukang Cukur'),
(76, 'Tukang Gigi'),
(77, 'Tukang Jahit'),
(78, 'Tukang Kayu'),
(79, 'Tukang Las/Pandai Besi'),
(80, 'Tukang Listrik'),
(81, 'Tukang Sol Sepatu'),
(82, 'Ustadz/Mubaligh'),
(83, 'Wakil Bupati'),
(84, 'Wakil Gubernur'),
(85, 'Wakil Presiden'),
(86, 'Wakil Walikota'),
(87, 'Walikota'),
(88, 'Wartawan'),
(89, 'Wiraswasta');

-- --------------------------------------------------------

--
-- Table structure for table `data_pendidikan`
--

CREATE TABLE `data_pendidikan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_pendidikan`
--

INSERT INTO `data_pendidikan` (`id`, `nama`) VALUES
(7, 'Akademi/Diploma III/S. Muda'),
(2, 'Belum Tamat SD/Sederajat'),
(6, 'Diploma I/II'),
(8, 'Diploma IV/Strata I'),
(5, 'SLTA/Sederajat'),
(4, 'SLTP/Sederajat'),
(9, 'Strata II'),
(10, 'Strata III'),
(3, 'Tamat SD/Sederajat'),
(1, 'Tidak/Belum Sekolah');

-- --------------------------------------------------------

--
-- Table structure for table `data_penolong_kelahiran`
--

CREATE TABLE `data_penolong_kelahiran` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_penolong_kelahiran`
--

INSERT INTO `data_penolong_kelahiran` (`id`, `nama`) VALUES
(1, 'Dokter'),
(2, 'Bidan Perawat'),
(3, 'Dukun'),
(4, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `data_sakit_menahun`
--

CREATE TABLE `data_sakit_menahun` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_sakit_menahun`
--

INSERT INTO `data_sakit_menahun` (`id`, `nama`) VALUES
(13, 'Asthma'),
(6, 'Diabetes Melitus'),
(11, 'Gila/Setres'),
(7, 'Ginjal'),
(10, 'HIV/AIDS'),
(1, 'Jantung'),
(4, 'Kanker'),
(9, 'Lepra/Kusta'),
(2, 'Lever'),
(8, 'Malaria'),
(3, 'Paru-Paru'),
(5, 'Stroke'),
(12, 'TBC'),
(14, 'Tidak Ada/Tidak Sakit');

-- --------------------------------------------------------

--
-- Table structure for table `data_status_dasar`
--

CREATE TABLE `data_status_dasar` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_status_dasar`
--

INSERT INTO `data_status_dasar` (`id`, `nama`) VALUES
(1, 'Hidup'),
(4, 'Hilang'),
(2, 'Mati'),
(6, 'Pergi'),
(3, 'Pindah'),
(9, 'Tidak Valid');

-- --------------------------------------------------------

--
-- Table structure for table `data_suku`
--

CREATE TABLE `data_suku` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_suku`
--

INSERT INTO `data_suku` (`id`, `nama`, `deskripsi`) VALUES
(1, 'Aceh', 'Aceh'),
(2, 'Alas', 'Aceh'),
(3, 'Alor', 'NTT'),
(4, 'Ambon', 'Ambon'),
(5, 'Ampana', 'Sulawesi Tengah'),
(6, 'Anak Dalam', 'Jambi'),
(7, 'Aneuk Jamee', 'Aceh'),
(8, 'Arab: Orang Hadhrami', 'Arab: Orang Hadhrami'),
(9, 'Aru', 'Maluku'),
(10, 'Asmat', 'Papua'),
(11, 'Bare’e', 'Bare’e di Kabupaten Tojo Una-Una Tojo dan Tojo Barat'),
(12, 'Banten', 'Banten di Banten'),
(13, 'Besemah', 'Besemah di Sumatera Selatan'),
(14, 'Bali', 'Bali di Bali terdiri dari: Suku Bali Majapahit di sebagian besar Pulau Bali; Suku Bali Aga di Karangasem dan Kintamani'),
(15, 'Balantak', 'Balantak di Sulawesi Tengah'),
(16, 'Banggai', 'Banggai di Sulawesi Tengah (Kabupaten Banggai Kepulauan)'),
(17, 'Baduy', 'Baduy di Banten'),
(18, 'Bajau', 'Bajau di Kalimantan Timur'),
(19, 'Banjar', 'Banjar di Kalimantan Selatan'),
(20, 'Batak', 'Sumatera Utara'),
(21, 'Batak Karo', 'Sumatera Utara'),
(22, 'Mandailing', 'Sumatera Utara'),
(23, 'Angkola', 'Sumatera Utara'),
(24, 'Toba', 'Sumatera Utara'),
(25, 'Pakpak', 'Sumatera Utara'),
(26, 'Simalungun', 'Sumatera Utara'),
(27, 'Batin', 'Batin di Jambi'),
(28, 'Bawean', 'Bawean di Jawa Timur (Gresik)'),
(29, 'Bentong', 'Bentong di Sulawesi Selatan'),
(30, 'Berau', 'Berau di Kalimantan Timur (kabupaten Berau)'),
(31, 'Betawi', 'Betawi di Jakarta'),
(32, 'Bima', 'Bima NTB (kota Bima)'),
(33, 'Boti', 'Boti di kabupaten Timor Tengah Selatan'),
(34, 'Bolang Mongondow', 'Bolang Mongondow di Sulawesi Utara (Kabupaten Bolaang Mongondow)'),
(35, 'Bugis', 'Bugis di Sulawesi Selatan: Orang Bugis Pagatan di Kalimantan Selatan, Kusan Hilir, Tanah Bumbu'),
(36, 'Bungku', 'Bungku di Sulawesi Tengah (Kabupaten Morowali)'),
(37, 'Buru', 'Buru di Maluku (Kabupaten Buru)'),
(38, 'Buol', 'Buol di Sulawesi Tengah (Kabupaten Buol)'),
(39, 'Bulungan ', 'Bulungan di Kalimantan Timur (Kabupaten Bulungan)'),
(40, 'Buton', 'Buton di Sulawesi Tenggara (Kabupaten Buton dan Kota Bau-Bau)'),
(41, 'Bonai', 'Bonai di Riau (Kabupaten Rokan Hilir)'),
(42, 'Cham ', 'Cham di Aceh'),
(43, 'Cirebon ', 'Cirebon di Jawa Barat (Kota Cirebon)'),
(44, 'Damal', 'Damal di Mimika'),
(45, 'Dampeles', 'Dampeles di Sulawesi Tengah'),
(46, 'Dani ', 'Dani di Papua (Lembah Baliem)'),
(47, 'Dairi', 'Dairi di Sumatera Utara'),
(48, 'Daya ', 'Daya di Sumatera Selatan'),
(49, 'Dayak', 'Dayak terdiri dari: Suku Dayak Ahe di Kalimantan Barat; Suku Dayak Bajare di Kalimantan Barat; Suku Dayak Damea di Kalimantan Barat; Suku Dayak Banyadu di Kalimantan Barat; Suku Bakati di Kalimantan Barat; Suku Punan di Kalimantan Tengah; Suku Kanayatn di Kalimantan Barat; Suku Dayak Krio di Kalimantan Barat (Ketapang], Suku Dayak Sungai Laur di Kalimantan Barat (Ketapang], Suku Dayak Simpangh di Kalimantan Barat (Ketapang], Suku Iban di Kalimantan Barat; Suku Mualang di Kalimantan Barat (Sekada'),
(50, 'Dompu', 'Dompu NTB (Kabupaten Dompu)'),
(51, 'Donggo', 'Donggo, Bima'),
(52, 'Dongga', 'Donggala di Sulawesi Tengah'),
(53, 'Dondo ', 'Dondo di Sulawesi Tengah (Kabupaten Toli-Toli)'),
(54, 'Duri', 'Duri Terletak di bagian utara Kabupaten Enrekang berbatasan dengan Kabupaten Tana Toraja, meliputi tiga kecamatan induk Anggeraja, Baraka, dan Alla di Sulawesi Selatan'),
(55, 'Eropa ', 'Eropa (orang Indo, peranakan Eropa-Indonesia, atau etnik Mestizo)'),
(56, 'Flores', 'Flores di NTT (Flores Timur)'),
(57, 'Lamaholot', 'Lamaholot, Flores Timur, terdiri dari: Suku Wandan, di Solor Timur, Flores Timur; Suku Kaliha, di Solor Timur, Flores Timur; Suku Serang Gorang, di Solor Timur, Flores Timur; Suku Lamarobak, di Solor Timur, Flores Timur; Suku Atanuhan, di Solor Timur, Flores Timur; Suku Wotan, di Solor Timur, Flores Timur; Suku Kapitan Belen, di Solor Timur, Flores Timur'),
(58, 'Gayo', 'Gayo di Aceh (Gayo Lues Aceh Tengah Bener Meriah Aceh Tenggara Aceh Timur Aceh Tamiang)'),
(59, 'Gorontalo', 'Gorontalo di Gorontalo (Kota Gorontalo)'),
(60, 'Gumai ', 'Gumai di Sumatera Selatan (Lahat)'),
(61, 'India', 'India, terdiri dari: Suku Tamil di Aceh, Sumatera Utara, Sumatera Barat, dan DKI Jakarta; Suku Punjab di Sumatera Utara, DKI Jakarta, dan Jawa Timur; Suku Bengali di DKI Jakarta; Suku Gujarati di DKI Jakarta dan Jawa Tengah; Orang Sindhi di DKI Jakarta dan Jawa Timur; Orang Sikh di Sumatera Utara, DKI Jakarta, dan Jawa Timur'),
(62, 'Jawa', 'Jawa di Jawa Tengah, Jawa Timur, DI Yogyakarta'),
(63, 'Tengger', 'Tengger di Jawa Timur (Probolinggo, Pasuruan, dan Malang)'),
(64, 'Osing ', 'Osing di Jawa Timur (Banyuwangi)'),
(65, 'Samin ', 'Samin di Jawa Tengah (Purwodadi)'),
(66, 'Bawean', 'Bawean di Jawa Timur (Pulau Bawean)'),
(67, 'Jambi ', 'Jambi di Jambi (Kota Jambi)'),
(68, 'Jepang', 'Jepang di DKI Jakarta, Jawa Timur, dan Bali'),
(69, 'Kei', 'Kei di Maluku Tenggara (Kabupaten Maluku Tenggara dan Kota Tual)'),
(70, 'Kaili ', 'Kaili di Sulawesi Tengah (Kota Palu)'),
(71, 'Kampar', 'Kampar'),
(72, 'Kaur ', 'Kaur di Bengkulu (Kabupaten Kaur)'),
(73, 'Kayu Agung', 'Kayu Agung di Sumatera Selatan'),
(74, 'Kerinci', 'Kerinci di Jambi (Kabupaten Kerinci)'),
(75, 'Komering ', 'Komering di Sumatera Selatan (Kabupaten Ogan Komering Ilir, Baturaja)'),
(76, 'Konjo Pegunungan', 'Konjo Pegunungan, Kabupaten Gowa, Sulawesi Selatan'),
(77, 'Konjo Pesisir', 'Konjo Pesisir, Kabupaten Bulukumba, Sulawesi Selatan'),
(78, 'Koto', 'Koto di Sumatera Barat'),
(79, 'Kubu', 'Kubu di Jambi dan Sumatera Selatan'),
(80, 'Kulawi', 'Kulawi di Sulawesi Tengah'),
(81, 'Kutai ', 'Kutai di Kalimantan Timur (Kutai Kartanegara)'),
(82, 'Kluet ', 'Kluet di Aceh (Aceh Selatan)'),
(83, 'Korea ', 'Korea di DKI Jakarta'),
(84, 'Krui', 'Krui di Lampung'),
(85, 'Laut,', 'Laut, Kepulauan Riau'),
(86, 'Lampung', 'Lampung, terdiri dari: Suku Sungkai di Lampung; Suku Abung di Lampung; Suku Way Kanan di Lampung, Sumatera Selatan dan Bengkulu; Suku Pubian di Lampung; Suku Tulang Bawang di Lampung; Suku Melinting di Lampung; Suku Peminggir Teluk di Lampung; Suku Ranau di Lampung, Sumatera Selatan dan Sumatera Utara; Suku Komering di Sumatera Selatan; Suku Cikoneng di Banten; Suku Merpas di Bengkulu; Suku Belalau di Lampung; Suku Smoung di Lampung; Suku Semaka di Lampung'),
(87, 'Lematang ', 'Lematang di Sumatera Selatan'),
(88, 'Lembak', 'Lembak, Kabupaten Rejang Lebong, Bengkulu'),
(89, 'Lintang', 'Lintang, Sumatera Selatan'),
(90, 'Lom', 'Lom, Bangka Belitung'),
(91, 'Lore', 'Lore, Sulawesi Tengah'),
(92, 'Lubu', 'Lubu, daerah perbatasan antara Provinsi Sumatera Utara dan Provinsi Sumatera Barat'),
(93, 'Moronene', 'Moronene di Sulawesi Tenggara.'),
(94, 'Madura', 'Madura di Jawa Timur (Pulau Madura, Kangean, wilayah Tapal Kuda)'),
(95, 'Makassar', 'Makassar di Sulawesi Selatan: Kabupaten Gowa, Kabupaten Takalar, Kabupaten Jeneponto, Kabupaten Bantaeng, Kabupaten Bulukumba (sebagian), Kabupaten Sinjai (bagian perbatasan Kab Gowa), Kabupaten Maros (sebagian), Kabupaten Pangkep (sebagian), Kota Makassar'),
(96, 'Mamasa', 'Mamasa (Toraja Barat) di Sulawesi Barat: Kabupaten Mamasa'),
(97, 'Manda', 'Mandar Sulawesi Barat: Polewali Mandar'),
(98, 'Melayu', 'Melayu, terdiri dari Suku Melayu Tamiang di Aceh (Aceh Tamiang], Suku Melayu Riau di Riau dan Kepulauan Riau; Suku Melayu Deli di Sumatera Utara; Suku Melayu Jambi di Jambi; Suku Melayu Bangka di Pulau Bangka; Suku Melayu Belitung di Pulau Belitung; Suku Melayu Sambas di Kalimantan Barat'),
(99, 'Mentawai', 'Mentawai di Sumatera Barat (Kabupaten Kepulauan Mentawai)'),
(100, 'Minahasa', 'Minahasa di Sulawesi Utara (Kabupaten Minahasa), terdiri 9 subetnik : Suku Babontehu; Suku Bantik; Suku Pasan Ratahan'),
(101, 'Ponosakan', 'Ponosakan; Suku Tonsea; Suku Tontemboan; Suku Toulour; Suku Tonsawang; Suku Tombulu'),
(102, 'Minangkabau', 'Minangkabau, Sumatera Barat'),
(103, 'Mongondow', 'Mongondow, Sulawesi Utara'),
(104, 'Mori', 'Mori, Kabupaten Morowali, Sulawesi Tengah'),
(105, 'Muko-Muko', 'Muko-Muko di Bengkulu (Kabupaten Mukomuko)'),
(106, 'Muna', 'Muna di Sulawesi Tenggara (Kabupaten Muna)'),
(107, 'Muyu', 'Muyu di Kabupaten Boven Digoel, Papua'),
(108, 'Mekongga', 'Mekongga di Sulawesi Tenggara (Kabupaten Kolaka dan Kabupaten Kolaka Utara)'),
(109, 'Moro', 'Moro di Kalimantan Barat dan Kalimantan Utara'),
(110, 'Nias', 'Nias di Sumatera Utara (Kabupaten Nias, Nias Selatan dan Nias Utara dari dua keturunan Jepang dan Vietnam)'),
(111, 'Ngada ', 'Ngada di NTT: Kabupaten Ngada'),
(112, 'Osing', 'Osing di Banyuwangi Jawa Timur'),
(113, 'Ogan', 'Ogan di Sumatera Selatan'),
(114, 'Ocu', 'Ocu di Kabupaten Kampar, Riau'),
(115, 'Padoe', 'Padoe di Sulawesi Tengah dan Sulawesi Selatan'),
(116, 'Papua', 'Papua / Irian, terdiri dari: Suku Asmat di Kabupaten Asmat; Suku Biak di Kabupaten Biak Numfor; Suku Dani, Lembah Baliem, Papua; Suku Ekagi, daerah Paniai, Abepura, Papua; Suku Amungme di Mimika; Suku Bauzi, Mamberamo hilir, Papua utara; Suku Arfak di Manokwari; Suku Kamoro di Mimika'),
(117, 'Palembang', 'Palembang di Sumatera Selatan (Kota Palembang)'),
(118, 'Pamona', 'Pamona di Sulawesi Tengah (Kabupaten Poso) dan di Sulawesi Selatan'),
(119, 'Pesisi', 'Pesisi di Sumatera Utara (Tapanuli Tengah)'),
(120, 'Pasir', 'Pasir di Kalimantan Timur (Kabupaten Pasir)'),
(121, 'Pubian', 'Pubian di Lampung'),
(122, 'Pattae', 'Pattae di Polewali Mandar'),
(123, 'Pakistani', 'Pakistani di Sumatera Utara, DKI Jakarta, dan Jawa Tengah'),
(124, 'Peranakan', 'Peranakan (Tionghoa-Peranakan atau Baba Nyonya)'),
(125, 'Rawa', 'Rawa, Rokan Hilir, Riau'),
(126, 'Rejang', 'Rejang di Bengkulu (Kabupaten Bengkulu Tengah, Kabupaten Bengkulu Utara, Kabupaten Kepahiang, Kabupaten Lebong, dan Kabupaten Rejang Lebong)'),
(127, 'Rote', 'Rote di NTT (Kabupaten Rote Ndao)'),
(128, 'Rongga', 'Rongga di NTT Kabupaten Manggarai Timur'),
(129, 'Rohingya', 'Rohingya'),
(130, 'Sabu', 'Sabu di Pulau Sabu, NTT'),
(131, 'Saluan', 'Saluan di Sulawesi Tengah'),
(132, 'Sambas', 'Sambas (Melayu Sambas) di Kalimantan Barat: Kabupaten Sambas'),
(133, 'Samin', 'Samin di Jawa Tengah (Blora) dan Jawa Timur (Bojonegoro)'),
(134, 'Sangi', 'Sangir di Sulawesi Utara (Kepulauan Sangihe)'),
(135, 'Sasak', 'Sasak di NTB, Lombok'),
(136, 'Sekak Bangka', 'Sekak Bangka'),
(137, 'Sekayu', 'Sekayu di Sumatera Selatan'),
(138, 'Semendo ', 'Semendo di Bengkulu, Sumatera Selatan (Muara Enim)'),
(139, 'Serawai ', 'Serawai di Bengkulu (Kabupaten Bengkulu Selatan dan Kabupaten Seluma)'),
(140, 'Simeulue', 'Simeulue di Aceh (Kabupaten Simeulue)'),
(141, 'Sigulai ', 'Sigulai di Aceh (Kabupaten Simeulue bagian utara'),
(142, 'Suluk', 'Suluk di Kalimantan Utara)'),
(143, 'Sumbawa ', 'Sumbawa Di NTB (Kabupaten Sumbawa)'),
(144, 'Sumba', 'Sumba di NTT (Sumba Barat, Sumba Timur)'),
(145, 'Sunda', 'Sunda di Jawa Barat, Banten, DKI Jakarta, Lampung, Sumatra Selatan dan Jawa Tengah'),
(146, 'Sungkai ', 'Sungkai di Lampung Lampung Utara'),
(147, 'Talau', 'Talaud di Sulawesi Utara (Kepulauan Talaud)'),
(148, 'Talang Mamak', 'Talang Mamak di Riau (Indragiri Hulu)'),
(149, 'Tamiang ', 'Tamiang di Aceh (Kabupaten Aceh Tamiang)'),
(150, 'Tengger ', 'Tengger di Jawa Timur (Kabupaten Pasuruan) dan Probolinggo (lereng G. Bromo)'),
(151, 'Ternate ', 'Ternate di Maluku Utara (Kota Ternate)'),
(152, 'Tidore', 'Tidore di Maluku Utara (Kota Tidore)'),
(153, 'Tidung', 'Tidung di Kalimantan Timur (Kabupaten Tanah Tidung)'),
(154, 'Timor', 'Timor di NTT, Kota Kupang'),
(155, 'Tionghoa', 'Tionghoa, terdiri dari: Orang Cina Parit di Pelaihari, Tanah Laut, Kalsel; Orang Cina Benteng di Tangerang, Provinsi Banten; Orang Tionghoa Hokkien di Jawa dan Sumatera Utara; Orang Tionghoa Hakka di Belitung dan Kalimantan Barat; Orang Tionghoa Hubei; Orang Tionghoa Hainan; Orang Tionghoa Kanton; Orang Tionghoa Hokchia; Orang Tionghoa Tiochiu'),
(156, 'Tojo', 'Tojo di Sulawesi Tengah (Kabupaten Tojo Una-Una)'),
(157, 'Toraja', 'Toraja di Sulawesi Selatan (Tana Toraja)'),
(158, 'Tolaki', 'Tolaki di Sulawesi Tenggara (Kendari)'),
(159, 'Toli Toli', 'Toli Toli di Sulawesi Tengah (Kabupaten Toli-Toli)'),
(160, 'Tomini', 'Tomini di Sulawesi Tengah (Kabupaten Parigi Mouton'),
(161, 'Una-una ', 'Una-una di Sulawesi Tengah (Kabupaten Tojo Una-Una)'),
(162, 'Ulu', 'Ulu di Sumatera Utara (Mandailing natal)'),
(163, 'Wolio', 'Wolio di Sulawesi Tenggara (Buton)');

-- --------------------------------------------------------

--
-- Table structure for table `data_tempat_dilahirkan`
--

CREATE TABLE `data_tempat_dilahirkan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_tempat_dilahirkan`
--

INSERT INTO `data_tempat_dilahirkan` (`id`, `nama`) VALUES
(5, 'Lainnya'),
(3, 'Polindes'),
(2, 'Puskesmas'),
(1, 'RS/RB'),
(4, 'Rumah');

-- --------------------------------------------------------

--
-- Table structure for table `data_warganegara`
--

CREATE TABLE `data_warganegara` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `data_warganegara`
--

INSERT INTO `data_warganegara` (`id`, `nama`) VALUES
(3, 'Dua Kewarganegaraan'),
(2, 'WNA'),
(1, 'WNI');

-- --------------------------------------------------------

--
-- Table structure for table `kelahiran`
--

CREATE TABLE `kelahiran` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_anak` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ayah_id` bigint UNSIGNED DEFAULT NULL,
  `ibu_id` bigint UNSIGNED DEFAULT NULL,
  `hari_lahir` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jam_lahir` time NOT NULL,
  `jenis_persalinan_id` bigint UNSIGNED NOT NULL,
  `anak_ke` int NOT NULL,
  `berat_bayi` int NOT NULL COMMENT 'gram',
  `panjang_bayi` int NOT NULL COMMENT 'cm',
  `tempat_dilahirkan_id` bigint UNSIGNED NOT NULL,
  `penolong_kelahiran_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `keuangan`
--

CREATE TABLE `keuangan` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran` year NOT NULL,
  `jenis_keuangan` enum('Pendapatan','Pembiayaan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_anggaran` bigint UNSIGNED NOT NULL,
  `nilai_realisasi` bigint UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_kuitansi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penduduk`
--

CREATE TABLE `penduduk` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nik` bigint UNSIGNED NOT NULL,
  `tempat_lahir` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `agama_id` bigint UNSIGNED NOT NULL,
  `telepon` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `identitas_elektronik` enum('Belum','KTP_EL','KIA') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'KTP_EL',
  `hubungan_keluarga_id` bigint UNSIGNED NOT NULL,
  `rt` bigint NOT NULL,
  `rw` bigint NOT NULL,
  `alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kodepos` bigint UNSIGNED DEFAULT NULL,
  `pendidikan_id` bigint UNSIGNED NOT NULL,
  `nik_ayah` bigint UNSIGNED DEFAULT NULL,
  `nama_ayah` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `nik_ibu` bigint UNSIGNED DEFAULT NULL,
  `nama_ibu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `akte_kelahiran` enum('Ada','Tidak Ada') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kawin_id` bigint UNSIGNED NOT NULL,
  `akseptor_kb_id` bigint UNSIGNED NOT NULL,
  `pekerjaan_id` bigint UNSIGNED NOT NULL,
  `sakit_menahun_id` bigint UNSIGNED NOT NULL,
  `cacat_id` bigint UNSIGNED NOT NULL,
  `kelainan_fisik_mental` enum('Tidak Ada','Ada') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `golongan_darah_id` bigint UNSIGNED NOT NULL,
  `warganegara_id` bigint UNSIGNED NOT NULL,
  `asuransi_id` bigint UNSIGNED NOT NULL,
  `status_penduduk` enum('Tetap','Tidak Tetap') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status_dasar_id` bigint UNSIGNED NOT NULL,
  `suku_id` bigint UNSIGNED DEFAULT NULL,
  `kursus_id` bigint UNSIGNED DEFAULT NULL,
  `bahasa_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `perangkat`
--

CREATE TABLE `perangkat` (
  `id` bigint UNSIGNED NOT NULL,
  `penduduk_id` bigint UNSIGNED NOT NULL,
  `jabatan_id` bigint UNSIGNED NOT NULL,
  `nipd` bigint UNSIGNED DEFAULT NULL,
  `nip` bigint UNSIGNED DEFAULT NULL,
  `pangkat_golongan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_keputusan_pengangkatan` bigint DEFAULT NULL,
  `tanggal_keputusan_pengangkatan` date DEFAULT NULL,
  `no_keputusan_pemberhentian` bigint DEFAULT NULL,
  `tanggal_keputusan_pemberhentian` date DEFAULT NULL,
  `status_pejabat` enum('Aktif','Tidak Aktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `masa_jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '6 tahun periode'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_agama`
--
ALTER TABLE `data_agama`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_akseptor_kb`
--
ALTER TABLE `data_akseptor_kb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_asuransi`
--
ALTER TABLE `data_asuransi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_bahasa`
--
ALTER TABLE `data_bahasa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_cacat`
--
ALTER TABLE `data_cacat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_golongan_darah`
--
ALTER TABLE `data_golongan_darah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_hubungan_keluarga`
--
ALTER TABLE `data_hubungan_keluarga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_jabatan`
--
ALTER TABLE `data_jabatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_jenis_persalinan`
--
ALTER TABLE `data_jenis_persalinan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_kawin`
--
ALTER TABLE `data_kawin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_kursus`
--
ALTER TABLE `data_kursus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_pekerjaan`
--
ALTER TABLE `data_pekerjaan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_pendidikan`
--
ALTER TABLE `data_pendidikan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_penolong_kelahiran`
--
ALTER TABLE `data_penolong_kelahiran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_sakit_menahun`
--
ALTER TABLE `data_sakit_menahun`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_status_dasar`
--
ALTER TABLE `data_status_dasar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_suku`
--
ALTER TABLE `data_suku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_tempat_dilahirkan`
--
ALTER TABLE `data_tempat_dilahirkan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `data_warganegara`
--
ALTER TABLE `data_warganegara`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `kelahiran`
--
ALTER TABLE `kelahiran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelahiran_ibfk_1` (`ayah_id`),
  ADD KEY `kelahiran_ibfk_2` (`ibu_id`),
  ADD KEY `kelahiran_ibfk_4` (`jenis_persalinan_id`),
  ADD KEY `kelahiran_ibfk_5` (`tempat_dilahirkan_id`),
  ADD KEY `kelahiran_ibfk_6` (`penolong_kelahiran_id`);

--
-- Indexes for table `keuangan`
--
ALTER TABLE `keuangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penduduk`
--
ALTER TABLE `penduduk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `agama_id` (`agama_id`),
  ADD KEY `akseptor_kb_id` (`akseptor_kb_id`),
  ADD KEY `asuransi_id` (`asuransi_id`),
  ADD KEY `bahasa_id` (`bahasa_id`),
  ADD KEY `cacat_id` (`cacat_id`),
  ADD KEY `golongan_darah_id` (`golongan_darah_id`),
  ADD KEY `hubungan_keluarga_id` (`hubungan_keluarga_id`),
  ADD KEY `kawin_id` (`kawin_id`),
  ADD KEY `kursus_id` (`kursus_id`),
  ADD KEY `pekerjaan_id` (`pekerjaan_id`),
  ADD KEY `pendidikan_id` (`pendidikan_id`),
  ADD KEY `sakit_menahun_id` (`sakit_menahun_id`),
  ADD KEY `status_dasar_id` (`status_dasar_id`),
  ADD KEY `suku_id` (`suku_id`),
  ADD KEY `warganegara_id` (`warganegara_id`);

--
-- Indexes for table `perangkat`
--
ALTER TABLE `perangkat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perangkat_ibfk_1` (`penduduk_id`),
  ADD KEY `perangkat_ibfk_2` (`jabatan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_agama`
--
ALTER TABLE `data_agama`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `data_akseptor_kb`
--
ALTER TABLE `data_akseptor_kb`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `data_asuransi`
--
ALTER TABLE `data_asuransi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `data_bahasa`
--
ALTER TABLE `data_bahasa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `data_cacat`
--
ALTER TABLE `data_cacat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `data_golongan_darah`
--
ALTER TABLE `data_golongan_darah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `data_hubungan_keluarga`
--
ALTER TABLE `data_hubungan_keluarga`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `data_jabatan`
--
ALTER TABLE `data_jabatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `data_jenis_persalinan`
--
ALTER TABLE `data_jenis_persalinan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_kawin`
--
ALTER TABLE `data_kawin`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_kursus`
--
ALTER TABLE `data_kursus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `data_pekerjaan`
--
ALTER TABLE `data_pekerjaan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `data_pendidikan`
--
ALTER TABLE `data_pendidikan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `data_penolong_kelahiran`
--
ALTER TABLE `data_penolong_kelahiran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_sakit_menahun`
--
ALTER TABLE `data_sakit_menahun`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `data_status_dasar`
--
ALTER TABLE `data_status_dasar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `data_suku`
--
ALTER TABLE `data_suku`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `data_tempat_dilahirkan`
--
ALTER TABLE `data_tempat_dilahirkan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `data_warganegara`
--
ALTER TABLE `data_warganegara`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kelahiran`
--
ALTER TABLE `kelahiran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keuangan`
--
ALTER TABLE `keuangan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penduduk`
--
ALTER TABLE `penduduk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perangkat`
--
ALTER TABLE `perangkat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kelahiran`
--
ALTER TABLE `kelahiran`
  ADD CONSTRAINT `kelahiran_ibfk_1` FOREIGN KEY (`ayah_id`) REFERENCES `penduduk` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `kelahiran_ibfk_2` FOREIGN KEY (`ibu_id`) REFERENCES `penduduk` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `kelahiran_ibfk_4` FOREIGN KEY (`jenis_persalinan_id`) REFERENCES `data_jenis_persalinan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `kelahiran_ibfk_5` FOREIGN KEY (`tempat_dilahirkan_id`) REFERENCES `data_tempat_dilahirkan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `kelahiran_ibfk_6` FOREIGN KEY (`penolong_kelahiran_id`) REFERENCES `data_penolong_kelahiran` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `penduduk`
--
ALTER TABLE `penduduk`
  ADD CONSTRAINT `penduduk_ibfk_1` FOREIGN KEY (`agama_id`) REFERENCES `data_agama` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_ibfk_10` FOREIGN KEY (`pekerjaan_id`) REFERENCES `data_pekerjaan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `penduduk_ibfk_11` FOREIGN KEY (`pendidikan_id`) REFERENCES `data_pendidikan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `penduduk_ibfk_12` FOREIGN KEY (`sakit_menahun_id`) REFERENCES `data_sakit_menahun` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `penduduk_ibfk_13` FOREIGN KEY (`status_dasar_id`) REFERENCES `data_status_dasar` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `penduduk_ibfk_14` FOREIGN KEY (`suku_id`) REFERENCES `data_suku` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `penduduk_ibfk_15` FOREIGN KEY (`warganegara_id`) REFERENCES `data_warganegara` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `penduduk_ibfk_2` FOREIGN KEY (`akseptor_kb_id`) REFERENCES `data_akseptor_kb` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_ibfk_3` FOREIGN KEY (`asuransi_id`) REFERENCES `data_asuransi` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_ibfk_4` FOREIGN KEY (`bahasa_id`) REFERENCES `data_bahasa` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_ibfk_5` FOREIGN KEY (`cacat_id`) REFERENCES `data_cacat` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_ibfk_6` FOREIGN KEY (`golongan_darah_id`) REFERENCES `data_golongan_darah` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_ibfk_7` FOREIGN KEY (`hubungan_keluarga_id`) REFERENCES `data_hubungan_keluarga` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_ibfk_8` FOREIGN KEY (`kawin_id`) REFERENCES `data_kawin` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_ibfk_9` FOREIGN KEY (`kursus_id`) REFERENCES `data_kursus` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `perangkat`
--
ALTER TABLE `perangkat`
  ADD CONSTRAINT `perangkat_ibfk_1` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `perangkat_ibfk_2` FOREIGN KEY (`jabatan_id`) REFERENCES `data_jabatan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
