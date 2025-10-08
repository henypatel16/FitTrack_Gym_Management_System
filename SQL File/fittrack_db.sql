-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2025 at 06:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fittrack_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `member_id`, `date`, `status`, `created_at`) VALUES
(7, 9, '2025-09-05', 'Present', '2025-09-21 15:59:42'),
(8, 10, '2025-09-07', 'Present', '2025-09-21 15:59:52'),
(9, 10, '2025-09-06', 'Absent', '2025-09-21 16:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `bmi_records`
--

CREATE TABLE `bmi_records` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `bmi` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bmi_records`
--

INSERT INTO `bmi_records` (`id`, `user_id`, `age`, `height`, `weight`, `bmi`, `created_at`) VALUES
(8, 4, 20, 195, 55, 14.46, '2025-09-04 07:54:49'),
(13, 2, 19, 158, 50, 20.03, '2025-09-21 15:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `trainer` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `capacity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `title`, `image`, `trainer`, `date`, `time`, `capacity`, `created_at`) VALUES
(1, 'YOGA CLASS', '1756278377_yoga.jpg', 'Sneh Patel', '2025-09-06', '10:00:00', 50, '2025-08-27 07:06:17'),
(2, 'ZUMBA CLASS', '1756278352_zumba.jpg', 'Aliza Sharma', '2025-08-30', '13:00:00', 50, '2025-08-27 07:05:52'),
(3, 'CARDIO CLASS', '1756278339_cardio.jpg', 'Vatsal  Chaudhari', '2025-09-02', '11:00:00', 30, '2025-08-27 07:05:39'),
(4, 'CONDITIONING SESSION', '1756278313_CONDITIONING.jpg', 'Raj Patel', '2025-09-04', '09:00:00', 30, '2025-08-27 07:05:13');

-- --------------------------------------------------------

--
-- Table structure for table `class_join`
--

