DELIMITER $$

DROP PROCEDURE IF EXISTS sp_GetAllFacaturen$$
CREATE PROCEDURE sp_GetAllFacaturen()
BEGIN
    SELECT *
    FROM Facaturen
    ORDER BY DatumAangemaakt DESC;
END$$


DROP PROCEDURE IF EXISTS sp_GetFacatuurById$$
CREATE PROCEDURE sp_GetFacatuurById(IN p_id INT)
BEGIN
    SELECT *
    FROM Facaturen
    WHERE FacatuurId = p_id;
END$$


DROP PROCEDURE IF EXISTS sp_CreateFacatuur$$
CREATE PROCEDURE sp_CreateFacatuur(
    IN p_LespakketId INT,
    IN p_Kaarthouder VARCHAR(100),
    IN p_Kaartnummer CHAR(18),
    IN p_Vervaldatum DATE,
    IN p_CVV CHAR(4),
    IN p_Opmerking VARCHAR(255)
)
BEGIN

    INSERT INTO Facaturen
    (
        LespakketId,
        Kaarthouder,
        Kaartnummer,
        Vervaldatum,
        CVV,
        Opmerking
    )
    VALUES
    (
        p_LespakketId,
        p_Kaarthouder,
        p_Kaartnummer,
        p_Vervaldatum,
        p_CVV,
        p_Opmerking
    );

    SELECT LAST_INSERT_ID() AS new_id;

END$$



DROP PROCEDURE IF EXISTS sp_UpdateFacatuur$$
CREATE PROCEDURE sp_UpdateFacatuur(
    IN p_id INT,
    IN p_Kaarthouder VARCHAR(100),
    IN p_Kaartnummer CHAR(18),
    IN p_Vervaldatum DATE,
    IN p_CVV CHAR(4),
    IN p_IsActief TINYINT,
    IN p_Opmerking VARCHAR(255)
)
BEGIN

UPDATE Facaturen
SET
    Kaarthouder = p_Kaarthouder,
    Kaartnummer = p_Kaartnummer,
    Vervaldatum = p_Vervaldatum,
    CVV = p_CVV,
    IsActief = p_IsActief,
    Opmerking = p_Opmerking
WHERE FacatuurId = p_id;


SELECT ROW_COUNT() AS affected;

END$$



DROP PROCEDURE IF EXISTS sp_DeleteFacatuur$$
CREATE PROCEDURE sp_DeleteFacatuur(IN p_id INT)
BEGIN

DELETE FROM Facaturen
WHERE FacatuurId = p_id;

SELECT ROW_COUNT() AS affected;

END$$


DELIMITER ;