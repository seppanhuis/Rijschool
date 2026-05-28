DROP PROCEDURE IF EXISTS `sp_GetActieveLespakketten`;

DELIMITER $$

CREATE PROCEDURE `sp_GetActieveLespakketten`()
BEGIN
    SELECT
        `LespakketId`,
        `Naam`,
        `Omschrijving`,
        `AantalLessen`,
        `Prijs`
    FROM `Lespakketten`
    WHERE `IsActief` = 1
    ORDER BY `Prijs` ASC, `Naam` ASC;
END$$

DELIMITER ;
