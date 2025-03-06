-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 02:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digital_wallet`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(15,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `wallet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `created_at`, `amount`, `user_id`, `type`, `wallet_id`) VALUES
(1, '2025-03-05 15:41:05', 89.00, 1, 'deposit', 30),
(2, '2025-03-05 15:41:56', 78.00, 1, 'deposit', 30),
(3, '2025-03-05 16:55:28', 30.00, 1, 'deposit', 30),
(4, '2025-03-05 16:55:29', 30.00, 1, 'deposit', 30),
(5, '2025-03-05 23:01:42', 56.00, 5, 'deposit', 31),
(6, '2025-03-05 23:06:07', 12.00, 5, 'transfer', 31);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `id_url` varchar(255) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `username`, `phone_number`, `password`, `address`, `id_url`, `user_type_id`, `is_verified`, `created_at`) VALUES
(1, 'yehia.al.arja12@gmail.com', 'Yehia Arja', '70950038', '$2y$10$kcHrIFpjxBins.5RtnoTzueCUcitcdmztAcsRV34hf.kkB8jaqIyC', '', 'http://localhost/digital-wallet/wallet-server/uploads/1741088660_e-wallet-logo-vector-44767093.png', 1, 1, '2025-03-04 11:44:20'),
(3, 'yehia.al.arja112@gmail.com', 'Yehia Arja', '709500380', '$2y$10$AyrwMs60mg9NI2Nb32TE4eTPoVYDMAEHtnTeQ7WFdxgLyN6NYFe8y', '', 'http://localhost/digital-wallet/wallet-server/connection/uploads/1741116804_e-wallet-logo-vector-44767093.png', 2, 1, '2025-03-04 19:33:24'),
(5, 'yehiaarja793@gmail.com', 'Yehia Arja', '70950038h', '$2y$10$UbWE6KKiExJrVL8ufkrOB.mjDB7RDYxm7rUypUZMvyNGitroHZb/e', '', 'http://localhost/digital-wallet/wallet-server/connection/uploads/1741121439_e-wallet-logo-vector-44767093.png', 2, 1, '2025-03-04 20:50:39'),
(6, 'yehia.al.arja127@gmail.com', 'Yehia Arja', '70950038y', '$2y$10$.HsZJN46GFAMmkoWgcjZZuW7JAkZb.U3qzULDHiGEtv.wBffYF48e', '', 'http://localhost/digital-wallet/wallet-server/connection/uploads/1741121532_e-wallet-logo-vector-44767093.png', 2, 1, '2025-03-04 20:52:12'),
(9, 'yehiaalarja11@gmail.com', 'yehia arja', '70950038hj', '$2y$10$BU2GLm3KaLaC6TSOZEmVU.4DHMP3A8X6d96eiiiyGW6psMiGKU2u6', '', 'http://localhost/digital-wallet/wallet-server/connection/uploads/1741121954_e-wallet-logo-vector-44767093.png', 2, 1, '2025-03-04 20:59:14'),
(10, 'yehiaalarja11@gmail.comh', 'Yehia Arja', 'h', '$2y$10$DmaU2DFhiN3DCIFnEMwcd.Iu1eKxe9kaSt56AwY.ucW/cDot19kEW', '', 'http://localhost/digital-wallet/wallet-server/connection/uploads/1741122066_e-wallet-logo-vector-44767093.png', 2, 1, '2025-03-04 21:01:07'),
(11, 'yehia.al.arjah12@gmail.com', 'yehia arja', 'hhhj', '$2y$10$G/1SnjzpN1aKGrwAPu41D.LMshnDETGC9yOMwEF0nA5q8fglRh5OW', '', 'http://localhost/digital-wallet/wallet-server/connection/uploads/1741122428_e-wallet-logo-vector-44767093.png', 2, 1, '2025-03-04 21:07:08'),
(18, 'yehia.al.arja1@gmail.com', 'Yehia Arja', '70950038w', '$2y$10$RLGyXJ8nWzG0B.i4trRVze1B/9JqiZDvwtyCPvJ3.3CespUSD6EbC', '', 'http://localhost/digital-wallet/wallet-server/connection/uploads/1741122733_e-wallet-logo-vector-44767093.png', 2, 1, '2025-03-04 21:12:13'),
(19, 'yehia.al.arja172@gmail.com', 'Yehia Arja', '709500388', '$2y$10$fOPAFKP9DQpAxj2v5bnN/uRYhmgPK5uhqEsqH8UnerxbNmjvp9Wue', 'aramoun', 'http://localhost/digital-wallet/wallet-server/connection/uploads/1741213865_images.jpeg', 2, 0, '2025-03-05 22:31:05'),
(21, 'yehiaarja7973@gmail.com', 'Yehia Arja', '709500388y', '$2y$10$I/9ItfZ2X1cSLd1Va6H.yeSMqzpion/ocPGw.yIuUGumlq31oj62a', 'aramoun', 'http://localhost/digital-wallet/wallet-server/connection/uploads/1741214474_images.jpeg', 2, 0, '2025-03-05 22:41:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `user_type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`user_type_id`, `type_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
  `wallet_number` varchar(255) NOT NULL,
  `balance` decimal(15,2) DEFAULT 0.00,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `wallet_number`, `balance`, `user_id`) VALUES
(30, 'dEgMXbxH', 18.00, 1),
(31, 'xtZaiTNP', 20.00, 5),
(32, 'EZQkTitG', 12.00, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_id` (`wallet_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD KEY `user_type_id` (`user_type_id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wallet_number` (`wallet_number`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`user_type_id`);

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
