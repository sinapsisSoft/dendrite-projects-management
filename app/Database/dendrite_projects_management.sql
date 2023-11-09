-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-06-2023 a las 21:39:13
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `dendrite_projects_management`
--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activities`
--

DROP TABLE IF EXISTS `activities`;
CREATE TABLE IF NOT EXISTS `activities` (
  `Activi_id` int(11) NOT NULL AUTO_INCREMENT,
  `Activi_name` varchar(100) NOT NULL,
  `Activi_code` varchar(15) NOT NULL,
  `Activi_observation` varchar(200) NOT NULL,
  `Activi_startDate` date DEFAULT NULL,
  `Activi_endDate` date NOT NULL,
  `Activi_link` varchar(200) NOT NULL,
  `Activi_codeMiigo` varchar(30) DEFAULT NULL,
  `Activi_codeSpectra` varchar(30) DEFAULT NULL,
  `Activi_codeDelivery` varchar(100) NOT NULL,
  `Activi_percentage` varchar(15) NOT NULL,
  `Stat_id` int(11) NOT NULL,
  `Project_product_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Activi_id`),
  KEY `activities_status` (`Stat_id`),
  KEY `activities_project_product` (`Project_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE IF NOT EXISTS `brand` (
  `Brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `Brand_name` varchar(100) NOT NULL UNIQUE,
  `Brand_description` varchar(100) NOT NULL,
  `Client_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Brand_id`),
  KEY `brand_client` (`Client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `City_id` int(11) NOT NULL AUTO_INCREMENT,
  `City_name` varchar(50) NOT NULL,
  `Country_id` int(11) NOT NULL,
  PRIMARY KEY (`City_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `Client_id` int(11) NOT NULL AUTO_INCREMENT,
  `Client_name` varchar(100) NOT NULL,
  `Client_identification` varchar(20) NOT NULL,
  `Client_email` varchar(100) NOT NULL,
  `Client_phone` varchar(10) NOT NULL,
  `Client_address` varchar(100) NOT NULL,
  `DocType_id` int(11) NOT NULL,
  `Comp_id` int(11) NOT NULL,
  `Stat_id` int(11) NOT NULL,
  `Country_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Client_id`),
  UNIQUE KEY `Client_identification` (`Client_identification`),
  UNIQUE KEY `Client_email` (`Client_email`),
  KEY `client_company` (`Comp_id`),
  KEY `client_docType` (`DocType_id`),
  KEY `client_state` (`Stat_id`),
  KEY `client_contry` (`Country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_contact`
--

DROP TABLE IF EXISTS `client_contact`;
CREATE TABLE IF NOT EXISTS `client_contact` (
  `Client_contact_id` int(11) NOT NULL,
  `Contact_id` int(11) NOT NULL,
  `Client_id` int(11) NOT NULL,
  PRIMARY KEY (`Client_contact_id`),
  KEY `client_contact_client` (`Client_id`),
  KEY `client_contact_contact` (`Contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `Comp_id` int(11) NOT NULL AUTO_INCREMENT,
  `Comp_name` varchar(100) NOT NULL,
  `Comp_identification` varchar(20) NOT NULL,
  `Comp_email` varchar(100) NOT NULL,
  `Comp_phone` varchar(10) NOT NULL,
  `DocType_id` int(11) NOT NULL,
  `Stat_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Comp_id`),
  UNIQUE KEY `Comp_identification` (`Comp_identification`),
  UNIQUE KEY `Comp_email` (`Comp_email`),
  KEY `company_status` (`Stat_id`),
  KEY `company_doctType` (`DocType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`Comp_id`, `Comp_name`, `Comp_identification`, `Comp_email`, `Comp_phone`, `DocType_id`, `Stat_id`, `updated_at`, `created_at`) VALUES
(1, 'Market Support', '123', 'danaco', '125', 1, 1, NULL, '2023-01-30 21:22:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_contact`
--

DROP TABLE IF EXISTS `company_contact`;
CREATE TABLE IF NOT EXISTS `company_contact` (
  `Comp_contac_id` int(11) NOT NULL AUTO_INCREMENT,
  `Comp_id` int(11) NOT NULL,
  `Contact_id` int(11) NOT NULL,
  PRIMARY KEY (`Comp_contac_id`),
  KEY `company_contact_company` (`Comp_id`),
  KEY `company_contact_contact` (`Contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `Contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `Contact_name` varchar(100) NOT NULL,
  `Contact_charge` varchar(50) NOT NULL,
  `Contact_phone` varchar(10) NOT NULL,
  `Contact_email` varchar(100) NOT NULL,
  PRIMARY KEY (`Contact_id`),
  UNIQUE KEY `Contact_email` (`Contact_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `Country_id` int(11) NOT NULL AUTO_INCREMENT,
  `Country_name` varchar(100) NOT NULL UNIQUE,
  PRIMARY KEY (`Country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `DocType_id` int(11) NOT NULL AUTO_INCREMENT,
  `DocType_name` varchar(100) NOT NULL UNIQUE,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`DocType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `doctype`
--

INSERT INTO `doctype` (`DocType_id`, `DocType_name`, `updated_at`, `created_at`) VALUES
(1, 'NIT', NULL, '2023-01-30 21:14:01'),
(2, 'Cédula de ciudadanía', NULL, '2023-01-30 21:17:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email`
--

DROP TABLE IF EXISTS `email`;
CREATE TABLE IF NOT EXISTS `email` (
  `Email_id` int(11) NOT NULL AUTO_INCREMENT,
  `Email_user` varchar(100) NOT NULL,
  `Email_pass` varchar(150) NOT NULL,
  `Email_host` varchar(150) NOT NULL,
  `Email_puerto` varchar(150) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`Email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `email`
--

INSERT INTO `email` (`Email_id`, `Email_user`, `Email_pass`, `Email_host`, `Email_puerto`, `updated_at`) VALUES
(1, 'no-responder@dendrite.com.co', 'Sinapsis2020*', 'smtp.hostinger.co', '587', '2023-06-04 23:58:38');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mail`
--

DROP TABLE IF EXISTS `mail`;
CREATE TABLE IF NOT EXISTS `mail` (
  `Mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `Mail_user` varchar(150) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`Mail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mail`
--

INSERT INTO `mail` (`Mail_id`, `Mail_user`, `updated_at`) VALUES
(1, 'developer.sinapsist@gmail.com', '2023-06-04 23:51:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manager`
--

DROP TABLE IF EXISTS `manager`;
CREATE TABLE IF NOT EXISTS `manager` (
  `Manager_id` int(11) NOT NULL AUTO_INCREMENT,
  `Manager_name` varchar(100) NOT NULL UNIQUE,
  `Manager_email` varchar(100) NOT NULL UNIQUE,
  `Manager_phone` varchar(10) NOT NULL,
  `Client_id` int(11) NOT NULL,
  PRIMARY KEY (`Manager_id`),
  KEY `manager_client` (`Client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manager_brands`
--

DROP TABLE IF EXISTS `manager_brands`;
CREATE TABLE IF NOT EXISTS `manager_brands` (
  `Manager_brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `Manager_id` int(11) NOT NULL,
  `Brand_id` int(11) NOT NULL,
  PRIMARY KEY (`Manager_brand_id`),
  KEY `manager_brands_brand` (`Brand_id`),
  KEY `manager_brands_manager` (`Manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

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
  `Mod_id` int(11) NOT NULL AUTO_INCREMENT,
  `Mod_name` varchar(50) NOT NULL,
  `Mod_route` varchar(30) NOT NULL,
  `Mod_description` varchar(100) NOT NULL,
  `Mod_icon` varchar(300) DEFAULT NULL,
  `Mod_parent` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Mod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `module`
--

INSERT INTO `module` (`Mod_id`, `Mod_name`, `Mod_route`, `Mod_description`, `Mod_icon`, `Mod_parent`, `updated_at`, `created_at`) VALUES
(1, 'Inicio', 'home', 'Página de inicio', 'assets/json/system-outline-41-home.json', NULL, NULL, '2023-01-30 21:42:37'),
(2, 'Gestión de proyectos', '', 'Módulo de gestión de proyectos', 'assets/json/system-outline-44-folder.json', NULL, NULL, '2023-01-30 22:28:31'),
(3, 'Proyectos', 'project', 'Gestión de proyectos', NULL, 2, NULL, '2023-07-27 11:20:27'),
(4, 'Solicitudes de proyectos', 'projectrequest', 'Listado de solicitudes de proyectos', NULL, 2, NULL, '2023-07-27 11:22:07'),
(5, 'Crear solicitud de proyecto', 'projectuser', 'Creación de solicitudes de proyecto', NULL, 2, NULL, '2023-07-27 11:22:07'),
(6, 'Productos / Servicios', '', 'Gestión de productos y servicios', 'assets/json/system-outline-64-shopping-bag.json', NULL, NULL, '2023-07-27 11:24:44'),
(7, 'Productos', 'product', 'Gestión de productos', NULL, 6, NULL, '2023-07-27 11:24:44'),
(8, 'Marca', 'productbrand', 'Gestión de marca de productos', NULL, 6, NULL, '2023-07-27 11:24:44'),
(9, 'Presentación', 'filing', 'Gestión de presentaciones de los productos', NULL, 6, NULL, '2023-07-27 11:24:44'),
(10, 'Gestión de clientes', 'client', 'Gestión de clientes', 'assets/json/system-outline-2-accessibility.json', NULL, NULL, '2023-07-27 11:26:13'),
(11, 'Reportes', 'report', 'Visualización de reportes', 'assets/json/system-outline-43-pie-chart-diagram.json', NULL, NULL, '2023-07-27 11:26:13'),
(12, 'Gestión de usuarios', '', 'Gestión de usuarios del sistema', 'assets/json/system-outline-8-account.json', NULL, NULL, '2023-07-27 11:29:14'),
(13, 'Usuarios', 'user', 'Gestión de usuarios', NULL, 12, NULL, '2023-07-27 11:29:14'),
(14, 'Módulos', 'module', 'Gestión de módulos', NULL, 12, NULL, '2023-07-27 11:29:14'),
(15, 'Roles', 'role', 'Gestión de roles y permisos', NULL, 12, NULL, '2023-07-27 11:29:14'),
(16, 'Estado', 'userstatus', 'Gestión de estado de usuarios', NULL, 12, NULL, '2023-07-27 11:29:14'),
(17, 'Configuración', '', 'Gestión de configuraciones básicas del sistema', 'assets/json/system-outline-63-settings-cog.json', NULL, NULL, '2023-07-27 11:33:51'),
(18, 'Tipo de documento', 'doctype', 'Gestión de tipos de documento', NULL, 17, NULL, '2023-07-27 11:33:51'),
(19, 'Correo para notificaciones', 'email', 'Gestión de credenciales para el correo de envío de notificaciones', NULL, 17, NULL, '2023-07-27 11:33:51'),
(20, 'Correo de correspondencia', 'mail', 'Gestión de correo para envío de notificaciones de cambio de estado', NULL, 17, NULL, '2023-07-27 11:33:51'),
(21, 'Prioridades', 'priorities', 'Gestión de prioridades para los proyectos', NULL, 17, NULL, '2023-07-27 11:33:51'),
(22, 'País', 'country', 'Gestión de países', NULL, 17, NULL, '2023-07-27 11:33:51'),
(23, 'Ciudad', 'city', 'Gestión de ciudades de los países', NULL, 17, NULL, '2023-07-27 11:33:51'),
(24, 'Seguimiento de subactividades', 'subactivitiesuser', 'Seguimiento de subactividades', NULL, 2, NULL, '2023-07-27 11:33:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permit`
--

DROP TABLE IF EXISTS `permit`;
CREATE TABLE IF NOT EXISTS `permit` (
  `Perm_id` int(11) NOT NULL AUTO_INCREMENT,
  `Perm_name` varchar(50) NOT NULL,
  `Perm_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Perm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
-- Estructura de tabla para la tabla `priorities`
--

DROP TABLE IF EXISTS `priorities`;
CREATE TABLE IF NOT EXISTS `priorities` (
  `Priorities_id` int(11) NOT NULL AUTO_INCREMENT,
  `Priorities_name` varchar(100) NOT NULL UNIQUE,
  `Priorities_color` varchar(20) NOT NULL,
  PRIMARY KEY (`Priorities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `Prod_code` varchar(30) NOT NULL,
  `Prod_id` int(11) NOT NULL AUTO_INCREMENT,
  `Prod_name` varchar(100) NOT NULL,
  `Prod_description` varchar(200) NOT NULL,
  `Prod_brand_id` int(11) NOT NULL,
  `Filing_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Prod_id`),
  KEY `product_filing` (`Filing_id`),
  KEY `product_brand` (`Prod_brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_brand`
--

DROP TABLE IF EXISTS `product_brand`;
CREATE TABLE IF NOT EXISTS `product_brand` (
  `Prod_brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `Prod_brand_name` varchar(100) NOT NULL,
  `Prod_brand_description` varchar(150) NOT NULL,
  PRIMARY KEY (`Prod_brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `Profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `Profile_lastName` varchar(100) NOT NULL,
  `Profile_surName` varchar(100) NOT NULL,
  `Profile_img` varchar(150) NOT NULL,
  `Profile_cellphone` varchar(10) NOT NULL,
  `Profile_identification` varchar(10) NOT NULL,
  `Profile_email` varchar(255) NOT NULL,
  `DocType_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Profile_id`),
  KEY `profile_user` (`User_id`),
  KEY `profile_doctype` (`DocType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project`
--
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `Project_id` int(11) NOT NULL AUTO_INCREMENT,
  `Project_code` varchar(10) DEFAULT NULL,
  `Project_name` varchar(100) NOT NULL,
  `Manager_id` int(11) NOT NULL,
  `Brand_id` int(11) NOT NULL,
  `Project_purchaseOrder` varchar(10) NOT NULL,
  `Project_ddtStartDate` date DEFAULT NULL,
  `Project_ddtEndDate` date DEFAULT NULL,
  `Project_startDate` date DEFAULT NULL,
  `Project_estimatedEndDate` date DEFAULT NULL,
  `Project_activitiEndDate` date NOT NULL,
  `Project_observation` varchar(300) NOT NULL,
  `Project_percentage` varchar(15) DEFAULT NULL,
  `Project_url` varchar(2100) DEFAULT NULL,
  `Client_id` int(11) NOT NULL,
  `User_id` int(11) DEFAULT NULL,
  `Project_commercial` int(11) DEFAULT NULL,
  `Stat_id` int(11) NOT NULL,
  `Priorities_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Project_id`),
  KEY `project_stati` (`Stat_id`),
  KEY `project_user` (`User_id`),
  KEY `project_client` (`Client_id`),
  KEY `project_brand` (`Brand_id`),
  KEY `project_manager` (`Manager_id`),
  KEY `project_commercial` (`Project_commercial`),  
  KEY `Priorities_id` (`Priorities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_product`
--

DROP TABLE IF EXISTS `project_product`;
CREATE TABLE IF NOT EXISTS `project_product` (
  `Project_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `Project_productAmount` varchar(10) NOT NULL,
  `Project_id` int(11) NOT NULL,
  `Prod_id` int(11) NOT NULL,
  `Project_product_percentage` varchar(15) DEFAULT NULL,
  `Stat_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Project_product_id`),
  KEY `project_product_prod` (`Prod_id`),
  KEY `project_product_project` (`Project_id`),
  KEY `project_product_status` (`Stat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `project_request`
--

DROP TABLE IF EXISTS `project_request`;
CREATE TABLE IF NOT EXISTS `project_request` (
  `ProjReq_id` int(11) NOT NULL AUTO_INCREMENT,
  `User_id` int(11) NOT NULL,
  `ProjReq_name` varchar(100) NOT NULL,
  `Brand_id` int(11) NOT NULL,
  `ProjReq_observation` varchar(300) DEFAULT NULL,
  `Stat_id` int(11) DEFAULT NULL,
  `Project_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ProjReq_id`),
  KEY `project_request_user` (`User_id`),
  KEY `project_request_brand` (`Brand_id`),
  KEY `project_request_project` (`Project_id`),
  KEY `project_request_status` (`Stat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `project_request_product`
--

DROP TABLE IF EXISTS `project_request_product`;
CREATE TABLE IF NOT EXISTS `project_request_product` (
  `ProjReq_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `ProjReq_id` int(11) NOT NULL,
  `Prod_id` int(11) NOT NULL,
  `ProjReq_product_amount` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ProjReq_product_id`),
  KEY `project_request_product_project_request` (`ProjReq_id`),
  KEY `project_request_product_product` (`Prod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_tracking`
--

DROP TABLE IF EXISTS `project_tracking`;
CREATE TABLE IF NOT EXISTS `project_tracking` (
  `ProjectTrack_id` int(11) NOT NULL AUTO_INCREMENT,
  `ProjectTrack_name` varchar(100) DEFAULT NULL,
  `ProjectTrack_description` varchar(200) DEFAULT NULL,
  `Project_id` int(11) DEFAULT NULL,
  `ProjectTrack_date` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`ProjectTrack_id`),
  KEY `project_tracking_project` (`Project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `Role_id` int(11) NOT NULL AUTO_INCREMENT,
  `Role_name` varchar(50) NOT NULL UNIQUE,
  `Role_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`Role_id`, `Role_name`, `Role_description`, `updated_at`, `created_at`) VALUES
(1, 'Administrador', 'Administrador', NULL, '2023-01-30 21:50:45'),
(2, 'Colaborador', 'Colaborador', NULL, '2023-02-27 21:37:10'),
(3, 'Comercial', '', NULL, '2023-03-21 10:20:16'),
(4, 'Gerente de marca', '', NULL, '2023-04-26 10:58:37'),
(5, 'Directivo', '', NULL, '2023-07-20 18:14:32'),
(6, 'Administrativo', '', NULL, '2023-08-15 13:59:53'),
(7, 'Tráfico', '', NULL, '2023-08-15 15:20:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_module`
--

DROP TABLE IF EXISTS `role_module`;
CREATE TABLE IF NOT EXISTS `role_module` (
  `Role_mod_id` int(11) NOT NULL AUTO_INCREMENT,
  `Role_id` int(11) NOT NULL,
  `Mod_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Role_mod_id`),
  KEY `role_module` (`Mod_id`),
  KEY `role_module_role` (`Role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `role_module`
--

INSERT INTO `role_module` (`Role_mod_id`, `Role_id`, `Mod_id`, `created_at`) VALUES
(1, 1, 1, '2023-08-16 19:39:13'),
(2, 1, 2, '2023-08-16 19:39:13'),
(3, 1, 3, '2023-08-16 19:39:13'),
(4, 1, 4, '2023-08-16 19:39:13'),
(5, 1, 5, '2023-08-16 19:39:13'),
(6, 1, 6, '2023-08-16 19:39:13'),
(7, 1, 7, '2023-08-16 19:39:13'),
(8, 1, 8, '2023-08-16 19:39:13'),
(9, 1, 9, '2023-08-16 19:39:13'),
(10, 1, 10, '2023-08-16 19:39:13'),
(11, 1, 11, '2023-08-16 19:39:13'),
(12, 1, 12, '2023-08-16 19:39:13'),
(13, 1, 13, '2023-08-16 19:39:13'),
(14, 1, 14, '2023-08-16 19:39:13'),
(15, 1, 15, '2023-08-16 19:39:13'),
(16, 1, 16, '2023-08-16 19:39:13'),
(17, 1, 17, '2023-08-16 19:39:13'),
(18, 1, 18, '2023-08-16 19:39:13'),
(19, 1, 19, '2023-08-16 19:39:13'),
(20, 1, 20, '2023-08-16 19:39:13'),
(21, 1, 21, '2023-08-16 19:39:13'),
(22, 1, 22, '2023-08-16 19:39:13'),
(23, 1, 23, '2023-08-16 19:39:13'),
(26, 2, 3, '2023-08-16 19:40:46'),
(27, 2, 1, '2023-08-16 19:40:46'),
(28, 2, 2, '2023-08-16 19:40:46'),
(29, 3, 1, '2023-08-16 19:42:08'),
(30, 3, 2, '2023-08-16 19:42:08'),
(31, 3, 3, '2023-08-16 19:42:08'),
(32, 3, 4, '2023-08-16 19:42:08'),
(33, 3, 6, '2023-08-16 19:42:08'),
(34, 3, 7, '2023-08-16 19:42:08'),
(35, 3, 8, '2023-08-16 19:42:08'),
(36, 3, 9, '2023-08-16 19:42:08'),
(37, 3, 10, '2023-08-16 19:42:08'),
(38, 3, 11, '2023-08-16 19:42:08'),
(39, 3, 12, '2023-08-16 19:42:08'),
(40, 3, 13, '2023-08-16 19:42:08'),
(41, 3, 17, '2023-08-16 19:42:08'),
(42, 3, 18, '2023-08-16 19:42:08'),
(43, 3, 21, '2023-08-16 19:42:08'),
(44, 3, 22, '2023-08-16 19:42:08'),
(45, 3, 23, '2023-08-16 19:42:08'),
(46, 4, 1, '2023-08-16 19:47:53'),
(47, 4, 2, '2023-08-16 19:47:53'),
(48, 4, 5, '2023-08-16 19:47:53'),
(66, 6, 1, '2023-08-16 19:56:05'),
(67, 6, 2, '2023-08-16 19:56:05'),
(68, 6, 3, '2023-08-16 19:56:05'),
(69, 6, 4, '2023-08-16 19:56:05'),
(70, 6, 7, '2023-08-16 19:56:05'),
(71, 6, 6, '2023-08-16 19:56:05'),
(72, 6, 8, '2023-08-16 19:56:05'),
(73, 6, 9, '2023-08-16 19:56:05'),
(74, 6, 10, '2023-08-16 19:56:05'),
(75, 6, 11, '2023-08-16 19:56:05'),
(76, 6, 17, '2023-08-16 19:56:05'),
(77, 6, 18, '2023-08-16 19:56:05'),
(78, 6, 19, '2023-08-16 19:56:05'),
(79, 6, 20, '2023-08-16 19:56:05'),
(80, 6, 21, '2023-08-16 19:56:05'),
(81, 6, 22, '2023-08-16 19:56:05'),
(82, 6, 23, '2023-08-16 19:56:05'),
(83, 5, 2, '2023-08-16 19:56:27'),
(84, 5, 3, '2023-08-16 19:56:27'),
(85, 5, 4, '2023-08-16 19:56:27'),
(86, 5, 6, '2023-08-16 19:56:27'),
(87, 5, 7, '2023-08-16 19:56:27'),
(88, 5, 8, '2023-08-16 19:56:27'),
(89, 5, 9, '2023-08-16 19:56:27'),
(90, 5, 10, '2023-08-16 19:56:27'),
(91, 5, 11, '2023-08-16 19:56:27'),
(92, 5, 17, '2023-08-16 19:56:27'),
(93, 5, 18, '2023-08-16 19:56:27'),
(94, 5, 19, '2023-08-16 19:56:27'),
(95, 5, 20, '2023-08-16 19:56:27'),
(96, 5, 21, '2023-08-16 19:56:27'),
(97, 5, 22, '2023-08-16 19:56:27'),
(98, 5, 23, '2023-08-16 19:56:27'),
(99, 5, 1, '2023-08-16 19:56:27'),
(100, 7, 1, '2023-08-16 19:57:57'),
(101, 7, 2, '2023-08-16 19:57:57'),
(102, 7, 3, '2023-08-16 19:57:57'),
(103, 7, 4, '2023-08-16 19:57:57'),
(104, 7, 11, '2023-08-16 19:57:57'),
(105, 7, 12, '2023-08-16 19:57:57'),
(106, 7, 21, '2023-08-16 19:57:57'),
(107, 7, 22, '2023-08-16 19:57:57'),
(108, 7, 23, '2023-08-16 19:57:57'),
(109, 7, 18, '2023-08-16 19:57:57'),
(110, 7, 17, '2023-08-16 19:57:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_module_permit`
--

DROP TABLE IF EXISTS `role_module_permit`;
CREATE TABLE IF NOT EXISTS `role_module_permit` (
  `Role_mod_per_id` int(11) NOT NULL AUTO_INCREMENT,
  `Perm_id` int(11) NOT NULL,
  `Role_mod_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Role_mod_per_id`),
  KEY `Role_mod_id` (`Role_mod_id`),
  KEY `Perm_id` (`Perm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `role_module_permit`
--

INSERT INTO `role_module_permit` (`Role_mod_per_id`, `Perm_id`, `Role_mod_id`, `updated_at`, `created_at`) VALUES
(1, 2, 1, NULL, '2023-08-16 19:39:13'),
(2, 1, 2, NULL, '2023-08-16 19:39:13'),
(3, 2, 2, NULL, '2023-08-16 19:39:13'),
(4, 3, 2, NULL, '2023-08-16 19:39:13'),
(5, 4, 2, NULL, '2023-08-16 19:39:13'),
(6, 1, 3, NULL, '2023-08-16 19:39:13'),
(7, 2, 3, NULL, '2023-08-16 19:39:13'),
(8, 3, 3, NULL, '2023-08-16 19:39:13'),
(9, 4, 3, NULL, '2023-08-16 19:39:13'),
(10, 4, 4, NULL, '2023-08-16 19:39:13'),
(11, 3, 4, NULL, '2023-08-16 19:39:13'),
(12, 2, 4, NULL, '2023-08-16 19:39:13'),
(13, 1, 4, NULL, '2023-08-16 19:39:13'),
(14, 4, 5, NULL, '2023-08-16 19:39:13'),
(15, 2, 5, NULL, '2023-08-16 19:39:13'),
(16, 1, 5, NULL, '2023-08-16 19:39:13'),
(17, 3, 5, NULL, '2023-08-16 19:39:13'),
(18, 4, 6, NULL, '2023-08-16 19:39:13'),
(19, 3, 6, NULL, '2023-08-16 19:39:13'),
(20, 2, 6, NULL, '2023-08-16 19:39:13'),
(21, 1, 6, NULL, '2023-08-16 19:39:13'),
(22, 1, 7, NULL, '2023-08-16 19:39:13'),
(23, 2, 7, NULL, '2023-08-16 19:39:13'),
(24, 3, 7, NULL, '2023-08-16 19:39:13'),
(25, 4, 7, NULL, '2023-08-16 19:39:13'),
(26, 4, 8, NULL, '2023-08-16 19:39:13'),
(27, 3, 8, NULL, '2023-08-16 19:39:13'),
(28, 2, 8, NULL, '2023-08-16 19:39:13'),
(29, 1, 8, NULL, '2023-08-16 19:39:13'),
(30, 4, 9, NULL, '2023-08-16 19:39:13'),
(31, 3, 9, NULL, '2023-08-16 19:39:13'),
(32, 2, 9, NULL, '2023-08-16 19:39:13'),
(33, 1, 9, NULL, '2023-08-16 19:39:13'),
(34, 4, 10, NULL, '2023-08-16 19:39:13'),
(35, 3, 10, NULL, '2023-08-16 19:39:13'),
(36, 2, 10, NULL, '2023-08-16 19:39:13'),
(37, 1, 10, NULL, '2023-08-16 19:39:13'),
(38, 4, 11, NULL, '2023-08-16 19:39:13'),
(39, 3, 11, NULL, '2023-08-16 19:39:13'),
(40, 2, 11, NULL, '2023-08-16 19:39:13'),
(41, 1, 11, NULL, '2023-08-16 19:39:13'),
(42, 1, 12, NULL, '2023-08-16 19:39:13'),
(43, 2, 12, NULL, '2023-08-16 19:39:13'),
(44, 3, 12, NULL, '2023-08-16 19:39:13'),
(45, 4, 12, NULL, '2023-08-16 19:39:13'),
(46, 1, 13, NULL, '2023-08-16 19:39:13'),
(47, 2, 13, NULL, '2023-08-16 19:39:13'),
(48, 4, 13, NULL, '2023-08-16 19:39:13'),
(49, 3, 13, NULL, '2023-08-16 19:39:13'),
(50, 1, 14, NULL, '2023-08-16 19:39:13'),
(51, 2, 14, NULL, '2023-08-16 19:39:13'),
(52, 3, 14, NULL, '2023-08-16 19:39:13'),
(53, 4, 14, NULL, '2023-08-16 19:39:13'),
(54, 1, 15, NULL, '2023-08-16 19:39:13'),
(55, 2, 15, NULL, '2023-08-16 19:39:13'),
(56, 4, 15, NULL, '2023-08-16 19:39:13'),
(57, 3, 15, NULL, '2023-08-16 19:39:13'),
(58, 1, 16, NULL, '2023-08-16 19:39:13'),
(59, 2, 16, NULL, '2023-08-16 19:39:13'),
(60, 3, 16, NULL, '2023-08-16 19:39:13'),
(61, 4, 16, NULL, '2023-08-16 19:39:13'),
(62, 1, 17, NULL, '2023-08-16 19:39:13'),
(63, 2, 17, NULL, '2023-08-16 19:39:13'),
(64, 4, 17, NULL, '2023-08-16 19:39:13'),
(65, 3, 17, NULL, '2023-08-16 19:39:13'),
(66, 1, 18, NULL, '2023-08-16 19:39:13'),
(67, 2, 18, NULL, '2023-08-16 19:39:13'),
(68, 3, 18, NULL, '2023-08-16 19:39:13'),
(69, 4, 18, NULL, '2023-08-16 19:39:13'),
(70, 1, 19, NULL, '2023-08-16 19:39:13'),
(71, 2, 19, NULL, '2023-08-16 19:39:13'),
(72, 4, 19, NULL, '2023-08-16 19:39:13'),
(73, 3, 19, NULL, '2023-08-16 19:39:13'),
(74, 4, 20, NULL, '2023-08-16 19:39:13'),
(75, 3, 20, NULL, '2023-08-16 19:39:13'),
(76, 2, 20, NULL, '2023-08-16 19:39:13'),
(77, 1, 20, NULL, '2023-08-16 19:39:13'),
(78, 4, 21, NULL, '2023-08-16 19:39:13'),
(79, 3, 21, NULL, '2023-08-16 19:39:13'),
(80, 2, 21, NULL, '2023-08-16 19:39:13'),
(81, 1, 21, NULL, '2023-08-16 19:39:13'),
(82, 4, 22, NULL, '2023-08-16 19:39:13'),
(83, 3, 22, NULL, '2023-08-16 19:39:13'),
(84, 2, 22, NULL, '2023-08-16 19:39:13'),
(85, 1, 22, NULL, '2023-08-16 19:39:13'),
(86, 4, 23, NULL, '2023-08-16 19:39:13'),
(87, 3, 23, NULL, '2023-08-16 19:39:13'),
(88, 2, 23, NULL, '2023-08-16 19:39:13'),
(89, 1, 23, NULL, '2023-08-16 19:39:13'),
(94, 1, 26, NULL, '2023-08-16 19:40:46'),
(95, 2, 26, NULL, '2023-08-16 19:40:46'),
(96, 3, 26, NULL, '2023-08-16 19:40:46'),
(97, 2, 27, NULL, '2023-08-16 19:40:46'),
(98, 1, 28, NULL, '2023-08-16 19:40:46'),
(99, 2, 28, NULL, '2023-08-16 19:40:46'),
(100, 3, 28, NULL, '2023-08-16 19:40:46'),
(101, 4, 28, NULL, '2023-08-16 19:40:46'),
(102, 2, 29, NULL, '2023-08-16 19:42:08'),
(103, 1, 30, NULL, '2023-08-16 19:42:08'),
(104, 2, 30, NULL, '2023-08-16 19:42:08'),
(105, 3, 30, NULL, '2023-08-16 19:42:08'),
(106, 4, 30, NULL, '2023-08-16 19:42:08'),
(107, 1, 31, NULL, '2023-08-16 19:42:08'),
(108, 2, 31, NULL, '2023-08-16 19:42:08'),
(109, 3, 31, NULL, '2023-08-16 19:42:08'),
(110, 4, 31, NULL, '2023-08-16 19:42:08'),
(111, 1, 32, NULL, '2023-08-16 19:42:08'),
(112, 2, 32, NULL, '2023-08-16 19:42:08'),
(113, 3, 32, NULL, '2023-08-16 19:42:08'),
(114, 4, 32, NULL, '2023-08-16 19:42:08'),
(115, 1, 33, NULL, '2023-08-16 19:42:08'),
(116, 2, 33, NULL, '2023-08-16 19:42:08'),
(117, 3, 33, NULL, '2023-08-16 19:42:08'),
(118, 4, 33, NULL, '2023-08-16 19:42:08'),
(119, 1, 34, NULL, '2023-08-16 19:42:08'),
(120, 2, 34, NULL, '2023-08-16 19:42:08'),
(121, 3, 34, NULL, '2023-08-16 19:42:08'),
(122, 4, 34, NULL, '2023-08-16 19:42:08'),
(123, 1, 35, NULL, '2023-08-16 19:42:08'),
(124, 2, 35, NULL, '2023-08-16 19:42:08'),
(125, 3, 35, NULL, '2023-08-16 19:42:08'),
(126, 4, 35, NULL, '2023-08-16 19:42:08'),
(127, 1, 36, NULL, '2023-08-16 19:42:08'),
(128, 2, 36, NULL, '2023-08-16 19:42:08'),
(129, 3, 36, NULL, '2023-08-16 19:42:08'),
(130, 4, 36, NULL, '2023-08-16 19:42:08'),
(131, 1, 37, NULL, '2023-08-16 19:42:08'),
(132, 2, 37, NULL, '2023-08-16 19:42:08'),
(133, 3, 37, NULL, '2023-08-16 19:42:08'),
(134, 4, 37, NULL, '2023-08-16 19:42:08'),
(135, 1, 38, NULL, '2023-08-16 19:42:08'),
(136, 2, 38, NULL, '2023-08-16 19:42:08'),
(137, 3, 38, NULL, '2023-08-16 19:42:08'),
(138, 4, 38, NULL, '2023-08-16 19:42:08'),
(139, 1, 39, NULL, '2023-08-16 19:42:08'),
(140, 2, 39, NULL, '2023-08-16 19:42:08'),
(141, 3, 39, NULL, '2023-08-16 19:42:08'),
(142, 4, 39, NULL, '2023-08-16 19:42:08'),
(143, 1, 40, NULL, '2023-08-16 19:42:08'),
(144, 2, 40, NULL, '2023-08-16 19:42:08'),
(145, 3, 40, NULL, '2023-08-16 19:42:08'),
(146, 4, 40, NULL, '2023-08-16 19:42:08'),
(147, 1, 41, NULL, '2023-08-16 19:42:08'),
(148, 2, 41, NULL, '2023-08-16 19:42:08'),
(149, 3, 41, NULL, '2023-08-16 19:42:08'),
(150, 4, 41, NULL, '2023-08-16 19:42:08'),
(151, 1, 42, NULL, '2023-08-16 19:42:08'),
(152, 2, 42, NULL, '2023-08-16 19:42:08'),
(153, 3, 42, NULL, '2023-08-16 19:42:08'),
(154, 4, 42, NULL, '2023-08-16 19:42:08'),
(155, 1, 43, NULL, '2023-08-16 19:42:08'),
(156, 2, 43, NULL, '2023-08-16 19:42:08'),
(157, 3, 43, NULL, '2023-08-16 19:42:08'),
(158, 4, 43, NULL, '2023-08-16 19:42:08'),
(159, 1, 44, NULL, '2023-08-16 19:42:08'),
(160, 2, 44, NULL, '2023-08-16 19:42:08'),
(161, 3, 44, NULL, '2023-08-16 19:42:08'),
(162, 4, 44, NULL, '2023-08-16 19:42:08'),
(163, 1, 45, NULL, '2023-08-16 19:42:08'),
(164, 2, 45, NULL, '2023-08-16 19:42:08'),
(165, 3, 45, NULL, '2023-08-16 19:42:08'),
(166, 4, 45, NULL, '2023-08-16 19:42:08'),
(167, 2, 46, NULL, '2023-08-16 19:47:53'),
(168, 1, 47, NULL, '2023-08-16 19:47:53'),
(169, 2, 47, NULL, '2023-08-16 19:47:53'),
(170, 3, 47, NULL, '2023-08-16 19:47:53'),
(171, 1, 48, NULL, '2023-08-16 19:47:53'),
(172, 2, 48, NULL, '2023-08-16 19:47:53'),
(173, 3, 48, NULL, '2023-08-16 19:47:53'),
(174, 4, 48, NULL, '2023-08-16 19:47:53'),
(208, 2, 66, NULL, '2023-08-16 19:56:05'),
(209, 2, 67, NULL, '2023-08-16 19:56:05'),
(210, 2, 68, NULL, '2023-08-16 19:56:05'),
(211, 2, 69, NULL, '2023-08-16 19:56:05'),
(212, 2, 70, NULL, '2023-08-16 19:56:05'),
(213, 2, 71, NULL, '2023-08-16 19:56:05'),
(214, 2, 72, NULL, '2023-08-16 19:56:05'),
(215, 2, 73, NULL, '2023-08-16 19:56:05'),
(216, 2, 74, NULL, '2023-08-16 19:56:05'),
(217, 2, 75, NULL, '2023-08-16 19:56:05'),
(218, 2, 76, NULL, '2023-08-16 19:56:05'),
(219, 2, 77, NULL, '2023-08-16 19:56:05'),
(220, 2, 78, NULL, '2023-08-16 19:56:05'),
(221, 2, 79, NULL, '2023-08-16 19:56:05'),
(222, 2, 80, NULL, '2023-08-16 19:56:05'),
(223, 2, 81, NULL, '2023-08-16 19:56:05'),
(224, 2, 82, NULL, '2023-08-16 19:56:05'),
(225, 2, 83, NULL, '2023-08-16 19:56:27'),
(226, 2, 84, NULL, '2023-08-16 19:56:27'),
(227, 2, 85, NULL, '2023-08-16 19:56:27'),
(228, 2, 86, NULL, '2023-08-16 19:56:27'),
(229, 2, 87, NULL, '2023-08-16 19:56:27'),
(230, 2, 88, NULL, '2023-08-16 19:56:27'),
(231, 2, 89, NULL, '2023-08-16 19:56:27'),
(232, 2, 90, NULL, '2023-08-16 19:56:27'),
(233, 2, 91, NULL, '2023-08-16 19:56:27'),
(234, 2, 92, NULL, '2023-08-16 19:56:27'),
(235, 2, 93, NULL, '2023-08-16 19:56:27'),
(236, 2, 94, NULL, '2023-08-16 19:56:27'),
(237, 2, 95, NULL, '2023-08-16 19:56:27'),
(238, 2, 96, NULL, '2023-08-16 19:56:27'),
(239, 2, 97, NULL, '2023-08-16 19:56:27'),
(240, 2, 98, NULL, '2023-08-16 19:56:27'),
(241, 2, 99, NULL, '2023-08-16 19:56:27'),
(242, 2, 100, NULL, '2023-08-16 19:57:57'),
(243, 1, 101, NULL, '2023-08-16 19:57:57'),
(244, 2, 101, NULL, '2023-08-16 19:57:57'),
(245, 3, 101, NULL, '2023-08-16 19:57:57'),
(246, 4, 101, NULL, '2023-08-16 19:57:57'),
(247, 3, 102, NULL, '2023-08-16 19:57:57'),
(248, 4, 102, NULL, '2023-08-16 19:57:57'),
(249, 2, 102, NULL, '2023-08-16 19:57:57'),
(250, 1, 102, NULL, '2023-08-16 19:57:57'),
(251, 1, 103, NULL, '2023-08-16 19:57:57'),
(252, 2, 103, NULL, '2023-08-16 19:57:57'),
(253, 3, 103, NULL, '2023-08-16 19:57:57'),
(254, 4, 103, NULL, '2023-08-16 19:57:57'),
(255, 1, 104, NULL, '2023-08-16 19:57:57'),
(256, 2, 104, NULL, '2023-08-16 19:57:57'),
(257, 3, 104, NULL, '2023-08-16 19:57:57'),
(258, 4, 104, NULL, '2023-08-16 19:57:57'),
(259, 2, 105, NULL, '2023-08-16 19:57:57'),
(260, 2, 106, NULL, '2023-08-16 19:57:57'),
(261, 2, 107, NULL, '2023-08-16 19:57:57'),
(262, 2, 108, NULL, '2023-08-16 19:57:57'),
(263, 2, 109, NULL, '2023-08-16 19:57:57'),
(264, 2, 110, NULL, '2023-08-16 19:57:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `Stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `Stat_name` varchar(100) NOT NULL UNIQUE,
  `Stat_description` varchar(200) NOT NULL,
  `StatType_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Stat_id`),
  KEY `status_StatusType` (`StatType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`Stat_id`, `Stat_name`, `Stat_description`, `StatType_id`, `updated_at`, `created_at`) VALUES
(1, 'Activo', 'Status Active', 1, NULL, '2023-01-27 22:03:01'),
(2, 'Inactivo', '', 1, NULL, '2023-03-13 10:57:20'),
(3, 'Asignado', 'Activo de proyecto', 4, NULL, '2023-03-28 13:10:52'),
(4, 'Pendiente', '', 4, NULL, '2023-04-18 01:15:33'),
(5, 'Realizado', '', 4, NULL, '2023-04-18 01:16:20'),
(6, 'Creado', '', 7, NULL, '2023-04-18 01:16:20'),
(7, 'Proyecto creado', '', 7, NULL, '2023-04-18 01:16:20'),
(8, 'Rechazado', '', 7, NULL, '2023-04-18 01:16:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `statustype`
--

DROP TABLE IF EXISTS `statustype`;
CREATE TABLE IF NOT EXISTS `statustype` (
  `StatType_id` int(11) NOT NULL AUTO_INCREMENT,
  `StatType_name` varchar(100) NOT NULL,
  `StatType_description` varchar(200) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`StatType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `statustype`
--

INSERT INTO `statustype` (`StatType_id`, `StatType_name`, `StatType_description`, `updated_at`, `created_at`) VALUES
(1, 'Usuario', 'Estado de usuarios', NULL, '2023-01-27 22:02:15'),
(2, 'Empresa', 'Estado de empresas', NULL, '2023-01-30 21:20:19'),
(3, 'Cliente', 'Estado de clientes', NULL, '2023-02-20 02:21:22'),
(4, 'Proyecto', 'Estado de proyectos', NULL, '2023-03-28 13:10:18'),
(5, 'Actividades', 'Estado de actividades', NULL, '2023-04-05 09:30:25'),
(6, 'Productos', 'Estado de productos', NULL, '2023-04-10 16:31:05'),
(7, 'Solicitudes proyecto', 'Estados de las solicitudes de proyecto', NULL, '2023-04-10 16:31:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subactivities`
--

DROP TABLE IF EXISTS `subactivities`;
CREATE TABLE IF NOT EXISTS `subactivities` (
  `SubAct_id` int(11) NOT NULL AUTO_INCREMENT,
  `SubAct_name` varchar(100) NOT NULL,
  `User_id` int(11) NOT NULL,
  `SubAct_estimatedEndDate` date NOT NULL,
  `Stat_id` int(11) NOT NULL,
  `Activi_id` int(11) NOT NULL,
  `Priorities_id` int(11) NOT NULL,
  `SubAct_description` varchar(150) NOT NULL,
  `SubAct_duration` float NULL,
  `SubAct_percentage` varchar(15) NOT NULL,
  `SubAct_endDate` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`SubAct_id`),
  KEY `subactivities_user` (`User_id`),
  KEY `subactivities_stad` (`Stat_id`),
  KEY `subactivities_activi` (`Activi_id`),
  KEY `Priorities_id` (`Priorities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `User_id` int(11) NOT NULL AUTO_INCREMENT,
  `User_name` varchar(100) NOT NULL,
  `User_email` varchar(100) NOT NULL,
  `User_password` varchar(255) NOT NULL,
  `Comp_id` int(11) NOT NULL,
  `Stat_id` int(11) NOT NULL,
  `Role_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`User_id`),
  UNIQUE KEY `User_email` (`User_email`),
  KEY `user_status` (`Stat_id`),
  KEY `user_company` (`Comp_id`),
  KEY `Role_id` (`Role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`User_id`, `User_name`, `User_email`, `User_password`, `Comp_id`, `Stat_id`, `Role_id`, `updated_at`, `created_at`) VALUES
(1, 'Admin Sinapsis', 'info@sinapsist.com.co', '$2y$10$qOf7pj7SWcne3YDcXh9y/u33EJssA4GyzZfjBnvpXi4tg3jSgLchy', 1, 1, 3, '2023-06-05 14:50:39', '2023-01-30 22:10:44');
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_manager`
--

DROP TABLE IF EXISTS `user_manager`;
CREATE TABLE IF NOT EXISTS `user_manager` (
  `UserManager_id` int(11) NOT NULL AUTO_INCREMENT, 
  `User_id` int(11) NOT NULL, 
  `Manager_id` int(11) NOT NULL, 
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP, 
  `updated_at` DATETIME DEFAULT NULL, 
  PRIMARY KEY (`UserManager_id`),
  KEY `usermanager_user` (`User_id`),
  KEY `usermanager_manager` (`Manager_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_project_product` FOREIGN KEY (`Project_product_id`) REFERENCES `project_product` (`Project_product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `activities_status` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`);

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
  ADD CONSTRAINT `manager_client` FOREIGN KEY (`Client_id`) REFERENCES `client` (`Client_id`);

--
-- Filtros para la tabla `manager_brands`
--
ALTER TABLE `manager_brands`
  ADD CONSTRAINT `manager_brands_brand` FOREIGN KEY (`Brand_id`) REFERENCES `brand` (`Brand_id`),
  ADD CONSTRAINT `manager_brands_manager` FOREIGN KEY (`Manager_id`) REFERENCES `manager` (`Manager_id`);

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_brand` FOREIGN KEY (`Prod_brand_id`) REFERENCES `product_brand` (`Prod_brand_id`),
  ADD CONSTRAINT `product_filing` FOREIGN KEY (`Filing_id`) REFERENCES `filing` (`Filing_id`);

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
  ADD CONSTRAINT `project_brand` FOREIGN KEY (`Brand_id`) REFERENCES `brand` (`Brand_id`),
  ADD CONSTRAINT `project_client` FOREIGN KEY (`Client_id`) REFERENCES `client` (`Client_id`),
  ADD CONSTRAINT `project_priorities` FOREIGN KEY (`Priorities_id`) REFERENCES `priorities` (`Priorities_id`),
  ADD CONSTRAINT `project_manager` FOREIGN KEY (`Manager_id`) REFERENCES `manager` (`Manager_id`),
  ADD CONSTRAINT `project_stat` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`),
  ADD CONSTRAINT `project_commercial` FOREIGN KEY (`Project_commercial`) REFERENCES `user` (`User_id`),
  ADD CONSTRAINT `project_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`);

--
-- Filtros para la tabla `project_product`
--
ALTER TABLE `project_product`
  ADD CONSTRAINT `project_product_prod` FOREIGN KEY (`Prod_id`) REFERENCES `product` (`Prod_id`),
  ADD CONSTRAINT `project_product_project` FOREIGN KEY (`Project_id`) REFERENCES `project` (`Project_id`),
  ADD CONSTRAINT `project_product_status` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`);

--
-- Filtros para la tabla `project_request`
--
ALTER TABLE `project_request`
  ADD CONSTRAINT `project_request_brand` FOREIGN KEY (`Brand_id`) REFERENCES `brand` (`Brand_id`),
  ADD CONSTRAINT `project_request_project` FOREIGN KEY (`Project_id`) REFERENCES `project` (`Project_id`),
  ADD CONSTRAINT `project_request_status` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`),
  ADD CONSTRAINT `project_request_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`);

--
-- Filtros para la tabla `project_request_product`
--
ALTER TABLE `project_request_product`
  ADD CONSTRAINT `project_request_product_product` FOREIGN KEY (`Prod_id`) REFERENCES `product` (`Prod_id`),
  ADD CONSTRAINT `project_request_product_project_request` FOREIGN KEY (`ProjReq_id`) REFERENCES `project_request` (`ProjReq_id`);

--
-- Filtros para la tabla `project_tracking`
--
ALTER TABLE `project_tracking`
  ADD CONSTRAINT `project_tracking_project` FOREIGN KEY (`Project_id`) REFERENCES `project` (`Project_id`);

--
-- Filtros para la tabla `role_module`
--
ALTER TABLE `role_module`
  ADD CONSTRAINT `role_module_role` FOREIGN KEY (`Role_id`) REFERENCES `role` (`Role_id`),
  ADD CONSTRAINT `role_module_module` FOREIGN KEY (`Mod_id`) REFERENCES `module` (`Mod_id`);

--
-- Filtros para la tabla `role_module_permit`
--
ALTER TABLE `role_module_permit`
  ADD CONSTRAINT `role_module_permit_role` FOREIGN KEY (`Role_mod_id`) REFERENCES `role_module` (`Role_mod_id`),
  ADD CONSTRAINT `role_module_permit_permit` FOREIGN KEY (`Perm_id`) REFERENCES `permit` (`Perm_id`);

--
-- Filtros para la tabla `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_StatusType` FOREIGN KEY (`StatType_id`) REFERENCES `statustype` (`StatType_id`);

--
-- Filtros para la tabla `subactivities`
--
ALTER TABLE `subactivities`
  ADD CONSTRAINT `subactivities_activi` FOREIGN KEY (`Activi_id`) REFERENCES `activities` (`Activi_id`),
  ADD CONSTRAINT `subactivities_priorities` FOREIGN KEY (`Priorities_id`) REFERENCES `priorities` (`Priorities_id`),
  ADD CONSTRAINT `subactivities_stad` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`),
  ADD CONSTRAINT `subactivities_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_company` FOREIGN KEY (`Comp_id`) REFERENCES `company` (`Comp_id`),
  ADD CONSTRAINT `user_role` FOREIGN KEY (`Role_id`) REFERENCES `role` (`Role_id`),
  ADD CONSTRAINT `user_status` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`);

--
-- Filtros para la tabla `user_manager`
--
ALTER TABLE `user_manager`
  ADD CONSTRAINT `usermanager_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`),
  ADD CONSTRAINT `usermanager_manager` FOREIGN KEY (`Manager_id`) REFERENCES `manager` (`Manager_id`);
COMMIT;
