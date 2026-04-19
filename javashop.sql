-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 19, 2026 at 08:04 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `javashop`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `bank_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `bank_name`, `account_number`, `account_name`, `logo`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'BCA', '1234567890', 'JavaShop Indonesia', NULL, 1, '2026-04-15 17:44:57', '2026-04-15 17:44:57'),
(2, 'BNI', '0987654321', 'JavaShop Indonesia', NULL, 1, '2026-04-15 17:44:57', '2026-04-15 17:44:57'),
(3, 'BRI', '1122334455', 'JavaShop Indonesia', NULL, 1, '2026-04-15 17:44:57', '2026-04-15 17:44:57');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image_url`, `link_url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(6, 'Elfaria', 'banners/01KPD5DVD9DPVNH6E34CHWT4WK.png', NULL, 0, 1, '2026-04-17 00:28:01', '2026-04-17 00:28:01'),
(7, 'Vivian', 'banners/01KPD5FPQ0AB08GGSGQTTVZH3K.jpg', NULL, 0, 1, '2026-04-17 00:29:02', '2026-04-17 00:29:02');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('javashop-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1776393754),
('javashop-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1776393754;', 1776393754),
('javashop-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:1;', 1776410995),
('javashop-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1776410995;', 1776410995),
('javashop-cache-un10102007@gmail.com|admin|127.0.0.1', 'i:1;', 1776481439),
('javashop-cache-un10102007@gmail.com|admin|127.0.0.1:timer', 'i:1776481439;', 1776481439);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `variant_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Arabika', 'arabika', NULL, 1, '2026-04-15 17:44:24', '2026-04-15 17:44:24'),
(2, 'Robusta', 'robusta', NULL, 1, '2026-04-15 17:44:24', '2026-04-15 17:44:24'),
(3, 'Blend', 'blend', NULL, 1, '2026-04-15 17:44:24', '2026-04-15 17:44:24'),
(4, 'Single Origin', 'single-origin', NULL, 1, '2026-04-15 17:44:24', '2026-04-15 17:44:24'),
(5, 'Decaf', 'decaf', NULL, 1, '2026-04-15 17:44:24', '2026-04-15 17:44:24'),
(6, 'my', 'my', NULL, 1, '2026-04-15 20:08:56', '2026-04-15 20:08:56');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"36aeb14e-67df-4564-acc0-2c6e06f0e1ef\",\"displayName\":\"App\\\\Notifications\\\\OrderConfirmedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:29:\\\"Illuminate\\\\Support\\\\Collection\\\":2:{s:8:\\\"\\u0000*\\u0000items\\\";a:1:{i:0;O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:20:\\\"un10102007@gmail.com\\\";}}}s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;}s:12:\\\"notification\\\";O:44:\\\"App\\\\Notifications\\\\OrderConfirmedNotification\\\":2:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"17a994b3-a4e0-42a6-ae23-628df0ac156f\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\",\"batchId\":null},\"createdAt\":1776386835,\"delay\":null}', 0, NULL, 1776386835, 1776386835),
(2, 'default', '{\"uuid\":\"97d9f1ff-b9cd-4503-9a29-d39c31960dd5\",\"displayName\":\"App\\\\Notifications\\\\OrderShippedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:29:\\\"Illuminate\\\\Support\\\\Collection\\\":2:{s:8:\\\"\\u0000*\\u0000items\\\";a:1:{i:0;O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:20:\\\"un10102007@gmail.com\\\";}}}s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;}s:12:\\\"notification\\\";O:42:\\\"App\\\\Notifications\\\\OrderShippedNotification\\\":2:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"ce96cee6-a167-4d11-9e10-b82a3a4112e4\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\",\"batchId\":null},\"createdAt\":1776388123,\"delay\":null}', 0, NULL, 1776388123, 1776388123),
(3, 'default', '{\"uuid\":\"d64dceec-dd8d-4582-963f-1cc93ef17be6\",\"displayName\":\"App\\\\Notifications\\\\OrderDeliveredNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:29:\\\"Illuminate\\\\Support\\\\Collection\\\":2:{s:8:\\\"\\u0000*\\u0000items\\\";a:1:{i:0;O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:20:\\\"un10102007@gmail.com\\\";}}}s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;}s:12:\\\"notification\\\";O:44:\\\"App\\\\Notifications\\\\OrderDeliveredNotification\\\":2:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"e99d189c-56b3-456a-b0e9-0ef432b708f7\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\",\"batchId\":null},\"createdAt\":1776388133,\"delay\":null}', 0, NULL, 1776388133, 1776388133),
(4, 'default', '{\"uuid\":\"37c2e8d9-c6f7-46d0-97c3-33c62a362b4b\",\"displayName\":\"App\\\\Notifications\\\\OrderShippedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:29:\\\"Illuminate\\\\Support\\\\Collection\\\":2:{s:8:\\\"\\u0000*\\u0000items\\\";a:1:{i:0;O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:22:\\\"huutaaoo1507@gmail.com\\\";}}}s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;}s:12:\\\"notification\\\";O:42:\\\"App\\\\Notifications\\\\OrderShippedNotification\\\":2:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"f06804c9-180e-4a94-b140-ca69d7de7f66\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\",\"batchId\":null},\"createdAt\":1776393600,\"delay\":null}', 0, NULL, 1776393600, 1776393600),
(5, 'default', '{\"uuid\":\"ff1be0fb-47db-4b31-952c-d117062df632\",\"displayName\":\"App\\\\Notifications\\\\OrderDeliveredNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:29:\\\"Illuminate\\\\Support\\\\Collection\\\":2:{s:8:\\\"\\u0000*\\u0000items\\\";a:1:{i:0;O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:22:\\\"huutaaoo1507@gmail.com\\\";}}}s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;}s:12:\\\"notification\\\";O:44:\\\"App\\\\Notifications\\\\OrderDeliveredNotification\\\":2:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"dbbd209f-dc91-4b75-bf00-df58979d408c\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\",\"batchId\":null},\"createdAt\":1776393613,\"delay\":null}', 0, NULL, 1776393613, 1776393613);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_01_000001_add_columns_to_users_table', 1),
(5, '2025_01_01_000002_create_user_addresses_table', 1),
(6, '2025_01_01_000003_create_categories_table', 1),
(7, '2025_01_01_000004_create_products_table', 1),
(8, '2025_01_01_000005_create_product_images_table', 1),
(9, '2025_01_01_000006_create_product_variants_table', 1),
(10, '2025_01_01_000007_create_cart_items_table', 1),
(11, '2025_01_01_000008_create_vouchers_table', 1),
(12, '2025_01_01_000009_create_orders_table', 1),
(13, '2025_01_01_000010_create_order_items_table', 1),
(14, '2025_01_01_000011_create_payments_table', 1),
(15, '2025_01_01_000012_create_bank_accounts_table', 1),
(16, '2025_01_01_000013_create_reviews_table', 1),
(17, '2025_01_01_000014_create_wishlists_table', 1),
(18, '2025_01_01_000015_create_notifications_table', 1),
(19, '2025_01_01_000016_create_voucher_usages_table', 1),
(20, '2026_04_16_031320_make_end_date_nullable_on_vouchers_table', 2),
(21, '2026_04_16_034230_create_banners_table', 3),
(22, '2026_04_16_044954_alter_orders_table_for_payment_flow', 4),
(23, '2026_04_16_065823_add_coordinates_to_user_addresses', 5),
(24, '2026_04_17_010421_add_snap_token_to_orders_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `address_id` bigint UNSIGNED NOT NULL,
  `voucher_id` bigint UNSIGNED DEFAULT NULL,
  `order_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending_admin','pending_payment','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'pending_admin',
  `payment_method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'midtrans',
  `subtotal` decimal(12,2) NOT NULL,
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL,
  `courier` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courier_service` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_token` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `voucher_id`, `order_number`, `status`, `payment_method`, `subtotal`, `shipping_cost`, `discount`, `total`, `courier`, `courier_service`, `tracking_number`, `snap_token`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 4, 'JVS-20260416-5883', 'pending_payment', 'midtrans', 999999.00, 0.00, 89999.91, 909999.09, NULL, NULL, NULL, NULL, 'aku jawa', '2026-04-15 21:32:34', '2026-04-16 18:06:15'),
