-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 27, 2020 at 11:43 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zyder_chocolate_factory`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(25) DEFAULT NULL,
  `price` int(20) NOT NULL,
  `expiry_date` varchar(255) NOT NULL,
  `imagename` varchar(255) DEFAULT NULL,
  `likes` int(20) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `quantity`, `price`, `expiry_date`, `imagename`, `likes`) VALUES
(32, 'Bites', 80, 5, '2023-10-31', 'choco6.jpg', 5),
(30, 'Whoppers', 1000, 5, '2022-10-31', 'choco5.jpg', 2),
(29, 'Choco Bar', 100, 50, '2023-10-31', 'choco4.jpg', 6),
(31, 'Dark Chocolate', 1000, 50, '2023-10-31', 'choco3.jpg', 20),
(27, 'diary milk', 50, 10, '2020-11-20', 'choco2.jpg', 2),
(33, 'swiss', 80, 50, '2023-10-31', 'choco9.jpg', 10),
(35, 'swiss2', 1000, 50, '2022-10-31', 'choco9.jpg', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
