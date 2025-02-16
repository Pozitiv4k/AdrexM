-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: iun. 09, 2024 la 09:02 PM
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
-- Structură tabel pentru tabel `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id` int(11) NOT NULL,
  `nume` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `ingrediente`
--

INSERT INTO `ingrediente` (`id`, `nume`) VALUES
(1, 'Făină albă'),
(2, 'Făină integrală'),
(3, 'Făină de secară'),
(4, 'Făină fără gluten'),
(5, 'Făină neagră'),
(6, 'Cartofi'),
(7, 'Apă'),
(8, 'Drojdie'),
(9, 'Sare'),
(10, 'Semințe'),
(11, 'Ulei de măsline'),
(12, 'Zahăr'),
(13, 'Ovăz'),
(14, 'Miere'),
(15, 'Scorțișoară'),
(16, 'Cacao'),
(17, 'Ciocolată'),
(18, 'Vanilie'),
(19, 'Lapte'),
(20, 'Unt'),
(21, 'Ouă'),
(22, 'Mere'),
(23, 'Portocale'),
(24, 'Banane'),
(25, 'Căpșuni'),
(26, 'Afine'),
(27, 'Alune'),
(28, 'Nuci'),
(29, 'Fistic'),
(30, 'Mac'),
(31, 'Pudră de copt'),
(32, 'Sodă de copt'),
(33, 'Oțet'),
(34, 'Iaurt'),
(35, 'Brânză'),
(36, 'Smântână'),
(37, 'Fructe uscate'),
(38, 'Stafide'),
(39, 'Cireșe confiate'),
(40, 'Lămâie'),
(41, 'Gălbenușuri'),
(42, 'Albușuri'),
(43, 'Fulgere de ovăz'),
(44, 'Grașime vegetală'),
(45, 'Cereale integrale'),
(46, 'Piper'),
(47, 'Usturoi'),
(48, 'Ceapă'),
(49, 'Mărar'),
(50, 'Pătrunjel'),
(51, 'Busuioc'),
(52, 'Ardei'),
(53, 'Morcovi'),
(54, 'Broccoli'),
(55, 'Conopidă'),
(56, 'Spanac'),
(57, 'Rucola'),
(58, 'Rosiile'),
(59, 'Salata verde'),
(60, 'Castraveți'),
(61, 'Dovlecei'),
(62, 'Vinete'),
(63, 'Fasole'),
(64, 'Lintea'),
(65, 'Orez'),
(66, 'Cus cus'),
(67, 'Quinoa'),
(68, 'Dovleac'),
(69, 'Ciuperci'),
(70, 'Avocado'),
(71, 'Ananas'),
(72, 'Piersici'),
(73, 'Prune'),
(74, 'Pepene galben'),
(75, 'Caise'),
(76, 'Mango'),
(77, 'Kiwis'),
(78, 'Pepene roșu'),
(79, 'Zmeură'),
(80, 'Caise'),
(81, 'Coacăze'),
(82, 'Papaya'),
(83, 'Nectarine'),
(84, 'Mure'),
(85, 'Piersici'),
(86, 'Coșulețe'),
(87, 'Cocoșat'),
(88, 'Pineapple'),
(89, 'Coconut'),
(90, 'Papaya'),
(91, 'Lime'),
(92, 'Avocado'),
(93, 'Grapefruit'),
(94, 'Guava'),
(95, 'Cherimoya'),
(96, 'Carambola'),
(97, 'Plums');

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
-- Structură tabel pentru tabel `neconformitati`
--

