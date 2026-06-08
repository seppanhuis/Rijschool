DROP PROCEDURE IF EXISTS `sp_UpdateLespakket`;
DELIMITER $$

CREATE PROCEDURE `sp_UpdateLespakket`(
    IN p_Id INT,
    IN p_Naam VARCHAR(100),
    IN p_Omschrijving VARCHAR(255),
    IN p_AantalLessen INT,
    IN p_Prijs DECIMAL(10,2)
)
BEGIN
    UPDATE `Lespakketten`
    SET
        `Naam` = p_Naam,
        `Omschrijving` = p_Omschrijving,
        `AantalLessen` = p_AantalLessen,
        `Prijs` = p_Prijs,
        `DatumGewijzigd` = CURRENT_TIMESTAMP(6)
    WHERE `LespakketId` = p_Id;

    SELECT ROW_COUNT() AS affected;
END$$

DELIMITER ;