-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 20 Ağu 2024, 12:24:42
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `login`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `fullName` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `confirm` tinyint(1) DEFAULT NULL,
  `code` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `userinfo`
--

INSERT INTO `userinfo` (`id`, `fullName`, `phone`, `email`, `password`, `confirm`, `code`) VALUES
(65, 'yunus emre aynas', '05541515004', 'aynasyunusemre7@gmail.com', '$2y$10$Gvh/XD1t8v.hkOFrynFbtOtntknfeSpE4xtT.Z2tBs9LfVfaJ20qG', 1, 9289),
(66, 'yunus emre aynas', '05541515004', 'yunusemreaynas@gmail.com', '$2y$10$6ti8S1EvmkaJkVlvEABr2OmM970pD83U63IiHanCm0w.2QX1OnTYa', 1, 3968);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
