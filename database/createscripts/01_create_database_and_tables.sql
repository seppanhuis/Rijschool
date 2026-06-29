USE `VierkanteWielen`;

DROP TABLE IF EXISTS `Rijlessen`;
DROP TABLE IF EXISTS `Mededelingen`;
DROP TABLE IF EXISTS `Leerlingen`;
DROP TABLE IF EXISTS `Autos`;
DROP TABLE IF EXISTS `Lespakketten`;
DROP TABLE IF EXISTS `Instructeurs`;
DROP TABLE IF EXISTS `Rollen`;
DROP TABLE IF EXISTS `Facaturen`;

CREATE TABLE `Rollen` (
    `RolId` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `Naam` VARCHAR(50) NOT NULL,
    `Omschrijving` VARCHAR(255) NOT NULL,
    `IsActief` TINYINT(1) NOT NULL DEFAULT 1,
    `Opmerking` VARCHAR(255) NULL,
    `DatumAangemaakt` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    `DatumGewijzigd` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (`RolId`),
    UNIQUE KEY `UQ_Rollen_Naam` (`Naam`)
) ENGINE=InnoDB;

CREATE TABLE `Instructeurs` (
    `InstructeurId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `Voornaam` VARCHAR(100) NOT NULL,
    `Achternaam` VARCHAR(100) NOT NULL,
    `Telefoon` VARCHAR(20) NOT NULL,
    `Email` VARCHAR(150) NOT NULL,
    `Adres` VARCHAR(150) NOT NULL,
    `Postcode` VARCHAR(10) NOT NULL,
    `Woonplaats` VARCHAR(100) NOT NULL,
    `Specialisme` VARCHAR(150) NOT NULL,
    `IsActief` TINYINT(1) NOT NULL DEFAULT 1,
    `Opmerking` VARCHAR(255) NULL,
    `DatumAangemaakt` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    `DatumGewijzigd` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (`InstructeurId`),
    UNIQUE KEY `UQ_Instructeurs_Email` (`Email`)
) ENGINE=InnoDB;

CREATE TABLE `Lespakketten` (
    `LespakketId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `Naam` VARCHAR(100) NOT NULL,
    `Omschrijving` VARCHAR(255) NOT NULL,
    `AantalLessen` INT UNSIGNED NOT NULL,
    `Prijs` DECIMAL(10,2) NOT NULL,
    `IsActief` TINYINT(1) NOT NULL DEFAULT 1,
    `Opmerking` VARCHAR(255) NULL,
    `DatumAangemaakt` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    `DatumGewijzigd` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (`LespakketId`)
) ENGINE=InnoDB;

