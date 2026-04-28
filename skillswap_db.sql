-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2026 at 05:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skillswap_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_by_sender` tinyint(1) DEFAULT 0,
  `deleted_by_receiver` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `created_at`, `deleted_by_sender`, `deleted_by_receiver`) VALUES
(1, 2, 1, 'hello', '2026-04-28 12:39:12', 0, 1),
(2, 2, 1, 'akkame', '2026-04-28 12:39:20', 0, 1),
(3, 1, 2, 'fayya isin fayyaa', '2026-04-28 12:39:52', 0, 0),
(4, 3, 1, 'hello abdulaziz', '2026-04-28 13:53:07', 0, 0),
(5, 3, 1, 'could you help me with graphic', '2026-04-28 13:53:45', 0, 0),
(6, 4, 2, 'hi', '2026-04-28 14:34:11', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`) VALUES
(4, 'Data Science'),
(3, 'Digital Marketing'),
(2, 'Graphic Design'),
(6, 'Photography'),
(5, 'Public Speaking'),
(1, 'Web Development');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `student_id`, `profile_pic`, `created_at`) VALUES
(1, 'Abdulaziz Abdurahman', 'abdulaziz.afia7@gmail.com', '$2y$10$6r2YUPBxYuJo4IOcxZv6beSTW38paIpSdhTYjWPbTyZe5Tij7YZTu', NULL, 'default.png', '2026-04-28 11:58:01'),
(2, 'ABDIREHMAN KEDIR', 'abdulaziz@gmail.com', '$2y$10$4TBt8HlQzf/A/ysbjnEP8uzdAsNEa06ibPu7S0vJNH2esxXq/sdW2', NULL, 'default.png', '2026-04-28 12:02:04'),
(3, 'aa bb', 'afia7@gmail.com', '$2y$10$BPJTnF6pa6TQ8FE/0yrveeqMEHE1JZyjfi85R0K.QGEl9BxkXA9ZO', NULL, 'default.png', '2026-04-28 13:51:20'),
(4, 'awel surur', '7@gmail.com', '$2y$10$DGMzq/UHVMpSuRsyWFcKDOdVpq5ZXTj9R1k42Q7mdTmN5lBKZ4H4O', NULL, 'default.png', '2026-04-28 14:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

CREATE TABLE `user_skills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `skill_id` int(11) DEFAULT NULL,
  `type` enum('teach','learn') DEFAULT NULL,
  `skill_level` enum('Beginner','Intermediate','Advanced') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_skills`
--

INSERT INTO `user_skills` (`id`, `user_id`, `skill_id`, `type`, `skill_level`) VALUES
(1, 1, 4, 'teach', NULL),
(2, 1, 3, 'teach', NULL),
(3, 1, 2, 'teach', NULL),
(7, 2, 1, 'teach', NULL),
(8, 2, 5, 'teach', NULL),
(9, 2, 3, 'learn', NULL),
(10, 2, 4, 'learn', NULL),
(11, 3, 1, 'teach', NULL),
(12, 3, 4, 'teach', NULL),
(13, 3, 3, 'teach', NULL),
(14, 3, 2, 'learn', NULL),
(15, 3, 6, 'learn', NULL),
(16, 3, 5, 'learn', NULL),
(17, 4, 4, 'teach', NULL),
(18, 4, 3, 'teach', NULL),
(19, 4, 2, 'teach', NULL),
(20, 4, 6, 'teach', NULL),
(21, 4, 1, 'learn', NULL),
(22, 4, 5, 'learn', NULL),
(23, 4, 6, 'learn', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_skills`
--
ALTER TABLE `user_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD CONSTRAINT `user_skills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