(2, 2, 1, 4, 'JVS-20260416-6288', 'processing', 'midtrans', 572000.00, 0.00, 51480.00, 520520.00, NULL, NULL, NULL, NULL, NULL, '2026-04-15 22:57:08', '2026-04-16 17:47:39'),
(3, 2, 5, 4, 'JVS-20260417-2316', 'processing', 'cod', 100000.00, 7200.00, 9000.00, 98200.00, 'sicepat', 'BEST', NULL, NULL, NULL, '2026-04-16 17:41:26', '2026-04-16 17:47:12'),
(4, 2, 4, NULL, 'JVS-20260417-6969', 'delivered', 'midtrans', 55000.00, 8000.00, 0.00, 63000.00, 'jne', 'REG', NULL, NULL, NULL, '2026-04-16 17:56:55', '2026-04-16 18:08:53'),
(5, 2, 1, NULL, 'JVS-20260417-6188', 'pending_payment', 'midtrans', 110000.00, 8000.00, 0.00, 118000.00, 'jne', 'REG', NULL, NULL, NULL, '2026-04-16 17:59:00', '2026-04-16 18:06:15'),
(6, 2, 5, NULL, 'JVS-20260417-3104', 'cancelled', 'midtrans', 105000.00, 8000.00, 0.00, 113000.00, 'jne', 'REG', NULL, NULL, NULL, '2026-04-16 18:02:15', '2026-04-16 18:07:54'),
(7, 2, 5, NULL, 'JVS-20260417-6279', 'pending_payment', 'midtrans', 60000.00, 8000.00, 0.00, 68000.00, 'jne', 'REG', NULL, 'e096cca2-a852-4ac0-8203-2ef200c8c61d', NULL, '2026-04-16 18:10:13', '2026-04-16 18:10:23'),
(8, 3, 6, 4, 'JVS-20260417-8648', 'processing', 'midtrans', 1999998.00, 8000.00, 179999.82, 1827998.18, 'jne', 'REG', NULL, '44d857e5-8e37-4ef3-9460-a452c3063ed9', NULL, '2026-04-16 18:52:04', '2026-04-16 18:53:57'),
(9, 4, 7, 4, 'JVS-20260417-0225', 'delivered', 'midtrans', 196000.00, 7200.00, 17640.00, 185560.00, 'sicepat', 'BEST', NULL, '9740e3b3-3398-4366-97cb-4a4c6d985373', NULL, '2026-04-16 19:37:41', '2026-04-16 19:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `variant_id` bigint UNSIGNED DEFAULT NULL,
  `product_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variant_info` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `variant_id`, `product_name`, `variant_info`, `quantity`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 181, 'my kisah', '1kg · Extra Fine', 1, 999999.00, 999999.00, '2026-04-15 21:32:34', '2026-04-15 21:32:34'),
