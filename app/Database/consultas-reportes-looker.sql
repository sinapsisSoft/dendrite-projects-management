-- Actividades por colaborador
-- Comercial Role reports
-- Table information
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_commercial_info_table`$$
CREATE PROCEDURE `sp_select_commercial_info_table` (IN initDate DATE, IN finDate DATE, IN userId INT)   
BEGIN
  SELECT SA.User_id, U.User_name, SA.SubAct_id, SA.SubAct_name, SA.SubAct_percentage, AC.Activi_id, AC.Activi_name, AC.Project_product_id, PP.Prod_id, PD.Prod_name, P.Project_id, P.Project_name, P.Project_code, P.Client_id, C.Client_name, C.Country_id, CN.Country_name FROM activities AC
  RIGHT JOIN subactivities SA ON AC.Activi_id = SA.Activi_id
  INNER JOIN user U ON SA.User_id = U.User_id
  INNER JOIN project_product PP ON AC.Project_product_id = PP.Project_product_id
  INNER JOIN project P ON PP.Project_id = P.Project_id
  INNER JOIN product PD ON PP.Prod_id = PD.Prod_id
  INNER JOIN client C ON P.Client_id = C.Client_id
  INNER JOIN country CN ON C.Country_id = CN.Country_id
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