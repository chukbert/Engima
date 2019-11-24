-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 22, 2019 at 05:05 PM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `WBDdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `idFilm` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `releaseDate` date NOT NULL,
  `durationMinutes` int(10) NOT NULL,
  `synopsis` varchar(1000) NOT NULL,
  `posterUrl` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`idFilm`, `title`, `releaseDate`, `durationMinutes`, `synopsis`, `posterUrl`) VALUES
(1, 'Avengers: Endgame', '2019-09-24', 182, 'Adrift in space with no food or water, Tony Stark sends a message to Pepper Potts as his oxygen supply starts to dwindle. Meanwhile, the remaining Avengers -- Thor, Black Widow, Captain America and Bruce Banner -- must figure out a way to bring back their vanquished allies for an epic showdown with Thanos -- the evil demigod who decimated the planet and the universe.', '/uploads/film/avengers_endgame.jpg'),
(2, 'Avengers: Infinity War', '2019-09-20', 160, 'Iron Man, Thor, the Hulk and the rest of the Avengers unite to battle their most powerful enemy yet -- the evil Thanos. On a mission to collect all six Infinity Stones, Thanos plans to use the artifacts to inflict his twisted will on reality. The fate of the planet and existence itself has never been more uncertain as everything the Avengers have fought for has led up to this moment.', '/uploads/film/avengers_infinity_war.jpg'),
(3, 'Aladdin', '1992-11-25', 91, 'When street rat Aladdin frees a genie from a lamp, he finds his wishes granted. However, he soon finds that the evil has other plans for the lamp -- and for Princess Jasmine. But can Aladdin save Princess Jasmine and his love for her after she sees that he isn\'t quite what he appears to be?', '/uploads/film/aladdin.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `filmgenre`
--

CREATE TABLE `filmgenre` (
  `idFilm` int(10) NOT NULL,
  `idGenre` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `filmgenre`
--

INSERT INTO `filmgenre` (`idFilm`, `idGenre`) VALUES
(1, 3),
(1, 1),
(1, 2),
(2, 3),
(2, 2),
(3, 3),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `idGenre` int(10) NOT NULL,
  `genre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`idGenre`, `genre`) VALUES
(1, 'Drama'),
(2, 'Fantasy'),
(3, 'Adventure');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `idReview` int(10) NOT NULL,
  `idTransaction` int(10) NOT NULL,
  `rating` int(5) NOT NULL,
  `comment` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`idReview`, `idTransaction`, `rating`, `comment`) VALUES
(1, 14, 8, 'asdsad'),
(2, 15, 10, 'Mantap jiwaaaaaaaaaaaaaaaaaaaaa'),
(3, 16, 8, 'So-so.'),
(5, 18, 9, 'Good movie, but I wasn\'t even born yet.');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `idSchedule` int(10) NOT NULL,
  `idFilm` int(10) NOT NULL,
  `dateTime` datetime NOT NULL,
  `maxSeats` int(10) NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`idSchedule`, `idFilm`, `dateTime`, `maxSeats`, `price`) VALUES
(1, 2, '2019-09-21 10:00:00', 20, 25000),
(2, 2, '2019-09-21 14:00:00', 20, 25000),
(3, 2, '2019-09-21 18:00:00', 20, 25000),
(4, 1, '2019-09-26 10:00:00', 20, 45000),
(5, 1, '2019-09-29 10:00:00', 20, 45000),
(6, 1, '2019-09-29 14:00:00', 10, 45000),
(7, 1, '2019-09-29 18:00:00', 20, 45000),
(8, 3, '1992-12-12 10:00:00', 30, 100000),
(9, 19, '2019-09-29 18:00:00', 20, 2000),
(59, 330457, '2019-11-21 00:00:00', 20, 45000),
(60, 330457, '2019-11-22 00:00:00', 20, 45000),
(61, 330457, '2019-11-23 00:00:00', 20, 45000),
(62, 330457, '2019-11-24 00:00:00', 20, 45000),
(63, 330457, '2019-11-25 00:00:00', 20, 45000),
(64, 330457, '2019-11-26 00:00:00', 20, 45000),
(65, 330457, '2019-11-27 00:00:00', 20, 45000),
(66, 492188, '2019-11-16 00:00:00', 20, 45000),
(67, 492188, '2019-11-17 00:00:00', 20, 45000),
(68, 492188, '2019-11-18 00:00:00', 20, 45000),
(69, 492188, '2019-11-19 00:00:00', 20, 45000),
(70, 492188, '2019-11-20 00:00:00', 20, 45000),
(71, 492188, '2019-11-21 00:00:00', 20, 45000),
(72, 492188, '2019-11-22 00:00:00', 20, 45000),
(73, 501907, '2019-11-23 00:00:00', 20, 45000),
(74, 501907, '2019-11-24 00:00:00', 20, 45000),
(75, 501907, '2019-11-25 00:00:00', 20, 45000),
(76, 501907, '2019-11-26 00:00:00', 20, 45000),
(77, 501907, '2019-11-27 00:00:00', 20, 45000),
(78, 501907, '2019-11-28 00:00:00', 20, 45000),
(79, 501907, '2019-11-29 00:00:00', 20, 45000),
(80, 626299, '2019-11-16 00:00:00', 20, 45000),
(81, 626299, '2019-11-17 00:00:00', 20, 45000),
(82, 626299, '2019-11-18 00:00:00', 20, 45000),
(83, 626299, '2019-11-19 00:00:00', 20, 45000),
(84, 626299, '2019-11-20 00:00:00', 20, 45000),
(85, 626299, '2019-11-21 00:00:00', 20, 45000),
(86, 626299, '2019-11-22 00:00:00', 20, 45000),
(87, 611207, '2019-11-22 00:00:00', 20, 45000),
(88, 611207, '2019-11-23 00:00:00', 20, 45000),
(89, 611207, '2019-11-24 00:00:00', 20, 45000),
(90, 611207, '2019-11-25 00:00:00', 20, 45000),
(91, 611207, '2019-11-26 00:00:00', 20, 45000),
(92, 611207, '2019-11-27 00:00:00', 20, 45000),
(93, 611207, '2019-11-28 00:00:00', 20, 45000);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `idTransaction` int(10) NOT NULL,
  `idUser` int(10) NOT NULL,
  `idSchedule` int(10) NOT NULL,
  `seatNumber` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`idTransaction`, `idUser`, `idSchedule`, `seatNumber`) VALUES
