-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2022 at 07:51 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inotes`
--

-- --------------------------------------------------------

--
-- Table structure for table `ankit`
--

CREATE TABLE `ankit` (
  `sno` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `tstamp` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ankit`
--

INSERT INTO `ankit` (`sno`, `title`, `description`, `tstamp`) VALUES
(1, 'Hello', 'how are you all my friends', '2022-10-27 22:10:44'),
(2, 'hello', 'how are you ankit.', '2022-10-27 22:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `barun@gmail.com`
--

CREATE TABLE `barun@gmail.com` (
  `sno` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `tstamp` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barun@gmail.com`
--

INSERT INTO `barun@gmail.com` (`sno`, `title`, `description`, `tstamp`) VALUES
(1, 'Hello', 'how are you all my friends', '2022-10-27 21:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `deoshree@thakur`
--

CREATE TABLE `deoshree@thakur` (
  `sno` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `tstamp` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deoshree@thakur`
--

INSERT INTO `deoshree@thakur` (`sno`, `title`, `description`, `tstamp`) VALUES
(1, 'Deo', 'This is the test notes', '2022-10-26 20:53:13'),
(2, 'Deo', 'This is the test notes', '2022-10-26 20:53:32'),
(3, 'Deo', 'This is the test notes', '2022-10-26 20:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `pawan@sharma`
--

CREATE TABLE `pawan@sharma` (
  `sno` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `tstamp` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`fname`, `lname`, `uname`, `email`, `password`) VALUES
('Ankit', 'Bhardwaj', 'ankit', 'ankit@gmail.com', '$2y$10$msY.ZZ.G7NlEUA3DpXB6meWCiAWN5YGePSeF322//yK6Zn7gHLPJG'),
('Barun', 'Tiwary', 'barun@gmail.com', 'baruntiwary@gmail.com', '$2y$10$fqqCS1fI/pakJjBkCGI8xOZaOcySJiDOxBOQ1hJcjjtr0kh/zMvJm'),
('Deoshree', 'Thakur', 'deoshree@Thakur', 'deoshree@gmail.com', '$2y$10$MF0AmsRYeSHqTU2ArAD9hedKK5VcGd11GTbsTSNj/445sqBxytf1m'),
('Pawan', 'Sharma', 'pawan@sharma', 'pawan@sharma.gmail.com', '$2y$10$WTeviKq4TZJQIn791k6Nt.O.mrJ0a0byEzs.90xWEvYz.AwPW7faa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ankit`
--
ALTER TABLE `ankit`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `barun@gmail.com`
--
ALTER TABLE `barun@gmail.com`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `deoshree@thakur`
--
ALTER TABLE `deoshree@thakur`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `pawan@sharma`
--
ALTER TABLE `pawan@sharma`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uname`),
  ADD UNIQUE KEY `uname` (`uname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ankit`
--
ALTER TABLE `ankit`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barun@gmail.com`
--
ALTER TABLE `barun@gmail.com`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deoshree@thakur`
--
ALTER TABLE `deoshree@thakur`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pawan@sharma`
--
ALTER TABLE `pawan@sharma`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
