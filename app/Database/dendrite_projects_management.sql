-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-01-2024 a las 16:18:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

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

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `sp_create_general_chart`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_create_general_chart` (IN `userId` INT, IN `roleId` INT, IN `initialDate` DATE, IN `finalDate` DATE)   BEGIN   
    SET lc_time_names = 'es_CO';
    IF roleId = 1 THEN
        SELECT COUNT(Project_id) AS Client_total, P.Project_startDate, UCASE(MONTHNAME(P.Project_startDate)) AS Project_month, P.Client_id, C.Client_name 
        FROM project P
        INNER JOIN client C ON P.Client_id = C.Client_id
        WHERE P.Project_startDate >= initialDate AND P.Project_startDate <= finalDate
        GROUP BY Project_month, C.Client_name
        ORDER BY P.Project_startDate ASC;
    ELSE     
        IF roleId = 2 THEN
            SELECT COUNT(SA.SubAct_id) AS Client_total, SA.SubAct_estimatedEndDate, UCASE(MONTHNAME(SA.SubAct_estimatedEndDate)) AS Project_month, P.Client_id, C.Client_name 
            FROM project P
            INNER JOIN client C ON P.Client_id = C.Client_id
            INNER JOIN project_product PP ON P.Project_id = PP.Project_id
            INNER JOIN activities A ON PP.Project_product_id = A.Project_product_id
            INNER JOIN subactivities SA ON A.Activi_id = SA.Activi_id
            WHERE SA.User_id = userId AND (SA.SubAct_estimatedEndDate >= initialDate AND SA.SubAct_estimatedEndDate <= finalDate)
            GROUP BY Project_month, C.Client_name 
            ORDER BY P.Project_startDate ASC;
        ELSE 
            IF roleId = 3 THEN
                SELECT COUNT(Project_id) AS Client_total, P.Project_startDate, UCASE(MONTHNAME(P.Project_startDate)) AS Project_month, P.Client_id, C.Client_name 
                FROM project P
                INNER JOIN client C ON P.Client_id = C.Client_id
                WHERE Project_commercial = userId AND P.Project_startDate >= initialDate AND P.Project_startDate <= finalDate
                GROUP BY Project_month, C.Client_name
                ORDER BY P.Project_startDate ASC;   
            ELSE 
                IF roleId = 4 THEN
                    SELECT COUNT(P.Brand_id) AS Client_total, P.Project_startDate, UCASE(MONTHNAME(P.Project_startDate)) AS Project_month, P.Brand_id, B.Brand_name
                    FROM project P
                    INNER JOIN client C ON P.Client_id = C.Client_id
                    INNER JOIN brand B ON P.Brand_id = B.Brand_id
                    INNER JOIN user_manager UM ON P.Manager_id = UM.Manager_id
                    WHERE UM.User_id = userId AND P.Project_startDate >= initialDate AND P.Project_startDate <= finalDate
                    GROUP BY Project_month, B.Brand_id
                    ORDER BY P.Project_startDate ASC;
                ELSE
                    IF roleId = 7 THEN
                        SELECT COUNT(Project_id) AS Client_total, P.Project_startDate, UCASE(MONTHNAME(P.Project_startDate)) AS Project_month, P.Client_id, C.Client_name 
                        FROM project P
                        INNER JOIN client C ON P.Client_id = C.Client_id
                        WHERE P.User_id = userId AND P.Project_startDate >= initialDate AND P.Project_startDate <= finalDate
                        GROUP BY Project_month, C.Client_name
                        ORDER BY P.Project_startDate ASC; 
                    ELSE
                        IF roleId = 5 OR roleId = 6 THEN
                            SELECT COUNT(Project_id) AS Client_total, P.Project_startDate, UCASE(MONTHNAME(P.Project_startDate)) AS Project_month, P.Client_id, C.Client_name 
                            FROM project P
                            INNER JOIN client C ON P.Client_id = C.Client_id
                            WHERE P.Project_startDate >= initialDate AND P.Project_startDate <= finalDate
                            GROUP BY Project_month, C.Client_name
                            ORDER BY P.Project_startDate ASC; 
                        ELSE
                            SELECT "Not found" AS "result";    
                        END IF;  
                    END IF;   
                END IF;         
            END IF;    
        END IF; 
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_role_module`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_role_module` (IN `roleId` INT)   BEGIN
    DELETE role_module_permit FROM role_module_permit
    INNER JOIN role_module RM ON role_module_permit.Role_mod_id = RM.Role_mod_id
    WHERE RM.Role_id = roleId;
    DELETE FROM role_module
    WHERE role_module.Role_id = roleId;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_projectRequest`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_projectRequest` (IN `projectRequestId` INT)   BEGIN
    INSERT INTO project(Project_name, Manager_id, Brand_id, Client_id, Stat_id, Project_observation)
    SELECT ProjReq_name, UM.Manager_id, PR.Brand_id, C.Client_id, 1, ProjReq_observation
    FROM project_request PR
    INNER JOIN user_manager UM ON PR.User_id = UM.User_id
    INNER JOIN manager M ON UM.Manager_id = M.Manager_id
    INNER JOIN client C ON M.Client_id = C.Client_id
    WHERE ProjReq_id = projectRequestId;
    SET @projectId = (SELECT LAST_INSERT_ID() AS 'Project_id');
    INSERT INTO project_product(`Project_productAmount`,`Project_id`,`Prod_id`, Project_product_percentage,`Stat_id`)
    SELECT ProjReq_product_amount, @projectId, Prod_id, 0, 4 FROM project_request_product
    WHERE ProjReq_id = projectRequestId;
    SELECT @projectId AS 'Project_id';
END$$

DROP PROCEDURE IF EXISTS `sp_insert_user_manager`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_user_manager` (IN `managerId` INT)   BEGIN
    INSERT INTO user(User_name, User_email, User_password, Comp_id, Stat_id, Role_id)
    SELECT M.Manager_name, M.Manager_email, '', C.Comp_id, 1, 4
    FROM manager M
    INNER JOIN client CL ON M.Client_id = CL.Client_id
    INNER JOIN company C ON CL.Comp_id = C.Comp_id
    WHERE Manager_id = managerId;
    SELECT LAST_INSERT_ID() AS 'User_id';
END$$

