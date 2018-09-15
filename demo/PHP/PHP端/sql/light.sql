-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 06 月 27 日 16:48
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `light`
--

-- --------------------------------------------------------

--
-- 表的结构 `ts_admin`
--

CREATE TABLE IF NOT EXISTS `ts_admin` (
  `admin_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员编号',
  `admin_name` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ts_admin`
--

INSERT INTO `ts_admin` (`admin_id`, `admin_name`, `password`, `email`, `add_time`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@itcast.cn', 0),
(2, 'test', 'test', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `ts_photosensitive`
--

CREATE TABLE IF NOT EXISTS `ts_photosensitive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_id` tinyint(4) NOT NULL DEFAULT '1',
  `photosensitive` varchar(20) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- 转存表中的数据 `ts_photosensitive`
--

INSERT INTO `ts_photosensitive` (`id`, `node_id`, `photosensitive`, `time`) VALUES
(12, 1, '5', 1529563746),
(13, 1, '12', 1529563749),
(14, 1, '12', 1529563752),
(15, 1, '12', 1529563755),
(16, 1, '12', 1529563758),
(17, 1, '12', 1529563761),
(18, 1, '11', 1529563764),
(19, 1, '10', 1529563767),
(20, 1, '8', 1529563770),
(21, 1, '12', 1529563797),
(22, 1, '12', 1529563800),
(23, 1, '12', 1529563803),
(24, 1, '12', 1529563806),
(25, 1, '12', 1529563809),
(26, 1, '12', 1529563812),
(27, 1, '12', 1529563815),
(28, 1, '22', 1529564407),
(29, 1, '22', 1529564410),
(30, 1, '22', 1529564413),
(31, 1, '22', 1529564416),
(32, 1, '22', 1529564419),
(33, 1, '22', 1529564422),
(34, 1, '22', 1529564425),
(35, 1, '22', 1529564428),
(36, 1, '22', 1529564431),
(37, 1, '22', 1529564434),
(38, 1, '33', 1530077188),
(39, 1, '33', 1530077191),
(40, 1, '32', 1530077194),
(41, 1, '33', 1530077197),
(42, 1, '33', 1530077200),
(43, 1, '33', 1530077203),
(44, 1, '33', 1530077206),
(45, 1, '32', 1530077209),
(46, 1, '21', 1530077348),
(47, 1, '22', 1530077351),
(48, 1, '25', 1530077354),
(49, 1, '25', 1530077357),
(50, 1, '26', 1530077360),
(51, 1, '26', 1530077363),
(52, 1, '22', 1530077366),
(53, 1, '17', 1530077369),
(54, 1, '23', 1530077372),
(55, 1, '24', 1530077375),
(56, 1, '24', 1530077378),
(57, 1, '24', 1530077381),
(58, 1, '23', 1530077384),
(59, 1, '17', 1530077387),
(60, 1, '24', 1530077390),
(61, 1, '27', 1530077393),
(62, 1, '29', 1530077396),
(63, 1, '28', 1530077399),
(64, 1, '26', 1530077402),
(65, 1, '38', 1530077405),
(66, 1, '43', 1530077408),
(67, 1, '41', 1530077411),
(68, 1, '55', 1530077414),
(69, 1, '32', 1530077417),
(70, 1, '43', 1530077420),
(71, 1, '37', 1530077423),
(72, 1, '27', 1530077426),
(73, 1, '28', 1530077429);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