(1, 21, 6, 1),
(2, 21, 6, 2),
(3, 21, 6, 3),
(4, 21, 6, 4),
(5, 21, 6, 5),
(6, 21, 6, 6),
(7, 21, 6, 7),
(8, 21, 6, 8),
(9, 21, 6, 9),
(10, 21, 6, 10),
(11, 22, 7, 2),
(12, 21, 7, 3),
(13, 21, 8, 4),
(14, 21, 1, 1),
(15, 21, 2, 1),
(16, 22, 1, 4),
(17, 21, 4, 12),
(18, 21, 8, 1),
(0, 23, 7, 20),
(0, 24, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `profilePicture` varchar(200) NOT NULL,
  `cookie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `username`, `password`, `email`, `phoneNumber`, `profilePicture`, `cookie`) VALUES
(21, 'asif', 'ce0b996aa0b7d64169a4b8ffeaf878c5', 'asif@gmail.com', '085725574114', '/uploads/profile/0b25bdbf912ab2de84d3d6b244447387-Yu Narukami.png', 'eyIyMDQyMjEyMzQ0IjoxNTY5NzQ0OTg0fQ=='),
(22, 'haha', '4e4d6c332b6fe62a63afe56171fd3725', 'haha@gmail.com', '08221312321', '/uploads/profile/0b25bdbf912ab2de84d3d6b244447387-Yu Narukami.png', 'eyIyMDcxODU0ODUzIjoxNTY5NzI4NDk2fQ=='),
(23, 'asd', '7815696ecbf1c96e6894b779456d330e', 'asd@gmail.com', '085123123123', '/uploads/profile/0b25bdbf912ab2de84d3d6b244447387-Yu Narukami.png', 'eyI1MjMxMTE3ODYiOjE1Njk3MzU0MDV9'),
(24, 'mantap', '2fea6c02a98d6318d44cdf150775f07a', 'mantap@gmail.com', '085725574119', '/uploads/profile/0b25bdbf912ab2de84d3d6b244447387-Yu Narukami.png', 'eyI2MzMwMDU1MjciOjE1Njk3NDg1NzV9'),
(25, 'hahaha', '101a6ec9f938885df0a44f20458d2eb4', 'hahaha@gmail.com', '123123123123', '/uploads/profile/0b25bdbf912ab2de84d3d6b244447387-Yu Narukami.png', 'eyIxOTM1OTk2ODE1IjoxNTY5NzQ4Nzc0fQ=='),
(26, 'bari', '53b937338b7f2f0279343ca336cef9ed', 'bariansyahi@gmail.com', '081220740745', '/uploads/profile/ab979b390123bc89d96872a47113ac49-worker.png', 'eyIxNTU5MzExOTkiOjE1NzQ0NDUzNjN9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`idReview`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`idSchedule`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `username` (`username`,`email`,`phoneNumber`),
  ADD UNIQUE KEY `username_2` (`username`,`email`,`phoneNumber`),
  ADD UNIQUE KEY `username_3` (`username`,`email`,`phoneNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `idReview` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `idSchedule` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
