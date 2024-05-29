-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 03:55 PM
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
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(32, 'Health'),
(33, 'Travel'),
(34, 'Food'),
(35, 'Technology'),
(36, 'Nature'),
(37, 'Fitness'),
(38, 'Lifestyle'),
(39, 'Gaming'),
(40, 'Coding'),
(41, 'Web Development'),
(42, 'Android Development'),
(43, 'Cooking'),
(44, 'Comedy');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_user_id` int(3) NOT NULL,
  `comment_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_user_id`, `comment_content`, `comment_status`, `comment_date`) VALUES
(1, 1, 9, 'this is the first comment', '', '2024-05-23'),
(2, 2, 9, 'this is the second comment', '', '2024-05-23'),
(3, 2, 9, 'This is a good post 😀😁😁', '', '2024-05-23'),
(6, 2, 9, 'hehe 😀😀', '', '2024-05-23'),
(7, 2, 9, 'NULL', '', '2024-05-23'),
(8, 1, 9, 'hehe 🤣🤣🤣', '', '2024-05-24'),
(9, 2, 9, '123', '', '2024-05-24'),
(10, 2, 9, 'suiiiiiiiii', '', '2024-05-24'),
(11, 1, 9, 'suiiii\n', '', '2024-05-24'),
(12, 1, 9, 'lol\n', '', '2024-05-24'),
(13, 1, 9, 'wowwwww 😶😐', '', '2024-05-24'),
(14, 2, 28, 'nice post :) 😐😯', '', '2024-05-24'),
(15, 1, 9, 'hello', '', '2024-05-25'),
(16, 2, 9, 'hula\n', '', '2024-05-25'),
(17, 2, 9, 'hello\n', '', '2024-05-25'),
(60, 3, 9, '1', '', '2024-05-26'),
(61, 3, 9, '2', '', '2024-05-26'),
(62, 3, 9, '3', '', '2024-05-26'),
(63, 3, 9, '4', '', '2024-05-26'),
(66, 3, 9, '5', '', '2024-05-26'),
(67, 3, 9, '6', '', '2024-05-26'),
(68, 3, 9, '7', '', '2024-05-26'),
(69, 3, 9, '8', '', '2024-05-26'),
(70, 3, 9, '9', '', '2024-05-26'),
(71, 1, 9, 'nice post', '', '2024-05-26'),
(72, 1, 9, 'gg', '', '2024-05-26'),
(73, 3, 9, '10', '', '2024-05-26'),
(74, 3, 9, '11', '', '2024-05-26'),
(75, 1, 9, 'hello', '', '2024-05-26'),
(76, 1, 9, 'new', '', '2024-05-26'),
(77, 1, 9, 'suiiiiiii no suiiiiiiiii 🙂😁😁😁😁😴🤡🤡🤡🤡🤡🤡💀💀💀💀💀', '', '2024-05-28');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(10) NOT NULL,
  `like_post_id` int(10) NOT NULL,
  `like_user_id` int(10) NOT NULL,
  `like_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `like_post_id`, `like_user_id`, `like_status`) VALUES
(3, 1, 9, 1),
(9, 5, 9, 1),
(10, 2, 9, 1),
(14, 4, 9, 0),
(15, 7, 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_author_id` int(10) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_user` varchar(255) NOT NULL,
  `post_date` date NOT NULL DEFAULT current_timestamp(),
  `post_image` text NOT NULL,
  `post_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `post_type` varchar(20) NOT NULL,
  `post_comment_count` varchar(255) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL,
  `post_likes` bigint(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_author_id`, `post_category_id`, `post_title`, `post_author`, `post_user`, `post_date`, `post_image`, `post_content`, `post_type`, `post_comment_count`, `post_status`, `post_views_count`, `post_likes`) VALUES
(1, 9, 41, 'First Post (Web Development)', 'Niladri Basak', '', '2024-05-22', 'technology-tag.jpg', 'This is the first post of this PROJECT <3', '0', '', 'published', 2, 1),
(2, 9, 42, 'Second Post (Android development)', 'Niladri Basak', '', '2024-05-22', 'coding.png', 'This is the second post of this PROJECT', '0', '', 'published', 0, 1),
(3, 9, 41, 'Web Development', 'Niladri Basak', '', '2024-05-25', 'coding.png', 'suiiiiii 😁😁😁😁 web development', '1', '', 'draft', 2, 0),
(4, 9, 33, 'This is a new post', 'test1', '', '2024-05-27', '1716825891birla-planetarium.jpg', '<p>Birla planetarium is an attractive spot.</p><p><font color=\"#0000ff\">#kolkata #travel</font></p>', '0', '', 'published', 0, 0),
(5, 9, 40, 'This is a new post', 'test1', '', '2024-05-27', '1716828639FlashPost.png', '<p>hello world</p>', '0', '', 'published', 0, 1),
(7, 28, 44, 'post 6', 'test1', '', '2024-05-27', '1716834483FlashPost.png', '<ul><li>one</li><li>two</li><li>three</li></ul>', '0', '', 'published', 0, 0),
(15, 9, 35, 'Web Development', 'Niladri Basak', '', '2024-05-28', '1716841535aunwesha.png', '<p>nice</p>', '0', '', 'published', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text DEFAULT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` tinyint(2) NOT NULL DEFAULT 0,
  `user_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_username`, `user_email`, `user_image`, `user_password`, `user_role`, `user_created_at`, `user_updated_at`) VALUES
(9, 'Niladri Basak', 'niladri_17', 'niladri.basak.007@gmail.com', '17169040496a5e88f24dc1c5e8769d17b04534ee1a.png', '$2y$10$69hellomotherfucker69uctR5y9PDolnAn0qmkLYfFRfHhZgnSEa', 1, '2024-05-20 16:28:26', NULL),
(28, 'test1', 'test1', 'test1@test.com', '17168368826a5e88f24dc1c5e8769d17b04534ee1a.png', '$2y$10$69hellomotherfucker69uctR5y9PDolnAn0qmkLYfFRfHhZgnSEa', 0, '2024-05-24 14:02:37', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
