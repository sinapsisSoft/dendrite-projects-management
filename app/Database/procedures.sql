
--
-- Procedimientos
--
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
WHERE PP.Project_id = project_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_activities`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_activities` ()   BEGIN 
SELECT A.Activi_id, A.Activi_name, AP.ApprCode_code, A.created_at FROM activities A INNER JOIN approvalcode AP on AP.ApprCode_id = A.ApprCode_id;

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_details_activities` (IN `Activi_id` INT)   BEGIN
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
    S.Stat_name,
    P.Prod_name
FROM activities A
LEFT JOIN status S ON S.Stat_id = A.Stat_id
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
U.User_name,
P.Project_startDate,
P.Project_estimatedEndDate,
P.Project_activitiEndDate,
S.Stat_name,
P.Project_link,
P.Project_observation,
PR.Priorities_name,
P.Project_commercial

FROM project P
INNER JOIN client C on C.Client_id = P.Client_id
INNER JOIN manager M on M.Manager_id = P.Manager_id
INNER JOIN brand B on B.Brand_id = P.Brand_id
INNER JOIN country CT on CT.Country_id = P.Country_id
INNER JOIN user U on U.User_id = P.User_id
INNER JOIN status S on S.Stat_id = P.Stat_id
INNER JOIN priorities PR on PR.Priorities_id = P.Priorities_id

WHERE P.Project_id = Project_id;

END$$

DROP PROCEDURE IF EXISTS `sp_select_all_project_product`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_project_product` (IN `project_id` INT)   SELECT
	PP.Project_product_id,
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
WHERE PP.Project_id = project_id$$

DROP PROCEDURE IF EXISTS `sp_select_all_project_table`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_project_table` ()   BEGIN   

 SELECT PRO.Project_id, PRO.Project_code, PRO.Project_name, PRI.Priorities_name, PRI.Priorities_color, ST.Stat_name, PRO.created_at AS Created_at FROM project PRO
    INNER JOIN status ST ON PRO.Stat_id =ST.Stat_id
    INNER JOIN priorities PRI ON PRO.Priorities_id = PRI.Priorities_id
    ORDER BY Project_id ASC;

END$$

DROP PROCEDURE IF EXISTS `sp_select_all_subactivities`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_subactivities` (IN `activity_id` INT)   BEGIN
 SELECT
 SA.SubAct_id,
 SA.SubAct_name,
 S.Stat_name,
 PRI.Priorities_name,
 PRI.Priorities_color,
 CASE 
    	WHEN SA.SubAct_percentage = 100 THEN '#16FF00' 
        WHEN SA.SubAct_percentage > 0 and SA.SubAct_percentage < 100 THEN '#FFD93D'
        ELSE '#FF0303' END as color
FROM subactivities SA
INNER JOIN status S ON S.Stat_id = SA.Stat_id
INNER JOIN priorities PRI on PRI.Priorities_id = SA.Priorities_id
WHERE SA.Activi_id = activity_id;
END$$

DROP PROCEDURE IF EXISTS `sp_select_subactivity_info`$$
CREATE PROCEDURE `sp_select_subactivity_info` (IN `subactivity_id` INT)
BEGIN
SELECT SA.SubAct_name, AC.Activi_name, AC.Activi_id, US.User_id, US.User_name, PJ.Project_id, PJ.Project_name FROM subactivities SA INNER JOIN activities AC ON SA.Activi_id = AC.Activi_id INNER JOIN project_product PP ON AC.Project_product_id = PP.Project_product_id INNER JOIN project PJ ON PP.Project_id = PJ.Project_id INNER JOIN user US ON SA.User_id = US.User_id WHERE SA.SubAct_id = subactivity_id;
END $$

DROP PROCEDURE IF EXISTS `sp_select_all_users`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_users` ()   BEGIN
    SELECT User_id,User_name,User_email,CO.Comp_name,ST.Stat_name,RO.Role_name,USU.created_at AS Created_at FROM user USU 
    INNER JOIN status ST ON USU.Stat_id =ST.Stat_id
    INNER JOIN role RO ON USU.Role_id=RO.Role_id
    INNER JOIN company CO ON USU.Comp_id =CO.Comp_id
    WHERE ST.Stat_id=1 ORDER BY User_id ASC;
END$$

DROP PROCEDURE IF EXISTS `sp_select_all_users_collaborator`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_users_collaborator` ()   BEGIN

SELECT U.User_id, U.User_name, U.User_email FROM user U INNER JOIN role R on R.Role_id = U.Role_id WHERE R.Role_name = "Colaborador";

END$$

DROP PROCEDURE IF EXISTS `sp_select_all_users_comercial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_users_comercial` ()   BEGIN

SELECT U.User_name, U.User_id, U.User_email FROM user U INNER JOIN role R on R.Role_id = U.Role_id WHERE R.Role_name = "Comercial";

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
    SELECT Stat_id,Stat_name FROM status WHERE StatType_id=1;
END$$

DROP PROCEDURE IF EXISTS `sp_update_percent_activity`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_percent_activity` (IN `activity_id` INT)   BEGIN
SELECT @porcent := ROUND(SUM(SubAct_percentage) / COUNT(*)) as porcent FROM subactivities WHERE Activi_id = activity_id;
SELECT @porcent;
update activities set Activi_percentage = @porcent
WHERE Activi_id = activity_id;
END$$