CREATE TABLE `Autos` (
    `AutoId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `Merk` VARCHAR(100) NOT NULL,
    `Model` VARCHAR(100) NOT NULL,
    `Kenteken` VARCHAR(20) NOT NULL,
    `Bouwjaar` SMALLINT UNSIGNED NOT NULL,
    `IsElektrisch` TINYINT(1) NOT NULL DEFAULT 0,
    `IsActief` TINYINT(1) NOT NULL DEFAULT 1,
    `Opmerking` VARCHAR(255) NULL,
    `DatumAangemaakt` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    `DatumGewijzigd` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (`AutoId`),
    UNIQUE KEY `UQ_Autos_Kenteken` (`Kenteken`)
) ENGINE=InnoDB;

CREATE TABLE `Leerlingen` (
    `LeerlingId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `InstructeurId` INT UNSIGNED NOT NULL,
    `LespakketId` INT UNSIGNED NOT NULL,
    `Voornaam` VARCHAR(100) NOT NULL,
    `Achternaam` VARCHAR(100) NOT NULL,
    `Geboortedatum` DATE NOT NULL,
    `Telefoon` VARCHAR(20) NOT NULL,
    `Email` VARCHAR(150) NOT NULL,
    `Adres` VARCHAR(150) NOT NULL,
    `Postcode` VARCHAR(10) NOT NULL,
    `Woonplaats` VARCHAR(100) NOT NULL,
    `LesTegoed` INT UNSIGNED NOT NULL DEFAULT 0,
    `IsActief` TINYINT(1) NOT NULL DEFAULT 1,
    `Opmerking` VARCHAR(255) NULL,
    `DatumAangemaakt` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    `DatumGewijzigd` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (`LeerlingId`),
    UNIQUE KEY `UQ_Leerlingen_Email` (`Email`),
    KEY `IX_Leerlingen_InstructeurId` (`InstructeurId`),
    KEY `IX_Leerlingen_LespakketId` (`LespakketId`),
    CONSTRAINT `FK_Leerlingen_Instructeurs` FOREIGN KEY (`InstructeurId`) REFERENCES `Instructeurs` (`InstructeurId`) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT `FK_Leerlingen_Lespakketten` FOREIGN KEY (`LespakketId`) REFERENCES `Lespakketten` (`LespakketId`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE `Mededelingen` (
    `MededelingId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `RolId` TINYINT UNSIGNED NOT NULL,
    `Titel` VARCHAR(150) NOT NULL,
    `Bericht` TEXT NOT NULL,
    `Doelgroep` VARCHAR(50) NOT NULL,
    `PublicatieVanaf` DATETIME(6) NOT NULL,
    `IsActief` TINYINT(1) NOT NULL DEFAULT 1,
    `Opmerking` VARCHAR(255) NULL,
    `DatumAangemaakt` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    `DatumGewijzigd` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (`MededelingId`),
    KEY `IX_Mededelingen_RolId` (`RolId`),
    CONSTRAINT `FK_Mededelingen_Rollen` FOREIGN KEY (`RolId`) REFERENCES `Rollen` (`RolId`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE `Rijlessen` (
    `RijlesId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `LeerlingId` INT UNSIGNED NOT NULL,
    `InstructeurId` INT UNSIGNED NOT NULL,
    `AutoId` INT UNSIGNED NOT NULL,
    `LesStart` DATETIME(6) NOT NULL,
    `LesEinde` DATETIME(6) NOT NULL,
    `Ophaaladres` VARCHAR(150) NOT NULL,
    `Lesdoel` VARCHAR(150) NOT NULL,
    `Onderwerp` VARCHAR(255) NOT NULL,
    `Status` VARCHAR(30) NOT NULL,
    `Resultaat` VARCHAR(255) NULL,
    `Commentaar` VARCHAR(255) NULL,
    `Annuleringsreden` VARCHAR(255) NULL,
    `IsActief` TINYINT(1) NOT NULL DEFAULT 1,
    `Opmerking` VARCHAR(255) NULL,
    `DatumAangemaakt` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    `DatumGewijzigd` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (`RijlesId`),
    KEY `IX_Rijlessen_LeerlingId` (`LeerlingId`),
    KEY `IX_Rijlessen_InstructeurId` (`InstructeurId`),
    KEY `IX_Rijlessen_AutoId` (`AutoId`),
    CONSTRAINT `FK_Rijlessen_Leerlingen` FOREIGN KEY (`LeerlingId`) REFERENCES `Leerlingen` (`LeerlingId`) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT `FK_Rijlessen_Instructeurs` FOREIGN KEY (`InstructeurId`) REFERENCES `Instructeurs` (`InstructeurId`) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT `FK_Rijlessen_Autos` FOREIGN KEY (`AutoId`) REFERENCES `Autos` (`AutoId`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE `Facaturen` (
    `FacatuurId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `LespakketId` INT UNSIGNED NOT NULL,
    `Kaarthouder` VARCHAR(100) NOT NULL,
    `Kaartnummer` CHAR(18) NOT NULL,
    `Vervaldatum` DATE NOT NULL,
    `CVV` CHAR(4) NOT NULL,
    `IsActief` TINYINT(1) NOT NULL DEFAULT 1,
    `Opmerking` VARCHAR(255) NULL,
    `DatumAangemaakt` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    `DatumGewijzigd` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
        ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (`FacatuurId`)
) ENGINE=InnoDB;