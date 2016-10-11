BEGIN;

-- Par convention on met a 0 la limite lorsqu'il s'agit d'une formule I ou IBI

INSERT INTO Formule(nom, espace, tarif, limite, type, createur, active)
VALUES ('10 jours tarif reduit', 4, 250, 10, 'L','brad.pitt@gmail.com','true');

INSERT INTO Salle(numero, type, espace, nbPlaces)
VALUES (2,'collec',4,5);

INSERT INTO Mois(mois, annee, formule, espace, active)
VALUES ('juin', 2016,'10 jours tarif reduit',4,'true');

INSERT INTO Formule(nom, espace, tarif, limite, type, createur, active)
VALUES ('Classique', 4, 500, 0, 'I','brad.pitt@gmail.com','true');

INSERT INTO Salle(numero, type, espace, nbPlaces)
VALUES (3,'collec',4,6);

INSERT INTO Mois(mois, annee, formule, espace, active)
VALUES ('juillet', 2016, 'Classique',4,'true');

INSERT INTO Formule(nom, espace, tarif, limite, type, createur, active)
VALUES ('No limit', 4, 1000, 0, 'IBI','brad.pitt@gmail.com','true');

INSERT INTO Salle(numero, type, espace, nbPlaces)
VALUES (4,'indiv',4,1);

INSERT INTO Salle(numero, type, espace, nbPlaces)
VALUES (5,'collec',4,4);

INSERT INTO Mois(mois, annee, formule, espace, active)
VALUES ('juin', 2016, 'No limit',4,'true');

INSERT INTO Formule(nom, espace, tarif, limite, type, createur, active)
VALUES ('Low cost', 5, 250, 14, 'L','brad.pitt@gmail.com','true');

INSERT INTO Salle(numero, type, espace, nbPlaces)
VALUES (6,'collec',5,7);

INSERT INTO Mois(mois, annee, formule, espace, active)
VALUES ('janvier', 2017, 'Low cost',5,'true');

INSERT INTO Formule(nom, espace, tarif, limite, type, createur, active)
VALUES ('Simple', 5, 500, 0, 'I','brad.pitt@gmail.com','true');

INSERT INTO Salle(numero, type, espace, nbPlaces)
VALUES (7,'collec',5,3);

INSERT INTO Mois(mois, annee, formule, espace, active)
VALUES ('avril', 2016, 'Simple',5,'true');

INSERT INTO Formule(nom, espace, tarif, limite, type, createur, active)
VALUES ('Nolimit2', 5, 1000, 0, 'IBI','brad.pitt@gmail.com','true');

INSERT INTO Salle(numero, type, espace, nbPlaces)
VALUES (8,'indiv',5,1);

INSERT INTO Salle(numero, type, espace, nbPlaces)
VALUES (9,'collec',5,2);

INSERT INTO Mois(mois, annee, formule, espace, active)
VALUES ('decembre', 2016, 'Nolimit2',5,'true');

INSERT INTO Formule(nom, espace, tarif, limite, type, createur, active)
VALUES ('Inactive', 4, 500, 0, 'I','brad.pitt@gmail.com','false');

INSERT INTO Salle(numero, type, espace, nbPlaces)
VALUES (10,'indiv',4,1);

INSERT INTO Mois(mois, annee, formule, espace, active)
VALUES ('juin', 2016, 'Inactive',4,'false');

COMMIT;