-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2017. Már 12. 22:47
-- Kiszolgáló verziója: 10.1.16-MariaDB
-- PHP verzió: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `liber`
--
CREATE DATABASE IF NOT EXISTS `liber` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `liber`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `account`
--

CREATE TABLE `account` (
  `id` int(100) NOT NULL,
  `company_profile_id` int(100) NOT NULL,
  `permission_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `deletedAccount` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `account`
--

INSERT INTO `account` (`id`, `company_profile_id`, `permission_id`, `user_id`, `deletedAccount`) VALUES
(1, 1, 2, 1, 0),
(47, 40, 5, 47, 0),
(48, 41, 4, 48, 0),
(49, 1, 3, 49, 0),
(50, 1, 3, 50, 0),
(51, 42, 5, 51, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `company_profile`
--

CREATE TABLE `company_profile` (
  `id` int(100) NOT NULL,
  `contactName` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `taxNumber` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_hungarian_ci NOT NULL,
  `addressZipCode` varchar(10) COLLATE utf8_hungarian_ci NOT NULL,
  `addressCountry` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `addressCity` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `addressStreet` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `logo` varchar(500) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `company_profile`
--

INSERT INTO `company_profile` (`id`, `contactName`, `taxNumber`, `description`, `addressZipCode`, `addressCountry`, `addressCity`, `addressStreet`, `logo`) VALUES
(1, '', '', '', '', '', '', '', ''),
(40, 'Kovács Anna', '12346578', 'Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! ', '1146', 'Magyarország', 'Budapest', 'Ajtósi Dűrer sor 19-21', ''),
(41, 'Dekoratőr János', '3216547', 'Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása! Ez itt a szolgáltató cég leírása!', '1111', 'Magyarország', 'Budapest', 'Pista utca 3.', ''),
(42, 'Tóth Sándor', '123465789', 'Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! Ez itt egy leírás! ', '1146', 'Magyarország', 'Budapest', 'Tóth utca 6.', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `equipment`
--

CREATE TABLE `equipment` (
  `id` int(100) NOT NULL,
  `name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `price` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `price_unit` varchar(20) COLLATE utf8_hungarian_ci NOT NULL,
  `time` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `time_unit` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `amount` int(100) NOT NULL,
  `available_amount` int(100) NOT NULL,
  `description` varchar(1000) COLLATE utf8_hungarian_ci NOT NULL,
  `owner_id` int(100) NOT NULL,
  `owner_name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `venue_id` int(100) NOT NULL,
  `venue_name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `price`, `price_unit`, `time`, `time_unit`, `amount`, `available_amount`, `description`, `owner_id`, `owner_name`, `venue_id`, `venue_name`) VALUES
(5, 'Egyszerű szék', '40', 'Forint', '24', 'Óra', 200, 0, 'Ez a felszerelés leírása! Ez a felszerelés leírása! Ez a felszerelés leírása! Ez a felszerelés leírása! Ez a felszerelés leírása! Ez a felszerelés leírása! Ez a felszerelés leírása! Ez a felszerelés leírása! Ez a felszerelés leírása! ', 47, 'Dürlin Kft.', 17, 'Dürer-Ház'),
(6, 'Sima asztal', '2000', 'Forint', '1', 'Óra', 30, 0, 'Nagyon szép asztal!', 47, 'Dürlin Kft.', 17, 'Dürer-Ház'),
(7, 'Körasztal', '1000', 'Forint', '24', 'Óra', 2, 0, 'Nagyon csúcs!', 48, 'Dekoráció Kft.', 0, 'Nem helyhez kötött'),
(8, 'Sörpad', '20000', 'Forint', '24', 'Óra', 200, 0, 'sdipjsadpsdajdjsa', 51, 'Corvina kft.', 18, 'Sziget fesztivál');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `event`
--

