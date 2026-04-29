-- Resume Builder Database Schema
-- Clean schema (no data) for fresh installation

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resumebuilder`
--
CREATE DATABASE IF NOT EXISTS `resumebuilder` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `resumebuilder`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(250) NOT NULL,
  `email_id` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_id` (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `email_id` varchar(250) NOT NULL,
  `resume_title` varchar(250) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `marital_status` varchar(50) NOT NULL,
  `hobbies` varchar(250) NOT NULL,
  `languages` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `objective` text NOT NULL,
  `slug` varchar(250) NOT NULL,
  `updated_at` int(20) NOT NULL,
  `background` varchar(250) NOT NULL DEFAULT '',
  `font` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_resumes_user` (`user_id`),
  CONSTRAINT `fk_resumes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE `educations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) NOT NULL,
  `course` varchar(250) NOT NULL,
  `institute` varchar(250) NOT NULL,
  `started` varchar(250) NOT NULL,
  `ended` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_educations_resume` (`resume_id`),
  CONSTRAINT `fk_educations_resume` FOREIGN KEY (`resume_id`) REFERENCES `resumes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) NOT NULL,
  `position` varchar(250) NOT NULL,
  `company` varchar(250) NOT NULL,
  `job_desc` text NOT NULL,
  `started` varchar(250) NOT NULL,
  `ended` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_experiences_resume` (`resume_id`),
  CONSTRAINT `fk_experiences_resume` FOREIGN KEY (`resume_id`) REFERENCES `resumes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) NOT NULL,
  `skill` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_skills_resume` (`resume_id`),
  CONSTRAINT `fk_skills_resume` FOREIGN KEY (`resume_id`) REFERENCES `resumes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
