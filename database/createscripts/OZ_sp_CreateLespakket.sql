DROP PROCEDURE IF EXISTS `sp_CreateLespakket`;
DELIMITER $$

CREATE PROCEDURE `sp_CreateLespakket`(
    IN p_Naam VARCHAR(100),
    IN p_Omschrijving VARCHAR(255),
    IN p_AantalLessen INT,
    IN p_Prijs DECIMAL(10,2)
)
BEGIN
    INSERT INTO `Lespakketten` (
        `Naam`,
        `Omschrijving`,
        `AantalLessen`,
        `Prijs`
    )
    VALUES (
        p_Naam,
        p_Omschrijving,
        p_AantalLessen,
        p_Prijs
    );

    SELECT LAST_INSERT_ID() AS new_id;
END$$

DELIMITER ;