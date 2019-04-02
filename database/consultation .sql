-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2019 at 11:37 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `consultation`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_appointments` (IN `req_id` INT, IN `Date` DATE, IN `time_start` TIME, IN `time_addStart` TIME, IN `time_addEnd` TIME)  NO SQL
BEGIN
INSERT INTO apointments(Request_id, Date, Time_start, Time_end)VALUES(req_id,Date,ADDTIME(time_start,time_addStart),ADDTIME(time_start,time_addEnd));
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_appointment_by_stud_idate` (IN `stud_id` INT, IN `dates` DATE)  NO SQL
BEGIN
SELECT (SELECT Lastname FROM tblstaff WHERE id IN (SELECT Staff_id FROM staff_schedule st WHERE st.id=r.Sched_id)) as lastname,(SELECT Firstname FROM tblstaff WHERE id IN (SELECT Staff_id FROM staff_schedule st WHERE st.id=r.Sched_id)) as firstname,(SELECT time_format(Time_start,'%I:%i %p') FROM apointments WHERE Request_id=r.id) as time_start,(SELECT time_format(Time_end,'%I:%i %p') FROM apointments WHERE Request_id=r.id) as time_end,(SELECT Status FROM status WHERE id=r.Status_id) as Status FROM request r WHERE r.Student_id=stud_id AND (r.Status_id=1 OR r.Status_id=2 OR r.Status_id=3) AND r.Sched_id IN (SELECT DISTINCT Sched_id FROM date d WHERE d.Sched_date=dates); 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_department` (IN `college_id` INT(11))  BEGIN
	SELECT id,Department FROM department where Collegeid=college_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_apointments_by_id_and_date` (IN `staff_id` INT, IN `date` DATE)  NO SQL