DROP PROCEDURE IF EXISTS `sp_select_activities_project`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_activities_project` (IN `project_id` INT)   BEGIN
select 
	A.Activi_id,
    A.Activi_name,
    A.Activi_code,
    A.created_at
FROM
activities A
INNER JOIN project_product PP ON PP.Project_product_id = A.Project_product_id
WHERE PP.Project_id = project_id
ORDER BY A.Activi_id DESC;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_activities`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_activities` ()   BEGIN 
SELECT A.Activi_id, A.Activi_name, AP.ApprCode_code, A.created_at 
FROM activities A 
INNER JOIN approvalcode AP on AP.ApprCode_id = A.ApprCode_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_brands_client`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_brands_client` (IN `client_id` INT)   BEGIN
SELECT 
	B.Brand_id,
        B.Brand_name
FROM brand B
LEFT JOIN manager_brands MB ON MB.Brand_id = B.Brand_id
WHERE MB.Brand_id IS NULL AND B.Client_id = client_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_clients`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_clients` (IN `Client_id` INT)   BEGIN
SELECT
C.Client_id,
C.Client_name,
C.Client_identification,
C.Client_email,
C.Client_phone,
C.Client_address,
DT.DocType_name,
CO.Comp_name,
S.Stat_name,
CY.Country_name
FROM client C
LEFT JOIN doctype DT  ON DT.DocType_id = C.DocType_id
LEFT JOIN status S ON S.Stat_id = C.Stat_id
LEFT JOIN country CY ON CY.Country_id = C.Country_id
LEFT JOIN company CO ON CO.Comp_id = C.Comp_id
WHERE C.Client_id= Client_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_details_activities`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_details_activities` (IN `ActiviId` INT)   BEGIN
SELECT
A.Activi_id,
    A.Activi_name,
    A.Activi_code,
    A.Activi_codeMiigo,
    A.Activi_codeSpectra,
    A.Activi_codeDelivery,
    A.Activi_endDate,
    A.Activi_startDate,
    A.Activi_percentage,
    A.Activi_link,
    A.Activi_observation,
    S.Stat_name,
    P.Prod_name
FROM activities A
LEFT JOIN status S ON S.Stat_id = A.Stat_id
LEFT JOIN project_product PP ON PP.Project_product_id = A.Project_product_id
LEFT JOIN product P ON P.Prod_id = PP.Prod_id
WHERE A.Activi_id = ActiviId;
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

DROP PROCEDURE IF EXISTS `sp_select_all_petitions`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_petitions` ()   BEGIN
SELECT Petition_id, Petition_code, Petition_descriptions, Petition_start_date, Petition_end_date, PET.Petition_status_id,PET.Petition_type_id,PET_STA.Petition_status_name,PET_TYPE.Petition_type_name, PET.Client_id, PET.User_id, CLI.Client_name, USU.User_name FROM petition PET 
INNER JOIN petitionstatus PET_STA ON PET.Petition_status_id=PET_STA.Petition_status_id
INNER JOIN petitiontype PET_TYPE ON PET.Petition_type_id=PET_TYPE.Petition_type_id
INNER JOIN client CLI ON PET.Client_id=CLI.Client_id
INNER JOIN user USU ON PET.User_id=USU.User_id;
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
P.User_id AS Project_traffic,
U1.User_name,
P.Project_startDate,
P.Project_estimatedEndDate,
P.Project_activitiEndDate,
S.Stat_name,
P.Project_observation,
P.Project_url,
PR.Priorities_name,
U2.User_id,
U2.User_name AS 'Project_commercial'
FROM project P
INNER JOIN client C on C.Client_id = P.Client_id
INNER JOIN manager M on M.Manager_id = P.Manager_id
INNER JOIN brand B on B.Brand_id = P.Brand_id
INNER JOIN country CT on CT.Country_id = C.Country_id
INNER JOIN user U1 on P.User_id = U1.User_id
INNER JOIN user U2 on P.Project_commercial = U2.User_id 
INNER JOIN status S on S.Stat_id = P.Stat_id
INNER JOIN priorities PR on PR.Priorities_id = P.Priorities_id
WHERE P.Project_id = Project_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_project_product`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_project_product` (IN `project_id` INT)   BEGIN    	        
    SELECT PP.Project_product_id,
    P.Prod_name,
    PP.Project_productAmount,
    (select round(sum(A.Activi_percentage) / count(*)) from activities A where A.Project_product_id = PP.Project_product_id) as Project_product_percentage,
    S.Stat_name,
    CASE 
    	WHEN S.Stat_name LIKE 'Realizado' THEN '#16FF00' 
        WHEN S.Stat_name LIKE 'Pendiente' THEN '#FFD93D'
        ELSE '#FF0303' END as color
FROM project_product PP
INNER JOIN product P ON P.Prod_id = PP.Prod_id
INNER JOIN status S ON S.Stat_id = PP.Stat_id
WHERE PP.Project_id = project_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_project_table`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_project_table` (IN `userId` INT)   BEGIN   
    SET @role = (SELECT Role_id FROM user WHERE User_id = userId);
    IF @role = 3 THEN
        SELECT PRO.Project_id, PRO.Project_code, CL.Client_name, PRO.Project_name, PRI.Priorities_name, PRI.Priorities_color, ST.Stat_name, PRO.created_at AS Created_at, PRO.Project_percentage FROM project PRO
        INNER JOIN status ST ON PRO.Stat_id =ST.Stat_id
        INNER JOIN priorities PRI ON PRO.Priorities_id = PRI.Priorities_id
        INNER JOIN client CL ON PRO.Client_id = CL.Client_id
        WHERE Project_commercial = userId
        ORDER BY Project_id DESC;
    ELSE 
        IF @role = 7 THEN
            SELECT PRO.Project_id, PRO.Project_code, CL.Client_name, PRO.Project_name, PRI.Priorities_name, PRI.Priorities_color, ST.Stat_name, PRO.created_at AS Created_at, PRO.Project_percentage, PRO.Project_commercial, U.User_name FROM project PRO
            INNER JOIN status ST ON PRO.Stat_id =ST.Stat_id
            INNER JOIN priorities PRI ON PRO.Priorities_id = PRI.Priorities_id
            INNER JOIN client CL ON PRO.Client_id = CL.Client_id
            INNER JOIN user U ON PRO.Project_commercial = U.User_id
            WHERE PRO.User_id = userId
            ORDER BY Project_id DESC;
        ELSE
            SELECT PRO.Project_id, PRO.Project_code, CL.Client_name, PRO.Project_name, PRI.Priorities_name, PRI.Priorities_color, ST.Stat_name, PRO.created_at AS Created_at, PRO.Project_percentage, PRO.Project_commercial, U.User_name FROM project PRO
            INNER JOIN status ST ON PRO.Stat_id =ST.Stat_id
            INNER JOIN priorities PRI ON PRO.Priorities_id = PRI.Priorities_id
            INNER JOIN client CL ON PRO.Client_id = CL.Client_id
            INNER JOIN user U ON PRO.Project_commercial = U.User_id
            ORDER BY Project_id DESC;
        END IF;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_subactivities`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_subactivities` (IN `activity_id` INT)   BEGIN
 SELECT
 SA.SubAct_id,
 SA.SubAct_name,
 S.Stat_name,
 U.User_name,
 SA.SubAct_duration,
 SA.SubAct_percentage,
 SA.SubAct_duration,
 PRI.Priorities_name,
 PRI.Priorities_color,
 CASE 
    	WHEN SA.SubAct_percentage = 100 THEN '#16FF00' 
        WHEN SA.SubAct_percentage > 0 and SA.SubAct_percentage < 100 THEN '#FFD93D'
        ELSE '#FF0303' END as color
