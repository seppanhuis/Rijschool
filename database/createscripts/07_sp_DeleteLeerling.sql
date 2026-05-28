DROP PROCEDURE IF EXISTS `sp_DeleteLeerling`;

DELIMITER $$

CREATE PROCEDURE `sp_DeleteLeerling`(
    IN p_id INT
)
BEGIN
    DELETE FROM `Leerlingen`
    WHERE `LeerlingId` = p_id;

    SELECT ROW_COUNT() AS `affected`;
END$$

DELIMITER ;
