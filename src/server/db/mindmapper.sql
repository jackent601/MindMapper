-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2023 at 11:03 PM
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
-- Database: `mindtrial`
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
(11, 6, NULL),
(12, 7, NULL),
(13, 8, NULL),
(14, 9, NULL),
(15, 10, NULL),
(16, 11, NULL),
(17, 12, NULL),
(18, 13, NULL),
(19, 14, NULL),
(20, 15, NULL),
(21, 16, NULL),
(22, 17, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `api_key` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `user_id`, `api_key`) VALUES
(1, 1, 'validAPIkeyTest'),
(2, 2, 'user2apikey'),
(15, 16, '5oilGNsNxKr9OSGKudK5');

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
(1, 0, 0, 'neutral', 'fun excited'),
(2, 9, 9, 'ecstatic', ''),
(3, -9, -9, 'distraught', ''),
(4, 9, -9, 'Angry', ''),
(5, -9, 9, 'content', ''),
(6, 9, 0, 'surprised', ''),
(7, -9, 0, 'sleepy', ''),
(8, 0, 9, 'happy', ''),
(9, 0, -9, 'sad', ''),
(10, 4, 4, 'joyful', ''),
(11, -4, -4, 'annoyed', ''),
(12, 4, -4, 'afraid', ''),
(13, -4, 4, 'calm', ''),
(14, -4, 0, 'groggy', ''),
(15, 4, 0, 'awake', ''),
(16, 0, 4, 'merry', ''),
(17, 0, -4, 'low', '');

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
(3, 1, 5, 3, 'buzzed', '');

-- --------------------------------------------------------

--
-- Table structure for table `mood_entry`
--

CREATE TABLE `mood_entry` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `context` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL,
  `valence` int(11) NOT NULL,
  `arousal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mood_entry`
--

INSERT INTO `mood_entry` (`id`, `user_id`, `context`, `datetime`, `name`, `valence`, `arousal`) VALUES
(1, 1, 'testing out custom mood entries for dummy 1', '2023-02-16 00:45:44', 'Happy', 7, 7),
(2, 1, 'again testing out custom mood entries for dummy 1', '2023-02-14 00:45:44', 'happy but tired', 7, 3),
(3, 1, 'testing out core moods for dummy1', '2023-02-19 00:46:40', '', 0, 0),
(4, 1, 'did my datab', '2023-02-20 00:47:13', '', 0, 0),
(6, 2, 'too much coffee!', '2023-02-15 00:47:13', '', 0, 0),
(7, 2, 'coffee crash', '2023-02-19 00:48:02', '', 0, 0),
(8, 2, 'stuck in ikea...', '2023-02-20 00:48:53', '', 0, 0),
(9, 1, '', '2023-02-27 21:27:23', '', 0, 0),
(13, 1, 'tonight', '2023-02-28 00:27:17', '', 0, 0),
(14, 1, 'another mood', '2023-02-28 00:51:09', '', 0, 0),
(15, 1, '', '2023-03-01 22:27:04', '', 0, 0),
(16, 1, 'test', '2023-03-01 22:31:55', '', 0, 0),
(17, 1, 'at the airport', '2023-03-09 17:22:03', '', 0, 0),
(22, 1, 'trying to finish this report...', '2023-03-18 00:28:36', '', 0, 0),
(25, 1, '', '2023-03-20 20:56:55', '', 8, 7),
(26, 1, 'This was added through postman submission', '2023-03-20 20:57:39', 'This was added through postman submission', 8, 7),
(29, 1, 'ecstaticy', '2023-03-20 21:06:09', 'ecstatic', 9, 9),
(30, 16, 'just starting', '2023-03-01 21:16:00', 'Mellow', 0, 0),
(31, 16, 'long week', '2023-03-03 21:16:20', 'calm', 4, -4),
(32, 16, 'hard week', '2023-03-05 21:16:36', 'tired', -4, -4),
(33, 16, 'Had a nice dinner', '2023-03-02 21:18:02', 'thankful', 2, 2),
(34, 16, 'tough work week', '2023-03-08 21:20:14', 'Very Tired', -4, -4),
(35, 16, 'Had a bit of a fight with the better half', '2023-03-10 21:20:49', 'upset', -9, 9),
(36, 16, 'We made up!', '2023-03-11 21:21:04', 'joyous!', 9, 9),
(37, 16, 'Enjoying', '2023-03-14 21:22:21', 'Happy', 4, 4),
(38, 16, 'Maybe too much of a good weekend...', '2023-03-18 21:22:38', 'groggy', 0, -4),
(39, 16, 'Getting back into work', '2023-03-20 21:22:56', 'flow', 2, 2),
(40, 16, 'ready for the weekend', '2023-03-22 21:26:20', 'excited', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `mood_entry_user_tags`
--

CREATE TABLE `mood_entry_user_tags` (
  `id` int(11) NOT NULL,
  `user_tag_id` int(11) NOT NULL,
  `mood_entry_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mood_entry_user_tags`
--

INSERT INTO `mood_entry_user_tags` (`id`, `user_tag_id`, `mood_entry_id`) VALUES
(1, 1, 3),
(2, 2, 1),
(3, 1, 4),
(5, 3, 7),
(6, 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'dummy1', '$2y$10$nqY9XX02BfKUr4k.YMrKHO4MipYY39BvvMfzk.vbo8HQzC2rj45GK'),
(2, 'dummy2', '$2y$10$nqY9XX02BfKUr4k.YMrKHO4MipYY39BvvMfzk.vbo8HQzC2rj45GK'),
(16, 'myUser', '$2y$10$38tLeziR2VPflwehOtwUr.a.FRPMW6Lr5K5iE6sJKd50Ayr7GQjxu');

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
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_api_user_id` (`user_id`);

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
  ADD KEY `FK_mood_entry_user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `core_moods`
--
ALTER TABLE `core_moods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `custom_moods`
--
ALTER TABLE `custom_moods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mood_entry`
--
ALTER TABLE `mood_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `mood_entry_user_tags`
--
ALTER TABLE `mood_entry_user_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_tags`
--
ALTER TABLE `user_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD CONSTRAINT `FK_api_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `custom_moods`
--
ALTER TABLE `custom_moods`
  ADD CONSTRAINT `FK_user_custom_mood` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `mood_entry`
--
ALTER TABLE `mood_entry`
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