FROM subactivities SA
INNER JOIN status S ON S.Stat_id = SA.Stat_id
INNER JOIN priorities PRI on PRI.Priorities_id = SA.Priorities_id
INNER JOIN user U ON SA.User_id = U.User_id
WHERE SA.Activi_id = activity_id
ORDER BY SA.SubAct_id DESC;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_users`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_users` ()   BEGIN
    SELECT User_id, User_name, User_email, CO.Comp_name, ST.Stat_name, USU.Role_id, RO.Role_name, USU.created_at AS Created_at FROM user USU 
    INNER JOIN status ST ON USU.Stat_id = ST.Stat_id
    INNER JOIN role RO ON USU.Role_id = RO.Role_id
    INNER JOIN company CO ON USU.Comp_id = CO.Comp_id
    -- WHERE ST.Stat_id = 1 
    ORDER BY User_id ASC;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_users_collaborator`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_users_collaborator` ()   BEGIN
SELECT U.User_id, U.User_name, U.User_email FROM user U INNER JOIN role R on R.Role_id = U.Role_id 
WHERE R.Role_name = "Colaborador";
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_users_comercial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_users_comercial` ()   BEGIN
SELECT U.User_name, U.User_id, U.User_email FROM user U INNER JOIN role R on R.Role_id = U.Role_id 
WHERE R.Role_name = "Comercial";
END$$

DROP PROCEDURE IF EXISTS `sp_select_brands_client`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_brands_client` (IN `clientId` INT)   BEGIN
SELECT B.Brand_id, B.Brand_name, 
       (SELECT Manager_id FROM manager_brands MB WHERE B.Brand_id = MB.Brand_id LIMIT 1) AS Manager_id 
FROM brand B
WHERE B.Client_id = clientId;
END$$

DROP PROCEDURE IF EXISTS `sp_select_country_client`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_country_client` (IN `clientId` INT)   BEGIN
SELECT
C.Country_id,
CY.Country_name
FROM client C
INNER JOIN country CY ON CY.Country_id = C.Country_id
WHERE C.Client_id = clientId;
END$$

DROP PROCEDURE IF EXISTS `sp_select_info_project`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_info_project` (IN `projectId` INT)   BEGIN
SELECT P.Project_id, 
P.Project_name, 
B.Brand_name, 
M.Manager_name, 
C.Client_name, 
P.Project_purchaseOrder, 
P.Project_startDate, 
PR.Priorities_name FROM project P
INNER JOIN brand B ON P.Brand_id = B.Brand_id
INNER JOIN manager M ON P.Manager_id = M.Manager_id
INNER JOIN client C ON P.Client_id = C.Client_id
INNER JOIN priorities PR ON P.Priorities_id = PR.Priorities_id
WHERE P.Project_id = projectId;
END$$

DROP PROCEDURE IF EXISTS `sp_select_info_subactivity`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_info_subactivity` (IN `subactId` INT)   BEGIN
    SELECT S.SubAct_name,
    S.SubAct_estimatedEndDate,
    S.Priorities_id,
    S.SubAct_description,
    S.User_id,
    U.User_name,
    PR.Priorities_name,
    P.Project_id,
    P.Project_name,
    A.Activi_name,
    A.Activi_id
    FROM subactivities S
    INNER JOIN activities A ON S.Activi_id = A.Activi_id
    INNER JOIN project_product PP ON A.Project_product_id = PP.Project_product_id 
    INNER JOIN project P ON PP.Project_id = P.Project_id
    INNER JOIN priorities PR ON P.Priorities_id = PR.Priorities_id
    INNER JOIN user U ON S.User_id = U.User_id
    WHERE S.SubAct_id = subactId;
END$$

DROP PROCEDURE IF EXISTS `sp_select_manager_brands`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_manager_brands` (IN `ManagerId` INT)   BEGIN
SELECT 
	MB.Brand_id,
    B.Brand_name
FROM manager_brands MB
INNER JOIN brand B ON MB.Brand_id = B.Brand_id
WHERE MB.Manager_id = ManagerId;
END$$

DROP PROCEDURE IF EXISTS `sp_select_modules_role`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_modules_role` (IN `role_id` INT)   BEGIN
select 
	rm.Mod_id as mod_id,
    (select group_concat(rmp.Perm_id) from role_module_permit rmp 
where rmp.Role_mod_id = rm.Role_mod_id) as permits
from role_module rm where rm.Role_id = role_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_module_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_module_id` (IN `ModId` INT)   BEGIN
SELECT * FROM module WHERE Mod_parent=ModId OR Mod_id=ModId 
ORDER BY Mod_parent ASC;
END$$

DROP PROCEDURE IF EXISTS `sp_select_percent_project`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_percent_project` (IN `projectId` INT)   BEGIN
SET @percent = (SELECT 
	ROUND(SUM(A.Activi_percentage) / COUNT(*))
FROM activities A
INNER JOIN project_product PP ON PP.Project_product_id = A.Project_product_id
WHERE PP.Project_id = projectId);
UPDATE project SET Project_percentage = @percent WHERE Project_id = projectId;
SELECT @percent AS percent;
END$$

DROP PROCEDURE IF EXISTS `sp_select_petition_detail`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_petition_detail` (IN `PetitionId` INT)   BEGIN
SELECT Petition_id, Petition_code, Petition_descriptions, Petition_start_date, Petition_end_date, PET.Petition_status_id,PET.Petition_type_id,PET_STA.Petition_status_name,PET_TYPE.Petition_type_name, PET.Client_id, PET.User_id, CLI.Client_name, USU.User_name FROM petition PET 
INNER JOIN petitionstatus PET_STA ON PET.Petition_status_id=PET_STA.Petition_status_id
INNER JOIN petitiontype PET_TYPE ON PET.Petition_type_id=PET_TYPE.Petition_type_id
INNER JOIN client CLI ON PET.Client_id=CLI.Client_id
INNER JOIN user USU ON PET.User_id=USU.User_id
WHERE Petition_id=PetitionId;
END$$

DROP PROCEDURE IF EXISTS `sp_select_projectrequest_all`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_projectrequest_all` ()   BEGIN
    SELECT PR.ProjReq_id, PR.ProjReq_name, PR.User_id, U.User_name, U.User_email, M.Manager_phone, PR.Brand_id, B.Brand_name, PR.created_at, C.Client_name, PR.Stat_id, S.Stat_name, PR.Project_id, P.Project_code
    FROM project_request PR
    INNER JOIN user U ON PR.User_id = U.User_id
    INNER JOIN brand B ON PR.Brand_id = B.Brand_id
    INNER JOIN user_manager UM ON U.User_id = UM.User_id
    INNER JOIN manager M ON UM.Manager_id = M.Manager_id
    INNER JOIN status S ON PR.Stat_id = S.Stat_id
    INNER JOIN client C ON M.Client_id = C.Client_id
    LEFT JOIN project P ON PR.Project_id = P.Project_id
    ORDER BY PR.ProjReq_id DESC;
END$$

DROP PROCEDURE IF EXISTS `sp_select_projectrequest_detail`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_projectrequest_detail` (IN `projReqId` INT)   BEGIN
    SELECT ProjReq_id, PR.User_id, U.User_name, ProjReq_name, PR.Brand_id, B.Brand_name, ProjReq_observation, PR.created_at, PR.updated_at, C.Client_name, CT.Country_name, PR.Stat_id, S.Stat_name
    FROM project_request PR
    INNER JOIN user U ON PR.User_id = U.User_id
    INNER JOIN brand B ON PR.Brand_id = B.Brand_id
    INNER JOIN user_manager UM ON U.User_id = UM.User_id
    INNER JOIN manager M ON UM.Manager_id = M.Manager_id
    INNER JOIN status S ON PR.Stat_id = S.Stat_id
    INNER JOIN client C ON M.Client_id = C.Client_id
    INNER JOIN country CT ON C.Country_id = CT.Country_id 
    WHERE ProjReq_id = projReqId;
