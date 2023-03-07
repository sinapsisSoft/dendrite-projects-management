DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_all_users`()
BEGIN
    SELECT User_id,User_email,CO.Comp_name,ST.Stat_name,RO.Role_name,USU.created_at AS Created_at FROM user USU 
    INNER JOIN status ST ON USU.Stat_id =ST.Stat_id
    INNER JOIN role RO ON USU.Role_id=RO.Role_id
    INNER JOIN company CO ON USU.Comp_id =CO.Comp_id
    WHERE ST.Stat_id=1 ORDER BY User_id ASC;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_status_users`()
BEGIN
    SELECT Stat_id,Stat_name FROM status WHERE StatType_id=1;
END$$
DELIMITER ;

