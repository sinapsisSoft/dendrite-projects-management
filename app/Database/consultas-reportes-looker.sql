-- Actividades por colaborador
-- Comercial Role reports
-- Table information
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_commercial_info_table`$$
CREATE PROCEDURE `sp_select_commercial_info_table` (IN initDate DATE, IN finDate DATE, IN userId INT)   
BEGIN
  SELECT SA.User_id, U.User_name, SA.SubAct_id, SA.SubAct_name, SA.SubAct_percentage, AC.Activi_id, AC.Activi_name, AC.Project_product_id, PP.Prod_id, PD.Prod_name, P.Project_id, P.Project_name, P.Project_code, P.Client_id, C.Client_name, C.Country_id, CN.Country_name, P.Project_purchaseOrder, P.Manager_id, M.Manager_name, P.Project_startDate, P.Project_percentage, P.User_id, U2.User_name AS Project_traffic, P.Project_estimatedEndDate, P.Project_activitiEndDate, AC.Activi_startDate, AC.Activi_endDate, SA.SubAct_estimatedEndDate, SA.SubAct_endDate, P.Brand_id, B.Brand_name FROM activities AC
  RIGHT JOIN subactivities SA ON AC.Activi_id = SA.Activi_id
  INNER JOIN user U ON SA.User_id = U.User_id  
  INNER JOIN project_product PP ON AC.Project_product_id = PP.Project_product_id
  INNER JOIN project P ON PP.Project_id = P.Project_id
  INNER JOIN user U2 ON P.User_id = U2.User_id
  INNER JOIN product PD ON PP.Prod_id = PD.Prod_id
  INNER JOIN client C ON P.Client_id = C.Client_id
  INNER JOIN country CN ON C.Country_id = CN.Country_id
  INNER JOIN manager M ON P.Manager_id = M.Manager_id
  INNER JOIN brand B ON P.Brand_id = B.Brand_id
  WHERE (P.Project_startDate BETWEEN initDate AND finDate) AND P.Project_commercial = userId
  GROUP BY SA.SubAct_id
  ORDER BY P.Project_id ASC; 
END$$

-- Bar chart of each collaborator indicating the average completeness of their activities
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_commercial_info_chart1`$$
CREATE PROCEDURE `sp_select_commercial_info_chart1` (IN initDate DATE, IN finDate DATE, IN userId INT)   
BEGIN
  SELECT U.User_name, ROUND(AVG(SubAct_percentage),2) AS User_average FROM subactivities SA
  INNER JOIN activities AC ON SA.Activi_id = AC.Activi_id
  INNER JOIN project_product PP ON PP.Project_product_id = AC.Project_product_id
  INNER JOIN project P ON P.Project_id = PP.Project_id
  INNER JOIN user U ON SA.User_id = U.User_id
  WHERE (P.Project_startDate BETWEEN initDate AND finDate) AND P.Project_commercial = userId
  GROUP BY SA.User_id;
END$$

-- Polar area chart on the percentage of progress of the projects
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_commercial_info_chart2`$$
CREATE PROCEDURE `sp_select_commercial_info_chart2` (IN initDate DATE, IN finDate DATE, IN userId INT)   
BEGIN
SELECT P.Project_name, P.Project_percentage FROM subactivities SA
  INNER JOIN activities AC ON SA.Activi_id = AC.Activi_id
  INNER JOIN project_product PP ON PP.Project_product_id = AC.Project_product_id
  INNER JOIN project P ON P.Project_id = PP.Project_id
  INNER JOIN user U ON SA.User_id = U.User_id
  WHERE (P.Project_startDate BETWEEN initDate AND finDate) AND P.Project_commercial = userId
  GROUP BY P.Project_id;
END$$

-- Grafico de lienas de la cantidad de proyectos por cliente y mes
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_commercial_info_chart3`$$
CREATE PROCEDURE `sp_select_commercial_info_chart3` (IN initDate DATE, IN finDate DATE, IN userId INT)   
BEGIN
  SELECT DATE_FORMAT(P.Project_startDate, '%Y-%m') AS Project_date, COUNT(P.Project_id) AS Project_count, P.Client_id, C.Client_name FROM project P
  INNER JOIN client C ON P.Client_id = C.Client_id
  WHERE (P.Project_startDate BETWEEN initDate AND finDate) AND P.Project_commercial = userId
  GROUP BY P.Client_id, Project_date
  ORDER BY C.Client_id ASC, Project_date ASC;
