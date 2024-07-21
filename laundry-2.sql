-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jul 2024 pada 17.02
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry-2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` bigint(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gender` enum('Laki-laki','Perempuan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id`, `user_id`, `name`, `phone_number`, `address`, `is_deleted`, `created_at`, `updated_at`, `gender`) VALUES
(41, 31, 'Rudi', 628567326333, 'Jln. Bantul Selatan, Bantul', 1, '2024-07-01 01:56:08', '2024-07-01 07:07:19', 'Laki-laki'),
(43, 33, 'Forsaken Jason', 65234535, 'jln. Keraton barat lagi, Keraton', 0, '2024-07-01 07:06:35', '2024-07-01 07:30:07', 'Laki-laki'),
(46, 33, 'Something', 653534534, 'Jln Wates Utara, Wates', 0, '2024-07-01 07:25:38', '2024-07-01 07:25:38', 'Laki-laki'),
(47, 34, 'Budi', 6281209245, 'Jln. Maguwoharjo, Sleman', 0, '2024-07-02 04:25:34', '2024-07-09 02:20:29', 'Perempuan'),
(48, 33, 'Winda', 6234297, 'Jl. Depok, Sleman', 0, '2024-07-09 02:02:44', '2024-07-09 02:02:44', 'Perempuan'),
(49, 33, 'Ridho', 62097146, 'Jl. Wates, Bantul', 0, '2024-07-09 02:03:15', '2024-07-09 02:03:15', 'Laki-laki'),
(50, 34, 'Linnda', 624367576, 'Jl. Mancasan, Sleman', 0, '2024-07-09 02:20:16', '2024-07-09 02:20:16', 'Perempuan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `total` decimal(10,0) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `expense`
--

INSERT INTO `expense` (`id`, `user_id`, `date`, `name`, `quantity`, `price`, `total`, `note`, `created_at`, `updated_at`) VALUES
(4, 30, '2024-07-13', 'Rinso', 4, 9000, 36000, 'Beli toko A', '2024-07-01 07:54:30', '2024-07-01 08:05:07'),
(5, 30, '2024-07-09', 'Pelembut', 4, 5000, 20000, 'Toko B', '2024-07-09 02:00:13', '2024-07-09 02:00:13'),
(6, 30, '2024-07-09', 'Rinso cair', 9, 2000, 18000, 'Toko B', '2024-07-09 02:00:32', '2024-07-09 02:00:32'),
(8, 30, '2024-07-09', 'Pewangi molto', 6, 4000, 24000, 'Toko B', '2024-07-09 02:15:07', '2024-07-09 02:15:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `packet`
--

CREATE TABLE `packet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `estimation` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `packet`
--

INSERT INTO `packet` (`id`, `user_id`, `name`, `estimation`, `price`, `description`, `is_deleted`, `created_at`, `updated_at`) VALUES
(12, 30, 'Reguler', '12 Days', 6000, 'Sabun biasa, serba biasa dan lebih biasa\r\n', 1, '2024-06-30 12:19:07', '2024-06-30'),
(13, 30, 'Cuci Kering', '2 Hari', 8000, 'Cuci kering, pewangi, setrika. Untuk bahan Menggunakan bahan standar', 1, '2024-07-01 06:43:45', '2024-07-01'),
(14, 30, 'Cuci Basah', '1 Hari', 3000, 'Cuci basah menggunakan bahan standar', 1, '2024-07-01 08:07:27', '2024-07-01'),
(16, 30, 'Hemat', '2 Hari', 4000, 'Cuci popok', 1, '2024-07-01 14:29:25', '2024-07-01'),
(17, 30, 'Reguler', '3 Hari', 6000, 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quo, quod.', 0, '2024-07-07 06:46:30', '2024-07-07'),
(18, 30, 'Hemat', '5 Hari', 3000, 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quo, quod.', 0, '2024-07-07 06:46:47', '2024-07-07'),
(19, 30, 'Express', '2 Hari', 8000, 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quo, quod.', 0, '2024-07-07 06:47:07', '2024-07-07'),
(20, 30, 'hemat july', '2 hari', 5000, 'cuci kering', 1, '2024-07-09 02:13:01', '2024-07-09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_company`
--

CREATE TABLE `profil_company` (
  `id` int(11) NOT NULL,
  `name_company` varchar(50) NOT NULL,
  `about` text NOT NULL,
  `vision` text NOT NULL,
  `mission` text NOT NULL,
  `banner_img` varchar(100) NOT NULL,
  `about_img` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(250) NOT NULL,
  `city` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `street` varchar(100) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `url_map` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profil_company`
--

INSERT INTO `profil_company` (`id`, `name_company`, `about`, `vision`, `mission`, `banner_img`, `about_img`, `phone_number`, `email`, `city`, `district`, `street`, `postal_code`, `url_map`) VALUES
(1, 'MrClean', 'Di MrClean, kami bangga dalam memberikan layanan laundry terbaik dengan sentuhan personal. Terletak di pusat Yogyakarta, misi kami adalah membuat hari mencuci pakaian menjadi lebih mudah bagi pelanggan kami yang berharga.', 'Menjadi penyedia layanan laundry terdepan di Yogyakarta, dikenal karena kualitas, keandalan, dan inovasi dalam setiap layanan yang kami tawarkan.', 'Menyediakan Layanan Berkualitas Tinggi: Memberikan hasil laundry yang bersih, wangi, dan rapi dengan standar kebersihan yang tinggi dan teknologi canggih.\r\nMengutamakan Kepuasan Pelanggan: Memberikan pelayanan yang ramah, responsif, dan profesional untuk memastikan setiap pelanggan merasa dihargai dan puas.\r\nInovasi Berkelanjutan: Terus berinovasi dalam layanan dan proses laundry untuk memenuhi kebutuhan dan harapan pelanggan yang terus berkembang.', '../uploads/hero-bg.jpg', '../uploads/laundry-about.jpg', '628226860200', 'mrclean@gmail.com', 'Yogyakarta', 'Sleman', 'Jln. Candi gebang', 55511, 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d17144.422780199795!2d110.41349356631176!3d-7.747524341246426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sid!4v1720188003398!5m2!1sen!2sid');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `packet_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `status` enum('Belum diproses','Sedang diproses','Siap diambil','Sudah diambil') NOT NULL DEFAULT 'Belum diproses',
  `discount` int(11) NOT NULL DEFAULT 0,
  `amount` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaction`
--

INSERT INTO `transaction` (`id`, `user_id`, `customer_id`, `packet_id`, `weight`, `status`, `discount`, `amount`, `created_at`, `updated_at`) VALUES
(38, 34, 47, 18, 5, 'Sudah diambil', 0, 15000, '2024-07-08 13:55:58', '2024-07-09 09:22:55'),
(39, 34, 46, 18, 3, 'Siap diambil', 0, 9000, '2024-07-08 15:17:42', '2024-07-08 22:19:52'),
(41, 34, 43, 18, 2, 'Siap diambil', 0, 6000, '2024-07-08 15:32:46', '2024-07-08 22:46:27'),
(42, 34, 43, 17, 4, 'Sedang diproses', 0, 24000, '2024-07-08 15:32:59', '2024-07-08 22:46:21'),
(43, 34, 47, 17, 6, 'Belum diproses', 0, 36000, '2024-07-08 15:33:12', '2024-07-08 22:33:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` enum('Laki-laki','Perempuan','','') NOT NULL,
  `phone_number` bigint(16) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `security_question` varchar(255) NOT NULL,
  `security_answer` varchar(255) NOT NULL,
  `role` enum('Admin','Kasir') NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `full_name`, `gender`, `phone_number`, `address`, `password`, `security_question`, `security_answer`, `role`, `is_deleted`) VALUES
(30, 'admin', 'admin1', 'Laki-laki', 62867324243, 'Jln. Candi Gebang, Sleman', 'admin', 'Siapa wakil presiden pemenang pemilu 2024?', 'gibran', 'Admin', 0),
(31, 'kasir1', 'kasir laundry1', 'Laki-laki', 6287532323, 'Sleman', 'kasir1', '', '', 'Kasir', 1),
(32, 'kasir2', 'kasir2', 'Laki-laki', 62874234234, 'Wedomartani', 'kasir2', '', '', 'Kasir', 1),
(33, 'kasir3', 'kasir3', 'Laki-laki', 6274863843, 'Jln. Maguwoharjo, Sleman', 'kasir3', '', '', 'Kasir', 0),
(34, 'kasir4', 'kasir4', 'Laki-laki', 62544354545, 'Jln Wates Utara, Wates', 'kasir4', '', '', 'Kasir', 0),
(35, 'kasir1', 'kasir5', 'Perempuan', 6282183939874, 'Jl. Sudirman, Concat', 'kasir5', '', '', 'Kasir', 1),
(36, 'kasir1', 'kasir1', 'Perempuan', 6282183939875, 'Jln. Sudirman, Sleman', 'kasir1', '', '', 'Kasir', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `packet`
--
ALTER TABLE `packet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `profil_company`
--
ALTER TABLE `profil_company`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `packet_id` (`packet_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `packet`
--
ALTER TABLE `packet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `profil_company`
--
ALTER TABLE `profil_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ketidakleluasaan untuk tabel `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ketidakleluasaan untuk tabel `packet`
--
ALTER TABLE `packet`
  ADD CONSTRAINT `packet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`packet_id`) REFERENCES `packet` (`id`),
  ADD CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`packet_id`) REFERENCES `packet` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