END$$

DROP PROCEDURE IF EXISTS `sp_select_projectrequest_product`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_projectrequest_product` (IN `projReqId` INT)   BEGIN
    SELECT ProjReq_product_id, PRP.Prod_id, P.Prod_name, ProjReq_product_amount 
    FROM project_request_product PRP
    INNER JOIN product P ON PRP.Prod_id = P.Prod_id
    WHERE ProjReq_id = projReqId;
END$$

DROP PROCEDURE IF EXISTS `sp_select_projectrequest_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_projectrequest_user` (IN `userId` INT)   BEGIN
    SELECT PR.ProjReq_id, PR.ProjReq_name, PR.User_id, U.User_name, PR.Brand_id, B.Brand_name, PR.created_at, C.Client_name, PR.Stat_id, S.Stat_name, PR.Project_id, P.Project_code, P.Project_percentage
    FROM project_request PR
    INNER JOIN user U ON PR.User_id = U.User_id
    INNER JOIN brand B ON PR.Brand_id = B.Brand_id
    INNER JOIN user_manager UM ON U.User_id = UM.User_id
    INNER JOIN manager M ON UM.Manager_id = M.Manager_id
    INNER JOIN status S ON PR.Stat_id = S.Stat_id
    INNER JOIN client C ON M.Client_id = C.Client_id
    LEFT JOIN project P ON PR.Project_id = P.Project_id
    WHERE UM.User_id = userId
    ORDER BY PR.ProjReq_id DESC;
END$$

DROP PROCEDURE IF EXISTS `sp_select_role_module_permit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_role_module_permit` (IN `UserId` INT, IN `ModRoute` VARCHAR(30))   BEGIN
SELECT RMP.Perm_id FROM role_module_permit RMP
INNER JOIN role_module RM ON RM.Role_mod_id=RMP.Role_mod_id
WHERE RM.Role_id=(SELECT Role_id FROM user WHERE User_id=UserId) AND RM.Mod_id=(SELECT Mod_id FROM module WHERE Mod_route=ModRoute);
END$$

DROP PROCEDURE IF EXISTS `sp_select_status_petitions`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_status_petitions` ()   BEGIN
    SELECT Petition_status_id,Petition_status_name FROM petitionstatus;
END$$

DROP PROCEDURE IF EXISTS `sp_select_status_project_product`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_status_project_product` (IN `percent` INT)   BEGIN
 IF percent = 0 THEN
  SELECT Stat_name FROM status WHERE Stat_name = 'Sin asignar';
 ELSEIF percent > 100 THEN
  SELECT Stat_name FROM status WHERE Stat_name = 'Realizado';
 ELSE SELECT Stat_name FROM status WHERE Stat_name = 'Pendiente';
END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_select_status_users`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_status_users` ()   BEGIN
    SELECT Stat_id,Stat_name FROM status WHERE StatType_id = 1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_subactivity_info`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_subactivity_info` (IN `subactivity_id` INT)   BEGIN
SELECT SA.SubAct_name, SA.SubAct_description, AC.Activi_name, AC.Activi_id, US.User_id, US.User_name, PJ.Project_id, PJ.Project_name 
FROM subactivities SA INNER JOIN activities AC ON SA.Activi_id = AC.Activi_id 
INNER JOIN project_product PP ON AC.Project_product_id = PP.Project_product_id 
INNER JOIN project PJ ON PP.Project_id = PJ.Project_id 
INNER JOIN user US ON SA.User_id = US.User_id 
WHERE SA.SubAct_id = subactivity_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_subactivity_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_subactivity_user` (IN `userId` INT)   BEGIN
    SELECT
    A.Activi_name,
    PP.Project_product_id,
    C.Client_name,
    P.Project_name,
    SA.SubAct_id,
    SA.SubAct_name,
    S.Stat_name,
    SA.SubAct_duration,
    SA.SubAct_percentage,
    PRI.Priorities_name,
    PRI.Priorities_color,
    CASE 
        WHEN SA.SubAct_percentage = 100 THEN '#16FF00' 
        WHEN SA.SubAct_percentage > 0 and SA.SubAct_percentage < 100 THEN '#FFD93D'
        ELSE '#FF0303' END as color
    FROM subactivities SA
    INNER JOIN status S ON S.Stat_id = SA.Stat_id
    INNER JOIN priorities PRI on PRI.Priorities_id = SA.Priorities_id
    INNER JOIN activities A ON SA.Activi_id = A.Activi_id
    INNER JOIN project_product PP ON A.Project_product_id = PP.Project_product_id
    INNER JOIN project P ON PP.Project_id = P.Project_id
    INNER JOIN client C ON P.Client_id = C.Client_id
    WHERE SA.User_id = userId
    ORDER BY SA.SubAct_id DESC;
END$$

DROP PROCEDURE IF EXISTS `sp_select_type_petitions`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_type_petitions` ()   BEGIN
    SELECT Petition_type_id,Petition_type_name FROM petitiontype;
END$$

DROP PROCEDURE IF EXISTS `sp_select_user_detail`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_user_detail` (IN `userId` INT)   BEGIN
    SELECT User_id, User_name, User_email, Comp_id, Stat_id, Role_id FROM user 
    WHERE User_id = userId;
END$$

DROP PROCEDURE IF EXISTS `sp_select_user_email`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_user_email` (IN `UserEmail` VARCHAR(100))   BEGIN
SELECT User_id FROM user WHERE User_email=UserEmail;
END$$

DROP PROCEDURE IF EXISTS `sp_select_user_manager`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_user_manager` (IN `managerId` INT)   BEGIN
    SET @exist = (SELECT COUNT(UserManager_id) FROM user_manager WHERE Manager_id = managerId);
    IF @exist > 0 THEN
        SELECT UM.UserManager_id, UM.Manager_id, U.User_email, U.User_password, U.Stat_id, UM.Manager_id 
        FROM user U
        INNER JOIN user_manager UM ON U.User_id = UM.User_id
        WHERE UM.Manager_id = managerId;
    ELSE 
        SELECT Manager_id, Manager_email AS 'User_email' FROM manager
        WHERE Manager_id = managerId;
    END IF;    
END$$