CREATE TABLE `class_join` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_join`
--

INSERT INTO `class_join` (`id`, `class_id`, `Name`, `email`, `phone`, `status`, `joined_at`) VALUES
(3, 3, 'vandana', 'vandanaparik4@gmail.com', '8497237498', 'Confirmed', '2025-09-04 08:37:41'),
(4, 2, 'vandana', 'vandanaparik4@gmail.com', '8497237498', 'Pending', '2025-09-04 08:38:06'),
(7, 3, 'heny', 'heny01@gmail.com', '6351249014', 'Pending', '2025-09-21 14:51:46');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'heny', 'heny01@gmail.com', '6351249014', 'I really love the new yoga classes. Can you add more evening slots?', '2025-09-02 07:59:30'),
(6, 'vandana', 'vandanaparik4@gmail.com', '8000015023', 'The gym equipment is excellent! Thank you for maintaining it so well.', '2025-09-02 08:14:33');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `plan` varchar(100) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `enrolled_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `name`, `email`, `phone`, `plan`, `payment_method`, `status`, `enrolled_on`) VALUES
(5, 'vandana', 'vandanaparik4@gmail.com', '8497237498', 'Silver Membership', 'Cash', 'Paid', '2025-09-04 07:51:17'),
(9, 'heny', 'heny01@gmail.com', '6351249014', 'Platinum Membership', 'Cash', 'Pending', '2025-09-21 14:06:27');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `condition_status` enum('Active','Inactive','Maintenance') DEFAULT 'Active',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `category`, `quantity`, `purchase_date`, `price`, `condition_status`, `image`, `created_at`) VALUES
(2, 'Treadmill', 'Cardio', 6, '2025-08-21', 10000.00, 'Active', 'equipment/1756280775_e0d9ba84.jpg', '2025-08-27 07:38:49'),
(3, 'Dumbbell', 'Strength', 4, '2025-08-18', 2000.00, 'Active', 'equipment/1756281134_d3f61cf1.avif', '2025-08-27 07:52:14'),
(4, 'Kettebells', 'Free Weights', 5, '2025-08-19', 1500.00, 'Active', 'equipment/1756281532_2d2e51f9.jpg', '2025-08-27 07:58:52'),
(5, 'Medicine Ball', 'Free Weights', 5, '2025-08-18', 3000.00, 'Active', 'equipment/1756282021_e73d986e.jpg', '2025-08-27 08:07:01'),
(6, 'Barbell', 'Free Weights', 10, '2025-08-01', 4000.00, 'Active', 'equipment/1756282260_a7d1d9bf.avif', '2025-08-27 08:11:00'),
(7, 'Plates', 'Free Weights', 8, '2025-08-19', 3000.00, 'Active', 'equipment/1756282299_42a51822.avif', '2025-08-27 08:11:39'),
(8, 'Leg Press Machine', 'Strength', 5, '2025-08-13', 10000.00, 'Active', 'equipment/1756286044_c7d07e55.jpg', '2025-08-27 08:15:02'),
(9, 'Resistance Bands', 'Flexibility', 5, '2025-08-19', 500.00, 'Active', 'equipment/1756282616_644dcd02.jpg', '2025-08-27 08:16:56'),
(10, 'Form Roller and Yoga Mats', 'Flexibility', 15, '2025-08-20', 900.00, 'Maintenance', 'equipment/1756282871_20f49eb0.jpg', '2025-08-27 08:21:11'),
(11, 'Punching Bags', 'Other', 7, '2025-08-26', 800.00, 'Inactive', 'equipment/1756283355_3933a3fb.jpg', '2025-08-27 08:29:15'),
(12, 'Spin Bike', 'Cardio', 8, '2025-08-14', 4000.00, 'Active', 'equipment/1756284116_fa5e2845.jpg', '2025-08-27 08:41:56');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `plan_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `phone`, `gender`, `plan_id`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(9, 'heny', 'heny01@gmail.com', '6351249014', 'Female', 9, '2025-09-11', '2025-10-11', 'Active', '2025-09-21 15:58:52'),
(10, 'vandana', 'vandanaparik4@gmail.com', '8497237498', 'Female', 1, '2025-09-03', '2025-09-18', 'Active', '2025-09-21 15:59:24'),
(11, 'Krishna', 'krishna84@gmail.com', '8497237498', 'Male', 9, '2025-09-21', '2025-10-21', 'Active', '2025-09-21 16:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `title`, `price`, `duration`, `description`) VALUES
(1, 'Silver Membership', 999, '15 Days', 'Gym access during regular hours, basic trainer support, general workout plan, 1 group class/week.'),
(7, 'Permium Membership', 12999, '1 year', 'Unlimited gym entry for 1 year, 1 personal trainer consultation at the start, and access to 1 group class. Comes with a basic fitness assessment and special discounts on additional services.\r\n'),
(8, 'Platinum Membership', 3000, '2 Month', 'Unlimited gym access, priority trainer support, custom workout + diet plan, stream room access, 3 fitness classes/week, locker + protein shake.'),
(9, 'Gold Membership', 2000, '1 month', 'Full gym access, fitness test, personalized workout + diet plan, locker facility, 1 zumba or yoga class/week.');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `type`, `title`, `description`, `duration`, `member_id`, `created_at`) VALUES
(1, 'workout', 'Chest Day', 'Bench press, Dumbell fly, Push-ups, Chest press', '4 Weeks', 10, '2025-08-28 07:27:45'),
(4, 'diet', 'Keto Diet', 'Egg, Chicken, Salad, Nuts', '1 Month', 10, '2025-08-28 07:29:42'),
(5, 'workout', 'Leg Day', 'Squats, Lunges, Leg press, Hamstring curls', '4 Weeks', 11, '2025-08-28 07:34:53'),
(7, 'workout', 'Upper Body', 'Push-ups, Shoulder Press, Biceps curls, Bent over rows W Dumbbell', '3 week', 9, '2025-09-04 08:06:29');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `experience` varchar(50) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `availability` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `name`, `specialization`, `experience`, `contact`, `email`, `availability`, `profile_pic`, `status`, `created_at`) VALUES
(3, 'Sneh Patel', 'Yoga & Meditation', '4', '8745210963', 'snehpatel1084@gmail.com', '6am- 10pm', 'pic-1.png', 'Active', '2025-08-24 13:00:42'),
(5, 'Aliza Sharma', 'Zumba & Aerobics', '5', '9876632109', 'Aliza1111@gmail.com', '6am- 12pm', 'pic-4.png', 'Active', '2025-08-25 08:04:32'),
(6, 'Vatsal Chaudhari', 'CrossFit & Cardio', '6', '9974219580', 'vatsal40@gmail.com', 'Weekdays Only', 'pic-7.jpg', 'Inactive', '2025-08-25 08:07:54'),
(7, 'Raj Patel', 'Sprint & Endurance Coach', '3', '9087653211', 'rajpatel21@gmail.com', '6am- 12pm', 'pic-5.jpg', 'Active', '2025-08-25 08:19:57'),
(8, 'Khushi Verma', 'Strength & Weight Training', '4', '7893521690', 'khushi90@gmail.com', '6am- 6pm', 'pic-2.png', 'Active', '2025-08-25 08:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `profile_pic`, `role`) VALUES
(1, 'FitTrack_gym', '12345', '1757171993_logo1.png', 'admin'),
(2, 'heny', '1626', '1756901173_user.jpeg', 'user'),
(3, 'krishna', '1111', '1756645738_user3.png', 'user'),
(4, 'vandana', '1111', '1756647044_user2.jpeg', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `bmi_records`
--
ALTER TABLE `bmi_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_join`
--
ALTER TABLE `class_join`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bmi_records`
--
ALTER TABLE `bmi_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `class_join`
--
ALTER TABLE `class_join`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bmi_records`
--
ALTER TABLE `bmi_records`
  ADD CONSTRAINT `bmi_records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `plans_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
