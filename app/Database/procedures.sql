
--
-- Procedimientos
--
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_activities_project`$$
CREATE PROCEDURE `sp_select_activities_project` (IN `project_id` INT)   BEGIN
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

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_activities`$$
CREATE PROCEDURE `sp_select_all_activities` ()   BEGIN 
SELECT A.Activi_id, A.Activi_name, AP.ApprCode_code, A.created_at 
FROM activities A 
INNER JOIN approvalcode AP on AP.ApprCode_id = A.ApprCode_id;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_brands_client`$$
CREATE PROCEDURE `sp_select_all_brands_client` (IN `client_id` INT)   BEGIN
SELECT 
	B.Brand_id,
        B.Brand_name
FROM brand B
LEFT JOIN manager_brands MB ON MB.Brand_id = B.Brand_id
WHERE MB.Brand_id IS NULL AND B.Client_id = client_id;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_brands_client`$$
CREATE PROCEDURE `sp_select_brands_client` (IN `clientId` INT)   
BEGIN
SELECT B.Brand_id, B.Brand_name, 
       (SELECT Manager_id FROM manager_brands MB WHERE B.Brand_id = MB.Brand_id LIMIT 1) AS Manager_id 
FROM brand B
WHERE B.Client_id = clientId;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_manager_brands`$$
CREATE PROCEDURE `sp_select_manager_brands` (IN `ManagerId` INT)   
BEGIN
SELECT 
	MB.Brand_id,
    B.Brand_name
FROM manager_brands MB
INNER JOIN brand B ON MB.Brand_id = B.Brand_id
WHERE MB.Manager_id = ManagerId;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_clients`$$
CREATE PROCEDURE `sp_select_all_clients` (IN `Client_id` INT)   BEGIN
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

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_country_client`$$
CREATE PROCEDURE `sp_select_country_client` (IN `clientId` INT)   
BEGIN
SELECT
C.Country_id,
CY.Country_name
FROM client C
INNER JOIN country CY ON CY.Country_id = C.Country_id
WHERE C.Client_id = clientId;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_details_activities`$$
CREATE PROCEDURE `sp_select_all_details_activities` (IN `ActiviId` INT)   BEGIN
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

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_details_subactivities`$$
CREATE PROCEDURE `sp_select_all_details_subactivities` (IN `SubAct_id` INT)   BEGIN
SELECT
    SA.SubAct_id,
    SA.SubAct_name,
    S.Stat_name,
    SA.SubAct_description
FROM subactivities SA
LEFT JOIN status S ON S.Stat_id = SA.Stat_id
WHERE SA.SubAct_id = SubAct_id; 
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_project`$$
CREATE PROCEDURE `sp_select_all_project` (IN `project_id` INT)   
BEGIN
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
U1.User_name,
P.Project_startDate,
P.Project_estimatedEndDate,
P.Project_activitiEndDate,
S.Stat_name,
P.Project_observation,
PR.Priorities_name,
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

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_project_product`$$
CREATE PROCEDURE `sp_select_all_project_product` (IN `project_id` INT)   
BEGIN    	        
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

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_project_table`$$
CREATE PROCEDURE `sp_select_all_project_table` ()   
BEGIN   
 SELECT PRO.Project_id, PRO.Project_code, PRO.Project_name, PRI.Priorities_name, PRI.Priorities_color, ST.Stat_name, PRO.created_at AS Created_at, PRO.Project_percentage FROM project PRO
    INNER JOIN status ST ON PRO.Stat_id =ST.Stat_id
    INNER JOIN priorities PRI ON PRO.Priorities_id = PRI.Priorities_id
    ORDER BY Project_id DESC;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_subactivities`$$
CREATE PROCEDURE `sp_select_all_subactivities` (IN `activity_id` INT)   BEGIN
 SELECT
 SA.SubAct_id,
 SA.SubAct_name,
 S.Stat_name,
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
WHERE SA.Activi_id = activity_id
ORDER BY SA.SubAct_id DESC;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_subactivity_info`$$
CREATE PROCEDURE `sp_select_subactivity_info` (IN `subactivity_id` INT)
BEGIN
SELECT SA.SubAct_name, AC.Activi_name, AC.Activi_id, US.User_id, US.User_name, PJ.Project_id, PJ.Project_name FROM subactivities SA INNER JOIN activities AC ON SA.Activi_id = AC.Activi_id INNER JOIN project_product PP ON AC.Project_product_id = PP.Project_product_id INNER JOIN project PJ ON PP.Project_id = PJ.Project_id INNER JOIN user US ON SA.User_id = US.User_id WHERE SA.SubAct_id = subactivity_id;
END $$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_users`$$
CREATE PROCEDURE `sp_select_all_users`()   
BEGIN
    SELECT User_id, User_name, User_email, CO.Comp_name, ST.Stat_name, USU.Role_id, RO.Role_name, USU.created_at AS Created_at FROM user USU 
    INNER JOIN status ST ON USU.Stat_id = ST.Stat_id
    INNER JOIN role RO ON USU.Role_id = RO.Role_id
    INNER JOIN company CO ON USU.Comp_id = CO.Comp_id
    -- WHERE ST.Stat_id = 1 
    ORDER BY User_id ASC;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_users_collaborator`$$