BEGIN
SELECT id,Request_id,Date,date_format(Time_start,'%I:%i %p') as timeStart,date_format(Time_end,'%I:%i %p') as timeEnd,(SELECT Student_id FROM request WHERE id=a.Request_id) as student_id,(SELECT Firstname FROM tblstudent where id IN(SELECT Student_id FROM request WHERE id=a.Request_id)) as studentName,(SELECT Status FROM status where id=1) as Status FROM apointments a WHERE a.Request_id in (SELECT DISTINCT id FROM request r WHERE r.Sched_id IN (SELECT DISTINCT id FROM staff_schedule s WHERE s.Staff_id=staff_id) AND r.Status_id=1) AND a.Date=date;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_date_by_staff_id` (IN `staff_id` INT)  BEGIN
SELECT id,(select Sched_date FROM date d where d.id=s.Date_id) as Dates,(select date_format(d.Time_start,'%I:%i %p') FROM date d where d.id=s.Date_id) as time_start,(select date_format(d.Time_end,'%I:%i %p') FROM date d where d.id=s.Date_id) as time_end FROM staff_schedule s WHERE s.Staff_id=staff_id ORDER BY Dates;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_request_by_id_and_status` (IN `staff_id` INT, IN `status_id` INT)  NO SQL
BEGIN
SELECT id,Student_id,(SELECT Firstname FROM tblstudent WHERE id=r.Student_id) as Student_Name,Reason,(SELECT date_format(Sched_date,'%M %d,%Y') FROM date where Sched_id=r.Sched_id) as Date,(SELECT date_format(Time_start,'%I:%i %p') FROM date where Sched_id=r.Sched_id) as time_start,(SELECT date_format(Time_end,'%I:%i %p') FROM date where Sched_id=r.Sched_id) as time_end FROM request r WHERE r.Status_id=status_id and Sched_id IN (SELECT Sched_id FROM staff_schedule WHERE Staff_id=staff_id) ORDER by id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_sched_by_staff_id_and_date` (IN `staff_id` INT(11), IN `date` DATE)  NO SQL
BEGIN
SELECT Time_start as ts,date_format(Time_start,'%I:%i %p') as Time_start,date_format(Time_end,'%I:%i %p') as Time_end FROM
date d where d.Sched_id IN (SELECT DISTINCT id FROM staff_schedule WHERE Staff_id = staff_id) AND d.Sched_date=date ORDER BY ts;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_staff_by_department` (IN `dept_id` INT)  NO SQL
BEGIN
SELECT * FROM tblstaff s where s.Department=dept_id; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_status_by_staff_id` (IN `staff_id` INT)  NO SQL
BEGIN
SELECT s.id,s.Firstname,s.Middlename,s.Lastname,s.Gender,s.Email,c.Collagename,d.Department FROM tblstaff s JOIN department d ON s.Department=d.id JOIN college c ON d.Collegeid=c.id WHERE s.id=staff_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_status_by_stud_id` (IN `stud_id` INT)  NO SQL
BEGIN
SELECT s.id,s.Firstname,s.Middlename,s.Lastname,s.DoB,s.Gender,s.Email,s.PhoneNumber,c.Collagename,d.Department FROM tblstudent s JOIN department d ON s.Department=d.id JOIN college c ON d.Collegeid=c.id WHERE s.id=stud_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_studlimit_and_studsched` (IN `req_id` INT)  NO SQL
BEGIN
SELECT (SELECT Sched_date FROM date WHERE Sched_id=r.Sched_id) as Date,(SELECT Time_start FROM date WHERE Sched_id=r.Sched_id) as Time_start,(SELECT Student_Limit FROM staff_schedule WHERE id=r.Sched_id) as Student_limit,(select count(id) FROM request where Sched_id=r.Sched_id and Status_id=1) as numres FROM request r WHERE r.id=req_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_time_by_dateandstaffid` (IN `staff_id` INT, IN `sDate` DATE)  NO SQL
BEGIN
SELECT id,(select Sched_date FROM date d where d.id=s.Date_id) as Dates,(select date_format(d.Time_start,'%I:%i %p') FROM date d where d.id=s.Date_id) as time_start,(select date_format(d.Time_end,'%I:%i %p') FROM date d where d.id=s.Date_id) as time_end FROM staff_schedule s WHERE s.Staff_id=staff_id AND s.Date_id IN (SELECT DISTINCT id FROM date where Sched_date=sDate) ORDER BY time_start;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Usertype` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `Username`, `Password`, `Usertype`, `Status`) VALUES
(17, 'ianrey258', 'qweqwe', 2, 1),
(18, 'iraian', 'qweqwe', 1, 1),
(19, 'ianrey147', 'qweqwe', 1, 1),
(20, 'Christian', '123456', 2, 1),
(21, 'etorma25', '111111', 2, 1),
(24, 'staff', '123456', 1, 1);

--
-- Triggers `accounts`
--
DELIMITER $$
CREATE TRIGGER `add_id_to_users` AFTER INSERT ON `accounts` FOR EACH ROW BEGIN
IF(NEW.Usertype='1')THEN
INSERT INTO tblstaff(Accountid)VALUES(NEW.id);
ELSEIF(NEW.Usertype='2')THEN
INSERT INTO tblstudent(Accountid)VALUES(NEW.id);
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accstatus`
--

CREATE TABLE `accstatus` (
  `id` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accstatus`
--

INSERT INTO `accstatus` (`id`, `Status`) VALUES
(1, 'Active'),
(2, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `apointments`
--

CREATE TABLE `apointments` (
  `id` int(11) NOT NULL,
  `Request_id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time_start` time NOT NULL,
  `Time_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apointments`
--

INSERT INTO `apointments` (`id`, `Request_id`, `Date`, `Time_start`, `Time_end`) VALUES
(1, 4, '2019-03-28', '13:45:00', '14:00:00'),
(2, 6, '2019-03-28', '14:00:00', '14:15:00'),
(3, 5, '2019-03-28', '13:30:00', '13:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `id` int(11) NOT NULL,
  `Collagename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`id`, `Collagename`) VALUES
