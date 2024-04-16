-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-04-16 06:20
-- 서버 버전: 10.4.32-MariaDB
-- PHP 버전: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `pinkping`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `admins`
--

CREATE TABLE `admins` (
  `idx` int(11) NOT NULL,
  `userid` varchar(145) DEFAULT NULL,
  `email` varchar(245) DEFAULT NULL,
  `username` varchar(145) DEFAULT NULL,
  `passwd` varchar(200) DEFAULT NULL,
  `regdate` datetime DEFAULT current_timestamp(),
  `level` tinyint(4) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `end_login_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `admins`
--

INSERT INTO `admins` (`idx`, `userid`, `email`, `username`, `passwd`, `regdate`, `level`, `last_login`, `end_login_date`) VALUES
(4, 'admin', 'admin@pinkping.com', '관리자', '33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e', '2024-04-08 14:59:11', 100, '2024-04-16 09:31:01', NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `category`
--

CREATE TABLE `category` (
  `cid` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `pcode` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `step` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `category`
--

INSERT INTO `category` (`cid`, `code`, `pcode`, `name`, `step`) VALUES
(1, 'A0001', '', '컴퓨터', 1),
(2, 'B0001', 'A0001', '노트북', 2),
(3, 'C0001', 'B0001', '게임용', 3),
(14, 'A0002', '', '태블릿', 1),
(15, 'B0002', 'A0001', '삼성', 2),
(16, 'C0003', 'B0001', 'LG', 3),
(17, 'A0003', '', '테스트', 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `coupons`
--

CREATE TABLE `coupons` (
  `cid` int(11) NOT NULL,
  `coupon_name` varchar(100) DEFAULT NULL COMMENT '쿠폰명',
  `coupon_image` varchar(100) DEFAULT NULL COMMENT '쿠폰이미지',
  `coupon_type` tinyint(4) DEFAULT NULL COMMENT '쿠폰타입',
  `coupon_price` double DEFAULT NULL COMMENT '할인금액',
  `coupon_ratio` double DEFAULT NULL COMMENT '할인비율',
  `status` tinyint(4) DEFAULT 0 COMMENT '상태',
  `regdate` datetime DEFAULT NULL COMMENT '등록일',
  `userid` varchar(100) DEFAULT NULL COMMENT '등록한유저',
  `max_value` double DEFAULT NULL COMMENT '최대할인금액',
  `use_min_price` double DEFAULT NULL COMMENT '최소사용금액'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `products`
--

CREATE TABLE `products` (
  `pid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cate` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `thumbnail` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `sale_price` double DEFAULT NULL,
  `sale_ratio` double DEFAULT NULL,
  `cnt` int(11) DEFAULT NULL,
  `sale_cnt` int(11) DEFAULT NULL,
  `ismain` tinyint(4) DEFAULT NULL,
  `isnew` tinyint(4) DEFAULT NULL,
  `isbest` tinyint(4) DEFAULT NULL,
  `isrecom` tinyint(4) DEFAULT NULL,
  `locate` tinyint(4) DEFAULT NULL,
  `userid` varchar(100) DEFAULT NULL,
  `sale_end_date` datetime DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `delivery_fee` double DEFAULT NULL,
  `product_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `products`
--

INSERT INTO `products` (`pid`, `name`, `cate`, `content`, `thumbnail`, `price`, `sale_price`, `sale_ratio`, `cnt`, `sale_cnt`, `ismain`, `isnew`, `isbest`, `isrecom`, `locate`, `userid`, `sale_end_date`, `reg_date`, `status`, `delivery_fee`, `product_image`) VALUES
(1, '상품명1', 'A0001B0001C0001', '\r\n설명 1\r\n\r\n', '/pinkping/admin/upload/20240411094455109948.jpg', 100000, 0, 0, 0, 0, 1, 1, 0, 0, 1, 'admin', '2024-04-11 00:00:00', '2024-04-11 16:45:40', 1, 0, NULL),
(2, '상품명2', 'A0001B0001C0001', '<p>설명2</p>', '/pinkping/admin/upload/20240411102030943193.jpg', 15000, 0, 0, 0, 0, 1, 1, 0, 0, 2, 'admin', '2024-04-18 00:00:00', '2024-04-11 17:20:30', 0, 0, NULL),
(3, '상품명3', 'A0002', '<p>설명3</p>', '/pinkping/admin/upload/20240412053356156422.jpg', 5000, 0, 0, 0, 0, 1, 1, 0, 0, 2, 'admin', '2024-06-01 00:00:00', '2024-04-12 12:33:56', 1, 0, NULL),
(9, '상품명1', 'A0001B0001C0001', '\r\n설명 1\r\n\r\n', '/pinkping/admin/upload/20240411094455109948.jpg', 100000, 0, 0, 0, 0, 1, 1, 0, 0, 1, 'admin', '2024-04-11 00:00:00', '2024-04-11 16:45:40', 1, 0, NULL),
(10, '상품명2', 'A0001B0001C0001', '<p>설명2</p>', '/pinkping/admin/upload/20240411102030943193.jpg', 15000, 0, 0, 0, 0, 1, 1, 0, 0, 2, 'admin', '2024-04-18 00:00:00', '2024-04-11 17:20:30', 0, 0, NULL),
(11, '상품명3', 'A0002', '<p>설명3</p>', '/pinkping/admin/upload/20240412053356156422.jpg', 5000, 0, 0, 0, 0, 1, 1, 0, 0, 2, 'admin', '2024-06-01 00:00:00', '2024-04-12 12:33:56', 1, 0, NULL),
(12, '상품명1', 'A0001B0001C0001', '\r\n설명 1\r\n\r\n', '/pinkping/admin/upload/20240411094455109948.jpg', 100000, 0, 0, 0, 0, 1, 1, 0, 0, 1, 'admin', '2024-04-11 00:00:00', '2024-04-11 16:45:40', 1, 0, NULL),
(13, '상품명2', 'A0001B0001C0001', '<p>설명2</p>', '/pinkping/admin/upload/20240411102030943193.jpg', 15000, 0, 0, 0, 0, 1, 1, 0, 0, 2, 'admin', '2024-04-18 00:00:00', '2024-04-11 17:20:30', 0, 0, NULL),
(14, '상품명3', 'A0002', '<p>설명3</p>', '/pinkping/admin/upload/20240412053356156422.jpg', 5000, 0, 0, 0, 0, 1, 1, 0, 0, 2, 'admin', '2024-06-01 00:00:00', '2024-04-12 12:33:56', 1, 0, NULL),
(15, '상품명1', 'A0001B0001C0001', '\r\n설명 1\r\n\r\n', '/pinkping/admin/upload/20240411094455109948.jpg', 100000, 0, 0, 0, 0, 1, 1, 0, 0, 1, 'admin', '2024-04-11 00:00:00', '2024-04-11 16:45:40', 1, 0, NULL),
(16, '상품명2', 'A0001B0001C0001', '<p>설명2</p>', '/pinkping/admin/upload/20240411102030943193.jpg', 15000, 0, 0, 0, 0, 1, 1, 0, 0, 2, 'admin', '2024-04-18 00:00:00', '2024-04-11 17:20:30', 0, 0, NULL),
(17, '상품명3', 'A0002', '<p>설명3</p>', '/pinkping/admin/upload/20240412053356156422.jpg', 5000, 0, 0, 0, 0, 1, 1, 0, 0, 2, 'admin', '2024-06-01 00:00:00', '2024-04-12 12:33:56', 1, 0, NULL),
(18, '옵션 테스트', 'A0001B0001C0001', '옵션 테스트 설명', '/pinkping/admin/upload/20240415061019208604.png', 12000, 0, 0, 0, 0, 0, 1, 0, 0, 2, 'admin', '2024-05-10 00:00:00', '2024-04-15 13:10:19', 0, 0, NULL),
(19, '옵션 테스트2', 'A0001', '<p>ㅁㄴㅇㄹ</p>', '/pinkping/admin/upload/20240415061131208852.jpg', 12000, 0, 0, 0, 0, 0, 1, 0, 0, 2, 'admin', '2024-04-06 00:00:00', '2024-04-15 13:11:31', 0, 0, NULL),
(20, '옵션 테스트3', 'A0001', '<p>ㅁㄴㅇㄹ</p>', '/pinkping/admin/upload/20240415061341830924.jpg', 12000, 0, 0, 0, 0, 0, 1, 0, 0, 1, 'admin', '2024-04-26 00:00:00', '2024-04-15 13:13:41', 0, 0, NULL),
(21, '옵션 테스트4 - 수정4', 'A0001', '<p>ㅁㄴㅇㄹ - 수정4</p>', '/pinkping/admin/upload/20240416053252648887.png', 12000, 0, 0, 0, 0, 0, 1, 1, 1, 2, 'admin', '2024-04-27 00:00:00', '2024-04-16 12:32:52', 0, 0, NULL),
(22, '옵션 테스트5 - 수정2', '', '<p>ㅁㄴㅇㄹ - 수정2</p>', '/pinkping/admin/upload/20240416050858857797.jpg', 15000, 0, 0, 0, 0, 1, 0, 0, 1, 2, 'admin', '2024-04-30 00:00:00', '2024-04-16 12:08:58', 0, 0, NULL),
(23, '옵션 테스트 6', 'A0002', '<p>설명 테스트</p>', '/pinkping/admin/upload/20240416052245763666.jpg', 12000, 0, 0, 0, 0, 1, 1, 0, 0, 2, 'admin', '2024-04-30 00:00:00', '2024-04-16 12:22:45', 0, 0, NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `product_image_table`
--

CREATE TABLE `product_image_table` (
  `imgid` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `userid` varchar(100) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `regdate` datetime DEFAULT current_timestamp(),
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `product_image_table`
--

INSERT INTO `product_image_table` (`imgid`, `pid`, `userid`, `filename`, `regdate`, `status`) VALUES
(8, NULL, 'admin', '20240411073607928959.jpg', '2024-04-11 14:36:07', 1),
(9, NULL, 'admin', '20240411073607153251.jpg', '2024-04-11 14:36:07', 0),
(10, NULL, 'admin', '20240411100220182195.jpg', '2024-04-11 17:02:20', 1),
(11, NULL, 'admin', '20240411100220879936.jpg', '2024-04-11 17:02:20', 1),
(12, NULL, 'admin', '20240411101513709015.jpg', '2024-04-11 17:15:13', 1),
(13, NULL, 'admin', '20240411101513158209.jpg', '2024-04-11 17:15:13', 1),
(14, 2, 'admin', '20240411102025195246.jpg', '2024-04-11 17:20:25', 1),
(15, 2, 'admin', '20240411102025611566.jpg', '2024-04-11 17:20:25', 1),
(16, NULL, 'admin', '20240412053122130407.jpg', '2024-04-12 12:31:22', 1),
(17, NULL, 'admin', '20240412053122183024.jpg', '2024-04-12 12:31:22', 1),
(18, 18, 'admin', '20240415060911391403.jpg', '2024-04-15 13:09:11', 1),
(19, 18, 'admin', '20240415060911133914.jpg', '2024-04-15 13:09:11', 1),
(20, 19, 'admin', '20240415061101321269.jpg', '2024-04-15 13:11:01', 1),
(21, 19, 'admin', '20240415061101201028.png', '2024-04-15 13:11:01', 1),
(22, 20, 'admin', '20240415061322187228.png', '2024-04-15 13:13:22', 1),
(23, 20, 'admin', '20240415061322149663.jpg', '2024-04-15 13:13:22', 1),
(24, 21, 'admin', '20240415061508995368.jpg', '2024-04-15 13:15:08', 1),
(25, 21, 'admin', '20240415061508951755.jpg', '2024-04-15 13:15:08', 1),
(26, 22, 'admin', '20240415093302208658.jpg', '2024-04-15 16:33:02', 1),
(27, 22, 'admin', '20240415093302131934.jpg', '2024-04-15 16:33:02', 1),
(28, 22, 'admin', '20240416045817135679.png', '2024-04-16 11:58:17', 1),
(29, 22, 'admin', '20240416050647206653.jpg', '2024-04-16 12:06:47', 1),
(30, 21, 'admin', '20240416051548140335.jpg', '2024-04-16 12:15:48', 1),
(31, NULL, 'admin', '20240416051711643010.jpg', '2024-04-16 12:17:11', 1),
(32, 23, 'admin', '20240416052223135351.jpg', '2024-04-16 12:22:23', 1),
(33, 23, 'admin', '20240416052224619383.jpg', '2024-04-16 12:22:24', 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `product_options`
--

CREATE TABLE `product_options` (
  `poid` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `cate` varchar(100) DEFAULT NULL,
  `option_name` varchar(100) DEFAULT NULL,
  `option_cnt` int(11) DEFAULT NULL,
  `option_price` int(11) DEFAULT NULL,
  `image_url` varchar(300) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `product_options`
--

INSERT INTO `product_options` (`poid`, `pid`, `cate`, `option_name`, `option_cnt`, `option_price`, `image_url`, `status`) VALUES
(10, 21, '컬러', '블루수정2', 200, 20000, '/pinkping/admin/upload/optiondata/20240416053252531507.jpg', 1),
(11, 21, '컬러', '블루수정2', 200, 20000, '/pinkping/admin/upload/optiondata/20240416053252531507.jpg', 1),
(12, 22, '컬러', '레드', 100, 10000, '/pinkping/admin/upload/optiondata/20240415093325172771.png', 1),
(13, 22, '컬러', '블루', 100, 12000, '/pinkping/admin/upload/optiondata/20240415093325115012.jpg', 1),
(14, 23, '컬러', '레드', 100, 200, '/pinkping/admin/upload/optiondata/20240416052245112937.jpg', 1),
(15, 23, '컬러', '블루', 200, 300, '/pinkping/admin/upload/optiondata/20240416052245101851.jpg', 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `user_coupons`
--

CREATE TABLE `user_coupons` (
  `ucid` int(11) NOT NULL,
  `couponid` int(11) DEFAULT NULL COMMENT '쿠폰아이디',
  `userid` varchar(100) DEFAULT NULL COMMENT '유저아이디',
  `status` int(11) DEFAULT 1 COMMENT '상태',
  `use_max_date` datetime DEFAULT NULL COMMENT '사용기한',
  `regdate` datetime DEFAULT NULL COMMENT '등록일',
  `reason` varchar(100) DEFAULT NULL COMMENT '쿠폰취득사유'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cid`);

--
-- 테이블의 인덱스 `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`cid`);

--
-- 테이블의 인덱스 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`);

--
-- 테이블의 인덱스 `product_image_table`
--
ALTER TABLE `product_image_table`
  ADD PRIMARY KEY (`imgid`);

--
-- 테이블의 인덱스 `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`poid`),
  ADD KEY `newtable_pid_IDX` (`pid`) USING BTREE;

--
-- 테이블의 인덱스 `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD PRIMARY KEY (`ucid`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `category`
--
ALTER TABLE `category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- 테이블의 AUTO_INCREMENT `coupons`
--
ALTER TABLE `coupons`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 테이블의 AUTO_INCREMENT `product_image_table`
--
ALTER TABLE `product_image_table`
  MODIFY `imgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- 테이블의 AUTO_INCREMENT `product_options`
--
ALTER TABLE `product_options`
  MODIFY `poid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 테이블의 AUTO_INCREMENT `user_coupons`
--
ALTER TABLE `user_coupons`
  MODIFY `ucid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