CREATE PROCEDURE `sp_select_all_users_collaborator` ()   
BEGIN
SELECT U.User_id, U.User_name, U.User_email FROM user U INNER JOIN role R on R.Role_id = U.Role_id WHERE R.Role_name = "Colaborador";
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_users_comercial`$$
CREATE PROCEDURE `sp_select_all_users_comercial` ()   
BEGIN
SELECT U.User_name, U.User_id, U.User_email FROM user U INNER JOIN role R on R.Role_id = U.Role_id WHERE R.Role_name = "Comercial";
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_modules_role`$$
CREATE PROCEDURE `sp_select_modules_role` (IN `role_id` INT)   BEGIN
select 
	rm.Mod_id as mod_id,
    (select group_concat(rmp.Perm_id) from role_module_permit rmp 
where rmp.Role_mod_id = rm.Role_mod_id) as permits
from role_module rm where rm.Role_id = role_id;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_percent_project`$$
CREATE PROCEDURE `sp_select_percent_project` (IN `projectId` INT)   
BEGIN
SET @percent = (SELECT 
	ROUND(SUM(A.Activi_percentage) / COUNT(*))
FROM activities A
INNER JOIN project_product PP ON PP.Project_product_id = A.Project_product_id
WHERE PP.Project_id = projectId);
UPDATE project SET Project_percentage = @percent WHERE Project_id = projectId;
SELECT @percent AS percent;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_user_notification`$$
CREATE PROCEDURE `sp_select_user_notification` (IN `subactivityId` INT)   
BEGIN
    SELECT project.User_id, user.User_email FROM project
    INNER JOIN project_product ON project_product.Project_id = project.Project_id
    INNER JOIN user ON user.User_id  = project.User_id
    INNER JOIN activities ON activities.Project_product_id = project_product.Project_product_id
    INNER JOIN subactivities ON activities.Activi_id = subactivities.Activi_id
    WHERE SubAct_id = subactivityId;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_status_project_product`$$
CREATE PROCEDURE `sp_select_status_project_product` (IN `percent` INT)   BEGIN
 IF percent = 0 THEN
  SELECT Stat_name FROM status WHERE Stat_name = 'Sin asignar';
 ELSEIF percent > 100 THEN
  SELECT Stat_name FROM status WHERE Stat_name = 'Realizado';
 ELSE SELECT Stat_name FROM status WHERE Stat_name = 'Pendiente';
END IF;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_info_project`$$
CREATE PROCEDURE `sp_select_info_project` (IN `projectId` INT)   
BEGIN
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

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_status_users`$$
CREATE PROCEDURE `sp_select_status_users` ()   BEGIN
    SELECT Stat_id,Stat_name FROM status WHERE StatType_id = 1;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_update_percent_activity`$$
CREATE PROCEDURE `sp_update_percent_activity` (IN `activityId` INT)   
BEGIN
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
SELECT @porcent; 
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_delete_role_module`$$
CREATE PROCEDURE `sp_delete_role_module` (IN `roleId` INT)   
BEGIN
    DELETE role_module_permit FROM role_module_permit
    INNER JOIN role_module RM ON role_module_permit.Role_mod_id = RM.Role_mod_id
    WHERE RM.Role_id = roleId;
    DELETE FROM role_module
    WHERE role_module.Role_id = roleId;
END $$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_user_manager`$$
CREATE PROCEDURE `sp_select_user_manager` (IN `managerId` INT)   
BEGIN
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
END $$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_insert_user_manager`$$
CREATE PROCEDURE `sp_insert_user_manager` (IN `managerId` INT)   
BEGIN
    INSERT INTO user(User_name, User_email, User_password, Comp_id, Stat_id, Role_id)
    SELECT M.Manager_name, M.Manager_email, '', C.Comp_id, 1, 5
    FROM manager M
    INNER JOIN client CL ON M.Client_id = CL.Client_id
    INNER JOIN company C ON CL.Comp_id = C.Comp_id
    WHERE Manager_id = managerId;
    SELECT LAST_INSERT_ID() AS 'User_id';
END $$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_update_user_email`$$
CREATE PROCEDURE `sp_update_user_email` (IN `managerId` INT)   
BEGIN
    UPDATE user U
    INNER JOIN user_manager UM ON U.User_id = UM.User_id
    INNER JOIN manager M ON UM.Manager_id = M.Manager_id
    SET U.User_email = M.Manager_email    
    WHERE M.Manager_id = managerId;
