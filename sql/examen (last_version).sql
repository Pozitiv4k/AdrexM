-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: mai 01, 2025 la 06:44 PM
-- Versiune server: 10.4.32-MariaDB
-- Versiune PHP: 8.2.12

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
-- Structură tabel pentru tabel `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `about`
--

INSERT INTO `about` (`id`, `description`, `image_path`) VALUES
(1, 'AdrexCam oferă soluții complete de supraveghere video, configurare echipamente CCTV, creare și mentenanță rețele locale. Ne ocupăm de instalarea, întreținerea și monitorizarea sistemelor de securitate și echipamente de rețea, oferind servicii rapide, sigure și personalizate pentru locuințe și afaceri. Cu o echipă de profesioniști și echipamente de ultimă generație, garantăm performanță și fiabilitate în fiecare proiect.', 'uploads/adrex_about.png');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `cabluri`
--

CREATE TABLE `cabluri` (
  `id` int(11) NOT NULL,
  `tip_cablu` varchar(255) DEFAULT NULL,
  `cantitate` int(11) DEFAULT NULL,
  `activ` tinyint(1) DEFAULT 1,
  `user_id` int(11) NOT NULL,
  `descriere` text DEFAULT NULL,
  `imagine` varchar(255) DEFAULT NULL,
  `pret_piata` decimal(10,2) DEFAULT 0.00,
  `pret_montator` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `cabluri`
--

INSERT INTO `cabluri` (`id`, `tip_cablu`, `cantitate`, `activ`, `user_id`, `descriere`, `imagine`, `pret_piata`, `pret_montator`) VALUES
(2, 'Cablu | Ethernet | Cat5 | UTP 4x2', 20054, 1, 1, 'Кабель для передачи данных UNV UTP, Cat.5e (4X2X24AWG), Медь (100%) 1m\nКабель для передачи данных UNV UTP, Cat.5e (4X2X24AWG), Медь (100%) 1m\nКабель для передачи данных UNV UTP, Cat.5e (4X2X24AWG), Медь (100%) 1m\n', NULL, 0.00, 0.00),
(5, 'Cablu | Ethernet | Cat5 | UTP Extern 4x2', 1800, 1, 1, 'Наружный кабель для передачи данных UNV UTP, Cat.5, Медь, 1m\nНаружный кабель для передачи данных UNV UTP, Cat.5, Медь, 1m\nНаружный кабель для передачи данных UNV UTP, Cat.5, Медь, 1m', NULL, 0.00, 0.00),
(7, 'Cablu | UTP extern cu tros Cat.5E CU', 10000, 1, 1, 'Экранированный кабель для передачи данных с тросом ZOLL FTP ,Cat.5e (24AWG (0.52mm)), Медь (100%), 1m', NULL, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `carousel`
--

CREATE TABLE `carousel` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `carousel`
--

INSERT INTO `carousel` (`id`, `title`, `image_path`, `created_at`, `is_active`) VALUES
(3, 'Securitate video', 'uploads/ai-powered-device-concept.jpg', '2025-04-29 18:03:41', 1),
(4, 'Mentenanță', 'uploads/optical-lens-technology-background-purple-blue-gradient.jpg', '2025-04-29 18:03:50', 1),
(5, 'Rețialistică', 'uploads/surveillance-data-security-technology.jpg', '2025-04-29 18:04:00', 1);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `numar_serie` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `village` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `config_file_path` varchar(500) DEFAULT NULL,
  `memento` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `clients`
--

INSERT INTO `clients` (`id`, `login`, `phone`, `numar_serie`, `city`, `village`, `email`, `config_file_path`, `memento`, `created_at`, `updated_at`) VALUES
(1, 'Pozitiv4k', '068989572', 'xc43111111', 'Cahul', '', 'alimcotet6@gmail.com', 'uploads/2.png,../depozit/uploads/1744550415_cablu.PNG,../depozit/uploads/1744550420_cablu.PNG', '12532', '2025-01-08 11:21:57', '2025-04-13 18:08:30'),
(2, '204071', '068301571', 'xc432', 'Cantemir', 'Baimaclia', 'laviniadez69@gmail.com', 'uploads/voobly-v2.7.5.9.exe', '12', '2025-01-08 11:57:37', '2025-01-08 11:57:37'),
(3, 'Qwerty', '123456789', 'xXCdf', 'Cahul', 'Burlacu', 'asdfgh2@fadf', 'uploads/1736339448_giphy-ezgif.com-crop.gif,uploads/1736339765_msxml (1).msi,uploads/1736339770_msxml (1).msi', '`12', '2025-01-08 12:30:48', '2025-03-30 16:54:11'),
(4, 'Pozitiv4k', 'xx', '', 'Cahul', '', '1@sd', NULL, '1', '2025-01-11 10:04:34', '2025-01-11 10:04:34'),
(5, '56543Der', '23254634432', '231', 'Cantemir', '', '345@df', '', '4', '2025-01-29 12:41:36', '2025-03-30 16:12:14'),
(6, '23121', '21312313', '', 'Cahul', 'Burlacu', '2131231@43342', NULL, '12', '2025-03-30 15:55:45', '2025-03-30 15:55:45'),
(7, '23121', '21312313', '', 'Cahul', 'Burlacu', '2131231@43342', NULL, '12', '2025-03-30 15:56:50', '2025-03-30 15:56:50'),
(8, '1321234', '41235423', '231', 'Cahul', 'Burlacu', '23112312@ssdaf', NULL, '1', '2025-03-30 15:57:01', '2025-03-30 15:57:01'),
(9, 'Pozitiv4k', '068989572', '231', 'Cantemir', 'Baimaclia', 'aSASD@FGSD', NULL, '11', '2025-04-05 12:07:05', '2025-04-05 12:07:05'),
(10, 'iihaibullinchasda', 'asdas', 'asdas', 'Cahul', 'Burlacu', 'sada@f', NULL, '1', '2025-04-05 12:07:47', '2025-04-05 12:07:47'),
(11, 'Pozitiv4kasd', 'sada', 'as', 'Cahul', 'Roșu', 'dasd@sdad', NULL, '1', '2025-04-05 12:11:31', '2025-04-05 12:11:31'),
(12, 'Pozitiv4kasd', 'sada', 'as', 'Cahul', 'Roșu', 'dasd@sdad', NULL, '1', '2025-04-05 12:12:44', '2025-04-05 12:12:44'),
(13, 'Pozitiv4k', '068989572', 'xc431', 'Leova', 'Iargara', 'dsa@sd', NULL, '111', '2025-04-05 12:12:59', '2025-04-05 12:12:59'),
(14, 'dsfsd', 'sdfsdf', 'sdfsdf', 'Cahul', 'Roșu', '234e@sad', NULL, 'dzfzdf', '2025-04-05 12:13:54', '2025-04-05 12:13:54'),
(15, 'Pozitiv4k', '068989572', 'Hey1mh3r3', 'Cahul', 'Roșu', 'sda@sad', NULL, '1', '2025-04-13 17:51:11', '2025-04-13 17:51:11'),
(16, 'Pozitiv4k', '068989572', 'Hey1mh3r3', 'Cahul', '', '2133', NULL, '', '2025-04-13 17:53:17', '2025-04-13 17:53:17');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `echipamente`
--

