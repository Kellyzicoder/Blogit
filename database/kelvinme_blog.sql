-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2022 at 12:44 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kelvinme_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blogid` int(5) NOT NULL,
  `bgname` varchar(150) NOT NULL,
  `bgdescript` varchar(200) NOT NULL,
  `bgdate` date NOT NULL,
  `userid` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blogid`, `bgname`, `bgdescript`, `bgdate`, `userid`) VALUES
(83, 'Covid19', 'Coronavirus disease (COVID-19) is an infectious disease caused by the SARS-CoV-2 virus.\r\nMost people who fall sick with COVID-19 will experience mild to moderate symptoms and recover', '2022-10-25', 52),
(82, 'Liston College', 'Liston College is a school in Henderson, Auckland, New Zealand, for year seven to 13 boys and offers a Catholic education to its students.', '2022-10-25', 52),
(80, 'War', 'War is an intense armed conflict between states, governments, societies, or paramilitary groups such as mercenaries, insurgents, and militias', '2022-10-24', 40),
(88, 'test', 'Some text', '2022-10-28', 77);

-- --------------------------------------------------------

--
-- Table structure for table `entry`
--

CREATE TABLE `entry` (
  `entryid` int(5) NOT NULL,
  `entname` varchar(150) NOT NULL,
  `enttext` varchar(2000) NOT NULL,
  `blogid` int(5) NOT NULL,
  `statusid` int(1) NOT NULL,
  `entdate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `entry`
--

INSERT INTO `entry` (`entryid`, `entname`, `enttext`, `blogid`, `statusid`, `entdate`) VALUES
(85, 'History', 'During 1973 and 1974, the school was erected on the property at Edwards Avenue, which prior to work commencing was &quot; ... an open paddock with an old house on it.&quot; The buildings, gymnasium and grounds were ready for occupation in the first term of 1975. The school was formally opened in November 1975 by John Mackey, the ninth Catholic Bishop of Auckland (1974–1983), in the presence of Archbishop Liston (who died the following year, 8 July 1976).', 82, 1, '2022-10-25'),
(83, 'Symptoms of Covid 19', 'Most common symptoms:fever, cough,tiredness, loss of taste or smell. Less common symptoms: sore throat, headache, aches and pains, diarrhoea, a rash on skin, or, discolouration of fingers or toes, red or irritated eyes', 83, 1, '2022-10-25'),
(84, 'Roll', 'Liston College has a diverse, multicultural roll. In 2018 its ethnic composition was 9% Maori, 31% New Zealand European, 11% Samoan, 10% Indian, 4% Tongan, 4% African, 13% Southeast Asian and 18% Other. The college excels in sporting and cultural activities. Academically, the school offers for senior years the National Certificate of Educational Achievement assessment system (NCEA)', 82, 1, '2022-10-25'),
(82, 'Who is Edmund Rice?', 'Blessed Edmund Ignatius Rice, was a Roman Catholic missionary and educationalist. Edmund was the founder of two religious institutes of religious brothers: the Congregation of Christian Brothers and the Presentation Brothers.\r\n\r\nBorn in Callan, Ireland, in 1762, Edmund came to the bustling city port of Waterford as a young man. He was talented and energetic and soon became very wealthy. Married to Mary Elliot, in 1789 he experienced her tragic death soon after she gave birth to their daughter Mary. Deeply saddened by her loss, Edmund entered a time of mourning. As his daughter continued to open the depths of his love, his relationship with God deepened. In his own brokenness, he was moved with compassion to recognise the brokenness of those around him. He entered more deeply into their struggle and found in the story of Jesus the call to liberation that is at the heart of what Jesus preached and in which his church is engaged.', 82, 1, '2022-10-25'),
(81, 'Russian &amp; Ukraine War', 'He added that the attacks were on a &quot;very wide&quot; scale, hitting regions in Ukraine&#039;s west, centre, south and east.\r\n\r\nIn an evening address, Mr Zelensky said power had been restored in multiple areas where it had been cut off.\r\n\r\nOfficials had said earlier on Saturday that nearly 1.5 million households had been left without electricity.\r\n\r\nIn his video, Mr Zelensky added that most of the Russian missiles and drones were being shot down, and such strikes would not stop a Ukrainian military advance.\r\n\r\n&quot;Of course, we do not yet have the technical ability to shoot down 100% of Russian missiles and attack drones. We will gradually come to this - with the help of our partners, I&#039;m confident of this,&quot; the Ukrainian leader said in a video.', 80, 1, '2022-10-24'),
(89, 'Test', 'testskjbukbluINUHIHI', 88, 2, '2022-10-28');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `statusid` int(1) NOT NULL,
  `statustype` varchar(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`statusid`, `statustype`) VALUES
(1, 'Published'),
(2, 'Draft');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(5) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(120) NOT NULL,
  `usertype` int(1) DEFAULT 1,
  `userdate` date DEFAULT NULL,
  `online` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `firstname`, `lastname`, `email`, `password`, `usertype`, `userdate`, `online`) VALUES
(52, 'Bob', 'Mensah', 'bob@gmail.com', '$2y$10$B4siLN/Oz/HalJXPJWoZ4O2PSi5iOKvF0d6w4V2SgTlLGE9J18jR2', 1, '2022-10-19', 1666692147),
(40, 'Prisca', 'M', 'prism@gmail.com', '$2y$10$JyHJ6uiUBwtSl.AuZrt1auI5gtToxH11nG9vI9IDngCq2TnYoJPpC', 2, '2022-10-14', 1666953038),
(51, 'Gideon', 'Mensah', 'gnmensah@gmail.com', '$2y$10$nxl7eVEe9l2EmLeuwnGq1ezRWSsxGNhRpLmByLOmshjYWj5k7Nxju', 1, '2022-10-18', 1666687857),
(76, 'Ts', 'Ts', 'test@gmail.comm', '$2y$10$MOcT3wpMdBSn.3RouYdG3eB.lCMn2wzS.XzwC1M2m0Q9OhBq.3JpC', 1, '2022-10-28', 1666952111),
(77, 't', 't', 'test@gmail.com', '$2y$10$I0gEvUBiuVF2T37.5pvZ5uT0OnptJFJqP76zJgC61hkuEv1J6D4T.', 1, '2022-10-28', 1666953127);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blogid`);

--
-- Indexes for table `entry`
--
ALTER TABLE `entry`
  ADD PRIMARY KEY (`entryid`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`statusid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blogid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `entry`
--
ALTER TABLE `entry`
  MODIFY `entryid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `statusid` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