(2, 2, 121, 'Papua Wamena Single Origin', '100g · Biji Utuh', 1, 110000.00, 110000.00, '2026-04-15 22:57:08', '2026-04-15 22:57:08'),
(3, 2, 135, 'Papua Wamena Single Origin', '500g · Extra Fine', 1, 462000.00, 462000.00, '2026-04-15 22:57:10', '2026-04-15 22:57:10'),
(4, 3, 166, 'Decaf Sugarcane EA Process', '100g · Biji Utuh', 1, 100000.00, 100000.00, '2026-04-16 17:41:26', '2026-04-16 17:41:26'),
(5, 4, 46, 'Robusta Lampung Klasik', '100g · Biji Utuh', 1, 55000.00, 55000.00, '2026-04-16 17:56:55', '2026-04-16 17:56:55'),
(6, 5, 121, 'Papua Wamena Single Origin', '100g · Biji Utuh', 1, 110000.00, 110000.00, '2026-04-16 17:59:00', '2026-04-16 17:59:00'),
(7, 6, 136, 'Kintamani Bali Single Origin', '100g · Biji Utuh', 1, 105000.00, 105000.00, '2026-04-16 18:02:15', '2026-04-16 18:02:15'),
(8, 7, 61, 'Robusta Temanggung Java', '100g · Biji Utuh', 1, 60000.00, 60000.00, '2026-04-16 18:10:14', '2026-04-16 18:10:14'),
(9, 8, 181, 'my kisah', '1kg · Extra Fine', 2, 999999.00, 1999998.00, '2026-04-16 18:52:04', '2026-04-16 18:52:04'),
(10, 9, 8, 'Arabika Gayo Premium', '250g · Medium', 1, 196000.00, 196000.00, '2026-04-16 19:37:42', '2026-04-16 19:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `method` enum('bank_transfer','qris','midtrans') COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proof_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `midtrans_transaction_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `midtrans_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','confirmed','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `confirmed_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `method`, `bank_name`, `account_number`, `proof_image`, `amount`, `midtrans_transaction_id`, `midtrans_status`, `status`, `rejection_reason`, `confirmed_at`, `confirmed_by`, `created_at`, `updated_at`) VALUES
(1, 4, 'bank_transfer', NULL, NULL, NULL, 63000.00, '888ccf89-d5fe-45c0-b362-5d41152cac1f', 'settlement', 'confirmed', NULL, '2026-04-16 17:57:59', NULL, '2026-04-16 17:57:59', '2026-04-16 17:57:59'),
(2, 8, 'qris', NULL, NULL, NULL, 1827998.18, 'ad55cefa-eac1-45d9-a304-e58cc74bd081', 'settlement', 'confirmed', NULL, '2026-04-16 18:53:57', NULL, '2026-04-16 18:53:57', '2026-04-16 18:53:57'),
(3, 9, 'qris', NULL, NULL, NULL, 185560.00, '1bcdfebf-82a0-4181-8b6d-e26e5c5be8df', 'settlement', 'confirmed', NULL, '2026-04-16 19:38:47', NULL, '2026-04-16 19:38:47', '2026-04-16 19:38:47');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Arabika Gayo Premium', 'arabika-gayo-premium', 'Biji kopi Arabika pilihan dari dataran tinggi Gayo, Aceh. Ditanam di ketinggian 1.400-1.700 mdpl dengan suhu sejuk sepanjang tahun. Memiliki body yang full dan clean cup finish. Tasting notes: coklat hitam, buah beri hutan, dan herbal segar dengan keasaman yang cerah.', 1, '2026-04-15 17:44:24', '2026-04-15 17:44:24', NULL),
(2, 1, 'Arabika Toraja Sapan', 'arabika-toraja-sapan', 'Arabika premium dari wilayah Sapan, Tana Toraja, Sulawesi Selatan. Diproses secara wet-hull (Giling Basah) tradisional yang menghasilkan karakter unik kopi Toraja. Ketinggian 1.500 mdpl. Tasting notes: rempah-rempah hangat, karamel, tembakau manis, dan sedikit citrus di aftertaste.', 1, '2026-04-15 17:44:28', '2026-04-15 17:44:28', NULL),
(3, 1, 'Arabika Flores Bajawa', 'arabika-flores-bajawa', 'Kopi Arabika dari Bajawa, Flores, NTT. Ditanam di sekitar lereng vulkanik Gunung Inerie pada ketinggian 1.200-1.600 mdpl. Menghasilkan cita rasa yang kompleks dan khas. Tasting notes: coklat susu, kayu manis, madu, dan aroma floral yang lembut dengan body medium-full.', 1, '2026-04-15 17:44:30', '2026-04-15 17:44:30', NULL),
(4, 2, 'Robusta Lampung Klasik', 'robusta-lampung-klasik', 'Robusta fine dari dataran Lampung, Sumatera. Kopi ini telah menjadi tulang punggung industri kopi Indonesia. Full body dengan crema tebal, cocok untuk lovers espresso sejati. Tasting notes: roasted nut, dark chocolate, earthy, dan sedikit woody dengan keasaman rendah.', 1, '2026-04-15 17:44:33', '2026-04-15 17:44:33', NULL),
(5, 2, 'Robusta Temanggung Java', 'robusta-temanggung-java', 'Fine Robusta dari lereng Gunung Sindoro dan Sumbing, Temanggung, Jawa Tengah. Diproses natural (dijemur langsung) menghasilkan rasa yang lebih manis dan fruity dibanding Robusta pada umumnya. Tasting notes: karamel, kacang almond, dried fruit, dan sedikit spicy.', 1, '2026-04-15 17:44:34', '2026-04-15 17:44:34', NULL),
(6, 2, 'Robusta Dampit Malang', 'robusta-dampit-malang', 'Robusta premium dari Dampit, Malang, Jawa Timur. Tumbuh di ketinggian 600-800 mdpl dengan intensitas matahari yang optimal. Body tebal dan bold, sangat cocok untuk kopi tubruk dan espresso blend. Tasting notes: dark cocoa, roasted peanut, tobacco, dan aftertaste yang panjang.', 1, '2026-04-15 17:44:36', '2026-04-15 17:44:36', NULL),
(7, 3, 'JavaShop House Blend', 'javashop-house-blend', 'Signature blend JavaShop — racikan khusus dari 60% Arabika Gayo dan 40% Robusta Lampung. Diracik untuk menghasilkan profil rasa seimbang yang cocok untuk segala metode seduh. Medium roast. Tasting notes: coklat, caramel, nutty, dan sedikit fruity dengan body medium dan keasaman lembut.', 1, '2026-04-15 17:44:40', '2026-04-15 17:44:40', NULL),
(8, 3, 'Espresso Supreme Blend', 'espresso-supreme-blend', 'Blend premium untuk espresso sejati — 50% Arabika Toraja, 30% Robusta Temanggung, 20% Arabika Flores. Dark roast yang menghasilkan crema tebal dan kekayaan rasa yang luar biasa. Tasting notes: dark chocolate, burnt caramel, smoky, dan spice dengan body extra-full.', 1, '2026-04-15 17:44:41', '2026-04-15 17:44:41', NULL),
(9, 4, 'Papua Wamena Single Origin', 'papua-wamena-single-origin', 'Kopi langka dari Lembah Baliem, Wamena, Papua. Ditanam secara organik oleh suku Dani pada ketinggian 1.500-1.800 mdpl. Satu-satunya kopi dari wilayah paling timur Indonesia. Tasting notes: buah tropis, lemon zest, madu hutan, dan floral tea-like dengan body light-medium dan keasaman yang cerah.', 1, '2026-04-15 17:44:44', '2026-04-15 17:44:44', NULL),
(10, 4, 'Kintamani Bali Single Origin', 'kintamani-bali-single-origin', 'Arabika dari dataran tinggi Kintamani, Bali. Ditanam di antara pohon jeruk menggunakan sistem subak (irigasi tradisional Bali). Memiliki sertifikasi Geographical Indication. Ketinggian 1.200-1.600 mdpl. Tasting notes: citrus segar, brown sugar, vanilla, dan almond dengan keasaman tinggi dan body medium.', 1, '2026-04-15 17:44:48', '2026-04-15 17:44:48', NULL),
(11, 5, 'Decaf Mountain Water Arabika', 'decaf-mountain-water-arabika', 'Arabika Gayo yang diproses decaf menggunakan metode Swiss Water Process — tanpa bahan kimia, 99.9% bebas kafein. Tetap mempertahankan karakter rasa asli kopi Gayo dengan profil yang lebih lembut. Cocok untuk penikmat kopi malam hari. Tasting notes: caramel, walnut, milk chocolate dengan keasaman rendah dan body medium.', 1, '2026-04-15 17:44:52', '2026-04-15 17:44:52', NULL),
(12, 5, 'Decaf Sugarcane EA Process', 'decaf-sugarcane-ea-process', 'Arabika Flores yang diproses decaf menggunakan metode Ethyl Acetate alami dari tebu. Proses ini lebih ramah lingkungan dan mempertahankan rasa manis alami kopi. Tasting notes: brown sugar, stone fruit, honey, dan sedikit floral. Cocok untuk yang ingin menikmati kopi tanpa kafein tapi tetap kaya rasa.', 1, '2026-04-15 17:44:55', '2026-04-15 17:44:55', NULL),
(13, 4, 'my kisah', 'my-kisah', '<p>my kisah<br>hanya gambar, tidak beserta orang nya</p>', 1, '2026-04-15 19:58:11', '2026-04-15 19:58:11', NULL),
(16, 4, 'my kisah (Copy)', 'my-kisah-copy-1776308732', '<p>my kisah<br>hanya gambar, tidak beserta orang nya</p>', 1, '2026-04-15 20:05:32', '2026-04-15 20:08:14', '2026-04-15 20:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_primary`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=600&fit=crop', 1, 0, '2026-04-15 17:44:26', '2026-04-15 17:44:26'),
(2, 2, 'https://images.unsplash.com/photo-1587734195503-904fca47e0e9?w=600&fit=crop', 1, 0, '2026-04-15 17:44:28', '2026-04-15 17:44:28'),
(3, 3, 'https://images.unsplash.com/photo-1611854779393-1b2da9d400fe?w=600&fit=crop', 1, 0, '2026-04-15 17:44:30', '2026-04-15 17:44:30'),
(4, 4, 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefda?w=600&fit=crop', 1, 0, '2026-04-15 17:44:33', '2026-04-15 17:44:33'),
(5, 5, 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=600&fit=crop', 1, 0, '2026-04-15 17:44:35', '2026-04-15 17:44:35'),
(6, 6, 'https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=600&fit=crop', 1, 0, '2026-04-15 17:44:36', '2026-04-15 17:44:36'),
(7, 7, 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&fit=crop', 1, 0, '2026-04-15 17:44:40', '2026-04-15 17:44:40'),
(8, 8, 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=600&fit=crop', 1, 0, '2026-04-15 17:44:42', '2026-04-15 17:44:42'),
(9, 9, 'https://images.unsplash.com/photo-1504630083234-14187a9df0f5?w=600&fit=crop', 1, 0, '2026-04-15 17:44:44', '2026-04-15 17:44:44'),
(10, 10, 'https://images.unsplash.com/photo-1511920170033-f8396924c348?w=600&fit=crop', 1, 0, '2026-04-15 17:44:49', '2026-04-15 17:44:49'),
(11, 11, 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=600&fit=crop', 1, 0, '2026-04-15 17:44:52', '2026-04-15 17:44:52'),
(12, 12, 'https://images.unsplash.com/photo-1498804103079-a6351b050096?w=600&fit=crop', 1, 0, '2026-04-15 17:44:56', '2026-04-15 17:44:56'),
(13, 13, 'https://lh3.googleusercontent.com/pw/AP1GczN2Z7weI1jdPhyE1kY6kz3bht1n_qPWWEqOTy0ClmokyinizytFAVtUsRuZ3_Ta2IGAo2LNRboMuHDCJhxYVFT70eoJ4OCZwmVJrWrOcfWQQhHUlJaVHoz7brfOJe1trUWyHyMey2FR_2n9f3-JBZH9=w1079-h607-s-no-gm?authuser=0', 1, 0, '2026-04-15 19:58:11', '2026-04-15 19:59:31');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `size` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grind_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `size`, `grind_type`, `price`, `stock`, `sku`, `created_at`, `updated_at`) VALUES
(1, 1, '100g', 'Biji Utuh', 85000.00, 62, 'ARABIKA-GAYO-PREMIUM-100g-biji-utuh', '2026-04-15 17:44:26', '2026-04-15 17:44:26'),
(2, 1, '100g', 'Coarse', 85000.00, 43, 'ARABIKA-GAYO-PREMIUM-100g-coarse', '2026-04-15 17:44:26', '2026-04-15 17:44:26'),
(3, 1, '100g', 'Medium', 85000.00, 77, 'ARABIKA-GAYO-PREMIUM-100g-medium', '2026-04-15 17:44:27', '2026-04-15 17:44:27'),
(4, 1, '100g', 'Fine', 85000.00, 19, 'ARABIKA-GAYO-PREMIUM-100g-fine', '2026-04-15 17:44:27', '2026-04-15 17:44:27'),
(5, 1, '100g', 'Extra Fine', 85000.00, 15, 'ARABIKA-GAYO-PREMIUM-100g-extra-fine', '2026-04-15 17:44:27', '2026-04-15 17:44:27'),
(6, 1, '250g', 'Biji Utuh', 196000.00, 88, 'ARABIKA-GAYO-PREMIUM-250g-biji-utuh', '2026-04-15 17:44:27', '2026-04-15 17:44:27'),
(7, 1, '250g', 'Coarse', 196000.00, 49, 'ARABIKA-GAYO-PREMIUM-250g-coarse', '2026-04-15 17:44:27', '2026-04-15 17:44:27'),
(8, 1, '250g', 'Medium', 196000.00, 57, 'ARABIKA-GAYO-PREMIUM-250g-medium', '2026-04-15 17:44:27', '2026-04-16 19:37:42'),
(9, 1, '250g', 'Fine', 196000.00, 74, 'ARABIKA-GAYO-PREMIUM-250g-fine', '2026-04-15 17:44:28', '2026-04-15 17:44:28'),
(10, 1, '250g', 'Extra Fine', 196000.00, 70, 'ARABIKA-GAYO-PREMIUM-250g-extra-fine', '2026-04-15 17:44:28', '2026-04-15 17:44:28'),
(11, 1, '500g', 'Biji Utuh', 357000.00, 81, 'ARABIKA-GAYO-PREMIUM-500g-biji-utuh', '2026-04-15 17:44:28', '2026-04-15 17:44:28'),
(12, 1, '500g', 'Coarse', 357000.00, 66, 'ARABIKA-GAYO-PREMIUM-500g-coarse', '2026-04-15 17:44:28', '2026-04-15 17:44:28'),
(13, 1, '500g', 'Medium', 357000.00, 88, 'ARABIKA-GAYO-PREMIUM-500g-medium', '2026-04-15 17:44:28', '2026-04-15 17:44:28'),
(14, 1, '500g', 'Fine', 357000.00, 61, 'ARABIKA-GAYO-PREMIUM-500g-fine', '2026-04-15 17:44:28', '2026-04-15 17:44:28'),
(15, 1, '500g', 'Extra Fine', 357000.00, 15, 'ARABIKA-GAYO-PREMIUM-500g-extra-fine', '2026-04-15 17:44:28', '2026-04-15 17:44:28'),
(16, 2, '100g', 'Biji Utuh', 95000.00, 31, 'ARABIKA-TORAJA-SAPAN-100g-biji-utuh', '2026-04-15 17:44:29', '2026-04-15 17:44:29'),
(17, 2, '100g', 'Coarse', 95000.00, 74, 'ARABIKA-TORAJA-SAPAN-100g-coarse', '2026-04-15 17:44:29', '2026-04-15 17:44:29'),
(18, 2, '100g', 'Medium', 95000.00, 52, 'ARABIKA-TORAJA-SAPAN-100g-medium', '2026-04-15 17:44:29', '2026-04-15 17:44:29'),
(19, 2, '100g', 'Fine', 95000.00, 10, 'ARABIKA-TORAJA-SAPAN-100g-fine', '2026-04-15 17:44:29', '2026-04-15 17:44:29'),
(20, 2, '100g', 'Extra Fine', 95000.00, 39, 'ARABIKA-TORAJA-SAPAN-100g-extra-fine', '2026-04-15 17:44:29', '2026-04-15 17:44:29'),
(21, 2, '250g', 'Biji Utuh', 219000.00, 91, 'ARABIKA-TORAJA-SAPAN-250g-biji-utuh', '2026-04-15 17:44:29', '2026-04-15 17:44:29'),
(22, 2, '250g', 'Coarse', 219000.00, 99, 'ARABIKA-TORAJA-SAPAN-250g-coarse', '2026-04-15 17:44:29', '2026-04-15 17:44:29'),
(23, 2, '250g', 'Medium', 219000.00, 24, 'ARABIKA-TORAJA-SAPAN-250g-medium', '2026-04-15 17:44:29', '2026-04-15 17:44:29'),
(24, 2, '250g', 'Fine', 219000.00, 47, 'ARABIKA-TORAJA-SAPAN-250g-fine', '2026-04-15 17:44:29', '2026-04-15 17:44:29'),
(25, 2, '250g', 'Extra Fine', 219000.00, 98, 'ARABIKA-TORAJA-SAPAN-250g-extra-fine', '2026-04-15 17:44:30', '2026-04-15 17:44:30'),
(26, 2, '500g', 'Biji Utuh', 399000.00, 82, 'ARABIKA-TORAJA-SAPAN-500g-biji-utuh', '2026-04-15 17:44:30', '2026-04-15 17:44:30'),
(27, 2, '500g', 'Coarse', 399000.00, 56, 'ARABIKA-TORAJA-SAPAN-500g-coarse', '2026-04-15 17:44:30', '2026-04-15 17:44:30'),
(28, 2, '500g', 'Medium', 399000.00, 76, 'ARABIKA-TORAJA-SAPAN-500g-medium', '2026-04-15 17:44:30', '2026-04-15 17:44:30'),
(29, 2, '500g', 'Fine', 399000.00, 71, 'ARABIKA-TORAJA-SAPAN-500g-fine', '2026-04-15 17:44:30', '2026-04-15 17:44:30'),
(30, 2, '500g', 'Extra Fine', 399000.00, 54, 'ARABIKA-TORAJA-SAPAN-500g-extra-fine', '2026-04-15 17:44:30', '2026-04-15 17:44:30'),
(31, 3, '100g', 'Biji Utuh', 90000.00, 100, 'ARABIKA-FLORES-BAJAWA-100g-biji-utuh', '2026-04-15 17:44:30', '2026-04-15 17:44:30'),
(32, 3, '100g', 'Coarse', 90000.00, 14, 'ARABIKA-FLORES-BAJAWA-100g-coarse', '2026-04-15 17:44:30', '2026-04-15 17:44:30'),
(33, 3, '100g', 'Medium', 90000.00, 23, 'ARABIKA-FLORES-BAJAWA-100g-medium', '2026-04-15 17:44:30', '2026-04-15 17:44:30'),
(34, 3, '100g', 'Fine', 90000.00, 90, 'ARABIKA-FLORES-BAJAWA-100g-fine', '2026-04-15 17:44:31', '2026-04-15 17:44:31'),
(35, 3, '100g', 'Extra Fine', 90000.00, 78, 'ARABIKA-FLORES-BAJAWA-100g-extra-fine', '2026-04-15 17:44:32', '2026-04-15 17:44:32'),
(36, 3, '250g', 'Biji Utuh', 207000.00, 77, 'ARABIKA-FLORES-BAJAWA-250g-biji-utuh', '2026-04-15 17:44:32', '2026-04-15 17:44:32'),
(37, 3, '250g', 'Coarse', 207000.00, 80, 'ARABIKA-FLORES-BAJAWA-250g-coarse', '2026-04-15 17:44:32', '2026-04-15 17:44:32'),
(38, 3, '250g', 'Medium', 207000.00, 72, 'ARABIKA-FLORES-BAJAWA-250g-medium', '2026-04-15 17:44:32', '2026-04-15 17:44:32'),
(39, 3, '250g', 'Fine', 207000.00, 74, 'ARABIKA-FLORES-BAJAWA-250g-fine', '2026-04-15 17:44:32', '2026-04-15 17:44:32'),
(40, 3, '250g', 'Extra Fine', 207000.00, 99, 'ARABIKA-FLORES-BAJAWA-250g-extra-fine', '2026-04-15 17:44:32', '2026-04-15 17:44:32'),
(41, 3, '500g', 'Biji Utuh', 378000.00, 95, 'ARABIKA-FLORES-BAJAWA-500g-biji-utuh', '2026-04-15 17:44:32', '2026-04-15 17:44:32'),
(42, 3, '500g', 'Coarse', 378000.00, 10, 'ARABIKA-FLORES-BAJAWA-500g-coarse', '2026-04-15 17:44:32', '2026-04-15 17:44:32'),
(43, 3, '500g', 'Medium', 378000.00, 85, 'ARABIKA-FLORES-BAJAWA-500g-medium', '2026-04-15 17:44:32', '2026-04-15 17:44:32'),
(44, 3, '500g', 'Fine', 378000.00, 28, 'ARABIKA-FLORES-BAJAWA-500g-fine', '2026-04-15 17:44:33', '2026-04-15 17:44:33'),
(45, 3, '500g', 'Extra Fine', 378000.00, 19, 'ARABIKA-FLORES-BAJAWA-500g-extra-fine', '2026-04-15 17:44:33', '2026-04-15 17:44:33'),
(46, 4, '100g', 'Biji Utuh', 55000.00, 94, 'ROBUSTA-LAMPUNG-KLASIK-100g-biji-utuh', '2026-04-15 17:44:33', '2026-04-16 17:56:55'),
(47, 4, '100g', 'Coarse', 55000.00, 98, 'ROBUSTA-LAMPUNG-KLASIK-100g-coarse', '2026-04-15 17:44:33', '2026-04-15 17:44:33'),
(48, 4, '100g', 'Medium', 55000.00, 15, 'ROBUSTA-LAMPUNG-KLASIK-100g-medium', '2026-04-15 17:44:33', '2026-04-15 17:44:33'),
(49, 4, '100g', 'Fine', 55000.00, 64, 'ROBUSTA-LAMPUNG-KLASIK-100g-fine', '2026-04-15 17:44:33', '2026-04-15 17:44:33'),
(50, 4, '100g', 'Extra Fine', 55000.00, 56, 'ROBUSTA-LAMPUNG-KLASIK-100g-extra-fine', '2026-04-15 17:44:33', '2026-04-15 17:44:33'),
(51, 4, '250g', 'Biji Utuh', 127000.00, 38, 'ROBUSTA-LAMPUNG-KLASIK-250g-biji-utuh', '2026-04-15 17:44:33', '2026-04-15 17:44:33'),
(52, 4, '250g', 'Coarse', 127000.00, 17, 'ROBUSTA-LAMPUNG-KLASIK-250g-coarse', '2026-04-15 17:44:34', '2026-04-15 17:44:34'),
(53, 4, '250g', 'Medium', 127000.00, 87, 'ROBUSTA-LAMPUNG-KLASIK-250g-medium', '2026-04-15 17:44:34', '2026-04-15 17:44:34'),
(54, 4, '250g', 'Fine', 127000.00, 86, 'ROBUSTA-LAMPUNG-KLASIK-250g-fine', '2026-04-15 17:44:34', '2026-04-15 17:44:34'),
(55, 4, '250g', 'Extra Fine', 127000.00, 63, 'ROBUSTA-LAMPUNG-KLASIK-250g-extra-fine', '2026-04-15 17:44:34', '2026-04-15 17:44:34'),
(56, 4, '500g', 'Biji Utuh', 231000.00, 56, 'ROBUSTA-LAMPUNG-KLASIK-500g-biji-utuh', '2026-04-15 17:44:34', '2026-04-15 17:44:34'),
(57, 4, '500g', 'Coarse', 231000.00, 100, 'ROBUSTA-LAMPUNG-KLASIK-500g-coarse', '2026-04-15 17:44:34', '2026-04-15 17:44:34'),
(58, 4, '500g', 'Medium', 231000.00, 60, 'ROBUSTA-LAMPUNG-KLASIK-500g-medium', '2026-04-15 17:44:34', '2026-04-15 17:44:34'),
(59, 4, '500g', 'Fine', 231000.00, 44, 'ROBUSTA-LAMPUNG-KLASIK-500g-fine', '2026-04-15 17:44:34', '2026-04-15 17:44:34'),
(60, 4, '500g', 'Extra Fine', 231000.00, 32, 'ROBUSTA-LAMPUNG-KLASIK-500g-extra-fine', '2026-04-15 17:44:34', '2026-04-15 17:44:34'),
(61, 5, '100g', 'Biji Utuh', 60000.00, 49, 'ROBUSTA-TEMANGGUNG-JAVA-100g-biji-utuh', '2026-04-15 17:44:35', '2026-04-16 18:10:14'),
(62, 5, '100g', 'Coarse', 60000.00, 96, 'ROBUSTA-TEMANGGUNG-JAVA-100g-coarse', '2026-04-15 17:44:35', '2026-04-15 17:44:35'),
(63, 5, '100g', 'Medium', 60000.00, 57, 'ROBUSTA-TEMANGGUNG-JAVA-100g-medium', '2026-04-15 17:44:35', '2026-04-15 17:44:35'),
(64, 5, '100g', 'Fine', 60000.00, 87, 'ROBUSTA-TEMANGGUNG-JAVA-100g-fine', '2026-04-15 17:44:35', '2026-04-15 17:44:35'),
(65, 5, '100g', 'Extra Fine', 60000.00, 96, 'ROBUSTA-TEMANGGUNG-JAVA-100g-extra-fine', '2026-04-15 17:44:35', '2026-04-15 17:44:35'),
(66, 5, '250g', 'Biji Utuh', 138000.00, 92, 'ROBUSTA-TEMANGGUNG-JAVA-250g-biji-utuh', '2026-04-15 17:44:35', '2026-04-15 17:44:35'),
(67, 5, '250g', 'Coarse', 138000.00, 85, 'ROBUSTA-TEMANGGUNG-JAVA-250g-coarse', '2026-04-15 17:44:35', '2026-04-15 17:44:35'),
(68, 5, '250g', 'Medium', 138000.00, 95, 'ROBUSTA-TEMANGGUNG-JAVA-250g-medium', '2026-04-15 17:44:35', '2026-04-15 17:44:35'),
(69, 5, '250g', 'Fine', 138000.00, 31, 'ROBUSTA-TEMANGGUNG-JAVA-250g-fine', '2026-04-15 17:44:35', '2026-04-15 17:44:35'),
(70, 5, '250g', 'Extra Fine', 138000.00, 97, 'ROBUSTA-TEMANGGUNG-JAVA-250g-extra-fine', '2026-04-15 17:44:36', '2026-04-15 17:44:36'),
(71, 5, '500g', 'Biji Utuh', 252000.00, 41, 'ROBUSTA-TEMANGGUNG-JAVA-500g-biji-utuh', '2026-04-15 17:44:36', '2026-04-15 17:44:36'),
(72, 5, '500g', 'Coarse', 252000.00, 17, 'ROBUSTA-TEMANGGUNG-JAVA-500g-coarse', '2026-04-15 17:44:36', '2026-04-15 17:44:36'),
(73, 5, '500g', 'Medium', 252000.00, 35, 'ROBUSTA-TEMANGGUNG-JAVA-500g-medium', '2026-04-15 17:44:36', '2026-04-15 17:44:36'),
(74, 5, '500g', 'Fine', 252000.00, 23, 'ROBUSTA-TEMANGGUNG-JAVA-500g-fine', '2026-04-15 17:44:36', '2026-04-15 17:44:36'),
(75, 5, '500g', 'Extra Fine', 252000.00, 90, 'ROBUSTA-TEMANGGUNG-JAVA-500g-extra-fine', '2026-04-15 17:44:36', '2026-04-15 17:44:36'),
(76, 6, '100g', 'Biji Utuh', 50000.00, 34, 'ROBUSTA-DAMPIT-MALANG-100g-biji-utuh', '2026-04-15 17:44:36', '2026-04-15 17:44:36'),
(77, 6, '100g', 'Coarse', 50000.00, 51, 'ROBUSTA-DAMPIT-MALANG-100g-coarse', '2026-04-15 17:44:37', '2026-04-15 17:44:37'),
(78, 6, '100g', 'Medium', 50000.00, 23, 'ROBUSTA-DAMPIT-MALANG-100g-medium', '2026-04-15 17:44:37', '2026-04-15 17:44:37'),
(79, 6, '100g', 'Fine', 50000.00, 58, 'ROBUSTA-DAMPIT-MALANG-100g-fine', '2026-04-15 17:44:38', '2026-04-15 17:44:38'),
(80, 6, '100g', 'Extra Fine', 50000.00, 61, 'ROBUSTA-DAMPIT-MALANG-100g-extra-fine', '2026-04-15 17:44:38', '2026-04-15 17:44:38'),
(81, 6, '250g', 'Biji Utuh', 115000.00, 89, 'ROBUSTA-DAMPIT-MALANG-250g-biji-utuh', '2026-04-15 17:44:38', '2026-04-15 17:44:38'),
(82, 6, '250g', 'Coarse', 115000.00, 25, 'ROBUSTA-DAMPIT-MALANG-250g-coarse', '2026-04-15 17:44:39', '2026-04-15 17:44:39'),
(83, 6, '250g', 'Medium', 115000.00, 69, 'ROBUSTA-DAMPIT-MALANG-250g-medium', '2026-04-15 17:44:39', '2026-04-15 17:44:39'),
(84, 6, '250g', 'Fine', 115000.00, 28, 'ROBUSTA-DAMPIT-MALANG-250g-fine', '2026-04-15 17:44:39', '2026-04-15 17:44:39'),
(85, 6, '250g', 'Extra Fine', 115000.00, 82, 'ROBUSTA-DAMPIT-MALANG-250g-extra-fine', '2026-04-15 17:44:39', '2026-04-15 17:44:39'),
(86, 6, '500g', 'Biji Utuh', 210000.00, 31, 'ROBUSTA-DAMPIT-MALANG-500g-biji-utuh', '2026-04-15 17:44:39', '2026-04-15 17:44:39'),
(87, 6, '500g', 'Coarse', 210000.00, 31, 'ROBUSTA-DAMPIT-MALANG-500g-coarse', '2026-04-15 17:44:39', '2026-04-15 17:44:39'),
(88, 6, '500g', 'Medium', 210000.00, 67, 'ROBUSTA-DAMPIT-MALANG-500g-medium', '2026-04-15 17:44:39', '2026-04-15 17:44:39'),
(89, 6, '500g', 'Fine', 210000.00, 20, 'ROBUSTA-DAMPIT-MALANG-500g-fine', '2026-04-15 17:44:40', '2026-04-15 17:44:40'),
(90, 6, '500g', 'Extra Fine', 210000.00, 37, 'ROBUSTA-DAMPIT-MALANG-500g-extra-fine', '2026-04-15 17:44:40', '2026-04-15 17:44:40'),
(91, 7, '100g', 'Biji Utuh', 75000.00, 59, 'JAVASHOP-HOUSE-BLEND-100g-biji-utuh', '2026-04-15 17:44:40', '2026-04-15 17:44:40'),
(92, 7, '100g', 'Coarse', 75000.00, 82, 'JAVASHOP-HOUSE-BLEND-100g-coarse', '2026-04-15 17:44:40', '2026-04-15 17:44:40'),
(93, 7, '100g', 'Medium', 75000.00, 63, 'JAVASHOP-HOUSE-BLEND-100g-medium', '2026-04-15 17:44:40', '2026-04-15 17:44:40'),
(94, 7, '100g', 'Fine', 75000.00, 87, 'JAVASHOP-HOUSE-BLEND-100g-fine', '2026-04-15 17:44:40', '2026-04-15 17:44:40'),
(95, 7, '100g', 'Extra Fine', 75000.00, 42, 'JAVASHOP-HOUSE-BLEND-100g-extra-fine', '2026-04-15 17:44:40', '2026-04-15 17:44:40'),
(96, 7, '250g', 'Biji Utuh', 173000.00, 29, 'JAVASHOP-HOUSE-BLEND-250g-biji-utuh', '2026-04-15 17:44:40', '2026-04-15 17:44:40'),
(97, 7, '250g', 'Coarse', 173000.00, 91, 'JAVASHOP-HOUSE-BLEND-250g-coarse', '2026-04-15 17:44:41', '2026-04-15 17:44:41'),
(98, 7, '250g', 'Medium', 173000.00, 16, 'JAVASHOP-HOUSE-BLEND-250g-medium', '2026-04-15 17:44:41', '2026-04-15 17:44:41'),
(99, 7, '250g', 'Fine', 173000.00, 54, 'JAVASHOP-HOUSE-BLEND-250g-fine', '2026-04-15 17:44:41', '2026-04-15 17:44:41'),
(100, 7, '250g', 'Extra Fine', 173000.00, 93, 'JAVASHOP-HOUSE-BLEND-250g-extra-fine', '2026-04-15 17:44:41', '2026-04-15 17:44:41'),
(101, 7, '500g', 'Biji Utuh', 315000.00, 69, 'JAVASHOP-HOUSE-BLEND-500g-biji-utuh', '2026-04-15 17:44:41', '2026-04-15 17:44:41'),
(102, 7, '500g', 'Coarse', 315000.00, 86, 'JAVASHOP-HOUSE-BLEND-500g-coarse', '2026-04-15 17:44:41', '2026-04-15 17:44:41'),
(103, 7, '500g', 'Medium', 315000.00, 17, 'JAVASHOP-HOUSE-BLEND-500g-medium', '2026-04-15 17:44:41', '2026-04-15 17:44:41'),
(104, 7, '500g', 'Fine', 315000.00, 31, 'JAVASHOP-HOUSE-BLEND-500g-fine', '2026-04-15 17:44:41', '2026-04-15 17:44:41'),
(105, 7, '500g', 'Extra Fine', 315000.00, 91, 'JAVASHOP-HOUSE-BLEND-500g-extra-fine', '2026-04-15 17:44:41', '2026-04-15 17:44:41'),
(106, 8, '100g', 'Biji Utuh', 80000.00, 88, 'ESPRESSO-SUPREME-BLEND-100g-biji-utuh', '2026-04-15 17:44:42', '2026-04-15 17:44:42'),
(107, 8, '100g', 'Coarse', 80000.00, 58, 'ESPRESSO-SUPREME-BLEND-100g-coarse', '2026-04-15 17:44:42', '2026-04-15 17:44:42'),
(108, 8, '100g', 'Medium', 80000.00, 96, 'ESPRESSO-SUPREME-BLEND-100g-medium', '2026-04-15 17:44:42', '2026-04-15 17:44:42'),
(109, 8, '100g', 'Fine', 80000.00, 69, 'ESPRESSO-SUPREME-BLEND-100g-fine', '2026-04-15 17:44:42', '2026-04-15 17:44:42'),
(110, 8, '100g', 'Extra Fine', 80000.00, 61, 'ESPRESSO-SUPREME-BLEND-100g-extra-fine', '2026-04-15 17:44:42', '2026-04-15 17:44:42'),
(111, 8, '250g', 'Biji Utuh', 184000.00, 92, 'ESPRESSO-SUPREME-BLEND-250g-biji-utuh', '2026-04-15 17:44:42', '2026-04-15 17:44:42'),
(112, 8, '250g', 'Coarse', 184000.00, 82, 'ESPRESSO-SUPREME-BLEND-250g-coarse', '2026-04-15 17:44:42', '2026-04-15 17:44:42'),
(113, 8, '250g', 'Medium', 184000.00, 10, 'ESPRESSO-SUPREME-BLEND-250g-medium', '2026-04-15 17:44:42', '2026-04-15 17:44:42'),
(114, 8, '250g', 'Fine', 184000.00, 92, 'ESPRESSO-SUPREME-BLEND-250g-fine', '2026-04-15 17:44:43', '2026-04-15 17:44:43'),
(115, 8, '250g', 'Extra Fine', 184000.00, 93, 'ESPRESSO-SUPREME-BLEND-250g-extra-fine', '2026-04-15 17:44:43', '2026-04-15 17:44:43'),
(116, 8, '500g', 'Biji Utuh', 336000.00, 36, 'ESPRESSO-SUPREME-BLEND-500g-biji-utuh', '2026-04-15 17:44:44', '2026-04-15 17:44:44'),
(117, 8, '500g', 'Coarse', 336000.00, 33, 'ESPRESSO-SUPREME-BLEND-500g-coarse', '2026-04-15 17:44:44', '2026-04-15 17:44:44'),
(118, 8, '500g', 'Medium', 336000.00, 64, 'ESPRESSO-SUPREME-BLEND-500g-medium', '2026-04-15 17:44:44', '2026-04-15 17:44:44'),
(119, 8, '500g', 'Fine', 336000.00, 43, 'ESPRESSO-SUPREME-BLEND-500g-fine', '2026-04-15 17:44:44', '2026-04-15 17:44:44'),
(120, 8, '500g', 'Extra Fine', 336000.00, 42, 'ESPRESSO-SUPREME-BLEND-500g-extra-fine', '2026-04-15 17:44:44', '2026-04-15 17:44:44'),
(121, 9, '100g', 'Biji Utuh', 110000.00, 11, 'PAPUA-WAMENA-SINGLE-ORIGIN-100g-biji-utuh', '2026-04-15 17:44:45', '2026-04-16 17:59:00'),
(122, 9, '100g', 'Coarse', 110000.00, 87, 'PAPUA-WAMENA-SINGLE-ORIGIN-100g-coarse', '2026-04-15 17:44:46', '2026-04-15 17:44:46'),
(123, 9, '100g', 'Medium', 110000.00, 49, 'PAPUA-WAMENA-SINGLE-ORIGIN-100g-medium', '2026-04-15 17:44:46', '2026-04-15 17:44:46'),
(124, 9, '100g', 'Fine', 110000.00, 54, 'PAPUA-WAMENA-SINGLE-ORIGIN-100g-fine', '2026-04-15 17:44:47', '2026-04-15 17:44:47'),
(125, 9, '100g', 'Extra Fine', 110000.00, 14, 'PAPUA-WAMENA-SINGLE-ORIGIN-100g-extra-fine', '2026-04-15 17:44:47', '2026-04-15 17:44:47'),
(126, 9, '250g', 'Biji Utuh', 253000.00, 99, 'PAPUA-WAMENA-SINGLE-ORIGIN-250g-biji-utuh', '2026-04-15 17:44:47', '2026-04-15 17:44:47'),
(127, 9, '250g', 'Coarse', 253000.00, 76, 'PAPUA-WAMENA-SINGLE-ORIGIN-250g-coarse', '2026-04-15 17:44:47', '2026-04-15 17:44:47'),
(128, 9, '250g', 'Medium', 253000.00, 88, 'PAPUA-WAMENA-SINGLE-ORIGIN-250g-medium', '2026-04-15 17:44:47', '2026-04-15 17:44:47'),
(129, 9, '250g', 'Fine', 253000.00, 34, 'PAPUA-WAMENA-SINGLE-ORIGIN-250g-fine', '2026-04-15 17:44:47', '2026-04-15 17:44:47'),
(130, 9, '250g', 'Extra Fine', 253000.00, 57, 'PAPUA-WAMENA-SINGLE-ORIGIN-250g-extra-fine', '2026-04-15 17:44:47', '2026-04-15 17:44:47'),
(131, 9, '500g', 'Biji Utuh', 462000.00, 16, 'PAPUA-WAMENA-SINGLE-ORIGIN-500g-biji-utuh', '2026-04-15 17:44:47', '2026-04-15 17:44:47'),
(132, 9, '500g', 'Coarse', 462000.00, 91, 'PAPUA-WAMENA-SINGLE-ORIGIN-500g-coarse', '2026-04-15 17:44:47', '2026-04-15 17:44:47'),
(133, 9, '500g', 'Medium', 462000.00, 72, 'PAPUA-WAMENA-SINGLE-ORIGIN-500g-medium', '2026-04-15 17:44:48', '2026-04-15 17:44:48'),
(134, 9, '500g', 'Fine', 462000.00, 81, 'PAPUA-WAMENA-SINGLE-ORIGIN-500g-fine', '2026-04-15 17:44:48', '2026-04-15 17:44:48'),
(135, 9, '500g', 'Extra Fine', 462000.00, 43, 'PAPUA-WAMENA-SINGLE-ORIGIN-500g-extra-fine', '2026-04-15 17:44:48', '2026-04-15 22:57:10'),
(136, 10, '100g', 'Biji Utuh', 105000.00, 62, 'KINTAMANI-BALI-SINGLE-ORIGIN-100g-biji-utuh', '2026-04-15 17:44:49', '2026-04-16 18:07:54'),
(137, 10, '100g', 'Coarse', 105000.00, 83, 'KINTAMANI-BALI-SINGLE-ORIGIN-100g-coarse', '2026-04-15 17:44:49', '2026-04-15 17:44:49'),
(138, 10, '100g', 'Medium', 105000.00, 56, 'KINTAMANI-BALI-SINGLE-ORIGIN-100g-medium', '2026-04-15 17:44:49', '2026-04-15 17:44:49'),
(139, 10, '100g', 'Fine', 105000.00, 12, 'KINTAMANI-BALI-SINGLE-ORIGIN-100g-fine', '2026-04-15 17:44:49', '2026-04-15 17:44:49'),
(140, 10, '100g', 'Extra Fine', 105000.00, 97, 'KINTAMANI-BALI-SINGLE-ORIGIN-100g-extra-fine', '2026-04-15 17:44:49', '2026-04-15 17:44:49'),
(141, 10, '250g', 'Biji Utuh', 242000.00, 24, 'KINTAMANI-BALI-SINGLE-ORIGIN-250g-biji-utuh', '2026-04-15 17:44:49', '2026-04-15 17:44:49'),
(142, 10, '250g', 'Coarse', 242000.00, 75, 'KINTAMANI-BALI-SINGLE-ORIGIN-250g-coarse', '2026-04-15 17:44:49', '2026-04-15 17:44:49'),
(143, 10, '250g', 'Medium', 242000.00, 24, 'KINTAMANI-BALI-SINGLE-ORIGIN-250g-medium', '2026-04-15 17:44:49', '2026-04-15 17:44:49'),
(144, 10, '250g', 'Fine', 242000.00, 43, 'KINTAMANI-BALI-SINGLE-ORIGIN-250g-fine', '2026-04-15 17:44:49', '2026-04-15 17:44:49'),
(145, 10, '250g', 'Extra Fine', 242000.00, 16, 'KINTAMANI-BALI-SINGLE-ORIGIN-250g-extra-fine', '2026-04-15 17:44:49', '2026-04-15 17:44:49'),
(146, 10, '500g', 'Biji Utuh', 441000.00, 57, 'KINTAMANI-BALI-SINGLE-ORIGIN-500g-biji-utuh', '2026-04-15 17:44:50', '2026-04-15 17:44:50'),
(147, 10, '500g', 'Coarse', 441000.00, 23, 'KINTAMANI-BALI-SINGLE-ORIGIN-500g-coarse', '2026-04-15 17:44:50', '2026-04-15 17:44:50'),
(148, 10, '500g', 'Medium', 441000.00, 40, 'KINTAMANI-BALI-SINGLE-ORIGIN-500g-medium', '2026-04-15 17:44:51', '2026-04-15 17:44:51'),
(149, 10, '500g', 'Fine', 441000.00, 18, 'KINTAMANI-BALI-SINGLE-ORIGIN-500g-fine', '2026-04-15 17:44:51', '2026-04-15 17:44:51'),
(150, 10, '500g', 'Extra Fine', 441000.00, 49, 'KINTAMANI-BALI-SINGLE-ORIGIN-500g-extra-fine', '2026-04-15 17:44:51', '2026-04-15 17:44:51'),
(151, 11, '100g', 'Biji Utuh', 95000.00, 82, 'DECAF-MOUNTAIN-WATER-ARABIKA-100g-biji-utuh', '2026-04-15 17:44:52', '2026-04-15 17:44:52'),
(152, 11, '100g', 'Coarse', 95000.00, 15, 'DECAF-MOUNTAIN-WATER-ARABIKA-100g-coarse', '2026-04-15 17:44:52', '2026-04-15 17:44:52'),
(153, 11, '100g', 'Medium', 95000.00, 78, 'DECAF-MOUNTAIN-WATER-ARABIKA-100g-medium', '2026-04-15 17:44:52', '2026-04-15 17:44:52'),
(154, 11, '100g', 'Fine', 95000.00, 39, 'DECAF-MOUNTAIN-WATER-ARABIKA-100g-fine', '2026-04-15 17:44:52', '2026-04-15 17:44:52'),
(155, 11, '100g', 'Extra Fine', 95000.00, 39, 'DECAF-MOUNTAIN-WATER-ARABIKA-100g-extra-fine', '2026-04-15 17:44:52', '2026-04-15 17:44:52'),
(156, 11, '250g', 'Biji Utuh', 219000.00, 30, 'DECAF-MOUNTAIN-WATER-ARABIKA-250g-biji-utuh', '2026-04-15 17:44:52', '2026-04-15 17:44:52'),
(157, 11, '250g', 'Coarse', 219000.00, 41, 'DECAF-MOUNTAIN-WATER-ARABIKA-250g-coarse', '2026-04-15 17:44:52', '2026-04-15 17:44:52'),
(158, 11, '250g', 'Medium', 219000.00, 12, 'DECAF-MOUNTAIN-WATER-ARABIKA-250g-medium', '2026-04-15 17:44:53', '2026-04-15 17:44:53'),
(159, 11, '250g', 'Fine', 219000.00, 12, 'DECAF-MOUNTAIN-WATER-ARABIKA-250g-fine', '2026-04-15 17:44:53', '2026-04-15 17:44:53'),
(160, 11, '250g', 'Extra Fine', 219000.00, 83, 'DECAF-MOUNTAIN-WATER-ARABIKA-250g-extra-fine', '2026-04-15 17:44:53', '2026-04-15 17:44:53'),
(161, 11, '500g', 'Biji Utuh', 399000.00, 89, 'DECAF-MOUNTAIN-WATER-ARABIKA-500g-biji-utuh', '2026-04-15 17:44:53', '2026-04-15 17:44:53'),
(162, 11, '500g', 'Coarse', 399000.00, 29, 'DECAF-MOUNTAIN-WATER-ARABIKA-500g-coarse', '2026-04-15 17:44:53', '2026-04-15 17:44:53'),
(163, 11, '500g', 'Medium', 399000.00, 56, 'DECAF-MOUNTAIN-WATER-ARABIKA-500g-medium', '2026-04-15 17:44:54', '2026-04-15 17:44:54'),
(164, 11, '500g', 'Fine', 399000.00, 82, 'DECAF-MOUNTAIN-WATER-ARABIKA-500g-fine', '2026-04-15 17:44:54', '2026-04-15 17:44:54'),
(165, 11, '500g', 'Extra Fine', 399000.00, 10, 'DECAF-MOUNTAIN-WATER-ARABIKA-500g-extra-fine', '2026-04-15 17:44:55', '2026-04-15 17:44:55'),
(166, 12, '100g', 'Biji Utuh', 100000.00, 58, 'DECAF-SUGARCANE-EA-PROCESS-100g-biji-utuh', '2026-04-15 17:44:56', '2026-04-16 17:41:26'),
(167, 12, '100g', 'Coarse', 100000.00, 71, 'DECAF-SUGARCANE-EA-PROCESS-100g-coarse', '2026-04-15 17:44:56', '2026-04-15 17:44:56'),
(168, 12, '100g', 'Medium', 100000.00, 81, 'DECAF-SUGARCANE-EA-PROCESS-100g-medium', '2026-04-15 17:44:56', '2026-04-15 17:44:56'),
(169, 12, '100g', 'Fine', 100000.00, 31, 'DECAF-SUGARCANE-EA-PROCESS-100g-fine', '2026-04-15 17:44:56', '2026-04-15 17:44:56'),
(170, 12, '100g', 'Extra Fine', 100000.00, 97, 'DECAF-SUGARCANE-EA-PROCESS-100g-extra-fine', '2026-04-15 17:44:56', '2026-04-15 17:44:56'),
(171, 12, '250g', 'Biji Utuh', 230000.00, 92, 'DECAF-SUGARCANE-EA-PROCESS-250g-biji-utuh', '2026-04-15 17:44:56', '2026-04-15 17:44:56'),
(172, 12, '250g', 'Coarse', 230000.00, 85, 'DECAF-SUGARCANE-EA-PROCESS-250g-coarse', '2026-04-15 17:44:56', '2026-04-15 17:44:56'),
(173, 12, '250g', 'Medium', 230000.00, 39, 'DECAF-SUGARCANE-EA-PROCESS-250g-medium', '2026-04-15 17:44:56', '2026-04-15 17:44:56'),
(174, 12, '250g', 'Fine', 230000.00, 10, 'DECAF-SUGARCANE-EA-PROCESS-250g-fine', '2026-04-15 17:44:56', '2026-04-15 17:44:56'),
(175, 12, '250g', 'Extra Fine', 230000.00, 46, 'DECAF-SUGARCANE-EA-PROCESS-250g-extra-fine', '2026-04-15 17:44:57', '2026-04-15 17:44:57'),
(176, 12, '500g', 'Biji Utuh', 420000.00, 67, 'DECAF-SUGARCANE-EA-PROCESS-500g-biji-utuh', '2026-04-15 17:44:57', '2026-04-15 17:44:57'),
(177, 12, '500g', 'Coarse', 420000.00, 51, 'DECAF-SUGARCANE-EA-PROCESS-500g-coarse', '2026-04-15 17:44:57', '2026-04-15 17:44:57'),
(178, 12, '500g', 'Medium', 420000.00, 12, 'DECAF-SUGARCANE-EA-PROCESS-500g-medium', '2026-04-15 17:44:57', '2026-04-15 17:44:57'),
(179, 12, '500g', 'Fine', 420000.00, 100, 'DECAF-SUGARCANE-EA-PROCESS-500g-fine', '2026-04-15 17:44:57', '2026-04-15 17:44:57'),
(180, 12, '500g', 'Extra Fine', 420000.00, 27, 'DECAF-SUGARCANE-EA-PROCESS-500g-extra-fine', '2026-04-15 17:44:57', '2026-04-15 17:44:57'),
(181, 13, '1kg', 'Extra Fine', 999999.00, 6, 'my9', '2026-04-15 19:58:11', '2026-04-16 18:52:04');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `order_id`, `rating`, `comment`, `image`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 4, 5, 'jawa', NULL, 1, '2026-04-16 18:28:51', '2026-04-16 18:28:51'),
(2, 4, 1, 9, 5, 'Kopi enak bangget', NULL, 1, '2026-04-16 19:40:44', '2026-04-16 19:40:44');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Px7tPNu09IjzGCrF6b7qwNMQ6xPFPTVK2cmYuIjk', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJvMXk1QzRhc2d6RW5VUGtiVHZFNWc4Q3B5R2ZMVWFlMWN3VEdKaDR1IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluIiwicm91dGUiOiJmaWxhbWVudC5hZG1pbi5wYWdlcy5kYXNoYm9hcmQifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiNmM1MGFmNDAzZThjYjU4MDcyOGU0Nzk4NDFhYjM3YmJiMjZjMTNiZDYxZmFjOWM0ZGVlZGY0OGEwYjZmNGYyMCIsInRhYmxlcyI6eyJkNWMwYmFkYjQxNmRjYjk0NzkyMjg3NmVkOTE3MzE5OV9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InByb2R1Y3QubmFtZSIsImxhYmVsIjoiUHJvZHVrIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNpemUiLCJsYWJlbCI6IlVrdXJhbiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJncmluZF90eXBlIiwibGFiZWwiOiJHaWxpbmdhbiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzdG9jayIsImxhYmVsIjoiU3RvayIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9XSwiMmFmYWQ0NGNmM2M5NWJmNDBmZTVjZjI0NjE0M2ZiZGZfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJvcmRlcl9udW1iZXIiLCJsYWJlbCI6Ik5vLiBQZXNhbmFuIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InVzZXIubmFtZSIsImxhYmVsIjoiUGVsYW5nZ2FuIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InRvdGFsIiwibGFiZWwiOiJUb3RhbCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzdGF0dXMiLCJsYWJlbCI6IlN0YXR1cyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9XSwiMDk5MWIxZDIyODY0ZTcyYzBlODNlYjBhMmNkMDc3MjdfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpbWFnZXMuaW1hZ2VfdXJsIiwibGFiZWwiOiJGb3RvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Im5hbWUiLCJsYWJlbCI6Ik5hbWEiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY2F0ZWdvcnkubmFtZSIsImxhYmVsIjoiS2F0ZWdvcmkiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidmFyaWFudHNfc3VtX3N0b2NrIiwibGFiZWwiOiJTdG9rIFRvdGFsIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InZhcmlhbnRzX21pbl9wcmljZSIsImxhYmVsIjoiSGFyZ2EgRGFyaSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpc19hY3RpdmUiLCJsYWJlbCI6IkFrdGlmIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNyZWF0ZWRfYXQiLCJsYWJlbCI6IkRpYnVhdCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9XSwiZDVjMGJhZGI0MTZkY2I5NDc5MjI4NzZlZDkxNzMxOTlfcGVyX3BhZ2UiOiIxMCIsIjkzMDE0ZDhlYmJiODAzNTk2ZjVkZWViZmQxOWI1NTA4X2NvbHVtbnMiOlt7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoib3JkZXJfbnVtYmVyIiwibGFiZWwiOiJOby4gUGVzYW5hbiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ1c2VyLm5hbWUiLCJsYWJlbCI6IlBlbGFuZ2dhbiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJUYW5nZ2FsIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Iml0ZW1zX2NvdW50IiwibGFiZWwiOiJJdGVtcyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ0b3RhbCIsImxhYmVsIjoiVG90YWwiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicGF5bWVudC5tZXRob2QiLCJsYWJlbCI6Ik1ldG9kZSBCYXlhciIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJwYXltZW50LnN0YXR1cyIsImxhYmVsIjoiUGVtYmF5YXJhbiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzdGF0dXMiLCJsYWJlbCI6IlN0YXR1cyBQZXNhbmFuIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH1dfX0=', 1776504680);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('customer','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin JavaShop', 'admin@javashop.id', 'admin', NULL, NULL, '2026-04-15 17:44:22', '$2y$12$fv4mn/vlTlf34EpBHgpVPOLtcyswo0X8WZP8.DUHvIoEev.U4Qb4S', NULL, '2026-04-15 17:44:23', '2026-04-15 17:44:23'),
(2, 'bys', 'un10102007@gmail.com', 'customer', '083845879186', NULL, NULL, '$2y$12$056P8378eIozVK4vT2ond.ADMHB8Y31T.iHnPtQaN7vQxF35Bua52', NULL, '2026-04-15 20:22:07', '2026-04-17 20:02:05'),
(3, 'arena', 'arena@gmail.com', 'customer', NULL, NULL, NULL, '$2y$12$/DJ3L2V1AgdEwj/vxKGtQui9RcilVgBNJoauEbS/QTyErY4PNKvEG', NULL, '2026-04-16 18:46:24', '2026-04-16 18:46:24'),
(4, 'Brill', 'huutaaoo1507@gmail.com', 'customer', NULL, NULL, NULL, '$2y$12$SGsujdSeQEnfhR8FozC63.spUTV7mIqOWFX4HLUWGAu/fyGJLYys6', NULL, '2026-04-16 19:35:21', '2026-04-16 19:35:21'),
(5, 'jawa', 'jawa@gmail.com', 'customer', NULL, NULL, NULL, '$2y$12$Fl/cMNZ7bj3PIZI0zgKRleaV7x0tQzpRfbWOjGrMjjjgcPY5ZHJOG', NULL, '2026-04-17 00:26:25', '2026-04-17 00:26:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `label` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `label`, `recipient_name`, `phone`, `address`, `city`, `province`, `postal_code`, `latitude`, `longitude`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 2, 'Rumah', 'bys', '083845879186', 'SMK Negeri 5 Kendal', 'Kendal', 'Jawa Tengah', '51361', NULL, NULL, 0, '2026-04-15 21:32:05', '2026-04-15 21:32:05'),
(4, 2, 'Rumah', 'bys', '083845879186', 'Timbang, Weleri, Kendal, Jawa Tengah, Jawa, 51355, Indonesia', 'Kabupaten Kendal', 'Jawa Tengah', '51355', -6.98001629, 110.07576585, 0, '2026-04-16 03:42:56', '2026-04-16 03:42:56'),
(5, 2, 'Kantor', 'bys', '089876543210', 'Bogosari, Tembeleng, Kendal, Jawa Tengah, Jawa, 51363, Indonesia', 'Kabupaten Kendal', 'Jawa Tengah', '51363', -7.04962090, 110.05125558, 0, '2026-04-16 17:13:47', '2026-04-16 17:13:47'),
(6, 3, 'sekolah', 'arena', '083153740337', 'sekolah', 'Kabupaten Kendal', 'Jawa Tengah', '51361', -7.04532500, 110.04833221, 0, '2026-04-16 18:50:52', '2026-04-16 18:50:52'),
(7, 4, 'Rumah', 'Brill', '0987654321', 'Bogosari, Tembeleng, Kendal, Jawa Tengah, Jawa, 51363, Indonesia', 'Kabupaten Kendal', 'Jawa Tengah', '51363', -7.04938377, 110.05128356, 0, '2026-04-16 19:37:02', '2026-04-16 19:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('percentage','fixed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(12,2) NOT NULL,
  `min_purchase` decimal(12,2) NOT NULL DEFAULT '0.00',
  `max_discount` decimal(12,2) DEFAULT NULL,
  `quota` int DEFAULT NULL,
  `used_count` int NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `name`, `type`, `value`, `min_purchase`, `max_discount`, `quota`, `used_count`, `start_date`, `end_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'WELCOME10', 'Diskon Selamat Datang 10%', 'percentage', 10.00, 50000.00, NULL, 100, 0, '2026-01-01', '2026-12-31', 1, '2026-04-15 17:44:58', '2026-04-15 17:44:58'),
(2, 'KOPI50', 'Potongan Rp 50.000', 'fixed', 50000.00, 200000.00, NULL, 50, 0, '2026-01-01', '2026-12-31', 1, '2026-04-15 17:44:58', '2026-04-15 17:44:58'),
(3, 'JAVASHOP20', 'Diskon Special 20% (Max 100rb)', 'percentage', 20.00, 150000.00, 100000.00, 30, 0, '2026-01-01', '2026-12-31', 1, '2026-04-15 17:44:58', '2026-04-15 17:44:58'),
(4, 'AKUJAWA9', 'Khusus Jawa', 'percentage', 9.00, 0.00, NULL, 999, 5, '2026-04-16', NULL, 1, '2026-04-15 20:15:44', '2026-04-16 19:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `voucher_usages`
--

CREATE TABLE `voucher_usages` (
  `id` bigint UNSIGNED NOT NULL,
  `voucher_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `used_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voucher_usages`
--

INSERT INTO `voucher_usages` (`id`, `voucher_id`, `user_id`, `order_id`, `used_at`) VALUES
(1, 4, 2, 1, '2026-04-15 21:32:34'),
(2, 4, 2, 2, '2026-04-15 22:57:10'),
(3, 4, 2, 3, '2026-04-16 17:41:27'),
(4, 4, 3, 8, '2026-04-16 18:52:04'),
(5, 4, 4, 9, '2026-04-16 19:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(2, 4, 13, '2026-04-16 19:56:23', '2026-04-16 19:56:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_user_id_variant_id_unique` (`user_id`,`variant_id`),
  ADD KEY `cart_items_variant_id_foreign` (`variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_address_id_foreign` (`address_id`),
  ADD KEY `orders_voucher_id_foreign` (`voucher_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_variant_id_foreign` (`variant_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_confirmed_by_foreign` (`confirmed_by`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_sku_unique` (`sku`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_order_id_foreign` (`order_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_code_unique` (`code`);

--
-- Indexes for table `voucher_usages`
--
ALTER TABLE `voucher_usages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `voucher_usages_voucher_id_order_id_unique` (`voucher_id`,`order_id`),
  ADD KEY `voucher_usages_user_id_foreign` (`user_id`),
  ADD KEY `voucher_usages_order_id_foreign` (`order_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `voucher_usages`
--
ALTER TABLE `voucher_usages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `user_addresses` (`id`),
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_confirmed_by_foreign` FOREIGN KEY (`confirmed_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `voucher_usages`
--
ALTER TABLE `voucher_usages`
  ADD CONSTRAINT `voucher_usages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `voucher_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `voucher_usages_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`);

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
