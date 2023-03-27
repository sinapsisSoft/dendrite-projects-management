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

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_modules_role`()
BEGIN
select 
	rm.Mod_id as mod_id,
    (select group_concat(rmp.Perm_id) from role_module_permit rmp 
where rmp.Role_mod_id = rm.Role_mod_id) as permits
from role_module rm where rm.Role_id = role_id;

END
DELIMITER ;

