USE `VierkanteWielen`;

INSERT INTO `Rollen` (`Naam`, `Omschrijving`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
('Administrator', 'Volledige beheerdersrol voor het platform', 1, 'Beheerder van alle administratieve processen', SYSDATE(6), SYSDATE(6)),
('Eigenaar', 'Rijschoolhouder met beheerrechten', 1, 'Eigenaar en eindverantwoordelijke', SYSDATE(6), SYSDATE(6)),
('Instructeur', 'Instructeur die lessen verzorgt', 1, 'Kan leerlingen en lessen beheren', SYSDATE(6), SYSDATE(6)),
('Leerling', 'Klant die rijlessen volgt', 1, 'Doelgroep van de rijschool', SYSDATE(6), SYSDATE(6)),
('Gastgebruiker', 'Bezoeker met alleen leesrechten', 1, 'Kan informatie bekijken en zich aanmelden', SYSDATE(6), SYSDATE(6));

INSERT INTO `Instructeurs` (`Voornaam`, `Achternaam`, `Telefoon`, `Email`, `Adres`, `Postcode`, `Woonplaats`, `Specialisme`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
('Eva', 'de Vries', '0612345671', 'eva@vierkantewielen.nl', 'Bredaseweg 12', '4611BG', 'Bergen op Zoom', 'Fysieke begeleiding en autismevriendelijk lesgeven', 1, 'Hoofdbegeleider voor aangepaste lessen', SYSDATE(6), SYSDATE(6)),
('Daan', 'Jansen', '0612345672', 'daan@vierkantewielen.nl', 'Kastanjelaan 4', '4621BA', 'Bergen op Zoom', 'Stadsklachten en schakelauto', 1, 'Rijdt veel in de ochtenduren', SYSDATE(6), SYSDATE(6)),
('Fatima', 'El Amrani', '0612345673', 'fatima@vierkantewielen.nl', 'Lindelaan 18', '4701AA', 'Roosendaal', 'Rustige coaching voor jonge leerlingen', 1, 'Extra aandacht voor faalangst', SYSDATE(6), SYSDATE(6)),
('Lars', 'van Dijk', '0612345674', 'lars@vierkantewielen.nl', 'Stationsweg 8', '4614AK', 'Bergen op Zoom', 'Elektrische voertuigen en examenvoorbereiding', 1, 'Geeft ook theoriebegeleiding', SYSDATE(6), SYSDATE(6)),
('Sophie', 'Bakker', '0612345675', 'sophie@vierkantewielen.nl', 'Molenstraat 27', '4706CA', 'Roosendaal', 'Startende bestuurders en herintreders', 0, 'Tijdelijk niet inzetbaar', SYSDATE(6), SYSDATE(6));

INSERT INTO `Lespakketten` (`Naam`, `Omschrijving`, `AantalLessen`, `Prijs`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
('Starter 10', 'Intensief startpakket voor beginnende leerlingen', 10, 799.00, 1, 'Geschikt voor snelle opstart', SYSDATE(6), SYSDATE(6)),
('Comfort 20', 'Rustig tempo met extra herhalingslessen', 20, 1499.00, 1, 'Populair bij jongeren', SYSDATE(6), SYSDATE(6)),
('Flex 25', 'Flexibel pakket met tussentijdse evaluaties', 25, 1799.00, 1, 'Inclusief planning per week', SYSDATE(6), SYSDATE(6)),
('Pro 30', 'Voor leerlingen die snel examenrijp zijn', 30, 2099.00, 1, 'Veel examenvoorbereiding', SYSDATE(6), SYSDATE(6)),
('Beperkte mobiliteit 15', 'Aangepast pakket met extra aandacht en tempo', 15, 1299.00, 1, 'Voor maatwerktrajecten', SYSDATE(6), SYSDATE(6));

INSERT INTO `Autos` (`Merk`, `Model`, `Kenteken`, `Bouwjaar`, `IsElektrisch`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
('Toyota', 'Yaris Hybrid', '11-AB-11', 2023, 0, 1, 'Zuinig en wendbaar in de stad', SYSDATE(6), SYSDATE(6)),
('Renault', 'Zoe', '22-CD-22', 2022, 1, 1, 'Elektrische lesauto met automaat', SYSDATE(6), SYSDATE(6)),
('Kia', 'e-Niro', '33-EF-33', 2024, 1, 1, 'Ruime elektrische lesauto', SYSDATE(6), SYSDATE(6)),
('Peugeot', '208', '44-GH-44', 2021, 0, 0, 'Reserveauto voor drukke dagen', SYSDATE(6), SYSDATE(6)),
('Volkswagen', 'ID.3', '55-IJ-55', 2024, 1, 1, 'Voor studenten die elektrisch willen rijden', SYSDATE(6), SYSDATE(6));

INSERT INTO `Leerlingen` (`InstructeurId`, `LespakketId`, `Voornaam`, `Achternaam`, `Geboortedatum`, `Telefoon`, `Email`, `Adres`, `Postcode`, `Woonplaats`, `LesTegoed`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 5, 'Noa', 'de Jong', '2007-04-18', '0611111101', 'noa.dejong@example.nl', 'Bergsebaan 14', '4615AB', 'Bergen op Zoom', 12, 1, 'Heeft extra uitleg nodig bij invoegen', SYSDATE(6), SYSDATE(6)),
(2, 1, 'Lars', 'Peters', '2006-09-02', '0611111102', 'lars.peters@example.nl', 'Markt 8', '4701AC', 'Roosendaal', 18, 1, 'Plant lessen het liefst na school', SYSDATE(6), SYSDATE(6)),
(3, 2, 'Amina', 'Hassan', '2008-01-24', '0611111103', 'amina.hassan@example.nl', 'Kerkstraat 22', '4611BD', 'Bergen op Zoom', 9, 1, 'Voelt zich prettig bij rustige instructie', SYSDATE(6), SYSDATE(6)),
(4, 3, 'Sem', 'van Leeuwen', '2005-11-30', '0611111104', 'sem.vanleeuwen@example.nl', 'Molenweg 3', '4691AA', 'Tholen', 6, 1, 'Wil graag in een elektrische auto rijden', SYSDATE(6), SYSDATE(6)),
(1, 4, 'Mila', 'Smit', '2007-07-10', '0611111105', 'mila.smit@example.nl', 'Havenstraat 19', '4612CC', 'Bergen op Zoom', 14, 0, 'Tijdelijk pauze na operatie', SYSDATE(6), SYSDATE(6));

INSERT INTO `Mededelingen` (`RolId`, `Titel`, `Bericht`, `Doelgroep`, `PublicatieVanaf`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(2, 'Opening binnen een maand', 'De rijschool opent binnenkort met een volledig testbaar portaal.', 'Bezoeker', SYSDATE(6), 1, 'Belangrijk voor de homepage', SYSDATE(6), SYSDATE(6)),
(1, 'Nieuwe planning in het systeem', 'Alle instructeurs en leerlingen vinden hun rooster terug in de omgeving.', 'Instructeur', SYSDATE(6), 1, 'Voor interne communicatie', SYSDATE(6), SYSDATE(6)),
(1, 'Lespakketten zijn klaar', 'De basispakketten zijn geladen en direct te testen.', 'Leerling', SYSDATE(6), 1, 'Gebruik voor servicepagina', SYSDATE(6), SYSDATE(6)),
(1, 'Ziekmeldingen registreren', 'Instructeurs melden afwezigheid voortaan via het portaal.', 'Instructeur', SYSDATE(6), 1, 'Proces voor planning', SYSDATE(6), SYSDATE(6)),
(1, 'Beperkte mobiliteit centraal', 'Extra aandacht voor maatwerk en toegankelijkheid staat voorop.', 'Bezoeker', SYSDATE(6), 1, 'Past bij de doelgroep', SYSDATE(6), SYSDATE(6));

INSERT INTO `Rijlessen` (`LeerlingId`, `InstructeurId`, `AutoId`, `LesStart`, `LesEinde`, `Ophaaladres`, `Lesdoel`, `Onderwerp`, `Status`, `Resultaat`, `Commentaar`, `Annuleringsreden`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, '2026-06-01 09:00:00', '2026-06-01 10:00:00', 'Bergsebaan 14, Bergen op Zoom', 'Koppeling en wegopstart', 'Introductieles en voertuigcontrole', 'Gepland', NULL, 'Rustige eerste kennismaking', NULL, 1, 'Start van het leertraject', SYSDATE(6), SYSDATE(6)),
(2, 2, 2, '2026-06-02 11:00:00', '2026-06-02 12:00:00', 'Markt 8, Roosendaal', 'Rijden in woonwijk', 'Bochten en voorrang', 'Gepland', NULL, 'Leerling is oplettend', NULL, 1, 'Ochtendtraining', SYSDATE(6), SYSDATE(6)),
(3, 3, 3, '2026-05-28 13:30:00', '2026-05-28 14:30:00', 'Kerkstraat 22, Bergen op Zoom', 'Verkeer lezen', 'Voorrang en snelheidsinschatting', 'Afgerond', 'Voldoende gecontroleerd', 'Goed herstel na een korte pauze', NULL, 1, 'Evaluatie afgerond', SYSDATE(6), SYSDATE(6)),
(4, 4, 5, '2026-06-03 15:00:00', '2026-06-03 16:00:00', 'Molenweg 3, Tholen', 'Examenroutes oefenen', 'Snelweg en opritten', 'Gepland', NULL, 'Focus op e-routes', NULL, 1, 'Elektrische auto ingepland', SYSDATE(6), SYSDATE(6)),
(5, 1, 4, '2026-05-30 09:30:00', '2026-05-30 10:30:00', 'Havenstraat 19, Bergen op Zoom', 'Herstart na herstel', 'Rustig heropstarten', 'Geannuleerd', NULL, 'Leerling wilde de les tijdelijk verzetten', 'Herstelperiode na operatie', 0, 'Les verplaatst naar later moment', SYSDATE(6), SYSDATE(6));
