-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2022 年 6 月 09 日 13:55
-- サーバのバージョン： 5.7.34
-- PHP のバージョン: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `kadai_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf32_unicode_ci NOT NULL,
  `pass` varchar(128) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- テーブルのデータのダンプ `user`
--

INSERT INTO `user` (`id`, `name`, `pass`) VALUES
(1, 'tes', '$argon2i$v=19$m=65536,t=4,p=1$VFJITGxxc3JoN2hJZi5zNw$jMRxdWA12mJOJccfV6SkC3gbEd3aifBLKOPtFLM/ss0'),
(5, 'test', '$argon2i$v=19$m=65536,t=4,p=1$YjNXcko3SW53d08yVkcxQQ$YDsq4uxL36smwa5xJlocnMfRlzXyq8NJA4FL+N/LoYo');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
