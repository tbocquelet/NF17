BEGIN;

INSERT INTO IntervenantExt(mail,nom,prenom,age)
VALUES ('george.clooney@gmail.com','Clooney','George',55);

INSERT INTO Manager(mail,nom,prenom,age)
VALUES ('brad.pitt@gmail.com','Pitt','Brad',52);

INSERT INTO Coworker(mail,nom,prenom,age,presentation,situationProfessionnelle)
VALUES ('bruce.willis@gmail.com','Willis','Bruce',61,'Anciennement acteur je viens de me reconvertir dans la sécurité informatique.','Ingenieur système');

--- attention avec les attributs serial lors de l'insertion des donnees
--- lorsqu'on les reutilise derriere il faut regarder l'id qui a ete attribue par le SGBDR pour le specifier a la main dans la requete INSERT 
INSERT INTO Espace(ID, adresse_rue, adresse_codePostal, adresse_ville, adresse_pays, surface, nbBureaux, nbSalles,description,gerant,active)
VALUES (DEFAULT, 'Rue de vaugirard',75000,'Paris','France',100,10,0,'Espace compose uniquement de bureaux','brad.pitt@gmail.com','true');

--- pour l'attribut serial, on peut specifier l'attribut et mettre DEFAULT
--- ou on peut tout simplement l'ignorer

--- pour le type booleen : on ne peut pas juste mettre 1, il faut mettre true, t , yes...

INSERT INTO Salle(numero, type, espace, nbPlaces)
VALUES (1,'indiv',3,1);

INSERT INTO Formule(nom, espace, tarif, limite, type, createur, active)
VALUES ('Premier prix', 3, 1000, 20, 'L','brad.pitt@gmail.com','true');

INSERT INTO Mois(mois, annee, formule, espace, active)
VALUES ('janvier', 2016, 'Premier prix',3,'true');

INSERT INTO Souscription(mois, annee, formule, espace, coworker)
VALUES ('janvier',2016,'Premier prix',3,'bruce.willis@gmail.com');

INSERT INTO Conference(titre, resume, intervenantExt, espaceProposant, createur)
VALUES ('Le festival de Cannes', 'Le festival vu de l interieur', 'george.clooney@gmail.com', 3,'brad.pitt@gmail.com');

INSERT INTO Information(nom,contenu,confAnnoncee,auteur)
VALUES ('VENEZ VOIR LE FESTIVAL', 'Conference sur le cinema', 1,'brad.pitt@gmail.com');

INSERT INTO Publie(info, espace)
VALUES ('VENEZ VOIR LE FESTIVAL', 3);

INSERT INTO Ouverte(conference, espace)
VALUES (1,3);

INSERT INTO Occupe(coworker,espace,salle)
VALUES ('bruce.willis@gmail.com',3,1);

INSERT INTO Domaine(nom)
VALUES ('informatique');

INSERT INTO Activite(domaine, coworker)
VALUES ('informatique','bruce.willis@gmail.com');

COMMIT;