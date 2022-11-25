-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql106.byetcluster.com
-- Generation Time: Nov 25, 2022 at 03:35 PM
-- Server version: 10.3.27-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_33063526_facebook_book`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_chat`
--

CREATE TABLE `admin_chat` (
  `id` int(11) NOT NULL,
  `sender` int(255) NOT NULL,
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

CREATE TABLE `bans` (
  `id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `ban_status` varchar(255) NOT NULL,
  `ban_time` int(255) NOT NULL,
  `baned_by` int(11) NOT NULL,
  `ban_reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comments_desc` text NOT NULL,
  `maker` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `comments_desc`, `maker`) VALUES
(114, 46, 'hello', 33),
(115, 48, 'Hello', 33),
(116, 49, 'hello', 33),
(117, 46, 'Hello agin', 33),
(118, 50, 'Hello from mobile', 33),
(119, 50, 'Hello', 33);

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `current` int(11) NOT NULL,
  `follower` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `current`, `follower`) VALUES
(34, 34, 33),
(35, 35, 33),
(36, 33, 35),
(37, 37, 36),
(38, 37, 35),
(39, 37, 34),
(40, 37, 33);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(111, 33, 46),
(112, 33, 48),
(115, 33, 50),
(116, 33, 51);

-- --------------------------------------------------------

--
-- Table structure for table `login_tokens`
--

CREATE TABLE `login_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_tokens`
--

INSERT INTO `login_tokens` (`id`, `token`, `user_id`) VALUES
(129, 'e42784ef6cf8cc8b26c1191bdee2fa1267d08479', 35),
(131, 'd3d750407dbce84901f26ec8f15c9eee1108e5c6', 33),
(132, '5501f1b3d4555f00b52690e202480e4cf7842686', 36),
(133, '4df0735ed5bbb459ca26188505006ceded04bbbf', 33),
(134, '146c489527bb5ba2395a8f70805f2995c6741105', 33),
(135, '878e183465d2a249b0df7a116725e416a2230ee5', 33),
(136, 'be16f371ebff8bd95e985b48b38fee28d0edda2c', 37),
(137, '5cf77ed7a6f3780611a6e26b93bfc3f55841431f', 38),
(139, '0bf2b9328828474b33bfe3ae5fb439aa1f49f6f7', 33),
(140, '7074d224b90abb85be36d7326d62a55d09cc752e', 33);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `income_id` int(11) NOT NULL,
  `outcome_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `msg`, `income_id`, `outcome_id`) VALUES
(44, 'hello from mena', 34, 33),
(45, 'Hello men’s', 33, 34),
(47, 'خخخ', 35, 33),
(48, 'اخويا الندال', 33, 35),
(49, 'السندال', 33, 35),
(50, 'fake you', 33, 36),
(51, 'احوان', 36, 33),
(52, 'because you are trash', 36, 33),
(53, 'fake you agin', 33, 36),
(54, 'hello', 38, 36);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `post_desc` text NOT NULL,
  `post_image` text DEFAULT NULL,
  `post_maker` int(11) NOT NULL,
  `post_like` int(11) NOT NULL,
  `post_important` varchar(255) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post_desc`, `post_image`, `post_maker`, `post_like`, `post_important`) VALUES
(46, 'helolo world\r\n', 'default1.jpg', 33, 1, 'No'),
(48, 'hello agin', 'IMG-637ff2b6cf4442.91552068.png', 33, 1, 'No'),
(50, 'from ad', 'admin_banner.jpg', 33, 1, 'Yes'),
(51, 'حموكشا عالاسفلت\r\n', 'default.jpg', 35, 1, 'No'),
(53, 'hello', 'admin_banner.jpg', 33, 0, 'Yes'),
(54, 'good bot', 'IMG-638108bb473c49.76653440.png', 33, 0, 'Yes'),
(55, 'good user', 'IMG-638108ed930865.10979952.png', 33, 0, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `content`, `name`) VALUES
(13, 'unlock ban', 'mena'),
(14, 'Riphero653@gmail.com', 'CiND2R1'),
(15, 'unlock ban', 'sno7y21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `images` text DEFAULT NULL,
  `role` varchar(11) NOT NULL DEFAULT 'member',
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `images`, `role`, `status`) VALUES
(33, 'sno7y21', '$2y$10$.RBiWME3is/eajLvRNs.POw4KoKLV5mT6XFCXBH9gewBYuzsZoqk.', 'sno7y@gmail.com', 'IMG-637fedb3543300.92963516.png', 'Owner', '1669406502'),
(34, 'mena', '$2y$10$UDFFqKDd9gRETW4cWOjJ7OOO4LiE2gaUpgdwJOEzhp1xMJ0ErsuEa', 'sno7y@gmail.com', 'IMG-6380fc07afab13.08833613.png', 'member', '1669397727'),
(35, '7amok4a', '$2y$10$zXNsolP/Jwc13zDr0VwRB.4G8OKuAECu2f5EoVWwg9sUqsH4tKb.i', 'hamo2.medo2@gmail.com', 'IMG-6380ffb168cd25.27235443.jpg', 'member', '1669398503'),
(36, 'CiND2R1', '$2y$10$pSkhiAjywDydzkhXpxEDO.PcRURDAJ91SVkUF9MqY9twZPKyNk0EK', 'riphero653@gmail.com', 'IMG-638105ff49ec93.32239435.png', 'Admin', '1669409067'),
(37, 'nawaf', '$2y$10$zNSkEdFxDCehX8MMfGpCBe/VGrqccZH6vjPN9jcMsd9d.ISxhGQHW', 'no@gmail.com', 'IMG-638111b208b0e3.30936000.png', 'member', ''),
(38, 'test', '$2y$10$ajHk7B0oHwEWRajfqlWfMe4mU7HPKLL/nWWsNXWrh0gDoJdmvW30e', 'test@test.com', 'IMG-638112a3ecb1f0.12184664.png', 'member', '1669403472');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_chat`
--
ALTER TABLE `admin_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender` (`sender`);

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_ibfk_1` (`post_id`),
  ADD KEY `maker` (`maker`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `current` (`current`),
  ADD KEY `current_2` (`current`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `income_id` (`income_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_maker` (`post_maker`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
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
-- AUTO_INCREMENT for table `admin_chat`
--
ALTER TABLE `admin_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_chat`
--
ALTER TABLE `admin_chat`
  ADD CONSTRAINT `admin_chat_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bans`
--
ALTER TABLE `bans`
  ADD CONSTRAINT `bans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`maker`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD CONSTRAINT `login_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`income_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_maker`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
