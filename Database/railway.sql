-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2015 年 04 月 12 日 20:17
-- 伺服器版本: 5.6.17
-- PHP 版本： 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫： `railway`
--

-- --------------------------------------------------------

--
-- 資料表結構 `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(200) NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `order_detail`
--

CREATE TABLE IF NOT EXISTS `order_detail` (
  `order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  PRIMARY KEY (`order_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `order_head`
--

CREATE TABLE IF NOT EXISTS `order_head` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `railroad_detail`
--

CREATE TABLE IF NOT EXISTS `railroad_detail` (
  `railroad_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `time_schedule` time NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`railroad_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `railroad_head`
--

CREATE TABLE IF NOT EXISTS `railroad_head` (
  `railroad_head_id` int(11) NOT NULL AUTO_INCREMENT,
  `railroad_number` varchar(10) NOT NULL,
  `train_id` int(11) NOT NULL,
  `day` int(11) NOT NULL COMMENT 'M for Monday, T for Tuesday, W for Wed, TH for thursday, F for friday, S for saturday, U for sunday',
  PRIMARY KEY (`railroad_head_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `railroad_id` int(11) NOT NULL,
  `departure_city_id` int(11) NOT NULL,
  `arrival_city_id` int(11) NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `train`
--

CREATE TABLE IF NOT EXISTS `train` (
  `train_id` int(11) NOT NULL AUTO_INCREMENT,
  `train_name` varchar(100) NOT NULL,
  `number_seats` int(11) NOT NULL,
  `handicap` tinyint(1) NOT NULL,
  PRIMARY KEY (`train_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`users_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