CREATE TABLE `event` (
  `id` int(100) NOT NULL,
  `time_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `customer_id` int(100) NOT NULL,
  `organizer_id` int(100) NOT NULL,
  `venue_id` int(100) NOT NULL,
  `status` varchar(15) COLLATE utf8_hungarian_ci NOT NULL DEFAULT 'pending',
  `flag_company` tinyint(4) NOT NULL DEFAULT '1',
  `flag_customer` tinyint(4) NOT NULL DEFAULT '1',
  `flag_service_provider` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `event`
--

INSERT INTO `event` (`id`, `time_start`, `time_end`, `customer_id`, `organizer_id`, `venue_id`, `status`, `flag_company`, `flag_customer`, `flag_service_provider`) VALUES
(23, '2017-05-05 03:00:00', '2017-05-06 03:00:00', 49, 47, 17, 'canceled', 1, 0, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `event_equipment`
--

CREATE TABLE `event_equipment` (
  `id` int(100) NOT NULL,
  `equipment_id` int(100) NOT NULL,
  `event_id` int(100) NOT NULL,
  `company_id` int(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `status` varchar(15) COLLATE utf8_hungarian_ci NOT NULL DEFAULT 'pending',
  `status_service_provider` varchar(15) COLLATE utf8_hungarian_ci NOT NULL,
  `flag_company` tinyint(1) NOT NULL DEFAULT '1',
  `flag_customer` tinyint(1) NOT NULL DEFAULT '1',
  `flag_service_provider` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `event_equipment`
--

INSERT INTO `event_equipment` (`id`, `equipment_id`, `event_id`, `company_id`, `amount`, `status`, `status_service_provider`, `flag_company`, `flag_customer`, `flag_service_provider`) VALUES
(66, 7, 23, 48, 2, 'canceled', 'active', 0, 0, 0),
(67, 6, 23, 47, 20, 'canceled', '', 0, 0, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `event_service`
--

CREATE TABLE `event_service` (
  `id` int(100) NOT NULL,
  `service_id` int(100) NOT NULL,
  `event_id` int(100) NOT NULL,
  `company_id` int(100) NOT NULL,
  `status` varchar(15) COLLATE utf8_hungarian_ci NOT NULL DEFAULT 'pending',
  `status_service_provider` varchar(15) COLLATE utf8_hungarian_ci NOT NULL,
  `flag_company` tinyint(4) NOT NULL DEFAULT '1',
  `flag_customer` tinyint(4) NOT NULL DEFAULT '1',
  `flag_service_provider` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `event_service`
--

INSERT INTO `event_service` (`id`, `service_id`, `event_id`, `company_id`, `status`, `status_service_provider`, `flag_company`, `flag_customer`, `flag_service_provider`) VALUES
(14, 14, 23, 48, 'canceled', 'active', 1, 0, 0),
(15, 13, 23, 47, 'canceled', '', 0, 0, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `favorite`
--

CREATE TABLE `favorite` (
  `id` int(100) NOT NULL,
  `account_id` int(100) NOT NULL,
  `item_id` int(100) NOT NULL,
  `item_type` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `favorite`
--

INSERT INTO `favorite` (`id`, `account_id`, `item_id`, `item_type`) VALUES
(1, 49, 47, 'organizer'),
(2, 47, 48, 'serviceProvider');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `content` varchar(1000) COLLATE utf8_hungarian_ci NOT NULL,
  `sender_id` int(100) NOT NULL,
  `receiver_id` int(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `message`
--

INSERT INTO `message` (`id`, `content`, `sender_id`, `receiver_id`, `time`) VALUES
(82, 'szia!', 48, 49, '2017-03-12 16:58:07'),
(83, 'szia!', 49, 48, '2017-03-12 16:58:43');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `messagepartner`
--

CREATE TABLE `messagepartner` (
  `id` int(100) NOT NULL,
  `master_id` int(100) NOT NULL,
  `partner_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `messagepartner`
--

INSERT INTO `messagepartner` (`id`, `master_id`, `partner_id`) VALUES
(23, 49, 47),
(24, 47, 49),
(25, 50, 51),
(26, 51, 50),
(27, 49, 48),
(28, 48, 49);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `permission`
--

CREATE TABLE `permission` (
  `id` int(100) NOT NULL,
  `permissionName` varchar(300) COLLATE utf8_hungarian_ci NOT NULL,
  `venues` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Use of Venue Page',
  `services` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Use of ServicePage',
  `equipments` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Use of Equipments Page',
  `messages` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Use of Messages Page',
  `settings` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Use of Settings Page',
  `browse` tinyint(1) NOT NULL COMMENT 'Use of Browse Page',
  `favorites` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Use of Favorites Page',
  `events` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Use of Events Page',
  `block` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Block Users\\Items',
  `userManage` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Manage Users',
  `confirm` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Confirm Actions '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `permission`
--

INSERT INTO `permission` (`id`, `permissionName`, `venues`, `services`, `equipments`, `messages`, `settings`, `browse`, `favorites`, `events`, `block`, `userManage`, `confirm`) VALUES
(2, 'Full Admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(3, 'customer', 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0),
(4, 'service', 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(5, 'organizer', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `service`
--

CREATE TABLE `service` (
  `id` int(100) NOT NULL,
  `name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `price` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `price_unit` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `time` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `time_unit` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_hungarian_ci NOT NULL,
  `owner_id` int(100) NOT NULL,
  `owner_name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `venue_id` int(100) NOT NULL,
  `venue_name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `service`
--

INSERT INTO `service` (`id`, `name`, `price`, `price_unit`, `time`, `time_unit`, `description`, `owner_id`, `owner_name`, `venue_id`, `venue_name`) VALUES
(13, 'Alap pincérszolgálat', '20.000', 'Forint', '24', 'Óra', 'Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! ', 47, 'Dürlin Kft.', 17, 'Dürer-Ház'),
(14, 'Alap dekoráció', '20000', 'Forint', '24', 'Óra', 'Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! Ez a szolgáltatás leírása! ', 48, 'Dekoráció Kft.', 0, 'Nem helyhez kötött');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

CREATE TABLE `user` (
  `id` int(100) NOT NULL,
  `name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Name of user',
  `email` varchar(100) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Email of user',
  `password` varchar(100) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'password of user',
  `phoneNumber` varchar(20) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'phonenumber of user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `phoneNumber`) VALUES
(1, 'Admin', 'admin@admin.com', 'adminadmin', '12346579'),
(47, 'Dürlin Kft.', 'durlin@gmail.com', 'durlin', '06201234567'),
(48, 'Dekoráció Kft.', 'dekoracio@gmail.com', 'dekoracio', '06203216457'),
(49, 'Almássy Tamás', 'tomi@tomi.com', 'tomi', '06307894561'),
(50, 'Rápolthy Bálint', 'balint@gmail.com', 'balint', '06123456789'),
(51, 'Corvina kft.', 'corvina@gmail.com', 'corvina', '06312654789');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `venue`
--

CREATE TABLE `venue` (
  `id` int(100) NOT NULL,
  `name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `price` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `price_unit` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `time` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `time_unit` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_hungarian_ci NOT NULL,
  `owner_id` int(100) NOT NULL,
  `owner_name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `venue`
--

INSERT INTO `venue` (`id`, `name`, `price`, `price_unit`, `time`, `time_unit`, `description`, `owner_id`, `owner_name`) VALUES
(17, 'Dürer-Ház', '40.000', 'Forint', '24', 'Óra', 'Ez a helyszín leírása! Ez a helyszín leírása! Ez a helyszín leírása! Ez a helyszín leírása! Ez a helyszín leírása! Ez a helyszín leírása! Ez a helyszín leírása! Ez a helyszín leírása! Ez a helyszín leírása! Ez a helyszín leírása! Ez a helyszín leírása! ', 47, 'Dürlin Kft.'),
(18, 'Sziget fesztivál', '20000', 'Forint', '24', 'Óra', 'PJIOASDSDJFPFPIASDHN', 51, 'Corvina kft.');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `event_equipment`
--
ALTER TABLE `event_equipment`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `event_service`
--
ALTER TABLE `event_service`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `messagepartner`
--
ALTER TABLE `messagepartner`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `account`
--
ALTER TABLE `account`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT a táblához `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT a táblához `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT a táblához `event`
--
ALTER TABLE `event`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT a táblához `event_equipment`
--
ALTER TABLE `event_equipment`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT a táblához `event_service`
--
ALTER TABLE `event_service`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT a táblához `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT a táblához `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT a táblához `messagepartner`
--
ALTER TABLE `messagepartner`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT a táblához `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT a táblához `service`
--
ALTER TABLE `service`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT a táblához `venue`
--
ALTER TABLE `venue`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