DROP PROCEDURE IF EXISTS `sp_select_user_modules`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_user_modules` (IN `UserId` INT)   BEGIN
SELECT
    MO.Mod_id,
    MO.Mod_name,
    MO.Mod_route,
    MO.Mod_icon,
    MO.Mod_parent
FROM role_module RM
    INNER JOIN module MO ON RM.Mod_id = MO.Mod_id
    INNER JOIN role RL ON RL.Role_id = RM.Role_id
WHERE RL.Role_id = (
        SELECT Role_id
        FROM user
        WHERE User_id = UserId
    );

END$$

DROP PROCEDURE IF EXISTS `sp_select_user_notification`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_user_notification` (IN `subactivityId` INT)   BEGIN
    SELECT project.User_id, user.User_email FROM project
    INNER JOIN project_product ON project_product.Project_id = project.Project_id
    INNER JOIN user ON user.User_id  = project.User_id
    INNER JOIN activities ON activities.Project_product_id = project_product.Project_product_id
    INNER JOIN subactivities ON activities.Activi_id = subactivities.Activi_id
    WHERE SubAct_id = subactivityId;
END$$

DROP PROCEDURE IF EXISTS `sp_select_user_role`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_user_role` (IN `UserId` INT)   BEGIN
SELECT Role_id FROM user WHERE User_id=UserId;
END$$

DROP PROCEDURE IF EXISTS `sp_update_percent_activity`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_percent_activity` (IN `activityId` INT)   BEGIN
SET @porcent = (SELECT ROUND(SUM(SubAct_percentage) / COUNT(*)) as porcent FROM subactivities WHERE Activi_id = activityId);
UPDATE activities SET Activi_percentage = @porcent
WHERE Activi_id = activityId;
SET @projectId = (SELECT PP.Project_id FROM project_product PP
                INNER JOIN activities A ON PP.Project_product_id = A.Project_product_id 
                WHERE A.Activi_id = activityId);
SET @projectPercent = (SELECT ROUND(SUM(Activi_percentage) / COUNT(*)) as porcent FROM activities A
                INNER JOIN project_product PP ON A.Project_product_id = PP.Project_product_id
                WHERE PP.Project_id = @projectId);
UPDATE project SET Project_percentage = @projectPercent WHERE Project_id = @projectId;
IF @projectPercent = 100 THEN
    UPDATE project SET Project_activitiEndDate = NOW() WHERE Project_id = @projectId;
END IF;
SELECT @projectPercent AS 'Proj_percent'; 
END$$

DROP PROCEDURE IF EXISTS `sp_update_user_email`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_user_email` (IN `managerId` INT)   BEGIN
    UPDATE user U
    INNER JOIN user_manager UM ON U.User_id = UM.User_id
    INNER JOIN manager M ON UM.Manager_id = M.Manager_id
    SET U.User_email = M.Manager_email    
    WHERE M.Manager_id = managerId;
END$$

DROP PROCEDURE IF EXISTS `sp_update_user_status`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_user_status` (IN `managerId` INT, IN `statusId` INT)   BEGIN
    UPDATE user U
    INNER JOIN user_manager UM ON U.User_id = UM.User_id
    INNER JOIN manager M ON UM.Manager_id = M.Manager_id
    SET U.Stat_id = statusId    
    WHERE M.Manager_id = managerId;
    SELECT U.User_id FROM user U
    INNER JOIN user_manager UM ON U.User_id = UM.User_id
    INNER JOIN manager M ON UM.Manager_id = M.Manager_id
    WHERE M.Manager_id = managerId;
END$$

DELIMITER ;

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Activi_id`),
  KEY `activities_status` (`Stat_id`),
  KEY `activities_project_product` (`Project_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `activities`
--

