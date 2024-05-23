-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 04:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `course_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `user_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` int(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`name`, `email`, `number`, `message`) VALUES
('VINTAS JAZICO - HIGH TOP - ROYAL WHITE', 'admin@admin.com', 12345688, '123');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `video` varchar(100) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `tutor_id`, `playlist_id`, `title`, `description`, `video`, `thumb`, `date`, `status`) VALUES
('ZKoBxj6KRxxWHijg9I7V', 'daykb3hPvPWOQXCctRBm', 'k3StS1tNolVItWc9j5Un', '123', '123', 'heeLmCdYwZPVtWz6s8J4.mp4', 'QtpkfuccGZrV3u2oU3sh.png', '2024-05-08', 'active'),
('O6AgXOcj5hD7HV64Wg2R', 'eKjjCDro2EWcztNNXytN', 'IXQ5a4lPk4D2fhvEmZ8N', '[5 KÝ HIỆU MỖI TUẦN] Giới thiệu bản thân bằng Ngôn ngữ ký hiêu', '[5 KÝ HIỆU MỖI TUẦN] Giới thiệu bản thân bằng Ngôn ngữ ký hiêu', 'B52eVKSHFzWhV0yYNG3Q.mp4', 'rs4lHXtkwMlxzodgnMcU.jpg', '2024-05-10', 'active'),
('IbPodl1xm8BB6keGVQVe', 'eKjjCDro2EWcztNNXytN', 'hrzjlQYPqPgxXFzyAxqa', 'Học 5 ngôn ngữ kí hiệu mỗi ngày: Xin lỗi, cám ơn, biết ơn,yêu thương, hạnh phúc', 'Học 5 ngôn ngữ kí hiệu mỗi ngày: Xin lỗi, cám ơn, biết ơn,yêu thương, hạnh phúc', 'ZpJwPY43iSb7M7yKQtCk.mp4', 'xpuO8KTWmz6tFuHnP4QF.jpg', '2024-05-10', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`id`, `tutor_id`, `title`, `description`, `thumb`, `date`, `status`) VALUES
('IXQ5a4lPk4D2fhvEmZ8N', 'eKjjCDro2EWcztNNXytN', '[5 KÝ HIỆU MỖI TUẦN] Giới thiệu bản thân bằng Ngôn ngữ ký hiêu', '[5 KÝ HIỆU MỖI TUẦN] Giới thiệu bản thân bằng Ngôn ngữ ký hiêu', 'eUvBE5nVWdMAAyqQlf8k.jpg', '2024-05-10', 'active'),
('hrzjlQYPqPgxXFzyAxqa', 'eKjjCDro2EWcztNNXytN', 'Học 5 ngôn ngữ kí hiệu mỗi ngày', 'Học 5 ngôn ngữ kí hiệu mỗi ngày: Xin lỗi, cám ơn, biết ơn,yêu thương, hạnh phúc', 'dznGLIvo1mYsfQtD1SYL.jpg', '2024-05-10', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `profession` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`id`, `name`, `profession`, `email`, `password`, `image`) VALUES
('eKjjCDro2EWcztNNXytN', 'Thong Nguyen', 'teacher', 'thong@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'CqG6QINFDMFxiMLx1ASp.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`) VALUES
('QI8fovfp50yB86LiDq8C', 'VINTAS JAZICO - HIGH TOP - ROYAL WHITE', 'admin@example.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'WFxrP6cLsVs7jaLwsOZN.png'),
('BVjDccVtJpL1ARP9Yb87', 'rongvang23578hn@gmail.com', 'rongvang23578hn@gmai', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rqEX2U3ECOPCIb8D14cy.png'),
('6iw9Jot6nuifjgkgudLl', 'test', 'rongvang235781hn@gmai', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'WOL2QtUrJXW5LddsIZ0T.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
