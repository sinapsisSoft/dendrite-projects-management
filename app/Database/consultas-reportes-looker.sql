-- Actividades por colaborador
SELECT SA.User_id, U.User_name, SA.SubAct_id, SA.SubAct_name, SA.SubAct_percentage, AC.Activi_id, AC.Activi_name, P.Project_id, P.Project_name, P.Client_id, C.Client_name FROM activities AC
RIGHT JOIN subactivities SA ON AC.Activi_id = SA.Activi_id
INNER JOIN user U ON SA.User_id = U.User_id
INNER JOIN project_product PP ON AC.Project_product_id = PP.Project_product_id
INNER JOIN project P ON PP.Project_id = P.Project_id
INNER JOIN client C ON P.Client_id = C.Client_id
WHERE SA.SubAct_percentage < 100
GROUP BY SA.SubAct_id ;

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