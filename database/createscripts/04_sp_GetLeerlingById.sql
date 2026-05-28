DROP PROCEDURE IF EXISTS `sp_GetLeerlingById`;

DELIMITER $$

CREATE PROCEDURE `sp_GetLeerlingById`(
    IN p_id INT
)
BEGIN
    SELECT
        L.`LeerlingId`,
        L.`Voornaam`,
        L.`Achternaam`,
        L.`Geboortedatum`,
        L.`Telefoon`,
        L.`Email`,
        L.`Adres`,
        L.`Postcode`,
        L.`Woonplaats`,
        L.`LesTegoed`,
        L.`IsActief`,
        L.`Opmerking`,
        L.`DatumAangemaakt`,
        L.`DatumGewijzigd`,
        I.`InstructeurId`,
        CONCAT(I.`Voornaam`, ' ', I.`Achternaam`) AS `InstructeurNaam`,
        P.`LespakketId`,
        P.`Naam` AS `LespakketNaam`
    FROM `Leerlingen` AS L
    INNER JOIN `Instructeurs` AS I ON I.`InstructeurId` = L.`InstructeurId`
    INNER JOIN `Lespakketten` AS P ON P.`LespakketId` = L.`LespakketId`
    WHERE L.`LeerlingId` = p_id;
END$$

DELIMITER ;