END$$

-- Numero de proyectos por pais y cliente

-- Porcentaje de proyectos
SELECT ROUND(SUM(A.Activi_percentage) / COUNT(*)) as percent, P.Project_name, P.Client_id, C.Client_name 
FROM activities A INNER JOIN project_product PP ON PP.Project_product_id = A.Project_product_id 
INNER JOIN project P ON PP.Project_id = P.Project_id
INNER JOIN client C ON P.Client_id = C.Client_id
GROUP BY PP.Project_id;

-- Proyectos por cliente
SELECT COUNT(P.Client_id) AS total, C.Client_name 
FROM project P INNER JOIN client C ON P.Client_id = C.Client_id 
GROUP BY P.Client_id;

-- Administrative Role reports
-- Table information
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_administrative_info_table`$$
CREATE PROCEDURE `sp_select_administrative_info_table` (IN initDate DATE, IN finDate DATE)   
BEGIN
  SELECT PR.ProjReq_id, PR.User_id, UM.Manager_id, (SELECT Manager_name FROM manager WHERE Manager_id = UM.Manager_id) AS Manager_name, PR.ProjReq_name, PR.Project_id, P.Project_code, PRP.Prod_id, PD.Prod_name, PR.Stat_id, S.Stat_name, PR.created_at, C.Client_name, PR.Brand_id, B.Brand_name, P.Project_commercial, (SELECT User_name FROM user WHERE User_id = P.Project_commercial) AS User_name FROM project_request PR
  LEFT JOIN project_request_product PRP ON PR.ProjReq_id = PRP.ProjReq_id
  INNER JOIN status S ON PR.Stat_id = S.Stat_id
  INNER JOIN user_manager UM ON PR.User_id = UM.User_id
  INNER JOIN manager M ON UM.Manager_id = M.Manager_id
  INNER JOIN client C ON M.Client_id = C.Client_id
  LEFT JOIN product PD ON PRP.Prod_id = PD.Prod_id
  LEFT JOIN project P ON PR.Project_id = P.Project_id
  LEFT JOIN brand B ON PR.Brand_id = B.Brand_id
  WHERE (P.Project_startDate BETWEEN initDate AND finDate)
  ORDER BY P.Project_id DESC;
END$$

-- Table information 2
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_administrative_info_table2`$$
CREATE PROCEDURE `sp_select_administrative_info_table2` (IN initDate DATE, IN finDate DATE)   
BEGIN
  SELECT SA.User_id, U.User_name, SA.SubAct_id, SA.SubAct_name, SA.SubAct_percentage, AC.Activi_id, AC.Activi_name, AC.Project_product_id, PP.Prod_id, PD.Prod_name, P.Project_id, P.Project_name, P.Project_code, P.Client_id, C.Client_name, C.Country_id, CN.Country_name, P.Project_purchaseOrder, P.Manager_id, M.Manager_name, P.Project_startDate, P.Project_percentage, P.User_id, U2.User_name AS Project_traffic, P.Project_estimatedEndDate, P.Project_activitiEndDate, AC.Activi_startDate, AC.Activi_endDate, SA.SubAct_estimatedEndDate, SA.SubAct_endDate, P.Brand_id, B.Brand_name, P.Project_commercial, U3.User_name AS Project_commercialName FROM activities AC
  RIGHT JOIN subactivities SA ON AC.Activi_id = SA.Activi_id
  INNER JOIN user U ON SA.User_id = U.User_id  
  INNER JOIN project_product PP ON AC.Project_product_id = PP.Project_product_id
  INNER JOIN project P ON PP.Project_id = P.Project_id
  INNER JOIN user U2 ON P.User_id = U2.User_id
  INNER JOIN user U3 ON P.Project_commercial = U3.User_id
  INNER JOIN product PD ON PP.Prod_id = PD.Prod_id
  INNER JOIN client C ON P.Client_id = C.Client_id
  INNER JOIN country CN ON C.Country_id = CN.Country_id
  INNER JOIN manager M ON P.Manager_id = M.Manager_id
  INNER JOIN brand B ON P.Brand_id = B.Brand_id
  WHERE P.Project_startDate BETWEEN initDate AND finDate
  GROUP BY SA.SubAct_id
  ORDER BY P.Project_id ASC; 
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_administrative_info_chart1`$$
CREATE PROCEDURE `sp_select_administrative_info_chart1` (IN initDate DATE, IN finDate DATE)   
BEGIN
  SELECT CONCAT(Project_code, " ", SUBSTRING(Brand_name, 1, 10)) AS Project_name, 
  CASE 
    WHEN Project_activitiEndDate > 0 THEN ROUND((DATEDIFF (Project_estimatedEndDate, Project_activitiEndDate) * 100) / DATEDIFF (Project_estimatedEndDate, Project_startDate),2) + 100 
    ELSE 0
    END AS Project_estimation
  FROM project P
  INNER JOIN brand B ON P.Brand_id = B.Brand_id
  WHERE (Project_startDate BETWEEN initDate AND finDate)
  ORDER BY Project_id DESC;
END$$

-- Lineas graphic of prject numbers by client and month
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_administrative_info_chart3`$$
CREATE PROCEDURE `sp_select_administrative_info_chart3` (IN initDate DATE, IN finDate DATE)   
BEGIN
  SELECT DATE_FORMAT(PR.created_at, '%Y-%m') AS Project_date, COUNT(PR.ProjReq_id ) AS Project_count, PR.User_id, M.Manager_name FROM project_request PR
  INNER JOIN user U ON PR.User_id = U.User_id
  INNER JOIN user_manager UM ON U.User_id = UM.User_id
  INNER JOIN manager M ON UM.Manager_id = M.Manager_id
  WHERE PR.created_at BETWEEN initDate AND finDate
  GROUP BY UM.Manager_id, Project_date 
  ORDER BY UM.Manager_id ASC, Project_date ASC;