TRUNCATE TABLE `activities`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE IF NOT EXISTS `brand` (
  `Brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `Brand_name` varchar(100) NOT NULL,
  `Brand_description` varchar(100) NOT NULL,
  `Client_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Brand_id`),
  UNIQUE KEY `Brand_name` (`Brand_name`),
  KEY `brand_client` (`Client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `brand`
--

TRUNCATE TABLE `brand`;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `city`
--

TRUNCATE TABLE `city`;
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
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Client_id`),
  UNIQUE KEY `Client_identification` (`Client_identification`),
  UNIQUE KEY `Client_email` (`Client_email`),
  KEY `client_company` (`Comp_id`),
  KEY `client_docType` (`DocType_id`),
  KEY `client_state` (`Stat_id`),
  KEY `client_contry` (`Country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `client`
--

TRUNCATE TABLE `client`;
--
-- Volcado de datos para la tabla `client`
--

INSERT INTO `client` (`Client_id`, `Client_name`, `Client_identification`, `Client_email`, `Client_phone`, `Client_address`, `DocType_id`, `Comp_id`, `Stat_id`, `Country_id`, `updated_at`, `created_at`) VALUES
(1, 'Market', '900123456', 'market@gmail.com', '3012528242', 'Calle falsa 123', 1, 1, 1, 1, NULL, '2024-01-08 23:56:13');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `client_contact`
--

TRUNCATE TABLE `client_contact`;
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
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Comp_id`),
  UNIQUE KEY `Comp_identification` (`Comp_identification`),
  UNIQUE KEY `Comp_email` (`Comp_email`),
  KEY `company_status` (`Stat_id`),
  KEY `company_doctType` (`DocType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `company`
--

TRUNCATE TABLE `company`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `company_contact`
--

TRUNCATE TABLE `company_contact`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `contact`
--

TRUNCATE TABLE `contact`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `Country_id` int(11) NOT NULL AUTO_INCREMENT,
  `Country_name` varchar(100) NOT NULL,
  PRIMARY KEY (`Country_id`),
  UNIQUE KEY `Country_name` (`Country_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `country`
--

TRUNCATE TABLE `country`;
--
-- Volcado de datos para la tabla `country`
--

INSERT INTO `country` (`Country_id`, `Country_name`) VALUES
(1, 'Colombia'),
(3, 'peru'),
(2, 'Venezuela');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctype`
--

DROP TABLE IF EXISTS `doctype`;
CREATE TABLE IF NOT EXISTS `doctype` (
  `DocType_id` int(11) NOT NULL AUTO_INCREMENT,
  `DocType_name` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`DocType_id`),
  UNIQUE KEY `DocType_name` (`DocType_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `doctype`
--

TRUNCATE TABLE `doctype`;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `email`
--

TRUNCATE TABLE `email`;
--
-- Volcado de datos para la tabla `email`
--

INSERT INTO `email` (`Email_id`, `Email_user`, `Email_pass`, `Email_host`, `Email_puerto`, `updated_at`) VALUES
(1, 'no-responder@dendrite.com.co', 'Sinapsis2020*', 'smtp.hostinger.co', '587', '2023-06-04 23:58:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `Employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `Employee_name` varchar(30) NOT NULL,
  `Employee_identification` varchar(20) NOT NULL,
  `Employee_email` varchar(100) NOT NULL,
  `Employee_phone` varchar(10) NOT NULL,
  `Employee_address` varchar(100) NOT NULL,
  `User_id` int(11) NOT NULL,
  `DocType_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Employee_id`),
  UNIQUE KEY `Employee_identification` (`Employee_identification`),
  UNIQUE KEY `Employee_email` (`Employee_email`),
  KEY `User_employee` (`User_id`),
  KEY `Doctype_employee` (`DocType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `employee`
--

TRUNCATE TABLE `employee`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `Files_id` int(11) NOT NULL AUTO_INCREMENT,
  `Files_name` varchar(20) NOT NULL,
  `Files_rute` varchar(300) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Files_id`),
  UNIQUE KEY `Files_rute` (`Files_rute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `files`
--

TRUNCATE TABLE `files`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `filing`
--

TRUNCATE TABLE `filing`;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `mail`
--

TRUNCATE TABLE `mail`;
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
  `Manager_name` varchar(100) NOT NULL,
  `Manager_email` varchar(100) NOT NULL,
  `Manager_phone` varchar(10) NOT NULL,
  `Client_id` int(11) NOT NULL,
  PRIMARY KEY (`Manager_id`),
  UNIQUE KEY `Manager_name` (`Manager_name`),
  UNIQUE KEY `Manager_email` (`Manager_email`),
  KEY `manager_client` (`Client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `manager`
--

TRUNCATE TABLE `manager`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `manager_brands`
--

TRUNCATE TABLE `manager_brands`;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `Mod_id` int(11) NOT NULL AUTO_INCREMENT,
  `Mod_name` varchar(50) NOT NULL,
  `Mod_route` varchar(30) NOT NULL,
  `Mod_description` varchar(100) NOT NULL,
  `Mod_icon` varchar(300) DEFAULT NULL,
  `Mod_parent` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Mod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `module`
--

TRUNCATE TABLE `module`;
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
(24, 'Seguimiento de subactividades', 'subactivitiesuser', 'Seguimiento de subactividades', NULL, 2, NULL, '2023-07-27 11:33:51'),
(25, 'Solicitudes', 'petitions', 'Módulo de solicitudes', NULL, NULL, NULL, '2024-01-07 06:07:19');

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
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Perm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
-- Estructura de tabla para la tabla `petition`
--

DROP TABLE IF EXISTS `petition`;
CREATE TABLE IF NOT EXISTS `petition` (
  `Petition_id` int(11) NOT NULL AUTO_INCREMENT,
  `Petition_code` int(11) NOT NULL,
  `Petition_descriptions` varchar(600) NOT NULL,
  `Petition_start_date` datetime NOT NULL DEFAULT current_timestamp(),
  `Petition_end_date` datetime DEFAULT NULL,
  `Petition_url` varchar(80) NOT NULL,
  `Petition_status_id` int(11) NOT NULL,
  `Petition_type_id` int(11) NOT NULL,
  `Client_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Petition_id`),
  UNIQUE KEY `petition_code` (`Petition_code`),
  KEY `petition_client` (`Client_id`),
  KEY `petition_user` (`User_id`),
  KEY `petition_type_petition` (`Petition_type_id`),
  KEY `petition_type_status` (`Petition_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `petition`
--

TRUNCATE TABLE `petition`;
--
-- Volcado de datos para la tabla `petition`
--

INSERT INTO `petition` (`Petition_id`, `Petition_code`, `Petition_descriptions`, `Petition_start_date`, `Petition_end_date`, `Petition_url`, `Petition_status_id`, `Petition_type_id`, `Client_id`, `User_id`, `updated_at`, `created_at`) VALUES
(1, 1, 'La plataforma no esta funcionando', '2024-01-09 00:03:31', NULL, '', 1, 1, 1, 1, NULL, '2024-01-09 00:03:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `petitionstatus`
--

DROP TABLE IF EXISTS `petitionstatus`;
CREATE TABLE IF NOT EXISTS `petitionstatus` (
  `Petition_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `Petition_status_name` varchar(20) NOT NULL,
  `Petition_status_description` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Petition_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `petitionstatus`
--

TRUNCATE TABLE `petitionstatus`;
--
-- Volcado de datos para la tabla `petitionstatus`
--

INSERT INTO `petitionstatus` (`Petition_status_id`, `Petition_status_name`, `Petition_status_description`, `updated_at`, `created_at`) VALUES
(1, 'Creado', 'Estado de la solicitud Creado', NULL, '2024-01-10 15:53:29'),
(2, 'Asignado', 'Estado de la solicitud Asignado', NULL, '2024-01-10 15:53:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `petitiontype`
--

DROP TABLE IF EXISTS `petitiontype`;
CREATE TABLE IF NOT EXISTS `petitiontype` (
  `Petition_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `Petition_type_name` varchar(20) NOT NULL,
  `Petition_type_description` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Petition_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `petitiontype`
--

TRUNCATE TABLE `petitiontype`;
--
-- Volcado de datos para la tabla `petitiontype`
--

INSERT INTO `petitiontype` (`Petition_type_id`, `Petition_type_name`, `Petition_type_description`, `updated_at`, `created_at`) VALUES
(1, 'Soporte Dendrite', 'Soporte de la plataforma Dendrite', NULL, '2024-01-09 00:01:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `petition_process_status`
--

DROP TABLE IF EXISTS `petition_process_status`;
CREATE TABLE IF NOT EXISTS `petition_process_status` (
  `Petition_process_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `Petition_process_status_name` varchar(20) NOT NULL,
  `Petition_process_status_description` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Petition_process_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `petition_process_status`
--

TRUNCATE TABLE `petition_process_status`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `priorities`
--

DROP TABLE IF EXISTS `priorities`;
CREATE TABLE IF NOT EXISTS `priorities` (
  `Priorities_id` int(11) NOT NULL AUTO_INCREMENT,
  `Priorities_name` varchar(100) NOT NULL,
  `Priorities_color` varchar(20) NOT NULL,
  PRIMARY KEY (`Priorities_id`),
  UNIQUE KEY `Priorities_name` (`Priorities_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `priorities`
--

TRUNCATE TABLE `priorities`;
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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Prod_id`),
  KEY `product_filing` (`Filing_id`),
  KEY `product_brand` (`Prod_brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `product`
--

TRUNCATE TABLE `product`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `product_brand`
--

TRUNCATE TABLE `product_brand`;
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
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Profile_id`),
  KEY `profile_user` (`User_id`),
  KEY `profile_doctype` (`DocType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `profile`
--

TRUNCATE TABLE `profile`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `project`
--

TRUNCATE TABLE `project`;
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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Project_product_id`),
  KEY `project_product_prod` (`Prod_id`),
  KEY `project_product_project` (`Project_id`),
  KEY `project_product_status` (`Stat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `project_product`
--

TRUNCATE TABLE `project_product`;
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
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ProjReq_id`),
  KEY `project_request_user` (`User_id`),
  KEY `project_request_brand` (`Brand_id`),
  KEY `project_request_project` (`Project_id`),
  KEY `project_request_status` (`Stat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `project_request`
--

TRUNCATE TABLE `project_request`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `project_request_product`
--

TRUNCATE TABLE `project_request_product`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `project_tracking`
--

TRUNCATE TABLE `project_tracking`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `Role_id` int(11) NOT NULL AUTO_INCREMENT,
  `Role_name` varchar(50) NOT NULL,
  `Role_description` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Role_id`),
  UNIQUE KEY `Role_name` (`Role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `role`
--

TRUNCATE TABLE `role`;
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
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Role_mod_id`),
  KEY `role_module` (`Mod_id`),
  KEY `role_module_role` (`Role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `role_module`
--

TRUNCATE TABLE `role_module`;
--
-- Volcado de datos para la tabla `role_module`
--

INSERT INTO `role_module` (`Role_mod_id`, `Role_id`, `Mod_id`, `created_at`) VALUES
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
(110, 7, 17, '2023-08-16 19:57:57'),
(111, 1, 1, '2024-01-07 06:07:46'),
(112, 1, 2, '2024-01-07 06:07:46'),
(113, 1, 3, '2024-01-07 06:07:46'),
(114, 1, 4, '2024-01-07 06:07:46'),
(115, 1, 5, '2024-01-07 06:07:46'),
(116, 1, 6, '2024-01-07 06:07:46'),
(117, 1, 7, '2024-01-07 06:07:46'),
(118, 1, 8, '2024-01-07 06:07:46'),
(119, 1, 9, '2024-01-07 06:07:46'),
(120, 1, 10, '2024-01-07 06:07:46'),
(121, 1, 11, '2024-01-07 06:07:46'),
(122, 1, 12, '2024-01-07 06:07:46'),
(123, 1, 13, '2024-01-07 06:07:46'),
(124, 1, 14, '2024-01-07 06:07:46'),
(125, 1, 15, '2024-01-07 06:07:46'),
(126, 1, 16, '2024-01-07 06:07:46'),
(127, 1, 17, '2024-01-07 06:07:46'),
(128, 1, 18, '2024-01-07 06:07:46'),
(129, 1, 19, '2024-01-07 06:07:46'),
(130, 1, 20, '2024-01-07 06:07:46'),
(131, 1, 21, '2024-01-07 06:07:46'),
(132, 1, 22, '2024-01-07 06:07:46'),
(133, 1, 23, '2024-01-07 06:07:46'),
(134, 1, 25, '2024-01-07 06:07:46');

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
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Role_mod_per_id`),
  KEY `Role_mod_id` (`Role_mod_id`),
  KEY `Perm_id` (`Perm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=358 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `role_module_permit`
--

TRUNCATE TABLE `role_module_permit`;
--
-- Volcado de datos para la tabla `role_module_permit`
--

INSERT INTO `role_module_permit` (`Role_mod_per_id`, `Perm_id`, `Role_mod_id`, `updated_at`, `created_at`) VALUES
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
(264, 2, 110, NULL, '2023-08-16 19:57:57'),
(265, 2, 111, NULL, '2024-01-07 06:07:46'),
(266, 1, 112, NULL, '2024-01-07 06:07:46'),
(267, 2, 112, NULL, '2024-01-07 06:07:46'),
(268, 3, 112, NULL, '2024-01-07 06:07:46'),
(269, 4, 112, NULL, '2024-01-07 06:07:46'),
(270, 1, 113, NULL, '2024-01-07 06:07:46'),
(271, 2, 113, NULL, '2024-01-07 06:07:46'),
(272, 3, 113, NULL, '2024-01-07 06:07:46'),
(273, 4, 113, NULL, '2024-01-07 06:07:46'),
(274, 4, 114, NULL, '2024-01-07 06:07:46'),
(275, 3, 114, NULL, '2024-01-07 06:07:46'),
(276, 2, 114, NULL, '2024-01-07 06:07:46'),
(277, 1, 114, NULL, '2024-01-07 06:07:46'),
(278, 4, 115, NULL, '2024-01-07 06:07:46'),
(279, 2, 115, NULL, '2024-01-07 06:07:46'),
(280, 1, 115, NULL, '2024-01-07 06:07:46'),
(281, 3, 115, NULL, '2024-01-07 06:07:46'),
(282, 4, 116, NULL, '2024-01-07 06:07:46'),
(283, 3, 116, NULL, '2024-01-07 06:07:46'),
(284, 2, 116, NULL, '2024-01-07 06:07:46'),
(285, 1, 116, NULL, '2024-01-07 06:07:46'),
(286, 1, 117, NULL, '2024-01-07 06:07:46'),
(287, 2, 117, NULL, '2024-01-07 06:07:46'),
(288, 3, 117, NULL, '2024-01-07 06:07:46'),
(289, 4, 117, NULL, '2024-01-07 06:07:46'),
(290, 4, 118, NULL, '2024-01-07 06:07:46'),
(291, 3, 118, NULL, '2024-01-07 06:07:46'),
(292, 2, 118, NULL, '2024-01-07 06:07:46'),
(293, 1, 118, NULL, '2024-01-07 06:07:46'),
(294, 4, 119, NULL, '2024-01-07 06:07:46'),
(295, 3, 119, NULL, '2024-01-07 06:07:46'),
(296, 2, 119, NULL, '2024-01-07 06:07:46'),
(297, 1, 119, NULL, '2024-01-07 06:07:46'),
(298, 4, 120, NULL, '2024-01-07 06:07:46'),
(299, 3, 120, NULL, '2024-01-07 06:07:46'),
(300, 2, 120, NULL, '2024-01-07 06:07:46'),
(301, 1, 120, NULL, '2024-01-07 06:07:46'),
(302, 4, 121, NULL, '2024-01-07 06:07:46'),
(303, 3, 121, NULL, '2024-01-07 06:07:46'),
(304, 2, 121, NULL, '2024-01-07 06:07:46'),
(305, 1, 121, NULL, '2024-01-07 06:07:46'),
(306, 1, 122, NULL, '2024-01-07 06:07:46'),
(307, 2, 122, NULL, '2024-01-07 06:07:46'),
(308, 3, 122, NULL, '2024-01-07 06:07:46'),
(309, 4, 122, NULL, '2024-01-07 06:07:46'),
(310, 1, 123, NULL, '2024-01-07 06:07:46'),
(311, 2, 123, NULL, '2024-01-07 06:07:46'),
(312, 4, 123, NULL, '2024-01-07 06:07:46'),
(313, 3, 123, NULL, '2024-01-07 06:07:46'),
(314, 1, 124, NULL, '2024-01-07 06:07:46'),
(315, 2, 124, NULL, '2024-01-07 06:07:46'),
(316, 3, 124, NULL, '2024-01-07 06:07:46'),
(317, 4, 124, NULL, '2024-01-07 06:07:46'),
(318, 1, 125, NULL, '2024-01-07 06:07:46'),
(319, 2, 125, NULL, '2024-01-07 06:07:46'),
(320, 4, 125, NULL, '2024-01-07 06:07:46'),
(321, 3, 125, NULL, '2024-01-07 06:07:46'),
(322, 1, 126, NULL, '2024-01-07 06:07:46'),
(323, 2, 126, NULL, '2024-01-07 06:07:46'),
(324, 3, 126, NULL, '2024-01-07 06:07:46'),
(325, 4, 126, NULL, '2024-01-07 06:07:46'),
(326, 1, 127, NULL, '2024-01-07 06:07:46'),
(327, 2, 127, NULL, '2024-01-07 06:07:46'),
(328, 4, 127, NULL, '2024-01-07 06:07:46'),
(329, 3, 127, NULL, '2024-01-07 06:07:46'),
(330, 1, 128, NULL, '2024-01-07 06:07:46'),
(331, 2, 128, NULL, '2024-01-07 06:07:46'),
(332, 3, 128, NULL, '2024-01-07 06:07:46'),
(333, 4, 128, NULL, '2024-01-07 06:07:46'),
(334, 1, 129, NULL, '2024-01-07 06:07:46'),
(335, 2, 129, NULL, '2024-01-07 06:07:46'),
(336, 4, 129, NULL, '2024-01-07 06:07:46'),
(337, 3, 129, NULL, '2024-01-07 06:07:46'),
(338, 4, 130, NULL, '2024-01-07 06:07:46'),
(339, 3, 130, NULL, '2024-01-07 06:07:46'),
(340, 2, 130, NULL, '2024-01-07 06:07:46'),
(341, 1, 130, NULL, '2024-01-07 06:07:46'),
(342, 4, 131, NULL, '2024-01-07 06:07:46'),
(343, 3, 131, NULL, '2024-01-07 06:07:46'),
(344, 2, 131, NULL, '2024-01-07 06:07:46'),
(345, 1, 131, NULL, '2024-01-07 06:07:46'),
(346, 4, 132, NULL, '2024-01-07 06:07:46'),
(347, 3, 132, NULL, '2024-01-07 06:07:46'),
(348, 2, 132, NULL, '2024-01-07 06:07:46'),
(349, 1, 132, NULL, '2024-01-07 06:07:46'),
(350, 4, 133, NULL, '2024-01-07 06:07:46'),
(351, 3, 133, NULL, '2024-01-07 06:07:46'),
(352, 2, 133, NULL, '2024-01-07 06:07:46'),
(353, 1, 133, NULL, '2024-01-07 06:07:46'),
(354, 1, 134, NULL, '2024-01-07 06:07:46'),
(355, 2, 134, NULL, '2024-01-07 06:07:46'),
(356, 3, 134, NULL, '2024-01-07 06:07:46'),
(357, 4, 134, NULL, '2024-01-07 06:07:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `Stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `Stat_name` varchar(100) NOT NULL,
  `Stat_description` varchar(200) NOT NULL,
  `StatType_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Stat_id`),
  UNIQUE KEY `Stat_name` (`Stat_name`),
  KEY `status_StatusType` (`StatType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `status`
--

TRUNCATE TABLE `status`;
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
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`StatType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `statustype`
--

TRUNCATE TABLE `statustype`;
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
  `SubAct_duration` float DEFAULT NULL,
  `SubAct_percentage` varchar(15) NOT NULL,
  `SubAct_endDate` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`SubAct_id`),
  KEY `subactivities_user` (`User_id`),
  KEY `subactivities_stad` (`Stat_id`),
  KEY `subactivities_activi` (`Activi_id`),
  KEY `Priorities_id` (`Priorities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `subactivities`
--

TRUNCATE TABLE `subactivities`;
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
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`User_id`),
  UNIQUE KEY `User_email` (`User_email`),
  KEY `user_status` (`Stat_id`),
  KEY `user_company` (`Comp_id`),
  KEY `Role_id` (`Role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `user`
--

TRUNCATE TABLE `user`;
--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`User_id`, `User_name`, `User_email`, `User_password`, `Comp_id`, `Stat_id`, `Role_id`, `updated_at`, `created_at`) VALUES
(1, 'Admin Sinapsis', 'info@sinapsist.com.co', '$2y$10$3kHNBVNf6Z2KXa2ZKXKl4OoTfLhhf7H0ka.mNnRuUDFYVEUXnAC1e', 1, 1, 1, '2024-01-07 11:02:52', '2023-01-30 22:10:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_manager`
--

DROP TABLE IF EXISTS `user_manager`;
CREATE TABLE IF NOT EXISTS `user_manager` (
  `UserManager_id` int(11) NOT NULL AUTO_INCREMENT,
  `User_id` int(11) NOT NULL,
  `Manager_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`UserManager_id`),
  KEY `usermanager_user` (`User_id`),
  KEY `usermanager_manager` (`Manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncar tablas antes de insertar `user_manager`
--

TRUNCATE TABLE `user_manager`;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_project_product` FOREIGN KEY (`Project_product_id`) REFERENCES `project_product` (`Project_product_id`),
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
  ADD CONSTRAINT `client_country` FOREIGN KEY (`Country_id`) REFERENCES `country` (`Country_id`),
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
-- Filtros para la tabla `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `Doctype_employee` FOREIGN KEY (`DocType_id`) REFERENCES `doctype` (`DocType_id`),
  ADD CONSTRAINT `User_employee` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`);

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
-- Filtros para la tabla `petition`
--
ALTER TABLE `petition`
  ADD CONSTRAINT `petition_client` FOREIGN KEY (`Client_id`) REFERENCES `client` (`Client_id`),
  ADD CONSTRAINT `petition_type_petition` FOREIGN KEY (`Petition_type_id`) REFERENCES `petitiontype` (`Petition_type_id`),
  ADD CONSTRAINT `petition_type_status` FOREIGN KEY (`Petition_status_id`) REFERENCES `petitionstatus` (`Petition_status_id`),
  ADD CONSTRAINT `petition_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`);

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
  ADD CONSTRAINT `project_commercial` FOREIGN KEY (`Project_commercial`) REFERENCES `user` (`User_id`),
  ADD CONSTRAINT `project_manager` FOREIGN KEY (`Manager_id`) REFERENCES `manager` (`Manager_id`),
  ADD CONSTRAINT `project_priorities` FOREIGN KEY (`Priorities_id`) REFERENCES `priorities` (`Priorities_id`),
  ADD CONSTRAINT `project_stat` FOREIGN KEY (`Stat_id`) REFERENCES `status` (`Stat_id`),
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
  ADD CONSTRAINT `role_module_module` FOREIGN KEY (`Mod_id`) REFERENCES `module` (`Mod_id`),
  ADD CONSTRAINT `role_module_role` FOREIGN KEY (`Role_id`) REFERENCES `role` (`Role_id`);

--
-- Filtros para la tabla `role_module_permit`
--
ALTER TABLE `role_module_permit`
  ADD CONSTRAINT `role_module_permit_permit` FOREIGN KEY (`Perm_id`) REFERENCES `permit` (`Perm_id`),
  ADD CONSTRAINT `role_module_permit_role` FOREIGN KEY (`Role_mod_id`) REFERENCES `role_module` (`Role_mod_id`);

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
  ADD CONSTRAINT `usermanager_manager` FOREIGN KEY (`Manager_id`) REFERENCES `manager` (`Manager_id`),
  ADD CONSTRAINT `usermanager_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
