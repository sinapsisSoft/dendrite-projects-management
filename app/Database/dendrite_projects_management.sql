-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 17-05-2023 a las 15:31:31
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `dendrite_projects_management`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `sp_select_all_activities`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_activities` ()   BEGIN 
SELECT A.Activi_id, A.Activi_name, AP.ApprCode_code, A.created_at FROM activities A INNER JOIN approvalcode AP on AP.ApprCode_id = A.ApprCode_id;

END$$

DROP PROCEDURE IF EXISTS `sp_select_all_details_activities`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_details_activities` (IN `Activi_id` INT)   BEGIN
SELECT
A.Activi_id,
    A.Activi_name,
    A.Activi_code,
    A.Activi_codeMiigo,
    A.Activi_codeSpectra,
    A.Activi_codeDelivery,
    A.Activi_endDate,
    A.Activi_percentage,
    S.Stat_name,
    U.User_email,
    P.Prod_name
FROM activities A
LEFT JOIN status S ON S.Stat_id = A.Stat_id
LEFT JOIN user U ON U.User_id = A.User_assigned
LEFT JOIN project_product PP ON PP.Project_product_id = A.Project_product_id
LEFT JOIN product P ON P.Prod_id = PP.Prod_id
WHERE A.Activi_id = Activi_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_details_subactivities`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_details_subactivities` (IN `SubAct_id` INT)   BEGIN
SELECT
    SA.SubAct_id,
    SA.SubAct_name,
    S.Stat_name,
    SA.SubAct_description
FROM subactivities SA
LEFT JOIN status S ON S.Stat_id = SA.Stat_id
WHERE SA.SubAct_id = SubAct_id; 
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_project`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_project` (IN `project_id` INT)   BEGIN

SELECT
P.Project_id,
P.Project_code,
P.Project_name,
C.Client_name,
M.Manager_name,
B.Brand_name,
P.Project_purchaseOrder,
P.Project_ddtStartDate,
CT.Country_name,
P.Project_ddtEndDate,
C.Client_name,
U.User_email,
P.Project_startDate,
P.Project_estimatedEndDate,
P.Project_activitiEndDate,
S.Stat_name,
P.Project_link,
P.Project_observation

FROM project P
INNER JOIN client C on C.Client_id = P.Client_id
INNER JOIN manager M on M.Manager_id = P.Manager_id
INNER JOIN brand B on B.Brand_id = P.Brand_id
INNER JOIN country CT on CT.Country_id = P.Country_id
INNER JOIN user U on U.User_id = P.User_id
INNER JOIN status S on S.Stat_id = P.Stat_id

WHERE P.Project_id = Project_id;

END$$

DROP PROCEDURE IF EXISTS `sp_select_all_project_product`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_project_product` (IN `project_id` INT)   SELECT
	PP.Project_product_id,
    P.Prod_name,
    PP.Project_productAmount,
    S.Stat_name,
    CASE 
    	WHEN S.Stat_name LIKE 'Realizado' THEN '#16FF00' 
        WHEN S.Stat_name LIKE 'Pendiente' THEN '#FFD93D'
        ELSE '#FF0303' END as color
FROM project_product PP
INNER JOIN product P ON P.Prod_id = PP.Prod_id
INNER JOIN status S ON S.Stat_id = PP.Stat_id
WHERE PP.Project_id = project_id$$

DROP PROCEDURE IF EXISTS `sp_select_all_subactivities`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_subactivities` (IN `activity_id` INT)   BEGIN
SELECT
 SA.SubAct_id,
 SA.SubAct_name,
 S.Stat_name,
 CASE 
    	WHEN S.Stat_name LIKE 'Realizado' THEN '#16FF00' 
        WHEN S.Stat_name LIKE 'Pendiente' THEN '#FFD93D'
        ELSE '#FF0303' END as color
