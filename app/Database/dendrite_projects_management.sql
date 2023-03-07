-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-03-2023 a las 21:33:08
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dendrite_projects_management`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_users` ()   BEGIN
    SELECT User_id,User_email,CO.Comp_name,ST.Stat_name,RO.Role_name,USU.created_at AS Created_at FROM user USU 
    INNER JOIN status ST ON USU.Stat_id =ST.Stat_id
    INNER JOIN role RO ON USU.Role_id=RO.Role_id
    INNER JOIN company CO ON USU.Comp_id =CO.Comp_id
    WHERE ST.Stat_id=1 ORDER BY User_id ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_status_users` ()   BEGIN
    SELECT Stat_id,Stat_name FROM status WHERE StatType_id=1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activities`
--

CREATE TABLE `activities` (
  `Activi_id` int(10) UNSIGNED NOT NULL,
  `Activi_name` varchar(100) NOT NULL,
  `Activi_observation` varchar(200) NOT NULL,
  `Activi_startDate` datetime NOT NULL,
  `Activi_endDate` datetime NOT NULL,
  `Activi_time` varchar(10) NOT NULL,
  `Activi_link` varchar(200) NOT NULL,
  `Activi_completion` varchar(50) NOT NULL,
  `Appr_code_activi_id` int(10) UNSIGNED NOT NULL,
  `Stat_id` int(10) UNSIGNED NOT NULL,
  `Project_product_id` int(10) UNSIGNED NOT NULL,
  `User_id` int(10) UNSIGNED NOT NULL,
  `User_assigned` int(10) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `approvalcode`
--

CREATE TABLE `approvalcode` (
  `ApprCode_id` int(10) UNSIGNED NOT NULL,
  `ApprCode_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `approvalcodeactivities`
--

CREATE TABLE `approvalcodeactivities` (
  `Appr_code_activi_id` int(10) UNSIGNED NOT NULL,
  `ApprCode_id` int(10) UNSIGNED NOT NULL,
  `Activi_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brand`
--

CREATE TABLE `brand` (
  `Brand_id` int(10) UNSIGNED NOT NULL,
  `Brand_name` int(11) NOT NULL,
  `Brand_description` int(11) NOT NULL,
  `Client_id` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

CREATE TABLE `client` (
  `Client_id` int(10) UNSIGNED NOT NULL,
  `Client_name` varchar(100) NOT NULL,
  `Client_identification` varchar(20) NOT NULL,
  `Client_email` varchar(100) NOT NULL,
  `Client_phone` varchar(10) NOT NULL,
  `Client_address` varchar(100) NOT NULL,
  `DocType_id` int(10) UNSIGNED NOT NULL,
  `Comp_id` int(10) UNSIGNED NOT NULL,
  `Stat_id` int(10) UNSIGNED NOT NULL,
  `Country_id` int(11) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `client`
--

INSERT INTO `client` (`Client_id`, `Client_name`, `Client_identification`, `Client_email`, `Client_phone`, `Client_address`, `DocType_id`, `Comp_id`, `Stat_id`, `Country_id`, `updated_at`, `created_at`) VALUES
(1, 'Market Support', '9012356487', 'market@gmail.com', '3012528242', 'Calle ', 6, 1, 3, 1, NULL, '2023-02-20 02:23:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_contact`
--

CREATE TABLE `client_contact` (
  `Client_contact_id` int(10) NOT NULL,
  `Contact_id` int(10) UNSIGNED NOT NULL,
  `Client_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

CREATE TABLE `company` (
  `Comp_id` int(10) UNSIGNED NOT NULL,
  `Comp_name` varchar(100) NOT NULL,
  `Comp_identification` varchar(20) NOT NULL,
  `Comp_email` varchar(100) NOT NULL,
  `Comp_phone` varchar(10) NOT NULL,
  `DocType_id` int(5) UNSIGNED NOT NULL,
  `Stat_id` int(5) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`Comp_id`, `Comp_name`, `Comp_identification`, `Comp_email`, `Comp_phone`, `DocType_id`, `Stat_id`, `updated_at`, `created_at`) VALUES
(1, 'Sinapsis Technologies', '901261786', 'info@sinapsist.com.co', '3012528242', 6, 2, NULL, '2023-01-30 21:22:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_contact`
--

CREATE TABLE `company_contact` (
  `Comp_contac_id` int(10) UNSIGNED NOT NULL,
  `Comp_id` int(10) UNSIGNED NOT NULL,
  `Contact_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact`
--

CREATE TABLE `contact` (
  `Contact_id` int(10) UNSIGNED NOT NULL,
  `Contact_name` varchar(100) NOT NULL,
  `Contact_charge` varchar(50) NOT NULL,
  `Contact_phone` varchar(10) NOT NULL,
  `Contact_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

CREATE TABLE `country` (
  `Country_id` int(10) UNSIGNED NOT NULL,
  `Country_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `country`
--

INSERT INTO `country` (`Country_id`, `Country_name`) VALUES
(1, 'Afganistan'),
(2, 'Albania'),
(3, 'Alemania'),
(4, 'Andorra'),
(5, 'Angola'),
(6, 'Antigua y Barbuda'),
(7, 'Arabia Saudita / Arabia Saudí'),
(8, 'Argelia'),
(9, 'Armenia'),
(10, 'Australia'),
(11, 'Austria'),
(12, 'Azerbaiyán'),
(13, 'Gabón'),
(14, 'Gambia'),
(15, 'Georgia'),
(16, 'Ghana'),
(17, 'Granada'),
(18, 'Grecia'),
(19, 'Guatemala'),
(20, 'Guinea'),
(21, 'Guinea-Bisáu'),
(22, 'Guinea Ecuatorial'),
(23, 'Guyana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctype`
--

CREATE TABLE `doctype` (
  `DocType_id` int(10) UNSIGNED NOT NULL,
  `DocType_name` varchar(100) NOT NULL,
  `DocType_code` varchar(10) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `doctype`
--

INSERT INTO `doctype` (`DocType_id`, `DocType_name`, `DocType_code`, `updated_at`, `created_at`) VALUES
(1, 'Registro civil de nacimiento', '11', NULL, '2023-01-30 21:14:01'),
(2, 'Tarjeta de identidad', '12', NULL, '2023-01-30 21:14:01'),
(3, 'Cédula de ciudadanía', '13', NULL, '2023-01-30 21:17:22'),
(4, 'Tarjeta de extranjería', '21', NULL, '2023-01-30 21:17:22'),
(5, 'Cédula de extranjería', '22', NULL, '2023-01-30 21:17:42'),
(6, 'NIT', '31', NULL, '2023-01-30 21:17:42'),
(7, 'Pasaporte', '41', NULL, '2023-01-30 21:18:04'),
(8, 'Tipo de documento extranjero', '42', '0000-00-00 00:00:00', '2023-01-30 21:18:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filing`
--

CREATE TABLE `filing` (
  `Filing_id` int(11) UNSIGNED NOT NULL,
  `Filing_name` varchar(100) NOT NULL,
  `Filing_description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `filing`
--

INSERT INTO `filing` (`Filing_id`, `Filing_name`, `Filing_description`) VALUES
(1, 'Virtual ', 'Virtual ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2023-01-17-195438', 'App\\Database\\Migrations\\AddUser', 'default', 'App', 1674061564, 1),
(2, '2023-01-18-105045', 'App\\Database\\Migrations\\AddCompany', 'default', 'App', 1674061564, 1),
(3, '2023-01-18-105614', 'App\\Database\\Migrations\\AddDocumentType', 'default', 'App', 1674061564, 1),
(4, '2023-01-18-142236', 'App\\Database\\Migrations\\AddClient', 'default', 'App', 1674061564, 1),
(5, '2023-01-18-153416', 'App\\Database\\Migrations\\AddStatusType', 'default', 'App', 1674061564, 1),
(6, '2023-01-18-154308', 'App\\Database\\Migrations\\AddStatus', 'default', 'App', 1674061564, 1),
(7, '2023-01-19-092911', 'App\\Database\\Migrations\\AddRole', 'default', 'App', 1674120943, 2),
(8, '2023-01-19-092927', 'App\\Database\\Migrations\\AddModule', 'default', 'App', 1674120943, 2),
(9, '2023-01-19-093007', 'App\\Database\\Migrations\\AddPermit', 'default', 'App', 1674120943, 2),
(10, '2023-01-19-094918', 'App\\Database\\Migrations\\AddRoleModule', 'default', 'App', 1674122237, 3),
(12, '2023-01-19-094930', 'App\\Database\\Migrations\\AddRoleModulePermit', 'default', 'App', 1674124239, 4),
(13, '2023-01-19-101314', 'App\\Database\\Migrations\\AddProfile', 'default', 'App', 1674124955, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `module`
--

CREATE TABLE `module` (
  `Mod_id` int(10) UNSIGNED NOT NULL,
  `Mod_name` varchar(50) NOT NULL,
  `Mod_route` varchar(30) NOT NULL,
  `Mod_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `module`
--

INSERT INTO `module` (`Mod_id`, `Mod_name`, `Mod_route`, `Mod_description`, `updated_at`, `created_at`) VALUES
(1, 'HOME', 'home/home', 'Is Home', NULL, '2023-01-30 21:42:37'),
(2, 'USER', 'user/user', 'USER', NULL, '2023-01-30 22:28:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permit`
--

CREATE TABLE `permit` (
  `Perm_id` int(10) UNSIGNED NOT NULL,
  `Perm_name` varchar(50) NOT NULL,
  `Perm_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permit`
--

INSERT INTO `permit` (`Perm_id`, `Perm_name`, `Perm_description`, `updated_at`, `created_at`) VALUES
(1, 'Create', 'Create', NULL, '2023-01-30 21:48:49'),
(2, 'Read', 'Read', NULL, '2023-01-30 21:48:49'),
(3, 'Update', 'Update', NULL, '2023-01-30 21:49:12'),
(4, 'Delete', 'Delete', NULL, '2023-01-30 21:49:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `Prod_id` int(11) NOT NULL,
  `Prod_name` varchar(100) NOT NULL,
  `Prod_description` varchar(200) NOT NULL,
  `Prod_value` double NOT NULL,
  `TypePro_id` int(11) UNSIGNED NOT NULL,
  `Unit_id` int(11) UNSIGNED NOT NULL,
  `Filing_id` int(11) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`Prod_id`, `Prod_name`, `Prod_description`, `Prod_value`, `TypePro_id`, `Unit_id`, `Filing_id`, `updated_at`, `created_at`) VALUES
(1, 'Desarrollo de pagina web ', 'Desarrollo de pagina web ', 750000, 1, 1, 1, '2023-02-20 08:47:16', '2023-02-20 02:48:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_type`
--

CREATE TABLE `product_type` (
  `TypePro_id` int(11) UNSIGNED NOT NULL,
  `TypePro_name` varchar(100) NOT NULL,
  `TypePro_description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `product_type`
--

INSERT INTO `product_type` (`TypePro_id`, `TypePro_name`, `TypePro_description`) VALUES
(1, 'Digital ', ''),
(2, 'Físico ', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile`
--

CREATE TABLE `profile` (
  `Profile_id` int(10) UNSIGNED NOT NULL,
  `Profile_lastName` varchar(100) NOT NULL,
  `Profile_surName` varchar(100) NOT NULL,
  `Profile_img` varchar(150) NOT NULL,
  `Profile_cellphone` varchar(10) NOT NULL,
  `Profile_identification` varchar(10) NOT NULL,
  `Profile_email` varchar(255) NOT NULL,
  `DocType_id` int(10) UNSIGNED NOT NULL,
  `User_id` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project`
--

CREATE TABLE `project` (
  `Project_id` int(10) UNSIGNED NOT NULL,
  `Project_code` varchar(10) NOT NULL,
  `Project_name` varchar(100) NOT NULL,
  `Project_purchaseOrder` varchar(10) NOT NULL,
  `Project_ddtStartDate` datetime NOT NULL DEFAULT current_timestamp(),
  `Project_ddtEndDate` datetime DEFAULT NULL,
  `Project_startDate` datetime DEFAULT NULL,
  `Project_estimatedEndDate` datetime DEFAULT NULL,
  `Project_activitiStartDate` datetime DEFAULT NULL,
  `Project_link` varchar(200) NOT NULL,
  `Project_observation` varchar(300) NOT NULL,
  `Client_id` int(10) UNSIGNED NOT NULL,
  `Country_id` int(10) UNSIGNED NOT NULL,
  `User_id` int(10) UNSIGNED NOT NULL,
  `Stat_id` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_product`
--

CREATE TABLE `project_product` (
  `Project_product_id` int(10) UNSIGNED NOT NULL,
  `Project_productAmount` varchar(10) NOT NULL,
  `Project_id` int(10) UNSIGNED NOT NULL,
  `Prod_id` int(10) UNSIGNED NOT NULL,
  `Stat_id` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `Role_id` int(10) UNSIGNED NOT NULL,
  `Role_name` varchar(50) NOT NULL,
  `Role_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`Role_id`, `Role_name`, `Role_description`, `updated_at`, `created_at`) VALUES
(1, 'Administrator', 'Administrator', NULL, '2023-01-30 21:50:45'),
(2, 'Cliente', 'Cliente', NULL, '2023-02-27 21:37:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_module`
--

CREATE TABLE `role_module` (
  `Role_mod_id` int(10) UNSIGNED NOT NULL,
  `Role_id` int(10) UNSIGNED NOT NULL,
  `Mod_id` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `role_module`
--

INSERT INTO `role_module` (`Role_mod_id`, `Role_id`, `Mod_id`, `updated_at`, `created_at`) VALUES
(1, 1, 1, NULL, '2023-01-30 21:51:24'),
(2, 1, 2, NULL, '2023-01-30 22:28:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_module_permit`
--

CREATE TABLE `role_module_permit` (
  `Role_mod_per_id` int(10) UNSIGNED NOT NULL,
  `Perm_id` int(10) UNSIGNED NOT NULL,
  `Role_mod_id` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `role_module_permit`
--

INSERT INTO `role_module_permit` (`Role_mod_per_id`, `Perm_id`, `Role_mod_id`, `updated_at`, `created_at`) VALUES
(1, 2, 1, NULL, '2023-01-30 21:52:10'),
(2, 3, 1, NULL, '2023-01-30 21:52:57'),
(3, 2, 2, NULL, '2023-01-30 22:29:00'),
(4, 1, 2, NULL, '2023-01-30 22:29:11'),
(5, 4, 2, NULL, '2023-01-30 22:29:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `Stat_id` int(10) UNSIGNED NOT NULL,
  `Stat_name` varchar(100) NOT NULL,
  `Stat_description` varchar(200) NOT NULL,
  `StatType_id` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`Stat_id`, `Stat_name`, `Stat_description`, `StatType_id`, `updated_at`, `created_at`) VALUES
(1, 'Active', 'Status Active', 1, NULL, '2023-01-27 22:03:01'),
(2, 'Active', 'Status Active Company', 2, NULL, '2023-01-30 21:20:54'),
(3, 'Active', 'Status Active Client', 3, NULL, '2023-02-20 02:22:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `statustype`
--

CREATE TABLE `statustype` (
  `StatType_id` int(10) UNSIGNED NOT NULL,
  `StatType_name` varchar(100) NOT NULL,
  `StatType_description` varchar(200) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `statustype`
--

INSERT INTO `statustype` (`StatType_id`, `StatType_name`, `StatType_description`, `updated_at`, `created_at`) VALUES
(1, 'User', 'Status User', NULL, '2023-01-27 22:02:15'),
(2, 'Company', 'Status Company', NULL, '2023-01-30 21:20:19'),
(3, 'Client', 'Status Client', NULL, '2023-02-20 02:21:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unit`
--

CREATE TABLE `unit` (
  `Unit_id` int(11) UNSIGNED NOT NULL,
  `Unit_name` varchar(100) NOT NULL,
  `Unit_symbol` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `unit`
--

INSERT INTO `unit` (`Unit_id`, `Unit_name`, `Unit_symbol`) VALUES
(1, 'Unidad', 'UNI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `User_id` int(10) UNSIGNED NOT NULL,
  `User_email` varchar(100) NOT NULL,
  `User_password` varchar(255) NOT NULL,
  `Comp_id` int(10) UNSIGNED NOT NULL,
  `Stat_id` int(10) UNSIGNED NOT NULL,
  `Role_id` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`User_id`, `User_email`, `User_password`, `Comp_id`, `Stat_id`, `Role_id`, `updated_at`, `created_at`) VALUES
(1, 'd.casallas@sinapsist.com.co', '$2y$10$HKc7OJ.5sCwmDYNd1wv/IOLVBuJf6Zs7VHasW57Ng4lbIKlsL8Ioi', 1, 1, 2, '2023-03-07 20:17:15', '2023-01-30 22:10:44'),
(212, 'diehercasvan@gmail.com', '$2y$10$KnJWFxVif2qpEOfZVYPYledtmu7wAI6gkgiwCoRKHsS3jiEhOqA3m', 1, 1, 2, NULL, '2023-02-25 22:25:58'),
(216, 'diehercas@gmail.com', '$2y$10$WuaZbhdaqpKkzr0uq5tEGOtWjPxJcV3PNYpUyqigqJOJOz4JzuVyS', 1, 1, 1, '2023-02-28 03:02:47', '2023-02-27 14:28:28'),
(217, 'pequitas@gmail.com', '$2y$10$909LAeXkPJhBWpvvvW5pPupoU/bgS9qU5Rtn/bvL5yvGPgggh.HWG', 1, 1, 1, '2023-02-28 03:09:52', '2023-02-27 14:51:10'),
(218, 'd.sinapsis@sinapsis.com.co', '$2y$10$RQpl4H4/GCcNI0GZUCr8iuDww4bFeEdAtzTYdR/C3s7GklFXh6y1e', 1, 1, 1, NULL, '2023-02-27 21:15:21'),
(219, 'diegoaaa@gmail.com', '$2y$10$xeIcp/EPluOsmU.m7B1sde.Hcg9tGI2FWuYSWfskuRr95oaxiKGwm', 1, 1, 1, '0000-00-00 00:00:00', '2023-03-07 14:49:03'),
(220, 'sinapsis@gmail.com', '$2y$10$ediAxyuSP0zWSVXS998XluZ3sAQaBUlzeCo5RfMAq.Rnni1Bhmd2q', 1, 1, 1, '0000-00-00 00:00:00', '2023-03-07 15:10:02'),
(221, 'sinapsittt@gmail.com', '$2y$10$LfH.q4DpMbBJi7N3m4H/Te5sd6yfkVC6rv5qo3aYKJjDQ4W6fCRvG', 1, 1, 2, '0000-00-00 00:00:00', '2023-03-07 15:10:46');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`Activi_id`),
  ADD KEY `activities_status` (`Stat_id`),
  ADD KEY `activities_user` (`User_id`),
  ADD KEY `activities_project_product` (`Project_product_id`),
  ADD KEY `activities_code` (`Appr_code_activi_id`);

--
-- Indices de la tabla `approvalcode`
--
ALTER TABLE `approvalcode`
  ADD PRIMARY KEY (`ApprCode_id`);

--
-- Indices de la tabla `approvalcodeactivities`
--
ALTER TABLE `approvalcodeactivities`
  ADD PRIMARY KEY (`Appr_code_activi_id`),
  ADD KEY `approvalcodeactivities_appCode` (`ApprCode_id`),
  ADD KEY `approvalcodeactivities_Act` (`Activi_id`);

--
-- Indices de la tabla `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`Brand_id`),
  ADD KEY `brand_client` (`Client_id`);

--
-- Indices de la tabla `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`Client_id`),
  ADD UNIQUE KEY `Client_identification` (`Client_identification`),
  ADD UNIQUE KEY `Client_email` (`Client_email`),
  ADD KEY `client_company` (`Comp_id`),
  ADD KEY `client_docType` (`DocType_id`),
  ADD KEY `client_state` (`Stat_id`),
  ADD KEY `client_contry` (`Country_id`);

--
-- Indices de la tabla `client_contact`
--
ALTER TABLE `client_contact`
  ADD PRIMARY KEY (`Client_contact_id`),
  ADD KEY `client_contact_client` (`Client_id`),
  ADD KEY `client_contact_contact` (`Contact_id`);

--
-- Indices de la tabla `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`Comp_id`),
  ADD UNIQUE KEY `Comp_identification` (`Comp_identification`),
  ADD UNIQUE KEY `Comp_email` (`Comp_email`),
  ADD KEY `company_status` (`Stat_id`),
  ADD KEY `company_doctType` (`DocType_id`);

--
-- Indices de la tabla `company_contact`
--
ALTER TABLE `company_contact`
  ADD PRIMARY KEY (`Comp_contac_id`),
  ADD KEY `company_contact_company` (`Comp_id`),
  ADD KEY `company_contact_contact` (`Contact_id`);

--
-- Indices de la tabla `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`Contact_id`),
  ADD UNIQUE KEY `Contact_email` (`Contact_email`);

--
-- Indices de la tabla `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`Country_id`);

--
-- Indices de la tabla `doctype`
--
ALTER TABLE `doctype`
  ADD PRIMARY KEY (`DocType_id`);

--
-- Indices de la tabla `filing`
--
ALTER TABLE `filing`
  ADD PRIMARY KEY (`Filing_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`Mod_id`);

--
-- Indices de la tabla `permit`
--
ALTER TABLE `permit`
  ADD PRIMARY KEY (`Perm_id`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Prod_id`),
  ADD KEY `product_typeProduct` (`TypePro_id`),
  ADD KEY `product_uni` (`Unit_id`),
  ADD KEY `product_filing` (`Filing_id`);

--
-- Indices de la tabla `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`TypePro_id`);

--
-- Indices de la tabla `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`Profile_id`),
  ADD KEY `profile_user` (`User_id`),
  ADD KEY `profile_doctype` (`DocType_id`);

--
-- Indices de la tabla `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`Project_id`),
  ADD KEY `project_stati` (`Stat_id`),
  ADD KEY `project_user` (`User_id`),
  ADD KEY `project_client` (`Client_id`),
  ADD KEY `project_contry` (`Country_id`);

--
-- Indices de la tabla `project_product`
--
ALTER TABLE `project_product`
  ADD PRIMARY KEY (`Project_product_id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`Role_id`);

--
-- Indices de la tabla `role_module`
--
ALTER TABLE `role_module`
  ADD PRIMARY KEY (`Role_mod_id`),
  ADD KEY `role_module` (`Mod_id`),
  ADD KEY `role_module_role` (`Role_id`);

--
-- Indices de la tabla `role_module_permit`
--
ALTER TABLE `role_module_permit`
  ADD PRIMARY KEY (`Role_mod_per_id`),
  ADD KEY `Role_mod_id` (`Role_mod_id`),
  ADD KEY `Perm_id` (`Perm_id`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`Stat_id`),
  ADD KEY `status_StatusType` (`StatType_id`);

--
-- Indices de la tabla `statustype`
--
ALTER TABLE `statustype`
  ADD PRIMARY KEY (`StatType_id`);

--
-- Indices de la tabla `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`Unit_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_id`),
  ADD UNIQUE KEY `User_email` (`User_email`),
  ADD KEY `user_status` (`Stat_id`),
  ADD KEY `user_company` (`Comp_id`),
  ADD KEY `Role_id` (`Role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activities`
--
ALTER TABLE `activities`
  MODIFY `Activi_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `approvalcode`
--
ALTER TABLE `approvalcode`
  MODIFY `ApprCode_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `approvalcodeactivities`
--
ALTER TABLE `approvalcodeactivities`
  MODIFY `Appr_code_activi_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `brand`
--
ALTER TABLE `brand`
  MODIFY `Brand_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `client`
--
ALTER TABLE `client`
  MODIFY `Client_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `company`
--
ALTER TABLE `company`
  MODIFY `Comp_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `company_contact`
--
ALTER TABLE `company_contact`
  MODIFY `Comp_contac_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contact`
--
ALTER TABLE `contact`
  MODIFY `Contact_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doctype`
--
ALTER TABLE `doctype`
  MODIFY `DocType_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `filing`
--
ALTER TABLE `filing`
  MODIFY `Filing_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `module`
--
ALTER TABLE `module`
  MODIFY `Mod_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permit`
--
ALTER TABLE `permit`
  MODIFY `Perm_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `Prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `product_type`
--
ALTER TABLE `product_type`
  MODIFY `TypePro_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `profile`
--
ALTER TABLE `profile`
  MODIFY `Profile_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `project`
--
ALTER TABLE `project`
  MODIFY `Project_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `project_product`
--
ALTER TABLE `project_product`
  MODIFY `Project_product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `Role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `role_module`
--
ALTER TABLE `role_module`
  MODIFY `Role_mod_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `role_module_permit`
--
ALTER TABLE `role_module_permit`
  MODIFY `Role_mod_per_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `Stat_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `statustype`
--
ALTER TABLE `statustype`
  MODIFY `StatType_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `unit`
--
ALTER TABLE `unit`
  MODIFY `Unit_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `User_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_code` FOREIGN KEY (`Appr_code_activi_id`) REFERENCES `approvalcodeactivities` (`Appr_code_activi_id`),
  ADD CONSTRAINT `activities_project_product` FOREIGN KEY (`Project_product_id`) REFERENCES `project_product` (`Project_product_id`),
  ADD CONSTRAINT `activities_status` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`),
  ADD CONSTRAINT `activities_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`);

--
-- Filtros para la tabla `approvalcodeactivities`
--
ALTER TABLE `approvalcodeactivities`
  ADD CONSTRAINT `approvalcodeactivities_Act` FOREIGN KEY (`Activi_id`) REFERENCES `activities` (`Activi_id`),
  ADD CONSTRAINT `approvalcodeactivities_appCode` FOREIGN KEY (`ApprCode_id`) REFERENCES `approvalcode` (`ApprCode_id`);

--
-- Filtros para la tabla `brand`
--
ALTER TABLE `brand`
  ADD CONSTRAINT `brand_client` FOREIGN KEY (`Client_id`) REFERENCES `client` (`Client_id`);

--
-- Filtros para la tabla `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_company` FOREIGN KEY (`Comp_id`) REFERENCES `company` (`Comp_id`),
  ADD CONSTRAINT `client_contry` FOREIGN KEY (`Country_id`) REFERENCES `country` (`Country_id`),
  ADD CONSTRAINT `client_docType` FOREIGN KEY (`DocType_id`) REFERENCES `doctype` (`DocType_id`),
  ADD CONSTRAINT `client_state` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`);

--
-- Filtros para la tabla `client_contact`
--
ALTER TABLE `client_contact`
  ADD CONSTRAINT `client_contact_client` FOREIGN KEY (`Client_id`) REFERENCES `client` (`Client_id`),
  ADD CONSTRAINT `client_contact_contact` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`Contact_id`);

--
-- Filtros para la tabla `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_doctType` FOREIGN KEY (`DocType_id`) REFERENCES `doctype` (`DocType_id`),
  ADD CONSTRAINT `company_status` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`);

--
-- Filtros para la tabla `company_contact`
--
ALTER TABLE `company_contact`
  ADD CONSTRAINT `company_contact_company` FOREIGN KEY (`Comp_id`) REFERENCES `company` (`Comp_id`),
  ADD CONSTRAINT `company_contact_contact` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`Contact_id`);

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_filing` FOREIGN KEY (`Filing_id`) REFERENCES `filing` (`Filing_id`),
  ADD CONSTRAINT `product_typeProduct` FOREIGN KEY (`TypePro_id`) REFERENCES `product_type` (`TypePro_id`),
  ADD CONSTRAINT `product_uni` FOREIGN KEY (`Unit_id`) REFERENCES `unit` (`Unit_id`);

--
-- Filtros para la tabla `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_doctype` FOREIGN KEY (`DocType_id`) REFERENCES `doctype` (`DocType_id`),
  ADD CONSTRAINT `profile_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`);

--
-- Filtros para la tabla `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_client` FOREIGN KEY (`Client_id`) REFERENCES `client` (`Client_id`),
  ADD CONSTRAINT `project_contry` FOREIGN KEY (`Country_id`) REFERENCES `country` (`Country_id`),
  ADD CONSTRAINT `project_stati` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`),
  ADD CONSTRAINT `project_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`);

--
-- Filtros para la tabla `role_module`
--
ALTER TABLE `role_module`
  ADD CONSTRAINT `role_module` FOREIGN KEY (`Mod_id`) REFERENCES `module` (`Mod_id`),
  ADD CONSTRAINT `role_module_role` FOREIGN KEY (`Role_id`) REFERENCES `role` (`Role_id`);

--
-- Filtros para la tabla `role_module_permit`
--
ALTER TABLE `role_module_permit`
  ADD CONSTRAINT `role_module_permit_ibfk_1` FOREIGN KEY (`Role_mod_id`) REFERENCES `role_module` (`Role_mod_id`),
  ADD CONSTRAINT `role_module_permit_ibfk_2` FOREIGN KEY (`Perm_id`) REFERENCES `permit` (`Perm_id`);

--
-- Filtros para la tabla `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_StatusType` FOREIGN KEY (`StatType_id`) REFERENCES `statustype` (`StatType_id`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_company` FOREIGN KEY (`Comp_id`) REFERENCES `company` (`Comp_id`),
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`Role_id`) REFERENCES `role` (`Role_id`),
  ADD CONSTRAINT `user_status` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
