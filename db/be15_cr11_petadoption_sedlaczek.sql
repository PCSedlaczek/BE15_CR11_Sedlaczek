-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2022 at 09:00 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `be15_cr11_petadoption_sedlaczek`
--
CREATE DATABASE IF NOT EXISTS `be15_cr11_petadoption_sedlaczek` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be15_cr11_petadoption_sedlaczek`;

-- --------------------------------------------------------

--
-- Table structure for table `adoptions`
--

CREATE TABLE `adoptions` (
  `id` int(11) NOT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_animal` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(35) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `location` varchar(95) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `species` varchar(10) DEFAULT NULL,
  `size` varchar(6) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `hobbies` varchar(255) DEFAULT NULL,
  `breed` varchar(30) DEFAULT NULL,
  `registered` date DEFAULT NULL,
  `status` enum('Available','Adopted','Reserved','Weaning','Recovering','Withdrawn','Deceased') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `image`, `location`, `description`, `species`, `size`, `age`, `gender`, `hobbies`, `breed`, `registered`, `status`) VALUES
(1, 'Spike', 'hedgehogs/arif-hidayat-mGQ5-MTqRbQ-unsplash.jpg', 'Wildtierhilfe Wien', NULL, 'Hedgehog', 'small', 4, 'male', NULL, '', '2018-02-02', 'Available'),
(2, 'Nero', 'rabbits/aneta-voborilova-HxfVwDszy2Q-unsplash.jpg', 'TierQuarTier Wien', NULL, 'Bunny', 'medium', 3, 'male', NULL, '', '2019-06-30', 'Available'),
(3, 'Cookie', 'rabbits/erik-jan-leusink-SDX4KWIbA-unsplash.jpg', 'TierQuarTier Wien', NULL, 'Bunny', 'medium', 1, 'female', NULL, '', '2021-06-20', 'Available'),
(4, 'Coco', 'rodents/nils-schirmer-cKYM8KMwaUQ-unsplash.jpg', 'TierQuarTier Wien', NULL, 'Guinea pig', 'medium', 2, 'female', NULL, '', '2020-06-22', 'Available'),
(5, 'Jack Frost', 'dogs/lui-peng-ybHtKz5He9Y-unsplash.jpg', 'TierQuarTier Wien', NULL, 'Dog', 'large', 9, 'male', NULL, 'Samoyed', '2017-09-05', 'Available'),
(6, 'Sushi', 'dogs/flouffy-g2FtlFrc164-unsplash.jpg', 'TierQuarTier Wien', NULL, 'Dog', 'large', 2, 'female', NULL, 'Australian Shepherd', '2021-05-10', 'Available'),
(7, 'Toto', 'dogs/victor-grabarczyk-N04FIfHhv_k-unsplash.jpg', 'TierQuarTier Wien', NULL, 'Dog', 'medium', 5, 'male', NULL, 'Terrier', '2019-04-05', 'Available'),
(8, 'Rambo', 'dogs/flouffy-qEO5MpLyOks-unsplash.jpg', 'TierQuarTier Wien', NULL, 'Dog', 'medium', 11, 'male', NULL, 'Schnauzer', '2019-04-05', 'Available'),
(9, 'Stella', 'cats/fabrice-audio-ZDLYDbIeYpw-unsplash.jpg', 'TierQuarTier Wien', NULL, 'Cat', 'large', 10, 'female', NULL, 'British Longhair', '2015-06-25', 'Available'),
(10, 'Sandy', 'reptiles/stijn-swinnen-DXoWetDELis-unsplash.jpg', 'Wildtierhilfe Wien', NULL, 'Snake', 'medium', 5, 'male', NULL, 'Beauty rat snake', '2019-03-14', 'Available'),
(11, 'Cassiopeia', 'reptiles/marcus-dietachmair-4JUscQ_9UrA-unsplash.j', 'Wildtierhilfe Wien', NULL, 'Tortoise', 'medium', 12, 'female', NULL, 'Greek tortoise', '2015-07-02', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(35) DEFAULT NULL,
  `lname` varchar(35) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(26) DEFAULT NULL,
  `address` varchar(95) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(53) DEFAULT 'Austria',
  `img` varchar(50) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `status` varchar(5) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `phone`, `address`, `city`, `zip`, `country`, `img`, `pwd`, `status`) VALUES
(1, 'Petra', 'Sedlaczek', 'p.sedlaczek@drei.at', '06706016567', 'Traviatagasse 12-16/13/5', 'Wien', '1230', 'Austria', '62428c48e73f2.png', 'de35f4a917be45f4bf19e30314833d69ae16710964689fbb196dbf62e69e79f4', 'user'),
(2, 'Petra', 'Sedlaczek', 'petra.sedlaczek@drei.at', '06706016567', 'Traviatagasse 12-16/13/5', 'Wien', '1230', 'Austria', 'admin.jpg', 'de35f4a917be45f4bf19e30314833d69ae16710964689fbb196dbf62e69e79f4', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoptions`
--
ALTER TABLE `adoptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`fk_user`),
  ADD KEY `fk_animal` (`fk_animal`);

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoptions`
--
ALTER TABLE `adoptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoptions`
--
ALTER TABLE `adoptions`
  ADD CONSTRAINT `adoptions_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `adoptions_ibfk_2` FOREIGN KEY (`fk_animal`) REFERENCES `animals` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