FROM subactivities SA
INNER JOIN status S ON S.Stat_id = SA.Stat_id
WHERE SA.Activi_id = activity_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_users`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_users` ()   BEGIN
    SELECT User_id,User_email,CO.Comp_name,ST.Stat_name,RO.Role_name,USU.created_at AS Created_at FROM user USU 
    INNER JOIN status ST ON USU.Stat_id =ST.Stat_id
    INNER JOIN role RO ON USU.Role_id=RO.Role_id
    INNER JOIN company CO ON USU.Comp_id =CO.Comp_id
    WHERE ST.Stat_id=1 ORDER BY User_id ASC;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_users_comercial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_users_comercial` ()   BEGIN

SELECT U.User_id, U.User_email FROM user U INNER JOIN role R on R.Role_id = U.Role_id WHERE R.Role_name = "Comercial";

END$$

DROP PROCEDURE IF EXISTS `sp_select_all_users_developer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_users_developer` ()   BEGIN

SELECT U.User_id, U.User_email FROM user U INNER JOIN role R on R.Role_id = U.Role_id WHERE R.Role_name = "Developer";

END$$

DROP PROCEDURE IF EXISTS `sp_select_modules_role`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_modules_role` (IN `role_id` INT)   BEGIN
select 
	rm.Mod_id as mod_id,
    (select group_concat(rmp.Perm_id) from role_module_permit rmp 
where rmp.Role_mod_id = rm.Role_mod_id) as permits
from role_module rm where rm.Role_id = role_id;

END$$