CREATE TABLE `echipamente` (
  `id` int(11) NOT NULL,
  `tip_echipament` varchar(255) DEFAULT NULL,
  `model_echipament` varchar(255) DEFAULT NULL,
  `numar_serie` varchar(255) DEFAULT NULL,
  `activ` tinyint(1) DEFAULT 1,
  `user_id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `descriere` text DEFAULT NULL,
  `imagine` varchar(255) DEFAULT NULL,
  `pret_piata` decimal(10,2) DEFAULT 0.00,
  `pret_montator` decimal(10,2) DEFAULT 0.00,
  `disponibil` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `echipamente`
--

INSERT INTO `echipamente` (`id`, `tip_echipament`, `model_echipament`, `numar_serie`, `activ`, `user_id`, `model`, `descriere`, `imagine`, `pret_piata`, `pret_montator`, `disponibil`) VALUES
(40, 'Dahua', 'DH-SD2A500HB GN-AW-PV-S2', '12345678', 1, 2, '', 'Dahua DH-SD2A500HB-GN-A-PV-S2 5MP 4 mm Full-color 5 Mp,1/2.8\" 5 Мп CMOS STARVIS , 2560 x 1920, Full Color Мин. Освещение Цвет 0,005 Lux при F1,6 Ч/Б 0,0005 Lux при F1,6 Фиксированный объектив 4мм (80,4°)H.265/H.264(25к/с) Поворот 0~355° по горизонтали и -0~90° по вертикали 16x цифровой зум Встроенный ИК-подсветка 30м / LED подсветка 30m ИК и белый свет, три режима ночного видения. Встроенный микрофон и динамик Аудио 1 вход, 1 выход. Обнаружение человека IVS функции Пересечение, Вторжение. Звуковая и световая сигнализация. Встроенный прожектор и сирена 110 dB Порт 1 x 100Мбит/с Wi-Fi IEEE802.11b/g/n, двойная антенна ONVIF Поддержка Micro SD карта до 512GB Питание DC 12В/1,5A ± 10 % PoE Потребление 3.5Вт Макс. 12,95 Вт. В комплект не входит блок питания. Материал пластик Рабочие условия -30°C ~ +60°C Относительная влажность менее 95% IP66 молниезащита TVS 2000 В Защита от перенапряжения защита от скачков напряжения . Гарантия 3 года.\r\n', 'uploads/1743859982_dahua.PNG', 1940.00, 1700.00, 1),
(41, 'Dahua', 'DH-SD2A500HB GN-AW-PV-S2', 'Hey1mh3r4', 1, 2, '', 'Dahua DH-SD2A500HB-GN-A-PV-S2 5MP 4 mm Full-color 5 Mp,1/2.8\" 5 Мп CMOS STARVIS , 2560 x 1920, Full Color Мин. Освещение Цвет 0,005 Lux при F1,6 Ч/Б 0,0005 Lux при F1,6 Фиксированный объектив 4мм (80,4°)H.265/H.264(25к/с) Поворот 0~355° по горизонтали и -0~90° по вертикали 16x цифровой зум Встроенный ИК-подсветка 30м / LED подсветка 30m ИК и белый свет, три режима ночного видения. Встроенный микрофон и динамик Аудио 1 вход, 1 выход. Обнаружение человека IVS функции Пересечение, Вторжение. Звуковая и световая сигнализация. Встроенный прожектор и сирена 110 dB Порт 1 x 100Мбит/с Wi-Fi IEEE802.11b/g/n, двойная антенна ONVIF Поддержка Micro SD карта до 512GB Питание DC 12В/1,5A ± 10 % PoE Потребление 3.5Вт Макс. 12,95 Вт. В комплект не входит блок питания. Материал пластик Рабочие условия -30°C ~ +60°C Относительная влажность менее 95% IP66 молниезащита TVS 2000 В Защита от перенапряжения защита от скачков напряжения . Гарантия 3 года.\r\n', 'uploads/1743860184_dahua.PNG', 1940.00, 170.00, 1),
(42, 'Dahua', 'DH-SD2A500HB GN-AW-PV-S2', '48575443678291F', 1, 2, '', 'Dahua DH-SD2A500HB-GN-A-PV-S2 5MP 4 mm Full-color 5 Mp,1/2.8\" 5 Мп CMOS STARVIS , 2560 x 1920, Full Color Мин. Освещение Цвет 0,005 Lux при F1,6 Ч/Б 0,0005 Lux при F1,6 Фиксированный объектив 4мм (80,4°)H.265/H.264(25к/с) Поворот 0~355° по горизонтали и -0~90° по вертикали 16x цифровой зум Встроенный ИК-подсветка 30м / LED подсветка 30m ИК и белый свет, три режима ночного видения. Встроенный микрофон и динамик Аудио 1 вход, 1 выход. Обнаружение человека IVS функции Пересечение, Вторжение. Звуковая и световая сигнализация. Встроенный прожектор и сирена 110 dB Порт 1 x 100Мбит/с Wi-Fi IEEE802.11b/g/n, двойная антенна ONVIF Поддержка Micro SD карта до 512GB Питание DC 12В/1,5A ± 10 % PoE Потребление 3.5Вт Макс. 12,95 Вт. В комплект не входит блок питания. Материал пластик Рабочие условия -30°C ~ +60°C Относительная влажность менее 95% IP66 молниезащита TVS 2000 В Защита от перенапряжения защита от скачков напряжения . Гарантия 3 года.\r\n', 'uploads/1743860184_dahua.PNG', 1940.00, 1700.00, 1),
(43, 'Dahua', 'DH-SD2A500HB GN-AW-PV-S2', '48575446312HFF4', 1, 1, '', 'Camera IP', 'uploads/1743961795_Снимок.PNG', 100.00, 120.00, 1),
(44, 'Dahua', 'DH-SD2A500HB GN-AW-PV-S2', 'Hey1mh3r3213', 1, 1, '', '11111', 'uploads/1744559040_Снимок.PNG', 1111.00, 1111.00, 1),
(45, 'Dahua', 'DH-SD2A500HB GN-AW-PV-S2', 'Hey1mh3r3', 1, 1, '', '1111', 'uploads/1744565796_Снимок.PNG', 1111.00, 11111.00, 1);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `echipamente_clienti`
--

CREATE TABLE `echipamente_clienti` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `echipament_id` int(11) NOT NULL,
  `data_montaj` date NOT NULL,
  `tehnician` varchar(255) DEFAULT NULL,
  `observatii` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(15, 'Bakery', 'bad@user', 'Salut Bakery', '2024-06-09 19:00:24'),
(16, 'Bakery', 'alimcotet6@gmail.com', 'Salut Bakery', '2025-04-16 14:39:59'),
(17, 'Bakery', 'alimcotet6@gmail.com', 'Salut Bakery', '2025-04-16 14:45:22'),
(18, 'Bakery', 'dfgfg@fds', 'Salut Bakery', '2025-04-16 14:46:39'),
(19, 'Bakery', 'alimcotet6@gmail.com', 'Salut Bakery', '2025-04-16 14:55:46'),
(20, 'Bakery', 'alimcotet6@gmail.com', 'Salut Bakery', '2025-04-16 14:56:38'),
(21, 'Bakery', 'alimcotet6@gmail.com', 'Salut Bakery', '2025-04-16 14:57:28');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `instrumente`
--

CREATE TABLE `instrumente` (
  `id` int(11) NOT NULL,
  `tip_instrument` varchar(255) DEFAULT NULL,
  `cantitate` int(11) DEFAULT NULL,
  `activ` tinyint(1) DEFAULT 1,
  `user_id` int(11) NOT NULL,
  `descriere` text DEFAULT NULL,
  `imagine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `instrumente`
--

INSERT INTO `instrumente` (`id`, `tip_instrument`, `cantitate`, `activ`, `user_id`, `descriere`, `imagine`) VALUES
(1, 'Instrument | Box Instrumente', 2, 1, 1, NULL, NULL),
(2, 'Instrument | Tester Ethernet', 5, 1, 1, NULL, NULL),
(3, 'Instrument | Clește de sertizare', 3, 1, 1, NULL, NULL),
(4, 'Instrument | Multimetru', 4, 1, 2, NULL, NULL),
(5, 'Instrument | Cutter cablu', 7, 1, 2, NULL, NULL),
(6, 'Ciocan', 31, 1, 1, NULL, NULL),
(7, 'Șurubelniță', 3, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL,
  `prenume` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `adresa` text NOT NULL,
  `serviciu` varchar(100) NOT NULL,
  `descriere` text NOT NULL,
  `data_creare` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `leads`
--

INSERT INTO `leads` (`id`, `nume`, `prenume`, `email`, `telefon`, `adresa`, `serviciu`, `descriere`, `data_creare`) VALUES
(1, 'Bakery', 'Fantai', 'bakery@co', '12345678', 'Cahul,Cahul 1', 'Alt serviciu', 'Aș dori instalarea a 3 camere de supraveghere video cât m-ar costa', '2025-04-16 14:23:15'),
(2, 'Bakery', 'Fantai', 'bakery@co', '12345678', 'Cahul,Cahul 1', 'Alt serviciu', 'Aș dori instalarea a 3 camere de supraveghere video cât m-ar costa', '2025-04-16 14:23:29'),
(3, 'Bakery', 'Fantai', 'bakery@co', '12345678', 'Cahul,Cahul 1', 'Alt serviciu', 'Aș dori instalarea a 3 camere de supraveghere video cât m-ar costa', '2025-04-16 14:25:15'),
(4, 'Bakery', 'Fantai', 'bad@user', '123456789', 'Cahul,Cahul 1str armean1', 'Consultare', 'Consultatie', '2025-04-16 14:26:03'),
(5, 'Bakery', 'Fantai', 'bad@user', '123456789', 'Cahul,Cahul 1str armean1', 'Consultare', 'Consultatie', '2025-04-16 14:27:05'),
(6, 'Bakery', 'Fantai', 'bad@user', '123456789', 'Cahul,Cahul 1str armean1', 'Consultare', 'Consultatie', '2025-04-16 14:27:16'),
(7, 'Bakery', 'Fantai', 'dsa@sd', '12345678', '111', 'Consultare', 'dasdasdasd', '2025-04-16 14:27:31'),
(8, 'Bakery', 'Fantai', 'alimcotet6@gmail.com', '12345678', '111', 'Consultare', 'ghjk', '2025-04-16 14:31:04'),
(9, 'Bakery', 'Fantai', 'alimcotet6@gmail.com', '12345678', '111', 'Consultare', 'ghjk', '2025-04-16 14:31:23'),
(10, 'Bakery', 'Fantai', 'alimcotet6@gmail.com', '12345678', '111', 'Consultare', 'ghjk', '2025-04-16 14:31:25'),
(11, 'Bakery', 'Fantai', 'alimcotet6@gmail.com', '12345678', '111', 'Consultare', 'ghjk', '2025-04-16 14:31:37'),
(12, 'Bakery', 'Fantai', 'alimcotet6@gmail.com', '12345678', '111', 'Consultare', 'ghjk', '2025-04-16 14:33:13'),
(13, 'Bakery', 'Fantai', 'laviniadez69@gmail.com', '12345678', 'sadasdasd', 'Consultare', 'asdasdasdasfdsa', '2025-04-16 14:33:25'),
(14, 'Bakery', 'Fantai', 'alimcotet6@gmail.com', '12345678', '111', 'Consultare', 'dvf', '2025-04-16 15:07:53');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `categorie` enum('clienti','materiale','utilizatori') NOT NULL,
  `mesaj` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `logs`
--

INSERT INTO `logs` (`id`, `categorie`, `mesaj`, `created_at`) VALUES
(1, 'clienti', 'superuser a modificat clientul Qwerty: Telefon: 123456789, SN: xXCdf, Oras: Cahul, Sat: Burlacu, Email: asdfgh2@fadf, Memento: `12.', '2025-03-30 16:54:11'),
(2, 'utilizatori', 'superuser a adăugat utilizatorul 12341243 cu rol Administrator.', '2025-03-30 16:59:53'),
(3, 'materiale', 'Material ID=2 (Tip=Cablu | Ethernet | Cat5 | UTP 4x2, Cantitate=1212) a fost transferat de la superuser către 321432.', '2025-03-30 17:00:14'),
(4, 'utilizatori', 'superuser a adăugat utilizatorul superuserdsfsf cu rol User.', '2025-03-30 17:09:17'),
(5, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 17:48:13'),
(6, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 17:48:44'),
(7, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 17:48:59'),
(8, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 17:49:06'),
(9, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 17:49:18'),
(10, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 17:49:24'),
(11, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 17:49:32'),
(12, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 18:02:52'),
(13, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 18:14:25'),
(14, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 18:14:33'),
(15, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 18:14:37'),
(16, '', 'A fost adăugat un nou echipament: Camera Dahua DH-SD2A500HB GN-AW-PV-S2, număr serie: Hey1mh3r3.', '2025-03-30 18:41:47'),
(17, '', 'A fost adăugat un nou echipament: , număr serie: Hey1mh3r23.', '2025-03-30 18:41:59'),
(18, '', 'A fost adăugat un nou echipament: Camera Dahua DH-SD2A500HB GN-AW-PV-S2, număr serie: Hey1mh3r354.', '2025-03-30 18:42:09'),
(19, '', 'A fost adăugat un nou echipament: Camera Dahua DH-SD2A500HB GN-AW-PV-S2, număr serie: 53434trfgddfhg.', '2025-03-30 18:42:23'),
(20, '', 'A fost adăugat un nou echipament: Camera Dahua DH-SD2A500HB GN-AW-PV-S2, număr serie: 3242345.', '2025-03-30 18:43:42'),
(21, 'materiale', 'A fost adăugat un nou material: .', '2025-03-30 18:45:40'),
(22, '', 'A fost adăugat un echipament: Camera Dahua DH-SD2A500HB GN-AW-PV-S2 cu numărul de serie fgfhjklfjhkhjhlhjklhklhjklhjkl.', '2025-03-30 18:50:23'),
(23, 'utilizatori', 'superuser a revocat drepturile de administrator pentru utilizatorul 12341243.', '2025-04-05 12:02:12'),
(24, 'clienti', 'A fost adăugat un nou client: Pozitiv4k.', '2025-04-05 12:07:05'),
(25, 'clienti', 'A fost adăugat un nou client: iihaibullinchasda.', '2025-04-05 12:07:47'),
(26, 'clienti', 'superuser a adaugat clientul : Telefon: , SN: , Oras: , Sat: , Email: , Memento: .', '2025-04-05 12:09:21'),
(27, 'clienti', 'superuser a adaugat clientul : Telefon: , SN: , Oras: , Sat: , Email: , Memento: .', '2025-04-05 12:10:07'),
(28, 'clienti', ' a adaugat clientul Pozitiv4kasd: Telefon: sada, SN: as, Oras: Cahul, Sat: Roșu, Email: dasd@sdad, Memento: 1.', '2025-04-05 12:11:31'),
(29, 'clienti', 'A fost adăugat un nou client: .', '2025-04-05 12:11:31'),
(30, 'clienti', 'superuser a modificat clientul Pozitiv4kasd: Telefon: sada, SN: as, Oras: Cahul, Sat: Roșu, Email: dasd@sdad, Memento: 1.', '2025-04-05 12:12:44'),
(31, 'clienti', 'superuser a modificat clientul Pozitiv4k: Telefon: 068989572, SN: xc431, Oras: Leova, Sat: Iargara, Email: dsa@sd, Memento: 111.', '2025-04-05 12:12:59'),
(32, 'clienti', 'superuser a adaugat clientul  cu datele: dsfsd: Telefon: sdfsdf, SN: sdfsdf, Oras: Cahul, Sat: Roșu, Email: 234e@sad, Memento: dzfzdf.', '2025-04-05 12:13:54'),
(33, 'materiale', 'Echipamentul ID=42 (Tip=Dahua, Nr. Serie=48575443678291F) a fost transferat de la superuser către angajat.', '2025-04-06 17:52:52'),
(34, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=22) a fost transferat de la superuser către Superman.', '2025-04-06 17:53:54'),
(35, '', 'superuser a programat taskul ID 1 pentru superuser la data 2025-04-09.', '2025-04-09 18:11:16'),
(36, '', 'superuser a transmis taskul ID 1 către superuser, programat pentru 2025-04-09.', '2025-04-09 18:19:05'),
(37, '', 'superuser a transmis taskul ID 1 către superuser, programat pentru 2025-04-09.', '2025-04-09 18:24:08'),
(38, 'clienti', 'superuser a modificat clientul Pozitiv4k: Telefon: 068989572, SN: xc431111, Oras: Cahul, Sat: , Email: alimcotet6@gmail.com, Memento: 12532.', '2025-04-13 13:18:59'),
(39, 'clienti', 'superuser a modificat clientul Pozitiv4k: Telefon: 068989572, SN: xc431111, Oras: Cahul, Sat: , Email: alimcotet6@gmail.com, Memento: 12532.', '2025-04-13 13:19:42'),
(40, 'clienti', 'superuser a modificat clientul Pozitiv4k: Telefon: 068989572, SN: xc431111, Oras: Cahul, Sat: , Email: alimcotet6@gmail.com, Memento: 12532.', '2025-04-13 13:20:15'),
(41, 'clienti', 'superuser a modificat clientul Pozitiv4k: Telefon: 068989572, SN: xc431111, Oras: Cahul, Sat: , Email: alimcotet6@gmail.com, Memento: 12532.', '2025-04-13 13:20:20'),
(42, 'materiale', 'Echipamentul ID=41 (Tip=Dahua, Nr. Serie=Hey1mh3r4) a fost transferat de la superuser către angajat.', '2025-04-13 17:02:19'),
(43, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către superuser.', '2025-04-13 17:16:21'),
(44, 'materiale', 'Echipamentul ID=40 (Tip=Dahua, Nr. Serie=12345678) a fost transferat de la superuser către angajat.', '2025-04-13 17:16:37'),
(45, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:18:04'),
(46, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:18:25'),
(47, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:18:27'),
(48, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:18:43'),
(49, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:19:13'),
(50, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:20:15'),
(51, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:22:04'),
(52, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:23:00'),
(53, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:23:16'),
(54, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:23:37'),
(55, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:24:06'),
(56, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:24:12'),
(57, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:30:24'),
(58, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:34:40'),
(59, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către superuser.', '2025-04-13 17:34:48'),
(60, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:34:56'),
(61, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:35:40'),
(62, 'materiale', 'Material ID=27 (Tip=Scoabe , Cantitate=1) a fost transferat de la superuser către angajat.', '2025-04-13 17:35:47'),
(63, '', 'superuser a programat taskul ID 2 pentru superuser la data 2025-04-13.', '2025-04-13 17:44:01'),
(64, '', 'superuser a programat taskul ID 2 pentru superuser la data 2025-04-13.', '2025-04-13 17:45:53'),
(65, '', 'superuser a programat taskul ID 2 pentru superuser la data 2025-04-13.', '2025-04-13 17:46:04'),
(66, '', 'superuser a transmis taskul ID 3 către superuser, programat pentru 2025-04-13.', '2025-04-13 17:46:43'),
(67, 'clienti', 'superuser a adaugat clientul  cu datele: Pozitiv4k: Telefon: 068989572, SN: Hey1mh3r3, Oras: Cahul, Sat: Roșu, Email: sda@sad, Memento: 1.', '2025-04-13 17:51:11'),
(68, 'clienti', 'superuser a adaugat clientul  cu datele: Pozitiv4k: Telefon: 068989572, SN: Hey1mh3r3, Oras: Cahul, Sat: , Email: 2133, Memento: .', '2025-04-13 17:53:17'),
(69, 'clienti', 'superuser a modificat clientul Pozitiv4k: Telefon: 068989572, SN: xc431111, Oras: Cahul, Sat: , Email: alimcotet6@gmail.com, Memento: 12532.', '2025-04-13 18:08:21'),
(70, 'clienti', 'superuser a modificat clientul Pozitiv4k: Telefon: 068989572, SN: xc43111111, Oras: Cahul, Sat: , Email: alimcotet6@gmail.com, Memento: 12532.', '2025-04-13 18:08:30'),
(71, 'clienti', 'superuser a modificat clientul Pozitiv4k: Telefon: 068989572, SN: xc43111111, Oras: Cahul, Sat: , Email: alimcotet6@gmail.com, Memento: 12532.', '2025-04-13 18:09:02'),
(72, 'clienti', 'superuser a modificat clientul Pozitiv4k: Telefon: 068989572, SN: xc43111111, Oras: Cahul, Sat: , Email: alimcotet6@gmail.com, Memento: 12532.', '2025-04-13 18:09:22'),
(73, 'clienti', 'superuser a modificat clientul Pozitiv4k: Telefon: 068989572, SN: xc43111111, Oras: Cahul, Sat: , Email: alimcotet6@gmail.com, Memento: 12532.', '2025-04-13 18:09:25');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `loguri_client`
--

CREATE TABLE `loguri_client` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `tip` enum('echipament','cablu','material') DEFAULT NULL,
  `nume` varchar(255) DEFAULT NULL,
  `detalii` text DEFAULT NULL,
  `data_log` datetime DEFAULT current_timestamp(),
  `user_log` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `materiale`
--

CREATE TABLE `materiale` (
  `id` int(11) NOT NULL,
  `tip_material` varchar(255) DEFAULT NULL,
  `cantitate` int(11) DEFAULT NULL,
  `activ` tinyint(1) DEFAULT 1,
  `user_id` int(11) NOT NULL,
  `descriere` text DEFAULT NULL,
  `imagine` varchar(255) DEFAULT NULL,
  `pret_piata` decimal(10,2) DEFAULT 0.00,
  `pret_montator` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `materiale`
--

INSERT INTO `materiale` (`id`, `tip_material`, `cantitate`, `activ`, `user_id`, `descriere`, `imagine`, `pret_piata`, `pret_montator`) VALUES
(27, 'Scoabe ', 61, 1, 1, 'Scoabe plastic 4mm', NULL, 0.25, 0.25),
(28, 'Scoabe ', 22, 1, 6, NULL, NULL, 0.00, 0.00),
(29, 'Scoabe ', 17, 1, 2, NULL, NULL, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `price_list`
--

CREATE TABLE `price_list` (
  `id` int(11) NOT NULL,
  `item` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `features` text DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `price_list`
--

INSERT INTO `price_list` (`id`, `item`, `price`, `features`) VALUES
(1, 'Instalarea sistemelor de securitate inteligentă', 500.00, 'În prețul dat este inclus instalarea și configurarea a unui punct de acces (camera video,echipament rețea ,alt echipament de securitate sau rețea internă)'),
(2, 'Mentenanță', 300.00, 'Mentenanța este un lucru esențial,serviciul de mentenanță incepe de la prețul indicat mai sus'),
(3, 'Consultare', 0.00, 'Consultarea în privința instalării sistemelor de securitate inteligente ,sau crearea rețelor locale începe de la 0-100 LEU');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `icon`) VALUES
(1, 'Servicii de mentenanță', 'Mentenanța sistemelor de securitate ,și a rețelelor locale', 'flaticon-camera'),
(2, 'Instalare', 'Instalarea sistemelor de supraveghere video,a lacatelor inteligente ,sisteme de securitate inteligente', 'flaticon-cctv'),
(3, 'Configurări', 'Configurarea sitemelor de securitate inteligente și a echipamentelor de rețea ', 'flaticon-surveillance');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `tip` varchar(50) DEFAULT NULL,
  `descriere` text DEFAULT NULL,
  `adresa` text DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `status` enum('nou','programat','transmis','in_desfasurare','finalizat','replanificat') DEFAULT 'nou',
  `assigned_user` varchar(100) DEFAULT NULL,
  `data_programata` date DEFAULT NULL,
  `data_creare` timestamp NOT NULL DEFAULT current_timestamp(),
  `asignat_la` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `tasks`
--

INSERT INTO `tasks` (`id`, `tip`, `descriere`, `adresa`, `client_id`, `status`, `assigned_user`, `data_programata`, `data_creare`, `asignat_la`) VALUES
(1, 'Instalare', 'Betax', 'As', 1, '', NULL, '2025-04-09', '2025-04-09 17:55:43', '0000-00-00 00:00:00'),
(2, NULL, '111', '111', 1, 'nou', NULL, '2025-04-13', '2025-04-13 17:37:47', '0000-00-00 00:00:00'),
(3, NULL, '111', '111', 1, '', NULL, '2025-04-13', '2025-04-13 17:38:50', '0000-00-00 00:00:00'),
(4, NULL, '11', '111', 1, 'nou', NULL, NULL, '2025-04-13 17:39:33', NULL),
(5, NULL, '111', '111', 1, 'nou', NULL, NULL, '2025-04-13 17:41:55', NULL),
(6, NULL, '111', '111', 12, 'nou', NULL, NULL, '2025-04-13 17:42:19', NULL);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `imagine` varchar(255) DEFAULT NULL,
  `nume_prenume` varchar(100) NOT NULL,
  `functie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `team`
--

INSERT INTO `team` (`id`, `imagine`, `nume_prenume`, `functie`) VALUES
(3, 'tehnician2.jpg', 'Andrei Mocanu', 'Tehnician/Montator'),
(5, 'tehnician.png', 'Tudor Teodorescu', 'Tehnician/Montator (Superior)'),
(6, 'tehnician2.jpg', 'Catalin Diacon', 'Rețialist'),
(8, 'tehnician.png', 'Martin Bernard', 'Rețialist(Superior)');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `tipuri`
--

CREATE TABLE `tipuri` (
  `id` int(11) NOT NULL,
  `categorie` varchar(50) NOT NULL,
  `tip` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `tipuri`
--

INSERT INTO `tipuri` (`id`, `categorie`, `tip`) VALUES
(3, 'material', 'Hârtie'),
(4, 'material', 'Cartuș'),
(5, 'cablu', 'Cablu Ethernet'),
(6, 'cablu', 'Cablu USB'),
(7, 'instrument', 'Ciocan'),
(8, 'instrument', 'Șurubelniță'),
(18, 'instrument', 'Surubelnita X'),
(21, 'echipament', 'Camera Dahua DH-SD2A500HB GN-AW-PV-S2'),
(22, 'echipament', 'Camera Dahua DH-SD2A500HB GN-AW-PV-S2'),
(23, 'echipament', 'Camera Dahua DH-SD2A500HB GN-AW-PV-S3'),
(24, 'echipament', 'Camera Dahua DH-SD2A500HB GN-AW-PV-S3');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_superuser` tinyint(1) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_superuser`, `user_id`, `created_at`) VALUES
(1, 'superuser', '$2y$10$pSH6Bv8rY772EaWXuiIpsesTjXtjDArDxU2VSqvFmKJ3qqvm9WxWu', 1, 1, '2024-10-12 19:19:42'),
(2, 'angajat', '$2y$10$uACoek07uf5h21YX0/OaYOday54O5xVBE2bTPrtRtKxTL7SBVF.tG', 0, 2, '2024-10-12 19:20:01'),
(4, 'admin', '$2y$10$Me0Pb7uHmxJWNynthiyaUOTJPYeLcKpXjRpfs94eZAJkLxp4FJKVy', 0, 4, '2024-10-12 19:20:35'),
(5, 'angajat2', '$2y$10$/1grbw7PwCXsJFSAIt3P6uR3KuAqB7zpCinbByn5WlNVLunpVg1US', 0, 5, '2024-10-12 19:48:20'),
(6, 'Superman', '$2y$10$2c1O4ybERllrGzwcvBlT1OYCB1pNIdU.sBw5PayRVEyJfVfC8czeG', 0, 6, '2024-11-06 16:06:11'),
(7, 'HellCat', '$2y$10$vMs6xps3gDXO0b1LS9sfUur2CMsi4YCq/b/hvMxzajd4H/VL1pFJe', 1, 7, '2024-12-08 08:20:23'),
(8, 'BetaJ', '$2y$10$3Pbbm70PpLyVkBRXB9M12.r7q5Xc3Hq3tknZ/Rlb9VLzYbfRVqSbW', 0, NULL, '2025-03-30 14:47:38'),
(9, 'bob22', '$2y$10$HurSNcH.Esy34MEE0QbkZui1UcqDPIoFIorU7SY7E3iwg73y5if6u', 0, NULL, '2025-03-30 14:52:52'),
(10, 'bob23', '$2y$10$/hGvPmjWpe2cmTFuRFM35.AgwpNiJS992Hf9GkKzHGuc/T6G3Ws/q', 0, NULL, '2025-03-30 14:54:04'),
(11, '123215342', '$2y$10$.REjKHF4SFuJL.byVdtheukkLBGo5pKznsVY4wu9pNHnao6l434Ki', 0, NULL, '2025-03-30 15:03:12'),
(12, '321432', '$2y$10$QDudamfQnRZi8EnqbyU.JOp5kfrjp7jeh.8bMuw4iWlrAH1gvc7Xq', 0, NULL, '2025-03-30 15:23:49'),
(13, '321432', '$2y$10$Av9x7rS1fyFVCf1rULQdUesrWgqq.Hs9tIQSh7seOlsRQkZ6Uv6.K', 0, NULL, '2025-03-30 15:25:50'),
(14, '12341243', '$2y$10$UqgiWWMBL3yX31BSa2mzwuZrn/.KBT.9/1DDTsCIiSZBCZtyxkaLu', 0, NULL, '2025-03-30 15:59:53'),
(15, 'superuserdsfsf', '$2y$10$slQcb6OrkAFHOAcERLxKsuD9xigTMb7gEPjgQPt.tU9ZRPnukAN.2', 0, NULL, '2025-03-30 16:09:17');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `cabluri`
--
ALTER TABLE `cabluri`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `echipamente`
--
ALTER TABLE `echipamente`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `echipamente_clienti`
--
ALTER TABLE `echipamente_clienti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `echipament_id` (`echipament_id`);

--
-- Indexuri pentru tabele `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `instrumente`
--
ALTER TABLE `instrumente`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `loguri_client`
--
ALTER TABLE `loguri_client`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `materiale`
--
ALTER TABLE `materiale`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `price_list`
--
ALTER TABLE `price_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexuri pentru tabele `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `tipuri`
--
ALTER TABLE `tipuri`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pentru tabele `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pentru tabele `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pentru tabele `echipamente`
--
ALTER TABLE `echipamente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pentru tabele `echipamente_clienti`
--
ALTER TABLE `echipamente_clienti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pentru tabele `instrumente`
--
ALTER TABLE `instrumente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pentru tabele `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pentru tabele `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT pentru tabele `loguri_client`
--
ALTER TABLE `loguri_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `materiale`
--
ALTER TABLE `materiale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pentru tabele `price_list`
--
ALTER TABLE `price_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pentru tabele `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pentru tabele `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pentru tabele `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pentru tabele `tipuri`
--
ALTER TABLE `tipuri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `echipamente_clienti`
--
ALTER TABLE `echipamente_clienti`
  ADD CONSTRAINT `echipamente_clienti_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `echipamente_clienti_ibfk_2` FOREIGN KEY (`echipament_id`) REFERENCES `echipamente` (`id`);

--
-- Constrângeri pentru tabele `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
