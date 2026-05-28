DROP PROCEDURE IF EXISTS `sp_GetActieveInstructeurs`;

DELIMITER $$

CREATE PROCEDURE `sp_GetActieveInstructeurs`()
BEGIN
    SELECT
        `InstructeurId`,
        `Voornaam`,
        `Achternaam`,
        CONCAT(`Voornaam`, ' ', `Achternaam`) AS `VolledigeNaam`,
        `Specialisme`,
        `Email`
    FROM `Instructeurs`
    WHERE `IsActief` = 1
    ORDER BY `Achternaam` ASC, `Voornaam` ASC;
END$$

DELIMITER ;