(1, 'College of Engineering and Architecture'),
(2, 'College of Information Technology and Computing'),
(3, 'College of Science and Mathematics'),
(4, 'College of Science and Technology Education'),
(5, 'College of Technology');

-- --------------------------------------------------------

--
-- Table structure for table `date`
--

CREATE TABLE `date` (
  `id` int(11) NOT NULL,
  `Sched_id` int(11) NOT NULL,
  `Sched_date` date DEFAULT NULL,
  `Time_start` time DEFAULT NULL,
  `Time_end` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `date`
--

INSERT INTO `date` (`id`, `Sched_id`, `Sched_date`, `Time_start`, `Time_end`) VALUES
(12, 22, '2019-03-15', '14:45:00', '16:30:00'),
(13, 23, '2019-03-16', '14:00:00', '16:00:00'),
(14, 24, '2019-03-10', '14:00:00', '15:00:00'),
(15, 25, '2019-03-15', '14:00:00', '17:00:00'),
(16, 26, '2019-03-25', '14:45:00', '15:00:00'),
(17, 27, '2019-03-28', '13:30:00', '15:00:00'),
(18, 28, '2019-04-02', '13:30:00', '16:00:00'),
(19, 29, '2019-04-03', '07:00:00', '09:00:00'),
(20, 30, '2019-04-03', '14:00:00', '14:30:00'),
(21, 31, '2019-04-03', '10:35:00', '11:00:00'),
(22, 32, '2019-04-03', '08:00:00', '10:30:00'),
(23, 33, '2019-04-04', '14:00:00', '16:30:00');

--
-- Triggers `date`
--
DELIMITER $$
CREATE TRIGGER `add_sched` AFTER UPDATE ON `date` FOR EACH ROW BEGIN
DECLARE limits,x,y int;
SET x=(date_format(NEW.Time_end,'%h')-date_format(NEW.Time_start,'%h'))*60+(date_format(NEW.Time_start,'%i')+date_format(NEW.Time_end,'%i'));
SET limits=0;SET y=0;

counting: LOOP
IF y<x THEN
	SET y=y+15;
    SET limits=limits + 1;
	ITERATE counting;
	END IF;
LEAVE counting;
END LOOP;
UPDATE staff_schedule s SET s.Student_Limit=limits,s.Date_id=new.id WHERE s.id = NEW.Sched_id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Collegeid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `Department`, `Collegeid`) VALUES
(1, 'DEPARTMENT OF ARCHITECTURE', 1),
(2, 'DEPARTMENT OF CIVIL ENGINEERING\r\n', 1),
(3, 'DEPARTMENT OF ELECTRONICS ENGINEERING\r\n', 1),
(4, 'DEPARTMENT OF ELECTRICAL ENGINEERING\r\n', 1),
(5, 'DEPARTMENT OF MECHANICAL ENGINEERING\r\n', 1),
(6, 'DEPARTMENT OF COMPUTER ENGINEERING\r\n', 2),
(7, 'DEPARTMENT OF INFORMATION TECHNOLOGY\r\n', 2),
(8, 'DEPARTMENT OF TECHNOLOGY COMMUNICATION MANAGEMENT\r\n', 2),
(9, 'DEPARTMENT OF MATHEMATICAL SCIENCES\r\n', 3),
(10, 'DEPARTMENT OF CHEMISTRY\r\n', 3),
(11, 'DEPARTMENT OF ENVIRONMENTAL SCIENCE AND TECHNOLOGY\r\n', 3),
(12, 'DEPARTMENT OF BIOLOGY\r\n', 3),
(13, 'DEPARTMENT OF FOOD SCIENCE AND TECHNOLOGY\r\n', 3),
(14, 'DEPARTMENT OF PHYSICS\r\n', 3),
(15, 'COMMUNICATION ARTS, LANGUAGE AND LITERATURE UNIT\r\n', 3),
(16, 'NSTP UNIT\r\n', 3),
(17, 'SOCIAL SCIENCES UNIT\r\n', 3),
(18, 'PERSONALITY DEVELOPMENT/ PHYSICAL EDUCATION UNIT\r\n', 3),
(19, 'DEPARTMENT OF EDUCATION, PLANNING AND MANAGEMENT\r\n', 4),
(20, 'DEPARTMENT OF MATHEMATICS EDUCATION\r\n', 4),
(21, 'DEPARTMENT OF PUBLIC ADMINISTRATION\r\n', 4),
(22, 'DEPARTMENT OF SCIENCE EDUCATION\r\n', 4),
(23, 'DEPARTMENT OF SPECIAL EDUCATION\r\n', 4),
(24, 'DEPARTMENT OF TEACHING LANGUAGES\r\n', 4),
(25, 'DEPARTMENT OF TECHNOLOGY LIVELIHOOD EDUCATION & TECHNICIAN TEACHER EDUCATION\r\n', 4),
(26, 'SENIOR HIGH SCHOOL\r\n', 4),
(27, 'ELECTRO-MECHANICAL TECHNOLOGY\r\n', 5),
(28, 'ELECTRONICS AND COMMUNICATION TECHNOLOGY\r\n', 5),
(29, 'ELECTRICAL AND TECHNOLOGY MANAGEMENT\r\n', 5),
(30, 'AUTOMOTIVE AND MECHANICAL TECHNOLOGY\r\n', 5);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `Student_id` int(11) NOT NULL,
  `Reason` text NOT NULL,
  `Sched_id` int(11) NOT NULL,
  `Status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `Student_id`, `Reason`, `Sched_id`, `Status_id`) VALUES
(4, 3, 'grado', 27, 4),
(5, 4, 'basta lang', 27, 1),
(6, 5, 'try me', 27, 2),
(7, 3, 'wtf', 30, 2),
(8, 3, 'wtf', 30, 2),
(9, 3, 'wtf', 30, 2),
(10, 3, 'hahahh', 30, 3),
(11, 3, 'nyahahah', 30, 2),
(12, 3, 'stormy', 30, 2),
(13, 3, 'wtf', 30, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `show_accounts`
-- (See below for the actual view)
--
CREATE TABLE `show_accounts` (
`id` int(11)
,`Username` varchar(255)
,`Usertype` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `staff_info`
-- (See below for the actual view)
--
CREATE TABLE `staff_info` (
`id` int(11)
,`Firstname` varchar(255)
,`Middlename` varchar(255)
,`Lastname` varchar(255)
,`Gender` enum('Male','Female')
,`Email` varchar(255)
,`Department` varchar(255)
,`Collage` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `staff_schedule`
--

CREATE TABLE `staff_schedule` (
  `id` int(11) NOT NULL,
  `Staff_id` int(11) NOT NULL,
  `Date_id` int(11) DEFAULT NULL,
  `Student_Limit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_schedule`
--

INSERT INTO `staff_schedule` (`id`, `Staff_id`, `Date_id`, `Student_Limit`) VALUES
(22, 16, 12, 13),
(23, 16, 13, 8),
(24, 16, 14, 4),
(25, 16, 15, 12),
(26, 16, 16, 7),
(27, 16, 17, 10),
(28, 17, 18, 14),
(29, 17, 19, 8),
(30, 18, 20, 2),
(31, 18, 21, 7),
(32, 16, 22, 10),
(33, 16, 23, 10);

--
-- Triggers `staff_schedule`
--
DELIMITER $$
CREATE TRIGGER `add_date` AFTER INSERT ON `staff_schedule` FOR EACH ROW BEGIN
	INSERT INTO date(Sched_id)VALUES(NEW.id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `Status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `Status`) VALUES
