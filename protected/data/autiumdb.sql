-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 03, 2017 at 09:47 AM
-- Server version: 5.5.54-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `autiumdb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series`(IN n_first BIGINT, IN n_last BIGINT)
BEGIN
    -- Call base stored procedure
    CALL generate_series_base(n_first, n_last);
    
    -- Output
    SELECT * FROM series_tmp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_base`(IN n_first BIGINT, IN n_last BIGINT)
BEGIN
    -- Call generate_series_n_base stored procedure with "1" as "n_increment".
    CALL generate_series_n_base(n_first, n_last, 1);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_date_day`(IN n_first DATETIME, IN n_last DATETIME, IN n_increment CHAR(40))
BEGIN
    -- Call base stored procedure
    CALL generate_series_date_day_base(n_first, n_last, n_increment);
    
    -- Output
    SELECT * FROM series_tmp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_date_day_base`(IN n_first DATETIME, IN n_last DATETIME, IN n_increment CHAR(40))
BEGIN
    -- Create tmp table
    DROP TEMPORARY TABLE IF EXISTS series_tmp;
    CREATE TEMPORARY TABLE series_tmp (
        series DATETIME
    ) engine = memory;
    
    WHILE n_first  <= n_last DO
        -- Insert in tmp table
        INSERT INTO series_tmp (series) VALUES (n_first);

        -- Increment value by one
        SELECT DATE_ADD(n_first, INTERVAL +n_increment day) INTO n_first;
    END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_date_day_no_output`(IN n_first DATETIME, IN n_last DATETIME, IN n_increment CHAR(40))
BEGIN
    -- Call base stored procedure
    CALL generate_series_date_day_base(n_first, n_last, n_increment);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_date_hour`(IN n_first DATETIME, IN n_last DATETIME, IN n_increment CHAR(40))
BEGIN
    -- Call base stored procedure
    CALL generate_series_date_hour_base(n_first, n_last, n_increment);
    
    -- Output
    SELECT * FROM series_tmp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_date_hour_base`(IN n_first DATETIME, IN n_last DATETIME, IN n_increment CHAR(40))
BEGIN
    -- Create tmp table
    DROP TEMPORARY TABLE IF EXISTS series_tmp;
    CREATE TEMPORARY TABLE series_tmp (
        series DATETIME
    ) engine = memory;
    
    WHILE n_first  <= n_last DO
        -- Insert in tmp table
        INSERT INTO series_tmp (series) VALUES (n_first);

        -- Increment value by one
        SELECT DATE_ADD(n_first, INTERVAL +n_increment hour) INTO n_first;
    END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_date_hour_no_output`(IN n_first DATETIME, IN n_last DATETIME, IN n_increment CHAR(40))
BEGIN
    -- Call base stored procedure
    CALL generate_series_date_hour_base(n_first, n_last, n_increment);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_date_minute`(IN n_first DATETIME, IN n_last DATETIME, IN n_increment CHAR(40))
BEGIN
    -- Call base stored procedure
    CALL generate_series_date_minute_base(n_first, n_last, n_increment);
    
    -- Output
    SELECT * FROM series_tmp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_date_minute_base`(IN n_first DATETIME, IN n_last DATETIME, IN n_increment CHAR(40))
BEGIN
    -- Create tmp table
    DROP TEMPORARY TABLE IF EXISTS series_tmp;
    CREATE TEMPORARY TABLE series_tmp (
        series DATETIME
    ) engine = memory;
    
    WHILE n_first  <= n_last DO
        -- Insert in tmp table
        INSERT INTO series_tmp (series) VALUES (n_first);

        -- Increment value by one
        SELECT DATE_ADD(n_first, INTERVAL +n_increment minute) INTO n_first;
    END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_date_minute_no_output`(IN n_first DATETIME, IN n_last DATETIME, IN n_increment CHAR(40))
BEGIN
    -- Call base stored procedure
    CALL generate_series_date_minute_base(n_first, n_last, n_increment);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_n`(IN n_first BIGINT, IN n_last BIGINT, IN n_increment BIGINT)
BEGIN
    -- Call base stored procedure
    CALL generate_series_n_base(n_first, n_last, n_increment);
    
    -- Output
    SELECT * FROM series_tmp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_no_output`(IN n_first BIGINT, IN n_last BIGINT)
BEGIN
    -- Call base stored procedure
    CALL generate_series_base(n_first, n_last);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_n_base`(IN n_first BIGINT, IN n_last BIGINT, IN n_increment BIGINT)
BEGIN
    -- Create tmp table
    DROP TEMPORARY TABLE IF EXISTS series_tmp;
    CREATE TEMPORARY TABLE series_tmp (
        series bigint
    ) engine = memory;
    
    WHILE n_first <= n_last DO
        -- Insert in tmp table
        INSERT INTO series_tmp (series) VALUES (n_first);

        -- Increment value by one
        SET n_first = n_first + n_increment; 
    END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_series_n_no_output`(IN n_first BIGINT, IN n_last BIGINT, IN n_increment BIGINT)
BEGIN
    -- Call base stored procedure
    CALL generate_series_n_base(n_first, n_last, n_increment);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accident`
--

CREATE TABLE IF NOT EXISTS `accident` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `occured_at` datetime NOT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `vehicle_reg` varchar(255) NOT NULL,
  `make` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `weather_condition` varchar(255) DEFAULT 'Sunny',
  `notes` text,
  `note_type` varchar(255) DEFAULT NULL,
  `source` varchar(255) NOT NULL DEFAULT 'Mobile',
  `claim_cost` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `driver_id` (`driver_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=153 ;

--
-- Dumping data for table `accident`
--