CREATE TABLE `neconformitati` (
  `id` int(11) NOT NULL,
  `nume_reteta` varchar(255) DEFAULT NULL,
  `actiuni_corective` varchar(255) DEFAULT NULL,
  `descriere` varchar(255) DEFAULT NULL,
  `data_neconformitate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `neconformitati`
--

INSERT INTO `neconformitati` (`id`, `nume_reteta`, `actiuni_corective`, `descriere`, `data_neconformitate`) VALUES
(36, 'Pâine cu Secară', 'Ingredientele neconforme: făină albă, apă, drojdie, sare', 'Ingredientele corecte: Făină de secară, Făină neagră, Cartofi', '2024-06-09 19:16:17'),
(37, 'Pâine cu Secară', 'Ingredientele neconforme: făină albă, apă, drojdie, sare', 'Ingredientele corecte: Făină de secară, Făină neagră, Cartofi', '2024-06-09 20:46:00'),
(38, 'Pâine cu Secară', 'Ingredientele corecte: Făină de secară, Făină neagră, Cartofi', 'Ingredientele neconforme: făină albă, apă, drojdie, sare', '2024-06-09 20:49:19');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `produse_ingrediente`
--

CREATE TABLE `produse_ingrediente` (
  `id` int(11) NOT NULL,
  `produs` varchar(255) NOT NULL,
  `ingredient` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `produse_ingrediente`
--

INSERT INTO `produse_ingrediente` (`id`, `produs`, `ingredient`) VALUES
(1, 'Pâine Albă', 'Făină albă, apă, drojdie, sare'),
(2, 'Pâine Integrală', 'Făină integrală, apă, drojdie, sare'),
(3, 'Pâine cu Secară', 'Făină de secară, făină albă, apă, drojdie, sare'),
(4, 'Baghetă', 'Făină albă, apă, drojdie, sare'),
(5, 'Chiflă', 'Făină albă, apă, drojdie, sare'),
(6, 'Pâine cu Semințe', 'Făină albă, semințe, apă, drojdie, sare'),
(7, 'Pâine fără Gluten', 'Făină fără gluten, apă, drojdie, sare'),
(8, 'Pâine Neagră', 'Făină neagră, apă, drojdie, sare'),
(9, 'Pâine cu Cartofi', 'Făină albă, cartofi, apă, drojdie, sare'),
(10, 'Focaccia', 'Făină albă, ulei de măsline, apă, drojdie, sare'),
(11, 'Croissant', 'Făină albă, unt, apă, drojdie, sare'),
(12, 'Brioșe', 'Făină albă, ouă, unt, lapte, drojdie, sare'),
(13, 'Pâine de Casa', 'Făină albă, apă, drojdie, sare'),
(14, 'Lipie', 'Făină albă, apă, drojdie, sare'),
(15, 'Bagel', 'Făină albă, apă, drojdie, sare, ouă, malai'),
(16, 'Bruschete', 'Pâine, usturoi, ulei de măsline, sare, piper'),
(17, 'Crackers', 'Făină albă, unt, sare, apă'),
(18, 'Grissini', 'Făină albă, ulei de măsline, sare, drojdie'),
(19, 'Panini', 'Pâine, prosciutto, mozzarella, rucola, ulei de măsline'),
(20, 'Tortilla', 'Făină albă, apă, sare, ulei de măsline'),
(21, 'Pretzel', 'Făină albă, apă, drojdie, sare, bicarbonat de sodiu'),
(22, 'Pita', 'Făină albă, apă, drojdie, sare, ulei de măsline'),
(23, 'Scone', 'Făină albă, unt, lapte, zahăr, ouă, praf de copt, sare'),
(24, 'Cornbread', 'Făină albă, făină de porumb, lapte, ouă, unt, zahăr, sare, praf de copt'),
(25, 'Biscuit', 'Făină albă, unt, lapte, sare, praf de copt'),
(26, 'Covrigi', 'Făină albă, apă, drojdie, sare, bicarbonat de sodiu'),
(27, 'Flatbread', 'Făină albă, apă, sare, ulei de măsline'),
(28, 'Muffin', 'Făină albă, zahăr, lapte, unt, ouă, praf de copt, sare'),
(29, 'Bun', 'Făină albă, lapte, unt, zahăr, ouă, drojdie, sare'),
(30, 'Roll', 'Făină albă, apă, drojdie, sare, zahăr, unt'),
(31, 'Donut', 'Făină albă, lapte, unt, zahăr, ouă, drojdie, sare'),
(32, 'Ciabatta', 'Făină albă, apă, sare, drojdie'),
(33, 'Mămăligă', 'Mălai, apă, sare'),
(34, 'Brioche', 'Făină albă, unt, lapte, zahăr, ouă, drojdie, sare'),
(35, 'Fougasse', 'Făină albă, apă, ulei de măsline, drojdie, sare, rozmarin'),
(36, 'Kaiser roll', 'Făină albă, apă, drojdie, sare, zahăr, unt'),
(37, 'Kulcha', 'Făină albă, apă, drojdie, sare, iaurt'),
(38, 'Roti', 'Făină albă, apă, sare'),
(39, 'Baguette', 'Făină albă, apă, drojdie, sare'),
(40, 'Cheesecake', 'Brânză de vaci, smântână, ouă, zahăr, unt, biscuiți'),
(41, 'Crostata', 'Făină albă, unt, zahăr, ouă, vanilie, fructe'),
(42, 'Eclair', 'Făină albă, unt, apă, ouă, sare'),
(43, 'Pandispan', 'Făină albă, ouă, zahăr, praf de copt, vanilie'),
(44, 'Tiramisu', 'Mascarpone, ouă, zahăr, cafea, biscuiți, cacao'),
(45, 'Muffin cu ciocolată', 'Făină albă, zahăr, lapte, unt, ouă, praf de copt, sare, ciocolată'),
(46, 'Prajitura cu mere', 'Făină albă, zahăr, unt, ouă, mere, scorțișoară, praf de copt'),
(47, 'Tort cu fructe', 'Făină albă, zahăr, unt, ouă, fructe, praf de copt'),
(48, 'Briosa cu ciocolată', 'Făină albă, zahăr, unt, ouă, lapte, ciocolată'),
(49, 'Tort cu ciocolată', 'Făină albă, zahăr, unt, ouă, ciocolată, praf de copt'),
(50, 'Placinta cu mere', 'Făină albă, unt, zahăr, ouă, mere, scorțișoară'),
(51, 'Placinta cu branza', 'Făină albă, unt, zahăr, ouă, brânză, vanilie'),
(52, 'Placinta cu dovleac', 'Făină albă, unt, zahăr, ouă, dovleac, scorțișoară'),
(53, 'Cheesecake cu fructe de padure', 'Brânză de vaci, smântână, ouă, zahăr, unt, fructe de padure'),
(54, 'Cheesecake cu ciocolata', 'Brânză de vaci, smântână, ouă, zahăr, unt, ciocolată'),
(55, 'Tarta cu capsuni', 'Făină albă, unt, zahăr, ouă, capsuni, praf de copt'),
(56, 'Tarta cu visine', 'Făină albă, unt, zahăr, ouă, visine, praf de copt'),
(57, 'Tarta cu piersici', 'Făină albă, unt, zahăr, ouă, piersici, praf de copt'),
(58, 'Tarta cu ciocolata', 'Făină albă, unt, zahăr, ouă, ciocolată, praf de copt'),
(59, 'Tarta cu mere', 'Făină albă, unt, zahăr, ouă, mere, scorțișoară, praf de copt'),
(60, 'Tarta cu nuci pecan', 'Făină albă, unt, zahăr, ouă, nuci pecan, sirop de arțar, praf de copt'),
(61, 'Tarta cu ciocolata si caramel', 'Făină albă, unt, zahăr, ouă, ciocolată, caramel, praf de copt'),
(62, 'Muffin cu morcovi', 'Făină albă, morcovi, zahăr, lapte, unt, ouă, praf de copt, scorțișoară, nucă'),
(63, 'Muffin cu afine', 'Făină albă, afine, zahăr, lapte, unt, ouă, praf de copt'),
(64, 'Muffin cu mere', 'Făină albă, mere, zahăr, lapte, unt, ouă, praf de copt, scorțișoară'),
(65, 'Muffin cu cirese', 'Făină albă, cireșe, zahăr, lapte, unt, ouă, praf de copt'),
(66, 'Muffin cu ciocolata si portocale', 'Făină albă, ciocolată, portocale, zahăr, lapte, unt, ouă, praf de copt'),
(67, 'Muffin cu scortisoara', 'Făină albă, scorțișoară, zahăr, lapte, unt, ouă, praf de copt'),
(68, 'Muffin cu dovleac', 'Făină albă, dovleac, zahăr, lapte, unt, ouă, praf de copt, scorțișoară'),
(69, 'Muffin cu ciocolata', 'Făină albă, ciocolată, zahăr, lapte, unt, ouă, praf de copt'),
(70, 'Muffin cu mere si scortisoara', 'Făină albă, mere, scorțișoară, zahăr, lapte, unt, ouă, praf de copt'),
(71, 'Muffin cu prune', 'Făină albă, prune, zahăr, lapte, unt, ouă, praf de copt'),
(72, 'Muffin cu nuci si stafide', 'Făină albă, nuci, stafide, zahăr, lapte, unt, ouă, praf de copt'),
(73, 'Cornbread cu miere', 'Făină albă, făină de porumb, miere, lapte, unt, ouă, praf de copt'),
(74, 'Cornbread cu branza', 'Făină albă, făină de porumb, brânză, lapte, unt, ouă, praf de copt'),
(75, 'Cornbread cu piper', 'Făină albă, făină de porumb, piper, lapte, unt, ouă, praf de copt'),
(76, 'Cornbread cu jalapenos', 'Făină albă, făină de porumb, jalapenos, lapte, unt, ouă, praf de copt'),
(77, 'Cornbread cu cheddar si bacon', 'Făină albă, făină de porumb, cheddar, bacon, lapte, unt, ouă, praf de copt'),
(78, 'Cornbread cu rosii si busuioc', 'Făină albă, făină de porumb, roșii, busuioc, lapte, unt, ouă, praf de copt'),
(79, 'Cornbread cu spanac si branza feta', 'Făină albă, făină de porumb, spanac, brânză feta, lapte, unt, ouă, praf de copt'),
(80, 'Cornbread cu afine', 'Făină albă, făină de porumb, afine, lapte, unt, ouă, praf de copt'),
(81, 'Cornbread cu mere si scortisoara', 'Făină albă, făină de porumb, mere, scorțișoară, lapte, unt, ouă, praf de copt'),
(82, 'Cornbread cu ciocolata si nuci', 'Făină albă, făină de porumb, ciocolată, nuci, lapte, unt, ouă, praf de copt'),
(83, 'Cornbread cu dovleac si scortisoara', 'Făină albă, făină de porumb, dovleac, scorțișoară, lapte, unt, ouă, praf de copt'),
(84, 'Cornbread cu banane si ciocolata', 'Făină albă, făină de porumb, banane, ciocolată, lapte, unt, ouă, praf de copt'),
(85, 'Cornbread cu mazare si menta', 'Făină albă, făină de porumb, mazăre, mentă, lapte, unt, ouă, praf de copt'),
(86, 'Cornbread cu ceapa verde si branza cheddar', 'Făină albă, făină de porumb, ceapă verde, cheddar, lapte, unt, ouă, praf de copt'),
(87, 'Cornbread cu cartofi dulci si sirop de artar', 'Făină albă, făină de porumb, cartofi dulci, sirop de arțar, lapte, unt, ouă, praf de copt'),
(88, 'Cornbread cu portocale si ghimbir', 'Făină albă, făină de porumb, portocale, ghimbir, lapte, unt, ouă, praf de copt'),
(89, 'Cornbread cu rosii uscate si masline', 'Făină albă, făină de porumb, roșii uscate, măsline, lapte, unt, ouă, praf de copt'),
(90, 'Cornbread cu lamaie si lavanda', 'Făină albă, făină de porumb, lămâie, lavandă, lapte, unt, ouă, praf de copt'),
(91, 'Cornbread cu prune si cimbru', 'Făină albă, făină de porumb, prune, cimbru, lapte, unt, ouă, praf de copt'),
(92, 'Cornbread cu nuci pecan si sirop de arțar', 'Făină albă, făină de porumb, nuci pecan, sirop de arțar, lapte, unt, ouă, praf de copt');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `produse_panificatie`
--

CREATE TABLE `produse_panificatie` (
  `id` int(11) NOT NULL,
  `nume` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `produse_panificatie`
--

INSERT INTO `produse_panificatie` (`id`, `nume`) VALUES
(1, 'Pâine Albă'),
(2, 'Pâine Integrală'),
(3, 'Pâine cu Secară'),
(4, 'Baghetă'),
(5, 'Chiflă'),
(6, 'Pâine cu Semințe'),
(7, 'Pâine fără Gluten'),
(8, 'Pâine Neagră'),
(9, 'Pâine cu Cartofi'),
(10, 'Focaccia'),
(11, 'Croissant'),
(12, 'Brioșe'),
(13, 'Pâine de Casa'),
(14, 'Lipie'),
(15, 'Bagel'),
(16, 'Bruschete'),
(17, 'Crackers'),
(18, 'Grissini'),
(19, 'Panini'),
(20, 'Tortilla'),
(21, 'Pretzel'),
(22, 'Pita'),
(23, 'Scone'),
(24, 'Cornbread'),
(25, 'Biscuit'),
(26, 'Covrigi'),
(27, 'Flatbread'),
(28, 'Muffin'),
(29, 'Bun'),
(30, 'Roll'),
(31, 'Donut'),
(32, 'Ciabatta'),
(33, 'Mămăligă'),
(34, 'Brioche'),
(35, 'Fougasse'),
(36, 'Kaiser roll'),
(37, 'Kulcha'),
(38, 'Roti'),
(39, 'Baguette'),
(40, 'Fougasse'),
(41, 'Bagel'),
(42, 'Cheesecake'),
(43, 'Crostata'),
(44, 'Eclair'),
(45, 'Pandispan'),
(46, 'Tiramisu'),
(47, 'Muffin cu ciocolată'),
(48, 'Prajitura cu mere'),
(49, 'Tort cu fructe'),
(50, 'Briosa cu ciocolată'),
(51, 'Tort cu ciocolată'),
(52, 'Placinta cu mere'),
(53, 'Placinta cu branza'),
(54, 'Placinta cu dovleac'),
(55, 'Cheesecake cu fructe de padure'),
(56, 'Cheesecake cu ciocolata'),
(57, 'Tarta cu capsuni'),
(58, 'Tarta cu visine'),
(59, 'Tarta cu piersici'),
(60, 'Tarta cu ciocolata'),
(61, 'Tarta cu mere'),
(62, 'Tarta cu nuci pecan'),
(63, 'Tarta cu ciocolata si caramel'),
(64, 'Muffin cu morcovi'),
(65, 'Muffin cu afine'),
(66, 'Muffin cu mere'),
(67, 'Muffin cu cirese'),
(68, 'Muffin cu ciocolata si portocale'),
(69, 'Muffin cu scortisoara'),
(70, 'Muffin cu dovleac'),
(71, 'Muffin cu ciocolata'),
(72, 'Muffin cu mere si scortisoara'),
(73, 'Muffin cu prune'),
(74, 'Muffin cu nuci si stafide'),
(75, 'Cornbread cu miere'),
(76, 'Cornbread cu branza'),
(77, 'Cornbread cu piper'),
(78, 'Cornbread cu jalapenos'),
(79, 'Cornbread cu cheddar si bacon'),
(80, 'Cornbread cu rosii si busuioc'),
(81, 'Cornbread cu spanac si branza feta'),
(82, 'Cornbread cu afine'),
(83, 'Cornbread cu mere si scortisoara'),
(84, 'Cornbread cu ciocolata si nuci'),
(85, 'Cornbread cu dovleac si scortisoara'),
(86, 'Cornbread cu banane si ciocolata'),
(87, 'Cornbread cu mazare si menta'),
(88, 'Cornbread cu ceapa verde si branza cheddar'),
(89, 'Cornbread cu cartofi dulci si sirop de artar'),
(90, 'Cornbread cu portocale si ghimbir'),
(91, 'Cornbread cu rosii uscate si masline'),
(92, 'Cornbread cu lamaie si lavanda'),
(93, 'Cornbread cu prune si cimbru'),
(94, 'Cornbread cu nuci pecan si sirop de arțar');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `retete`
--

CREATE TABLE `retete` (
  `id` int(11) NOT NULL,
  `nume` varchar(255) NOT NULL,
  `ingrediente` text NOT NULL,
  `parametri_calitate` text NOT NULL,
  `cantitati` varchar(255) DEFAULT NULL,
  `conditii` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `retete`
--

INSERT INTO `retete` (`id`, `nume`, `ingrediente`, `parametri_calitate`, `cantitati`, `conditii`) VALUES
(24, 'Pâine Albă', 'Făină albă, apă, drojdie, sare', '', 'Greutate: 500g', 'Umiditate: 30%'),
(25, 'Pâine Integrală', 'Făină integrală, apă, drojdie, sare', '', 'Greutate: 500g', 'Umiditate: 30%'),
(27, 'Baghetă', 'Făină albă, apă, drojdie, sare', '', 'Greutate: 250g', 'Umiditate: 25%'),
(28, 'Chiflă', 'Făină albă, apă, drojdie, sare', '', 'Greutate: 100g', 'Umiditate: 30%'),
(29, 'Pâine cu Semințe', 'Făină albă, apă, drojdie, sare, semințe', '', 'Greutate: 500g', 'Umiditate: 30%'),
(30, 'Pâine fără Gluten', 'Făină fără gluten, apă, drojdie, sare', '', 'Greutate: 500g', 'Umiditate: 30%'),
(31, 'Pâine Neagră', 'Făină neagră, apă, drojdie, sare', '', 'Greutate: 500g', 'Umiditate: 30%'),
(32, 'Pâine cu Cartofi', 'Făină albă, cartofi, apă, drojdie, sare', '', 'Greutate: 500g', 'Umiditate: 30%'),
(33, 'Focaccia', 'Făină albă, apă, drojdie, sare, ulei de măsline', '', 'Greutate: 500g', 'Umiditate: 30%'),
(37, 'Pâine cu Secară', 'Făină de secară, Făină neagră, Cartofi', '', '10/10', 'Umeditate 10%');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `trasabilitate`
--

CREATE TABLE `trasabilitate` (
  `id` int(11) NOT NULL,
  `id_reteta` int(11) DEFAULT NULL,
  `lot` varchar(255) NOT NULL,
  `data_productie` date NOT NULL,
  `detalii_trasabilitate` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_superuser` tinyint(1) DEFAULT 0,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_superuser`, `email`) VALUES
(1, 'admin1', 'superuser', 0, 'admin@admin.com'),
(3, 'superuser', 'super', 1, 'superuser@superuser.com');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `inspectii_calitate`
--
ALTER TABLE `inspectii_calitate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_reteta` (`id_reteta`);

--
-- Indexuri pentru tabele `neconformitati`
--
ALTER TABLE `neconformitati`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `produse_ingrediente`
--
ALTER TABLE `produse_ingrediente`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `produse_panificatie`
--
ALTER TABLE `produse_panificatie`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `retete`
--
ALTER TABLE `retete`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `trasabilitate`
--
ALTER TABLE `trasabilitate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_reteta` (`id_reteta`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pentru tabele `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT pentru tabele `inspectii_calitate`
--
ALTER TABLE `inspectii_calitate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `neconformitati`
--
ALTER TABLE `neconformitati`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pentru tabele `produse_ingrediente`
--
ALTER TABLE `produse_ingrediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT pentru tabele `produse_panificatie`
--
ALTER TABLE `produse_panificatie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT pentru tabele `retete`
--
ALTER TABLE `retete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pentru tabele `trasabilitate`
--
ALTER TABLE `trasabilitate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `inspectii_calitate`
--
ALTER TABLE `inspectii_calitate`
  ADD CONSTRAINT `inspectii_calitate_ibfk_1` FOREIGN KEY (`id_reteta`) REFERENCES `retete` (`id`);

--
-- Constrângeri pentru tabele `trasabilitate`
--
ALTER TABLE `trasabilitate`
  ADD CONSTRAINT `trasabilitate_ibfk_1` FOREIGN KEY (`id_reteta`) REFERENCES `retete` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
