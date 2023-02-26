DELIMITER $$
DROP PROCEDURE IF EXISTS sp_select_all_users$$
CREATE PROCEDURE sp_select_all_users()
BEGIN
    SELECT User_id,User_email,CO.Comp_name,ST.Stat_name,RO.Role_name,USU.created_at AS Created_at FROM user USU 
    INNER JOIN status ST ON ST.Stat_id=USU.Stat_id 
    INNER JOIN role RO ON RO.Role_id=USU.Role_id 
    INNER JOIN company CO ON CO.Comp_id=USU.Role_id ORDER BY User_id ASC;
END$$

