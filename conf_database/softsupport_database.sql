-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 08, 2022 at 09:17 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `softsupport_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `name_customer` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `name_customer`, `city`) VALUES
(2, 'Efrei', 'Villejuif'),
(3, 'Société Générale', 'Fontenay-sous-Bois');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id_project` int(11) NOT NULL,
  `name_project` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status_project` varchar(50) NOT NULL,
  `id_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id_project`, `name_project`, `description`, `status_project`, `id_customer`) VALUES
(1, 'Webapp', 'A web application for Efrei developed in NodeJS.', 'In production', 2),
(2, 'Chatbot', 'A chatbot for Efrei developed in Java.', 'Under test', 2),
(3, 'Portfolio', 'A portfolio developed in ReactJS.', 'In development', 3),
(4, 'App Migration', 'Webapp migration to the cloud', 'In development', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` int(11) NOT NULL,
  `name_ticket` varchar(100) NOT NULL,
  `incident_details` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `creation_date` date NOT NULL,
  `id_reporter` int(11) NOT NULL,
  `id_dev` int(11) DEFAULT NULL,
  `id_project` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id_ticket`, `name_ticket`, `incident_details`, `status`, `creation_date`, `id_reporter`, `id_dev`, `id_project`) VALUES
(1, 'DNS probleme', 'There is a problem on the dns server', 'Done', '2022-03-31', 7, 6, 1),
(2, 'Homepage bug', 'Cannot acces to the home page', 'Done', '2022-05-02', 7, 6, 3),
(3, 'Connection', 'Problem', 'Work in progress', '2022-05-05', 5, 6, 1),
(4, 'Redirection login page', 'Problem redirection ', 'Work in progress', '2022-06-05', 5, 6, 1),
(5, 'Problem 3', 'problem chatbot', 'Waiting for support', '2022-06-05', 5, NULL, 2),
(6, 'Ticket 1', 'Problem 1', 'Waiting for support', '2022-04-07', 5, NULL, 1),
(7, 'Network', 'Network problem', 'Waiting for support', '2022-06-07', 5, NULL, 2),
(9, 'Redirection WAF', 'The web app firewall doesn\'t work correctly ', 'Waiting for support', '2022-06-07', 5, NULL, 4),
(10, 'Admin access', 'The admin have no longer access to his account', 'Done', '2022-06-07', 7, 6, 1),
(11, 'Webapp update', 'The new version of the webapp causes problems', 'Cancelled', '2022-06-07', 7, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `isAdmin` tinyint(4) NOT NULL,
  `isDev` tinyint(4) NOT NULL,
  `isReporter` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `first_name`, `last_name`, `mail`, `password`, `isAdmin`, `isDev`, `isReporter`) VALUES
(1, 'root', 'Admin', 'SoftSupport', 'admin.softsupport01@gmail.com', '$2y$10$A8VkqjyKSxoiQ9WJt89HduTIeAL0dNBPUxLjQDV/zJ9rJNvLGheiO', 1, 0, 0),
(2, 'myahia', 'Mohcine', 'YAHIA', 'mohcine.93.yahia@gmail.com', '$2y$10$UcTJBPIu5XKAESuwsfk0muHfh2qW9Vssg2WFeSopHkY116Kr7L4q6', 0, 0, 1),
(4, 'neutamene', 'Noreddine', 'EUTAMENE', 'test@gmail.com', '$2y$10$ABPUkTBI1iY.j5kEp1dFeOla/mUD4oyzE7FwAbMVxo8nb0bpM8xZm', 0, 0, 1),
(5, 'amned', 'Abdelmajid', 'MNED', 'test@gmail.com', '$2y$10$mM0h/Z5CPRNdEg8qVsGlse71GWf3QuCt.raWdl16gtuS8B9dXAK7a', 0, 0, 1),
(6, 'dev', 'Dev', 'TEST', 'test@gmail.com', '$2y$10$biG2RE3js5dQEMFZQYdALOENLOk.1aDcLS6WCO3Xk8rOXHa3pbwAS', 0, 1, 0),
(7, 'report', 'Reporter', 'TEST', 'test@gmail.com', '$2y$10$oNZH0dLRDlWvhM428jk4juXzFgheVJ5zuQlPMu0c82FkZ294P0Peq', 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id_project`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id_project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
