DROP PROCEDURE IF EXISTS `sp_GetAllLespakketten`;

DELIMITER $$

CREATE PROCEDURE `sp_GetAllLespakketten`()
BEGIN
    SELECT
        L.`LespakketId`
        ,L.`Naam`
        ,L.`Omschrijving`
        ,L.`AantalLessen`
        ,L.`Prijs`
        ,L.`IsActief`
        ,L.`Opmerking`
        ,L.`DatumAangemaakt`
        ,L.`DatumGewijzigd`
    FROM `Lespakketten` AS L
    where L.IsActief = 1
    ORDER BY L.`Naam` ASC;
END$$

DELIMITER ;
