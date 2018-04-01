-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 25, 2017 lúc 05:48 PM
-- Phiên bản máy phục vụ: 10.1.26-MariaDB
-- Phiên bản PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `photosharing`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `role` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`username`, `email`, `password`, `role`) VALUES
('moderator', 'moderator@gmail.com', '123', 'Moderator'),
('Test', 'Test@gmail.com', '123', 'User'),
('HFDyu', 'thedarkdragon2009@gmail.com', '123', 'Administrator'),
('TungLe', 'tungle@gmail.com', '123', 'Administrator'),
('user', 'user@gmail.com', '123', 'User');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `owner` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `comment` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `uploadDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`owner`, `email`, `image`, `comment`, `uploadDate`) VALUES
('moderator@gmail.com', 'Test@gmail.com', 'QuanLyChuyenDi_XoaChuyenDi.PNG', '5', '2017-12-21 02:48:06'),
('thedarkdragon2009@gmail.com', 'Test@gmail.com', 'QuanLyChuyenDi_XoaChuyenDi.PNG', 'Test', '2017-12-21 02:47:12'),
('thedarkdragon2009@gmail.com', 'Test@gmail.com', 'QuanLyChuyenDi_XoaChuyenDi.PNG', '1', '2017-12-21 02:47:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `image`
--

CREATE TABLE `image` (
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `owner` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `theme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `uploaddate` datetime NOT NULL,
  `noview` int(11) NOT NULL,
  `nodownload` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `image`
--

INSERT INTO `image` (`name`, `owner`, `theme`, `uploaddate`, `noview`, `nodownload`) VALUES
('3ebd97b37706e08f9200d27656b94e4b--futuristic-technology-new-technology.jpg', 'tungle@gmail.com', 'Technology', '2017-12-25 21:15:49', 3, 0),
('505872990.jpg', 'user@gmail.com', 'Nature', '2017-12-25 21:04:42', 4, 0),
('amazing-animal-beautiful-beautifull.jpg', 'user@gmail.com', 'Nature', '2017-12-25 21:04:42', 5, 0),
('brace-yourself-final-year-project-is-coming.jpg', 'thedarkdragon2009@gmail.com', 'Meme', '2017-12-25 21:18:58', 8, 0),
('cecil-AP463227356214-1000x400.jpg', 'thedarkdragon2009@gmail.com', 'Animals', '2017-12-25 20:46:30', 3, 0),
('conducted-collaboration-experiment-participants-environments-artificial-listened_5e43e23c-178a-11e7-9d7a-cd3db232b835.jpg', 'user@gmail.com', 'Nature', '2017-12-25 21:04:42', 3, 0),
('d43ce059d34b39bef244b92d905bddba--painting-art-ideas-acrylics-artistic-painting.jpg', 'thedarkdragon2009@gmail.com', 'Arts', '2017-12-25 21:00:45', 2, 0),
('DatVe.PNG', 'thedarkdragon2009@gmail.com', 'Uncategorized', '2017-12-21 02:28:23', 9, 0),
('digiedge1.jpg', 'tungle@gmail.com', 'Technology', '2017-12-25 21:15:49', 2, 0),
('e8b734cd2e285d8eb5203f601b4341db.jpg', 'thedarkdragon2009@gmail.com', 'Technology', '2017-12-25 21:18:58', 5, 0),
('environmental_portrait.jpg', 'moderator@gmail.com', 'People', '2017-12-25 21:10:54', 4, 0),
('fc94b.jpg', 'thedarkdragon2009@gmail.com', 'Meme', '2017-12-25 21:18:58', 5, 0),
('final project.jpg', 'thedarkdragon2009@gmail.com', 'Meme', '2017-12-25 21:18:58', 33, 0),
('la_france_cote_nature_6.jpg', 'Test@gmail.com', 'Nature', '2017-12-25 21:06:06', 2, 0),
('main-qimg-c08e76932df14867d678e1c6417aaf8a.png', 'tungle@gmail.com', 'Technology', '2017-12-25 21:15:50', 3, 0),
('QuanLyChuyenDi_XoaChuyenDi.PNG', 'Test@gmail.com', 'Uncategorized', '2017-12-21 02:41:01', 28, 0),
('QuanLyTuyenDi.PNG', 'user@gmail.com', 'Uncategorized', '2017-12-21 02:40:42', 8, 0),
('QuyDinhChuyenDi.png', 'tungle@gmail.com', 'Uncategorized', '2017-12-21 02:40:22', 4, 0),
('QuyDinhDonGiaVe.png', 'tungle@gmail.com', 'Uncategorized', '2017-12-21 02:40:22', 4, 0),
('stock-photo-142984111-1500x1000.jpg', 'Test@gmail.com', 'Nature', '2017-12-25 21:06:06', 3, 0),
('TraCuuChuyenDi.PNG', 'moderator@gmail.com', 'Uncategorized', '2017-12-21 02:39:59', 10, 0),
('unnamed.jpg', 'thedarkdragon2009@gmail.com', 'Arts', '2017-12-25 21:00:06', 2, 0),
('wide.jpeg', 'moderator@gmail.com', 'People', '2017-12-25 21:10:54', 3, 0),
('working-on-my-final-project-71930.jpg', 'thedarkdragon2009@gmail.com', 'Meme', '2017-12-25 21:18:58', 31, 0),
('XemBaoCao.png', 'moderator@gmail.com', 'Uncategorized', '2017-12-21 02:39:59', 4, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `likes`
--

CREATE TABLE `likes` (
  `emailOwner` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `emailLike` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `likes`
--

INSERT INTO `likes` (`emailOwner`, `image`, `emailLike`) VALUES
('Test@gmail.com', 'QuanLyChuyenDi_XoaChuyenDi.PNG', 'moderator@gmail.com'),
('Test@gmail.com', 'QuanLyChuyenDi_XoaChuyenDi.PNG', 'user@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `theme`
--

CREATE TABLE `theme` (
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL DEFAULT 'Uncategorized'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `theme`
--

INSERT INTO `theme` (`name`) VALUES
('Animals'),
('Arts'),
('Meme'),
('Nature'),
('People'),
('Technology'),
('Uncategorized');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`owner`,`uploadDate`);

--
-- Chỉ mục cho bảng `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`name`,`owner`);

--
-- Chỉ mục cho bảng `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`emailOwner`,`image`,`emailLike`);

--
-- Chỉ mục cho bảng `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
