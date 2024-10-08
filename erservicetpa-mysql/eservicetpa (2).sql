-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2024 at 06:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eservice`
--

-- --------------------------------------------------------

--
-- Table structure for table `constants`
--

CREATE TABLE `constants` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `constants`
--

INSERT INTO `constants` (`id`, `title`, `parent_id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'جذر الشجرة', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'حالة الحياة', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'شهيد', 4, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'متوفى', 4, 27, '2024-08-24', 27, '2024-08-24', '2024-08-24', NULL),
(7, 'على قيد الحياة', 4, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(8, 'الحالة الإجتماعية', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(9, 'أعزب', 8, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(10, 'متزوج', 8, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(11, 'مطلق', 8, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(12, 'سبب الوفاة', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(13, 'شهيد', 12, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(14, 'مرض', 12, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(15, 'حادث سير', 12, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(16, 'حادث عمل', 12, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(17, 'سبب رباني', 12, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(18, 'مفقود', 4, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(19, 'طبيعة العمل', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(20, 'لا يعمل', 19, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(21, 'موظف حكومي', 19, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(22, 'موظف وكالة', 19, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(23, 'موظف قطاع خاص', 19, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(24, 'عامل', 19, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(25, 'طبيعة المسكن', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(26, 'ملك', 25, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(27, 'إيجار', 25, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(28, 'مشترك مع العائلة', 25, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(29, 'الإقامة الحالية', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(30, 'المسكن الأصلي', 29, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(31, 'نازح - مدرسة', 29, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(32, 'نازح مستشفى', 29, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(33, 'نازح لدى أسرة', 29, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(34, 'حالة السكن', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(35, 'غير متضرر', 34, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(36, 'ضرر جزئي', 34, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(37, 'ضرر بليغ غير صالح للسكن', 34, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(38, 'هدم كلي', 34, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(39, 'ضرر بسيط', 34, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(40, 'المحافظات', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(41, 'شمال غزة', 40, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(42, 'غزة', 40, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(43, 'الوسطى', 40, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(44, 'خان يونس', 40, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(45, 'رفح', 40, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(46, 'جهة الوادي', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(47, 'شمال الوادي', 46, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(48, 'جنوب الوادي', 46, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(49, 'صلة القرابة', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(50, 'أم', 49, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(51, 'أخ/ت', 49, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(52, 'عم/ة', 49, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(53, 'خال/ة', 49, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(54, 'جد/ة', 49, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(55, 'المرحلة التعليمية', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(56, 'ابتدائي', 55, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(57, 'اعدادي', 55, 27, '2024-08-24', 27, '2024-08-24', NULL, NULL),
(58, 'ثانوي', 56, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(59, 'جامعي', 55, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(60, 'روضة', 55, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(61, 'بستان', 60, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(62, 'تمهيدي', 60, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(63, 'أول', 56, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(64, 'ثاني', 56, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(65, 'ثالث', 56, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(66, 'رابع', 56, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(67, 'خامس', 56, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(68, 'سادس', 56, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(69, 'أول إعدادي', 57, 27, '2024-08-24', 27, '2024-08-24', NULL, NULL),
(70, 'ثاني إعدادي', 57, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(71, 'ثالث إعدادي', 57, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(72, 'ثانوي', 55, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(73, 'أول ثانوي', 72, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(74, 'ثاني ثانوي', 58, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(75, 'ثالث ثانوي', 72, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(76, 'المستوى الأول', 59, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(77, 'المستوى الثاني', 59, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(78, 'المستوى الثالث', 59, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(79, 'المستوى الرابع', 59, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(80, 'المستوى الخامس', 59, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(81, 'المستوى السادس', 59, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(82, 'المستوى السابع', 59, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(83, 'المرفقات', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(84, 'صورة شخصية', 83, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(85, 'صورة هوية', 83, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(86, 'شهادة وفاة', 83, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(87, 'شهادة ميلاد', 83, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(88, 'الوصاية', 83, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(89, 'تقرير طبي', 83, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(90, 'شهادة قيد', 83, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(91, 'شهادة عزوبية', 83, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(92, 'شهادة شكر', 83, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(93, 'صورة طولية', 83, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(94, 'الحالة الصحية', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(95, 'مرض مزمن', 94, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(96, 'جريح بحاجة لعلاج', 94, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(97, 'جريح لا يحتاج علاج', 94, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(98, 'جيدة', 94, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(99, 'حالة الإعاقة', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(100, 'حركي', 99, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(101, 'بصري', 99, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(102, 'سمعي', 99, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(103, 'عقلي', 99, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(104, 'متعدد', 99, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(105, 'نوع الإغاثة', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(106, 'كفالة', 105, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(107, 'طرد صحي', 105, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(108, 'طرد غذائي', 105, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(109, 'نوع الكفالة', 1, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(110, 'طفل حالة إجتماعية', 109, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(111, 'طفل مريض', 109, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(112, 'طفل يتيم', 109, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(113, 'طفل لطيم', 109, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(114, 'طفل عجي', 109, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(115, 'نوع الاتصال', 1, 27, '2024-08-25', NULL, NULL, NULL, NULL),
(116, 'بريد', 115, 27, '2024-08-25', NULL, NULL, NULL, NULL),
(117, 'جوال', 115, 27, '2024-08-25', NULL, NULL, NULL, NULL),
(118, 'واتس', 115, 27, '2024-08-25', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `identity` int(9) NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'ذكر',
  `maretal_status` int(11) NOT NULL,
  `dob` date NOT NULL,
  `death_date` varchar(20) DEFAULT NULL,
  `death_reason` int(11) NOT NULL,
  `user_status` int(5) NOT NULL,
  `asylum_status` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'حالة اللجوء مواطن لاجىء',
  `naturalwork` int(11) NOT NULL COMMENT 'حالة العمل يعمل لايعمل موظف حكومي',
  `incom` decimal(11,0) NOT NULL,
  `after_death_incom` decimal(11,0) NOT NULL,
  `total_member_no` int(11) NOT NULL,
  `male_no_under_me` int(11) NOT NULL,
  `femail_no_under_me` int(11) NOT NULL,
  `email` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dwelling_nature` int(11) NOT NULL COMMENT 'طبيعة السكن ملك ايجار مشترك',
  `dwelling_damage` int(11) NOT NULL,
  `current_residence_status` int(11) NOT NULL COMMENT 'نازح اسرة نازح مدرسة مسكنه الاصلي',
  `current_residence` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `original_residence_status` int(11) NOT NULL,
  `original_residence` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nearest_famous_place` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `governorate` int(11) NOT NULL,
  `Local_area` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `valley_side` int(11) NOT NULL COMMENT 'شمال الوادي جنوب الوادي',
  `last_health_status` int(11) NOT NULL,
  `last_edu_status` int(11) NOT NULL,
  `image` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` date DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `sname`, `tname`, `lname`, `name`, `identity`, `gender`, `maretal_status`, `dob`, `death_date`, `death_reason`, `user_status`, `asylum_status`, `naturalwork`, `incom`, `after_death_incom`, `total_member_no`, `male_no_under_me`, `femail_no_under_me`, `email`, `dwelling_nature`, `dwelling_damage`, `current_residence_status`, `current_residence`, `original_residence_status`, `original_residence`, `nearest_famous_place`, `governorate`, `Local_area`, `valley_side`, `last_health_status`, `last_edu_status`, `image`, `user_name`, `password`, `role_id`, `is_active`, `date_created`, `created_by`, `created_at`, `deleted_by`, `deleted_at`, `updated_by`, `updated_at`) VALUES
(27, '', '', '', '', 'وفاء علاء الدين أحمد', 906674551, '0', 0, '1981-04-22', NULL, 0, 0, '0', 0, 0, 0, 0, 0, 0, 'admin@mail.com', 0, 0, 0, '', 0, '', '', 0, '', 0, 0, 0, 'IMG-20230830-WA0054.jpg', '906674551', '$2y$10$tyQAbY.lSzSVnTAebcly5u0NBRTma8yfPqebG3LLiqJHvLzvm0EkS', 1, 1, 1599504982, 0, NULL, 0, '2024-08-23 08:22:27', 0, NULL),
(32, '', '', '', '', 'Tiffany O. Errico', 0, '0', 0, '0000-00-00', NULL, 0, 0, '0', 0, 0, 0, 0, 0, 0, 'tiffo@mail.com', 0, 0, 0, '', 0, '', '', 0, '', 0, 0, 0, 'default.jpg', '', '$2y$10$pZFHhWCS.Ao.eJEsRIx8e.0HH.UdkNI4w/NdlLSZ8dYYigAbvgaAe', 2, 1, 1599577135, 0, NULL, 0, '2024-08-20 19:04:01', 0, NULL),
(33, '', '', '', '', 'Marvin D. Behrens', 0, '0', 0, '0000-00-00', NULL, 0, 0, '0', 0, 0, 0, 0, 0, 0, 'marvind@mail.com', 0, 0, 0, '', 0, '', '', 0, '', 0, 0, 0, 'default.jpg', '', '$2y$10$4Qc8UQVBZg8mx1/iKcgiHu.zJ9zs4IoIvDPMSMktj6DEyV3pQX7DS', 2, 1, 1599577186, 0, NULL, 0, '2024-08-20 19:04:01', 0, NULL),
(34, '', '', '', '', 'Nelson L. Perez\n', 0, '0', 0, '0000-00-00', NULL, 0, 0, '0', 0, 0, 0, 0, 0, 0, 'nelsonp@mail.com', 0, 0, 0, '', 0, '', '', 0, '', 0, 0, 0, 'default.jpg', '', '$2y$10$NRnnTrxQkRqVK0M/BNXLa.sajWUnF971Hff/Hsyext75qAoDgXWI2', 2, 1, 1599577219, 0, NULL, 0, '2024-08-20 19:04:01', 0, NULL),
(35, '', '', '', '', 'Seth L. Buckner\n', 0, '0', 0, '0000-00-00', NULL, 0, 0, '0', 0, 0, 0, 0, 0, 0, 'sethb@mail.com', 0, 0, 0, '', 0, '', '', 0, '', 0, 0, 0, 'default.jpg', '', '$2y$10$kIB2L/O3/7z7pQmV.XYtAOOBYDZl5TbSWSULg1QTws7TNm1qI/XAm', 2, 1, 1599577247, 0, NULL, 0, '2024-08-20 19:04:01', 0, NULL),
(36, '', '', '', '', 'Harold B. Loya\n', 0, '0', 0, '0000-00-00', NULL, 0, 0, '0', 0, 0, 0, 0, 0, 0, 'haroldbl@mail.com', 0, 0, 0, '', 0, '', '', 0, '', 0, 0, 0, 'default.jpg', '', '$2y$10$wW9vlmU6rjciESA6i1N.we3TMlE6fWG7ICy7LOkZdRxPK7m6j001W', 2, 1, 1599577284, 0, NULL, 0, '2024-08-20 19:04:01', 0, NULL),
(37, '', '', '', '', 'Christine Moore', 0, '0', 0, '0000-00-00', NULL, 0, 0, '0', 0, 0, 0, 0, 0, 0, 'christine@mail.com', 0, 0, 0, '', 0, '', '', 0, '', 0, 0, 0, 'default.jpg', '', '$2y$10$enF4wVVEDEYRSEd.NT7JheUjB6.TBnTWR0q4aJU5JlulO.lHmZb9G', 2, 1, 1651551632, 0, NULL, 0, '2024-08-20 19:04:01', 0, NULL),
(38, '', '', '', '', 'Michael K. Parker', 0, '0', 0, '0000-00-00', NULL, 0, 0, '0', 0, 0, 0, 0, 0, 0, 'michaelp@mail.com', 0, 0, 0, '', 0, '', '', 0, '', 0, 0, 0, 'default.jpg', '', '$2y$10$YP4.s3pZe2RzbYv48fEA5.g04TkeDnxOCq7OSSW5zQf77qaqZYGoK', 2, 1, 1651593601, 0, NULL, 0, '2024-08-20 19:04:01', 0, NULL),
(43, 'تالا', 'احمد', 'موسى', 'احمد', 'تالا احمد موسى احمد', 0, '', 0, '0000-00-00', NULL, 0, 0, '0', 0, 0, 0, 0, 0, 0, 'jsp@windowslive.com', 0, 0, 0, '', 0, '', '', 0, '', 0, 0, 0, 'default.jpg', 'tala', '$2y$10$srKRksJHMboeBI6Ed1UtS.1sssz.UKA64fHRBnHJM0O0fxJrvgCT2', 2, 1, 20, 0, NULL, NULL, '2024-08-20 20:10:57', NULL, NULL),
(44, 'dd', 'ddd', 'dddd', 'dddd', 'dd ddd dddd dddd', 0, 'ذكر', 0, '0000-00-00', '2024-08-01', 0, 5, '0', 20, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, '', '', 0, '', 0, 0, 0, '', '', '', 0, 0, 0, 27, '2024-08-24', NULL, '2024-08-25 03:28:27', NULL, NULL),
(45, 'wafa', 'alaa', 'mahmoud', 'ahmed', 'wafa alaa mahmoud ahmed', 906674551, 'ذكر', 0, '0000-00-00', '12-08-2024', 16, 6, 'لاجىء', 22, 55, 555, 0, 0, 0, '', 27, 38, 32, 'غزة', 0, 'جباليا القصاصيب', 'عائشة', 41, 'جبالياfvbn ', 47, 0, 0, '', '', '', 0, 0, 0, 27, '2024-08-24', NULL, '2024-08-25 04:41:24', 27, '2024-08-24 21:00:00'),
(46, '5', '5', '5', '5', '5 5 5 5', 259999999, 'ذكر', 0, '0000-00-00', '0000-00-00', 13, 5, '0', 20, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, '', '', 0, '', 0, 0, 0, '', '', '', 0, 0, 0, 27, '2024-08-24', NULL, '2024-08-24 21:36:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `submenu_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`, `submenu_id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00', NULL),
(14, 1, 3, 2, NULL, NULL, NULL, NULL, '0000-00-00', NULL),
(15, 1, 3, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 2, 3, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 1, 2, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 1, 3, 3, NULL, NULL, NULL, NULL, '2024-08-23', NULL),
(22, 3, 1, 0, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(23, 4, 1, 0, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(24, 4, 2, 0, 27, '2024-08-24', NULL, NULL, '2024-08-24', 27),
(25, 4, 2, 0, 27, '2024-08-24', NULL, NULL, NULL, NULL),
(26, 1, 10, 12, 27, '2024-08-24', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_contact`
--

CREATE TABLE `user_contact` (
  `id` int(50) NOT NULL,
  `user_id` int(20) NOT NULL,
  `contact_value` varchar(200) NOT NULL,
  `contact_type` int(50) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_contact`
--

INSERT INTO `user_contact` (`id`, `user_id`, `contact_value`, `contact_type`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 45, '0567088862', 117, 27, '2024-08-25', NULL, NULL, NULL, NULL),
(5, 45, 'Ab@a.com', 116, 27, '2024-08-25', NULL, NULL, NULL, NULL),
(6, 45, 'Axx@a.com', 116, 27, '2024-08-25', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_education`
--

CREATE TABLE `user_education` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `edu_stage` int(11) NOT NULL,
  `edu_level` int(11) NOT NULL,
  `edu_details` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `deleted_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_family`
--

CREATE TABLE `user_family` (
  `id` int(11) NOT NULL,
  `user_parent_id` int(11) NOT NULL,
  `user_child_id` int(11) NOT NULL,
  `relation` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `deleted_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_health`
--

CREATE TABLE `user_health` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `health_status` int(11) NOT NULL,
  `health_details` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `deleted_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_hoby`
--

CREATE TABLE `user_hoby` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hoby_no` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `deleted_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ar_menu` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `color` varchar(20) NOT NULL,
  `display` int(11) NOT NULL DEFAULT 0,
  `menu_icon` varchar(100) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`, `ar_menu`, `color`, `display`, `menu_icon`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'Admin', 'إدارة الأنظمة', '', 1, 'fa fa-cog fa-spin fa-1x fa-fw2', 27, '2024-08-23', 27, '2024-08-23', NULL, NULL),
(2, 'Menu', 'إدارة القوائم', '', 1, 'fa fa-cog fa-spin fa-1x fa-fw2', 27, '2024-08-23', 27, '2024-08-23', NULL, NULL),
(3, 'User', 'إدارة المعلومات الشخصية', '', 1, 'fa fa-cog fa-spin fa-1x fa-fw2', 27, '2024-08-23', 27, '2024-08-23', NULL, NULL),
(4, 'Report Form', 'نماذج التقارير', '', 1, 'fa fa-cog fa-spin fa-1x fa-fw2', 27, '2024-08-23', 27, '2024-08-23', NULL, NULL),
(5, 'Report', 'التقارير', '', 1, 'fa fa-cog fa-spin fa-1x fa-fw2', 27, '2024-08-23', 27, '2024-08-23', NULL, NULL),
(6, 'Admin2', 'الأنظمةوفاء', '', 0, 'fa fa-cog fa-spin fa-1x fa-fw2', 27, '2024-08-23', 27, '2024-08-23', NULL, NULL),
(7, 'Admin3', 'الأنظمةوفاء', '', 0, 'fa fa-cog fa-spin fa-1x fa-fw2', 27, '2024-08-23', 27, '2024-08-23', '2024-08-23', 27),
(9, 'qw', 'qwe', '', 0, 'qwe', 27, '2024-08-24', NULL, NULL, '2024-08-24', 27),
(10, 'Member', 'إدارة المستخدمين', '', 1, 'fas fa-user', 27, '2024-08-25', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_report`
--

CREATE TABLE `user_report` (
  `id` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `nik` varchar(64) NOT NULL,
  `rt` int(11) NOT NULL,
  `rw` int(11) NOT NULL,
  `village` varchar(64) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `type` text NOT NULL,
  `date_reported` int(11) NOT NULL,
  `file` varchar(64) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_report`
--

INSERT INTO `user_report` (`id`, `name`, `nik`, `rt`, `rw`, `village`, `title`, `description`, `type`, `date_reported`, `file`) VALUES
('1', 'Marvin D. Behrens', '0311192857689401', 1, 4, 'Little Ivywood', 'Flood', 'Several residential areas were affected by the flood', 'Natural Disaster', 1646499899, '5f57a6d18c382.jpeg'),
('2', 'Tiffany O. Errico', '3299000709012871', 2, 4, 'Aucteraden', 'Need Education Help', 'Some children are still not getting a decent education.', 'Education', 1648405450, '5f57a769d43b0.jpg'),
('5f57a769d43b0', 'Tiffany O. Errico', '3299000709012871', 2, 4, 'Aucteraden', 'Need Education Help', 'Some children are still not getting a decent education.', 'Education', 1648405450, '5f57a769d43b0.jpg'),
('6270af1bdf852', 'Christine Moore', '12121', 2, 2, 'as', 'Demo', 'Demo demo demo', 'Corona Virus', 1651552027, '6270af1bdf852.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'Admin', 27, NULL, 33, NULL, NULL, NULL),
(2, 'Member', 27, NULL, 27, '2024-08-23', '2024-08-23', NULL),
(3, 'تجربة برمجية', 34, NULL, NULL, NULL, '2024-08-23', 27),
(4, 'وفاء تجربة', 33, NULL, 27, '2024-08-23', NULL, NULL),
(5, 'wafa', 27, '2024-08-23', NULL, NULL, NULL, 27);

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ar_title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `ar_title`, `url`, `icon`, `is_active`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 'Dashboard', 'سطح المكتب', 'admin', 'fas fa-fw fa-tachometer-alt', 1, NULL, NULL, 27, '2024-08-24', NULL, NULL),
(2, 3, 'My Profile', 'المعلومات الشخصية', 'user', 'fas fa-fw fa-user', 1, NULL, NULL, 27, '2024-08-24', NULL, NULL),
(3, 3, 'Update Profile', 'تعديل البيانات الشخصية', 'user/edit', 'fas fa-fw fa-user-edit', 1, NULL, NULL, 27, '2024-08-24', NULL, NULL),
(4, 2, 'Menu Management', 'إدارة القوائم', 'menu', 'fas fa-fw fa-folder', 1, NULL, NULL, 27, '2024-08-24', NULL, NULL),
(5, 2, 'Submenu Management', 'إدارة القوائم الفرعية', 'menu/submenu', 'fas fa-fa-fw fa-folder-open', 1, NULL, NULL, 27, '2024-08-24', NULL, NULL),
(6, 1, 'Access Authority', 'إدارة الصلاحيات', 'admin/role', 'fas fa-fw fa-user-tie', 1, NULL, NULL, 27, '2024-08-24', NULL, NULL),
(7, 3, 'Change Password', 'تغيير كلمة المرور', 'user/changepassword', 'fas fa-fw fa-key', 1, NULL, NULL, 27, '2024-08-24', NULL, NULL),
(9, 4, 'Report', 'نموذج التقرير', 'report/addreport', 'fas fa-fw fa-headset', 1, NULL, NULL, 27, '2024-08-24', NULL, NULL),
(10, 5, 'Report Data', 'بيانات التقرير', 'report', 'fas fa-fw fa-file-alt', 1, NULL, NULL, 27, '2024-08-24', NULL, NULL),
(11, 10, 'User Data', 'بيانات المستخدم', 'member/datamember', 'fas fa-fw fa-users', 1, NULL, NULL, 27, '2024-08-25', NULL, NULL),
(12, 1, 'def manage', 'إدارة تعريفات النظام', 'admin/def', 'fas fa-cogs', 1, 27, '2024-08-24', 27, '2024-08-24', NULL, NULL),
(13, 10, 'add member', 'إضافة شخص', 'member/add_member', 'fa fa-user', 1, 27, '2024-08-24', 27, '2024-08-25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(8, 'aa@gmail.com', 'Wag8dsxx6ziM9O8n/HisVkGyy9+az5XeumzNuaJMGg4=', 1599579296),
(9, 'christine@mail.com', '0Hrx2++F9JMO4pYOuQRLLlfQwP5DWH/O76x//+Yhs54=', 1651551632),
(10, 'jsp@windowslive.com', '5cg3Zr+rL3nXvTUQhl2szXcE+3I/bt5ZyHwQj2an2gI=', 1724183890),
(11, 'jsp@windowslive.com', 'aN76e66hHLKlEVIQY0AMoPoLYFAln5kVQHa3IbivbPQ=', 1724184248),
(12, 'jsp@windowslive.com', '0fB6/BhmhTIF0Ld4ZfYR2At2faygjV2YwpoR28/tIjU=', 1724184400),
(13, 'jsp@windowslive.com', 'v/+c5AC0A9UlLEJOhvYO/im2jb1y1rB8jF3B4mBvzWM=', 1724184614),
(14, 'jsp@windowslive.com', 'UrhCRwgnVoYy0n10qwWsoHlLwvdYFRqMzXoQwREXuBY=', 1724184657);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `constants`
--
ALTER TABLE `constants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_contact`
--
ALTER TABLE `user_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_hoby`
--
ALTER TABLE `user_hoby`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_report`
--
ALTER TABLE `user_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `constants`
--
ALTER TABLE `constants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_contact`
--
ALTER TABLE `user_contact`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_hoby`
--
ALTER TABLE `user_hoby`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `constants`
--
ALTER TABLE `constants`
  ADD CONSTRAINT `constants_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `constants` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