END $$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_update_user_status`$$
CREATE PROCEDURE `sp_update_user_status` (IN `managerId` INT, IN `statusId` INT)   
BEGIN
    UPDATE user U
    INNER JOIN user_manager UM ON U.User_id = UM.User_id
    INNER JOIN manager M ON UM.Manager_id = M.Manager_id
    SET U.Stat_id = statusId    
    WHERE M.Manager_id = managerId;
    SELECT U.User_id FROM user U
    INNER JOIN user_manager UM ON U.User_id = UM.User_id
    INNER JOIN manager M ON UM.Manager_id = M.Manager_id
    WHERE M.Manager_id = managerId;
END $$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_projectrequest_all`$$
CREATE PROCEDURE `sp_select_projectrequest_all` ()   
BEGIN
    SELECT PR.ProjReq_id, PR.ProjReq_name, PR.User_id, U.User_name, PR.Brand_id, B.Brand_name, PR.created_at, C.Client_name, PR.Stat_id, S.Stat_name, PR.Project_id, P.Project_code
    FROM project_request PR
    INNER JOIN user U ON PR.User_id = U.User_id
    INNER JOIN brand B ON PR.Brand_id = B.Brand_id
    INNER JOIN user_manager UM ON U.User_id = UM.User_id
    INNER JOIN manager M ON UM.Manager_id = M.Manager_id
    INNER JOIN status S ON PR.Stat_id = S.Stat_id
    INNER JOIN client C ON M.Client_id = C.Client_id
    LEFT JOIN project P ON PR.Project_id = P.Project_id
    ORDER BY PR.ProjReq_id DESC;
END $$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_projectrequest_detail`$$
CREATE PROCEDURE `sp_select_projectrequest_detail` (IN projReqId INT)   
BEGIN
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
END $$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_projectrequest_product`$$
CREATE PROCEDURE `sp_select_projectrequest_product` (IN projReqId INT)   
BEGIN
    SELECT ProjReq_product_id, PRP.Prod_id, P.Prod_name, ProjReq_product_amount 
    FROM project_request_product PRP
    INNER JOIN product P ON PRP.Prod_id = P.Prod_id
    WHERE ProjReq_id = projReqId;
END $$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_insert_projectRequest`$$
CREATE PROCEDURE `sp_insert_projectRequest` (IN projectRequestId INT)   
BEGIN
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
END $$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_projectrequest_user`$$
CREATE PROCEDURE `sp_select_projectrequest_user` (IN userId INT)   
BEGIN
    SELECT PR.ProjReq_id, PR.ProjReq_name, PR.User_id, U.User_name, PR.Brand_id, B.Brand_name, PR.created_at, C.Client_name, PR.Stat_id, S.Stat_name, PR.Project_id, P.Project_code
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
END $$

DELIMITER $$

DROP PROCEDURE
    IF EXISTS `sp_select_user_modules` $$
CREATE PROCEDURE
    `sp_select_user_modules`(IN UserId INT) BEGIN
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

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_select_user_email$$
CREATE PROCEDURE sp_select_user_email(IN UserEmail VARCHAR(100)) BEGIN
SELECT User_id FROM user WHERE User_email=UserEmail;
END$$ 

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_select_role_module_permit$$
CREATE PROCEDURE sp_select_role_module_permit(IN UserId INT,IN ModRoute VARCHAR(30) )
BEGIN
SELECT RMP.Perm_id FROM role_module_permit RMP
INNER JOIN role_module RM ON RM.Role_mod_id=RMP.Role_mod_id
WHERE RM.Role_id=(SELECT Role_id FROM USER WHERE User_id=UserId) AND RM.Mod_id=(SELECT Mod_id FROM module WHERE Mod_route=ModRoute);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_create_general_chart`$$
CREATE PROCEDURE `sp_create_general_chart` (IN userId INT, IN roleId INT, IN initialDate DATE, IN finalDate DATE)   
BEGIN   
    SET lc_time_names = 'es_CO';
    IF roleId = 1 THEN
        SELECT COUNT(Project_id) AS Client_total, P.Project_startDate, UCASE(MONTHNAME(P.Project_startDate)) AS Project_month, P.Client_id, C.Client_name 
        FROM project P
        INNER JOIN client C ON P.Client_id = C.Client_id
        WHERE P.Project_startDate >= initialDate AND P.Project_startDate <= finalDate
        GROUP BY Project_month, C.Client_name
        ORDER BY P.Project_startDate ASC;
    ELSE     
        IF roleId = 4 THEN
            SELECT COUNT(Project_id) AS Client_total, P.Project_startDate, UCASE(MONTHNAME(P.Project_startDate)) AS Project_month, P.Client_id, C.Client_name 
            FROM project P
            INNER JOIN client C ON P.Client_id = C.Client_id
            WHERE Project_commercial = userId AND P.Project_startDate >= initialDate AND P.Project_startDate <= finalDate
            GROUP BY Project_month, C.Client_name
            ORDER BY P.Project_startDate ASC;                
        END IF;
    END IF;
END$$

