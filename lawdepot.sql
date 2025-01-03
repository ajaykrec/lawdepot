-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 07:37 AM
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
-- Database: `lawdepot`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `banner_id` bigint(20) UNSIGNED NOT NULL,
  `bannercat_id` int(11) NOT NULL,
  `banner_image` varchar(200) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`banner_id`, `bannercat_id`, `banner_image`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(4, 2, '0.55058100-1735537182-vs-images.jpg', 1, '1', '2024-12-30 00:09:43', '2024-12-30 00:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `banners_categories`
--

DROP TABLE IF EXISTS `banners_categories`;
CREATE TABLE `banners_categories` (
  `bannercat_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners_categories`
--

INSERT INTO `banners_categories` (`bannercat_id`, `name`, `width`, `height`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Home Banner', 1200, 300, 1, '2024-12-24 05:58:25', '2024-12-24 05:58:25'),
(2, 'faq banner', 1200, 300, 1, '2024-12-30 00:08:24', '2024-12-30 00:08:24');

-- --------------------------------------------------------

--
-- Table structure for table `banners_language`
--

DROP TABLE IF EXISTS `banners_language`;
CREATE TABLE `banners_language` (
  `banner_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `banner_text` text DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners_language`
--

INSERT INTO `banners_language` (`banner_id`, `language_id`, `banner_text`, `url`, `created_at`, `updated_at`) VALUES
(4, 1, 'kkk', '', '2025-01-02 06:52:04', '2025-01-02 06:52:04'),
(4, 2, '', '', '2025-01-02 06:52:04', '2025-01-02 06:52:04'),
(4, 3, '', '', '2025-01-02 06:52:04', '2025-01-02 06:52:04');

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
CREATE TABLE `blocks` (
  `block_id` bigint(20) UNSIGNED NOT NULL,
  `identity` varchar(150) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`block_id`, `identity`, `status`, `created_at`, `updated_at`) VALUES
(2, '888', '1', '2024-12-28 04:37:57', '2024-12-28 04:37:57'),
(3, '8887', '1', '2024-12-28 04:38:27', '2024-12-28 04:38:27');

-- --------------------------------------------------------

--
-- Table structure for table `blocks_language`
--

DROP TABLE IF EXISTS `blocks_language`;
CREATE TABLE `blocks_language` (
  `block_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blocks_language`
--

INSERT INTO `blocks_language` (`block_id`, `language_id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(2, 1, 'ffff', '', '2024-12-28 04:38:02', '2024-12-28 04:38:02'),
(2, 2, 'fff', '', '2024-12-28 04:38:02', '2024-12-28 04:38:02'),
(2, 3, 'fff', '', '2024-12-28 04:38:02', '2024-12-28 04:38:02'),
(3, 1, 'ere', '<p>ere</p>', '2024-12-28 04:38:27', '2024-12-28 04:38:27'),
(3, 2, 'er', '<p>erer</p>', '2024-12-28 04:38:27', '2024-12-28 04:38:27'),
(3, 3, 'er', '<p>ere</p>', '2024-12-28 04:38:27', '2024-12-28 04:38:27');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `code` varchar(200) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `default` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `language_id`, `name`, `code`, `image`, `default`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'United Kingdom', 'uk', '0.69608500-1735542609-vs-en.png', 0, 1, 1, '2024-12-30 01:40:10', '2024-12-30 02:18:45'),
(3, 1, 'India', 'in', '0.48308200-1735543530-vs-in.png', 1, 2, 1, '2024-12-30 01:51:34', '2024-12-30 02:18:45'),
(4, 1, 'United States', 'us', '0.17957200-1735543692-vs-us.png', 0, 3, 1, '2024-12-30 01:58:12', '2024-12-30 02:21:11'),
(5, 1, 'Australia', 'au', '0.28374100-1735543828-vs-au.png', 0, 4, 1, '2024-12-30 02:00:28', '2024-12-30 02:18:45');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `password` varchar(150) DEFAULT NULL,
  `auth_provider` varchar(100) DEFAULT NULL,
  `auth_uid` varchar(150) DEFAULT NULL,
  `profile_photo` varchar(150) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `login_status` int(11) NOT NULL,
  `remember_token` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers_address`
--

DROP TABLE IF EXISTS `customers_address`;
CREATE TABLE `customers_address` (
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `postcode` varchar(15) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `city` varchar(150) DEFAULT NULL,
  `default` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers_document`
--

DROP TABLE IF EXISTS `customers_document`;
CREATE TABLE `customers_document` (
  `cus_document_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` int(11) NOT NULL,
  `document_file` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `template` text DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `country_id`, `category_id`, `name`, `slug`, `short_description`, `description`, `template`, `image`, `meta_title`, `meta_keyword`, `meta_description`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Residential Rental Agreement', 'residential-rental-agreement', 'creates a residential tenancy between a landlord and a tenant, and outlines the rights and responsibilities of each party during the term.', '<div style=\"color: #72818b; font-family: \'Open Sans\', sans-serif; font-size: medium; background-color: #ffffff;\">\r\n<h2 id=\"what-is-a-residential-rental-agreement\" style=\"color: #333333; font-size: 36px; font-weight: normal; margin-bottom: 25px;\">What is a Residential Rental Agreement?</h2>\r\n</div>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">A Residential Rental Agreement is an agreement that outlines the terms and conditions of a tenancy, including the rights and obligations of the landlord and tenant.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">You can use a Residential Rental Agreement to rent out various types of residential properties, including bungalows, flats, rooms, row houses, etc.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">A Residential Rental Agreement is also known as a:</p>\r\n<ul style=\"margin-left: 1.2em; margin-top: 0.2em; padding: 0px; font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">\r\n<li style=\"padding-bottom: 0.5em;\">Lease</li>\r\n<li style=\"padding-bottom: 0.5em;\">Rental contract</li>\r\n<li style=\"padding-bottom: 0.5em;\">Rental agreement</li>\r\n<li style=\"padding-bottom: 0.5em;\">Tenancy agreement</li>\r\n<li style=\"padding-bottom: 0.5em;\">Residential tenancy agreement</li>\r\n</ul>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">If you are looking to rent commercial property, use LawDepot\'s&nbsp;<a href=\"https://www.lawdepot.com/in/commercial-lease-agreement/\" target=\"_blank\" rel=\"noopener noreferrer nofollow\" style=\"outline: none; text-decoration-line: none; color: #88abac; font-weight: 600;\">Commercial Rental Agreement</a>.</p>\r\n<div style=\"color: #72818b; font-family: \'Open Sans\', sans-serif; font-size: medium; background-color: #ffffff;\">\r\n<h2 id=\"does-a-rental-agreement-need-to-be-notarised-in-india\" style=\"color: #333333; font-size: 36px; margin-top: 60px; font-weight: normal; margin-bottom: 25px;\">Does a Rental Agreement need to be notarised in India?</h2>\r\n</div>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">You don&rsquo;t need to notarise a Rental Agreement in India.</p>\r\n<div style=\"color: #72818b; font-family: \'Open Sans\', sans-serif; font-size: medium; background-color: #ffffff;\">\r\n<h2 id=\"how-do-i-write-a-residential-rental-agreement-in-india\" style=\"color: #333333; font-size: 36px; margin-top: 60px; font-weight: normal; margin-bottom: 25px;\">How do I write a Residential Rental Agreement in India?</h2>\r\n</div>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">You can easily create a Residential Rental Agreement by completing LawDepot&rsquo;s questionnaire. Using our template ensures you complete the following necessary steps.</p>\r\n<h3 id=\"1-state-the-type-of-property\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">1. State the type of property</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Start your Rental Agreement by selecting the type of rental property, such as a:</p>\r\n<ul style=\"margin-left: 1.2em; margin-top: 0.2em; padding: 0px; font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">\r\n<li style=\"padding-bottom: 0.5em;\">Bungalow</li>\r\n<li style=\"padding-bottom: 0.5em;\">Flat</li>\r\n<li style=\"padding-bottom: 0.5em;\">Room</li>\r\n<li style=\"padding-bottom: 0.5em;\">Row house</li>\r\n</ul>\r\n<h3 id=\"2-set-the-length-of-the-rental-agreement-\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">2. Set the length of the Rental Agreement</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">State when the Rental Agreement will start and end. You can choose to create a fixed-term lease or an automatic renewal lease.</p>\r\n<h4 style=\"color: #72818b; font-family: \'Open Sans\', sans-serif; font-size: medium; background-color: #ffffff;\">Fixed-term</h4>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">A rental agreement with a fixed-term ends on a set date. It can benefit both the landlord and tenant because the terms and conditions stay the same for the duration of the agreement.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">The landlord doesn\'t have to worry about the tenant breaking the lease early because the tenant is responsible for paying rent for the entire length of the agreement. On the other hand, the tenant doesn\'t have to worry about the rent increasing in price.</p>\r\n<h4 style=\"color: #72818b; font-family: \'Open Sans\', sans-serif; font-size: medium; background-color: #ffffff;\">Automatic renewal</h4>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">If you don\'t know when the agreement will come to an end, you can select this option. The Rental Agreement will automatically renew every month, 11 months, or yearly. This agreement will continue until one of the parties terminates it.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">To terminate the agreement, the landlord or tenant needs to provide a notice of their intention to leave as required by law. If the tenant doesn\'t move out at the end of the notice period, the landlord can provide them with an eviction notice.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Automatic renewal also gives the landlord the right to raise the rent or change the terms of the agreement as long as they provide the tenant with proper notice as required by law.</p>\r\n<h3 id=\"3-outline-details-about-the-property\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">3. Outline details about the property</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Provide as many details as you have available in your Rental Agreement, including the property&rsquo;s address and whether the property is furnished.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">If possible, attach photos of the property and include any additional details relevant to the agreement.</p>\r\n<h3 id=\"4-provide-the-parties-information\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">4. Provide the parties&rsquo; information</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Provide the names and contact details of all the parties involved in the Rental Agreement:</p>\r\n<ul style=\"margin-left: 1.2em; margin-top: 0.2em; padding: 0px; font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">\r\n<li style=\"padding-bottom: 0.5em;\"><span>Landlord</span>: The person or company who owns the property and allows the use of the space in exchange for rent.</li>\r\n<li style=\"padding-bottom: 0.5em;\"><span>Tenant</span>: The person who signs the Rental Agreement and is responsible for paying rent.</li>\r\n<li style=\"padding-bottom: 0.5em;\"><span>Occupants</span>: The people who live on the property but haven&rsquo;t signed the rental agreement, such as friends or family members of the tenant.</li>\r\n<li style=\"padding-bottom: 0.5em;\"><span>Guarantor</span>&nbsp;(if applicable): The person liable to the landlord for any breach of the agreement by the tenant. They can&rsquo;t be a tenant.</li>\r\n<li style=\"padding-bottom: 0.5em;\"><span>Property manager</span>&nbsp;(if applicable): The person who deals with the tenant and manages the rental property on behalf of the landlord, typically in return for a fee.</li>\r\n</ul>\r\n<h3 id=\"5-decide-on-a-method-for-rent-payments\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">5. Decide on a method for rent payments</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Decide on important rent details like:</p>\r\n<ul style=\"margin-left: 1.2em; margin-top: 0.2em; padding: 0px; font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">\r\n<li style=\"padding-bottom: 0.5em;\">The price of rent</li>\r\n<li style=\"padding-bottom: 0.5em;\">When rent is due</li>\r\n<li style=\"padding-bottom: 0.5em;\">How the tenant will pay (e.g., cash, cheque, bank deposit)</li>\r\n</ul>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">States and territories have different laws about rent control, and some may have differing regulations for the cities within them.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Different states may also have different rules about charging fair rent, which is the amount of money a tenant can expect to pay to rent a property. You should ensure that you know the rules about fair rent in your area to determine how much you can charge.</p>\r\n<h3 id=\"6-state-if-pets-or-smoking-is-permitted\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">6. State if pets or smoking is permitted</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Landlords will have differing policies on allowing pets or smoking inside the property. It&rsquo;s a good idea to discuss these topics before entering into a Rental Agreement.</p>\r\n<h3 id=\"7-provide-rental-deposit-details\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">7. Provide rental deposit details</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">A rental deposit is a sum of money the tenant pays to the landlord to guarantee that the tenant will fulfil their obligations under the Rental Agreement.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">The landlord can use the deposit to fix any damage that occurs during the tenant\'s occupancy. However, the deposit doesn\'t cover normal wear and tear. At the end of the agreement, if there is no damage to the property, the landlord must return the deposit to the tenant.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Before you add a rental deposit, you should ensure that landlords can hold rental deposits in your state or territory.</p>\r\n<h3 id=\"8-state-the-amount-of-notice-the-landlord-needs-to-provide-to-enter-the-property\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">8. State the amount of notice the landlord needs to provide to enter the property</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">The landlord doesn&rsquo;t have the right to enter the property unless there&rsquo;s an emergency. However, the landlord may enter the property if he or she provides reasonable notice to the tenant. A written notice of 24 to 48 hours explaining when and why the landlord will enter the property is typically reasonable for non-emergencies. You can specify how much of a notice the landlord must provide the tenant in the Rental Agreement.</p>\r\n<h3 id=\"9-state-the-amount-of-notice-needed-to-terminate-the-agreement\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">9. State the amount of notice needed to terminate the agreement</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">State in the questionnaire how many days notice the landlord needs to give the tenant before they can terminate the Rental Agreement.</p>\r\n<h3 id=\"10-outline-who-will-pay-for-services-and-amenities\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">10. Outline who will pay for services and amenities</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">There are instances where the price of rent will include some services and amenities. The landlord and tenant should discuss which additional charges are the tenant&rsquo;s responsibility.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Additional charges can include:</p>\r\n<ul style=\"margin-left: 1.2em; margin-top: 0.2em; padding: 0px; font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">\r\n<li style=\"padding-bottom: 0.5em;\">Electricity</li>\r\n<li style=\"padding-bottom: 0.5em;\">Water</li>\r\n<li style=\"padding-bottom: 0.5em;\">Sanitation</li>\r\n<li style=\"padding-bottom: 0.5em;\">Drainage</li>\r\n<li style=\"padding-bottom: 0.5em;\">Air conditioning</li>\r\n<li style=\"padding-bottom: 0.5em;\">Additional storage space</li>\r\n<li style=\"padding-bottom: 0.5em;\">Other charges</li>\r\n</ul>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Different states and union territories have varying rules about what a landlord can charge a tenant as an additional charge. You should ensure that you are permitted by the law to add additional charges to your Rental Agreement.</p>\r\n<h3 id=\"11-outline-improvements-that-need-to-be-made-to-the-property\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">11. Outline improvements that need to be made to the property</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Landlord improvements are enhancements to the property made by the landlord. They can include something as simple as putting on a new coat of paint to complex renovations. They typically occur before the tenant moves in.</p>\r\n<h3 id=\"12-state-if-there-will-be-a-walkthrough-inspection\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">12. State if there will be a walkthrough inspection</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">An inspection report is a written record of any existing damage observed during a walkthrough of the property by the tenant and landlord.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Most landlords will want to conduct a walkthrough inspection at the beginning and end of the Rental Agreement to record the property&rsquo;s condition.</p>\r\n<h3 id=\"13-outline-any-additional-clauses\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">13. Outline any additional clauses</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">If there are any terms or conditions unique to your situation that the questionnaire didn\'t address, you can include them here.</p>\r\n<h3 id=\"14-provide-the-signing-details\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">14. Provide the signing details</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Provide the date the landlord and tenant will sign the Rental Agreement.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">LawDepot&rsquo;s questionnaire gives you the option to include space to print your document on stamp paper. Your Rental Agreement may be required to be printed on stamp paper. Check with your local authority to confirm.</p>\r\n<div style=\"color: #72818b; font-family: \'Open Sans\', sans-serif; font-size: medium; background-color: #ffffff;\">\r\n<h2 id=\"why-is-a-rental-agreement-important\" style=\"color: #333333; font-size: 36px; margin-top: 60px; font-weight: normal; margin-bottom: 25px;\">Why is a Rental Agreement important?</h2>\r\n</div>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Rental Agreements come with a lot of advantages for the landlord and tenant.</p>\r\n<h3 id=\"for-the-landlord\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">For the landlord</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">A Rental Agreement gives a landlord leverage when seeking reimbursement for any damage done to the property or appliances while the tenant occupies the property.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">The landlord also needs a Rental Agreement to penalize the tenant for late rent payments since the document outlines the terms for penalties and additional charges.</p>\r\n<h3 id=\"for-the-tenant\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">For the tenant</h3>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Without a Rental Agreement, the landlord may have the right to evict the tenant by providing a minimum of 30 days\' notice. It would be more difficult for a tenant to fight the eviction in court without the proof of residency that the Rental Agreement provides.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">A fixed-term Rental Agreement also prevents the landlord the ability to raise the rent for the duration of the agreement.</p>\r\n<p style=\"font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">It may be a good idea to look up your state or territory&rsquo;s rent control laws for more specifics. For example, a person interested in renting a property in Bangalore should look to the&nbsp;<a href=\"https://dpal.karnataka.gov.in/storage/pdf-files/ao2001/34%20of%202001%20(E).pdf\" rel=\"noopener noreferrer nofollow\" target=\"_blank\" style=\"outline: none; text-decoration-line: none; color: #88abac; font-weight: 600;\">Karnataka Rent Control Act, 2001</a>, while someone in Hyderabad should look to&nbsp;<a href=\"https://www.indiacode.nic.in/bitstream/123456789/8607/1/act_15_of_1960.pdf\" target=\"_blank\" rel=\"noopener noreferrer nofollow\" style=\"outline: none; text-decoration-line: none; color: #88abac; font-weight: 600;\">The Telangana Buildings (Lease, Rent and Eviction) Control Act, 1960</a>.</p>\r\n<h3 id=\"relatedDocsTitle\" style=\"margin: 30px 0px 20px; font-weight: normal; font-size: 24px; color: #454857; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">Related Documents:</h3>\r\n<ul id=\"relatedDocsUS\" class=\"relatedDocs\" style=\"margin-left: 1.2em; margin-top: 0.2em; padding: 0px; margin-bottom: 0px; font-size: 18px; color: #72818b; font-family: \'Open Sans\', sans-serif; background-color: #ffffff;\">\r\n<li style=\"padding-bottom: 0.5em;\"><a href=\"https://www.lawdepot.com/in/rental-application-form/\" target=\"_blank\" style=\"outline: none; text-decoration-line: none; color: #88abac; font-weight: 600;\" rel=\"noopener\">Residential Rental Application</a>: Collect information to screen potential tenants for a rental property.</li>\r\n<li style=\"padding-bottom: 0.5em;\"><a href=\"https://www.lawdepot.com/in/commercial-lease-agreement/\" target=\"_blank\" style=\"outline: none; text-decoration-line: none; color: #88abac; font-weight: 600;\" rel=\"noopener\">Commercial Rental Agreement</a>: Lease a commercial space to a business tenant and include details about the rights, duties, and responsibilities of the landlord and tenant.</li>\r\n</ul>', '<div class=\" outputDocument residentialLease outputDocument\">\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Center;\"><span>RESIDENTIAL RENTAL AGREEMENT</span></p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Left;\"><span>THIS LEASE</span> (the \"Lease\") dated this 12th day of December, 2024</p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Left;\">BETWEEN:</p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Center; margin-top: 24.0pt;\"><span>krisha kumar</span></p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Center;\">(the \"Landlord\")</p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Center;\">- AND-</p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Center; margin-top: 17.0pt;\"><span>rahul kumar, _____________________________, _____________________________ and _____________________________</span></p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Center;\">(collectively and individually the \"Tenant\")</p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Center;\">- AND-</p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Center; margin-top: 17.0pt;\"><span>gopi kishan</span></p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Center;\">(the \"Guarantor\")</p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Center;\">(individually the &ldquo;Party&rdquo; and collectively the &ldquo;Parties&rdquo;)</p>\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Left;\"><span>IN CONSIDERATION OF</span> the Landlord leasing certain premises to the Tenant and other valuable consideration, the receipt and sufficiency of which consideration is hereby acknowledged, the Parties agree as follows:</p>\r\n<ol start=\"1\" style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; list-style: decimal;\">\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Leased Property</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"1\"><span>The Landlord agrees to rent to the Tenant the condo, municipally described as ______________________________________________ (the \"Property\"), for use as residential premises only. A photo of the Property is hereby attached to this Lease.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"2\"><span>Subject to the provisions of this Lease, apart from the Tenant, no other persons will live in the Property without the prior written permission of the Landlord.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"3\"><span>No guests of the Tenants may occupy the Property for longer than one week without the prior written permission of the Landlord.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"4\"><span>No pets or animals are allowed to be kept in or about the Property.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"5\"><span>Smoking is permitted on the Property. The Tenant will be responsible for all damage caused by smoking including, but not limited to, stains, burns, odors and removal of debris.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"6\"><span>The Landlord agrees to supply and the Tenant agrees to use and maintain in reasonable condition, normal wear and tear excepted, the following furnishings: ________________________________________________________________________________<br />________________________________________________________________________________</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Term</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"7\"><span>The term of the Lease is a periodic tenancy commencing at 12:00 noon on 18 December 2024 and continuing on a year-to-year basis until the Landlord or the Tenant terminates the tenancy.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"8\"><span>Notwithstanding that the term of this Lease commences on 18 December 2024, the Tenant is entitled to possession of the Property at 12:00 noon on 27 December 2024.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"9\"><span>Upon the greater of 30 days\' notice and any notice required under the applicable legislation of the National Capital Territory of Delhi (the \"Act\"), the Landlord may terminate this tenancy if the Tenant has defaulted in the payment of any portion of the Rent when due, and that amount is still due after any grace period required by the Act, or the Tenant has breached any provision of this rental.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Rent</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"10\"><span>Subject to the provisions of this Lease, the rent for the Property is ₹5,000.00</span> per year (the \"Rent\").<span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"11\"><span>The Tenant will pay the Rent on or before the 10th of each and every year of the term of this Lease to the Landlord at 45 gho lane road kol-58 or at such other place as the Landlord may later designate by _________________________________</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Rental Deposit</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"12\"><span>On execution of this Lease, the Tenant will pay the Landlord a security deposit of ₹4,000.00</span> (the \"Security Deposit\").<span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"13\"><span>The Landlord will return the Security Deposit at the end of this tenancy, less such deductions as provided in this Lease but no deduction will be made for damage due to reasonable wear and tear nor for any deduction prohibited by the Act.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"14\"><span>During the term of this Lease or after its termination, the Landlord may charge the Tenant or make deductions from the Security Deposit for any or all of the following:</span> <span> <br /></span>\r\n<ol start=\"1\" style=\"list-style: lower-alpha;\">\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"1\"><span>repair of walls due to plugs, large nails or any unreasonable number of holes in the walls including the repainting of such damaged walls;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"2\"><span>repainting required to repair the results of any other improper use or excessive damage by the Tenant;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"3\"><span>unplugging toilets, sinks and drains;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"4\"><span>replacing damaged or missing doors, windows, screens, mirrors or light fixtures;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"5\"><span>repairing cuts, burns, or water damage to linoleum, rugs, and other areas;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"6\"><span>any other repairs or cleaning due to any damage beyond normal wear and tear caused or permitted by the Tenant or by any person for whom the Tenant is responsible;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"7\"><span>the cost of extermination where the Tenant or the Tenant\'s guests have brought or allowed insects into the Property or building;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"8\"><span>repairs and replacement required where windows are left open which directly or indirectly causes rain or water damage to floors, walls, structure, or plumbing;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"9\"><span>replacement of locks or lost keys for the Property and any administrative fees associated with the replacement as a result of the Tenant\'s misplacement of the keys; and</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 0.0pt;\" value=\"10\"><span>any other purpose allowed under this Lease or the Act.</span> <span> <br /></span></li>\r\n</ol>\r\n</li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"15\"><span>The Tenant may not use the Security Deposit as payment for the Rent.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"16\"><span>Within the lesser of 10</span> and any time period required by the Act and after the termination of this tenancy, the Landlord will deliver or mail the Security Deposit less any proper deductions or with further demand for payment to: ________________________________________________________, or at such other place as the Tenant may advise.<span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Guarantor</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"17\"><span>The Guarantor, gopi kishan</span> of _________________________, guarantees to the Landlord that the Tenant will comply with the Tenant\'s obligations under this Lease arising during the original term, any renewed or additional term, and any resulting periodic tenancy by virtue of statute, contract or consent. As such, the Guarantor agrees to compensate the Landlord in full on demand for<span> <br /></span>\r\n<ol start=\"1\" style=\"list-style: lower-alpha;\">\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"1\"><span>the Rent during any time the Tenant occupies the Property;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"2\"><span>if the Tenant fails to pay the Rent according to this Lease, the arrears and any fees charged by or to the Landlord for the collection of the Rent according to this Lease; and</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 0.0pt;\" value=\"3\"><span>any damage caused by the Tenant\'s negligence or willful act or that of the Tenant\'s employee, family, agent, or visitor, if the Tenant fails to rectify, or pay to rectify, that damage.</span> <span> <br /></span></li>\r\n</ol>\r\n</li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"18\"><span>The Guarantor&rsquo;s obligation to guarantee survives the termination or expiry of this Lease. The Guarantor\'s obligations remain fully effective even if this Lease is disclaimed or the Landlord gives the Tenant extra time to comply with any obligation or does not insist on strict compliance with its terms.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Quiet Enjoyment</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"19\"><span>The Landlord covenants that on paying the Rent and performing the covenants contained in this Lease, the Tenant will peacefully and quietly have, hold, and enjoy the Property for the agreed term.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Inspections</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"20\"><span>The Tenant acknowledges that the Tenant inspected the Property, including the grounds and all buildings and improvements, and that they are, at the time of the execution of this Lease, in good order, good repair, safe, clean, and tenantable condition.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"21\"><span>At all reasonable times during the term of this Lease and any renewal of this Lease, the Landlord and its agents may enter the Property to make inspections or repairs, or to show the Property to prospective tenants or purchasers upon the greater of 0 hours\' notice to the Tenant and any notice required by the Act.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Tenant Improvements</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"22\"><span>The Tenant will obtain written permission from the Landlord before doing any of the following: </span> <span> <br /></span>\r\n<ol start=\"1\" style=\"list-style: lower-alpha;\">\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"1\"><span>applying adhesive materials, or inserting nails or hooks in walls or ceilings other than two small picture hooks per wall;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"2\"><span>painting, wallpapering, redecorating or in any way significantly altering the appearance of the Property;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"3\"><span>removing or adding walls, or performing any structural alterations;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"4\"><span>changing the amount of heat or power normally used on the Property as well as installing additional electrical wiring or heating units;</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"5\"><span>placing or exposing or allowing to be placed or exposed anywhere inside or outside the Property any placard, notice or sign for advertising or any other purpose; or</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 0.0pt;\" value=\"6\"><span>affixing to or erecting upon or near the Property any radio or TV antenna or tower.</span> <span> <br /></span></li>\r\n</ol>\r\n</li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Additional Charges</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"23\"><span>The Tenant is responsible for the payment of the following charges in relation to the Property: electricity, water, sanitation, drainage, air conditioning, property/house tax and additional storage space.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Attorney Fees</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"24\"><span>In the event that any action is filed in relation to this Lease, the unsuccessful Party in the action will pay to the successful Party, in addition to all the sums that either Party may be called on to pay, a reasonable sum for the successful Party\'s attorney fees.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Governing Law</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"25\"><span>This Lease will be construed in accordance with, and exclusively governed by, the laws of the National Capital Territory of Delhi.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Severability</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"26\"><span>If there is a conflict between any provision of this Lease and the Act, the Act will prevail and such provisions of the Lease will be amended or deleted as necessary in order to comply with the Act. Further, any provisions that are required by the Act are incorporated into this Lease.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"27\"><span>The invalidity or unenforceability of any provisions of this Lease will not affect the validity or enforceability of any other provision of this Lease. Such other provisions remain in full force and effect.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Amendment of Lease</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"28\"><span>This Lease may only be amended or modified by a written document executed by the Parties.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Assignment and Subletting</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"29\"><span>Without the prior, express, and written consent of the Landlord, the Tenant will not assign this Lease, or sublet or grant any concession or licence to use the Property or any part of the Property. A consent by the Landlord to one assignment, subletting, concession, or licence will not be deemed to be a consent to any subsequent assignment, subletting, concession, or licence. Any assignment, subletting, concession, or licence without the prior written consent of the Landlord, or an assignment or subletting by operation of law, will be void and will, at the Landlord\'s option, terminate this Lease.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Maintenance</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"30\"><span>The Tenant will, at its sole expense, keep and maintain the Property and appurtenances in good and sanitary condition and repair during the term of this Lease and any renewal of this Lease.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"31\"><span>Major maintenance and repair of the Property not due to the Tenant\'s misuse, waste, or neglect or that of the Tenant\'s employee, family, agent, or visitor, will be the responsibility of the Landlord or the Landlord\'s assigns.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Care and Use of Property</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"32\"><span>The Tenant will promptly notify the Landlord of any damage, or of any situation that may significantly interfere with the normal use of the Property or to any furnishings supplied by the Landlord.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"33\"><span>The Tenant will not engage in any illegal trade or activity on or about the Property.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"34\"><span>The Parties will comply with standards of health, sanitation, fire, housing and safety as required by law.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"35\"><span>If the Tenant is absent from the Property and the Property is unoccupied for a period of 4 consecutive days or longer, the Tenant will arrange for regular inspection by a competent person. The Landlord will be notified in advance as to the name, address and phone number of the person doing the inspections.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"36\"><span>At the expiration of the term of this Lease, the Tenant will quit and surrender the Property in as good a state and condition as they were at the commencement of this Lease, reasonable use and wear and tear excepted.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"37\"><span>During the term of this Lease or after its termination, the Landlord may charge the Tenant for replacement of locks and/or lost keys to the Property, and any administrative fees associated with the replacement as a result of the Tenant\'s misplacement of the keys.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Rules and Regulations</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"38\"><span>The Tenant will obey all rules and regulations of the Landlord regarding the Property.</span> <span> <br /></span></li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>Address for Notice</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"39\"><span>For any matter relating to this tenancy, the Tenant may be contacted at the Property or through the phone number below. After this tenancy has been terminated, the contact information of the Tenant is:</span> <span> <br /></span>\r\n<ol start=\"1\" style=\"list-style: lower-alpha;\">\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"1\"><span>Name: rahul kumar, _____________________________, _____________________________ and _____________________________</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"2\"><span>Phone: 9874563210.</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 0.0pt;\" value=\"3\"><span>Post termination notice address: ________________________________________________________</span> <span> <br /></span></li>\r\n</ol>\r\n</li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"40\"><span>For any matter relating to this tenancy, whether during or after this tenancy has been terminated, the Guarantor\'s address for notice is:</span> <span> <br /></span>\r\n<ol start=\"1\" style=\"list-style: lower-alpha;\">\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"1\"><span>Name: gopi kishan.</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 0.0pt;\" value=\"2\"><span>Address: _________________________</span> <span> <br /></span></li>\r\n</ol>\r\n</li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"41\"><span>For any matter relating to this tenancy, whether during or after this tenancy has been terminated, the Landlord\'s address for notice is:</span> <span> <br /></span>\r\n<ol start=\"1\" style=\"list-style: lower-alpha;\">\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"1\"><span>Name: krisha kumar.</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"2\"><span>Address: 45 gho lane road kol-58.</span> <span> <br /></span>\r\n<p style=\"text-align: Left;\">The contact information for the Property Manager of the Landlord is:</p>\r\n</li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"3\"><span>Name: tttt.</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 18.0pt;\" value=\"4\"><span>Phone: 9874563210.</span> <span> <br /></span></li>\r\n<li style=\"margin-bottom: 0.0pt;\" value=\"5\"><span>Email: tt.</span> <span> <br /></span></li>\r\n</ol>\r\n</li>\r\n<li class=\"lhl\" style=\"line-height: 18.0pt; text-align: Left; margin-bottom: 16.0pt; list-style: none;\"><span>General Provisions</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"42\"><span>All monetary amounts stated or referred to in this Lease are based in the Indian rupee.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"43\"><span>Any waiver by the Landlord of any failure by the Tenant to perform or observe the provisions of this Lease will not operate as a waiver of the Landlord\'s rights under this Lease in respect of any subsequent defaults, breaches or non-performance and will not defeat or affect in any way the Landlord\'s rights in respect of any subsequent default or breach.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"44\"><span>This Lease will extend to and be binding upon and inure to the benefit of the respective heirs, executors, administrators, successors and assigns, as the case may be, of each Party. All covenants are to be construed as conditions of this Lease.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"45\"><span>All sums payable by the Tenant to the Landlord pursuant to any provision of this Lease will be deemed to be additional rent and will be recovered by the Landlord as rental arrears.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"46\"><span>Where there is more than one Tenant executing this Lease, all Tenants are jointly and severally liable for each other\'s acts, omissions and liabilities pursuant to this Lease.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"47\"><span>Locks may not be added or changed without the prior written agreement of both Parties.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"48\"><span>Headings are inserted for the convenience of the Parties only and are not to be considered when interpreting this Lease. Words in the singular mean and include the plural and vice versa. Words in the masculine mean and include the feminine and vice versa.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"49\"><span>This Lease may be executed in counterparts. Facsimile signatures are binding and are considered to be original signatures.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"50\"><span>This Lease constitutes the entire agreement between the Parties. Any prior understanding or representation of any kind preceding the date of this Lease will not be binding on either Party except to the extent incorporated in this Lease.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"51\"><span>The Tenant will indemnify and save the Landlord, and the owner of the Property where different from the Landlord, harmless from all liabilities, fines, suits, claims, demands and actions of any kind or nature for which the Landlord will or may become liable or suffer by reason of any breach, violation or non-performance by the Tenant or by any person for whom the Tenant is responsible, of any covenant, term, or provisions hereof or by reason of any act, neglect or default on the part of the Tenant or other person for whom the Tenant is responsible. Such indemnification in respect of any such breach, violation or non-performance, damage to property, injury or death occurring during the term of the Lease will survive the termination of the Lease, notwithstanding anything in this Lease to the contrary.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"52\"><span>The Tenant agrees that the Landlord will not be liable or responsible in any way for any personal injury or death that may be suffered or sustained by the Tenant or by any person for whom the Tenant is responsible who may be on the Property of the Landlord or for any loss of or damage or injury to any property, including cars and contents thereof belonging to the Tenant or to any other person for whom the Tenant is responsible.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"53\"><span>The Tenant is responsible for any person or persons who are upon or occupying the Property or any other part of the Landlord\'s premises at the request of the Tenant, either express or implied, whether for the purposes of visiting the Tenant, making deliveries, repairs or attending upon the Property for any other reason. Without limiting the generality of the foregoing, the Tenant is responsible for all members of the Tenant\'s family, guests, servants, tradesmen, repairmen, employees, agents, invitees or other similar persons.</span> <span> <br /></span></li>\r\n<li style=\"line-height: 18.0pt; margin-bottom: 16.0pt;\" value=\"54\"><span>Time is of the essence in this Lease.</span> <span> <br /></span></li>\r\n</ol>\r\n<div class=\" keepTogether\">\r\n<p style=\"line-height: 18.0pt; font-size: 12.0pt; font-family: Times New Roman; color: #000000; text-align: Left; margin-top: 34.0pt;\"><span>IN WITNESS WHEREOF</span> rahul kumar, _____________________________, _____________________________ and _____________________________ and krisha kumar and gopi kishan have duly affixed their signatures on this 12th day of December, 2024.</p>\r\n<div>\r\n<table style=\"line-height: 18.0pt; margin-left: auto; margin-right: auto; margin-top: 22.0pt; width: 100%; border-collapse: separate; border-spacing: 0pt;\"><colgroup> <col style=\"width: 50%;\" /> <col style=\"width: 50%;\" /></colgroup>\r\n<tbody>\r\n<tr>\r\n<td style=\"text-align: Right; vertical-align: Bottom; padding: 16.0pt; width: 50%;\">&nbsp;</td>\r\n<td style=\"text-align: Left; vertical-align: Bottom; padding: 16.0pt; width: 50%;\">\r\n<p style=\"font-size: 12.0pt; line-height: 18.0pt; font-family: Times New Roman; color: #000000; text-align: Left;\">krisha kumar<br /><br />Per:____________________________ (Seal)</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: Right; vertical-align: Bottom; padding: 16.0pt; width: 50%;\">&nbsp;</td>\r\n<td style=\"text-align: Left; vertical-align: Bottom; padding: 16.0pt; width: 50%;\">\r\n<p style=\"font-size: 12.0pt; line-height: 18.0pt; font-family: Times New Roman; color: #000000; text-align: Left;\">_______________________________<br />rahul kumar</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: Right; vertical-align: Bottom; padding: 16.0pt; width: 50%;\">&nbsp;</td>\r\n<td style=\"text-align: Left; vertical-align: Bottom; padding: 16.0pt; width: 50%;\">\r\n<p style=\"font-size: 12.0pt; line-height: 18.0pt; font-family: Times New Roman; color: #000000; text-align: Left;\">_______________________________<br />______________________(Tenant)</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: Right; vertical-align: Bottom; padding: 16.0pt; width: 50%;\">&nbsp;</td>\r\n<td style=\"text-align: Left; vertical-align: Bottom; padding: 16.0pt; width: 50%;\">\r\n<p style=\"font-size: 12.0pt; line-height: 18.0pt; font-family: Times New Roman; color: #000000; text-align: Left;\">_______________________________<br />______________________(Tenant)</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: Right; vertical-align: Bottom; padding: 16.0pt; width: 50%;\">&nbsp;</td>\r\n<td style=\"text-align: Left; vertical-align: Bottom; padding: 16.0pt; width: 50%;\">\r\n<p style=\"font-size: 12.0pt; line-height: 18.0pt; font-family: Times New Roman; color: #000000; text-align: Left;\">_______________________________<br />______________________(Tenant)</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<table style=\"line-height: 18.0pt; margin-left: auto; margin-right: auto; margin-top: 22.0pt; width: 100%; border-collapse: separate; border-spacing: 0pt;\"><colgroup> <col style=\"width: 50%;\" /> <col style=\"width: 50%;\" /></colgroup>\r\n<tbody>\r\n<tr>\r\n<td style=\"text-align: Left; vertical-align: Middle; padding: 16.0pt; width: 50%;\">&nbsp;</td>\r\n<td style=\"text-align: Left; vertical-align: Middle; padding: 16.0pt; width: 50%;\"><span>_________________________________<br />Guarantor: gopi kishan<br /><br /></span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n</div>', '0.32395300-1735631574-vs-thali-1.png', 'Free Residential Rental Agreement Template', NULL, 'Need a simple Tenancy Agreement in India? Create, print or download your own customized Tenancy Agreement for free now. It allows you to set lease terms.', 1, 1, '2024-12-31 02:12:49', '2024-12-31 02:22:54');

-- --------------------------------------------------------

--
-- Table structure for table `documents_category`
--

DROP TABLE IF EXISTS `documents_category`;
CREATE TABLE `documents_category` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `banner_image` varchar(150) DEFAULT NULL,
  `banner_text` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents_category`
--

INSERT INTO `documents_category` (`category_id`, `parent_id`, `country_id`, `name`, `slug`, `image`, `banner_image`, `banner_text`, `content`, `meta_title`, `meta_keyword`, `meta_description`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 3, 'Real Estate', 'real-estate', '', '', '', '', 'Real Estate', '', '', 1, 1, '2024-12-30 05:42:31', '2024-12-30 05:50:18'),
(3, 0, 3, 'Financial', 'financial', '', '', '', '', 'Financial', '', '', 2, 1, '2024-12-30 05:50:50', '2024-12-30 05:50:50'),
(4, 0, 3, 'Business', 'business', '', '', '', '', 'Business', '', '', 3, 1, '2024-12-30 05:51:12', '2024-12-30 05:51:12'),
(5, 0, 3, 'Family', 'family', '', '', '', '', 'Family', '', '', 4, 1, '2024-12-30 05:51:37', '2024-12-30 05:51:37'),
(6, 0, 5, 'Real Estate', 'real-estate', '', '', '', '', '', '', '', 0, 1, '2024-12-30 05:53:22', '2024-12-30 05:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `documents_question`
--

DROP TABLE IF EXISTS `documents_question`;
CREATE TABLE `documents_question` (
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `label` varchar(150) DEFAULT NULL,
  `question` varchar(150) DEFAULT NULL,
  `placeholder` varchar(150) DEFAULT NULL,
  `answer_type` varchar(50) DEFAULT NULL COMMENT 'text, textarea, dropdown, radio, checkbox, date, image, file',
  `display_type` tinyint(4) NOT NULL COMMENT '0:vertical, 1:horizontal',
  `field_name` varchar(150) DEFAULT NULL,
  `label_group` int(11) NOT NULL,
  `is_add_another` tinyint(4) NOT NULL COMMENT '0:No, 1:Yes',
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents_question`
--

INSERT INTO `documents_question` (`question_id`, `document_id`, `step_id`, `option_id`, `label`, `question`, `placeholder`, `answer_type`, `display_type`, `field_name`, `label_group`, `is_add_another`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, '0000999', 'What type of property is being rented?', '', 'radio', 1, 'type_of_property', 0, 0, 0, '2025-01-02 01:36:50', '2025-01-03 00:59:21'),
(3, 1, 0, 11, 'Property Location', 'Where is the rental property located?', NULL, 'dropdown', 0, 'property_location', 1, 0, 0, '2025-01-02 02:06:39', '2025-01-02 02:06:39'),
(10, 1, 0, 7, '', 'Describe the property', '(e.g. farmhouse)', 'text', 0, 'describe_property', 0, 0, 0, '2025-01-03 00:00:35', '2025-01-03 01:00:06');

-- --------------------------------------------------------

--
-- Table structure for table `documents_question_option`
--

DROP TABLE IF EXISTS `documents_question_option`;
CREATE TABLE `documents_question_option` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `image` varchar(150) DEFAULT NULL,
  `placeholder` varchar(150) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `is_table_value` tinyint(4) NOT NULL COMMENT '0:No, 1:Yes',
  `is_sub_question` tinyint(4) NOT NULL COMMENT '0:No, 1:Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents_question_option`
--

INSERT INTO `documents_question_option` (`option_id`, `document_id`, `question_id`, `image`, `placeholder`, `title`, `value`, `is_table_value`, `is_sub_question`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '0.80156300-1735825426-vs-house.png', NULL, 'House', 'House', 0, 0, '2025-01-02 07:47:44', '2025-01-02 08:13:46'),
(2, 1, 1, '0.97502100-1735825497-vs-apartment.png', '', 'Apartment', 'Apartment', 0, 0, '2025-01-02 08:14:45', '2025-01-03 00:56:32'),
(3, 1, 1, '0.15345400-1735825532-vs-condo.png', NULL, 'Condo', 'Condo', 0, 0, '2025-01-02 08:15:32', '2025-01-02 08:15:32'),
(4, 1, 1, '0.42808100-1735825556-vs-duplex.png', NULL, 'Duplex', 'Duplex', 0, 0, '2025-01-02 08:15:56', '2025-01-02 08:15:56'),
(5, 1, 1, '0.84333100-1735825577-vs-mobile.png', NULL, 'Mobile Home', 'Mobile Home', 0, 0, '2025-01-02 08:16:17', '2025-01-02 08:16:17'),
(6, 1, 1, '0.68620200-1735825603-vs-room.png', NULL, 'Room', 'Room', 0, 0, '2025-01-02 08:16:43', '2025-01-02 08:16:43'),
(7, 1, 1, '0.75955300-1735825647-vs-other.png', NULL, 'Other', 'Other', 0, 1, '2025-01-02 08:17:27', '2025-01-02 08:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `documents_step`
--

DROP TABLE IF EXISTS `documents_step`;
CREATE TABLE `documents_step` (
  `step_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents_step`
--

INSERT INTO `documents_step` (`step_id`, `document_id`, `name`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'General', 1, 1, '2024-12-31 06:00:49', '2024-12-31 06:00:49'),
(2, 1, 'Property', 2, 1, '2024-12-31 06:01:40', '2024-12-31 06:01:40'),
(3, 1, 'Parties', 3, 1, '2024-12-31 06:01:53', '2024-12-31 06:01:53'),
(4, 1, 'Terms', 4, 1, '2024-12-31 06:02:07', '2024-12-31 06:02:07'),
(5, 1, 'Final Details', 5, 1, '2024-12-31 06:02:22', '2024-12-31 06:02:22'),
(6, 1, 'Signing', 6, 1, '2024-12-31 06:08:20', '2024-12-31 06:13:13');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE `email_templates` (
  `email_template_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `parameters` text DEFAULT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`email_template_id`, `title`, `subject`, `body`, `parameters`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Contact Us ( Notification To User )', 'Docmaker : Confirmation for your inquiry', '<table style=\"width: 600px; border: solid 1px #38b000; font-family: \'Verdana\'; font-size: 15px; background: #fff; color: #707070;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"left\">\r\n<tbody>\r\n<tr>\r\n<td style=\"background-color: #f6f9fe; padding: 25px 15px; border-bottom: solid 1px #ccc; text-align: center;\"><a href=\"{site_url}\" target=\"_blank\" rel=\"noopener\"><img src=\"{logo}\" style=\"height: 40px;\" /></a></td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<table style=\"width: 100%;\" cellspacing=\"0\" cellpadding=\"2\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<div style=\"padding: 25px; font-size: 15px; color: #707070;\">\r\n<p>Dear <span>{name}</span>,</p>\r\n<p>We received your information. We will get back to you soon. Your inquiry details are:</p>\r\n<table style=\"width: 100%; background: #ccc; font-size: 15px; color: #707070;\" cellspacing=\"1\" cellpadding=\"10\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"background: #fff;\" width=\"30%;\"><span>Name</span></td>\r\n<td style=\"background: #fff;\" width=\"70%\"><span>{name}</span></td>\r\n</tr>\r\n<tr>\r\n<td style=\"background: #fff;\" width=\"30%;\"><span>Email</span></td>\r\n<td style=\"background: #fff;\" width=\"70%\"><span>{email}</span></td>\r\n</tr>\r\n<tr>\r\n<td style=\"background: #fff;\" width=\"30%;\"><span>Subject</span></td>\r\n<td style=\"background: #fff;\" width=\"70%\"><span>{subject}</span></td>\r\n</tr>\r\n<tr>\r\n<td style=\"background: #fff;\" width=\"30%;\"><span>Message</span></td>\r\n<td style=\"background: #fff;\"><span>{message}</span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Thank you again,<br />{site_name}</p>\r\n</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"background-color: #38b000; text-align: center; padding: 20px 15px; color: #fff;\">{site_name} &copy; 2024. All Rights Reserved.</td>\r\n</tr>\r\n</tbody>\r\n</table>', NULL, '1', '2023-12-27 01:18:48', '2024-12-23 09:27:28'),
(2, 'Reset Password', 'Docmaker : Reset Password', '<table style=\"width: 600px; border: solid 1px #38b000; font-family: \'Verdana\'; font-size: 15px; background: #fff; color: #707070;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"left\">\r\n<tbody>\r\n<tr>\r\n<td style=\"background-color: #f6f9fe; padding: 25px 15px; border-bottom: solid 1px #ccc; text-align: center;\"><a href=\"{site_url}\" target=\"_blank\" rel=\"noopener\"><img src=\"{logo}\" style=\"height: 40px;\" /></a></td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<table style=\"width: 100%;\" cellspacing=\"0\" cellpadding=\"2\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<div style=\"padding: 25px; font-size: 15px; color: #707070;\">\r\n<p>Hello!</p>\r\n<p>You are receiving this email because we received a password reset request for your account.</p>\r\n<p><a href=\"{reset_password_link}\">Reset Password</a></p>\r\n<p>This password reset link will expire in 60 minutes.</p>\r\n<p>If you did not request a password reset, no further action is required.</p>\r\n<p>Regards,</p>\r\n<p>{site_name}</p>\r\n<p>If you\'re having trouble clicking the \"Reset Password\" button, copy and paste the URL below into your web browser: {reset_password_link}</p>\r\n</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"background-color: #38b000; text-align: center; padding: 20px 15px; color: #fff;\">{site_name} &copy; 2024. All Rights Reserved.</td>\r\n</tr>\r\n</tbody>\r\n</table>', NULL, '1', '2023-12-29 10:00:09', '2024-12-23 09:27:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `faq_id` bigint(20) UNSIGNED NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs_language`
--

DROP TABLE IF EXISTS `faqs_language`;
CREATE TABLE `faqs_language` (
  `faq_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
CREATE TABLE `language` (
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `code` varchar(200) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `default` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`language_id`, `name`, `code`, `image`, `default`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', '0.69025300 1735302940-vs-en.png', 1, 1, 1, '2024-12-23 16:10:17', '2025-01-02 00:33:02'),
(2, 'French', 'fr', '0.98386800 1735302961-vs-fr.png', 0, 2, 1, '2024-12-23 16:10:17', '2025-01-02 00:33:02'),
(3, 'German', 'de', '0.45913100 1735302981-vs-de.png', 0, 3, 1, '2024-12-23 16:10:17', '2025-01-02 00:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2014_10_10_000000_create_users_types_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_10_02_101510_create_banners_categories_table', 1),
(9, '2023_10_02_102134_create_contacts_table', 1),
(10, '2023_10_02_102300_create_email_templates_table', 1),
(12, '2023_10_02_102606_create_modules_table', 1),
(14, '2023_10_02_102919_create_settings_table', 1),
(17, '2023_12_12_141418_create_testimonial_table', 1),
(18, '2024_12_23_154323_create_language_table', 2),
(19, '2024_12_23_160532_create_country_table', 3),
(22, '2023_10_02_102747_create_pages_table', 5),
(23, '2024_12_24_091038_create_pages_language_table', 6),
(24, '2024_12_24_112148_create_blocks_language_table', 7),
(25, '2023_10_02_101733_create_blocks_table', 8),
(26, '2024_12_24_113225_create_banners_language_table', 9),
(27, '2023_10_02_065330_create_banners_table', 10),
(28, '2024_12_24_113926_create_faqs_language_table', 11),
(29, '2023_10_02_102440_create_faqs_table', 12),
(30, '2024_04_16_105253_create_customers_table', 13),
(31, '2024_04_16_112401_create_customers_address_table', 14),
(32, '2024_04_17_092128_create_zones_table', 15),
(33, '2023_12_12_135913_create_documents_category_table', 16),
(34, '2023_12_12_135913_create_documents_table', 17),
(35, '2024_12_27_071602_create_customers_document_table', 18),
(38, '2024_12_27_072150_create_documents_step_table', 19),
(39, '2024_12_27_075233_create_documents_question_table', 20),
(40, '2024_12_27_080850_create_documents_question_option_table', 21);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'CMS Pages', 'pages', '2024-12-23 09:07:56', '2024-12-23 09:07:56'),
(2, 'Block', 'blocks', '2024-12-23 09:07:56', '2024-12-23 09:07:56'),
(3, 'Email Template', 'emailtemplates', '2024-12-23 09:07:56', '2024-12-23 09:07:56'),
(4, 'Settings', 'settings', '2024-12-23 09:07:56', '2024-12-23 09:07:56'),
(5, 'Faq', 'faq', '2024-12-23 09:07:56', '2024-12-23 09:07:56'),
(6, 'Contacts', 'contact', '2024-12-23 09:07:56', '2024-12-23 09:07:56'),
(8, 'Language', 'language', '2024-12-23 09:07:56', '2024-12-23 09:07:56'),
(9, 'Country', 'country', '2024-12-23 09:07:56', '2024-12-23 09:07:56'),
(10, 'Documents', 'document', '2024-12-23 09:07:56', '2024-12-23 09:07:56'),
(11, 'Zones', 'zones', '2024-12-23 09:07:56', '2024-12-23 09:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(150) NOT NULL,
  `banner_image` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `slug`, `banner_image`, `status`, `created_at`, `updated_at`) VALUES
(1, '/', '', 1, '2024-12-28 02:39:59', '2024-12-28 02:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `pages_language`
--

DROP TABLE IF EXISTS `pages_language`;
CREATE TABLE `pages_language` (
  `page_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `content` text DEFAULT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages_language`
--

INSERT INTO `pages_language` (`page_id`, `language_id`, `name`, `content`, `meta_title`, `meta_keyword`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Home', '<p>welcome to home!!</p>', '', '', '', '2024-12-30 02:18:59', '2024-12-30 02:18:59'),
(1, 2, 'maison', '<p>bienvenue &agrave; la maison !!</p>', '', '', '', '2024-12-30 02:18:59', '2024-12-30 02:18:59'),
(1, 3, 'heim', '<p>Willkommen zu Hause!!</p>', '', '', '', '2024-12-30 02:18:59', '2024-12-30 02:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('ajaykrec@gmail.com', '$2y$12$0v.91ZBhg645.S/05p/QdO3YZwTgTnJexYOOJmV0sixtGXigoMmyS', '2024-12-23 09:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ejDPiH0xLt5byXIhfj3d8pHpR3PdB6SYc6N4gYFt', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NjoiX3Rva2VuIjtzOjQwOiJpcUx1eXlBcURrNHVrSTR5aGFBOElHbEhYUnRQcnpYSm1QVWFEZDdOIjtzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NToiZW1haWwiO3M6MTg6ImFqYXlrcmVjQGdtYWlsLmNvbSI7fQ==', 1735886118);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `setting_id` bigint(20) NOT NULL,
  `field_type` enum('TextBox','TextArea','TextEditor','Image','Radio','PDF','DOC','XML') NOT NULL DEFAULT 'TextBox',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_showing` enum('Y','N') NOT NULL DEFAULT 'Y',
  `title` varchar(150) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `field_type`, `sort_order`, `is_showing`, `title`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'TextBox', 5, 'Y', 'Contact Phone', 'contact_phone', '9874563210', '2024-12-23 14:47:57', '2024-12-23 09:17:57'),
(4, 'TextBox', 1, 'Y', 'Site Name', 'site_name', 'Docmaker', '2024-12-23 14:46:06', '2024-12-23 09:16:06'),
(5, 'TextBox', 5, 'Y', 'Contact Fax', 'cantact_fax', '', '2024-11-18 07:46:46', '2023-03-04 18:12:53'),
(6, 'TextBox', 5, 'Y', 'Contact Email', 'contact_email', 'info@docmaker.com', '2024-12-23 14:48:11', '2024-12-23 09:18:11'),
(28, 'TextBox', 7, 'Y', 'To Email Address', 'to_email', 'info@docmaker.com', '2024-12-23 14:48:23', '2024-12-23 09:18:23'),
(29, 'TextBox', 7, 'Y', 'To Email Name', 'to_email_name', 'Docmaker', '2024-12-23 14:48:34', '2024-12-23 09:18:34'),
(30, 'TextBox', 8, 'Y', 'From Email Name', 'from_email_name', 'Docmaker', '2024-12-23 14:48:42', '2024-12-23 09:18:42'),
(31, 'TextBox', 8, 'Y', 'From Email Address', 'from_email', 'info@ajtek.in', '2024-11-21 07:00:37', '2023-03-04 18:12:53'),
(32, 'TextBox', 1, 'Y', 'Domain name', 'domain', 'docmaker.com', '2024-12-23 14:46:18', '2024-12-23 09:16:18'),
(41, 'TextBox', 1, 'Y', 'Site Url', 'site_url', 'https://www.docmaker.com', '2024-12-23 14:46:37', '2024-12-23 09:16:37'),
(117, 'TextBox', 0, 'Y', 'Designed By', 'designed_by', '', '2024-11-26 04:02:33', '2024-11-26 03:31:46'),
(56, 'TextArea', 0, 'Y', 'Copyright Text', 'copyrights', '© <strong><span>docmaker.com</span></strong>. All Rights Reserved', '2024-12-23 14:45:40', '2024-12-23 09:15:40'),
(13, 'TextArea', 4, 'Y', 'Contact Address', 'contact_address', 'Docmaker LLP <br />\r\nUnit 123 Park lane\r\nKol -85\r\nIndia', '2024-12-23 14:47:42', '2024-12-23 09:17:42'),
(42, 'Image', 2, 'Y', 'Logo', 'logo', '0.64581200 1734965707-vs-logo.png', '2024-12-23 14:55:07', '2024-12-23 09:25:07'),
(63, 'TextBox', 5, 'Y', 'Currency Code', 'currency_code', 'GBP', '2024-11-18 07:46:46', '2023-03-04 18:12:53'),
(62, 'TextArea', 5, 'Y', 'Currency', 'currency', '£', '2024-11-18 07:46:46', '2023-03-04 18:12:53'),
(64, 'TextBox', 55, 'Y', 'Twitter Url (Social media)', 'twitter_url', 'https://twitter.com', '2024-12-23 14:49:57', '2024-12-23 09:19:57'),
(65, 'TextBox', 55, 'Y', 'Facebook Url (Social media)', 'facebook_url', 'https://www.facebook.com', '2024-12-23 14:50:05', '2024-12-23 09:20:05'),
(66, 'TextBox', 55, 'Y', 'LinkedIn Url (Social media)', 'linkedIn_url', 'https://www.linkedin.com', '2024-12-23 14:50:12', '2024-12-23 09:20:12'),
(68, 'TextBox', 55, 'Y', 'Instagram Url (Social media)', 'instagram_url', '', '2024-11-26 03:44:32', '2023-03-04 18:12:53'),
(73, 'TextArea', 1000, 'Y', 'Footer about us text', 'footer_about_us_text', '', '2024-11-26 03:55:56', '2023-03-04 18:12:53'),
(108, 'TextBox', 55, 'Y', 'Pinterest Url (Social media)', 'pinterest_url', 'https://www.pinterest.com/', '2024-11-26 03:47:01', '2023-03-04 18:12:53'),
(77, 'Radio', 1000, 'Y', 'Set Under Construction', 'under_construction', '0', '2025-01-02 07:04:01', '2025-01-02 01:34:01'),
(82, 'Image', 2, 'Y', 'Footer Logo', 'footer_logo', '0.99642800 1734965718-vs-logo.png', '2024-12-23 14:55:19', '2024-12-23 09:25:19'),
(86, 'TextBox', 5, 'Y', 'Timing', 'timing', 'Mon - Sat 9.00AM – 5.30PM  <br />Sunday Closed', '2024-11-18 07:46:46', '2023-03-04 18:12:53');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

DROP TABLE IF EXISTS `testimonial`;
CREATE TABLE `testimonial` (
  `testimonial_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `designation` varchar(150) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`testimonial_id`, `name`, `designation`, `profile_image`, `description`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ff', 'gfgfg', '', '<p>fgfg</p>', 5, 1, '2024-12-28 06:27:30', '2024-12-28 06:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `profile_image` varchar(150) DEFAULT NULL,
  `usertype_id` int(11) NOT NULL,
  `company` varchar(150) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `social_media` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `login_status` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `email_verified_at`, `password`, `phone_number`, `profile_image`, `usertype_id`, `company`, `country`, `address`, `about`, `date_of_birth`, `social_media`, `status`, `login_status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'ajaykrec@gmail.com', NULL, '$2y$12$amAq.LLCrdtcgqN0DX1.zuvbpR8Sd2W6kf5mr6KI68LmjRSnRFLZ6', '9876543210', '', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '5cd8c88e6518fa964baa4db906f0a7a7967695172e0c012a8dde069785f2e395', '2024-12-23 09:07:56', '2024-12-23 09:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `users_types`
--

DROP TABLE IF EXISTS `users_types`;
CREATE TABLE `users_types` (
  `usertype_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(100) NOT NULL,
  `modules` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_types`
--

INSERT INTO `users_types` (`usertype_id`, `user_type`, `modules`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrator', NULL, '2024-12-23 09:07:56', '2024-12-23 09:07:56'),
(2, 'Administrator', 'null', '2024-12-23 09:07:56', '2024-12-27 03:04:37'),
(4, 'Editor', NULL, '2024-12-23 09:07:56', '2024-12-23 09:07:56'),
(5, 'Tech Support', NULL, '2024-12-23 09:07:56', '2024-12-23 09:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
CREATE TABLE `zones` (
  `zone_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `zone_code` varchar(32) NOT NULL,
  `zone_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`zone_id`, `country_id`, `zone_code`, `zone_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'AL', 'Alabama', 1, NULL, NULL),
(2, 4, 'AK', 'Alaska', 1, NULL, NULL),
(3, 4, 'AS', 'American Samoa', 1, NULL, NULL),
(4, 4, 'AZ', 'Arizona', 1, NULL, NULL),
(5, 4, 'AR', 'Arkansas', 1, NULL, NULL),
(6, 4, 'AF', 'Armed Forces Africa', 1, NULL, NULL),
(7, 4, 'AA', 'Armed Forces Americas', 1, NULL, NULL),
(8, 4, 'AC', 'Armed Forces Canada', 1, NULL, NULL),
(9, 4, 'AE', 'Armed Forces Europe', 1, NULL, NULL),
(10, 4, 'AM', 'Armed Forces Middle East', 1, NULL, NULL),
(11, 4, 'AP', 'Armed Forces Pacific', 1, NULL, NULL),
(12, 4, 'CA', 'California', 1, NULL, NULL),
(13, 4, 'CO', 'Colorado', 1, NULL, NULL),
(14, 4, 'CT', 'Connecticut', 1, NULL, NULL),
(15, 4, 'DE', 'Delaware', 1, NULL, NULL),
(16, 4, 'DC', 'District of Columbia', 1, NULL, NULL),
(17, 4, 'FM', 'Federated States Of Micronesia', 1, NULL, NULL),
(18, 4, 'FL', 'Florida', 1, NULL, NULL),
(19, 4, 'GA', 'Georgia', 1, NULL, NULL),
(20, 4, 'GU', 'Guam', 1, NULL, NULL),
(21, 4, 'HI', 'Hawaii', 1, NULL, NULL),
(22, 4, 'ID', 'Idaho', 1, NULL, NULL),
(23, 4, 'IL', 'Illinois', 1, NULL, NULL),
(24, 4, 'IN', 'Indiana', 1, NULL, NULL),
(25, 4, 'IA', 'Iowa', 1, NULL, NULL),
(26, 4, 'KS', 'Kansas', 1, NULL, NULL),
(27, 4, 'KY', 'Kentucky', 1, NULL, NULL),
(28, 4, 'LA', 'Louisiana', 1, NULL, NULL),
(29, 4, 'ME', 'Maine', 1, NULL, NULL),
(30, 4, 'MH', 'Marshall Islands', 1, NULL, NULL),
(31, 4, 'MD', 'Maryland', 1, NULL, NULL),
(32, 4, 'MA', 'Massachusetts', 1, NULL, NULL),
(33, 4, 'MI', 'Michigan', 1, NULL, NULL),
(34, 4, 'MN', 'Minnesota', 1, NULL, NULL),
(35, 4, 'MS', 'Mississippi', 1, NULL, NULL),
(36, 4, 'MO', 'Missouri', 1, NULL, NULL),
(37, 4, 'MT', 'Montana', 1, NULL, NULL),
(38, 4, 'NE', 'Nebraska', 1, NULL, NULL),
(39, 4, 'NV', 'Nevada', 1, NULL, NULL),
(40, 4, 'NH', 'New Hampshire', 1, NULL, NULL),
(41, 4, 'NJ', 'New Jersey', 1, NULL, NULL),
(42, 4, 'NM', 'New Mexico', 1, NULL, NULL),
(43, 4, 'NY', 'New York', 1, NULL, NULL),
(44, 4, 'NC', 'North Carolina', 1, NULL, NULL),
(45, 4, 'ND', 'North Dakota', 1, NULL, NULL),
(46, 4, 'MP', 'Northern Mariana Islands', 1, NULL, NULL),
(47, 4, 'OH', 'Ohio', 1, NULL, NULL),
(48, 4, 'OK', 'Oklahoma', 1, NULL, NULL),
(49, 4, 'OR', 'Oregon', 1, NULL, NULL),
(50, 4, 'PW', 'Palau', 1, NULL, NULL),
(51, 4, 'PA', 'Pennsylvania', 1, NULL, NULL),
(52, 4, 'PR', 'Puerto Rico', 1, NULL, NULL),
(53, 4, 'RI', 'Rhode Island', 1, NULL, NULL),
(54, 4, 'SC', 'South Carolina', 1, NULL, NULL),
(55, 4, 'SD', 'South Dakota', 1, NULL, NULL),
(56, 4, 'TN', 'Tennessee', 1, NULL, NULL),
(57, 4, 'TX', 'Texas', 1, NULL, NULL),
(58, 4, 'UT', 'Utah', 1, NULL, NULL),
(59, 4, 'VT', 'Vermont', 1, NULL, NULL),
(60, 4, 'VI', 'Virgin Islands', 1, NULL, NULL),
(61, 4, 'VA', 'Virginia', 1, NULL, NULL),
(62, 4, 'WA', 'Washington', 1, NULL, NULL),
(63, 4, 'WV', 'West Virginia', 1, NULL, NULL),
(64, 4, 'WI', 'Wisconsin', 1, NULL, NULL),
(65, 4, 'WY', 'Wyoming', 1, NULL, NULL),
(66, 38, 'AB', 'Alberta', 1, NULL, NULL),
(67, 38, 'BC', 'British Columbia', 1, NULL, NULL),
(68, 38, 'MB', 'Manitoba', 1, NULL, NULL),
(69, 38, 'NF', 'Newfoundland', 1, NULL, NULL),
(70, 38, 'NB', 'New Brunswick', 1, NULL, NULL),
(71, 38, 'NS', 'Nova Scotia', 1, NULL, NULL),
(72, 38, 'NT', 'Northwest Territories', 1, NULL, NULL),
(73, 38, 'NU', 'Nunavut', 1, NULL, NULL),
(74, 38, 'ON', 'Ontario', 1, NULL, NULL),
(75, 38, 'PE', 'Prince Edward Island', 1, NULL, NULL),
(76, 38, 'QC', 'Quebec', 1, NULL, NULL),
(77, 38, 'SK', 'Saskatchewan', 1, NULL, NULL),
(78, 38, 'YT', 'Yukon Territory', 1, NULL, NULL),
(79, 81, 'NDS', 'Niedersachsen', 1, NULL, NULL),
(80, 81, 'BAW', 'Baden-W?rttemberg', 1, NULL, NULL),
(81, 81, 'BAY', 'Bayern', 1, NULL, NULL),
(82, 81, 'BER', 'Berlin', 1, NULL, NULL),
(83, 81, 'BRG', 'Brandenburg', 1, NULL, NULL),
(84, 81, 'BRE', 'Bremen', 1, NULL, NULL),
(85, 81, 'HAM', 'Hamburg', 1, NULL, NULL),
(86, 81, 'HES', 'Hessen', 1, NULL, NULL),
(87, 81, 'MEC', 'Mecklenburg-Vorpommern', 1, NULL, NULL),
(88, 81, 'NRW', 'Nordrhein-Westfalen', 1, NULL, NULL),
(89, 81, 'RHE', 'Rheinland-Pfalz', 1, NULL, NULL),
(90, 81, 'SAR', 'Saarland', 1, NULL, NULL),
(91, 81, 'SAS', 'Sachsen', 1, NULL, NULL),
(92, 81, 'SAC', 'Sachsen-Anhalt', 1, NULL, NULL),
(93, 81, 'SCN', 'Schleswig-Holstein', 1, NULL, NULL),
(94, 81, 'THE', 'Th?ringen', 1, NULL, NULL),
(95, 14, 'WI', 'Wien', 1, NULL, NULL),
(96, 14, 'NO', 'Nieder?sterreich', 1, NULL, NULL),
(97, 14, 'OO', 'Ober?sterreich', 1, NULL, NULL),
(98, 14, 'SB', 'Salzburg', 1, NULL, NULL),
(99, 14, 'KN', 'K?rnten', 1, NULL, NULL),
(100, 14, 'ST', 'Steiermark', 1, NULL, NULL),
(101, 14, 'TI', 'Tirol', 1, NULL, NULL),
(102, 14, 'BL', 'Burgenland', 1, NULL, NULL),
(103, 14, 'VB', 'Voralberg', 1, NULL, NULL),
(104, 204, 'AG', 'Aargau', 1, NULL, NULL),
(105, 204, 'AI', 'Appenzell Innerrhoden', 1, NULL, NULL),
(106, 204, 'AR', 'Appenzell Ausserrhoden', 1, NULL, NULL),
(107, 204, 'BE', 'Bern', 1, NULL, NULL),
(108, 204, 'BL', 'Basel-Landschaft', 1, NULL, NULL),
(109, 204, 'BS', 'Basel-Stadt', 1, NULL, NULL),
(110, 204, 'FR', 'Freiburg', 1, NULL, NULL),
(111, 204, 'GE', 'Genf', 1, NULL, NULL),
(112, 204, 'GL', 'Glarus', 1, NULL, NULL),
(113, 204, 'JU', 'Graub?nden', 1, NULL, NULL),
(114, 204, 'JU', 'Jura', 1, NULL, NULL),
(115, 204, 'LU', 'Luzern', 1, NULL, NULL),
(116, 204, 'NE', 'Neuenburg', 1, NULL, NULL),
(117, 204, 'NW', 'Nidwalden', 1, NULL, NULL),
(118, 204, 'OW', 'Obwalden', 1, NULL, NULL),
(119, 204, 'SG', 'St. Gallen', 1, NULL, NULL),
(120, 204, 'SH', 'Schaffhausen', 1, NULL, NULL),
(121, 204, 'SO', 'Solothurn', 1, NULL, NULL),
(122, 204, 'SZ', 'Schwyz', 1, NULL, NULL),
(123, 204, 'TG', 'Thurgau', 1, NULL, NULL),
(124, 204, 'TI', 'Tessin', 1, NULL, NULL),
(125, 204, 'UR', 'Uri', 1, NULL, NULL),
(126, 204, 'VD', 'Waadt', 1, NULL, NULL),
(127, 204, 'VS', 'Wallis', 1, NULL, NULL),
(128, 204, 'ZG', 'Zug', 1, NULL, NULL),
(129, 204, 'ZH', 'Z?rich', 1, NULL, NULL),
(130, 195, 'A Coru?a', 'A Coru?a', 1, NULL, NULL),
(131, 195, 'Alava', 'Alava', 1, NULL, NULL),
(132, 195, 'Albacete', 'Albacete', 1, NULL, NULL),
(133, 195, 'Alicante', 'Alicante', 1, NULL, NULL),
(134, 195, 'Almeria', 'Almeria', 1, NULL, NULL),
(135, 195, 'Asturias', 'Asturias', 1, NULL, NULL),
(136, 195, 'Avila', 'Avila', 1, NULL, NULL),
(137, 195, 'Badajoz', 'Badajoz', 1, NULL, NULL),
(138, 195, 'Baleares', 'Baleares', 1, NULL, NULL),
(139, 195, 'Barcelona', 'Barcelona', 1, NULL, NULL),
(140, 195, 'Burgos', 'Burgos', 1, NULL, NULL),
(141, 195, 'Caceres', 'Caceres', 1, NULL, NULL),
(142, 195, 'Cadiz', 'Cadiz', 1, NULL, NULL),
(143, 195, 'Cantabria', 'Cantabria', 1, NULL, NULL),
(144, 195, 'Castellon', 'Castellon', 1, NULL, NULL),
(145, 195, 'Ceuta', 'Ceuta', 1, NULL, NULL),
(146, 195, 'Ciudad Real', 'Ciudad Real', 1, NULL, NULL),
(147, 195, 'Cordoba', 'Cordoba', 1, NULL, NULL),
(148, 195, 'Cuenca', 'Cuenca', 1, NULL, NULL),
(149, 195, 'Girona', 'Girona', 1, NULL, NULL),
(150, 195, 'Granada', 'Granada', 1, NULL, NULL),
(151, 195, 'Guadalajara', 'Guadalajara', 1, NULL, NULL),
(152, 195, 'Guipuzcoa', 'Guipuzcoa', 1, NULL, NULL),
(153, 195, 'Huelva', 'Huelva', 1, NULL, NULL),
(154, 195, 'Huesca', 'Huesca', 1, NULL, NULL),
(155, 195, 'Jaen', 'Jaen', 1, NULL, NULL),
(156, 195, 'La Rioja', 'La Rioja', 1, NULL, NULL),
(157, 195, 'Las Palmas', 'Las Palmas', 1, NULL, NULL),
(158, 195, 'Leon', 'Leon', 1, NULL, NULL),
(159, 195, 'Lleida', 'Lleida', 1, NULL, NULL),
(160, 195, 'Lugo', 'Lugo', 1, NULL, NULL),
(161, 195, 'Madrid', 'Madrid', 1, NULL, NULL),
(162, 195, 'Malaga', 'Malaga', 1, NULL, NULL),
(163, 195, 'Melilla', 'Melilla', 1, NULL, NULL),
(164, 195, 'Murcia', 'Murcia', 1, NULL, NULL),
(165, 195, 'Navarra', 'Navarra', 1, NULL, NULL),
(166, 195, 'Ourense', 'Ourense', 1, NULL, NULL),
(167, 195, 'Palencia', 'Palencia', 1, NULL, NULL),
(168, 195, 'Pontevedra', 'Pontevedra', 1, NULL, NULL),
(169, 195, 'Salamanca', 'Salamanca', 1, NULL, NULL),
(170, 195, 'Santa Cruz de Tenerife', 'Santa Cruz de Tenerife', 1, NULL, NULL),
(171, 195, 'Segovia', 'Segovia', 1, NULL, NULL),
(172, 195, 'Sevilla', 'Sevilla', 1, NULL, NULL),
(173, 195, 'Soria', 'Soria', 1, NULL, NULL),
(174, 195, 'Tarragona', 'Tarragona', 1, NULL, NULL),
(175, 195, 'Teruel', 'Teruel', 1, NULL, NULL),
(176, 195, 'Toledo', 'Toledo', 1, NULL, NULL),
(177, 195, 'Valencia', 'Valencia', 1, NULL, NULL),
(178, 195, 'Valladolid', 'Valladolid', 1, NULL, NULL),
(179, 195, 'Vizcaya', 'Vizcaya', 1, NULL, NULL),
(180, 195, 'Zamora', 'Zamora', 1, NULL, NULL),
(181, 195, 'Zaragoza', 'Zaragoza', 1, NULL, NULL),
(184, 31, 'NSW', 'New South Wales', 1, NULL, NULL),
(189, 188, 'SG-1', 'Central Singapore', 1, NULL, NULL),
(190, 188, 'SG-02', 'North East', 1, NULL, NULL),
(191, 188, 'SG-03', 'North West', 1, NULL, NULL),
(192, 188, 'SG-04', 'South East', 1, NULL, NULL),
(193, 188, 'SG-05', 'South West', 1, NULL, NULL),
(194, 31, 'ACT', 'Australian Capital Territory', 1, NULL, NULL),
(195, 3, 'NT', 'Northern Territory', 1, NULL, NULL),
(196, 9, 'QLD', 'Queensland', 1, NULL, NULL),
(197, 5, 'SA', 'South Australia', 1, NULL, NULL),
(198, 5, 'TAS', 'Tasmania', 1, NULL, NULL),
(199, 5, 'VIC', 'Victoria', 1, NULL, NULL),
(201, 3, '', 'Andaman and Nicobar Islands', 1, NULL, NULL),
(202, 3, '', 'Andhra Pradesh', 1, NULL, NULL),
(203, 3, '', 'Arunachal Pradesh', 1, NULL, NULL),
(204, 3, '', 'Assam', 1, NULL, NULL),
(205, 3, '', 'Bihar', 1, NULL, NULL),
(206, 3, '', 'Chandigarh', 1, NULL, NULL),
(207, 3, '', 'Chhattisgarh', 1, NULL, NULL),
(208, 3, '', 'Dadra and Nagar Haveli', 1, NULL, NULL),
(209, 3, '', 'Daman and Diu', 1, NULL, NULL),
(210, 3, '', 'Delhi', 1, NULL, NULL),
(211, 3, '', 'Goa', 1, NULL, NULL),
(212, 3, '', 'Gujarat', 1, NULL, NULL),
(213, 3, '', 'Haryana', 1, NULL, NULL),
(214, 3, '', 'Himachal Pradesh', 1, NULL, NULL),
(215, 3, '', 'Jammu and Kashmir', 1, NULL, NULL),
(216, 3, '', 'Jharkhand', 1, NULL, NULL),
(217, 3, '', 'Karnataka', 1, NULL, NULL),
(218, 3, '', 'Kerala', 1, NULL, NULL),
(219, 3, '', 'Lakshadweep', 1, NULL, NULL),
(220, 3, '', 'Madhya Pradesh', 1, NULL, NULL),
(221, 3, '', 'Maharashtra', 1, NULL, NULL),
(222, 3, '', 'Manipur', 1, NULL, NULL),
(223, 3, '', 'Meghalaya', 1, NULL, NULL),
(224, 3, '', 'Mizoram', 1, NULL, NULL),
(225, 3, '', 'Nagaland', 1, NULL, NULL),
(226, 3, '', 'Orissa', 1, NULL, NULL),
(227, 3, '', 'Puducherry', 1, NULL, NULL),
(228, 3, '', 'Punjab', 1, NULL, NULL),
(229, 3, '', 'Rajasthan', 1, NULL, NULL),
(230, 3, '', 'Sikkim', 1, NULL, NULL),
(231, 3, '', 'Tamil Nadu', 1, NULL, NULL),
(232, 3, '', 'Tripura', 1, NULL, NULL),
(233, 3, '', 'Uttar Pradesh', 1, NULL, NULL),
(234, 3, '', 'Uttarakhand', 1, NULL, NULL),
(235, 3, '', 'West Bengal', 1, NULL, NULL),
(200, 5, 'WA', 'Western Australia', 1, NULL, NULL),
(236, 27, '657657', 'fdhdfg', 1, NULL, NULL),
(242, 2, 'I0', 'AberconwyandColwyn', 1, NULL, NULL),
(243, 2, 'I1', 'AberdeenCity', 1, NULL, NULL),
(244, 2, 'I2', 'Aberdeenshire', 1, NULL, NULL),
(245, 2, 'I3', 'Anglesey', 1, NULL, NULL),
(246, 2, 'I4', 'Angus', 1, NULL, NULL),
(247, 2, 'I5', 'Antrim', 1, NULL, NULL),
(248, 2, 'I6', 'ArgyllandBute', 1, NULL, NULL),
(249, 2, 'I', 'Armagh', 1, NULL, NULL),
(250, 2, 'I', 'Avon', 1, NULL, NULL),
(251, 2, 'I', 'Ayrshire', 1, NULL, NULL),
(252, 2, 'IB', 'BathandNESomerset', 1, NULL, NULL),
(253, 2, 'IC', 'Bedfordshire', 1, NULL, NULL),
(254, 2, 'IE', 'Belfast', 1, NULL, NULL),
(255, 2, 'IF', 'Berkshire', 1, NULL, NULL),
(256, 2, 'IG', 'Berwickshire', 1, NULL, NULL),
(257, 2, 'IH', 'BFPO', 1, NULL, NULL),
(258, 2, 'II', 'BlaenauGwent', 1, NULL, NULL),
(259, 2, 'IJ', 'Buckinghamshire', 1, NULL, NULL),
(260, 2, 'IK', 'Caernarfonshire', 1, NULL, NULL),
(261, 2, 'IM', 'Caerphilly', 1, NULL, NULL),
(262, 2, 'IO', 'Caithness', 1, NULL, NULL),
(263, 2, 'IP', 'Cambridgeshire', 1, NULL, NULL),
(264, 2, 'IQ', 'Cardiff', 1, NULL, NULL),
(265, 2, 'IR', 'Cardiganshire', 1, NULL, NULL),
(266, 2, 'IS', 'Carmarthenshire', 1, NULL, '2024-12-30 03:08:54'),
(267, 2, '\r\nIT', '\r\nCeredigion', 1, NULL, NULL),
(268, 2, '\r\nIU', '\r\nChannelIslands', 1, NULL, NULL),
(269, 2, '\r\nIV', '\r\nCheshire', 1, NULL, NULL),
(270, 2, '\r\nIW', '\r\nCityofBristol', 1, NULL, NULL),
(271, 2, '\r\nIX', '\r\nClackmannanshire', 1, NULL, NULL),
(272, 2, '\r\nIY', '\r\nClwyd', 1, NULL, NULL),
(273, 2, '\r\nIZ', '\r\nConwy', 1, NULL, NULL),
(274, 2, '\r\nJ0', '\r\nCornwall/Scilly', 1, NULL, NULL),
(275, 2, '\r\nJ1', '\r\nCumbria', 1, NULL, NULL),
(276, 2, '\r\nJ2', '\r\nDenbighshire', 1, NULL, NULL),
(277, 2, '\r\nJ3', '\r\nDerbyshire', 1, NULL, NULL),
(278, 2, '\r\nJ4', '\r\nDerry/Londonderry', 1, NULL, NULL),
(279, 2, '\r\nJ5', '\r\nDevon', 1, NULL, NULL),
(280, 2, '\r\nJ6', '\r\nDorset', 1, NULL, NULL),
(281, 2, '\r\nJ', '\r\nDown', 1, NULL, NULL),
(282, 2, '\r\nJ', '\r\nDumfriesandGalloway', 1, NULL, NULL),
(283, 2, '\r\nJ', '\r\nDunbartonshire', 1, NULL, NULL),
(284, 2, '\r\nJA', '\r\nDundee', 1, NULL, NULL),
(285, 2, '\r\nJB', '\r\nDurham', 1, NULL, NULL),
(286, 2, '\r\nJC', '\r\nDyfed', 1, NULL, NULL),
(287, 2, '\r\nJD', '\r\nEastAyrshire', 1, NULL, NULL),
(288, 2, '\r\nJE', '\r\nEastDunbartonshire', 1, NULL, NULL),
(289, 2, '\r\nJF', '\r\nEastLothian', 1, NULL, NULL),
(290, 2, '\r\nJG', '\r\nEastRenfrewshire', 1, NULL, NULL),
(291, 2, '\r\nJH', '\r\nEastRidingYorkshire', 1, NULL, NULL),
(292, 2, '\r\nJI', '\r\nEastSussex', 1, NULL, NULL),
(293, 2, '\r\nJJ', '\r\nEdinburgh', 1, NULL, NULL),
(294, 2, '\r\nJK', '\r\nEngland', 1, NULL, NULL),
(295, 2, '\r\nJL', '\r\nEssex', 1, NULL, NULL),
(296, 2, '\r\nJM', '\r\nFalkirk', 1, NULL, NULL),
(297, 2, '\r\nJN', '\r\nFermanagh', 1, NULL, NULL),
(298, 2, '\r\nJO', '\r\nFife', 1, NULL, NULL),
(299, 2, '\r\nJP', '\r\nFlintshire', 1, NULL, NULL),
(300, 2, '\r\nJQ', '\r\nGlasgow', 1, NULL, NULL),
(301, 2, '\r\nJR', '\r\nGloucestershire', 1, NULL, NULL),
(302, 2, '\r\nJS', '\r\nGreaterLondon', 1, NULL, NULL),
(303, 2, '\r\nJT', '\r\nGreaterManchester', 1, NULL, NULL),
(304, 2, '\r\nJU', '\r\nGwent', 1, NULL, NULL),
(305, 2, '\r\nJV', '\r\nGwynedd', 1, NULL, NULL),
(306, 2, '\r\nJW', '\r\nHampshire', 1, NULL, NULL),
(307, 2, '\r\nJX', '\r\nHartlepool', 1, NULL, NULL),
(308, 2, '\r\nHAW', '\r\nHerefordandWorcester', 1, NULL, NULL),
(309, 2, '\r\nJY', '\r\nHertfordshire', 1, NULL, NULL),
(310, 2, '\r\nJZ', '\r\nHighlands', 1, NULL, NULL),
(311, 2, '\r\nK0', '\r\nInverclyde', 1, NULL, NULL),
(312, 2, '\r\nK1', '\r\nInverness-Shire', 1, NULL, NULL),
(313, 2, '\r\nK2', '\r\nIsleofMan', 1, NULL, NULL),
(314, 2, '\r\nK3', '\r\nIsleofWight', 1, NULL, NULL),
(315, 2, '\r\nK4', '\r\nKent', 1, NULL, NULL),
(316, 2, '\r\nK5', '\r\nKincardinshire', 1, NULL, NULL),
(317, 2, '\r\nK6', '\r\nKingstonUponHull', 1, NULL, NULL),
(318, 2, '\r\nK', '\r\nKinross-Shire', 1, NULL, NULL),
(319, 2, '\r\nK', '\r\nKirklees', 1, NULL, NULL),
(320, 2, '\r\nK', '\r\nLanarkshire', 1, NULL, NULL),
(321, 2, '\r\nKA', '\r\nLancashire', 1, NULL, NULL),
(322, 2, '\r\nKB', '\r\nLeicestershire', 1, NULL, NULL),
(323, 2, '\r\nKC', '\r\nLincolnshire', 1, NULL, NULL),
(324, 2, '\r\nKD', '\r\nLondonderry', 1, NULL, NULL),
(325, 2, '\r\nKE', '\r\nMerseyside', 1, NULL, NULL),
(326, 2, '\r\nKF', '\r\nMerthyrTydfil', 1, NULL, NULL),
(327, 2, '\r\nKG', '\r\nMidGlamorgan', 1, NULL, NULL),
(328, 2, '\r\nKI', '\r\nMidLothian', 1, NULL, NULL),
(329, 2, '\r\nKH', '\r\nMiddlesex', 1, NULL, NULL),
(330, 2, '\r\nKJ', '\r\nMonmouthshire', 1, NULL, NULL),
(331, 2, '\r\nKK', '\r\nMoray', 1, NULL, NULL),
(332, 2, '\r\nKL', '\r\nNeath&amp;PortTalbot', 1, NULL, NULL),
(333, 2, '\r\nKM', '\r\nNewport', 1, NULL, NULL),
(334, 2, '\r\nKN', '\r\nNorfolk', 1, NULL, NULL),
(335, 2, '\r\nKP', '\r\nNorthAyrshire', 1, NULL, NULL),
(336, 2, '\r\nKQ', '\r\nNorthEastLincolnshire', 1, NULL, NULL),
(337, 2, '\r\nKR', '\r\nNorthLanarkshire', 1, NULL, NULL),
(338, 2, '\r\nKT', '\r\nNorthLincolnshire', 1, NULL, NULL),
(339, 2, '\r\nKU', '\r\nNorthSomerset', 1, NULL, NULL),
(340, 2, '\r\nKV', '\r\nNorthYorkshire', 1, NULL, NULL),
(341, 2, '\r\nKO', '\r\nNorthamptonshire', 1, NULL, NULL),
(342, 2, '\r\nKW', '\r\nNorthernIreland', 1, NULL, NULL),
(343, 2, '\r\nKX', '\r\nNorthumberland', 1, NULL, NULL),
(344, 2, '\r\nKZ', '\r\nNottinghamshire', 1, NULL, NULL),
(345, 2, '\r\nL0', '\r\nOrkneyandShetlandIsles', 1, NULL, NULL),
(346, 2, '\r\nL1', '\r\nOxfordshire', 1, NULL, NULL),
(347, 2, '\r\nL2', '\r\nPembrokeshire', 1, NULL, NULL),
(348, 2, '\r\nL3', '\r\nPerthandKinross', 1, NULL, NULL),
(349, 2, '\r\nL4', '\r\nPowys', 1, NULL, NULL),
(350, 2, '\r\nL5', '\r\nRedcarandCleveland', 1, NULL, NULL),
(351, 2, '\r\nL6', '\r\nRenfrewshire', 1, NULL, NULL),
(352, 2, '\r\nL', '\r\nRhondaCynonTaff', 1, NULL, NULL),
(353, 2, '\r\nL', '\r\nRutland', 1, NULL, NULL),
(354, 2, '\r\nL', '\r\nScottishBorders', 1, NULL, NULL),
(355, 2, '\r\nLB', '\r\nShetland', 1, NULL, NULL),
(356, 2, '\r\nLC', '\r\nShropshire', 1, NULL, NULL),
(357, 2, '\r\nLD', '\r\nSomerset', 1, NULL, NULL),
(358, 2, '\r\nLE', '\r\nSouthAyrshire', 1, NULL, NULL),
(359, 2, '\r\nLF', '\r\nSouthGlamorgan', 1, NULL, NULL),
(360, 2, '\r\nLG', '\r\nSouthGloucesteshire', 1, NULL, NULL),
(361, 2, '\r\nLH', '\r\nSouthLanarkshire', 1, NULL, NULL),
(362, 2, '\r\nLI', '\r\nSouthYorkshire', 1, NULL, NULL),
(363, 2, '\r\nLJ', '\r\nStaffordshire', 1, NULL, NULL),
(364, 2, '\r\nLK', '\r\nStirling', 1, NULL, NULL),
(365, 2, '\r\nLL', '\r\nStocktonOnTees', 1, NULL, NULL),
(366, 2, '\r\nLM', '\r\nSuffolk', 1, NULL, NULL),
(367, 2, '\r\nLN', '\r\nSurrey', 1, NULL, NULL),
(368, 2, '\r\nLO', '\r\nSwansea', 1, NULL, NULL),
(369, 2, '\r\nLP', '\r\nTorfaen', 1, NULL, NULL),
(370, 2, '\r\nLQ', '\r\nTyneandWear', 1, NULL, NULL),
(371, 2, '\r\nLR', '\r\nTyrone', 1, NULL, NULL),
(372, 2, '\r\nLS', '\r\nValeOfGlamorgan', 1, NULL, NULL),
(373, 2, '\r\nLT', '\r\nWales', 1, NULL, NULL),
(374, 2, '\r\nLU', '\r\nWarwickshire', 1, NULL, NULL),
(375, 2, '\r\nLV', '\r\nWestBerkshire', 1, NULL, NULL),
(376, 2, '\r\nLW', '\r\nWestDunbartonshire', 1, NULL, NULL),
(377, 2, '\r\nLX', '\r\nWestGlamorgan', 1, NULL, NULL),
(378, 2, '\r\nLY', '\r\nWestLothian', 1, NULL, NULL),
(379, 2, '\r\nLZ', '\r\nWestMidlands', 1, NULL, NULL),
(380, 2, '\r\nM0', '\r\nWestSussex', 1, NULL, NULL),
(381, 2, '\r\nM1', '\r\nWestYorkshire', 1, NULL, NULL),
(382, 2, '\r\nM2', '\r\nWesternIsles', 1, NULL, NULL),
(383, 2, '\r\nM3', '\r\nWiltshire', 1, NULL, NULL),
(384, 2, '\r\nM4', '\r\nWirral', 1, NULL, NULL),
(385, 2, '\r\nM5', '\r\nWorcestershire', 1, NULL, NULL),
(386, 2, '\r\nM6', '\r\nWrexham', 1, NULL, NULL),
(387, 2, '\r\nM', '\r\nYork', 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `banners_categories`
--
ALTER TABLE `banners_categories`
  ADD PRIMARY KEY (`bannercat_id`);

--
-- Indexes for table `banners_language`
--
ALTER TABLE `banners_language`
  ADD PRIMARY KEY (`banner_id`,`language_id`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`block_id`),
  ADD UNIQUE KEY `blocks_identity_unique` (`identity`);

--
-- Indexes for table `blocks_language`
--
ALTER TABLE `blocks_language`
  ADD PRIMARY KEY (`block_id`,`language_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`),
  ADD UNIQUE KEY `country_code_unique` (`code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`);

--
-- Indexes for table `customers_address`
--
ALTER TABLE `customers_address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `customers_document`
--
ALTER TABLE `customers_document`
  ADD PRIMARY KEY (`cus_document_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `documents_category`
--
ALTER TABLE `documents_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `documents_question`
--
ALTER TABLE `documents_question`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `documents_question_option`
--
ALTER TABLE `documents_question_option`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `documents_step`
--
ALTER TABLE `documents_step`
  ADD PRIMARY KEY (`step_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`email_template_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `faqs_language`
--
ALTER TABLE `faqs_language`
  ADD PRIMARY KEY (`faq_id`,`language_id`);

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
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`language_id`),
  ADD UNIQUE KEY `language_code_unique` (`code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `pages_language`
--
ALTER TABLE `pages_language`
  ADD PRIMARY KEY (`page_id`,`language_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `OptionName` (`key`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`testimonial_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_types`
--
ALTER TABLE `users_types`
  ADD PRIMARY KEY (`usertype_id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`zone_id`),
  ADD KEY `idx_zones_country_id` (`country_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `banner_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `banners_categories`
--
ALTER TABLE `banners_categories`
  MODIFY `bannercat_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `block_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers_address`
--
ALTER TABLE `customers_address`
  MODIFY `address_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers_document`
--
ALTER TABLE `customers_document`
  MODIFY `cus_document_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documents_category`
--
ALTER TABLE `documents_category`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `documents_question`
--
ALTER TABLE `documents_question`
  MODIFY `question_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `documents_question_option`
--
ALTER TABLE `documents_question_option`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `documents_step`
--
ALTER TABLE `documents_step`
  MODIFY `step_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `email_template_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `faq_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `language_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `testimonial_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_types`
--
ALTER TABLE `users_types`
  MODIFY `usertype_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `zone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=389;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