(1, 'Ongoing'),
(2, 'Postpone'),
(3, 'Decline'),
(4, 'Requesting'),
(5, 'Done');

-- --------------------------------------------------------

--
-- Stand-in structure for view `student_info`
-- (See below for the actual view)
--
CREATE TABLE `student_info` (
`id` int(11)
,`Firstname` varchar(255)
,`Middlename` varchar(255)
,`Lastname` varchar(255)
,`DoB` date
,`Gender` enum('Male','Female')
,`Email` varchar(255)
,`PhoneNumber` bigint(50)
,`Department` varchar(255)
,`College` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `tblstaff`
--

CREATE TABLE `tblstaff` (
  `id` int(11) NOT NULL,
  `Accountid` int(11) NOT NULL,
  `Firstname` varchar(255) DEFAULT NULL,
  `Middlename` varchar(255) DEFAULT NULL,
  `Lastname` varchar(255) DEFAULT NULL,
  `Gender` enum('Male','Female') DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Department` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblstaff`
--

INSERT INTO `tblstaff` (`id`, `Accountid`, `Firstname`, `Middlename`, `Lastname`, `Gender`, `Email`, `Department`) VALUES
(16, 18, 'Ianrey', NULL, 'Acampado', 'Male', 'ianrey147@gmail.com', 2),
(17, 19, 'Ianrey', 'J', 'acampado', 'Male', 'marvinbonani@yahoo.com', 1),
(18, 24, 'staff', 'staff', 'Dagpin', 'Male', 'jcasdasfaSf@gmail.com', 7);

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `id` int(11) NOT NULL,
  `Accountid` int(11) NOT NULL,
  `Firstname` varchar(255) NOT NULL,
  `Middlename` varchar(255) NOT NULL,
  `Lastname` varchar(255) NOT NULL,
  `DoB` date NOT NULL,
  `Gender` enum('Male','Female') NOT NULL,
  `Email` varchar(255) NOT NULL,
  `PhoneNumber` bigint(50) NOT NULL,
  `Department` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`id`, `Accountid`, `Firstname`, `Middlename`, `Lastname`, `DoB`, `Gender`, `Email`, `PhoneNumber`, `Department`) VALUES
(3, 17, 'ianrey', 'J', 'acampado', '1997-07-28', 'Male', 'ianrey_2014@yahoo.com.ph', 935900234, 2),
(4, 20, 'Christian', 'M', 'Balagtas', '2019-12-30', 'Male', 'marvinbonani@yahoo.com', 9752662481, 7),
(5, 21, 'jonathan', 'namata', 'etorma', '2019-12-30', 'Male', 'desabby93@gmail.com', 905833610, 7);

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `id` int(11) NOT NULL,
  `Usertype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`id`, `Usertype`) VALUES
(1, 'Staff'),
(2, 'Student'),
(3, 'Admin');

-- --------------------------------------------------------

--
-- Structure for view `show_accounts`
--
DROP TABLE IF EXISTS `show_accounts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `show_accounts`  AS  select `a`.`id` AS `id`,`a`.`Username` AS `Username`,(select `usertype`.`Usertype` from `usertype` where (`usertype`.`id` = `a`.`Usertype`)) AS `Usertype` from `accounts` `a` order by (select `usertype`.`Usertype` from `usertype` where (`usertype`.`id` = `a`.`Usertype`)) ;

-- --------------------------------------------------------

--
-- Structure for view `staff_info`
--
DROP TABLE IF EXISTS `staff_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `staff_info`  AS  select `s`.`id` AS `id`,`s`.`Firstname` AS `Firstname`,`s`.`Middlename` AS `Middlename`,`s`.`Lastname` AS `Lastname`,`s`.`Gender` AS `Gender`,`s`.`Email` AS `Email`,(select `d`.`Department` from `department` `d` where (`d`.`id` = `s`.`Department`)) AS `Department`,(select `c`.`Collagename` from `college` `c` where `c`.`id` in (select distinct `department`.`Collegeid` from `department` where (`department`.`id` = `s`.`Department`))) AS `Collage` from `tblstaff` `s` ;

-- --------------------------------------------------------

--
-- Structure for view `student_info`
--
DROP TABLE IF EXISTS `student_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `student_info`  AS  select `s`.`id` AS `id`,`s`.`Firstname` AS `Firstname`,`s`.`Middlename` AS `Middlename`,`s`.`Lastname` AS `Lastname`,`s`.`DoB` AS `DoB`,`s`.`Gender` AS `Gender`,`s`.`Email` AS `Email`,`s`.`PhoneNumber` AS `PhoneNumber`,(select `d`.`Department` from `department` `d` where (`d`.`id` = `s`.`Department`)) AS `Department`,(select `c`.`Collagename` from `college` `c` where `c`.`id` in (select distinct `department`.`Collegeid` from `department` where (`department`.`id` = `s`.`Department`))) AS `College` from `tblstudent` `s` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Usertype` (`Usertype`),
  ADD KEY `accounts_ibfk_2` (`Status`);

--
-- Indexes for table `accstatus`
--
ALTER TABLE `accstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apointments`
--
ALTER TABLE `apointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Request_id` (`Request_id`);

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `date`
--
ALTER TABLE `date`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Sched_id` (`Sched_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Collageid` (`Collegeid`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Scedule_id` (`Sched_id`),
  ADD KEY `Student_id` (`Student_id`),
  ADD KEY `Status_id` (`Status_id`);

--
-- Indexes for table `staff_schedule`
--
ALTER TABLE `staff_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Staff_id` (`Staff_id`),
  ADD KEY `Date_id` (`Date_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstaff`
--
ALTER TABLE `tblstaff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Department` (`Department`),
  ADD KEY `Accountid` (`Accountid`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Department` (`Department`),
  ADD KEY `Accountid` (`Accountid`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `accstatus`
--
ALTER TABLE `accstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `apointments`
--
ALTER TABLE `apointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `date`
--
ALTER TABLE `date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `staff_schedule`
--
ALTER TABLE `staff_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblstaff`
--
ALTER TABLE `tblstaff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`Usertype`) REFERENCES `usertype` (`id`),
  ADD CONSTRAINT `accounts_ibfk_2` FOREIGN KEY (`Status`) REFERENCES `accstatus` (`id`);

--
-- Constraints for table `apointments`
--
ALTER TABLE `apointments`
  ADD CONSTRAINT `apointments_ibfk_1` FOREIGN KEY (`Request_id`) REFERENCES `request` (`id`);

--
-- Constraints for table `date`
--
ALTER TABLE `date`
  ADD CONSTRAINT `date_ibfk_1` FOREIGN KEY (`Sched_id`) REFERENCES `staff_schedule` (`id`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`Collegeid`) REFERENCES `college` (`id`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`Sched_id`) REFERENCES `staff_schedule` (`id`),
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`Student_id`) REFERENCES `tblstudent` (`id`),
  ADD CONSTRAINT `request_ibfk_3` FOREIGN KEY (`Status_id`) REFERENCES `status` (`id`);

--
-- Constraints for table `staff_schedule`
--
ALTER TABLE `staff_schedule`
  ADD CONSTRAINT `staff_schedule_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `tblstaff` (`id`),
  ADD CONSTRAINT `staff_schedule_ibfk_2` FOREIGN KEY (`Date_id`) REFERENCES `date` (`id`);

--
-- Constraints for table `tblstaff`
--
ALTER TABLE `tblstaff`
  ADD CONSTRAINT `tblstaff_ibfk_1` FOREIGN KEY (`Department`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `tblstaff_ibfk_2` FOREIGN KEY (`Accountid`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD CONSTRAINT `tblstudent_ibfk_1` FOREIGN KEY (`Department`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `tblstudent_ibfk_2` FOREIGN KEY (`Accountid`) REFERENCES `accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
