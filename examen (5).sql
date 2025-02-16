-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: dec. 08, 2024 la 06:04 PM
-- Versiune server: 10.4.32-MariaDB
-- Versiune PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `examen`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `cabluri`
--

CREATE TABLE `cabluri` (
  `id` int(11) NOT NULL,
  `tip_cablu` varchar(255) DEFAULT NULL,
  `cantitate` int(11) DEFAULT NULL,
  `activ` tinyint(1) DEFAULT 1,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `cabluri`
--

INSERT INTO `cabluri` (`id`, `tip_cablu`, `cantitate`, `activ`, `user_id`) VALUES
(2, 'Cablu | Ethernet | Cat5 | UTP 4x2', 21500, 1, 1),
(3, 'Cablu | Optic | 2FO | G.652D | aerial', 11200, 1, 2),
(4, 'Cablu | Coaxial | RG6', 2000, 1, 2),
(5, 'Cablu | Ethernet | Cat5 | FTP 4x2', 1800, 1, 1),
(7, 'Cablu | Optic | 1FO | G.657 | drop | 1.2kN', 10000, 1, 1);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `echipamente`
--

CREATE TABLE `echipamente` (
  `id` int(11) NOT NULL,
  `tip_echipament` varchar(255) DEFAULT NULL,
  `numar_serie` varchar(255) DEFAULT NULL,
  `clona` tinyint(1) DEFAULT NULL,
  `cantitate` int(11) DEFAULT NULL,
  `activ` tinyint(1) DEFAULT 1,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `echipamente`
--

INSERT INTO `echipamente` (`id`, `tip_echipament`, `numar_serie`, `clona`, `cantitate`, `activ`, `user_id`) VALUES
(1, 'ET | Ethernet | WAN SC/APC', '4857544336073311', 1, 1, 1, 7),
(2, 'ET | Ethernet | LAN SC/APC', '4857544336073312', 0, 1, 1, 1),
(3, 'ET | Ethernet | WAN SC/APC', '4857544336073313', 1, 1, 1, 2),
(4, 'ET | Fiber | WAN SC/APC', '4857544336073314', 0, 1, 1, 2),
(5, 'ET | Ethernet | LAN SC/APC', '4857544336073315', 1, 1, 1, 1),
(6, 'Camera Bulet', '12345678', 0, 1, 1, 1),
(9, 'Camera Bulet Pro', '123456789', 0, NULL, 1, 1),
(10, 'Camera Bulet', '12345678', 0, 1, 1, 1),
(12, 'Camera Bulet V3 Pro', '48575443678291F', NULL, 0, 1, 1),
(13, 'Camera Bulet V3 Pro', '48575446312HFF4', NULL, 0, 1, 7);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mesaj` text NOT NULL,
  `data_adaugare` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `feedback`
--

INSERT INTO `feedback` (`id`, `nume`, `email`, `mesaj`, `data_adaugare`) VALUES
(15, 'Bakery', 'bad@user', 'Salut Bakery', '2024-06-09 19:00:24');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `inspectii_calitate`
--

CREATE TABLE `inspectii_calitate` (
  `id` int(11) NOT NULL,
  `id_reteta` int(11) DEFAULT NULL,
  `tip_inspectie` varchar(255) NOT NULL,
  `rezultat` varchar(255) NOT NULL,
  `data_inspectie` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `instrumente`
--

CREATE TABLE `instrumente` (
  `id` int(11) NOT NULL,
  `tip_instrument` varchar(255) DEFAULT NULL,
  `cantitate` int(11) DEFAULT NULL,
  `activ` tinyint(1) DEFAULT 1,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `instrumente`
--

INSERT INTO `instrumente` (`id`, `tip_instrument`, `cantitate`, `activ`, `user_id`) VALUES
(1, 'Instrument | Box Instrumente', 2, 1, 1),
(2, 'Instrument | Tester Ethernet', 5, 1, 1),
(3, 'Instrument | Clește de sertizare', 3, 1, 1),
(4, 'Instrument | Multimetru', 4, 1, 2),
(5, 'Instrument | Cutter cablu', 7, 1, 2);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `materiale`
--

CREATE TABLE `materiale` (
  `id` int(11) NOT NULL,
  `tip_material` varchar(255) DEFAULT NULL,
  `cantitate` int(11) DEFAULT NULL,
  `activ` tinyint(1) DEFAULT 1,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `materiale`
--

INSERT INTO `materiale` (`id`, `tip_material`, `cantitate`, `activ`, `user_id`) VALUES
(1, 'Conector | Ethernet | RJ-11', 76, 1, 1),
(2, 'Conector | Ethernet | RJ-45', 150, 1, 2),
(3, 'Conector | Cat5 | 6p4c', 200, 1, 1),
(4, 'Conector | Cat6 | 8p8c', 50, 1, 1),
(5, 'Conector | RJ-45 | Cat5', 300, 1, 2);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_superuser` tinyint(1) DEFAULT 0,
  `inspector` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_superuser`, `inspector`, `created_at`) VALUES
(1, 'superuser', '$2y$10$KGI9mOqEuW6jMIrXEgflT.Ew9qPxcfTwRz0fMw2XUa.GyZ9G33oAq', 1, 0, '2024-10-12 19:19:42'),
(2, 'angajat', '$2y$10$uACoek07uf5h21YX0/OaYOday54O5xVBE2bTPrtRtKxTL7SBVF.tG', 0, 0, '2024-10-12 19:20:01'),
(4, 'admin', '$2y$10$Me0Pb7uHmxJWNynthiyaUOTJPYeLcKpXjRpfs94eZAJkLxp4FJKVy', 0, 1, '2024-10-12 19:20:35'),
(5, 'angajat2', '$2y$10$/1grbw7PwCXsJFSAIt3P6uR3KuAqB7zpCinbByn5WlNVLunpVg1US', 0, 0, '2024-10-12 19:48:20'),
(6, 'Superman', '$2y$10$2c1O4ybERllrGzwcvBlT1OYCB1pNIdU.sBw5PayRVEyJfVfC8czeG', 0, 0, '2024-11-06 16:06:11'),
(7, 'HellCat', '$2y$10$vMs6xps3gDXO0b1LS9sfUur2CMsi4YCq/b/hvMxzajd4H/VL1pFJe', 1, 0, '2024-12-08 08:20:23');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `cabluri`
--
ALTER TABLE `cabluri`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `echipamente`
--
ALTER TABLE `echipamente`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `inspectii_calitate`
--
ALTER TABLE `inspectii_calitate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_reteta` (`id_reteta`);

--
-- Indexuri pentru tabele `instrumente`
--
ALTER TABLE `instrumente`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `materiale`
--
ALTER TABLE `materiale`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `cabluri`
--
ALTER TABLE `cabluri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pentru tabele `echipamente`
--
ALTER TABLE `echipamente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pentru tabele `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pentru tabele `inspectii_calitate`
--
ALTER TABLE `inspectii_calitate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `instrumente`
--
ALTER TABLE `instrumente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pentru tabele `materiale`
--
ALTER TABLE `materiale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `inspectii_calitate`
--
ALTER TABLE `inspectii_calitate`
  ADD CONSTRAINT `inspectii_calitate_ibfk_1` FOREIGN KEY (`id_reteta`) REFERENCES `retete` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