END$$

-- Traffic Role reports
-- Table information
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_traffic_info_table`$$
CREATE PROCEDURE `sp_select_traffic_info_table` (IN initDate DATE, IN finDate DATE, IN userId INT)   
BEGIN
  SELECT SA.User_id, U.User_name, SA.SubAct_id, SA.SubAct_name, SA.SubAct_percentage, AC.Activi_id, AC.Activi_name, AC.Project_product_id, PP.Prod_id, PD.Prod_name, P.Project_id, P.Project_name, P.Project_code, P.Client_id, C.Client_name, C.Country_id, CN.Country_name FROM activities AC
  RIGHT JOIN subactivities SA ON AC.Activi_id = SA.Activi_id
  INNER JOIN user U ON SA.User_id = U.User_id
  INNER JOIN project_product PP ON AC.Project_product_id = PP.Project_product_id
  INNER JOIN project P ON PP.Project_id = P.Project_id
  INNER JOIN product PD ON PP.Prod_id = PD.Prod_id
  INNER JOIN client C ON P.Client_id = C.Client_id
  INNER JOIN country CN ON C.Country_id = CN.Country_id
  WHERE (P.Project_startDate BETWEEN initDate AND finDate) AND P.User_id = userId
  GROUP BY SA.SubAct_id
  ORDER BY P.Project_id ASC; 
END$$