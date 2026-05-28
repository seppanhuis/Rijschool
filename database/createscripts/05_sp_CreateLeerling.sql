DROP PROCEDURE IF EXISTS `sp_CreateLeerling`;

DELIMITER $$

CREATE PROCEDURE `sp_CreateLeerling`(
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
    INSERT INTO `Leerlingen` (
        `InstructeurId`,
        `LespakketId`,
        `Voornaam`,
        `Achternaam`,
        `Geboortedatum`,
        `Telefoon`,
        `Email`,
        `Adres`,
        `Postcode`,
        `Woonplaats`,
        `LesTegoed`,
        `IsActief`,
        `Opmerking`,
        `DatumAangemaakt`,
        `DatumGewijzigd`
    ) VALUES (
        p_instructeur_id,
        p_lespakket_id,
        p_voornaam,
        p_achternaam,
        p_geboortedatum,
        p_telefoon,
        p_email,
        p_adres,
        p_postcode,
        p_woonplaats,
        p_les_tegoed,
        p_is_actief,
        p_opmerking,
        SYSDATE(6),
        SYSDATE(6)
    );

    SELECT LAST_INSERT_ID() AS `new_id`;
END$$

DELIMITER ;
