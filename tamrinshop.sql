-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2022 at 12:34 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tamrinshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'شومیز', 'shomiz', NULL, '2022-05-17 20:21:51', '2022-05-17 20:21:51'),
(2, 'پیراهن', 'پیراهن', NULL, '2022-05-17 22:41:33', '2022-05-17 22:41:33'),
(3, 'شومیز آستین کوتاه', 'شومیز-آستین-کوتاه', 1, '2022-05-17 22:43:18', '2022-05-17 22:43:18'),
(6, 'شومیز آستین بلند', 'شومیز-آستین-بلند', 1, '2022-05-17 23:40:34', '2022-05-17 23:40:34'),
(7, 'پیراهن مجلسی', 'پیراهن-مجلسی', 2, '2022-05-18 00:14:58', '2022-05-18 00:30:49');

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE `category_product` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`category_id`, `product_id`) VALUES
(1, 2),
(1, 5),
(1, 10),
(1, 11),
(1, 15),
(2, 13),
(2, 14),
(2, 16),
(2, 17),
(3, 15),
(6, 2),
(6, 5),
(6, 10),
(6, 11),
(7, 14);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `commentable_id` bigint(20) UNSIGNED NOT NULL,
  `commentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `commentable_id`, `commentable_type`, `approved`, `comment`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 2, 11, 'App\\Models\\Product', 1, 'عالی و زیبا', 0, '2022-05-22 16:27:54', '2022-05-24 09:01:45'),
(2, 2, 13, 'App\\Models\\Product', 1, 'زیبا و کاربردی', 0, '2022-05-22 16:43:34', '2022-05-24 10:56:59'),
(3, 2, 13, 'App\\Models\\Product', 0, 'جذاب', 0, '2022-05-22 18:30:07', '2022-05-22 18:30:07'),
(4, 2, 11, 'App\\Models\\Product', 1, 'عالی', 0, '2022-05-23 06:58:26', '2022-05-24 08:33:50'),
(5, 2, 11, 'App\\Models\\Product', 1, 'خوش رنگ', 0, '2022-05-23 13:35:20', '2022-05-24 08:18:56'),
(6, 2, 11, 'App\\Models\\Product', 1, 'جنس عالی', 0, '2022-05-23 13:55:57', '2022-05-24 08:24:42'),
(7, 2, 13, 'App\\Models\\Product', 0, 'نرمال', 0, '2022-05-23 17:35:20', '2022-05-23 17:35:20'),
(8, 2, 13, 'App\\Models\\Product', 1, 'ziba', 0, '2022-05-23 19:49:49', '2022-05-23 19:49:49'),
(10, 2, 13, 'App\\Models\\Product', 1, 'متشکرم', 8, '2022-05-24 10:55:04', '2022-05-24 11:19:11'),
(11, 2, 13, 'App\\Models\\Product', 1, 'ممنون', 2, '2022-05-24 10:57:38', '2022-05-24 11:22:11'),
(12, 2, 13, 'App\\Models\\Product', 1, 'thanks', 2, '2022-05-24 11:08:44', '2022-05-25 18:48:18'),
(13, 2, 13, 'App\\Models\\Product', 1, 'خواهش میکنم', 11, '2022-05-24 15:52:21', '2022-05-25 18:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_05_14_194210_create_products_table', 2),
(8, '2022_05_17_190820_create_categories_table', 3),
(9, '2022_05_18_232004_create_relationship_between_category_and_product', 4),
(11, '2022_05_20_133732_create_comments_table', 5),
(12, '2022_05_27_172721_add_inventory_to_products_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `inventory` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `title`, `slug`, `description`, `price`, `image`, `created_at`, `updated_at`, `inventory`) VALUES
(2, 2, 'شومیز سبز', 'شومیز-سبز-2', '<p>سبز</p>', '350', '/images/shirt/shirt (2).jpg', '2022-05-15 19:26:07', '2022-05-26 10:46:45', 0),
(5, 2, 'شومیز ساتن کرم', 'شومیز-ساتن-کرم-2', '<p>ساتن کرم</p>', '370', '/images/shirt/shirt (4).jpg', '2022-05-15 20:44:37', '2022-05-26 10:46:28', 0),
(10, 2, 'شومیز چهارخونه', 'شومیز-چهارخونه-2', '<p>چهارخونه</p>', '350', '/images/shirt/shirt (3).jpg', '2022-05-17 13:40:44', '2022-05-26 10:45:25', 0),
(11, 2, 'شومیز سفید', 'شومیز-سفید', '<p>سفید آستین بلند</p>', '350', '/images/shirt/shirt.jpg', '2022-05-17 13:44:45', '2022-05-19 08:40:18', 0),
(13, 2, 'پیراهن قرمز', 'پیراهن-قرمز-2', '<p>پیراهن قرمز</p>', '170000', '/images/dress/dress2.jpg', '2022-05-19 15:35:40', '2022-05-26 12:24:12', 0),
(14, 2, 'پیراهن سیاه سفید', 'پیراهن-سیاه-سفید', '<p>پیراهن سیاه سفید</p>', '700000', '/images/dress/dress4.jpg', '2022-05-26 12:25:37', '2022-05-26 12:27:26', 0),
(15, 2, 'شومیز گلبهی', 'شومیز-گلبهی', '<p>شومیز گلبهی</p>', '170000', '/images/shirt/shirt (1).jpeg', '2022-05-26 12:49:36', '2022-05-26 12:49:36', 0),
(16, 2, 'پیراهن آبی', 'پیراهن-آبی', '<p>پیراهن آبی</p>', '750000', '/images/dress/dress1.jpg', '2022-05-26 12:51:26', '2022-05-27 13:56:15', 5),
(17, 2, 'پیراهن مشگی', 'پیراهن-مشگی-2', '<p>پیراهن مشگی</p>', '1000000', '/images/dress/dress3.jpg', '2022-05-27 13:55:35', '2022-05-27 13:59:31', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `superuser` tinyint(1) NOT NULL DEFAULT 0,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `superuser`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'asie', 1, 'asie.sohrabiii@gmail.com', '2022-05-14 21:13:52', '$2y$10$1RLoRfa65w19Vb5wFYEqVOa5j2TYgUsHZJpKh116zNqL8dHOT4fRm', 'OTwiGQa2ubSlIKQEI18yCb7fTOnBk6pm62PjjcKKJEUzhSLFCDEZrPuKnOo9', '2022-05-14 21:13:29', '2022-05-14 21:13:52'),
(5, 'آسیه', 0, 'asiye.sohrabi@gmail.com', NULL, '$2y$10$B325Z7pYpp186TsVpXw3/eyD2LwqfxG7qQeWpHsQVKDxh70TxUMrm', NULL, '2022-06-13 06:42:12', '2022-06-13 06:42:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`category_id`,`product_id`),
  ADD KEY `category_product_product_id_foreign` (`product_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category_product`
--
ALTER TABLE `category_product`
  ADD CONSTRAINT `category_product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
