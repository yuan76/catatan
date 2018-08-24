-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 05, 2018 at 08:23 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sf_db019`
--

-- --------------------------------------------------------

--
-- Table structure for table `parameter`
--

CREATE TABLE `parameter` (
  `id_param` int(11) NOT NULL,
  `nama` text NOT NULL,
  `param1` text,
  `param2` text,
  `param3` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parameter`
--

INSERT INTO `parameter` (`id_param`, `nama`, `param1`, `param2`, `param3`) VALUES
(1, 'jml_user', '154', '4137', '083892903267'),
(2, 'admin', '32f6f1361a29d7e19de9beeb92a9f4683d2022003b0731f3688482f09addffba', '142d43c36a95fc9fed5e5bf921780485b3eda0cd0aff9ad12ddc957ec2504e27', NULL),
(3, 'note', 'addd', 'sd', NULL),
(4, 'coba', '1', '2', '3'),
(10, 'dbank_mandiri', '014_862395', 'bca swarga', 'andini nu fatya'),
(9, 'dbank_iman', '014_862395', 'bca swarga', 'andini nu fatya'),
(11, 'dbank_iwan', '014_862395', 'bca swarga', 'andini nu fatya'),
(12, 'seq', '30', NULL, NULL),
(13, 'seq', '30', NULL, NULL),
(14, 'Paytren', 'type', 'pyt', NULL),
(15, 'Oriflame', 'type', 'ori', NULL),
(16, 'Eco Racing', 'type', 'eco', NULL),
(17, '99000', 'harga', 'pyt', 'bln6'),
(18, '175000', 'harga', 'pyt', 'th1'),
(19, '20000', 'basil', 'pyt', 'bln6'),
(20, '50000', 'basil', 'pyt', 'th1'),
(22, 'frame02.png', 'framee', 'ini theme abcde', NULL),
(21, 'frame01.png', 'framee', 'ini theme bla bla bla', NULL),
(23, 'frame3.png', 'frame', 'pyt', NULL),
(24, 'frame2.png', 'frame', 'pyt', NULL),
(25, 'frame1.png', 'frame', 'pyt', NULL),
(26, 'framePat1.png', 'frame', 'pyt', NULL),
(27, 'SF3.png', 'promote', 'pyt', '250,650,120,120,20,700'),
(28, 'SF2.png', 'promote', 'pyt', '490,530,120,120,490,680'),
(29, 'SF1.png', 'promote', 'pyt', '490,340,120,120,330,400'),
(30, 'framePat2.png', 'frame', 'pyt', NULL),
(31, 'frameSF1.png', 'frame', 'pyt', NULL),
(32, 'frameSF1.png', 'frame', 'eco', NULL),
(33, 'frameEco1.png', 'frame', 'eco', NULL),
(34, 'frameEco2.png', 'frame', 'eco', NULL),
(35, 'Eco2.png', 'promote', 'eco', '20,500,120,120,160,550'),
(36, 'Eco3.png', 'promote', 'eco', '30,80,120,120,30,230');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parameter`
--
ALTER TABLE `parameter`
  ADD PRIMARY KEY (`id_param`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parameter`
--
ALTER TABLE `parameter`
  MODIFY `id_param` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