INSERT INTO `accident` (`id`, `driver_id`, `occured_at`, `longitude`, `latitude`, `location`, `vehicle_reg`, `make`, `model`, `weather_condition`, `notes`, `note_type`, `source`, `claim_cost`) VALUES
(1, 5, '2017-07-13 06:05:01', -2.15448992724152, 52.4533091526386, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(2, 3, '2017-12-07 17:53:00', -0.9726842, 51.1506875, NULL, 'EH4PML1', 'Mercedes', 'S-Type', 'Sunny', NULL, NULL, 'Mobile', NULL),
(3, 16, '2017-01-06 18:04:00', 148.2038438, -35.1925522, NULL, 'EH4PML10', 'Dodge', 'Van', 'Sunny', NULL, NULL, 'Mobile', NULL),
(4, 11, '2017-12-07 18:13:00', -79.7514054, 43.3699688, NULL, 'EH4PML15', 'Honda', 'Van', 'Sunny', NULL, NULL, 'Mobile', NULL),
(5, 6, '2017-01-18 09:36:42', NULL, NULL, NULL, 'EKC 8CS', 'BMW', 'V8', 'Sunny', NULL, NULL, 'Mobile', NULL),
(6, 6, '2017-01-18 09:36:42', NULL, NULL, 'Tseting Manual Location', 'EKC 8CS', 'BMW', 'V8', 'Sunny', NULL, NULL, 'Mobile', NULL),
(7, 6, '2017-01-18 09:36:42', NULL, NULL, 'Tseting Manual Location', 'EKC 8CS', 'BMW', 'V8', 'Sunny', NULL, NULL, 'Mobile', NULL),
(8, 6, '2017-01-18 09:36:42', NULL, NULL, 'Tseting Manual Location', 'EKC 8CS', 'BMW', 'V8', 'Sunny', NULL, NULL, 'Mobile', NULL),
(9, 6, '2017-01-18 09:36:42', NULL, NULL, 'Tseting Manual Location', 'EKC 8CS', 'BMW', 'V8', 'Sunny', NULL, NULL, 'Mobile', NULL),
(10, 6, '2017-01-18 09:36:42', NULL, NULL, 'Tseting Manual Location', 'EKC 8CS', 'BMW', 'V8', 'Sunny', NULL, NULL, 'Mobile', NULL),
(11, 6, '2017-07-19 12:24:30', -0.1337, 51.50998, '', 'FR56 HGY', 'citroen', 'Berlingo', 'Sunny', NULL, NULL, 'Mobile', NULL),
(12, 6, '2017-07-19 12:29:46', NULL, NULL, 'Testing', 'FR56 HGY', 'citroen', 'Berlingo', 'Sunny', NULL, NULL, 'Mobile', NULL),
(13, 4, '2017-07-19 19:34:47', NULL, NULL, 'Manual location ', 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(14, 4, '2017-07-21 12:46:28', -1.05870637111464, 51.727104932118, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', 'Driver was heading down the M40 and vehicle in front put the brakes on sharply. Driver didn''t ave enough time or distance to stop and shunted the other vehicle in the back. Our driver states that the vehicle in front had no reason to stop and the CCTV footage shows that this is correct. ', NULL, 'Mobile', NULL),
(15, 4, '2017-07-21 02:50:28', -1.05888565544303, 51.7269623694043, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(16, 4, '2017-07-24 19:49:06', NULL, NULL, 'Test', 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(17, 4, '2017-07-24 22:51:01', NULL, NULL, 'Test 2', 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(18, 4, '2017-07-24 19:52:19', NULL, NULL, '213 Main Street , Pathhead', 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(19, 6, '2017-07-30 04:45:10', NULL, NULL, 'USA', 'FR56 HGY', 'citroen', 'Berlingo', 'Sunny', NULL, NULL, 'Mobile', NULL),
(20, 6, '2017-07-30 04:47:09', NULL, NULL, 'Fdsfsf', 'FR56 HGY', 'citroen', 'Berlingo', 'Sunny', NULL, NULL, 'Mobile', NULL),
(21, 6, '2017-08-19 06:08:42', NULL, NULL, 'Lahore', 'KR63 YKG', 'Volvo', 'XC60', 'Snow', NULL, NULL, 'Mobile', NULL),
(22, 6, '2017-08-20 07:10:22', NULL, NULL, 'Lahore', 'FR56 HGY', 'citroen', 'Berlingo', 'Dry', NULL, NULL, 'Mobile', NULL),
(23, 6, '2017-08-19 18:20:36', NULL, NULL, 'Lahore', 'KR63 YKG', 'Volvo', 'XC60', 'Snow', NULL, NULL, 'Mobile', NULL),
(24, 6, '2017-08-19 21:25:56', NULL, NULL, 'Lahore', 'FR56 HGY', 'citroen', 'Berlingo', 'Dry', NULL, NULL, 'Mobile', NULL),
(25, 6, '2017-08-26 19:14:31', NULL, NULL, '20992–20996 W Homestead Rd , Sunnyvale', 'FR56 HGY', 'citroen', 'Berlingo', 'Raining', NULL, NULL, 'Mobile', NULL),
(26, 6, '2017-08-26 19:23:04', NULL, NULL, 'N/A', 'FR56 HGY', 'citroen', 'Berlingo', 'Raining', NULL, NULL, 'Mobile', NULL),
(27, 6, '2017-08-26 19:33:00', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Snow', NULL, NULL, 'Mobile', NULL),
(28, 6, '2017-08-26 21:08:01', NULL, NULL, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Raining', NULL, NULL, 'Mobile', NULL),
(29, 6, '2017-08-26 21:08:53', NULL, NULL, 'Zeeshan manually entered', 'FR56 HGY', 'citroen', 'Berlingo', 'Icy', NULL, NULL, 'Mobile', NULL),
(30, 4, '2017-08-26 08:45:55', -2.15443532761863, 52.4532532731476, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(31, 53, '2017-08-28 12:29:14', NULL, NULL, 'Lahore, Gulberg, Pakistan', 'GAY 8OY', 'Fiat ', '500', 'Dry', NULL, NULL, 'Mobile', NULL),
(32, 53, '2017-08-30 14:24:22', NULL, NULL, NULL, 'EH4PML20', 'Dodge', 'Car', 'Snow', NULL, NULL, 'Mobile', NULL),
(33, 53, '2017-08-30 14:25:51', NULL, NULL, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Dry', NULL, NULL, 'Mobile', NULL),
(34, 4, '2017-09-02 12:08:43', -2.14314040728113, 52.4552746397, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(35, 4, '2017-09-03 12:59:09', NULL, NULL, NULL, '5EXY', 'Rangerover', 'Sport HSE v Sport HSE vSport HSE v', 'Snow', NULL, NULL, 'Mobile', NULL),
(36, 4, '2017-09-07 03:19:20', -1.85217571444982, 52.898776684937, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(37, 4, '2017-09-19 11:34:59', -2.15453577228091, 52.4532328080874, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(38, 4, '2017-09-26 09:29:45', -0.627009104937899, 51.5904237516705, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(39, 4, '2017-09-30 13:55:43', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Dry', NULL, NULL, 'Mobile', NULL),
(40, 4, '2017-09-30 14:05:54', NULL, NULL, NULL, '554a14daswd5554a14daswd5', 'Mercedes', 'T-Type', 'Raining', NULL, NULL, 'Mobile', NULL),
(41, 4, '2017-09-30 14:13:03', NULL, NULL, NULL, 'EH4PML2', 'Landrover', 'R-Type', 'Snow', NULL, NULL, 'Mobile', NULL),
(42, 4, '2017-09-30 19:03:24', NULL, NULL, NULL, '5EXY', 'Rangerover', 'Sport HSE v Sport HSE vSport HSE v', 'Dry', NULL, NULL, 'Mobile', NULL),
(43, 54, '2017-09-30 19:28:21', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Snow', NULL, NULL, 'Mobile', NULL),
(44, 54, '2017-09-30 20:13:39', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Raining', NULL, NULL, 'Mobile', NULL),
(45, 54, '2017-09-30 20:24:14', NULL, NULL, 'Hello Manual location', 'FR56 HGY', 'citroen', 'Berlingo', 'Icy', NULL, NULL, 'Mobile', NULL),
(46, 54, '2017-09-30 20:27:03', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Snow', NULL, NULL, 'Mobile', NULL),
(47, 21, '2017-12-09 20:44:00', NULL, NULL, '', 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', 'test', NULL, 'Fleet Manager', 0),
(48, 1, '2017-09-30 22:09:45', NULL, NULL, '', 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Fleet Manager', NULL),
(49, 21, '2017-08-01 00:00:00', -3.188267, 55.953252, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Dry', NULL, NULL, 'Fleet Manager', NULL),
(50, 54, '2017-09-30 20:51:33', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Foggy', NULL, NULL, 'Mobile', NULL),
(51, 54, '2017-09-30 23:31:12', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Icy', NULL, NULL, 'Mobile', NULL),
(52, 54, '2017-10-01 12:13:29', NULL, NULL, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Raining', NULL, NULL, 'Mobile', NULL),
(53, 54, '2017-10-01 12:15:50', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Raining', NULL, NULL, 'Mobile', NULL),
(54, 54, '2017-10-01 12:19:10', NULL, NULL, 'Near Royalmile ', 'KR63 YKG', 'Volvo', 'XC60', 'Dry', NULL, NULL, 'Mobile', NULL),
(55, 1, '2017-01-10 11:30:00', NULL, NULL, '', 'KR63 YKG', 'Volvo', 'XC60', 'Foggy', NULL, NULL, 'Fleet Manager', NULL),
(56, 54, '2017-10-01 15:15:13', NULL, NULL, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Raining', NULL, NULL, 'Mobile', NULL),
(57, 4, '2017-09-29 17:15:41', NULL, NULL, NULL, '554a14daswd5554a14daswd5', 'Mercedes', 'T-Type', 'Snow', NULL, NULL, 'Mobile', NULL),
(58, 54, '2017-11-10 14:24:00', -3.188267, 55.953252, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Rainy', NULL, NULL, 'Fleet Manager', NULL),
(59, 4, '2017-10-02 22:15:43', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Foggy', NULL, NULL, 'Mobile', NULL),
(60, 54, '2017-10-03 10:32:00', NULL, NULL, 'edinburgh', 'KR63 YKG', 'Volvo', 'XC60', 'Rainy', NULL, NULL, 'Fleet Manager', NULL),
(61, 1, '2017-10-03 10:33:00', NULL, NULL, 'edinburgh, uk ', 'KR63 YKG', 'Volvo', 'XC60', 'Dry', NULL, NULL, 'Fleet Manager', NULL),
(62, 20, '2017-10-03 10:38:00', NULL, NULL, 'edinburgh, a702, UK', 'EH4PML4', 'Lincoln', 'Truck', 'Rainy', NULL, NULL, 'Fleet Manager', NULL),
(63, 1, '2017-10-03 10:41:00', NULL, NULL, 'edinburgh, A701, UK', 'KR63 YKG', 'Volvo', 'XC60', 'Snow', NULL, NULL, 'Fleet Manager', NULL),
(64, 20, '2017-10-03 10:47:00', NULL, NULL, 'edinburgh, A701, UK', 'KR63 YKG', 'Volvo', 'XC60', 'Rainy', 'hello test', NULL, 'Fleet Manager', 200.26),
(65, 4, '2017-10-03 10:33:59', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Foggy', NULL, NULL, 'Mobile', NULL),
(66, 4, '2017-10-03 02:30:42', -1.71951030381184, 52.455406822313, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Sunny', NULL, NULL, 'Mobile', NULL),
(67, 19, '2017-10-03 06:24:00', NULL, NULL, '123', '5EXY', 'Rangerover', 'Sport HSE ', 'Foggy', NULL, NULL, 'Fleet Manager', NULL),
(68, 54, '2017-10-03 12:32:51', NULL, NULL, NULL, '5EXY', 'Rangerover', 'Sport HSE ', 'Dry', 'test', 'Collision whilst reversing', 'Mobile', 676.9),
(69, 54, '2017-10-03 22:46:39', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Dry', NULL, NULL, 'Mobile', NULL),
(70, 54, '2017-10-04 10:05:56', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Raining', 'test', 'Collision with a  moving vehicle', 'Mobile', 200),
(71, 54, '2017-10-04 11:17:22', NULL, NULL, NULL, '5EXY', 'Rangerover', 'Sport HSE ', 'Snow', NULL, NULL, 'Mobile', NULL),
(72, 54, '2017-10-04 11:29:10', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Dry', NULL, NULL, 'Mobile', NULL),
(73, 54, '2017-10-05 10:43:15', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Snow', NULL, NULL, 'Mobile', NULL),
(74, 54, '2017-10-05 12:23:44', NULL, NULL, NULL, 'EH4PML18', 'Fiat', 'Car', 'Raining', NULL, NULL, 'Mobile', NULL),
(75, 54, '2017-10-05 13:39:27', NULL, NULL, NULL, 'FR56 HGY', 'citroen', 'Berlingo', 'Dry', NULL, NULL, 'Mobile', NULL),
(76, 64, '2017-10-06 11:16:00', NULL, NULL, 'edinburgh', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Fleet Manager', NULL),
(77, 66, '2017-10-06 14:47:53', NULL, NULL, NULL, 'FR56 HGY', 'Scania', 'Rigid Body', 'Snow', '', 'Collision with a  moving vehicle', 'Mobile', 200),
(78, 66, '2017-10-19 03:59:00', NULL, NULL, '432', 'FR56 HGY', 'Scania', 'Rigid Body', 'Foggy', NULL, NULL, 'Fleet Manager', NULL),
(79, 66, '2017-10-06 18:47:13', NULL, NULL, NULL, 'SO64 FGH', 'BMW', 'X5', 'Snow', NULL, NULL, 'Mobile', NULL),
(80, 66, '2017-10-06 20:35:35', NULL, NULL, NULL, 'SO64 FGH', 'BMW', 'X5', 'Snow', NULL, NULL, 'Mobile', NULL),
(81, 70, '2017-10-07 09:37:04', NULL, NULL, NULL, 'YS65DUU', 'Ford', 'Focus', 'Dry', NULL, NULL, 'Mobile', NULL),
(82, 66, '2017-10-06 20:54:09', NULL, NULL, NULL, 'SO64 FGH', 'BMW', 'X5', 'Raining', NULL, NULL, 'Mobile', NULL),
(83, 66, '2017-10-06 18:47:13', NULL, NULL, NULL, 'SO64 FGH', 'BMW', 'X5', 'Snow', NULL, NULL, 'Mobile', NULL),
(84, 66, '2017-10-07 17:58:22', NULL, NULL, NULL, 'SO64 FGH', 'BMW', 'X5', 'Snow', NULL, NULL, 'Mobile', NULL),
(85, 76, '2017-10-07 20:04:14', NULL, NULL, NULL, 'BRMX221', 'Audi', 'A4', 'Raining', NULL, NULL, 'Mobile', NULL),
(86, 76, '2017-10-07 20:10:26', NULL, NULL, 'My street', 'FR56 HGY', 'Scania', 'Rigid Body', 'Icy', NULL, NULL, 'Mobile', NULL),
(87, 78, '2017-10-08 09:08:41', NULL, NULL, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Dry', 'Luke was driving down the A435 when he pulled off at junction 13. There was a vehicle parked on the slip road with no hazards on and luke clipped the wing mirror as he was pulling off. ', 'Collision with a stationary vehicle', 'Mobile', 0),
(88, 78, '2017-10-08 10:58:29', NULL, NULL, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Dry', NULL, NULL, 'Mobile', NULL),
(89, 66, '2017-10-08 14:01:53', NULL, NULL, NULL, 'SO64 FGH', 'BMW', 'X5', 'Dry', NULL, NULL, 'Mobile', NULL),
(90, 77, '2017-10-01 05:35:00', NULL, NULL, '401 hwy cawthra exit', 'BRMX221', 'Audi', 'A4', 'Raining', NULL, NULL, 'Fleet Manager', NULL),
(91, 66, '2017-10-10 18:17:03', NULL, NULL, NULL, 'SO64 FGH', 'BMW', 'X5', 'Raining', NULL, NULL, 'Mobile', NULL),
(92, 76, '2017-10-10 15:00:59', NULL, NULL, 'My street', 'FR56 HGY', 'Scania', 'Rigid Body', 'Foggy', NULL, NULL, 'Mobile', NULL),
(93, 66, '2017-10-11 16:43:56', NULL, NULL, 'Test', 'SO64 FGH', 'BMW', 'X5', 'Snow', NULL, NULL, 'Mobile', NULL),
(94, 76, '2017-10-13 12:42:52', NULL, NULL, NULL, 'BRMX221', 'Audi', 'A4', 'Snow', NULL, NULL, 'Mobile', NULL),
(95, 13, '2017-10-26 10:38:00', NULL, NULL, 'Edinburgh', 'EH4PML3', 'Honda', 'Van', 'Raining', 'Everyone seemed to lose the control', 'Vehicle tipping', 'Fleet Manager', 500),
(96, 66, '2017-10-15 13:10:25', NULL, NULL, 'Test', 'SO64 FGH', 'BMW', 'X5', 'Snow', NULL, NULL, 'Mobile', NULL),
(97, 66, '2017-10-15 14:49:44', NULL, NULL, 'Fcf', 'FR56 HGY', 'Scania', 'Rigid Body', 'Dry', NULL, NULL, 'Mobile', NULL),
(98, 66, '2017-10-15 14:49:44', NULL, NULL, 'Fcf', 'FR56 HGY', 'Scania', 'Rigid Body', 'Dry', NULL, NULL, 'Mobile', NULL),
(99, 66, '2017-10-15 14:46:51', NULL, NULL, 'Vid. ', 'FR56 HGY', 'Scania', 'Rigid Body', 'Dry', NULL, NULL, 'Mobile', NULL),
(100, 66, '2017-10-15 15:52:34', NULL, NULL, NULL, 'FR56 HGY', 'Scania', 'Rigid Body', 'Snow', NULL, NULL, 'Mobile', NULL),
(101, 66, '2017-10-15 15:53:37', NULL, NULL, NULL, 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(102, 66, '2017-10-15 16:02:31', NULL, NULL, NULL, 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(103, 54, '2017-10-05 13:46:30', NULL, NULL, NULL, 'Registration', 'Make', 'Model', 'Raining', NULL, NULL, 'Mobile', NULL),
(104, 66, '2017-10-15 16:06:05', NULL, NULL, NULL, 'FR56 HGY', 'Scania', 'Rigid Body', 'Dry', NULL, NULL, 'Mobile', NULL),
(105, 66, '2017-10-15 19:08:19', NULL, NULL, NULL, 'FR56 HGY', 'Scania', 'Rigid Body', 'Dry', NULL, NULL, 'Mobile', NULL),
(106, 4, '2017-10-16 00:28:49', NULL, NULL, 'London', 'FR56 HGY', 'citroen', 'Berlingo', 'Raining', NULL, NULL, 'Mobile', NULL),
(107, 4, '2017-10-16 00:28:49', NULL, NULL, 'London', 'FR56 HGY', 'citroen', 'Berlingo', 'Raining', NULL, NULL, 'Mobile', NULL),
(108, 4, '2017-10-16 00:28:49', NULL, NULL, 'London', 'FR56 HGY', 'citroen', 'Berlingo', 'Raining', NULL, NULL, 'Mobile', NULL),
(109, 66, '2017-10-15 21:22:18', NULL, NULL, NULL, 'PX121', 'Ford', 'Kuga', 'Raining', NULL, NULL, 'Mobile', NULL),
(110, 66, '2017-10-15 21:29:10', NULL, NULL, 'Tedt', 'PX121', 'Ford', 'Kuga', 'Raining', NULL, NULL, 'Mobile', NULL),
(111, 66, '2017-10-15 21:29:56', NULL, NULL, 'Tedt', 'SO64 FGH', 'BMW', 'X5', 'Dry', NULL, NULL, 'Mobile', NULL),
(112, 66, '2017-10-15 21:32:03', NULL, NULL, NULL, 'PK121', 'Ford', 'Kuga', 'Dry', NULL, NULL, 'Mobile', NULL),
(113, 83, '2017-10-16 01:20:49', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(114, 83, '2017-10-16 02:25:04', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(115, 83, '2017-10-16 02:25:04', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(116, 83, '2017-10-16 02:53:59', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(117, 83, '2017-10-16 03:02:36', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(118, 66, '2017-10-16 10:48:46', NULL, NULL, NULL, 'FR56 HGY', 'Scania', 'Rigid Body', 'Snow', NULL, NULL, 'Mobile', NULL),
(119, 66, '2017-10-16 10:48:44', NULL, NULL, NULL, 'PK121', 'Ford', 'Kuga', 'Snow', NULL, NULL, 'Mobile', NULL),
(120, 66, '2017-10-16 15:48:49', NULL, NULL, NULL, 'PK121', 'Ford', 'Kuga', 'Raining', NULL, NULL, 'Mobile', NULL),
(121, 66, '2017-10-16 15:55:47', NULL, NULL, NULL, 'ye56 hlx', 'Ford', 'Kuga', 'Snow', NULL, NULL, 'Mobile', NULL),
(122, 66, '2017-10-16 16:15:17', NULL, NULL, NULL, 'PK121', 'Ford', 'Kuga', 'Snow', NULL, NULL, 'Mobile', NULL),
(123, 83, '2017-10-16 23:06:23', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(124, 83, '2017-10-16 23:25:47', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(125, 83, '2017-10-17 12:49:14', NULL, NULL, 'LONDON	', 'FR56 HGY', 'Scania', 'Rigid Body', NULL, NULL, NULL, 'Mobile', NULL),
(126, 83, '2017-10-17 05:23:13', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(127, 83, '2017-10-17 05:25:13', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(128, 83, '2017-10-17 05:28:21', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(129, 83, '2017-10-17 05:37:57', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(130, 83, '2017-10-17 05:37:57', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(131, 83, '2017-10-17 05:37:57', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(132, 83, '2017-10-17 05:37:57', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(133, 83, '2017-10-17 07:43:43', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(134, 83, '2017-10-17 07:43:43', NULL, NULL, 'London', 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(135, 66, '2017-10-17 11:12:13', NULL, NULL, NULL, 'ye56 hlx', 'Ford', 'Kuga', 'Snow', NULL, NULL, 'Mobile', NULL),
(136, 66, '2017-10-17 11:12:13', NULL, NULL, NULL, 'ye56 hlx', 'Ford', 'Kuga', 'Snow', NULL, NULL, 'Mobile', NULL),
(137, 66, '2017-10-17 11:12:31', NULL, NULL, NULL, '676AA', 'HONDA', 'CIVIC', 'Snow', NULL, NULL, 'Mobile', NULL),
(138, 66, '2017-10-17 11:14:03', NULL, NULL, 'Hfg', 'ye56 hlx', 'Ford', 'Kuga', 'Snow', NULL, NULL, 'Mobile', NULL),
(139, 66, '2017-10-17 11:12:13', NULL, NULL, NULL, 'ye56 hlx', 'Ford', 'Kuga', 'Snow', NULL, NULL, 'Mobile', NULL),
(140, 66, '2017-10-17 11:16:05', NULL, NULL, NULL, 'ye56 hlx', 'Ford', 'Kuga', 'Dry', NULL, NULL, 'Mobile', NULL),
(141, 66, '2017-10-17 11:43:53', NULL, NULL, NULL, 'ye56 hlx', 'Ford', 'Kuga', 'Snow', NULL, NULL, 'Mobile', NULL),
(142, 66, '2017-10-17 19:34:49', NULL, NULL, 'London main Big Ben area', '676AA', 'HONDA', 'CIVIC', 'Raining', NULL, NULL, 'Mobile', NULL),
(143, 76, '2017-10-17 13:20:02', NULL, NULL, NULL, 'FR56 HGY', 'Scania', 'Rigid Body', 'Raining', NULL, NULL, 'Mobile', NULL),
(144, 66, '2017-10-17 11:12:31', NULL, NULL, NULL, '676AA', 'HONDA', 'CIVIC', 'Snow', NULL, NULL, 'Mobile', NULL),
(145, 66, '2017-10-17 11:12:31', NULL, NULL, NULL, '676AA', 'HONDA', 'CIVIC', 'Snow', NULL, NULL, 'Mobile', NULL),
(146, 78, '2017-10-19 12:44:47', NULL, NULL, 'Park regis ', 'AUT 01', 'Scania', 'Rigid', 'Dry', 'hfybfj ksnnf ks', 'Collision with a stationary vehicle', 'Mobile', 4500),
(147, 66, '2017-10-19 12:40:07', NULL, NULL, NULL, 'ye56 hlx', 'Ford', 'Kuga', 'Raining', NULL, NULL, 'Mobile', NULL),
(148, 78, '2017-10-20 12:17:30', NULL, NULL, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Dry', NULL, NULL, 'Mobile', NULL),
(149, 78, '2017-10-25 09:52:17', NULL, NULL, NULL, 'KR63 YKG', 'Volvo', 'XC60', 'Dry', NULL, NULL, 'Mobile', NULL),
(150, 66, '2017-10-25 17:41:55', NULL, NULL, NULL, 'PK121', 'Ford', 'Kuga', 'Dry', NULL, NULL, 'Mobile', NULL),
(151, 78, '2017-10-31 10:25:10', NULL, NULL, NULL, 'AUT 01', 'Scania', 'Rigid', 'Dry', NULL, NULL, 'Mobile', NULL),
(152, 66, '2017-10-17 11:12:31', NULL, NULL, NULL, '676AA', 'HONDA', 'CIVIC', 'Snow', NULL, NULL, 'Mobile', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accident_driver`
--

CREATE TABLE IF NOT EXISTS `accident_driver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `insurer` varchar(255) DEFAULT NULL,
  `reg` varchar(255) DEFAULT NULL,
  `accident_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `accident_media`
--

CREATE TABLE IF NOT EXISTS `accident_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accident_id` int(255) NOT NULL,
  `directory_name` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `media_type` enum('Image','Audio') NOT NULL,
  `image_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accident_id` (`accident_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=154 ;

--
-- Dumping data for table `accident_media`
--

INSERT INTO `accident_media` (`id`, `accident_id`, `directory_name`, `filename`, `media_type`, `image_type`) VALUES
(1, 1, '072017', '182801-image', 'Image', 'Other'),
(2, 1, '072017', '124497-image', 'Image', 'Self'),
(3, 1, '072017', '16927-image', 'Image', 'Self'),
(4, 3, '072017', '20170713_140629.jpg', 'Image', 'Self'),
(5, 3, '072017', '20170713_140634.jpg', 'Image', 'Self'),
(6, 4, '072017', '20170713_140629.jpg', 'Image', 'Self'),
(7, 4, '072017', '20170713_140634.jpg', 'Image', 'Self'),
(8, 4, '072017', '20170713_140629.jpg', 'Image', 'Other'),
(9, 14, '072017', '1414948-image', 'Image', 'Self'),
(10, 14, '072017', '148813-image', 'Image', 'Other'),
(11, 14, '072017', '1497226-image', 'Image', 'Other'),
(12, 15, '072017', '1548221-image', 'Image', 'Self'),
(13, 15, '072017', '1543339-image', 'Image', 'Other'),
(14, 16, '072017', '1681262-recording', 'Audio', NULL),
(15, 18, '072017', '1818762-recording', 'Audio', NULL),
(16, 30, '082017', '3053976-image', 'Image', 'Self'),
(17, 30, '082017', '308596-image', 'Image', 'Other'),
(18, 35, '092017', '3551557-image', 'Image', 'Self'),
(19, 35, '092017', '3545409-image', 'Image', 'Self'),
(20, 35, '092017', '3591564-image', 'Image', 'Self'),
(21, 35, '092017', '3560819-image', 'Image', 'Self'),
(22, 35, '092017', '3596414-image', 'Image', 'Self'),
(23, 35, '092017', '3563864-image', 'Image', 'Self'),
(24, 36, '092017', '3684079-image', 'Image', 'Self'),
(25, 36, '092017', '3650651-image', 'Image', 'Other'),
(26, 36, '092017', '3621843-image', 'Image', 'Other'),
(27, 38, '092017', '3861037-image', 'Image', 'Self'),
(28, 38, '092017', '3853666-image', 'Image', 'Other'),
(29, 41, '092017', '4170084-image', 'Image', 'Other'),
(30, 41, '092017', '4173460-image', 'Image', 'Other'),
(31, 41, '092017', '4172469-image', 'Image', 'Other'),
(32, 41, '092017', '4136111-image', 'Image', 'Other'),
(33, 41, '092017', '4195286-image', 'Image', 'Self'),
(34, 41, '092017', '4119733-image', 'Image', 'Self'),
(35, 41, '092017', '4153414-image', 'Image', 'Self'),
(36, 41, '092017', '4119736-image', 'Image', 'Self'),
(37, 41, '092017', '4136377-image', 'Image', 'Self'),
(38, 41, '092017', '4173345-image', 'Image', 'Self'),
(39, 41, '092017', '4116603-recording', 'Audio', NULL),
(40, 43, '092017', '4384052-recording', 'Audio', NULL),
(41, 43, '092017', '4388579-image', 'Image', 'Other'),
(42, 43, '092017', '4352339-image', 'Image', 'Self'),
(43, 44, '092017', '4436756-image', 'Image', 'Other'),
(44, 44, '092017', '4475834-image', 'Image', 'Other'),
(45, 44, '092017', '4426459-image', 'Image', 'Self'),
(46, 44, '092017', '4426873-image', 'Image', 'Self'),
(47, 47, '092017', 'Screenshot_1.png', 'Image', 'Self'),
(48, 47, '092017', 'Screenshot_2.png', 'Image', 'Self'),
(49, 47, '092017', 'Screenshot_2.png', 'Image', 'Other'),
(50, 47, '092017', '1506805324-01 - mylo xyloto.mp3', 'Audio', NULL),
(51, 53, '102017', '5397427-image', 'Image', 'Other'),
(52, 53, '102017', '5337006-image', 'Image', 'Self'),
(53, 59, '102017', '5956602-recording', 'Audio', NULL),
(54, 62, '102017', 'caseone-invoicing-white%402x.png', 'Image', 'Self'),
(55, 63, '102017', 'free-payment-method-gateway-icon-sets-05.png', 'Image', 'Self'),
(56, 63, '102017', 'caseone-invoicing-white%402x.png', 'Image', 'Self'),
(57, 64, '102017', 'Screenshot_1.png', 'Image', 'Self'),
(58, 64, '102017', 'caseone-invoicing-white2x.png', 'Image', 'Self'),
(59, 66, '102017', '6689382-image', 'Image', 'Self'),
(60, 66, '102017', '6690005-image', 'Image', 'Other'),
(61, 66, '102017', '6672412-image', 'Image', 'Other'),
(62, 66, '102017', '6683376-image', 'Image', 'Other'),
(63, 70, '102017', '7016165-image', 'Image', 'Other'),
(64, 70, '102017', '7088419-recording', 'Audio', NULL),
(65, 70, '102017', '7061460-image', 'Image', 'Self'),
(66, 70, '102017', '7053274-image', 'Image', 'Self'),
(67, 71, '102017', '714344-recording', 'Audio', NULL),
(68, 71, '102017', '7191726-image', 'Image', 'Self'),
(69, 71, '102017', '7136727-image', 'Image', 'Self'),
(70, 71, '102017', '7143776-image', 'Image', 'Self'),
(71, 71, '102017', '7167022-image', 'Image', 'Self'),
(72, 71, '102017', '7186445-image', 'Image', 'Self'),
(73, 71, '102017', '713859-image', 'Image', 'Self'),
(74, 71, '102017', '7137520-image', 'Image', 'Self'),
(75, 71, '102017', '7122289-image', 'Image', 'Self'),
(76, 71, '102017', '7170029-image', 'Image', 'Other'),
(77, 71, '102017', '7142532-image', 'Image', 'Other'),
(78, 71, '102017', '7194550-image', 'Image', 'Other'),
(79, 71, '102017', '714191-image', 'Image', 'Other'),
(80, 73, '102017', '7395969-recording', 'Audio', NULL),
(81, 73, '102017', '7367944-image', 'Image', 'Self'),
(82, 73, '102017', '7365953-image', 'Image', 'Other'),
(83, 75, '102017', '7511052-image', 'Image', 'Self'),
(84, 75, '102017', '7577477-recording', 'Audio', NULL),
(85, 76, '102017', 'select-date.png', 'Image', 'Self'),
(86, 77, '102017', '7745356-image', 'Image', 'Self'),
(87, 77, '102017', '7735989-image', 'Image', 'Self'),
(88, 80, '102017', '801572-recording', 'Audio', NULL),
(89, 81, '102017', '8141202-image', 'Image', 'Other'),
(90, 81, '102017', '8110505-image', 'Image', 'Self'),
(91, 81, '102017', '8171066-image', 'Image', 'Self'),
(92, 81, '102017', '8152897-image', 'Image', 'Self'),
(93, 82, '102017', '824943-recording', 'Audio', NULL),
(94, 84, '102017', '8486416-recording', 'Audio', NULL),
(95, 85, '102017', '8564060-recording', 'Audio', NULL),
(96, 85, '102017', '8575126-image', 'Image', 'Other'),
(97, 87, '102017', '8717020-image', 'Image', 'Self'),
(98, 87, '102017', '873847-image', 'Image', 'Self'),
(99, 87, '102017', '8776198-image', 'Image', 'Self'),
(100, 87, '102017', '8793397-image', 'Image', 'Other'),
(101, 87, '102017', '8749526-image', 'Image', 'Other'),
(102, 88, '102017', '8866198-recording', 'Audio', NULL),
(103, 88, '102017', '8895484-image', 'Image', 'Other'),
(104, 88, '102017', '8875932-image', 'Image', 'Other'),
(105, 88, '102017', '8833214-image', 'Image', 'Other'),
(106, 88, '102017', '8877342-image', 'Image', 'Self'),
(107, 88, '102017', '8864841-image', 'Image', 'Self'),
(108, 89, '102017', '8915418-recording', 'Audio', NULL),
(109, 94, '102017', '9495363-image', 'Image', 'Self'),
(110, 94, '102017', '941297-image', 'Image', 'Other'),
(111, 95, '102017', 'Anonymous-guy-fawkes-machete-wallpapers-1920x1080-620x349.jpg', 'Image', 'Self'),
(112, 95, '102017', 'cosmic-galaxy-aoq.jpg', 'Image', 'Self'),
(113, 95, '102017', '8.jpg', 'Image', 'Self'),
(114, 95, '102017', 'red-autumn-trees-wallpaper-1.jpg', 'Image', 'Self'),
(115, 95, '102017', '5822529-top-wallpaper.jpg', 'Image', 'Other'),
(116, 95, '102017', 'red-autumn-trees-wallpaper-1.jpg', 'Image', 'Other'),
(117, 109, '102017', '10977436-recording', 'Audio', NULL),
(118, 113, '102017', '11337327-recording', 'Audio', NULL),
(119, 113, '102017', '11320601-image', 'Image', 'Self'),
(120, 118, '102017', '1186532-recording', 'Audio', NULL),
(121, 122, '102017', '12221660-recording', 'Audio', NULL),
(122, 126, '102017', '1261974-recording', 'Audio', NULL),
(123, 127, '102017', '1271579-recording', 'Audio', NULL),
(124, 128, '102017', '12832515-recording', 'Audio', NULL),
(125, 129, '102017', '12966779-recording', 'Audio', NULL),
(126, 133, '102017', '13399459-recording', 'Audio', NULL),
(127, 134, '102017', '1347718-recording', 'Audio', NULL),
(128, 135, '102017', '13552030-recording', 'Audio', NULL),
(129, 136, '102017', '1368976-recording', 'Audio', NULL),
(130, 139, '102017', '13911906-recording', 'Audio', NULL),
(131, 140, '102017', '14059593-recording', 'Audio', NULL),
(132, 141, '102017', '14128617-recording', 'Audio', NULL),
(133, 143, '102017', '1435118-recording', 'Audio', NULL),
(134, 143, '102017', '14335638-image', 'Image', 'Self'),
(135, 143, '102017', '14374872-image', 'Image', 'Other'),
(136, 146, '102017', '14649709-image', 'Image', 'Self'),
(137, 146, '102017', '14621759-image', 'Image', 'Other'),
(138, 146, '102017', '1465711-image', 'Image', 'Other'),
(139, 147, '102017', '14711668-recording', 'Audio', NULL),
(140, 147, '102017', '14753974-image', 'Image', 'Other'),
(141, 147, '102017', '14755904-image', 'Image', 'Self'),
(142, 147, '102017', '14744421-image', 'Image', 'Self'),
(143, 147, '102017', '14720019-image', 'Image', 'Self'),
(144, 148, '102017', '1485321-recording', 'Audio', NULL),
(145, 148, '102017', '14864083-image', 'Image', 'Self'),
(146, 148, '102017', '14895254-image', 'Image', 'Self'),
(147, 148, '102017', '14840837-image', 'Image', 'Other'),
(148, 148, '102017', '14834317-image', 'Image', 'Other'),
(149, 149, '102017', '14983187-image', 'Image', 'Self'),
(150, 149, '102017', '14940058-image', 'Image', 'Other'),
(151, 151, '102017', '15180537-recording', 'Audio', NULL),
(152, 151, '102017', '15125152-image', 'Image', 'Self'),
(153, 151, '102017', '1513098-image', 'Image', 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `accident_police`
--

CREATE TABLE IF NOT EXISTS `accident_police` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accident_id` int(11) NOT NULL,
  `officer_name` varchar(255) NOT NULL,
  `police_station` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accident_id` (`accident_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `accident_police`
--

INSERT INTO `accident_police` (`id`, `accident_id`, `officer_name`, `police_station`, `phone_number`, `batch_number`) VALUES
(1, 41, 'Martin ', 'N/A', 'N/A', 'N/A'),
(2, 42, 'bgbnj', 'N/A', 'N/A', 'N/A'),
(3, 43, 'Richard ', 'Edinburgh leith ', 'N/A', 'N/A'),
(4, 44, 'join ', 'N/A', 'N/A', 'N/A'),
(5, 69, 'Richard cole ', 'N/A', 'N/A', 'N/A'),
(6, 70, 'Richard cole', 'N/A', 'N/A', 'N/A'),
(7, 71, 'Micheal cole', 'Leith, Edinburgh ', '065468745', '864686'),
(8, 73, 'Jonathan Hamilton ', 'leith Edinburgh ', '0765864577', '85486577'),
(9, 75, 'nhvbn', 'N/A', 'bfvb', 'BBG'),
(10, 78, 'N/A', 'N/A', 'N/A', 'N/A'),
(11, 87, 'Keith bott', 'N/A', '06895794', '45678'),
(12, 92, 'constable Maynard', 'Burlington ', '9056709988', '6896443'),
(13, 95, 'John Mooney', 'N/A', 'N/A', 'N/A'),
(14, 146, 'PC nobody ', 'Edgbaston ', '06891728', '45789'),
(15, 147, 'Andrew', 'N/A', 'N/A', 'N/A'),
(16, 148, 'officer gray ', 'N/A', '0799689', '5445');

-- --------------------------------------------------------

--
-- Table structure for table `accident_vehicles`
--

CREATE TABLE IF NOT EXISTS `accident_vehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accident_id` int(11) NOT NULL,
  `vehicle_reg` varchar(255) NOT NULL,
  `number_of_pessengers` int(11) NOT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `insurer` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=146 ;

--
-- Dumping data for table `accident_vehicles`
--

INSERT INTO `accident_vehicles` (`id`, `accident_id`, `vehicle_reg`, `number_of_pessengers`, `driver_name`, `phone_number`, `insurer`, `address`) VALUES
(1, 1, 'FR54PHY', 2, 'Carl Jenkinsons ', '07896543789', 'N/A', 'N/A'),
(2, 13, 'N/A', -1, NULL, NULL, NULL, NULL),
(3, 14, 'BF556UY', 2, 'David welling', '0789654689', 'axa', 'N/A'),
(4, 15, 'GCHJFF', 2, 'fun', 'ben ', 'N/A', 'N/A'),
(5, 15, 'BVHH', 1, 'BCH', '975798', 'N/A', 'N/A'),
(6, 16, 'N/A', 0, NULL, NULL, NULL, NULL),
(7, 16, 'N/A', 0, NULL, NULL, NULL, NULL),
(8, 16, 'N/A', 0, NULL, NULL, NULL, NULL),
(9, 16, 'N/A', 0, NULL, NULL, NULL, NULL),
(10, 16, 'N/A', 0, NULL, NULL, NULL, NULL),
(11, 16, 'N/A', 0, NULL, NULL, NULL, NULL),
(12, 16, 'N/A', 0, NULL, NULL, NULL, NULL),
(13, 18, 'N/A', 0, NULL, NULL, NULL, NULL),
(14, 19, 'SDFSF', 2, 'DFDSFDSF', 'N/A', 'N/A', 'N/A'),
(15, 19, 'N/A', 0, NULL, NULL, NULL, NULL),
(16, 19, 'N/A', 0, NULL, NULL, NULL, NULL),
(17, 19, 'N/A', 0, NULL, NULL, NULL, NULL),
(18, 19, 'N/A', 0, NULL, NULL, NULL, NULL),
(19, 19, 'N/A', 0, NULL, NULL, NULL, NULL),
(20, 30, 'N/A', 3, NULL, NULL, NULL, NULL),
(21, 30, 'N/A', 0, NULL, NULL, NULL, NULL),
(22, 34, 'N/A', 0, NULL, NULL, NULL, NULL),
(23, 34, 'N/A', 3, NULL, NULL, NULL, NULL),
(24, 35, 'BFBMB', 1, 'can', 'by ', 'N/A', 'N/A'),
(25, 36, 'N/A', 1, NULL, NULL, NULL, NULL),
(26, 36, 'FDJCC', 2, NULL, NULL, NULL, NULL),
(27, 37, 'TYU67UN', 2, 'Lee shaw ', '0789123467', 'admiral ', 'N/A'),
(28, 38, 'N/A', 2, 'claire johnson', '08891829', 'N/A', 'N/A'),
(29, 38, 'N/A', 1, 'hhenkdm', 'N/A', 'N/A', 'N/A'),
(30, 40, 'N/A', 0, NULL, NULL, NULL, NULL),
(31, 41, 'KGG', 2, NULL, NULL, NULL, NULL),
(32, 42, 'BFBHJ', 0, NULL, NULL, NULL, NULL),
(33, 42, 'HFG', 1, 'vfbj', 'hvbnj', 'N/A', ' chjnh'),
(34, 43, 'SO65 GXM', 1, 'James ', '0796547754', 'don''t know ', 'Glasgow '),
(35, 43, 'YE56 YLX', 2, 'don''t know ', 'N/A', 'N/A', 'N/A'),
(36, 44, 'SO65 GXM', 1, 'Alison ', 'N/A', 'N/A', 'N/A'),
(37, 45, 'N/A', 0, NULL, NULL, NULL, NULL),
(38, 50, 'N/A', 0, 'ccgv', 'N/A', 'N/A', 'N/A'),
(39, 51, 'N/A', 0, NULL, NULL, NULL, NULL),
(40, 52, 'N/A', 0, NULL, NULL, NULL, NULL),
(41, 53, 'SO65GXM', 0, 'haroon', '0795432093', 'aviva', 'Edinburgh '),
(42, 53, 'YE56 HKX', 1, NULL, NULL, NULL, NULL),
(43, 56, 'N/A', 0, NULL, NULL, NULL, NULL),
(44, 59, 'FBCV', 0, NULL, NULL, NULL, NULL),
(45, 59, 'GRF', 0, NULL, NULL, NULL, NULL),
(46, 62, '1234', 1, NULL, NULL, NULL, NULL),
(47, 64, 'so65 gxm', 1, 'Mark', NULL, NULL, NULL),
(48, 64, 'ye56 hlx', 2, '12', NULL, 'aviva', 'abderdeen'),
(49, 65, 'N/A', 0, NULL, NULL, NULL, NULL),
(50, 66, 'DHUFVJJ', 3, 'adam Ashworth ', '075806807', 'N/A', 'N/A'),
(51, 66, 'GDTG', 0, 'tom holliday ', '07577996', 'N/A', 'N/A'),
(52, 68, 'YE56 HLX', 2, 'Ali', '08777788', 'aviva ', 'Edinburgh '),
(53, 68, 'SO65GXM ', 0, 'Adam ', 'N/A', 'N/A', 'N/A'),
(54, 69, 'SO65 GXM', 1, 'Adam', '08697686556', 'aviva', 'Dundee '),
(55, 69, 'YE56 HLC', 2, 'mark ', 'N/A', 'N/A', 'N/A'),
(56, 70, 'SO65 GXM', 1, 'Adam', 'N/A', 'N/A', 'N/A'),
(57, 70, 'YE56 HLC ', 2, 'mark ', '07577755', 'aviva', 'Dundee '),
(58, 71, 'YE56 HOX', 3, 'Adam ', '0765774445', 'aviva', 'Portland gardens, Edinburgh, eh6 6nq, United Kingdom '),
(59, 71, 'PX56 HGF', 2, 'Joanna halsall ', '075675467', 'admiral ', 'Edinburgh, united kingdom'),
(60, 71, 'HG67 HFD', 0, 'Anna', '0757864577', 'privilege ', 'Birmingham '),
(61, 72, 'N/A', 0, NULL, NULL, NULL, NULL),
(62, 73, 'SO65 HLX', 2, 'mark carter', '07954212056', 'admiral', '213 princess street, Edinburgh, eh1 6fd, uk '),
(63, 73, 'PX23 HFD', 1, 'Nathan George ', '07657754675', 'privellege ', 'Edinburgh, uk'),
(64, 74, 'HGHHUGVBU', 0, NULL, NULL, NULL, NULL),
(65, 75, 'NGVB', 2, 'Adam ', 'bfvb', 'bfvb', 'N/A'),
(66, 75, 'BFBB', 2, 'can', 'N/A', 'N/A', 'N/A'),
(67, 76, 'so65 gxm', 1, NULL, NULL, NULL, NULL),
(68, 77, 'HFBHH', 0, 'CDC', 'N/A', 'N/A', 'N/A'),
(69, 78, 'N/A', 1, 'N/A', 'N/A', 'N/A', 'N/A'),
(70, 78, 'N/A', 1, 'N/A', 'N/A', 'N/A', 'N/A'),
(71, 78, '1112', 1, 'N/A', 'N/A', 'N/A', 'N/A'),
(72, 79, 'GHJ', 0, 'htfhh', 'N/A', 'N/A', 'N/A'),
(73, 80, 'N/A', 0, NULL, NULL, NULL, NULL),
(74, 81, 'HG67YUI', 1, 'Michael Jones', '07123456789', 'Admiral', 'Birmingham'),
(75, 82, 'N/A', 0, NULL, NULL, NULL, NULL),
(76, 83, 'N/A', 0, NULL, NULL, NULL, NULL),
(77, 84, 'N/A', 0, NULL, NULL, NULL, NULL),
(78, 85, 'TFGHHGF', 1, 'brad', '908776278', 'bell air', '5477 single dr'),
(79, 85, 'N/A', 0, NULL, NULL, NULL, NULL),
(80, 85, 'N/A', 0, NULL, NULL, NULL, NULL),
(81, 86, 'POLTECH', 2, 'Bella', '9047654', 'great west', '9987 ford dr'),
(82, 87, 'GY56SKU', 2, 'tom holliday ', '07801565436', 'AXA', 'N/A'),
(83, 88, 'BV16NMU', 1, 'Kate brown ', '07965437892', 'Aviva', 'N/A'),
(84, 88, 'FY63IKN', 0, 'tom redmore', '01214253789', 'N/A', 'N/A'),
(85, 89, 'N/A', 0, NULL, NULL, NULL, NULL),
(86, 92, 'TTYPHHG', 0, 'Nick', '4167789609', 'State Farm ', '6210 gatwich dr'),
(87, 93, 'N/A', 0, NULL, NULL, NULL, NULL),
(88, 94, 'GGHJFF', 1, 'ggghj', 'N/A', 'N/A', 'N/A'),
(89, 95, 'KMO 552', 2, 'Robert', 'N/A', 'N/A', 'N/A'),
(90, 95, 'SOH 85Y', 1, 'Willy', 'N/A', 'N/A', 'N/A'),
(91, 96, 'N/A', 0, NULL, NULL, NULL, NULL),
(92, 97, 'N/A', 0, NULL, NULL, NULL, NULL),
(93, 98, 'N/A', 0, NULL, NULL, NULL, NULL),
(94, 99, 'N/A', 0, NULL, NULL, NULL, NULL),
(95, 100, 'N/A', 0, NULL, NULL, NULL, NULL),
(96, 102, 'N/A', 0, NULL, NULL, NULL, NULL),
(97, 103, 'N/A', 0, NULL, NULL, NULL, NULL),
(98, 104, 'BFHJ', 1, NULL, NULL, NULL, NULL),
(99, 105, 'BFHJ', 1, NULL, NULL, NULL, NULL),
(100, 106, 'N/A', 0, NULL, NULL, NULL, NULL),
(101, 107, 'N/A', 0, NULL, NULL, NULL, NULL),
(102, 108, 'N/A', 0, NULL, NULL, NULL, NULL),
(103, 109, 'N/A', 0, NULL, NULL, NULL, NULL),
(104, 110, 'N/A', 0, NULL, NULL, NULL, NULL),
(105, 111, 'N/A', 0, NULL, NULL, NULL, NULL),
(106, 112, 'N/A', 0, NULL, NULL, NULL, NULL),
(107, 113, 'N/A', 0, NULL, NULL, NULL, NULL),
(108, 115, 'N/A', 0, NULL, NULL, NULL, NULL),
(109, 116, 'N/A', 0, NULL, NULL, NULL, NULL),
(110, 117, 'N/A', 0, NULL, NULL, NULL, NULL),
(111, 118, 'N/A', 0, NULL, NULL, NULL, NULL),
(112, 119, 'N/A', 0, NULL, NULL, NULL, NULL),
(113, 120, 'N/A', 0, NULL, NULL, NULL, NULL),
(114, 121, 'N/A', 0, NULL, NULL, NULL, NULL),
(115, 122, 'N/A', 0, NULL, NULL, NULL, NULL),
(116, 123, 'ERT454', 0, NULL, NULL, NULL, NULL),
(117, 124, 'N/A', 0, NULL, NULL, NULL, NULL),
(118, 126, 'N/A', 0, NULL, NULL, NULL, NULL),
(119, 127, 'N/A', 0, NULL, NULL, NULL, NULL),
(120, 128, 'N/A', 0, NULL, NULL, NULL, NULL),
(121, 129, 'N/A', 0, NULL, NULL, NULL, NULL),
(122, 130, 'N/A', 0, NULL, NULL, NULL, NULL),
(123, 131, 'N/A', 0, NULL, NULL, NULL, NULL),
(124, 132, 'N/A', 0, NULL, NULL, NULL, NULL),
(125, 133, 'N/A', 0, NULL, NULL, NULL, NULL),
(126, 134, 'N/A', 0, NULL, NULL, NULL, NULL),
(127, 135, 'N/A', 0, NULL, NULL, NULL, NULL),
(128, 136, 'N/A', 0, NULL, NULL, NULL, NULL),
(129, 137, 'N/A', 0, NULL, NULL, NULL, NULL),
(130, 138, 'N/A', 0, NULL, NULL, NULL, NULL),
(131, 139, 'N/A', 0, NULL, NULL, NULL, NULL),
(132, 140, 'N/A', 0, NULL, NULL, NULL, NULL),
(133, 141, 'VCVV', 0, 'HFD', 'N/A', 'N/A', 'N/A'),
(134, 142, 'BAS608', 0, NULL, NULL, NULL, NULL),
(135, 143, 'N/A', 0, NULL, NULL, NULL, NULL),
(136, 144, 'N/A', 0, NULL, NULL, NULL, NULL),
(137, 145, 'BRCVBJGV', 0, 'vgbvccvb', 'CDC', 'CBC ', 'N/A'),
(138, 146, 'KR63YKG', 1, 'luke Withers ', '078015752289', 'AXA', 'N/A'),
(139, 147, 'YEDH', 1, 'haroon', 'N/A', 'N/A', 'N/A'),
(140, 148, 'HJDBEH', 2, 'tom holliday', '071894793', 'aviva', 'N/A'),
(141, 149, 'GCHEIG', 2, 'paul Mullington ', '07579055', 'AXA', 'N/A'),
(142, 150, 'N/A', 0, NULL, NULL, NULL, NULL),
(143, 151, 'GGJFCG', 2, 'Danny James ', '068948849', 'AXA ', 'N/A'),
(144, 151, 'GCB HAS', 0, 'Tom jones ', '075838748', 'N/A', 'N/A'),
(145, 152, 'N/A', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accident_witness`
--

CREATE TABLE IF NOT EXISTS `accident_witness` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accident_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `witness_audio_statement` varchar(255) NOT NULL,
  `directory_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accident_id` (`accident_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Active','Blocked','Inactive') NOT NULL DEFAULT 'Active',
  `date_created` datetime NOT NULL,
  `role` enum('Admin','Fleet','Driver','') NOT NULL DEFAULT 'Admin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `status`, `date_created`, `role`) VALUES
(1, 'admin@gmail.com', '$2y$13$EpMDlHYJRTlx9cT3bTPHbegpqrMbLRUgaOX6obTntFdMmQpqwuQxy', 'Active', '2017-03-01 00:00:00', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `daily_inspection_report`
--

CREATE TABLE IF NOT EXISTS `daily_inspection_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `fleetmanager_id` int(11) NOT NULL,
  `submitted_date` datetime NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'Driver',
  `claim_cost` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `daily_inspection_report`
--

INSERT INTO `daily_inspection_report` (`id`, `driver_id`, `vehicle_id`, `fleetmanager_id`, `submitted_date`, `user_type`, `claim_cost`) VALUES
(1, 53, 2, 1, '2017-08-28 16:19:02', 'Driver', NULL),
(2, 53, 2, 1, '2017-08-28 17:44:58', 'Driver', NULL),
(3, 53, 1, 1, '2017-08-28 17:45:09', 'Driver', NULL),
(4, 53, 2, 1, '2017-08-28 21:26:27', 'Driver', NULL),
(5, 53, 2, 1, '2017-08-28 21:31:15', 'Driver', NULL),
(6, 53, 1, 1, '2017-08-28 21:33:11', 'Driver', NULL),
(7, 53, 2, 1, '2017-08-30 17:29:49', 'Driver', NULL),
(8, 53, 1, 1, '2017-08-30 17:29:55', 'Driver', NULL),
(9, 53, 1, 1, '2017-08-30 17:30:03', 'Driver', NULL),
(10, 53, 1, 1, '2017-08-30 17:46:10', 'Driver', NULL),
(11, 4, 1, 1, '2017-09-01 10:58:51', 'Driver', NULL),
(12, 4, 1, 1, '2017-09-02 10:04:55', 'Driver', NULL),
(13, 4, 1, 1, '2017-09-02 18:07:04', 'Driver', NULL),
(14, 4, 1, 1, '2017-09-02 18:09:30', 'Driver', NULL),
(15, 4, 1, 1, '2017-09-02 18:19:22', 'Driver', NULL),
(16, 4, 1, 1, '2017-09-03 12:45:04', 'Driver', NULL),
(17, 4, 1, 1, '2017-09-07 12:41:47', 'Driver', NULL),
(18, 4, 2, 1, '2017-09-29 17:01:57', 'Driver', NULL),
(19, 4, 2, 1, '2017-09-29 17:40:45', 'Driver', NULL),
(20, 4, 1, 1, '2017-09-30 19:05:06', 'Driver', NULL),
(21, 4, 1, 1, '2017-09-30 19:05:06', 'Driver', NULL),
(22, 54, 4, 1, '2017-09-30 21:20:53', 'Driver', NULL),
(23, 1, 2, 1, '2017-09-12 21:19:00', 'Fleet Manager', NULL),
(24, 1, 2, 1, '2017-09-20 21:31:00', 'Fleet Manager', NULL),
(25, 54, 4, 1, '2017-10-01 10:32:35', 'Driver', '200'),
(26, 1, 4, 1, '2017-10-12 09:50:00', 'Fleet Manager', ''),
(27, 1, 2, 1, '2017-10-18 09:51:00', 'Fleet Manager', '300.23'),
(28, 1, 4, 1, '2017-10-11 09:53:00', 'Fleet Manager', '923.87'),
(29, 54, 4, 1, '2017-10-01 16:26:51', 'Driver', NULL),
(30, 1, 2, 1, '2017-10-03 11:19:00', 'Fleet Manager', ''),
(31, 54, 1, 1, '2017-10-03 12:49:34', 'Driver', NULL),
(32, 54, 2, 1, '2017-10-03 12:59:26', 'Driver', NULL),
(33, 1, 2, 1, '2017-10-04 09:06:00', 'Fleet Manager', NULL),
(34, 63, 4, 1, '2017-10-04 23:18:20', 'Driver', NULL),
(35, 54, 4, 1, '2017-10-05 12:13:16', 'Driver', NULL),
(36, 54, 4, 1, '2017-10-05 13:42:53', 'Driver', NULL),
(37, 66, 29, 3, '2017-10-06 14:49:13', 'Driver', '100'),
(38, 66, 29, 3, '2017-10-06 14:53:02', 'Driver', NULL),
(39, 66, 30, 3, '2017-10-06 15:26:30', 'Driver', NULL),
(40, 3, 30, 3, '2017-10-06 16:35:00', 'Fleet Manager', NULL),
(41, 76, 38, 5, '2017-10-07 20:03:29', 'Driver', NULL),
(42, 76, 38, 5, '2017-10-07 20:03:51', 'Driver', NULL),
(43, 78, 41, 7, '2017-10-08 09:10:55', 'Driver', NULL),
(44, 78, 41, 7, '2017-10-08 11:00:46', 'Driver', NULL),
(45, 76, 37, 5, '2017-10-10 14:19:25', 'Driver', NULL),
(46, 76, 38, 5, '2017-10-10 14:20:49', 'Driver', NULL),
(47, 5, 37, 5, '2017-10-10 21:16:00', 'Fleet Manager', NULL),
(48, 76, 37, 5, '2017-10-10 16:23:42', 'Driver', NULL),
(49, 3, 29, 3, '2017-10-11 10:30:00', 'Fleet Manager', NULL),
(50, 66, 29, 3, '2017-10-11 23:26:23', 'Driver', NULL),
(51, 76, 38, 5, '2017-10-13 12:32:26', 'Driver', NULL),
(52, 4, 3, 1, '2017-10-15 16:21:44', 'Driver', NULL),
(53, 4, 4, 1, '2017-10-15 17:02:08', 'Driver', NULL),
(54, 66, 29, 3, '2017-10-15 14:51:35', 'Driver', NULL),
(55, 66, 31, 3, '2017-10-15 15:04:14', 'Driver', NULL),
(56, 66, 29, 3, '2017-10-15 19:02:47', 'Driver', NULL),
(57, 66, 29, 3, '2017-10-15 19:05:38', 'Driver', NULL),
(58, 66, 31, 3, '2017-10-15 21:42:52', 'Driver', NULL),
(59, 66, 31, 3, '2017-10-15 21:44:00', 'Driver', NULL),
(60, 66, 29, 3, '2017-10-16 10:49:41', 'Driver', NULL),
(61, 66, 31, 3, '2017-10-16 15:49:10', 'Driver', NULL),
(62, 83, 29, 3, '2017-10-17 05:48:37', 'Driver', NULL),
(63, 66, 29, 3, '2017-10-17 11:15:35', 'Driver', NULL),
(64, 76, 38, 5, '2017-10-17 13:37:07', 'Driver', NULL),
(65, 66, 31, 3, '2017-10-18 19:15:40', 'Driver', NULL),
(66, 66, 29, 3, '2017-10-19 13:10:12', 'Driver', NULL),
(67, 66, 31, 3, '2017-10-19 13:12:06', 'Driver', NULL),
(68, 78, 45, 7, '2017-10-19 13:11:29', 'Driver', NULL),
(69, 3, 31, 3, '2017-10-19 15:04:00', 'Fleet Manager', NULL),
(70, 78, 42, 7, '2017-10-20 12:20:58', 'Driver', NULL),
(71, 66, 29, 3, '2017-10-23 18:38:56', 'Driver', NULL),
(72, 3, 30, 3, '2017-10-23 18:46:00', 'Fleet Manager', NULL),
(73, 78, 45, 7, '2017-10-25 09:54:32', 'Driver', NULL),
(74, 78, 45, 7, '2017-10-31 10:37:34', 'Driver', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `daily_inspection_report_items`
--

CREATE TABLE IF NOT EXISTS `daily_inspection_report_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `inspected` tinyint(1) NOT NULL,
  `notes` text,
  `report_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=345 ;

--
-- Dumping data for table `daily_inspection_report_items`
--

INSERT INTO `daily_inspection_report_items` (`id`, `name`, `inspected`, `notes`, `report_id`) VALUES
(1, 'Tyre Tread', 1, 'Notes', 1),
(2, 'Seat Belts', 0, '', 1),
(3, 'Windscreen', 0, '', 1),
(4, 'Brake Lights', 0, '', 1),
(5, 'Number plate visibility', 1, '', 1),
(6, 'Fuel/oil leaks', 0, '', 1),
(7, 'Steering', 0, '', 1),
(8, 'Wipers and washer', 0, '', 1),
(9, 'Indicators', 0, '', 1),
(10, 'Handbrake', 0, '', 1),
(11, 'mirrors', 0, '', 1),
(12, 'Horn', 0, '', 1),
(13, 'Antifreeze level', 0, '', 1),
(14, 'Wheel Nuts', 0, '', 1),
(15, 'Brakes', 0, '', 1),
(16, 'Suspension', 0, '', 1),
(17, 'Fire extinguishers', 0, '', 1),
(18, 'Umbrella Holder', 0, '', 1),
(19, 'Tyres', 1, '', 2),
(20, 'Mirrors', 1, '', 2),
(21, 'Engine', 1, '', 2),
(22, 'Brake Lights', 1, '', 3),
(23, 'Number Plate Visibility and Show in Two Lines', 1, '', 3),
(24, 'WindScreen', 1, '', 3),
(25, 'Seat belts', 1, '', 3),
(26, 'Tyres', 1, 'Ty', 4),
(27, 'Mirrors', 0, '', 4),
(28, 'Engine', 0, '', 4),
(29, 'Tyres', 1, 'Types note ', 5),
(30, 'Mirrors', 1, '', 5),
(31, 'Engine', 0, '', 5),
(32, 'Brake Lights', 1, '', 6),
(33, 'Number Plate Visibility and Show in Two Lines', 1, 'Yukon', 6),
(34, 'WindScreen', 1, '', 6),
(35, 'Seat belts', 1, '', 6),
(36, 'Tyres', 0, '', 7),
(37, 'Mirrors', 1, '', 7),
(38, 'Engine', 1, '', 7),
(39, 'Brake Lights', 1, '', 8),
(40, 'Number Plate Visibility and Show in Two Lines', 1, '', 8),
(41, 'WindScreen', 0, '', 8),
(42, 'Seat belts', 1, '', 8),
(43, 'Brake Lights', 0, '', 9),
(44, 'Number Plate Visibility and Show in Two Lines', 0, '', 9),
(45, 'WindScreen', 0, '', 9),
(46, 'Seat belts', 1, '', 9),
(47, 'Brake Lights', 1, '', 10),
(48, 'Number Plate Visibility and Show in Two Lines', 1, '', 10),
(49, 'WindScreen', 0, '', 10),
(50, 'Seat belts', 1, '', 10),
(51, 'Brake Lights', 1, '', 11),
(52, 'Number Plate Visibility and Show in Two Lines', 1, '', 11),
(53, 'WindScreen', 1, '', 11),
(54, 'Seat belts', 1, '', 11),
(55, 'Brake Lights', 1, '', 12),
(56, 'Number Plate Visibility and Show in Two Lines', 0, '', 12),
(57, 'WindScreen', 1, '', 12),
(58, 'Seat belts', 0, '', 12),
(59, 'Brake Lights', 0, '', 13),
(60, 'Number Plate Visibility and Show in Two Lines', 1, '', 13),
(61, 'WindScreen', 0, '', 13),
(62, 'Seat belts', 0, '', 13),
(63, 'Brake Lights', 1, '', 14),
(64, 'Number Plate Visibility and Show in Two Lines', 1, '', 14),
(65, 'WindScreen', 1, '', 14),
(66, 'Seat belts', 0, '', 14),
(67, 'Brake Lights', 1, 'Jenny', 15),
(68, 'Number Plate Visibility and Show in Two Lines', 1, 'High', 15),
(69, 'WindScreen', 1, '', 15),
(70, 'Seat belts', 0, '', 15),
(71, 'Brake Lights', 1, '', 16),
(72, 'Number Plate Visibility and Show in Two Lines', 1, '', 16),
(73, 'WindScreen', 1, '', 16),
(74, 'Seat belts', 0, '', 16),
(75, 'Steering test - check if it''s working properly - test the multi lines support. ', 0, '', 16),
(76, 'Brake Lights', 1, '', 17),
(77, 'Number Plate Visibility and Show in Two Lines', 1, '', 17),
(78, 'WindScreen', 1, '', 17),
(79, 'Seat belts', 1, '', 17),
(80, 'Steering test - check if it''s working properly - test the multi lines support. ', 1, '', 17),
(81, 'Tyres', 1, 'Hhh Huxley', 18),
(82, 'Mirrors', 1, '', 18),
(83, 'Engine', 1, '', 18),
(84, 'Tyres', 1, 'Hhujg', 19),
(85, 'Mirrors', 1, 'Ghhh', 19),
(86, 'Engine', 1, 'Hghj', 19),
(87, 'Brake Lights', 0, '', 20),
(88, 'Number Plate Visibility and Show in Two Lines', 1, '', 20),
(89, 'WindScreen', 1, '', 20),
(90, 'Seat belts', 1, '', 20),
(91, 'Steering test - check if it''s working properly - test the multi lines support. ', 1, '', 20),
(92, 'Brake Lights', 0, '', 21),
(93, 'Number Plate Visibility and Show in Two Lines', 0, '', 21),
(94, 'WindScreen', 1, '', 21),
(95, 'Seat belts', 1, '', 21),
(96, 'Steering test - check if it''s working properly - test the multi lines support. ', 1, '', 21),
(97, 'Headlights', 1, '', 22),
(98, 'Braklelights', 1, 'Test', 22),
(99, 'Treads', 0, '', 22),
(100, 'Streering', 0, '', 22),
(101, 'Seats', 0, '', 22),
(102, 'Oil Level', 0, '', 22),
(103, 'Mirrors', 0, '', 22),
(104, 'Tyres', 1, '', 23),
(105, 'Mirrors', 1, '', 23),
(106, 'Engine', 1, '', 23),
(107, 'Tyres', 1, 'test', 24),
(108, 'Mirrors', 1, '', 24),
(109, 'Engine', 1, '', 24),
(110, 'Braklelights', 1, 'Hello text ', 25),
(111, 'Streering', 1, '', 25),
(112, 'Mirrors1', 0, '', 25),
(113, 'Headlights', 1, '', 26),
(114, 'Braklelights', 0, '', 26),
(115, 'Treads', 0, '', 26),
(116, 'Streering', 0, '', 26),
(117, 'Seats', 0, '', 26),
(118, 'Oil Level', 0, '', 26),
(119, 'Mirrors1', 0, '', 26),
(120, 'Engine', 0, '', 26),
(121, 'Tyres', 0, '', 27),
(122, 'Mirrors', 0, '', 27),
(123, 'Engine', 0, '', 27),
(124, 'Headlights', 0, '', 28),
(125, 'Braklelights', 1, 'test', 28),
(126, 'Treads', 1, '', 28),
(127, 'Streering', 1, '', 28),
(128, 'Seats', 1, '', 28),
(129, 'Oil Level', 0, '', 28),
(130, 'Mirrors1', 0, '', 28),
(131, 'Engine', 0, '', 28),
(132, 'Braklelights', 0, '', 29),
(133, 'Treads', 0, '', 29),
(134, 'Streering', 0, '', 29),
(135, 'Seats', 0, '', 29),
(136, 'Oil Level', 0, '', 29),
(137, 'Mirrors1', 0, '', 29),
(138, 'Tyres', 1, 'near limit', 30),
(139, 'Mirrors', 0, '', 30),
(140, 'Engine', 1, 'engine making strange noise', 30),
(141, 'Braklelights', 1, '', 31),
(142, 'Treads', 1, 'Test ', 31),
(143, 'Streering', 0, '', 31),
(144, 'Seats', 0, '', 31),
(145, 'Oil Level', 0, '', 31),
(146, 'Mirrors1', 0, '', 31),
(147, 'Tyres', 1, 'Cv', 32),
(148, 'Mirrors', 1, 'Vgf', 32),
(149, 'Engine', 1, 'Bugs', 32),
(150, 'Tyres', 0, '', 33),
(151, 'Mirrors', 0, '', 33),
(152, 'Engine', 0, '', 33),
(153, 'Braklelights', 0, '', 34),
(154, 'Treads', 0, '', 34),
(155, 'Streering', 0, '', 34),
(156, 'Seats', 0, '', 34),
(157, 'Oil Level', 0, '', 34),
(158, 'Mirrors1', 0, '', 34),
(159, 'Braklelights', 1, 'Bhgh', 35),
(160, 'Treads', 0, '', 35),
(161, 'Streering', 0, '', 35),
(162, 'Seats', 1, '', 35),
(163, 'Oil Level', 0, '', 35),
(164, 'Mirrors1', 0, '', 35),
(165, 'Braklelights', 0, '', 36),
(166, 'Treads', 1, '', 36),
(167, 'Streering', 0, '', 36),
(168, 'Seats', 1, '', 36),
(169, 'Oil Level', 1, 'Bfbh', 36),
(170, 'Mirrors1', 1, 'Big vh', 36),
(171, 'Headlights', 1, '', 37),
(172, 'tyres', 0, '', 37),
(173, 'door', 1, 'Htfhh', 37),
(174, 'Headlights', 0, '', 38),
(175, 'tyres', 0, '', 38),
(176, 'door', 0, '', 38),
(177, 'Headlights', 1, '', 39),
(178, 'tyres', 0, '', 39),
(179, 'door', 0, '', 39),
(180, 'Headlights', 1, 'test', 40),
(181, 'tyres', 0, '', 40),
(182, 'door', 0, '', 40),
(183, 'Headlights', 1, '', 41),
(184, 'Break lights', 1, '', 41),
(185, 'Hazzards', 1, '', 41),
(186, 'Wipers', 0, '', 41),
(187, 'Headlights', 0, '', 42),
(188, 'Break lights', 0, '', 42),
(189, 'Hazzards', 0, '', 42),
(190, 'Wipers', 0, '', 42),
(191, 'Tyre tread', 0, '', 43),
(192, 'Windscreen Condition', 1, 'Crack on passenger side\n', 43),
(193, 'Oil Level', 0, '', 43),
(194, 'Brake Lights', 1, 'Rear left not working', 43),
(195, 'Headlights', 0, '', 43),
(196, 'Horn', 0, '', 43),
(197, 'Washer Fluid Level', 0, '', 43),
(198, 'Seatbelts', 0, '', 43),
(199, 'Handbrake', 0, '', 43),
(200, 'Reg Visibility', 0, '', 43),
(201, 'Tyre tread', 1, 'Front right getting bald', 44),
(202, 'Windscreen Condition', 0, '', 44),
(203, 'Oil Level', 0, '', 44),
(204, 'Brake Lights', 0, '', 44),
(205, 'Headlights', 0, '', 44),
(206, 'Horn', 0, '', 44),
(207, 'Washer Fluid Level', 1, '', 44),
(208, 'Seatbelts', 1, 'Slight tear \n', 44),
(209, 'Handbrake', 0, '', 44),
(210, 'Reg Visibility', 0, '', 44),
(211, 'Headlights', 1, 'Test3', 45),
(212, 'Break lights', 0, 'Test2', 45),
(213, 'Hazzards', 1, 'Test 1', 45),
(214, 'Wipers', 0, '', 45),
(215, 'Headlights', 1, '', 46),
(216, 'Break lights', 1, '', 46),
(217, 'Hazzards', 1, '', 46),
(218, 'Wipers', 1, 'Test4\n\n', 46),
(219, 'Windshield', 1, '', 47),
(220, 'Tires', 0, 'Test 5', 47),
(221, 'Seatbelts', 0, '', 47),
(222, 'Headlights', 1, 'Test 6', 47),
(223, 'Break lights', 0, '', 47),
(224, 'Hazzards', 0, '', 47),
(225, 'Wipers', 0, '', 47),
(226, 'Headlights', 1, '', 48),
(227, 'Break lights', 1, '', 48),
(228, 'Hazzards', 0, '', 48),
(229, 'Wipers', 1, '', 48),
(230, 'Headlights', 1, 'test', 49),
(231, 'tyres', 0, '', 49),
(232, 'door', 0, '', 49),
(233, 'Headlights', 0, '', 50),
(234, 'tyres', 0, '', 50),
(235, 'door', 0, '', 50),
(236, 'Headlights', 1, 'Don''t work\n\n', 51),
(237, 'Break lights', 0, '', 51),
(238, 'Hazzards', 0, '', 51),
(239, 'Wipers', 0, '', 51),
(240, 'Tyres', 1, '', 52),
(241, 'Mirrors', 1, '', 52),
(242, 'Engine', 1, '', 52),
(243, 'Braklelights', 1, '', 53),
(244, 'Treads', 1, '', 53),
(245, 'Streering', 0, '', 53),
(246, 'Seats', 0, '', 53),
(247, 'Oil Level', 0, '', 53),
(248, 'Mirrors1', 0, '', 53),
(249, 'Headlights', 0, '', 54),
(250, 'tyres', 0, '', 54),
(251, 'door', 0, '', 54),
(252, 'Headlights', 1, 'CBC ', 55),
(253, 'tyres', 0, '', 55),
(254, 'door', 0, '', 55),
(255, 'Headlights', 1, '', 56),
(256, 'tyres', 1, '', 56),
(257, 'door', 1, '', 56),
(258, 'boot', 1, '', 56),
(259, 'Headlights', 0, '', 57),
(260, 'tyres', 1, 'Cchj', 57),
(261, 'door', 0, '', 57),
(262, 'boot', 0, '', 57),
(263, 'Headlights', 1, '', 58),
(264, 'tyres', 1, '', 58),
(265, 'door', 0, '', 58),
(266, 'boot', 0, '', 58),
(267, 'Headlights', 0, '', 59),
(268, 'tyres', 0, '', 59),
(269, 'door', 0, '', 59),
(270, 'boot', 0, '', 59),
(271, 'Headlights', 1, '', 60),
(272, 'tyres', 0, '', 60),
(273, 'door', 0, '', 60),
(274, 'boot', 0, '', 60),
(275, 'Headlights', 1, '', 61),
(276, 'tyres', 1, '', 61),
(277, 'door', 0, '', 61),
(278, 'boot', 0, '', 61),
(279, 'Headlights', 1, '', 62),
(280, 'tyres', 0, '', 62),
(281, 'door', 0, '', 62),
(282, 'boot', 0, '', 62),
(283, 'Headlights', 0, '', 63),
(284, 'tyres', 1, '', 63),
(285, 'door', 0, '', 63),
(286, 'boot', 0, '', 63),
(287, 'Headlights', 0, '', 64),
(288, 'Break lights', 0, '', 64),
(289, 'Hazzards', 0, '', 64),
(290, 'Wipers', 0, '', 64),
(291, 'Headlights', 1, '', 65),
(292, 'tyres', 1, '', 65),
(293, 'door', 1, '', 65),
(294, 'boot', 1, '', 65),
(295, 'Headlights', 1, 'HFGH \n', 66),
(296, 'tyres', 1, '', 66),
(297, 'door', 1, '', 66),
(298, 'boot', 0, '', 66),
(299, 'Headlights', 1, 'Hhh', 67),
(300, 'tyres', 0, '', 67),
(301, 'door', 0, '', 67),
(302, 'boot', 0, '', 67),
(303, 'Horn', 0, '', 68),
(304, 'Reversing beepers', 1, '', 68),
(305, 'Mirrors', 1, '', 68),
(306, 'Seat Pressure cut off', 0, '', 68),
(307, 'Seatbelt', 0, '', 68),
(308, 'Lights', 0, '', 68),
(309, 'Load Alarm', 0, '', 68),
(310, 'Headlights', 0, 'test', 69),
(311, 'tyres', 0, '', 69),
(312, 'door', 0, '', 69),
(313, 'boot', 0, '', 69),
(314, 'Tyre tread', 0, '', 70),
(315, 'Windscreen Condition', 0, '', 70),
(316, 'Oil Level', 0, '', 70),
(317, 'Brake Lights', 0, '', 70),
(318, 'Headlights', 0, '', 70),
(319, 'Horn', 0, '', 70),
(320, 'Washer Fluid Level', 0, '', 70),
(321, 'Seatbelts', 0, '', 70),
(322, 'Handbrake', 0, '', 70),
(323, 'Reg Visibility', 0, '', 70),
(324, 'Headlights', 1, '', 71),
(325, 'tyres', 1, 'Cgjggg', 71),
(326, 'door', 1, '', 71),
(327, 'boot', 1, '', 71),
(328, 'tyres', 1, '', 72),
(329, 'door', 0, '', 72),
(330, 'boot', 0, '', 72),
(331, 'Horn', 1, 'Horn defect \n', 73),
(332, 'Reversing beepers', 0, '', 73),
(333, 'Mirrors', 0, '', 73),
(334, 'Seat Pressure cut off', 0, '', 73),
(335, 'Seatbelt', 0, '', 73),
(336, 'Lights', 1, '', 73),
(337, 'Load Alarm', 0, '', 73),
(338, 'Horn', 1, 'Fault ', 74),
(339, 'Reversing beepers', 0, '', 74),
(340, 'Mirrors', 0, '', 74),
(341, 'Seat Pressure cut off', 0, '', 74),
(342, 'Seatbelt', 1, 'Torn ', 74),
(343, 'Lights', 0, '', 74),
(344, 'Load Alarm', 0, '', 74);

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE IF NOT EXISTS `driver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autium_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `policy_number` varchar(255) DEFAULT NULL,
  `insurer` varchar(255) DEFAULT NULL,
  `vehicle_reg` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `driving_license` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `status` enum('New','Active','Inactive','Pending') NOT NULL,
  `fleetmanager_id` int(11) NOT NULL,
  `role` enum('Driver','Fleet','Admin') NOT NULL DEFAULT 'Driver',
  `access_token` varchar(255) DEFAULT NULL,
  `token_expiry` varchar(255) NOT NULL,
  `license_type` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `points` varchar(255) DEFAULT NULL,
  `driving_convictions` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fleetmanager_id` (`fleetmanager_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=87 ;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`id`, `autium_id`, `password`, `full_name`, `policy_number`, `insurer`, `vehicle_reg`, `address`, `driving_license`, `dob`, `status`, `fleetmanager_id`, `role`, `access_token`, `token_expiry`, `license_type`, `nationality`, `points`, `driving_convictions`) VALUES
(1, '', '$2y$13$i.WIJXXuE30K1DWwJf85KuxdMznd95TSxt/1qkzuMWhgfuFXXd8Uq', 'Andrew Wilson', NULL, NULL, NULL, '1 Canada Way, Canada, CA 456', 'WILS078678', '2017-07-12', 'Active', 1, 'Driver', NULL, '2017-07-12 18:59:46', 'Full UK', 'Canadian', '3', 'No'),
(2, 'AUT-00002', '$2y$13$AkfXhKfm/FmooFDe01T0.ePewzfQMd2QS5vDxZWXsC4xhBsifeRW.', 'Tom Holliday', NULL, NULL, NULL, '15 harborne road, harborne, Birmingham, B7 HSeE', 'HOL3456878Y', '1991-03-23', 'Active', 1, 'Driver', 'EpKe_xZFxVZrPKn29YTrKpaGwEMNmUpUOtd5j9WiyN_WqcK1LPZVay~jYHlMqIOmXIbaECpX4sY2', '2024-07-12 23:42:12', 'Full UK', 'British', '0', 'No'),
(3, 'AUT-00003', '$2y$13$vQKEEwaXazmAiTHZvq3cl.WyDqJE9l2ino//lJ09lvFIlUKw6MLyu', 'Andrew Wilson', NULL, NULL, NULL, 'Canada Drive, Canada, CA 456', 'WILS078678', '1987-01-10', 'Active', 1, 'Driver', NULL, '2017-07-12 19:04:28', 'Full UK', 'Canadian', '0', 'No'),
(4, 'AUT-00004', '$2y$13$pq.V.PSG.lZ86.utgipwiuQt4xuE/ijKmuHsUkpFduNYtL7jugjD2', 'Luke Withers', NULL, NULL, NULL, '37 Western Road, Stourbridge, DY8 3XU', '1234', '2017-09-11', 'Active', 1, 'Driver', '1A4HJSBCAsF8_nmgpjjdZPXt_nBRJ~uBQQ1H8A6Hk_nyCyfL4E4SSYYV0Wj~ba~1jmNnET2xC3Z4', '2024-07-12 19:05:56', 'Full UK', 'British', '3', 'No'),
(5, 'AUT-00005', '$2y$13$TnssL2uLhON4BLEMxOKsk.xcigJQaQNO8GKi9WquGOjmke6Xsqfyq', 'Luke Withers', NULL, NULL, NULL, '37 Western Road, Stourbridge, DY8 3XU', 'WITHE456778966', '1988-09-11', 'Active', 2, 'Driver', 'RI2wHs~Pgig~hdGPCAC8adqgBd3a6y1c96D439rrBexRhLT3A0bpHrNnMp2dgrvMjx127Dty52y5', '2024-07-12 20:21:29', 'Full UK', 'British', '0', 'No'),
(6, 'AUT-00006', '$2y$13$5I9pNYBPHTnGfGSzpI0VaOuR04DCMCoK4mQl6D.lpGpcpRlI34Pcu', 'Haroon Rasheed ', NULL, NULL, NULL, 'Portland Gardens, Edinburgh, EH6 6NQ', 'HAR85443443YKS', '1986-10-12', 'Active', 1, 'Driver', 'oNfpkXJPicX0ARRxi6vD7ifgu3EFP~eJEz~gvGGJaEEhmSQQEDc5JF4myaFwKKO94Q46ldGDzcy6', '2024-07-13 12:07:49', 'Full UK', 'British', '0', 'No'),
(7, 'AUT-00007', '$2y$13$NaMJW5xS/SBqa7rBu4e8DuCrZRf.wJVW.o1dPGiw1E2Jkzc/zW9qS', 'Name', NULL, NULL, NULL, 'Confirm', 'Address', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:30', 'Nationality', 'Licence Type', 'DOB', NULL),
(8, 'AUT-00008', '$2y$13$wGbJRInWoo69pIRw/VD4nOomroyyuFY/MT88Qf2ceBYTG1CxIgs4O', 'Herald Jacobson', NULL, NULL, NULL, 'Autium1', '25 Nile Drive, Burlington On', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:31', 'Color?', 'G2', '12-24-2010', NULL),
(9, 'AUT-00009', '$2y$13$SzjT06.2SLYPVdvZqp6fuOKP7n8lI2LeZr5vkYnQlnPWI3acR4cPC', 'Brad Watts', NULL, NULL, NULL, 'Autium2', '32 Den Turnoff, Casaloma', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:32', 'Italian', 'G2', '01/02/1999', NULL),
(10, 'AUT-000010', '', 'Joey Scrivo', NULL, NULL, NULL, 'Autium3', '55 Bridgeford, Park Dale, Cal 32244', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:32', 'Greek', 'G1', '30/30/3000', NULL),
(11, 'AUT-000011', '$2y$13$e1czlAcMA50jaU4jZpXFW.kO2LolNqp6YfFIElcQK7Vwegye.y67q', 'Scott Delaney', NULL, NULL, NULL, 'Autium4', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:33', 'Scottish', 'D56', '01/01/1885', NULL),
(12, 'AUT-000012', '$2y$13$wbu/5kIaCAqQC7Ne3HHrU.HcaIq.6C1xF1rgn.lnsiRM4okKotshG', 'Marco Estrada', NULL, NULL, NULL, 'Autium5', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:33', 'English', 'None', '05-30-99', NULL),
(13, 'AUT-000013', '$2y$13$eogzuPElvAC33quvEM/1p.hdJkjEQB/evkXHQtzgMwWdsK3YAz00u', 'Ben Nichols', NULL, NULL, NULL, 'Autium6', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:34', 'Indian', 'Blank', '1999-30-05', NULL),
(14, 'AUT-000014', '$2y$13$2w3GhWG.OKfFWE7E7Udxau74EMdbRLGb2xb1iGbRDiTM/c.Pbkc2.', 'Nikki Fourfingers', NULL, NULL, NULL, 'Autium7', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:35', 'Black', NULL, '05-30-99', NULL),
(15, 'AUT-000015', '$2y$13$85PNIuXJpWJTeJPRyvm3ienNTLug29AZ2YNAmOaJymLvKWlD4WyrW', 'Andrew Wilson Jr', NULL, NULL, NULL, 'Autium8', 'This could be blank', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:36', 'White', NULL, '1999', NULL),
(16, 'AUT-000016', '', 'Greg Thefist', NULL, NULL, NULL, 'Autium9', 'Hopefully it could be anything', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:36', 'Caucasion', NULL, '07-08-01', NULL),
(17, 'AUT-000017', '', 'Henry Hanks', NULL, NULL, NULL, 'Autium10', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:36', 'Whats the point?', NULL, '651', NULL),
(18, 'AUT-000018', '', 'Nick Noble', NULL, NULL, NULL, 'Autium11', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:36', NULL, 'Test', NULL, NULL),
(19, 'AUT-000019', '', 'Gerrard Thomas', NULL, NULL, NULL, 'Autium12', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:36', NULL, NULL, NULL, NULL),
(20, 'AUT-000020', '', 'Kathy Thegreek', NULL, NULL, NULL, 'Autium13', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:36', NULL, 'test', NULL, NULL),
(21, 'AUT-000021', '$2y$13$t/om7Vsu9jKTT9OSwaRiJefPmbXOxyUdmuZs8ctuGwaMJFz3kpEJq', 'Name', NULL, NULL, NULL, 'Confirm', 'Address', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:37', 'Nationality', 'Licence Type', 'DOB', NULL),
(22, 'AUT-000022', '$2y$13$vfwsWb9FqGDyWs/G/44bTOzhwlsGVWtXHg79IMFzPS5ODoNXCrm6W', 'Herald Jacobson', NULL, NULL, NULL, 'Autium1', '25 Nile Drive, Burlington On', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:37', 'Color?', 'G2', '12-24-2010', NULL),
(23, 'AUT-000023', '$2y$13$8ICK/ZnaemtwKmqeSM.0/uOWFd95Zl4AW7dfBBaPanyo/9lgZ6CGq', 'Brad Watts', NULL, NULL, NULL, 'Autium2', '32 Den Turnoff, Casaloma', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:38', 'Italian', 'G2', '01/02/1999', NULL),
(24, 'AUT-000024', '', 'Joey Scrivo', NULL, NULL, NULL, 'Autium3', '55 Bridgeford, Park Dale, Cal 32244', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:38', 'Greek', 'G1', '30/30/3000', NULL),
(25, 'AUT-000025', '$2y$13$DCJXn0AWPa4coc8diMOMUe1hUmGwDA4EK0In7mEBySImHn.JL/oaO', 'Scott Delaney', NULL, NULL, NULL, 'Autium4', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:39', 'Scottish', 'D56', '01/01/1885', NULL),
(26, 'AUT-000026', '$2y$13$CnMEolc2fLwnLttwnjExqevXs1bT21SPK1f9JfFNv84HuNiVOBWEi', 'Marco Estrada', NULL, NULL, NULL, 'Autium5', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:40', 'English', 'None', '05-30-99', NULL),
(27, 'AUT-000027', '$2y$13$hRxSpdrGVIMBEew226W7yOzHRTzwCTyAMJf8rJX57Vl0lxFrsrOgm', 'Ben Nichols', NULL, NULL, NULL, 'Autium6', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:41', 'Indian', 'Blank', '1999-30-05', NULL),
(28, 'AUT-000028', '$2y$13$uIQoH2iFc0lyPOaWWgljGeKZ1Sna6uWNYzkcMyIrTCUtKWL.dJ0jC', 'Nikki Fourfingers', NULL, NULL, NULL, 'Autium7', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:41', 'Black', NULL, '05-30-99', NULL),
(29, 'AUT-000029', '$2y$13$sI.6E7p2q/jDITjrqTzJzek93R95RPFzjnXOgpnf2JBcFX3ho2Prq', 'Andrew Wilson Jr', NULL, NULL, NULL, 'Autium8', 'This could be blank', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:42', 'White', NULL, '1999', NULL),
(30, 'AUT-000030', '', 'Greg Thefist', NULL, NULL, NULL, 'Autium9', 'Hopefully it could be anything', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:42', 'Caucasion', NULL, '07-08-01', NULL),
(31, 'AUT-000031', '', 'Henry Hanks', NULL, NULL, NULL, 'Autium10', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:42', 'Whats the point?', NULL, '651', NULL),
(32, 'AUT-000032', '', 'Nick Noble', NULL, NULL, NULL, 'Autium11', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:42', NULL, 'Test', NULL, NULL),
(33, 'AUT-000033', '', 'Gerrard Thomas', NULL, NULL, NULL, 'Autium12', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:42', NULL, NULL, NULL, NULL),
(34, 'AUT-000034', '', 'Kathy Thegreek', NULL, NULL, NULL, 'Autium13', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:06:42', NULL, 'test', NULL, NULL),
(35, 'AUT-000035', '$2y$13$DQeFHdl2r0WNF2OmUdkx5.T14hsOGHcq/ckT3D6C0OlhPu4KblrQ6', 'Name', NULL, NULL, NULL, 'Confirm', 'Address', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:53', 'Nationality', 'Licence Type', 'DOB', NULL),
(36, 'AUT-000036', '$2y$13$6C7U8/BCrZ607w.05ydyRO2MjENLbcpbDwttg8woI3TAJ92oiWX5y', 'Herald Jacobson', NULL, NULL, NULL, 'Autium1', '25 Nile Drive, Burlington On', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:54', 'Color?', 'G2', '12-24-2010', NULL),
(37, 'AUT-000037', '$2y$13$Ix3PMSlwfgIPJ3M3ZC4WoOefrrVPHbJEHVrQA/yuXJDpk/9mmVNH.', 'Brad Watts', NULL, NULL, NULL, 'Autium2', '32 Den Turnoff, Casaloma', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:55', 'Italian', 'G2', '01/02/1999', NULL),
(38, 'AUT-000038', '', 'Joey Scrivo', NULL, NULL, NULL, 'Autium3', '55 Bridgeford, Park Dale, Cal 32244', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:55', 'Greek', 'G1', '30/30/3000', NULL),
(39, 'AUT-000039', '$2y$13$DaGM2suagQBhkyA27GLwGegAaP2pulGjiQy6e3OEJERSHTBObVW.O', 'Scott Delaney', NULL, NULL, NULL, 'Autium4', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:55', 'Scottish', 'D56', '01/01/1885', NULL),
(40, 'AUT-000040', '$2y$13$vxAWFlVIBij9VCWSU7QdOe1SoVgGabhCd2AnBiBFP1C9pwGB0WhYe', 'Marco Estrada', NULL, NULL, NULL, 'Autium5', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:56', 'English', 'None', '05-30-99', NULL),
(41, 'AUT-000041', '$2y$13$mjGZ/YmremwsU840K0OZQuDEBe7X1pyNWlwsICMc/er/Q1yQfcK5m', 'Ben Nichols', NULL, NULL, NULL, 'Autium6', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:57', 'Indian', 'Blank', '1999-30-05', NULL),
(42, 'AUT-000042', '$2y$13$EsOAFKIS.FHyzMpc2E83EuMxTC6Tmi2B7YnoVRv4t/i2O3LcdRo.6', 'Nikki Fourfingers', NULL, NULL, NULL, 'Autium7', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:58', 'Black', NULL, '05-30-99', NULL),
(43, 'AUT-000043', '$2y$13$i6FVZ9vwtxeuSWlGXhJKKOFYnmG.gUdqY8xel5ODdU82yvbH0mawu', 'Andrew Wilson Jr', NULL, NULL, NULL, 'Autium8', 'This could be blank', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:59', 'White', NULL, '1999', NULL),
(44, 'AUT-000044', '', 'Greg Thefist', NULL, NULL, NULL, 'Autium9', 'Hopefully it could be anything', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:59', 'Caucasion', NULL, '07-08-01', NULL),
(45, 'AUT-000045', '', 'Henry Hanks', NULL, NULL, NULL, 'Autium10', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:59', 'Whats the point?', NULL, '651', NULL),
(46, 'AUT-000046', '', 'Nick Noble', NULL, NULL, NULL, 'Autium11', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:59', NULL, 'Test', NULL, NULL),
(47, 'AUT-000047', '', 'Gerrard Thomas', NULL, NULL, NULL, 'Autium12', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:59', NULL, NULL, NULL, NULL),
(48, 'AUT-000048', '', 'Kathy Thegreek', NULL, NULL, NULL, 'Autium13', NULL, '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-07-13 16:07:59', NULL, 'test', NULL, NULL),
(49, 'AUT-000049', '$2y$13$qzUBrNp/dZ2N2K0zQMKROOxzv7cbHBiq.Ls.4fQ2z000jqfCEHcZi', 'Bella Bear', NULL, NULL, NULL, '', '', '2017-07-11', 'Active', 1, 'Driver', '0EPMatQWVZebq3FqErHXhvOijdTPRVspgyBW7fkTJqMP4rG7Bgmw7tTGiCzHk0KKPkaZiq49Lcb49', '2024-07-14 12:58:58', '', '', '0', 'No'),
(50, 'AUT-000050', '$2y$13$e2wC9KNHlh5FKxvqo5V0TOFeaR//enTlmX4aP.u2LvIn9cptcvOKy', 'Luke Withers', NULL, NULL, NULL, '14 Heath Road, Belbroughton, DY8 5TN', 'LW4567890', '1988-09-11', 'Active', 1, 'Driver', NULL, '2017-07-18 19:20:48', 'No', 'British', '6', NULL),
(51, 'AUT-000051', '$2y$13$ZJ85CeC0IVU2HBS85jIMoe6zR.KK8lqcoKe0MJtrR8Njlx9oAGbtC', 'Luke Withers', NULL, NULL, NULL, '14 Heath Road, Belbroughton, DY8 5TN', 'LW4567890', '1988-09-11', 'Active', 1, 'Driver', NULL, '2017-07-18 19:20:49', 'Yes', 'UK', '6', NULL),
(52, 'AUT-000052', '$2y$13$7L6b9wHlKRSvEp84Q.Hiburm7Xh8IEumQOe/zCQmF/vKg4dmrPEd.', 'Luke Withers', NULL, NULL, NULL, '14 Heath Road, Belbroughton, DY8 5TN', 'LW4567890', '1988-09-11', 'Active', 1, 'Driver', NULL, '2017-07-18 19:20:50', 'No', 'British', '6', NULL),
(53, 'AUT-000053', '$2y$13$/2dT69Siux17en79jy5Ew.0ZrRok5g794OcNvlLKvB6WxcrGiP33.', 'Zeeshan Ahmad', NULL, NULL, NULL, 'H # 70, Usman Gani Street, HighCoirt Society, Johar town C-1, Lahore.', '3450136927485', '2016-11-30', 'Active', 1, 'Driver', 'sAq4dm0MABLKMw~KNcijftL6Wb8LgjExxXIW~e09JgJmwCn3Prn19tr7mIN3fqGtZ~2etc_~lTz53', '2024-08-26 16:25:12', 'LTV', 'Pakistani', '7', 'Yes'),
(54, 'AUT-000054', '$2y$13$D7cthhlaUaLYBZ6gFxhEVunDQLRbruySAjCVzl335YK0M7YGRZjO6', 'Haroon Rasheed', NULL, NULL, NULL, '41 St. bernard Crescent, Edinburgh, EH6 6NQ', 'ab123nm', '1986-10-10', 'Active', 1, 'Driver', 'IzKuQhl9Sae0Qb6oKMCDX4sYprH5gyyzuV8s~SHbaJ9F~mQfIp8uULmZYW6EIGxhP1NHsd~qp3o54', '2024-09-30 18:28:04', 'Full UK', '', '0', 'No'),
(55, 'AUT-000055', '', 'Tom Dodd', NULL, NULL, NULL, '14 Heath Road, Belbroughton, DY8 5TN', 'LW45678901', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-10-01 10:24:15', 'No', 'British', '6', 'No'),
(56, 'AUT-000056', '', 'Tom Snow', NULL, NULL, NULL, NULL, 'LW4567123', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-10-01 10:24:15', 'No', NULL, '3', NULL),
(57, 'AUT-000057', '', 'Ian Rogers', NULL, NULL, NULL, 'George Street, Canada', 'LW4567891', '1970-01-01', 'Active', 1, 'Driver', NULL, '2017-10-01 10:24:15', '', 'Canadian', '0', 'No'),
(58, 'AUT-000058', '', 'Matrin Grey', NULL, NULL, NULL, '14 Heath Road, Belbroughton, DY8 5TN', 'LW4567890', '1988-09-25', 'Active', 1, 'Driver', NULL, '2017-10-02 12:40:27', 'No', 'British', '6', NULL),
(59, 'AUT-000059', '', 'David Garfield', NULL, NULL, NULL, NULL, 'LW4567123', '1988-10-25', 'Active', 1, 'Driver', NULL, '2017-10-02 12:40:27', 'No', NULL, '3', NULL),
(60, 'AUT-000060', '', 'Sam Jones', NULL, NULL, NULL, 'George Street, Canada', 'LW4567890', '1988-09-25', 'Active', 1, 'Driver', NULL, '2017-10-02 12:40:27', 'No', 'Canadian', NULL, NULL),
(61, 'AUT-000061', '', 'Ian Rogers', NULL, NULL, NULL, '', 'LW4567891', '1988-09-25', 'Active', 1, 'Driver', NULL, '2017-10-02 12:40:27', 'No', '', '0', 'No'),
(62, 'AUT-000062', '$2y$13$e/oIR1MVTk7QXJyplD3N4Oc19cwI5aTXTqq0oShEiASAfsOLTSY/O', 'David Garfield', NULL, NULL, NULL, '', 'LW4567123', '1988-10-10', 'Active', 1, 'Driver', NULL, '2017-10-03 09:21:05', 'No', '', '3', 'No'),
(63, 'AUT-000063', '$2y$13$hiTA07HOcYCH1ba.Y7lTUuNFxG7VOPK9NqPLSPImIfnAAi9i7qmWm', 'Ian Rogers', NULL, NULL, NULL, '', 'LW4567890', '1988-09-25', 'Active', 1, 'Driver', 'djc9PAU8qwt3Kb6PKyspqOqOalajLSCK22EHDhILF~klnji7sTqMbIjIzuLF1XgbujkIwBeDvR463', '2024-10-04 23:12:22', 'No', '', '0', 'No'),
(64, 'AUT-000064', '$2y$13$3BAtSAQ6YOZwFIa0gv7JI.4eeCveTGDQbNr7OZ0ERJcHV0UZA8U0G', 'Matrin Grey', NULL, NULL, NULL, '14 Heath Road, Belbroughton, DY8 5TN', 'LW4567890', '2017-06-20', 'Active', 3, 'Driver', NULL, '2017-10-04 22:24:45', 'No', 'British', '9', 'Yes'),
(65, 'AUT-000065', '$2y$13$XZ9ANDtY1ELd/DRyZBVUgOstgy5.4bgwGqcoQr7j12bp213p9fd2C', 'David Garfield', NULL, NULL, NULL, NULL, 'LW4567123', '1988-10-10', 'Active', 3, 'Driver', NULL, '2017-10-04 22:24:46', 'No', NULL, '3', NULL),
(66, 'AUT-000066', '$2y$13$TU7l/7CP010Cd0JztRP8uuP6xdFh.ivIbTtts9hgH95Plk8kMyQlC', 'Ian Rogers', NULL, NULL, NULL, '', 'mn123', '1988-09-25', 'Active', 3, 'Driver', 'PdasNcUqY0DLZprwFK_6Y_WH8ENeG~XpuEACUz8KcSW6xvFstJoeeM~6WXa9AOuIWk_bnrjLBO666', '2024-10-06 14:47:41', 'No', '', '6', 'No'),
(67, 'AUT-000067', '$2y$13$2EQ87UVKPQtCYCT1he5wcea9LDygeeT45s2JfUCghTogcRddI0tIu', 'David Brent', NULL, NULL, NULL, '14 Heath Road, Belbroughton, DY8 5TN', 'LW4567890', '1988-09-25', 'Active', 6, 'Driver', NULL, '2017-10-07 08:29:48', 'No', 'British', '0', 'No'),
(68, 'AUT-000068', '$2y$13$sDDma8yaG3anDvgzf5cTFOqxgjdyHSG55Fhz/lFPJY35QCVpeIeaa', 'Chris Finch', NULL, NULL, NULL, '', 'LW4567123', '1988-10-10', 'Active', 6, 'Driver', NULL, '2017-10-07 08:29:49', 'No', 'British', '0', 'No'),
(69, 'AUT-000069', '$2y$13$zNK4e7nEu3eejWyBOz4aZulrIFMZ87grAnAs5Y9M10QHZpJhNS0Rq', 'Darren Clegg', NULL, NULL, NULL, 'The Lords, Harborne', 'LW4567890', '1985-01-01', 'Active', 6, 'Driver', NULL, '2017-10-07 08:29:50', 'No', 'British', '0', 'No'),
(70, 'AUT-000070', '$2y$13$fJZmKu9xfpJLbO1zLPYtSOP1GW5.XvSc.7fXTfKHwIc0j9CKPsjzW', 'Tom Holliday', NULL, NULL, NULL, '25 Wood Lane, Harborne, B17 9AY', 'LW1234555', '1991-11-01', 'Active', 6, 'Driver', 'CABxGH8RKMHwVJ1Ne2EvZMZASUHLw4ossRcP6_3RakIqXF4s~3E5LJvEjBSGZPh1jCKHGpsRtBV70', '2024-10-07 09:36:46', 'No', 'British', '0', 'No'),
(71, 'AUT-000071', '$2y$13$HHNGMTPWuS6CK89WXo3HZerVgRjIL94YiETJUlts7cLywYfmHpwbm', 'Karl Pilkington', NULL, NULL, NULL, '', 'LW4567890', '1988-09-25', 'Active', 6, 'Driver', NULL, '2017-10-07 08:29:51', 'No', 'British', '0', 'No'),
(72, 'AUT-000072', '$2y$13$wrtcxqxGIbiBY8gwL.hjGuycf0BWzG3xwf0BuAi2nsteXs27UbkDG', 'Matrin Grey', NULL, NULL, NULL, '14 Heath Road, Belbroughton, DY8 5TN', 'LW4567890', '1988-09-25', 'Active', 5, 'Driver', NULL, '2017-10-07 23:50:49', 'No', 'British', '6', NULL),
(73, 'AUT-000073', '$2y$13$PIcNpj8KeJrc/MV.DaHiCOkWtL4iuw1morCp0rCbnl5QO///RLRhS', 'David Garfield', NULL, NULL, NULL, NULL, 'LW4567123', '1988-10-10', 'Active', 5, 'Driver', NULL, '2017-10-07 23:50:50', 'No', NULL, '3', NULL),
(74, 'AUT-000074', '$2y$13$191IgBioNgIYloJXr13vJOp6uI3MvcedotX4VTE7xYsXvedjcLs/e', 'Ian Rogers', NULL, NULL, NULL, '', 'LW4567890', '1988-09-25', 'Active', 5, 'Driver', NULL, '2017-10-07 23:50:51', 'G2', '', '0', 'No'),
(75, 'AUT-000075', '$2y$13$SkGAsES7.04f1ngnmcZmtuYwu51GUk5gged7.fubjqNCPvSfo6wCu', 'Luke Withers', NULL, NULL, NULL, '255 Queen Street', 'Uy3828399', '1966-08-30', 'Active', 5, 'Driver', NULL, '2017-10-07 23:50:52', 'No', 'British', '12', NULL),
(76, 'AUT-000076', '$2y$13$wsehoiI0izpdP2SRWTc9hejJwz0OyZqq0ym2HVssnYc4bTisQ7K0G', 'Andrew Smilson', NULL, NULL, NULL, '450 West Point Avenue', 'WBF330409', '1905-06-05', 'Active', 5, 'Driver', '2qbYxfcyiEKxpaIeJw3PIclNYPD7Pqg6NaOTJBnNTgl3ypGPujHFr6rGL3RLUPDriTYD00kbo_u76', '2024-10-08 00:59:39', 'No', 'Canadian', NULL, NULL),
(77, 'AUT-000077', '$2y$13$UvTEuk.6IoAR5eLKqwOupOTj2pkmNqfeq/HX/SzFctaApd7x.r1iS', 'Tom Scavenger', NULL, NULL, NULL, '10 Skyview Cr', '9btY99209', '1905-06-10', 'Active', 5, 'Driver', NULL, '2017-10-07 23:50:53', 'No', 'Canadian', '3', NULL),
(78, 'AUT-000078', '$2y$13$gdBGfSRlLXnRcQ6zHfWyAeQh1m4BCdNyXJ8lefdiCxi5Z2A1ptfzW', 'Luke Withers', NULL, NULL, NULL, '37 Western Road', 'WITHE378857', '1988-09-11', 'Active', 7, 'Driver', 'SE~zcX76llXf6D5kCnPPFDk~pxaB6Z3QYo3CzmIEfXS3tY9fo9K19mPDJgfS8q8hgRCxhh0GmDh78', '2024-10-08 09:08:27', 'Full UK', 'British', '3', 'No'),
(79, 'AUT-000079', '$2y$13$AxdJwxR34EEuP/TX3KtUFeyKqs1KKRYho/dMSH7n.T2OLCji2/.1u', 'Matrin Grey', NULL, NULL, NULL, '14 Heath Road, Belbroughton, DY8 5TN', 'LW4567890', '1988-09-25', 'Active', 7, 'Driver', NULL, '2017-10-08 15:27:09', 'No', 'British', '6', 'No'),
(80, 'AUT-000080', '$2y$13$lx5dw02StoLzYhFW1Sur5OEOcdrxjDN94yypIC7Ecqou2di4zoeSq', 'David Garfield', NULL, NULL, NULL, '99, Endless Crescent, Dudley, DY6 5PU', 'LW4567123', '1988-10-10', 'Active', 7, 'Driver', NULL, '2017-10-08 15:27:10', 'No', 'British', '3', NULL),
(81, 'AUT-000081', '$2y$13$7rL1fQZTp31Rdkfjdqve/u3W5AxY.8CefEfQBYhQN0ZOcPVIdFjiy', 'Toby Carvery', NULL, NULL, NULL, 'East London Street, Canada', 'TBC4567899', '1963-04-28', 'Active', 7, 'Driver', NULL, '2017-10-08 15:27:11', 'Yes', 'British', '6', NULL),
(82, 'AUT-000082', '$2y$13$L0vHz7PkxKQ.hDBvXGkC7.N4mju0QvvgvjV/3uhzLEovh1S87XJ4m', 'Ian Rogers', NULL, NULL, NULL, 'Firth, Scotland, SC4 7UY', 'LW4567890', '1988-09-25', 'Active', 7, 'Driver', NULL, '2017-10-08 15:27:12', 'No', 'British', NULL, NULL),
(83, 'AUT-000083', '$2y$13$fI5u9H/xtNqkg/UzQ6QIPuELYGq1FYDT3YJtfbr7VHJW9ItY07EpK', 'Bilawal', NULL, NULL, NULL, '', '123456', '2017-10-15', 'Active', 3, 'Driver', 'd~R3iHskQu2~Td4xfPBI~kL7_BN9ig0rQuvxPpoGnOZnPl7fjjixJV2cFJLWzyVf5DagbqiSqpo83', '2024-10-15 21:20:28', '', '', '0', 'No'),
(84, 'AUT-000084', '$2y$13$hcSSZOhc.SqVxbCwJWzRfeoKH3j.9MQTmR/ZbuxpjLFFFGL66NNWi', 'Haroon', NULL, NULL, NULL, '', 'DW123456', '2017-10-24', 'Active', 3, 'Driver', NULL, '2017-10-23 17:16:21', '', '', '0', 'No'),
(85, 'AUT-000085', '$2y$13$ASRBiujKcBFU1Ib8QqnR9Oqlhz/8x.MbFYD9cnNRV.iGoVpP9oqKm', 'Matrin Grey', NULL, NULL, NULL, '14 Heath Road, Belbroughton, DY8 5TN', 'LW4567890', '1988-09-25', 'Active', 3, 'Driver', NULL, '2017-10-23 17:19:14', 'No', 'British', '6', 'No'),
(86, 'AUT-000086', '$2y$13$0zD/P.J/MbVDuK6yd.G3C.kIFLmrxu/Iy9uzZPawt4JtiLTCw148.', 'Ian Rogers', NULL, NULL, NULL, '', 'LW4567890', '1988-09-25', 'Active', 3, 'Driver', NULL, '2017-10-23 17:19:15', 'No', '', '0', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `fleetmanager`
--

CREATE TABLE IF NOT EXISTS `fleetmanager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Fleet','Admin','Driver') NOT NULL DEFAULT 'Fleet',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` enum('Active','Blocked','Inactive') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `fleetmanager`
--

INSERT INTO `fleetmanager` (`id`, `email`, `password`, `role`, `first_name`, `last_name`, `picture`, `status`) VALUES
(1, 'fleetmanager@gmail.com', '$2y$13$EpMDlHYJRTlx9cT3bTPHbegpqrMbLRUgaOX6obTntFdMmQpqwuQxy', 'Fleet', 'Luke', 'Withers (Fleet Manager )', '1507035944-caseone-invoicing-white2x.png', 'Active'),
(2, 'luke_withers@autium.co.uk', '$2y$13$EpMDlHYJRTlx9cT3bTPHbegpqrMbLRUgaOX6obTntFdMmQpqwuQxy', 'Fleet', 'Luke', 'Withers', NULL, 'Inactive'),
(3, 'haroon@4d-studios.co.uk', '$2y$13$LQ0w2KW2Ddnu89IAwtLcvunynOdXBVTrVhg5sNANcMbyjuwwgaGmK', 'Fleet', 'Haroon', ' Rasheed (Fleet Manager)', NULL, 'Active'),
(4, 'matt.clive@gmail.com', '$2y$13$OPJhY8V1lSXSMluTqMbNd.SnSD5pVMr0nRp8qmhetoe4AScDZBP0a', 'Fleet', 'Matt', 'Clive', NULL, 'Active'),
(5, 'teamautium@gmail.com', '$2y$13$AdVcbBCPLDYTRPl1HELmX.8Hnnh2km5tiwb8HibWdZYojd2qyJo7e', 'Fleet', 'Luke', 'Withers', NULL, 'Active'),
(6, 'tom_holliday@autium.co.uk', '$2y$13$.6Ip.8Tx//.Uh7Zs.BC/WO/VY.cdM1UEpO5Mw65fcnuLyu0JVKXIG', 'Fleet', 'Tom', 'Holliday', NULL, 'Active'),
(7, 'withers_2004@hotmail.com', '$2y$13$wUidafoaAbqdJ.68j..UH.YCs/OP9xOS/gUZVhpo1XhMhhZfy/z.S', 'Fleet', 'Luke', 'Withers', NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password_requests`
--

CREATE TABLE IF NOT EXISTS `forgot_password_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `date_requested` datetime NOT NULL,
  `status` enum('Pending','Changed','Rejected') NOT NULL,
  `fleetmanager_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inspection_checklist`
--

CREATE TABLE IF NOT EXISTS `inspection_checklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT '0',
  `inspection_report_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=337 ;

--
-- Dumping data for table `inspection_checklist`
--

INSERT INTO `inspection_checklist` (`id`, `item_name`, `is_done`, `inspection_report_id`) VALUES
(1, 'security of load', 1, 1),
(2, 'Security ', 1, 1),
(3, 'Rear Under Bar', 1, 1),
(4, 'Floor/ Bodywork', 0, 1),
(5, 'Sideguards', 1, 1),
(6, 'Rear Under Bar', 1, 2),
(7, 'Security ', 1, 2),
(8, 'Sideguards', 1, 2),
(9, 'Mudguards', 1, 2),
(10, 'Suspension', 1, 2),
(11, 'security of load', 1, 2),
(12, 'Floor/ Bodywork', 1, 2),
(13, 'Tyre Tread', 0, 3),
(14, 'Seat Belts', 0, 3),
(15, 'Windscreen', 1, 3),
(16, 'Brake Lights', 1, 3),
(17, 'Number plate visibility', 1, 3),
(18, 'Fuel/oil leaks', 1, 3),
(19, 'Steering', 1, 3),
(20, 'Wipers and washer', 1, 3),
(21, 'Indicators', 1, 3),
(22, 'Handbrake', 1, 3),
(23, 'mirrors', 1, 3),
(24, 'Horn', 1, 3),
(25, 'Antifreeze level', 1, 3),
(26, 'Wheel Nuts', 1, 3),
(27, 'Brakes', 1, 3),
(28, 'Suspension', 1, 3),
(29, 'Fire extinguishers', 0, 3),
(30, 'Umbrella Holder', 0, 3),
(31, 'Tyre Tread', 1, 4),
(32, 'Seat Belts', 1, 4),
(33, 'Windscreen', 1, 4),
(34, 'Brake Lights', 1, 4),
(35, 'Number plate visibility', 1, 4),
(36, 'Fuel/oil leaks', 1, 4),
(37, 'Steering', 1, 4),
(38, 'Wipers and washer', 1, 4),
(39, 'Indicators', 1, 4),
(40, 'Handbrake', 1, 4),
(41, 'mirrors', 1, 4),
(42, 'Horn', 1, 4),
(43, 'Antifreeze level', 1, 4),
(44, 'Wheel Nuts', 1, 4),
(45, 'Brakes', 1, 4),
(46, 'Suspension', 1, 4),
(47, 'Fire extinguishers', 1, 4),
(48, 'Umbrella Holder', 1, 4),
(49, 'Fire extinguishers', 0, 5),
(50, 'Umbrella Holder', 1, 5),
(51, 'Suspension', 1, 5),
(52, 'Wheel Nuts', 1, 5),
(53, 'Brakes', 1, 5),
(54, 'Tyre Tread', 0, 6),
(55, 'Seat Belts', 0, 6),
(56, 'Windscreen', 1, 6),
(57, 'Brake Lights', 1, 6),
(58, 'Number plate visibility', 1, 6),
(59, 'Fuel/oil leaks', 1, 6),
(60, 'Steering', 1, 6),
(61, 'Wipers and washer', 1, 6),
(62, 'Indicators', 1, 6),
(63, 'Handbrake', 1, 6),
(64, 'mirrors', 1, 6),
(65, 'Horn', 1, 6),
(66, 'Antifreeze level', 1, 6),
(67, 'Wheel Nuts', 1, 6),
(68, 'Brakes', 1, 6),
(69, 'Suspension', 1, 6),
(70, 'Fire extinguishers', 1, 6),
(71, 'Umbrella Holder', 1, 6),
(72, 'Wheels/ Tyres', 1, 7),
(73, 'Wheel Nuts', 1, 7),
(74, 'Handbrake & Cable', 1, 7),
(75, 'Electric Coupling', 1, 7),
(76, 'Air Couplings', 1, 7),
(77, 'Brakes', 1, 7),
(78, 'Suspension', 1, 7),
(79, 'Mudguards', 1, 7),
(80, 'Sideguards', 1, 7),
(81, 'Rear Under Bar', 1, 7),
(82, 'Floor/ Bodywork', 1, 7),
(83, 'Security ', 0, 7),
(84, 'security of load', 0, 7),
(85, 'Tyre Tread', 1, 8),
(86, 'Seat Belts', 1, 8),
(87, 'Windscreen', 1, 8),
(88, 'Brake Lights', 1, 8),
(89, 'Number plate visibility', 1, 8),
(90, 'Fuel/oil leaks', 1, 8),
(91, 'Steering', 1, 8),
(92, 'Wipers and washer', 1, 8),
(93, 'Indicators', 1, 8),
(94, 'Handbrake', 1, 8),
(95, 'mirrors', 1, 8),
(96, 'Horn', 1, 8),
(97, 'Antifreeze level', 1, 8),
(98, 'Wheel Nuts', 1, 8),
(99, 'Brakes', 1, 8),
(100, 'Suspension', 1, 8),
(101, 'Fire extinguishers', 1, 8),
(102, 'Umbrella Holder', 1, 8),
(103, 'Tyre Tread', 0, 9),
(104, 'Seat Belts', 0, 9),
(105, 'Windscreen', 0, 9),
(106, 'Brake Lights', 0, 9),
(107, 'Number plate visibility', 1, 9),
(108, 'Fuel/oil leaks', 1, 9),
(109, 'Steering', 1, 9),
(110, 'Wipers and washer', 1, 9),
(111, 'Indicators', 1, 9),
(112, 'Handbrake', 1, 9),
(113, 'mirrors', 1, 9),
(114, 'Horn', 1, 9),
(115, 'Antifreeze level', 1, 9),
(116, 'Wheel Nuts', 1, 9),
(117, 'Brakes', 1, 9),
(118, 'Suspension', 1, 9),
(119, 'Fire extinguishers', 1, 9),
(120, 'Umbrella Holder', 1, 9),
(121, 'Tyre Tread', 1, 10),
(122, 'Seat Belts', 0, 10),
(123, 'Windscreen', 0, 10),
(124, 'Brake Lights', 0, 10),
(125, 'Number plate visibility', 1, 10),
(126, 'Fuel/oil leaks', 1, 10),
(127, 'Steering', 1, 10),
(128, 'Wipers and washer', 1, 10),
(129, 'Indicators', 1, 10),
(130, 'Handbrake', 1, 10),
(131, 'mirrors', 1, 10),
(132, 'Horn', 1, 10),
(133, 'Antifreeze level', 1, 10),
(134, 'Wheel Nuts', 1, 10),
(135, 'Brakes', 0, 10),
(136, 'Suspension', 0, 10),
(137, 'Fire extinguishers', 0, 10),
(138, 'Umbrella Holder', 0, 10),
(139, 'Tyre Tread', 0, 11),
(140, 'Seat Belts', 0, 11),
(141, 'Windscreen', 0, 11),
(142, 'Brake Lights', 1, 11),
(143, 'Number plate visibility', 1, 11),
(144, 'Fuel/oil leaks', 1, 11),
(145, 'Steering', 1, 11),
(146, 'Wipers and washer', 1, 11),
(147, 'Indicators', 1, 11),
(148, 'Handbrake', 1, 11),
(149, 'mirrors', 1, 11),
(150, 'Horn', 1, 11),
(151, 'Antifreeze level', 1, 11),
(152, 'Wheel Nuts', 1, 11),
(153, 'Brakes', 1, 11),
(154, 'Suspension', 1, 11),
(155, 'Fire extinguishers', 1, 11),
(156, 'Umbrella Holder', 1, 11),
(157, 'Tyre Tread', 1, 12),
(158, 'Seat Belts', 1, 12),
(159, 'Windscreen', 1, 12),
(160, 'Brake Lights', 1, 12),
(161, 'Number plate visibility', 1, 12),
(162, 'Fuel/oil leaks', 1, 12),
(163, 'Steering', 1, 12),
(164, 'Wipers and washer', 1, 12),
(165, 'Indicators', 1, 12),
(166, 'Handbrake', 1, 12),
(167, 'mirrors', 1, 12),
(168, 'Horn', 1, 12),
(169, 'Antifreeze level', 1, 12),
(170, 'Wheel Nuts', 1, 12),
(171, 'Brakes', 1, 12),
(172, 'Suspension', 1, 12),
(173, 'Fire extinguishers', 1, 12),
(174, 'Umbrella Holder', 1, 12),
(175, 'Tyre Tread', 1, 13),
(176, 'Seat Belts', 1, 13),
(177, 'Windscreen', 1, 13),
(178, 'Brake Lights', 1, 13),
(179, 'Number plate visibility', 1, 13),
(180, 'Fuel/oil leaks', 1, 13),
(181, 'Steering', 1, 13),
(182, 'Wipers and washer', 1, 13),
(183, 'Indicators', 1, 13),
(184, 'Handbrake', 1, 13),
(185, 'mirrors', 1, 13),
(186, 'Horn', 1, 13),
(187, 'Antifreeze level', 1, 13),
(188, 'Wheel Nuts', 1, 13),
(189, 'Brakes', 1, 13),
(190, 'Suspension', 1, 13),
(191, 'Fire extinguishers', 1, 13),
(192, 'Umbrella Holder', 1, 13),
(193, 'Tyre Tread', 1, 14),
(194, 'Seat Belts', 1, 14),
(195, 'Windscreen', 1, 14),
(196, 'Brake Lights', 1, 14),
(197, 'Number plate visibility', 1, 14),
(198, 'Fuel/oil leaks', 1, 14),
(199, 'Steering', 1, 14),
(200, 'Wipers and washer', 1, 14),
(201, 'Indicators', 1, 14),
(202, 'Handbrake', 1, 14),
(203, 'mirrors', 1, 14),
(204, 'Horn', 1, 14),
(205, 'Antifreeze level', 1, 14),
(206, 'Wheel Nuts', 1, 14),
(207, 'Brakes', 1, 14),
(208, 'Suspension', 1, 14),
(209, 'Fire extinguishers', 1, 14),
(210, 'Umbrella Holder', 1, 14),
(211, 'Tyre Tread', 1, 15),
(212, 'Seat Belts', 1, 15),
(213, 'Windscreen', 1, 15),
(214, 'Brake Lights', 1, 15),
(215, 'Number plate visibility', 1, 15),
(216, 'Fuel/oil leaks', 1, 15),
(217, 'Steering', 1, 15),
(218, 'Wipers and washer', 1, 15),
(219, 'Indicators', 1, 15),
(220, 'Handbrake', 1, 15),
(221, 'mirrors', 1, 15),
(222, 'Horn', 1, 15),
(223, 'Antifreeze level', 1, 15),
(224, 'Wheel Nuts', 1, 15),
(225, 'Brakes', 1, 15),
(226, 'Suspension', 1, 15),
(227, 'Fire extinguishers', 1, 15),
(228, 'Umbrella Holder', 1, 15),
(229, 'Tyre Tread', 1, 16),
(230, 'Seat Belts', 1, 16),
(231, 'Windscreen', 1, 16),
(232, 'Brake Lights', 1, 16),
(233, 'Number plate visibility', 1, 16),
(234, 'Fuel/oil leaks', 1, 16),
(235, 'Steering', 1, 16),
(236, 'Wipers and washer', 1, 16),
(237, 'Indicators', 1, 16),
(238, 'Handbrake', 1, 16),
(239, 'mirrors', 1, 16),
(240, 'Horn', 1, 16),
(241, 'Antifreeze level', 1, 16),
(242, 'Wheel Nuts', 1, 16),
(243, 'Brakes', 1, 16),
(244, 'Suspension', 1, 16),
(245, 'Fire extinguishers', 1, 16),
(246, 'Umbrella Holder', 1, 16),
(247, 'Tyre Tread', 1, 17),
(248, 'Seat Belts', 1, 17),
(249, 'Windscreen', 1, 17),
(250, 'Brake Lights', 1, 17),
(251, 'Number plate visibility', 1, 17),
(252, 'Fuel/oil leaks', 1, 17),
(253, 'Steering', 1, 17),
(254, 'Wipers and washer', 1, 17),
(255, 'Indicators', 1, 17),
(256, 'Handbrake', 1, 17),
(257, 'mirrors', 1, 17),
(258, 'Horn', 1, 17),
(259, 'Antifreeze level', 1, 17),
(260, 'Wheel Nuts', 1, 17),
(261, 'Brakes', 1, 17),
(262, 'Suspension', 1, 17),
(263, 'Fire extinguishers', 1, 17),
(264, 'Umbrella Holder', 1, 17),
(265, 'Tyre Tread', 1, 18),
(266, 'Seat Belts', 1, 18),
(267, 'Windscreen', 1, 18),
(268, 'Brake Lights', 1, 18),
(269, 'Number plate visibility', 1, 18),
(270, 'Fuel/oil leaks', 1, 18),
(271, 'Steering', 1, 18),
(272, 'Wipers and washer', 1, 18),
(273, 'Indicators', 1, 18),
(274, 'Handbrake', 1, 18),
(275, 'mirrors', 1, 18),
(276, 'Horn', 1, 18),
(277, 'Antifreeze level', 1, 18),
(278, 'Wheel Nuts', 1, 18),
(279, 'Brakes', 1, 18),
(280, 'Suspension', 1, 18),
(281, 'Fire extinguishers', 1, 18),
(282, 'Umbrella Holder', 1, 18),
(283, 'Tyre Tread', 1, 19),
(284, 'Seat Belts', 0, 19),
(285, 'Windscreen', 1, 19),
(286, 'Brake Lights', 1, 19),
(287, 'Number plate visibility', 1, 19),
(288, 'Fuel/oil leaks', 1, 19),
(289, 'Steering', 1, 19),
(290, 'Wipers and washer', 1, 19),
(291, 'Indicators', 1, 19),
(292, 'Handbrake', 1, 19),
(293, 'mirrors', 1, 19),
(294, 'Horn', 1, 19),
(295, 'Antifreeze level', 1, 19),
(296, 'Wheel Nuts', 1, 19),
(297, 'Brakes', 1, 19),
(298, 'Suspension', 1, 19),
(299, 'Fire extinguishers', 1, 19),
(300, 'Umbrella Holder', 1, 19),
(301, 'Tyre Tread', 1, 20),
(302, 'Seat Belts', 0, 20),
(303, 'Windscreen', 1, 20),
(304, 'Brake Lights', 1, 20),
(305, 'Number plate visibility', 1, 20),
(306, 'Fuel/oil leaks', 1, 20),
(307, 'Steering', 1, 20),
(308, 'Wipers and washer', 1, 20),
(309, 'Indicators', 1, 20),
(310, 'Handbrake', 1, 20),
(311, 'mirrors', 1, 20),
(312, 'Horn', 1, 20),
(313, 'Antifreeze level', 1, 20),
(314, 'Wheel Nuts', 1, 20),
(315, 'Brakes', 1, 20),
(316, 'Suspension', 1, 20),
(317, 'Fire extinguishers', 1, 20),
(318, 'Umbrella Holder', 1, 20),
(319, 'Tyre Tread', 1, 21),
(320, 'Seat Belts', 1, 21),
(321, 'Windscreen', 1, 21),
(322, 'Brake Lights', 1, 21),
(323, 'Number plate visibility', 1, 21),
(324, 'Fuel/oil leaks', 1, 21),
(325, 'Steering', 1, 21),
(326, 'Wipers and washer', 1, 21),
(327, 'Indicators', 1, 21),
(328, 'Handbrake', 1, 21),
(329, 'mirrors', 1, 21),
(330, 'Horn', 1, 21),
(331, 'Antifreeze level', 1, 21),
(332, 'Wheel Nuts', 1, 21),
(333, 'Brakes', 1, 21),
(334, 'Suspension', 1, 21),
(335, 'Fire extinguishers', 1, 21),
(336, 'Umbrella Holder', 1, 21);

-- --------------------------------------------------------

--
-- Table structure for table `inspection_checklist_fleet`
--

CREATE TABLE IF NOT EXISTS `inspection_checklist_fleet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `fleetmanager_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `inspection_checklist_fleet`
--

INSERT INTO `inspection_checklist_fleet` (`id`, `item_name`, `fleetmanager_id`) VALUES
(1, 'Tyre Tread', 1),
(2, 'Seat Belts', 1),
(3, 'Windscreen', 1),
(4, 'Brake Lights', 1),
(5, 'Number plate visibility', 1),
(6, 'Fuel/oil leaks', 1),
(7, 'Steering', 1),
(8, 'Wipers and washer', 1),
(9, 'Indicators', 1),
(10, 'Handbrake', 1),
(11, 'mirrors', 1),
(12, 'Horn', 1),
(13, 'Antifreeze level', 1),
(14, 'Wheel Nuts', 1),
(15, 'Brakes', 1),
(16, 'Suspension', 1),
(17, 'Fire extinguishers', 1),
(19, 'Umbrella Holder', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inspection_template`
--

CREATE TABLE IF NOT EXISTS `inspection_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) NOT NULL,
  `fleetmanager_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `udpated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `inspection_template`
--

INSERT INTO `inspection_template` (`id`, `template_name`, `fleetmanager_id`, `created_at`, `udpated_at`) VALUES
(1, 'Routine Check', 1, '2017-08-21 07:38:08', '2017-10-02 16:49:22'),
(3, 'trailer-HRY', 1, '2017-09-30 19:49:31', '2017-10-03 10:17:28'),
(6, 'Haroon Ins', 3, '2017-10-06 13:45:55', '2017-10-23 17:45:49'),
(7, 'Uber Circle Check 2', 5, '2017-10-07 23:34:13', '2017-10-07 23:36:04'),
(8, 'Daily Vehicle Check', 7, '2017-10-08 08:06:59', '2017-10-08 08:06:59'),
(9, 'FLT Daily Check', 7, '2017-10-08 15:36:55', '2017-10-08 15:36:55'),
(10, 'FLT Inspection', 6, '2017-10-08 17:09:46', '2017-10-08 17:09:46'),
(11, 'lukes Inspection', 7, '2017-10-20 11:12:29', '2017-10-20 11:12:50');

-- --------------------------------------------------------

--
-- Table structure for table `inspection_template_items`
--

CREATE TABLE IF NOT EXISTS `inspection_template_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `template_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `inspection_template_items`
--

INSERT INTO `inspection_template_items` (`id`, `name`, `visible`, `template_id`, `created_at`) VALUES
(1, 'Tyres', 1, 1, '2017-08-21 07:38:08'),
(2, 'Mirrors', 1, 1, '2017-08-21 07:38:08'),
(3, 'Engine', 1, 1, '2017-08-21 07:38:08'),
(9, 'Headlights', 0, 3, '2017-09-30 19:49:31'),
(10, 'Braklelights', 1, 3, '2017-09-30 19:49:31'),
(11, 'Treads', 1, 3, '2017-09-30 19:49:31'),
(12, 'Streering', 1, 3, '2017-09-30 19:49:31'),
(13, 'Seats', 1, 3, '2017-09-30 19:49:31'),
(14, 'Oil Level', 1, 3, '2017-09-30 19:49:31'),
(15, 'Mirrors1', 1, 3, '2017-09-30 19:52:53'),
(18, 'Engine', 0, 3, '2017-10-01 09:36:17'),
(19, 'Headlights', 0, 6, '2017-10-06 13:45:55'),
(20, 'tyres', 1, 6, '2017-10-06 13:45:55'),
(21, 'door', 1, 6, '2017-10-06 13:45:55'),
(22, 'Windshield', 0, 7, '2017-10-07 23:34:13'),
(23, 'Tires', 0, 7, '2017-10-07 23:35:36'),
(24, 'Seatbelts', 0, 7, '2017-10-07 23:35:36'),
(25, 'Headlights', 1, 7, '2017-10-07 23:35:36'),
(26, 'Break lights', 1, 7, '2017-10-07 23:35:36'),
(27, 'Hazzards', 1, 7, '2017-10-07 23:35:36'),
(28, 'Wipers', 1, 7, '2017-10-07 23:35:36'),
(29, 'Tyre tread', 1, 8, '2017-10-08 08:06:59'),
(30, 'Windscreen Condition', 1, 8, '2017-10-08 08:06:59'),
(31, 'Oil Level', 1, 8, '2017-10-08 08:06:59'),
(32, 'Brake Lights', 1, 8, '2017-10-08 08:06:59'),
(33, 'Headlights', 1, 8, '2017-10-08 08:06:59'),
(34, 'Horn', 1, 8, '2017-10-08 08:06:59'),
(35, 'Washer Fluid Level', 1, 8, '2017-10-08 08:06:59'),
(36, 'Seatbelts', 1, 8, '2017-10-08 08:06:59'),
(37, 'Handbrake', 1, 8, '2017-10-08 08:06:59'),
(38, 'Reg Visibility', 1, 8, '2017-10-08 08:06:59'),
(39, 'Horn', 1, 9, '2017-10-08 15:36:55'),
(40, 'Reversing beepers', 1, 9, '2017-10-08 15:36:55'),
(41, 'Mirrors', 1, 9, '2017-10-08 15:36:55'),
(42, 'Seat Pressure cut off', 1, 9, '2017-10-08 15:36:55'),
(43, 'Seatbelt', 1, 9, '2017-10-08 15:36:55'),
(44, 'Lights', 1, 9, '2017-10-08 15:36:55'),
(45, 'Load Alarm', 1, 9, '2017-10-08 15:36:55'),
(46, 'Forks', 1, 10, '2017-10-08 17:09:46'),
(47, 'Lifting equip', 1, 10, '2017-10-08 17:09:46'),
(48, 'boot', 1, 6, '2017-10-15 17:40:35'),
(49, 'windscreen ', 1, 11, '2017-10-20 11:12:50'),
(50, 'washer fluid', 1, 11, '2017-10-20 11:12:50');

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `push_notifications` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `driver_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`id`, `push_notifications`, `driver_id`) VALUES
(1, 'Yes', 4),
(2, 'Yes', 5),
(3, 'Yes', 2),
(4, 'Yes', 6),
(5, 'Yes', 49),
(6, 'Yes', 53),
(7, 'Yes', 54),
(8, 'Yes', 63),
(9, 'Yes', 66),
(10, 'Yes', 70),
(11, 'Yes', 76),
(12, 'Yes', 78),
(13, 'Yes', 83);

-- --------------------------------------------------------

--
-- Table structure for table `reset_request_token`
--

CREATE TABLE IF NOT EXISTS `reset_request_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `expiry` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `reset_request_token`
--

INSERT INTO `reset_request_token` (`id`, `token`, `driver_id`, `expiry`, `created_at`) VALUES
(1, 'HbaCxiOcPL~PaMTWQCTST5nGp4Ydnzu7mgCFk24~54', 54, '2017-10-03 12:16:23', '2017-10-03 11:06:23'),
(2, 'HT0sCSKPgDnH_TYj6VNFZ7NceZv2U0B1qiXPrn0E54', 54, '2017-10-03 12:21:07', '2017-10-03 11:11:07'),
(3, 'wtDy3Zl2OTFjOWmVLiRRRYQ5CbmUWUkPqZY9J3c766', 66, '2017-10-06 16:53:56', '2017-10-06 15:43:56'),
(4, 'Pcs~B8QkVZ2Bob9F9P2esA5TllKJUeCaeB0E_qy866', 66, '2017-10-15 14:51:13', '2017-10-15 13:41:13');

-- --------------------------------------------------------

--
-- Table structure for table `trailer_checklist_fleet`
--

CREATE TABLE IF NOT EXISTS `trailer_checklist_fleet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `fleetmanager_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `trailer_checklist_fleet`
--

INSERT INTO `trailer_checklist_fleet` (`id`, `item_name`, `fleetmanager_id`) VALUES
(1, 'Wheels/ Tyres', 1),
(2, 'Wheel Nuts', 1),
(3, 'Handbrake & Cable', 1),
(4, 'Electric Coupling', 1),
(5, 'Air Couplings', 1),
(6, 'Brakes', 1),
(7, 'Suspension', 1),
(8, 'Mudguards', 1),
(9, 'Sideguards', 1),
(10, 'Rear Under Bar', 1),
(11, 'Floor/ Bodywork', 1),
(12, 'Security ', 1),
(13, 'security of load', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_device`
--

CREATE TABLE IF NOT EXISTS `user_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_name` varchar(255) NOT NULL,
  `device_token` varchar(255) NOT NULL,
  `device_type` enum('iOS','Android') NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `user_device`
--

INSERT INTO `user_device` (`id`, `device_name`, `device_token`, `device_type`, `user_id`) VALUES
(1, 'iPhone', 'CF90DFCC97A3937918DEC37D3242C903BD59EB2CCC0F4F11588518921986BD9A', 'iOS', 4),
(2, 'iPhone', '7E5E660444F5AE193DC4289DCAACAC0AEE88ADE9CEEF873C4D69BB61EA4B6E03', 'iOS', 5),
(3, 'iPhone', '2D6F50EEE16D74BA615479E8FE1494F2369C1F63B23F69E1702D47B036267E10', 'iOS', 2),
(4, 'iPhone', '15E84F9009CF0BD32F019528BE72C990C529E1F3D3FEB97B5DD2E8DE6CF85F7C', 'iOS', 5),
(5, 'TGH', 'C36B829764B2B922B0A520B5A5DB555BED61DDBF98C914B0268A5DE30A2A0371', 'iOS', 49),
(6, 'iPhone', '74520BBD8156F7C74D28B8A3000CF0D279F4C4C9A6F0DFDA4117E7DB8B358F94', 'iOS', 6),
(7, 'iPhone', '135B162DF9DFA54F0230B5A0D820B8492B117F83B2819130D64E0A5334C61E0C', 'iOS', 4),
(8, 'iPhone', '0A736094A03C5FA9D62E7336967C35D1FAC0A8E63921CC0C75A6F5AC399EF084', 'iOS', 4),
(9, 'iPhone', '521A6450A02461554F0CF71C20936FE6B7C9D32FF15045EDC736D89B05CE9150', 'iOS', 4),
(10, 'iPhone', '8C6053F5A54559E6DFBA7F5E64723BF3CEE96A1F20192996C4FE4B11542FC728', 'iOS', 4),
(11, 'iPhone', 'F8AB3C8FCDBF7766D8607CCFFC7AA6FAE7103DFC8926767459052BBF528BB84F', 'iOS', 4),
(12, 'iPhone', 'FB72AF70A340C8AA5D208E40DFFD017873EC929DA270F2DA80916BB2D1E6427E', 'iOS', 4),
(13, 'iPhone', '66240EFB7993D18C7158257DC57C28DDD5E934C0D51A23D69CC405402989477D', 'iOS', 4),
(14, 'iPhone', '201DD19B3995156CE22CE1F23740908F6A79AEA3E7C0825F4BE7123CAB5561DB', 'iOS', 4),
(15, 'iPhone', 'C65BAFE9F980D598BC0029844ECA2E4CBD7C3C0F544FBF776F284F0462BC0C94', 'iOS', 4),
(16, 'iPhone', '9EAC06EF75A2DFC595D895CFBE4F886C59E68F511DFCAB7E3ED3ECC6CD5E40DD', 'iOS', 4),
(17, 'iPhone', 'C5AF5E0B80FF40FB9E97AEA52596EBB5A39D47A799279D7D549B33A70F397060', 'iOS', 4),
(18, 'iPhone', 'DCA6E96D83DB7A52C63B3637D2525B71090458B6D084214120D6A522F72A907D', 'iOS', 4),
(19, 'iPhone', 'DCA3F58C38B8FF5E33B626743A3EDFB4779312722FE1A311DCDBE5314C900F1B', 'iOS', 4),
(20, 'iPhone', 'D8CFE4611A19DE49743F06DC7779B0B361FE58C0915F417B6D0C1FA025846471', 'iOS', 4),
(21, 'iPhone', '2E710763F7D34F560EF17ED01D0D18F8BE6C6E24B01A98EA13C7531FFA147FFE', 'iOS', 4),
(22, 'iPhone', '0EEF575DB934EB774BE2D2D8ED96307DFB4E44912E2CCA1768E348E6F6EE9FB5', 'iOS', 54),
(23, 'iPhone', '3BFB4E133EEFA1D1C4049629DBB9F15E02A089E679C48D9DF1DCFEE9E8A6C6D8', 'iOS', 4),
(24, 'iPhone', 'BFA25099CB55542FA506539F00C63253C02DCEF5B1AD651E26AA3021828B6FCC', 'iOS', 54),
(25, 'iPhone', '7CFF73ED30B6FC75C06D08568B0AF74F766227CE61DC7114EF0567701F8BCC9A', 'iOS', 54),
(26, 'iPhone', '74360C7D2C1F6EEC5498E4B7A91CF1F48E26CB884AB682727602810D60CDCC7B', 'iOS', 63),
(27, 'iPhone', '12D4EE641E231607F156E688197A8E9731E98379CB3F752317AF77E9D48C8A5E', 'iOS', 54),
(28, 'iPhone', 'A78939BA8B84E209866164294D76B3E7B8947ACFCDC5AE1938F01B4D3B01AC87', 'iOS', 54),
(29, 'iPhone', '98E39A7E47DCBB03378CB8585CFAEADD0A812197C70B85FD92D31B64995DBDC4', 'iOS', 66),
(30, 'iPhone', 'E80278F32EF67DEFCB63A8CA33D67FF04B91919A93097E038769ABD64BF465D5', 'iOS', 66),
(31, 'iPhone', 'F48842ACE8CFC8ECA8D9362B44995F33FF8D585DC2F851585DB6D579D668C1CF', 'iOS', 66),
(32, 'TGH', '7ADDB7D3B2922A253A99CB03EBDD2EEAD27DE8BD77F45ECDF7448F62B37105CD', 'iOS', 70),
(33, 'Andrew’s iPhone', 'A0D50F09563D07D191C8D3CE597DA6D216B13DF75FE57FDC35A8D62A18BC5603', 'iOS', 76),
(34, 'iPhone', '7CF5F077914F8300E0BF0D2B345A4A4BE1B854FC54437F49CB61D42D68A0A20D', 'iOS', 78),
(35, 'iPhone', '33DFEC8899E323A4F0FD604B009EC746F817F268B8E3500B94F439D28C71E7F2', 'iOS', 66),
(36, 'iPhone', 'ACB04B2B377CD8B3112D010B528CB463F3429C637ED6CCEC074031289CCE8131', 'iOS', 66),
(37, 'iPhone', 'C8D0179E9727849616F1142A8DF1CF9BA13F9199BB69786AE2B5B24DFD49DE32', 'iOS', 66),
(38, 'iPhone', 'B2FE1BA76E1A56626A6658C8C448772417DC90FCA5029297FBEDB5F9F536229F', 'iOS', 66),
(39, 'iPhone', '75D77C3EB469E9A056F180E2BC871CFDAC7798DABFAC94BAD97D509904BAF8F0', 'iOS', 66),
(40, 'iPhone', '164419358207E1D6039C79D1EFCA91AC869F889E71D9CBC9A3406FAA6545157F', 'iOS', 66),
(41, 'iPhone', '37BDCC78A447C12B5E1389D0B1CDBF71F32F05D53D675B36128DB33EB9816126', 'iOS', 66);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fleetmanager_id` int(11) NOT NULL,
  `vehicle_reg` varchar(255) NOT NULL,
  `make` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `vehicle_type` varchar(255) DEFAULT 'Car',
  `serial_number` varchar(255) DEFAULT NULL,
  `gross_vehicle_weight` varchar(255) DEFAULT NULL,
  `next_mot` varchar(255) DEFAULT NULL,
  `tax_expires` varchar(255) DEFAULT NULL,
  `inspection_template_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `fleetmanager_id`, `vehicle_reg`, `make`, `model`, `vehicle_type`, `serial_number`, `gross_vehicle_weight`, `next_mot`, `tax_expires`, `inspection_template_id`) VALUES
(1, 1, 'KR63 YKG', 'Volvo', 'XC60', 'Car', '123', '12 Tonne', '2017-12-23', '2018-01-12', 3),
(2, 1, 'GAY 8OY', 'Fiat ', '500', 'Car', '', '', '2017-09-20', '2017-11-02', 3),
(3, 1, '5EXY', 'Rangerover', 'Sport HSE ', 'Car', '', '', '', '', 1),
(4, 1, 'FR56 HGY', 'citroen', 'Berlingo', 'Car', '', '', NULL, NULL, 3),
(5, 2, 'KR63 YKG', 'Volvo', 'XC60', 'Car', 'N/A', '1tonne', '2017-07-22', '2017-07-31', NULL),
(6, 1, 'Registration', 'Make', 'Model', 'Car', 'Serial', 'Weight', NULL, NULL, NULL),
(7, 1, 'EH4PML1', 'Mercedes', 'S-Type', 'Car', '6522235411', '1500', '2018-12-04', '', 3),
(8, 1, 'EH4PML2', 'Landrover', 'R-Type', 'Car', '6522235511', '1600', '2017-05-12', '', NULL),
(9, 1, 'EH4PML3', 'Honda', 'Van', 'Car', '6522235611', '1700', '2017-09-12', NULL, NULL),
(10, 1, 'EH4PML4', 'Lincoln', 'Truck', 'Car', '6522235713', '5000', '2017-10-12', NULL, NULL),
(11, 1, 'EH4PML5', 'Nissan', 'Truck', 'Car', '652223581hy', '20000', '2018-02-06', '', NULL),
(12, 1, 'EH4PML6', 'Nissan', 'Truck', 'Car', '65222359as', '65000', '2018-02-06', NULL, NULL),
(13, 1, 'EH4PML7', 'Mercedes', 'Truck', 'Car', '652223601321', '2', '2018-02-06', NULL, NULL),
(14, 1, 'EH4PML8', 'Holden', 'Truck', 'Car', '6522236111', '4', '2018-02-06', NULL, NULL),
(15, 1, 'EH4PML9', 'Fiat', 'Truck', 'Car', '6522236211', '66', '2018-02-06', NULL, NULL),
(16, 1, 'EH4PML10', 'Dodge', 'Van', 'Car', '6522236311', '6.6', '2017-09-12', NULL, NULL),
(17, 1, 'EH4PML11', 'Ford', 'Van', 'Car', '6522236411', '4.2', '2017-09-12', NULL, NULL),
(18, 1, 'EH4PML12', 'Mercedes', 'Van', 'Car', '6522236511', '1255', '2017-09-12', NULL, NULL),
(19, 1, 'EH4PML13', 'Landrover', 'Van', 'Car', '6522236611', '25454', '2017-09-12', NULL, NULL),
(20, 1, 'EH4PML14', 'Landrover', 'Van', 'Car', '6522236711', '1500', '2017-05-12', NULL, NULL),
(21, 1, 'EH4PML15', 'Honda', 'Van', 'Car', '6522236811', '1500', '2017-05-12', NULL, NULL),
(22, 1, 'EH4PML16', 'Nissan', 'Van', 'Car', '6522236911', '1500', '2017-05-12', NULL, NULL),
(23, 1, 'EH4PML17', 'Nissan', 'Van', 'Car', '6522237011', '1500', '2018-04-12', NULL, NULL),
(24, 1, 'EH4PML18', 'Fiat', 'Car', 'Car', '6522237111', '1500', '2018-04-12', NULL, NULL),
(25, 1, 'EH4PML19', 'Dodge', 'Car', 'Car', '6522237211', '1500', '2018-04-12', NULL, NULL),
(26, 1, 'EH4PML20', 'Dodge', 'Car', 'Car', '6522237311', '1500', '2018-04-12', NULL, NULL),
(27, 1, 'SO64 FGH', 'Mercedes', 'T-Type', 'Car', '554111s5', '2.2', NULL, NULL, NULL),
(28, 1, 'MK123', 'Ford', 'Kuga', 'Car', '', '', '', '2018-01-21', NULL),
(29, 3, 'FR56 HGY', 'Scania', 'Rigid Body', 'Car', '', '44 tonne', '2017-11-10', '2017-11-16', 6),
(30, 3, 'SO64 FGH', 'BMW', 'X5', 'Car', '', '20 Tonne', '2017-12-29', '2018-01-18', 6),
(31, 3, 'ye56 hlx', 'Ford', 'Kuga', 'Car', '', '21 Tonne', '2017-08-08', '2017-08-07', 6),
(32, 6, 'FR56 HGY', 'Scania', 'Rigid Body', 'Car', NULL, '44 tonne', '2018-09-25', '2017-09-25', NULL),
(33, 6, 'YS65DUU', 'Ford', 'Focus', 'Car', '12345', '12 tonne', '2019-07-25', '2018-12-01', NULL),
(34, 6, 'FR56 HGY', 'Nissan', 'Leaf', 'Car', NULL, '2 tonne', '2018-01-01', '2018-01-21', NULL),
(35, 6, 'MK121', 'Ford', 'Kuga', 'Car', '', '2 tonne', '2019-04-09', '2018-01-21', 10),
(36, 6, 'KR63YKG', 'Volvo', 'XC60', 'Car', NULL, '3 tonne', '2018-06-05', '2018-10-05', NULL),
(37, 5, 'BRMX221', 'Audi', 'A4', 'Car', '', '', '1970-01-01', '1970-01-01', 7),
(38, 5, 'FR56 HGY', 'Scania', 'Rigid Body', 'Car', '6545343', '44 tonne', '2017-09-25', '2018-09-25', 7),
(39, 5, 'FR56 HG2', 'Nissan', 'Leaf', 'Car', '12345', '12 tonne', '2019-07-25', '2018-09-26', 7),
(40, 5, 'FR56 HGY', 'Scania', 'Rigid Body', 'Car', '5432er', NULL, '2019-07-26', '2018-09-27', NULL),
(41, 7, 'KR63 YKG', 'Volvo', 'XC60', 'Car', '', '2300', '1970-01-01', '1970-01-01', 11),
(42, 7, 'FP65 LYP', 'Ford', 'Transit', 'Van', '', '3,500KG', '2017-12-01', '2018-01-01', 8),
(43, 7, 'AUT 01', 'Scania', 'Rigid', 'Car', '', '44,000KG', '2018-06-28', '2018-03-18', 8),
(44, 7, 'AUT 02', 'Nissan', 'Navara', 'Van', '', '2,800KG', '2018-03-14', '2017-12-05', 8),
(45, 7, 'AUT 03', 'Yamaha', 'FLT', 'S-Type', 'YH45657799', '1,200KG', '2017-10-08', '2017-10-08', 9),
(46, 3, 'PK121', 'Ford', 'Kuga', 'Car', '', '', '', '2018-01-21', NULL),
(47, 3, 'PX121', 'Ford', 'Kuga', 'Truck', NULL, NULL, NULL, '2018-01-21', NULL),
(48, 3, '676AA', 'HONDA', 'CIVIC', 'Car', '78989', '900', '1970-01-01', '2017-08-12', NULL),
(49, 3, 'so65 gbn', 'Nissan', 'Qasqai', 'Car', '12345', '12 tonn', '1970-01-01', '1970-01-01', 6);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_driver`
--

CREATE TABLE IF NOT EXISTS `vehicle_driver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicledriver_fkey` (`vehicle_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=892 ;

--
-- Dumping data for table `vehicle_driver`
--

INSERT INTO `vehicle_driver` (`id`, `vehicle_id`, `driver_id`) VALUES
(7, 5, 5),
(11, 8, 49),
(12, 11, 49),
(82, 26, 53),
(94, 8, 4),
(101, 8, 2),
(388, 4, 1),
(389, 4, 2),
(390, 4, 3),
(391, 4, 4),
(392, 4, 5),
(393, 4, 6),
(394, 4, 7),
(395, 4, 8),
(396, 4, 9),
(397, 4, 10),
(398, 4, 11),
(399, 4, 12),
(400, 4, 13),
(401, 4, 14),
(402, 4, 15),
(403, 4, 16),
(404, 4, 17),
(405, 4, 18),
(406, 4, 19),
(407, 4, 20),
(408, 4, 21),
(409, 4, 22),
(410, 4, 23),
(411, 4, 24),
(412, 4, 25),
(413, 4, 26),
(414, 4, 27),
(415, 4, 28),
(416, 4, 29),
(417, 4, 30),
(418, 4, 31),
(419, 4, 32),
(420, 4, 33),
(421, 4, 34),
(422, 4, 35),
(423, 4, 36),
(424, 4, 37),
(425, 4, 38),
(426, 4, 39),
(427, 4, 40),
(428, 4, 41),
(429, 4, 42),
(430, 4, 43),
(431, 4, 44),
(432, 4, 45),
(433, 4, 46),
(434, 4, 47),
(435, 4, 48),
(436, 4, 49),
(437, 4, 50),
(438, 4, 51),
(439, 4, 52),
(440, 4, 53),
(495, 27, 1),
(496, 27, 4),
(497, 27, 53),
(501, 7, 6),
(528, 4, 54),
(529, 6, 54),
(530, 11, 54),
(531, 18, 54),
(532, 20, 54),
(533, 24, 54),
(534, 27, 54),
(574, 4, 63),
(575, 1, 4),
(576, 1, 53),
(577, 1, 54),
(578, 1, 63),
(582, 2, 1),
(583, 2, 2),
(584, 2, 3),
(585, 2, 4),
(586, 2, 5),
(587, 2, 6),
(588, 2, 7),
(589, 2, 8),
(590, 2, 9),
(591, 2, 10),
(592, 2, 11),
(593, 2, 12),
(594, 2, 13),
(595, 2, 14),
(596, 2, 15),
(597, 2, 16),
(598, 2, 17),
(599, 2, 18),
(600, 2, 19),
(601, 2, 20),
(602, 2, 21),
(603, 2, 22),
(604, 2, 23),
(605, 2, 24),
(606, 2, 25),
(607, 2, 26),
(608, 2, 27),
(609, 2, 28),
(610, 2, 29),
(611, 2, 30),
(612, 2, 31),
(613, 2, 32),
(614, 2, 33),
(615, 2, 34),
(616, 2, 35),
(617, 2, 36),
(618, 2, 37),
(619, 2, 38),
(620, 2, 39),
(621, 2, 40),
(622, 2, 41),
(623, 2, 42),
(624, 2, 43),
(625, 2, 44),
(626, 2, 45),
(627, 2, 46),
(628, 2, 47),
(629, 2, 48),
(630, 2, 49),
(631, 2, 50),
(632, 2, 51),
(633, 2, 52),
(634, 2, 53),
(635, 2, 54),
(636, 2, 63),
(666, 3, 1),
(667, 3, 2),
(668, 3, 3),
(669, 3, 4),
(670, 3, 6),
(671, 3, 7),
(672, 3, 8),
(673, 3, 9),
(674, 3, 10),
(675, 3, 11),
(676, 3, 31),
(677, 3, 32),
(678, 3, 33),
(679, 3, 34),
(680, 3, 35),
(681, 3, 36),
(682, 3, 37),
(683, 3, 38),
(684, 3, 39),
(685, 3, 40),
(686, 3, 41),
(687, 3, 42),
(688, 3, 43),
(689, 3, 44),
(690, 3, 45),
(691, 3, 46),
(692, 3, 47),
(693, 3, 48),
(694, 3, 49),
(695, 3, 50),
(696, 3, 51),
(697, 3, 52),
(698, 3, 53),
(699, 3, 54),
(700, 32, 67),
(701, 33, 67),
(702, 34, 67),
(704, 36, 67),
(705, 32, 68),
(706, 33, 68),
(707, 34, 68),
(709, 36, 68),
(710, 32, 69),
(711, 33, 69),
(712, 34, 69),
(714, 36, 69),
(715, 32, 70),
(716, 33, 70),
(717, 34, 70),
(719, 36, 70),
(720, 32, 71),
(721, 33, 71),
(722, 34, 71),
(724, 36, 71),
(725, 38, 72),
(726, 38, 73),
(728, 38, 75),
(729, 38, 76),
(730, 38, 77),
(731, 37, 72),
(732, 37, 73),
(734, 37, 75),
(735, 37, 76),
(736, 37, 77),
(737, 39, 73),
(739, 39, 75),
(767, 45, 79),
(768, 45, 80),
(769, 45, 81),
(770, 45, 82),
(771, 44, 81),
(772, 44, 82),
(774, 42, 79),
(775, 42, 80),
(776, 42, 81),
(777, 42, 82),
(778, 37, 74),
(779, 38, 74),
(780, 39, 74),
(781, 40, 74),
(782, 35, 67),
(783, 35, 68),
(784, 35, 69),
(785, 35, 70),
(786, 35, 71),
(787, 29, 64),
(817, 29, 83),
(854, 49, 64),
(855, 49, 65),
(857, 49, 83),
(859, 42, 78),
(860, 43, 78),
(861, 45, 78),
(862, 41, 78),
(863, 41, 79),
(876, 31, 84),
(877, 46, 84),
(878, 47, 84),
(879, 48, 84),
(880, 47, 85),
(881, 29, 86),
(882, 30, 86),
(883, 31, 86),
(884, 46, 86),
(885, 47, 86),
(886, 48, 86),
(887, 49, 86),
(888, 29, 66),
(889, 31, 66),
(890, 46, 66),
(891, 47, 66);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_inspection`
--

CREATE TABLE IF NOT EXISTS `vehicle_inspection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) DEFAULT NULL,
  `driver_id` int(11) NOT NULL,
  `inspection_type` enum('Daily','Quarterly','Trailer') NOT NULL DEFAULT 'Daily',
  `notification_date` datetime DEFAULT NULL,
  `submitted_date` datetime DEFAULT NULL,
  `due_date` date NOT NULL,
  `status` enum('Pending','Completed') NOT NULL,
  `directory_name` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `notes` text,
  `vehicle_reg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_id` (`vehicle_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `vehicle_inspection`
--

INSERT INTO `vehicle_inspection` (`id`, `vehicle_id`, `driver_id`, `inspection_type`, `notification_date`, `submitted_date`, `due_date`, `status`, `directory_name`, `image1`, `image2`, `notes`, `vehicle_reg`) VALUES
(1, NULL, 4, 'Trailer', NULL, '2017-07-12 19:26:26', '2017-07-12', 'Completed', NULL, NULL, NULL, NULL, 'FR16738'),
(2, NULL, 2, 'Trailer', NULL, '2017-07-14 14:06:13', '2017-07-14', 'Completed', NULL, NULL, NULL, NULL, 'TEST '),
(3, 4, 6, 'Daily', NULL, '2017-07-18 22:37:35', '2017-07-18', 'Completed', NULL, NULL, NULL, NULL, NULL),
(4, 1, 4, 'Daily', NULL, '2017-07-24 18:42:23', '2017-07-24', 'Completed', NULL, NULL, NULL, NULL, NULL),
(5, 1, 4, 'Daily', NULL, '2017-07-24 20:16:45', '2017-07-24', 'Completed', NULL, NULL, NULL, NULL, NULL),
(6, 4, 6, 'Daily', NULL, '2017-07-30 11:48:34', '2017-07-30', 'Completed', NULL, NULL, NULL, NULL, NULL),
(7, NULL, 6, 'Trailer', NULL, '2017-07-30 11:49:07', '2017-07-30', 'Completed', NULL, NULL, NULL, NULL, 'FDFDSFF'),
(8, 1, 6, 'Daily', NULL, NULL, '2017-08-19', 'Completed', NULL, NULL, NULL, NULL, NULL),
(9, 1, 6, 'Daily', NULL, NULL, '2017-08-19', 'Completed', NULL, NULL, NULL, NULL, NULL),
(10, 4, 6, 'Daily', NULL, '2017-08-19 06:06:38', '2017-08-19', 'Completed', NULL, NULL, NULL, NULL, NULL),
(11, 1, 6, 'Daily', NULL, '2017-08-19 10:10:33', '2017-08-19', 'Completed', NULL, NULL, NULL, NULL, NULL),
(12, 4, 6, 'Daily', NULL, '2017-08-19 06:12:00', '2017-08-19', 'Completed', NULL, NULL, NULL, NULL, NULL),
(13, 4, 6, 'Daily', NULL, '2017-08-21 21:22:29', '2017-08-19', 'Completed', NULL, NULL, NULL, NULL, NULL),
(14, 4, 6, 'Daily', NULL, '2017-08-19 19:47:46', '2017-08-19', 'Completed', NULL, NULL, NULL, NULL, NULL),
(15, 4, 6, 'Daily', NULL, '2017-08-19 19:53:14', '2017-08-19', 'Completed', NULL, NULL, NULL, NULL, NULL),
(16, 4, 6, 'Daily', NULL, '2017-08-20 15:01:44', '2017-08-20', 'Completed', NULL, NULL, NULL, NULL, NULL),
(17, 4, 6, 'Daily', NULL, '2017-08-21 14:43:53', '2017-08-21', 'Completed', NULL, NULL, NULL, NULL, NULL),
(18, 1, 6, 'Daily', NULL, '2017-08-26 18:32:30', '2017-08-26', 'Completed', NULL, NULL, NULL, NULL, NULL),
(19, 1, 53, 'Daily', NULL, '2017-08-28 12:28:35', '2017-08-28', 'Completed', NULL, NULL, NULL, NULL, NULL),
(20, 2, 53, 'Daily', NULL, '2017-08-28 13:03:54', '2017-08-28', 'Completed', NULL, NULL, NULL, NULL, NULL),
(21, 3, 4, 'Daily', NULL, '2017-08-29 16:12:50', '2017-08-29', 'Completed', NULL, NULL, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accident`
--
ALTER TABLE `accident`
  ADD CONSTRAINT `accident_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`);

--
-- Constraints for table `accident_media`
--
ALTER TABLE `accident_media`
  ADD CONSTRAINT `accident_media_ibfk_1` FOREIGN KEY (`accident_id`) REFERENCES `accident` (`id`);

--
-- Constraints for table `accident_police`
--
ALTER TABLE `accident_police`
  ADD CONSTRAINT `accident_police_ibfk_1` FOREIGN KEY (`accident_id`) REFERENCES `accident` (`id`);

--
-- Constraints for table `accident_witness`
--
ALTER TABLE `accident_witness`
  ADD CONSTRAINT `accident_witness_ibfk_1` FOREIGN KEY (`accident_id`) REFERENCES `accident` (`id`);

--
-- Constraints for table `driver`
--
ALTER TABLE `driver`
  ADD CONSTRAINT `driver_ibfk_1` FOREIGN KEY (`fleetmanager_id`) REFERENCES `fleetmanager` (`id`);

--
-- Constraints for table `vehicle_driver`
--
ALTER TABLE `vehicle_driver`
  ADD CONSTRAINT `vehicledriver_fkey` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`);

--
-- Constraints for table `vehicle_inspection`
--
ALTER TABLE `vehicle_inspection`
  ADD CONSTRAINT `vehicle_inspection_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
