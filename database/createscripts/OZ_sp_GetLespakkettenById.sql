DROP PROCEDURE IF EXISTS `sp_GetLespakkettenById`;
DELIMITER $$

CREATE PROCEDURE `sp_GetLespakkettenById`(IN p_Id INT)
BEGIN
    SELECT
        L.`LespakketId`,
        L.`Naam`,
        L.`Omschrijving`,
        L.`AantalLessen`,
        L.`Prijs`,
        L.`IsActief`,
        L.`Opmerking`,
        L.`DatumAangemaakt`,
        L.`DatumGewijzigd`
    FROM `Lespakketten` AS L
    WHERE L.`LespakketId` = p_Id
    LIMIT 1;
END$$

DELIMITER ;