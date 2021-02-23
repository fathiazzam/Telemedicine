-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2018 at 10:24 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_telemedic`
--

-- --------------------------------------------------------

--
-- Table structure for table `list_call`
--

CREATE TABLE `list_call` (
  `id_call` int(11) NOT NULL,
  `id_caller` int(11) NOT NULL,
  `id_receiver` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `video` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `create_date` date NOT NULL,
  `phone` bigint(18) NOT NULL,
  `autho` int(1) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `fullName`, `gender`, `create_date`, `phone`, `autho`, `status`) VALUES
(1, 'azzam', 'a@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Azzam Fatih', 'Laki-Lak', '2018-07-03', 2147483647, 2, 0),
(5, 'syah', 'syah@lala.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Syah Alam', 'Laki-laki', '0000-00-00', 89898989, 2, 0),
(6, 'alam', 'alam@lala.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Alam Syah Dr', 'Laki-laki', '0000-00-00', 8976517537, 1, 0),
(7, 'far', 'far@lala.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Far ouq', 'Laki-laki', '0000-00-00', 2147483647, 1, 0),
(8, 'siarikui', 'javajazz@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'dr. Anizzul', 'Laki-laki', '0000-00-00', 81332179757, 1, 0),
(9, 'fafa', 'fafa@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Maulida Syarifa', 'perempuan', '0000-00-00', 81575661815, 1, 0),
(10, 'Arringga', 'nilamartur25201@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'Arringga Nilam Pranasiwi', 'perempuan', '0000-00-00', 81775098965, 1, 0),
(11, 'Meidin', 'meidinpaulamaldini@gmail.com', '16d2e27cef59e943aeb71fcf14d7e886', 'Meidin Paula Maldini', 'perempuan', '0000-00-00', 83835149376, 2, 0),
(12, 'Hanif', 'hanif.anshafy@gmail.com', 'e172dd95f4feb21412a692e73929961e', 'Hanif Andi Setyawan', 'Laki-laki', '0000-00-00', 83857224044, 1, 0),
(13, 'Adi', 'adifilardimahardiman@gmail.com', '36eafced6501c4973bcb6a4f5ce87fbc', 'Adi Filardi Mahardiman', 'Laki-laki', '0000-00-00', 83854884546, 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `list_call`
--
ALTER TABLE `list_call`
  ADD PRIMARY KEY (`id_call`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `list_call`
--
ALTER TABLE `list_call`
  MODIFY `id_call` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