DROP PROCEDURE IF EXISTS `sp_select_percent_project`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_percent_project` (IN `project_id` INT)   BEGIN
SELECT 
	ROUND(SUM(A.Activi_percentage) / COUNT(*)) as percent
FROM activities A
INNER JOIN project_product PP ON PP.Project_product_id = A.Project_product_id
WHERE PP.Project_id = project_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_status_users`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_status_users` ()   BEGIN
    SELECT Stat_id,Stat_name FROM status WHERE StatType_id=1;
END$$

DROP PROCEDURE IF EXISTS `sp_update_percent_activity`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_percent_activity` (IN `activity_id` INT)   BEGIN
SELECT @porcent := ROUND(SUM(SubAct_percentage) / COUNT(*)) as porcent FROM subactivities WHERE Activi_id = activity_id;
SELECT @porcent;
update activities set Activi_percentage = @porcent
WHERE Activi_id = activity_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activities`
--

DROP TABLE IF EXISTS `activities`;
CREATE TABLE IF NOT EXISTS `activities` (
  `Activi_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Activi_name` varchar(100) NOT NULL,
  `Activi_code` varchar(15) NOT NULL,
  `Activi_observation` varchar(200) NOT NULL,
  `Activi_startDate` datetime NOT NULL,
  `Activi_endDate` datetime DEFAULT NULL,
  `Activi_link` varchar(200) NOT NULL,
  `Activi_codeMiigo` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Activi_codeSpectra` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Activi_codeDelivery` int DEFAULT NULL,
  `Activi_percentage` varchar(15) NOT NULL,
  `Stat_id` int UNSIGNED DEFAULT NULL,
  `Project_product_id` int UNSIGNED DEFAULT NULL,
  `User_id` int UNSIGNED DEFAULT NULL,
  `User_assigned` int UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Activi_id`),
  KEY `activities_status` (`Stat_id`),
  KEY `activities_user` (`User_id`),
  KEY `activities_project_product` (`Project_product_id`),
  KEY `activities_approvalcode` (`Activi_code`),
  KEY `activities_user_assigned` (`User_assigned`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `activities`
--

INSERT INTO `activities` (`Activi_id`, `Activi_name`, `Activi_code`, `Activi_observation`, `Activi_startDate`, `Activi_endDate`, `Activi_link`, `Activi_codeMiigo`, `Activi_codeSpectra`, `Activi_codeDelivery`, `Activi_percentage`, `Stat_id`, `Project_product_id`, `User_id`, `User_assigned`, `updated_at`, `created_at`) VALUES
(11, 'danna', 'ACT_011', 'desarrollar', '2023-05-17 00:00:00', NULL, 'git', '125', '45', 78, '0', NULL, 1, NULL, 1, '0000-00-00 00:00:00', '2023-05-17 09:51:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE IF NOT EXISTS `brand` (
  `Brand_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Brand_name` varchar(50) NOT NULL,
  `Brand_description` varchar(100) NOT NULL,
  `Client_id` int UNSIGNED NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Brand_id`),
  KEY `brand_client` (`Client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `brand`
--

INSERT INTO `brand` (`Brand_id`, `Brand_name`, `Brand_description`, `Client_id`, `updated_at`, `created_at`) VALUES
(7, 'coca cola', 'fria', 2, '0000-00-00 00:00:00', '2023-03-28 11:59:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `City_id` int NOT NULL AUTO_INCREMENT,
  `City_name` varchar(50) NOT NULL,
  `Country_id` int NOT NULL,
  PRIMARY KEY (`City_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `city`
--

INSERT INTO `city` (`City_id`, `City_name`, `Country_id`) VALUES
(5, 'maracaibo', 2),
(4, 'Cartagena', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `Client_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Client_name` varchar(100) NOT NULL,
  `Client_identification` varchar(20) NOT NULL,
  `Client_email` varchar(100) NOT NULL,
  `Client_phone` varchar(10) NOT NULL,
  `Client_address` varchar(100) NOT NULL,
  `DocType_id` int UNSIGNED NOT NULL,
  `Comp_id` int UNSIGNED NOT NULL,
  `Stat_id` int UNSIGNED NOT NULL,
  `Country_id` int UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Client_id`),
  UNIQUE KEY `Client_identification` (`Client_identification`),
  UNIQUE KEY `Client_email` (`Client_email`),
  KEY `client_company` (`Comp_id`),
  KEY `client_docType` (`DocType_id`),
  KEY `client_state` (`Stat_id`),
  KEY `client_contry` (`Country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `client`
--

INSERT INTO `client` (`Client_id`, `Client_name`, `Client_identification`, `Client_email`, `Client_phone`, `Client_address`, `DocType_id`, `Comp_id`, `Stat_id`, `Country_id`, `updated_at`, `created_at`) VALUES
(2, 'pepe', '152478930', 'pepe@gmail.com', '3025897144', 'zaragocilla', 1, 1, 1, 1, NULL, '2023-03-23 12:13:46'),
(3, 'market support', '90126111', 'sinapsis@gmail.com', '3025897144', 'zaragocilla', 6, 14, 1, 1, NULL, '2023-05-05 11:08:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_contact`
--

DROP TABLE IF EXISTS `client_contact`;
CREATE TABLE IF NOT EXISTS `client_contact` (
  `Client_contact_id` int NOT NULL,
  `Contact_id` int UNSIGNED NOT NULL,
  `Client_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`Client_contact_id`),
  KEY `client_contact_client` (`Client_id`),
  KEY `client_contact_contact` (`Contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `Comp_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Comp_name` varchar(100) NOT NULL,
  `Comp_identification` varchar(20) NOT NULL,
  `Comp_email` varchar(100) NOT NULL,
  `Comp_phone` varchar(10) NOT NULL,
  `DocType_id` int UNSIGNED NOT NULL,
  `Stat_id` int UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Comp_id`),
  UNIQUE KEY `Comp_identification` (`Comp_identification`),
  UNIQUE KEY `Comp_email` (`Comp_email`),
  KEY `company_status` (`Stat_id`),
  KEY `company_doctType` (`DocType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`Comp_id`, `Comp_name`, `Comp_identification`, `Comp_email`, `Comp_phone`, `DocType_id`, `Stat_id`, `updated_at`, `created_at`) VALUES
(1, 'Sinapsis', '123', 'danaco', '125', 1, 1, NULL, '2023-01-30 21:22:39'),
(14, 'Sinapsis Lab', '900000000', 'sinapsislab.com', '7101010', 6, 1, NULL, '2023-05-12 15:29:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_contact`
--

DROP TABLE IF EXISTS `company_contact`;
CREATE TABLE IF NOT EXISTS `company_contact` (
  `Comp_contac_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Comp_id` int UNSIGNED NOT NULL,
  `Contact_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`Comp_contac_id`),
  KEY `company_contact_company` (`Comp_id`),
  KEY `company_contact_contact` (`Contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `Contact_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Contact_name` varchar(100) NOT NULL,
  `Contact_charge` varchar(50) NOT NULL,
  `Contact_phone` varchar(10) NOT NULL,
  `Contact_email` varchar(100) NOT NULL,
  PRIMARY KEY (`Contact_id`),
  UNIQUE KEY `Contact_email` (`Contact_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `Country_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Country_name` varchar(100) NOT NULL,
  PRIMARY KEY (`Country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `country`
--

INSERT INTO `country` (`Country_id`, `Country_name`) VALUES
(1, 'Colombia'),
(2, 'Venezuela'),
(3, 'peru');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctype`
--

DROP TABLE IF EXISTS `doctype`;
CREATE TABLE IF NOT EXISTS `doctype` (
  `DocType_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `DocType_name` varchar(100) NOT NULL,
  `DocType_code` varchar(10) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`DocType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

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
  `Filing_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Filing_name` varchar(100) NOT NULL,
  `Filing_description` varchar(200) NOT NULL,
  PRIMARY KEY (`Filing_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `filing`
--

INSERT INTO `filing` (`Filing_id`, `Filing_name`, `Filing_description`) VALUES
(1, 'Virtual ', 'Virtual ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manager`
--

DROP TABLE IF EXISTS `manager`;
CREATE TABLE IF NOT EXISTS `manager` (
  `Manager_id` int NOT NULL AUTO_INCREMENT,
  `Manager_name` varchar(100) NOT NULL,
  `Manager_email` varchar(100) NOT NULL,
  `Manager_phone` varchar(10) NOT NULL,
  `Brand_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`Manager_id`),
  KEY `manager_brand` (`Brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `manager`
--

INSERT INTO `manager` (`Manager_id`, `Manager_name`, `Manager_email`, `Manager_phone`, `Brand_id`) VALUES
(2, 'Juan', 'juanP@gmail.com', '123', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

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
  `Mod_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Mod_name` varchar(50) NOT NULL,
  `Mod_route` varchar(30) NOT NULL,
  `Mod_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Mod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `module`
--

INSERT INTO `module` (`Mod_id`, `Mod_name`, `Mod_route`, `Mod_description`, `updated_at`, `created_at`) VALUES
(1, 'HOME', 'home/home', 'Is Home', NULL, '2023-01-30 21:42:37'),
(2, 'USER', 'user/user', 'USER', NULL, '2023-01-30 22:28:31'),
(5, 'inventario', '5', 'a', NULL, '2023-03-21 10:19:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permit`
--

DROP TABLE IF EXISTS `permit`;
CREATE TABLE IF NOT EXISTS `permit` (
  `Perm_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Perm_name` varchar(50) NOT NULL,
  `Perm_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Perm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

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
  `Prod_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Prod_name` varchar(100) NOT NULL,
  `Prod_description` varchar(200) NOT NULL,
  `Prod_value` double NOT NULL,
  `TypePro_id` int UNSIGNED NOT NULL,
  `Brand_id` int UNSIGNED NOT NULL,
  `Unit_id` int UNSIGNED NOT NULL,
  `Filing_id` int UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Prod_id`),
  KEY `product_typeProduct` (`TypePro_id`),
  KEY `product_uni` (`Unit_id`),
  KEY `product_filing` (`Filing_id`),
  KEY `Brand_id` (`Brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`Prod_id`, `Prod_name`, `Prod_description`, `Prod_value`, `TypePro_id`, `Brand_id`, `Unit_id`, `Filing_id`, `updated_at`, `created_at`) VALUES
(3, 'pagina', 'web', 20, 1, 7, 1, 1, NULL, '2023-03-28 12:40:55'),
(4, 'podcats', 'podcats grabación de audio y video', 0, 1, 7, 1, 1, NULL, '2023-04-19 16:13:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_type`
--

DROP TABLE IF EXISTS `product_type`;
CREATE TABLE IF NOT EXISTS `product_type` (
  `TypePro_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `TypePro_name` varchar(100) NOT NULL,
  `TypePro_description` varchar(200) NOT NULL,
  PRIMARY KEY (`TypePro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `Profile_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Profile_lastName` varchar(100) NOT NULL,
  `Profile_surName` varchar(100) NOT NULL,
  `Profile_img` varchar(150) NOT NULL,
  `Profile_cellphone` varchar(10) NOT NULL,
  `Profile_identification` varchar(10) NOT NULL,
  `Profile_email` varchar(255) NOT NULL,
  `DocType_id` int UNSIGNED NOT NULL,
  `User_id` int UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Profile_id`),
  KEY `profile_user` (`User_id`),
  KEY `profile_doctype` (`DocType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `Project_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Project_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Project_name` varchar(100) NOT NULL,
  `Manager_id` int NOT NULL,
  `Brand_id` int UNSIGNED NOT NULL,
  `Project_purchaseOrder` varchar(10) NOT NULL,
  `Project_ddtStartDate` datetime DEFAULT NULL,
  `Project_ddtEndDate` datetime DEFAULT NULL,
  `Project_startDate` datetime DEFAULT NULL,
  `Project_estimatedEndDate` datetime DEFAULT NULL,
  `Project_activitiEndDate` date NOT NULL,
  `Project_observation` varchar(300) NOT NULL,
  `Project_link` varchar(150) NOT NULL,
  `Project_percentage` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Client_id` int UNSIGNED NOT NULL,
  `Country_id` int UNSIGNED NOT NULL,
  `User_id` int UNSIGNED NOT NULL,
  `Stat_id` int UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Project_id`),
  KEY `project_stati` (`Stat_id`),
  KEY `project_user` (`User_id`),
  KEY `project_client` (`Client_id`),
  KEY `project_contry` (`Country_id`),
  KEY `project_brand` (`Brand_id`),
  KEY `project_manager` (`Manager_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `project`
--

INSERT INTO `project` (`Project_id`, `Project_code`, `Project_name`, `Manager_id`, `Brand_id`, `Project_purchaseOrder`, `Project_ddtStartDate`, `Project_ddtEndDate`, `Project_startDate`, `Project_estimatedEndDate`, `Project_activitiEndDate`, `Project_observation`, `Project_link`, `Project_percentage`, `Client_id`, `Country_id`, `User_id`, `Stat_id`, `updated_at`, `created_at`) VALUES
(3, 'PRO_003', 'inventario', 2, 7, '125', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 'infromación', 'git', NULL, 2, 1, 218, 1, '2023-05-17 14:39:30', '2023-04-28 12:31:43'),
(4, 'PRO_004', 'inventario', 2, 7, '125', '2023-05-08 00:00:00', '2023-05-08 00:00:00', '2023-05-09 00:00:00', '2023-05-16 00:00:00', '2023-05-09', 'descripción', '0', '', 3, 1, 218, 1, '0000-00-00 00:00:00', '2023-05-08 13:05:35'),
(5, 'PRO_005', 'desarrollo web sinapsis', 2, 7, '125', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2023-05-15', 'descripción', '0', NULL, 3, 1, 216, 1, '2023-05-15 19:11:22', '2023-05-15 14:09:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_product`
--

DROP TABLE IF EXISTS `project_product`;
CREATE TABLE IF NOT EXISTS `project_product` (
  `Project_product_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Project_productAmount` varchar(10) NOT NULL,
  `Project_id` int UNSIGNED NOT NULL,
  `Prod_id` int UNSIGNED NOT NULL,
  `Projet_product_percentage` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Stat_id` int UNSIGNED NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Project_product_id`),
  KEY `project_product_stat` (`Stat_id`),
  KEY `project_product_prod` (`Prod_id`),
  KEY `project_product_project` (`Project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `project_product`
--

INSERT INTO `project_product` (`Project_product_id`, `Project_productAmount`, `Project_id`, `Prod_id`, `Projet_product_percentage`, `Stat_id`, `updated_at`, `created_at`) VALUES
(1, '11', 3, 3, '', 13, '2023-05-10 23:17:27', '2023-04-28 19:20:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_tracking`
--

DROP TABLE IF EXISTS `project_tracking`;
CREATE TABLE IF NOT EXISTS `project_tracking` (
  `ProjectTrack_id` int NOT NULL AUTO_INCREMENT,
  `ProjectTrack_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ProjectTrack_description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ProjectTrack_date` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`ProjectTrack_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `Role_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Role_name` varchar(50) NOT NULL,
  `Role_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`Role_id`, `Role_name`, `Role_description`, `updated_at`, `created_at`) VALUES
(1, 'Administrator', 'Administrator', NULL, '2023-01-30 21:50:45'),
(2, 'Cliente', 'Cliente', NULL, '2023-02-27 21:37:10'),
(7, 'Developer', '', NULL, '2023-03-21 10:20:16'),
(8, 'Administrator', '', NULL, '2023-04-19 16:06:49'),
(9, 'Comercial', '', NULL, '2023-04-26 10:58:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_module`
--

DROP TABLE IF EXISTS `role_module`;
CREATE TABLE IF NOT EXISTS `role_module` (
  `Role_mod_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Role_id` int UNSIGNED NOT NULL,
  `Mod_id` int UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Role_mod_id`),
  KEY `role_module` (`Mod_id`),
  KEY `role_module_role` (`Role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `role_module`
--

INSERT INTO `role_module` (`Role_mod_id`, `Role_id`, `Mod_id`, `created_at`) VALUES
(3, 2, 2, '2023-03-17 12:35:11'),
(4, 2, 1, '2023-03-17 12:35:11'),
(57, 1, 2, '2023-03-21 01:36:09'),
(61, 7, 5, '2023-03-21 10:20:24'),
(62, 8, 1, '2023-04-19 16:06:49'),
(63, 8, 5, '2023-04-19 16:06:49'),
(64, 9, 1, '2023-04-26 10:58:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_module_permit`
--

DROP TABLE IF EXISTS `role_module_permit`;
CREATE TABLE IF NOT EXISTS `role_module_permit` (
  `Role_mod_per_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Perm_id` int UNSIGNED NOT NULL,
  `Role_mod_id` int UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Role_mod_per_id`),
  KEY `Role_mod_id` (`Role_mod_id`),
  KEY `Perm_id` (`Perm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `role_module_permit`
--

INSERT INTO `role_module_permit` (`Role_mod_per_id`, `Perm_id`, `Role_mod_id`, `updated_at`, `created_at`) VALUES
(7, 2, 3, NULL, '2023-03-17 12:35:11'),
(8, 3, 3, NULL, '2023-03-17 12:35:11'),
(9, 2, 4, NULL, '2023-03-17 12:35:11'),
(10, 3, 4, NULL, '2023-03-17 12:35:11'),
(131, 1, 57, NULL, '2023-03-21 01:36:09'),
(132, 2, 57, NULL, '2023-03-21 01:36:09'),
(133, 3, 57, NULL, '2023-03-21 01:36:09'),
(134, 4, 57, NULL, '2023-03-21 01:36:09'),
(143, 2, 61, NULL, '2023-03-21 10:20:24'),
(144, 4, 61, NULL, '2023-03-21 10:20:24'),
(145, 3, 61, NULL, '2023-03-21 10:20:24'),
(146, 1, 62, NULL, '2023-04-19 16:06:49'),
(147, 2, 62, NULL, '2023-04-19 16:06:49'),
(148, 3, 63, NULL, '2023-04-19 16:06:49'),
(149, 4, 63, NULL, '2023-04-19 16:06:49'),
(150, 1, 64, NULL, '2023-04-26 10:58:37'),
(151, 2, 64, NULL, '2023-04-26 10:58:37'),
(152, 3, 64, NULL, '2023-04-26 10:58:37'),
(153, 4, 64, NULL, '2023-04-26 10:58:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `Stat_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Stat_name` varchar(100) NOT NULL,
  `Stat_description` varchar(200) NOT NULL,
  `StatType_id` int UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Stat_id`),
  KEY `status_StatusType` (`StatType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`Stat_id`, `Stat_name`, `Stat_description`, `StatType_id`, `updated_at`, `created_at`) VALUES
(1, 'Active', 'Status Active', 1, NULL, '2023-01-27 22:03:01'),
(2, 'Active', 'Status Active Company', 2, NULL, '2023-01-30 21:20:54'),
(3, 'Active', 'Status Active Client', 3, NULL, '2023-02-20 02:22:26'),
(4, 'Inactivo', '', 1, NULL, '2023-03-13 10:57:20'),
(5, 'demo', '', 2, NULL, '2023-03-13 14:50:35'),
(7, 'demo', '', 3, NULL, '2023-03-13 14:51:11'),
(10, 'demo', '', 2, NULL, '2023-03-13 16:36:41'),
(12, 'Pendiente', 'Activo de proyecto', 4, NULL, '2023-03-28 13:10:52'),
(13, 'Realizado', '', 4, NULL, '2023-04-18 01:15:33'),
(14, 'Sin asignar', '', 4, NULL, '2023-04-18 01:16:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `statustype`
--

DROP TABLE IF EXISTS `statustype`;
CREATE TABLE IF NOT EXISTS `statustype` (
  `StatType_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `StatType_name` varchar(100) NOT NULL,
  `StatType_description` varchar(200) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`StatType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `statustype`
--

INSERT INTO `statustype` (`StatType_id`, `StatType_name`, `StatType_description`, `updated_at`, `created_at`) VALUES
(1, 'User', 'Status User', NULL, '2023-01-27 22:02:15'),
(2, 'Company', 'Status Company', NULL, '2023-01-30 21:20:19'),
(3, 'Client', 'Status Client', NULL, '2023-02-20 02:21:22'),
(4, 'Proyect', 'Status Project', NULL, '2023-03-28 13:10:18'),
(5, 'Activities', 'Status Activities', NULL, '2023-04-05 09:30:25'),
(6, 'Productos', 'Estado de productos', NULL, '2023-04-10 16:31:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subactivities`
--

DROP TABLE IF EXISTS `subactivities`;
CREATE TABLE IF NOT EXISTS `subactivities` (
  `SubAct_id` int NOT NULL AUTO_INCREMENT,
  `SubAct_name` varchar(100) NOT NULL,
  `User_id` int UNSIGNED NOT NULL,
  `SubAct_estimatedEndDate` date NOT NULL,
  `Stat_id` int UNSIGNED NOT NULL,
  `Activi_id` int UNSIGNED NOT NULL,
  `SubAct_description` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `SubAct_percentage` varchar(15) NOT NULL,
  PRIMARY KEY (`SubAct_id`),
  KEY `User_id` (`User_id`),
  KEY `Stat_id` (`Stat_id`),
  KEY `Activi_id` (`Activi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unit`
--

DROP TABLE IF EXISTS `unit`;
CREATE TABLE IF NOT EXISTS `unit` (
  `Unit_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Unit_name` varchar(100) NOT NULL,
  `Unit_symbol` varchar(5) NOT NULL,
  PRIMARY KEY (`Unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `User_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `User_email` varchar(100) NOT NULL,
  `User_password` varchar(255) NOT NULL,
  `Comp_id` int UNSIGNED NOT NULL,
  `Stat_id` int UNSIGNED NOT NULL,
  `Role_id` int UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`User_id`),
  UNIQUE KEY `User_email` (`User_email`),
  KEY `user_status` (`Stat_id`),
  KEY `user_company` (`Comp_id`),
  KEY `Role_id` (`Role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`User_id`, `User_email`, `User_password`, `Comp_id`, `Stat_id`, `Role_id`, `updated_at`, `created_at`) VALUES
(1, 'dannacontreras53@gmail.com', '$2y$10$Yd4kbZuUh3i2XwORKvx/7eUkF9tcIYCHLVH9F6Gp2IwQ3TOxj5zym', 1, 4, 7, '2023-03-13 15:58:06', '2023-01-30 22:10:44'),
(212, 'diehercasvan@gmail.com', '$2y$10$KnJWFxVif2qpEOfZVYPYledtmu7wAI6gkgiwCoRKHsS3jiEhOqA3m', 1, 1, 2, NULL, '2023-02-25 22:25:58'),
(216, 'diehercas@gmail.com', '$2y$10$x1tS3Vn65bSGt4V3F36d/u92/dYbU5ZPm.9Knc0vEzDbuUmd.D/8q', 1, 1, 7, '2023-04-10 21:36:08', '2023-02-27 14:28:28'),
(217, 'pequitas@gmail.com', '$2y$10$909LAeXkPJhBWpvvvW5pPupoU/bgS9qU5Rtn/bvL5yvGPgggh.HWG', 1, 1, 1, '2023-02-28 03:09:52', '2023-02-27 14:51:10'),
(218, 'd.sinapsis@sinapsis.com.co', '$2y$10$RQpl4H4/GCcNI0GZUCr8iuDww4bFeEdAtzTYdR/C3s7GklFXh6y1e', 1, 1, 1, NULL, '2023-02-27 21:15:21'),
(219, 'diegoaaa@gmail.com', '$2y$10$xeIcp/EPluOsmU.m7B1sde.Hcg9tGI2FWuYSWfskuRr95oaxiKGwm', 1, 1, 1, '0000-00-00 00:00:00', '2023-03-07 14:49:03'),
(220, 'sinapsis@gmail.com', '$2y$10$ediAxyuSP0zWSVXS998XluZ3sAQaBUlzeCo5RfMAq.Rnni1Bhmd2q', 1, 1, 1, '0000-00-00 00:00:00', '2023-03-07 15:10:02'),
(221, 'sinapsittt@gmail.com', '$2y$10$LfH.q4DpMbBJi7N3m4H/Te5sd6yfkVC6rv5qo3aYKJjDQ4W6fCRvG', 1, 1, 2, '0000-00-00 00:00:00', '2023-03-07 15:10:46'),
(222, 'andresp@gmail.com', '$2y$10$uXvXZC3To03Dq0Rw3SsaT.spcokgO6ORf1.FJfLSDvV0VcVMXsEiK', 1, 1, 9, '0000-00-00 00:00:00', '2023-04-26 11:29:59');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_project_product` FOREIGN KEY (`Project_product_id`) REFERENCES `project_product` (`Project_product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `activities_status` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`),
  ADD CONSTRAINT `activities_user_assigned` FOREIGN KEY (`User_assigned`) REFERENCES `user` (`User_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `client_country` FOREIGN KEY (`Country_id`) REFERENCES `country` (`Country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
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
-- Filtros para la tabla `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manager_brand` FOREIGN KEY (`Brand_id`) REFERENCES `brand` (`Brand_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_filing` FOREIGN KEY (`Filing_id`) REFERENCES `filing` (`Filing_id`),
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Brand_id`) REFERENCES `brand` (`Brand_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
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
  ADD CONSTRAINT `project_brand` FOREIGN KEY (`Brand_id`) REFERENCES `brand` (`Brand_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `project_client` FOREIGN KEY (`Client_id`) REFERENCES `client` (`Client_id`),
  ADD CONSTRAINT `project_country` FOREIGN KEY (`Country_id`) REFERENCES `country` (`Country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `project_manager` FOREIGN KEY (`Manager_id`) REFERENCES `manager` (`Manager_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `project_stati` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`),
  ADD CONSTRAINT `project_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`);

--
-- Filtros para la tabla `project_product`
--
ALTER TABLE `project_product`
  ADD CONSTRAINT `project_product_prod` FOREIGN KEY (`Prod_id`) REFERENCES `product` (`Prod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `project_product_project` FOREIGN KEY (`Project_id`) REFERENCES `project` (`Project_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `project_product_stat` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `role_module`
--
ALTER TABLE `role_module`
  ADD CONSTRAINT `role_module_role` FOREIGN KEY (`Role_id`) REFERENCES `role` (`Role_id`);

--
-- Filtros para la tabla `role_module_permit`
--
ALTER TABLE `role_module_permit`
  ADD CONSTRAINT `role_module_permit_ibfk_1` FOREIGN KEY (`Role_mod_id`) REFERENCES `role_module` (`Role_mod_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Filtros para la tabla `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_StatusType` FOREIGN KEY (`StatType_id`) REFERENCES `statustype` (`StatType_id`);

--
-- Filtros para la tabla `subactivities`
--
ALTER TABLE `subactivities`
  ADD CONSTRAINT `subactivities_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `subactivities_ibfk_2` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `subactivities_ibfk_3` FOREIGN KEY (`Activi_id`) REFERENCES `activities` (`Activi_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_company` FOREIGN KEY (`Comp_id`) REFERENCES `company` (`Comp_id`),
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`Role_id`) REFERENCES `role` (`Role_id`),
  ADD CONSTRAINT `user_status` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`);
COMMIT;
