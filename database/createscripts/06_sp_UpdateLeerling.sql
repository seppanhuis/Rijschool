DROP PROCEDURE IF EXISTS `sp_UpdateLeerling`;

DELIMITER $$

CREATE PROCEDURE `sp_UpdateLeerling`(
    IN p_id INT,
    IN p_voornaam VARCHAR(100),
    IN p_achternaam VARCHAR(100),
    IN p_geboortedatum DATE,
    IN p_telefoon VARCHAR(20),
    IN p_email VARCHAR(150),
    IN p_adres VARCHAR(150),
    IN p_postcode VARCHAR(10),
    IN p_woonplaats VARCHAR(100),
    IN p_instructeur_id INT,
    IN p_lespakket_id INT,
    IN p_les_tegoed INT,
    IN p_is_actief TINYINT,
    IN p_opmerking VARCHAR(255)
)
BEGIN
    UPDATE `Leerlingen`
    SET
        `InstructeurId` = p_instructeur_id,
        `LespakketId` = p_lespakket_id,
        `Voornaam` = p_voornaam,
        `Achternaam` = p_achternaam,
        `Geboortedatum` = p_geboortedatum,
        `Telefoon` = p_telefoon,
        `Email` = p_email,
        `Adres` = p_adres,
        `Postcode` = p_postcode,
        `Woonplaats` = p_woonplaats,
        `LesTegoed` = p_les_tegoed,
        `IsActief` = p_is_actief,
        `Opmerking` = p_opmerking,
        `DatumGewijzigd` = SYSDATE(6)
    WHERE `LeerlingId` = p_id;

    SELECT ROW_COUNT() AS `affected`;
END$$

DELIMITER ;
