-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2023 at 01:50 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moodtracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_moods`
--

CREATE TABLE `all_moods` (
  `id` int(11) NOT NULL,
  `core_mood_id` int(11) DEFAULT NULL,
  `custom_mood_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_moods`
--

INSERT INTO `all_moods` (`id`, `core_mood_id`, `custom_mood_id`) VALUES
(1, 2, NULL),
(2, 3, NULL),
(3, 1, NULL),
(4, 5, NULL),
(5, 4, NULL),
(6, NULL, 1),
(7, NULL, 2),
(8, NULL, 3),
(9, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `core_moods`
--

CREATE TABLE `core_moods` (
  `id` int(11) NOT NULL,
  `arousal` int(11) NOT NULL,
  `valence` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `core_moods`
--

INSERT INTO `core_moods` (`id`, `arousal`, `valence`, `name`, `description`) VALUES
(1, 9, 9, 'excited', 'fun excited'),
(2, 5, 0, 'awake', ''),
(3, 5, -5, 'dread', ''),
(4, -5, -1, 'tired', 'yawwwn'),
(5, -3, 7, 'mellow', 'a better yawn');

-- --------------------------------------------------------

--
-- Table structure for table `custom_moods`
--

CREATE TABLE `custom_moods` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `arousal` int(11) NOT NULL,
  `valence` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_moods`
--

INSERT INTO `custom_moods` (`id`, `user_id`, `arousal`, `valence`, `name`, `description`) VALUES
(1, 1, -9, -9, 'aggressively sad', 'some dummy moods'),
(2, 1, 9, 9, 'aggressively happy', 'more custom tests'),
(3, 1, 5, 3, 'buzzed', ''),
(4, 2, 7, -3, 'lost', 'lost can be a mood');

-- --------------------------------------------------------

--
-- Table structure for table `mood_entry`
--

CREATE TABLE `mood_entry` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mood_id` int(11) NOT NULL,
  `context` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mood_entry`
--

INSERT INTO `mood_entry` (`id`, `user_id`, `mood_id`, `context`, `datetime`) VALUES
(1, 1, 6, 'testing out custom mood entries for dummy 1', '2023-02-16 00:45:44'),
(2, 1, 7, 'again testing out custom mood entries for dummy 1', '2023-02-14 00:45:44'),
(3, 1, 2, 'testing out core moods for dummy1', '2023-02-19 00:46:40'),
(4, 1, 4, 'again testing out core moods for dummy1', '2023-02-20 00:47:13'),
(5, 2, 8, 'buzzy buzzy', '2023-02-08 00:47:13'),
(6, 2, 1, 'too much coffee!', '2023-02-15 00:47:13'),
(7, 2, 5, 'coffee crash', '2023-02-19 00:48:02'),
(8, 2, 9, 'stuck in ikea...', '2023-02-20 00:48:53');

-- --------------------------------------------------------

--
-- Table structure for table `mood_entry_user_tags`
--

CREATE TABLE `mood_entry_user_tags` (
  `id` int(11) NOT NULL,
  `mood_entry_id` int(11) NOT NULL,
  `user_tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mood_entry_user_tags`
--

INSERT INTO `mood_entry_user_tags` (`id`, `mood_entry_id`, `user_tag_id`) VALUES
(1, 3, 1),
(2, 1, 2),
(3, 4, 1),
(4, 5, 3),
(5, 7, 3),
(6, 8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'dummy1', 'dummyPassword1'),
(2, 'dummy2', 'dummyPassword2');

-- --------------------------------------------------------

--
-- Table structure for table `user_tags`
--

CREATE TABLE `user_tags` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tag_name` varchar(50) NOT NULL,
  `tag_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tags`
--

INSERT INTO `user_tags` (`id`, `user_id`, `tag_name`, `tag_desc`) VALUES
(1, 1, 'work_related', 'anything work related'),
(2, 1, 'friends', 'all socials'),
(3, 2, 'driving', 'would this be a tag?'),
(4, 2, 'friends', 'testing duplicate tag names between users');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_moods`
--
ALTER TABLE `all_moods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_all_moods_core_mood_id` (`core_mood_id`),
  ADD KEY `FK_all_moods_custom_mood_id` (`custom_mood_id`);

--
-- Indexes for table `core_moods`
--
ALTER TABLE `core_moods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_moods`
--
ALTER TABLE `custom_moods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_custom_mood` (`user_id`);

--
-- Indexes for table `mood_entry`
--
ALTER TABLE `mood_entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_mood_entry_user_id` (`user_id`),
  ADD KEY `FK_mood_entry_mood_id` (`mood_id`);

--
-- Indexes for table `mood_entry_user_tags`
--
ALTER TABLE `mood_entry_user_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_mood_entry_user_tag_user_tag` (`user_tag_id`),
  ADD KEY `FK_mood_entry_user_tag_mood_entry_id` (`mood_entry_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tags`
--
ALTER TABLE `user_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_tag` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_moods`
--
ALTER TABLE `all_moods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `core_moods`
--
ALTER TABLE `core_moods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `custom_moods`
--
ALTER TABLE `custom_moods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mood_entry`
--
ALTER TABLE `mood_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mood_entry_user_tags`
--
ALTER TABLE `mood_entry_user_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_tags`
--
ALTER TABLE `user_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `all_moods`
--
ALTER TABLE `all_moods`
  ADD CONSTRAINT `FK_all_moods_core_mood_id` FOREIGN KEY (`core_mood_id`) REFERENCES `core_moods` (`id`),
  ADD CONSTRAINT `FK_all_moods_custom_mood_id` FOREIGN KEY (`custom_mood_id`) REFERENCES `custom_moods` (`id`);

--
-- Constraints for table `custom_moods`
--
ALTER TABLE `custom_moods`
  ADD CONSTRAINT `FK_user_custom_mood` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `mood_entry`
--
ALTER TABLE `mood_entry`
  ADD CONSTRAINT `FK_mood_entry_mood_id` FOREIGN KEY (`mood_id`) REFERENCES `all_moods` (`id`),
  ADD CONSTRAINT `FK_mood_entry_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `mood_entry_user_tags`
--
ALTER TABLE `mood_entry_user_tags`
  ADD CONSTRAINT `FK_mood_entry_user_tag_mood_entry_id` FOREIGN KEY (`mood_entry_id`) REFERENCES `mood_entry` (`id`),
  ADD CONSTRAINT `FK_mood_entry_user_tag_user_tag` FOREIGN KEY (`user_tag_id`) REFERENCES `user_tags` (`id`);

--
-- Constraints for table `user_tags`
--
ALTER TABLE `user_tags`
  ADD CONSTRAINT `FK_user_tag` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
