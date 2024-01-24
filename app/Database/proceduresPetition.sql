
--
-- Procedimientos
--
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_all_petitions`$$
CREATE PROCEDURE `sp_select_all_petitions` ()   BEGIN
SELECT Petition_id, Petition_code, Petition_descriptions, Petition_start_date, Petition_end_date, PET.Petition_status_id,PET.Petition_type_id,PET_STA.Petition_status_name,PET_TYPE.Petition_type_name, PET.Client_id, PET.User_id, CLI.Client_name, USU.User_name FROM petition PET 
INNER JOIN petitionstatus PET_STA ON PET.Petition_status_id=PET_STA.Petition_status_id
INNER JOIN petitiontype PET_TYPE ON PET.Petition_type_id=PET_TYPE.Petition_type_id
INNER JOIN client CLI ON PET.Client_id=CLI.Client_id
INNER JOIN user USU ON PET.User_id=USU.User_id;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_petition_detail`$$
CREATE PROCEDURE `sp_select_petition_detail` (IN PetitionId INT)   BEGIN
SELECT Petition_id, Petition_code, Petition_descriptions, Petition_start_date, Petition_end_date, PET.Petition_status_id,PET.Petition_type_id,PET_STA.Petition_status_name,PET_TYPE.Petition_type_name, PET.Client_id, PET.User_id, CLI.Client_name, USU.User_name FROM petition PET 
INNER JOIN petitionstatus PET_STA ON PET.Petition_status_id=PET_STA.Petition_status_id
INNER JOIN petitiontype PET_TYPE ON PET.Petition_type_id=PET_TYPE.Petition_type_id
INNER JOIN client CLI ON PET.Client_id=CLI.Client_id
INNER JOIN user USU ON PET.User_id=USU.User_id
WHERE Petition_id=PetitionId;
END;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_status_petitions`$$
CREATE PROCEDURE `sp_select_status_petitions` ()   BEGIN
    SELECT Petition_status_id,Petition_status_name FROM petitionstatus;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_select_type_petitions`$$
CREATE PROCEDURE `sp_select_type_petitions` ()   BEGIN
    SELECT Petition_type_id,Petition_type_name FROM petitiontype;
END$$