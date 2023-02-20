-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-02-2023 a las 09:00:15
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
CREATE DATABASE IF NOT EXISTS `dendrite_projects_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dendrite_projects_management`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `Client_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Client_name` varchar(100) NOT NULL,
  `Client_identification` varchar(20) NOT NULL,
  `Client_email` varchar(100) NOT NULL,
  `Client_phone` varchar(10) NOT NULL,
  `Client_address` varchar(100) NOT NULL,
  `DocType_id` int(5) UNSIGNED NOT NULL,
  `Comp_id` int(5) UNSIGNED NOT NULL,
  `Stat_id` int(5) UNSIGNED NOT NULL,
  `Country_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Client_id`),
  UNIQUE KEY `Client_identification` (`Client_identification`),
  UNIQUE KEY `Client_email` (`Client_email`),
  KEY `client_company` (`Comp_id`),
  KEY `client_docType` (`DocType_id`),
  KEY `client_state` (`Stat_id`),
  KEY `Country_id` (`Country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `client`
--

TRUNCATE TABLE `client`;
--
-- Volcado de datos para la tabla `client`
--

INSERT INTO `client` (`Client_id`, `Client_name`, `Client_identification`, `Client_email`, `Client_phone`, `Client_address`, `DocType_id`, `Comp_id`, `Stat_id`, `Country_id`, `updated_at`, `created_at`) VALUES
(1, 'Market Support', '9012356487', 'market@gmail.com', '3012528242', 'Calle ', 6, 1, 3, 1, NULL, '2023-02-20 02:23:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `Comp_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Comp_name` varchar(100) NOT NULL,
  `Comp_identification` varchar(20) NOT NULL,
  `Comp_email` varchar(100) NOT NULL,
  `Comp_phone` varchar(10) NOT NULL,
  `DocType_id` int(5) UNSIGNED NOT NULL,
  `Stat_id` int(5) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Comp_id`),
  UNIQUE KEY `Comp_identification` (`Comp_identification`),
  UNIQUE KEY `Comp_email` (`Comp_email`),
  KEY `company_state` (`Stat_id`),
  KEY `company_docType` (`DocType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `company`
--

TRUNCATE TABLE `company`;
--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`Comp_id`, `Comp_name`, `Comp_identification`, `Comp_email`, `Comp_phone`, `DocType_id`, `Stat_id`, `updated_at`, `created_at`) VALUES
(1, 'Sinapsis Technologies', '901261786', 'info@sinapsist.com.co', '3012528242', 6, 2, NULL, '2023-01-30 21:22:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `Country_id` int(11) NOT NULL AUTO_INCREMENT,
  `Country_name` varchar(100) NOT NULL,
  PRIMARY KEY (`Country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

--
-- Truncar tablas antes de insertar `country`
--

TRUNCATE TABLE `country`;
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

DROP TABLE IF EXISTS `doctype`;
CREATE TABLE IF NOT EXISTS `doctype` (
  `DocType_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `DocType_name` varchar(100) NOT NULL,
  `DocType_code` varchar(10) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`DocType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `doctype`
--

TRUNCATE TABLE `doctype`;
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

DROP TABLE IF EXISTS `filing`;
CREATE TABLE IF NOT EXISTS `filing` (
  `Filing_id` int(11) NOT NULL AUTO_INCREMENT,
  `Filing_name` varchar(100) NOT NULL,
  `Filing_description` varchar(200) NOT NULL,
  PRIMARY KEY (`Filing_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Truncar tablas antes de insertar `filing`
--

TRUNCATE TABLE `filing`;
--
-- Volcado de datos para la tabla `filing`
--

INSERT INTO `filing` (`Filing_id`, `Filing_name`, `Filing_description`) VALUES
(1, 'Virtual ', 'Virtual ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `migrations`
--

TRUNCATE TABLE `migrations`;
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

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `Mod_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Mod_name` varchar(50) NOT NULL,
  `Mod_route` varchar(30) NOT NULL,
  `Mod_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Mod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `module`
--

TRUNCATE TABLE `module`;
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

DROP TABLE IF EXISTS `permit`;
CREATE TABLE IF NOT EXISTS `permit` (
  `Perm_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Perm_name` varchar(50) NOT NULL,
  `Perm_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Perm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `permit`
--

TRUNCATE TABLE `permit`;
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

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `Prod_id` int(11) NOT NULL AUTO_INCREMENT,
  `Prod_name` varchar(100) NOT NULL,
  `Prod_description` varchar(200) NOT NULL,
  `Prod_value` double NOT NULL,
  `TypePro_id` int(11) NOT NULL,
  `Unit_id` int(11) NOT NULL,
  `Filing_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Prod_id`),
  KEY `product_filing` (`Filing_id`),
  KEY `product_uni` (`Unit_id`),
  KEY `product_typePro` (`TypePro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Truncar tablas antes de insertar `product`
--

TRUNCATE TABLE `product`;
--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`Prod_id`, `Prod_name`, `Prod_description`, `Prod_value`, `TypePro_id`, `Unit_id`, `Filing_id`, `updated_at`, `created_at`) VALUES
(1, 'Desarrollo de pagina web ', 'Desarrollo de pagina web ', 750000, 1, 1, 1, '2023-02-20 08:47:16', '2023-02-20 02:48:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_type`
--

DROP TABLE IF EXISTS `product_type`;
CREATE TABLE IF NOT EXISTS `product_type` (
  `TypePro_id` int(11) NOT NULL AUTO_INCREMENT,
  `TypePro_name` varchar(100) NOT NULL,
  `TypePro_description` varchar(200) NOT NULL,
  PRIMARY KEY (`TypePro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Truncar tablas antes de insertar `product_type`
--

TRUNCATE TABLE `product_type`;
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

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `Profile_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Profile_lastName` varchar(100) NOT NULL,
  `Profile_surName` varchar(100) NOT NULL,
  `Profile_img` varchar(150) NOT NULL,
  `Profile_cellphone` varchar(10) NOT NULL,
  `Profile_identification` varchar(10) NOT NULL,
  `Profile_email` varchar(255) NOT NULL,
  `DocType_id` int(5) UNSIGNED NOT NULL,
  `User_id` int(5) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Profile_id`),
  KEY `profile_user` (`User_id`),
  KEY `profile_doctype` (`DocType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `profile`
--

TRUNCATE TABLE `profile`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `Role_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Role_name` varchar(50) NOT NULL,
  `Role_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `role`
--

TRUNCATE TABLE `role`;
--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`Role_id`, `Role_name`, `Role_description`, `updated_at`, `created_at`) VALUES
(1, 'Administrator', 'Administrator', NULL, '2023-01-30 21:50:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_module`
--

DROP TABLE IF EXISTS `role_module`;
CREATE TABLE IF NOT EXISTS `role_module` (
  `Role_mod_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Role_id` int(5) UNSIGNED NOT NULL,
  `Mod_id` int(5) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Role_mod_id`),
  KEY `role_module` (`Mod_id`),
  KEY `role_module_role` (`Role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `role_module`
--

TRUNCATE TABLE `role_module`;
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

DROP TABLE IF EXISTS `role_module_permit`;
CREATE TABLE IF NOT EXISTS `role_module_permit` (
  `Role_mod_per_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Perm_id` int(5) UNSIGNED NOT NULL,
  `Role_mod_id` int(5) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Role_mod_per_id`),
  KEY `Role_mod_id` (`Role_mod_id`),
  KEY `Perm_id` (`Perm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `role_module_permit`
--

TRUNCATE TABLE `role_module_permit`;
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

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `Stat_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Stat_name` varchar(100) NOT NULL,
  `Stat_description` varchar(200) NOT NULL,
  `StatType_id` int(5) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Stat_id`),
  KEY `status_StatusType` (`StatType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `status`
--

TRUNCATE TABLE `status`;
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

DROP TABLE IF EXISTS `statustype`;
CREATE TABLE IF NOT EXISTS `statustype` (
  `StatType_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `StatType_name` varchar(100) NOT NULL,
  `StatType_description` varchar(200) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`StatType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `statustype`
--

TRUNCATE TABLE `statustype`;
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

DROP TABLE IF EXISTS `unit`;
CREATE TABLE IF NOT EXISTS `unit` (
  `Unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `Unit_name` varchar(100) NOT NULL,
  `Unit_symbol` varchar(5) NOT NULL,
  PRIMARY KEY (`Unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Truncar tablas antes de insertar `unit`
--

TRUNCATE TABLE `unit`;
--
-- Volcado de datos para la tabla `unit`
--

INSERT INTO `unit` (`Unit_id`, `Unit_name`, `Unit_symbol`) VALUES
(1, 'Unidad', 'UNI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `User_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `User_email` varchar(100) NOT NULL,
  `User_password` varchar(255) NOT NULL,
  `Comp_id` int(5) UNSIGNED NOT NULL,
  `Stat_id` int(5) UNSIGNED NOT NULL,
  `Role_id` int(5) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`User_id`),
  UNIQUE KEY `User_email` (`User_email`),
  KEY `user_status` (`Stat_id`),
  KEY `user_company` (`Comp_id`),
  KEY `Role_id` (`Role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `user`
--

TRUNCATE TABLE `user`;
--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`User_id`, `User_email`, `User_password`, `Comp_id`, `Stat_id`, `Role_id`, `updated_at`, `created_at`) VALUES
(1, 'd.casallas@sinapsist.com.co', 'Sinapsis2023*', 1, 2, 1, NULL, '2023-01-30 22:10:44');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_company` FOREIGN KEY (`Comp_id`) REFERENCES `company` (`Comp_id`),
  ADD CONSTRAINT `client_docType` FOREIGN KEY (`DocType_id`) REFERENCES `doctype` (`DocType_id`),
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`Country_id`) REFERENCES `country` (`Country_id`),
  ADD CONSTRAINT `client_state` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`);

--
-- Filtros para la tabla `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_docType` FOREIGN KEY (`DocType_id`) REFERENCES `doctype` (`DocType_id`),
  ADD CONSTRAINT `company_state` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`);

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_filing` FOREIGN KEY (`Filing_id`) REFERENCES `filing` (`Filing_id`),
  ADD CONSTRAINT `product_typePro` FOREIGN KEY (`TypePro_id`) REFERENCES `product_type` (`TypePro_id`),
  ADD CONSTRAINT `product_uni` FOREIGN KEY (`Unit_id`) REFERENCES `unit` (`Unit_id`);

--
-- Filtros para la tabla `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_doctype` FOREIGN KEY (`DocType_id`) REFERENCES `doctype` (`DocType_id`),
  ADD CONSTRAINT `profile_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`);

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
